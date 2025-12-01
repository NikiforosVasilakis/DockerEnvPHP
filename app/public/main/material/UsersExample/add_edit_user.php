<?php
require_once 'db.php';
require_once 'utilities.php';

// Constants
define('MAX_FILE_SIZE_MB', 2.0);
define('AVATAR_UPLOAD_DIR', 'assets/uploads/avatars/');

// Redirect unauthorized users
if (!isLoggedIn()) {
    redirect('login.php');
}

// Determine if this is an edit operation
$isEdit = isset($_GET['id']);
$error = '';
$user = [
    'id' => '',
    'username' => '',
    'email' => '',
    'name' => '',
    'surname' => '',
    'birthdate' => '',
    'gender' => 'male',
    'avatar' => '',
    'status' => 'active',
    'role_id' => '2' // Default role is 'user'
];

// Check user permission to edit
$isOwnProfile = false;
if ($isEdit) {
    try {
        $id = sanitizeInput($_GET['id']);
        $sql = "SELECT * FROM `users` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            throw new Exception('User not found.');
        }

        // Check if the user is editing their own profile
        $isOwnProfile = ($_SESSION['username'] === $user['username']);

        // Restrict non-admins from editing other users
        if (!$isOwnProfile && !isAdmin()) {
            throw new Exception('Unauthorized access.');
        }
    } catch (Exception $e) {
        redirect('index.php?error=' . urlencode($e->getMessage()));
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Invalid or missing CSRF token.');
        }

        // Sanitize input
        $id = sanitizeInput($_POST['id']);
        $email = sanitizeInput($_POST['email']);
        $name = sanitizeInput($_POST['name']);
        $surname = sanitizeInput($_POST['surname']);
        $birthdate = sanitizeInput($_POST['birthdate']);
        $gender = sanitizeInput($_POST['gender']);
        $status = sanitizeInput($_POST['status']);
        $role_id = isset($_POST['role_id']) ? sanitizeInput($_POST['role_id']) : $user['role_id'];
        $avatar = $user['avatar'] ?: 'assets/images/placeholders/avatar-' . $gender . '.jpg';

        // Validate email
        if (!isValidEmail($email)) {
            throw new Exception('Invalid email format.');
        }

        // Hash password if provided
        $password = sanitizeInput($_POST['password']);
        $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;

        // Prevent non-admin users from changing their username or role
        if (!isAdmin() && $isOwnProfile) {
            $role_id = $user['role_id']; // Preserve role for non-admins
            unset($_POST['username']); // Ignore username changes
        }

        // Avatar file validation
        $maxFileSize = setMaxFileSize(MAX_FILE_SIZE_MB);
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $avatar = validateFileUpload($_FILES['avatar'], $allowedMimeTypes, $maxFileSize, $user['username']);

            ensureDirectoryExists(AVATAR_UPLOAD_DIR);
            $avatarPath = AVATAR_UPLOAD_DIR . $avatar;

            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath)) {
                throw new Exception('Failed to save uploaded avatar.');
            }
        } elseif ($isEdit) {
            // If editing and no file is uploaded, retain the current avatar
            $avatar = $user['avatar'] ?? null;
        } else {
            // For new user and no file uploaded, use a default placeholder based on gender
            $avatar = null;
        }

        // Update or insert user
        if ($isEdit) {
            // Update existing user
            $sql = "UPDATE `users` SET `email` = ?, `name` = ?, `surname` = ?, `birthdate` = ?, 
                    `gender` = ?, `avatar` = ?, `status` = ?" .
                ($hashedPassword ? ", `password` = ?" : "") .
                (isAdmin() && !$isOwnProfile ? ", `role_id` = ?" : "") .
                " WHERE `id` = ?";
            $stmt = $conn->prepare($sql);

            if ($hashedPassword) {
                $stmt->bind_param(
                    "ssssssssi",
                    $email, $name, $surname, $birthdate, $gender, $avatar, $status, $hashedPassword, $id
                );
            } elseif (isAdmin() && !$isOwnProfile) {
                $stmt->bind_param(
                    "sssssssii",
                    $email, $name, $surname, $birthdate, $gender, $avatar, $status, $role_id, $id
                );
            } else {
                $stmt->bind_param(
                    "sssssssi",
                    $email, $name, $surname, $birthdate, $gender, $avatar, $status, $id
                );
            }
        } else {
            // Add new user
            $sql = "INSERT INTO `users` (`username`, `password`, `email`, `name`, `surname`, 
                    `birthdate`, `gender`, `avatar`, `status`, `role_id`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $role_id = 2; // Default role is 'user'
            $stmt->bind_param(
                "sssssssssi",
                sanitizeInput($_POST['username']), $hashedPassword, $email, $name, $surname, $birthdate, $gender, $avatar, $status, $role_id
            );
        }

        if ($stmt->execute()) {
            redirect('index.php?message=' . ($isEdit ? 'User updated successfully.' : 'User added successfully.'));
        } else {
            throw new Exception('Error: Unable to save user. ' . $stmt->error);
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $isEdit ? 'Edit User' : 'Add User'; ?></title>
    <!-- Base CSS -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- Page-Specific CSS -->
    <link rel="stylesheet" href="assets/css/add_edit_user.css">
</head>
<body>
<div class="container">
    <!-- Header Section -->
    <div class="header">
        <h2><?php echo $isEdit ? 'Edit User' : 'Add User'; ?></h2>
        <a href="index.php">Return to Home</a>
    </div>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <!-- Add User Form -->
    <form class="add-user-form" method="POST" action="" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id'] ?? ''); ?>">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"
            <?php echo (!isAdmin() && $isOwnProfile) ? 'disabled' : ''; ?> required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="<?php echo $isEdit ? 'Leave blank to keep current password' : 'Enter password'; ?>">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="name">First Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label for="surname">Last Name:</label>
        <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required>

        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>

        <fieldset>
            <legend>Gender:</legend>
            <input type="radio" id="male" name="gender" value="male" <?php echo $user['gender'] === 'male' ? 'checked' : ''; ?>>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female" <?php echo $user['gender'] === 'female' ? 'checked' : ''; ?>>
            <label for="female">Female</label>
        </fieldset>

        <label for="avatar">Avatar:</label>
        <input type="file" id="avatar" name="avatar" accept="image/*">

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo $user['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select>

        <?php if (isAdmin() && !$isOwnProfile): ?>
            <label for="role_id">Role:</label>
            <select id="role_id" name="role_id">
                <option value="1" <?php echo $user['role_id'] == 1 ? 'selected' : ''; ?>>Admin</option>
                <option value="2" <?php echo $user['role_id'] == 2 ? 'selected' : ''; ?>>User</option>
            </select>
        <?php endif; ?>

        <button type="submit"><?php echo $isEdit ? 'Update User' : 'Add User'; ?></button>
    </form>
</div>
</body>
</html>
