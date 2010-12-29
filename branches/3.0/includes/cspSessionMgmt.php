<?php
//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

//$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
//$url = urlencode(!empty($query) ? " $host$self?$query" : " $host$self");
$url = urlencode(!empty($query) ? " $self?$query" : " $self");

if(isset($_GET['msgID'])) {
	$sysMsg = $portalMsg[$_GET['msgID']][$lang];
}

// Check if logout action has been sent
if((isset($_SESSION['uid'])) && (isset($_GET['action'])) && ($_GET['action']=="logout")) {
	// If logout action set then insert user, browser info, date and time user logging out
	$user = $_SESSION['username'];
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$qryLogout = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', 'User Logout', '$agent', CURDATE(), CURTIME())";
  mysql_query($qryLogout) or die(mysql_error());
  // remove all session information
	session_destroy();
	die(header("Location: csp_UserLogin.php?msgID=2"));
}

if(!isset($_SESSION['uid'])) {
	die(header("Location: csp_UserLogin.php"));
}
?>