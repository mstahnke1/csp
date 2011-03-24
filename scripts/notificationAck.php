<?php
include_once('../includes/config.inc.php');
include_once('../includes/db_connect.inc.php');

if(isset($_GET) && $_GET['taskID']) {
	$taskID = $_GET['taskID'];
	$agentID = $_SESSION['uid'];
	$date = date('Y-m-d H:i:s');
	mysql_select_db($dbname2);
	$qryAck1 = "UPDATE taskinfo SET uid = '$agentID', ack = -1, ack_timestamp = '$date' WHERE ID = $taskID LIMIT 1";
	$resAck1 = mysql_query($qryAck1);
	if($resAck1) {
		$sysMsg = urlencode("Notification successfully acknowledged.");
	  die(header("Location: " . $_SERVER['HTTP_REFERER'] . "?sysMsg=" . $sysMsg));
	} else {
		die(mysql_error());
	}
}
