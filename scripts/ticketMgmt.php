<?php
require_once('../includes/cspSessionMgmt.php');
include('../includes/config.inc.php');
include('../includes/db_connect.inc.php');

$agentID = $_SESSION['uid'];

if(isset($_GET['action']) && $_GET['action'] == "endCall") {
	$callID = $_GET['callID'];
	$ticketID = $_GET['ticketID'];
	$date = date('Y-m-d H:i:s');
	$qryEndCall1 = "DELETE FROM activeCallList WHERE id = '$callID'";
	if(mysql_query($qryEndCall1)) {
		$qryEndCall2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
										VALUES('$ticketID', 'Call Ended', '$agentID', '$date', 3)";
		$rstEndCall2 = mysql_query($qryEndCall2);
		if($rstEndCall2) {
			include 'includes/db_close.inc.php';
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_GET['action']) && $_GET['action'] == "closeTicket") {
	$ticketID = $_GET['ticketID'];
	$date = date('Y-m-d H:i:s');
	$qryCloseTicket3 = "SELECT ID FROM tblTickets WHERE ID = '$ticketID' AND categoryCode IS NOT NULL";
	$resCloseTicket3 = mysql_query($qryCloseTicket3);
	if($resCloseTicket3) {
		$numCloseTicket3 = mysql_num_rows($resCloseTicket3);
		if($numCloseTicket3 == 0) {
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID . "&msgID=23"));
		}
	} else {
		die(mysql_error());
	}
	$qryCloseTicket1 = "UPDATE tblTickets SET Status = -1 WHERE ID = '$ticketID' LIMIT 1";
	if(mysql_query($qryCloseTicket1)) {
		$qryCloseTicket2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
												VALUES('$ticketID', 'Ticket Closed', '$agentID', '$date', 4)";
		if(mysql_query($qryCloseTicket2)) {
			include 'includes/db_close.inc.php';
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_GET['action']) && $_GET['action'] == "reopenTicket") {
	$ticketID = $_GET['ticketID'];
	$date = date('Y-m-d H:i:s');
	$qryCloseTicket1 = "UPDATE tblTickets SET Status = 0 WHERE ID = '$ticketID' LIMIT 1";
	if(mysql_query($qryCloseTicket1)) {
		$qryCloseTicket2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
												VALUES('$ticketID', 'Ticket Reopened', '$agentID', '$date', 5)";
		if(mysql_query($qryCloseTicket2)) {
			include 'includes/db_close.inc.php';
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}
?>