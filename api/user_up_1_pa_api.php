<?php 
	header("Access-Control-Allow-Origin:*");
	$u_ID = $_POST["u_ID"];
	$u_password = md5($_POST["u_password"]);
	$new_password = md5($_POST["new_password"]);

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT * FROM userdata WHERE u_ID = ".$u_ID;
	$result = execute_sql($link, "jhproject" , $sql);

	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_assoc($result);	
		if ($row["u_password"] == $u_password) {
			$sql = "UPDATE userdata SET u_password = '$new_password' WHERE u_ID = ".$u_ID;
				if (execute_sql($link, "jhproject", $sql)) {
		    		echo 1;
				}else {
			    	echo "更新失敗: " . mysqli_error($link);
				}
		}else{
			echo "原始密碼錯誤";
		}
	}else{
		echo "無此筆資料";
	}
	mysqli_close($link);
	// $con->close();
 ?>