<?php
function doubleArrayValues($array) {
    foreach ($array as &$value) { 
        $value *= 2;
    }
    return $array;
}

$numbers = [1, 2, 3, 4, 5];

$doubled = doubleArrayValues($numbers);

echo "Original array: [" . implode(", ", $numbers) . "]\n";
echo "Doubled array: [" . implode(", ", $doubled) . "]";
?>