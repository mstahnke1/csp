Hi
<?php
include_once 'includes/config.inc.php';
include 'includes/db_connect.inc.php';

if(isset($_GET['action']) && $_GET['action'] == "endCall") {
	$callID = $_GET['callID'];
	$ticketID = $_GET['ticketID'];
	$agentID = "1";
	$date = date('Y-m-d H:i:s');
	$qryEndCall1 = "DELETE FROM activeCallList WHERE id = '$callID'";
	if(mysql_query($qryEndCall1)) {
		$qryEndCall2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
										VALUES('$ticketID', 'Call Ended', '$agentID', '$date', 3)";
		$rstEndCall2 = mysql_query($qryEndCall2);
		if($rstEndCall2) {
			die(header("Location: cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_GET['action']) && $_GET['action'] == "closeTicket") {
	$ticketID = $_GET['ticketID'];
	$agentID = "1";
	$date = date('Y-m-d H:i:s');
	$qryCloseTicket1 = "UPDATE tblTickets SET Status = -1 WHERE ID = '$ticketID' LIMIT 1";
	if(mysql_query($qryCloseTicket1)) {
		$qryCloseTicket2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
												VALUES('$ticketID', 'Ticket Closed', '$agentID', '$date', 4)";
		if(mysql_query($qryCloseTicket2)) {
			die(header("Location: cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_GET['action']) && $_GET['action'] == "reopenTicket") {
	$ticketID = $_GET['ticketID'];
	$agentID = "1";
	$date = date('Y-m-d H:i:s');
	$qryCloseTicket1 = "UPDATE tblTickets SET Status = 0 WHERE ID = '$ticketID' LIMIT 1";
	if(mysql_query($qryCloseTicket1)) {
		$qryCloseTicket2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
												VALUES('$ticketID', 'Ticket Reopened', '$agentID', '$date', 5)";
		if(mysql_query($qryCloseTicket2)) {
			die(header("Location: cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

include 'includes/db_close.inc.php';
?>