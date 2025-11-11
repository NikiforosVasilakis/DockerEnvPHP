<?php

// Define a string 'tags' with multiple tags separated by commas.
$tags = "PHP, Web Development, Coding";

// Use 'explode' to split the string into an array using ", " as the delimiter.
$tagArray = explode(", ", $tags);

// Display each tag in the array on a new line with a bullet point.
echo "Tags:<br>";
foreach ($tagArray as $tag) {
    echo "- $tag<br>";
}
