<?php
//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();
	if(!isset($_SESSION['uid'])) {
		include_once "csp_UserLogin.php";
//		header("Location: csp_UserLogin.php");
	}else{
		include_once "cspUserHome_Dashboard.php";
//		header('Location: cspUserHome_Dashboard.php');
	}
?>