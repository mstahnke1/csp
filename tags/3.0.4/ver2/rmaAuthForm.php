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
	$query2 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$row[CustomerNumber]'";
	$result2 = mysql_query($query2);
	$row2 = mysql_fetch_assoc($result2);
	$dateClosed = strtotime($row['DateClosed']);
	if($row['Contact'] == "" || is_null($row['Contact'])) {
		$contact = $row2['FacilityName'];
	} else {
		$contact = $row['Contact'];
	}
	$query3 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticketID' AND Warranty = 2 AND Device IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')";
	$result3 = mysql_query($query3);
	$count3 = mysql_num_rows($result3); 
	$repairFee = number_format(39, 2);
	$totalFee = number_format($repairFee*$count3, 2);
	//$repairFee = number_format($repairFee, 2);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>HomeFree Systems | Customer Service Portal - Repair Authorization</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="csPortal_Layout.css" />
</head>

<body>
<center>
	<!-- START Table Page -->
	<table width="800" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<!-- START Table Menu -->
				<table cellspacing="0" cellpadding="0" border="0" width="100%" align="left">
					<tr>
						<td valign="bottom" style="padding-bottom:1px;" width="330">
						<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					</tr>
					<tr>
						<td align="center">
							<p><br /><u><font size="4" face="Arial">Repair Authorization / Non-Warranty Equipment</font></u></p>
						</td>
					</tr>
					<tr>
						<td align="left">
							<br />
							<p><?php echo date('F d, Y', $dateClosed); ?></p>
							<br />
							<p><?php echo $row2['FacilityName']; ?></p>
							<p>Dear <?php echo $contact; ?>,</p>
							<p>RMA Ticket # <?php echo $ticketID; ?> has been opened for Personal Watches with the following Serial Numbers: 
								<?php
									$serialNums = "";
									while($row3 = mysql_fetch_array($result3)) { 
										$serialNums .= $row3['SN'] . ", ";
									}
									$serialNums = substr($serialNums, 0, -2);
									echo $serialNums;
								?>.
							These devices are no longer under warranty.
							</p>
							<p>The cost of repair is $<?php echo $repairFee; ?> per device for a total order value of $<?php echo $totalFee; ?>. Repair cost includes battery & strap replacement, as well as, testing and verifying proper calibration.</p>
							<p>By responding back by e-mail or fax you agree to pay all charges related to this order or repairs, and confirm that you are authorized by your organization to place orders that carry a financial value.</p>
							<p>Upon receipt of the items, HomeFree will evaluate the devices and make the repairs (Battery, Straps and Calibration only). If HomeFree is unable to repair the devices, you will be notified immediately, and the unrepaired items will be returned to you. You will not be charged for the items that cannot be repaired.</p>
							<p>Please return this letter by fax or e-mail prior to shipping in the devices in need of service or repair. Should HomeFree receive the devices without prior authorization, items will be shipped back to you unrepaired.</p>
							<p>You may return this letter:
								<ol>
									<li><font size="2">By Fax &mdash; send signed letter to (414)358-8100</font></li>
									<li><font size="2">By Email &mdash; Please reply to this e-mail and state that you approve all terms and conditions as stated in the letter.</font></li>
								</ol>
							</p>
							<p>In order to ensure quick handling of your order, please include a copy of this signed letter in the box with the items you are sending in for repair.</p>
							<p>By returning this letter you hereby acknowledge you understand the terms and conditions associated with the above mentioned repair ticket.</p>
							<p>Date Signed: _____ /_____ /_____</p>
							<p>Signature: _____________________</p>
							<p>Print Name: ____________________</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>		
</center>
</body>
</html>