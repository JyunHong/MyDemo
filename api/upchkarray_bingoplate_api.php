<?php 
	header("Access-Control-Allow-Origin:*");
	
	$bp_chklinearray = $_POST["bp_chklinearray"];
	$bp_number = $_POST["bp_number"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT * FROM bingoplate WHERE bp_number ='$bp_number'";
	$result = execute_sql($link, "jhproject" , $sql);
	

	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_assoc($result);	
		$sql = "UPDATE bingoplate SET bp_chklinearray ='$bp_chklinearray' WHERE bp_number ='$bp_number' ";	
		if (execute_sql($link, "jhproject", $sql)) {
		   	echo 1 ;
		}else {
		   	echo 0 . mysqli_error($link);
		}

	}else{
		echo "無此筆資料";
	}
	mysqli_close($link);

 ?>