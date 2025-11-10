<?php
$myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
// δείξε κάθε γραμμή μέχρι το end-of-file
while(!feof($myfile)) {
  echo fgets($myfile) . "<br>";
}
fclose($myfile);
?>

