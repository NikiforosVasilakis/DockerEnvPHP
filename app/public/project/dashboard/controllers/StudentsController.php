<?php

class StudentsController
{
    private mysqli $conn;

    public function __construct()
    {
        $host = 'db';
        $username = 'root';
        $password = 'rootpass';
        $database = 'Univercity_DB';

        $this->conn = new mysqli($host, $username, $password, $database);

        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    /**
     * List all students
     */
    public function index(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: /project/auth/login.php');
            exit;
        }

        $students = $this->getStudentsFromDb();

        require BASE_PATH . '/views/students/index.php';
    }

    /**
     * Pull all students from the database
     */
    private function getStudentsFromDb(): array
    {
        $sql = "SELECT u.id, u.username, u.email, u.created_at, r.role_name
                FROM users u
                JOIN user_roles r ON u.role_id = r.id
                WHERE LOWER(r.role_name) = 'student'
                ORDER BY u.username ASC";

        $result = $this->conn->query($sql);

        if ($result === false) {
            return [];
        }

        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        return $rows;
    }
}
