<?php
$qryCat1 = "SELECT * FROM issueCategories WHERE parentCode IS NULL";
$resCat1 = mysql_query($qryCat1);
$qryCat3 = "SELECT ID FROM tblTicketMessages WHERE EnteredBy = '$agentID' AND TicketID = '$ticketID' AND msgType = 2";
$rstCat3 = mysql_query($qryCat3);
$numCat3 = mysql_num_rows($rstCat3);
?>
<div class="cspDashModule" <?php if($numCat3 > 0) { echo 'style="display: block"'; } else { echo 'style="display: none"'; } ?>>
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Categorize Issue</td>
		</tr>
		<tr>
			<td>
				<div>
					<?php
					while($rowCat1 = mysql_fetch_assoc($resCat1)) {
						$qryCat2 = "SELECT COUNT(code) AS numSubCat FROM issueCategories WHERE parentCode = '$rowCat1[code]'";
						$resCat2 = mysql_query($qryCat2);
						$rowCat2 = mysql_fetch_assoc($resCat2);
						$numSubCat2 = $rowCat2['numSubCat'];
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
								?>
								<span>
									<a href="Javascript:void(0);" onclick="window.location='categoryListMgmt.php?catCode=<?php echo $rowCat1['code']; ?>&ticketID=<?php echo $ticketID; ?>'"><span><?php echo $rowCat1['description']; ?></span></a>
								</span>
								<?php
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