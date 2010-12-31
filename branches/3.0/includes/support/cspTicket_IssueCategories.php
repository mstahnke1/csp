<?php
$qryCat1 = "SELECT * FROM issueCategories WHERE parentCode IS NULL";
$resCat1 = mysql_query($qryCat1);
?>
<div class="cspDashModule">
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
									<a id="<?php echo "link".$rowCat1['code']; ?>" href="Javascript:void(0);" onclick="conExpImg('<?php echo $rowCat1['code']; ?>', 'expand');getChildCatList('<?php echo $rowCat1['code']; ?>');"><img id="<?php echo "img" . $rowCat1['code']; ?>" src="theme/default/images/iconExpand.png" border="0" title="Expand" /></a>
								</span>
								<span><?php echo $rowCat1['description']; ?></span>
								<?php
							} else {
								?>
								<span>
									<a href="#"><span><?php echo $rowCat1['description']; ?></span></a>
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