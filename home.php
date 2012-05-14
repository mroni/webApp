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
	<link rel="stylesheet" href="style.css" />
	
	<script type="text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script type="text/javascript">
	$(function()
	{
		$('#addNewTask').hide();
		
		var flag = false;

		//タスク登録ボタンを押すと出てくる
		$('#addNewTaskToggle').click(function()
		{
			$('#addNewTask').toggle("middle");
		});

		//タイトルの長さチェック
		$('#title').blur(function()
		{
			if($(this).val().length > 20)	
			{
				$(this).next().text('タイトルは20文字以下で入して下さい').css('color','red');
				flag = false;
			}
			else
			{
				$(this).next().empty();
				flag = true;
			}

		});


		//本文の文字数チェック
		$('#content').keyup(function()
		{
			var length = $(this).val().length;

			if(length < 100)
			{
				$(this).prev().prev().text("("+length+"/100)").css('color','black');	
				flag = true;
			}
			else
			{
				$(this).prev().prev().text("内容は100文字以下で入力してください").css('color','red');	
				flag = false;
			}
		});

		//サブミットされた時の処理（空白でないか、文字数は大丈夫か）
		$('#addNewTask').submit(function(e)
		{
			if( $('#content').val() == '')	
			{
				$('#content').prev().prev().text("内容を入力してください").css('color','red');	
				flag = false;
				e.preventDefault();
			}

			//タイトルが空だったら無題とする
			if( $('#title').val() == '')	
			{
				$('#title').val("無題");
			}

			if(!flag)
			{
				e.preventDefault();
			}
		});
	});
	</script>
</head>
<body>

<ul class = "headerInfo">
	<li><?php echo $_SESSION['userName'];?></li>
	<li>
		<a href="modifyUserInfo.php">ユーザ情報変更</a>
	</li>
	<li>
		<a href="logout.php">Logout</a>
	</li>
</ul>

<div id = "new">
	<button id = "addNewTaskToggle">新しいタスクを登録する</button>
	<div id="addNewTask">
		<form id="addNewTaskForm" action="addNewTask.php" method = "post">
			タイトル<br>
			<input id="title" name="title" type="text" size = 40/>
			<span></span>
			<br>
	
	
			タスク内容<span>(0/100)</span>
			<br>
			<textarea id="content" name="content" rows="4" cols="25"></textarea><br>
			<span></span>
			<br>
			<input type="submit" value="登録" />
		</form>
	</div>
</div>


<!-- 更新があった分を表示する 将来的 -->
<div class="newTak"></div>


<div class="content">
	<?php 
	//登録しているタスクの分だけ表示する
	foreach($taskLists as $taskList)
	{

	?>
		<ul class = "taskList">
			<li><?php echo htmlspecialchars($taskList['title']);?></li> 
			<li><?php echo nl2br(htmlspecialchars($taskList['content']));?></li>
			<li><?php echo htmlspecialchars($taskList['created_at']);?></li>
		</ul>

	<?php
	//foreachの終了
	}
	?>
</div>


</body>
</html>
