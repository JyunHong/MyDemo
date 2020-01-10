<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	// $bp_content = array();
	$bp_number = $_POST["bp_number"];
	$bp_content = $_POST["bp_content"];
	$bp_chklinearray = $_POST["bp_chklinearray"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "INSERT INTO bingoplate (bp_number, bp_content ,bp_chklinearray) VALUES ('$bp_number','$bp_content','$bp_chklinearray')";

	if (execute_sql($link, "jhproject", $sql)) {
		echo 1 ;
	}else{
		echo 2 .mysqli_error($link);
	}
	mysqli_close($link); 
?>
