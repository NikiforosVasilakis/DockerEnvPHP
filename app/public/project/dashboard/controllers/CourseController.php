<?php

class CourseController
{
    private $courseModel;

    public function __construct()
    {
        $this->courseModel = new Course();
    }

    //teacher
    public function teacherIndex(): void
    {
        // Get all courses for this teacher
        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $teacher_id = $_SESSION['user']['id'];
        $courses = $this->courseModel->getCoursesByTeacher($teacher_id);
        require BASE_PATH . '/views/Courses/teacher/index.php';
    }

    public function create(): void
    {
        // Check authentication
        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        require BASE_PATH . '/views/Courses/teacher/create.php';
    }

    /**
     * Store a newly created course in the database
     * POST /project/teacher/dashboard/cources/courses
     */
    public function store(): void
    {
        // Check authentication
        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /project/auth/login.php');
            exit;
        }

        // Only handle POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project/teacher/dashboard/cources/create');
            exit;
        }

        $teacher_id = $_SESSION['user']['id'];
        
        // Validate input
        $course_code = trim($_POST['course_code'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $is_published = isset($_POST['is_published']) ? 1 : 0;

        $errors = [];

        // Validate course code
        if (empty($course_code)) {
            $errors[] = "Course code is required.";
        } elseif ($this->courseModel->courseCodeExists($course_code)) {
            $errors[] = "Course code already exists.";
        } elseif (strlen($course_code) > 20) {
            $errors[] = "Course code must be 20 characters or less.";
        }

        // Validate title
        if (empty($title)) {
            $errors[] = "Course title is required.";
        } elseif (strlen($title) > 200) {
            $errors[] = "Course title must be 200 characters or less.";
        }

        // If validation passes, create the course
        if (empty($errors)) {
            $course_id = $this->courseModel->create($teacher_id, $course_code, $title, $description, $is_published);
            
            if ($course_id) {
                $_SESSION['success'] = "Course created successfully!";
                header('Location: /project/teacher/dashboard/cources');
                exit;
            } else {
                $_SESSION['error'] = "Failed to create course. Please try again.";
                header('Location: /project/teacher/dashboard/cources/create');
                exit;
            }
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: /project/teacher/dashboard/cources/create');
            exit;
        }
    }

    public function edit(): void
    {
        $course_id = $_GET['id'] ?? null;
        
        if (!$course_id) {
            $_SESSION['error'] = "Course ID is required.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $teacher_id = $_SESSION['user']['id'];
        $course = $this->courseModel->getCourseById($course_id);

        // Check if course exists and belongs to this teacher
        if (!$course || $course['teacher_id'] != $teacher_id) {
            $_SESSION['error'] = "Course not found or access denied.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        // Get course content
        $contents = $this->courseModel->getCourseContent($course_id);

        require BASE_PATH . '/views/Courses/teacher/edit.php';
    }

    /**
     * Update course details
     * POST /project/teacher/dashboard/cources/update?id=X
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $course_id = $_GET['id'] ?? null;
        $teacher_id = $_SESSION['user']['id'];

        if (!$course_id) {
            $_SESSION['error'] = "Course ID is required.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        $course = $this->courseModel->getCourseById($course_id);
        
        // Check if course belongs to this teacher
        if (!$course || $course['teacher_id'] != $teacher_id) {
            $_SESSION['error'] = "You do not have access to this course.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        // Validate input
        $course_code = trim($_POST['course_code'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $is_published = isset($_POST['is_published']) ? 1 : 0;

        $errors = [];

        if (empty($course_code)) {
            $errors[] = "Course code is required.";
        } elseif ($this->courseModel->courseCodeExists($course_code, $course_id)) {
            $errors[] = "Course code already exists.";
        }

        if (empty($title)) {
            $errors[] = "Course title is required.";
        }

        if (empty($errors)) {
            if ($this->courseModel->update($course_id, $course_code, $title, $description, $is_published)) {
                $_SESSION['success'] = "Course updated successfully!";
                header('Location: /project/teacher/dashboard/cources');
                exit;
            } else {
                $_SESSION['error'] = "Failed to update course.";
                header('Location: /project/teacher/dashboard/cources/edit?id=' . $course_id);
                exit;
            }
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: /project/teacher/dashboard/cources/edit?id=' . $course_id);
            exit;
        }
    }

    /**
     * Add content to a course
     * POST /project/teacher/dashboard/cources/add-content?id=X
     */
    public function addContent(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $course_id = $_GET['id'] ?? null;
        $teacher_id = $_SESSION['user']['id'];

        if (!$course_id) {
            $_SESSION['error'] = "Course ID is required.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        $course = $this->courseModel->getCourseById($course_id);
        
        if (!$course || $course['teacher_id'] != $teacher_id) {
            $_SESSION['error'] = "You do not have access to this course.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        $content_type = strtoupper($_POST['content_type'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $body = trim($_POST['body'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $file_path = null;

        $errors = [];

        if (empty($title)) {
            $errors[] = "Content title is required.";
        }

        if (!in_array($content_type, ['TEXT', 'VIDEO', 'LINK', 'FILE'])) {
            $errors[] = "Invalid content type.";
        }

        if ($content_type === 'TEXT' && empty($body)) {
            $errors[] = "Content text is required.";
        }

        if (($content_type === 'VIDEO' || $content_type === 'LINK') && empty($url)) {
            $errors[] = "URL is required for this content type.";
        }

        if ($content_type === 'FILE' && empty($_FILES['file']['name'])) {
            $errors[] = "File upload is required.";
        }

        if (empty($errors)) {
            // Handle file upload if needed
            if ($content_type === 'FILE' && !empty($_FILES['file']['name'])) {
                // For now, just store the filename. In production, implement proper file upload
                $file_path = $_FILES['file']['name'];
            }

            $content_id = $this->courseModel->addContent($course_id, $content_type, $title, $body, $url, $file_path);
            
            if ($content_id) {
                $_SESSION['success'] = "Content added successfully!";
                header('Location: /project/teacher/dashboard/cources/edit?id=' . $course_id);
                exit;
            } else {
                $_SESSION['error'] = "Failed to add content.";
                header('Location: /project/teacher/dashboard/cources/edit?id=' . $course_id);
                exit;
            }
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: /project/teacher/dashboard/cources/edit?id=' . $course_id);
            exit;
        }
    }

    /**
     * Delete course content
     * GET /project/teacher/dashboard/cources/delete-content?id=X&course_id=Y
     */
    public function deleteContent(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $content_id = $_GET['id'] ?? null;
        $course_id = $_GET['course_id'] ?? null;
        $teacher_id = $_SESSION['user']['id'];

        if (!$content_id || !$course_id) {
            $_SESSION['error'] = "Invalid request.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        $course = $this->courseModel->getCourseById($course_id);
        
        if (!$course || $course['teacher_id'] != $teacher_id) {
            $_SESSION['error'] = "You do not have access to this course.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        if ($this->courseModel->deleteContent($content_id)) {
            $_SESSION['success'] = "Content deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete content.";
        }

        header('Location: /project/teacher/dashboard/cources/edit?id=' . $course_id);
        exit;
    }

    public function delete(): void
    {
        $course_id = $_GET['id'] ?? null;
        
        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $teacher_id = $_SESSION['user']['id'];

        if (!$course_id) {
            $_SESSION['error'] = "Course ID is required.";
            header('Location: /app/public/project/dashboard/dashboard.php?route=courses/teacher');
            exit;
        }

        $course = $this->courseModel->getCourseById($course_id);

        // Check if course exists and belongs to this teacher
        if (!$course || $course['teacher_id'] != $teacher_id) {
            $_SESSION['error'] = "Course not found or access denied.";
            header('Location: /app/public/project/dashboard/dashboard.php?route=courses/teacher');
            exit;
        }

        if ($this->courseModel->delete($course_id)) {
            $_SESSION['success'] = "Course deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete course.";
        }

        header('Location: /app/public/project/dashboard/dashboard.php?route=courses/teacher');
        exit;
    }

    //student
    public function studentIndex(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $student_id = $_SESSION['user']['id'];
        
        // Get enrolled courses
        $enrolledCourses = $this->courseModel->getEnrolledCourses($student_id);
        // Get available courses
        $availableCourses = $this->courseModel->getPublishedCourses();

        require BASE_PATH . '/views/Courses/student/index.php';
    }

    /**
     * Enroll the current student into a course
     * POST /project/student/dashboard/courses/join
     */
    public function enroll(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project/student/dashboard/courses');
            exit;
        }

        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $course_id = $_POST['course_id'] ?? null;
        $student_id = $_SESSION['user']['id'];

        if (!$course_id) {
            $_SESSION['error'] = "Course ID is required.";
            header('Location: /project/student/dashboard/courses');
            exit;
        }

        $course = $this->courseModel->getCourseById($course_id);

        if (!$course || !$course['is_published']) {
            $_SESSION['error'] = "Course not available.";
            header('Location: /project/student/dashboard/courses');
            exit;
        }

        $this->courseModel->enrollStudent((int)$course_id, $student_id);
        $_SESSION['success'] = "Joined course successfully.";
        header('Location: /project/student/dashboard/courses');
        exit;
    }

    /**
     * Show a specific course (for teacher)
     * GET /project/teacher/dashboard/cources/show?id=X
     */
    public function teacherShow(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $course_id = $_GET['id'] ?? null;
        $teacher_id = $_SESSION['user']['id'];
        
        if (!$course_id) {
            $_SESSION['error'] = "Course ID is required.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        $course = $this->courseModel->getCourseById($course_id);
        
        if (!$course) {
            $_SESSION['error'] = "Course not found.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        // Check if course belongs to this teacher
        if ($course['teacher_id'] != $teacher_id) {
            $_SESSION['error'] = "You do not have access to this course.";
            header('Location: /project/teacher/dashboard/cources');
            exit;
        }

        $contents = $this->courseModel->getCourseContent($course_id);
        $students = $this->courseModel->getEnrolledStudents($course_id);

        require BASE_PATH . '/views/Courses/teacher/show.php';
    }

    public function show(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
            header('Location: /app/public/project/auth/login.php');
            exit;
        }

        $course_id = $_GET['id'] ?? null;
        $student_id = $_SESSION['user']['id'];
        
        if (!$course_id) {
            $_SESSION['error'] = "Course ID is required.";
            header('Location: /project/dashboard/dashboard.php?route=courses/student');
            exit;
        }

        $course = $this->courseModel->getCourseById($course_id);
        
        if (!$course || !$course['is_published']) {
            $_SESSION['error'] = "Course not found or not published.";
            header('Location: /project/dashboard/dashboard.php?route=courses/student');
            exit;
        }

        $isEnrolled = $this->courseModel->isStudentEnrolled($course_id, $student_id);

        if (!$isEnrolled) {
            $_SESSION['error'] = "Join the course before viewing its content.";
            header('Location: /project/student/dashboard/courses');
            exit;
        }

        $contents = $this->courseModel->getVisibleCourseContent($course_id);

        require BASE_PATH . '/views/Courses/student/show.php';
    }
}