<?php
include_once('../config.inc.php');
include_once('../db_connect.inc.php');
include_once('../functions.inc.php');
$sysID = $_GET['sysID'];

if($sysID == -1) {
	die();
}

$qrySysDetails1 = "SELECT tblCustSystemInfo.*, tblVpnClients.* 
									FROM tblCustSystemInfo 
									LEFT JOIN tblVpnClients ON tblCustSystemInfo.VpnClientType = tblVpnClients.ID 
									WHERE tblCustSystemInfo.id = '$sysID'";
$rstSysDetails1 = mysql_query($qrySysDetails1);
$rowSysDetails1 = mysql_fetch_assoc($rstSysDetails1);

if (($rowSysDetails1['ConnectionType'] == 0) OR (is_null($rowSysDetails1['ConnectionType']))) { 
	$connType = "None";
} elseif ($rowSysDetails1['ConnectionType'] == 1) {
	$connType = "Modem - VNC";
} elseif ($rowSysDetails1['ConnectionType'] == 2) {
	$connType = "Internet - VNC";
} elseif ($rowSysDetails1['ConnectionType'] == 3) {
	$connType = "Internet - RDP";
} elseif ($rowSysDetails1['ConnectionType'] == 4) {
	$connType = "VPN - VNC";
} elseif ($rowSysDetails1['ConnectionType'] == 5) {
	$connType = "VPN - RDP";
} elseif ($rowSysDetails1['ConnectionType'] == 6) {
	$connType = "LogMeIn";
} elseif ($rowSysDetails1['ConnectionType'] == 7) {
	$connType = "Serial";
} elseif ($rowSysDetails1['ConnectionType'] == 8) {
	$connType = "Network";
} elseif ($rowSysDetails1['ConnectionType'] == 9) {
	$connType = "GoToMyPC";
} elseif ($rowSysDetails1['ConnectionType'] == 10) {
	$connType = "TeamViewer";
}

if($rowSysDetails1['systemType'] != "pgTransmitter") {
	$divID = "stationDetails";
	if($rowSysDetails1['Dedicated'] == -1) {
		$dedicated = "Yes";
	} else {
		$dedicated = "No";
	}
} else {
	$divID = "transmitterDetails";
}

if (($rowSysDetails1['VpnClientType'] == 0) OR (is_null($rowSysDetails1['VpnClientType']))) {
	$vpnType = "None";
} else { 
	$vpnType = $rowSysDetails1['ClientName'];
}
?>
<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="cspTicketHeading">Equipment Details</td>
	</tr>
	<tr>
		<td>
			<div style="clear:both;">
				<span style="display:block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Physical Location:</span>
				<span id="sysLoc<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysLoc<?php echo $rowSysDetails1['id']; ?>', 'SystemStationLocation', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['SystemStationLocation']; ?>&nbsp;</span>
			</div>
			<div style="clear:both;">
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Manufacturer:</span>
				<span id="sysMan<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysMan<?php echo $rowSysDetails1['id']; ?>', 'SystemManufacturer', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['SystemManufacturer']; ?>&nbsp;</span>
			</div>
			<div style="clear:both;">
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Model Number:</span>
				<span id="sysModNum<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysModNum<?php echo $rowSysDetails1['id']; ?>', 'SystemModelNumber', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['SystemModelNumber']; ?>&nbsp;</span>
			</div>
			<div style="clear:both;">
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Serial Number:</span>
				<span id="sysSerNum<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysSerNum<?php echo $rowSysDetails1['id']; ?>', 'SystemSerialNumber', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['SystemSerialNumber']; ?>&nbsp;</span>
			</div>
			<div style="clear:both;">
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">User Name:</span>
				<span id="sysUser<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysUser<?php echo $rowSysDetails1['id']; ?>', 'SystemUserName', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['SystemUserName']; ?>&nbsp;</span>
			</div>
			<div style="clear:both;">
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Password:</span>
				<span id="sysPass<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysPass<?php echo $rowSysDetails1['id']; ?>', 'SystemPassword', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['SystemPassword']; ?>&nbsp;</span>
			</div>
			<div style="clear:both;">
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">LAN IP Address:</span>
				<span id="sysIpAdd<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysIpAdd<?php echo $rowSysDetails1['id']; ?>', 'SystemIPAddress', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['SystemIPAddress']; ?>&nbsp;</span>
			</div>
			<?php
			if($rowSysDetails1['systemType'] != "pgTransmitter") {
				?>
				<div style="line-height: 16px; clear:both;">
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Operating System:</span>
					<span id="sysOS<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysOS<?php echo $rowSysDetails1['id']; ?>', 'OperatingSystem', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['OperatingSystem']; ?>&nbsp;</span>
				</div>
				<div style="clear:both;">
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">OS License Key:</span>
					<span id="sysOSLic<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysOSLic<?php echo $rowSysDetails1['id']; ?>', 'OperatingSystemLicense', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['OperatingSystemLicense']; ?>&nbsp;</span>
				</div>
				<div style="clear:both;">
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Notes:</span>
					<span id="otherInfo<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('otherInfo<?php echo $rowSysDetails1['id']; ?>', 'OtherInfo', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['OtherInfo']; ?>&nbsp;</span>
				</div>
				<?php
			} else {
				?>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Protocol:</span>
					<span id="sysProtocol<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysProtocol<?php echo $rowSysDetails1['id']; ?>', 'OtherInfo', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['OtherInfo']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Connection Type:</span>
					<span id="sysConnType<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysConnType<?php echo $rowSysDetails1['id']; ?>', 'ConnectionType', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $connType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Comm. Port:</span>
					<span id="sysComPort<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysComPort<?php echo $rowSysDetails1['id']; ?>', 'commPort', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['commPort']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">RAS Port:</span>
					<span id="sysRasPort<?php echo $rowSysDetails1['id']; ?>" style="display:block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysRasPort<?php echo $rowSysDetails1['id']; ?>', 'RasPort', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['RasPort']; ?>&nbsp;</span>
				</div>
				<?php
			}
			?>
		</td>
	</tr>
</table>
<?php
if($rowSysDetails1['systemType'] != "pgTransmitter") {
	?>
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspTicketHeading">Remote Access</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Connection Type:</span>
					<span id="sysConnType<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysConnType<?php echo $rowSysDetails1['id']; ?>', 'ConnectionType', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $connType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">Modem Number:</span>
					<span id="sysModemNum<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysModemNum<?php echo $rowSysDetails1['id']; ?>', 'SystemDialInNumber', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo formatPhone($rowSysDetails1['SystemDialInNumber']); ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">WAN IP/Host name:</span>
					<span id="sysWanInfo<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysWanInfo<?php echo $rowSysDetails1['id']; ?>', 'WanIPAddress', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['WanIPAddress']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">VPN Client:</span>
					<span id="sysVpnType<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysVpnType<?php echo $rowSysDetails1['id']; ?>', 'VpnClientType', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $vpnType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">VPN User:</span>
					<span id="sysVpnUser<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysVpnUser<?php echo $rowSysDetails1['id']; ?>', 'VpnUsername', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['VpnUsername']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">VPN Password:</span>
					<span id="sysVpnPass<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysVpnPass<?php echo $rowSysDetails1['id']; ?>', 'VpnPassword', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['VpnPassword']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">RAS User Name:</span>
					<span id="sysRasUser<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysRasUser<?php echo $rowSysDetails1['id']; ?>', 'RasUsername', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['RasUsername']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">RAS Password:</span>
					<span id="sysRasPass<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysRasPass<?php echo $rowSysDetails1['id']; ?>', 'RASPassword', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['RASPassword']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">RAS Port:</span>
					<span id="sysRasPort<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;" onDblClick="modSysInfo('sysRasPort<?php echo $rowSysDetails1['id']; ?>', 'RasPort', '<?php echo $rowSysDetails1['id']; ?>', 'tblCustSystemInfo');" title="Double click to edit"><?php echo $rowSysDetails1['RasPort']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px; clear:both;">RAS Dedicated?:</span>
					<span id="sysRasDedicated<?php echo $rowSysDetails1['id']; ?>" style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $dedicated; ?>&nbsp;</span>
				</div>
			</td>
		</tr>
	</table>
	<?php
}
?>
<div style="text-align:center;">
	<a href="javascript:void(0)" onclick="getSysDetails('scripts/sysInfoMaint.php?maintAction=remove&equipID=<?php echo $sysID; ?>', '<?php echo $divID; ?>', 'remove');">[Remove]</a>
</div>