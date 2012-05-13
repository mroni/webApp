<?php

session_start();

//db制御ファイルの読み込み
require_once "util.php";

//ホスト名とファイルのディレクトリを変数に格納
$host =  $_SERVER['HTTP_HOST'];
$dir  = dirname($_SERVER['PHP_SELF']);

//正規ページからのアクセスでなければindex.phpへ遷移させる
if( $_POST['sesid'] != session_id())
{
		header("Location: http://$host$dir/index.php");
	exit;
}

//新規にユーザを登録する
addNewUser($_POST['newUserName'] , $_POST['newUserPassword']);

//セッションにユーザIDを格納する
$_SESSION['userName'] = $_POST['newUserName'];

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>会員登録完了</title>

	

</head>
<body>

<p>会員登録が完了しました</p>

<a href="home.php">ホーム画面へ行く</a>

</body>
</html>
