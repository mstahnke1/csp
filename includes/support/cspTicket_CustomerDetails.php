<div class="cspDashModule">	
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Problem Details
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
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Facility:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $rowTicketDetail1['facilityName']; ?></span>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Reported By:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $rowTicketDetail1['Contact']; ?></span>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Contact Number:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo formatPhone($rowTicketDetail1['ContactPhone']); ?></span>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Description:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $rowTicketDetail1['Summary']; ?></span>
			</td>
		</tr>
	</table>
</div>