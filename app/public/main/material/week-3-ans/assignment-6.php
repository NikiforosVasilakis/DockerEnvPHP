<?php

// Define a variable 'userInput' with a sample text string.
$userInput = "This is a sample text that may or may not exceed the character limit.";

// Display the character count of 'userInput' using 'strlen'.
echo "Character count: " . strlen($userInput);

// Check if 'userInput' exceeds 200 characters.
if (strlen($userInput) > 200) {
    // Display a message indicating the character limit has been exceeded.
    echo "<br>Your input exceeds the 200-character limit.";
}
