<?php
if(isset($_GET['catCode'])) {
	include('../includes/config.inc.php');
	include('../includes/db_connect.inc.php');
	$catCode = $_GET['catCode'];
	$qryGetCatList1 = "SELECT * FROM issueCategories WHERE parentCode = '$catCode'";
	$resGetCatList1 = mysql_query($qryGetCatList1);
}

while($rowGetCatList1 = mysql_fetch_assoc($resGetCatList1)) {
	$qrySubCatList = "SELECT COUNT(code) AS numSubCat FROM issueCategories WHERE parentCode = '$rowGetCatList1[code]'";
	$resSubCatList = mysql_query($qrySubCatList);
	$rowSubCatList = mysql_fetch_assoc($resSubCatList);
	$numSubCatList = $rowSubCatList['numSubCat'];
	?>
	<div id="<?php echo "div" . $rowGetCatList1['code']; ?>" style="margin-left: 10px;">
		<?php
		if($numSubCatList > 0) {
			?>
			<span>
				<a id="<?php echo "link".$rowGetCatList1['code']; ?>" href="Javascript:void(0);" onclick="conExpImg('<?php echo $rowGetCatList1['code']; ?>', 'expand');getChildCatList('<?php echo $rowGetCatList1['code']; ?>');"><img id="<?php echo "img" . $rowGetCatList1['code']; ?>" src="theme/default/images/iconExpand.png" border="0" title="Expand" /></a>
			</span>
			<span><?php echo $rowGetCatList1['description']; ?></span>
			<?php
		} else {
			?>
			<span style="margin-left: 12px">
				<a href="#"><span><?php echo $rowGetCatList1['description']; ?></span></a>
			</span>
			<?php
		}
		?>
	</div>
	<?php
}
?>