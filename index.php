<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>

	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>webApp</title>
	<link rel="stylesheet" href="style.css" />

	<script type="text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script type="text/javascript">
	$(function()
	{
		var registerFlag =  false;


		//ユーザ名の重複チェック　
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
					registerFlag = false;
				}
				
				//文字列チェック
				else
				{
					if( !($(this).val().match(/^[0-9A-Za-z]+$/)) )
					{
						$(this).next().text('ユーザ名は、アルファベット大文字小文字と数字のみが使えます').css('color','red');
						registerFlag = false;
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
									registerFlag = false;
								}
								else
								{
							
									name.next().text('登録可能なユーザ名です').css('color','green');
									registerFlag = true;;
						
								}	
							}
						});
					}
				}
			}
		});

		//パスワードの正規表現チェック
		$('#newUserPassword').blur(function()
		{
			//エラー表示領域を消す
			$(this).next().empty();

			if( $(this).val() != '')
			{
				//文字数を確認
				if($(this).val().length > 20)
				{
					$(this).next().text('パスワードは20文字以下にして下さい').css('color','red');
					registerFlag = false;
				}
				
				//文字列チェック
				else
				{
					if( !($(this).val().match(/^[0-9A-Za-z-_]+$/)) )
					{
						$(this).next().text('パスワードは、アルファベット大文字小文字と数字、-、_のみが使えます').css('color','red');
						registerFlag = false;
					}

					else
					{
						$(this).next().text('有効なパスワードです').css('color','green');
						registerFlag = true;
					}
				}
			}
			
		
		});

		//パスワードが一致しているか確認
		$('#confirmNewUserPassword').keyup(function()
		{
			if($(this).val() != $('#newUserPassword').val())	
			{
				$(this).next().text('パスワードが一致しません').css('color','red');
				registerFlag = false;
			}
			else
			{
				$(this).next().text('パスワードが一致しました').css('color','green');
				registerFlag = true;
			}

		});

		//サブミットボタンが押された時の処理(空文字ないかandパスワード一致してるか)
		$('#registerUserForm').submit(function(e)
		{
			var newUserName = $('#newUserName').val();
			var newUserPassword = $('#newUserPassword').val();
			var confirmNewUserPassword = $('#confirmNewUserPassword').val();
					

			//空文字チェック
			if( !(newUserName != '' && newUserPassword != '' && confirmNewUserPassword != '') )
			{
				registerFlag = false;

				if(newUserName == '')
				{
					$('#newUserName').next().text('ユーザ名を入力してください').css('color','red');
				}
				
				if(newUserPassword == '')
				{
					$('#newUserPassword').next().text('パスワードを入力してください').css('color','red');
				}
				
				if(confirmNewUserPassword == '')
				{
					$('#confirmNewUserPassword').next().text('確認用パスワードを入力してください').css('color','red');
				}
				e.preventDefault();

			}

			//パスワードが一致しているか確認
			else
			{
				if( !(registerFlag && (newUserPassword == confirmNewUserPassword)) )
				{
					$('#confirmNewUserPassword').next().text('パスワードが一致しません').css('color','red');
					registerFlag = false;
					e.preventDefault();
				}
			}
			
					
		});
		
	})
	
	</script>
</head>
<body>

<div class="header"></div>


<div class = "container">
	<div id = "login">
		<ul class = 'errorMsg'>
		<?php
			echo @$_SESSION['errorMsg'];
		?>
		</ul>
	
		<form id = "loginForm" action="logincheck.php" method = "post">
			ユーザID：<input id="userName" name="userName" type="text" /><br>
			パスワード：<input id="userPassword" name="userPassword" type="password" />
			<br>
			<input type="submit" value="ログイン" />
		</form>
	</div>
	
	<div id="registerUser">
		
		<p>登録がまだの方はこちら</p>
		<form id = "registerUserForm" method="post" action="registerUser.php">
			ユーザ名：<input id="newUserName" name="newUserName" type="text" />
			<span></span>
			<br>
	
			パスワード:<input id="newUserPassword" name="newUserPassword" type="password" />
			<span></span>
			<br>
	
			パスワード(確認用)<input id="confirmNewUserPassword" name="confirmNewUserPassword" type="password" />
			<span></span>
			<br>
			<input name="sesid" type="hidden" value = "<?php echo session_id();?>">
	
			<input type="submit" value="登録する" />
		</form>
	</div>
</div>
</body>
</html>


