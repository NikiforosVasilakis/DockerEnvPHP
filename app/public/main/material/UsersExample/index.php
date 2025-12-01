<?php
require_once 'db.php';
require_once 'utilities.php';
require_once 'auto_login.php';

// Fetch and sanitize the search input
$search = isLoggedIn() && !empty($_GET['search']) ? sanitizeInput(trim($_GET['search'])) : '';

// Fetch users from the database
try {
    // Start base query
    $sql = "SELECT `u`.*, `r`.`role_name` 
            FROM `users` AS `u` 
            JOIN `roles` AS `r` ON `u`.`role_id` = `r`.`id`";

    // Adjust query based on user role
    if (!isAdmin()) {
        $sql .= " WHERE `r`.`role_name` != 'admin'";
    }

    // Add search filter if provided
    if ($search) {
        $sql .= isAdmin() ? " WHERE " : " AND ";
        $sql .= "`u`.`username` LIKE ?";
    }

    // Prepare and execute the query
    if ($search) {
        $stmt = $conn->prepare($sql);
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query($sql);
    }

    handleDbError($conn);
} catch (Exception $e) {
    die("Error fetching users: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <script src="assets/js/index.js" defer></script>
</head>
<body>
<div class="container">
    <!-- Header Section -->
    <div class="header">
        <h2>Users List</h2>
        <?php if (isLoggedIn()): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>

    <!-- Welcome Message -->
    <?php if (isLoggedIn()): ?>
        <p class="welcome">
            Welcome,
            <a href="view_user.php?id=<?php echo htmlspecialchars($_SESSION['user_id']); ?>" class="profile-link">
                <?php
                echo isset($_SESSION['name'], $_SESSION['surname'])
                    ? htmlspecialchars($_SESSION['name'] . ' ' . $_SESSION['surname'])
                    : htmlspecialchars($_SESSION['username']);
                ?>
            </a>!
        </p>
    <?php endif; ?>

    <!-- Search Form -->
    <?php if (isLoggedIn()): ?>
        <form class="search-bar" method="GET" action="index.php">
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    <?php endif; ?>

    <!-- Add User Link for Admins -->
    <?php if (isAdmin()): ?>
        <a href="add_edit_user.php">Add User</a>
    <?php endif; ?>

    <!-- Display Success/Error Messages -->
    <?php if (!empty($_GET['message'])): ?>
        <p class="success-message"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php elseif (!empty($_GET['error'])): ?>
        <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <!-- Users Table -->
    <table>
        <thead>
        <tr>
            <th>Avatar</th>
            <th>Username</th>
            <th>Email</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Birthdate</th>
            <th>Status</th>
            <?php if (isAdmin()): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo getAvatarHtml($row); ?></td>
                <td>
                    <?php if (isLoggedIn()): ?>
                        <a href="view_user.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                            <?php echo htmlspecialchars($row['username']); ?>
                        </a>
                    <?php else: ?>
                        <?php echo htmlspecialchars($row['username']); ?>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['surname']); ?></td>
                <td><?php echo htmlspecialchars($row['birthdate']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <?php if (isAdmin()): ?>
                    <td>
                        <a href="add_edit_user.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-edit">Edit</a>
                        <button
                                class="btn btn-delete delete-btn"
                                data-id="<?php echo htmlspecialchars($row['id']); ?>"
                                data-name="<?php echo htmlspecialchars($row['name'] ?? $row['username']); ?>"
                                data-surname="<?php echo htmlspecialchars($row['surname'] ?? ''); ?>"
                                data-csrf="<?php echo $_SESSION['csrf_token']; ?>"
                        >
                            Delete
                        </button>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Deletion Confirmation -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p id="deleteMessage"></p>
        <button id="confirmDelete" class="confirm-btn">Yes, Delete</button>
        <button id="cancelDelete" class="cancel-btn">Cancel</button>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <p>Loading...</p>
</div>

</body>
</html>
