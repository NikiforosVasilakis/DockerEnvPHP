<?php

// Define a variable 'userInput' with a sample text string.
$userInput = "This is a sample text that may or may not exceed the character limit.";

// Display the word count of 'userInput' using 'str_word_count'.
echo "Word count: " . str_word_count($userInput);

// Check if 'userInput' exceeds 20 words.
if (str_word_count($userInput) > 20) {
    // Display a message indicating the word limit has been exceeded.
    echo "<br>Your input exceeds the 20-word limit.";
}
