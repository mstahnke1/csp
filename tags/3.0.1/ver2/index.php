<?php
//session_set_cookie_params(0 , '/', '.dmatek.com');
//session_start();
	if(! isset($_SESSION['username'])) {
		include_once "csPortal_Login.php";
//		header("Location: csPortal_Login.php");
	}else{
		$name = $_SESSION['displayname'];
		$message2="Welcome back, $name!";
		include_once "csPortal_Main.php";
//		header('Location: csPortal_Main.php');
	}
?>