<?php
include_once('../includes/config.inc.php');
include_once('../includes/db_connect.inc.php');

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
	} else {
		?>
		<input type="text" id="<?php echo $dbField; ?>" value="<?php echo $rowUpdSysInfo3['dbFieldVal']; ?>" onBlur="updSysInfo('<?php echo $eleID; ?>', '<?php echo $dbField; ?>', '<?php echo $recID; ?>', '<?php echo $dbTable; ?>');" />
		<?php
	}
}
?>