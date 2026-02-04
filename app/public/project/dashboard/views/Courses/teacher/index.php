<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Courses</title>
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

        .courses-section-header {
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            margin: 0 auto 2.5rem auto; 
            padding: 0 2rem;
            max-width: 1400px;
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
        
        .section-title { 
            font-size: 2.25rem; 
            font-weight: 800; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }
        
        .create-course-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            border: none; 
            padding: 0.675rem 1.75rem; 
            border-radius: 10px;
            font-size: 0.95rem; 
            font-weight: 700; 
            cursor: pointer; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .create-course-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .create-course-btn:hover::before {
            left: 100%;
        }
        
        .create-course-btn:hover { 
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5); 
            transform: translateY(-3px); 
        }
        
        .create-course-btn:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 15px rgba(102, 126, 234, 0.4);
        }
        
        .create-course-btn svg { 
            width: 18px; 
            height: 18px;
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
        }

        .courses-container {
            padding: 0 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 2rem;
            margin-top: 1.5rem;
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

        .course-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            border-radius: 16px;
            padding: 1.75rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .course-card:hover {
            box-shadow: 0 15px 50px rgba(102, 126, 234, 0.25);
            transform: translateY(-8px);
            border-color: rgba(102, 126, 234, 0.3);
        }
        
        .course-card:hover::before {
            transform: scaleX(1);
        }

        .course-card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .course-code {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }

        .course-status {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-published {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(17, 153, 142, 0.3);
        }

        .status-draft {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(245, 87, 108, 0.3);
        }

        .course-title {
            font-size: 1.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 1rem 0 0.75rem 0;
            line-height: 1.3;
            letter-spacing: -0.3px;
        }

        .course-description {
            color: #4a5568;
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 1.25rem;
            display: -webk5rem;
            padding-top: 1.25rem;
            border-top: 2px solid rgba(102, 126, 234, 0.1);
        }

        .course-meta {
            font-size: 0.85rem;
            color: #718096;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
        
        .course-meta::before {
            content: '📅';
            font-size: 1rem;
        }

        .course-actions {
            display: flex;
            gap: 0.625rem;
        }

        .action-btn {
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .btn-edit {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #2d3748;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #c3cfe2 0%, #f5f7fa 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transform5rem 2rem;
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            border-radius: 20px;
            margin-top: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(102, 126, 234, 0.1);
            animation: fadeInUp 0.6s ease-out;
        }

        .empty-state svg {
            width: 100px;
            height: 100px;
            color: #cbd5e0;
            margin-bottom: 2rem;
            opacity: 0.7;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.05));
        }

        .empty-state h3 {
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }

        .empty-state p {
            font-size: 1.05rem;
            color: #718096;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .alert {
            padding: 1.25rem 1.75rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: slideInDown 0.4s ease-out;
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
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721C24;
            border-left: 4px solid #dc3545
            color: #333;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background: #D4EDDA;
            color: #155724;
            border: 1px solid #C3E6CB;
        }

        .alert-error {
            background: #F8D7DA;
            color: #721C24;
            border: 1px solid #F5C6CB;
        }

        @media (max-width: 1024px) {
            .main-content { 
                margin-left: 200px; 
                padding: 1.5rem; 
            }
            .courses-section-header { 
                padding: 0 1.5rem; 
            }
            .courses-container {
                padding: 0 1.5rem;
            }
            .section-title { 
                font-size: 1.5rem; 
            }
            .courses-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .main-content { 
                margin-left: 180px; 
                padding: 1rem; 
            }
            .courses-section-header { 
                flex-direction: column; 
                align-items: flex-start; 
                gap: 1rem; 
                padding: 0 1rem; 
            }
            .courses-container {
                padding: 0 1rem;
            }
            .section-title { 
                font-size: 1.3rem; 
            }
            .create-course-btn { 
                width: 100%; 
                justify-content: center; 
            }
            .courses-grid {
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
                <div class="courses-section-header">
                    <h1 class="section-title">My Courses</h1>
                    <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/create" class="create-course-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Create Course
                    </a>
                </div>

                <div class="courses-container">
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

                    <?php if (empty($courses)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                            <h3>No courses yet</h3>
                            <p>Get started by creating your first course</p>
                            <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/create" class="create-course-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Create Your First Course
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="courses-grid">
                            <?php foreach ($courses as $course): ?>
                                <div class="course-card" onclick="window.location.href='<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/show?id=<?php echo $course['id']; ?>'">
                                    <div class="course-card-header">
                                        <span class="course-code"><?php echo htmlspecialchars($course['course_code']); ?></span>
                                        <span class="course-status <?php echo $course['is_published'] ? 'status-published' : 'status-draft'; ?>">
                                            <?php echo $course['is_published'] ? 'Published' : 'Draft'; ?>
                                        </span>
                                    </div>
                                    
                                    <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                                    
                                    <?php if (!empty($course['description'])): ?>
                                        <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>
                                    <?php else: ?>
                                        <p class="course-description" style="color: #999; font-style: italic;">No description provided</p>
                                    <?php endif; ?>
                                    
                                    <div class="course-footer">
                                        <span class="course-meta">
                                            Created <?php echo date('M j, Y', strtotime($course['created_at'])); ?>
                                        </span>
                                        <div class="course-actions" onclick="event.stopPropagation();">
                                            <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/edit?id=<?php echo $course['id']; ?>" class="action-btn btn-edit">Edit</a>
                                            <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/cources/show?id=<?php echo $course['id']; ?>" class="action-btn btn-view">View</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
