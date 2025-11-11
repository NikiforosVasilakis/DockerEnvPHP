<?php
// Function that removes a specific value from an array
function removeValue($array, $value) {
    // Use array_diff to create a new array excluding the specified value
    return array_values(array_diff($array, [$value]));
}
