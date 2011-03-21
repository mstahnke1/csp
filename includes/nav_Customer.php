<li><a href="cspUserSupport_Customer.php?custID=<?php echo $custID; ?>">Customer</a><ul>
	<?php
	if(isset($custID)) {
		?>
		<li><a href="JavaScript:void(0);" onclick="getPage('cspUserSupport_CustSysInfo.php?custID=<?php echo $custID; ?>', 'newContent');">System Details</a></li>
		<li><a href="JavaScript:void(0);" onclick="javascript:TINY.box.show('cspUserSupport_NewTicket.php?custID=<?php echo $custID; ?>',1,0,0,1,0);">New Ticket</a></li>
		<?php
	}
	?>
	<li><a href="#">Add Contact</a></li>
	<li><a href="#">Monitor</a></li></ul>
</li>