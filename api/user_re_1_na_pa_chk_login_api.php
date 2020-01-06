<?php
 	session_start();

	header("Access-Control-Allow-Origin:*");
	require_once("dbtools.inc.php");

	$link=create_connection();
	mysqli_query($link,"SET NAMES UTF8");
	$u_username=$_POST["u_username"];
	$u_password=md5($_POST["u_password"]);
	
	// $myArray = array();
	$sql = "SELECT * FROM userdata WHERE u_username = '$u_username'";
	$result=execute_sql($link,"jhproject",$sql);
	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_assoc($result);
		//判斷是否從Google登入
		if ($row["u_level"] != 1) {
			if ($row["u_password"] == $u_password) {
				$_SESSION["u_ID"]=$row["u_ID"];
				$_SESSION["u_name"]=$row["u_name"];
				$_SESSION["u_level"]=$row["u_level"];
				echo "等待跳轉...";
				$message = "登入成功";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header('Refresh:1;url=../home_page.php');
				
			} else {
				echo "帳號密碼有錯,請重新輸入,若未註冊請先註冊,謝謝您!";
				header('Location:../login.php');
			}

		} else {
			echo "您之前已用Google帳號連結登入,請用Google連結重新登入,謝謝您!";
		}
	} else {
  		echo "帳號密碼有錯,請重新輸入,若未註冊請先註冊,謝謝您!";
  	}
	mysqli_close($link);
?>