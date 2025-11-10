<?php
// Declare an array with items. Each item is an associative array with 'name', 'price', and 'quantity'
$items = [
    ["name" => "Item 1", "price" => 10, "quantity" => 5],
    ["name" => "Item 2", "price" => 20, "quantity" => 3],
    ["name" => "Item 3", "price" => 15, "quantity" => 8],
    ["name" => "Item 4", "price" => 25, "quantity" => 2],
    ["name" => "Item 5", "price" => 30, "quantity" => 6],
    ["name" => "Item 6", "price" => 12, "quantity" => 9],
    ["name" => "Item 7", "price" => 18, "quantity" => 4],
    ["name" => "Item 8", "price" => 22, "quantity" => 7],
    ["name" => "Item 9", "price" => 16, "quantity" => 5],
    ["name" => "Item 10", "price" => 28, "quantity" => 3],
    ["name" => "Item 11", "price" => 35, "quantity" => 1],
    ["name" => "Item 12", "price" => 40, "quantity" => 10],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="exercise-1.css">
    <title>Table Example</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the items array and generate each row dynamically
            foreach ($items as $item) {
                echo "<tr>";
                echo "<td>" . $item['name'] . "</td>";
                echo "<td>" . $item['price'] . "</td>";
                echo "<td>" . $item['quantity'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
