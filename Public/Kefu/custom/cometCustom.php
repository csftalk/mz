<?php
set_time_limit(0);
include '../conn.php';
$sid = $_GET['sid'];
$whatid = $sid;
$sql = "select * from mz_talk where whatid = {$whatid} and isread = 0 and role = 's' limit 1";

while(true) {
    $rs = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($rs);
    if(!empty($row)) {
        echo json_encode($row);
        $sql = "update mz_talk set isread = 1 where id = " . $row['id'];
        mysqli_query($link,$sql);
        exit();
    }

    usleep(500);
}
