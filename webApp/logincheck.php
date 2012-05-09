<?php


session_start();

/*------------------------------------------------
	ログインをチェックする処理
------------------------------------------------*/

$flag = false;

//ホスト名とファイルのディレクトリを変数に格納
$host =  $_SERVER['HTTP_HOST'];
$dir  = dirname($_SERVER['PHP_SELF']);


if(!$flag)
{
	//ログイン失敗したらhome.phpへ遷移
	header("Location: $host$dir/index.php");
	exit;
}

else
{
	//ログイン成功したらセッションにユーザIDを登録し、home.phpへ遷移
	$_SESSION['userName'] = $_POST['userName'];
	header("Location: $host$dir/home.php");
	exit;
}
?>
