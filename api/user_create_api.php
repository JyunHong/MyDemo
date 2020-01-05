<?php 
	session_start();
	header("Access-Control-Allow-Origin:*");

    $Account = $_POST["Account"];
	$Password = md5($_POST["Password"]);
	$Code = 0 ;
	$Message = "";
	$IsOK=false;
	
	require_once("dbtools.inc.php");
	$link = create_connection();
	$sql = "SELECT * FROM user WHERE Account = '$Account'";
	$result = execute_sql($link, "jhproject" , $sql);

	if($Account!=null&&$Password!=null){
		if (mysqli_num_rows($result)>0) {
		// echo "此帳號已有人使用,請使用其他帳號";
		echo 2;

		}else{
			$sql = "INSERT INTO user (Account, Password)  VALUES ('$Account', '$Password')";
			if (execute_sql($link, "jhproject", $sql)) {
			// echo "註冊成功";
				$IsOK="true";
				echo '{"Code": '.$Code.',"Message": '.$Message.',"Result": {"IsOK" : '.$IsOK.'}}';
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

