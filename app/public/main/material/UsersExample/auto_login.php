<?php

try {
    // Check if the user is already logged in
    if (!isset($_SESSION['username']) && isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
        $username = sanitizeInput($_COOKIE['username']);
        $hashedPassword = sanitizeInput($_COOKIE['password']);

        // Query the database for the user
        $sql = "SELECT `u`.`username`, `u`.`password`, `u`.`name`, `u`.`surname`, `u`.`status`, `r`.`role_name`
                FROM `users` AS `u`
                JOIN `roles` AS `r` ON `u`.`role_id` = `r`.`id`
                WHERE `u`.`username` = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Database statement preparation failed: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Validate the stored cookie password hash with the database hash
            if ($hashedPassword === $user['password'] && $user['status'] === 'active') {
                // Set session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['surname'] = $user['surname'];
                $_SESSION['role'] = $user['role_name'];
                $_SESSION['isAdmin'] = ($user['role_name'] === 'admin');

                // Regenerate session ID for security
                session_regenerate_id(true);
            }
        }
    }
} catch (Exception $e) {
    // Log the error for debugging purposes
    error_log("Auto-login error: " . $e->getMessage(), 3, 'logs/error_log.txt');
}
