<?php

include "database.php";

$server = 'localhost';
$user = 'root';
$passwd = 'zandilem';
$db = 'camagru_db';
$dsn = "mysql:$server;dbname=$db";

try
{
	$connect = new PDO($dsn, $user, $passwd);
}
catch(PDOException $e)
{
	echo $e;
}
?>
