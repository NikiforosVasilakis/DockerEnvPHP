<?php
// Middleware handles authentication & role check
// $_SESSION['user'] is populated by login system

include_once __DIR__ . '/../../../../auth/connect.php';

$teacher_id = (int)$_SESSION['user']['id'];

// Fetch assignments for courses owned by this teacher
$assignments = [];
$sql = "SELECT a.id, a.title, a.description, a.due_at, a.attachment_path, a.max_points, a.allow_late, c.title AS course_title
        FROM assignments a
        JOIN courses c ON a.course_id = c.id
        WHERE c.teacher_id = ?
        ORDER BY a.due_at DESC, a.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $assignments[] = [
        'title' => $row['title'],
        'description' => $row['description'] ?? '',
        'teacher' => 'You',
        'due_date' => $row['due_at'] ? date('Y-m-d', strtotime($row['due_at'])) : 'N/A',
        'submitted' => false,
        'course_title' => $row['course_title']
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
    <title>Teacher - Assignments</title>
    <link rel="stylesheet" href="../../../css/styles.css">
    <style>
        body { margin: 0; padding: 0; background: #f5f5f5; }
        .main-wrapper { display: flex; min-height: 100vh; background: #f5f5f5; }
        .main-content { margin-left: 240px; margin-top: 70px; flex: 1; padding: 2rem; background: #f5f5f5; }

        .assignments-section-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem; padding: 0 2rem;
        }
        .section-title { font-size: 1.8rem; font-weight: 700; color: #1a1a1a; }
        .add-assignment-btn {
            background: #5B5FFF; color: white; border: none; padding: 0.875rem 2rem; border-radius: 10px;
            font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(91, 95, 255, 0.3); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .add-assignment-btn:hover { background: #4a4ecc; box-shadow: 0 4px 12px rgba(91, 95, 255, 0.4); transform: translateY(-2px); }
        .add-assignment-btn svg { width: 20px; height: 20px; }

        @media (max-width: 1024px) {
            .main-content { margin-left: 200px; padding: 1.5rem; }
            .assignments-section-header { padding: 0 1.5rem; }
            .section-title { font-size: 1.5rem; }
        }
        @media (max-width: 768px) {
            .main-content { margin-left: 180px; padding: 1rem; }
            .assignments-section-header { flex-direction: column; align-items: flex-start; gap: 1rem; padding: 0 1rem; }
            .section-title { font-size: 1.3rem; }
            .add-assignment-btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>
        <div style="flex: 1;">
            <?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>
            <div class="main-content">
                <div class="assignments-section-header">
                    <h1 class="section-title">Assignments</h1>
                    <a href="<?php echo BASE_URL; ?>/project/teacher/dashboard/assignments/create" class="add-assignment-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Assignment
                    </a>
                </div>

                <?php include_once __DIR__ . '/../../../../components/assignments.php'; ?>
            </div>
        </div>
    </div>
</body>
<script>
// You can add small UI interactions here later if needed
</script>
</html>
