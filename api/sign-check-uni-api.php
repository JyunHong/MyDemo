<?php
	header("Access-Control-Allow-Origin:*");
	//尋找是否有已存在的帳號 true: 存在 false: 不存在
	$u_username = $_POST["u_username"];

	require_once("dbtools.inc.php");
	$link = create_connection();
	$sql = "SELECT * FROM userdata WHERE u_username = '$u_username'";
	$result = execute_sql($link, "jhproject", $sql);

	if(mysqli_num_rows($result) == 1){
		echo true; 
	}else{
		echo false;
	}

?>