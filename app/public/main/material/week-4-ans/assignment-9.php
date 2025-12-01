<?php
function findMaxInArray($array) {
    $max = $array[0]; 
    foreach ($array as $value) { 
        if ($value > $max) { 
            $max = $value;
        }
    }
    return $max;
}

$array = [3, 7, 2, 9, 4];

$maxValue = findMaxInArray($array);

echo "Array: [" . implode(", ", $array) . "]\n";
echo "Maximum value in the array: $maxValue";
?>