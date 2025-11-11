<?php

// Define 'productName' with spaces between words.
$productName = "Super Cool Product";

// Use 'str_replace' to replace spaces with hyphens to make the name URL-friendly.
echo "URL Friendly: " . str_replace(" ", "-", $productName);
