<?php
require_once('config.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="templateDefault.css" />
<META HTTP-EQUIV="Refresh" CONTENT="<?php echo $refRate; ?>">
<title>HomeFree | Active Monitor</title>

</head>

<body>
<div class="container">
<div class="ticketMon" align="center">
	<?php require_once('tickets.php'); ?>
</div>
<div class="taskMon" align="center">
	<?php require_once('tasks.php'); ?>
</div>
<div class="ticketStats" align="center">
	<?php require_once('ticketstats.php'); ?>
</div>
<div class="taskStats" align="center">
	<?php require_once('taskstats.php'); ?>
</div>
	<div class="footer">
		<hr size="1" />
		<font face="Arial" size="1"><address>Copyright &copy; 2005 - 2008 HomeFree, Inc.</address></font>
		<font face="Arial" size="1"><address>CSP Active Monitor 1.00.0</address></font>
	</div>
</div>
</body>

</html>
