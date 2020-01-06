<?php
	session_start();
	// session_unset();
	// session_destroy();
	// header("Location: ../html/home.php");
	if (isset($_REQUEST['logout'])) {
   		session_unset();
		if(session_destroy()){
			header("Location: ../home_page.php");
		}
	}

	if(session_destroy()){
		header("Location: ../home_page.php");
	}
	header("Location: ../home_page.php");
?>