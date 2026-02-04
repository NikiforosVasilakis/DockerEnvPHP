<?php

class User
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
	 * Find a user by ID
	 */
	public function findById(int $id)
	{
		$stmt = $this->conn->prepare(
			"SELECT u.id, u.username, u.email, u.created_at, r.role_name, u.role_id
			 FROM users u
			 JOIN user_roles r ON u.role_id = r.id
			 WHERE u.id = ?
			 LIMIT 1"
		);

		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result ? $result->fetch_assoc() : null;
		$stmt->close();
		return $row;
	}

	/**
	 * Get all teachers (users with role Teacher)
	 */
	public function getTeachers()
	{
		$stmt = $this->conn->prepare(
			"SELECT u.id, u.username, u.email, u.created_at, r.role_name
			 FROM users u
			 JOIN user_roles r ON u.role_id = r.id
			 WHERE LOWER(r.role_name) = LOWER(?)
			 ORDER BY u.username ASC"
		);

		$role = 'Teacher';
		$stmt->bind_param('s', $role);
		$stmt->execute();
		$result = $stmt->get_result();
		$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
		$stmt->close();
		return $rows;
	}

	/**
	 * Get all students (users with role Student)
	 */
	public function getStudents()
	{
		$stmt = $this->conn->prepare(
			"SELECT u.id, u.username, u.email, u.created_at, r.role_name, u.role_id
			 FROM users u
			 JOIN user_roles r ON u.role_id = r.id
			 WHERE LOWER(r.role_name) = LOWER(?)
			 ORDER BY u.username ASC"
		);

		$role = 'Student';
		$stmt->bind_param('s', $role);
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
