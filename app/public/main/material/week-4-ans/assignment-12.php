<?php
// Function that checks if a number is in the Fibonacci sequence
function isFibonacci($number) {
    $a = 0; // Initialize the first Fibonacci number
    $b = 1; // Initialize the second Fibonacci number
    while ($b < $number) { // Continue until the series reaches or exceeds the number
        $temp = $a + $b; // Calculate the next Fibonacci number
        $a = $b; // Update a to the next number
        $b = $temp; // Update b to the new Fibonacci number
    }
    return $b == $number || $a == $number; // Return true if number matches Fibonacci sequence
}
