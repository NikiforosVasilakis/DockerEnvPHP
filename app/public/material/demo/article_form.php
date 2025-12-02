<?php
session_start();
require_once 'connect.php';

// Only logged-in users can add/update articles
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Determine if we are editing BEFORE permission checks
$edit_mode = false;
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
    $edit_mode = true;
}

$can_create = isset($_SESSION['user']['can_create']) ? $_SESSION['user']['can_create'] : 0;
$can_update = isset($_SESSION['user']['can_update']) ? $_SESSION['user']['can_update'] : 0;

// Permission checks
if (!$edit_mode && $can_create != 1) {
    die("You do not have permission to create articles.");
}
if ($edit_mode && $can_update != 1) {
    die("You do not have permission to edit articles.");
}

$article = [
    'title' => '',
    'short_description' => '',
    'author' => '',
    'category' => '',
    'tags' => '',
    'body' => ''
];

// If we are editing
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM articles WHERE id = $id LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $article = $result->fetch_assoc();
    } else {
        die("Article not found.");
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $conn->real_escape_string($_POST['title']);
    $short_description = $conn->real_escape_string($_POST['short_description']);
    $author = $conn->real_escape_string($_POST['author']);
    $category = $conn->real_escape_string($_POST['category']);
    $tags = $conn->real_escape_string($_POST['tags']);
    $body = $conn->real_escape_string($_POST['body']);

    if ($edit_mode) {
        // Update existing
        $sql = "
            UPDATE articles SET
                title = '$title',
                short_description = '$short_description',
                author = '$author',
                category = '$category',
                tags = '$tags',
                body = '$body'
            WHERE id = $id
        ";
        if ($can_update != 1) {
            die("You do not have permission to update articles.");
        }

        if ($conn->query($sql)) {
            header("Location: article.php?id=" . $id . "&updated=1");
            exit;
        } else {
            die("Error updating: " . $conn->error);
        }

    } else {
        // Insert new article
        $sql = "
            INSERT INTO articles 
            (title, short_description, author, category, tags, body)
            VALUES 
            ('$title', '$short_description', '$author', '$category', '$tags', '$body')
        ";
        if ($can_create != 1) {
            die("You do not have permission to create articles.");
        }

        if ($conn->query($sql)) {
            header("Location: articles.php?added=1");
            exit;
        } else {
            die("Error adding: " . $conn->error);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $edit_mode ? "Edit Article" : "Add Article"; ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 25px; }
        .container {
            background: #fff; padding: 20px; border-radius: 6px;
            border: 1px solid #ddd; max-width: 800px; margin: auto;
        }
        input, textarea {
            width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #bbb; border-radius: 4px;
        }
        button {
            padding: 10px 18px; background: #0066cc; colour: #fff;
            border: none; border-radius: 4px; cursor: pointer;
        }
        button:hover { background: #004c99; }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            background: #555; colour: #fff;
            padding: 8px 12px; border-radius: 4px; text-decoration: none;
        }
        .back-btn:hover { background: #333; }
    </style>
</head>
<body>

<div class="container">

    <h2><?php echo $edit_mode ? "Edit Article" : "Add New Article"; ?></h2>

    <form method="POST">

        <label>Title:</label>
        <input type="text" name="title" required
               value="<?php echo htmlspecialchars($article['title']); ?>">

        <label>Short Description:</label>
        <input type="text" name="short_description" required
               value="<?php echo htmlspecialchars($article['short_description']); ?>">

        <label>Author:</label>
        <input type="text" name="author" required
               value="<?php echo htmlspecialchars($article['author']); ?>">

        <label>Category:</label>
        <input type="text" name="category" required
               value="<?php echo htmlspecialchars($article['category']); ?>">

        <label>Tags (comma separated):</label>
        <input type="text" name="tags"
               value="<?php echo htmlspecialchars($article['tags']); ?>">

        <label>Full Article Body (HTML allowed):</label>
        <textarea name="body" rows="12"><?php echo htmlspecialchars($article['body']); ?></textarea>

        <button type="submit">
            <?php echo $edit_mode ? "Update Article" : "Add Article"; ?>
        </button>
    </form>

    <a class="back-btn" href="articles.php">← Back to Articles</a>

</div>

</body>
</html>