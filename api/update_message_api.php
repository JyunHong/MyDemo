<?php 
	header("Access-Control-Allow-Origin:*");
	
	$u_ID = $_POST["u_ID"];
	$m_id = $_POST["m_id"];
	$m_title = $_POST["m_title"];
	$m_theme = $_POST["m_theme"];
	$m_message = $_POST["m_message"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT * FROM messages WHERE m_id = ".$m_id;
	$result = execute_sql($link, "jhproject" , $sql);

	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_assoc($result);	
		$sql = "UPDATE messages SET m_title = '$m_title',m_theme = '$m_theme',m_message = '$m_message' WHERE m_id = ".$m_id;
			if (execute_sql($link, "jhproject", $sql)) {
		   		echo 1 ;
			}else {
		    	echo "更新失敗: " . mysqli_error($link);
			}

	}else{
		echo "無此筆資料";
	}
	mysqli_close($link);

 ?>