<?php
function isUppercase($char) {
    return ctype_upper($char);
}

$char = 'G';

if (isUppercase($char)) {
    echo "'$char' is an uppercase letter.";
} else {
    echo "'$char' is not an uppercase letter.";
}
?>