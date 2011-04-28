<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
require_once('includes/cspSessionMgmt.php');
?>

<head>
	<title>Company Name | Customer Service Portal</title>
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
				<div class="sidebox">
					<div class="boxhead"><h2>Recent Activity</h2></div>
					<div class="boxbody">
						<div class="box-option">List option number 1 and data</div>
						<div class="box-option">List option number 2 and data</div>
						<div class="box-option">List option number 3 and data</div>
						<div class="box-option">List option number 4 and data</div>
					</div>
				</div>
			</div>
			<div class="cspContent" align="left">
				<div class="cspNavBar">
					<div class="cspNavBarItem">Home</div>
					<div class="cspNavBarItem">Nav2</div>
					<div class="cspNavBarItem">Nav3</div>
				</div>
				<div class="cbb">
					<p>
						HomeFree Customer Service Excellence!<br />
						Powered by the new<br />
						Customer Service Portal Version 3.0!
					</p>
				</div>
			</div>
			<div class="cspFooter">
				<font face="Arial" size="1" style="float:left;"><address>CSP Version 3.0.0</address></font>
				<font face="Arial" size="1" style="float:right;"><address>Copyright &copy; 2010 HomeFree, Inc.</address></font>
			</div>
		</div>
	</center>
</body>

</html>