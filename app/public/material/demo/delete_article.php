<?php
session_start();
require_once 'connect.php';

// Must be logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Load permissions if not loaded
if (!isset($_SESSION['user']['can_delete'])) {
    $role_id = intval($_SESSION['user']['role_id']);
    $q = $conn->query("SELECT * FROM user_roles WHERE id = $role_id LIMIT 1");
    if ($q && $q->num_rows === 1) {
        $_SESSION['user'] = array_merge($_SESSION['user'], $q->fetch_assoc());
    }
}

// Check delete permission
if ($_SESSION['user']['can_delete'] != 1) {
    die("You do not have permission to delete articles.");
}

// Validate ID
if (!isset($_GET['id']) || !intval($_GET['id'])) {
    die("Invalid article ID.");
}

$id = intval($_GET['id']);

// Execute deletion
$sql = "DELETE FROM articles WHERE id = $id";

if ($conn->query($sql)) {
    header("Location: articles.php?deleted=1");
    exit;
} else {
    die("Error deleting article: " . $conn->error);
}
