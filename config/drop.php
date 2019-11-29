<?php
include 'database.php';
try
{
    $dsn = "mysql:host=$server;dbname=$db";
    $connect = new pdo($dsn, $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dsql = "DROP DATABASE camagru_db";
    $connect->exec($dsql);
    echo 'Database has been deleted';
}
catch(PDOException $e)
{
    echo $e;
}
?>