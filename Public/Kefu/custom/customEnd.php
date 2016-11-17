<?php

include '../conn.php';
session_start();
$uid = $_SESSION['userInfo']['id'];
$sql = "update mz_online  set uid = 0,status = 0 where uid = {$uid}";
$res = mysqli_query($link,$sql);