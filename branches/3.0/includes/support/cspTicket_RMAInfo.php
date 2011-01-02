<?php
$qryRMAInfo1 = "SELECT * FROM deviceList";
$resRMAInfo1 = mysql_query($qryRMAInfo1);
?>
<div id="rmaInfo" class="cspDashModule" <?php if($rowTicketDetail1['rmaReturn'] != 1) { echo 'style="display: none"'; }?>>
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">RMA Information</td>
		</tr>
		<tr>
			<td>
				<div id="divRmaForm">
					<form id="rmaForm">
							<span style="display:inline-block;">Device:<br />
								<select name="deviceType">
								<?php
								while($rowRMAInfo1 = mysql_fetch_assoc($resRMAInfo1)) {
								?>
									<option value="<?php echo $rowRMAInfo1['part#']; ?>"><?php echo $rowRMAInfo1['partDesc']; ?></option>
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
							<span style="display:inline-block;>
								<input type="hidden" name="ticketNum" value="<?php echo $ticketID; ?>" />
			     			<input type="submit" name="sbmRmaDevice" value="Save" />
			     		</span>
			     	</div>
					</form>
				</div>
			</td>
		</tr>
	</table>
</div>