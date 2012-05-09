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
		$('#registerUserForm').submit(function(e)
		{
			var userName = $("#newUserName").val();
			var userPassword = $("#newUserPassword").val();

			alert(userPassword);
			e.preventDefault();


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


<div id = "login">
	<form id = "loginForm" action="logincheck.php" method = "post">
		<input id="userName" name="userName" type="text" /><br>
		<input id="userPassword" name="userPassword" type="password" />
		<input type="submit" value="ログイン" />
	</form>
</div>

<div id="registerUser">
	<ul class = 'errorMsg'></ul>

	<form id = "registerUserForm" method="post" action="registerUser.php">
		<input id="newUserName" name="userName" type="text" /><br>
		<input id="newUserPassword" name="userPassword" type="password" />
		<input type="submit" value="登録する" />
	</form>
</div>
</body>
</html>


