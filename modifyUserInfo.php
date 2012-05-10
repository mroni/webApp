<?php

session_start();

//データベース関係の関数を読み込む
require_once "util.php";

//ホスト名とファイルのディレクトリを変数に格納
$host =  $_SERVER['HTTP_HOST'];
$dir  = dirname($_SERVER['PHP_SELF']);


//ログインしてなければindex.phpへ遷移させる
if(!isset($_SESSION['userName']))
{
	header("Location: http://$host$dir/index.php");
	exit;
}


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ユーザ情報変更ページ</title>
</head>
<body>
	
<div id="list">
	<ul>
		<li>ユーザ名変更</li>
		<li>パスワード変更</li>
		<li>退会orz</li>
	</ul>
</div>


<div id="modifyName">
	<form id="modifyNameForm" action="">
		新しいのユーザ名<br>
		<input id="newUserName" name="newUserName" type="text" /><br>
		パスワードを入力してください<br>
		<input id="userPassword" name="userPassword" type="password" />
		<br>
		<input id="" name="" type="submit" value = "変更"/>
	</form>
</div>

<div id="modifyPassword">
	<form id="modifyPasswordForm" action="">
		現在のパスワード<br>
		<input id="newUserName" name="newUserName" type="password" /><br>
		新しいパスワード<br>
		<input id="userPassword" name="userPassword" type="password" /><br>
		確認用パスワード<br>
		<input id="userPassword" name="userPassword" type="password" />
		<br>
		<input id="" name="" type="submit" value = "変更"/>
	</form>
</div>

<div id="modifyName">
<p>退会しちゃうと全部のタスクが消えちゃいます。。本当に退会しますか？</p>
<button>はい。もう未練はないので退会します</button>
<button>やっぱりやめません</button>
</div>




</body>
</html>
