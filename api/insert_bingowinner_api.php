<?php
	header("Access-Control-Allow-Origin:*");

	require_once("dbtools.inc.php");
	$link = create_connection();

	$bp_number = $_POST["bp_number"];
	$br_ID = $_POST["br_ID"];

	mysqli_query($link, "SET NAMES utf8");

	$sql = "SELECT * FROM bingoplate WHERE bp_number='$bp_number'";

	$result = execute_sql($link, "jhproject", $sql);
	$row = mysqli_fetch_assoc($result);

	if (mysqli_num_rows($result)>0) {
		$u_ID=$row["u_ID"];
		$bp_ID=$row["bp_ID"];
		$sql = "INSERT INTO bingowinner (u_ID, bp_number ,bp_ID ,br_ID) VALUES ('$u_ID','$bp_number','$bp_ID','$br_ID')";
			if(execute_sql($link, "jhproject", $sql)){
				echo 1 ;
			}else{
				echo 0 .mysqli_error($link);
			}
	 }else{
	  	echo "無資料";
	 }
?>
