<?php
$link = mysqli_connect('localhost', 'root', '') or die('连接数据库失败');
mysqli_select_db($link, 'meizu');
mysqli_set_charset($link, 'utf8');