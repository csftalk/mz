<?php
include '../conn.php';
session_start();
$sid = $_SESSION['adminInfo']['id'];
$sql = "select * from mz_online where sid = {$sid}";
$rs = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($rs);
if ($row) {
	$sql = "update mz_online set status = 1,uid = 0 where sid = {$sid}";
	$res = mysqli_query($link,$sql);
} else {
	$sql = "insert into mz_online (sid,status) values ({$sid}, 1)";
	$res = mysqli_query($link,$sql);
}

if ($res) {
	echo 'ok';die;
} else {
	echo 'fail';die;
}