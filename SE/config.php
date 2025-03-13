<?php

$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "fitness_club";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
	exit();
	
mysqli_set_charset($connect,"utf8");
}
?>
