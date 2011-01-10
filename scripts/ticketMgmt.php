<?php
require_once('../includes/cspSessionMgmt.php');
include('../includes/config.inc.php');
include('../includes/db_connect.inc.php');
require_once('ticketStatusChangeFunctions.php');

$agentID = $_SESSION['uid'];

if(isset($_GET['action']) && $_GET['action'] == "endCall") {
	$callID = $_GET['callID'];
	$ticketID = $_GET['ticketID'];
	$date = date('Y-m-d H:i:s');
	//Verify a comment has been added for this call before ending the call
	$qryEndCall2 = "SELECT ID FROM tblTicketMessages WHERE TicketID = '$ticketID' AND msgType = 0 AND Date > (SELECT Date FROM tblTicketMessages WHERE callid = '$callID')";
	$resEndCall2 = mysql_query($qryEndCall2);
	$numEndCall2 = mysql_num_rows($resEndCall2);
	if($numEndCall2 == 0) {
		die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID . "&msgID=27"));
	}
	$qryEndCall1 = "DELETE FROM activeCallList WHERE id = '$callID'";
	if(mysql_query($qryEndCall1)) {
		$callMsg = "Call ID: " . $callID;
		$qryEndCall2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType, callID)
										VALUES('$ticketID', '$callMsg', '$agentID', '$date', 3, '$callID')";
		$rstEndCall2 = mysql_query($qryEndCall2);
		if($rstEndCall2) {
			include '../includes/db_close.inc.php';
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_GET['action']) && $_GET['action'] == "escalateTicket") {
	$ticketID = $_GET['ticketID'];
	$date = date('Y-m-d H:i:s');
	$qryEscTicket1 = "UPDATE tblTickets SET Status = 2 WHERE ID = '$ticketID' LIMIT 1";
	if(mysql_query($qryEscTicket1)) {
		$qryEscTicket2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
												VALUES('$ticketID', 'Ticket Escalated', '$agentID', '$date', 9)";
		if(mysql_query($qryEscTicket2)) {
			include 'includes/db_close.inc.php';
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID . "&msgID=24"));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_GET['action']) && $_GET['action'] == "closeTicket") {
	$ticketID = $_GET['ticketID'];
	$closeChecks = statusChangeVerify($ticketID, "close");
	if($closeChecks == 0) {
		statusChangeTasks($ticketID, "close");
		$date = date('Y-m-d H:i:s');
		$qryCloseTicket1 = "UPDATE tblTickets SET Status = -1, DateClosed = '$date' WHERE ID = '$ticketID' LIMIT 1";
		if(mysql_query($qryCloseTicket1)) {
			$qryCloseTicket2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
													VALUES('$ticketID', 'Ticket Closed', '$agentID', '$date', 4)";
			if(mysql_query($qryCloseTicket2)) {
				include '../includes/db_close.inc.php';
				die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID . "&msgID=" . $closeChecks));
			} else {
				die(mysql_error());
			}
		} else {
			die(mysql_error());
		}
	} else {
		die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID . "&msgID=" . $closeChecks));
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
			include '../includes/db_close.inc.php';
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_GET['action']) && $_GET['action'] == "cancelTicket") {
	$ticketID = $_GET['ticketID'];
	$date = date('Y-m-d H:i:s');
	$qryCanTicket1 = "UPDATE tblTickets SET Status = 1 WHERE ID = '$ticketID' LIMIT 1";
	if(mysql_query($qryCanTicket1)) {
		$qryCanTicket2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
												VALUES('$ticketID', 'Ticket Canceled', '$agentID', '$date', 5)";
		if(mysql_query($qryCanTicket2)) {
			include '../includes/db_close.inc.php';
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID . "&msgID=25"));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}
?>