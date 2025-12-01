<?php
require_once 'db.php';
require_once 'utilities.php';

$error = ''; // Initialize error message

// Handle cookie for "Remember Me"
$savedUsername = $_COOKIE['username'] ?? '';
$savedPassword = $_COOKIE['password'] ?? ''; // Note: Hashed password in the cookie

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Sanitize input
        $username = sanitizeInput($_POST['username']);
        $password = sanitizeInput($_POST['password']);
        $rememberMe = isset($_POST['remember_me']);

        // Authenticate user
        $sql = "SELECT `u`.`id`, `u`.`username`, `u`.`password`, `u`.`name`, `u`.`surname`, `u`.`status`, `r`.`role_name`
                FROM `users` AS `u`
                JOIN `roles` AS `r` ON `u`.`role_id` = `r`.`id`
                WHERE `u`.`username` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Check if user account is active
                if ($user['status'] === 'active') {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id']; // Ensure ID is stored
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['surname'] = $user['surname'];
                    $_SESSION['role'] = $user['role_name'];
                    $_SESSION['isAdmin'] = ($user['role_name'] === 'admin');

                    // Handle "Remember Me" checkbox
                    if ($rememberMe) {
                        setcookie('username', $username, time() + (86400 * 30), "/"); // Expires in 30 days
                        setcookie('password', $user['password'], time() + (86400 * 30), "/"); // Save hashed password
                    } else {
                        setcookie('username', '', time() - 3600, "/"); // Expire cookie
                        setcookie('password', '', time() - 3600, "/");
                    }

                    // Redirect to index
                    redirect('index.php');
                } else {
                    $error = "Your account is inactive. Please contact the administrator.";
                }
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    } catch (Exception $e) {
        // Log error for debugging
        error_log($e->getMessage(), 3, 'logs/error_log.txt');
        $error = "An error occurred. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Base CSS -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- Page-Specific CSS -->
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input
                type="text"
                id="username"
                name="username"
                placeholder="Enter your username"
                value="<?php echo htmlspecialchars($savedUsername); ?>"
                required
        >
        <label for="password">Password:</label>
        <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                value="<?php echo htmlspecialchars($savedPassword); ?>"
                required
        >
        <label>
            <input type="checkbox" name="remember_me" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
            Remember Me
        </label>
        <button type="submit">Login</button>
    </form>
    <!-- Link to return to home page -->
    <p>
        <a href="index.php" class="home-link">Return to Home</a>
    </p>
</div>
</body>
</html>
