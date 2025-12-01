<?php
function arrayIntersection($array1, $array2) {
    return array_values(array_intersect($array1, $array2));
}

$array1 = [1, 2, 3, 4, 5];
$array2 = [3, 4, 5, 6, 7];

$intersection = arrayIntersection($array1, $array2);

echo "Array 1: [" . implode(", ", $array1) . "]\n";
echo "Array 2: [" . implode(", ", $array2) . "]\n";
echo "Intersection: [" . implode(", ", $intersection) . "]";
?>