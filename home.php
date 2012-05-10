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


//セッションID固定化攻撃を避けるためにセッションIDを再生成する
session_regenerate_id(true);


//ユーザ名を格納
$userName = $_SESSION['userName'];


//ログイン中のユーザのuserIdを検索
$_SESSION['userId'] = returnUserId($userName);

//自身の登録してるタスクを一覧取得
$taskLists = returnTasks($_SESSION['userId']);


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
		<a href="modifyUserInfo.php">ユーザ情報変更</a>
	</li>
	<li>
		<a href="logout.php">Logout</a>
	</li>
</ul>


<a href="addNewTask.php">新しいタスクを登録する</a>
<div id="addNewTask">
	<form id="addNewTaskForm" action="addNewTask.php" method = "post">
		タイトル<br>
		<input id="title" name="title" type="text" size = 40/><br>
		タスク内容<br>
		<textarea id="content" name="content" rows="4" cols="25"></textarea><br>
		<input type="submit" value="登録" />
	</form>
</div>


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
		<p><?php echo nl2br(htmlspecialchars($taskList['content']));?></p>
		<p><?php echo htmlspecialchars($taskList['created_at']);?></p>

	<?php
	//foreachの終了
	}
	?>
</div>


</body>
</html>
