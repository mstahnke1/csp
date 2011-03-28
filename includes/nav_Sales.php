<?php
$qrySaleMenu1 = "SELECT projmanage FROM employees WHERE id = '$_SESSION[uid]'";
$rstSaleMenu1 = mysql_query($qrySaleMenu1);
$rowSaleMenu1 = mysql_fetch_assoc($rstSaleMenu1);
?>
<li><a href="#">Sales</a><ul>
	<li><a href="sales/addcustomer.php?view=new">Create Scope of Work</a></li>
	<li><a href="sales/searchfacility.php">Lookup Scope of Work</a></li>
	<li><a href="sales/servicecall.php?view=new">Service Calls</a></li>
	<li><a href="sales/proactivecall.php">Proactive Calls</a></li>
	<?php
	if($rowSaleMenu1['projmanage'] == 1) {
		?>
		<li><a href="sales/searchfacility.php">Create Install Quote from Scope</a></li>
		<li><a href="sales/installquotesearch.php?by=hfq">Lookup Install Quote on HFQ</a></li>
		<li><a href="sales/installquote.php?view=installprices">Update Install Prices</a></li>
		<li><a href="sales/installquotesearch.php?by=facility">Schedule Install/Training</a></li>
		<li><a href="sales/installquotesearch.php?value=New_Customers&page=ticket">Add Install Ticket</a></li>
		<li><a href="sales/installquotesearch.php?value=New_Customers&page=viewticket">View Install Tickets</a></li>
		<?php
	}
	?>
	<li><a href="sales/installquote.php?view=installcalendar">Install Calendar</a></li></ul>
</li>