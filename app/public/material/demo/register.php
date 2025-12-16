<?php
session_start();
require_once 'connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name  = $conn->real_escape_string($_POST['last_name']);
    $email      = $conn->real_escape_string($_POST['email']);
    $phone      = $conn->real_escape_string($_POST['phone']);
    $age        = intval($_POST['age']);
    $city       = $conn->real_escape_string($_POST['city']);
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $reg_code   = $conn->real_escape_string($_POST['reg_code']);

    // Verify registration code
    $sql = "
        SELECT * FROM registration_codes 
        WHERE reg_code = '$reg_code' 
          AND used = 0
          AND expires_at > NOW()
        LIMIT 1
    ";
    $res = $conn->query($sql);

    if (!$res || $res->num_rows === 0) {
        $message = "Invalid or expired registration code.";
    } else {

        $code = $res->fetch_assoc();
        $role_id = $code['role_id'];

        // Insert user
        $sql = "
            INSERT INTO users 
            (first_name, last_name, email, phone, age, city, password, role_id)
            VALUES
            ('$first_name', '$last_name', '$email', '$phone', $age, '$city', '$password', $role_id)
        ";

        if ($conn->query($sql)) {

            // Mark registration code as used
            $conn->query("
                UPDATE registration_codes SET used = 1 WHERE id = {$code['id']}
            ");

            $message = "Registration successful! You may now login.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        body { font-family: Arial; padding: 25px; background: #f4f4f4; }
        .container { background: #fff; padding: 20px; border-radius: 6px; max-width: 600px; margin: auto; border: 1px solid #ddd; }
        input { width: 100%; padding: 10px; margin: 8px 0; border-radius: 4px; border: 1px solid #bbb; }
        button { padding: 10px; background: #0066cc; color: #fff; border: none; border-radius: 4px; }
        button:hover { background: #004c99; }
        .message { font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="container">

    <h2>Register</h2>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>First Name:</label>
        <input type="text" name="first_name" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Phone:</label>
        <input type="text" name="phone">

        <label>Age:</label>
        <input type="number" name="age" min="1" max="120">

        <label>City:</label>
        <input type="text" name="city">

        <label>Registration Code:</label>
        <input type="text" name="reg_code" required>

        <button type="submit">Register</button>
    </form>

    <br>
    <a href="login.php">Already registered? Login</a>

</div>

</body>
</html>