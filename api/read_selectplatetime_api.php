<?php
	header("Access-Control-Allow-Origin:*");
	// $m_theme=$_POST["m_theme"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$selectplate_Time ;
	$gt_ID=1;
	mysqli_query($link, "SET NAMES utf8");

	$sql = "SELECT selectplate_Time FROM gametiming";

	$result = execute_sql($link, "jhproject", $sql);
	$row = mysqli_fetch_assoc($result);
	$selectplate_Time=$row["selectplate_Time"];
	if (mysqli_num_rows($result)>0) {

		echo $selectplate_Time ;

		--$selectplate_Time;
		$sql = "UPDATE gametiming SET selectplate_Time ='$selectplate_Time' WHERE gt_ID=".$gt_ID;	
		execute_sql($link, "jhproject", $sql);

	}else{
		echo "無資料";
	}
	
	mysqli_close($link); 
?>
