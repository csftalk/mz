<?php

include '../conn.php';
$sid = $_POST['sid'];
$text = $_POST['text'];
$whatid = $sid;
$sql = "insert into mz_talk (whatid,role,text) values ('{$whatid}', 's', '{$text}')";
$res = mysqli_query($link,$sql);
if ($res) {
	echo 'ok';die;
} else {
	echo 'fail';die;
}
