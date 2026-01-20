<?php
// Sample grades data - replace with database queries
$grades = [
    ["module_name" => "Web Development", "grade" => "A", "percentage" => "95"],
    ["module_name" => "Database Systems", "grade" => "B+", "percentage" => "87"],
    ["module_name" => "Computer Networks", "grade" => "A-", "percentage" => "90"],
    ["module_name" => "Software Engineering", "grade" => "A", "percentage" => "92"],
];

$assignment_grades = [
    ["assignment_name" => "Project 1: Blog System", "grade" => "A", "percentage" => "92"],
    ["assignment_name" => "Quiz: Database Queries", "grade" => "B+", "percentage" => "85"],
    ["assignment_name" => "Assignment: Network Design", "grade" => "A", "percentage" => "94"],
    ["assignment_name" => "Presentation: Software Design", "grade" => "A-", "percentage" => "88"],
];

// Calculate overall GPA (simple average)
$all_grades = array_merge($grades, $assignment_grades);
$total_percentage = 0;
foreach ($all_grades as $grade) {
    $total_percentage += (int)$grade['percentage'];
}
$overall_gpa = round($total_percentage / count($all_grades), 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Grades - Student Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            color: #1a1a1a;
        }

        .main-container {
            margin-left: 240px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }

        .grades-header {
            background: linear-gradient(135deg, #5B5FFF 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 18px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(91, 95, 255, 0.2);
        }

        .grades-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .grades-header-text h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .grades-header-text p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .gpa-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 1.5rem 2rem;
            border-radius: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            min-width: 150px;
            backdrop-filter: blur(10px);
        }

        .gpa-card-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .gpa-card-label {
            font-size: 0.95rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .grades-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .grades-section-box {
            background: white;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .grades-section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .grades-section-title::before {
            content: '';
            width: 4px;
            height: 28px;
            background: linear-gradient(135deg, #5B5FFF, #764ba2);
            border-radius: 2px;
        }

        .grade-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem;
            background: #f9fafb;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .grade-item:hover {
            background: #f0f0f0;
            border-color: #e0e0e0;
            transform: translateX(5px);
        }

        .grade-item:last-child {
            margin-bottom: 0;
        }

        .grade-info {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .grade-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .grade-detail {
            font-size: 0.9rem;
            color: #666;
        }

        .grade-badge {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .grade-mark {
            font-size: 1.4rem;
            font-weight: 700;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            min-width: 60px;
            text-align: center;
            color: white;
        }

        .grade-a {
            background: #7c3aed;
        }

        .grade-b {
            background: #ec4899;
        }

        .grade-c {
            background: #3b82f6;
        }

        .grade-d {
            background: #f59e0b;
        }

        .grade-percentage {
            font-size: 0.95rem;
            color: #666;
            font-weight: 500;
            min-width: 50px;
            text-align: right;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
            border-top: 4px solid #5B5FFF;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #5B5FFF;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.95rem;
            color: #666;
            font-weight: 500;
        }

        .no-grades {
            text-align: center;
            padding: 3rem 2rem;
            color: #999;
            font-size: 1.1rem;
        }

        @media (max-width: 1200px) {
            .grades-header-content {
                flex-direction: column;
                text-align: left;
            }

            .grades-content {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .main-container {
                margin-left: 180px;
                padding: 1.5rem;
            }

            .grades-header {
                padding: 1.5rem;
            }

            .grades-header-text h1 {
                font-size: 1.5rem;
            }

            .grades-section-box {
                padding: 1.5rem;
            }

            .grades-section-title {
                font-size: 1.3rem;
            }

            .grade-item {
                padding: 1rem;
                flex-wrap: wrap;
            }

            .grade-mark {
                font-size: 1.2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include BASE_PATH . '/../components/sidebar-stud.php'; ?>
    <?php include BASE_PATH . '/../components/top-bar.php'; ?>
        
    <div class="main-container">
        <div class="grades-header">
            <div class="grades-header-content">
                <div class="grades-header-text">
                    <h1>My Grades</h1>
                    <p>View your module and assignment grades</p>
                </div>
                <div class="gpa-card">
                    <div class="gpa-card-value"><?php echo $overall_gpa; ?></div>
                    <div class="gpa-card-label">Overall GPA</div>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo count($grades); ?></div>
                <div class="stat-label">Modules</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo count($assignment_grades); ?></div>
                <div class="stat-label">Assignments</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php 
                    $a_count = 0;
                    foreach (array_merge($grades, $assignment_grades) as $grade) {
                        if (strpos($grade['grade'], 'A') === 0) $a_count++;
                    }
                    echo $a_count;
                ?></div>
                <div class="stat-label">A Grades</div>
            </div>
        </div>

        <div class="grades-content">
            <div class="grades-section-box">
                <h2 class="grades-section-title">Module Grades</h2>
                <?php if (count($grades) > 0): ?>
                    <?php foreach ($grades as $grade): ?>
                        <div class="grade-item">
                            <div class="grade-info">
                                <div class="grade-name"><?php echo htmlspecialchars($grade['module_name']); ?></div>
                            </div>
                            <div class="grade-badge">
                                <div class="grade-mark grade-<?php echo strtolower(str_replace(['+', '-'], '', $grade['grade'])); ?>">
                                    <?php echo htmlspecialchars($grade['grade']); ?>
                                </div>
                                <div class="grade-percentage"><?php echo htmlspecialchars($grade['percentage']); ?>%</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-grades">No module grades available yet.</div>
                <?php endif; ?>
            </div>

            <div class="grades-section-box">
                <h2 class="grades-section-title">Assignment Grades</h2>
                <?php if (count($assignment_grades) > 0): ?>
                    <?php foreach ($assignment_grades as $grade): ?>
                        <div class="grade-item">
                            <div class="grade-info">
                                <div class="grade-name"><?php echo htmlspecialchars($grade['assignment_name']); ?></div>
                            </div>
                            <div class="grade-badge">
                                <div class="grade-mark grade-<?php echo strtolower(str_replace(['+', '-'], '', $grade['grade'])); ?>">
                                    <?php echo htmlspecialchars($grade['grade']); ?>
                                </div>
                                <div class="grade-percentage"><?php echo htmlspecialchars($grade['percentage']); ?>%</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-grades">No assignment grades available yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
