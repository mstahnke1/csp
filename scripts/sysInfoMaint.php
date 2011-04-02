<?php
include_once('../includes/config.inc.php');
include_once('../includes/db_connect.inc.php');
$dbField = $_GET['dbField'];
$dbVal = $_GET['dbVal'];
$recID = $_GET['recID'];

$qryUpdSysInfo1 = "UPDATE tblCustSystemInfo SET $dbField = '$dbVal' WHERE id = $recID LIMIT 1";
mysql_query($qryUpdSysInfo1) or die(mysql_error());

$qryUpdSysInfo2 = "SELECT $dbField AS dbField FROM tblCustSystemInfo WHERE id = $recID";
$resUpdSysInfo2 = mysql_query($qryUpdSysInfo2) or die(mysql_error());
$rowUpdSysInfo2 = mysql_fetch_assoc($resUpdSysInfo2);

echo $rowUpdSysInfo2['dbField'];
?>