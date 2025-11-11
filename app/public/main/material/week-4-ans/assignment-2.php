<?php
// Function that checks if a character is alphabetical
function isLetter($char) {
    // Use ctype_alpha to check if the character is a letter
    return ctype_alpha($char);
}
