<?php
// Fetch assignments from DB with submission and grade status
$assignments = [];

// TODO: Replace with actual session student_id
// For now, you'll need to set this based on logged-in student
// Example: $student_id = $_SESSION['user_id'];
$student_id = 1; // Replace with session variable

$host = 'db';
$username = 'root';
$password = 'rootpass';
$database = 'Univercity_DB';

$conn = @new mysqli($host, $username, $password, $database);
if (!$conn->connect_error) {
	// Query to get all assignments from published courses
	// with submission status and grades for this student
	$sql = "SELECT 
				a.id,
				a.title,
				a.description,
				a.max_points,
				a.due_at,
				c.course_code,
				c.title AS course_title,
				sub.submitted_at,
				sub.status AS submission_status,
				g.points_awarded AS grade
			FROM assignments a
			INNER JOIN courses c ON a.course_id = c.id
			LEFT JOIN assignment_submissions sub 
				ON a.id = sub.assignment_id 
				AND sub.student_id = ?
			LEFT JOIN grades g ON sub.id = g.submission_id
			WHERE c.is_published = 1
			ORDER BY a.due_at ASC";
	
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param('i', $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		
		while ($row = $result->fetch_assoc()) {
			// Determine status based on submission and grade
			if ($row['grade'] !== null) {
				$status = 'graded';
			} elseif ($row['submitted_at'] !== null) {
				$status = 'submitted';
			} else {
				$status = 'pending';
			}
			
			$assignments[] = [
				'id' => $row['id'],
				'title' => $row['title'],
				'course_code' => $row['course_code'],
				'course_title' => $row['course_title'],
				'description' => $row['description'],
				'max_points' => $row['max_points'],
				'due_at' => $row['due_at'],
				'status' => $status,
				'submitted_at' => $row['submitted_at'],
				'grade' => $row['grade']
			];
		}
		
		$stmt->close();
	}
	$conn->close();
}
// Continue even if DB unavailable; UI will show empty state
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Assignments</title>
	<style>
	* { box-sizing: border-box; }
	body {
		margin: 0;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		background: linear-gradient(135deg, #f5f7fa 0%, #e9edf3 100%);
		color: #1a1a1a;
	}
	.page-wrapper { display: flex; min-height: 100vh; }
	.content {
		flex: 1;
		margin-left: 240px;
		margin-top: 70px;
		padding: 3rem;
	}

/* Section wrapper */
.assignments-section { margin-top: 1.5rem; }
.section-header {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: white;
	padding: 1rem 1.25rem;
	border-radius: 14px;
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 1rem;
	box-shadow: 0 6px 18px rgba(102, 126, 234, 0.35);
}
.section-title { margin: 0; font-size: 1.15rem; }
.section-pill {
	background: rgba(255,255,255,0.15);
	border: 1px solid rgba(255,255,255,0.35);
	border-radius: 999px;
	padding: 0.4rem 0.8rem;
	font-weight: 800;
}
.toolbar { display: flex; gap: 0.6rem; margin-top: 0.75rem; align-items: center; }
.search-input {
	flex: 1;
	padding: 0.7rem 0.9rem;
	border-radius: 12px;
	border: 1px solid #d1d5db;
	background: #f9fafb;
}
.search-input:focus {
	outline: none;
	border-color: #667eea;
	box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
	background: #fff;
}
.filter-btn {
	padding: 0.7rem 1rem;
	background: white;
	border: 1px solid #d1d5db;
	border-radius: 12px;
	font-weight: 700;
	cursor: pointer;
	transition: all 0.15s ease;
}
.filter-btn:hover { background: #f9fafb; border-color: #667eea; }
.filter-btn.active { background: #667eea; color: white; border-color: #667eea; }

/* Grid cards */
.assignments-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
	gap: 1rem;
	margin-top: 1rem;
}
.assignment-card {
	background: white;
	border-radius: 14px;
	padding: 1.25rem;
	border: 1px solid #e5e7eb;
	box-shadow: 0 8px 20px rgba(0,0,0,0.08);
	transition: transform 0.15s ease, box-shadow 0.2s ease;
}
.assignment-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }

.card-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 0.75rem; }
.status-badge {
	border-radius: 999px;
	padding: 0.3rem 0.7rem;
	font-weight: 800;
	font-size: 0.75rem;
	text-transform: uppercase;
}
.status-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.status-submitted { background: #dbeafe; color: #1e3a8a; border: 1px solid #93c5fd; }
.status-graded { background: #dcfce7; color: #166534; border: 1px solid #86efac; }

.assignment-title { font-weight: 900; color: #111827; margin: 0.5rem 0; font-size: 1.1rem; }
.course-info {
	display: inline-flex;
	align-items: center;
	gap: 0.4rem;
	background: #eef2ff;
	color: #4338ca;
	border: 1px solid #c7d2fe;
	border-radius: 8px;
	padding: 0.25rem 0.6rem;
	font-weight: 800;
	font-size: 0.85rem;
	margin-bottom: 0.5rem;
}
.description { color: #6b7280; font-size: 0.9rem; margin: 0.75rem 0; line-height: 1.5; }

.assignment-meta {
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin-top: 0.75rem;
	padding-top: 0.75rem;
	border-top: 1px solid #e5e7eb;
}
.meta-item { color: #6b7280; font-size: 0.85rem; }
.meta-label { font-weight: 700; color: #374151; }
.due-soon { color: #dc2626; font-weight: 800; }

.card-actions {
	margin-top: 0.75rem;
	display: flex;
	gap: 0.5rem;
	justify-content: flex-end;
}
.action-btn {
	padding: 0.6rem 1rem;
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: white;
	border: none;
	border-radius: 10px;
	font-weight: 800;
	box-shadow: 0 6px 16px rgba(102, 126, 234, 0.35);
	cursor: pointer;
	transition: all 0.15s ease;
}
.action-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.45); }
.action-btn:disabled { opacity: 0.6; cursor: not-allowed; }
.action-btn.secondary {
	background: white;
	color: #667eea;
	border: 1px solid #667eea;
	box-shadow: none;
}

.empty-state {
	margin-top: 1rem;
	padding: 2rem;
	color: #6b7280;
	text-align: center;
	background: #f8fafc;
	border: 1px solid #e5e7eb;
	border-radius: 12px;
}
@media (max-width: 640px) {
	.section-header { flex-direction: column; align-items: flex-start; }
	.assignment-meta { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
}
	</style>
</head>
<body>
	<?php include_once __DIR__ . '/../../../../components/sidebar-stud.php'; ?>
	<?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>

	<div class="page-wrapper">
		<div class="content">

<section class="assignments-section">
	<div class="section-header">
		<h3 class="section-title">My Assignments</h3>
		<div class="section-pill">Total: <?php echo count($assignments); ?></div>
	</div>
	<div class="toolbar">
		<input class="search-input" type="text" placeholder="Search assignments by title or course (UI only)">
		<button class="filter-btn active" type="button">All</button>
		<button class="filter-btn" type="button">Pending</button>
		<button class="filter-btn" type="button">Submitted</button>
		<button class="filter-btn" type="button">Graded</button>
	</div>

	<?php if (!empty($assignments)): ?>
		<div class="assignments-grid">
			<?php foreach ($assignments as $a): ?>
				<?php
					$title = htmlspecialchars($a['title']);
					$courseCode = htmlspecialchars($a['course_code']);
					$courseTitle = htmlspecialchars($a['course_title']);
					$desc = htmlspecialchars($a['description']);
					$maxPoints = htmlspecialchars((string) $a['max_points']);
					$dueAt = htmlspecialchars($a['due_at']);
					$status = htmlspecialchars($a['status']);
					$submittedAt = $a['submitted_at'] ? htmlspecialchars($a['submitted_at']) : null;
					$grade = $a['grade'] !== null ? htmlspecialchars((string) $a['grade']) : null;
					
					// Calculate if due soon (within 3 days)
					$dueSoon = (strtotime($a['due_at']) - time()) < (3 * 24 * 60 * 60) && $status === 'pending';
				?>
				<div class="assignment-card">
					<div class="card-header">
						<div>
							<span class="course-info"><?php echo $courseCode; ?></span>
						</div>
						<span class="status-badge status-<?php echo $status; ?>">
							<?php echo ucfirst($status); ?>
						</span>
					</div>
					
					<h4 class="assignment-title"><?php echo $title; ?></h4>
					<p class="description"><?php echo $desc; ?></p>
					
					<div class="assignment-meta">
						<div>
							<div class="meta-item">
								<span class="meta-label">Max Points:</span> <?php echo $maxPoints; ?>
							</div>
							<div class="meta-item <?php echo $dueSoon ? 'due-soon' : ''; ?>">
								<span class="meta-label">Due:</span> <?php echo $dueAt; ?>
							</div>
						</div>
						<?php if ($grade !== null): ?>
							<div class="meta-item" style="font-weight: 800; color: #16a34a;">
								Grade: <?php echo $grade; ?>/<?php echo $maxPoints; ?>
							</div>
						<?php elseif ($submittedAt): ?>
							<div class="meta-item">
								<span class="meta-label">Submitted:</span> <?php echo $submittedAt; ?>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="card-actions">
						<?php if ($status === 'pending'): ?>
							<a href="<?= BASE_URL ?? '' ?>/project/dashboard/views/assignments/student/submit.php?id=<?= $a['id'] ?>" class="action-btn" style="text-decoration: none; display: inline-block; text-align: center;">Submit</a>
						<?php elseif ($status === 'submitted'): ?>
							<button class="action-btn secondary" type="button">View Submission</button>
						<?php else: ?>
							<button class="action-btn secondary" type="button">View Grade</button>
							<button class="action-btn" type="button">Resubmit</button>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="empty-state">No assignments available yet.</div>
	<?php endif; ?>
</section>
		</div>
	</div>
</body>
</html>