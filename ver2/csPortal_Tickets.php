﻿<?php
$message="";
$sysMsg="";

//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

//$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
//$url = urlencode(!empty($query) ? " $host$self?$query" : " $host$self");
$url = urlencode(!empty($query) ? " $self?$query" : " $self");

if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	require_once 'includes/config.inc.php';
	require_once 'includes/db_connect.inc.php';
	mysql_query($queryLog);
	include 'includes/db_close.inc.php';
	die(header("Location: csPortal_Login.php?url=" . $url));
}
else
{
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
	
	require_once 'includes/config.inc.php';
	require_once 'includes/db_connect.inc.php';
	
	if(isset($_GET['msgID']))
	{
		$sysMsg = $portalMsg[$_GET['msgID']][$lang];
	}
	
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	$mail = $_SESSION['mail'];
	
	$query10 = "SELECT ID, f_name, l_name, dept, warr_prog FROM employees WHERE email = '$mail'";
	$result10 = mysql_query($query10);
	$row10 = mysql_fetch_array($result10);
	$user = $_SESSION['uid'];
	$curTime = date('H:i:s');
	$bgnTime = date('H:i:s', mktime(6, 40, 0, 0, 0, 0));
	$endTime = date('H:i:s', mktime(17, 20, 0, 0, 0, 0));
	
	if(isset($_GET['cust_num'])) {
		$custNum = $_GET['cust_num'];
	}

	include 'includes/functions.inc.php';
//	require_once "Mail.php";
	
	if((isset($_GET['action'])) && ($_GET['action'] == "removeDevice"))
	{
		$deviceID = $_GET['deviceID'];
		$ticketNum = $_GET['ticket_num'];
		$query30 = "DELETE FROM rmaDevices WHERE ID = '$deviceID' LIMIT 1";
		if(mysql_query($query30)) {
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?ticket_num=" . $ticketNum . "&by_ticket=Lookup&msgID=0"));
		} else {
			die(mysql_error());
		}
	}
	
	if(isset($_GET['sbmRmaDevice'])) {
		$deviceType = nl2br(stripslashes(fix_apos("'", "''", $_GET['deviceType'])));
		$serialNumber = $_GET['serialNumber'];
		$problemDesc = nl2br(stripslashes(fix_apos("'", "''", $_GET['problemDesc'])));
		$warrantyStatus = $_GET['warrantyStatus'];
		$ticketNum = $_GET['ticketNum'];
		$query = "INSERT INTO rmaDevices (SN, TicketID, Device, Problem, Warranty)
							VALUES ('$serialNumber', '$ticketNum', '$deviceType', '$problemDesc', '$warrantyStatus')";
		if(mysql_query($query)) {
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?ticket_num=" . $ticketNum . "&by_ticket=Lookup&msgID=0"));
		} else {
			die(mysql_error());
		}
	}
	
	if(isset($_GET['saveUpdRemark']))
	{
		$ticketID = $_GET['ticket_num'];
		$remarkID = $_GET['remarkID'];
		$date = date('Y-m-d H:i:s');
		$remark = nl2br(stripslashes(fix_apos("'", "''", $_GET['updatedRemark'])));
		$query = "UPDATE tblticketmessages SET Message = '$remark', Date = '$date' WHERE ID = '$remarkID' LIMIT 1";
		if(mysql_query($query))
		{
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?ticket_num=" . $ticketID . "&by_ticket=Lookup&msgID=0"));
		}
		else
		{
			$sysID = mysql_error();
		}
	}
	
	if(isset($_GET['saveUpdDesc']))
	{
		$ticketID = $_GET['ticket_num'];
		$ticketType = $_GET['ticketType'];
		$warrantyAct = "";
		if(isset($_GET['warrantyAct']))
		{
			$warrantyAct = $_GET['warrantyAct'];
		}
		$description = nl2br(stripslashes(fix_apos("'", "''", $_GET['prob_desc'])));
		$contact = $_GET['contact'];
		$contact_num = $_GET['contact_num'];
		$contact_ext = $_GET['contact_ext'];
		$query = "UPDATE tbltickets SET Contact = '$contact', ContactPhone = '$contact_num', Extension = '$contact_ext', Summary = '$description', Type = '$ticketType', warrantyActivity = '$warrantyAct' WHERE ID = '$ticketID' LIMIT 1";
		if(mysql_query($query))
		{
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?ticket_num=" . $ticketID . "&by_ticket=Lookup&msgID=0"));
		}
		else
		{
			$sysMsg = mysql_error();
		}
	}

	if(isset($_GET['by_ticket']))
	{
		$ticket_num = $_GET['ticket_num'];
		$query = "SELECT ID, CustomerNumber FROM tblTickets WHERE ID = '$ticket_num'";
		$result = mysql_query($query) or die ('Error retrieving Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
		$row = mysql_fetch_array($result);
		$query88 = "SELECT ID FROM rmadevices WHERE TicketID = '$ticket_num'";
		$result88 = mysql_query($query88);
		$num88 = mysql_num_rows($result88);
		$custNum = $row['CustomerNumber'];
		$query2 = "SELECT * FROM tblTickets WHERE ID = '$ticket_num'";
		$result2 = mysql_query($query2) or die (mysql_error());
		$query21 = "SELECT ID, DateOpened FROM tblTickets WHERE ID = '$ticket_num' AND Status <> -1";
		$result21 = mysql_query($query21) or die (mysql_error());
		$num21 = mysql_num_rows($result21);
	}

	if(isset($_GET['by_cust']))
	{
		$cust_num = $_GET['cust_num'];
		$query = "SELECT ID, CustomerNumber FROM tblTickets WHERE CustomerNumber = '$cust_num' AND Status <> 1 LIMIT 5";
		$result = mysql_query($query) or die ('Error retrieving Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
		$row = mysql_fetch_array($result);
		$query2 = "SELECT * FROM tblTickets WHERE CustomerNumber = '$cust_num' AND Status <> 1 ORDER BY id DESC LIMIT 5";
		$result2 = mysql_query($query2) or die (mysql_error());
	}
	
	
	if((isset($_GET['action'])) && ($_GET['action'] == "createTicket"))
	{
		$f_id = $_GET['f_id'];
		$contact = $_GET['contact'];
		$date = date('Y-m-d H:i:s');
		$contact_num = $_GET['contact_num'];
		$contact_ext = $_GET['contact_ext'];
		$ticketType = $_GET['ticketType'];
		$warrantyAct = "";
		if(isset($_GET['warrantyAct']))
		{
			$warrantyAct = $_GET['warrantyAct'];
		}
		$summary = nl2br(stripslashes(fix_apos("'", "''", $_GET['prob_desc'])));
		$query = "INSERT INTO tblTickets (CustomerNumber, Contact, ContactPhone, Extension, Summary, OpenedBy, DateOpened, Type, warrantyActivity) VALUES ('$f_id', '$contact', '$contact_num', '$contact_ext', '$summary', '$user', '$date', '$ticketType', '$warrantyAct')";
		if(mysql_query($query))
		{
			$query7 = "SELECT MAX(id) FROM tblTickets WHERE CustomerNumber = '$f_id'";
			$result7 = mysql_query($query7);
			$row7 = mysql_fetch_array($result7);
			$query6 = "SELECT * FROM notifications WHERE reference = '$f_id'";
			$result6 = mysql_query($query6);
			$num6 = mysql_num_rows($result6);
			if($num6 > 0)
			{
				while($row6 = mysql_fetch_array($result6)) {
					if($row6['usrType'] == 1) {
						$usrID = $row6['usrID'];
						$query8 = "SELECT f_name, l_name, email FROM employees WHERE id = '$usrID' AND active = 0";
						$result8 = mysql_query($query8);
						$num8 = mysql_num_rows($result8);
					}
					elseif($row6['usrType'] == 2) {
						$usrID = $row6['usrID'];
						$query8 = "SELECT f_name, l_name, email FROM clients WHERE id = '$usrID' AND active = 0";
						$result8 = mysql_query($query8);
						$num8 = mysql_num_rows($result8);
					}
					if($num8 > 0) {
						$query9 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custNum'";
						$result9 = mysql_query($query9);
						$row9 = mysql_fetch_array($result9);
						$facility = $row9['FacilityName'];
						while($row8 = mysql_fetch_array($result8)) {
							$from = "HomeFree Support <support@homefreesys.com>";
							$to =  $row8['f_name'] . " " . $row8['l_name'] . "<" . $row8['email'] . ">";
							$subject = "Ticket Number " . $row7['MAX(id)'] . " Has Been Opened";
							$body = '<font face="Arial" size="2">' . $row8['f_name'] . ' ' . $row8['l_name'] . 
											',<p>You are enrolled in our email update program. If you are receiving the message in error please reply to this
											email or please contact HomeFree at (414)358-8200 and let a HomeFree support representative know you would like to be removed.</p>
											<p>This message was automatically generated to provide you with the following support information:</font></p>
											<p><fieldset><legend><b><font face="Arial" size="2">Ticket Details:</b></font></legend>
											<dl>
											<dt><font face="Arial" size="2">Facility:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $facility . '</font></dd>
											<dt><font face="Arial" size="2">Reason Opened:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $summary . '</font></dd>
											<dt><font face="Arial" size="2">Opened By:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $name . '</font></dd>
											</dl>
											</fieldset></p>';

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
  							die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=16'));
 							}
 						}
 					}
				}
			}
			die(header('Location: '.$_SERVER['PHP_SELF'].'?ticket_num='.$row7['MAX(id)'].'&by_ticket=Lookup&msgID=0'));
		}
		else
		{
			die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=1'));
		}
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "cancelTicket"))
	{
		$f_id = $_GET['f_id'];
		$ticket_id = $_GET['ticket_id'];
		mysql_select_db($dbname2);
		$query5 = "SELECT Count(ID) FROM taskinfo WHERE (ticketNum = '$ticket_id') AND (Status != 3)";
		$result5 = mysql_query($query5) or die(mysql_error());
		$row5 = mysql_fetch_assoc($result5);
		$num5 = $row5['Count(ID)'];
		mysql_select_db($dbname);
		if($num5 != 0) {
			$query3 = "UPDATE taskinfo SET Status = 4 WHERE (ticketNum = '$ticket_id') AND (Status != 3)";
			mysql_select_db($dbname2);
			//mysql_query($query3) or die(mysql_error());
			if(!(mysql_query($query3))) {
				mysql_select_db($dbname);
				$userName = $_SESSION['username'];
				$agent = $_SERVER['HTTP_USER_AGENT'];
				$statement = nl2br(stripslashes(fix_apos("'", "''", 'mySql Error: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].'; Error: '.mysql_error())));
				$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$userName', '$statement', '$agent', CURDATE(), CURTIME())";
				mysql_query($queryLog); 
				die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=1'));
			}
		}
		mysql_select_db($dbname);
		$query = "UPDATE tbltickets SET Status = 1 WHERE ID = '$ticket_id' LIMIT 1";
		$query2 = "UPDATE tblticketmessages SET onCancelledTicket = 1 WHERE TicketID = '$ticket_id'";
		if(mysql_query($query) && mysql_query($query2))
		{
			die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=0'));
		} else {
			die(mysql_error());
			$userName = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = nl2br(stripslashes(fix_apos("'", "''", 'mySql Error: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].'; Error: '.mysql_error())));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$userName', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog); 
			die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=1'));
		}
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "reopenTicket"))
	{
		$f_id = $_GET['f_id'];
		$ticket_id = $_GET['ticket_id'];
		$query = "UPDATE tblTickets SET Status = 0, DateClosed = NULL, ClosedBy = NULL WHERE ID = $ticket_id LIMIT 1";
		$query2 = "UPDATE tblticketmessages SET onCancelledTicket = 0 WHERE TicketID = '$ticket_id'";
		if(mysql_query($query) && mysql_query($query2))
		{
			die(header('Location: '.$_SERVER['PHP_SELF'].'?ticket_num='.$ticket_id.'&by_ticket=Lookup&msgID=0'));
		} else {
			$userName = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = nl2br(stripslashes(fix_apos("'", "''", 'mySql Error: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].'; Error: '.mysql_error())));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$userName', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog);
			die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=1'));
			//die(mysql_error());
		}
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "escalateTicket"))
	{
		$f_id = $_GET['f_id'];
		$ticket_id = $_GET['ticket_id'];
		$query = "UPDATE tblTickets SET Status = 2 WHERE ID = '$ticket_id' LIMIT 1";
		$ticketUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		if(mysql_query($query))
		{
			$query2 = "SELECT * FROM tblTickets WHERE ID = '$ticket_id'";
			$result2 = mysql_query($query2);
			$row2 = mysql_fetch_array($result2);
			$query8 = "SELECT f_name, l_name, email FROM employees WHERE recEscTicket = 1 AND active = 0";
			$result8 = mysql_query($query8);
			$num8 = mysql_num_rows($result8);
			if($num8 > 0) {
				while($row8 = mysql_fetch_array($result8)) {
					$query9 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custNum'";
					$result9 = mysql_query($query9);
					$row9 = mysql_fetch_array($result9);
					$facility = $row9['FacilityName'];
					$from = $name . " <" . $_SESSION['mail'] . ">";
					$to =  $row8['f_name'] . " " . $row8['l_name'] . "<" . $row8['email'] . ">";
					$subject = "Ticket Number " . $ticket_id . " Has Been Escalated";
					$body = '<font face="Arial" size="2">' . $row8['f_name'] . ' ' . $row8['l_name'] . 
									',<p><b>Ticket <a href="' . $ticketUrl . '?ticket_num=' . $ticket_id . '&by_ticket=ticket&submit=Lookup">' . $ticket_id . '</a> has been escalated:</font></p>
									<p><fieldset><legend><b><font face="Arial" size="2">Ticket Details:</b></font></legend>
									<dl>
									<dt><font face="Arial" size="2">Facility:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $facility . '</font></dd>
									<dt><font face="Arial" size="2">Reason Opened:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $row2['Summary'] . '</font></dd>
									<dt><font face="Arial" size="2">Escalated By:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $name . '</font></dd>
									</dl>
									</fieldset></p>';

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
						die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=16'));
					}
				}
			}
			die(header('Location: '.$_SERVER['PHP_SELF'].'?ticket_num='.$ticket_id.'&by_ticket=Lookup&msgID=0'));
		} else {
			$userName = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = nl2br(stripslashes(fix_apos("'", "''", 'mySql Error: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].'; Error: '.mysql_error())));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$userName', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog);
			die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=1'));
		}
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "processRMA"))
	{
		$f_id = $_GET['f_id'];
		$ticket_id = $_GET['ticket_id'];
		$query2 = "SELECT * FROM tblTickets WHERE ID = '$ticket_id'";
		$result2 = mysql_query($query2);
		$row2 = mysql_fetch_array($result2);
		$query9 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$f_id'";
		$result9 = mysql_query($query9);
		$row9 = mysql_fetch_array($result9);
		$query28 = "SELECT * FROM devicelist";
		$result28 = mysql_query($query28);
		$facility = $row9['FacilityName'];
		$query = "SELECT TypeOfSale FROM tblFacilities WHERE CustomerNumber = '$f_id'";
		$query32 = "UPDATE tblTickets SET rmaReturn = '1' WHERE ID = $ticket_id";
		mysql_query($query32) or die(mysql_error());
		$ticketUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$query4 = "SELECT * FROM tblTicketMessages WHERE TicketID = $ticket_id";
		$result4 = mysql_query($query4);
		$query5 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticket_id'";
		$result5 = mysql_query($query5);
		$body = '<font face="Arial" size="2">Employee,' . 
						'<p>Customer return has been requested for ticket <a href="' . $ticketUrl . '?ticket_num=' . $ticket_id . '&by_ticket=ticket&submit=Lookup">' . $ticket_id . '</a></font></p>
						<font face="Arial" size="2"><b><u>Return Details</b></u></font><br />
						<font face="Arial" size="2">Facility: </font><font face="Arial" size="2" color="#666666">' . $facility . '</font><br />
						<font face="Arial" size="2">Contact: </font><font face="Arial" size="2" color="#666666">' . $row2['Contact'] . '</font><br />
						<font face="Arial" size="2">Reason Opened: </font><font face="Arial" size="2" color="#666666">' . $row2['Summary'] . '</font><br />';
						while($row4 = mysql_fetch_array($result4)) {
							$body .= '<font face="Arial" size="2">Technican Remarks: </font><font face="Arial" size="2" color="#666666">' . $row4['Message'] . '</font><br />';
						}
						$body .= '<font face="Arial" size="2"><u>Device Details</u></font><br />';
						while($row5 = mysql_fetch_array($result5)) {
							if($row5['Warranty'] == 1) {
								$warranty = "Problem Warrantied";
							} elseif($row5['Warranty'] == 2) {
								$warranty = "NOT Warrantied - Return for repair";
							} elseif($row5['Warranty'] == 3) {
								$warranty = "NOT Warrantied - Purchase replacement";
							}
							mysql_data_seek($result28, 0);
							while($row28 = mysql_fetch_array($result28)) {
								if($row28['part#'] == $row5['Device']){
									$deviceName = $row28['partDesc'];
								}
							}
							$body .= '<font face="Arial" size="2">' . $deviceName . ' (' . $row5['SN'] . ') - ' . $warranty . '</font><br />';
						}
		$body .= '</p>';
		$from = $name . " <" . $_SESSION['mail'] . ">";
		$subject = "Customer return request " . $ticket_id . " (" . $facility . ")";
		if($result = mysql_query($query))
		{
			$row = mysql_fetch_array($result);
			$createDate = date('Y-m-d H:i:s');
			$dueDate = (date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"))));
			$bodyInsert = nl2br(stripslashes(fix_apos("'", "''", $body)));
			mysql_select_db($dbname2);
			$query10 = "SELECT Count(ID) FROM taskinfo WHERE ticketNum = '$ticket_num' AND Status = '1' AND Type = '28'";
			$result10 = mysql_query($query10);
			$row10 = mysql_fetch_assoc($result10);
			$num10 = $row10['Count(ID)'];
			$subjectSales = nl2br(stripslashes(fix_apos("'", "''", "Approval required - " . $subject)));
			$subjectWarehouse = nl2br(stripslashes(fix_apos("'", "''", "Call tag - " . $subject)));
			mysql_select_db($dbname);
			if((is_null($row['TypeOfSale'])) OR ($row['TypeOfSale'] == 0)) {
				die(header('Location: '.$_SERVER['PHP_SELF'].'?ticket_num='.$ticket_id.'&by_ticket=Lookup&msgID=21'));
			} elseif ($row['TypeOfSale'] == 2) { //Direct Supply RMA process
				$query11 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticket_id' AND Warranty = 2 AND Device NOT IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')"; #Problem NOT Warrantied
				$result11 = mysql_query($query11);
				$count11 = mysql_num_rows($result11);
				$query12 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticket_id' AND Warranty = 2 AND Device IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')"; #Problem NOT Warrantied
				$result12 = mysql_query($query12) or die("Query 12: " . mysql_error());
				$count12 = mysql_num_rows($result12);
				if($count12 > 0) {
					$subjectInsert = nl2br(stripslashes(fix_apos("'", "''", "PO required - " . $subject)));
				} elseif($count12 == 0 && $count11 > 1) {
					$subjectInsert = nl2br(stripslashes(fix_apos("'", "''", "NO RETURN Purchase replacements - " . $subject)));
				} else {
					$subjectInsert = nl2br(stripslashes(fix_apos("'", "''", $subject)));
				}
				$query8 = "SELECT f_name, l_name, email FROM employees WHERE recRmaEmail = 1 AND active = 0";
				$result8 = mysql_query($query8);
				if($num10 == 0) {
					$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
										VALUES ('28', '$subjectInsert', '2', '1', '$bodyInsert', '$createDate', '$dueDate', '2000', '$_SESSION[uid]', '$ticket_id', '$f_id')";
				} else {
					$query6 = "UPDATE taskinfo SET Description = '$bodyInsert', Createdby = '$_SESSION[uid]' WHERE ticketNum = '$ticket_id'";
				}
				mysql_select_db($dbname2);
				mysql_query($query6) or die("6: ".mysql_error());
				mysql_select_db($dbname);
			} else { // HomeFree RMA process
				$query11 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticket_id' AND Warranty = '1'"; #Problem Warrantied
				$result11 = mysql_query($query11);
				$count11 = mysql_num_rows($result11);
				$query12 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticket_id' AND Warranty = 2 AND Device IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')"; #Problem NOT Warrantied
				$result12 = mysql_query($query12) or die("Query 12: " . mysql_error());
				$count12 = mysql_num_rows($result12);
				if($count11 > 0 && $count12 == 0) { # If all devices are warrantied
					$query8 = "SELECT f_name, l_name, email FROM employees WHERE dept = 5 AND active = 0";
					$result8 = mysql_query($query8);
					if($num10 == 0) {
						$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectWarehouse', '2', '1', '$bodyInsert', '$createDate', '$dueDate', '2001', '$_SESSION[uid]', '$ticket_id', '$f_id')";
					} else {
						$query6 = "UPDATE taskinfo SET Description = '$bodyInsert', Createdby = '$_SESSION[uid]' WHERE ticketNum = '$ticket_id'";
					}
					mysql_select_db($dbname2);
					mysql_query($query6) or die("6a: ".mysql_error());
					mysql_select_db($dbname);
				} elseif($count11 > 0 && $count12 > 0) { # If some devices are warranty and some not warranty but need pre-approval
					$query8 = "SELECT f_name, l_name, email FROM employees WHERE (((dept = 5) OR (recRmaEmail = 1)) AND active = 0)";
					$result8 = mysql_query($query8);
					$body .= '<font face="Arial" size="2"><b>**' . $count12 . ' device(s) need repair approvals**</b></font><br />';
					if($num10 == 0) {
						$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectWarehouse', '2', '1', '$bodyInsert', '$createDate', '$dueDate', '2001', '$_SESSION[uid]', '$ticket_id', '$f_id')";
						$query7 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectSales', '2', '1', '$bodyInsert', '$createDate', '$dueDate', '2000', '$_SESSION[uid]', '$ticket_id', '$f_id')";
						mysql_select_db($dbname2);
						mysql_query($query6) or die("6b: ".mysql_error());
						mysql_query($query7) or die(mysql_error());
						mysql_select_db($dbname);
					} elseif($num10 == 2) {
						$query6 = "UPDATE taskinfo SET Description = '$bodyInsert', Createdby = '$_SESSION[uid]' WHERE ticketNum = '$ticket_id' AND Status = '1' AND Type = '28'";
						mysql_select_db($dbname2);
						mysql_query($query6) or die("6b: ".mysql_error());
						mysql_select_db($dbname);
					} elseif($num10 == 1) {
						$query6 = "UPDATE taskinfo SET Subject = '$subjectWarehouse', Description = '$bodyInsert', Response = '2001', Createdby = '$_SESSION[uid]' WHERE ticketNum = '$ticket_id' AND Status = '1' AND Type = '28'";
						$query7 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectSales', '2', '1', '$bodyInsert', '$createDate', '$dueDate', '2000', '$_SESSION[uid]', '$ticket_id', '$f_id')";
						mysql_select_db($dbname2);
						mysql_query($query6) or die("6b: ".mysql_error());
						mysql_query($query7) or die(mysql_error());
						mysql_select_db($dbname);
					}
				} elseif($count11 == 0 && $count12 > 0) { # If devices are not warranty and need pre-approval
					$query8 = "SELECT f_name, l_name, email FROM employees WHERE recRmaEmail = 1 AND active = 0";
					$result8 = mysql_query($query8);
					$body .= '<font face="Arial" size="2"><b>**' . $count12 . ' device(s) need repair authorization**</b></font><br />';
					if($num10 == 0) {
						$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, ticketNum, CustomerNumber)
											VALUES ('28', '$subjectSales', '2', '1', '$bodyInsert', '$createDate', '$dueDate', '2000', '$_SESSION[uid]', '$ticket_id', '$f_id')";
					} else {
						$query6 = "UPDATE taskinfo SET Description = '$bodyInsert', Createdby = '$_SESSION[uid]' WHERE ticketNum = '$ticket_id'";
					}
					mysql_select_db($dbname2);
					mysql_query($query6) or die("6c: ".mysql_error());
					mysql_select_db($dbname);
				}
			}
			if(isset($result8)) {
				$num8 = mysql_num_rows($result8);
			} else {
				$num8 = 0;
			}
			if($num8 > 0) {
				while($row8 = mysql_fetch_array($result8)) {
					$to[] = $row8['f_name'] . " " . $row8['l_name'] . "<" . $row8['email'] . ">";
				}
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
					die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=16'));
				}
			}
			$query26 = "INSERT INTO tblticketmessages (TicketID, Message, EnteredBy, Date)
									VALUES ('$ticket_id', 'RMA processed', '$_SESSION[uid]', '$createDate')";
			mysql_query($query26) or die(mysql_error());
			die(header('Location: '.$_SERVER['PHP_SELF'].'?f_id='.$f_id.'&ticket_id='.$ticket_id.'&action=closeTicket&by_ticket=Lookup&ticket_num='.$ticket_id));
		} else {
			$userName = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = nl2br(stripslashes(fix_apos("'", "''", 'mySql Error: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].'; Error: '.mysql_error())));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$userName', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog);
			die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=1'));
		}
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "closeTicket"))
	{
		$f_id = $_GET['f_id'];
		$ticket_id = $_GET['ticket_id'];
		$date = date('Y-m-d H:i:s');
		$query = "UPDATE tblTickets SET Status = -1, DateClosed = '$date', ClosedBy = '$user' WHERE ID = $ticket_id LIMIT 1";
		$qryMsgNum = "SELECT Count(ID) AS MsgCount FROM tblTicketMessages WHERE TicketID = $ticket_id";
		$rstMsgNum = mysql_query($qryMsgNum);
		$rowMsgNum = mysql_fetch_array($rstMsgNum);
		$msgCount = $rowMsgNum['MsgCount'];
		if($msgCount > 0) {
			if(mysql_query($query))
			{
				$query6 = "SELECT * FROM notifications WHERE reference = '$f_id'";
				$result6 = mysql_query($query6);
				$num6 = mysql_num_rows($result6);
				if($num6 > 0)
				{
					while($row6 = mysql_fetch_array($result6)) {
						if($row6['usrType'] == 1) {
							$usrID = $row6['usrID'];
							$query8 = "SELECT f_name, l_name, email FROM employees WHERE id = '$usrID' AND active = 0";
							$result8 = mysql_query($query8);
							$num8 = mysql_num_rows($result8);
						}
						elseif($row6['usrType'] == 2) {
							$usrID = $row6['usrID'];
							$query8 = "SELECT f_name, l_name, email FROM clients WHERE id = '$usrID' AND active = 0";
							$result8 = mysql_query($query8);
							$num8 = mysql_num_rows($result8);
						}
						if($num8 > 0) {
							$query9 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custNum'";
							$result9 = mysql_query($query9);
							$row9 = mysql_fetch_array($result9);
							$facility = $row9['FacilityName'];
							while($row8 = mysql_fetch_array($result8)) {
								$from = "HomeFree Support <support@homefreesys.com>";
								$to =  $row8['f_name'] . " " . $row8['l_name'] . "<" . $row8['email'] . ">";
								$subject = "Ticket Number " . $ticket_id . " Has Been Closed";
								$body = '<font face="Arial" size="2">' . $row8['f_name'] . ' ' . $row8['l_name'] . 
												',<p>You are enrolled in our email update program. If you are receiving the message in error please reply to this
												email or please contact HomeFree at (414)358-8200 and let a HomeFree support representative know you would like to be removed.</p>
												<p>This message was automatically generated to provide you with the following support information:</font></p>
												<p><fieldset><legend><b><font face="Arial" size="2">Ticket Details:</b></font></legend>
												<dl>
												<dt><font face="Arial" size="2">Facility:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $facility . '</font></dd>
												<dt><font face="Arial" size="2">Status Changed To:</font></dt><dd><font face="Arial" size="2" color="#666666">Closed</font></dd>
												</dl>
												</fieldset></p>';
						
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
	  							die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=16'));
	 							}
	 						}
	 					}
					}
				}
				die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=0'));
			}
			else
			{
				$userName = $_SESSION['username'];
				$agent = $_SERVER['HTTP_USER_AGENT'];
				$statement = nl2br(stripslashes(fix_apos("'", "''", 'mySql Error: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].'; Error: '.mysql_error())));
				$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$userName', '$statement', '$agent', CURDATE(), CURTIME())";
				mysql_query($queryLog);
				die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=1'));
			}
		} else {
			die(header('Location: '.$_SERVER['PHP_SELF'].'?ticket_num='.$ticket_id.'&by_ticket=Lookup&msgID=20'));
		}
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "schFollowUp"))
	{
		$ticket_num = $_GET['ticket_num'];
		$fuDate = $_GET['fuDate'];
		$fuUID = $_SESSION['uid'];
		$cust_name = $_GET['cust_name'];
		$qryScheduleFU = "UPDATE tblTickets SET FollowUp = -1, DateFollowUp = '$fuDate', UidFollowUp = '$fuUID' WHERE ID = '$ticket_num'";
		$rstScheduleFU = mysql_query($qryScheduleFU);
		if($rstScheduleFU) {
			die(header('Location: phpToICS.php?ticket_num='.$ticket_num.'&fuDate='.$fuDate.'&cust_name='.$cust_name));
		}
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "remFollowUp"))
	{
		$ticket_id = $_GET['ticket_id'];
		$fuUID = $_SESSION['uid'];
		$qryScheduleFU = "UPDATE tblTickets SET FollowUp = 0, DateFollowUp = NULL, UidFollowUp = '$fuUID' WHERE ID = '$ticket_num'";
		$rstScheduleFU = mysql_query($qryScheduleFU);
		if($rstScheduleFU) {
			die(header('Location: '.$_SERVER['PHP_SELF'].'?ticket_num='.$ticket_id.'&by_ticket=Lookup&msgID=0'));
		}
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "saveRemark"))
	{
		$custNum = $_GET['cust_num'];
		$ticket_num = $_GET['ticket_num'];
		$date = date('Y-m-d H:i:s');
		$remark = nl2br(stripslashes(fix_apos("'", "''", $_GET['newRemark'])));
		$query = "INSERT INTO tblticketmessages (TicketID, Message, EnteredBy, Date) VALUES ('$ticket_num', '$remark', '$user', '$date')";
		if(mysql_query($query))
		{
			$query6 = "SELECT * FROM notifications WHERE reference = '$custNum'";
			$result6 = mysql_query($query6);
			$num6 = mysql_num_rows($result6);
			if($num6 > 0)
			{
				while($row6 = mysql_fetch_array($result6)) {
					if($row6['usrType'] == 1) {
						$usrID = $row6['usrID'];
						$query8 = "SELECT f_name, l_name, email FROM employees WHERE id = '$usrID' AND active = 0";
						$result8 = mysql_query($query8);
						$num8 = mysql_num_rows($result8);
					}
					elseif($row6['usrType'] == 2) {
						$usrID = $row6['usrID'];
						$query8 = "SELECT f_name, l_name, email FROM clients WHERE id = '$usrID' AND active = 0";
						$result8 = mysql_query($query8);
						$num8 = mysql_num_rows($result8);
					}
					if($num8 > 0) {
						$query9 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custNum'";
						$result9 = mysql_query($query9);
						$row9 = mysql_fetch_array($result9);
						$facility = $row9['FacilityName'];
						while($row8 = mysql_fetch_array($result8)) {
							$from = "HomeFree Support <support@homefreesys.com>";
							$to =  $row8['f_name'] . " " . $row8['l_name'] . "<" . $row8['email'] . ">";
							$subject = "Ticket Number " . $ticket_num . " Has Been Updated";
							$body = '<font face="Arial" size="2">' . $row8['f_name'] . ' ' . $row8['l_name'] . 
											',<p>You are enrolled in our email update program. If you are receiving the message in error please reply to this
											email or please contact HomeFree at (414)358-8200 and let a HomeFree support representative know you would like to be removed.</p>
											<p>This message was automatically generated to provide you with the following support information:</font></p>
											<p><fieldset><legend><b><font face="Arial" size="2">Ticket Details:</b></font></legend>
											<dl>
											<dt><font face="Arial" size="2">Facility:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $facility . '</font></dd>
											<dt><font face="Arial" size="2">Added Comment:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $remark . '</font></dd>
											<dt><font face="Arial" size="2">HomeFree Rep.:</font></dt><dd><font face="Arial" size="2" color="#666666">' . $name . '</font></dd>
											</dl>
											</fieldset></p>';
					
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
  							die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$custNum.'&by_cust=Lookup&msgID=16'));
 							}
 						}
 					}
				}
			}
			die(header('Location: '.$_SERVER['PHP_SELF'].'?ticket_num='.$ticket_num.'&by_ticket=Lookup&msgID=0'));
		}
		else
		{
			$userName = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = nl2br(stripslashes(fix_apos("'", "''", 'mySql Error: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].'; Error: '.mysql_error())));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$userName', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog);
			die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$custNum.'&by_cust=Lookup&msgID=1'));
		}
	}
	
	if(isset($_GET['returnAuth']))
	{
		if($_GET['returnAuth'] == 'Verified') {
			$retNote = "Returned equipment verified with ticket: " . $_GET['returnNote'];
		}elseif($_GET['returnAuth'] == 'Modified') {
			$retNote = "Returned equipment modified from ticket: " . $_GET['returnNote'];
		}elseif($_GET['returnAuth'] == 'Returned') {
			$retNote = "Returned equipment returned to customer: " . $_GET['returnNote'];
		}
		$ticket_num = $_GET['ticket_num'];
		$date = date('Y-m-d H:i:s');
		$ticketUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$remark = nl2br(stripslashes(fix_apos("'", "''", $retNote)));
		$query = "INSERT INTO tblticketmessages (TicketID, Message, EnteredBy, Date) VALUES ('$ticket_num', '$remark', '$user', '$date')";
		if(mysql_query($query))
		{
			if(($_GET['returnAuth'] == 'Verified') || ($_GET['returnAuth'] == 'Modified')) {
				$dueDate = (date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d")+7, date("Y"))));
				$query9 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custNum'";
				$result9 = mysql_query($query9);
				$row9 = mysql_fetch_array($result9);
				$facility = $row9['FacilityName'];
				mysql_select_db($dbname2);
				$query10 = "SELECT Count(ID) FROM taskinfo WHERE ticketNum = '$ticket_num' AND Status = 9";
				$result10 = mysql_query($query10);
				$row10 = mysql_fetch_assoc($result10);
				$num10 = $row10['Count(ID)'];
				$subject = "Repair ticket request " . $ticket_num . " (" . $facility . ")";
				$subject = nl2br(stripslashes(fix_apos("'", "''", $subject)));
				if($num10 == 0) {
					$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, Cancelationdate, ticketNum, CustomerNumber)
										VALUES ('11', '$subject', '2', '9', '$subject', '$date', '$dueDate', '2002', '$_SESSION[uid]', '$date', '$ticket_num', '$custNum')";
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
				} else {
					$query10 = "SELECT ID FROM taskinfo WHERE ticketNum = '$ticket_num' AND Status = 9";
					$result10 = mysql_query($query10);
					$row10 = mysql_fetch_array($result10);
					$query6 = "UPDATE tbltaskremarks SET remarks = '$remark', dateadded = '$date', addedby = '$_SESSION[uid]' WHERE taskid = '$row10[ID]' LIMIT 1";
					mysql_query($query6) or die(mysql_error());
				}
				mysql_select_db($dbname);
				$query8 = "SELECT f_name, l_name, email FROM employees WHERE manageRma = 1 AND active = 0";
				$result8 = mysql_query($query8);
				$num8 = mysql_num_rows($result8);
				if($num8 > 0) {
					while($row8 = mysql_fetch_array($result8)) {
						$to[] = $row8['f_name'] . " " . $row8['l_name'] . "<" . $row8['email'] . ">";
					}
					$from = $name . " <" . $_SESSION['mail'] . ">";
					$to = implode(', ', $to);
					$subject = "Repair ticket request " . $ticket_num . " (" . $facility . ")";
					$body = '<font face="Arial" size="2">Employee,' . 
									'<p>Customer repair requested for ticket <a href="' . $ticketUrl . '?ticket_num=' . $ticket_num . '&by_ticket=ticket&submit=Lookup">' . $ticket_num . '</a></font></p>
									<font face="Arial" size="2"><b><u>Return Details</b></u></font><br />
									<font face="Arial" size="2">Facility: </font><font face="Arial" size="2" color="#666666">' . $facility . '</font><br />
									<font face="Arial" size="2">Return Notes: </font><font face="Arial" size="2" color="#666666">' . $remark . '</font><br />';
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
						die(header('Location: '.$_SERVER['PHP_SELF'].'?cust_num='.$f_id.'&by_cust=Lookup&msgID=16'));
					}
				}
			} elseif($_GET['returnAuth'] == 'Returned') {
				$dueDate = (date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d")+7, date("Y"))));
				$query9 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custNum'";
				$result9 = mysql_query($query9);
				$row9 = mysql_fetch_array($result9);
				$facility = $row9['FacilityName'];
				$subject = "Repair ticket request " . $ticket_num . " (" . $facility . ")";
				$subject = nl2br(stripslashes(fix_apos("'", "''", $subject)));
				mysql_select_db($dbname2);
				$query10 = "SELECT Count(ID) FROM taskinfo WHERE ticketNum = '$ticket_num' AND Status = 9";
				$result10 = mysql_query($query10);
				$row10 = mysql_fetch_assoc($result10);
				$num10 = $row10['Count(ID)'];
				if($num10 == 0) {
					$query6 = "INSERT INTO taskinfo (Type, Subject, Priority, Status, Description, Createdate, Duedate, Response, Createdby, Cancelationdate, ticketNum, CustomerNumber)
										VALUES ('11', '$subject', '2', '4', '$subject', '$date', '$dueDate', '2002', '$_SESSION[uid]', '$date', '$ticket_num', '$custNum')";
					if(mysql_query($query6)) {
						$query3 = "SELECT MAX(ID) FROM taskinfo";
						if($result3 = mysql_query($query3)) {
							$row3 = mysql_fetch_array($result3);
							$newTaskID = $row3['MAX(ID)'];
							$query4 = "INSERT INTO tbltaskremarks (taskid, remarks, dateadded, addedby)
												VALUES ('$newTaskID', '$remark', '$date', '$_SESSION[uid]')";
							mysql_query($query4) or die(mysql_error());
							$query5 = "INSERT INTO tbltaskaudit (Date, User, Action, taskid, type, status, response) 
												VALUES ('$date', '$_SESSION[uid]', 'New Task', '$newTaskID', '11', '4', '2002')";
							mysql_query($query5) or die(mysql_error());
						}
					}
				} else {
					$query10 = "SELECT ID FROM taskinfo WHERE ticketNum = '$ticket_num' AND Status = 9";
					$result10 = mysql_query($query10);
					$row10 = mysql_fetch_array($result10);
					$query5 = "UPDATE taskinfo SET Status = 4 WHERE ID = '$row10[ID]'";
					mysql_query($query5) or die(mysql_error());
					$query6 = "UPDATE tbltaskremarks SET remarks = '$remark', dateadded = '$date', addedby = '$_SESSION[uid]' WHERE taskid = '$row10[ID]' LIMIT 1";
					mysql_query($query6) or die(mysql_error());
				}
				mysql_select_db($dbname);
			}
			die(header('Location: rmaRepairForm.php?ticketID='.$ticket_num.'&msgID=0'));
		} else {
			die(header('Location: '.$_SERVER['PHP_SELF'].'?ticket_num='.$ticket_num.'&by_ticket=Lookup&msgID=1'));
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Support Ticket System</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="csPortal_Layout.css" />

<?php
if(isset($_GET['by_ticket'])) {
	if($num21 > 0) {
		require_once('ActiveMonitor/config.inc.php');
		$row21 = mysql_fetch_array($result21);
		$curDate = strtotime("now");
		$DateOpened = strtotime($row21['DateOpened']);
		$query22 = "SELECT Date FROM tblticketmessages WHERE TicketID = '$ticket_num' ORDER BY Date DESC LIMIT 1";
		$result22 = mysql_query($query22) or die (mysql_error());
		$num22 = mysql_num_rows($result22);
		if($num22 > 0) {
			$row22 = mysql_fetch_array($result22);
			$DateUpdated = strtotime($row22['Date']);
			if($DateUpdated > $DateOpened) {
				$DateOpened = $DateUpdated;
			}
		}
		
		$timeActive = $curDate - $DateOpened;
		$warnActive = $warnActive * 60;
		$maxActive = $maxActive * 60;
		if($timeActive < $warnActive) {
			$MilSecToNotify = ($warnActive - $timeActive)*1000;
			$SecToNotify = $maxActive - $warnActive;
		}
		elseif(($timeActive > $warnActive) && ($timeActive < $maxActive)) {
			$MilSecToNotify = '10';
			$SecToNotify = $maxActive - $timeActive;
		}
		else
		{
			$MilSecToNotify = '0';
			$SecToNotify = '0';
		}
		$NotifyMinutes = floor($SecToNotify / 60);
		$temp_remainder = $SecToNotify - ($NotifyMinutes * 60);
		$NotifySeconds = $temp_remainder;
		$NotifyMessage = $NotifyMinutes . " Minutes " . $NotifySeconds . " Seconds";
		if((isset($_GET['by_ticket']) && (!(isset($_GET['action'])))) &&
		(($timeActive < $warnActive) || (($timeActive > $warnActive) && ($timeActive < $maxActive))) &&
		($num88 == 0)) {
		?>
		<script type="text/javascript">
			function timedMsg()
			{
			setTimeout("alert('Ticket will be marked as not active in <?php echo $NotifyMessage; ?>')",<?php echo $MilSecToNotify; ?>);
			}
		</script>
		<?php
		}
	}
}

if(isset($custNum)) {
?>
<script type="text/javascript">
	function updateStatus(str, ticket) {
		var chkFormNum = "chkFollowup"+ticket;
		if(str == -1) {
			if(document.forms[chkFormNum].fuSch.checked==false) {
				var auth = confirm("Are you sure you would like to CLOSE this ticket?")
				if(auth) {
					window.location = "<?php echo $_SERVER['PHP_SELF']; ?>?f_id=<?php echo $custNum; ?>&ticket_id="+ticket+"&action=closeTicket&by_ticket=Lookup&ticket_num="+ticket
				} else {
					window.location.reload()
				}
			} else {
				alert('You cannot close a ticket with an active follow up scheduled.')
				window.location.reload()
			}
		}
		if(str == 1) {
			var auth = confirm("Are you sure you would like to CANCEL this ticket?")
			if(auth) {
				window.location = "<?php echo $_SERVER['PHP_SELF']; ?>?f_id=<?php echo $custNum; ?>&ticket_id="+ticket+"&action=cancelTicket&by_ticket=Lookup&ticket_num="+ticket
	 		} else {
				window.location.reload()
			}
		}
		if(str == 2) {
			var auth = confirm("Are you sure you would like to ESCALATE this ticket?")
			if(auth) {
				window.location = "<?php echo $_SERVER['PHP_SELF']; ?>?f_id=<?php echo $custNum; ?>&ticket_id="+ticket+"&action=escalateTicket&by_ticket=Lookup&ticket_num="+ticket
			} else {
				window.location.reload()
			}
		}
		if(str == 3) {
			var auth = confirm("Are you sure you would like to process the RMA?")
			if(auth) {
				window.location = "<?php echo $_SERVER['PHP_SELF']; ?>?f_id=<?php echo $custNum; ?>&ticket_id="+ticket+"&action=processRMA&by_ticket=Lookup&ticket_num="+ticket
			} else {
				window.location.reload()
			}
		}
	}
</script>
<script type="text/javascript">
	function schFollowup(str, ticket) {
		var chkFormNum = "chkFollowup"+ticket;
		var disFormNum = "followUpForm"+ticket;
		if(document.forms[chkFormNum].fuSch.checked==true) {
			document.getElementById(disFormNum).style.display="inline";
		}
		if(document.forms[chkFormNum].fuSch.checked==false) {
			var auth = confirm("Are you sure you would like to clear follow-up information?")
			if(auth) {
				window.location = "<?php echo $_SERVER['PHP_SELF']; ?>?f_id=<?php echo $custNum; ?>&ticket_id="+ticket+"&action=remFollowUp&by_ticket=Lookup&ticket_num="+ticket
			} else {
				window.location.reload()
			}
		}
	}
</script>

<script type="text/javascript">
	function createAuth(str, ticket) {
		var chkFormNum = "rmaAuth"+ticket;
		var disFormNum = "rmaAuthDiv"+ticket;
		if(document.forms[chkFormNum].rmaAuth.checked==true) {
			document.getElementById(disFormNum).style.display="inline";
		}
		if(document.forms[chkFormNum].rmaAuth.checked==false) {
			document.getElementById(disFormNum).style.display="none";
		}
	}
</script>

<?php
}
?>
<script type="text/javascript">
	function changeView(str, ticket) {
		var chkFormNum = str+ticket;
		document.getElementById(chkFormNum).style.display="inline";
	}
</script>
</head>
<body onload="timedMsg()">
<div id="dhtmltooltip"></div>

<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

</script>

<SCRIPT LANGUAGE="JavaScript">
<!--
function showList() {
  sList = window.open("csPortal_ticketReports.php?action=csLookup", "list", "width=350, height=500, scrollbars=yes");
}

function remLink() {
  if (window.sList && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>

<?php
if((isset($_GET['view']) && ($_GET['view'] == "print")))
{
?>
	<table cellspacing="0" cellpadding="0" border="0" width="550" align="center">
<?php
}
else
{
?>
<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
<?php
}
?>
	<tr>
		<td>
			<?php
			if((isset($_GET['view']) && ($_GET['view'] == "print")))
			{
			?>
			<table cellspacing="0" cellpadding="0" border="0" width="550" align="left">
			<?php
			}
			else
			{
			?>
			<table cellspacing="0" cellpadding="0" border="0" width="600" align="left">
			<?php
			}
			?>
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;">
					<?php
					if((isset($_GET['view']) && ($_GET['view'] == "print")))
					{
					?>
					<img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></td>
					<?php
					}
					else
					{
					?>
					<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					<?php
					}
					?>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center" style="padding:0 0 6px 0; height:32px;">
					
									<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
										<tr>
											<?php
											if((isset($_GET['view']) && ($_GET['view'] == "print")))
											{
											?>
											<td>&nbsp;</td>
											<?php
											}
											else
											{
											echo '<td valign="bottom"><font size="2" face="Arial"><strong>' . $message . '</strong>&nbsp;<a href="csPortal_Login.php?action=logout">[' . $portalMsg[9][$lang] . ']</a></td>';
											}
											?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="bottom">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
									<?php
									if((isset($_GET['view']) && ($_GET['view'] == "print")))
									{
										?>
										<td>&nbsp;</td>
										<?php
										}
										else
										{
										?>
						  			<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'"; height="36" alt="Click to go to Netcom homepage."></a></td>
						  			<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'"; height="36" alt="Click to go to Sales homepage."></a></td>
						  			<td><a href="csPortal_Support.php"><img src="images/Support_ButtonActive.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonActive.gif'"; height="36" alt="Click for customer support options."></a></td>								
						  			<?php
						  			if($_SESSION['access'] >= 7)
						  			{
											echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonOff.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonOff.gif'\";\" height=\"36\" alt=\"Netcom's company administration portal.\"></a></td>";
										}
									}
									?>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<?php
					if((isset($_GET['view']) && ($_GET['view'] == "print")))
					{
					?>
						<td>&nbsp;</td>
					<?php
					}
						else
					{
					?>
					<td><img src="images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
					<?php
					}
					?>
					<td width="100%" style="background-image: url(images/subnav-bg.gif);">
		<!-- sub nav -->
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center">
									<table cellspacing="0" cellpadding="0" border="0" style="height:20px;">
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="0" id="tablist2">
												<tr>
													<?php
													if((isset($_GET['view']) && ($_GET['view'] == "print")))
													{
													?>
														<td>&nbsp;</td>
													<?php
													}
													else
													{
													?>
														<td style="color:#3b3d3d;font-size:10px;font-family: verdana;font-weight:bold;"><b>&nbsp;</b></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Facilities.php" style="font-size:10px;font-family: verdana;">CUSTOMER INFO</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Tickets.php" style="font-size:10px;font-family: verdana;">SUPPORT TICKETS</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_UpsTrack.php" style="font-size:10px;font-family: verdana;">SHIPMENT TRACKING</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Notifications.php" style="font-size:10px;font-family: verdana;">NOTIFICATIONS</a></td>
														<?php
														if(isset($_GET['cust_num'])) {
														?>
															<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
															<td style="padding-left:4px;padding-right:4px;"><a href="sales/proactivecall.php?f_id=<?php echo $custNum; ?>&view=newticketform" style="font-size:10px;font-family: verdana;">PROACTIVE CALLS</a></td>
														<?php
														}
													}
													?>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table align="center" width="759" border="0" bgcolor="#FFFFFF">
	<tr valign="top">
		<?php
  	/************************** COLUMN LEFT START *************************/
  	?>
		<td width="550">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
  			<tr>
  	<td><b><i><font face="Arial" size="2" color="Red"><?php echo $sysMsg; ?></font></b></i></td>
  </tr>
 <tr>
    <?php  
    if((isset($_GET['action'])) && ($_GET['action'] == "newTicket"))
    {
    	echo "<td align=\"left\">";
    	$f_id = $_GET['f_id'];
    	$query9 = "SELECT CustomerNumber, FacilityName FROM tblFacilities WHERE CustomerNumber = '$f_id'";
    	$result9 = mysql_query($query9) or die (mysql_error());
    	$row9 = mysql_fetch_array($result9);
    	echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">';
    	echo '<form name="addTicket" action="'.$_SERVER['PHP_SELF'].'" method="get">';
    	echo '<tr><td width="140" valign="top"><font face="Arial" size="2"><b>' . 'Customer Number: ' . '</td><td><font face="Arial" size="2">'.$row9['CustomerNumber'].'</font><input type="hidden" name="f_id" value="'.$row9['CustomerNumber'].'"></td></tr>';
			echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Facility Name: ' . '</b></td><td>'.$row9['FacilityName'].'</font></td></tr>';
			?>
			<tr>
				<td valign="top">
					<font face="Arial" size="2"><b>Ticket Type: </b></font>
				</td>
				<td>
					<select name="ticketType">
						<option value="0">Office Hours Call Center</option>
						<option value="1"<?php if(($curTime > $endTime) || ($curTime < $bgnTime) || (date("l")=="Saturday") || (date("l")=="Sunday")){ echo 'selected="selected"'; } ?>>After Hours Call Center</option>
						<option value="2">Site Visit/Service Call</option>
						<option value="4">Site Visit/Training</option>
						<option value="3">Proactive Call</option>
					</select>
				</td>
			</tr>
			<?php
			# Allow access to flag as warranty activity on the ticket
			if($row10['warr_prog'] == 1)
			{
			?>
			<tr>
				<td valign="top">
					<font face="Arial" size="2"><b>Ensure Activity: </b></font>
				</td>
				<td>
					<input type="checkbox" name="warrantyAct" value="Yes"  />
				</td>
			</tr>
			<?php
			}
    	echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Problem Description: ' . '</b></font></td><td><textarea name="prob_desc" rows="2" cols="45"></textarea></td></tr>';
			echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Contact Name: ' . '</b></td><td><input type="text" name="contact" /></font></td</tr>';
			echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Contact Number: ' . '</b></font></td><td><input type="text" name="contact_num" maxlength="10" size="10" />&nbsp;<font face="Arial" size="2"><b>Ext.</b></font><input type="text" name="contact_ext" maxlength="5" size="5"></td</tr>';
			//echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Opened By: </td><td>'.$user.'</font></td></tr>';
			echo '<input type="hidden" name="action" value="createTicket" />';
			echo '<input type="hidden" name="cust_num" value="'.$row9['CustomerNumber'].'" />';
			echo '<input type="hidden" name="by_cust" value="Lookup" />';
			echo '<tr><td colspan="2"><input name="submit" type="submit" value="Open" /></form>&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'" /></td></tr>';
			echo '</form>';
			echo '<td colspan="2"><div align="center"><hr width="50%"></div></td>';
			echo '</table>';
		}
		
    if(isset($_GET['by_ticket']) OR isset($_GET['by_cust']) OR isset($_GET['action'])) {
    	if(!(isset($_GET['action']) && $_GET['action'] == "newTicket"))
    	{
    		echo "<td align=\"left\">";
    	}
  		if(isset($_GET['by_ticket']) || isset($_GET['by_cust']))
  		{
  			if(is_null($row['ID'])) 
  			{
  				echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
					echo '<tr><td align="center"><i>' . 'No matches found' . '</i></td></tr>';
					echo '</table>';
				}
				else
				{
				?>
					<table align="center">
  					<tr>
  						<td  align="center"><a href="javascript:void(0)"onclick="window.open('csPortal_Facilities.php?cust_num=<?php echo $row['CustomerNumber']; ?>&by_cust=Lookup&secID=system&view=print','system','width=600,height=750,scrollbars=yes')"><font face="Arial" size="2">System Info</font></a></td>
  						<td  align="center"><a href="csPortal_ticketReportsNew.php?cust_num=<?php echo $row['CustomerNumber']; ?>"><font face="Arial" size="2">View Reports</font></a></td>
  					</tr>
  				</table>
  			<?php
					if(!isset($_GET['by_ticket']))
					{
				?>
  				<table align="center">
  					<tr>
  						<td align="center"><font face="Arial" size="3"><b><i>Viewing Last 5 Opened Tickets</i></b></font></td>
  					</tr>
  				</table>
  			<?php
  				}
					while($row2 = mysql_fetch_array($result2))
					{
						$CustNumber = $row2['CustomerNumber'];
						$TicketNum = $row2['ID'];
						if($row2['Status']==0) {
							$Status = 'OPEN';
						} elseif($row2['Status']==1) {
							$Status = 'CANCELED';
						}elseif($row2['Status']==2) {
							$Status = 'ESCALATED';
						}else{
							$Status = 'CLOSED';
						}
						$query3 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$CustNumber'";
						$result3 = mysql_query($query3) or die (mysql_error());
						$row3 = mysql_fetch_array($result3);
						$query4 = "SELECT * FROM tblTicketMessages WHERE TicketID = '$TicketNum' ORDER BY Date Asc";
						$result4 = mysql_query($query4) or die (mysql_error());
						
						// connect to work db and get task information
						mysql_select_db($dbname2);
						$query5 = "SELECT * FROM taskinfo WHERE ticketNum = '$TicketNum'";
						$result5 = mysql_query($query5);
						$row5 = mysql_fetch_array($result5);
						$taskId = $row5['ID'];
						$taskStatus = $row5['Status'];
						$taskType = $row5['Type'];
						$taskCount = mysql_num_rows($result5);
						mysql_select_db($dbname);
						
						echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
						if(isset($_GET['action']) && ($_GET['action'] == "newTicket"))
    				{
							echo '<tr align="center"><td colspan="2"><table cellspacing="5"><tr><td>&nbsp;</td>';
						}
						else
						{
							echo '<tr align="center"><td colspan="2"><table cellspacing="5"><tr><td><a href="'.$_SERVER['PHP_SELF'].'?f_id='.$CustNumber.'&action=newTicket"><font face="Arial" size="2">New Ticket</font></a></td>';
						}
						if($row2['Status'] != -1) {
							echo '<td><a href="'.$_SERVER['PHP_SELF'].'?by_ticket=ticket&ticket_num='.$TicketNum.'&action=createRemark&cust_num='.$CustNumber.'"><font face="Arial" size="2">Add Remark</font></a></td>';
							# link to create new task
							echo '<td  align="center"><a href="task/task.php?view=new&ticketNum=' . $TicketNum . '&type=13"><font face="Arial" size="2">Create Task</font></a></td>';
							
						}
							// check to see if task exists
						if($taskCount > 0)
						{
							echo '<td  align="center"><a href="task/task.php?action=UPDATE&viewticketNum=' . $TicketNum . '"><font face="Arial" size="2">View Task(s)</font></a></td>';
						}
						echo '</tr>';
						echo '</table></td></tr>';
    				echo '<tr><td width="140" valign="top"><font face="Arial" size="2"><b>' . 'Customer Number: ' . '</td><td><a href="csPortal_Facilities.php?cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup">' . $row2['CustomerNumber'] . '</a></font></td></tr>';
						echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Facility Name: ' . '</b></td><td>' . $row3['FacilityName'] . '</font></td></tr>';
   					echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Ticket Number: ' . '</b></td><td>' . $row2['ID'] . '</td></tr>';
						echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Current Status: ' . '</b></td><td>';
						if($Status == "CLOSED" || $Status == "CANCELED") {
							echo $Status . '</font>';
							if(($row10['dept'] == 2) || ($_SESSION['access'] >= 7)) {
								echo ' <a href="'.$_SERVER['PHP_SELF'].'?f_id='.$custNum.'&ticket_id='.$TicketNum.'&action=reopenTicket&by_ticket=Lookup&ticket_num='.$TicketNum.'">[Re-Open]</a></td></tr>';
							}
						} else {
							mysql_select_db($dbname2);
							$query31 = "SELECT ID FROM taskinfo WHERE ticketNum = '$TicketNum' AND Response = '2000' AND Type = '28' AND Status = '3'";
							$result31 = mysql_query($query31);
							$count31 = mysql_num_rows($result31);
							mysql_select_db($dbname);
						?>
						<form STYLE="margin: 0px; padding: 0px;">
						<select name="ticketStatus" onchange="updateStatus(this.value, <?php echo $TicketNum; ?>)">
							<option value="0" <?php if($row2['Status'] == 0){ echo 'selected="selected"'; } ?>>Open</option>
							<option value="2" <?php if($row2['Status'] == 2){ echo 'selected="selected"'; } ?>>Escalated</option>
							<?php
								if($count31 == 0) {
							?>
								<option value="3" <?php if($row2['Status'] == 3){ echo 'selected="selected"'; } ?>>Process RMA</option>
							<?php
								}
							?>
							<option value="-1" <?php if($row2['Status'] == -1){ echo 'selected="selected"'; } ?>>Closed</option>
							<option value="1" <?php if($row2['Status'] == 1){ echo 'selected="selected"'; } ?>>Canceled</option>
						</select>
						</form>
						</td></tr>
						<?php
						}
						if($row2['Status'] == -1) {
							echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Date Closed: ' . '</b></td><td>' . $row2['DateClosed'] . '</td></tr>';
							echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Ticket Duration: ' . '</b></td><td>' . dateDiff($row2['DateOpened'],$row2['DateClosed']) . '</td></tr>';
						}
						if($row2['rmaReturn'] == 1) {
							mysql_select_db($dbname2);
							$query31 = "SELECT * FROM taskinfo WHERE ticketNum = '$TicketNum' AND Response = '2000' AND Type = '28'";
							$result31 = mysql_query($query31);
							$count31 = mysql_num_rows($result31);
							$row31 = mysql_fetch_array($result31);
							mysql_select_db($dbname);
							if($count31 > 0) {
								if($row31['Status'] == 3) {
									$repairAuth = "Authorized";
								} else {
									$repairAuth = "Not Authorized";
								}
								echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Repair Authorization: ' . '</b></td><td>' . $repairAuth . '</td></tr>';
							}
						}
						
						# Update General Ticket Information
						if((isset($_GET['action'])) && ($_GET['action'] == "updateDesc"))
						{
							echo '<form name="descUpdate" action="'.$_SERVER['PHP_SELF'].'" method="get">';
						?>
						<tr>
							<td valign="top">
								<font face="Arial" size="2"><b>Ticket Type: </b></font>
							</td>
							<td>
								<select name="ticketType">
									<option value="0" <?php if($row2['Type'] == 0){ echo 'selected="selected"'; } ?>>Office Hours Call Center</option>
									<option value="1" <?php if($row2['Type'] == 1){ echo 'selected="selected"'; } ?>>After Hours Call Center</option>
									<option value="2" <?php if($row2['Type'] == 2){ echo 'selected="selected"'; } ?>>Site Visit/Service Call</option>
									<option value="2" <?php if($row2['Type'] == 4){ echo 'selected="selected"'; } ?>>Site Visit/Training</option>
									<option value="3" <?php if($row2['Type'] == 3){ echo 'selected="selected"'; } ?>>Procactive Call</option>
								</select>
							</td>
						</tr>
						<?php
						# Allow access to flag as warranty activity on the ticket
						if($row10['warr_prog'] == 1)
						{
						?>
						<tr>
							<td valign="top">
								<font face="Arial" size="2"><b>Ensure Activity: </b></font>
							</td>
							<td>
								<input type="checkbox" <?php if($row2['warrantyActivity']) { echo 'checked="yes"'; } ?> name="warrantyAct" value="Yes"  />
							</td>
						</tr>
						<?php
						}
						echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Problem Description: ' . '</b></font></td>';
						echo '<td><textarea name="prob_desc" rows="2" cols="45">'.strip_tags($row2['Summary']).'</textarea></td></tr>';
						echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Contact Name: ' . '</b></font></td><td><input type="text" name="contact" value="' . $row2['Contact'] . '" /></td></tr>';
						echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Contact Number: ' . '</b></font></td><td><input type="text" name="contact_num" maxlength="10" size="10" value="' . $row2['ContactPhone'] . '" />&nbsp;Ext.<input type="text" name="contact_ext" maxlength="5" size="5" value="'.$row2['Extension'].'" /></td></tr>';
						echo '<input type="hidden" name="by_cust" value="number">';
						echo '<input type="hidden" name="ticket_num" value="'.$row2['ID'].'">';
						//echo '<input type="hidden" name="cust_num" value="'.$custNum.'">';
						echo '<tr><td>&nbsp;</td><td><input name="saveUpdDesc" type="submit" value="Update"></form>&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['PHP_SELF'].'?cust_num='.$CustNumber.'&by_cust=Lookup\'"></td></tr>';
						}
						else
						{
							if($row2['Type'] == 0)
							{
								$ticketType = "Office Hours Call Center";
							}
							elseif($row2['Type'] == 1)
							{
								$ticketType = "After Hours Call Center";
							}
							elseif($row2['Type'] == 2)
							{
								$ticketType = "Site Visit/Service Call";
							}
							elseif($row2['Type'] == 3)
							{
								$ticketType = "Proactive Call";
							}
							elseif($row2['Type'] == 4)
							{
								$ticketType = "Site Visit/Training";
							}
							echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Ticket Type: ' . '</b></td><td>' . $ticketType . '</font></td></tr>';
							if($row2['warrantyActivity'] == "Yes")
							{
								echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Ensure Activity: ' . '</b></td><td>' . $row2['warrantyActivity'] . '</font></td></tr>';
							}
							echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Problem Description: ' . '</b></font></td>';
    					if((!($row2['Status'] == -1 || $row2['Status'] == 1)) && ($row2['OpenedBy'] == $user))
    					{
    						echo '<td>' . $row2['Summary'] . '</td></tr>';
								echo '<tr>&nbsp;<td></td><td><font face="Arial" size="2"><a href="'.$_SERVER['PHP_SELF'].'?action=updateDesc&id='.$row2['ID'].'&by_ticket=Lookup&ticket_num='.$row2['ID'].'">Edit</a></font></td></tr>';
    					}
    					else
    					{
    						echo '<td>' . $row2['Summary'] . '</td></tr>';
    					}
    					echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Contact Name: ' . '</b></td><td>' . $row2['Contact'] . '</font></td></tr>';
							echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Contact Number: ' . '</b></font></td><td>' . formatPhone($row2['ContactPhone']) . '&nbsp;<font face="Arial" size="2"><b>Ext.&nbsp;</b></font>'.$row2['Extension'].'</td></tr>';
    				}
    				$query23 = "SELECT f_name, l_name FROM employees WHERE id = '$row2[OpenedBy]'";
    				$result23 = mysql_query($query23);
    				$row23 = mysql_fetch_array($result23);
    				$empName23 = $row23['l_name'] . ", " . $row23['f_name'];
						echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Opened By: ' . '</b></td><td>' . $empName23 . ' @ ' . $row2['DateOpened'] . '</font></td></tr>';
						while($row4 = mysql_fetch_array($result4))
						{
							if((isset($_GET['action']) && ($_GET['action'] == "updateRemark")) && ($_GET['id'] == $row4['ID']))
							{
								echo '<form name="remarkUpdate" action="'.$_SERVER['PHP_SELF'].'" method="get">';
								echo '<tr><td valign="top"><font face="Arial" size="2"><b>Enter Remark:</b></td>';
								echo '<td><textarea name="updatedRemark" rows="5" cols="45">'.strip_tags($row4['Message']).'</textarea></td></tr>';
								echo '<input type="hidden" name="by_ticket" value="ticket">';
								echo '<input type="hidden" name="ticket_num" value="'.$row2['ID'].'">';
								//echo '<input type="hidden" name="cust_num" value="'.$custNum.'">';
								echo '<input type="hidden" name="remarkID" value="'.$row4['ID'].'">';
								echo '<tr><td>&nbsp;</td><td><input name="saveUpdRemark" type="submit" value="Update"></form>&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['PHP_SELF'].'?cust_num='.$CustNumber.'&by_cust=Lookup\'"></td></tr>';
							}
							else
							{
								echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Technician Remark: ' . '</b></td>';
								if((!($row2['Status'] == -1 || $row2['Status'] == 1)) && ($row4['EnteredBy'] == $user))
    						{
    							echo '<td>' . $row4['Message'] . '</td></tr>';
    							echo '<tr>&nbsp;<td></td><td><font face="Arial" size="2"><a href="'.$_SERVER['PHP_SELF'].'?action=updateRemark&id='.$row4['ID'].'&by_ticket=Lookup&ticket_num='.$row2['ID'].'">Edit</a></font></td></tr>';
    						}
    						else
    						{
    							echo '<td>' . $row4['Message'] . '</td></tr>';
    						}
    					}
    					$query24 = "SELECT f_name, l_name FROM employees WHERE id = '$row4[EnteredBy]'";
    					$result24 = mysql_query($query24);
    					$row24 = mysql_fetch_array($result24);
    					$empName24 = $row24['l_name'] . ", " . $row24['f_name'];
							echo '<tr><td valign="top">' . '&nbsp;</td><td>' . '<font face="Arial" size="2"><b>Signature: '.'</b></font>'.$empName24.' @ '.$row4['Date'].'</td></tr>';
						}
						if((isset($_GET['action'])) && ($_GET['action'] == "createRemark"))
    				{
    					$custNum = $_GET['cust_num'];
    					echo '<form name="addTicket" action="'.$_SERVER['PHP_SELF'].'" method="get">';
							echo '<tr><td valign="top"><font face="Arial" size="2"><b>Enter Remark:</b></td><td><textarea name="newRemark" rows="5" cols="45"></textarea></td></tr>';
							echo '<input type="hidden" name="action" value="saveRemark">';
							echo '<input type="hidden" name="by_ticket" value="ticket">';
							echo '<input type="hidden" name="ticket_num" value="'.$row2['ID'].'">';
							echo '<input type="hidden" name="cust_num" value="'.$custNum.'">';
							echo '<tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Update"></form>&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'"></td></tr>';
						}
						echo '</table>';
						if(!($row2['Status'] == -1 || $row2['Status'] == 1)) {
						?>
						<table width="100%">
							<form name="<?php echo "chkFollowup".$TicketNum; ?>">
								<tr align="left"><td><font face="Arial" size="2"><b>Schedule Follow-Up: </b></font><input type="checkbox" <?php if($row2['FollowUp'] == -1){ echo 'checked'; } ?> name="fuSch" onclick="schFollowup(this.value, <?php echo $TicketNum; ?>)"</td></tr>
							</form>
						</table>
						<div id="<?php echo "followUpForm".$TicketNum; ?>" style="display: <?php if($row2['FollowUp'] == -1){ echo 'inline'; } else { echo 'none'; } ?>;">
							<form name="<?php echo "followUp".$TicketNum; ?>" id="<?php echo "followUp".$TicketNum; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
								<table>
									<tr>
										<td>
				    					<font size="2" face="Arial">Select Date:</font><br />
				    					<INPUT TYPE="text" NAME="fuDate" id="fuDate" VALUE="<?php echo $row2['DateFollowUp']; ?>" SIZE="10" />
				    					<INPUT TYPE="hidden" NAME="action" VALUE="schFollowUp" />
				    					<INPUT TYPE="hidden" NAME="ticket_num" VALUE="<?php echo $TicketNum; ?>" />
				    					<INPUT TYPE="hidden" NAME="cust_name" VALUE="<?php echo $row3['FacilityName']; ?>" />
				    				</td>
				    				<td align="left" valign="bottom">
				    					<A HREF="#" onClick="cal.select(document.forms['<?php echo "followUp".$TicketNum; ?>'].fuDate,'anchor1','yyyy-MM-dd'); return false;" NAME="anchor1" ID="anchor1"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
				    					<font face="Arial" size="1">Example: yyyy/mm/dd
				    					<SCRIPT LANGUAGE="JavaScript" SRC="./js/calendarpopup.js"></SCRIPT>
				          		<SCRIPT LANGUAGE="JavaScript">
				       	  			var cal = new CalendarPopup();
				     					</SCRIPT>
				     				</td>
			     				</tr>
			     				<tr>
			     					<td>
			     						<input type="submit" name="sbmFollowUp" value="Submit" />
			     					</td>
			     				</tr>
		     				</table>
	     				</form>
						</div>
						<?php
						}
							$query28 = "SELECT * FROM devicelist";
							$result28 = mysql_query($query28);
							$query27 = "SELECT * FROM rmadevices WHERE TicketID = '$TicketNum'";
							$result27 = mysql_query($query27);
							$count27 = mysql_num_rows($result27);
							if($count27 > 0) {
							?>
								<table cellspacing="5" align="center">
									<tr>
										<td><u><b><font size="2" face="Arial">Device:</font></u></b></td>
										<td><u><b><font size="2" face="Arial">Serial #:</font></u></b></td>
										<td><u><b><font size="2" face="Arial">Problem:</font></u></b></td>
										<td><u><b><font size="2" face="Arial">Status:</font></u></b></td>
										<td>&nbsp;</td>
									</tr>
									<?php
										while($row27 = mysql_fetch_array($result27)) {
											if($row27['Warranty'] == 1) {
												$warranty = "Warrantied - Repair";
											} elseif($row27['Warranty'] == 2) {
												$warranty = "NOT Warrantied - Repair";
											} elseif($row27['Warranty'] == 3) {
												$warranty = "NOT Warrantied - Purchase replacement";
											} elseif($row27['Warranty'] == 4) {
												$warranty = "Warrantied - <b>Return Only</b>";
											} elseif($row27['Warranty'] == 5) {
												$warranty = "NOT Warrantied - <b>Return Only</b>";
											}
											mysql_data_seek($result28, 0);
											while($row28 = mysql_fetch_array($result28)) {
												if($row28['part#'] == $row27['Device']){
													$deviceName = $row28['partDesc'];
												}
											}
											echo '<tr>';
											echo '<td><font size="2" face="Arial">'. $deviceName . '</font></td>';
											echo '<td><font size="2" face="Arial">'. $row27['SN'] . '</font></td>';
											echo '<td><font size="2" face="Arial">'. $row27['Problem'] . '</font></td>';
											echo '<td><font size="2" face="Arial">'. $warranty . '</font></td>';
											if(!($row2['Status'] == -1 || $row2['Status'] == 1)) {
												echo '<td><a href="">[Edit]</a>&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?ticket_num='.$TicketNum.'&by_ticket=ticket&submit=Lookup&action=removeDevice&deviceID='.$row27['ID'].'">[Remove]</a></td>';
											}
											echo '</tr>';
										}
									?>
								</table>
							<?php
							}
						if(!($row2['Status'] == -1 || $row2['Status'] == 1)) {
						?>
						<table width="100%">
							<form name="<?php echo "rmaAuth".$TicketNum; ?>">
								<tr align="left"><td><font face="Arial" size="2"><b>Create RMA: </b></font><input type="checkbox" <?php if($count27 > 0){ echo 'checked'; } ?> name="rmaAuth" onclick="createAuth(this.value, <?php echo $TicketNum; ?>)"</td></tr>
							</form>
						</table>
						<div id="<?php echo "rmaAuthDiv".$TicketNum; ?>" style="display: <?php if($count27 > 0){ echo 'inline'; } else { echo 'none'; } ?>;">
							<form name="<?php echo "rmaAuthForm".$TicketNum; ?>" id="<?php echo "followUp".$TicketNum; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
								<table style="border-style:dashed; border-width:1px;" width="100%">
									<tr>
										<td valign="bottom">
											<?php
												$query25 = "SELECT * FROM devicelist";
												$result25 = mysql_query($query25);
												if((isset($_GET['action'])) && ($_GET['action'] == "updateRmaDevice")) {
													$query29 = "SELECT * FROM rmaDevices WHERE ID = '$_GET[deviceID]'";
													$result29 = mysql_query($query29) or die(mysql_error());
													$row29 = mysql_fetch_array($result29);
												}
											?>
											<font size="2" face="Arial">Device:</font><br />
											<select name="deviceType">
												<?php
												while($row25 = mysql_fetch_array($result25)) {
												?>
													<option value="<?php echo $row25['part#']; ?>"><?php echo $row25['partDesc']; ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td valign="bottom">
											<font size="2" face="Arial">Serial #:</font><br />
											<input name="serialNumber" size="10" type="text" />
										</td>
										<td valign="bottom">
											<font size="2" face="Arial">Problem:</font><br />
											<input name="problemDesc" type="text" />
										</td>
										<td valign="bottom">
											<font size="2" face="Arial">Problem<br />Warrantied?:</font><br />
											<select name="warrantyStatus">
												<option value="0"> --- </option>
												<option value="1">Yes</option>
												<option value="4">Yes (Return Only)</option>
												<option value="2">No (Return for Repair)</option>
												<option value="3">No (Purchase replacement)</option>
												<option value="5">No (Return Only)</option>
											</select>
										</td>
									</tr>
									<tr>
										<td valign="bottom" align="center" colspan="4">
											<input type="hidden" name="ticketNum" value="<?php echo $TicketNum; ?>" />
			     						<input type="submit" name="sbmRmaDevice" value="Save" />
			     					</td>
									</tr>
								</table>
							</form>
						</div>
						<?php
						} else {
							$query3 = "SELECT * FROM rmaDevices WHERE TicketID = '$TicketNum' AND Warranty = 2 AND Device IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')";
							$result3 = mysql_query($query3);
							$count3 = mysql_num_rows($result3);
							if($count3 > 0) {
							?>
								<table width="100%">
									<tr>
										<td align="center"><a href="rmaAuthForm.php?ticketID=<?php echo $TicketNum; ?>" target="_blank">[Repair Authorization Form]</a></td>
									</tr>
								</table>
							<?php
							}
						}
						if(($row2['rmaReturn'] == 1) && ($row10['dept'] == 5)) {
						?>
							<table width="100%">
								<tr>
									<td align="center"><span id="rmaReturnAuth" onclick="javascript:changeView('rmaReturn', '<?php echo $TicketNum; ?>');"><a href="#">[Return Verification]</a></span></td>
								</tr>
							</table>
							<div id="<?php echo "rmaReturn".$TicketNum; ?>" style="display: none">
								<form name="<?php echo "rmaReturnFrm".$TicketNum; ?>" id="<?php echo "rmaReturnFrm".$TicketNum; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
									<table style="border-style:dashed; border-width:1px;" width="100%">
										<tr>
											<td colspan="2">
												<font size="2" face="Arial">Use the notes section to put changes or notes to the return.</font>
					    				</td>
				     				</tr>
				     				<tr>
											<td valign="top">
												<font size="2" face="Arial">Return Notes:</font>
					    				</td>
					    				<td>
					    					<textarea name="returnNote" rows="5" cols="45"></textarea>
					    				</td>
				     				</tr>
				     				<tr>
				     					<td colspan="2" align="center">
				     						<input type="hidden" name="ticket_num" value="<?php echo $TicketNum; ?>" />
				     						<input type="hidden" name="by_ticket" value="ticket" />
				     						<input type="submit" name="returnAuth" value="Verified" /><input type="submit" name="returnAuth" value="Modified" /><input type="submit" name="returnAuth" value="Returned" /><input type="button" value="Cancel" onClick="javascript:window.location.reload()">
				     					</td>
				     				</tr>
			     				</table>
		     				</form>
							</div>
						<?php
						}
						# FILE UPLOAD FEATURE
						$query12 = "SELECT * FROM filemanager WHERE refNumber = '$TicketNum' AND attachType = 'ticket' AND publish = '-1' ORDER BY timestamp DESC";
						$result12 = mysql_query($query12);
						echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
   					if(mysql_num_rows($result12) > 0)
   					{
   						echo '<tr><td colspan="5" align="center"><font face="Arial" size="2"><b>File Manager</b></font></td></tr>';
   						while($row12 = mysql_fetch_array($result12))
   						{
   							if($row12['fileType'] == "image/jpeg")
   							{
   							$icon = "JPG_Small.png";
   							}
   							elseif($row12['fileType'] == "image/gif")
   							{
   							$icon = "GIF_Small.png";
   							}
   							elseif($row12['fileType'] == "application/pdf")
   							{
   							$icon = "PDF_Small.png";
   							}
   							elseif($row12['fileType'] == "application/msword")
   							{
   							$icon = "DOC_Small.png";
   							}
   							elseif($row12['fileType'] == "application/vnd.ms-excel")
   							{
   							$icon = "XLSX_Small.png";
   							}
   							elseif($row12['fileType'] == "application/x-zip-compressed")
   							{
   							$icon = "ZIP_Small.png";
   							}
   							elseif($row12['fileType'] == "application/zip")
   							{
   							$icon = "ZIP_Small.png";
   							}
   							elseif($row12['fileType'] == "text/plain")
   							{
   							$icon = "LOG_Small.png";
   							}
   							echo '<tr><td width="27"><img src="images/icons/'.$icon.'" width="26" height="26" /></td>';
   							echo '<td><a href="'.$row12['location'].'"><font face="Arial" size="2">' . $row12['name'] . '</font></a></td>';
   							echo '<td><font face="Arial" size="2">'.$row12['size'].' KB</font></td>';
   							echo '<td width="128"><font face="Arial" size="2">'.$row12['timestamp'].'</font></td>';
   							if((!($row2['Status'] == -1 || $row2['Status'] == 1)) && ($row12['addedBy'] == $user))
    						{
   								echo '<td width="22"><a href="csPortal_FileManage.php?action=deleteFile&fileID=' . $row12['id'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row12['name'].'?\')"><img src="images/delete-icon_Small.png" width="20" height="20" border="0" /></a></td></tr>';
   							}
   						}
   						if($row2['Status'] == -1 || $row2['Status'] == 1)
    					{
								echo '<tr><td colspan="4"><div align="center"><hr width="50%"></div></td></tr>';
    					}
   						echo '</table>';
   					}
   					else
   					{
   						echo '<tr><td align="center"><font face="Arial" size="2"><b>File Manager</b></font></td></tr>';
   						echo '<tr><td align="center"><i>No files found</i></td></tr>';
   						if($row2['Status'] == -1 || $row2['Status'] == 1)
    					{
								echo '<tr><td colspan="2"><div align="center"><hr width="50%"></div></td></tr>';
    					}
   						echo '</table>';
   					}
   					if(!($row2['Status'] == -1 || $row2['Status'] == 1)) {
   					?>
   					<table>
  						<form method="post" action="csPortal_FileManage.php" enctype="multipart/form-data">
  						<input type="hidden" name="action" value="add" />
  						<input type="hidden" name="type" value="ticket" />
  						<input type="hidden" name="ticket_num" value="<?php echo $TicketNum; ?>" />
  						<tr>
  							<td><font size="2" face="Arial"><strong>File Description:</strong></font><br /><input name="fileDesc" type="text" />
  						</tr>
  						<tr>
								<td><font size="2" face="Arial"><strong>File to Attach:</strong></font><br /><input name="uploadFile" size="40" type="file" /><i><?php echo ini_get('upload_max_filesize'); ?></i></td>
							</tr>
							<tr>
								<td><input name="submit" type="submit" value="Attach" /></td>
							</tr>
							</form>
							<tr>
								<td colspan="2"><div align="center"><hr width="50%"></div></td>
							<tr>
						</table>
						<?php
						}
					}
 				}
			}
  	}
  	else
  	{
  	?>
  	</tr>
 <tr>
	<td>&nbsp;</td>
</tr>
 <tr>
 	<td align="center">
 		<table border="0" cellspacing="0" cellpadding="0" STYLE="background-image: url('images/invbox_back.gif'); border: 1 ridge #CCCCCC" width="75%">
    <td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Support Ticket Tracking</b></font></td>
 	 	</tr>
 	 	<tr>
 	 	<?php
    		echo "<td align=\"center\"><font face=\"Arial\" size=\"2\">Please enter your required search criteria options below:</font></td>";
    		echo "</tr>";
    		echo "<tr>";
    		echo "<td align=\"center\">";
    		echo "<table border=\"0\">";
  			echo "<tr>";
    		echo '<form method="get" action="' . $_SERVER['PHP_SELF'] . '">';
    		echo '<td><font size="2" face="Arial"><strong>Ticket Number:</strong></font><br><input name="ticket_num" type="text"><input type="hidden" name="by_ticket" value="ticket"></td>';
				echo '<td valign="bottom"><input name="submit" type="submit" value="Lookup"></td></tr></form>';
				echo '<form method="get" action="' . 'csPortal_Facilities.php' . '">';
				echo "<tr>";
				echo '<td><font size="2" face="Arial"><strong>Facility Name:</strong></font><br><input name="f_name" type="text"><input type="hidden" name="by_name" value="name"></td>';
				echo '<td valign="bottom"><input name="submit" type="submit" value="Lookup"></td></tr></form>';
				echo "<tr>";
				echo '<form method="get" action="' . 'csPortal_Facilities.php' . '">';
				echo '<td><font size="2" face="Arial"><strong>Customer Number:</strong></font><br><input name="cust_num" type="text"><input type="hidden" name="by_cust" value="number"></td>';
				echo '<td valign="bottom"><input name="submit" type="submit" value="Lookup"></td></tr></form>';
				echo '</table>';
  	
  $query20 = "SELECT id, f_name, l_name FROM employees WHERE active = 0 ORDER BY l_name ASC";
  $result20 = mysql_query($query20);
 ?>
 </table>
 </tr>
 <tr>
	<td>&nbsp;</td>
</tr>
 <tr>
 	<td align="center">
 		<form name="snSearchFrm" method="GET" action="./task/rmareport.php">
 		<table border="0" cellspacing="0" cellpadding="0" STYLE="background-image: url('images/invbox_back.gif'); border: 1 ridge #CCCCCC" width="75%">
 			<tr> 
 				<td colspan="4" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Serial Number Search</b></font></td>
 			</tr>
 			<tr>
 				<td colspan="4" align="left">
 					<div><font size="2" face="Arial"><strong>Serial Number:</font><br /><input type="text" name="serialnum" /></div>
 					<?php
 					$query88 = "SELECT * FROM DeviceList";
 					$result88 = mysql_query($query88);
 					?>
 					<div><font size="2" face="Arial"><strong>Part Number:<br /></font>
 						<select name="part">
 							<option value="00">Any Part</option>
 							<?php
 							while($row88 = mysql_fetch_array($result88)) {
 								?>
 								<option value="<?php echo $row88['part#']; ?>"><?php echo $row88['partDesc']; ?></option>
 								<?php
 							}
 							?>
 						</select>
 					</div>
 				</td>
 			</tr>
			<tr>
				<td colspan="4" align="center">
					<input name="ticketnum" type="hidden" value="">
					<input name="custNum" type="hidden" value="">
					<input name="status" type="hidden" value="00">
					<input name="date3" type="hidden" value="">
					<input name="date4" type="hidden" value="">
					<input name="type" type="hidden" value="00">
					<input name="rmarpt" type="submit" value="Run" />
				</td>
			</tr>
		</table>
		</form>
 		<table border="0" cellspacing="0" cellpadding="0" STYLE="background-image: url('images/invbox_back.gif'); border: 1 ridge #CCCCCC" width="75%">
 			<tr> 
 				<td colspan="4" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Support Ticket Reporting</b></font></td>
 			</tr>
			<tr>
				<td colspan="4" align="center">
					<input type="button" value="Continue" onClick="window.location.href='csPortal_ticketReportsNew.php'">
				</td>
			</tr>
		</table>
		<?php
		}
		?>
	</td>
</tr>
  		</table>
  	</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
 		<td>
			<?php
		if((isset($_GET['view']) && ($_GET['view'] == "print")))
		{
			include 'includes/db_close.inc.php';
		?>
		<td>&nbsp;</td>
		<?php
		}
		else
		{
		
include_once 'rightPane.php';
}
?>
    </td>
    <?php
		/*************************** COLUMN RIGHT END ***************************/
		?>
  </tr>
	<?php
	/***************************** FOOTER START *****************************/
	?>
	<tr>
		<td colspan="2">
			<?php include_once ("./footer.php"); ?>
		</td>
	</tr>
	<?php
	/****************************** FOOTER END ******************************/
	?>
</table>
</body>
</html>