<?php
	header("Access-Control-Allow-Origin:*");
	session_start();

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "DELETE FROM bingoplate";

	if (execute_sql($link, "jhproject", $sql)) {
		echo 1 ;
	}else{
		echo 2 .mysqli_error($link);
	}
	mysqli_close($link); 
?>
