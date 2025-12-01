<?php
function isLetter($char) {
    return ctype_alpha($char);
}

$char = 'A';

if (isLetter($char)) {
    echo "'$char' is a letter.";
} else {
    echo "'$char' is not a letter.";
}
?>