<?php
$qryRMAInfo2 = "SELECT * FROM deviceList";
$resRMAInfo2 = mysql_query($qryRMAInfo2);
$qryRMAInfo1 = "SELECT rmaDevices.*, deviceList.partDesc AS partName 
								FROM rmaDevices 
								LEFT JOIN deviceList ON rmaDevices.Device = `deviceList`.`part#` 
								WHERE rmaDevices.TicketID = '$ticketID'";
$resRMAInfo1 = mysql_query($qryRMAInfo1) or die(mysql_error());
$numRMAInfo1 = mysql_num_rows($resRMAInfo1);
?>
<div id="rmaInfo" class="cspDashModule" <?php if($numRMAInfo1 < 1) { echo 'style="display: none"'; }?>>
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">RMA Information</td>
		</tr>
		<tr>
			<td>
				<div id="divRmaDeviceLst">
					<div>
						<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Device</u></span>
						<span style="width:14%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Serial Number</u></span>
						<span style="width:24%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Warranty Status</u></span>
						<span style="width:40%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Issue Reported</u></span>
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
								$warranty = "NOT Warrantied - Purchase replacement";
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
							<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRMAInfo1['partName']; ?></span>
							<span style="width:14%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRMAInfo1['SN']; ?></span>
							<span style="width:24%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $warranty; ?></span>
							<span style="width:40%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRMAInfo1['Problem']; ?></span>
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
									<option value="2">No (Return for Repair)</option>
									<option value="3">No (Purchase replacement)</option>
									<option value="5">No (Return Only)</option>
								</select>
							</span>
							<span style="display:inline-block;">
			     			<input type="submit" value="Save" />
			     		</span>
						</form>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
</div>