<?php

// Define 'product' associative array with product details.
$product = ["name" => "Laptop", "price" => 1200];

// Use 'array_keys' to get all keys and 'implode' to display them as a comma-separated string.
echo "Keys: " . implode(", ", array_keys($product)) . "<br>";

// Use 'array_values' to get all values and 'implode' to display them as a comma-separated string.
echo "Values: " . implode(", ", array_values($product));
