<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ajaxのテスト</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function()
	{
		$('button').click(function()
		{
			var arg1 = 5;
			var post_data = "fnc_name=test1&arg="+arg1;
			$.ajax({
				type:'POST',
				url:"ajax_test.php",
				data:post_data,
				success:function(msg)
				{
					alert(msg);
				}
			});
		});
	})
	</script>
</head>
<body>

<button>test</button>

</body>
</html>
