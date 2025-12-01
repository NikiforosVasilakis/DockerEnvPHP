<?php
session_start();
require_once 'connect.php';

$id = intval($_GET['id']);

$sql = "SELECT * FROM articles WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("Article not found.");
}

$article = $result->fetch_assoc();

// Load role permissions into session if not present (just in case)
if (isset($_SESSION['user']) && !isset($_SESSION['user']['can_create'])) {
    $role_id = intval($_SESSION['user']['role_id']);
    $query = $conn->query("SELECT * FROM user_roles WHERE id = $role_id");
    if ($query && $query->num_rows === 1) {
        $role = $query->fetch_assoc();
        $_SESSION['user'] = array_merge($_SESSION['user'], $role);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($article['title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 25px;
            background: #f4f4f4;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
            max-width: 800px;
            margin: auto;
        }
        h1 { margin-top: 0; }
        .meta {
            font-size: 14px;
            colour: #666;
            margin-bottom: 15px;
        }
        .back-btn {
            display: inline-block;
            padding: 10px 15px;
            background: #0066cc;
            colour: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .back-btn:hover { background: #004c99; }
        .article-body {
            font-size: 16px;
            line-height: 1.6;
        }
        .actions {
            margin-top: 25px;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
            colour: #0066cc;
        }
    </style>
</head>
<body>

<div class="container">

    <a class="back-btn" href="articles.php">← Back to Articles</a>

    <h1><?php echo htmlspecialchars($article['title']); ?></h1>

    <div class="meta">
        <strong>Category:</strong> <?php echo htmlspecialchars($article['category']); ?><br>
        <strong>Author:</strong> <?php echo htmlspecialchars($article['author']); ?><br>
        <strong>Date:</strong> <?php echo htmlspecialchars($article['created_at']); ?>
    </div>

    <div class="article-body">
        <?php echo $article['body']; ?>
    </div>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="actions">

            <?php if ($_SESSION['user']['can_update'] == 1): ?>
                <a href="article_form.php?id=<?php echo $article['id']; ?>">
                    Edit Article
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['user']['can_delete'] == 1): ?>
                <a href="delete_article.php?id=<?php echo $article['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this article?');">
                    Delete Article
                </a>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>

</body>
</html>