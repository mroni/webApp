<?php

//db設定ファイルの読み込み
require_once "../../config/database.php";

//データベースへ接続する
function connect()
{
	try
	{
		$pdo = new PDO("mysql:host=localhost;dbname=".DBNAME.";",USER,PASSWORD);
		
		return $pdo;
	
			
	}catch(PDOException $e)
	{
		return false;
	}
}


//データを挿入する
function insert($sql,$arg = array())
{
	$pdo = connect();
	$stmt = $pdo->prepare($sql);
	$res = $stmt->execute($arg);
	return $res;

}


//引数にマッチしたかどうかを返す
function select($sql , $arg = array())
{
	$pdo = connect();
	$stmt = $pdo->prepare($sql);

	$res = $stmt->execute($arg);
	$res = $stmt->fetchAll();

	if($stmt->rowCount($res) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}


//引数にマッチした配列を返す
function return_select($sql , $arg = array())
{
	$pdo = connect();
	$stmt = $pdo->prepare($sql);

	$res = $stmt->execute($arg);
	$res = $stmt->fetchAll();

	return $res;
}


