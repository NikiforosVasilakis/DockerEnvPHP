<?php
// Fetch students from DB (simple inline query for dashboard list)
$students = [];

$host = 'db';
$username = 'root';
$password = 'rootpass';
$database = 'Univercity_DB';

$conn = @new mysqli($host, $username, $password, $database);
if (!$conn->connect_error) {
	$sql = "SELECT u.id, u.username, u.email, u.created_at
			FROM users u
			JOIN user_roles r ON u.role_id = r.id
			WHERE LOWER(r.role_name) = 'student'
			ORDER BY u.username ASC";
	if ($result = $conn->query($sql)) {
		$students = $result->fetch_all(MYSQLI_ASSOC);
		$result->free();
	}
}
// keep going even if DB unavailable; UI will show empty state
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Students</title>
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
	/* removed top hero box styles */
    
/* Section wrapper */
.students-section { margin-top: 1.5rem; }
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
.students-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
	gap: 1rem;
	margin-top: 1rem;
}
.student-card {
	background: white;
	border-radius: 14px;
	padding: 1rem;
	border: 1px solid #e5e7eb;
	box-shadow: 0 8px 20px rgba(0,0,0,0.08);
	transition: transform 0.15s ease, box-shadow 0.2s ease;
}
.student-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
.card-header { display: flex; align-items: center; gap: 0.75rem; }
.avatar {
	width: 40px; height: 40px; border-radius: 50%;
	display: inline-flex; align-items: center; justify-content: center;
	background: #eef2ff; color: #4338ca; font-weight: 900;
	border: 2px solid #e5e7eb;
}
.name { font-weight: 800; color: #111827; }
.subtext { color: #6b7280; font-size: 0.9rem; }
.meta { display: flex; justify-content: space-between; align-items: center; margin-top: 0.75rem; }
.badge { background: #f1f5f9; color: #0f172a; border-radius: 999px; padding: 0.3rem 0.6rem; font-weight: 700; font-size: 0.8rem; }
.action-btn {
	padding: 0.5rem 0.8rem;
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: white; border: none; border-radius: 10px; font-weight: 800;
	box-shadow: 0 6px 16px rgba(102, 126, 234, 0.35);
	cursor: pointer;
}
.action-btn:link, .action-btn:visited { text-decoration: none; display: inline-block; }
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
			<!-- top hero box removed -->

<section class="students-section">
	<div class="section-header">
		<h3 class="section-title">Students Directory</h3>
		<div class="section-pill">Total: <?php echo count($students); ?></div>
	</div>
	<div class="toolbar">
		<input class="search-input" type="text" placeholder="Search students by name or email (UI only)">
	</div>

	<?php if (!empty($students)): ?>
		<div class="students-grid">
			<?php foreach ($students as $student): ?>
				<?php
					$name = $student['username'];
					$initials = strtoupper(substr($name, 0, 1));
				?>
				<div class="student-card">
					<div class="card-header">
						<div class="avatar"><?php echo htmlspecialchars($initials); ?></div>
						<div>
							<div class="name"><?php echo htmlspecialchars($name); ?></div>
							<div class="subtext">ID: <?php echo htmlspecialchars((string) $student['id']); ?></div>
						</div>
					</div>
					<div class="meta">
						<span class="subtext"><?php echo htmlspecialchars($student['email']); ?></span>
						<span class="badge">Joined: <?php echo htmlspecialchars($student['created_at']); ?></span>
					</div>
					<div style="margin-top: 0.75rem; display: flex; justify-content: flex-end;">
						<a class="action-btn" href="mailto:<?php echo htmlspecialchars($student['email']); ?>?subject=Hello&body=Hi%20<?php echo rawurlencode($name); ?>">Message</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="empty-state">No students found in the database.</div>
	<?php endif; ?>
</section>
		</div>
	</div>
</body>
</html>