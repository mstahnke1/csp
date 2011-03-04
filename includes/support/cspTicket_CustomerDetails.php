<div class="cspDashModule">	
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">
				<span style="display:inline-block; float:left;">Problem Details</span>
				<?php
				if(!($Status == "Closed" || $Status == "Canceled")) {
					?>
					<span style="float:right;"><a href="JavaScript:void(0);" onClick="javascript:TINY.box.show('cspUserSupport_NewTicket.php?action=editDetails&ticketID=<?php echo $ticketID; ?>',1,0,0,1,0);"><img src="theme/default/images/edit.jpg" width="37" height="14" border="0" title="Edit Problem Details" /></a></span>
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; float:left; padding:1px;">Facility:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowTicketDetail1['facilityName']; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; float:left; padding:1px;">Reported By:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowTicketDetail1['Contact']; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; float:left; padding:1px;">Contact Number:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo formatPhone($rowTicketDetail1['ContactPhone']); ?>&nbsp;ext&nbsp;<?php echo $rowTicketDetail1['Extension']; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; float:left; padding:1px;">Description:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowTicketDetail1['Summary']; ?></span>
				</div>
			</td>
		</tr>
	</table>
</div>