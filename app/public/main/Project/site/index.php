<?php
$host = 'db';
$username = 'root';
$password = 'rootpass';

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error){
    die("connection failed ". $conn-> connection_error);
}

?>
