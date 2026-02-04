<?php

class GradeController{

    private $userModel;
    private $gradeModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->gradeModel = new Grade();
    }

    public function teacherIndex(): void
    {
        if (empty($_SESSION['user']) || ($_SESSION['user']['role_id'] ?? null) != 2) {
            header('Location: /project/auth/login.php');
            exit;
        }

        $students = $this->userModel->getStudents();
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);

        require BASE_PATH . '/views/grades/teacher/index.php';

    }

    public function addForm(): void
    {
        if (empty($_SESSION['user']) || ($_SESSION['user']['role_id'] ?? null) != 2) {
            header('Location: /project/auth/login.php');
            exit;
        }

        $studentId = isset($_GET['student_id']) ? (int) $_GET['student_id'] : null;
        $student = null;

        if ($studentId) {
            $student = $this->userModel->findById($studentId);
        }

        if (!$student) {
            $_SESSION['errors'] = ['Student not found or not specified.'];
            header('Location: /project/teacher/dashboard/grades');
            exit;
        }

        require BASE_PATH . '/views/grades/teacher/add_grade.php';

    }

    //student
    public function studentIndex(): void
    {
        require BASE_PATH . '/views/grades/student/index.php';

    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project/teacher/dashboard/grades');
            exit;
        }

        if (empty($_SESSION['user']) || ($_SESSION['user']['role_id'] ?? null) != 2) {
            header('Location: /project/auth/login.php');
            exit;
        }

        $teacherId = $_SESSION['user']['id'];

        $studentId = isset($_POST['student_id']) ? (int) $_POST['student_id'] : 0;
        $course = trim($_POST['course'] ?? '');
        $letterGrade = trim($_POST['grade'] ?? '');
        $percentage = $_POST['percentage'] ?? '';
        $feedback = trim($_POST['comments'] ?? '') ?: null;

        $allowedGrades = ['A+','A','A-','B+','B','B-','C+','C','C-','D','F'];
        $errors = [];

        $student = $studentId ? $this->userModel->findById($studentId) : null;
        if (!$student || strtolower($student['role_name']) !== 'student') {
            $errors[] = 'Invalid student selection.';
        }

        if ($course === '' || strlen($course) < 2) {
            $errors[] = 'Course/Module is required.';
        }

        if ($letterGrade === '' || !in_array($letterGrade, $allowedGrades, true)) {
            $errors[] = 'Please choose a valid letter grade.';
        }

        if ($percentage === '' || !is_numeric($percentage) || $percentage < 0 || $percentage > 100) {
            $errors[] = 'Percentage must be between 0 and 100.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'course' => $course,
                'grade' => $letterGrade,
                'percentage' => $percentage,
                'comments' => $feedback,
                'student_id' => $studentId,
            ];
            header('Location: /project/teacher/dashboard/grades/add?student_id=' . $studentId);
            exit;
        }

        $saved = $this->gradeModel->createFinalGrade(
            $studentId,
            $course,
            $letterGrade,
            (float) $percentage,
            $feedback,
            $teacherId
        );

        if ($saved) {
            unset($_SESSION['old']);
            $_SESSION['success'] = 'Grade saved successfully.';
            header('Location: /project/teacher/dashboard/grades');
            exit;
        }

        $_SESSION['errors'] = ['Failed to save grade. Please try again.'];
        $_SESSION['old'] = [
            'course' => $course,
            'grade' => $letterGrade,
            'percentage' => $percentage,
            'comments' => $feedback,
            'student_id' => $studentId,
        ];
        header('Location: /project/teacher/dashboard/grades/add?student_id=' . $studentId);
        exit;
    }

}