<?php
switch ($rowSysInfo1['pagerType']) {
	case "HomeFree":
		$pagerType = "HomeFree";
		break;
	case "Commtech7900":
		$pagerType = "Commtech 7900";
		break;
	case "ApolloGold":
		$pagerType = "Apollo Gold";
		break;
	case "Genie":
		$pagerType = "Genie";
		break;
	default:
		$pagerType = "";
		break;
}
?>
<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Paging Details</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Pager Type:</span>
					<span id="pagerType<?php echo $custID; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('pagerType<?php echo $custID; ?>', 'pagerType', '<?php echo $custID; ?>', 'tblFacilities');" title="Double click to edit"><?php echo $pagerType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Frequency:</span>
					<span id="pagerFreq<?php echo $custID; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('pagerFreq<?php echo $custID; ?>', 'pagingFrequency', '<?php echo $custID; ?>', 'tblFacilities');" title="Double click to edit"><?php echo $rowSysInfo1['pagingFrequency']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">FCC (FRN):</span>
					<span id="fccFrn<?php echo $custID; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('fccFrn<?php echo $custID; ?>', 'FRN', '<?php echo $custID; ?>', 'tblFacilities');" title="Double click to edit"><?php echo $rowSysInfo1['FRN']; ?>&nbsp;</span>
				</div>
			</td>
		</tr>
	</table>
</div>