<?php
// Function that removes empty lines from a string
function removeEmptyLines($text) {
    // Split the text by newlines, filter out empty lines, and rejoin
    $lines = explode("\n", $text);
    $nonEmptyLines = array_filter($lines, 'trim'); // Remove lines that are empty or whitespace only
    return implode("\n", $nonEmptyLines); // Join the remaining lines
}
