<?php
$assignments = $assignments ?? [];
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);

// Normalize optional numeric fields for display
$assignments = array_map(function ($item) {
    $item['submissions'] = isset($item['submissions']) ? (int) $item['submissions'] : 0;
    $item['graded'] = isset($item['graded']) ? (int) $item['graded'] : 0;
    return $item;
}, $assignments);

$totalSubmissions = array_sum(array_column($assignments, 'submissions'));
$totalGraded = array_sum(array_column($assignments, 'graded'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Assignments</title>
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
            padding: 4rem;
            background: transparent;
        }

        .page-header {
            margin-bottom: 1.5rem;
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

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-content h1 {
            font-size: 1.75rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0 0 0.25rem 0;
            letter-spacing: -0.5px;
        }

        .header-content p {
            color: #718096;
            font-size: 0.9rem;
            margin: 0;
            font-weight: 500;
        }

        .create-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            border: none; 
            padding: 0.875rem 2rem; 
            border-radius: 12px;
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
        
        .create-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .create-btn:hover::before {
            left: 100%;
        }
        
        .create-btn:hover { 
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5); 
            transform: translateY(-3px); 
        }
        
        .create-btn svg { 
            width: 18px; 
            height: 18px;
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(102, 126, 234, 0.1);
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }

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

        .stat-value {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }

        .stat-label {
            color: #718096;
            font-size: 0.8rem;
            font-weight: 600;
            margin: 0.25rem 0 0 0;
            letter-spacing: 0.3px;
        }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            animation: fadeInUp 0.6s ease-out 0.4s both;
        }

        .tab-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #718096;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .tab-btn:hover:not(.active) {
            border-color: #667eea;
            color: #667eea;
        }

        .assignments-container {
            max-width: 100%;
        }

        .assignments-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            animation: fadeInUp 0.6s ease-out 0.5s both;
        }

        .assignment-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(102, 126, 234, 0.1);
            display: grid;
            grid-template-columns: 80px 1fr 200px;
            align-items: stretch;
        }

        .assignment-card:nth-child(1) .assignment-color {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .assignment-card:nth-child(2) .assignment-color {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .assignment-card:nth-child(3) .assignment-color {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .assignment-card:nth-child(4) .assignment-color {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .assignment-card:nth-child(5) .assignment-color {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .assignment-card:nth-child(6) .assignment-color {
            background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        }

        .assignment-color {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .assignment-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .assignment-header {
            margin-bottom: 0.75rem;
        }

        .assignment-title {
            font-size: 1rem;
            font-weight: 800;
            color: #2d3748;
            margin: 0 0 0.25rem 0;
        }

        .assignment-course {
            font-size: 0.75rem;
            color: #718096;
            font-weight: 600;
            margin: 0;
        }

        .assignment-description {
            color: #4a5568;
            font-size: 0.85rem;
            line-height: 1.5;
            margin: 0;
        }

        .assignment-stats {
            display: flex;
            gap: 1rem;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #eee;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.75rem;
            color: #718096;
            font-weight: 600;
        }

        .stat-item strong {
            color: #2d3748;
            font-weight: 800;
        }

        .assignment-actions {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.5rem;
            border-left: 1px solid #eee;
        }

        .action-link {
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-align: center;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
        }

        .action-view {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .action-view:hover {
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transform: translateY(-2px);
        }

        .action-edit {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
            color: #2d3748;
        }

        .action-edit:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .card-meta {
            font-size: 0.75rem;
            color: #a0aec0;
            margin-top: 0.5rem;
        }

        .assignment-card:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-4px);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%);
            border-radius: 14px;
            margin-top: 1.5rem;
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
        }

        .empty-state h3 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            font-size: 1.05rem;
            color: #718096;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        @media (max-width: 1024px) {
            .main-content { 
                margin-left: 200px; 
                padding: 2rem; 
            }
            .assignment-card {
                grid-template-columns: 1fr;
            }
            .assignment-actions {
                flex-direction: row;
                border-left: none;
                border-top: 1px solid #eee;
                padding-top: 1rem;
                gap: 0.5rem;
            }
            .action-link {
                flex: 1;
            }
        }

        @media (max-width: 768px) {
            .main-content { 
                margin-left: 180px; 
                padding: 1rem; 
            }
            .header-content h1 {
                font-size: 1.75rem;
            }
            .assignment-card {
                grid-template-columns: 1fr;
            }
            .create-btn {
                width: 100%;
                justify-content: center;
            }
            .assignment-color {
                display: none;
            }
            .assignment-actions {
                flex-direction: row;
                border: none;
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
                <div class="page-header">
                    <div class="header-top">
                        <div class="header-content">
                            <h1>Assignments</h1>
                            <p>Create and manage assignments for your courses</p>
                        </div>
                        <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments/create" class="create-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Create Assignment
                        </a>
                    </div>

                    <!-- Stats Cards -->
                    <div class="stats-container">
                        <div class="stat-card">
                            <p class="stat-value"><?php echo count($assignments); ?></p>
                            <p class="stat-label">Total Assignments</p>
                        </div>
                        <div class="stat-card">
                            <p class="stat-value"><?php echo $totalSubmissions; ?></p>
                            <p class="stat-label">Total Submissions</p>
                        </div>
                        <div class="stat-card">
                            <p class="stat-value"><?php echo $totalGraded; ?></p>
                            <p class="stat-label">Graded</p>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="filter-tabs">
                        <button class="tab-btn active" onclick="filterAssignments('all')">All Assignments</button>
                        <button class="tab-btn" onclick="filterAssignments('pending')">Pending Grading</button>
                        <button class="tab-btn" onclick="filterAssignments('due-soon')">Due Soon</button>
                    </div>
                </div>

                <div class="assignments-container">
                    <?php if ($success): ?>
                        <div class="alert alert-success" style="margin-bottom: 1rem;">
                            <strong><?php echo htmlspecialchars($success); ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($assignments)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="14" rx="2" ry="2"></rect>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                <line x1="7" y1="15" x2="7" y2="15"></line>
                                <line x1="11" y1="15" x2="11" y2="15"></line>
                                <line x1="15" y1="15" x2="15" y2="15"></line>
                            </svg>
                            <h3>No assignments yet</h3>
                            <p>Create your first assignment to see it listed here.</p>
                            <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments/create" class="create-btn" style="margin-top: 1rem;">Create Assignment</a>
                        </div>
                    <?php else: ?>
                    <div class="assignments-list">
                        <?php foreach ($assignments as $assignment): 
                            $dueAt = $assignment['due_at'] ?? null;
                            $dueTs = $dueAt ? strtotime($dueAt) : null;
                            $is_due_soon = $dueTs ? ($dueTs - time() < 7 * 24 * 60 * 60) : false;
                            $submissions = $assignment['submissions'] ?? 0;
                            $graded = $assignment['graded'] ?? 0;
                            $has_pending = ($submissions - $graded) > 0;
                            $courseLabel = $assignment['course_title'] ?? ($assignment['course_code'] ?? '');
                        ?>
                            <div class="assignment-card" data-status="<?php echo $has_pending ? 'pending' : 'graded'; ?>" data-due="<?php echo $is_due_soon ? 'soon' : 'later'; ?>">
                                <div class="assignment-color">
                                    📋
                                </div>
                                
                                <div class="assignment-body">
                                    <div class="assignment-header">
                                        <h3 class="assignment-title"><?php echo htmlspecialchars($assignment['title']); ?></h3>
                                        <p class="assignment-course"><?php echo htmlspecialchars($courseLabel); ?></p>
                                    </div>
                                    
                                    <p class="assignment-description"><?php echo htmlspecialchars($assignment['description']); ?></p>
                                    
                                    <div class="assignment-stats">
                                        <div class="stat-item">
                                            <span>📝</span>
                                            <span>Submissions: <strong><?php echo $submissions; ?></strong></span>
                                        </div>
                                        <div class="stat-item">
                                            <span>✓</span>
                                            <span>Graded: <strong><?php echo $graded; ?></strong></span>
                                        </div>
                                        <div class="stat-item">
                                            <span>⏱️</span>
                                            <span>Due: <strong><?php echo $dueTs ? date('M j, Y', $dueTs) : '—'; ?></strong></span>
                                        </div>
                                        <div class="stat-item">
                                            <span>📊</span>
                                            <span>Points: <strong><?php echo $assignment['max_points']; ?></strong></span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-meta">
                                        Created <?php echo !empty($assignment['created_at']) ? date('M j, Y', strtotime($assignment['created_at'])) : '—'; ?>
                                    </div>
                                </div>
                                
                                <div class="assignment-actions">
                                    <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments/view?id=<?php echo $assignment['id']; ?>" class="action-link action-view">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        View
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments/edit?id=<?php echo $assignment['id']; ?>" class="action-link action-edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterAssignments(status) {
            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Filter assignments
            const cards = document.querySelectorAll('.assignment-card');
            cards.forEach(card => {
                if (status === 'all') {
                    card.style.display = '';
                } else if (status === 'pending') {
                    card.style.display = card.getAttribute('data-status') === 'pending' ? '' : 'none';
                } else if (status === 'due-soon') {
                    card.style.display = card.getAttribute('data-due') === 'soon' ? '' : 'none';
                }
            });
        }
    </script>
</body>
</html>
