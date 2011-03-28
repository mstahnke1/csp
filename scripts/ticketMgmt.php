<?php
require_once('../includes/cspSessionMgmt.php');
include('../includes/config.inc.php');
include('../includes/db_connect.inc.php');
include_once('../includes/functions.inc.php');
require_once('ticketStatusChangeFunctions.php');
include_once "mail.php";

$agentID = $_SESSION['uid'];

if(isset($_GET['action']) && $_GET['action'] == "endCall") {
	$callID = $_GET['callID'];
	$ticketID = $_GET['ticketID'];
	$date = date('Y-m-d H:i:s');
	//Verify a comment has been added for this call before ending the call
	$qryEndCall2 = "SELECT ID FROM tblTicketMessages WHERE TicketID = '$ticketID' AND msgType = 0 AND Date > (SELECT Date FROM tblTicketMessages WHERE callid = '$callID')";
	$resEndCall2 = mysql_query($qryEndCall2) or die(mysql_error());
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
												VALUES('$ticketID', 'Ticket Canceled', '$agentID', '$date', 8)";
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

if(isset($_GET['returnAuth'])) {
	if($_GET['returnAuth'] == 'Verified') {
		$retNote = "Returned equipment verified with ticket: " . $_GET['returnNote'];
	}elseif($_GET['returnAuth'] == 'Modified') {
		$retNote = "Returned equipment modified from ticket: " . $_GET['returnNote'];
	}
	$ticketID = $_GET['ticketID'];
	$date = date('Y-m-d H:i:s');
	$ticketUrl = "http://".$_SERVER['HTTP_HOST']."/dev/csp/cspUserSupport_TicketDetail.php?ticketID=".$ticketID;
	$remark = nl2br(stripslashes(fix_apos("'", "''", $retNote)));
	$query = "INSERT INTO tblticketmessages (TicketID, Message, EnteredBy, Date, msgType) VALUES ('$ticketID', '$remark', '$_SESSION[uid]', '$date', '11')";
	if(mysql_query($query))
	{
		$dueDate = (date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d")+7, date("Y"))));
		$query9 = "SELECT tblTickets.CustomerNumber, tblFacilities.FacilityName AS FacilityName 
							FROM tblTickets 
							LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
							WHERE tblTickets.ID = '$ticketID'";
		$result9 = mysql_query($query9);
		$row9 = mysql_fetch_array($result9);
		$facility = $row9['FacilityName'];
		$custID = $row9['CustomerNumber'];
		mysql_select_db($dbname2);
		$query10 = "DELETE FROM taskinfo WHERE ticketNum = '$ticketID' AND Status = 9";
		mysql_query($query10) or die(mysql_error());
		$subject = "Repair ticket request " . $ticketID . " (" . $facility . ")";
		$subject = nl2br(stripslashes(fix_apos("'", "''", $subject)));
		$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, Cancelationdate, ticketNum, CustomerNumber)
							VALUES ('11', '$subject', '2', '9', '$subject', '$date', '$dueDate', '2002', '$_SESSION[uid]', '$date', '$ticketID', '$custID')";
		if(mysql_query($query6)) {
			$query3 = "SELECT MAX(ID) FROM taskinfo";
			if($result3 = mysql_query($query3)) {
				$row3 = mysql_fetch_array($result3);
				$newTaskID = $row3['MAX(ID)'];
				$query4 = "INSERT INTO tbltaskremarks (taskid, remarks, dateadded, addedby)
									VALUES ('$newTaskID', '$remark', '$date', '$_SESSION[uid]')";
				mysql_query($query4) or die("Query 4: ".mysql_error());
				$query5 = "INSERT INTO tbltaskaudit (Date, User, Action, taskid, type, status, response) 
									VALUES ('$date', '$_SESSION[uid]', 'New Task', '$newTaskID', '11', '1', '2002')";
				mysql_query($query5) or die("Query 5: ".mysql_error());
			}
		}
		mysql_select_db($dbname);
		$query8 = "SELECT f_name, l_name, email FROM employees WHERE manageRma = 1 AND active = 0";
		$result8 = mysql_query($query8);
		$num8 = mysql_num_rows($result8);
		if($num8 > 0) {
			while($row8 = mysql_fetch_array($result8)) {
				$to[] = $row8['f_name'] . " " . $row8['l_name'] . "<" . $row8['email'] . ">";
			}
			$from = $_SESSION['displayname'] . " <" . $_SESSION['mail'] . ">";
			$to = implode(', ', $to);
			$subject = "Repair ticket request " . $ticketID . " (" . $facility . ")";
			$body = '<p>Customer repair requested for ticket <a href="' . $ticketUrl . '?ticketID=' . $ticketID . '&by_ticket=ticket&submit=Lookup">' . $ticketID . '</a></p>
							<b><u>Return Details</b></u></font><br />
							Facility: ' . $facility . '<br />
							Return Notes: ' . $remark . '<br />';
			$body .= '</p>';

			$headers = array ('From' => $from,
				'To' => $to,
				'Subject' => $subject,
				'Content-type' => $type);
			$smtp = Mail::factory('smtp',
				array ('host' => $SmtpHost,
				'auth' => true,
				'username' => $SmtpUsername,
				'password' => $SmtpPassword));
	
			$mail = $smtp->send($to, $headers, $body);
		
			if (PEAR::isError($mail)) {
				die(header('Location: ../cspUserSupport_TicketDetail.php?ticketID='.$ticketID.'&msgID=16'));
			}
		}
		die(header('Location: ../ver2/rmaRepairForm.php?ticketID=' . $ticketID));
	} else {
		die(header('Location: ../cspUserSupport_TicketDetail.php?ticketID='.$ticketID.'&msgID=1'));
	}
}
?>