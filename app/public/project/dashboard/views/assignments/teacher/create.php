<?php
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? null;
$old = $_SESSION['old'] ?? [];

// Ensure courses variable exists
$courses = $courses ?? [];

unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Create Assignment</title>
    <link rel="stylesheet" href="../../../css/styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
        }

        .main-content {
            margin-left: 240px;
            margin-top: 70px;
            flex: 1;
            padding: 1.5rem;
            background: transparent;
        }

        .page-header {
            margin-bottom: 2rem;
            animation: fadeInDown 0.6s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-content h1 {
            font-size: 1.75rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0 0 0.25rem 0;
        }

        .header-content p {
            color: #718096;
            font-size: 0.9rem;
            margin: 0;
            font-weight: 500;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #764ba2;
            gap: 0.75rem;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            border-left: 4px solid #ff5252;
        }

        .alert-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border-left: 4px solid #43e97b;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .alert li {
            margin: 0.25rem 0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Form Container */
        .form-container {
            background: white;
            border-radius: 14px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(102, 126, 234, 0.1);
            animation: fadeInUp 0.6s ease-out 0.2s both;
            max-width: 700px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
            letter-spacing: 0.3px;
        }

        .form-group label .required {
            color: #ff6b6b;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-hint {
            font-size: 0.8rem;
            color: #718096;
            margin-top: 0.4rem;
            font-weight: 500;
        }

        .form-group-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .checkbox-group label {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
        }

        .form-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #2d3748;
            box-shadow: none;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
            transform: translateY(-2px);
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 180px;
                padding: 1rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .form-group-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .form-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .header-content h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>
        <div style="flex: 1;">
            <?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>
            <div class="main-content">
                <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments" class="back-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to Assignments
                </a>

                <div class="page-header">
                    <div class="header-content">
                        <h1>Create New Assignment</h1>
                        <p>Add a new assignment to your course</p>
                    </div>
                </div>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <strong>Success!</strong> Assignment created successfully. Redirecting...
                    </div>
                <?php elseif (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <strong>Please fix the following errors:</strong>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments" class="form-container">
                    <div class="form-group">
                        <label for="title">
                            Assignment Title <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            placeholder="e.g., HTML & CSS Basics"
                            value="<?php echo htmlspecialchars($old['title'] ?? ''); ?>"
                            required
                        >
                        <div class="form-hint">Give your assignment a clear, descriptive title (3-100 characters)</div>
                    </div>

                    <div class="form-group">
                        <label for="course_id">
                            Select Course <span class="required">*</span>
                        </label>
                        <select id="course_id" name="course_id" required>
                            <option value="">Choose a course...</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?php echo $course['id']; ?>" <?php echo (!empty($old['course_id']) && $old['course_id'] == $course['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($course['title']); ?> (<?php echo $course['code']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-hint">Select the course this assignment belongs to</div>
                    </div>

                    <div class="form-group">
                        <label for="description">
                            Description <span class="required">*</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            placeholder="Describe the assignment requirements, objectives, and any additional instructions for students..."
                            required
                        ><?php echo htmlspecialchars($old['description'] ?? ''); ?></textarea>
                        <div class="form-hint">Provide clear instructions and expectations for students (minimum 10 characters)</div>
                    </div>

                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="max_points">
                                Max Points <span class="required">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="max_points" 
                                name="max_points" 
                                placeholder="e.g., 100"
                                min="1"
                                step="1"
                                value="<?php echo htmlspecialchars($old['max_points'] ?? '100'); ?>"
                                required
                            >
                            <div class="form-hint">Total points for this assignment</div>
                        </div>

                        <div class="form-group">
                            <label for="due_at">
                                Due Date <span class="required">*</span>
                            </label>
                            <input 
                                type="datetime-local" 
                                id="due_at" 
                                name="due_at"
                                value="<?php echo htmlspecialchars($old['due_at'] ?? ''); ?>"
                                required
                            >
                            <div class="form-hint">When should students submit this?</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Options</label>
                        <div class="checkbox-group">
                            <input 
                                type="checkbox" 
                                id="allow_late" 
                                name="allow_late"
                                <?php echo (!empty($old['allow_late'])) ? 'checked' : ''; ?>
                            >
                            <label for="allow_late">Allow late submissions</label>
                        </div>
                        <div class="form-hint">Check this if students can submit after the due date (may apply grade penalties)</div>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Create Assignment
                        </button>
                        <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments" class="btn btn-secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
