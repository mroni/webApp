<?php

//セッションの初期化
session_start();

//すべてのセッションを破壊する
$_SESSION = array();

//セッションを切断するために、セッションクッキーも削除します。
if(isset($_COOKIE[session_name()]))
{
	setcookie(session_name() , '' , time() -42000 );
}

//最終的にセッション破壊
session_destroy();

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ログアウト完了</title>
</head>
<body>

<p>ログアウト完了しました。</p>

<a href="index.php">ログイン画面へ戻る</a>
	
</body>
</html>
