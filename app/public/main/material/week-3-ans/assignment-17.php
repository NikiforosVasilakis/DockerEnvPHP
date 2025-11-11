<?php

// Define 'items' array with some duplicate items.
$items = ["Apple", "Banana", "Apple", "Orange"];

// Use 'array_unique' to remove duplicates, keeping only unique items.
$uniqueItems = array_unique($items);

// Display the unique items using 'implode' to join them with commas.
echo "Unique Items: " . implode(", ", $uniqueItems);
