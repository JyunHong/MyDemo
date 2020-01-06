<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	$m_id = $_POST["m_id"];
	$u_ID = $_POST["u_ID"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT fm_id FROM favoritemess WHERE m_id = $m_id AND u_ID = $u_ID ";
	$result = execute_sql($link, "jhproject" , $sql);
	if (mysqli_num_rows($result)==0) {
		echo true ;
	}else {
	    echo false . mysqli_error($link);
	}

	mysqli_close($link); 
?>
