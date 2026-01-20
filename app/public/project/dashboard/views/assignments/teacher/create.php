<?php
// Middleware handles authentication & role check
// $_SESSION['user'] is populated by login system

include_once __DIR__ . '/../../../../auth/connect.php';

$error_message = '';
$success_message = '';

$teacher_id = (int)$_SESSION['user']['id'];

// Fetch teacher courses for selection
$courses = [];
{
	$course_sql = "SELECT id, title FROM courses WHERE teacher_id = ? ORDER BY title";
	$course_stmt = $conn->prepare($course_sql);
	$course_stmt->bind_param('i', $teacher_id);
	$course_stmt->execute();
	$course_res = $course_stmt->get_result();
	while ($row = $course_res->fetch_assoc()) {
		$courses[] = $row;
	}
	$course_stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error_message)) {
	$course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
	$title = isset($_POST['title']) ? trim($_POST['title']) : '';
	$description = isset($_POST['description']) ? trim($_POST['description']) : '';
	$max_points = isset($_POST['max_points']) ? (float)$_POST['max_points'] : 100.0;
	$due_at = isset($_POST['due_at']) ? trim($_POST['due_at']) : '';
	$allow_late = isset($_POST['allow_late']) ? 1 : 0;
	$attachment_path = null;

	if (empty($course_id) || empty($title)) {
		$error_message = 'Please select a course and provide a title.';
	} else {
		// Handle file upload if provided
		if (!empty($_FILES['attachment']['name'])) {
			$uploadDir = __DIR__ . '/../../../../assets/assignments';
			if (!is_dir($uploadDir)) {
				@mkdir($uploadDir, 0775, true);
			}
			$originalName = basename($_FILES['attachment']['name']);
			$safeName = uniqid('asg_', true) . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $originalName);
			$targetPath = $uploadDir . '/' . $safeName;
			if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
				// Store web-accessible relative path
				$attachment_path = '/app/public/project/assets/assignments/' . $safeName;
			} else {
				$error_message = 'Failed to upload file. Please try again.';
			}
		}

		if (empty($error_message)) {
			$insert_sql = "INSERT INTO assignments (course_id, title, description, attachment_path, max_points, due_at, allow_late, created_at)
						   VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
			$stmt = $conn->prepare($insert_sql);
			$stmt->bind_param(
				'isssdsi',
				$course_id,
				$title,
				$description,
				$attachment_path,
				$max_points,
				$due_at,
				$allow_late
			);
			if ($stmt->execute()) {
				$success_message = 'Assignment created successfully! Redirecting...';
				header('Refresh: 2; url=' . BASE_URL . '/project/teacher/dashboard/assignments');
			} else {
				$error_message = 'Error creating assignment: ' . $conn->error;
			}
			$stmt->close();
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create Assignment</title>
	<link rel="stylesheet" href="../../../css/styles.css">
	<style>
		body { margin: 0; padding: 0; background: #f5f5f5; }
		.main-wrapper { display: flex; min-height: 100vh; background: #f5f5f5; }
		.main-content { margin-left: 240px; margin-top: 70px; flex: 1; padding: 2rem; background: #f5f5f5; }
		.create-form-container { background: white; border-radius: 18px; padding: 2.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 700px; margin: 0 auto; }
		.form-title { font-size: 2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 1.5rem; }
		.form-group { margin-bottom: 1.25rem; display: flex; flex-direction: column; }
		.form-label { font-size: 1rem; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; }
		.form-input, .form-textarea, .form-select { padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem; transition: all 0.2s ease; }
		.form-input:focus, .form-textarea:focus, .form-select:focus { outline: none; border-color: #5B5FFF; box-shadow: 0 0 0 3px rgba(91,95,255,0.1); }
		.form-textarea { resize: vertical; min-height: 120px; }
		.form-actions { display: flex; gap: 1rem; margin-top: 1.5rem; }
		.form-btn { padding: 0.875rem 2rem; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
		.btn-submit { background: #5B5FFF; color: white; box-shadow: 0 2px 8px rgba(91,95,255,0.3); }
		.btn-submit:hover { background: #4a4ecc; box-shadow: 0 4px 12px rgba(91,95,255,0.4); transform: translateY(-2px); }
		.btn-cancel { background: #e5e7eb; color: #374151; }
		.btn-cancel:hover { background: #d1d5db; }
		.alert { padding: 1rem; border-radius: 10px; margin-bottom: 1rem; font-weight: 500; }
		.alert-error { background: #fee2e2; color: #991b1b; border: 2px solid #fca5a5; }
		.alert-success { background: #dcfce7; color: #166534; border: 2px solid #86efac; }
	</style>
</head>
<body>
	<div class="main-wrapper">
		<?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>
		<div style="flex: 1;">
			<?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>
			<div class="main-content">
				<div class="create-form-container">
					<h1 class="form-title">Create Assignment</h1>

					<?php if (!empty($error_message)): ?>
						<div class="alert alert-error"><?php echo htmlspecialchars($error_message); ?></div>
					<?php endif; ?>
					<?php if (!empty($success_message)): ?>
						<div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
					<?php endif; ?>

					<form method="POST" action="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments" enctype="multipart/form-data">
						<div class="form-group">
							<label class="form-label">Course <span style="color:#ef4444">*</span></label>
							<select name="course_id" class="form-select" required>
								<option value="">Select course</option>
								<?php foreach ($courses as $c): ?>
									<option value="<?php echo (int)$c['id']; ?>"><?php echo htmlspecialchars($c['title']); ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label class="form-label">Title <span style="color:#ef4444">*</span></label>
							<input type="text" name="title" class="form-input" placeholder="Assignment title" required />
						</div>

						<div class="form-group">
							<label class="form-label">Description</label>
							<textarea name="description" class="form-textarea" placeholder="Brief description of the assignment"></textarea>
						</div>

						<div class="form-group">
							<label class="form-label">Attachment (optional)</label>
							<input type="file" name="attachment" class="form-input" />
						</div>

						<div class="form-group">
							<label class="form-label">Max Points</label>
							<input type="number" step="0.01" name="max_points" class="form-input" value="100" />
						</div>

						<div class="form-group">
							<label class="form-label">Due Date</label>
							<input type="datetime-local" name="due_at" class="form-input" />
						</div>

						<div class="form-group">
							<label class="form-label">Allow Late Submission</label>
							<input type="checkbox" name="allow_late" />
						</div>

						<div class="form-actions">
							<button type="submit" class="form-btn btn-submit">Create Assignment</button>
							<a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments" class="form-btn btn-cancel" style="text-decoration:none;display:inline-block;text-align:center;">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
