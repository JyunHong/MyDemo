<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	// $bp_content = array();
	$u_ID = $_POST["u_ID"];
	$bp_number = $_POST["bp_number"];


	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "INSERT INTO bingowinner (u_ID, bp_number) VALUES ('$u_ID','$bp_number')";

	if (execute_sql($link, "jhproject", $sql)) {
		echo 1 ;
	}else{
		echo 2 .mysqli_error($link);
	}
	mysqli_close($link); 
?>
