<?php
	header("Access-Control-Allow-Origin:*");
	// $m_theme=$_POST["m_theme"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$break_Time ;
	$gt_ID=1;
	mysqli_query($link, "SET NAMES utf8");

	$sql = "SELECT break_Time FROM gametiming";

	$result = execute_sql($link, "jhproject", $sql);
	$row = mysqli_fetch_assoc($result);
	$break_Time=$row["break_Time"];
	if (mysqli_num_rows($result)>0) {

		echo $break_Time ;

		--$break_Time;
		$sql = "UPDATE gametiming SET break_Time ='$break_Time' WHERE gt_ID=".$gt_ID;	
		execute_sql($link, "jhproject", $sql);
		
	}else{
		echo "無資料";
	}

	mysqli_close($link); 
?>
