<!-- START Recent Support Call Stats Dashboard Module -->
<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';

$dateTo = date('Y-m-d', strtotime('+1 day',strtotime(date('Y-m-d'))));
$dateFrom = date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));

$qryDashCallVol1 = "SELECT COUNT(tblTickets.id) as ticketCount, tblTickets.id AS ticketID, tblTickets.CustomerNumber AS custNum, tblTickets.DateOpened AS dateOpened, tblFacilities.FacilityName AS facilityName, tblTicketMessages.Date, MAX(tblTicketMessages.Date) AS lastCall  
										FROM tblTickets 
										LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
										LEFT JOIN tblFacilities ON tblFacilities.CustomerNumber = tblTickets.CustomerNumber 
										WHERE ((tblTickets.DateOpened >= '$dateFrom' AND tblTickets.DateOpened <= '$dateTo') OR (tblTicketMessages.Date >= '$dateFrom' AND tblTicketMessages.Date <= '$dateTo'))  
										AND tblTickets.Status NOT IN(1) 
										GROUP BY custNum 
										ORDER BY ticketCount DESC 
										LIMIT 15";
$rstDashCallVol1 = mysql_query($qryDashCallVol1) or die(mysql_error());
$numDashCallVol1 = mysql_num_rows($rstDashCallVol1);
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Call Volume Statistics</td>
		</tr>
		<tr>
			<td>
				<?php
				if($numDashCallVol1 > 0) {
					?>
					<div>
						<span style="display:inline-block; width:77%;"><strong><u>Facility (Calls)</u></strong></span><span style="display:inline-block; width:23%;"><strong><u>Last Call</u></strong></span>
					</div>
					<?php
					while($rowDashCallVol1 = mysql_fetch_array($rstDashCallVol1)) {
						$lastCall = date("Y-m-d", strtotime($rowDashCallVol1['lastCall']));
						$dateOpen = date("Y-m-d", strtotime($rowDashCallVol1['dateOpened']));
						if($lastCall == "1969-12-31") {
							$lastCall = $dateOpen;
						}
						?>
						<div class="cspMOHighlight">
							<span style="display:inline-block; width:77%;"><?php echo $rowDashCallVol1['facilityName'] . " (" . $rowDashCallVol1['ticketCount'] . ")"; ?></span><span style="display:inline-block; width:23%; vertical-align:top;"><?php echo $lastCall; ?></span>
						</div>
						<?php
					}
				} else {
					?>
					<div>
						<span style="display:inline-block; width:100%;">No recent calls have been logged.</span>
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