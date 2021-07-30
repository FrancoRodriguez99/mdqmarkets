<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'MDQMARKET';

$fra31 = mysqli_connect('localhost', 'root', '', 'MDQMARKET');
if($fra31 === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }


try {
	 $fra30 = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
	die('FAIL:' . $e->getMessage());
}
?>