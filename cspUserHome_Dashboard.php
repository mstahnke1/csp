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
				&nbsp;
			</div>
			<div id="cspContent" class="cspContent" align="left">
				<div class="cspNavBar">
					<div class="cspNavBarItem">Home</div>
				</div>
				<div class="cbb">
					<div class="dashLeftCol">
						<?php require_once('includes/dashboard/homeDash_Tasks.php'); ?>
						<?php require_once('includes/dashboard/homeDash_Tickets.php'); ?>
					</div>
					<div class="dashRightCol">
						<?php require_once('includes/dashboard/homeDash_DbBackups.php'); ?>
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