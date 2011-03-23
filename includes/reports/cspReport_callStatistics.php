<?php
include_once('../config.inc.php');
include_once('../db_connect.inc.php');
if(isset($_POST)) {
	$qryRpt1 = "SELECT tblTickets.*, COUNT(tblTickets.ID) AS callCount, tblFacilities.FacilityName AS facilityName 
							FROM tblTickets 
							LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
							LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber ";
	$qryRpt2 = "SELECT tblTickets.*, COUNT(tblTickets.ID) AS callCount, tblFacilities.FacilityName AS facilityName 
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
		$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
		$where[] = "tblTicketMessages.Date < '$dateTo' ";
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
	$numRpt1 = mysql_num_rows($resRpt1);
	while($rowRpt1 = mysql_fetch_assoc($resRpt1)) {
		$numTotalOffice = $numTotalOffice + $rowRpt1['callCount'];
	}
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
					$qryRpt3 = "SELECT tblTickets.*, COUNT(DISTINCT tblTickets.ID) AS issueCount, issueCategories.description AS catDesc, issueCategories.parentCode AS parentCode 
											FROM tblTickets 
											LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
											LEFT JOIN issueCategories ON tblTickets.categoryCode = issueCategories.code 
											WHERE tblTickets.CustomerNumber = '$rowRpt1[CustomerNumber]' AND tblTicketMessages.callType != 1 AND ";
					if(!empty($where)) {
					  $qryRpt3 .= implode(" AND ", $where);
					} else {
						$qryRpt3 = substr($qryRpt3, 0, -4);
					}
					$qryRpt3 .= "GROUP BY tblTickets.categoryCode ORDER BY issueCount DESC LIMIT 0,50";
					$resRpt3 = mysql_query($qryRpt3) or die(mysql_error());
					?>
					<tr>
						<td class="statData">
							<div id="callCount">
								<a id="link_<?php echo $rowRpt1['CustomerNumber']; ?>_OfficeHours" href="javascript:void(0);" onclick="showDiv('issueList<?php echo $rowRpt1['CustomerNumber']; ?>_OfficeHours', '<?php echo $rowRpt1['CustomerNumber']; ?>_OfficeHours');">
									<img id="img_<?php echo $rowRpt1['CustomerNumber']; ?>_OfficeHours" src="theme/default/images/iconExpand.png" border="0" />
								</a>
								<a href="javascript:void(0);" onclick="buildRpt('cspRprtParams', 'cspReport_callDetailed.php', 'custID', '<?php echo $rowRpt1['CustomerNumber']; ?>');">
									<?php echo $rowRpt1['facilityName'] . " <i>(" . $rowRpt1['callCount'] . ")</i>"; ?>
								</a>
							</div>
							<div id="issueList<?php echo $rowRpt1['CustomerNumber']; ?>_OfficeHours" style="margin-left:12px; display:none;">
								<?php
								while($rowRpt3 = mysql_fetch_assoc($resRpt3)) {
									$catDesc = $rowRpt3['catDesc'];
									$catCode = $rowRpt3['parentCode'];
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
									?>
									<a href="javascript:void(0);" onclick="buildRpt('cspRprtParams', 'cspReport_callStatistics.php', 'issueCat', '<?php echo $rowRpt3['categoryCode']; ?>');">
										<div style="text-indent:-7px; padding-left:7px;">&bull; <?php echo $catDesc . " (" . $rowRpt3['issueCount'] . ")"; ?></div>
									</a>
									<?php
								}
								?>
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
						<?php
						if($numTotalOnCall > 0) {
							?>
							<a href="javascript:void(0);" onclick="buildRpt('cspRprtParams', 'cspReport_callDetailed.php', 'callType', '1');">
								<?php echo $numTotalOnCall; ?> Total Calls
							</a>
							<?php
						} else {
							echo $numTotalOnCall; ?> Total Calls
							<?php
						}
						?>
					</td>
				</tr>
				<?php
				while($rowRpt2 = mysql_fetch_assoc($resRpt2)) {
					$qryRpt3 = "SELECT tblTickets.*, COUNT(DISTINCT tblTickets.ID) AS issueCount, issueCategories.description AS catDesc, issueCategories.parentCode AS parentCode 
											FROM tblTickets 
											LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
											LEFT JOIN issueCategories ON tblTickets.categoryCode = issueCategories.code 
											WHERE tblTickets.CustomerNumber = '$rowRpt2[CustomerNumber]' AND tblTicketMessages.callType = 1 AND ";
					if(!empty($where)) {
					  $qryRpt3 .= implode(" AND ", $where);
					} else {
						$qryRpt3 = substr($qryRpt3, 0, -4);
					}
					$qryRpt3 .= "GROUP BY tblTickets.categoryCode ORDER BY issueCount DESC LIMIT 0,50";
					$resRpt3 = mysql_query($qryRpt3) or die(mysql_error());
					?>
					<tr>
						<td class="statData">
							<div id="callCount">
								<a id="link_<?php echo $rowRpt2['CustomerNumber']; ?>_AfterHours" href="javascript:void(0);" onclick="showDiv('issueList<?php echo $rowRpt2['CustomerNumber']; ?>_AfterHours', '<?php echo $rowRpt2['CustomerNumber']; ?>_AfterHours');">
									<img id="img_<?php echo $rowRpt2['CustomerNumber']; ?>_AfterHours" src="theme/default/images/iconExpand.png" border="0" />
								</a>
								<a href="javascript:void(0);" onclick="buildRpt('cspRprtParams', 'cspReport_callDetailed.php', 'custID', '<?php echo $rowRpt2['CustomerNumber']; ?>');">
									<?php echo $rowRpt2['facilityName'] . " <i>(" . $rowRpt2['callCount'] . ")</i>"; ?>
								</a>
							</div>
							<div id="issueList<?php echo $rowRpt2['CustomerNumber']; ?>_AfterHours" style="margin-left:12px; display:none;">
								<?php
								while($rowRpt3 = mysql_fetch_assoc($resRpt3)) {
									$catDesc = $rowRpt3['catDesc'];
									$catCode = $rowRpt3['parentCode'];
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
									?>
									<a href="javascript:void(0);" onclick="buildRpt('cspRprtParams', 'cspReport_callStatistics.php', 'issueCat', '<?php echo $rowRpt3['categoryCode']; ?>');">
										<div style="text-indent:-7px; padding-left:7px;">&bull; <?php echo $catDesc . " (" . $rowRpt3['issueCount'] . ")"; ?></div>
									</a>
									<?php
								}
								?>
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