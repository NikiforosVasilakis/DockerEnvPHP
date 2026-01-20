<?php
session_start();

// Database connection
include_once __DIR__ . '/../../../../auth/connect.php';

// Teacher ID from session (adjust based on your session structure)
$teacher_id = $_SESSION['user_id'] ?? 1; // Default to 1 for testing

// Fetch courses created by this teacher from database
$courses = [];
$sql = "SELECT id, course_code, title, description FROM courses WHERE teacher_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $courses[] = [
        'title' => $row['title'],
        'subtitle' => $row['description'] ?? 'No description',
        'progress' => 0,
        'code' => $row['course_code']
    ];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Manage Courses</title>
    <link rel="stylesheet" href="../../../css/styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            background: #f5f5f5;
        }

        .main-content {
            margin-left: 240px;
            margin-top: 70px;
            flex: 1;
            padding: 2rem;
            background: #f5f5f5;
        }

        .course-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 0 2rem;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .add-course-btn {
            background: #5B5FFF;
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(91, 95, 255, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-course-btn:hover {
            background: #4a4ecc;
            box-shadow: 0 4px 12px rgba(91, 95, 255, 0.4);
            transform: translateY(-2px);
        }

        .add-course-btn svg {
            width: 20px;
            height: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 200px;
                padding: 1.5rem;
            }

            .course-section-header {
                padding: 0 1.5rem;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 180px;
                padding: 1rem;
            }

            .course-section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 0 1rem;
            }

            .section-title {
                font-size: 1.3rem;
            }

            .add-course-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        <?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>

        <!-- Main Content -->
        <div style="flex: 1;">
            <!-- Top Bar -->
            <?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>

            <!-- Page Content -->
            <div class="main-content">
                <div class="course-section-header">
                    <h1 class="section-title">My Courses</h1>
                    <a href="<?= BASE_URL ?>/project/teacher/dashboard/cources/create">create</a>
                    <a href="create.php" class="add-course-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Course
                    </a>
                </div>

                <!-- Course Panel Component -->
                <?php include_once __DIR__ . '/../../../../components/cource_panel.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>
