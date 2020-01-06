<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	$m_id = $_POST["m_id"];
	// $rem_id = $_POST["rem_id"];
	$u_ID = $_POST["u_ID"];

	require_once("dbtools.inc.php");
	$link = create_connection();
	// $sql = "SELECT rem_id FROM remessages WHERE m_id = $m_id";
	// $result = execute_sql($link, "jhproject" , $sql);
	// $row = mysqli_fetch_assoc($result);
	$rem_id=$_POST["rem_id"];

	$sql = "SELECT reml_id FROM remessagelike WHERE rem_id = $rem_id AND u_ID = $u_ID ";
	$result = execute_sql($link, "jhproject" , $sql);
	if (mysqli_num_rows($result)==0) {
		echo 1;
		// echo $rem_id;
	}else {
		echo 0;
	}
	
	mysqli_close($link); 
?>
