<?php
$qryTicketHistory1 = "SELECT tblTicketMessages.*, employees.f_name AS firstName, employees.l_name AS lastName 
											FROM tblTicketMessages 
											LEFT JOIN employees ON tblTicketMessages.EnteredBy = employees.id 
											WHERE TicketID = '$ticketID' ORDER BY ID DESC";
$rstTicketHistory1 = mysql_query($qryTicketHistory1) or die(mysql_error());
?>
<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">History Thread</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Agent</u></span>
					<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Timestamp</u></span>
					<span style="display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Update</u></span>
				</div>
				<?php
				while($rowTicketHistory1 = mysql_fetch_array($rstTicketHistory1)) {
					$agentName = $rowTicketHistory1['firstName'] . " " . $rowTicketHistory1['lastName'];
					if($rowTicketHistory1['msgType'] == 0) {
						$updateType = "Comment Added";
					} elseif($rowTicketHistory1['msgType'] == 1) {
						$updateType = "Ticket Opened";
					} elseif($rowTicketHistory1['msgType'] == 2) {
						$updateType = "Call Started";
					} elseif($rowTicketHistory1['msgType'] == 3) {
						$updateType = "Call Ended";
					} elseif($rowTicketHistory1['msgType'] == 4) {
						$updateType = "Ticket Closed";
					} elseif($rowTicketHistory1['msgType'] == 5) {
						$updateType = "Ticket Reopened";
					} elseif($rowTicketHistory1['msgType'] == 6) {
						$updateType = "Problem Details Updated";
					} elseif($rowTicketHistory1['msgType'] == 7) {
						$updateType = "Issue Category Updated";
					} elseif($rowTicketHistory1['msgType'] == 8) {
						$updateType = "Ticket Canceled";
					} elseif($rowTicketHistory1['msgType'] == 9) {
						$updateType = "Ticket Escalated";
					} elseif($rowTicketHistory1['msgType'] == 10) {
						$updateType = "RMA Processed";
					} elseif($rowTicketHistory1['msgType'] == 11) {
						$updateType = "Return Processed";
					}
					?>
					<div class="cspMOHighlight">
						<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $agentName; ?></span>
						<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowTicketHistory1['Date']; ?></span>
						<span style="display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $updateType; ?></span>
						<?php
						if($rowTicketHistory1['msgType'] == 0 || $rowTicketHistory1['msgType'] == 2 || $rowTicketHistory1['msgType'] == 3 || $rowTicketHistory1['msgType'] == 10) {
							?>
							<span style="display:inline-block; vertical-align:center; padding:1px 1px 1px 1px;"><a href="JavaScript:void(0);" onclick="showDiv('cspTicketComment_<?php echo $rowTicketHistory1['ID']; ?>');"><img src="theme/default/images/moreInfo.jpg" width="13px" height="13px" border="0" title="View Additional Information" /></a></span>
							<?php
						}
						?>
						<div id="cspTicketComment_<?php echo $rowTicketHistory1['ID']; ?>" class="cspTicketComment"><?php echo $rowTicketHistory1['Message']; ?></div>
					</div>
					<?php
				}
				?>
				</div>
			</td>
		</tr>
	</table>
</div>