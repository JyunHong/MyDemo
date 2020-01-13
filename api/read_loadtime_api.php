<?php
	header("Access-Control-Allow-Origin:*");
	// $m_theme=$_POST["m_theme"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$load_Time ;
	$gt_ID = 1;
	$game_Time = 1;
	mysqli_query($link, "SET NAMES utf8");

	$sql = "SELECT load_Time FROM gametiming";

	$result = execute_sql($link, "jhproject", $sql);
	$row = mysqli_fetch_assoc($result);
	$load_Time=$row["load_Time"];
	if (mysqli_num_rows($result)>0) {

		echo $load_Time ;

		if($load_Time==0){
			$sql = "UPDATE gametiming SET game_Time ='$game_Time' WHERE gt_ID=".$gt_ID;
			execute_sql($link, "jhproject", $sql);
		}

		--$load_Time;
		$sql = "UPDATE gametiming SET load_Time ='$load_Time' WHERE gt_ID=".$gt_ID;	
		if (execute_sql($link, "jhproject", $sql)) {
		}else {
		   	echo 0 . mysqli_error($link);
		}
		
	}else{
		echo "無資料";
	}

	mysqli_close($link); 
?>
