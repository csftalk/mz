<?php
session_start();
include '../conn.php';
$sid = $_SESSION['adminInfo']['id'];
// $sql = "select * from mz_online where sid = {$sid}";
// $rs = mysqli_query($link,$sql);

//$row = mysqli_fetch_assoc($rs);
// if ($row['uid'] == '0') {
// 	// $sql = "update mz_online set status = 0 where sid ={$sid}";
// 	// $rs = mysqli_query($link,$sql);
// 	echo 'ok';die;
// } else {
// 	echo 'fail';die;
// }

// $sql = "update mz_online set status = 0 where sid ={$sid}";
// $rs = mysqli_query($link,$sql);
// if ($rs) {
// 	echo 'ok';die;
// } else {
// 	echo 'fail';die;
// }
echo 'ok';