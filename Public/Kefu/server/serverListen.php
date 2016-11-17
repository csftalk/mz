<?php
set_time_limit(0);
include '../conn.php';
session_start();
$sid = $_SESSION['adminInfo']['id'];
$sql = "select * from mz_online where sid = {$sid}";
$res = mysqli_query($link,$sql);
while(true) {
    $rs = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($rs);
    $res = [];
    if($row['uid'] != 0) {
        $res[] = 'ok';
        $res[] = $row['uid'];
        echo json_encode($res);die;
    } 

    sleep(1);
}
