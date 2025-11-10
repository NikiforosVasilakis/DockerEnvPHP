<?php
//$favcolor = "red";
$favcolor = $_POST['color'];
switch ($favcolor) {
    case "red":
        echo "Το αγαπημένο σου χρώμα είναι red!";
        break;
    case "blue":
        echo "Το αγαπημένο σου χρώμα είναι blue!";
        break;
    case "green":
        echo "Το αγαπημένο σου χρώμα είναι green!";
        break;
    default:
        echo "Το αγαπημένο σου χρώμα είναι δεν είναι red, blue, ή green!";
} ?>
<?php
echo "<br><a href=switch.html>Ξαναδοκίμασε</a>"
?>
