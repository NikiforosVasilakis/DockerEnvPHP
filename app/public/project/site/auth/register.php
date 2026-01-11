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
				$_SESSION['just_logged_in'] = true;
				header('Location: ../main/Dashboard/main.php');
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
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register - NYU</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
			background: #1a1a2e;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 1rem;
			padding-top: calc(1rem - 2px);
		}

		.auth-wrapper {
			width: 100%;
			max-width: 380px;
		}

		.auth-card {
			background: white;
			border-radius: 16px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
			padding: 3rem 2.5rem;
			text-align: center;
		}

		.auth-header {
			margin-bottom: 2.5rem;
		}

		.auth-header h1 {
			font-size: 1.6rem;
			color: #0f1724;
			margin-top: 0rem;
			font-weight: 700;
			letter-spacing: -0.5px;
		}

		.form-group {
			margin-bottom: 1.25rem;
		}

		input {
			width: 100%;
			padding: 0.95rem 1.1rem;
			border: 1px solid #e0e0e0;
			border-radius: 8px;
			font-size: 0.95rem;
			transition: all 0.3s ease;
			background-color: #f9f9f9;
		}

		input:focus {
			outline: none;
			border-color: #667eea;
			background-color: white;
			box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.08);
		}

		input::placeholder {
			color: #bbb;
		}

		.submit-btn {
			width: 100%;
			padding: 0.95rem;
			background: #2563eb;
			color: white;
			border: none;
			border-radius: 8px;
			font-weight: 600;
			font-size: 0.95rem;
			cursor: pointer;
			transition: all 0.3s ease;
			box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
			text-transform: uppercase;
			letter-spacing: 0.5px;
			margin-top: 0.5rem;
		}

		.submit-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 12px 28px rgba(37, 99, 235, 0.3);
		}

		.submit-btn:active {
			transform: translateY(0);
		}

		.message {
			padding: 1rem;
			border-radius: 8px;
			margin-bottom: 1.5rem;
			font-weight: 500;
			font-size: 0.9rem;
			background-color: #ffebee;
			color: #c62828;
			border: 1px solid #ffcdd2;
			text-align: left;
		}

		.message.success {
			background-color: #e8f5e9;
			color: #2e7d32;
			border: 1px solid #c8e6c9;
		}

		.auth-footer {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 1.8rem;
			padding-top: 1.8rem;
			border-top: 1px solid #e8e8e8;
		}

		.auth-footer a {
			color: #666;
			text-decoration: none;
			font-size: 0.85rem;
			transition: color 0.3s ease;
		}

		.auth-footer a:hover {
			color: #2563eb;
		}

		.back-link {
			display: block;
			margin-top: 2rem;
			color: #999;
			text-decoration: none;
			font-size: 0.85rem;
			transition: color 0.3s ease;
		}

		.back-link:hover {
			color: #2563eb;
		}

		@media (max-width: 600px) {
			.auth-card {
				padding: 2.5rem 1.5rem;
			}

			.auth-header h1 {
				font-size: 1.4rem;
			}

			.auth-footer {
				flex-direction: column;
				gap: 1rem;
			}

			.auth-footer a {
				width: 100%;
				text-align: center;
			}
		}
	</style>
</head>
<body>

<div class="auth-wrapper">
	<div class="auth-card">
		<div class="auth-header">
			<h1>Create Account</h1>
		</div>

		<?php if ($message): ?>
			<div class="message <?php echo strpos($message, 'Error') === false && strpos($message, 'Invalid') === false && strpos($message, 'exists') === false ? 'success' : ''; ?>"><?= htmlspecialchars($message) ?></div>
		<?php endif; ?>

		<form method="POST">
			<div class="form-group">
				<input type="text" name="username" placeholder="Username" required>
			</div>

			<div class="form-group">
				<input type="email" name="email" placeholder="Email" required>
			</div>

			<div class="form-group">
				<input type="password" name="password" placeholder="Password" required>
			</div>

			<div class="form-group">
				<input type="text" name="reg_code" placeholder="Registration Code" required>
			</div>

			<button type="submit" class="submit-btn">Register</button>
		</form>

		<div class="auth-footer">
			<a href="login.php">Already have an account? Sign in</a>
		</div>

		<a href="../index.php" class="back-link">← Back to site</a>
	</div>
</div>

</body>
</html>
