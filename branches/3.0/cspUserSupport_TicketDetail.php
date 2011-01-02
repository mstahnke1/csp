<?php
require_once('includes/cspSessionMgmt.php');

$ticketID = $_GET['ticketID'];
$agentID = $_SESSION['uid'];
include('includes/config.inc.php');
include('includes/db_connect.inc.php');
include_once('includes/functions.inc.php');

if(isset($_GET['msgID'])) {
	$sysMsg = $portalMsg[$_GET['msgID']][$lang];
}

if(isset($_GET['ticketID'])) {
	$qryTicketDetail1 = "SELECT tblTickets.*, tblFacilities.FacilityName AS facilityName 
											FROM tblTickets 
											LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
											WHERE tblTickets.ID = '$ticketID'";
	$rstTicketDetail1 = mysql_query($qryTicketDetail1) or die(mysql_error());
	$rowTicketDetail1 = mysql_fetch_array($rstTicketDetail1);
	$custID = $rowTicketDetail1['CustomerNumber'];
	if($rowTicketDetail1['Status']==0) {
		$Status = "Open";
	} elseif($rowTicketDetail1['Status']==1) {
		$Status = "Canceled";
	}elseif($rowTicketDetail1['Status']==2) {
		$Status = "Escalated";
	}else{
		$Status = "Closed";
	}
	$openedBy = $rowTicketDetail1['OpenedBy'];
	$qryTicketDetail2 = "SELECT employees.f_name AS firstName, employees.l_name AS lastName 
											FROM employees WHERE id = '$openedBy'";
	$rstTicketDetail2 = mysql_query($qryTicketDetail2) or die(mysql_error());
	$rowTicketDetail2 = mysql_fetch_array($rstTicketDetail2);
	if($rowTicketDetail2) {
		$openedBy = $rowTicketDetail2['firstName'] . " " . $rowTicketDetail2['lastName'];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<head>
	<title><?php echo $companyName; ?> | CSP - Support</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="theme/default/cspDefault.css" />
	<link rel="stylesheet" type="text/css" href="tinyboxstyle.css" />
	<script type="text/javascript" src="js/cb.js"></script>
	<script type="text/javascript" src="js/loadPage.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/tinybox.js"></script>
	<link rel="icon" type="image/ico" href="favicon.ico" />
</head>

<body">
	<center>
		<div class="cspContainer">
			<div class="cspHeader">
				<?php require_once('cspInfoPanel.php'); ?>
			</div>
			<div class="cspLeftPanel">
				<?php require_once('cspMenuBar.php'); ?>
			</div>
			<div class="cspRightPanel">
				<?php require_once('cspRightPanel.php'); ?>
			</div>
			<div id="cspContent" class="cspContent" align="left">
				<div class="cspNavBar">
					<ul id="navbar">
						<?php require_once('includes/nav_Support.php'); ?>
						<?php require_once('includes/nav_Customer.php'); ?>
						<?php require_once('includes/nav_Ticket.php'); ?>
					</ul>
				</div>
				<div class="cbb">
					<div class="cspSysMsg">
						<?php if(isset($sysMsg)) { echo $sysMsg; } ?>
					</div>
					<div class="dashLeftCol">
						<?php require_once('includes/support/cspTicket_CustomerDetails.php'); ?>
					</div>
					<div class="dashRightCol">
						<?php require_once('includes/support/cspTicket_TicketDetails.php'); ?>
					</div>
					<div class="dashFullCol">
						<?php require_once('includes/support/cspTicket_ActiveCallThread.php'); ?>
					</div>
					<div class="dashRightCol">
						<?php require_once('includes/support/cspTicket_FileManager.php'); ?>
					</div>
					<div class="dashFullCol">
						<?php
						if($Status != "Closed" && $Status != "Canceled") {
							require_once('includes/support/cspTicket_IssueCategories.php');
						}
						?>
						<?php require_once('includes/support/cspTicket_HistoryThread.php'); ?>
					</div>
				</div>
			</div>
			<div class="cspFooter">
				<?php require_once('cspFooter.php'); ?>
			</div>
		</div>
	</center>
</body>
<?php
include 'includes/db_close.inc.php';
?>
</html>