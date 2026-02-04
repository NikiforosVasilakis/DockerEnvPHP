<?php

class AssignmentsController
{
    private $assignmentModel;
    private $courseModel;

    public function __construct()
    {
        $this->assignmentModel = new Assignment();
        $this->courseModel = new Course();
    }

    //teacher
    public function teacherIndex(): void
    {
        if (empty($_SESSION['user']) || ($_SESSION['user']['role_id'] ?? null) != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $teacher_id = $_SESSION['user']['id'];
        $assignments = $this->assignmentModel->getAssignmentsByTeacher($teacher_id);

        require BASE_PATH . '/views/assignments/teacher/index.php';
    }

    public function create(): void
    {
        if (empty($_SESSION['user']) || ($_SESSION['user']['role_id'] ?? null) != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $teacher_id = $_SESSION['user']['id'];
        $courses = $this->courseModel->getCoursesByTeacher($teacher_id);

        require BASE_PATH . '/views/assignments/teacher/create.php';
    }

    /**
     * Store a newly created assignment
     * POST /project/teacher/dashboard/assignments
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project/teacher/dashboard/assignments/create');
            exit;
        }

        if (empty($_SESSION['user']) || ($_SESSION['user']['role_id'] ?? null) != 2) {
            header('Location: /project/auth/login.php');
            exit;
        }

        $teacher_id = $_SESSION['user']['id'];

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $course_id = $_POST['course_id'] ?? '';
        $max_points = $_POST['max_points'] ?? '';
        $due_at = $_POST['due_at'] ?? '';
        $allow_late = isset($_POST['allow_late']) ? 1 : 0;
        $due_at_formatted = $due_at ? str_replace('T', ' ', $due_at) : null;

        $errors = [];

        if (empty($title)) {
            $errors[] = 'Assignment title is required.';
        } elseif (strlen($title) < 3 || strlen($title) > 200) {
            $errors[] = 'Title must be between 3 and 200 characters.';
        }

        if (empty($description) || strlen($description) < 10) {
            $errors[] = 'Description is required (minimum 10 characters).';
        }

        if (empty($course_id)) {
            $errors[] = 'Please select a course.';
        } else {
            $course = $this->courseModel->getCourseById($course_id);
            if (!$course || $course['teacher_id'] != $teacher_id) {
                $errors[] = 'Invalid course selection.';
            }
        }

        if (empty($max_points) || !is_numeric($max_points) || $max_points <= 0) {
            $errors[] = 'Max points must be a positive number.';
        }

        if (empty($due_at)) {
            $errors[] = 'Due date is required.';
        }

        $old = [
            'title' => $title,
            'description' => $description,
            'course_id' => $course_id,
            'max_points' => $max_points,
            'due_at' => $due_at,
            'allow_late' => $allow_late
        ];

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $old;
            header('Location: /project/teacher/dashboard/assignments/create');
            exit;
        }

        $assignment_id = $this->assignmentModel->create(
            $teacher_id,
            (int) $course_id,
            $title,
            $description,
            (float) $max_points,
            $due_at_formatted,
            $allow_late,
            null
        );

        if ($assignment_id) {
            $_SESSION['success'] = 'Assignment created successfully!';
            unset($_SESSION['old']);
            header('Location: /project/teacher/dashboard/assignments');
            exit;
        }

        $_SESSION['errors'] = ['Failed to create assignment. Please try again.'];
        $_SESSION['old'] = $old;
        header('Location: /project/teacher/dashboard/assignments/create');
        exit;
    }

    //student
    public function studentIndex(): void
    {
        require BASE_PATH . '/views/assignments/student/index.php';
    }
    public function submit(): void
    {
        require BASE_PATH . '/views/assignments/student/submit.php';
    }
}