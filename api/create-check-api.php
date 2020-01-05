<?php
	header("Access-Control-Allow-Origin:*");
	//尋找是否有已存在的帳號 true: 存在 false: 不存在
	$Account = $_POST["Account"];

	require_once("dbtools.inc.php");
	$link = create_connection();
	$sql = "SELECT * FROM user WHERE Account = '$Account'";
	$result = execute_sql($link, "jhproject", $sql);

	if(mysqli_num_rows($result) == 1){
		echo true; 
	}else{
		echo false;
	}

?>