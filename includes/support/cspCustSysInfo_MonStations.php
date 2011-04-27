<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">
				<span style="float: left;">Monitoring Stations</span>
				<span style="float: right;">
					<a href="javascript:void(0);" onclick="getSysDetails('scripts/sysInfoMaint.php?getNewEquipForm=monStation&custID=<?php echo $custID; ?>', 'stationDetails', 'new');">
						<img src="theme/default/images/icons/add_file_icon.gif" height="14" width="14" border="0" title="Add Station" />
					</a>
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; line-height:28px; vertical-align:top; text-align:right; padding:1px;">Equipment:</span>
					<span style="display:inline-block; vertical-align:top; padding:1px 1px 1px 5px">
						<select name="monStation" onChange="getSysDetails('includes/support/sysInfoDetails.php', 'stationDetails', this.value);">
							<option value="-1">Select</option>
							<?php
							while($rowSysInfo2 = mysql_fetch_assoc($rstSysInfo2)) {
								if($rowSysInfo2['systemType'] != "pgTransmitter") {
									?>
									<option value="<?php echo $rowSysInfo2['id']; ?>"><?php echo $rowSysInfo2['SystemStationLocation'] . ' (' . $rowSysInfo2['systemType'] . ')'; ?></option>
									<?php
								}
							}
							if($numSysInfo2 > 0) {
								mysql_data_seek($rstSysInfo2, 0);
							}
							?>
						</select>
					</span>
				</div>
				<div id="stationDetails"></div>
			</td>
		</tr>
	</table>
</div>