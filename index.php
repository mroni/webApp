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
		$('#newUserName').blur(function()
		{
			var post = "functionName=userCheck&userName="+$(this).val();
			$.ajax({
				type:'POST',
				url:"util.php",
				data:post,
				success:function(msg)
				{
					if(msg)
					{
						$('#doubleName').text('既に登録されていますよ！').css('color','red');
					}
					else
					{
						$('#doubleName').text('それなら登録できます').css('color','red');
					}	
				}
			});

		});

		$('#registerUserForm').submit(function(e)
		{
						//var userName = $("#newUserName").val();
			//var userPassword = $("#newUserPassword").val();

			//alert(userPassword);
			//e.preventDefault();


			/*
			$.ajax({
				type:"POST",
				url:"db.php",
				data:"userName="+
			})
			//*/

		});
		
		//var name = $('#newUserName');
		//var password = $('#newUserPassword');

		//name.val('ユーザ名').css('color','gray');
		//password.val('パスワード');

		$('#registerUserForm').submit(function(e)
		{
			//userNameのチェック	
		});
	})
	
	</script>
</head>
<body>

<div id="header"></div>

<div id = "login">
	<ul class = 'errorMsg'>
	<?php
		echo @$_SESSION['errorMsg'];
	?>
	</ul>

	<form id = "loginForm" action="logincheck.php" method = "post">
		<input id="userName" name="userName" type="text" /><br>
		<input id="userPassword" name="userPassword" type="password" />
		<input type="submit" value="ログイン" />
	</form>
</div>

<div id="registerUser">
	
	<div id="doubleName"></div>
	<form id = "registerUserForm" method="post" action="registerUser.php">
		<input id="newUserName" name="newUserName" type="text" /><br>
		<input id="newUserPassword" name="newUserPassword" type="password" />
		<input id="confirmNewUserPassword" name="confirmNewUserPassword" type="password" />
		<input type="submit" value="登録する" />
	</form>
</div>
</body>
</html>


