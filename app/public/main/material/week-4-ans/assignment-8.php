<?php
// Function that returns an array with the common elements of two arrays
function arrayIntersection($array1, $array2) {
    // Use array_intersect to find common elements and array_values to reindex
    return array_values(array_intersect($array1, $array2));
}
