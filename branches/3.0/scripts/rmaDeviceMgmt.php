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

$qryRmaDevice2 = "SELECT rmaDevices.*, deviceList.partDesc AS partName 
									FROM rmaDevices 
									LEFT JOIN deviceList ON rmaDevices.Device = `deviceList`.`part#` 
									WHERE rmaDevices.TicketID = '$ticketID'";
$resRmaDevice2 = mysql_query($qryRmaDevice2) or die(mysql_error());
?>
<div>
	<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Device</u></span>
	<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Serial Number</u></span>
	<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Warranty Status</u></span>
	<span style="width:40%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><u>Issue Reported</u></span>
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
	<div>
		<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRmaDevice2['partName']; ?></span>
		<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRmaDevice2['SN']; ?></span>
		<span style="width:18%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $warranty; ?></span>
		<span style="width:40%; display:inline-block; vertical-align:top; padding:1px 1px 1px 1px;"><?php echo $rowRmaDevice2['Problem']; ?></span>
	</div>
	<?php
}
?>