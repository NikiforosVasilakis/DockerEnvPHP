<?php

// Define 'userInput' containing HTML tags and text.
$userInput = "<h1>Welcome</h1> <p>This is a <b>great</b> day!</p>";

// Use 'strip_tags' to remove all HTML tags from 'userInput'.
$cleanedInput = strip_tags($userInput);

// Display the cleaned input, which contains only plain text.
echo "Cleaned Input: $cleanedInput";
