<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Create Course</title>
    <link rel="stylesheet" href="../../../css/styles.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body { 
            margin: 0; 
            padding: 0; 
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
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
            padding: 2.5rem;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 70px);
        }

        .form-container {
            width: 100%;
            max-width: 700px;
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(102, 126, 234, 0.1);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .form-header h1 {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.5px;
        }

        .form-header p {
            color: #718096;
            font-size: 1rem;
            margin: 0;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 2rem;
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
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

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }

        label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 700;
            color: #2d3748;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .label-required {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            color: #2d3748;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        input[type="text"]::placeholder,
        textarea::placeholder {
            color: #a0aec0;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .input-hint {
            font-size: 0.85rem;
            color: #718096;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 10px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        input[type="checkbox"] {
            width: 24px;
            height: 24px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .checkbox-label {
            margin: 0;
            font-weight: 600;
            color: #2d3748;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .checkbox-label-hint {
            font-size: 0.85rem;
            color: #718096;
            font-weight: 400;
            display: block;
            margin-top: 0.25rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }

        .btn {
            flex: 1;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
            transform: translateY(-3px);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
            color: #2d3748;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #cbd5e0 0%, #e2e8f0 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        .alert {
            padding: 1.25rem 1.75rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: slideInDown 0.4s ease-out;
            border-left: 4px solid;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721C24;
            border-left-color: #dc3545;
        }

        .alert-error ul {
            margin: 0.5rem 0 0 1.5rem;
            padding: 0;
        }

        .alert-error li {
            margin-bottom: 0.25rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid transparent;
        }

        .back-link:hover {
            color: #764ba2;
            border-bottom-color: #764ba2;
        }

        .back-link svg {
            width: 18px;
            height: 18px;
        }

        @media (max-width: 1024px) {
            .main-content { 
                margin-left: 200px; 
                padding: 2rem; 
            }
            .form-container {
                padding: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .main-content { 
                margin-left: 180px; 
                padding: 1rem; 
                min-height: auto;
            }
            .form-container {
                padding: 2rem;
                border-radius: 16px;
            }
            .form-header h1 {
                font-size: 1.5rem;
            }
            .form-actions {
                flex-direction: column;
            }
            .btn {
                width: 100%;
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
                <div class="form-container">
                    <div class="form-header">
                        <h1>Create New Course</h1>
                        <p>Set up a course for your students</p>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error">
                            <?php 
                            // Check if error is already HTML-formatted with <br> tags
                            if (strpos($_SESSION['error'], '<br>') !== false) {
                                echo $_SESSION['error'];
                            } else {
                                echo htmlspecialchars($_SESSION['error']);
                            }
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/courses">
                        <div class="form-group">
                            <label for="course_code">
                                Course Code
                                <span class="label-required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="course_code" 
                                name="course_code" 
                                placeholder="e.g., CS101, MATH201" 
                                required
                                maxlength="20"
                                value="<?php echo htmlspecialchars($_POST['course_code'] ?? ''); ?>"
                            >
                            <div class="input-hint">Unique identifier for your course (e.g., CS101, BIO202)</div>
                        </div>

                        <div class="form-group">
                            <label for="title">
                                Course Title
                                <span class="label-required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                placeholder="e.g., Introduction to Web Development" 
                                required
                                maxlength="200"
                                value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
                            >
                            <div class="input-hint">A clear and descriptive name for your course</div>
                        </div>

                        <div class="form-group">
                            <label for="description">
                                Course Description
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                placeholder="Describe your course, learning objectives, topics covered, etc."
                            ><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                            <div class="input-hint">Help students understand what they'll learn in this course</div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox-group">
                                <div class="checkbox-wrapper">
                                    <input 
                                        type="checkbox" 
                                        id="is_published" 
                                        name="is_published" 
                                        value="1"
                                        <?php echo isset($_POST['is_published']) ? 'checked' : ''; ?>
                                    >
                                    <label for="is_published" class="checkbox-label">
                                        Publish Course
                                        <span class="checkbox-label-hint">Make this course visible to students</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>
                                Create Course
                            </button>
                            <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>

                    <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources" class="back-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Back to Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
