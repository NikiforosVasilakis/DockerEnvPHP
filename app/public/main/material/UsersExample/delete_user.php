<?php
require_once 'db.php';
require_once 'utilities.php';

// Check if the user is an admin
if (!isAdmin()) {
    error_log("Unauthorized delete attempt by user: " . ($_SESSION['username'] ?? 'Guest'), 3, 'logs/error_log.txt');
    header("Location: index.php?error=Unauthorized action.");
    exit;
}

// Handle GET request with CSRF protection
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'], $_GET['csrf_token'])) {
    try {
        // Validate CSRF token
        if ($_GET['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Invalid CSRF token.');
        }

        // Sanitize the input
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        if (!$id || $id <= 0) {
            throw new Exception('Invalid user ID.');
        }

        // Prepare the DELETE query
        $sql = "DELETE FROM `users` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception('Failed to prepare statement: ' . $conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: index.php?message=User deleted successfully.");
            exit;
        } else {
            throw new Exception('No user found with the given ID.');
        }
    } catch (Exception $e) {
        error_log("Error deleting user: " . $e->getMessage(), 3, 'logs/error_log.txt');
        header("Location: index.php?error=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    header("Location: index.php?error=Invalid request.");
    exit;
}
