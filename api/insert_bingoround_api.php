<?php
	header("Access-Control-Allow-Origin:*");

	require_once("dbtools.inc.php");
	$link = create_connection();


	mysqli_query($link, "SET NAMES utf8");

	$sql = "SELECT max(br_ID) FROM bingoround";
	$result=execute_sql($link, "jhproject", $sql);
	$row = mysqli_fetch_assoc($result);
	$br_ID = $row["max(br_ID)"];

	$n=$br_ID-1 ;

	$sql = "UPDATE bingoround SET br_over ='1' WHERE br_ID = ".$n;	
		if (execute_sql($link, "jhproject", $sql)) {
		   	echo 1 ;
		}else {
		   	echo 0 . mysqli_error($link);
		}

	$sql = "INSERT INTO bingoround (round) VALUES ('$br_ID')";
		if(execute_sql($link, "jhproject", $sql)){
			echo 1 ;
		}else{
			echo 0 .mysqli_error($link);
		}
	mysqli_close($link); 
?>
