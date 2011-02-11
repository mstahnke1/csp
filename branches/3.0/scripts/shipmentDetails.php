<?php
include_once('../includes/config.inc.php');
include_once('../includes/db_connect.inc.php');
include_once('../includes/functions.inc.php');

$qryShipDetail1 = "SELECT DISTINCT siShipmentID, siCollectionDate FROM shipmentdata ";

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
$rowShipDetail1 = mysql_fetch_assoc($rstShipDetail1);
?>
<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="cspTicketHeading">Shipment Details</td>
	</tr>
	<tr>
		<td>
			<div>
				<span style="display:inline-block; padding:1px;"><?php echo date('Y-m-d', strtotime($rowShipDetail1['siCollectionDate'])); ?></span>
				<span style="display:inline-block; padding:1px;"><?php echo $rowShipDetail1['siShipmentID']; ?></span>
				<span style="display:inline-block; padding:1px;"><?php echo $rowShipDetail1['siTotalShipmentCharge']; ?></span>
				<span style="display:inline-block; padding:1px;"><?php echo $rowShipDetail1['stCompanyName']; ?></span>
			</div>
		</td>
	</tr>
</table>