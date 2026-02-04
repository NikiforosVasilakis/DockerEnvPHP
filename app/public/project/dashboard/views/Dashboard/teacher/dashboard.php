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
	<title>Teacher Dashboard</title>
	<style>
		* { box-sizing: border-box; }
		body {
			margin: 0;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background: linear-gradient(135deg, #f5f7fa 0%, #e9edf3 100%);
			color: #1a1a1a;
		}
		.layout { display: flex; min-height: 100vh; }
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
		.hero h1 { margin: 0 0 0.25rem 0; font-size: 1.9rem; }
		.hero p { margin: 0; opacity: 0.9; }
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
		.grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
			gap: 1rem;
			margin-top: 2rem;
		}
		.card {
			background: white;
			border-radius: 14px;
			padding: 1.25rem 1.4rem;
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
			border: 1px solid #e5e7eb;
		}
		.card h3 { margin: 0 0 0.35rem 0; font-size: 1rem; color: #4b5563; }
		.metric { font-size: 2rem; font-weight: 800; color: #111827; }
		.muted { color: #6b7280; font-size: 0.9rem; }
		.calendar-card { margin-top: 1.5rem; }
		.table-card { margin-top: 1.5rem; }
		.table { width: 100%; border-collapse: collapse; }
		.table thead { background: #f7f9fc; }
		.table th, .table td { padding: 0.75rem 0.9rem; text-align: left; }
		.table th { font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.4px; color: #6b7280; }
		.table tbody tr { border-bottom: 1px solid #e5e7eb; }
		.table tbody tr:last-child { border-bottom: none; }
		.name { font-weight: 700; color: #111827; }
		.subtext { color: #6b7280; font-size: 0.9rem; }
		.empty-state { padding: 1rem; color: #6b7280; text-align: center; }
		.calendar-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 0.75rem;
		}
		.calendar-header h3 { margin: 0; font-size: 1.1rem; }
		.calendar-grid {
			display: grid;
			grid-template-columns: repeat(7, 1fr);
			gap: 0.35rem;
		}
		.day-name {
			text-align: center;
			font-weight: 700;
			color: #6b7280;
			font-size: 0.85rem;
		}
		.day {
			background: #f9fafb;
			border: 1px solid #e5e7eb;
			border-radius: 10px;
			min-height: 70px;
			padding: 0.4rem;
			text-align: right;
			font-weight: 700;
			color: #374151;
		}
		.day.today { border-color: #667eea; box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.3); }
		@media (max-width: 900px) {
			.content { margin-left: 200px; padding: 2rem; }
		}
		@media (max-width: 640px) {
			.content { margin-left: 0; padding: 1.4rem; margin-top: 60px; }
			.hero { flex-direction: column; align-items: flex-start; }
		}
	</style>
</head>
<body>
	<?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>
	<?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>

	<div class="layout">
		<div class="content">
			<div class="hero">
				<div>
					<h1>Teacher Dashboard</h1>
					<p>Summary of your classes, assignments, students, and grades.</p>
				</div>
				<div class="hero-pill">Overview</div>
			</div>

			<div class="grid">
				<div class="card">
					<h3>Courses</h3>
					<div class="metric">—</div>
					<div class="muted">Total courses you manage</div>
				</div>
				<div class="card">
					<h3>Assignments</h3>
					<div class="metric">—</div>
					<div class="muted">Created assignments</div>
				</div>
				<div class="card">
					<h3>Students</h3>
					<div class="metric"><?php echo count($students); ?></div>
					<div class="muted">Enrolled students</div>
				</div>
				<div class="card">
					<h3>Grades</h3>
					<div class="metric">—</div>
					<div class="muted">Recent grade submissions</div>
				</div>
			</div>

			<div class="card table-card">
				<h3>All Students</h3>
				<?php if (!empty($students)): ?>
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Joined</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($students as $student): ?>
								<tr>
									<td>
										<div class="name"><?php echo htmlspecialchars($student['username']); ?></div>
										<div class="subtext">ID: <?php echo htmlspecialchars((string) $student['id']); ?></div>
									</td>
									<td class="subtext"><?php echo htmlspecialchars($student['email']); ?></td>
									<td class="subtext"><?php echo htmlspecialchars($student['created_at']); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="empty-state">No students found in the database.</div>
				<?php endif; ?>
			</div>

			<div class="card calendar-card">
				<div class="calendar-header">
					<h3 id="monthLabel">Calendar</h3>
					<div class="muted">Today: <span id="todayLabel"></span></div>
				</div>
				<div class="calendar-grid" id="calendar">
					<!-- Calendar will be injected by JS -->
				</div>
			</div>
		</div>
	</div>

	<script>
		(function renderCalendar() {
			const now = new Date();
			const year = now.getFullYear();
			const month = now.getMonth();
			const firstDay = new Date(year, month, 1);
			const startDay = firstDay.getDay();
			const daysInMonth = new Date(year, month + 1, 0).getDate();
			const calendarEl = document.getElementById('calendar');
			const monthLabel = document.getElementById('monthLabel');
			const todayLabel = document.getElementById('todayLabel');

			const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
			const dayNames = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

			monthLabel.textContent = `${monthNames[month]} ${year}`;
			todayLabel.textContent = `${monthNames[month]} ${now.getDate()}, ${year}`;

			// Day name headers
			dayNames.forEach(name => {
				const div = document.createElement('div');
				div.className = 'day-name';
				div.textContent = name;
				calendarEl.appendChild(div);
			});

			// Blank slots before the first day
			for (let i = 0; i < startDay; i++) {
				const blank = document.createElement('div');
				blank.className = 'day';
				calendarEl.appendChild(blank);
			}

			// Actual days
			for (let d = 1; d <= daysInMonth; d++) {
				const div = document.createElement('div');
				div.className = 'day';
				div.textContent = d;
				if (d === now.getDate()) div.classList.add('today');
				calendarEl.appendChild(div);
			}
		})();
	</script>
</body>
</html>
