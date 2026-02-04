<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course - <?php echo htmlspecialchars($course['title']); ?></title>
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
        }

        .page-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
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

        .form-section {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
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

        .section-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3748;
            margin: 0 0 2rem 0;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.2);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-group {
            margin-bottom: 1.75rem;
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
        input[type="url"],
        select,
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
        input[type="url"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        input[type="text"]::placeholder,
        input[type="url"]::placeholder,
        textarea::placeholder {
            color: #a0aec0;
        }

        textarea {
            resize: vertical;
            min-height: 150px;
            line-height: 1.6;
        }

        .input-hint {
            font-size: 0.85rem;
            color: #718096;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .content-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            border-radius: 12px;
            padding: 1.5rem;
            border: 2px solid rgba(102, 126, 234, 0.1);
            position: relative;
        }

        .content-type-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }

        .type-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .type-video {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .type-link {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .type-file {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .content-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0 0 0.5rem 0;
        }

        .content-delete {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #f8d7da;
            color: #721c24;
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .content-delete:hover {
            background: #f5c6cb;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            min-width: 150px;
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

        .btn-secondary {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
            color: #2d3748;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #cbd5e0 0%, #e2e8f0 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        .btn-small {
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            min-width: auto;
        }

        .btn-add-content {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 233, 123, 0.4);
        }

        .btn-add-content:hover {
            box-shadow: 0 6px 25px rgba(67, 233, 123, 0.5);
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

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721C24;
            border-left-color: #dc3545;
        }

        .toggle-form {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .toggle-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #718096;
        }

        .toggle-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .toggle-btn:hover:not(.active) {
            border-color: #667eea;
            color: #667eea;
        }

        .content-form {
            display: none;
        }

        .content-form.active {
            display: block;
            animation: fadeInUp 0.6s ease-out;
        }

        @media (max-width: 1024px) {
            .main-content { 
                margin-left: 200px; 
                padding: 2rem; 
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content { 
                margin-left: 180px; 
                padding: 1rem; 
            }
            .form-section {
                padding: 1.5rem;
            }
            .section-title {
                font-size: 1.25rem;
            }
            .btn-group {
                flex-direction: column;
            }
            .btn {
                width: 100%;
            }
            .content-grid {
                grid-template-columns: 1fr;
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
                <div class="page-container">
                    <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources" class="back-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Back to Courses
                    </a>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php 
                            echo htmlspecialchars($_SESSION['success']); 
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error">
                            <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Course Details Form -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <span>📝</span> Course Details
                        </h2>

                        <form method="POST" action="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/update?id=<?php echo $course['id']; ?>">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="course_code">
                                        Course Code
                                        <span class="label-required">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="course_code" 
                                        name="course_code" 
                                        placeholder="e.g., CS101" 
                                        required
                                        maxlength="20"
                                        value="<?php echo htmlspecialchars($course['course_code']); ?>"
                                    >
                                    <div class="input-hint">Unique identifier for your course</div>
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
                                        value="<?php echo htmlspecialchars($course['title']); ?>"
                                    >
                                    <div class="input-hint">A clear and descriptive name</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Course Description</label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    placeholder="Describe your course, learning objectives, topics covered, etc."
                                ><?php echo htmlspecialchars($course['description'] ?? ''); ?></textarea>
                                <div class="input-hint">Help students understand what they'll learn in this course</div>
                            </div>

                            <div class="form-group">
                                <label for="is_published">
                                    <input 
                                        type="checkbox" 
                                        id="is_published" 
                                        name="is_published" 
                                        value="1"
                                        <?php echo $course['is_published'] ? 'checked' : ''; ?>
                                        style="margin-right: 0.5rem; width: auto;"
                                    >
                                    Publish Course (make visible to students)
                                </label>
                            </div>

                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </svg>
                                    Save Changes
                                </button>
                                <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Add Course Content -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <span>📚</span> Course Content
                        </h2>

                        <!-- Content Type Toggle -->
                        <div class="toggle-form">
                            <button class="toggle-btn active" onclick="switchContentForm('text')">Text</button>
                            <button class="toggle-btn" onclick="switchContentForm('video')">Video</button>
                            <button class="toggle-btn" onclick="switchContentForm('link')">Link</button>
                            <button class="toggle-btn" onclick="switchContentForm('file')">File</button>
                        </div>

                        <!-- Text Content Form -->
                        <form class="content-form active" id="text-form" method="POST" action="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/add-content?id=<?php echo $course['id']; ?>">
                            <input type="hidden" name="content_type" value="TEXT">
                            <div class="form-group">
                                <label for="text-title">Content Title</label>
                                <input type="text" id="text-title" name="title" placeholder="e.g., Welcome to the Course" required>
                            </div>
                            <div class="form-group">
                                <label for="text-body">Content</label>
                                <textarea id="text-body" name="body" placeholder="Write your course content here..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-add-content btn-small">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Add Text Content
                            </button>
                        </form>

                        <!-- Video Content Form -->
                        <form class="content-form" id="video-form" method="POST" action="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/add-content?id=<?php echo $course['id']; ?>">
                            <input type="hidden" name="content_type" value="VIDEO">
                            <div class="form-group">
                                <label for="video-title">Video Title</label>
                                <input type="text" id="video-title" name="title" placeholder="e.g., Introduction Video" required>
                            </div>
                            <div class="form-group">
                                <label for="video-url">Video URL</label>
                                <input type="url" id="video-url" name="url" placeholder="https://youtube.com/..." required>
                                <div class="input-hint">Paste the full URL of your video</div>
                            </div>
                            <button type="submit" class="btn btn-add-content btn-small">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Add Video
                            </button>
                        </form>

                        <!-- Link Content Form -->
                        <form class="content-form" id="link-form" method="POST" action="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/add-content?id=<?php echo $course['id']; ?>">
                            <input type="hidden" name="content_type" value="LINK">
                            <div class="form-group">
                                <label for="link-title">Link Title</label>
                                <input type="text" id="link-title" name="title" placeholder="e.g., Reference Material" required>
                            </div>
                            <div class="form-group">
                                <label for="link-url">Link URL</label>
                                <input type="url" id="link-url" name="url" placeholder="https://example.com" required>
                            </div>
                            <button type="submit" class="btn btn-add-content btn-small">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Add Link
                            </button>
                        </form>

                        <!-- File Content Form -->
                        <form class="content-form" id="file-form" method="POST" action="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/add-content?id=<?php echo $course['id']; ?>" enctype="multipart/form-data">
                            <input type="hidden" name="content_type" value="FILE">
                            <div class="form-group">
                                <label for="file-title">File Name</label>
                                <input type="text" id="file-title" name="title" placeholder="e.g., Course Syllabus" required>
                            </div>
                            <div class="form-group">
                                <label for="file-upload">Upload File</label>
                                <input type="file" id="file-upload" name="file" required>
                                <div class="input-hint">Max file size: 10MB</div>
                            </div>
                            <button type="submit" class="btn btn-add-content btn-small">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Upload File
                            </button>
                        </form>

                        <!-- Existing Content -->
                        <?php if (!empty($contents)): ?>
                            <div style="margin-top: 3rem;">
                                <h3 style="color: #2d3748; font-weight: 700; margin-bottom: 1.5rem;">Course Content Items (<?php echo count($contents); ?>)</h3>
                                <div class="content-grid">
                                    <?php foreach ($contents as $content): ?>
                                        <div class="content-card">
                                            <button class="content-delete" onclick="deleteContent(<?php echo $content['id']; ?>)">Delete</button>
                                            <div class="content-type-badge type-<?php echo strtolower($content['content_type']); ?>">
                                                <?php echo htmlspecialchars($content['content_type']); ?>
                                            </div>
                                            <h4 class="content-title"><?php echo htmlspecialchars($content['title']); ?></h4>
                                            <?php if ($content['content_type'] === 'TEXT'): ?>
                                                <p style="color: #718096; font-size: 0.9rem; line-height: 1.6; margin: 0;">
                                                    <?php echo htmlspecialchars(substr($content['body'], 0, 150)) . (strlen($content['body']) > 150 ? '...' : ''); ?>
                                                </p>
                                            <?php elseif ($content['content_type'] === 'VIDEO'): ?>
                                                <p style="color: #718096; font-size: 0.9rem; margin: 0;">
                                                    <strong>URL:</strong> <?php echo htmlspecialchars(substr($content['url'], 0, 40)) . '...'; ?>
                                                </p>
                                            <?php elseif ($content['content_type'] === 'LINK'): ?>
                                                <p style="color: #718096; font-size: 0.9rem; margin: 0;">
                                                    <a href="<?php echo htmlspecialchars($content['url']); ?>" target="_blank" style="color: #667eea; text-decoration: none;">
                                                        Visit →
                                                    </a>
                                                </p>
                                            <?php elseif ($content['content_type'] === 'FILE'): ?>
                                                <p style="color: #718096; font-size: 0.9rem; margin: 0;">📎 File uploaded</p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div style="text-align: center; padding: 2rem; background: rgba(102, 126, 234, 0.05); border-radius: 12px; margin-top: 1.5rem;">
                                <p style="color: #718096; margin: 0;">No content added yet. Start by adding course materials above.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchContentForm(type) {
            // Hide all forms
            document.querySelectorAll('.content-form').forEach(form => {
                form.classList.remove('active');
            });
            // Deactivate all buttons
            document.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            // Show selected form
            document.getElementById(type + '-form').classList.add('active');
            // Activate button
            event.target.classList.add('active');
        }

        function deleteContent(contentId) {
            if (confirm('Are you sure you want to delete this content? This action cannot be undone.')) {
                window.location.href = '<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/delete-content?id=' + contentId + '&course_id=<?php echo $course['id']; ?>';
            }
        }
    </script>
</body>
</html>
