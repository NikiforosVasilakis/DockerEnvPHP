<?php

// Declare an email variable with a valid email format.
$email = "user@example.com";

// Declare an invalid email variable to test the validation function.
$invalidEmail = "user@invalid";

// Use 'filter_var' with 'FILTER_VALIDATE_EMAIL' to check if '$email' is a valid email format.
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Display "Email is valid" if the format is correct.
    echo "Email is valid.<br>";
} else {
    // Display "Email is invalid" if the format is incorrect.
    echo "Email is invalid.<br>";
}

// Validate the second email variable 'invalidEmail' similarly.
if (filter_var($invalidEmail, FILTER_VALIDATE_EMAIL)) {
    echo "Email is valid.<br>";
} else {
    echo "Email is invalid.<br>";
}
