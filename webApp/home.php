<?php


//ログインに成功しているのでセッションIDを発行する
session_start();

//ホスト名とファイルのディレクトリを変数に格納
$host =  $_SERVER['HTTP_HOST'];
$dir  = dirname($_SERVER['PHP_SELF']);


//ログインしてなければindex.phpへ遷移させる
if(isset($_SESSION['userNmae'])
{
	header("Location: $host$dir/index.php");
	exit;
}


//ユーザ名を格納
$user = $_SESSION['userNmae'];


//自身の登録してるタスクを一覧取得

$taskLists;


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>HOME</title>
</head>
<body>

<ul class="header">
	<li>
		<a href="">ユーザ情報変更</a>
	</li>
	<li>
		<a href="logout.php">Logout</a>
	</li>
</ul>


<a href="addNewTask.php">新しいタスクを登録する</a>


<!-- 更新があった分を表示する 将来的 -->
<div class="newTak"></div>


<div class="content">
	<?php 
	//登録しているタスクの分だけ表示する
	foreach($taskLists as $taskList)
	{

	?>
		<p><?php echo htmlspecialchars($taskList['userName']);?></p> 
		<p><?php echo htmlspecialchars($taskList['title']);?></p> 
		<p><?php echo htmlspecialchars($taskList['contents']);?></p>

	<?php
	//foreachの終了
	}
	?>
</div>


</body>
</html>
