<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
$companyName = 'HomeFree';
?>

<head>
	<title><?php echo $companyName; ?> | CSP - Support</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="theme/default/cspDefault.css" />
	<link rel="stylesheet" type="text/css" href="tinyboxstyle.css" />
	<script type="text/javascript" src="js/cb.js"></script>
	<script type="text/javascript" src="js/loadPage.js"></script>
	<script type="text/javascript" src="js/tinybox.js"></script>
	<link rel="icon" type="image/ico" href="favicon.ico" />
</head>

<body>
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
						<li><a href="cspUserSupport_Home.php">Customer</a><ul>
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
					</ul>
				</div>
				<div class="cbb">
					<div class="dashLeftCol">
						<?php require_once('includes/support/cspCustomer_Info.php'); ?>
					</div>
					<div class="dashRightCol">
						<?php require_once('includes/support/cspCustomer_Contacts.php'); ?>
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