<?php
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
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	mysql_query($queryLog);
	include 'includes/db_close.inc.php';
	die(header("Location: csPortal_Login.php?url=" . $url));
}

if($_SESSION['access'] < 5)
{
	die("You are not authorized.<br>Your activity has been logged");
}

include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';

if(isset($_GET['msgID']))
{
	$sysMsg = $portalMsg[$_GET['msgID']][$lang];
}

$name = $_SESSION['displayname'];
$message = $portalMsg[10][$lang] . " $name!";
$mail = $_SESSION['mail'];

if(isset($_GET['ticketID'])) {
	$ticketID = $_GET['ticketID'];
	$query = "SELECT * FROM tblTickets WHERE ID = $ticketID";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$query2 = "SELECT * FROM tblFacilities WHERE CustomerNumber = '$row[CustomerNumber]'";
	$result2 = mysql_query($query2);
	$row2 = mysql_fetch_assoc($result2);
	$query3 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticketID' AND Warranty = 2 AND Device IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')";
	$result3 = mysql_query($query3);
	$count3 = mysql_num_rows($result3); 
	$query4 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticketID'";
	$result4 = mysql_query($query4);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>HomeFree Systems | Customer Service Portal - RMA Repair Form</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="csPortal_Layout.css" />
</head>

<body>
<center>
	<!-- START Table Page -->
	<div width="100%">
				<!-- START Table Menu -->
				<table cellspacing="0" cellpadding="0" border="0" width="100%" align="left">
					<tr>
						<td valign="bottom" style="padding-bottom:1px;" width="100%" align="left">
						<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					</tr>
					<tr>
						<td align="center">
							<p><br /><u><font size="4" face="Arial">RMA Equipment Repair Form</font></u></p>
						</td>
					</tr>
					<tr>
						<td align="left">
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tr>
									<td width="49%" valign="top" style="BORDER-STYLE: solid; BORDER-WIDTH: 1px; BORDER-COLOR:#CCCCCC;">
										<table cellspacing="0" cellpadding="0" border="0" width="100%">
											<tr>
												<td>
													<div style="padding-left: 1px; font-variant:small-caps;"><p><b><u>Customer Information</u></b></p></div>
													<div style="padding-left: 6px">
														<table cellspacing="0" cellpadding="0" border="0">
															<tr>
																<td align="right"><font size="2">Number:</font></td><td><font size="2"><?php echo $row['CustomerNumber']; ?></font></td>
															</tr>
															<tr>
																<td align="right"><font size="2">Facility:</font></td><td><font size="2"><?php echo $row2['FacilityName']; ?></font></td>
															</tr>
															<tr>
																<td align="right" valign="top"><font size="2">&nbsp;</font></td><td><font size="2"><?php echo $row2['StreetAddress']; ?></font></div><div><font size="2"><?php echo $row2['City'] . ", " . $row2['StateOrProvinceCode'] . " " . $row2['PostalCode']; ?></font></div></td>
															</tr>
														</table>
													</div>
												</td>
											</tr>
										</table>
									</td>
									<td width="2%">&nbsp;</td>
									<td width="49%" valign="top" style="BORDER-STYLE: solid; BORDER-WIDTH: 1px; BORDER-COLOR:#CCCCCC;">
										<?php
										if($row['rmaReturn'] == 1) {
											mysql_select_db($dbname2);
											$query31 = "SELECT * FROM taskinfo WHERE ticketNum = '$ticketID' AND Response = '2000' AND Type = '28'";
											$result31 = mysql_query($query31);
											$count31 = mysql_num_rows($result31);
											$row31 = mysql_fetch_array($result31);
											if($count31 > 0) {
												if($row31['Status'] == 3) {
													$repairAuth = "Repair Authorized";
												} else {
													$repairAuth = "Repair NOT Authorized";
												}
											}
										}
										$query32 = "SELECT * FROM taskinfo WHERE ticketNum = '$ticketID' AND Status = '9' AND Type = '11'";
										$result32 = mysql_query($query32);
										$row32 = mysql_fetch_array($result32);
										mysql_select_db($dbname);
										?>
										<table cellspacing="0" cellpadding="0" border="0" width="100%">
											<tr>
												<td>
													<div style="padding-left: 1px; font-variant:small-caps;"><p><b><u>RMA Details</u></b></p></div>
													<div style="padding-left: 6px;">
														<p>
															<div><font size="2">Ticket Number: <?php echo $ticketID; ?></font></div>
															<div><font size="2">RMA Created: <?php echo date('F d, Y', strtotime($row['DateClosed'])); ?></font></div>
															<div><font size="2">Equipment Received: <?php echo date('F d, Y', strtotime($row32['Createdate'])); ?></font></div>
															<div><font size="2">Repair Deadline: <?php echo date('F d, Y', strtotime($row32['Duedate'])); ?></font></div>
															<div><font size="2">Authorization: <?php echo $repairAuth; ?></font></div>
														</p>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan="3">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="left" style="BORDER-STYLE: solid; BORDER-WIDTH: 1px; BORDER-COLOR:#CCCCCC;">
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tr>
									<td valign="top">
										<?php
										$query6 = "SELECT Message FROM tblTicketMessages WHERE TicketID = '$ticketID' ORDER BY ID DESC";
										$result6 = mysql_query($query6);
										$row6 = mysql_fetch_array($result6);
										?>
										<div style="padding-left: 1px; font-variant:small-caps;"><p><b><u>Return Notes:</u></b></p></div>
										<div style="padding-left: 6px;"><?php echo $row6['Message']; ?></div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td align="left" style="BORDER-STYLE: solid; BORDER-WIDTH: 1px; BORDER-COLOR:#CCCCCC;">
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tr>
									<td valign="top">
										<div style="padding-left: 1px; font-variant:small-caps;"><p><b><u>Device Details</u></b></p></div>
										<?php
										while($row4 = mysql_fetch_array($result4)) {
											$query5 = "SELECT partDesc FROM devicelist WHERE `part#` = '$row4[Device]'";
											$result5 = mysql_query($query5);
											$row5 = mysql_fetch_assoc($result5);
											if($row4['Warranty'] == 1) {
												$warranty = "Warrantied - Repair";
											} elseif($row4['Warranty'] == 2) {
												$warranty = "NOT Warrantied - Repair";
											} elseif($row4['Warranty'] == 3) {
												$warranty = "NOT Warrantied - Purchase replacement";
											} elseif($row4['Warranty'] == 4) {
												$warranty = "Warrantied - <b>Return Only</b>";
											} elseif($row4['Warranty'] == 5) {
												$warranty = "NOT Warrantied - <b>Return Only</b>";
											}
											?>
											<div style="padding-left: 6px;"><font size="2">Device: <?php echo $row5['partDesc']; ?> (<?php echo $row4['SN']; ?>)</div>
											<div style="padding-left: 6px;"><font size="2">Problem: <?php echo $row4['Problem']; ?></div>
												<div style="padding-left: 6px;"><font size="2">Status: <?php echo $warranty; ?></div>
											<div style="padding-left: 6px;" valign="top"><font size="2">Repair Notes: <br /><br /><br /><br /><br /></div>
											<div><hr width="100%" /></div>
											<?php
										}
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			
	</div>	
</center>
<script type="text/javascript">
	window.print();
</script>
</body>
</html>