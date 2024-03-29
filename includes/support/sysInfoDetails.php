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
	if($rowSysDetails1['Dedicated'] == -1) {
		$dedicated = "Yes";
	} else {
		$dedicated = "No";
	}
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
			<div>
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Physical Location:</span>
				<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['SystemStationLocation']; ?>&nbsp;</span>
			</div>
			<div>
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Manufacturer:</span>
				<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['SystemManufacturer']; ?>&nbsp;</span>
			</div>
			<div>
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Model Number:</span>
				<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['SystemModelNumber']; ?>&nbsp;</span>
			</div>
			<div>
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Serial Number:</span>
				<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['SystemSerialNumber']; ?>&nbsp;</span>
			</div>
			<div>
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">User Name:</span>
				<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['SystemUserName']; ?>&nbsp;</span>
			</div>
			<div>
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Password:</span>
				<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['SystemPassword']; ?>&nbsp;</span>
			</div>
			<div>
				<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">LAN IP Address:</span>
				<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['SystemIPAddress']; ?>&nbsp;</span>
			</div>
			<?php
			if($rowSysDetails1['systemType'] != "pgTransmitter") {
				?>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Operating System:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['OperatingSystem']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">OS License Key:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['OperatingSystemLicense']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Notes:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['OtherInfo']; ?>&nbsp;</span>
				</div>
				<?php
			} else {
				?>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Protocol:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['OtherInfo']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Connection Type:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $connType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Comm. Port:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['commPort']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">RAS Port:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['RasPort']; ?>&nbsp;</span>
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
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Connection Type:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $connType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">Modem Number:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo formatPhone($rowSysDetails1['SystemDialInNumber']); ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">WAN IP/Host name:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['WanIPAddress']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">VPN Client:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $vpnType; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">VPN User:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['VpnUsername']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">VPN Password:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['VpnPassword']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">RAS User Name:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['RasUsername']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">RAS Password:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['RASPassword']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">RAS Port:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $rowSysDetails1['RasPort']; ?>&nbsp;</span>
				</div>
				<div>
					<span style="display:inline-block; width:35%; vertical-align:top; float:left; text-align:right; padding:1px;">RAS Dedicated?:</span>
					<span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px;"><?php echo $dedicated; ?>&nbsp;</span>
				</div>
			</td>
		</tr>
	</table>
	<?php
}
?>