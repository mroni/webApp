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
		
		//パスワード変更処理のフラグ
		var passFlag = false;


		//ログイン中のユーザのID
		var userId = <?php echo $_SESSION['userId'];?>;

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

				$(this).hide();

				//セッションのユーザ名変更
			}

			e.preventDefault();

		});



		//パスワード変更のフラグ
		var newPassFlag = false;

		//新パスワードのチェック
		$('#newUserPassword').blur(function()
		{
			//エラー表示領域を消す
			$(this).next().empty();

			if( $(this).val() != '' )
			{
				//文字数を確認
				if($(this).val().length > 20)
				{
					$(this).next().text('パスワードは20文字以下にしてください').css('color','red');
					newPassFlag = false;
				}
				
				//文字列チェック
				else
				{
					if( !($(this).val().match(/^[0-9A-Za-z-_]+$/)) )
					{
						$(this).next().text('パスワードは、アルファベット大文字小文字と数字、-、_のみが使えます').css('color','red');
						newPassFlag = false;
					}

					else
					{
						$(this).next().text('有効なパスワードです').css('color','green');
						newPassFlag = true;
					}
				}
			}
		});


		//新しいパスワードが一致しているかを確認
		$('#confirmNewUserPassword').keyup(function()
		{
			if($(this).val() != $('#newUserPassword').val())	
			{
				$(this).next().text('パスワードが一致しません').css('color','red');
			}
			else
			{
				$(this).next().text('パスワードが一致しました').css('color','green');
			}

		});

		//パスワード入力欄に問題がなければ変更を実施
		$('#modifyPasswordForm').submit(function(e)
		{
			var nowUserPassword = $('#nowUserPassword').val();
			var newUserPassword = $('#newUserPassword').val();
			var confirmNewUserPassword = $('#confirmNewUserPassword').val();
					

			//空文字チェック
			if( !(nowUserPassword != '' && newUserPassword != '' && confirmNewUserPassword != '') )
			{
				newPassFlag = false;

				if(nowUserPassword == '')
				{
					$('#nowUserPassword').next().text('パスワードを入力してください').css('color','red');
				}
				
				if(newUserPassword == '')
				{
					$('#newUserPassword').next().text('新しいパスワードを入力してください').css('color','red');
				}
				
				if(confirmNewUserPassword == '')
				{
					$('#confirmNewUserPassword').next().text('確認用パスワードを入力してください').css('color','red');
				}

				e.preventDefault();

			}

			//文字が入力されていたら
			else
			{
				//確認用パスワードが一致しているか確認
				if( !(newUserPassword == confirmNewUserPassword) )
				{
					$('#confirmNewUserPassword').next().text('パスワードが一致しません').css('color','red');
					newPassFlag = false;
					e.preventDefault();
				}

				//確認用のパスワード一致が確認できたら現在のパスワードが一致してるか確認
				else
				{
					var post = "functionName=checkPassword&userId="+userId+"&password="+nowUserPassword;
	
					$.ajax({
						type:'POST',
						url:"util.php",
						data:post,
						async:false,
						success:function(msg)
						{
							if(!msg)
							{
								$('#nowUserPassword').next().text('パスワードが一致しません。').css('color','red');
								passFlag = false;
							}
							else
							{
								$('#nowUserPassword').next().empty();
								passFlag = true;;
							}	
						}
					});
		
				}


				//すべての条件をクリアしていたらパスワード変更処理を行う
				if(passFlag)
				{
					//POSTで送る値
					var post = "functionname=modifyUserPassword&userId="+userId+"&newUserPassword="+newUserPassword;


					$.ajax({
						type:'post',
						url:"util.php",
						data:post,
						dataType:"text",
						async:false,
						success:function(msg)
						{
							$.notifyBar({
								html: "パスワードを変更しました",
								delay: 2000,
								cls:'success',
								animationSpeed: "normal"
							});
						}
	
					
					});
					
					$(this).hide();
					
				}

			}

			e.preventDefault();
		});


		$('#byeYes').click(function()
		{
			if(confirm("本当に退会してもよろしいですか？"))
			{
				var post = "functionName=deleteUser&userId="+userId;
				$.ajax({
					type:'post',
					url:"util.php",
					data:post,
					async:false,
					success:function(msg)
					{
						alert("退会しました");
						location.href = "index.php";

					}
				});
				
				

			}else
			{
				alert("con");
			}
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
		<input id="nowUserPassword" name="nowUserPassword" type="password" />
		<span></span>	
		<br>

		新しいパスワード<br>
		<input id="newUserPassword" name="newUserPassword" type="password" />
		<span></span>	
		<br>

		確認用パスワード<br>
		<input id="confirmNewUserPassword" name="confirmNewUserPassword" type="password" />
		<span></span>	
		<br>

		<input id="" name="" type="submit" value = "変更"/>
	</form>
</div>

<div id="bye">
<p>退会しちゃうと全部のタスクが消えてしまいます。。本当に退会しますか？</p>
<button id = "byeYes">はい。退会します</button>
</div>




</body>
</html>
