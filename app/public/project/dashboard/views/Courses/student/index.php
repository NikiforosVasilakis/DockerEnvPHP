<?php
session_start();

$availableCourses = $availableCourses ?? [];
$enrolledCourses = $enrolledCourses ?? [];

// Map enrolled course ids for quick lookup
$enrolledMap = [];
foreach ($enrolledCourses as $enrolledCourse) {
	$enrolledMap[$enrolledCourse['id']] = true;
}

// Build unified list with enrolled flag
$courses = $availableCourses;
foreach ($courses as &$course) {
	$course['enrolled'] = !empty($enrolledMap[$course['id']] ?? false);
}
unset($course);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Courses</title>
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
		margin-left: 240px; /* student sidebar width */
		margin-top: 70px;   /* top bar height */
		padding: 3rem;
	}

/* Section wrapper */
.courses-section { margin-top: 1.5rem; }
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
.toolbar { display: flex; gap: 0.6rem; margin-top: 0.75rem; }
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

/* Grid cards */
.courses-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
	gap: 1rem;
	margin-top: 1rem;
}
.course-card {
	background: white;
	border-radius: 14px;
	padding: 1rem;
	border: 1px solid #e5e7eb;
	box-shadow: 0 8px 20px rgba(0,0,0,0.08);
	transition: transform 0.15s ease, box-shadow 0.2s ease;
}
.course-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
.card-header { display: flex; justify-content: space-between; align-items: center; }
.code {
	font-weight: 800; color: #4338ca; background: #eef2ff; border: 1px solid #c7d2fe;
	border-radius: 8px; padding: 0.3rem 0.5rem;
}
.title { font-weight: 900; color: #111827; margin: 0.35rem 0; }
.subtext { color: #6b7280; font-size: 0.9rem; }
.badges { display: flex; gap: 0.5rem; align-items: center; }
.badge { background: #f1f5f9; color: #0f172a; border-radius: 999px; padding: 0.3rem 0.6rem; font-weight: 700; font-size: 0.8rem; }
.badge-pub { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
.badge-draft { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

.card-actions { margin-top: 0.75rem; display: flex; justify-content: flex-end; gap: 0.5rem; }
.action-btn {
	padding: 0.5rem 0.8rem;
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: white; border: none; border-radius: 10px; font-weight: 800;
	box-shadow: 0 6px 16px rgba(102, 126, 234, 0.35);
	cursor: pointer;
}
.action-btn:disabled { opacity: 0.6; cursor: not-allowed; }
.action-link:link, .action-link:visited { text-decoration: none; display: inline-block; }

.empty-state {
	margin-top: 1rem; padding: 1rem; color: #6b7280; text-align: center;
	background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 12px;
}
@media (max-width: 640px) {
	.section-header { flex-direction: column; align-items: flex-start; }
}
	</style>
</head>
<body>
	<?php include_once __DIR__ . '/../../../../components/sidebar-stud.php'; ?>
	<?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>

	<div class="page-wrapper">
		<div class="content">

<section class="courses-section">
	<div class="section-header">
		<h3 class="section-title">My Courses</h3>
		<div class="section-pill">Total: <?php echo count($courses); ?></div>
	</div>
	<div class="toolbar">
		<input class="search-input" type="text" placeholder="Search courses by title or code (UI only)">
	</div>

	<?php if (isset($_SESSION['success'])): ?>
		<div class="empty-state" style="background:#e6fffa; border-color:#38b2ac; color:#0c6f5c; font-weight:700;">
			<?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
		</div>
	<?php endif; ?>

	<?php if (isset($_SESSION['error'])): ?>
		<div class="empty-state" style="background:#ffe6e6; border-color:#e53e3e; color:#9b1c1c; font-weight:700;">
			<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($courses)): ?>
		<div class="courses-grid">
			<?php foreach ($courses as $c): ?>
				<?php
					$code = htmlspecialchars($c['course_code']);
					$title = htmlspecialchars($c['title']);
					$teacher = htmlspecialchars($c['teacher_name'] ?? ($c['teacher'] ?? ''));
					$desc = htmlspecialchars($c['description']);
					$created = htmlspecialchars($c['created_at']);
					$published = !empty($c['is_published']);
					$enrolled = !empty($c['enrolled']);
				?>
				<div class="course-card">
					<div class="card-header">
						<span class="code"><?php echo $code; ?></span>
						<div class="badges">
							<span class="badge">Created: <?php echo $created; ?></span>
							<span class="badge <?php echo $published ? 'badge-pub' : 'badge-draft'; ?>">
								<?php echo $published ? 'Published' : 'Draft'; ?>
							</span>
							<?php if ($enrolled): ?>
								<span class="badge badge-pub">Enrolled</span>
							<?php endif; ?>
						</div>
					</div>
					<h4 class="title"><?php echo $title; ?></h4>
					<div class="subtext">Teacher: <?php echo $teacher; ?></div>
					<p class="subtext" style="margin-top: 0.5rem;"><?php echo $desc; ?></p>
					<div class="card-actions">
						<?php if ($enrolled): ?>
							<a class="action-link action-btn" href="<?php echo BASE_URL ?? ''; ?>/project/student/dashboard/courses/views?id=<?php echo $c['id']; ?>">Open</a>
						<?php else: ?>
							<form method="POST" style="margin:0;" action="<?php echo BASE_URL ?? ''; ?>/project/student/dashboard/courses/join">
								<input type="hidden" name="course_id" value="<?php echo $c['id']; ?>">
								<button class="action-btn" type="submit">Join</button>
							</form>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="empty-state">No courses available yet. Check back soon.</div>
	<?php endif; ?>
</section>
		</div>
	</div>
</body>
</html>