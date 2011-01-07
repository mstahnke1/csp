<?php
function statusChangeVerify($ticketID, $newStatus) {
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
		
		// Verify source of sale exists when RMA is being processed
		$qryCloseTicket5 = "SELECT tblTickets.ID, tblFacilities.TypeOfSale AS TypeOfSale 
												FROM tblTickets 
												LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
												WHERE tblTickets.ID = '$ticketID'";
		$resCloseTicket5 = mysql_query($qryCloseTicket5);
		$qryCloseTicket6 = "SELECT ID FROM rmaDevices WHERE TicketID = '$ticketID'";
		$resCloseTicket6 = mysql_query($qryCloseTicket6) or die(mysql_error);
		$numCloseTicket6 = mysql_num_rows($resCloseTicket6);
		if($resCloseTicket5) {
			if(((is_null($resCloseTicket5['TypeOfSale'])) || ($resCloseTicket5['TypeOfSale'] == 0)) && $numCloseTicket6 > 0) {
				return('21');
			}
		} else {
			die(mysql_error());
		}
	}
	return('0');
}

function statusChangeTasks($ticketID, $newStatus) {
	if($newStatus == "close") {
		// Check for RMA devices
		$qryRma1 = "SELECT rmaDevices.*, deviceList.partDesc AS partDesc 
								FROM rmaDevices 
								LEFT JOIN deviceList ON rmaDevices.Device = `deviceList`.`part#` 
								WHERE rmaDevices.TicketID = '$ticketID'";
		$resRma1 = mysql_query($qryRma1) or die(mysql_error);
		if(!$resRma1) {
			$agent = $_SESSION['displayname'];
			$browser = $_SERVER['HTTP_USER_AGENT'];
			$statement = "Query: qryRma1 | Error: " . mysql_error();
			$qryRmaError = "INSERT INTO activity_logs (user, statement, agent, date, time) 
											VALUES ('$agent', '$statement', '$browser', CURDATE(), CURTIME())";
			mysql_query($qryRmaError);
		}
		$numRma1 = mysql_num_rows($resRma1);
		if($numRma1 > 0) {
			//If RMA devices are present process request
			$date = date('Y-m-d H:i:s');
			$rmaDevices = "";
			$agent = $_SESSION['uid'];
			$qryRma2 = "UPDATE tblTickets SET rmaReturn = '1' WHERE ID = $ticketID LIMIT 1";
			mysql_query($qryRma2) or die(mysql_error());
			while($rowRma1 = mysql_fetch_assoc($resRma1)) {
				switch($rowRMAInfo1['Warranty']) {
					case 1:
						$warranty = "Warrantied - Repair";
						break;
					case 2:
						$warranty = "NOT Warrantied - Repair";
						break;
					case 3:
						$warranty = "NOT Warrantied - Purchase replacement";
						break;
					case 4:
						$warranty = "Warrantied - <b>Return Only</b>";
						break;
					case 5:
						$warranty = "NOT Warrantied - <b>Return Only</b>";
						break;
				}
				$rmaDevices .= "<div>" . $rowRma1['partDesc'] . " (" . $rowRma1['SN'] . ") - " . $rowRma1['Problem'] . " - " . $warranty . "</div>";
			}
			$qryRma3 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
									VALUES ('$ticketID', '$rmaDevices', '$agent', '$date', '10')";
			mysql_query($qryRma3) or die(mysql_error());
			/*
			<-------- LEFT OFF HERER --------->
			$qryRma4 = "SELECT tblTickets.ID, tblFacilities.TypeOfSale AS TypeOfSale 
									FROM tblTickets 
									LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
									WHERE tblTickets.ID = '$ticketID'";
			$resRma4 = mysql_query($qryRma4);
			$rowRma4 = mysql_fetch_assoc($resRma4);
			if($rowRma4['TypeOfSale'] == 1) {
				case 1
				*/
		} else {
			//If no devices are present make sure ticket is not labeled as RMA from a previous close
			$qryRma2 = "UPDATE tblTickets SET rmaReturn = '0' WHERE ID = $ticketID LIMIT 1";
			$resRma2 = mysql_query($qryRma2);
			if(!$resRma2) {
				$agent = $_SESSION['displayname'];
				$browser = $_SERVER['HTTP_USER_AGENT'];
				$statement = "Query: qryRma2 | Error: " . mysql_error();
				$qryRmaError = "INSERT INTO activity_logs (user, statement, agent, date, time) 
												VALUES ('$agent', '$statement', '$browser', CURDATE(), CURTIME())";
				mysql_query($qryRmaError);
			}
		}
	}
}
?>