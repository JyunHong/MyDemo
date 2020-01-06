<?php
	$m_id = $_POST["m_id"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "DELETE FROM messages WHERE m_id = " . $m_id;
	
	if(execute_sql($link, "jhproject", $sql)){
		echo "刪除成功";
	}else{
		echo "刪除失敗".mysqli_error($link);
	}

	mysqli_close($link);
?>