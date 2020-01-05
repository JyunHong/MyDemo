<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	$m_id = $_POST["m_id"];
	$u_ID = $_POST["u_ID"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT l_id FROM messagelike WHERE m_id = $m_id AND u_ID = $u_ID ";
	$result = execute_sql($link, "jhproject" , $sql);
	if(mysqli_num_rows($result)==0){
		//取出m_like值 加減
		$sql = "SELECT m_like FROM messages WHERE m_id = $m_id";
		$result = execute_sql($link, "jhproject" , $sql);
		$row=mysqli_fetch_assoc($result);
		$m_like=$row["m_like"];
		$m_like+=1;
		//新增你按讚的資料
		$sql = "INSERT INTO messagelike (m_id, u_ID) VALUES ('$m_id', '$u_ID')";
		execute_sql($link, "jhproject", $sql);
		//更新m_like的值
		$sql = "SELECT m_like FROM messages WHERE m_id = ".$m_id;
		$result = execute_sql($link, "jhproject" , $sql);
		if (mysqli_num_rows($result)>0) {
			$row=mysqli_fetch_assoc($result);	
			$sql = "UPDATE messages SET m_like = '$m_like' WHERE m_id = ".$m_id;
				if (execute_sql($link, "jhproject", $sql)) {
			    	echo "按讚了" ;
				}else {
				    echo 0 . mysqli_error($link);
				}
		}else{
			echo "無此筆資料";
		}
	}else{
		//取出m_like值 加減
		$sql = "SELECT m_like FROM messages WHERE m_id = $m_id";
		$result = execute_sql($link, "jhproject" , $sql);
		$row=mysqli_fetch_assoc($result);
		$m_like=$row["m_like"];
		$m_like-=1;

		// $sql = "INSERT INTO messagelike (m_id, u_ID) VALUES ('$m_id', '$u_ID')";
		// if (execute_sql($link, "jhproject", $sql)) {
		// 	echo 1 ;
		// }else{
		// 	echo 0 .mysqli_error($link);
		// }

		//更新m_like的值
		$sql = "SELECT m_like FROM messages WHERE m_id = ".$m_id;
		$result = execute_sql($link, "jhproject" , $sql);
		$row=mysqli_fetch_assoc($result);	
		$sql = "UPDATE messages SET m_like = '$m_like' WHERE m_id = ".$m_id;
		execute_sql($link, "jhproject", $sql);

		//刪除你按讚的資料
		$sql = "DELETE FROM messagelike WHERE u_ID ='$u_ID' AND m_id ='$m_id' ";
		if(execute_sql($link,"jhproject",$sql)){
			echo "收回讚了" ;
		}else{
			echo 0 .mysqli_error($link);
		}
	}
	mysqli_close($link); 
?>
