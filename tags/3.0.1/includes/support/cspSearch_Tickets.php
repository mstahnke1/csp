<?php
if(isset($_GET['srchString'])) {
	include('../config.inc.php');
	include('../db_connect.inc.php');
	$srchString = $_GET['srchString'];
	$qryTicketSearch = "SELECT ID FROM tblTickets WHERE ID = $srchString";
	$rstTicketSearch = mysql_query($qryTicketSearch) or die(mysql_error());
	$numTicketSearch = mysql_num_rows($rstTicketSearch);
	include('../db_close.inc.php');
	if($numTicketSearch > 0 ) {
		die(header("Location: ../../cspUserSupport_TicketDetail.php?ticketID=" . $srchString));
	} else {
		die(header("Location: ../../cspUserSupport_Search.php?type=Ticket&msgID=26"));
	}
}
?>
<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td colspan="2" class="cspBodyHeading">Ticket Lookup</td>
	</tr>
	<tr>
		<form id="lookupTicket" name="lookupTicket" action="includes/support/cspSearch_Tickets.php" method="get">
			<td style="text-align: right;">Ticket Number:</td>
			<td>
				<input type="text" name="srchString" />
				<input type="submit" value="Search" />
			</td>
		</form>
	</tr>
</table>
<div id="resultsDiv"></div>