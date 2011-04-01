<?php
$message="";
$sysMsg="";

include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
require_once 'Spreadsheet/Excel/Writer.php';

foreach($_GET as $val){
  if($val == "on"){
    $qry1 = "SELECT tblFacilities.*, tblCorpList.name AS corpName FROM tblFacilities LEFT JOIN tblCorpList ON tblFacilities.corpID = tblCorpList.id ORDER BY FacilityName";
		$rst1 = mysql_query($qry1) or die(mysql_error());
    break;
  }
}

if(isset($qry1)) {
	if(isset($_GET['outType']) && $_GET['outType'] == "print") {
		while($row1 = mysql_fetch_array($rst1)) {
			echo '<fieldset><legend><b><font face="Arial" size="2">' . $row1['FacilityName'] . '</font></b></legend>';
			echo '<table>';
			echo '<tr>';
			echo '<td colspan="2" align="Center"><u><font face="Arial" size="2">General Information</font></u></td></tr>';
			echo '<tr>';
			if(isset($_GET['custNum'])) {
				echo '<td><font face="Arial" size="2">' . 'Customer Number:' . '</font></td>';
				echo '<td><font face="Arial" size="2">' . $row1['CustomerNumber'] . '</font></td>';
			}
			echo '</tr>';
			if(isset($_GET['facAddress'])) {
				echo '<tr><td><font face="Arial" size="2">Address:</font></td>';
				echo '<td><font face="Arial" size="2">' . $row1['StreetAddress'] . '</font></td></tr>';
				echo '<tr><td>&nbsp;</td>';
				echo '<td><font face="Arial" size="2">' . 
							$row1['City'] . ', ' . $row1['StateOrProvinceCode'] . ' ' . $row1['PostalCode'] . '</font></td></tr>';
			}
			if(isset($_GET['corpInfo'])) {
				if(isset($row1['corpName'])) {
					echo '<tr><td><font face="Arial" size="2">Corporate:</font></td>';
					echo '<td><font face="Arial" size="2">' . $row1['corpName'] . '</font></td>';
				}
			}
			if($row1['Active'] == -1) {
				$status = 'Active';
			} elseif ($row1['Active'] == 0) {
				$status = 'Not Active';
			}
			echo '<tr><td><font face="Arial" size="2">Status:</font></td>';
			echo '<td><font face="Arial" size="2">' . $status . '</font></td>';
			if(isset($_GET['sysType'])) {
				if($row1['SystemType'] == '0') {
					$sysType = 'Elite';
				} elseif ($row1['SystemType'] == '1') {
					$sysType = 'On-Site';
				} elseif ($row1['SystemType'] == '2') {
					$sysType = 'On-Call';
				} elseif ($row1['SystemType'] == '3') {
					$sysType = 'On-Time';
				} else {
					$sysType = $row1['SystemType'];
				}									
				echo '<tr><td><font face="Arial" size="2">System Type:</font></td>';
				echo '<td><font face="Arial" size="2">' . $sysType . '</font></td>';
			}
			if(isset($_GET['saleRep'])) {
				$qry2 = "SELECT employees.f_name AS firstName, employees.l_name AS lastName FROM employees JOIN tblsalesrepbyterritories ON employees.id = tblsalesrepbyterritories.SalesRepID WHERE tblsalesrepbyterritories.CountryCode = '$row1[CountryCode]' AND tblsalesrepbyterritories.StateOrProvinceCode = '$row1[StateOrProvinceCode]'";
				$rst2 = mysql_query($qry2) or die(mysql_error());
				$row2 = mysql_fetch_array($rst2);
				echo '<tr><td><font face="Arial" size="2">' . 'Sales Rep.:' . '</font></td>';
				echo '<td><font face="Arial" size="2">' . $row2['firstName'] . ' ' . $row2['lastName'] . '</font></td></tr>';
			}
			if(isset($_GET['saleSrc'])) {
				$qry3 = "SELECT name FROM distributors WHERE id = '$row1[TypeOfSale]'";
				$rst3 = mysql_query($qry3) or die(mysql_error());
				$row3 = mysql_fetch_array($rst3);
				echo '<tr><td><font face="Arial" size="2">' . 'Distributor:' . '</font></td>';
				echo '<td><font face="Arial" size="2">' . $row3['name'] . '</font></td></tr>';
			}
			if(isset($_GET['purchDate'])) {
				echo '<tr><td><font face="Arial" size="2">Purchase Date:</font></td>';
				echo '<td><font face="Arial" size="2">' . $row1['datePurchased'] . '</font></td>';
			}
			if(isset($_GET['lastActivity'])) {
				$qry4 = "SELECT MAX(DateOpened) FROM tbltickets WHERE CustomerNumber = '$row1[CustomerNumber]'";
				$rst4 = mysql_query($qry4) or die(mysql_error());
				$row4 = mysql_fetch_array($rst4);
				echo '<tr><td><font face="Arial" size="2">Last Activity:</font></td>';
				echo '<td><font face="Arial" size="2">' . $row4['MAX(DateOpened)'] . '</font></td>';
			}
			echo '</table>';
			echo '</fieldset>';
		}
	} elseif(isset($_GET['outType']) && $_GET['outType'] == "export") {
		// Creating a workbook
		$workbook = new Spreadsheet_Excel_Writer();
		
		// sending HTTP headers
		$workbook->send('csPortal_Report_'.date('Ymd').'T'.date('His').'.xls');
		
		// Creating a worksheet
		$worksheet =& $workbook->addWorksheet('Facility Information');
		
		$y = 1;
		$x = 0;
	
		// The actual data
		$worksheet->write(0, 0, 'Customer Number');
		$worksheet->write(0, 1, 'Facility Name');
		$worksheet->write(0, 2, 'Facility Address');
		$worksheet->write(0, 3, 'Corporate Name');
		$worksheet->write(0, 4, 'Status');
		$worksheet->write(0, 5, 'System Type');
		$worksheet->write(0, 6, 'Sale Source');
		$worksheet->write(0, 7, 'Sales Rep');
		$worksheet->write(0, 8, 'Purchase Date');
		$worksheet->write(0, 9, 'Last Activity');
		
		while($row1 = mysql_fetch_array($rst1)) {
			$qry3 = "SELECT name FROM distributors WHERE id = '$row1[TypeOfSale]'";
			$rst3 = mysql_query($qry3) or die(mysql_error());
			$row3 = mysql_fetch_array($rst3);
	
			$qry2 = "SELECT employees.f_name AS firstName, employees.l_name AS lastName FROM employees JOIN tblsalesrepbyterritories ON employees.id = tblsalesrepbyterritories.SalesRepID WHERE tblsalesrepbyterritories.CountryCode = '$row1[CountryCode]' AND tblsalesrepbyterritories.StateOrProvinceCode = '$row1[StateOrProvinceCode]'";
			$rst2 = mysql_query($qry2) or die(mysql_error());
			$row2 = mysql_fetch_array($rst2);
			
			$qry4 = "SELECT MAX(DateOpened) FROM tbltickets WHERE CustomerNumber = '$row1[CustomerNumber]'";
			$rst4 = mysql_query($qry4) or die(mysql_error());
			$row4 = mysql_fetch_array($rst4);
			
			if($row1['SystemType'] == '0') {
				$sysType = 'Elite';
			} elseif ($row1['SystemType'] == '1') {
				$sysType = 'On-Site';
			} elseif ($row1['SystemType'] == '2') {
				$sysType = 'On-Call';
			} elseif ($row1['SystemType'] == '3') {
				$sysType = 'On-Time';
			} else {
				$sysType = $row1['SystemType'];
			}
			
			if($row1['Active'] == -1) {
				$status = 'Active';
			} elseif ($row1['Active'] == 0) {
				$status = 'Not Active';
			}
			
			$worksheet->write($y, 0, $row1['CustomerNumber']);
			$worksheet->writeString($y, 1, $row1['FacilityName']);
			$worksheet->writeString($y, 2, $row1['StreetAddress'] . ', ' . $row1['City'] . ', ' . $row1['StateOrProvinceCode'] . ' ' . $row1['PostalCode']);
			$worksheet->writeString($y, 3, $row1['corpName']);
			$worksheet->writeString($y, 4, $status);
			$worksheet->writeString($y, 5, $sysType);
			$worksheet->writeString($y, 6, $row3['name']);
			$worksheet->writeString($y, 7, $row2['firstName'] . ' ' . $row2['lastName']);
			$worksheet->writeString($y, 8, $row1['datePurchased']);
			$worksheet->writeString($y, 9, $row4['MAX(DateOpened)']);
			$y++;
		}
		
		include 'includes/db_close.inc.php';
		
		// Let's send the file
		$workbook->close();
		
		exit();
	} else {
		echo "Please select the output type for your report. <br /> Press the back button and resubmit your report.";
	}
} else {
	echo "You have not selected any data for your report. <br /> Press the back button and resubmit your report.";
}

include 'includes/db_close.inc.php';

?>