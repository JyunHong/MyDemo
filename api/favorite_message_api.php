<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	$m_id = $_POST["m_id"];
	$u_ID = $_POST["u_ID"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT 	fm_id FROM favoritemess WHERE m_id = $m_id AND u_ID = $u_ID ";
	$result = execute_sql($link, "jhproject" , $sql);
	if(mysqli_num_rows($result)==0){
		//新增你的收藏
		$sql = "INSERT INTO favoritemess (m_id, u_ID) VALUES ('$m_id', '$u_ID')";
			if (execute_sql($link, "jhproject", $sql)) {
			    echo "已加入收藏" ;
			}else {
				echo 0 . mysqli_error($link);
			}
	}else{
		//刪除你的收藏
		$sql = "DELETE FROM favoritemess WHERE u_ID ='$u_ID' AND m_id ='$m_id' ";
		if(execute_sql($link,"jhproject",$sql)){
			echo "已移除收藏" ;
		}else{
			echo 0 .mysqli_error($link);
		}
	}
	mysqli_close($link); 
?>
