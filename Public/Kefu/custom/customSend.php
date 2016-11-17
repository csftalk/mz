<?php

include '../conn.php';
$uid = $_POST['uid'];
$text = $_POST['text'];
$whatid = $uid;
$sql = "insert into mz_talk (whatid,role,text) values ('{$whatid}', 'u', '{$text}')";
$res = mysqli_query($link,$sql);
if ($res) {
	echo 'ok';die;
} else {
	echo 'fail';die;
}
