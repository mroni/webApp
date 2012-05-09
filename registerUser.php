<?php

//db制御ファイルの読み込み
require_once "db.php";

$userName = $_POST['userName'];
$userPassword = $_POST['userPassword'];

$arg = array($,'sadfjk');
$sql = "insert into user (userName , userPassword , created_at ) values (?,?,now())";

insert($sql,$arg);

