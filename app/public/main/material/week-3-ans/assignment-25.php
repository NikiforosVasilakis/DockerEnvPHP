<?php

// Define an array 'questions' with various quiz questions.
$questions = ["What is PHP?", "Explain arrays.", "What is a function?", "Define a variable."];

// Use 'shuffle' to randomize the order of the questions in the array.
shuffle($questions);

// Display each question in the randomized order with a bullet point.
echo "Questions (Random Order):<br>";
foreach ($questions as $question) {
    echo "- $question<br>";
}
