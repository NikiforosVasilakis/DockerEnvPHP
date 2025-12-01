<?php
function absoluteValue($number) {
    return ($number < 0) ? -$number : $number;
}

$number = -42;

$abs = absoluteValue($number);

echo "The absolute value of $number is $abs.";
?>