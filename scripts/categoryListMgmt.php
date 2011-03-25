<?php
if(isset($_GET['catCode']) && $_GET['catAction'] == "expand") {
	include('../includes/config.inc.php');
	include('../includes/db_connect.inc.php');
	$catCode = $_GET['catCode'];
	$ticketID = $_GET['ticketID'];
	$qryGetCatList1 = "SELECT * FROM issueCategories WHERE parentCode = '$catCode'";
	$resGetCatList1 = mysql_query($qryGetCatList1);

	while($rowGetCatList1 = mysql_fetch_assoc($resGetCatList1)) {
		$qrySubCatList = "SELECT code FROM issueCategories WHERE parentCode = '$rowGetCatList1[code]'";
		$resSubCatList = mysql_query($qrySubCatList);
		$rowSubCatList = mysql_fetch_assoc($resSubCatList);
		$numSubCatList = mysql_num_rows($resSubCatList);
		?>
		<div id="<?php echo "div" . $rowGetCatList1['code']; ?>" style="padding-left: 10px;">
			<?php
			if($numSubCatList > 0) {
				?>
				<span>
					<a id="<?php echo "link".$rowGetCatList1['code']; ?>" href="Javascript:void(0);" onclick="getChildCatList('<?php echo $rowGetCatList1['code']; ?>', 'expand', '<?php echo $ticketID; ?>');"><img id="<?php echo "img" . $rowGetCatList1['code']; ?>" src="theme/default/images/iconExpand.png" border="0" /></a>
				</span>
				<span><?php echo $rowGetCatList1['description']; ?></span>
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
	include('../includes/db_close.inc.php');
} elseif(isset($_GET['catCode']) && $_GET['catAction'] == "contract") {
	include('../includes/config.inc.php');
	include('../includes/db_connect.inc.php');
	$catCode = $_GET['catCode'];
	$ticketID = $_GET['ticketID'];
	$qryGetCatList1 = "SELECT * FROM issueCategories WHERE code = '$catCode'";
	$resGetCatList1 = mysql_query($qryGetCatList1);
	$rowGetCatList1 = mysql_fetch_assoc($resGetCatList1);
	?>
	<div id="<?php echo "div" . $rowGetCatList1['code']; ?>">
		<span>
			<a id="<?php echo "link".$rowGetCatList1['code']; ?>" href="Javascript:void(0);" onclick="getChildCatList('<?php echo $rowGetCatList1['code']; ?>', 'expand', '<?php echo $ticketID; ?>');"><img id="<?php echo "img" . $rowGetCatList1['code']; ?>" src="theme/default/images/iconExpand.png" border="0" /></a>
		</span>
		<span><?php echo $rowGetCatList1['description']; ?></span>
	</div>
	<?php
	include('../includes/db_close.inc.php');
} elseif(isset($_GET['catCode']) && $_GET['catAction'] == "saveCat") {
	include('../includes/config.inc.php');
	include('../includes/db_connect.inc.php');
	require_once('../includes/cspSessionMgmt.php');
	$catCode = $_GET['catCode'];
	$ticketID = $_GET['ticketID'];
	$agent = $_SESSION['uid'];
	$date = date('Y-m-d H:i:s');
	$message = "Issue category updated to " . $catCode;
	$qryCatUpdate1 = "UPDATE tblTickets SET categoryCode = '$catCode' WHERE ID = $ticketID LIMIT 1";
	$resCatUpdate1 = mysql_query($qryCatUpdate1);
	if($resCatUpdate1) {
		$qryCatUpdate2 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
											VALUES ('$ticketID', '$message', '$agent', '$date', 7)";
		$resCatUpdate2 = mysql_query($qryCatUpdate2);
		if($resCatUpdate2) {
			include('../includes/db_close.inc.php');
			die(header("Location: ../cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}
		
?>