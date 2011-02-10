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
					<span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">AMS Version:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowSysInfo1['SystemAMSVersion']; ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">License:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $licType; ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">User Licenses:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowSysInfo1['clientLic']; ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Database Type:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowSysInfo1['dbType']; ?></span>
				</div>
			</td>
		</tr>
	</table>
</div>