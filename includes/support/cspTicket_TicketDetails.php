<?php
$qryTicketDetails1 = "SELECT MAX(Date) AS lastUpdate FROM tblTicketMessages WHERE TicketID = '$ticketID'";
$rstTicketDetails1 = mysql_query($qryTicketDetails1) or die(mysql_error());
$rowTicketDetails1 = mysql_fetch_array($rstTicketDetails1);
if(is_null($rowTicketDetail1['categoryCode'])) {
	$catDesc = "Undefined";
} else {
	$catDesc = $rowTicketDetail1['catDesc'];
	$catCode = $rowTicketDetail1['parentCode'];
	$i = 1;
	while($i > 0) {
		$qryCatCode1 = "SELECT * FROM issueCategories WHERE code = '$catCode'";
		$rstCatCode1 = mysql_query($qryCatCode1);
		$i = mysql_num_rows($rstCatCode1);
		$rowCatCode1 = mysql_fetch_assoc($rstCatCode1);
		if($i > 0) {
			$catDesc = $rowCatCode1['description'] . " &rarr; " . $catDesc;
		}
		$catCode = $rowCatCode1['parentCode'];
	}
}
mysql_select_db($dbname2);
$qryTicketDetails2 = "SELECT * FROM taskinfo WHERE ticketNum = '$ticketID'";
$resTicketDetails2 = mysql_query($qryTicketDetails2);
$rowTicketDetails2 = mysql_fetch_array($resTicketDetails2);
$taskCount = mysql_num_rows($resTicketDetails2);
mysql_select_db($dbname);
?>
<div class="cspDashModule">	
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Ticket Details</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; float:left; text-align:right; padding:1px;">Ticket ID:</span>
					<span style="display:inline-block; width:68%; text-align:left; float:right; padding:1px;"><?php echo $rowTicketDetail1['ID']; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; float:left; text-align:right; padding:1px;">Status:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $Status; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; float:left; text-align:right; padding:1px;">Opened By:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $openedBy; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; float:left; text-align:right; padding:1px;">Date Created:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowTicketDetail1['DateOpened']; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; float:left; text-align:right; padding:1px;">Last Updated:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowTicketDetails1['lastUpdate']; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; float:left; text-align:right; padding:1px;">Linked Tasks:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><a href="task/task.php?action=UPDATE&viewticketNum=<?php echo $ticketID; ?>" target="_blank"><?php echo $taskCount; ?></a></span>
				</div>
				<div>
					<span style="display:inline-block; width:28%; vertical-align:top; float:left; text-align:right; padding:1px;">Issue Category:</span>
					<span style="display:inline-block; width:68%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $catDesc; ?></span>
				</div>
			</td>
		</tr>
	</table>
</div>