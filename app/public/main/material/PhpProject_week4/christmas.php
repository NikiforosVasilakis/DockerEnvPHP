<?php
$d1=strtotime("December 25");
$d2=ceil(($d1-time())/60/60/24);
echo "Μένουν " . $d2 ." μέχρι τα Χριστούγεννα.";
?>
