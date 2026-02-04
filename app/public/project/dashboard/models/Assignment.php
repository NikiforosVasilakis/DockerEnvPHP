<?php

class Assignment
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
	 * Create a new assignment
	 */
	public function create($teacher_id, $course_id, $title, $description, $max_points, $due_at, $allow_late = 0, $attachment_path = null)
	{
		// Ensure the course belongs to the teacher (defensive check)
		$courseStmt = $this->conn->prepare("SELECT teacher_id FROM courses WHERE id = ? LIMIT 1");
		$courseStmt->bind_param("i", $course_id);
		$courseStmt->execute();
		$courseResult = $courseStmt->get_result();
		$course = $courseResult->fetch_assoc();
		$courseStmt->close();

		if (!$course || $course['teacher_id'] != $teacher_id) {
			return false;
		}

		$stmt = $this->conn->prepare(
			"INSERT INTO assignments (course_id, title, description, attachment_path, max_points, due_at, allow_late) " .
			"VALUES (?, ?, ?, ?, ?, ?, ?)"
		);

		$stmt->bind_param(
			"isssdsi",
			$course_id,
			$title,
			$description,
			$attachment_path,
			$max_points,
			$due_at,
			$allow_late
		);

		$executed = $stmt->execute();

		if (!$executed) {
			$stmt->close();
			return false;
		}

		$assignment_id = $this->conn->insert_id;
		$stmt->close();
		return $assignment_id;
	}

	/**
	 * Get assignments for a teacher (via their courses)
	 */
	public function getAssignmentsByTeacher($teacher_id)
	{
		$stmt = $this->conn->prepare(
			"SELECT a.*, c.title AS course_title, c.course_code " .
			"FROM assignments a " .
			"JOIN courses c ON a.course_id = c.id " .
			"WHERE c.teacher_id = ? " .
			"ORDER BY a.created_at DESC"
		);

		$stmt->bind_param("i", $teacher_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$assignments = $result->fetch_all(MYSQLI_ASSOC);
		$stmt->close();

		return $assignments;
	}

	/**
	 * Get assignments for a student (enrolled courses)
	 */
	public function getAssignmentsByStudent($student_id, $limit = null)
	{
		$sql = "SELECT a.*, c.title AS course_title, c.course_code, u.username AS teacher_name " .
		       "FROM assignments a " .
		       "JOIN courses c ON a.course_id = c.id " .
		       "JOIN users u ON c.teacher_id = u.id " .
		       "JOIN course_enrollments ce ON c.id = ce.course_id " .
		       "WHERE ce.student_id = ? " .
		       "ORDER BY a.due_at ASC, a.created_at DESC";
		
		if ($limit) {
			$sql .= " LIMIT " . intval($limit);
		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$assignments = $result->fetch_all(MYSQLI_ASSOC);
		$stmt->close();

		return $assignments;
	}

	/**
	 * Get upcoming assignments for a student
	 */
	public function getUpcomingAssignments($student_id)
	{
		$stmt = $this->conn->prepare(
			"SELECT a.*, c.title AS course_title, c.course_code, u.username AS teacher_name " .
			"FROM assignments a " .
			"JOIN courses c ON a.course_id = c.id " .
			"JOIN users u ON c.teacher_id = u.id " .
			"JOIN course_enrollments ce ON c.id = ce.course_id " .
			"WHERE ce.student_id = ? AND a.due_at > NOW() " .
			"ORDER BY a.due_at ASC " .
			"LIMIT 5"
		);

		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$assignments = $result->fetch_all(MYSQLI_ASSOC);
		$stmt->close();

		return $assignments;
	}

	public function __destruct()
	{
		if ($this->conn) {
			$this->conn->close();
		}
	}
}
