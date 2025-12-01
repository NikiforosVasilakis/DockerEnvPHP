<?php
declare(strict_types=1);

/**
 * Utility functions for the application.
 * Includes functions for authentication, input sanitization, file handling, and more.
 *
 * Author: [Your Name]
 * Date: [Date]
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}

/**
 * Generate a CSRF token and store it in the session.
 */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Check if a user is logged in.
 *
 * @return bool True if the user is logged in, false otherwise.
 */
function isLoggedIn(): bool {
    return isset($_SESSION['username']);
}

/**
 * Check if the logged-in user is an admin.
 *
 * @return bool True if the user is an admin, false otherwise.
 */
function isAdmin(): bool {
    return isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];
}

/**
 * Sanitize user input to prevent XSS and other vulnerabilities.
 *
 * @param string $input The user input.
 * @return string The sanitized input.
 */
function sanitizeInput(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect the user to a specified location if they are not logged in.
 *
 * @param string $redirectPath The path to redirect to (default is 'index.php').
 * @return void
 */
function redirectIfNotLoggedIn(string $redirectPath = 'index.php'): void {
    if (!isLoggedIn()) {
        header("Location: $redirectPath");
        exit;
    }
}

/**
 * Redirect to a specific URL.
 *
 * @param string $url The URL to redirect to.
 * @return void
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

/**
 * Handle database errors by throwing an exception.
 *
 * @param mysqli $conn The database connection.
 * @return void
 * @throws Exception If there is a database error.
 */
function handleDbError(mysqli $conn): void {
    if ($conn->error) {
        throw new Exception("Database error: " . $conn->error);
    }
}

/**
 * Authenticate a user.
 *
 * @param mysqli $conn The database connection.
 * @param string $username The username provided by the user.
 * @param string $password The password provided by the user.
 * @return array|null The user data if authenticated, or null if authentication fails.
 * @throws Exception If the database query fails.
 */
function authenticateUser(mysqli $conn, string $username, string $password): ?array {
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

        // Verify password
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }

    return null; // Authentication failed
}

/**
 * Validate and prepare an uploaded file.
 *
 * @param array $file The uploaded file data (e.g., from $_FILES).
 * @param array $allowedMimeTypes Allowed MIME types (e.g., ['image/jpeg', 'image/png']).
 * @param int $maxSize The maximum file size in bytes.
 * @param string $username The username to include in the filename.
 * @return string The unique filename for the uploaded file.
 * @throws Exception If the file is invalid or exceeds constraints.
 */
function validateFileUpload(array $file, array $allowedMimeTypes, int $maxSize, string $username): string {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error.');
    }

    // Validate MIME type
    $mimeType = mime_content_type($file['tmp_name']);
    if (!in_array($mimeType, $allowedMimeTypes)) {
        throw new Exception('Invalid file type. Allowed types: ' . implode(', ', $allowedMimeTypes));
    }

    // Validate file size
    if ($file['size'] > $maxSize) {
        throw new Exception('File size exceeds the allowed limit of ' . ($maxSize / (1024 * 1024)) . ' MB.');
    }

    // Generate unique filename using username and uniqid
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $sanitizedUsername = preg_replace('/[^a-zA-Z0-9]/', '_', $username);
    $filename = uniqid($sanitizedUsername . '_') . '.' . $extension;

    return $filename;
}

/**
 * Validate an email address.
 *
 * @param string $email The email address to validate.
 * @return bool True if the email is valid, false otherwise.
 */
function isValidEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Convert a maximum file size from MB to bytes.
 *
 * @param float $megabytes The maximum file size in MB.
 * @return int The maximum file size in bytes.
 */
function setMaxFileSize(float $megabytes): int {
    return (int) ($megabytes * 1024 * 1024);
}

/**
 * Get the avatar HTML for a user.
 *
 * @param array $user The user data.
 * @return string The avatar HTML.
 */
function getAvatarHtml(array $user): string {
    $avatarPath = '';

    if (!empty($user['avatar'])) {
        $avatarPath = "assets/uploads/avatars/" . htmlspecialchars($user['avatar']);
    } else {
        $avatarPath = $user['gender'] === 'male'
            ? "assets/images/placeholders/avatar-male.jpg"
            : "assets/images/placeholders/avatar-female.jpg";
    }

    return sprintf(
        '<img src="%s" alt="%s\'s Avatar" class="avatar">',
        $avatarPath,
        htmlspecialchars($user['username'])
    );
}

/**
 * Ensure that a directory exists.
 *
 * @param string $directory The directory path.
 * @return void
 * @throws Exception If the directory cannot be created.
 */
function ensureDirectoryExists(string $directory): void {
    if (!is_dir($directory)) {
        if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new Exception('Failed to create directory: ' . $directory);
        }
    }
}

