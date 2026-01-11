<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Linking external CSS file -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/datatables.css">
    <link rel="stylesheet" href="css/graphs.css">
    <link rel="stylesheet" href="css/widgets.css">
</head>
<body>
<?php
// Main layout for the application
include_once __DIR__ . '/../views/components/sidebar.php';
include_once __DIR__ . '/../views/components/header.php';
?>

<main class="content">
    <?php include_once __DIR__ . '/../views/' . $view . '.php'; ?>
</main>
</body>
</html>