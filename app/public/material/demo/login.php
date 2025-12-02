<?php
require_once 'connect.php';
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Fetch user
    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            // Load role permissions
            $role_id = intval($user['role_id']);
            $role_sql = "SELECT * FROM user_roles WHERE id = $role_id LIMIT 1";
            $role_res = $conn->query($role_sql);

            if ($role_res && $role_res->num_rows === 1) {
                $role = $role_res->fetch_assoc();
                // Merge role into session user
                $_SESSION['user'] = array_merge($user, $role);
            } else {
                $_SESSION['user'] = $user;
            }

            header("Location: articles.php");
            exit;
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "User with that email does not exist.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<p><?= $message ?></p>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<br>
<a href="register.php">Need an account? Register here</a>

</body>
</html>