<?php
set_time_limit(0);
include '../conn.php';
//$uid = $_GET['uid'];
$whatid = $uid = 38;
$sql = "select * from mz_talk where whatid = {$whatid} and isread = 0 and role = 'u' limit 1";
$sql1 = "select * from mz_online where uid = {$uid}";

while(true) {
    $rs = mysqli_query($link,$sql1);
    $row = mysqli_fetch_assoc($rs);
    if (!$row){
    	$res = 'leave';
    	echo json_encode($res);
    	die;
    }
     usleep(500);
    $rs = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($rs);
    if(!empty($row)) {
        echo json_encode($row);
        $sql = "update mz_talk set isread = 1 where id = " . $row['id'];
        mysqli_query($link,$sql);
        exit();
    }
    

}
