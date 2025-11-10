<?php
$age = array("Petros"=>"35", "Yiannis"=>"37", "Nikos"=>"43");
krsort($age);

foreach($age as $x => $x_value) {
    echo "Key=" . $x . ", Value=" . $x_value;
    echo "<br>";
}
?>

