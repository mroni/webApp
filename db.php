<?php

//db設定ファイルの読み込み
require_once "../../config/database.php";


//データベースへ接続する
function connect()
{
	try
	{
		$pdo = new PDO("mysql:host=localhost;dbname=".DBNAME.";",USER,PASSWORD);

		//バッファードクエリを使用する
		$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); 
		
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


	//影響した行が1個以上あれば成功
	if($stmt->rowCount() > 0)
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

