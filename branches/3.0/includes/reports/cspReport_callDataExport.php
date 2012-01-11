<?php
include_once('../config.inc.php');
include_once('../db_connect.inc.php');
require_once('../functions.inc.php');

$qryRpt1 = "SELECT tblTickets.*, MAX(tblTicketMessages.Date) AS lastUpdate, tblFacilities.FacilityName AS facilityName, tblFacilities.servicePlan AS servicePlan 
							FROM tblTickets 
							LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
							LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber ";

//	foreach($_GET as $val){
//		if(!($val == "ALL" || $val == "")) {
  	$qryRpt1 .= "WHERE tblTicketMessages.msgType = 2 AND ";
//	  	break;
//	  } else {
//	  	$qryRpt1 .= "WHERE tblTicketMessages.callType != 1 ";
//	  	$qryRpt2 .= "WHERE tblTicketMessages.callType = 1 ";
//	  	break;
//	  }
//	}

$where = array();
$where2 = array();

$dateFrom = $_GET['dateFrom'];
if($dateFrom != "") {
	$where[] = "tblTicketMessages.Date >= '$dateFrom' ";
	$where2[] = "tblTicketMessages.Date >= '$dateFrom' ";
}

$dateTo = $_GET['dateTo'];
if($dateTo != "") {
	$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
	$where[] = "tblTicketMessages.Date < '$dateTo' ";
	$where2[] = "tblTicketMessages.Date < '$dateTo' ";
}

$custID = $_GET['custID'];
if($custID != "") {
  $where[] = "tblTickets.CustomerNumber = '$custID' ";
}

$incRMA = $_GET['incRMA'];
if($incRMA != "ALL"){
	if($incRMA == "Only") {
  	$where[] = "tblTickets.rmaReturn = '1' ";
  } elseif($incRMA == "No") {
  	$where[] = "tblTickets.rmaReturn != '1' ";
  }
}

$hfEmployee = $_GET['hfEmployee'];
if($hfEmployee != "ALL"){
  $where[] = "tblTicketMessages.EnteredBy = '$hfEmployee' ";
  $where2[] = "tblTicketMessages.EnteredBy = '$hfEmployee' ";
}

$ticketStatus = $_GET['ticketStatus'];
if($ticketStatus != "ALL"){
	if($ticketStatus == -1 || $ticketStatus == 1) {
 		$where[] = "tblTickets.Status = '$ticketStatus' ";
 	} else {
 		$where[] = "tblTickets.Status IN (0, 2) ";
 	}
} else {
	$where[] = "tblTickets.Status != 1 ";
}

$callType = $_GET['callType'];
if($callType != "ALL"){
  $where[] = "tblTicketMessages.callType = '$callType' ";
  $where2[] = "tblTicketMessages.callType = '$callType' ";
}

$spType = $_POST['spType'];
if($spType != "ALL"){
  $where[] = "tblFacilities.servicePlan = '$spType' ";
}

$issueCat = $_GET['issueCat'];
if($issueCat != "") {
  $where[] = "tblTickets.categoryCode = '$issueCat' ";
}

if(!empty($where)) {
  $qryRpt1 .= implode(" AND ", $where);
} else {
	$qryRpt1 = substr($qryRpt1, 0, -4);
}

$numTotalOffice = 0;
$qryRpt1 .= "GROUP BY tblTickets.ID ORDER BY lastUpdate DESC LIMIT 0,1000";
$resRpt1 = mysql_query($qryRpt1) or die(mysql_error());
$rowRpt1 = mysql_fetch_assoc($resRpt1);
if($custID != "") {
	$rptLabel = $rowRpt1['facilityName'];
} else {
	$rptLabel = "Call Detail";
}
mysql_data_seek($resRpt1, 0);

require_once 'Spreadsheet/Excel/Writer.php';

// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

// sending HTTP headers
$workbook->send('csp_Report_'.date('Ymd').'T'.date('His').'.xls');

// Creating a worksheet
$worksheet =& $workbook->addWorksheet('Report Details');

$x = 1;
$y = 0;

// The actual data
$worksheet->write(0, 0, 'Ticket Number');
$worksheet->write(0, 1, 'Status');
$worksheet->write(0, 2, 'Created Tasks');
$worksheet->write(0, 3, 'Sale Source');
$worksheet->write(0, 4, 'Customer');
$worksheet->write(0, 5, 'Corporate');
$worksheet->write(0, 6, 'Contact');
$worksheet->write(0, 7, 'Summary');
$worksheet->write(0, 8, 'Date Opened');
$worksheet->write(0, 9, 'Follow Up Date');
$worksheet->write(0, 10, 'Technician Remark');

while($rowRpt1 = mysql_fetch_array($resRpt1)) {
	// connect to work db and get task information 
	mysql_select_db($dbname2);
	$query5 = "SELECT * FROM taskinfo WHERE ticketNum = '$rowRpt1[ID]'";
	$result5 = mysql_query($query5, $conn);
	$taskList = "";
	$taskCount = mysql_num_rows($result5);
	mysql_select_db($dbname);
	$qryCustInfo = "SELECT tblFacilities.FacilityName,tblFacilities.TypeOfSale, tblCorpList.name FROM tblFacilities LEFT JOIN tblCorpList ON tblFacilities.corpID = tblCorpList.id WHERE CustomerNumber = '$rowRpt1[CustomerNumber]'";
	$rstCustInfo = mysql_query($qryCustInfo);
	$rowCustInfo = mysql_fetch_array($rstCustInfo);
	$custName = $rowCustInfo['FacilityName'];
	$custCorp = $rowCustInfo['name'];
	if($taskCount > 0) {
		while($row5 = mysql_fetch_array($result5)) {
			$qryGetEmp = "SELECT f_name, l_name FROM employees WHERE id = '$row5[Response]'";
			$rstGetEmp = mysql_query($qryGetEmp);
			$rowGetEmp = mysql_fetch_array($rstGetEmp);
			$empName = $rowGetEmp['f_name'] . " " . $rowGetEmp['l_name'];
			$taskList .= $row5['ID'] . "(" . $empName . "), ";
		}
		$taskList = substr($taskList, 0, -2);
	}
	if($rowRpt1['Status']==0) {
		$Status = 'OPEN';
	}elseif($rowRpt1['Status']==1) {
		$Status = 'CANCELED';
	}elseif($rowRpt1['Status']==2) {
		$Status = 'ESCALATED';
	}else{
		$Status = 'CLOSED';
	}
	if($rowCustInfo['TypeOfSale'] == 1) {
		$srcLead = "HomeFree";
	} elseif($rowCustInfo['TypeOfSale'] == 2) {
		$srcLead = "Direct Supply";
	} elseif($rowCustInfo['TypeOfSale'] == 3) {
		$srcLead = "Simplex";
	} else {
		$srcLead = "Unknown";
	}
	

	$worksheet->write($x, 0, $rowRpt1['ID']);
	$worksheet->writeString($x, 1, $Status);
	$worksheet->writeString($x, 2, $taskList);
	$worksheet->writeString($x, 3, $srcLead);
	$worksheet->writeString($x, 4, $custName." (".$rowRpt1['CustomerNumber'].")");
	$worksheet->writeString($x, 5, $custCorp);
	$worksheet->writeString($x, 6, $rowRpt1['Contact']);
	$worksheet->writeString($x, 7, $rowRpt1['Summary']);
	$worksheet->writeString($x, 8, $rowRpt1['DateOpened']);
	$worksheet->writeString($x, 9, $rowRpt1['DateFollowUp']);
	$worksheet->writeString($x, 10, strip_tags($rowRpt1['Message']));
	$x++;
}


// Let's send the file
$workbook->close();

//include '../db_close.inc.php';

exit();
?>