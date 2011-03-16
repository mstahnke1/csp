<?php
include_once('../config.inc.php');
include_once('../db_connect.inc.php');
require_once('../functions.inc.php');
if(isset($_POST)) {
	$qryRpt1 = "SELECT tblTickets.*, MAX(tblTicketMessages.Date) AS lastUpdate, tblFacilities.FacilityName AS facilityName 
							FROM tblTickets 
							LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
							LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber ";
	
//	foreach($_POST as $val){
//		if(!($val == "ALL" || $val == "")) {
	  	$qryRpt1 .= "WHERE tblTicketMessages.callType != 1 AND ";
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
	} else {
		$qryRpt1 = substr($qryRpt1, 0, -4);
	}
	
	$numTotalOffice = 0;
	$qryRpt1 .= "GROUP BY tblTickets.ID ORDER BY lastUpdate DESC LIMIT 0,50";
	$resRpt1 = mysql_query($qryRpt1) or die(mysql_error());
	$rowRpt1 = mysql_fetch_assoc($resRpt1);
	$facilityName = $rowRpt1['facilityName'];
	mysql_data_seek($resRpt1, 0);
}
?>
<table border="0" width="100%" cellspacing="1" cellpadding="0">
	<tr>
		<td class="cspTicketHeading" colspan="2">
			<span style="float: left;">Ticket Detail Report - <?php echo $facilityName; ?></span>
		</td>
	</tr>
		<td width="100%" align="center" valign="top" style="text-align: left;">
			<table class="ticketStats" border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td class="statHeading">
						<b>Office Hour Stats</b><br />
						<?php echo $numTotalOffice; ?> Total Calls
						<div>
							<span style="display:inline-block; width:7%;">
								<u>Ticket</u>
							</span>
							<span style="display:inline-block; width:18%;">
								<u>Date Opened</u>
							</span>
							<span style="display:inline-block; width:18%;">
								<u>Last Update</u>
							</span>
							<span style="display:inline-block; width:38%;">
								<u>Call Details</u>
							</span>
						</div>
						<?php
						while($rowRpt1 = mysql_fetch_assoc($resRpt1)) {
							$qryCallDetail1 = "SELECT tblTicketMessages.*, employees.f_name AS fName, employees.l_name AS lName 
																FROM tblTicketMessages 
																LEFT JOIN employees ON tblTicketMessages.EnteredBy = employees.id 
																WHERE tblTicketMessages.ticketID = '$rowRpt1[ID]' AND tblTicketMessages.callid IS NOT NULL";
							$resCallDetail1 = mysql_query($qryCallDetail1) or die(mysql_error());
							?>
							<div style="clear:both;">
								<span style="display:inline-block; width:7%; vertical-align:text-top;">
									<?php echo $rowRpt1['ID']; ?>
								</span>
								<span style="display:inline-block; width:18%; vertical-align:text-top;">
									<?php echo $rowRpt1['DateOpened']; ?>
								</span>
								<span style="display:inline-block; width:18%; vertical-align:text-top;">
									<?php echo $rowRpt1['lastUpdate']; ?>
								</span>
								<span style="display:inline-block; width:38%; vertical-align:text-top;">
									<?php
									while($rowCallDetail1 = mysql_fetch_assoc($resCallDetail1)) {
										if(!is_null($rowCallDetail1['callType'])) {
											$callID = $rowCallDetail1['callid'];
											$callBegin = $rowCallDetail1['Date'];
											continue;
										} elseif(is_null($rowCallDetail1['callType']) && $rowCallDetail1['callid'] == $callID) {
											$callEnd = $rowCallDetail1['Date'];
											echo "Call ID: " . $rowCallDetail1['callid'] . " | " . dateDiff($callBegin, $callEnd) . " | " . "Agent: " . $rowCallDetail1['fName'] . " " . $rowCallDetail1['lName'] . "<br />";
										}
									}
									mysql_data_seek($resCallDetail1, 0);
									?>
								</span>
							</div>
							<?php
						}
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>