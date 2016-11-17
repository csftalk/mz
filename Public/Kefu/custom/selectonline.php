<?php
include '../conn.php';
$uid = $_GET['uid'];
session_start();
$uid = $_SESSION['userInfo']['id'];
$sql = "select * from mz_online where status = 1 and uid = 0 limit 1";
$rs = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($rs);
$res = [];

if ($row) {
	$sql = "update mz_online set uid =  {$uid} where id = {$row['id']} ";
	mysqli_query($link,$sql);
	//$sql = "insert into mz_talk (whatid,role,text) values ({$row['sid']},'s', '主人，您好！！需要什么服务？')";
	// mysqli_query($link,$sql);
	// $sql = "insert into mz_talk (whatid,role,text) values ({$row['sid']},'s', '主人，您好！！需要什么服务？')";
	//mysqli_query($link,$sql);
	$res[] = 'ok';
	$res[] = $row['sid'];
	echo json_encode($res);die;
} else {
	$res[] = 'fail';
	echo json_encode($res);die;
}