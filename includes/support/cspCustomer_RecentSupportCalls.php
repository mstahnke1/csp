<!-- START Recent Support Call Stats Dashboard Module -->
<?php
include('includes/config.inc.php');
include('includes/db_connect.inc.php');
if(isset($custID)) {
	$qryRecentCalls1 = "SELECT tblTickets.*, GREATEST(MAX(tblTicketMessages.Date), tblTickets.DateOpened) AS lastUpdate, tblTicketMessages.Date, employees.f_name AS firstName, employees.l_name AS lastName 
											FROM tblTickets 
											LEFT JOIN employees ON tblTickets.OpenedBy = employees.id 
											LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
											WHERE tblTickets.CustomerNumber = '$custID' AND tblTickets.Status <> 1 
											GROUP BY tblTickets.ID 
											ORDER BY lastUpdate DESC 
											LIMIT 5";
	$rstRecentCalls1 = mysql_query($qryRecentCalls1) or die(mysql_error());
	$numRecentCalls1 = mysql_num_rows($rstRecentCalls1);
}
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Recent Support Calls</td>
		</tr>
		<tr>
			<td>
				<?php
				if($numRecentCalls1 > 0) {
					?>
					<div>
						<span style="width:6%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Ticket</u></span>
						<span style="width:8%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Status</u></span>
						<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Reported By</u></span>
						<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Last Updated</u></span>
						<span style="width:49%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Problem Description</u></span>
					</div>
					<?php
					while($rowRecentCalls1 = mysql_fetch_array($rstRecentCalls1)) {
						$agentName = $rowRecentCalls1['firstName'] . " " . $rowRecentCalls1['lastName'];
						if($rowRecentCalls1['Status'] == 0) {
							$Status = 'Open';
						} elseif($rowRecentCalls1['Status'] == 1) {
							$Status = 'Canceled';
						} elseif($rowRecentCalls1['Status'] == 2) {
							$Status = 'Escalated';
						} else {
							$Status = 'Closed';
						}
						?>
						<a href="cspUserSupport_TicketDetail.php?ticketID=<?php echo $rowRecentCalls1['ID']; ?>">
						<div class="cspMOHighlight">
							<span style="width:6%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRecentCalls1['ID']; ?></span>
							<span style="width:8%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $Status; ?></span>
							<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRecentCalls1['Contact']; ?></span>
							<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRecentCalls1['lastUpdate']; ?></span>
							<span style="width:49%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRecentCalls1['Summary']; ?></span>
						</div>
						</a>
						<?php
					}
				} else {
					?>
					<div>
						<span style="display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;">No support calls recorded</span>
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