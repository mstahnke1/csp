<!-- START Recent Support Call Stats Dashboard Module -->
<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';

$dateTo = date('Y-m-d', strtotime('+1 day',strtotime(date('Y-m-d'))));
$dateFrom = date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));

$qryDashCallVol1 = "SELECT tblTickets.id AS ticketID, tblTickets.CustomerNumber AS custNum, tblTickets.DateOpened AS dateOpened, tblFacilities.FacilityName AS facilityName, tblTicketMessages.Date 
										FROM tblTickets 
										LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
										LEFT JOIN tblFacilities ON tblFacilities.CustomerNumber = tblTickets.CustomerNumber 
										WHERE ((tblTickets.DateOpened >= '$dateFrom' AND tblTickets.DateOpened <= '$dateTo') OR (tblTicketMessages.Date >= '$dateFrom' AND tblTicketMessages.Date <= '$dateTo'))  
										AND tblTickets.Status NOT IN(1) 
										GROUP BY custNum";
$rstDashCallVol1 = mysql_query($qryDashCallVol1) or die(mysql_error());
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Call Volume Statistics</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:77%;"><strong><u>Facility</u></strong></span><span style="display:inline-block; width:23%;"><strong><u>Ticket Details</u></strong></span>
				</div>
				<?php
				while($rowDashTickets1 = mysql_fetch_array($rstDashTickets1)) {
					?>
					<div class="cspMOHighlight">
						<span style="display:inline-block; width:77%;">Ticket # <?php echo $rowDashTickets1['ticketID'] . " (" . $rowDashTickets1['facilityName'] . ")"; ?></span><span style="display:inline-block; width:23%; vertical-align:top;"><?php echo date("Y-m-d", strtotime($rowDashTickets1['dateOpened'])); ?></span>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
</div>

<?php
include 'includes/db_close.inc.php';
?>
<!-- END Recent Support Call Stats Dashboard Module -->