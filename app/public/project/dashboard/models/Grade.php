<?php

class Grade
{
	private $conn;

	public function __construct()
	{
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
	 * Store a final grade (UI form)
	 */
	public function createFinalGrade(int $studentId, string $course, string $letterGrade, float $percentage, ?string $feedback, int $gradedBy): bool
	{
		$stmt = $this->conn->prepare(
			"INSERT INTO final_grades (student_id, course, letter_grade, percentage, feedback, graded_by)
			 VALUES (?, ?, ?, ?, ?, ?)"
		);

		$stmt->bind_param(
			'issdsi',
			$studentId,
			$course,
			$letterGrade,
			$percentage,
			$feedback,
			$gradedBy
		);

		$executed = $stmt->execute();
		$stmt->close();
		return $executed;
	}

	/**
	 * Fetch latest final grades with student names (optional helper)
	 */
	public function getFinalGradesWithStudents(int $limit = 20): array
	{
		$stmt = $this->conn->prepare(
			"SELECT fg.*, u.username AS student_name, u.email, grader.username AS graded_by_name
			 FROM final_grades fg
			 JOIN users u ON fg.student_id = u.id
			 JOIN users grader ON fg.graded_by = grader.id
			 ORDER BY fg.created_at DESC
			 LIMIT ?"
		);

		$stmt->bind_param('i', $limit);
		$stmt->execute();
		$result = $stmt->get_result();
		$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
		$stmt->close();
		return $rows;
	}

	public function __destruct()
	{
		if ($this->conn) {
			$this->conn->close();
		}
	}
}

?>
