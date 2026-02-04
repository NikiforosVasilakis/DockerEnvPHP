<?php

class Course
{
    private $conn;

    public function __construct()
    {
        // Database connection
        $host = 'db';
        $username = 'root';
        $password = 'rootpass';
        $database = 'Univercity_DB';

        $this->conn = new mysqli($host, $username, $password, $database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * Create a new course
     */
    public function create($teacher_id, $course_code, $title, $description, $is_published = 0)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO courses (teacher_id, course_code, title, description, is_published) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param("isssi", $teacher_id, $course_code, $title, $description, $is_published);
        
        if ($stmt->execute()) {
            $course_id = $this->conn->insert_id;
            $stmt->close();
            return $course_id;
        } else {
            $error = $stmt->error;
            $stmt->close();
            return false;
        }
    }

    /**
     * Get all courses by teacher ID
     */
    public function getCoursesByTeacher($teacher_id)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM courses 
            WHERE teacher_id = ? 
            ORDER BY created_at DESC
        ");
        
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $courses = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $courses;
    }

    /**
     * Get a single course by ID
     */
    public function getCourseById($course_id)
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, u.username as teacher_name 
            FROM courses c
            JOIN users u ON c.teacher_id = u.id
            WHERE c.id = ?
        ");
        
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc();
        $stmt->close();
        
        return $course;
    }

    /**
     * Update a course
     */
    public function update($course_id, $course_code, $title, $description, $is_published)
    {
        $stmt = $this->conn->prepare("
            UPDATE courses 
            SET course_code = ?, title = ?, description = ?, is_published = ?
            WHERE id = ?
        ");
        
        $stmt->bind_param("sssii", $course_code, $title, $description, $is_published, $course_id);
        
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    /**
     * Delete a course
     */
    public function delete($course_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->bind_param("i", $course_id);
        
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    /**
     * Check if course code already exists
     */
    public function courseCodeExists($course_code, $exclude_id = null)
    {
        if ($exclude_id) {
            $stmt = $this->conn->prepare("SELECT id FROM courses WHERE course_code = ? AND id != ?");
            $stmt->bind_param("si", $course_code, $exclude_id);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM courses WHERE course_code = ?");
            $stmt->bind_param("s", $course_code);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        
        return $exists;
    }

    /**
     * Get all published courses
     */
    public function getPublishedCourses()
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, u.username as teacher_name 
            FROM courses c
            JOIN users u ON c.teacher_id = u.id
            WHERE c.is_published = 1
            ORDER BY c.created_at DESC
        ");
        
        $stmt->execute();
        $result = $stmt->get_result();
        $courses = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $courses;
    }

    /**
     * Get enrolled courses for a student
     */
    public function getEnrolledCourses($student_id)
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, u.username as teacher_name, ce.enrolled_at
            FROM courses c
            JOIN users u ON c.teacher_id = u.id
            JOIN course_enrollments ce ON c.id = ce.course_id
            WHERE ce.student_id = ?
            ORDER BY ce.enrolled_at DESC
        ");
        
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $courses = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $courses;
    }

    /**
     * Enroll a student into a course (idempotent)
     */
    public function enrollStudent($course_id, $student_id)
    {
        $stmt = $this->conn->prepare("INSERT IGNORE INTO course_enrollments (course_id, student_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $course_id, $student_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Check if a student is enrolled in a course
     */
    public function isStudentEnrolled($course_id, $student_id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM course_enrollments WHERE course_id = ? AND student_id = ?");
        $stmt->bind_param("ii", $course_id, $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $isEnrolled = $result->num_rows > 0;
        $stmt->close();
        return $isEnrolled;
    }

    /**
     * Get enrolled students for a course
     */
    public function getEnrolledStudents($course_id)
    {
        $stmt = $this->conn->prepare("
            SELECT u.id, u.username, u.email, ce.enrolled_at
            FROM course_enrollments ce
            JOIN users u ON ce.student_id = u.id
            WHERE ce.course_id = ?
            ORDER BY ce.enrolled_at DESC
        ");

        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $students = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $students;
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    /**
     * Add content to a course
     */
    public function addContent($course_id, $content_type, $title, $body, $url, $file_path, $sort_order = 0)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO course_contents (course_id, content_type, title, body, url, file_path, sort_order)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param("isssssi", $course_id, $content_type, $title, $body, $url, $file_path, $sort_order);
        
        if ($stmt->execute()) {
            $content_id = $this->conn->insert_id;
            $stmt->close();
            return $content_id;
        } else {
            $error = $stmt->error;
            $stmt->close();
            return false;
        }
    }

    /**
     * Get all content for a course
     */
    public function getCourseContent($course_id)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM course_contents
            WHERE course_id = ?
            ORDER BY sort_order ASC
        ");
        
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $contents = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $contents;
    }

    /**
     * Delete course content
     */
    public function deleteContent($content_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM course_contents WHERE id = ?");
        $stmt->bind_param("i", $content_id);
        
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    /**
     * Update course content
     */
    public function updateContent($content_id, $title, $body, $url, $is_visible)
    {
        $stmt = $this->conn->prepare("
            UPDATE course_contents 
            SET title = ?, body = ?, url = ?, is_visible = ?
            WHERE id = ?
        ");
        
        $stmt->bind_param("sssii", $title, $body, $url, $is_visible, $content_id);
        
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    /**
     * Get visible course content for students
     */
    public function getVisibleCourseContent($course_id)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM course_contents
            WHERE course_id = ? AND is_visible = 1
            ORDER BY sort_order ASC, created_at ASC
        ");

        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $contents = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $contents;
    }
}
