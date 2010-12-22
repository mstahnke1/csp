<?php
$qryActiveCall1 = "SELECT * FROM activeCallList WHERE ticket = '$ticketID'";
$rstActiveCall1 = mysql_query($qryActiveCall1);
$numActiveCall = mysql_num_rows($rstActiveCall1);

if($numActiveCall > 0) {
?>
<div class="cspDashModule">	
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Active Call List</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Agent</u></span>
					<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Name</u></span>
					<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Number</u></span>
				</div>
				<?php
				while($rowActiveCall1 = mysql_fetch_array($rstActiveCall1)) {
					?>
					<div class="cspMOHighlight">
						<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;">Mike Stahnke</span>
						<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowActiveCall1['contact']; ?></span>
						<span style="width:15%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo formatPhone($rowActiveCall1['contactNum']); ?></span>
						<span style="display:inline-block; vertical-align:center; padding:1px 1px 1px 1px;"><a href="JavaScript:void(0);" onclick="window.location='cspTicketManagement.php?action=endCall&callID=<?php echo $rowActiveCall1['id']; ?>&ticketID=<?php echo $ticketID; ?>'"><img src="theme/default/images/endcall.png" width="14px" height="14px" border="0" title="End Call" /></a></span>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
</div>
<?php
}
?>