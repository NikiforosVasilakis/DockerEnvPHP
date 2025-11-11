<?php

// Define 'productCode' with a sample code that includes a category prefix.
$productCode = "ELE12345";

// Use 'substr' to extract the first 3 characters from 'productCode' as the category.
echo "Category: " . substr($productCode, 0, 3);
