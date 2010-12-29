<!-- START Ticket Information Dashboard Module -->
<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
$userID = '1';
$qryDashTickets1 = "SELECT DISTINCT tblTickets.id AS ticketID, tblTickets.CustomerNumber AS custNum, tblTickets.DateOpened AS dateOpened, tblFacilities.FacilityName AS facilityName  
										FROM tblTickets 
										LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
										LEFT JOIN tblFacilities ON tblFacilities.CustomerNumber = tblTickets.CustomerNumber 
										WHERE (tblTickets.OpenedBy = '$userID' OR tblTicketMessages.EnteredBy = '$userID') 
										AND tblTickets.Status NOT IN(-1, 1)";
$rstDashTickets1 = mysql_query($qryDashTickets1) or die(mysql_error());
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Open Tickets</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:77%;"><u>Ticket Details</u></strong></span><span style="display:inline-block; width:23%;"><u>Date Opened</u></strong></span>
				</div>
				<?php
				while($rowDashTickets1 = mysql_fetch_array($rstDashTickets1)) {
					?>
					<div class="cspMOHighlight">
						<a href="JavaScript:void(0);" onclick="window.location='cspUserSupport_TicketDetail.php?ticketID=<?php echo $rowDashTickets1['ticketID']; ?>'">
							<span style="display:inline-block; width:77%;">Ticket # <?php echo $rowDashTickets1['ticketID'] . " (" . $rowDashTickets1['facilityName'] . ")"; ?></span><span style="display:inline-block; width:23%; vertical-align:top;"><?php echo date("Y-m-d", strtotime($rowDashTickets1['dateOpened'])); ?></span>
						</a>
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
<!-- END Ticket Information Dashboard Module -->