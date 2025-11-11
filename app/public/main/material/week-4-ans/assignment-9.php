<?php
// Function that returns the maximum value in an array
function findMaxInArray($array) {
    $max = $array[0]; // Assume the first element is the largest initially
    foreach ($array as $value) { // Loop through each element
        if ($value > $max) { // Update max if a larger value is found
            $max = $value;
        }
    }
    return $max; // Return the largest value
}
