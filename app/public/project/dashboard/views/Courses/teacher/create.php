<?php
session_start();

// Database connection
include_once __DIR__ . '/../../../../auth/connect.php';

$error_message = '';
$success_message = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = isset($_POST['course_name']) ? trim($_POST['course_name']) : '';
    $course_code = isset($_POST['course_code']) ? trim($_POST['course_code']) : '';
    $course_subtitle = isset($_POST['course_subtitle']) ? trim($_POST['course_subtitle']) : '';
    $course_description = isset($_POST['course_description']) ? trim($_POST['course_description']) : '';
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    
    // Validation
    if (empty($course_name) || empty($course_code) || empty($course_subtitle)) {
        $error_message = 'Please fill in all required fields (Course Name, Course Code, and Subtitle).';
    } else {
        // Require a logged-in teacher
        if (empty($_SESSION['user_id'])) {
            $error_message = 'You must be logged in to create a course.';
        } else {
            $teacher_id = (int)$_SESSION['user_id'];

            // Verify teacher exists and is role_id = 2 (Teacher)
            $verify_sql = "SELECT id FROM users WHERE id = ? AND role_id = 2";
            $verify_stmt = $conn->prepare($verify_sql);
            $verify_stmt->bind_param('i', $teacher_id);
            $verify_stmt->execute();
            $verify_result = $verify_stmt->get_result();

            if ($verify_result->num_rows === 0) {
                $error_message = 'Invalid teacher account. Please ensure you are logged in as a teacher.';
            } else {
                // Check if course code already exists
                $check_sql = "SELECT id FROM courses WHERE course_code = ?";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->bind_param('s', $course_code);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();

                if ($check_result->num_rows > 0) {
                    $error_message = 'Course code already exists. Please use a different code.';
                } else {
                    // Use subtitle as description if description is empty
                    if (empty($course_description) && !empty($course_subtitle)) {
                        $course_description = $course_subtitle;
                    }

                    // Insert course into database
                    $insert_sql = "INSERT INTO courses (teacher_id, course_code, title, description, is_published, created_at) 
                                  VALUES (?, ?, ?, ?, ?, NOW())";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param('isssi', $teacher_id, $course_code, $course_name, $course_description, $is_published);

                    if ($insert_stmt->execute()) {
                        $success_message = 'Course created successfully!';
                        // Redirect to course list after 2 seconds
                        header('Refresh: 2; url=index.php');
                    } else {
                        $error_message = 'Error creating course: ' . $conn->error;
                    }
                    $insert_stmt->close();
                }
                $check_stmt->close();
            }
            $verify_stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Course</title>
    <link rel="stylesheet" href="../../../css/styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            background: #f5f5f5;
        }

        .main-content {
            margin-left: 240px;
            margin-top: 70px;
            flex: 1;
            padding: 2rem;
            background: #f5f5f5;
        }

        .create-form-container {
            background: white;
            border-radius: 18px;
            padding: 2.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .form-label .required {
            color: #ef4444;
        }

        .form-input,
        .form-textarea {
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s ease;
            color: #1a1a1a;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #5B5FFF;
            box-shadow: 0 0 0 3px rgba(91, 95, 255, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-group.checkbox {
            flex-direction: row;
            align-items: center;
            gap: 0.75rem;
        }

        .form-group.checkbox input {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .form-group.checkbox label {
            margin: 0;
            font-weight: 500;
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .form-btn {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
        }

        .btn-submit {
            background: #5B5FFF;
            color: white;
            box-shadow: 0 2px 8px rgba(91, 95, 255, 0.3);
        }

        .btn-submit:hover {
            background: #4a4ecc;
            box-shadow: 0 4px 12px rgba(91, 95, 255, 0.4);
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-cancel:hover {
            background: #d1d5db;
        }

        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 2px solid #fca5a5;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 2px solid #86efac;
        }

        .form-hint {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.35rem;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 200px;
                padding: 1.5rem;
            }

            .create-form-container {
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 180px;
                padding: 1rem;
            }

            .create-form-container {
                padding: 1.5rem;
                border-radius: 12px;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        <?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>

        <!-- Main Content -->
        <div style="flex: 1;">
            <!-- Top Bar -->
            <?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>

            <!-- Page Content -->
            <div class="main-content">
                <div class="create-form-container">
                    <h1 class="form-title">Create New Course</h1>

                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-error">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($success_message); ?>
                            Redirecting to course list...
                        </div>
                    <?php endif; ?>

                   <form method="POST" action="<?= BASE_URL ?>/project/teacher/dashboard/cources/courses">
                        <!-- Course Name -->
                        <div class="form-group">
                            <label class="form-label">
                                Course Name <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="course_name" 
                                class="form-input" 
                                placeholder="e.g., Web Development Basics"
                                value="<?php echo isset($_POST['course_name']) ? htmlspecialchars($_POST['course_name']) : ''; ?>"
                                required
                            >
                            <div class="form-hint">Enter the full name of your course</div>
                        </div>

                        <!-- Course Code -->
                        <div class="form-group">
                            <label class="form-label">
                                Course Code <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="course_code" 
                                class="form-input" 
                                placeholder="e.g., CS101"
                                value="<?php echo isset($_POST['course_code']) ? htmlspecialchars($_POST['course_code']) : ''; ?>"
                                required
                            >
                            <div class="form-hint">Use a unique code (e.g., CS101, WEB201)</div>
                        </div>

                        <!-- Subtitle -->
                        <div class="form-group">
                            <label class="form-label">
                                Course Subtitle <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="course_subtitle" 
                                class="form-input" 
                                placeholder="e.g., HTML, CSS & JavaScript Fundamentals"
                                value="<?php echo isset($_POST['course_subtitle']) ? htmlspecialchars($_POST['course_subtitle']) : ''; ?>"
                                required
                            >
                            <div class="form-hint">A brief subtitle describing the course focus</div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label class="form-label">
                                Course Description
                            </label>
                            <textarea 
                                name="course_description" 
                                class="form-textarea" 
                                placeholder="Provide a detailed description of what students will learn in this course..."
                            ><?php echo isset($_POST['course_description']) ? htmlspecialchars($_POST['course_description']) : ''; ?></textarea>
                            <div class="form-hint">Optional - Add details about course content and objectives</div>
                        </div>

                        <!-- Publish -->
                        <div class="form-group checkbox">
                            <input 
                                type="checkbox" 
                                name="is_published" 
                                id="is_published"
                                <?php echo (isset($_POST['is_published']) && $_POST['is_published']) ? 'checked' : ''; ?>
                            >
                            <label for="is_published">Publish this course immediately</label>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="submit" class="form-btn btn-submit">Create Course</button>
                            <a href="index.php" class="form-btn btn-cancel" style="text-decoration: none; text-align: center;">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
