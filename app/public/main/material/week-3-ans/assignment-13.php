<?php

// Define 'username' with valid characters only.
$username = "JohnDoe";

// Define 'invalidUsername' with an invalid '@' character.
$invalidUsername = "John@Doe";

// Use 'strpos' to check if '@' is not found in 'username' (returns false if not found).
if (strpos($username, "@") === false) {
    // Display "Username is valid" if it does not contain '@'.
    echo "Username is valid.<br>";
} else {
    // Display "Username contains invalid characters" if it does contain '@'.
    echo "Username contains invalid characters.<br>";
}

// Check 'invalidUsername' similarly.
if (strpos($invalidUsername, "@") === false) {
    echo "Username is valid.<br>";
} else {
    echo "Username contains invalid characters.<br>";
}
