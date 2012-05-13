<?php

require_once "db.php";


if(isset($_POST['functionName']))
{

	//ユーザの重複チェック
	if( $_POST['functionName'] == 'userCheck' )
	{
		$res = $_POST['functionName']($_POST['userName']);
		echo $res;
	}

	//パスワードの確認
	else if( $_POST['functionName'] == 'checkPassword')
	{
		$res = $_POST['functionName']($_POST['userId'] , $_POST['password']);
		echo $res;
	}

	//ユーザ名変更
	else if( $_POST['functionName'] == 'modifyUserName' )
	{
		$res = $_POST['functionName']($_POST['userId'] , $_POST['newUserName']);
		echo $res;
	}


	//パスワードの更新
	else if( $_POST['functionName'] == 'modifyUserPassword')
	{
		$res = $_POST['functionName']($_POST['userId'] , $_POST['newUserPassword']);
		echo false;
	}


	//退会する
	else if( $_POST['functionName'] == 'deleteUser')
	{
		$_POST['functionName']($_POST['userId']);
	}
}


//IDとパスワードが合っているか照合する
function loginCheck($userName , $userPassword)
{
	$sql = "select * from  user where userName = ? and userPassword = ? ";
	$arg = array($userName,$userPassword);
	
	$flag = select($sql,$arg);
	return $flag;
}


//ユーザのIDを検索する
function returnUserId($userName)
{
	$sql = "select userId from user where userName = ?";
	$arg = array($userName);

	$userId = return_select($sql,$arg);

	return $userId[0]['userId'];
}


//自身の登録してるタスクを一覧取得
function returnTasks($userId)
{
	$sql = "select id ,userName , title , content , task.created_at , task.updated_at  from user , task where user.userId = ? and user.userId = task.userId;";
	$arg = array($userId);

	$result = return_select($sql,$arg);
	return $result;
}

//新しくタスクを登録する
function addNewTask($userId , $title , $content)
{
	$sql = "insert into task (userId , title , content , created_at) values ( ? , ? , ? , now())";
	$arg = array($userId , $title , $content);


	$result = insert($sql , $arg);

	return $result;
}


//新しいユーザを登録する
function addNewUser($userName , $userPassword)
{

	$sql = "insert into user (userName , userPassword , created_at ) values (?,?,now())";
	$arg = array($userName , $userPassword);

	$result = insert($sql , $arg);

	return $result;
}


//ユーザ名を変更する
function modifyUserName($userId , $newUserName)
{
	$sql = "update user set userName = ? where userId = ?";
	$arg = array($newUserName , $userId);
	
	$result = insert($sql , $arg);
	return $result;
}


//パスワードを変更する
function modifyUserPassword($userId , $newUserPassword)
{
	$sql = "update user set userPassword = ? where userId = ?";
	$arg = array($newUserPassword , $userId);
	
	$result = insert($sql , $arg);
	return $result;
}


//退会する
function deleteUser($userId)
{
	$sql = "delete from user where userId = ?";
	$arg = array($userId);
	
	$result = insert($sql , $arg);
}


//ユーザの重複チェック
function userCheck($userName)
{
	$sql = "select * from user where userName = ?";
	$arg = array($userName);

	$result = select($sql , $arg);
	return $result;
}


//ユーザのパスワードチェック
function checkPassword($userId,$password)
{
	$sql = "select * from user where userId = ? and userPassword = ?";
	$arg = array($userId , $password);

	$result = select($sql, $arg);
	return $result;
}



