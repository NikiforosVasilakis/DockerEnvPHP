<?php
session_start();
// Fetch grades from DB
$grades = [];
$assignment_grades = [];

// Resolve student_id from session (multiple possible keys)
$student_id = null;
if (isset($_SESSION['user_id'])) {
    $student_id = (int)$_SESSION['user_id'];
} elseif (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
    $student_id = (int)$_SESSION['user']['id'];
} elseif (isset($_SESSION['id'])) {
    $student_id = (int)$_SESSION['id'];
}

$host = 'db';
$username = 'root';
$password = 'rootpass';
$database = 'Univercity_DB';

$conn = @new mysqli($host, $username, $password, $database);
if (!$conn->connect_error) {
    // If we have the user email in session but no ID, fetch ID by email
    if (empty($student_id) && !empty($_SESSION['email'])) {
        if ($stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1')) {
            $stmt->bind_param('s', $_SESSION['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $student_id = (int)$row['id'];
            }
            $stmt->close();
        }
    }

    if (!empty($student_id)) {
        // Fetch final/module grades with feedback
        $sql_final = "SELECT 
                        course AS module_name,
                        letter_grade AS grade,
                        percentage,
                        feedback,
                        created_at
                    FROM final_grades
                    WHERE student_id = ?
                    ORDER BY created_at DESC";

        if ($stmt = $conn->prepare($sql_final)) {
            $stmt->bind_param('i', $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $grades[] = $row;
            }
            $stmt->close();
        }

        // Fetch assignment grades with feedback
        $sql_assignments = "SELECT 
                                a.title AS assignment_name,
                                g.points_awarded,
                                a.max_points,
                                g.feedback,
                                g.graded_at
                            FROM grades g
                            INNER JOIN assignment_submissions sub ON g.submission_id = sub.id
                            INNER JOIN assignments a ON sub.assignment_id = a.id
                            WHERE sub.student_id = ?
                            ORDER BY g.graded_at DESC";

        if ($stmt = $conn->prepare($sql_assignments)) {
            $stmt->bind_param('i', $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $percentage = round(($row['points_awarded'] / $row['max_points']) * 100, 1);

                // Determine letter grade
                if ($percentage >= 93) $letter = 'A';
                elseif ($percentage >= 90) $letter = 'A-';
                elseif ($percentage >= 87) $letter = 'B+';
                elseif ($percentage >= 83) $letter = 'B';
                elseif ($percentage >= 80) $letter = 'B-';
                elseif ($percentage >= 77) $letter = 'C+';
                elseif ($percentage >= 73) $letter = 'C';
                elseif ($percentage >= 70) $letter = 'C-';
                elseif ($percentage >= 67) $letter = 'D+';
                elseif ($percentage >= 60) $letter = 'D';
                else $letter = 'F';

                $assignment_grades[] = [
                    'assignment_name' => $row['assignment_name'],
                    'grade' => $letter,
                    'percentage' => $percentage,
                    'feedback' => $row['feedback'],
                    'graded_at' => $row['graded_at']
                ];
            }
            $stmt->close();
        }
    }

    $conn->close();
}

// Calculate overall GPA (simple average)
$all_grades = array_merge($grades, $assignment_grades);
$overall_gpa = 0;
if (count($all_grades) > 0) {
    $total_percentage = 0;
    foreach ($all_grades as $grade) {
        $total_percentage += (float)$grade['percentage'];
    }
    $overall_gpa = round($total_percentage / count($all_grades), 1);
}
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
            flex-direction: column;
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .grade-item:last-child {
            margin-bottom: 0;
        }

        .grade-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .grade-info {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            flex: 1;
        }

        .grade-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .grade-date {
            font-size: 0.85rem;
            color: #999;
            font-weight: 500;
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

        .grade-f {
            background: #dc2626;
        }

        .grade-percentage {
            font-size: 0.95rem;
            color: #666;
            font-weight: 500;
            min-width: 50px;
            text-align: right;
        }

        .grade-feedback {
            padding: 0.75rem;
            background: #fff;
            border-left: 3px solid #667eea;
            border-radius: 8px;
            margin-top: 0.75rem;
        }

        .feedback-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .feedback-text {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.5;
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
    <?php include __DIR__ . '/../../../../components/sidebar-stud.php'; ?>
    <?php include __DIR__ . '/../../../../components/top-bar.php'; ?>
        
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
                            <div class="grade-header-row">
                                <div class="grade-info">
                                    <div class="grade-name"><?php echo htmlspecialchars($grade['module_name']); ?></div>
                                    <?php if (!empty($grade['created_at'])): ?>
                                        <div class="grade-date">Graded: <?php echo date('M d, Y', strtotime($grade['created_at'])); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="grade-badge">
                                    <div class="grade-mark grade-<?php echo strtolower(str_replace(['+', '-'], '', $grade['grade'])); ?>">
                                        <?php echo htmlspecialchars($grade['grade']); ?>
                                    </div>
                                    <div class="grade-percentage"><?php echo htmlspecialchars($grade['percentage']); ?>%</div>
                                </div>
                            </div>
                            <?php if (!empty($grade['feedback'])): ?>
                                <div class="grade-feedback">
                                    <div class="feedback-label">Teacher Feedback</div>
                                    <div class="feedback-text"><?php echo htmlspecialchars($grade['feedback']); ?></div>
                                </div>
                            <?php endif; ?>
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
                            <div class="grade-header-row">
                                <div class="grade-info">
                                    <div class="grade-name"><?php echo htmlspecialchars($grade['assignment_name']); ?></div>
                                    <?php if (!empty($grade['graded_at'])): ?>
                                        <div class="grade-date">Graded: <?php echo date('M d, Y', strtotime($grade['graded_at'])); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="grade-badge">
                                    <div class="grade-mark grade-<?php echo strtolower(str_replace(['+', '-'], '', $grade['grade'])); ?>">
                                        <?php echo htmlspecialchars($grade['grade']); ?>
                                    </div>
                                    <div class="grade-percentage"><?php echo htmlspecialchars($grade['percentage']); ?>%</div>
                                </div>
                            </div>
                            <?php if (!empty($grade['feedback'])): ?>
                                <div class="grade-feedback">
                                    <div class="feedback-label">Teacher Feedback</div>
                                    <div class="feedback-text"><?php echo htmlspecialchars($grade['feedback']); ?></div>
                                </div>
                            <?php endif; ?>
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
