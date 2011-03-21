<?php
include_once('../includes/config.inc.php');
include_once('../includes/db_connect.inc.php');
include_once('../includes/functions.inc.php');

$qryShipDetail1 = "SELECT DISTINCT siShipmentID, siCollectionDate, siTotalShipmentCharge, stCompanyName, stAttention, stStreetAddress, stCity, stState, stZipCode, siServiceType, siSaturdayDeliveryOption, siCallTagOption FROM shipmentdata ";

foreach($_POST as $val){
  if($val != ""){
    $qryShipDetail1 .= "WHERE ";
    break;
  }
}

$where = array();

$dateFrom = $_POST['dateFrom'];
$dateFromUnix = strtotime($dateFrom);
if($dateFrom != ""){
  $where[] = "siCollectionDate >= '$dateFrom' ";
}

$dateTo = $_POST['dateTo'];
$dateToUnix = strtotime('+1 day',strtotime($dateTo));
if($dateTo != ""){
	$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
	$where[] = "siCollectionDate <= '$dateTo' ";
}

$refNum = $_POST['refNum'];
if($refNum != ""){
  $where[] = "((pkgPackageReference1 = '$refNum'
  || pkgPackageReference2 = '$refNum'
  || pkgPackageReference3 = '$refNum'
  || pkgPackageReference4 = '$refNum'
  || pkgPackageReference5 = '$refNum')
  && (siIsVOID !='Y'))";
}

if(!empty($where)){
  $qryShipDetail1 .= implode(" AND ", $where);
} else {
	$qryShipDetail1 = substr($qryShipDetail1, 0, -6);
}

$rstShipDetail1 = mysql_query($qryShipDetail1) or die(mysql_error());
$numShipDetail1 = mysql_num_rows($rstShipDetail1);
//$rowShipDetail1 = mysql_fetch_assoc($rstShipDetail1);
?>
<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="cspTicketHeading">Shipment Details</td>
	</tr>
	<tr>
		<td>
			<div>
				<span class="modListHeading" style="width:10%;">Date</span>
				<span class="modListHeading" style="width:6%;">Cost</span>
				<span class="modListHeading" style="width:25%;">Ship To</span>
				<span class="modListHeading" style="width:11%;">Service Type</span>
				<span class="modListHeading" style="width:15%;">Shipment Options</span>
				<span class="modListHeading" style="width:20%;">Tracking Details</span>
			</div>
			<?php
			while($rowShipDetail1 = mysql_fetch_assoc($rstShipDetail1)) {
				$qryShipDetail2 = "SELECT pkgTrackingNumber,pkgWeight FROM shipmentdata WHERE siShipmentID = '$rowShipDetail1[siShipmentID]'";
				$rstShipDetail2 = mysql_query($qryShipDetail2) or die(mysql_error());
				while($rowShipDetail2 = mysql_fetch_assoc($rstShipDetail2)) {
					$packageDetails = "";
					$packageDetails .= '<a href="http://wwwapps.ups.com/tracking/tracking.cgi?tracknum=' . $rowShipDetail2['pkgTrackingNumber'] . '" target="_blank">' . $rowShipDetail2['pkgTrackingNumber'] . '</a>';
				}
				$shipOptions = "";
				if($rowShipDetail1['siSaturdayDeliveryOption']=='Y') {
					$shipOptions .= "<div>Saturday Delivery</div>";
				}
				if($rowShipDetail1['siCallTagOption']=='Y') {
					$shipOptions .= "<div>Call Tag</div>";
				}
				?>
				<div class="cspMOHighlight">
					<span class="modList" style="width:10%;"><?php echo date('Y-m-d', strtotime($rowShipDetail1['siCollectionDate'])); ?></span>
					<span class="modList" style="width:6%;"><?php echo "$" . $rowShipDetail1['siTotalShipmentCharge']; ?></span>
					<span class="modList" style="width:25%;">
						<div><?php echo $rowShipDetail1['stCompanyName']; ?></div>
						<div><?php echo $rowShipDetail1['stAttention']; ?></div>
						<div><?php echo $rowShipDetail1['stStreetAddress']; ?></div>
						<div><?php echo $rowShipDetail1['stCity'] . ", " . $rowShipDetail1['stState'] . " " . $rowShipDetail1['stZipCode']; ?></div>
					</span>
					<span class="modList" style="width:11%;"><?php echo $rowShipDetail1['siServiceType']; ?></span>
					<span class="modList" style="width:15%;"><?php echo $shipOptions; ?></span>
					<span class="modList" style="width:20%;"><?php echo $packageDetails; ?></span>
				</div>
				<?php
			}
			?>
		</td>
	</tr>
</table>