<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	$m_title = $_POST["messagetitle"];
	$m_theme = $_POST["messagetheme"];
	$m_message = $_POST["message"];
	$u_ID = $_SESSION["u_ID"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "INSERT INTO messages (m_title, m_theme, m_message, u_ID) VALUES ('$m_title', '$m_theme', '$m_message', '$u_ID')";

	if (execute_sql($link, "jhproject", $sql)) {
	// if (execute_sql($link, "hotel", $sql)) {
		echo "等待跳轉...";
		$message = "留言成功";
		echo "<script type='text/javascript'>alert('$message');</script>";
		header('Refresh:1;url=../message_board.php');
	}else{
		echo "留言失敗".mysqli_error($link);
		echo " ".$m_title." ".$m_theme." ".$m_message." ".$u_ID;
	}
	mysqli_close($link); 
?>
