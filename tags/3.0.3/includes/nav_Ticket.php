<?php
$qryTicketDetail3 = "SELECT id FROM activeCallList WHERE agent = '$agentID' AND ticket = '$ticketID'";
$rstTicketDetail3 = mysql_query($qryTicketDetail3);
$numTicketDetail3 = mysql_num_rows($rstTicketDetail3);
$qryTicketNav1 = "SELECT ID FROM rmaDevices WHERE TicketID = '$ticketID'";
$resTicketNav1 = mysql_query($qryTicketNav1) or die(mysql_error());
$numTicketNav1 = mysql_num_rows($resTicketNav1);
$qryTicketNav2 = "SELECT * FROM rmaDevices WHERE TicketID = '$ticketID' AND Warranty = 2 AND Device IN(SELECT `part#` FROM devicelist WHERE rmaPreApproval = '1')";
$resTicketNav2 = mysql_query($qryTicketNav2);
$numTicketNav2 = mysql_num_rows($resTicketNav2);
?>
<li><a href="cspUserSupport_TicketDetail.php?ticketID=<?php echo $ticketID; ?>">Ticket</a><ul>
	<?php
	if($Status == "Open" || $Status == "Escalated") {
		if($numTicketDetail3 > 0) {
			?>
			<li><a href="JavaScript:void(0);" onclick="javascript:TINY.box.show('cspUserSupport_AddTicketComment.php?ticketID=<?php echo $ticketID; ?>',1,0,0,1,0);">New Comment</a></li>
			<?php
			if($numTicketNav1 < 1) {
				?>
				<li><a href="JavaScript:void(0);" onclick="javascript:showDiv('rmaInfo', '')">Create RMA</a></li>
				<?php
			}
		}
		if($Status != "Escalated") {
			?>
			<li><a href="JavaScript:void(0);" onclick="changeStatus(2, '<?php echo $ticketID; ?>');">Escalate Ticket</a></li>
			<?php
		}
		if(!is_null($rowTicketDetail1['categoryCode'])) {
			?>
			<li><a href="JavaScript:void(0);" onclick="javascript:showDiv('issueCatMod', '')">Re-Categorize Issue</a></li>
			<?php
		}
		if($numTicketDetail3 < 1) {
		?>
			<li><a href="JavaScript:void(0);" onclick="javascript:TINY.box.show('cspUserSupport_NewCall.php?ticketID=<?php echo $ticketID; ?>',1,0,0,1,0);">New Call</a></li>
			<li><a href="JavaScript:void(0);" onclick="changeStatus(1, '<?php echo $ticketID; ?>');">Cancel Ticket</a></li>
			<li><a href="JavaScript:void(0);" onclick="changeStatus(-1, '<?php echo $ticketID; ?>');">Close Ticket</a></li>
		<?php
		}
	}
	if($Status == "Closed" && $numTicketNav2 > 0) {
		?>
		<li><a href="JavaScript:void(0);" onclick="window.open('ver2/rmaAuthForm.php?ticketID=<?php echo $ticketID; ?>')">Authorization Form</a></li>
		<?php
	}
	if($Status == "Closed" && ($_SESSION['dept'] == 2 || $_SESSION['access'] >= 7)) {
		?>
		<li><a href="JavaScript:void(0);" onclick="window.location='scripts/ticketMgmt.php?action=reopenTicket&ticketID=<?php echo $ticketID; ?>'">Reopen Ticket</a></li>
		<?php
	}
	?>
	</ul>
</li>