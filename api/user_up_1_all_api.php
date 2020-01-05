<?php 
	session_start();
	header("Access-Control-Allow-Origin:*");
	$u_ID = $_POST["u_ID"];
	$u_password = md5($_POST["u_password"]);
	$u_phone = $_POST["u_phone"];
	$u_name = $_POST["u_name"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT * FROM userdata WHERE u_ID = '$u_ID'";
	$result = execute_sql($link, "jhproject" , $sql);

	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_assoc($result);
		if ($row["u_password"] == $u_password) {
			$sql = "UPDATE userdata SET u_name = '$u_name', u_phone ='$u_phone' WHERE u_ID = ".$u_ID;

			if (execute_sql($link, "jhproject", $sql)) {
				$sql = "SELECT * FROM userdata WHERE u_ID = ".$u_ID;
				$result = execute_sql($link, "jhproject" , $sql);
	    		$row=mysqli_fetch_assoc($result);
	    		$_SESSION["u_name"]=$row["u_name"];
	    		echo 1;
			}else {
		    	echo "更新失敗: " . mysqli_error($link);
			}
		} else {
		echo "密碼不正確";
		}
	} else {
		echo "無此筆資料";
	}
	mysqli_close($link);
?>