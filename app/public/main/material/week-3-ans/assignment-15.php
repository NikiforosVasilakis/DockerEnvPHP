<?php

// Define 'names' array with unsorted names.
$names = ["Charlie", "Alice", "Bob"];

// Use 'sort' to sort the names in alphabetical order.
sort($names);

// Use 'implode' to join the sorted names into a single string, separated by commas.
echo implode(", ", $names);
