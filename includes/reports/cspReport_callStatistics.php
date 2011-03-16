<?php
include_once('../config.inc.php');
include_once('../db_connect.inc.php');
if(isset($_POST)) {
	$qryRpt1 = "SELECT tblTickets.*, COUNT(tblTicketMessages.id) AS callCount, tblFacilities.FacilityName AS facilityName 
							FROM tblTickets 
							LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
							LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber ";
	$qryRpt2 = "SELECT tblTickets.*, COUNT(tblTicketMessages.id) AS callCount, tblFacilities.FacilityName AS facilityName 
							FROM tblTickets 
							LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
							LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber ";
	
//	foreach($_POST as $val){
//		if(!($val == "ALL" || $val == "")) {
	  	$qryRpt1 .= "WHERE tblTicketMessages.callType != 1 AND ";
	  	$qryRpt2 .= "WHERE tblTicketMessages.callType = 1 AND ";
//	  	break;
//	  } else {
//	  	$qryRpt1 .= "WHERE tblTicketMessages.callType != 1 ";
//	  	$qryRpt2 .= "WHERE tblTicketMessages.callType = 1 ";
//	  	break;
//	  }
//	}
	
	$where = array();
	
	$dateFrom = $_POST['dateFrom'];
	if($dateFrom != "") {
		$where[] = "tblTicketMessages.Date >= '$dateFrom' ";
	}
	
	$dateTo = $_POST['dateTo'];
	if($dateTo != "") {
		$where[] = "tblTicketMessages.Date <= '$dateTo' ";
	}
	
	$custID = $_POST['custID'];
	if($custID != "") {
	  $where[] = "tblTickets.CustomerNumber = '$custID' ";
	}
	
	$incRMA = $_POST['incRMA'];
	if($incRMA != "ALL"){
		if($incRMA == "Only") {
	  	$where[] = "tblTickets.rmaReturn = '1' ";
	  } elseif($incRMA == "No") {
	  	$where[] = "tblTickets.rmaReturn != '1' ";
	  }
	}
	
	$hfEmployee = $_POST['hfEmployee'];
	if($hfEmployee != "ALL"){
	  $where[] = "tblTicketMessages.EnteredBy = '$hfEmployee' ";
	}
	
	$ticketStatus = $_POST['ticketStatus'];
	if($ticketStatus != "ALL"){
		if($ticketStatus == -1 || $ticketStatus == 1) {
	 		$where[] = "tblTickets.Status = '$ticketStatus' ";
	 	} else {
	 		$where[] = "tblTickets.Status IN (0, 2) ";
	 	}
	} else {
		$where[] = "tblTickets.Status != 1 ";
	}
	
	$callType = $_POST['callType'];
	if($callType != "ALL"){
	  $where[] = "tblTicketMessages.callType = '$callType' ";
	}
	
	$issueCat = $_POST['issueCat'];
	if($issueCat != "") {
	  $where[] = "tblTickets.categoryCode = '$issueCat' ";
	}
	
	if(!empty($where)) {
	  $qryRpt1 .= implode(" AND ", $where);
	  $qryRpt2 .= implode(" AND ", $where);
	} else {
		$qryRpt1 = substr($qryRpt1, 0, -4);
		$qryRpt2 = substr($qryRpt2, 0, -4);
	}
	
	$numTotalOffice = 0;
	$qryRpt1 .= "GROUP BY tblTickets.CustomerNumber ORDER BY callCount DESC LIMIT 0,50";
	$resRpt1 = mysql_query($qryRpt1) or die(mysql_error());
	while($rowRpt1 = mysql_fetch_assoc($resRpt1)) {
		$numTotalOffice = $numTotalOffice + $rowRpt1['callCount'];
	}
	mysql_data_seek($resRpt1, 0);
	if($numRpt1 > 0) {
		mysql_data_seek($resRpt1, 0);
	}
	
	$numTotalOnCall = 0;
	$qryRpt2 .= "GROUP BY tblTickets.CustomerNumber ORDER BY callCount DESC LIMIT 0,50";
	$resRpt2 = mysql_query($qryRpt2);
	$numRpt2 = mysql_num_rows($resRpt2);
	while($rowRpt2 = mysql_fetch_assoc($resRpt2)) {
		$numTotalOnCall = $numTotalOnCall + $rowRpt2['callCount'];
	}
	if($numRpt2 > 0) {
		mysql_data_seek($resRpt2, 0);
	}
}
?>
<table border="0" width="100%" cellspacing="1" cellpadding="0">
	<tr>
		<td class="cspTicketHeading" colspan="2">
			<span style="float: left;">Statistics Report</span>
		</td>
	</tr>
		<td width="50%" align="center" valign="top" style="text-align: left;">
			<table class="ticketStats" border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td class="statHeading">
						<b>Office Hour Stats</b><br />
						<?php echo $numTotalOffice; ?> Total Calls
					</td>
				</tr>
				<?php
				while($rowRpt1 = mysql_fetch_assoc($resRpt1)) {
					?>
					<tr>
						<td class="statData">
							<div id="callCount">
								<a href="javascript:void(0);" onclick="buildRpt('cspRprtParams', 'cspReport_callDetailed.php', '<?php echo $rowRpt1['CustomerNumber']; ?>');">
									<?php echo $rowRpt1['facilityName'] . " <i>(" . $rowRpt1['callCount'] . ")</i>"; ?>
								</a>
							</div>
							<div id="ticketList">

							</div>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</td>
		<td width="50%" align="center" valign="top" style="text-align: left; border-left: 1px solid #999999;">
			<table class="ticketStats" border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td class="statHeading">
						<b>After Hour Stats</b> <br />
						<?php echo $numTotalOnCall; ?> Total Calls
					</td>
				</tr>
				<?php
				while($rowRpt2 = mysql_fetch_assoc($resRpt2)) {
					?>
					<tr>
						<td class="statData">
							<div id="callCount">
								<?php echo $rowRpt2['CustomerNumber'] . " " . $rowRpt2['facilityName'] . " <i>(" . $rowRpt2['callCount'] . ")</i>"; ?>
							</div>
							<div id="ticketList">

							</div>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</td>
	</tr>
</table>