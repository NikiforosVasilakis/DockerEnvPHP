<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Student Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/navbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/top-bar.css">
</head>
<body>
    <?php include BASE_PATH . '/../components/sidebar-stud.php'; ?>
    <?php include BASE_PATH . '/../components/top-bar.php'; ?>
    
    <main class="dashboard-main">
        <div class="courses-container">
            <!-- Header Section -->
            <div class="courses-header">
                <div class="header-content">
                    <h1 class="courses-title">My Courses</h1>
                    <p class="courses-subtitle">Track your enrolled courses and progress</p>
                </div>
                <div class="header-stats">
                    <div class="stat-card">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Total Courses</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">3</span>
                        <span class="stat-label">In Progress</span>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="courses-filters">
                <button class="filter-btn active" data-filter="all">All Courses</button>
                <button class="filter-btn" data-filter="active">In Progress</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
            </div>

            <!-- Courses Grid -->
            <div class="courses-grid">
                <?php
                $courses = [
                    [
                        'id' => 1,
                        'title' => 'Web Development Fundamentals',
                        'instructor' => 'Dr. Smith',
                        'progress' => 75,
                        'students' => 32,
                        'description' => 'Learn HTML, CSS, and JavaScript basics',
                        'status' => 'active',
                        'color' => '#667eea'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Database Systems',
                        'instructor' => 'Prof. Johnson',
                        'progress' => 60,
                        'students' => 28,
                        'description' => 'Master SQL and database design',
                        'status' => 'active',
                        'color' => '#764ba2'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Software Engineering',
                        'instructor' => 'Dr. Williams',
                        'progress' => 45,
                        'students' => 24,
                        'description' => 'Design patterns and best practices',
                        'status' => 'active',
                        'color' => '#f093fb'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Computer Networks',
                        'instructor' => 'Prof. Davis',
                        'progress' => 90,
                        'students' => 30,
                        'description' => 'TCP/IP protocols and networking',
                        'status' => 'completed',
                        'color' => '#4facfe'
                    ],
                    [
                        'id' => 5,
                        'title' => 'Cybersecurity Basics',
                        'instructor' => 'Dr. Brown',
                        'progress' => 85,
                        'students' => 22,
                        'description' => 'Security fundamentals and threats',
                        'status' => 'completed',
                        'color' => '#00f2fe'
                    ]
                ];
                ?>
                
                <?php foreach ($courses as $course): ?>
                    <div class="course-card" data-status="<?php echo $course['status']; ?>">
                        <!-- Course Header with Color -->
                        <div class="course-card-header" style="background: linear-gradient(135deg, <?php echo $course['color']; ?> 0%, rgba(0,0,0,0.1) 100%); background-color: <?php echo $course['color']; ?>;">
                            <div class="course-badge">
                                <?php echo ucfirst($course['status']); ?>
                            </div>
                            <div class="course-students">
                                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span><?php echo $course['students']; ?></span>
                            </div>
                        </div>

                        <!-- Course Body -->
                        <div class="course-card-body">
                            <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                            <p class="course-instructor">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <?php echo htmlspecialchars($course['instructor']); ?>
                            </p>
                            <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>

                            <!-- Progress Bar -->
                            <div class="progress-section">
                                <div class="progress-header">
                                    <span class="progress-label">Progress</span>
                                    <span class="progress-percent"><?php echo $course['progress']; ?>%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $course['progress']; ?>%; background-color: <?php echo $course['color']; ?>;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Footer -->
                        <div class="course-card-footer">
                            <a href="<?= BASE_URL ?>/project/student/dashboard/courses/views?id=<?php echo $course['id']; ?>" class="course-link">
                                View Course
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
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

        .courses-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Section */
        .courses-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            gap: 30px;
        }

        .header-content {
            flex: 1;
        }

        .courses-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: #1a1a1a;
            margin: 0 0 8px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .courses-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin: 0;
        }

        .header-stats {
            display: flex;
            gap: 16px;
        }

        .stat-card {
            background: white;
            padding: 20px 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
            min-width: 140px;
        }

        .stat-number {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            color: #5B5FFF;
            margin-bottom: 4px;
        }

        .stat-label {
            display: block;
            font-size: 0.85rem;
            color: #999;
            font-weight: 600;
        }

        /* Filter Section */
        .courses-filters {
            display: flex;
            gap: 12px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 24px;
            background: white;
            color: #666;
            border: 2px solid #e5e7eb;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            border-color: #5B5FFF;
            color: #5B5FFF;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        /* Courses Grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        .course-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .course-card-header {
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 120px;
        }

        .course-card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .course-badge {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
            text-transform: uppercase;
        }

        .course-students {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.25);
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }

        .course-students svg {
            width: 18px;
            height: 18px;
        }

        /* Course Body */
        .course-card-body {
            padding: 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .course-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 12px 0;
            line-height: 1.4;
        }

        .course-instructor {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #666;
            margin: 0 0 12px 0;
            font-weight: 600;
        }

        .course-instructor svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .course-description {
            font-size: 0.9rem;
            color: #888;
            margin: 0 0 20px 0;
            line-height: 1.5;
            flex: 1;
        }

        /* Progress Section */
        .progress-section {
            margin-top: auto;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .progress-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #666;
        }

        .progress-percent {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            transition: width 0.3s ease;
            border-radius: 10px;
        }

        /* Course Footer */
        .course-card-footer {
            padding: 16px 24px;
            border-top: 1px solid #f0f0f0;
        }

        .course-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #5B5FFF;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .course-link:hover {
            gap: 12px;
            color: #764ba2;
        }

        .course-link svg {
            width: 20px;
            height: 20px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-main {
                margin-left: 200px;
                padding: 90px 15px 15px 15px;
            }

            .courses-header {
                flex-direction: column;
                gap: 20px;
            }

            .header-stats {
                width: 100%;
                justify-content: space-between;
            }

            .courses-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }

            .courses-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-main {
                margin-left: 180px;
                padding: 80px 10px 10px 10px;
            }

            .courses-title {
                font-size: 1.8rem;
            }

            .courses-header {
                flex-direction: column;
            }

            .header-stats {
                width: 100%;
            }

            .stat-card {
                flex: 1;
            }

            .courses-grid {
                grid-template-columns: 1fr;
            }

            .courses-filters {
                overflow-x: auto;
            }
        }
    </style>

    <script>
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                document.querySelectorAll('.course-card').forEach(card => {
                    if (filter === 'all' || card.dataset.status === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>