<?php
$qryTicketDetails1 = "SELECT MAX(Date) AS lastUpdate FROM tblTicketMessages WHERE TicketID = '$ticketID'";
$rstTicketDetails1 = mysql_query($qryTicketDetails1) or die(mysql_error());
$rowTicketDetails1 = mysql_fetch_array($rstTicketDetails1);
if(is_null($rowTicketDetail1['categoryCode'])) {
	$categoryCode = "Undefined";
} else {
	$categoryCode = $rowTicketDetail1['categoryCode'];
}
?>
<div class="cspDashModule">	
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Ticket Details</td>
		</tr>
		<tr>
			<td>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Ticket ID:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $rowTicketDetail1['ID']; ?></span>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Status:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $Status; ?></span>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Opened By:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $openedBy; ?></span>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Date Created:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $rowTicketDetail1['DateOpened']; ?></span>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Last Updated:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $rowTicketDetails1['lastUpdate']; ?></span>
				<span style="display:inline-block; width:28%; vertical-align:top; text-align:right; padding:2px 1px 1px 5px;">Issue Category:</span><span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:2px 1px 1px 1px"><?php echo $categoryCode; ?></span>
			</td>
		</tr>
	</table>
</div>