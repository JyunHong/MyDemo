<?php 
	header("Access-Control-Allow-Origin:*");
	
	$b_number = $_POST["b_number"];
	$opennumber = 0 ;

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT * FROM bingonumber";
	$result = execute_sql($link, "jhproject" , $sql);
	

	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_assoc($result);	
		$sql = "UPDATE bingonumber SET opennumber ='$opennumber' , nowopen ='$opennumber' ";	
		if (execute_sql($link, "jhproject", $sql)) {
		   	echo 1 ;
		}else {
		   	echo 0 . mysqli_error($link);
		}

	}else{
		echo "無此筆資料";
	}
	mysqli_close($link);

 ?>