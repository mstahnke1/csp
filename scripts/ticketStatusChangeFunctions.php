<?php
function verifyChangeStatus($ticketID, $newStatus) {
	if($newStatus == "close") {
		// Verify that ticket has been assigned an issue category
		$qryCloseTicket3 = "SELECT ID FROM tblTickets WHERE ID = '$ticketID' AND categoryCode IS NOT NULL";
		$resCloseTicket3 = mysql_query($qryCloseTicket3);
		if($resCloseTicket3) {
			$numCloseTicket3 = mysql_num_rows($resCloseTicket3);
			if($numCloseTicket3 == 0) {
				return('23');
			}
		} else {
			die(mysql_error());
		}
		
		// Verify that ticket has agent comments
		$qryCloseTicket4 = "SELECT ID FROM tblTicketMessages WHERE TicketID = '$ticketID' AND msgType = 0";
		$resCloseTicket4 = mysql_query($qryCloseTicket4);
		if($resCloseTicket4) {
			$numCloseTicket4 = mysql_num_rows($resCloseTicket4);
			if($numCloseTicket4 == 0) {
				return('20');
			}
		} else {
			die(mysql_error());
		}
	}
	return('0');
}

function runStatusChangeTasks($ticketID, $newStatus) {
	if($newStatus == "escalateTicket") {
		
	}
}
?>