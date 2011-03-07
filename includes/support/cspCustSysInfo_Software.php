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
					<span style="display:inline-block; width:33%; vertical-align:top; float:left; text-align:right; padding:1px;">AMS Version:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; text-align:left; padding:1px;"><?php echo $rowSysInfo1['SystemAMSVersion']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:33%; vertical-align:top; float:left; text-align:right; padding:1px;">License:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; text-align:left; padding:1px;"><?php echo $licType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:33%; vertical-align:top; float:left; text-align:right; padding:1px;">User Licenses:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; text-align:left; padding:1px;"><?php echo $rowSysInfo1['clientLic']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:33%; vertical-align:top; float:left; text-align:right; padding:1px;">Database Type:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; text-align:left; padding:1px;"><?php echo $rowSysInfo1['dbType']; ?>&nbsp;</span>
				</div>
			</td>
		</tr>
	</table>
</div>