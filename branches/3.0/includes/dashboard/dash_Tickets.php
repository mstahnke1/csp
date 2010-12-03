<!-- START Ticket Information Dashboard Module -->
<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
$userID = '1';
$qryDashTickets1 = "SELECT id FROM tbltickets WHERE OpenedBy = '$userID' && Status NOT IN(-1, 1)";
$rstDashTickets1 = mysql_query($qryDashTickets1) or die(mysql_error());
?>

<div>
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0" width="49%">
		<tr>
			<td class="cspBodyHeading">Open Tickets</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:75%;"><strong><u>Ticket Details</u></strong></span><span style="display:inline-block; width:25%;"><strong><u>Date Opened</u></strong></span>
				</div>
				<div class="cspMOHighlight">
					<span style="display:inline-block; width:75%;">Ticket # 3987 (Morningside House)</span><span style="display:inline-block; width:25%;">11/12/2010</span>
				</div>
				<div class="cspMOHighlight">
					<span style="display:inline-block; width:75%;">Ticket # 4127 (St. Johns Home)</span><span style="display:inline-block; width:25%;">11/19/2010</span>
				</div>
				<div class="cspMOHighlight">
					<span style="display:inline-block; width:75%;">Ticket # 4144 (American Lake VA)</span><span style="display:inline-block; width:25%;">11/20/2010</span>
				</div>
			</td>
		</tr>
	</table>
</div>

<?php
include 'includes/db_close.inc.php';
?>
<!-- END Ticket Information Dashboard Module -->