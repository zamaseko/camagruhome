<?php
$server = 'localhost';
$username = 'root';
$db = 'camagru';
$password = 'zandilem';
try
{
	$dsn = "mysql:host=$server;dbname=. $db";
	$connect = new pdo($dsn, $user, $password);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo 'Connection to database is successfull';
}
catch(PDOException $e)
{
	echo 'Connection failed';
}
?>
