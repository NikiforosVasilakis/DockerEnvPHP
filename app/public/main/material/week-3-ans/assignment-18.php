<?php

// Define 'cart' array with a list of items.
$cart = ["Apple", "Banana", "Orange"];

// Define 'item' to check if it exists in the cart.
$item = "Banana";

// Use 'in_array' to check if 'item' is in 'cart'.
if (in_array($item, $cart)) {
    // Display that the item is in the cart if found.
    echo "$item is in the cart.";
} else {
    // Display that the item is not in the cart if not found.
    echo "$item is not in the cart.";
}
