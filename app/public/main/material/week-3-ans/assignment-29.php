<?php

// Define 'productCode' with a specific format of "XXX-XXXXX".
$productCode = "ELE-12345";

// Define a regular expression pattern to match "XXX-XXXXX" format.
$pattern = "/^([A-Z]{3})-(\\d{5})$/";

// Use 'preg_match' to check if the product code matches the pattern.
if (preg_match($pattern, $productCode, $matches)) {
    // Extract the category (first part) of the product code.
    $category = $matches[1];
    // Extract the code (second part) of the product code.
    $code = $matches[2];
    
    // Display the category and product code parts separately.
    echo "Category: $category<br>";
    echo "Product Code: $code";
} else {
    // Display an error if the product code format is invalid.
    echo "Invalid product code format.";
}
