<?php
switch ($rowSysInfo1['SystemType']) {
	case 0:
		$licType = "Elite";
		break;
	case 1:
		$licType = "On-Site";
		break;
	case 2:
		$licType = "On-Call";
		break;
	case 3:
		$licType = "On-Time";
		break;
	case 4:
		$licType = "On-Touch";
		break;
}
?>
<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Software Details</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:33%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">AMS Version:</span>
					<span id="amsVer<?php echo $custID; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; text-align:left; padding:1px;" onDblClick="modSysInfo('amsVer<?php echo $custID; ?>', 'SystemAMSVersion', '<?php echo $custID; ?>', 'tblFacilities');" title="Double click to edit"><?php echo $rowSysInfo1['SystemAMSVersion']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:33%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">License Type:</span>
					<span id="amsLicType<?php echo $custID; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; text-align:left; padding:1px;" onDblClick="modSysInfo('amsLicType<?php echo $custID; ?>', 'SystemType', '<?php echo $custID; ?>', 'tblFacilities');" title="Double click to edit"><?php echo $licType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:33%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">User Licenses:</span>
					<span id="amsLicUsers<?php echo $custID; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; text-align:left; padding:1px;" onDblClick="modSysInfo('amsLicUsers<?php echo $custID; ?>', 'clientLic', '<?php echo $custID; ?>', 'tblFacilities');" title="Double click to edit"><?php echo $rowSysInfo1['clientLic']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:33%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Database Type:</span>
					<span id="amsDbType<?php echo $custID; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; text-align:left; padding:1px;" onDblClick="modSysInfo('amsDbType<?php echo $custID; ?>', 'dbType', '<?php echo $custID; ?>', 'tblFacilities');" title="Double click to edit"><?php echo $rowSysInfo1['dbType']; ?>&nbsp;</span>
				</div>
			</td>
		</tr>
	</table>
</div>