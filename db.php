<?php

//db設定ファイルの読み込み
require_once "database.php";

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
	$res = $stmt->rowCount();
	if($res > 0)
		return true;
	else
		return false;
}


//引数にマッチしたかどうかを返す
function select($sql , $arg = array())
{
	$pdo = connect();
	$stmt = $pdo->prepare($sql);

	$res = $stmt->execute($arg);
	$res = $stmt->fetchAll();
	//var_dump($res);
	var_dump($stmt->rowCount());
	exit;

	/*
	if($stmt->rowCount($res) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
	//*/
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


//$sql = 'insert into user (userName , userPassword ,created_at ) values ( ? , ? , now())';
$sql = 'select * from user where userName = ? and userPassword = ?';
$arg = array('tet2' , 'test');


var_dump(select($sql,$arg));


