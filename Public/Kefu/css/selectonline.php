<?php
include 'conn.php';
$uid = $_GET['uid'];
$sql = "select * from mz_online where status = 1 and uid = 0 limit 1";
$rs = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($rs);
var_dump($row);