
<?php
$myfile = fopen("newfile.txt", "r") or die("Unable to open file!");
echo "Οι επισκέψεις στην σελίδα είναι: ".fread($myfile,filesize("newfile.txt"));
$count=fread($myfile,filesize("newfile.txt"));
$myfile = fopen("newfile.txt", "w+") or die("Unable to open file!");
echo fread($myfile,filesize("newfile.txt"));
$txt = $count+1;
fwrite($myfile, $txt);
fclose($myfile);

?>
