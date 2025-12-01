<?php
session_start();
require_once 'connect.php';

// Load permissions if logged in and not loaded
if (isset($_SESSION['user']) && !isset($_SESSION['user']['can_create'])) {
    $role_id = intval($_SESSION['user']['role_id']);
    $q = $conn->query("SELECT * FROM user_roles WHERE id = $role_id LIMIT 1");
    if ($q && $q->num_rows === 1) {
        $_SESSION['user'] = array_merge($_SESSION['user'], $q->fetch_assoc());
    }
}

// Fetch articles
$sql = "SELECT id, title, category, short_description 
        FROM articles 
        ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        h1 {
            margin-bottom: 15px;
        }
        .top-bar {
            margin-bottom: 20px;
        }
        .top-bar a {
            display: inline-block;
            padding: 8px 14px;
            text-decoration: none;
            margin-right: 10px;
            border-radius: 4px;
            font-weight: bold;
            colour: #fff;
        }
        .btn-add { background: #28a745; }
        .btn-login { background: #007bff; }
        .btn-logout { background: #dc3545; }
        .btn-register { background: #6c757d; }

        .article {
            background: #fff;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }
        .article h2 {
            margin: 0;
            font-size: 22px;
            colour: #333;
        }
        .category {
            font-size: 14px;
            colour: #888;
            margin: 6px 0;
        }
        .description {
            font-size: 15px;
            margin-bottom: 10px;
        }
        a.read-more {
            text-decoration: none;
            colour: #0066cc;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Article List</h1>

<div class="top-bar">
    <?php if (isset($_SESSION['user'])): ?>

        <?php if ($_SESSION['user']['can_create'] == 1): ?>
            <a href="article_form.php" class="btn-add">+ Add Article</a>
        <?php endif; ?>

        <a href="logout.php" class="btn-logout">Logout</a>

    <?php else: ?>
        <a href="login.php" class="btn-login">Login</a>
        <a href="register.php" class="btn-register">Register</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['deleted'])): ?>
    <p style="colour: green; font-weight: bold;">Article deleted successfully.</p>
<?php endif; ?>

<?php
if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
?>
        <div class="article">
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>

            <div class="category">
                Category: <?php echo htmlspecialchars($row['category']); ?>
            </div>

            <div class="description">
                <?php echo htmlspecialchars($row['short_description']); ?>
            </div>

            <a class="read-more" href="article.php?id=<?php echo $row['id']; ?>">
                Read more →
            </a>

            <?php if (isset($_SESSION['user'])): ?>
                <br><br>

                <?php if ($_SESSION['user']['can_update'] == 1): ?>
                    <a href="article_form.php?id=<?php echo $row['id']; ?>">Edit</a>
                <?php endif; ?>

                <?php if ($_SESSION['user']['can_delete'] == 1): ?>
                    <?php if ($_SESSION['user']['can_update'] == 1): ?> | <?php endif; ?>
                    <a href="delete_article.php?id=<?php echo $row['id']; ?>"
                       onclick="return confirm('Delete this article?');">
                        Delete
                    </a>
                <?php endif; ?>

            <?php endif; ?>
        </div>
<?php
    endwhile;
else:
?>
    <p>No articles found.</p>
<?php endif; ?>

</body>
</html>