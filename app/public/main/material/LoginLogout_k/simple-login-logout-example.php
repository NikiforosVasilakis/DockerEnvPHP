<?php
// Start a session at the top of the file
session_start();

// Define a simple username and password (for demonstration purposes only)
$validUsername = "admin";
$validPassword = "password";

// Handle the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Check if the submitted username and password are correct
    if ($username === $validUsername && $password === $validPassword) {
        // Store the username in the session to indicate that the user is logged in
        $_SESSION['username'] = $username;
    } else {
        $loginError = "Invalid username or password.";
    }
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Login Form</title>
</head>
<body>
    <?php if (isset($_SESSION['username'])): ?>
        <!-- If the user is logged in, show a welcome message and a logout link -->
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p><a href="?action=logout">Logout</a></p>
    <?php else: ?>
        <!-- If the user is not logged in, show the login form -->
        <h2>Login Form</h2>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($loginError)): ?>
            <p style="color: red;"><?= $loginError; ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
