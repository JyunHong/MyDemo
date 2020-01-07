<?php
	header("Access-Control-Allow-Origin:*");
	// $m_theme=$_POST["m_theme"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	//
	mysqli_query($link, "SET NAMES utf8");

	$sql = "SELECT * FROM messages INNER JOIN userdata ON messages.u_ID = userdata.u_ID ORDER BY messages.m_id DESC";

	$myArray = array();
	$result = execute_sql($link, "jhproject", $sql);
	$row = mysqli_fetch_assoc($result);

	if (mysqli_num_rows($result)>0) {
		do{
			$myArray[]=$row;
		}while($row = mysqli_fetch_assoc($result));

		echo json_encode($myArray);
	 }else{
	  	echo "無資料";
	 }
?>
