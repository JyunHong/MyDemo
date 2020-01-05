<?php 
	session_start();
	header("Access-Control-Allow-Origin:*");

    $u_username = $_POST["u_username"];//u_username
	$u_password = md5($_POST["u_password"]);//u_password
	$u_phone = $_POST["u_phone"];//u_phone
	$u_email = $_POST["u_username"];//u_email
	$u_name = $_POST["u_name"];//u_name
	$u_session = $_POST["u_session"];;
	$u_google = $_POST["u_google"];;
	$u_level = $_POST["u_level"];
	
	require_once("dbtools.inc.php");
	$link = create_connection();
	$sql = "SELECT * FROM userdata WHERE u_username = '$u_username'";
	$result = execute_sql($link, "jhproject" , $sql);

	if($u_username!=null&&$u_password!=null&&$u_phone!=null&&$u_username!=null&&$u_email!=null&&$u_name!=null){
		if (mysqli_num_rows($result)>0) {
		// echo "此帳號已有人使用,請使用其他帳號";
		echo 2;
		}else{
			$sql = "INSERT INTO userdata (u_username, u_password, u_phone, u_email, u_name, u_session, u_google)  VALUES ('$u_username', '$u_password', '$u_phone','$u_email','$u_name', '$u_session', '$u_google')";
			$sql = "INSERT INTO userdata (u_username, u_password, u_phone, u_email, u_name, u_level)  VALUES ('$u_username', '$u_password', '$u_phone','$u_email','$u_name', '$u_level')";
			if (execute_sql($link, "jhproject", $sql)) {
			// echo "註冊成功";
				echo 1;
			} else {
			echo "註冊失敗:" . mysqli_error($link);
				// echo 0 . mysqli_error($link);
			}
		}
	}else{
		echo "填寫資料有誤";
	}
	
	mysqli_close($link);
?>

