<?php
// Function that doubles each element in an array
function doubleArrayValues($array) {
    foreach ($array as &$value) { // Use a reference to modify each value directly
        $value *= 2; // Double the value
    }
    return $array; // Return the modified array
}
