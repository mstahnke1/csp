<!-- START Recent Support Call Stats Dashboard Module -->
<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';

$dateTo = date('Y-m-d', strtotime('+1 day',strtotime(date('Y-m-d'))));
$dateFrom = date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));

$qryDashCallVol1 = "SELECT tblTickets.id AS ticketID, tblTickets.CustomerNumber AS custNum, tblTickets.DateOpened AS dateOpened, tblFacilities.FacilityName AS facilityName  
										FROM tblTickets 
										LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
										LEFT JOIN tblFacilities ON tblFacilities.CustomerNumber = tblTickets.CustomerNumber 
										WHERE (tblTickets.OpenedBy = '$userID' OR tblTicketMessages.EnteredBy = '$userID') 
										AND tblTickets.Status NOT IN(1) 
										AND tblTicketMessages 
										GROUP BY custNum";
$rstDashCallVol1 = mysql_query($qryDashCallVol1);
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Call Volume Statistics</td>
		</tr>
	</table>
</div>

<?php
include 'includes/db_close.inc.php';
?>
<!-- END Recent Support Call Stats Dashboard Module -->