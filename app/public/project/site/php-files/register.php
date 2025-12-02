<?php
session_start();
require_once 'connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
	$email      = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
	$password   = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
	$reg_code   = isset($_POST['reg_code']) ? $conn->real_escape_string($_POST['reg_code']) : '';

	// Registration code is mandatory
	if ($reg_code === '') {
		$message = "Registration code is required.";
	} else {
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
			$role_id = intval($code['role_id']);
		}
	}

	if ($message === '') {
		// Insert user
		$sql = "
			INSERT INTO users 
			(username, email, password, role_id)
			VALUES
			('$username', '$email','$password', $role_id)
		";

		if ($conn->query($sql)) {
			$new_user_id = $conn->insert_id;
			if (isset($code['id'])) {
				// Mark registration code as used
				$conn->query("UPDATE registration_codes SET used = 1 WHERE id = {$code['id']}");
			}

			// Fetch the newly created user and merge role name
			$u_sql = "SELECT u.*, r.role_name FROM users u LEFT JOIN user_roles r ON u.role_id = r.id WHERE u.id = $new_user_id LIMIT 1";
			$u_res = $conn->query($u_sql);
			if ($u_res && $u_res->num_rows === 1) {
				$new_user = $u_res->fetch_assoc();
				$_SESSION['user'] = $new_user;
				header('Location: ../index.php');
				exit;
			}

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
</head>
<body>

<div class="container">

	<h2>Register</h2>

	<?php if ($message): ?>
		<p class="message"><?php echo htmlspecialchars($message); ?></p>
	<?php endif; ?>

	<form method="POST">

		<label>username:</label>
		<input type="text" name="username" required>

		<label>Email:</label>
		<input type="email" name="email" required>

		<label>Password:</label>
		<input type="password" name="password" required>

		<label>Registration Code:</label>
		<input type="text" name="reg_code" required>

		<button type="submit">Register</button>
	</form>

	<br>
	<a href="login.php">Already registered? Login</a>

</div>

</body>
</html>
