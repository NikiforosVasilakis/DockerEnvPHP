<?php
$age = (int)$_GET['age'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Age Check</title>
</head>
<body>
    <h2>Age Check</h2>
    <p>
        <?php
        if ($age >= 18) {
            echo "You are an adult.";
        } else {
            echo "You are not an adult.";
        }
        ?>
    </p>
</body>
</html>
