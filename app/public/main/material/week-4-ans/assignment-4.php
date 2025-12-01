<?php
function createSequence($N) {
    $sequence = [];
    for ($i = 1; $i <= $N; $i++) {
        $sequence[] = $i;
    }
    return $sequence;
}

$N = 7000;

$sequence = createSequence($N);

echo "Sequence from 1 to $N: " . implode(", ", $sequence);
?>