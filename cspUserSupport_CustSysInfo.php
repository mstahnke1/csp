<?php
include_once('includes/config.inc.php');
include_once('includes/db_connect.inc.php');
include_once('includes/functions.inc.php');
$custID = $_GET['custID'];
$qrySysInfo1 = "SELECT SystemType, SystemAMSVersion, dbType, clientLic, pagerType, pagingFrequency, FRN FROM tblFacilities WHERE CustomerNumber = '$custID'";
$rstSysInfo1 = mysql_query($qrySysInfo1);
$rowSysInfo1 = mysql_fetch_assoc($rstSysInfo1);
$qrySysInfo2 = "SELECT id, systemType, SystemStationLocation FROM tblCustSystemInfo WHERE CustomerNumber = '$custID'";
$rstSysInfo2 = mysql_query($qrySysInfo2);
$numSysInfo2 = mysql_num_rows($rstSysInfo2);
?>
<div class="dashLeftCol">
	<?php require_once('includes/support/cspCustSysInfo_Software.php'); ?>
	<?php require_once('includes/support/cspCustSysInfo_MonStations.php'); ?>
</div>
<div class="dashRightCol">
	<?php require_once('includes/support/cspCustSysInfo_Paging.php'); ?>
	<?php require_once('includes/support/cspCustSysInfo_PageTrans.php'); ?>
</div>