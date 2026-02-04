<?php
session_start();

// Fetch student data from database
$host = 'db';
$username = 'root';
$password = 'rootpass';
$database = 'Univercity_DB';

$conn = @new mysqli($host, $username, $password, $database);

$enrolledCourses = [];
$upcomingAssignments = [];
$studentGrades = [];
$studentId = $_SESSION['user']['id'] ?? null;
$studentName = $_SESSION['user']['username'] ?? 'Student';

if ($conn && !$conn->connect_error && $studentId) {
    // Fetch enrolled courses
    $sql = "SELECT c.*, u.username as teacher_name FROM courses c 
            JOIN users u ON c.teacher_id = u.id 
            JOIN course_enrollments ce ON c.id = ce.course_id 
            WHERE ce.student_id = ? ORDER BY ce.enrolled_at DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $enrolledCourses = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch upcoming assignments
    $sql = "SELECT a.*, c.title as course_title, c.course_code, u.username as teacher_name FROM assignments a 
            JOIN courses c ON a.course_id = c.id 
            JOIN users u ON c.teacher_id = u.id 
            JOIN course_enrollments ce ON c.id = ce.course_id 
            WHERE ce.student_id = ? AND a.due_at > NOW() 
            ORDER BY a.due_at ASC LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $upcomingAssignments = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch final grades
    $sql = "SELECT * FROM final_grades WHERE student_id = ? ORDER BY created_at DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $studentGrades = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .dashboard-main {
            flex: 1;
            margin-left: 240px;
            margin-top: 70px;
            padding: 2.5rem;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 16px;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .welcome-title {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
        }

        .welcome-subtitle {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
            text-align: center;
        }

        .stat-card.courses { border-left-color: #667eea; }
        .stat-card.assignments { border-left-color: #f5576c; }
        .stat-card.grades { border-left-color: #38b2ac; }

        .stat-label {
            color: #718096;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
        }

        .section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #2d3748;
            margin: 0 0 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .course-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            padding: 1.25rem;
            border-radius: 10px;
            border: 1px solid rgba(102, 126, 234, 0.15);
            transition: all 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .course-code {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .course-title {
            font-weight: 700;
            color: #2d3748;
            margin: 0.5rem 0;
            font-size: 1.1rem;
        }

        .course-teacher {
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.6rem 1.25rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .assignment-item {
            padding: 1.25rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
        }

        .assignment-item:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .assignment-info {
            flex: 1;
        }

        .assignment-title {
            font-weight: 700;
            color: #2d3748;
            margin: 0 0 0.25rem 0;
        }

        .assignment-meta {
            color: #718096;
            font-size: 0.9rem;
            margin: 0.25rem 0;
        }

        .assignment-status {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-upcoming {
            background: #fef3c7;
            color: #92400e;
        }

        .status-overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        .grade-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
        }

        .grade-item {
            padding: 1.25rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            border-radius: 8px;
            text-align: center;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .grade-course {
            color: #718096;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .grade-letter {
            font-size: 2rem;
            font-weight: 800;
            color: #667eea;
            margin: 0.5rem 0;
        }

        .grade-percentage {
            color: #718096;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #718096;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        @media (max-width: 1024px) {
            .dashboard-main { margin-left: 200px; }
        }

        @media (max-width: 768px) {
            .dashboard-main { margin-left: 0; padding: 1.5rem; }
            .welcome-title { font-size: 1.5rem; }
            .dashboard-grid { grid-template-columns: 1fr; }
            .course-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <?php include BASE_PATH . '/../components/sidebar-stud.php'; ?>
    <?php include BASE_PATH . '/../components/top-bar.php'; ?>
    
    <div class="dashboard-wrapper">
        <div class="dashboard-main">
            <div class="dashboard-container">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h1 class="welcome-title">Welcome back, <?php echo htmlspecialchars($studentName); ?>! 👋</h1>
                    <p class="welcome-subtitle">Here's your learning dashboard. Keep up the great work!</p>
                </div>

                <!-- Quick Stats -->
                <div class="dashboard-grid">
                    <div class="stat-card courses">
                        <div class="stat-label">Enrolled Courses</div>
                        <div class="stat-value"><?php echo count($enrolledCourses); ?></div>
                    </div>
                    <div class="stat-card assignments">
                        <div class="stat-label">Upcoming Assignments</div>
                        <div class="stat-value"><?php echo count($upcomingAssignments); ?></div>
                    </div>
                    <div class="stat-card grades">
                        <div class="stat-label">Grades Received</div>
                        <div class="stat-value"><?php echo count($studentGrades); ?></div>
                    </div>
                </div>

                <!-- Enrolled Courses Section -->
                <div class="section">
                    <h2 class="section-title">📚 My Courses</h2>
                    <?php if (!empty($enrolledCourses)): ?>
                        <div class="course-grid">
                            <?php foreach ($enrolledCourses as $course): ?>
                                <div class="course-card">
                                    <div class="course-code"><?php echo htmlspecialchars($course['course_code']); ?></div>
                                    <div class="course-title"><?php echo htmlspecialchars($course['title']); ?></div>
                                    <div class="course-teacher">👨‍🏫 <?php echo htmlspecialchars($course['teacher_name']); ?></div>
                                    <a href="<?php echo BASE_URL; ?>/project/student/dashboard/courses/views?id=<?php echo $course['id']; ?>" class="btn">View Course</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <p>You're not enrolled in any courses yet.</p>
                            <a href="<?php echo BASE_URL; ?>/project/student/dashboard/courses" class="btn" style="margin-top: 1rem;">Explore Courses</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Upcoming Assignments Section -->
                <div class="section">
                    <h2 class="section-title">📋 Upcoming Assignments</h2>
                    <?php if (!empty($upcomingAssignments)): ?>
                        <?php foreach ($upcomingAssignments as $assignment): ?>
                            <?php
                                $dueDate = new DateTime($assignment['due_at']);
                                $now = new DateTime();
                                $isOverdue = $dueDate < $now;
                                $daysLeft = ceil(($dueDate->getTimestamp() - $now->getTimestamp()) / 86400);
                                $statusClass = $isOverdue ? 'status-overdue' : 'status-upcoming';
                                $statusText = $isOverdue ? '⏰ Overdue' : ($daysLeft <= 1 ? '⏰ Due Today' : "📅 Due in $daysLeft days");
                            ?>
                            <div class="assignment-item">
                                <div class="assignment-info">
                                    <div class="assignment-title"><?php echo htmlspecialchars($assignment['title']); ?></div>
                                    <div class="assignment-meta"><strong><?php echo htmlspecialchars($assignment['course_title']); ?></strong> (<?php echo htmlspecialchars($assignment['course_code']); ?>)</div>
                                    <div class="assignment-meta">👨‍🏫 <?php echo htmlspecialchars($assignment['teacher_name']); ?></div>
                                </div>
                                <span class="assignment-status <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon">✅</div>
                            <p>No upcoming assignments. You're all caught up!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Grades Section -->
                <div class="section">
                    <h2 class="section-title">⭐ Your Grades</h2>
                    <?php if (!empty($studentGrades)): ?>
                        <div class="grade-grid">
                            <?php foreach ($studentGrades as $grade): ?>
                                <div class="grade-item">
                                    <div class="grade-course"><?php echo htmlspecialchars($grade['course']); ?></div>
                                    <div class="grade-letter"><?php echo htmlspecialchars($grade['letter_grade']); ?></div>
                                    <div class="grade-percentage"><?php echo htmlspecialchars($grade['percentage']); ?>%</div>
                                    <?php if ($grade['feedback']): ?>
                                        <div style="font-size: 0.8rem; color: #667eea; margin-top: 0.5rem; font-style: italic;">Feedback available</div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon">📊</div>
                            <p>No grades received yet. Check back soon!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
