<?php
require_once 'db.php';
require_once 'utilities.php';

// Redirect if no user ID is provided
if (empty($_GET['id']) || !isLoggedIn()) {
    header("Location: index.php");
    exit;
}

// Fetch user details
$user = null;
try {
    $userId = sanitizeInput($_GET['id']);
    $sql = "SELECT `u`.*, `r`.`role_name`
            FROM `users` AS `u`
            JOIN `roles` AS `r` ON `u`.`role_id` = `r`.`id`
            WHERE `u`.`id` = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        throw new Exception("User not found.");
    }
} catch (Exception $e) {
    die("Error fetching user details: " . $e->getMessage());
}

// Check if the current user can edit the profile
$canEdit = isAdmin() || (isset($_SESSION['username']) && $_SESSION['username'] === $user['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['name'] . ' ' . $user['surname']); ?> - Profile</title>
    <!-- Base CSS -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- Page-Specific CSS -->
    <link rel="stylesheet" href="assets/css/view_user.css">
</head>
<body>
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <?php if (!empty($user['avatar'])): ?>
                <img src="assets/uploads/avatars/<?php echo htmlspecialchars($user['avatar']); ?>" alt="<?php echo htmlspecialchars($user['username']); ?>'s Avatar">
            <?php else: ?>
                <img src="assets/images/placeholders/avatar-<?php echo $user['gender'] === 'male' ? 'male' : 'female'; ?>.jpg" alt="Default Avatar">
            <?php endif; ?>
        </div>
        <div class="profile-info">
            <h1><?php echo htmlspecialchars($user['name'] . ' ' . $user['surname']); ?></h1>
            <p class="username">@<?php echo htmlspecialchars($user['username']); ?></p>
            <p class="role"><?php echo htmlspecialchars(ucfirst($user['role_name'])); ?></p>
            <p class="status <?php echo htmlspecialchars($user['status']); ?>">
                <?php echo htmlspecialchars(ucfirst($user['status'])); ?>
            </p>
            <?php if ($canEdit): ?>
                <a href="add_edit_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="edit-profile-btn">Edit Profile</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="profile-details">
        <ul>
            <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
            <li><strong>Birthdate:</strong> <?php echo htmlspecialchars($user['birthdate']); ?></li>
            <li><strong>Gender:</strong> <?php echo htmlspecialchars(ucfirst($user['gender'])); ?></li>
        </ul>
        <a href="index.php" class="back-to-list">Back to Users List</a>
    </div>
</div>
</body>
</html>
