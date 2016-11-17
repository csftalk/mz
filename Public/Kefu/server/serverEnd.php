<?php

include '../conn.php';
session_start();
$sid = $_SESSION['adminInfo']['id'];
$sql = "update mz_online  set status = 0 where sid = {$sid}";
$res = mysqli_query($link,$sql);
echo 1;