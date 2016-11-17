<?php
set_time_limit(0);
session_start();
include '../conn.php';
// $uid = $_GET['uid'];
$sid = $_SESSION['adminInfo']['id'];
$sql = "select * from mz_online where sid = {$sid} ";
while(true) {
    $rs = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($rs);
    if($row['uid'] == '0') {
        echo 'leave';
        exit();
    }
    sleep(1);
}