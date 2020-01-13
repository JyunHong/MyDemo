<?php
	header("Access-Control-Allow-Origin:*");
	// $m_theme=$_POST["m_theme"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$load_Time = 30 ;
	$selectplate_Time = 60 ;
	$break_Time = 10 ;
	$gt_ID = 1 ;
	$game_Time = 0 ;
	mysqli_query($link, "SET NAMES utf8");

	$sql = "UPDATE gametiming SET game_Time ='$game_Time' , load_Time ='$load_Time' , selectplate_Time ='$selectplate_Time' , break_Time ='$break_Time' WHERE gt_ID=".$gt_ID;

	if (execute_sql($link, "jhproject", $sql)) {
		echo 1 ;
	}else {
		echo 0 . mysqli_error($link);
	}

	mysqli_close($link); 
?>
