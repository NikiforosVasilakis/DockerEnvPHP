<?php
// Function that returns an array with numbers from 1 to N
function createSequence($N) {
    $sequence = []; // Initialize an empty array
    // Loop from 1 to N and add each number to the array
    for ($i = 1; $i <= $N; $i++) {
        $sequence[] = $i;
    }
    return $sequence; // Return the resulting array
}
