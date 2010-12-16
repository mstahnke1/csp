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
					<ul id="navbar">
						<li><a href="#">Home</a><ul>
							<li><a href="#">Task Managment</a></li>
							<li><a href="http://www.google.com/calendar/embed?src=robbinh%40homefreesys.com&ctz=America/Chicago&pvttk=62ed24008053bf9f9905ef7216c557b9" target="_blank">HomeFree Calendar</a></li>
							<li><a href="#">Portal Notifications</a></li>
							<li><a href="#">Employee List</a></li></ul>
						</li>
						<!-- ... and so on ... -->
					</ul>
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
				<?php require_once('cspFooter.php'); ?>
			</div>
		</div>
	</center>
</body>

</html>