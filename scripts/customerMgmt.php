<?php
require_once('../includes/cspSessionMgmt.php');
include('../includes/config.inc.php');
include('../includes/db_connect.inc.php');
include_once('../includes/functions.inc.php');
require_once('ticketStatusChangeFunctions.php');

$agentID = $_SESSION['uid'];

if(isset($_GET['action']) && $_GET['action'] == "removeCust") {
	$custID = $_GET['custID'];
	if($_SESSION['access'] > 7) {
		$qryRemCust1 = "UPDATE tblFacilities SET Active = 0 WHERE CustomerNumber = '$custID' LIMIT 1";
		$resRemCust1 = mysql_query($qryRemCust1) or die(mysql_error());
		die(header("Location: ../cspUserSupport_Home.php?msgID=0"));
	}
}