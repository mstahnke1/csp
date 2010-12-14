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
	<script type="text/javascript" src="js/functions.js"></script>
	<link rel="icon" type="image/ico" href="favicon.ico" />
</head>

<body onLoad="lookupFacilityName.facilityName.focus()">
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
						<li><a href="#">Support</a><ul>
							<li><a href="#">Lookup Ticket</a></li>
							<li><a href="JavaScript:void(0);" onclick="window.location='cspFacilityLookup.php'">Lookup Facility</a></li>
							<li><a href="#">Add Facility</a></li>
							<li><a href="#">Shipment Tracking</a></li>
							<li><a href="#">Call Reports</a></li></ul>
						</li>
						<li><a href="#">Customer</a><ul>
							<li><a href="#">New Call</a></li></ul>
						</li>
					</ul>
				</div>
				<div class="cbb">
					<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td colspan="2" class="cspBodyHeading">Facility Lookup</td>
						</tr>
						<tr>
							<form id="lookupFacilityName" name="lookupFacilityName">
								<td style="text-align: right;">Facility Name:</td>
								<td>
									<input type="text" name="srchString" />
									<input type="hidden" name="srchType" value="facilityName" />
									<input type="button" value="Search" onclick="sbmFacilityLookup(this.form);" />
								</td>
							</form>
						</tr>
						<tr>
							<form name="lookupCustNum">
								<td style="text-align: right;">Customer Number:</td>
								<td>
									<input type="text" name="custNum" />
									<input type="button" value="Search" />
								</td>
							</form>
						</tr>
					</table>
					<div id="resultsDiv">a</div>
				</div>
			</div>
			<div class="cspFooter">
				<?php require_once('cspFooter.php'); ?>
			</div>
		</div>
	</center>
</body>

</html>