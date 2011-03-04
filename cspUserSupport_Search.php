<?php
require_once('includes/cspSessionMgmt.php');
include('includes/config.inc.php');
if(isset($_GET['msgID'])) {
	$sysMsg = $portalMsg[$_GET['msgID']][$lang];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<head>
	<title><?php echo $companyName; ?> | CSP - Support</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<![if !IE]>
		<link rel="stylesheet" type="text/css" href="theme/default/cspDefault.css" />
	<![endif]>
	<![if IE]>
		<link rel="stylesheet" type="text/css" href="theme/default/cspDefaultIE.css" />
	<![endif]>
	<link rel="stylesheet" type="text/css" href="tinyboxstyle.css" />
	<script type="text/javascript" src="js/cb.js"></script>
	<script type="text/javascript" src="js/loadPage.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<link rel="icon" type="image/ico" href="favicon.ico" />
</head>

<body onLoad="lookupFacilityName.facilityName.focus();">
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
					</ul>
				</div>
				<div class="cbb">
					<div class="cspSysMsg">
						<?php if(isset($sysMsg)) { echo $sysMsg; } ?>
					</div>
					<div class="dashLeftCol">
						<?php
						if(isset($_GET['type']) && $_GET['type'] == "Facility") {
							require_once('includes/support/cspSearch_Facility.php');
						} elseif(isset($_GET['type']) && $_GET['type'] == "Ticket") {
							require_once('includes/support/cspSearch_Tickets.php');
						}
						?>
					</div>
					<div class="dashRightCol">
						<div id="resultsDiv"></div>
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