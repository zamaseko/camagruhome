<?php
session_start();

if(!isset($_SESSION['user'] || !isset($_SESSION['logged_in'])))
header("Location: login.php");
exit();
else
{
	echo 'Congratulations, You are logged in';
}
?>
