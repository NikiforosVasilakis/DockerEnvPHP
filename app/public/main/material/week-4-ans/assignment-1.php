<?php
function findMax($num1, $num2) {
    return ($num1 > $num2) ? $num1 : $num2;
}

$num1 = 10;
$num2 = 25;

$max = findMax($num1, $num2);

echo "The maximum between $num1 and $num2 is: $max";
?>