<?php

session_start();

//データベース関係の関数を読み込む
require_once "util.php";

/*------------------------------------------------
	ログインをチェックする処理
------------------------------------------------*/

$userName     = $_POST['userName'];
$userPassword = $_POST['userPassword'];


//IDとパスワードが合っているか照合する
$flag = loginCheck($userName , $userPassword);


//ホスト名とファイルのディレクトリを変数に格納
$host =  $_SERVER['HTTP_HOST'];
$dir  = dirname($_SERVER['PHP_SELF']);


if(!$flag)
{
	//エラーメッセージを渡す
	$_SESSION['errorMsg'] = 'ユーザ名またはパスワードが間違っています。';

	//ログイン失敗したらhome.phpへ遷移
	header("Location: http://$host$dir/index.php");
	exit;
}

else
{
	//ログイン成功したらセッションにユーザIDを登録し、home.phpへ遷移
	unset($_SESSION['errorMsg']);
	$_SESSION['userName'] = $userName;
	header("Location: http://$host$dir/home.php");
	exit;
}
?>
