<?php
$qryTicketDetail3 = "SELECT id FROM activeCallList WHERE agent = '$agentID' AND ticket = '$ticketID'";
$rstTicketDetail3 = mysql_query($qryTicketDetail3);
$numTicketDetail3 = mysql_num_rows($rstTicketDetail3);
$qryTicketNav1 = "SELECT ID FROM rmaDevices WHERE TicketID = '$ticketID'";
$resTicketNav1 = mysql_query($qryTicketNav1) or die(mysql_error());
$numTicketNav1 = mysql_num_rows($resTicketNav1);
?>
<li><a href="#">Ticket</a><ul>
	<?php
	if($Status == "Open" || $Status == "Escalated") {
		if($numTicketDetail3 > 0) {
			?>
			<li><a href="JavaScript:void(0);" onclick="javascript:TINY.box.show('cspUserSupport_AddTicketComment.php?ticketID=<?php echo $ticketID; ?>',1,0,0,1,0);">New Comment</a></li>
			<?php
			if($numTicketNav1 < 1) {
				?>
				<li><a href="JavaScript:void(0);" onclick="javascript:showDiv('rmaInfo')">Create RMA</a></li>
				<?php
			}
		}
		?>
		<li><a href="JavaScript:void(0);" onclick="window.location='scripts/ticketMgmt.php?action=escalateTicket&ticketID=<?php echo $ticketID; ?>'">Escalate Ticket</a></li>
		<?php
		if(!is_null($rowTicketDetail1['categoryCode'])) {
			?>
			<li><a href="JavaScript:void(0);" onclick="javascript:showDiv('issueCatMod')">Re-Categorize Issue</a></li>
			<?php
		}
		if($numTicketDetail3 < 1) {
		?>
			<li><a href="JavaScript:void(0);" onclick="javascript:TINY.box.show('cspUserSupport_NewCall.php?ticketID=<?php echo $ticketID; ?>',1,0,0,1,0);">New Call</a></li>
			<li><a href="JavaScript:void(0);" onclick="window.location='scripts/ticketMgmt.php?action=cancelTicket&ticketID=<?php echo $ticketID; ?>'">Cancel Ticket</a></li>
			<li><a href="JavaScript:void(0);" onclick="window.location='scripts/ticketMgmt.php?action=closeTicket&ticketID=<?php echo $ticketID; ?>'">Close Ticket</a></li>
		<?php
		}
	}
	if($Status == "Closed") {
		?>
		<li><a href="JavaScript:void(0);" onclick="window.location='scripts/ticketMgmt.php?action=reopenTicket&ticketID=<?php echo $ticketID; ?>'">Reopen Ticket</a></li>
		<?php
	}
	?>
	</ul>
</li>