<?php
	header("Access-Control-Allow-Origin:*");
	require_once("dbtools.inc.php");

	$link = create_connection();
	$sql = "SELECT * FROM userdata";
	$result = execute_sql($link, "id10564565_hotel", $sql);
	$row = mysqli_fetch_assoc($result);
	$myArray = array();

	if(mysqli_num_rows($result) > 0){
		do{
			$myArray[] = $row;
		}while($row = mysqli_fetch_assoc($result));
		echo json_encode($myArray);
	}else{
		echo "none";
	}
?>