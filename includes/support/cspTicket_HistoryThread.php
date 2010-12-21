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
					?>
					<div class="cspMOHighlight">
						<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $agentName; ?></span>
						<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowTicketHistory1['Date']; ?></span>
						<?php
						if($rowTicketHistory1['msgType'] == 0) {
							?>
							<span style="display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;">Comment Added</span>
							<span style="display:inline-block; vertical-align:center; padding:1px 1px 1px 1px;"><a href="JavaScript:void(0);" onclick="showDiv('cspTicketComment_<?php echo $rowTicketHistory1['ID']; ?>');"><img src="theme/default/images/moreInfo.jpg" width="13px" height="13px" border="0" /></a></span>
							<div id="cspTicketComment_<?php echo $rowTicketHistory1['ID']; ?>" class="cspTicketComment"><?php echo $rowTicketHistory1['Message']; ?></div>
							<?php
						} else {
							?>
							<span style="display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowTicketHistory1['Message']; ?></span>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
				</div>
			</td>
		</tr>
	</table>
</div>