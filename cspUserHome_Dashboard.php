<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
$companyName = 'HomeFree';
?>

<head>
	<title><?php echo $companyName; ?> | CSP - Home</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="theme/default/cspDefault.css" />
	<script type="text/javascript" src="js/cb.js"></script>
	<script type="text/javascript" src="js/loadPage.js"></script>
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
				
			</div>
			<div id="cspContent" class="cspContent" align="left">
				<div class="cspNavBar">
					<div class="cspNavBarItem">Home</div>
				</div>
				<div class="cbb">
					<?php require_once('includes/dashboard/dash_DbBackups.php'); ?>
					<?php require_once('includes/dashboard/dash_Tasks.php'); ?>
					<div>
						<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0" width="49%">
							<tr>
								<td class="cspBodyHeading">Open Tickets</td>
							</tr>
							<tr>
								<td>
									<div class="cspMOHighlight">Ticket # 3987 Opened 11/12/2010</div>
									<div class="cspMOHighlight">Ticket # 3487 Opened 11/17/2010</div>
									<div class="cspMOHighlight">Ticket # 3287 Opened 10/17/2010</div>
								</td>
							</tr>
						</table>
					</div>
					<div>
						<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0" width="49%">
							<tr>
								<td class="cspBodyHeading">Recently Closed Tickets</td>
							</tr>
							<tr>
								<td>
									<div class="cspMOHighlight">Ticket # 3987 Opened 11/12/2010</div>
									<div class="cspMOHighlight">Ticket # 3487 Opened 11/17/2010</div>
									<div class="cspMOHighlight">Ticket # 3287 Opened 10/17/2010</div>
								</td>
							</tr>
						</table>
					</div>
					<div>
						<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0" width="49%">
							<tr>
								<td class="cspBodyHeading">Scheduled Follow-Ups</td>
							</tr>
							<tr>
								<td>
									<div class="cspMOHighlight">Facility Name	Last Backup</div>
									<div class="cspMOHighlight">Commonwealth AL - Kilmarnock	No Database on File</div>
									<div class="cspMOHighlight">Covenant Shores at Mercer Island	No Database on File</div>
								</td>
							</tr>
						</table>
					</div>
					<div>
						<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0" width="49%">
							<tr>
								<td class="cspBodyHeading">Customer Call Ranking</td>
							</tr>
							<tr>
								<td>
									<div>Past Week | Past Month</div>
									<div>Ticket # 3987 Opened 11/12/2010</div>
									<div>Ticket # 3487 Opened 11/17/2010</div>
									<div>Ticket # 3287 Opened 10/17/2010</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="cspFooter">
				<font face="Arial" size="1" style="float:left;">CSP Version 3.0.0</font>
				<font face="Arial" size="1" style="float:right;">Copyright &copy; 2010 HomeFree, Inc.</font>
			</div>
		</div>
	</center>
</body>

</html>