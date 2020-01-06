<?php
	header("Access-Control-Allow-Origin:*");
	session_start();
	
	$m_id = $_POST["m_id"];
	// $rem_id = $_POST["rem_id"];
	$u_ID = $_POST["u_ID"];

	require_once("dbtools.inc.php");
	$link = create_connection();
	$sql = "SELECT rem_id FROM remessages WHERE m_id = $m_id";
	$result = execute_sql($link, "jhproject" , $sql);
	$myArray = array();
	$row = mysqli_fetch_assoc($result);
	
	if (mysqli_num_rows($result)>0) {
		do{
			$rem_id=$row["rem_id"];
			$sql = "SELECT reml_id FROM remessagelike WHERE rem_id = $rem_id AND u_ID = $u_ID ";
			$result1 = execute_sql($link, "jhproject" , $sql);
			$row = mysqli_fetch_assoc($result1);
			if (mysqli_num_rows($result1)==0) {
				$myArray["$rem_id"]=true;
				// echo $rem_id;
			}else {
			    $myArray["$rem_id"]=false;
			}
		}while($row = mysqli_fetch_assoc($result));

		echo json_encode($myArray);
	 }else{
	  	echo "無資料";
	 }



	mysqli_close($link); 
?>
