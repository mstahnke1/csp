<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
$companyName = 'HomeFree';
$ticketID = $_GET['ticketID'];
include_once 'includes/config.inc.php';
include 'includes/functions.inc.php';
include 'includes/db_connect.inc.php';
if(isset($_GET['ticketID'])) {
	$qryTicketDetail1 = "SELECT tblTickets.*, tblFacilities.FacilityName AS facilityName 
											FROM tblTickets 
											LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
											WHERE tblTickets.ID = '$ticketID'";
	$rstTicketDetail1 = mysql_query($qryTicketDetail1) or die(mysql_error());
	$rowTicketDetail1 = mysql_fetch_array($rstTicketDetail1);
	$custID = $rowTicketDetail1['CustomerNumber'];
	if($rowTicketDetail1['Status']==0) {
		$Status = 'Open';
	} elseif($rowTicketDetail1['Status']==1) {
		$Status = 'Canceled';
	}elseif($rowTicketDetail1['Status']==2) {
		$Status = 'Escalated';
	}else{
		$Status = 'Closed';
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
						<li><a href="cspUserSupport_Home.php">Support</a><ul>
							<li><a href="JavaScript:void(0);" onclick="window.location='cspUserSupport_Search.php?type=Ticket'">Lookup Ticket</a></li>
							<li><a href="JavaScript:void(0);" onclick="window.location='cspUserSupport_Search.php?type=Facility'">Lookup Facility</a></li>
							<li><a href="#">Add Facility</a></li>
							<li><a href="#">Shipment Tracking</a></li>
							<li><a href="#">Call Reports</a></li></ul>
						</li>
						<li><a href="cspUserSupport_Customer.php?custID=<?php echo $custID; ?>">Customer</a><ul>
							<li><a href="JavaScript:void(0);" onclick="window.location='cspUserSupport_Search.php?type=Ticket'">Lookup Ticket</a></li>
							<?php
							if(isset($_GET['custID'])) {
								$custID = $_GET['custID'];
								?>
								<li><a href="JavaScript:void(0);" onclick="javascript:TINY.box.show('cspUserSupport_NewTicket.php?custID=<?php echo $custID; ?>',1,0,0,1,0);">New Ticket</a></li>
								<?php
							}
							?>
							<li><a href="#">Monitor</a></li></ul>
						</li>
						<li><a href="#">Ticket</a><ul>
							<li><a href="#">New Call</a></li>
							<li><a href="JavaScript:void(0);" onclick="javascript:TINY.box.show('cspUserSupport_AddTicketComment.php?ticketID=<?php echo $ticketID; ?>',1,0,0,1,0);">New Comment</a></li>
							<li><a href="#" >Close Ticket</a></li>
							<li><a href="#">Reopen Ticket</a></li></ul>
						</li>
					</ul>
				</div>
				<div class="cbb">
					<div class="dashLeftCol">
						<?php require_once('includes/support/cspTicket_CustomerDetails.php'); ?>
					</div>
					<div class="dashRightCol">
						<?php require_once('includes/support/cspTicket_TicketDetails.php'); ?>
					</div>
					<div class="dashFullCol">
						<?php require_once('includes/support/cspTicket_ActiveCallThread.php'); ?>
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

</html>