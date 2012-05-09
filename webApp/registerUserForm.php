<?php

require_once "/../../config/database.php";

try
{
	$pdo = new PDO("mysql:host=localhost;dbname=webApp;'webapp','training'");
}catch(PDOException $e)
{
	var_dump($e->getMessage();
}


$pdo = null;
