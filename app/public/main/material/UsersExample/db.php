<?php
// Database configuration
$servername = "127.0.0.1:8080";
$username = "Nick";
$password = "dbpass123@";
$database = "Practice_DB"; // Name of the database

// Create a new MySQLi connection to the MySQL server
$conn = new mysqli($servername, $username, $password);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database exists
$db_check_query = "SHOW DATABASES LIKE '$database'";
$result = $conn->query($db_check_query);

if ($result->num_rows === 0) {
    // Initialize database if it doesn't exist
    $sql_file = __DIR__ . '/data/init.sql';
    if (file_exists($sql_file)) {
        $sql_content = file_get_contents($sql_file);
        $queries = explode(";", $sql_content);

        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (!$conn->query($query)) {
                    die("Error executing query: " . $conn->error);
                }
            }
        }
    }
} else {
    // Do nothing if the database already exists
}

// Select the database
$conn->select_db($database);

// Set the character encoding to UTF-8
$conn->set_charset("utf8");
