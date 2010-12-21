<div class="cspDashModule">	
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Problem Details<span style="float:right;"><a href="#"><img src="theme/default/images/edit.jpg" width="37" height="14" border="0" /></a></span></td>
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