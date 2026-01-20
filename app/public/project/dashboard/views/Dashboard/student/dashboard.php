<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/navbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/sidebar-stud.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/top-bar.css">
</head>
<body>
    <?php include BASE_PATH . '/../components/sidebar-stud.php'; ?>
    <?php include BASE_PATH . '/../components/top-bar.php'; ?>
    
    <main class="dashboard-main">
        <!-- Courses Panel -->
        <?php include BASE_PATH . '/../components/cource_panel.php'; ?>

        <!-- Assignments Panel -->
        <?php include BASE_PATH . '/../components/assignments.php'; ?>

        <!-- Grades Panel -->
        <?php include BASE_PATH . '/../components/grades-comp.php'; ?>

        <!-- Students Panel (Classmates) -->
        <?php include BASE_PATH . '/../components/students-comp.php'; ?>

        <!-- Teachers Panel -->
        <?php include BASE_PATH . '/../components/teachers-comp.php'; ?>
    </main>

    <style>
        .dashboard-main {
            margin-left: 290px;
            padding: 100px 20px 20px 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        /* Panel Alignment - Clear floats and align right */
        .course-panel-box,
        .assignments-panel-box,
        .grades-panel-box,
        .students-panel-box,
        .teachers-panel-box {
            margin: 20px 15px;
            max-width: 950px;
            width: calc(100% - 30px);
        }

        /* Clear floats after each panel */
        .course-panel-box::after,
        .assignments-panel-box::after,
        .grades-panel-box::after,
        .students-panel-box::after,
        .teachers-panel-box::after {
            content: "";
            display: table;
            clear: both;
        }

        @media (max-width: 1024px) {
            .dashboard-main {
                margin-left: 200px;
                padding: 90px 15px 15px 15px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-main {
                margin-left: 180px;
                padding: 80px 10px 10px 10px;
            }
        }
    </style>
</body>
</html>
