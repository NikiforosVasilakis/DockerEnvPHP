<?php
// Start the session if it hasn't been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear "Remember Me" cookies
setcookie('username', '', time() - 3600, "/"); // Expire the username cookie
setcookie('password', '', time() - 3600, "/"); // Expire the password cookie

// Destroy the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session itself

/**
 * Redirect to the index page.
 */
header("Location: index.php");
exit;
