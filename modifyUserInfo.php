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

	<link rel="stylesheet" href="jquery.notifyBar.css" />

	<script type="text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src = "jquery.notifyBar.js"></script>
	<script type="text/javascript">
	$(function()
	{

		//ユーザ名変更処理のフラグ
		var nameFlag = false;
		var passFlag = false;


		//名前変更・パスワード変更・退会の各フォームを隠しておく
		$('#modifyName , #modifyPassword , #bye').hide();
		$('#toModifyName').click(function()
		{
			$('#modifyName').toggle('middle');
			//$('#modifyName').toggle(
			//function()
			//{
			//	$('#modifyName not(:animated)').show('fast');
			//},
			//function()
			//{
			//	$('#modifyName').toggle();
			//	//$(this).removeClass();
			//});
		});
		
		$('#toModifyPassword').click(function()
		{
			$('#modifyPassword').toggle('middle');
		});

		$('#toBye').click(function()
		{
			$('#bye').toggle('middle');
		});


		//ユーザ名のバリデーション
		$('#newUserName').blur(function()
		{
			//エラー表示領域を消す
			$(this).next().empty();

			if( $(this).val() != '' )
			{
				//文字数を確認
				if($(this).val().length > 10)
				{
					$(this).next().text('ユーザ名は10文字以下にして下さい').css('color','red');
					nameFlag = false;
				}
				
				//文字列チェック
				else
				{
					if( !($(this).val().match(/^[0-9A-Za-z]+$/)) )
					{
						$(this).next().text('ユーザ名は、アルファベット大文字小文字と数字のみが使えます').css('color','red');
						nameFlag = false;
					}

					//ユーザ名の重複チェック
					else
					{
						var name = $(this);
						var post = "functionName=userCheck&userName="+name.val();
						$.ajax({
							type:'POST',
							url:"util.php",
							data:post,
							success:function(msg)
							{
								if(msg)
								{
									
									name.next().text('既に登録されています！').css('color','red');
									nameFlag = false;
								}
								else
								{
							
									name.next().text('登録可能なユーザ名です').css('color','green');
									nameFlag = true;;
						
								}	
							}
						});
					}
				}
			}

		});


		//パスワードの入力チェック
		$('#modifyNameForm').submit(function(e)
		{
			var passArea = $('#userPassword');
			var userId = <?php echo $_SESSION['userId'];?>;
			var password = $('#userPassword').val();
			var post = "functionName=checkPassword&userId="+userId+"&password="+password;

			$.ajax({
				type:'POST',
				url:"util.php",
				data:post,
				async:false,
				success:function(msg)
				{
					if(!msg)
					{
						passArea.next().text('パスワードが一致しません。').css('color','red');
						passFlag = false;
					}
					else
					{
						passArea.next().empty();
						passFlag = true;;
					}	
				}
			});


			//ユーザ名が使用できないもの、またはパスワードが一致しなければ処理しない
			if(nameFlag && passFlag)
			{
				var newUserName = $('#newUserName').val();
				var post2 = "functionName=modifyUserName&userId="+userId+"&newUserName="+newUserName;
				$.ajax({
					type:'POST',
					url:'util.php',
					data:post2,
					success:function(flag)
					{
						$.notifyBar({
						html: "ユーザ名を変更しました",
						delay: 2000,
						cls:'success',
						animationSpeed: "normal"
						});
					}
				});

			}

			e.preventDefault();
			$(this).hide();

		});


	});
	</script>


</head>
<body>
	
<div id="list">
	<ul>
		<li id = "toModifyName">ユーザ名変更</li>
		<li id = "toModifyPassword">パスワード変更</li>
		<li id = "toBye">退会orz</li>
	</ul>
</div>


<div id="modifyName">
	<form id="modifyNameForm" action="">
		新しいのユーザ名<br>
		<input id="newUserName" name="newUserName" type="text" />
		<span></span>	
		<br>
		パスワードを入力してください<br>
		<input id="userPassword" name="userPassword" type="password" />
		<span></span>	
		<br>
		<input type="submit" value = "変更"/>
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

<div id="bye">
<p>退会しちゃうと全部のタスクが消えちゃいます。。本当に退会しますか？</p>
<button>はい。もう未練はないので退会します</button>
<button>やっぱりやめません</button>
</div>




</body>
</html>
