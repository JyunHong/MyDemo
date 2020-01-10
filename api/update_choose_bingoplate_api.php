<?php 
	header("Access-Control-Allow-Origin:*");
	
	$u_ID = $_POST["u_ID"];
	$bp_ID = $_POST["bp_ID"];
	$choose = 1 ;

	require_once("dbtools.inc.php");
	$link = create_connection();

	$sql = "SELECT * FROM bingoplate WHERE bp_ID = ".$bp_ID;
	$result = execute_sql($link, "jhproject" , $sql);
	

	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_assoc($result);	
		$sql = "UPDATE bingoplate SET choose ='$choose' , u_ID = '$u_ID' WHERE bp_ID = ".$bp_ID;
		$racho=$row["choose"];
		if($racho==0){	
			if (execute_sql($link, "jhproject", $sql)) {
		   		echo 1 ;
			}else {
		    	echo 0 . mysqli_error($link);
			}
		}else{
			echo 0 ;
		}

	}else{
		echo "無此筆資料";
	}
	mysqli_close($link);

 ?>