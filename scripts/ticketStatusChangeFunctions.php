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
		$rowCloseTicket5 = mysql_fetch_assoc($resCloseTicket5);
		$qryCloseTicket6 = "SELECT ID FROM rmaDevices WHERE TicketID = '$ticketID'";
		$resCloseTicket6 = mysql_query($qryCloseTicket6) or die(mysql_error);
		$numCloseTicket6 = mysql_num_rows($resCloseTicket6);
		if($resCloseTicket5) {
			if((is_null($rowCloseTicket5['TypeOfSale']) || $rowCloseTicket5['TypeOfSale'] == 0) && $numCloseTicket6 > 0) {
				return('21');
			}
		} else {
			die(mysql_error());
		}
	}
	return('0');
}

function statusChangeTasks($ticketID, $newStatus) {
	include_once('../includes/functions.inc.php');
	include('../includes/config.inc.php');
	require_once('../includes/db_connect.inc.php');
	require_once "Mail.php";
	if($newStatus == "close") {
		// Check for RMA devices
		$qryRma1 = "SELECT rmaDevices.*, deviceList.partDesc AS partDesc, deviceList.rmaPreApproval AS preApp 
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
			$preApp = 0;
			$agent = $_SESSION['uid'];
			$qryRma2 = "UPDATE tblTickets SET rmaReturn = '1' WHERE ID = $ticketID LIMIT 1";
			mysql_query($qryRma2) or die(mysql_error());
			while($rowRma1 = mysql_fetch_assoc($resRma1)) {
				if($rowRma1['preApp'] == 1) {
					$preApp++;
				}
				switch($rowRma1['Warranty']) {
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
			$qryRma4 = "SELECT tblTickets.*, tblFacilities.TypeOfSale AS TypeOfSale, tblFacilities.FacilityName AS facilityName, tblFacilities.CustomerNumber AS facilityID 
									FROM tblTickets 
									LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
									WHERE tblTickets.ID = '$ticketID'";
			$resRma4 = mysql_query($qryRma4) or die(mysql_error());
			$rowRma4 = mysql_fetch_assoc($resRma4);
			$qryRma5 = "SELECT * FROM tblTicketMessages WHERE TicketID = '$ticketID' AND msgType = 0";
			$resRma5 = mysql_query($qryRma5) or die(mysql_error());
			$ticketUrl = "http://".$_SERVER['HTTP_HOST']."/dev/csp/cspUserSupport_TicketDetail.php?ticketID=".$ticketID;
			//Prepare task and email body
			$rmaBody = '<p>
									Customer return has been requested for ticket <a href="' . $ticketUrl . '">' . $ticketID . '</a>
									</p>
									<p>
									<u>Return Details</u><br />
									Facility: ' . $rowRma4['facilityName'] . '<br />
									Contact: ' . $rowRma4['Contact'] . '<br />
									Reason Opened: ' . $rowRma4['Summary'] . '<br />';
									while($rowRma5 = mysql_fetch_array($resRma5)) {
										$rmaBody .= 'Agent Remarks: ' . $rowRma5['Message'] . '<br />';
									}
									$rmaBody .= '</p><p><u>Device Details</u><br />';
									$rmaBody .= $rmaDevices;
									$rmaBody .= '</p>';
			$rmaFrom = $_SESSION['displayname'] . " <" . $_SESSION['mail'] . ">";
			$rmaSubject = "Customer return request " . $ticketID . " (" . $rowRma4['facilityName'] . ")";
			$createDate = date('Y-m-d H:i:s');
			$dueDate = (date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"))));
			$rmaBodyInsert = nl2br(stripslashes(fix_apos("'", "''", $rmaBody)));
			switch($rowRma4['TypeOfSale']) {
				case 1:
					//HomeFree RMA Tasks
					$subjectSales = nl2br(stripslashes(fix_apos("'", "''", "Approval required - " . $rmaSubject)));
					$subjectWarehouse = nl2br(stripslashes(fix_apos("'", "''", "Call tag - " . $rmaSubject)));
					$qryRma6 = "DELETE FROM taskinfo WHERE ticketNum = '$ticketID' AND Status = '1' AND Type = '28'";
					mysql_select_db($dbname2);
					mysql_query($qryRma6) or die("HF qryRma6a: ".mysql_error());
					mysql_select_db($dbname);
					$query11 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticketID' AND Warranty IN (1, 4)"; #Problem Warrantied
					$result11 = mysql_query($query11) or die("HF query11: ".mysql_error());
					$count11 = mysql_num_rows($result11);
					$query12 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticketID' AND Warranty IN (2, 3, 5)"; #Problem NOT Warrantied
					$result12 = mysql_query($query12) or die("Query 12: " . mysql_error());
					$count12 = mysql_num_rows($result12);
					if($count11 > 0 && $count12 == 0) { # If all devices are warrantied
						$query8 = "SELECT f_name, l_name, email FROM employees WHERE (((dept = 5) OR (recRmaEmail = 1)) AND active = 0)";
						$result8 = mysql_query($query8) or die("HF query8: ".mysql_error());
						$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectWarehouse', '2', '1', '$rmaBodyInsert', '$createDate', '$dueDate', '2001', '$_SESSION[uid]', '$ticketID', '$rowRma4[facilityID]')";
						$query7 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectSales', '2', '1', '$rmaBodyInsert', '$createDate', '$dueDate', '2000', '$_SESSION[uid]', '$ticketID', '$rowRma4[facilityID]')";
						mysql_select_db($dbname2);
						mysql_query($query6) or die("HF 6a: ".mysql_error());
						mysql_query($query7) or die("HF query7: ".mysql_error());
						mysql_select_db($dbname);
					} elseif($count11 > 0 && $count12 > 0) { # If some devices are warranty and some not warranty
						$query8 = "SELECT f_name, l_name, email FROM employees WHERE (((dept = 5) OR (recRmaEmail = 1)) AND active = 0)";
						$result8 = mysql_query($query8) or die("HF query8: ".mysql_error());
						if($preApp > 0) {
							$rmaBody .= '<b>** ' . $count12 . ' device(s) need repair approvals **</b><br />';
							$rmaBodyInsert .= '<b>** ' . $count12 . ' device(s) need repair approvals **</b><br />';
						}
						$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectWarehouse', '2', '1', '$rmaBodyInsert', '$createDate', '$dueDate', '2001', '$_SESSION[uid]', '$ticketID', '$rowRma4[facilityID]')";
						$query7 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectSales', '2', '1', '$rmaBodyInsert', '$createDate', '$dueDate', '2000', '$_SESSION[uid]', '$ticketID', '$rowRma4[facilityID]')";
						mysql_select_db($dbname2);
						mysql_query($query6) or die("6b: ".mysql_error());
						mysql_query($query7) or die("HF query7: ".mysql_error());
						mysql_select_db($dbname);
					} elseif($count11 == 0 && $count12 > 0) { # If all devices are not warranty
						$query8 = "SELECT f_name, l_name, email FROM employees WHERE recRmaEmail = 1 AND active = 0";
						$result8 = mysql_query($query8) or die("HF query8: ".mysql_error());
						if($preApp > 0) {
							$rmaBody .= '<b>** ' . $count12 . ' device(s) need repair authorization **</b><br />';
							$rmaBodyInsert .= '<b>** ' . $count12 . ' device(s) need repair authorization **</b><br />';
						}
						$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectSales', '2', '1', '$rmaBodyInsert', '$createDate', '$dueDate', '2000', '$_SESSION[uid]', '$ticketID', '$rowRma4[facilityID]')";
						mysql_select_db($dbname2);
						mysql_query($query6) or die("6c: ".mysql_error());
						mysql_select_db($dbname);
					}
					break;
				case 2:
					//Direct Supply RMA tasks
					$qryRma6 = "DELETE FROM taskinfo WHERE ticketNum = '$ticketID' AND Status = '1' AND Type = '28'";
					mysql_select_db($dbname2);
					mysql_query($qryRma6) or die(mysql_error());
					mysql_select_db($dbname);
					$query11 = "SELECT ID FROM rmaDevices WHERE TicketID = '$ticketID' AND Warranty = 2 AND Device NOT IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')"; #Problem NOT Warrantied
					$result11 = mysql_query($query11);
					$count11 = mysql_num_rows($result11);
					$query12 = "SELECT ID FROM rmaDevices WHERE TicketID = '$ticketID' AND Warranty = 2 AND Device IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')"; #Problem NOT Warrantied
					$result12 = mysql_query($query12) or die("Query 12: " . mysql_error());
					$count12 = mysql_num_rows($result12);
					if($count12 > 0) {
						$subjectInsert = nl2br(stripslashes(fix_apos("'", "''", "PO required - " . $rmaSubject)));
					} elseif($count12 == 0 && $count11 > 1) {
						$subjectInsert = nl2br(stripslashes(fix_apos("'", "''", "NO RETURN Purchase replacements - " . $rmaSubject)));
					} else {
						$subjectInsert = nl2br(stripslashes(fix_apos("'", "''", $rmaSubject)));
					}
					$query8 = "SELECT f_name, l_name, email FROM employees WHERE recRmaEmail = 1 AND active = 0";
					$result8 = mysql_query($query8);
					$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
										VALUES ('28', '$subjectInsert', '2', '1', '$rmaBodyInsert', '$createDate', '$dueDate', '2000', '$_SESSION[uid]', '$ticketID', '$rowRma4[facilityID]')";
					mysql_select_db($dbname2);
					mysql_query($query6) or die("6: ".mysql_error());
					mysql_select_db($dbname);
					break;
			}
			
			//Send emails
			if(isset($result8)) {
				$num8 = mysql_num_rows($result8);
			} else {
				$num8 = 0;
			}
			if($num8 > 0) {
				while($row8 = mysql_fetch_array($result8)) {
					$to[] = $row8['f_name'] . " " . $row8['l_name'] . "<" . $row8['email'] . ">";
				}
				$headers = array ('From' => $rmaFrom,
					'To' => $to,
					'Subject' => $rmaSubject,
					'Content-type' => $type);
				$smtp = Mail::factory('smtp',
					array ('host' => $SmtpHost,
					'auth' => true,
					'username' => $SmtpUsername,
					'password' => $SmtpPassword));
		
				$mail = $smtp->send($to, $headers, $rmaBody);
			
				if (PEAR::isError($mail)) {
					die(header('Location: ../cspUserSupport_TicketDetail.php?ticketID=' . $ticketID . '&msgID=16'));
				}
			}
			$qryRma3 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
									VALUES ('$ticketID', '$rmaDevices', '$agent', '$date', '10')";
			mysql_query($qryRma3) or die(mysql_error());
		} else {
			//If no devices are present make sure ticket is not labeled as RMA from a previous close -- STATUS 4
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
			// Cancel any tasks that may exist from previously processing an RMA
			$qryRma6 = "UPDATE taskinfo 
									SET Status = '4' 
									WHERE ticketNum = '$ticketID' AND Status = '1' AND Type = '28'";
			mysql_select_db($dbname2);
			mysql_query($qryRma6) or die("Cancel Tasks: ".mysql_error());
			mysql_select_db($dbname);
		}
	}
}
?>