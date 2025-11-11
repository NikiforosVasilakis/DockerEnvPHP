<?php

// Define 'product' associative array with product details.
$product = ["name" => "Laptop", "price" => 1200];

// Use 'json_encode' to convert the array into a JSON string.
$json = json_encode($product);

// Display the JSON string.
echo "JSON: $json<br>";

// Decode the JSON string back into an associative array.
$decodedProduct = json_decode($json, true);

// Display the 'name' from the decoded array.
echo "Decoded Name: " . $decodedProduct["name"];
