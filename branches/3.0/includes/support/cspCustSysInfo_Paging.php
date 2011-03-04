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
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Pager Type:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $pagerType; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Frequency:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysInfo1['pagingFrequency']; ?></span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">FCC (FRN):</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysInfo1['FRN']; ?></span>
				</div>
			</td>
		</tr>
	</table>
</div>