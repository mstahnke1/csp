<?php
$qryRMAInfo2 = "SELECT * FROM deviceList";
$resRMAInfo2 = mysql_query($qryRMAInfo2);
$qryRMAInfo1 = "SELECT rmaDevices.*, deviceList.partDesc AS partName 
								FROM rmaDevices 
								LEFT JOIN deviceList ON rmaDevices.Device = `deviceList`.`part#` 
								WHERE rmaDevices.TicketID = '$ticketID'";
$resRMAInfo1 = mysql_query($qryRMAInfo1) or die(mysql_error());
$numRMAInfo1 = mysql_num_rows($resRMAInfo1);
$qryRMAInfo3 = "SELECT * FROM tblTicketMessages WHERE TicketID = '$ticketID' AND msgType = '11'";
$resRMAInfo3 = mysql_query($qryRMAInfo3) or die(mysql_error());
mysql_select_db($dbname2);
$qryRMAInfo4 = "SELECT * FROM taskinfo WHERE ticketNum = '$ticketID' AND Response = '2000' AND Type = '28'";
$resRMAInfo4 = mysql_query($qryRMAInfo4);
$numRMAInfo4 = mysql_num_rows($resRMAInfo4);
$rowRMAInfo4 = mysql_fetch_array($resRMAInfo4);
if($rowRMAInfo4['Status'] == 3) {
	$repairAuth = "Repair Authorized";
} else {
	$repairAuth = "Repair Not Authorized";
}
mysql_select_db($dbname);
?>
<div id="rmaInfo" class="cspDashModule"<?php if($numRMAInfo1 < 1) { echo ' style="display: none"'; }?>>
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">
				<span>RMA Information</span>
				<span id="rmaReturnAuth" style="font-variant:normal; FONT-WEIGHT: normal; float:right;<?php if($numRMAInfo1 < 1 && $Status != "Closed") { echo ' display:none;'; } ?>"><a href="javascript:void(0);" onclick="showDiv('divRmaReturnNotes');">[return verification]</a></span>
			</td>
		</tr>
		<tr>
			<td>
				<div id="divRmaDeviceLst">
					<div id="divRmaStatusInfo" class="rmaStatusInfo"<?php if($numRMAInfo1 < 1 && $Status != "Closed") { echo ' style="display:none;"'; } ?>>
						<div>
							<span><strong>Authorization:</strong></span>
							<span><?php echo $repairAuth; ?></span>
						</div>
						<?php
						while($rowRMAInfo3 = mysql_fetch_assoc($resRMAInfo3)) {
							?>
							<div>
								<span><strong>Return Notes:</strong></span>
								<span><?php echo $rowRMAInfo3['Message']; ?></span>
							</div>
							<?php
						}
						?>
						<div id="divRmaReturnNotes" style="display: none;">
							<form name="rmaReturnFrm" id="rmaReturnFrm" action="scripts/ticketMgmt.php" method="get">
								<table width="100%">
									<tr>
										<td colspan="2">
											<font size="2" face="Arial">Use the notes section to put changes or notes to the return.</font>
				    				</td>
			     				</tr>
			     				<tr>
										<td valign="top" style="text-align:right;">
											<font size="2" face="Arial">Return Notes:</font>
				    				</td>
				    				<td>
				    					<textarea name="returnNote" rows="5" cols="50"></textarea>
				    				</td>
			     				</tr>
			     				<tr>
			     					<td colspan="2" align="center">
			     						<input type="hidden" name="ticketID" value="<?php echo $ticketID; ?>" />
			     						<input type="hidden" name="custID" value="<?php echo $custID; ?>" />
			     						<input type="submit" name="returnAuth" value="Verified" /><input type="submit" name="returnAuth" value="Modified" /><input type="button" value="Cancel" onClick="javascript:window.location.reload()">
			     					</td>
			     				</tr>
		     				</table>
	     				</form>
						</div>
					</div>
					<div>
						<?php
						if($Status != "Closed" && $Status != "Canceled") {
							?>
							<span style="width:3%; display:inline-block; vertical-align:top; padding:0px 1px 0px 0px;"></span>
							<?php
						}
						?>
						<span style="width:18%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>Device</u></span>
						<span style="width:14%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>Serial Number</u></span>
						<span style="width:20%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>Warranty Status</u></span>
						<span style="width:37%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>Issue Reported</u></span>
						<span style="width:4%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>CRP?</u></span>
					</div>
					<?php
					while($rowRMAInfo1 = mysql_fetch_assoc($resRMAInfo1)) {
						switch($rowRMAInfo1['Warranty']) {
							case 1:
								$warranty = "Warrantied - Repair";
								break;
							case 2:
								$warranty = "NOT Warrantied - Repair";
								break;
							case 3:
								$warranty = "NOT Warrantied - Replacement";
								break;
							case 4:
								$warranty = "Warrantied - <b>Return Only</b>";
								break;
							case 5:
								$warranty = "NOT Warrantied - <b>Return Only</b>";
								break;
						}
						?>
						<div class="cspMOHighlight">
							<?php
							if($Status != "Closed" && $Status != "Canceled") {
								?>
								<span style="width:3%; display:inline-block; vertical-align:top; padding:0px 1px 0px 0px;">
									<form name="updDevice<?php echo $rowRMAInfo1['ID']; ?>">
									 <input type="checkbox" name="device" onChange="updRmaDevice('<?php echo $rowRMAInfo1['ID']; ?>', '<?php echo $ticketID; ?>');" />
									</form>
								</span>
								<?php
							}
							?>
							<span style="width:18%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px;"><?php echo $rowRMAInfo1['partName']; ?></span>
							<span style="width:14%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px;"><?php echo $rowRMAInfo1['SN']; ?></span>
							<span style="width:20%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px;"><?php echo $warranty; ?></span>
							<span style="width:37%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px;"><?php echo $rowRMAInfo1['Problem']; ?></span>
							<span style="width:4%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px; margin-top: 5px;"><?php if ($rowRMAInfo1['CRP'] == 1) { echo '<img src="theme/default/images/check3.gif" width="10" height="10" />'; } ?></span>
						</div>
						<?php
					}
					?>
				</div>
				<?php
				if($Status != "Closed" && $Status != "Canceled") {
					?>
					<div id="divRmaForm" style="padding-top: 5px;">
						<form id="rmaForm" name="rmaForm" onSubmit="sbmRmaDevice('rmaForm', '<?php echo $ticketID; ?>', 'add'); return false;">
							<span style="display:inline-block;">Device:<br />
								<select name="deviceType">
								<?php
								while($rowRMAInfo2 = mysql_fetch_assoc($resRMAInfo2)) {
								?>
									<option value="<?php echo $rowRMAInfo2['part#']; ?>"><?php echo $rowRMAInfo2['partDesc']; ?></option>
								<?php
								}
								?>
								</select>
							</span>
							<span style="display:inline-block;">Serial #:<br /><input name="serialNumber" size="10" type="text" /></span>
							<span style="display:inline-block;">Reported Issue:<br /><input name="problemDesc" size="25" type="text" /></span>
							<span style="display:inline-block;">Warranty Status:<br />
								<select name="warrantyStatus">
									<option value="0"> --- </option>
									<option value="1">Yes</option>
									<option value="4">Yes (Return Only)</option>
									<option value="2">No (Repair)</option>
									<option value="3">No (Replacement)</option>
									<option value="5">No (Return Only)</option>
								</select>
							</span>
							<span style="display:inline-block;">*CRP?:<br /><input name="chkCRP" type="checkbox" /></span>
						</div>
						<div>
							<span style="display:inline-block;">
			     			<input type="submit" value="Save" />
			     		</span>
			     	</div>
			     	<div>
			     		<span style="display:inline-block; FONT-SIZE: 10px; FONT-WEIGHT:bold; FONT-STYLE: italic; TEXT-DECORATION: none;">* CRP is a customer replaceable part. Replacement part will be sent for customer repair instead of returned for repair.</span>
						</form>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
</div>