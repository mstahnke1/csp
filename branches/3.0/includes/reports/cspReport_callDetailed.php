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
	  	$qryRpt1 .= "WHERE tblTicketMessages.msgType = 2 AND ";
//	  	break;
//	  } else {
//	  	$qryRpt1 .= "WHERE tblTicketMessages.callType != 1 ";
//	  	$qryRpt2 .= "WHERE tblTicketMessages.callType = 1 ";
//	  	break;
//	  }
//	}
	
	$where = array();
	$where2 = array();
	
	$dateFrom = $_POST['dateFrom'];
	if($dateFrom != "") {
		$where[] = "tblTicketMessages.Date >= '$dateFrom' ";
		$where2[] = "tblTicketMessages.Date >= '$dateFrom' ";
	}
	
	$dateTo = $_POST['dateTo'];
	if($dateTo != "") {
		$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
		$where[] = "tblTicketMessages.Date < '$dateTo' ";
		$where2[] = "tblTicketMessages.Date < '$dateTo' ";
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
	  $where2[] = "tblTicketMessages.EnteredBy = '$hfEmployee' ";
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
	  $where2[] = "tblTicketMessages.callType = '$callType' ";
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
	if($custID != "") {
		$rptLabel = $rowRpt1['facilityName'];
	} else {
		$rptLabel = "Call Detail";
	}
	mysql_data_seek($resRpt1, 0);
	
	$urlQryStrg = "dateFrom=" . $dateFrom . "&dateTo=" . $dateTo . "&custID=" . $custID . "&incRMA=" . $incRMA . 
								"&hfEmployee=" . $hfEmployee . "&ticketStatus=" . $ticketStatus . "&callType=" . $callType . "&issueCat=" . $issueCat;
}
?>
<table border="0" width="100%" cellspacing="1" cellpadding="0">
	<tr>
		<td class="cspTicketHeading" colspan="2">
			<span style="float: left;">Ticket Report - <?php echo $rptLabel; ?></span>
			<span style="float: right;">
				<a href="javascript:void(0);" onclick="window.open('includes/reports/cspReport_callDataExport.php?<?php echo $urlQryStrg; ?>','_self','')">
					<img src="theme/default/images/icons/XLSX.png" height="15" width="15" border="0" /> 
				</a>
			</span>
		</td>
	</tr>
		<td width="100%" align="center" valign="top" style="text-align: left;">
			<table class="ticketStats" border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td class="statHeading">
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
							<span style="display:inline-block; width:20%;">
								<u>Facility</u>
							</span>
							<span style="display:inline-block; width:35%;">
								<u>Call Details</u>
							</span>
						</div>
						<?php
						while($rowRpt1 = mysql_fetch_assoc($resRpt1)) {
							/*
							if($rowRpt1['Status']==0) {
								$Status = "Open";
							} elseif($rowRpt1['Status']==1) {
								$Status = "Canceled";
							}elseif($rowRpt1['Status']==2) {
								$Status = "Escalated";
							}else{
								$Status = "Closed";
							}
							*/
							$qryCallDetail1 = "SELECT tblTicketMessages.*, employees.f_name AS fName, employees.l_name AS lName 
																FROM tblTicketMessages 
																LEFT JOIN employees ON tblTicketMessages.EnteredBy = employees.id 
																WHERE tblTicketMessages.ticketID = '$rowRpt1[ID]' AND tblTicketMessages.msgType = 2 AND ";
							if(!empty($where2)) {
							  $qryCallDetail1 .= implode(" AND ", $where2);
							} else {
								$qryCallDetail1 = substr($qryCallDetail1, 0, -4);
							}
							$resCallDetail1 = mysql_query($qryCallDetail1) or die(mysql_error());
							?>
							<div style="clear:both;" class="cspMOHighlight">
								<span style="display:inline-block; width:7%; vertical-align:text-top;">
									<a href="cspUserSupport_TicketDetail.php?ticketID=<?php echo $rowRpt1['ID']; ?>" target="_blank">
										<?php echo $rowRpt1['ID']; ?>
									</a>
								</span>
								<span style="display:inline-block; width:18%; vertical-align:text-top;">
									<?php echo $rowRpt1['DateOpened']; ?>
								</span>
								<span style="display:inline-block; width:18%; vertical-align:text-top;">
									<?php echo $rowRpt1['lastUpdate']; ?>
								</span>
								<span style="display:inline-block; width:20%; vertical-align:text-top;">
									<?php echo $rowRpt1['facilityName']; ?>
								</span>
								<span style="display:inline-block; width:35%; vertical-align:text-top;">
									<?php
									while($rowCallDetail1 = mysql_fetch_assoc($resCallDetail1)) {
										$callID = $rowCallDetail1['callid'];
										$callType = $rowCallDetail1['callType'];
										$callBegin = $rowCallDetail1['Date'];
										switch ($callType) {
											case 0:
												$callTypeDesc = "Office Hours Call Center";
												break;
											case 1:
												$callTypeDesc = "After Hours Call Center";
												break;
											case 2:
												$callTypeDesc = "Site Visit/Service Call";
												break;
											case 3:
												$callTypeDesc = "Proactive Call";
												break;
											case 4:
												$callTypeDesc = "Site Visit/Training";
												break;
										}
										$qryCallDetail2 = "SELECT Date 
																			FROM tblTicketMessages 
																			WHERE callid = '$callID' AND msgType = 3";
										$resCallDetail2 = mysql_query($qryCallDetail2) or die(mysql_error());
										$numCallDetail2 = mysql_num_rows($resCallDetail2);
										$rowCallDetail2 = mysql_fetch_assoc($resCallDetail2);
										if($numCallDetail2 > 0) {
											$callEnd = $rowCallDetail2['Date'];
											echo "<div>Call ID: " . $callID . " | " . "Agent: " . $rowCallDetail1['fName'] . " " . $rowCallDetail1['lName'] . " | " . dateDiff($callBegin, $callEnd) . " " . $callTypeDesc . "</div>";
										} else {
											echo "<div>Call ID: " . $callID . " | " . "Agent: " . $rowCallDetail1['fName'] . " " . $rowCallDetail1['lName'] . "</div>";
										}
									}
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