<?php

// Define a variable 'comment' with an empty string.
$comment = "";

// Check if 'comment' is either unset or empty after trimming spaces.
if (!isset($comment) || empty(trim($comment))) {
    // Prompt the user to enter a comment if the input is empty.
    echo "Please enter a comment.";
} else {
    // Display the sanitized 'comment' if it contains text.
    echo "Comment submitted: " . htmlspecialchars($comment);
}
