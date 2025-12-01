<?php
function isFibonacci($number) {
    $a = 0; 
    $b = 1; 
    while ($b < $number) {
        $temp = $a + $b; 
        $a = $b; 
        $b = $temp; 
    }
    return $b == $number || $a == $number; 
}

$number = 21; 

if (isFibonacci($number)) {
    echo "$number is a Fibonacci number.";
} else {
    echo "$number is not a Fibonacci number.";
}
?>