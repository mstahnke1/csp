<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
if(isset($_POST['srchString']) && $_POST['srchString'] == 'facilityName') {
	$srchString = $_POST['srchString'];
	$qryCustSearch1 = "SELECT CustomerNumber, FacilityName, FacilityNameOther 
										FROM tblFacilities 
										WHERE FacilityName LIKE '%$srchString%' OR FacilityNameOther LIKE '%$srchString%' 
										AND Active = -1";
	$rstCustSearch1 = mysql_query($qryCustSearch1) or die(mysql_error());
}
?>
Search Submitted