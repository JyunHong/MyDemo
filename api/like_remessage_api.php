<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	$rem_id = $_POST["rem_id"];
	$u_ID = $_POST["u_ID"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT reml_id FROM remessagelike WHERE rem_id = $rem_id AND u_ID = $u_ID ";
	$result = execute_sql($link, "jhproject" , $sql);
	if(mysqli_num_rows($result)==0){
		//取出m_like值 加減
		$sql = "SELECT rem_like FROM messages WHERE m_id = $m_id";
		$result = execute_sql($link, "jhproject" , $sql);
		$row=mysqli_fetch_assoc($result);
		$rem_like=$row["rem_like"];
		$rem_like+=1;
		//新增你按讚的資料
		$sql = "INSERT INTO remessagelike (rem_id, u_ID) VALUES ('$rem_id', '$u_ID')";
		execute_sql($link, "jhproject", $sql);
		//更新m_like的值
		$sql = "SELECT rem_like FROM remessages WHERE rem_id = ".$rem_id;
		$result = execute_sql($link, "jhproject" , $sql);
		if (mysqli_num_rows($result)>0) {
			$row=mysqli_fetch_assoc($result);	
			$sql = "UPDATE remessages SET rem_like = '$rem_like' WHERE rem_id = ".$rem_id;
				if (execute_sql($link, "jhproject", $sql)) {
			    	echo 1 ;
				}else {
				    echo 0 . mysqli_error($link);
				}
		}else{
			echo "無此筆資料";
		}
	}else{
		//取出m_like值 加減
		$sql = "SELECT rem_like FROM remessages WHERE rem_id = $rem_id";
		$result = execute_sql($link, "jhproject" , $sql);
		$row=mysqli_fetch_assoc($result);
		$rem_like=$row["rem_like"];
		$rem_like-=1;

		// $sql = "INSERT INTO messagelike (m_id, u_ID) VALUES ('$m_id', '$u_ID')";
		// if (execute_sql($link, "jhproject", $sql)) {
		// 	echo 1 ;
		// }else{
		// 	echo 0 .mysqli_error($link);
		// }

		//更新m_like的值
		$sql = "SELECT rem_like FROM remessages WHERE rem_id = ".$rem_id;
		$result = execute_sql($link, "jhproject" , $sql);
		$row=mysqli_fetch_assoc($result);	
		$sql = "UPDATE remessages SET rem_like = '$rem_like' WHERE rem_id = ".$rem_id;
		execute_sql($link, "jhproject", $sql);

		//刪除你按讚的資料
		$sql = "DELETE FROM remessagelike WHERE u_ID ='$u_ID' AND rem_id ='$rem_id' ";
		if(execute_sql($link,"jhproject",$sql)){
			echo 1 ;
		}else{
			echo 0 .mysqli_error($link);
		}
	}
	mysqli_close($link); 
?>