<?php
require_once 'connect.php';
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';

	if (isset($conn) && !$conn->connect_error) {
		$sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
		$result = $conn->query($sql);

		if ($result && $result->num_rows === 1) {
			$user = $result->fetch_assoc();

			if (isset($user['password']) && password_verify($password, $user['password'])) {
				// Load role permissions/name
				$role_id = isset($user['role_id']) ? intval($user['role_id']) : 0;
				
				if ($role_id > 0) {
					$role_sql = "SELECT * FROM user_roles WHERE id = $role_id LIMIT 1";
					$role_res = $conn->query($role_sql);
					
					if ($role_res && $role_res->num_rows === 1) {
						$role = $role_res->fetch_assoc();
						$user = array_merge($user, ['role_name' => $role['role_name'],'role' => strtolower($role['role_name'])]);
					}
				}

				// Set session and redirect back to site index
				$_SESSION['user'] = $user;
				$_SESSION['just_logged_in'] = true;
				header('Location: /project/dashboard/dashboard.php');
				exit;
			} else {
				$message = "Incorrect password.";
			}
		} else {
			$message = "User with that email does not exist.";
		}
	} else {
		$message = "Database connection is not available.";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - NYU</title>
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

		.auth-footer {
			display: flex;
			justify-content: space-between;
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
			<h1>NYU Login System</h1>
		</div>

		<?php if ($message): ?>
			<div class="message"><?= htmlspecialchars($message) ?></div>
		<?php endif; ?>

		<form method="POST">
			<div class="form-group">
				<input type="email" id="email" name="email" placeholder="Email" required>
			</div>

			<div class="form-group">
				<input type="password" id="password" name="password" placeholder="Password" required>
			</div>

			<button type="submit" class="submit-btn">Log In</button>
		</form>

		<div class="auth-footer">
			<a href="#">Forgot password?</a>
			<a href="../auth/register.php">New user?</a>
		</div>

		<a href="../main/index.php" class="back-link">← Back to site</a>
	</div>
</div>

</body>
</html>
