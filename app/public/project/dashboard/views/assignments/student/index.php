<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments - Student Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/navbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/top-bar.css">
</head>
<body>
    <?php include BASE_PATH . '/../components/sidebar-stud.php'; ?>
    <?php include BASE_PATH . '/../components/top-bar.php'; ?>
    
    <main class="dashboard-main">
        <div class="assignments-container">
            <div class="assignments-header">
                <h2 class="assignments-title">My Assignments</h2>
                <p class="assignments-subtitle">View and submit your assignments here</p>
            </div>

            <div class="assignments-list">
                <?php
                $assignments = [
                    [
                        'id' => 1,
                        'title' => 'Assignment 1: PHP Form',
                        'description' => 'Create a PHP form with validation',
                        'course' => 'Web Development',
                        'teacher' => 'Dr. Smith',
                        'due_date' => '2026-01-20',
                        'submitted' => true,
                        'submission_date' => '2026-01-18'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Assignment 2: Database Queries',
                        'description' => 'Write complex SQL queries',
                        'course' => 'Database Systems',
                        'teacher' => 'Prof. Johnson',
                        'due_date' => '2026-01-25',
                        'submitted' => false,
                        'submission_date' => null
                    ],
                    [
                        'id' => 3,
                        'title' => 'Assignment 3: Web Application',
                        'description' => 'Build a complete web application',
                        'course' => 'Software Engineering',
                        'teacher' => 'Dr. Williams',
                        'due_date' => '2026-02-01',
                        'submitted' => false,
                        'submission_date' => null
                    ]
                ];
                ?>
                
                <?php foreach ($assignments as $assignment): ?>
                    <div class="assignment-card">
                        <div class="assignment-card-header">
                            <div class="assignment-info">
                                <h3 class="assignment-card-title"><?php echo htmlspecialchars($assignment['title']); ?></h3>
                                <p class="assignment-card-course"><?php echo htmlspecialchars($assignment['course']); ?> • <?php echo htmlspecialchars($assignment['teacher']); ?></p>
                            </div>
                            <div class="assignment-status <?php echo $assignment['submitted'] ? 'submitted' : 'pending'; ?>">
                                <?php echo $assignment['submitted'] ? '✓ Submitted' : '○ Pending'; ?>
                            </div>
                        </div>

                        <div class="assignment-card-body">
                            <p class="assignment-description"><?php echo htmlspecialchars($assignment['description']); ?></p>
                            
                            <div class="assignment-dates">
                                <div class="date-item">
                                    <span class="date-label">Due Date:</span>
                                    <span class="date-value"><?php echo date('M d, Y', strtotime($assignment['due_date'])); ?></span>
                                </div>
                                <?php if ($assignment['submitted']): ?>
                                    <div class="date-item">
                                        <span class="date-label">Submitted:</span>
                                        <span class="date-value"><?php echo date('M d, Y', strtotime($assignment['submission_date'])); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="assignment-card-footer">
                            <a href="<?= BASE_URL ?>/project/student/dashboard/assignments/submit?id=<?php echo $assignment['id']; ?>" class="submit-btn">
                                <?php echo $assignment['submitted'] ? 'Resubmit' : 'Submit'; ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <style>
        .dashboard-main {
            margin-left: 290px;
            padding: 100px 20px 20px 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .assignments-container {
            max-width: 950px;
            margin: 0 auto;
        }

        .assignments-header {
            margin-bottom: 40px;
        }

        .assignments-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 10px 0;
        }

        .assignments-subtitle {
            font-size: 1rem;
            color: #666;
            margin: 0;
        }

        .assignments-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .assignment-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 5px solid #5B5FFF;
        }

        .assignment-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .assignment-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
            gap: 20px;
        }

        .assignment-info {
            flex: 1;
        }

        .assignment-card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 8px 0;
        }

        .assignment-card-course {
            font-size: 0.95rem;
            color: #666;
            margin: 0;
            font-weight: 500;
        }

        .assignment-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .assignment-status.submitted {
            background: #d4edda;
            color: #155724;
        }

        .assignment-status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .assignment-card-body {
            margin-bottom: 20px;
        }

        .assignment-description {
            font-size: 1rem;
            color: #555;
            margin: 0 0 16px 0;
            line-height: 1.5;
        }

        .assignment-dates {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .date-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-label {
            font-weight: 600;
            color: #666;
            font-size: 0.9rem;
        }

        .date-value {
            color: #1a1a1a;
            font-size: 0.9rem;
        }

        .assignment-card-footer {
            display: flex;
            justify-content: flex-end;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 1024px) {
            .dashboard-main {
                margin-left: 200px;
                padding: 90px 15px 15px 15px;
            }

            .assignments-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-main {
                margin-left: 180px;
                padding: 80px 10px 10px 10px;
            }

            .assignments-title {
                font-size: 1.6rem;
            }

            .assignment-card-header {
                flex-direction: column;
            }

            .assignment-status {
                align-self: flex-start;
            }
        }
    </style>
</body>
</html>