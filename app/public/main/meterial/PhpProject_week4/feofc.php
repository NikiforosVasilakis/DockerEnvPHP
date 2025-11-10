<?php
$myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
// Προβολή ενός χαρακτήρα έως το end-of-file
while(!feof($myfile)) {
  echo fgetc($myfile);
  echo "-";
}
fclose($myfile);
?>


