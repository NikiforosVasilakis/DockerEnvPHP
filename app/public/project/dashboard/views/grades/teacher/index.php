<?php
// Normalize student fields (DB result uses username)
$students = $students ?? [];
$success = $success ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Teacher - Add Grades</title>
	<style>
		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background: linear-gradient(135deg, #f5f7fa 0%, #e9edf3 100%);
			color: #1a1a1a;
		}

		.page-wrapper {
			display: flex;
			min-height: 100vh;
			background: transparent;
		}

		.content {
			flex: 1;
			margin-left: 240px;
			margin-top: 70px;
			padding: 3rem;
		}

		.hero {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			padding: 2rem;
			border-radius: 18px;
			box-shadow: 0 10px 25px rgba(102, 126, 234, 0.35);
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 1.5rem;
		}

		.hero h1 {
			margin: 0 0 0.25rem 0;
			font-size: 1.9rem;
		}

		.hero p {
			margin: 0;
			opacity: 0.9;
		}

		.hero-pill {
			background: rgba(255, 255, 255, 0.15);
			border: 1px solid rgba(255, 255, 255, 0.3);
			padding: 0.75rem 1.25rem;
			border-radius: 999px;
			font-weight: 700;
			letter-spacing: 0.4px;
			text-transform: uppercase;
			font-size: 0.85rem;
		}

		.card {
			margin-top: 2rem;
			background: white;
			border-radius: 16px;
			padding: 1.5rem;
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
			border: 1px solid #e5e7eb;
		}

		.card h2 {
			margin: 0 0 1rem 0;
			font-size: 1.4rem;
			color: #1f2937;
			display: flex;
			align-items: center;
			gap: 0.6rem;
		}

		.card h2::before {
			content: '';
			width: 6px;
			height: 26px;
			border-radius: 3px;
			background: linear-gradient(135deg, #667eea, #764ba2);
		}

		.table {
			width: 100%;
			border-collapse: collapse;
		}

		.table thead {
			background: #f7f9fc;
		}

		.table th, .table td {
			padding: 0.85rem 1rem;
			text-align: left;
		}

		.table th {
			font-size: 0.9rem;
			text-transform: uppercase;
			letter-spacing: 0.4px;
			color: #6b7280;
		}

		.table tbody tr {
			border-bottom: 1px solid #e5e7eb;
			transition: background 0.2s ease;
		}

		.table tbody tr:last-child {
			border-bottom: none;
		}

		.table tbody tr:hover {
			background: #f9fafb;
		}

		.name {
			font-weight: 700;
			color: #111827;
		}

		.subtext {
			color: #6b7280;
			font-size: 0.9rem;
		}

		.badge {
			display: inline-flex;
			align-items: center;
			padding: 0.35rem 0.75rem;
			border-radius: 999px;
			font-size: 0.85rem;
			font-weight: 700;
			background: #eef2ff;
			color: #4338ca;
		}

		.action-btn {
			display: inline-flex;
			align-items: center;
			gap: 0.4rem;
			padding: 0.55rem 0.9rem;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			border: none;
			border-radius: 10px;
			cursor: pointer;
			font-weight: 700;
			box-shadow: 0 8px 20px rgba(102, 126, 234, 0.35);
			transition: transform 0.15s ease, box-shadow 0.2s ease;
		}

		.action-btn:hover {
			transform: translateY(-1px);
			box-shadow: 0 12px 26px rgba(102, 126, 234, 0.4);
		}

		.empty-state {
			padding: 2rem;
			text-align: center;
			color: #6b7280;
		}

		.alert-success {
			margin-top: 1rem;
			background: #ecfdf3;
			border: 1px solid #bbf7d0;
			color: #166534;
			padding: 0.9rem 1.2rem;
			border-radius: 12px;
			font-weight: 700;
		}

		@media (max-width: 900px) {
			.content {
				margin-left: 200px;
				padding: 2rem;
			}

			.table th:nth-child(3),
			.table td:nth-child(3),
			.table th:nth-child(4),
			.table td:nth-child(4) {
				display: none;
			}
		}

		@media (max-width: 640px) {
			.content {
				margin-left: 0;
				padding: 1.25rem;
				margin-top: 60px;
			}

			.hero {
				flex-direction: column;
				align-items: flex-start;
			}

			.table th:nth-child(2),
			.table td:nth-child(2) {
				display: none;
			}
		}
	</style>
</head>
<body>
	<?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>
	<?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>

	<div class="page-wrapper">
		<div class="content">
			<div class="hero">
				<div>
					<h1>Grades</h1>
					<p>Select a student to add or edit grades.</p>
				</div>
				<div class="hero-pill">Teacher View</div>
			</div>

			<?php if (!empty($success)): ?>
				<div class="alert-success"><?php echo htmlspecialchars($success); ?></div>
			<?php endif; ?>

			<div class="card">
				<h2>Students</h2>
				<?php if (!empty($students)): ?>
					<table class="table">
						<thead>
							<tr>
								<th>Student</th>
								<th>Email</th>
								<th>Course</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($students as $student): ?>
								<?php
									$studentName = $student['username'] ?? ($student['name'] ?? 'Student');
									$studentId = $student['id'] ?? 0;
									$courseLabel = $student['course'] ?? '—';
									$progressLabel = $student['progress'] ?? 'Active';
								?>
								<tr>
									<td>
										<div class="name"><?php echo htmlspecialchars($studentName); ?></div>
										<div class="subtext">ID: <?php echo htmlspecialchars((string) $studentId); ?></div>
									</td>
									<td class="subtext"><?php echo htmlspecialchars($student['email'] ?? ''); ?></td>
									<td class="subtext"><?php echo htmlspecialchars($courseLabel); ?></td>
									<td><span class="badge"><?php echo htmlspecialchars($progressLabel); ?></span></td>
									<td>
										<?php if ($studentId > 0): ?>
											<a class="action-btn" href="<?php echo BASE_URL; ?>/project/teacher/dashboard/grades/add?student_id=<?php echo urlencode((string) $studentId); ?>">
												<span>+ Add Grade</span>
											</a>
										<?php else: ?>
											<span class="subtext">No ID available</span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="empty-state">No students yet. Connect to the database to load data.</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</body>
</html>
