<?php
	header("Access-Control-Allow-Origin:*");
	$m_id = $_GET["m_id"];

	require_once("dbtools.inc.php");
	$link = create_connection();

	mysqli_query($link, "SET NAMES utf8");

	$sql = "SELECT * FROM remessages INNER JOIN userdata ON remessages.u_ID = userdata.u_ID Where remessages.m_id = $m_id ORDER BY remessages.m_id DESC";

	$myArray = array();
	$result = execute_sql($link, "jhproject", $sql);
	$row = mysqli_fetch_assoc($result);

	if (mysqli_num_rows($result)>0) {
		do{
			$myArray[]=$row;
		}while($row = mysqli_fetch_assoc($result));
		echo json_encode($myArray);
	 }else{
	  	echo "無資料";
	 }
	 mysqli_close($link);
?>
