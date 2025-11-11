<?php

// Define 'existingCustomers' array with names of existing customers.
$existingCustomers = ["Alice", "Bob"];

// Define 'newCustomers' array with names of new customers.
$newCustomers = ["Charlie", "David"];

// Use 'array_merge' to combine both arrays into a single array.
$allCustomers = array_merge($existingCustomers, $newCustomers);

// Display the list of all customers using 'implode' to join names with commas.
echo "Customers: " . implode(", ", $allCustomers);
