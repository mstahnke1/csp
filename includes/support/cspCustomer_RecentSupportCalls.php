<!-- START Recent Support Call Stats Dashboard Module -->
<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';

$custID = $_GET['custID'];
$qryRecentCalls1 = "SELECT tblTickets.*, employees.f_name AS firstName, employees.l_name AS lastName 
										FROM tblTickets 
										LEFT JOIN employees ON tblTickets.OpenedBy = employees.id 
										WHERE tblTickets.CustomerNumber = '000000' ORDER BY ID DESC 
										LIMIT 5";
$rstRecentCalls1 = mysql_query($qryRecentCalls1) or die(mysql_error());
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Recent Support Calls</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="width:6%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Ticket</u></span>
					<span style="width:8%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Status</u></span>
					<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Reported By</u></span>
					<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Timestamp</u></span>
					<span style="display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Problem Description</u></span>
				</div>
				<?php
				while($rowRecentCalls1 = mysql_fetch_array($rstRecentCalls1)) {
					$agentName = $rowRecentCalls1['firstName'] . " " . $rowRecentCalls1['lastName'];
					if($rowRecentCalls1['Status']==0) {
						$Status = 'Open';
					} elseif($rowRecentCalls1['Status']==1) {
						$Status = 'Canceled';
					}elseif($rowRecentCalls1['Status']==2) {
						$Status = 'Escalated';
					}else{
						$Status = 'Closed';
					}
					?>
					<a href="cspUserSupport_TicketDetail.php?ticketID=<?php echo $rowRecentCalls1['ID']; ?>">
					<div class="cspMOHighlight">
						<span style="width:6%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRecentCalls1['ID']; ?></span>
						<span style="width:8%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $Status; ?></span>
						<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRecentCalls1['Contact']; ?></span>
						<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRecentCalls1['DateOpened']; ?></span>
						<span style="width:50%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRecentCalls1['Summary']; ?></span>
					</div>
					</a>
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