<?php
// Enter your Host, username, password, database below.
$con = mysqli_connect("185.201.11.149","u754228801_jrsalaza","Njsm_9161","u754228801_assignments");
    if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die();
	}
?>