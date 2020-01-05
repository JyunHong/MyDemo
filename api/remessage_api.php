<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	$m_id = $_POST["m_id"];
	$rem_message = $_POST["rem_message"];
	$u_ID = $_POST["u_ID"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT rem FROM messages WHERE m_id = $m_id";
	$result = execute_sql($link, "jhproject" , $sql);
	$row=mysqli_fetch_assoc($result);
	$rem=$row["rem"];

	$sql = "SELECT rem FROM messages WHERE m_id = $m_id";
	$result = execute_sql($link, "jhproject" , $sql);
	$row=mysqli_fetch_assoc($result);
	$rem_floor=$row["rem"];
	$rem_floor+=1;

	$sql = "INSERT INTO remessages (rem_message, m_id, u_ID, rem_floor) VALUES ('$rem_message', '$m_id', '$u_ID','$rem_floor')";
	if (execute_sql($link, "jhproject", $sql)) {
		$rem += 1;
		echo "回覆成功";
	}else{
		echo "留言失敗".mysqli_error($link);
		echo " ".$rem_message." ".$m_id." ".$u_ID." ".$u_ID;
	}


	$sql = "SELECT rem FROM messages WHERE m_id = ".$m_id;
	$result = execute_sql($link, "jhproject" , $sql);
	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_assoc($result);	
		$sql = "UPDATE messages SET rem = '$rem' WHERE m_id = ".$m_id;
			if (execute_sql($link, "jhproject", $sql)) {
		    	
			}else {
			    echo "更新失敗: " . mysqli_error($link);
			}
	}else{
		echo "無此筆資料";
	}
	mysqli_close($link); 
?>
