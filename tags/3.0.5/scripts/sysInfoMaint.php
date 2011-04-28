<?php
include_once('../includes/config.inc.php');
include_once('../includes/db_connect.inc.php');
if(isset($_GET['custID'])) {
	$custID = $_GET['custID'];
}

if(isset($_GET['saveFieldVal'])) {
	$dbField = $_GET['dbField'];
	$dbVal = nl2br($_GET['dbVal']);
	$recID = $_GET['recID'];
	$dbTable = $_GET['dbTable'];
	if($dbTable == "tblCustSystemInfo") {
		$filterField = 'id';
	} else if($dbTable == "tblFacilities") {
		$filterField = 'CustomerNumber';
	}
	
	$qryUpdSysInfo1 = "UPDATE $dbTable SET $dbField = '$dbVal' WHERE $filterField = $recID LIMIT 1";
	mysql_query($qryUpdSysInfo1) or die(mysql_error());
	
	$qryUpdSysInfo2 = "SELECT $dbField AS dbField FROM $dbTable WHERE $filterField = $recID";
	$resUpdSysInfo2 = mysql_query($qryUpdSysInfo2) or die(mysql_error());
	$rowUpdSysInfo2 = mysql_fetch_assoc($resUpdSysInfo2);
	if($dbField == 'ConnectionType') {
		if(($rowUpdSysInfo2['dbField'] == 0) OR (is_null($rowUpdSysInfo2['dbField']))) { 
			$dbFieldVal = "None";
		} else if($rowUpdSysInfo2['dbField'] == 1) {
			$dbFieldVal = "Modem - VNC";
		} else if($rowUpdSysInfo2['dbField'] == 2) {
			$dbFieldVal = "Internet - VNC";
		} else if($rowUpdSysInfo2['dbField'] == 3) {
			$dbFieldVal = "Internet - RDP";
		} else if($rowUpdSysInfo2['dbField'] == 4) {
			$dbFieldVal = "VPN - VNC";
		} else if($rowUpdSysInfo2['dbField'] == 5) {
			$dbFieldVal = "VPN - RDP";
		} else if($rowUpdSysInfo2['dbField'] == 6) {
			$dbFieldVal = "LogMeIn";
		} else if($rowUpdSysInfo2['dbField'] == 7) {
			$dbFieldVal = "Serial";
		} else if($rowUpdSysInfo2['dbField'] == 8) {
			$dbFieldVal = "Network";
		} else if($rowUpdSysInfo2['dbField'] == 9) {
			$dbFieldVal = "GoToMyPC";
		} else if($rowUpdSysInfo2['dbField'] == 10) {
			$dbFieldVal = "TeamViewer";
		}
	} else if($dbField == 'VpnClientType') {
		if (($rowUpdSysInfo2['dbField'] == 0) OR (is_null($rowUpdSysInfo2['dbField']))) {
			$dbFieldVal = "None";
		} else { 
			$qryUpdSysInfo4 = "SELECT ClientName FROM tblVpnClients WHERE ID = '$dbVal'";
			$resUpdSysInfo4 = mysql_query($qryUpdSysInfo4) or die(mysql_error());
			$rowUpdSysInfo4 = mysql_fetch_assoc($resUpdSysInfo4);
			$dbFieldVal = $rowUpdSysInfo4['ClientName'];
		}
	} else if($dbField == 'pagerType') {
		switch ($rowUpdSysInfo2['dbField']) {
			case "HomeFree":
				$dbFieldVal = "HomeFree";
				break;
			case "Commtech7900":
				$dbFieldVal = "Commtech 7900";
				break;
			case "ApolloGold":
				$dbFieldVal = "Apollo Gold";
				break;
			case "Genie":
				$dbFieldVal = "Genie";
				break;
			default:
				$dbFieldVal = "";
				break;
		}
	} else if($dbField == 'SystemType') {
		switch ($rowUpdSysInfo2['dbField']) {
			case 0:
				$dbFieldVal = "Elite";
				break;
			case 1:
				$dbFieldVal = "On-Site";
				break;
			case 2:
				$dbFieldVal = "On-Call";
				break;
			case 3:
				$dbFieldVal = "On-Time";
				break;
			case 4:
				$dbFieldVal = "On-Touch";
				break;
		}
	} else {
		$dbFieldVal = $rowUpdSysInfo2['dbField'];
	}
	
	echo $dbFieldVal;
}

if(isset($_GET['getFieldVal'])) {
	$dbField = $_GET['dbField'];
	$recID = $_GET['recID'];
	$eleID = $_GET['eleID'];
	$dbTable = $_GET['dbTable'];
	
	if($dbTable == "tblCustSystemInfo") {
		$filterField = 'id';
	} else if($dbTable == "tblFacilities") {
		$filterField = 'CustomerNumber';
	}
	
	$qryUpdSysInfo3 = "SELECT $dbField AS dbFieldVal, systemType FROM $dbTable WHERE $filterField = $recID";
	$resUpdSysInfo3 = mysql_query($qryUpdSysInfo3) or die(mysql_error());
	$rowUpdSysInfo3 = mysql_fetch_assoc($resUpdSysInfo3);
	
	if($dbField == 'OtherInfo') {
		?>
		<textarea name="<?php echo $dbField; ?>" id="<?php echo $dbField; ?>" rows="6" cols="24" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');"><?php echo strip_tags($rowUpdSysInfo3['dbFieldVal']); ?></textarea>
		<?php
	} else if($dbField == 'ConnectionType' && $rowUpdSysInfo3['systemType'] != 'pgTransmitter') {
		?>
		<select name="<?php echo $dbField; ?>" id="<?php echo $dbField; ?>" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');">
			<option value="0" <?php if((is_null($rowUpdSysInfo3['dbFieldVal'])) OR ($rowUpdSysInfo3['dbFieldVal'] == 0)){ echo 'selected="selected"'; } ?>>None</option>
			<option value="1" <?php if($rowUpdSysInfo3['dbFieldVal'] == 1){ echo 'selected="selected"'; } ?>>Modem - VNC</option>
			<option value="2" <?php if($rowUpdSysInfo3['dbFieldVal'] == 2){ echo 'selected="selected"'; } ?>>Internet - VNC</option>
			<option value="3" <?php if($rowUpdSysInfo3['dbFieldVal'] == 3){ echo 'selected="selected"'; } ?>>Internet - RDP</option>
			<option value="4" <?php if($rowUpdSysInfo3['dbFieldVal'] == 4){ echo 'selected="selected"'; } ?>>VPN - VNC</option>
			<option value="5" <?php if($rowUpdSysInfo3['dbFieldVal'] == 5){ echo 'selected="selected"'; } ?>>VPN - RDP</option>
			<option value="6" <?php if($rowUpdSysInfo3['dbFieldVal'] == 6){ echo 'selected="selected"'; } ?>>LogMeIn</option>
			<option value="9" <?php if($rowUpdSysInfo3['dbFieldVal'] == 9){ echo 'selected="selected"'; } ?>>GoToMyPC</option>
			<option value="10" <?php if($rowUpdSysInfo3['dbFieldVal'] == 10){ echo 'selected="selected"'; } ?>>TeamViewer</option>
		</select>
		<?php
	} else if($dbField == 'ConnectionType' && $rowUpdSysInfo3['systemType'] == 'pgTransmitter') {
		?>
		<select name="<?php echo $dbField; ?>" id="<?php echo $dbField; ?>" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');">
			<option value="7" <?php if($rowUpdSysInfo3['dbFieldVal'] == 7){ echo 'selected="selected"'; } ?>>Serial</option>
			<option value="8" <?php if($rowUpdSysInfo3['dbFieldVal'] == 8){ echo 'selected="selected"'; } ?>>Network</option>
		</select>
		<?php
	} else if($dbField == 'VpnClientType') {
		$qryUpdSysInfo4 = "SELECT * FROM tblvpnclients";
		$resUpdSysInfo4 = mysql_query($qryUpdSysInfo4) or die (mysql_error());
		?>
		<select name="<?php echo $dbField; ?>" id="<?php echo $dbField; ?>" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');">
			<option value="0" <?php if((is_null($rowUpdSysInfo3['dbFieldVal'])) OR ($rowUpdSysInfo3['dbFieldVal'] == 0)){ echo 'selected="selected"'; } ?>>None</option>
			<?php
			while($rowUpdSysInfo4 = mysql_fetch_array($resUpdSysInfo4))
			{
			?>
				<option value="<?php echo $rowUpdSysInfo4['ID']; ?>" <?php if($rowUpdSysInfo4['ID'] == $rowUpdSysInfo3['dbFieldVal']){ echo 'selected="selected"'; } ?>><?php echo $rowUpdSysInfo4['ClientName']; ?></option>
			<?php
			}
			?>
		</select>
		<?php
	} else if($dbField == 'pagerType') {
		?>
		<select name="<?php echo $dbField; ?>" id="<?php echo $dbField; ?>" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');">
			<option value="HomeFree" <?php if($rowUpdSysInfo3['dbFieldVal'] == "HomeFree"){ echo 'selected="selected"'; } ?>>HomeFree</option>
			<option value="Commtech7900" <?php if($rowUpdSysInfo3['dbFieldVal'] == "Commtech7900"){ echo 'selected="selected"'; } ?>>Commtech 7900</option>
			<option value="ApolloGold" <?php if($rowUpdSysInfo3['dbFieldVal'] == "ApolloGold"){ echo 'selected="selected"'; } ?>>Apollo Gold</option>
			<option value="Genie" <?php if($rowUpdSysInfo3['dbFieldVal'] == "Genie"){ echo 'selected="selected"'; } ?>>Genie</option>
		</select>
		<?php
	} else if($dbField == 'SystemType') {
		?>
		<select name="<?php echo $dbField; ?>" id="<?php echo $dbField; ?>" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');">
			<option value="0" <?php if($rowUpdSysInfo3['dbFieldVal'] == 0){ echo 'selected="selected"'; } ?>>Elite</option>
			<option value="1" <?php if($rowUpdSysInfo3['dbFieldVal'] == 1){ echo 'selected="selected"'; } ?>>On-Site</option>
			<option value="2" <?php if($rowUpdSysInfo3['dbFieldVal'] == 2){ echo 'selected="selected"'; } ?>>On-Call</option>
			<option value="3" <?php if($rowUpdSysInfo3['dbFieldVal'] == 3){ echo 'selected="selected"'; } ?>>On-Time</option>
			<option value="4" <?php if($rowUpdSysInfo3['dbFieldVal'] == 4){ echo 'selected="selected"'; } ?>>On-Touch</option>
		</select>
		<?php
	} else if($dbField == 'dbType') {
		?>
		<select name="<?php echo $dbField; ?>" id="<?php echo $dbField; ?>" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');">
			<option value="MS Access" <?php if($rowUpdSysInfo3['dbFieldVal'] == "MS Access"){ echo 'selected="selected"'; } ?>>MS Access</option>
			<option value="Sybase" <?php if($rowUpdSysInfo3['dbFieldVal'] == "Sybase"){ echo 'selected="selected"'; } ?>>Sybase</option>
		</select>
		<?php
	} else {
		?>
		<input type="text" id="<?php echo $dbField; ?>" value="<?php echo $rowUpdSysInfo3['dbFieldVal']; ?>" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');" />
		<?php
	}
}

if(isset($_GET['getNewEquipForm'])) {
	?>
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Enter Equipment Details</td>
		</tr>
		<tr>
			<td>
				<form id="newEquipFrm" name="newEquipFrm">
					<div style="clear:both;">
						<span style="display:block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Physical Location:</span>
						<span style="display:block; width:62%; vertical-align:top; float:right; padding:1px;">
							<input type="text" name="equipLocation" id="equipLocation" />
						</span>
					</div>
					<?php
					if($_GET['getNewEquipForm'] == 'monStation') {
						?>
						<div style="clear:both;">
							<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Equipment Type:</span>
							<span style="display:block; width:62%; vertical-align:top; float:right; padding:1px;">
								<select name="equipType" id="equipType">
									<option value="Server">Server</option>
									<option value="Client">Client</option>
								</select>
							</span>
						</div>
						<?php
					}
					if($_GET['getNewEquipForm'] == 'pgTransmitter') {
					?>
						<div style="clear:both;">
							<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Equipment Type:</span>
							<span style="display:block; width:62%; vertical-align:top; float:right; padding:1px;">
								<select name="equipType" id="equipType">
									<option value="pgTransmitter">Paging Trasmitter</option>
								</select>
							</span>
						</div>
						<?php
					}
					?>
					<div style="text-align:right; clear:both;">
						<input type="button" value="Save" onClick="sbmEquip('newEquipFrm', '<?php echo $custID; ?>', 'new');" />
					</div>
				</form>
			</td>
		</tr>
	</table>
	<?php
}

if(isset($_GET['maintAction']) && $_GET['maintAction'] == 'new') {
	$equipLocation = $_GET['equipLocation'];
	$equipType = $_GET['equipType'];
	$qryEquipAdd = "INSERT INTO tblCustSystemInfo (CustomerNumber, SystemStationLocation, systemType) 
									VALUES ('$custID', '$equipLocation', '$equipType')";
	$resEquipAdd = mysql_query($qryEquipAdd) or die(mysql_error());
	if($equipType == 'Server' || $equipType == 'Client') {
		$divID = 'stationDetails';
	} else if($equipType == 'pgTransmitter') {
		$divID = 'transmitterDetails';
	}
	
	if($resEquipAdd) {
		$qryEquipAdd2 = "SELECT MAX(id) AS id FROM tblCustSystemInfo WHERE CustomerNumber = '$custID'";
		$resEquipAdd2 = mysql_query($qryEquipAdd2) or die(mysql_error());
		$rowEquipAdd2 = mysql_fetch_assoc($resEquipAdd2);
		$newRecID = $rowEquipAdd2['id'];
		?>
		Save successful, click <a href="javascript:void(0)" onclick="getSysDetails('includes/support/sysInfoDetails.php', '<?php echo $divID; ?>', '<?php echo $newRecID; ?>');"><strong>here</strong></a> to udpate record.
		<?php
	} else {
		echo "Save not successful";
	}
}

if(isset($_GET['maintAction']) && $_GET['maintAction'] == 'remove') {
	$equipID = $_GET['equipID'];
	$qryEquipRem1 = "DELETE FROM tblCustSystemInfo WHERE id = $equipID LIMIT 1";
	$resEquipRem1 = mysql_query($qryEquipRem1) or die(mysql_error());
	if($resEquipRem1) {
		echo "Successfully removed equipment. Refresh page to update.";
	} else {
		echo "Update failed.";
	}
}
?>