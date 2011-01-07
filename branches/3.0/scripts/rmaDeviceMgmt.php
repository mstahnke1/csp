<?php
if(isset($_POST['action']) && $_POST['action'] == "add") {
	include('../includes/config.inc.php');
	include('../includes/db_connect.inc.php');
	include('../includes/functions.inc.php');
	$ticketID = $_POST['ticketID'];
	$deviceType = $_POST['deviceType'];
	$serialNumber = nl2br(stripslashes(fix_apos("'", "''", $_POST['serialNumber'])));
	$problemDesc = nl2br(stripslashes(fix_apos("'", "''", $_POST['problemDesc'])));
	$warrantyStatus = $_POST['warrantyStatus'];
	$qryRmaDevice1 = "INSERT INTO rmaDevices (SN, TicketID, Device, Problem, Warranty) 
										VALUES ('$serialNumber', '$ticketID', '$deviceType', '$problemDesc', '$warrantyStatus')";
	mysql_query($qryRmaDevice1) or die(mysql_error());
}

if(isset($_GET['action']) && $_GET['action'] == "remove") {
	include('../includes/config.inc.php');
	include('../includes/db_connect.inc.php');
	include('../includes/functions.inc.php');
	$ticketID = $_GET['ticketID'];
	$deviceID = $_GET['deviceID'];
	$qryRmaDevice3 = "DELETE FROM rmaDevices WHERE ID = '$deviceID' AND TicketID = '$ticketID' LIMIT 1";
	mysql_query($qryRmaDevice3) or die("Error removing device from list");
}

$qryRmaDevice2 = "SELECT rmaDevices.*, deviceList.partDesc AS partName 
									FROM rmaDevices 
									LEFT JOIN deviceList ON rmaDevices.Device = `deviceList`.`part#` 
									WHERE rmaDevices.TicketID = '$ticketID'";
$resRmaDevice2 = mysql_query($qryRmaDevice2) or die(mysql_error());
$numRmaDevice2 = mysql_num_rows($resRmaDevice2);
?>
<div<?php if($numRmaDevice2 < 1) { echo ' style="display:none;"'; } ?>>
	<span style="width:3%; display:inline-block; vertical-align:top; padding:0px 1px 0px 0px;"></span>
	<span style="width:18%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>Device</u></span>
	<span style="width:14%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>Serial Number</u></span>
	<span style="width:24%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>Warranty Status</u></span>
	<span style="width:38%; display:inline-block; vertical-align:top; padding:0px 1px 0px 1px;"><u>Issue Reported</u></span>
</div>
<?php
while($rowRmaDevice2 = mysql_fetch_assoc($resRmaDevice2)) {
	switch($rowRmaDevice2['Warranty']) {
		case 1:
			$warranty = "Warrantied - Repair";
			break;
		case 2:
			$warranty = "NOT Warrantied - Repair";
			break;
		case 3:
			$warranty = "NOT Warrantied - Purchase replacement";
			break;
		case 4:
			$warranty = "Warrantied - <b>Return Only</b>";
			break;
		case 5:
			$warranty = "NOT Warrantied - <b>Return Only</b>";
			break;
	}
	?>
	<div class="cspMOHighlight">
		<span style="width:3%; display:inline-block; vertical-align:top; padding:0px 1px 0px 0px;">
			<form name="updDevice<?php echo $rowRmaDevice2['ID']; ?>">
			 <input type="checkbox" name="device" onChange="updRmaDevice('<?php echo $rowRmaDevice2['ID']; ?>', '<?php echo $ticketID; ?>');" />
			</form>
		</span>
		<span style="width:18%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px;"><?php echo $rowRmaDevice2['partName']; ?></span>
		<span style="width:14%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px;"><?php echo $rowRmaDevice2['SN']; ?></span>
		<span style="width:24%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px;"><?php echo $warranty; ?></span>
		<span style="width:38%; display:inline-block; vertical-align:top; line-height:20px; padding:0px 1px 0px 1px;"><?php echo $rowRmaDevice2['Problem']; ?></span>
	</div>
	<?php
}
?>