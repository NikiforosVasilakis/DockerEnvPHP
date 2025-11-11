<?php

// Declare a variable 'name' with a potentially unsafe string that includes special characters.
$name = "<John Doe>";

// Declare a variable 'message' with a script injection attempt to demonstrate XSS protection.
$message = "<script>alert('Hacked!');</script>";

// Display the sanitized 'name' using 'htmlspecialchars' to convert special characters to HTML entities.
// This prevents any HTML or JavaScript from being executed in the browser.
echo "Name: " . htmlspecialchars($name) . "<br>";

// Display the sanitized 'message' in a similar way to avoid script execution.
echo "Message: " . htmlspecialchars($message);
