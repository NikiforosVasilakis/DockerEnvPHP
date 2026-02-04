<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> - Teacher Course View</title>
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
            padding: 2.5rem;
            background: transparent;
        }

        .course-header {
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

        .course-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .course-code-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: inline-block;
        }

        .course-status-badge {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-published {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
        }

        .status-draft {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
        }

        .course-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 1.5rem 0 1rem 0;
            line-height: 1.2;
        }

        .course-meta {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid rgba(102, 126, 234, 0.1);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #718096;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .meta-item strong {
            color: #2d3748;
        }

        .course-description {
            background: linear-gradient(145deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            padding: 2rem;
            border-radius: 12px;
            border-left: 4px solid #667eea;
            margin-bottom: 2.5rem;
        }

        .description-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .description-content {
            color: #4a5568;
            font-size: 1rem;
            line-height: 1.8;
            white-space: pre-wrap;
        }

        .course-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.875rem 1.75rem;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
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

        .btn-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(245, 87, 108, 0.3);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
            transform: translateY(-3px);
        }

        .course-content {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(102, 126, 234, 0.1);
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
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
            margin: 0 0 1.5rem 0;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.2);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .empty-section {
            text-align: center;
            padding: 3rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 12px;
            border: 2px dashed rgba(102, 126, 234, 0.2);
            margin-top: 1rem;
        }

        .empty-section p {
            color: #718096;
            font-size: 1rem;
            margin: 0;
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

        @media (max-width: 1024px) {
            .main-content { 
                margin-left: 200px; 
                padding: 2rem; 
            }
            .course-header {
                padding: 2rem;
            }
            .course-title {
                font-size: 1.8rem;
            }
            .course-header-top {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .main-content { 
                margin-left: 180px; 
                padding: 1rem; 
            }
            .course-header {
                padding: 1.5rem;
            }
            .course-title {
                font-size: 1.5rem;
            }
            .course-actions {
                flex-direction: column;
            }
            .btn {
                width: 100%;
            }
            .course-meta {
                flex-direction: column;
                gap: 1rem;
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
                <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources" class="back-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Courses
                </a>

                <div class="course-header">
                    <div class="course-header-top">
                        <div>
                            <span class="course-code-badge"><?php echo htmlspecialchars($course['course_code']); ?></span>
                        </div>
                        <span class="course-status-badge <?php echo $course['is_published'] ? 'status-published' : 'status-draft'; ?>">
                            <?php echo $course['is_published'] ? '✓ Published' : '◯ Draft'; ?>
                        </span>
                    </div>

                    <h1 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h1>

                    <div class="course-meta">
                        <div class="meta-item">
                            <span>📅</span>
                            <span>Created: <strong><?php echo date('M j, Y', strtotime($course['created_at'])); ?></strong></span>
                        </div>
                        <div class="meta-item">
                            <span>👤</span>
                            <span>Instructor: <strong><?php echo htmlspecialchars($course['teacher_name']); ?></strong></span>
                        </div>
                        <?php if ($course['updated_at']): ?>
                            <div class="meta-item">
                                <span>🔄</span>
                                <span>Updated: <strong><?php echo date('M j, Y', strtotime($course['updated_at'])); ?></strong></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($course['description'])): ?>
                        <div class="course-description">
                            <div class="description-title">
                                <span>📖</span> Course Description
                            </div>
                            <div class="description-content"><?php echo htmlspecialchars($course['description']); ?></div>
                        </div>
                    <?php endif; ?>

                    <div class="course-actions">
                        <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/edit?id=<?php echo $course['id']; ?>" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                            Edit Course
                        </a>
                        <button onclick="if(confirm('Are you sure you want to delete this course? This action cannot be undone.')) { window.location.href = '<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/delete?id=<?php echo $course['id']; ?>'; }" class="btn btn-danger">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                            Delete Course
                        </button>
                    </div>
                </div>

                <div class="course-content">
                    <h2 class="section-title">
                        <span>📚</span> Course Content
                    </h2>
                    <div style="margin-bottom: 1.25rem;">
                        <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/edit?id=<?php echo $course['id']; ?>" class="btn btn-primary" style="padding: 0.65rem 1.25rem;">Add / Edit Content</a>
                    </div>

                    <?php if (!empty($contents)): ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem;">
                            <?php foreach ($contents as $content): ?>
                                <div class="content-card">
                                    <div class="content-type-badge type-<?php echo strtolower($content['content_type']); ?>">
                                        <?php echo htmlspecialchars($content['content_type']); ?>
                                    </div>
                                    <h4 class="content-title"><?php echo htmlspecialchars($content['title']); ?></h4>
                                    <?php if ($content['content_type'] === 'TEXT'): ?>
                                        <p style="color: #718096; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                                            <?php echo htmlspecialchars(substr($content['body'] ?? '', 0, 180)) . ((isset($content['body']) && strlen($content['body']) > 180) ? '...' : ''); ?>
                                        </p>
                                    <?php elseif ($content['content_type'] === 'VIDEO' || $content['content_type'] === 'LINK'): ?>
                                        <a href="<?php echo htmlspecialchars($content['url']); ?>" target="_blank" style="color: #667eea; font-weight: 700; text-decoration: none;">Open link →</a>
                                    <?php elseif ($content['content_type'] === 'FILE'): ?>
                                        <p style="color: #718096; font-size: 0.95rem; margin: 0;">📎 File uploaded</p>
                                    <?php endif; ?>
                                    <div style="margin-top: 0.75rem; color: #a0aec0; font-size: 0.85rem;">
                                        Visible: <?php echo !empty($content['is_visible']) ? 'Yes' : 'Hidden'; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-section">
                            <p>No course content added yet. Start by editing this course to add lessons and materials.</p>
                        </div>
                    <?php endif; ?>

                    <h2 class="section-title" style="margin-top: 2.5rem;">
                        <span>👥</span> Enrolled Students
                    </h2>
                    <?php if (!empty($students)): ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem;">
                            <?php foreach ($students as $stud): ?>
                                <div class="content-card">
                                    <div class="content-title"><?php echo htmlspecialchars($stud['username']); ?></div>
                                    <div style="color: #718096; font-size: 0.95rem;">Email: <?php echo htmlspecialchars($stud['email']); ?></div>
                                    <div style="color: #a0aec0; font-size: 0.85rem; margin-top: 0.5rem;">
                                        Enrolled: <?php echo date('M j, Y', strtotime($stud['enrolled_at'])); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-section">
                            <p>No students enrolled yet. Once students enroll, they will appear here.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
