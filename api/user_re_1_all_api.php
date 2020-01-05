<?php
	header("Access-Control-Allow-Origin:*");
	$u_ID = $_POST["u_ID"];
	require_once("dbtools.inc.php");
	$link=create_connection();
	mysqli_query($link,"SET NAMES UTF8");
	$sql = "SELECT * FROM userdata WHERE u_ID =".$u_ID;
	$result=execute_sql($link,"jhproject",$sql);
	$row=mysqli_fetch_assoc($result);
	$myArray = array();
	if (mysqli_num_rows($result)>0) {
		do {

			$myArray[] = $row;

		} while ($row=mysqli_fetch_assoc($result));

			echo json_encode($myArray);

	} else {

		echo "查無會員資料";

	}

?>