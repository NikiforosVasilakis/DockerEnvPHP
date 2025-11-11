<?php

// Define a variable 'password' with a sample password string.
$password = "securePassword123";

// Use 'password_hash' to securely hash the password.
// 'PASSWORD_DEFAULT' automatically uses a strong algorithm for hashing.
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Display the hashed password to show its encrypted form.
echo "Hashed Password: " . $hashedPassword;
