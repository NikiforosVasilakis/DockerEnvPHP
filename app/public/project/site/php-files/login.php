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
						$user = array_merge($user, ['role_name' => $role['role_name']]);
					}
				}

				// Set session and redirect back to site index
				$_SESSION['user'] = $user;
				header('Location: ../index.php');
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
	<title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if ($message): ?>
	<div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST">
	<input type="email" name="email" placeholder="Email" required>
	<input type="password" name="password" placeholder="Password" required>
	<button type="submit">Login</button>
</form>

<a class="back-link" href="../index.php">Back to site</a>

</body>
</html>
