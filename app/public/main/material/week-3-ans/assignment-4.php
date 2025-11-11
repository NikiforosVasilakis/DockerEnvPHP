<?php

// Define 'firstName' with mixed-case characters.
$firstName = "joHn";

// Define 'fullName' with mixed-case characters for first and last names.
$fullName = "john doE";

// Use 'ucfirst' to capitalize the first letter of 'firstName' after converting it to lowercase.
echo "First Name: " . ucfirst(strtolower($firstName)) . "<br>";

// Use 'ucwords' to capitalize the first letter of each word in 'fullName' after converting it to lowercase.
echo "Full Name: " . ucwords(strtolower($fullName));
