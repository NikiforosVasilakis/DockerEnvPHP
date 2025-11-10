<?php
// Declare an array with the given numbers
$numbers = [4, 8, 15, 16, 23, 42];

// Calculate the sum of the numbers using array_sum function
$sum = array_sum($numbers);

// Count the total number of elements in the array using count function
$count = count($numbers);

// Calculate the average by dividing the sum by the count of elements
$average = $sum / $count;

// Display the average
echo "The average is: " . $average;
