<?php


$res = $_POST['fnc_name'];

$res2 = $_POST['fnc_name']($_POST['arg']);

echo $res2;
function test1($arg1)
{
	$res = $arg1 + 3;
	return $res;
}


