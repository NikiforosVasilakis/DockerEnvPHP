<?php
function removeEmptyLines($text) {
    $lines = explode("\n", $text);
    $nonEmptyLines = array_filter($lines, 'trim'); 
    return implode("\n", $nonEmptyLines);
}

$text = "This is line 1.\n\nThis is line 2.\n\n\nThis is line 3.";

$result = removeEmptyLines($text);

echo "Original text:\n$text\n\n";
echo "Text after removing empty lines:\n$result";
?>