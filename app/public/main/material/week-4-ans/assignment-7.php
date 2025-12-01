<?php
function removeValue($array, $value) {
    return array_values(array_diff($array, [$value]));
}

$array = [1, 2, 3, 4, 2, 5];
$valueToRemove = 2;

$result = removeValue($array, $valueToRemove);

echo "Original array: [" . implode(", ", $array) . "]\n";
echo "Array after removing $valueToRemove: [" . implode(", ", $result) . "]";
?>