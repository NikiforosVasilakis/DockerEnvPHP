<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define BASE_URL if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

// Get assignment ID from query string
$assignment_id = $_GET['id'] ?? 1;

// Resolve student_id from session
$student_id = null;
if (isset($_SESSION['user_id'])) {
    $student_id = (int)$_SESSION['user_id'];
} elseif (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
    $student_id = (int)$_SESSION['user']['id'];
} elseif (isset($_SESSION['id'])) {
    $student_id = (int)$_SESSION['id'];
}

// Database connection
$host = 'db';
$username = 'root';
$password = 'rootpass';
$database = 'Univercity_DB';

$assignment = null;
$submission_success = false;
$error_message = '';
$existing_submission = null;

$conn = @new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    $error_message = 'Database connection failed. Please try again later.';
} else {
    // If student_id not in session, try to get it by email
    if (empty($student_id) && !empty($_SESSION['email'])) {
        if ($stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1')) {
            $stmt->bind_param('s', $_SESSION['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $student_id = (int)$row['id'];
            }
            $stmt->close();
        }
    }

    // Fetch assignment details from database
    $sql = "SELECT 
                a.id,
                a.title,
                a.description,
                a.max_points,
                a.due_at,
                c.title AS course_title,
                c.course_code
            FROM assignments a
            INNER JOIN courses c ON a.course_id = c.id
            WHERE a.id = ?
            LIMIT 1";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $assignment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $assignment = [
                'id' => $row['id'],
                'title' => $row['title'],
                'course' => $row['course_title'] . ' (' . $row['course_code'] . ')',
                'description' => $row['description'] ?? 'No description provided.',
                'due_date' => $row['due_at'],
                'max_points' => $row['max_points']
            ];
        } else {
            $error_message = 'Assignment not found.';
        }
        $stmt->close();
    }

    // Check for existing submission
    if (!empty($student_id)) {
        $sql_check = "SELECT 
                        sub.id,
                        sub.attempt_no,
                        sub.submission_text,
                        sub.submission_path,
                        sub.submitted_at,
                        sub.status,
                        g.points_awarded,
                        g.feedback AS grade_feedback
                    FROM assignment_submissions sub
                    LEFT JOIN grades g ON sub.id = g.submission_id
                    WHERE sub.assignment_id = ? AND sub.student_id = ?
                    ORDER BY sub.attempt_no DESC
                    LIMIT 1";
        
        if ($stmt = $conn->prepare($sql_check)) {
            $stmt->bind_param('ii', $assignment_id, $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $existing_submission = [
                    'id' => $row['id'],
                    'attempt_no' => $row['attempt_no'],
                    'submission_text' => $row['submission_text'],
                    'submission_path' => $row['submission_path'],
                    'submitted_at' => $row['submitted_at'],
                    'status' => $row['status'],
                    'points_awarded' => $row['points_awarded'],
                    'grade_feedback' => $row['grade_feedback']
                ];
            }
            $stmt->close();
        }
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_assignment']) && !empty($student_id) && $assignment) {
        $submission_text = $_POST['submission_text'] ?? '';
        $file_path = null;

        // Handle file upload
        if (isset($_FILES['submission_file']) && $_FILES['submission_file']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../../../../../../uploads/submissions/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_name = time() . '_' . basename($_FILES['submission_file']['name']);
            $target_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['submission_file']['tmp_name'], $target_path)) {
                $file_path = 'uploads/submissions/' . $file_name;
            }
        }

        // Get next attempt number for this student/assignment
        $attempt_no = 1;
        if ($stmt = $conn->prepare('SELECT MAX(attempt_no) as max_attempt FROM assignment_submissions WHERE assignment_id = ? AND student_id = ?')) {
            $stmt->bind_param('ii', $assignment_id, $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc() && $row['max_attempt'] !== null) {
                $attempt_no = (int)$row['max_attempt'] + 1;
            }
            $stmt->close();
        }

        // Check if submission is late
        $status = 'SUBMITTED';
        if (!empty($assignment['due_date']) && strtotime($assignment['due_date']) < time()) {
            $status = 'LATE';
        }

        // Insert submission into database
        $sql_insert = "INSERT INTO assignment_submissions 
                       (assignment_id, student_id, attempt_no, submission_text, submission_path, status)
                       VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql_insert)) {
            $stmt->bind_param('iiisss', $assignment_id, $student_id, $attempt_no, $submission_text, $file_path, $status);
            
            if ($stmt->execute()) {
                $submission_success = true;
            } else {
                $error_message = 'Failed to submit assignment. Please try again.';
            }
            $stmt->close();
        }
    }

    $conn->close();
}

// If no assignment found and no error yet, set default error
if (!$assignment && empty($error_message)) {
    $assignment = [
        'id' => $assignment_id,
        'title' => 'Assignment Not Found',
        'course' => 'Unknown',
        'description' => 'This assignment could not be loaded.',
        'due_date' => date('Y-m-d'),
        'max_points' => 0
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Assignment - Student Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9edf3 100%);
            color: #1a1a1a;
            min-height: 100vh;
        }

        .main-container {
            margin-left: 240px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
            position: relative;
            z-index: 1;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 18px;
            margin-bottom: 2rem;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .page-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .page-header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }

        .submission-card {
            background: white;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-title::before {
            content: '';
            width: 4px;
            height: 28px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.2s ease;
            background: #f9fafb;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-textarea {
            min-height: 200px;
            resize: vertical;
        }

        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #f9fafb;
            transition: all 0.2s ease;
            cursor: pointer;
            display: block;
            width: 100%;
            position: relative;
        }

        .file-upload-area:hover {
            border-color: #667eea;
            background: #f0f0ff;
        }

        .file-upload-area input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .file-upload-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
            pointer-events: none;
        }

        .file-upload-text {
            color: #6b7280;
            font-size: 0.95rem;
            font-weight: 600;
            pointer-events: none;
        }

        .file-upload-hint {
            color: #9ca3af;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            pointer-events: none;
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            transition: all 0.2s ease;
            width: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .assignment-info {
            background: white;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            height: fit-content;
            position: sticky;
            top: 90px;
        }

        .info-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1rem;
            color: #1a1a1a;
            font-weight: 600;
        }

        .due-date {
            color: #ec4899;
            font-weight: 700;
        }

        .success-message {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 14px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            font-size: 2rem;
        }

        .success-text h3 {
            margin-bottom: 0.25rem;
            font-size: 1.2rem;
        }

        .success-text p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1rem;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            gap: 0.75rem;
        }

        .description-box {
            background: #f9fafb;
            padding: 1rem;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .assignment-info {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                margin-left: 180px;
                padding: 1.5rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .submission-card,
            .assignment-info {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php 
    $sidebar_path = __DIR__ . '/../../../../components/sidebar-stud.php';
    $topbar_path = __DIR__ . '/../../../../components/top-bar.php';
    
    if (file_exists($sidebar_path)) {
        include $sidebar_path;
    }
    if (file_exists($topbar_path)) {
        include $topbar_path;
    }
    ?>

    <div class="main-container">
        <?php if (!empty($error_message)): ?>
            <div class="success-message" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                <div class="success-icon">⚠</div>
                <div class="success-text">
                    <h3>Error</h3>
                    <p><?php echo htmlspecialchars($error_message); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($submission_success): ?>
            <div class="success-message">
                <div class="success-icon">✓</div>
                <div class="success-text">
                    <h3>Submitted Successfully!</h3>
                    <p>Your assignment has been submitted at <?php echo date('M d, Y h:i A'); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="page-header">
            <div class="breadcrumb">
                <a href="<?php echo BASE_URL ?? ''; ?>/project/student/dashboard/assignments">Assignments</a>
                <span>›</span>
                <span>Submit Assignment</span>
            </div>
            <h1><?php echo htmlspecialchars($assignment['title']); ?></h1>
            <p><?php echo htmlspecialchars($assignment['course']); ?></p>
        </div>

        <div class="content-grid">
            <div class="submission-card">
                <h2 class="card-title"><?php echo $existing_submission ? 'Resubmit Your Work' : 'Submit Your Work'; ?></h2>

                <?php if ($existing_submission && !$submission_success): ?>
                    <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
                        <div style="font-weight: 700; color: #0369a1; margin-bottom: 0.5rem;">
                            📝 Previous Submission (Attempt #<?php echo $existing_submission['attempt_no']; ?>)
                        </div>
                        <div style="font-size: 0.9rem; color: #0c4a6e; margin-bottom: 0.5rem;">
                            <strong>Submitted:</strong> <?php echo date('M d, Y h:i A', strtotime($existing_submission['submitted_at'])); ?>
                        </div>
                        <?php if ($existing_submission['points_awarded'] !== null): ?>
                            <div style="font-size: 0.9rem; color: #15803d; margin-bottom: 0.5rem;">
                                <strong>Grade:</strong> <?php echo htmlspecialchars($existing_submission['points_awarded']); ?>/<?php echo htmlspecialchars((string)$assignment['max_points']); ?> points
                            </div>
                            <?php if ($existing_submission['grade_feedback']): ?>
                                <div style="font-size: 0.9rem; color: #0c4a6e;">
                                    <strong>Feedback:</strong> <?php echo nl2br(htmlspecialchars($existing_submission['grade_feedback'])); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($existing_submission['submission_path']): ?>
                            <div style="font-size: 0.9rem; color: #0c4a6e; margin-top: 0.5rem;">
                                <strong>File:</strong> <?php echo htmlspecialchars(basename($existing_submission['submission_path'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="assignment_id" value="<?php echo htmlspecialchars((string)$assignment['id']); ?>">

                    <div class="form-group">
                        <label class="form-label" for="submission_text">Submission Text</label>
                        <textarea 
                            class="form-textarea" 
                            id="submission_text" 
                            name="submission_text" 
                            placeholder="Enter your submission text, notes, or comments here..."
                            <?php echo $submission_success ? 'disabled' : ''; ?>
                        ><?php echo $submission_success ? 'Assignment submitted successfully! Your work has been saved to the database and is now awaiting grading.' : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="submission_file">Upload Files (Optional)</label>
                        <div class="file-upload-area" onclick="document.getElementById('submission_file').click();">
                            <input type="file" id="submission_file" name="submission_file" accept=".pdf,.docx,.zip" <?php echo $submission_success ? 'disabled' : ''; ?>>
                            <div class="file-upload-icon">📁</div>
                            <div class="file-upload-text">Click to upload or drag and drop</div>
                            <div class="file-upload-hint">PDF, DOCX, ZIP (max 10MB)</div>
                        </div>
                    </div>

                    <?php if (!$submission_success): ?>
                        <button type="submit" name="submit_assignment" class="submit-btn">
                               <?php echo $existing_submission ? 'Submit New Attempt' : 'Submit Assignment'; ?>
                        </button>
                    <?php else: ?>
                        <button type="button" class="submit-btn" style="background: #10b981; cursor: default;">
                            ✓ Submitted
                        </button>
                        <a href="<?php echo BASE_URL ?? ''; ?>/project/student/dashboard/assignments" class="back-link">
                            ← Back to Assignments
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <aside class="assignment-info">
                <h3 class="card-title" style="font-size: 1.2rem;">Assignment Details</h3>

                <div class="info-item">
                    <div class="info-label">Course</div>
                    <div class="info-value"><?php echo htmlspecialchars($assignment['course']); ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Due Date</div>
                    <div class="info-value due-date">
                        <?php echo date('M d, Y', strtotime($assignment['due_date'])); ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Max Points</div>
                    <div class="info-value"><?php echo htmlspecialchars((string)$assignment['max_points']); ?> points</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value" style="color: <?php echo ($submission_success || $existing_submission) ? '#10b981' : '#f59e0b'; ?>;">
                        <?php 
                        if ($submission_success) {
                            echo '✓ Submitted';
                        } elseif ($existing_submission) {
                            if ($existing_submission['points_awarded'] !== null) {
                                echo '✓ Graded (' . htmlspecialchars($existing_submission['points_awarded']) . '/' . htmlspecialchars((string)$assignment['max_points']) . ')';
                            } else {
                                echo '✓ Submitted (Attempt #' . $existing_submission['attempt_no'] . ')';
                            }
                        } else {
                            echo '⏳ Not Submitted';
                        }
                        ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Description</div>
                    <div class="description-box">
                        <?php echo nl2br(htmlspecialchars($assignment['description'])); ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        // File upload preview
        const fileInput = document.getElementById('submission_file');
        const uploadArea = fileInput?.parentElement;
        
        if (fileInput && uploadArea) {
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
                    uploadArea.querySelector('.file-upload-text').textContent = fileName;
                    uploadArea.querySelector('.file-upload-hint').textContent = `Size: ${fileSize} MB`;
                    uploadArea.style.borderColor = '#667eea';
                    uploadArea.style.background = '#f0f0ff';
                }
            });
        }
    </script>
</body>
</html>
