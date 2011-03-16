<?php
$qryCat1 = "SELECT * FROM issueCategories WHERE parentCode IS NULL";
$resCat1 = mysql_query($qryCat1);
if(isset($ticketID)) {
	$qryCat3 = "SELECT ID FROM tblTicketMessages WHERE EnteredBy = '$agentID' AND TicketID = '$ticketID' AND msgType = 2";
	$rstCat3 = mysql_query($qryCat3);
	$numCat3 = mysql_num_rows($rstCat3);
	$qryCat4 = "SELECT ID FROM tblTicketMessages WHERE EnteredBy = '$agentID' AND TicketID = '$ticketID' AND msgType = 7";
	$rstCat4 = mysql_query($qryCat4);
	$numCat4 = mysql_num_rows($rstCat4);
} else {
	$ticketID = -1;
	$numCat3 = 0;
	$numCat4 = 0;
}
?>
<div id="issueCatMod" class="cspDashModule" <?php if($numCat3 > 0 && $numCat4 < 1) { echo 'style="display: block"'; } else { echo 'style="display: none"'; } ?>>
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Issue Categories</td>
		</tr>
		<tr>
			<td>
				<div>
					<?php
					while($rowCat1 = mysql_fetch_assoc($resCat1)) {
						$qryCat2 = "SELECT code FROM issueCategories WHERE parentCode = '$rowCat1[code]'";
						$resCat2 = mysql_query($qryCat2);
						//$rowCat2 = mysql_fetch_assoc($resCat2);
						$numSubCat2 = mysql_num_rows($resCat2);
						?>
						<div id="<?php echo "div" . $rowCat1['code']; ?>">
							<?php
							if($numSubCat2 > 0) {
								?>
								<span>
									<a id="<?php echo "link".$rowCat1['code']; ?>" href="Javascript:void(0);" onclick="getChildCatList('<?php echo $rowCat1['code']; ?>', 'expand', '<?php echo $ticketID; ?>');"><img id="<?php echo "img" . $rowCat1['code']; ?>" src="theme/default/images/iconExpand.png" border="0" /></a>
								</span>
								<span><?php echo $rowCat1['description']; ?></span>
								<?php
							} else {
								if($ticketID <> -1) {
									?>
									<span><a href="Javascript:void(0);" class="leftArrow" onclick="window.location='scripts/categoryListMgmt.php?catCode=<?php echo $rowGetCatList1['code']; ?>&ticketID=<?php echo $ticketID; ?>&catAction=saveCat'"><span style="padding-left:12px"><?php echo $rowGetCatList1['description']; ?></span></span></a>
									<?php
								} else {
									?>
									<a href="Javascript:void(0);" class="leftArrow" onclick="javascript:populateTxt('cspRprtParams', 'issueCat', '<?php echo $rowGetCatList1['code']; ?>')"><span style="padding-left:12px" ><?php echo $rowGetCatList1['description']; ?></span></a>
									<?php
								}
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
			</td>
		</tr>
	</table>
</div>