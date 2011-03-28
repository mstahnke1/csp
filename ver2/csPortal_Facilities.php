<?php
$message="";
$sysMsg="";

//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

//$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
//$url = urlencode(!empty($query) ? " $host$self?$query" : " $host$self");
$url = urlencode(!empty($query) ? " $self?$query" : " $self");

if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	mysql_query($queryLog);
	include 'includes/db_close.inc.php';
	die(header("Location: csPortal_Login.php?url=" . $url));
}
else
{
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}

	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	include 'includes/functions.inc.php';
	
	if(isset($_GET['msgID']))
	{
		$sysMsg = $portalMsg[$_GET['msgID']][$lang];
	}
	
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	$mail = $_SESSION['mail'];
	$query19 = "SELECT id FROM employees WHERE email = '$mail'";
	$result19 = mysql_query($query19);
	$row19 = mysql_fetch_assoc($result19);
	$userid = $row19['id'];
	
	if(isset($_GET['action']) && $_GET['action'] == "removeCust")
	{
		$query = "UPDATE tblFacilities SET Active = 0 WHERE CustomerNumber = '$_GET[fid]' LIMIT 1";
		mysql_query($query) or die(mysql_error());
		die(header("Location: " . $_SERVER['PHP_SELF'] . "?msgID=0"));
	}
	
	if(isset($_POST['action']) && $_POST['action'] == "createNote")
	{
		$custNum = $_POST['cust_num'];
		$noteText = $_POST['noteText'];
		if(isset($_POST['optionPopup']))
		{
			$optionPopup = 1;
		}
		else
		{
			$optionPopup = 0;
		}
		$query17 = "INSERT INTO sysnotes (text, type, reference, notificationPopup, userid) VALUES ('$noteText', 'customer', '$custNum', '$optionPopup', '$userid')";
		$result17 = mysql_query($query17);
		if($result17)
		{
			header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0");
		}
		else
		{
			$sysMsg = mysql_error();
		} 
	}
	
	if(isset($_GET['action']) && $_GET['action'] == "deleteNote")
	{
		$custNum = $_GET['cust_num'];
		$noteID = $_GET['noteID'];
		$query18 = "DELETE FROM sysnotes WHERE id = '$noteID'";
		$result18 = mysql_query($query18);
		if($result18)
		{
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0"));
		}
		else
		{
			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_GET['action']) && $_GET['action'] == "deleteSys")
	{
		$custNum = $_GET['cust_num'];
		$SysID = $_GET['SysID'];
		$query = "DELETE FROM tblcustsysteminfo WHERE id = '$SysID'";
		$result = mysql_query($query);
		if($result)
		{
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0"));
		}
		else
		{
			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_POST['addContact']))
	{
		$custNum = $_POST['cust_num'];
		$cntFName = $_POST['cntFName'];
		$cntLName = $_POST['cntLName'];
		$cntPNumber = $_POST['cntPNumber'];
		$cntEmail = $_POST['cntEmail'];
		$cntPosition = $_POST['cntPosition'];
		$query24 = "INSERT INTO clients (custRef, f_name, l_name, email, phone1, position) VALUES ('$custNum', '$cntFName', '$cntLName', '$cntEmail', '$cntPNumber', '$cntPosition')";
		if(mysql_query($query24)) {
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num="  . $custNum . "&by_cust=Lookup&msgID=0"));
		} else {
			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_POST['updContact']))
	{
		$custNum = $_POST['cust_num'];
		$contactID = $_POST['contactID'];
		$cntFName = $_POST['cntFName'];
		$cntLName = $_POST['cntLName'];
		$cntPNumber = $_POST['cntPNumber'];
		$cntEmail = $_POST['cntEmail'];
		$cntPosition = $_POST['cntPosition'];
		$query24 = "UPDATE clients SET custRef = '$custNum', f_name = '$cntFName', l_name = '$cntLName', email = '$cntEmail', phone1 = '$cntPNumber', position = '$cntPosition' WHERE id = '$contactID' LIMIT 1";
		if(mysql_query($query24)) {
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num="  . $custNum . "&by_cust=Lookup&msgID=0"));
		} else {
			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_GET['action']) && $_GET['action'] == "rmvContact")
	{
		$custNum = $_GET['cust_num'];
		$contactID = $_GET['contactID'];
		$query22 = "UPDATE clients SET active = 1 WHERE id = '$contactID' LIMIT 1";
		$query23 = "DELETE FROM notifications WHERE usrID = '$contactID' AND usrType = 2";
		if(mysql_query($query22)) {
			if(mysql_query($query23)) {
				die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num="  . $custNum . "&by_cust=Lookup&msgID=0"));
			} else {
				$sysMsg = mysql_error();
			}
		} else {
			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_GET['saveNew']))
	{
		$custNum = $_GET['cust_num'];
		$opCompany = $_GET['opCompany'];
		if($_GET['cboCorporate'] == -1) {
			$corpID = "NULL";
		} elseif($_GET['cboCorporate'] == 0) {
			$corpName = $_GET['corpName'];
			$query27 = "INSERT INTO tblCorpList (name) VALUES ('$corpName')";
			$result27 = mysql_query($query27) or die(mysql_error());
			if($result27) {
				$query28 = "SELECT MAX(id) FROM tblCorpList";
				$result28 = mysql_query($query28) or die(mysql_error());
				$row28 = mysql_fetch_array($result28);
				$corpID = $row28['MAX(id)'];
			}
		} else {
			$corpID = $_GET['cboCorporate'];
		}
		$fName = stripslashes(fix_apos("'", "''", $_GET['fName']));
		$fNameOther = stripslashes(fix_apos("'", "''", $_GET['fNameOther']));
		$strAddress = stripslashes(fix_apos("'", "''", $_GET['strAddress']));
		$city = stripslashes(fix_apos("'", "''", $_GET['city']));
		$state = $_GET['state'];
		$zip = $_GET['zip'];
		$country = $_GET['country'];
		$phoneNum = $_GET['phoneNum'];
		$faxNum = $_GET['faxNum'];
		$saleType = $_GET['saleType'];
		$date = date('Y-m-d H:i:s');
		$query = "INSERT INTO tblfacilities (CustomerNumber, corpID, FacilityName, FacilityNameOther, StreetAddress, City, StateOrProvinceCode, PostalCode, CountryCode, PhoneNumber, FaxNumber, TypeOfSale, refCompany, DateModified) VALUES ('$custNum', $corpID, '$fName', '$fNameOther', '$strAddress', '$city', '$state', '$zip', '$country', '$phoneNum', '$faxNum', '$saleType', '$opCompany', '$date')";
		if(mysql_query($query))
		{
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0"));
		}
		else
		{
			$sysMsg = $portalMsg[1][$lang];
//			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_GET['saveSysNew']))
	{
		$custNum = $_GET['cust_num'];
		if(isset($_GET['softVersion']))
		{
			$softVersion = $_GET['softVersion'];
		}
		if(isset($_GET['dbType']))
		{
			$dbType = $_GET['dbType'];
		}
		if(isset($_GET['clientLic']))
		{
			$clientLic = $_GET['clientLic'];
		}
		if(isset($_GET['sysType']))
		{
 			$sysType = $_GET['sysType'];
 		}
 		if(isset($_GET['pagerType']))
		{
 			$pagerType = $_GET['pagerType'];
 		}
 		if(isset($_GET['pagingFrequency']))
		{
 			$pagingFreq = $_GET['pagingFrequency'];
 		}
 		if(isset($_GET['FRN']))
		{
 			$FRN = $_GET['FRN'];
 		}
 		$stationType = $_GET['stationType'];
		$location = $_GET['location'];
		$manufacturer = $_GET['manufacturer'];
		$modelNum = $_GET['modelNum'];
		$serialNum = $_GET['serialNum'];
		if(isset($_GET['os']))
		{
			$os = $_GET['os'];
		}
		else
		{
			$os = "";
		}
		if(isset($_GET['oslic']))
		{
			$oslic = $_GET['oslic'];
		}
		else
		{
			$oslic = "";
		}
		$notes = nl2br(stripslashes(fix_apos("'", "''", $_GET['notes'])));
		$connType = $_GET['connType'];
		$sysUser = $_GET['sysUser'];
		$sysPass = $_GET['sysPass'];
		$sysLanIp = $_GET['sysLanIp'];
		if(isset($_GET['modemNum']))
		{
			$modemNum = $_GET['modemNum'];
		}
		else
		{
			$modemNum = "";
		}
		if(isset($_GET['wanIP']))
		{
			$wanIP = $_GET['wanIP'];
		}
		else
		{
			$wanIP = "";
		}
		if(isset($_GET['vpnClient']))
		{
			$vpnClient = $_GET['vpnClient'];
		}
		else
		{
			$vpnClient = "";
		}
		if(isset($_GET['vpnUser']))
		{
			$vpnUser = stripslashes(fix_apos("'", "''", $_GET['vpnUser']));
		}
		else
		{
			$vpnUser = "";
		}
		if(isset($_GET['vpnPass']))
		{
			$vpnPass = stripslashes(fix_apos("'", "''", $_GET['vpnPass']));
		}
		else
		{
			$vpnPass = "";
		}
		if(isset($_GET['rasUser']))
		{
			$rasUser = stripslashes(fix_apos("'", "''", $_GET['rasUser']));
		}
		else
		{
			$rasUser = "";
		}
		if(isset($_GET['rasPass']))
		{
			$rasPass = stripslashes(fix_apos("'", "''", $_GET['rasPass']));
		}
		else
		{
			$rasPass = "";
		}
		if(isset($_GET['rasPort']))
		{
			$rasPort = $_GET['rasPort'];
		}
		else
		{
			$rasPort = "";
		}
		if(isset($_GET['comPort']))
		{
			$comPort = $_GET['comPort'];
		}
		else
		{
			$comPort = "";
		}
		if(isset($_GET['sysDedicated']))
		{
			$sysDedicated = $_GET['sysDedicated'];
		}
		else
		{
			$sysDedicated = 0;
		}
		$date = date('Y-m-d H:i:s');
		
		$query2 = "INSERT INTO tblcustsysteminfo (CustomerNumber, systemType, ConnectionType, SystemDialInNumber, WanIPAddress, SystemUserName, SystemPassword, SystemIPAddress, SystemStationLocation,
							VpnClientType, VpnUsername, VpnPassword, RasUsername, RASPassword, RasPort, Dedicated, commPort, SystemManufacturer, SystemModelNumber, 
							SystemSerialNumber, OperatingSystem, OperatingSystemLicense, OtherInfo, DateModified)
							VALUES ('$custNum', '$stationType', '$connType', '$modemNum', '$wanIP', '$sysUser', '$sysPass', '$sysLanIp', '$location', '$vpnClient', '$vpnUser', '$vpnPass', '$rasUser', '$rasPass', '$rasPort',
							'$sysDedicated', '$comPort', '$manufacturer', '$modelNum', '$serialNum', '$os', '$oslic', '$notes', '$date')";
		if(isset($_GET['stationType']) && $_GET['stationType'] == "Server")
		{
			$query = "UPDATE tblfacilities SET SystemType = '$sysType', SystemAMSVersion = '$softVersion', dbType = '$dbType', clientLic = '$clientLic' WHERE CustomerNumber = '$custNum' LIMIT 1";
			if((mysql_query($query)) && (mysql_query($query2)))
			{
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0"));
			}
			else
			{
				$sysMsg = $portalMsg[1][$lang];
//			$sysMsg = mysql_error();
			}
		}
		elseif(isset($_GET['stationType']) && $_GET['stationType'] == "pgTransmitter")
		{
			$query = "UPDATE tblfacilities SET pagerType = '$pagerType', pagingFrequency = '$pagingFreq', FRN = '$FRN' WHERE CustomerNumber = '$custNum' LIMIT 1";
			if((mysql_query($query)) && (mysql_query($query2)))
			{
				die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0"));
			}
			else
			{
				$sysMsg = $portalMsg[1][$lang];
//			$sysMsg = mysql_error();
			}
		}
		else
		{
			if(mysql_query($query2))
			{
				die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0"));
			}
			else
			{
				$sysMsg = $portalMsg[1][$lang];
//			$sysMsg = mysql_error();
			}
		}
	}
	
	if(isset($_GET['saveGenUpdates']))
	{
		$custNum = $_GET['cust_num'];
		$opCompany = $_GET['opCompany'];
		$fName = stripslashes(fix_apos("'", "''", $_GET['fName']));
		if($_GET['fNameOther'] == "")
		{
			$fNameOther = NULL;
		}
		else
		{
			$fNameOther = stripslashes(fix_apos("'", "''", $_GET['fNameOther']));
		}
		if($_GET['cboCorporate'] == -1) {
			$corpID = "NULL";
		} elseif($_GET['cboCorporate'] == 0) {
			$corpName = $_GET['corpName'];
			$query27 = "INSERT INTO tblCorpList (name) VALUES ('$corpName')";
			$result27 = mysql_query($query27) or die(mysql_error());
			if($result27) {
				$query28 = "SELECT MAX(id) FROM tblCorpList";
				$result28 = mysql_query($query28) or die(mysql_error());
				$row28 = mysql_fetch_array($result28);
				$corpID = $row28['MAX(id)'];
			}
		} else {
			$corpID = $_GET['cboCorporate'];
		}
		$strAddress = stripslashes(fix_apos("'", "''", $_GET['strAddress']));
		$city = stripslashes(fix_apos("'", "''", $_GET['city']));
		$state = $_GET['state'];
		$zip = $_GET['zip'];
		$country = $_GET['country'];
		$phoneNum = $_GET['phoneNum'];
		$faxNum = $_GET['faxNum'];
		$saleType = $_GET['saleType'];
		$date = date('Y-m-d H:i:s');
		$query = "UPDATE tblfacilities SET corpID = $corpID, FacilityName = '$fName', FacilityNameOther = '$fNameOther', StreetAddress = '$strAddress', City = '$city', CountryCode = '$country', StateOrProvinceCode = '$state', PostalCode = '$zip', PhoneNumber = '$phoneNum', FaxNumber = '$faxNum', TypeOfSale = '$saleType', refCompany = '$opCompany', DateModified = '$date' WHERE CustomerNumber = '$custNum' LIMIT 1";
		if(mysql_query($query))
		{
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0"));
		}
		else
		{
//			$sysMsg = $portalMsg[1][$lang];
			$sysMsg = mysql_error();
		}
	}
		
	if(isset($_GET['saveSysUpdates']))
	{
		$custNum = $_GET['cust_num'];
		$sysID = $_GET['sysID'];
		$stationType = $_GET['stationType'];
		$softVersion = $_GET['softVersion'];
		$clientLic = $_GET['clientLic'];
 		$sysType = $_GET['sysType'];
 		$pagerType = $_GET['pagerType'];
 		$pagingFreq = $_GET['pagingFrequency'];
 		$FRN = $_GET['FRN'];
 		$dbType = $_GET['dbType'];
		$location = $_GET['location'];
		$manufacturer = $_GET['manufacturer'];
		$modelNum = $_GET['modelNum'];
		$serialNum = $_GET['serialNum'];
		if(isset($_GET['os']))
		{
			$os = $_GET['os'];
		}
		else
		{
			$os = "";
		}
		if(isset($_GET['oslic']))
		{
			$oslic = $_GET['oslic'];
		}
		else
		{
			$oslic = "";
		}
		$notes = nl2br(stripslashes(fix_apos("'", "''", $_GET['notes'])));
		$connType = $_GET['connType'];
		$sysUser = $_GET['sysUser'];
		$sysPass = $_GET['sysPass'];
		$sysLanIp = $_GET['sysLanIp'];
		if(isset($_GET['modemNum']))
		{
			$modemNum = $_GET['modemNum'];
		}
		else
		{
			$modemNum = "";
		}
		if(isset($_GET['wanIP']))
		{
			$wanIP = $_GET['wanIP'];
		}
		else
		{
			$wanIP = "";
		}
		if(isset($_GET['vpnClient']))
		{
			$vpnClient = $_GET['vpnClient'];
		}
		else
		{
			$vpnClient = "";
		}
		if(isset($_GET['vpnUser']))
		{
			$vpnUser = stripslashes(fix_apos("'", "''", $_GET['vpnUser']));
		}
		else
		{
			$vpnUser = "";
		}
		if(isset($_GET['vpnPass']))
		{
			$vpnPass = stripslashes(fix_apos("'", "''", $_GET['vpnPass']));
		}
		else
		{
			$vpnPass = "";
		}
		if(isset($_GET['rasUser']))
		{
			$rasUser = stripslashes(fix_apos("'", "''", $_GET['rasUser']));
		}
		else
		{
			$rasUser = "";
		}
		if(isset($_GET['rasPass']))
		{
			$rasPass = stripslashes(fix_apos("'", "''", $_GET['rasPass']));
		}
		else
		{
			$rasPass = "";
		}
		if(isset($_GET['rasPort']))
		{
			$rasPort = $_GET['rasPort'];
		}
		else
		{
			$rasPort = "";
		}
		if(isset($_GET['comPort']))
		{
			$comPort = $_GET['comPort'];
		}
		else
		{
			$comPort = "";
		}
		if(isset($_GET['sysDedicated']))
		{
			$sysDedicated = $_GET['sysDedicated'];
		}
		else
		{
			$sysDedicated = 0;
		}
		$date = date('Y-m-d H:i:s');
		$query = "UPDATE tblfacilities SET SystemType = '$sysType', SystemAMSVersion = '$softVersion', clientLic = '$clientLic', dbType = '$dbType', pagerType = '$pagerType', pagingFrequency = '$pagingFreq', FRN = '$FRN' WHERE CustomerNumber = '$custNum' LIMIT 1";
		$query2 = "UPDATE tblcustsysteminfo SET systemType = '$stationType', ConnectionType = '$connType', SystemDialInNumber = '$modemNum', WanIPAddress = '$wanIP',
							SystemUserName = '$sysUser', SystemPassword = '$sysPass', SystemIPAddress = '$sysLanIp',
							VpnClientType = '$vpnClient', VpnUsername = '$vpnUser', VpnPassword = '$vpnPass', RasUsername = '$rasUser', RASPassword = '$rasPass', RasPort = '$rasPort',
							Dedicated = '$sysDedicated', commPort = '$comPort', SystemStationLocation = '$location', SystemManufacturer = '$manufacturer', SystemModelNumber = '$modelNum',
							SystemSerialNumber = '$serialNum', OperatingSystem = '$os', OperatingSystemLicense = '$oslic', OtherInfo = '$notes',
							DateModified = '$date' WHERE id = '$sysID' LIMIT 1";
		if((mysql_query($query)) && (mysql_query($query2)))
		{
			die(header("Location: " . $_SERVER['PHP_SELF'] . "?cust_num=" . $custNum . "&by_cust=Lookup&msgID=0"));
		}
		else
		{
			$sysMsg = $portalMsg[1][$lang];
//			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_GET['by_name']))
	{
		$f_name = $_GET['f_name'];
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
		$start_from = ($page-1) * 50;
		$query5 = "SELECT CustomerNumber, FacilityName, FacilityNameOther FROM tblFacilities WHERE Active = -1 AND ((FacilityName LIKE '%$f_name%') OR (FacilityNameOther LIKE '%$f_name%')) ORDER BY FacilityName LIMIT $start_from, 50";
		$result5 = mysql_query($query5) or die ('Error retrieving Customer Name Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
	}

	if(isset($_GET['by_cust']))
	{
		$cust_num = $_GET['cust_num'];
		$query = "SELECT CustomerNumber FROM tblFacilities WHERE CustomerNumber = '$cust_num' AND Active = -1";
		$result = mysql_query($query) or die ('Error retrieving Customer Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
		$row = mysql_fetch_array($result);
		$query2 = "SELECT * FROM tblFacilities WHERE CustomerNumber = '$cust_num' AND Active = -1";
		$result2 = mysql_query($query2) or die (mysql_error());
		$row2 = mysql_fetch_array($result2);
		$query14 = "SELECT * FROM tblCustSystemInfo WHERE (CustomerNumber = '$row[CustomerNumber]' && (systemType = 'Server' || systemType = 'Client'))";
		$result14 = mysql_query($query14) or die (mysql_error());
		$num14 = mysql_num_rows($result14);
		$query15 = "SELECT * FROM tblCustSystemInfo WHERE (CustomerNumber = '$row[CustomerNumber]' && systemType = 'pgTransmitter')";
		$result15 = mysql_query($query15) or die (mysql_error());
		$num15 = mysql_num_rows($result15);
		$query4 = "SELECT * FROM tblvpnclients";
		$result4 = mysql_query($query4) or die (mysql_error());
		$query5 = "SELECT SalesRepID FROM tblsalesrepbyterritories WHERE CountryCode = '$row2[CountryCode]' AND StateOrProvinceCode = '$row2[StateOrProvinceCode]'";
		$result5 = mysql_query($query5) or die (mysql_error());
		$row5 = mysql_fetch_assoc($result5);
		$query6 = "SELECT f_name, l_name FROM employees WHERE id = '$row5[SalesRepID]'";
		$result6 = mysql_query($query6) or die (mysql_error());
		$row6 = mysql_fetch_assoc($result6);
		$salesRep = $row6['l_name'].', '.$row6['f_name'];
		$query7 = "SELECT * FROM distributors WHERE id = '$row2[TypeOfSale]'";
		$result7 = mysql_query($query7) or die (mysql_error());
		$row7 = mysql_fetch_array($result7);
		$query8 = "SELECT * FROM tblcountries";
		$result8 = mysql_query($query8) or die (mysql_error());
		$query9 = "SELECT StateOrProvinceCode, StateOrProvince FROM tblsalesrepbyterritories WHERE CountryCode = 'US'";
		$result9 = mysql_query($query9) or die (mysql_error());
		$query10 = "SELECT * FROM filemanager WHERE refNumber = '$cust_num' && attachType = 'customer' && publish = -1 ORDER BY timestamp DESC";
		$result10 = mysql_query($query10);
		$curDate = date('Y-m-d H:i:s');
		$query11 = "SELECT Package, EndDate FROM warrantyinfo WHERE FacilityID = '$cust_num' && Package != '0'";
		$result11 = mysql_query($query11) or die(mysql_error());
		$num11 = mysql_num_rows($result11);
		$row11 = mysql_fetch_array($result11);
		$query12 = "SELECT ID FROM tbltickets WHERE CustomerNumber = '$cust_num' AND Status = 0";
		$result12 = mysql_query($query12) or die(mysql_error());
		$num12 = mysql_num_rows($result12);
		$activityDate = date('Y-m-d H:i:s', strtotime("-24 Hours", strtotime($curDate)));
		$query3 = "SELECT id FROM tbltickets WHERE CustomerNumber = '$cust_num' AND DateOpened >= '$activityDate'";
		$result3 = mysql_query($query3) or die (mysql_error());
		$query16 = "SELECT * FROM sysNotes WHERE reference = '$cust_num' && type = 'customer'";
		$result16 = mysql_query($query16) or die(mysql_error());
		$num16 = mysql_num_rows($result16);
		$query31 = "SELECT * FROM distributors";
    $result31 = mysql_query($query31);
		
		if((mysql_num_rows($result3) > 0) && (!isset($_GET['msgID'])))
		{
			$sysMsg = $portalMsg[15][$lang];
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Customer Information</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="csPortal_Layout.css" />

<SCRIPT TYPE="text/javascript" language="javascript1.2">
 document.cookie='refineIndex=0';
</SCRIPT>

<script language="JavaScript">
function change(form,section)
{
////////////////////////////////////
 if(section == 'Server')
 {
  document.getElementById('serverOpts').style.display="inline"; 
 }
 else
 {
  document.getElementById('serverOpts').style.display="none"; 
 }

////////////////////////////////////
}
</script>

<script language="JavaScript">
function changeElem(elemID,elemValue)
{
	if(elemValue == 0) {
		/*Shows text box to enter new corporate name*/
		document.getElementById(elemID).style.display="inline";
	}
	else if(elemValue == -1) {
		/*Removes text box to enter new corporate name*/
		alert('Corporate information will be removed.');
		document.getElementById(elemID).style.display="none";
	}
  else {
  	/*alert("You are assigning to corporate ID"+elemValue);*/
  	document.getElementById(elemID).style.display="none";
  }
}
</script>

</HEAD>

<BODY>
<div id="dhtmltooltip"></div>

<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

</script>
<?php
if((isset($_GET['view']) && ($_GET['view'] == "print")))
{
?>
	<table cellspacing="0" cellpadding="0" border="0" width="550" align="center">
<?php
}
else
{
?>
<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
<?php
}
?>
	<tr>
		<td>
			<?php
			if((isset($_GET['view']) && ($_GET['view'] == "print")))
			{
			?>
			<table cellspacing="0" cellpadding="0" border="0" width="550" align="left">
			<?php
			}
			else
			{
			?>
			<table cellspacing="0" cellpadding="0" border="0" width="600" align="left">
			<?php
			}
			?>
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;">
					<?php
					if((isset($_GET['view']) && ($_GET['view'] == "print")))
					{
					?>
					<img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></td>
					<?php
					}
					else
					{
					?>
					<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					<?php
					}
					?>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center" style="padding:0 0 6px 0; height:32px;">
					
									<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
										<tr>
											<?php
											if((isset($_GET['view']) && ($_GET['view'] == "print")))
											{
											?>
											<td>&nbsp;</td>
											<?php
											}
											else
											{
											echo '<td valign="bottom"><font size="2" face="Arial"><strong>' . $message . '</strong>&nbsp;<a href="csPortal_Login.php?action=logout">[' . $portalMsg[9][$lang] . ']</a></td>';
											}
											?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="bottom">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
									<?php
									if((isset($_GET['view']) && ($_GET['view'] == "print")))
									{
										?>
										<td>&nbsp;</td>
										<?php
										}
										else
										{
										?>
						  			<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'"; height="36" alt="Click to go to Netcom homepage."></a></td>
						  			<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'"; height="36" alt="Click to go to Sales homepage."></a></td>
						  			<td><a href="csPortal_Support.php"><img src="images/Support_ButtonActive.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonActive.gif'"; height="36" alt="Click for customer support options."></a></td>								
						  			<?php
						  			if($_SESSION['access'] >= 7)
						  			{
											echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonOff.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonOff.gif'\";\" height=\"36\" alt=\"Netcom's company administration portal.\"></a></td>";
										}
									}
									?>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<?php
					if((isset($_GET['view']) && ($_GET['view'] == "print")))
					{
					?>
						<td>&nbsp;</td>
					<?php
					}
						else
					{
					?>
					<td><img src="images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
					<?php
					}
					?>
					<td width="100%" style="background-image: url(images/subnav-bg.gif);">
		<!-- sub nav -->
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center">
									<table cellspacing="0" cellpadding="0" border="0" style="height:20px;">
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="0" id="tablist2">
												<tr>
													<?php
													if((isset($_GET['view']) && ($_GET['view'] == "print")))
													{
													?>
														<td>&nbsp;</td>
													<?php
													}
													else
													{
													?>
														<td style="color:#3b3d3d;font-size:10px;font-family: verdana;font-weight:bold;"><b>&nbsp;</b></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Facilities.php" style="font-size:10px;font-family: verdana;">CUSTOMER INFO</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Tickets.php" style="font-size:10px;font-family: verdana;">SUPPORT TICKETS</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_UpsTrack.php" style="font-size:10px;font-family: verdana;">SHIPMENT TRACKING</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Notifications.php" style="font-size:10px;font-family: verdana;">NOTIFICATIONS</a></td>
														<?php
														if(isset($_GET['cust_num'])) {
														?>
															<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
															<td style="padding-left:4px;padding-right:4px;"><a href="sales/trainingeval.php?f_id=<?php echo $cust_num; ?>&view=home" style="font-size:10px;font-family: verdana;">EVALUATION CENTER</a></td>
														<?php
														}
													}
													?>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
if(!(isset($_GET['view']) && ($_GET['view'] == "print")))
{
?>
	<table align="center" width="759" border="0" bgcolor="#FFFFFF">
<?php
} else {
?>
	<table align="center" width="550" border="0" bgcolor="#FFFFFF">
<?php
}
?>
	<tr valign="top">
		<?php
  	/************************** COLUMN LEFT START *************************/
  	?>
		<td width="550">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
  			<tr>
  	<td align="center"><b><i><font face="Arial" size="2" color="Red"><?php echo $sysMsg; ?></font></b></i></td>
  </tr>
 <tr>
    <?php
    if((isset($_GET['action']) && ($_GET['action'] == "createNew")))
		{
			echo '<td align="left">';
			echo '<form method="get" action="'.$_SERVER['PHP_SELF'].'">';
			echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">';
			echo '<tr><td>&nbsp;</td></tr>';
			echo '<tr><td colspan="2" align="center"><font face="Arial" size="3"><b>Facility Information</b></font></td></tr>';
    	echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Customer Number: ' . '</b></font></td><td><input type="text" name="cust_num" maxlength="6" size="6"></td></tr>';
    	echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Operating Company: ' . '</b></font></td>';
    	?>
			<td>
			<select name="opCompany">
			<option value="HomeFree">HomeFree</option>
			<option value="ElmoTech">ElmoTech</option>
			</select>
			</td>
			</tr>
			<?php
			echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Corporate: ' . '</b></font></td>';
			$query30 = "SELECT * FROM tblCorpList ORDER BY name ASC";
			$result30 = mysql_query($query30);
    	?>
			<td>
			<select name="cboCorporate" onchange="javascript:changeElem('txtNewCorpName',this.value);">
				<option value="-1">- None -</option>
				<?php
				$qryEmpPerms = "SELECT manageCorp FROM employees WHERE id = '$_SESSION[uid]'";
				$rstEmpPerms = mysql_query($qryEmpPerms);
				$rowEmpPerms = mysql_fetch_array($rstEmpPerms);
				if($rowEmpPerms['manageCorp'] == 1) {
				?>
					<option value="0">- New -</option>
				<?php
				}
				while($row30 = mysql_fetch_array($result30)) { ?>
					<option value="<?php echo $row30['id']; ?>"><?php echo $row30['name']; ?></option>
				<?php
				}
				?>
			</select>
			</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td id="txtNewCorpName" style="display: none;">
					<font face="Arial" size="2"><b>Corporate Name</b></font>
					<input type="text" name="corpName" value="" />
				</td>
			</tr>
			<?php
			echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Facility Name: ' . '</b></font></td><td><input type="text" name="fName"></td></tr>';
			echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Alternate Name: ' . '</b></font></td><td><input type="text" name="fNameOther"></td></tr>';
   		echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Street Address: ' . '</b></font></td><td><input type="text" name="strAddress"></td></tr>';
    	echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'City, State Zip:' . '</b></font></td><td><input type="text" name="city">,';
    	?>
			<select name="state">
			<?php
			$query9 = "SELECT StateOrProvinceCode, StateOrProvince FROM tblsalesrepbyterritories WHERE CountryCode = 'US'";
			$result9 = mysql_query($query9) or die (mysql_error());
			while($row9 = mysql_fetch_array($result9))
			{
			?>
				<option value="<?php echo $row9['StateOrProvinceCode']; ?>"><?php echo $row9['StateOrProvince']; ?></option>
			<?php
			}
			?>
    	</select>
    	<input type="text" name="zip" size="9"></td></tr>
    	<?php
    	echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Country Code:' . '</b></font></td>';
    	?>
			<td>
			<select name="country">
			<?php
			$query8 = "SELECT * FROM tblcountries";
			$result8 = mysql_query($query8) or die (mysql_error());
			while($row8 = mysql_fetch_array($result8))
			{
			?>
				<option value="<?php echo $row8['CountryCode']; ?>" <?php if($row8['CountryCode'] == "US"){ echo 'selected="selected"'; } ?>><?php echo $row8['Country']; ?></option>
			<?php
			}
			?>
			</select>
			</td>
			</tr>
			<?php
    	echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Source of Lead: ' . '</b></font></td>';
    	$query31 = "SELECT * FROM distributors";
    	$result31 = mysql_query($query31);
    	?>
			<td>
			<select name="saleType">
			<option value="0">Unknown</option>
			<?php
			while($row31 = mysql_fetch_array($result31)) {
			?>
				<option value="<?php echo $row31['id']; ?>"><?php echo $row31['name']; ?></option>
			<?php
			}
			?>
			</select>
			</td>
			</tr>
			<?php
    	echo '<tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>';
    	echo '</table>';
    	echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">';
			echo '<tr><td colspan="2" align="center"><font face="Arial" size="3"><b>Contact Information</b></font></td></tr>';
   		echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Phone Number: ' . '</b></font></td><td><input type="text" name="phoneNum" size="10" maxlength="10"></td></tr>';
   		echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Fax Number: ' . '</b></font></td><td><input type="text" name="faxNum" size="10" maxlength="10"></td></tr>';
   		echo '<input type="hidden" name="by_cust" value="Lookup">';
   		echo '<tr><td colspan="2"><input type="submit" name="saveNew" value="Update">&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['PHP_SELF'].'\'"></td></tr>';
			echo '<tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>';
   		echo '</table>';
   		echo '</form>';
		}
		
    if(isset($_GET['by_name']) OR isset($_GET['by_cust']) OR isset($_GET['action']))
    {
    	echo '<td align="left">';
  		if(isset($_GET['by_cust']))
  		{
  			if(is_null($row['CustomerNumber']) && !isset($_GET['by_name']))
  			{
  				echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
					echo '<tr><td align="center"><i>' . 'No matches found' . '</i></td></tr>';
					echo '</table>';
				}
				else
				{
					# UPDATE GENERAL FACILITY INFORMATION
					if((isset($_GET['action']) && ($_GET['action'] == "updateGen")))
					{
						echo '<form method="get" action="'.$_SERVER['PHP_SELF'].'">';
						echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">';
						echo '<tr><td>&nbsp;</td></tr>';
						echo '<tr><td colspan="2" align="center"><font face="Arial" size="3"><b>Facility Information</b></font></td></tr>';
    				echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Customer Number: ' . '</b></font></td><td>' . $row2['CustomerNumber'] . '</td></tr>';
    				echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Operating Company: ' . '</b></font></td>';
    				?>
						<td>
						<select name="opCompany">
							<option value="HomeFree" <?php if($row2['refCompany'] == "HomeFree"){ echo 'selected="selected"'; } ?>>HomeFree</option>
							<option value="ElmoTech" <?php if($row2['refCompany'] == "ElmoTech"){ echo 'selected="selected"'; } ?>>ElmoTech</option>
						</select>
						</td>
						</tr>
						<?php
						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Corporate: ' . '</b></font></td>';
						$query26 = "SELECT * FROM tblCorpList ORDER BY name ASC";
						$result26 = mysql_query($query26);
    				?>
						<td>
							<select name="cboCorporate" onchange="javascript:changeElem('txtNewCorpName',this.value);">
								<option value="-1" <?php if($row2['corpID'] == ""){ echo 'selected="selected"'; } ?>>- None -</option>
								<?php
								$qryEmpPerms = "SELECT manageCorp FROM employees WHERE id = '$_SESSION[uid]'";
								$rstEmpPerms = mysql_query($qryEmpPerms);
								$rowEmpPerms = mysql_fetch_array($rstEmpPerms);
								if($rowEmpPerms['manageCorp'] == 1) {
								?>
								<option value="0">- New -</option>
								<?php
								}
								while($row26 = mysql_fetch_array($result26)) { ?>
									<option value="<?php echo $row26['id']; ?>" <?php if($row26['id'] == $row2['corpID']){ echo 'selected="selected"'; } ?>><?php echo $row26['name']; ?></option>
								<?php
								}
								?>
							</select>
						</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td id="txtNewCorpName" style="display: none;">
								<font face="Arial" size="2"><b>Corporate Name</b></font>
								<input type="text" name="corpName" value="" />
							</td>
						</tr>
						<?php
						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Facility Name: ' . '</b></font></td><td><input type="text" name="fName" value="' . $row2['FacilityName'] . '"></td></tr>';
						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Alternate Name: ' . '</b></font></td><td><input type="text" name="fNameOther" value="' . $row2['FacilityNameOther'] . '"></td></tr>';
   					echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Street Address: ' . '</b></font></td><td><input type="text" name="strAddress" value="' . $row2['StreetAddress'] . '"></td></tr>';
    				echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'City, State Zip:' . '</b></font></td><td><input type="text" name="city" value="' . $row2['City'] . '">, ';
    				?>
						<select name="state">
						<?php
						while($row9 = mysql_fetch_array($result9))
						{
						?>
							<option value="<?php echo $row9['StateOrProvinceCode']; ?>" <?php if($row9['StateOrProvinceCode'] == $row2['StateOrProvinceCode']){ echo 'selected="selected"'; } ?>><?php echo $row9['StateOrProvince']; ?></option>
						<?php
						}
						?>
						</select>
    				<input type="text" name="zip" size="9" value="<?php echo $row2['PostalCode']; ?>"></td></tr>
    				<?php
    				echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Country Code:' . '</b></font></td>';
    				?>
						<td>
						<select name="country">
						<?php
						while($row8 = mysql_fetch_array($result8))
						{
						?>
							<option value="<?php echo $row8['CountryCode']; ?>" <?php if($row8['CountryCode'] == $row2['CountryCode']){ echo 'selected="selected"'; } ?>><?php echo $row8['Country']; ?></option>
						<?php
						}
						?>
						</select>
						</td>
						</tr>
						<?php
    				echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Source of Lead: ' . '</b></font></td>';
    				?>
						<td>
						<select name="saleType">
						<option value="0" <?php if((is_null($row2['TypeOfSale'])) OR ($row2['TypeOfSale'] == 0)){ echo 'selected="selected"'; } ?>>Unknown</option>
						<?php
						while($row31 = mysql_fetch_array($result31)) {
						?>
							<option value="<?php echo $row31['id']; ?>" <?php if($row2['TypeOfSale'] == $row31['id']){ echo 'selected="selected"'; } ?>><?php echo $row31['name']; ?></option>
						<?php
						}
						?>
						</select>
						</td>
						</tr>
						<?php
    				echo '<tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>';
    				echo '</table>';
    				echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">';
						echo '<tr><td colspan="2" align="center"><font face="Arial" size="3"><b>Contact Information</b></font></td></tr>';
   					echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Phone Number: ' . '</b></font></td><td><input type="text" name="phoneNum" size="10" maxlength="10" value="' . $row2['PhoneNumber'] . '"></td></tr>';
   					echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Fax Number: ' . '</b></font></td><td><input type="text" name="faxNum" size="10" maxlength="10" value="' . $row2['FaxNumber'] . '"></td></tr>';
   					echo '<input type="hidden" name="cust_num" value="'.$row2['CustomerNumber'].'">';
   					echo '<input type="hidden" name="by_cust" value="Lookup">';
   					echo '<tr><td colspan="2"><input type="submit" name="saveGenUpdates" value="Update">&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['PHP_SELF'].'?cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup\'"></td></tr>';
						echo '<tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>';
   					echo '</table>';
   					echo '</form>';
					}
					else
					{
						if((!(isset($_GET['secID']) &&  ($_GET['secID'] == "system"))))
						{
							if(!(isset($_GET['view']) && $_GET['view'] == "print"))
  						{
							echo '<table cellspacing="5" border="0" align="center"><td><a href="csPortal_Tickets.php?cust_num='.$row2['CustomerNumber'].'&by_cust=number&submit=Lookup"><font face="Arial" size="2">View Tickets</font></a></td>';
							if($num12 == 0)
							{
								echo '<td><a href="csPortal_Tickets.php?f_id='.$row2['CustomerNumber'].'&action=newTicket"><font face="Arial" size="2">Create Ticket</font></a></td></table>';
							}
							echo '<table cellspacing="5" align="center"><tr><td width="73" height="31" align="center" background="images/blank_glass-button.png"><a href="'.$_SERVER['PHP_SELF'].'?cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup&action=updateGen"><font face="Arial" size="2" color="white"><b>Update</b></font></a></td>';
	  					?>
  						<td width="73" height="31" align="center" background="images/blank_glass-button.png">
  							<a href="javascript:void(0)"onclick="window.open('csPortal_Facilities.php?cust_num=<?php echo $row2['CustomerNumber']; ?>&by_cust=Lookup&view=print','system','width=600,height=750,scrollbars=yes')"><font face="Arial" size="2" color="white"><b>Print</b></font></a>
  						</td>
  						<td width="73" height="31" align="center" background="images/blank_glass-button.png">
  							<a href="csPortal_Notifications.php?subscription=enroll&usrType=1&mntrRef=<?php echo $row2['CustomerNumber']; ?>" onClick="return confirm('Are you sure you want to monitor support activity for <?php echo $row2['FacilityName']; ?>')"><font face="Arial" size="2" color="white"><b>Monitor</b></font></a>
  						</td>
 					 		<?php
 					 		echo '</tr></table>';
							}
							else
							{
								if(!isset($_GET['sysID']))
								{
								?>
									<script language="Javascript1.2">
									<!--
										window.print();
									//-->
									</script>
							<?php
								}
							}
							echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" STYLE="background-image: url(\'images/invbox_back.gif\'); border: 1 ridge #CCCCCC">';
							echo '<tr><td colspan="2" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Facility Information</b></font></td></tr>';
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="1">Last Updated: '.$row2['DateModified'].'</font></td></tr>';
    					echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Customer Number: ' . '</b></font></td><td>' . $row2['CustomerNumber'] . '</td></tr>';
    					echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Operating Company: ' . '</b></font></td><td>' . $row2['refCompany'] . '</td></tr>';
    					if($row2['corpID'] != "") {
    						$query29 = "SELECT name FROM tblCorpList WHERE id = '$row2[corpID]'";
    						$result29 = mysql_query($query29);
    						$row29 = mysql_fetch_array($result29);
    						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Corporate: ' . '</b></font></td><td>' . $row29['name'] . '</td></tr>';
    					}
							echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Facility Name: ' . '</b></font></td><td>' . $row2['FacilityName'] . '</td></tr>';
							if($row2['FacilityNameOther'] != "") {
								echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Alternate Name: ' . '</b></font></td><td>' . $row2['FacilityNameOther'] . '</td></tr>';
							}
   						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Street Address: ' . '</b></font></td><td>' . $row2['StreetAddress'] . '</td></tr>';
    					echo '<tr><td width="135" valign="top">' . '&nbsp;' . '</td><td>' . $row2['City'] . ', ' . $row2['StateOrProvinceCode'] . ' ' . $row2['PostalCode'] .  '</td></tr>';
    					echo '<tr><td width="135" valign="top">' . '&nbsp;' . '</td><td>' . $row2['CountryCode'] . '</td></tr>';
   						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Phone Number: ' . '</b></font></td><td>' . formatPhone($row2['PhoneNumber']) . '</td></tr>';
   						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Fax Number: ' . '</b></font></td><td>' . formatPhone($row2['FaxNumber']) . '</td></tr>';
   						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'HF Representative: ' . '</b></font></td><td>' . $salesRep . '</td></tr>';
   						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Source of Lead: ' . '</b></font></td><td>' . $row7['name'] . '</td></tr>';
   						echo '<tr><td width="135" valign="top"><font face="Arial" size="2"><b>' . 'Ensure Program: ' . '</b></font></td>';
   						if(($num11 > 0) && ($row11['EndDate'] > $curDate))
   						{
   						echo '<td><font face="Arial" size="2" color="green">' . $row11['Package'] . ' Package Until ' . $row11['EndDate'] . '</font>';
   						}
   						elseif(($num11 > 0) && ($row11['EndDate'] < $curDate))
   						{
   						echo '<td><font face="Arial" size="2" color="red"><b>' . $row11['Package'] . ' Package EXPIRED ' . $row11['EndDate'] . '</b></font>';
   						}
   						else
   						{
   						echo '<td><font face="Arial" size="2" color="red">Not Enrolled</font>';
   						}
   						echo '&nbsp;<a href="csPortal_WarrantyProgram.php?cust_num=' . $cust_num . '"><font face="Arial" size="2">Details</font></a>';
   						echo '</td></tr>';
   						echo '<tr><td colspan="2"><div align="center"><hr width="50%"></div></td></tr>';
   						?>
   						<tr>
   							<td colspan="2" align="center">
   								<font face="Arial" size="2"><b>Contact Information</b></font>
   							</td>
   						</tr>
   						<tr>
  							<td colspan="2" align="center">
  								<font face="Arial" size="1"><strong>Notification Legend: </strong></font>
									<img src="images/check3.gif"><font face="Arial" size="1"> Email Enabled</font>
  							</td>
  						</tr>
  						<?php
  						if(!(isset($_GET['inputType']) && $_GET['inputType'] == "contact"))
  						{
 							?>
  						<tr>
  							<td colspan="2" align="center">
									<a href="<?php echo $_SERVER['PHP_SELF']; ?>?cust_num=<?php echo $row2['CustomerNumber']; ?>&by_cust=Lookup&inputType=contact"><img src="images/Plus_Sign.jpg" border="0"><font face="Arial" size="1"><strong>ADD CONTACT</strong></font></a>
  							</td>
  						</tr>
  						<?php
  						}
  						if(isset($_GET['inputType']) && $_GET['inputType'] == "contact")
  						{
 							?>
  							<tr>
   								<td colspan="2" align="center">
   									<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   									<table>
   										<tr>
   											<td>
   												<font face="Arial" size="2">First Name </font><br />
   												<input type="text" name="cntFName" />
   											</td>
   											<td>
   												<font face="Arial" size="2">Last Name:</font><br />
   												<input type="text" name="cntLName" />
   											</td>
   										</tr>
   										<tr>
   											<td>
   												<font face="Arial" size="2">Phone Number:</font><br />
   												<input type="text" size="10" maxlength="10" name="cntPNumber" />
   											</td>
   											<td>
   												<font face="Arial" size="2">Email:</font><br />
   												<input type="text" size="32" name="cntEmail" />
   											</td>
   										</tr>
   										<tr>
   											<td>
   												<font face="Arial" size="2">Position:</font><br />
   												<input type="text" name="cntPosition" />
   											</td>
   											<td>
   												&nbsp;
   											</td>
   										</tr>
   										<tr>
   											<td>
   												<input type="hidden" name="cust_num" value="<?php echo $cust_num; ?>" />
   												<input type="submit" name="addContact" value="Update" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?cust_num=<?php echo $row2['CustomerNumber']; ?>&by_cust=Lookup'">
   											</td>
   											<td>
   												&nbsp;
   											</td>
   										</tr>
   									</table>
   									</form>
   								</td>
   							</tr>
   						<?php
   						} elseif(isset($_GET['inputType']) && $_GET['inputType'] == "updcontact")
  						{
  							$contactID = $_GET['contactID'];
  							$query25 = "SELECT * FROM clients WHERE custRef = '$cust_num' AND id = '$contactID'";
   							$result25 = mysql_query($query25);
   							$row25 = mysql_fetch_array($result25);
 								?>
  							<tr>
   								<td colspan="2" align="center">
   									<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   									<table>
   										<tr>
   											<td>
   												<font face="Arial" size="2">First Name </font><br />
   												<input type="text" name="cntFName" value="<?php echo $row25['f_name']; ?>" />
   											</td>
   											<td>
   												<font face="Arial" size="2">Last Name:</font><br />
   												<input type="text" name="cntLName" value="<?php echo $row25['l_name']; ?>" />
   											</td>
   										</tr>
   										<tr>
   											<td>
   												<font face="Arial" size="2">Phone Number:</font><br />
   												<input type="text" size="10" maxlength="10" name="cntPNumber" value="<?php echo $row25['phone1']; ?>" />
   											</td>
   											<td>
   												<font face="Arial" size="2">Email:</font><br />
   												<input type="text" size="32" name="cntEmail" value="<?php echo $row25['email']; ?>" />
   											</td>
   										</tr>
   										<tr>
   											<td>
   												<font face="Arial" size="2">Position:</font><br />
   												<input type="text" name="cntPosition" value="<?php echo $row25['position']; ?>" />
   											</td>
   											<td>
   												&nbsp;
   											</td>
   										</tr>
   										<tr>
   											<td>
   												<input type="hidden" name="contactID" value="<?php echo $contactID; ?>" />
   												<input type="hidden" name="cust_num" value="<?php echo $cust_num; ?>" />
   												<input type="submit" name="updContact" value="Update" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?cust_num=<?php echo $row2['CustomerNumber']; ?>&by_cust=Lookup'">
   											</td>
   											<td>
   												&nbsp;
   											</td>
   										</tr>
   									</table>
   									</form>
   								</td>
   							</tr>
   						<?php
   						}
   						?>
   						<tr>
   							<td colspan="2" align="center">
   								<table width="100%">
   									<tr>
   										<td>
   											&nbsp;
   										</td>
   										<td>
   											<font face="Arial" size="2"><u>Name</u></font>
   										</td>
   										<td>
   											<font face="Arial" size="2"><u>Position</u></font>
   										</td>
   										<td>
   											<font face="Arial" size="2"><u>Phone</u></font>
   										</td>
   										<td>
   											<font face="Arial" size="2"><u>Email</u></font>
   										</td>
   									</tr>
   									<?php
   									$query20 = "SELECT * FROM clients WHERE custRef = '$row2[CustomerNumber]' AND active = 0";
   									$result20 = mysql_query($query20);
   									$num20 = mysql_num_rows($result20);
   									if($num20 > 0) {
   										while($row20 = mysql_fetch_array($result20)) {
   											$query21 = "SELECT id, ntfyType FROM notifications WHERE usrType = 2 AND usrID = '$row20[id]'";
   											$result21 = mysql_query($query21);
   											$num21 = mysql_num_rows($result21);
   											$row21 = mysql_fetch_array($result21);
   											?>
   											<tr>
   												<?php
   												if($num21 > 0) {
   													if($row21['ntfyType'] == 1) {
														?>
   														<td>
   															<img src="images/check3.gif" title="Email Notification" />
   															<a href="csPortal_Notifications.php?subscription=remove&id=<?php echo $row21['id']; ?>&f_id=<?php echo $cust_num; ?>" onClick="return confirm('Are you sure you want to unsubscribe to this notification?')"><img src="images/stop_sign.png" title="Stop Monitoring" border="0" /></a>
   													<?php
   													}
   												} else {
   												?>
   													<td>
   														<?php
   														if($_SESSION['access'] >= 7 && $row20['email'] != "") {
   														?>
   															<a href="csPortal_Notifications.php?subscription=enroll&usrType=2&mntrRef=<?php echo $cust_num; ?>&usrID=<?php echo $row20['id']; ?>" onClick="return confirm('Are you sure you want to activate support activity monitoring for <?php echo $row20['l_name'] . ", " . $row20['f_name']; ?>')"><img src="images/notification.jpg" title="Setup Monitoring" border="0" /></a>
   														<?php
   														} else {
   														?>
   															<img src="images/notification.jpg" title="Setup Monitoring" border="0" />
   														<?php
   														}
   														?>
   														</td>
   												<?php
   												}
   												?>
   												<td>
   													<font face="Arial" size="2"><?php echo $row20['l_name'] . ", " . $row20['f_name']; ?></font>
   												</td>
   												<td>
   													<font face="Arial" size="2"><?php echo $row20['position']; ?></font>
   												</td>
   												<td>
   													<font face="Arial" size="2"><?php echo formatPhone($row20['phone1']); ?></font>
   												</td>
   												<td>							
   													<a href="mailto:<?php echo $row20['email']; ?>"><font face="Arial" size="2"><?php echo $row20['email']; ?></font></a>
														<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=rmvContact&contactID=<?php echo $row20['id']; ?>&cust_num=<?php echo $cust_num; ?>" onClick="return confirm('Are you sure you want to remove <?php echo $row20['l_name'] . ", " . $row20['f_name']; ?> from the contact list?')"><img src="images/delete-icon_Smallest.png" title="Remove Contact" border="0" /></a>
														<a href="<?php echo $_SERVER['PHP_SELF']; ?>?cust_num=<?php echo $row2['CustomerNumber']; ?>&by_cust=Lookup&inputType=updcontact&contactID=<?php echo $row20['id']; ?>" onClick="return confirm('Are you sure you want to update <?php echo $row20['l_name'] . ", " . $row20['f_name']; ?> from the contact list?')"><img src="images/editor_icon.gif" width="10" height="10" title="Update Contact" border="0" /></a>
   												</td>
   											</tr>
   									<?php
   										}
   									} else {
   									?>
   										<tr>
   											<td colspan="5" align="center">
   												<font face="Arial" size="2"><i>*** No Contacts Found ***</i></font>
   											</td>
   										</tr>
   									<?php
   									}
   									?>
   								</table>
   							</td>
   						</tr>
   						<?php
   						echo '</table>';
   						?>
  						<table width="100%" border="0" cellpadding="0" cellspacing="0">
  							<tr>
  								<td>&nbsp;</td>
  							</tr>
  						</table>
  					<?php
						}
					}
					
					if((isset($_GET['action']) && ($_GET['action'] == "createSys")))
					{
						echo '<form method="get" action="'.$_SERVER['PHP_SELF'].'">';
						echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center" STYLE="background-image: url(\'images/invbox_back.gif\'); border: 1 ridge #CCCCCC">';
						echo '<a name="SysInfo"><tr><td colspan="2" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>System Information</b></font></td></tr></a>';
						?>
						<tr>
							<td width="125" valign="top"><font face="Arial" size="2"><b>Station Type: </b></font></td>
							<td>
								<?php
								if($_GET['sysType'] == "pTransmitter") {
								?>
									<select name="stationType">
										<option value="pgTransmitter">Paging Trasmitter</option>
									</select>
								<?php
								} else {
								?>
								<select name="stationType" onchange="change(this.form,this.value);">
									<option value="Server">Server</option>
									<option value="Client">Client</option>
								</select>
								<?php
								}
								?>
							</td>
						</tr>
						<tr>
						<?php
						echo '<tr><td colspan="2">';
						if($_GET['sysType'] == "monStation")
						{
						?>
							<div id="serverOpts" >
								<table width="100%">
									<tr>
										<td colspan="2" align="center"><font face="Arial" size="2"><b>SOFTWARE</b></font></td>
									</tr>
									<tr>
										<td valign="top"><font face="Arial" size="2"><b>AMS Version: </b></font></td><td><input type="text" name="softVersion"></td>
									</tr>
									<tr>
										<td width="125" valign="top"><font face="Arial" size="2"><b>Station Type: </b></font></td>
										<td>
											<select name="dbType">
												<option value="MS Access">MS Access</option>
												<option value="Sybase">Sybase</option>
											</select>
										</td>
									</tr>
									<tr>
										<td width="125" valign="top"><font face="Arial" size="2"><b>License Type: </b></font></td>
										<td>
											<select name="sysType">
												<option value="0">ELITE</option>
												<option value="1">ON-SITE</option>
												<option value="2">ON-CALL</option>
												<option value="3">ON-TIME</option>
												<option value="4">ON-TOUCH</option>
											</select>
										</td>
									</tr>
									<tr>
										<td width="125" valign="top"><font face="Arial" size="2"><b>Client Licenses: </b></font></td><td><input type="text" name="clientLic" size="3"></td>
									</tr>
								</table>
							</div>
							<?php
							echo '</td></tr>';
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>STATION DETAILS</b></font></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Physical Location: ' . '</b></font></td><td><input type="text" name="location"></font></td></tr>';
						}
						elseif($_GET['sysType'] == "pTransmitter")
						{
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Physical Location: ' . '</b></font></td><td><input type="text" name="location"></font></td></tr>';
						?>
							<tr><td width="125" valign="top"><font face="Arial" size="2"><b>Pager Type: </b></font></td>
							<td>
							<select name="pagerType">
							<option value="HomeFree">HomeFree</option>
							<option value="Commtech7900">Commtech 7900</option>
							<option value="ApolloGold">Apollo Gold</option>
							<option value="Genie">Genie</option>
							</select>
							</td>
							</tr>
							<tr><td width="125" valign="top"><font face="Arial" size="2"><b>Frequency: </b></font></td><td><input type="text" name="pagingFrequency" /></td></tr>
							<tr><td width="125" valign="top"><font face="Arial" size="2"><b>FCC Registration Number (FRN): </b></font></td><td><input type="text" name="FRN" /></td></tr>
						<?php
						}
   					echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Manufacturer: ' . '</b></font></td><td><input type="text" name="manufacturer"></td></tr>';
   					echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Model Number: ' . '</b></font></td><td><input type="text" name="modelNum"></td></tr>';
   					echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Serial Number: ' . '</b></font></td><td><input type="text" name="serialNum"></td></tr>';
   					if($_GET['sysType'] == "monStation")
						{
   						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Operating System: ' . '</b></font></td><td><input type="text" name="os"></td></tr>';
   						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'OS License Key: ' . '</b></font></td><td><input type="text" name="oslic"></td></tr>';
   					}
   					echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'User Name: ' . '</b></font></td><td><input type="text" name="sysUser"></td></tr>';
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Password: ' . '</b></font></td><td><input type="text" name="sysPass"></td></tr>';
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'LAN Address: ' . '</b></font></td><td><input type="text" name="sysLanIp"></td></tr>';
						if($_GET['sysType'] == "monStation")
						{
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>REMOTE ACCESS</b></font></td></tr>';
						}
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Connection Type: ' . '</b></font></td>';
						if($_GET['sysType'] == "monStation")
						{
							?>
							<td>
							<select name="connType">
							<option value="0">None</option>
							<option value="1">Modem - VNC</option>
							<option value="2">Internet - VNC</option>
							<option value="3">Internet - RDP</option>
							<option value="4">VPN - VNC</option>
							<option value="5">VPN - RDP</option>
							<option value="6">LogMeIn</option>
							<option value="9">GoToMyPC</option>
							<option value="10">TeamViewer</option>
							</select>
							</td>
							</tr>
							<?php
						}
						elseif($_GET['sysType'] == "pTransmitter")
						{
							?>
							<td>
							<select name="connType">
							<option value="7">Serial</option>
							<option value="8">Network</option>
							</select>
							</td>
							</tr>
						<?php
						}
						if($_GET['sysType'] == "monStation")
						{
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Modem Number: ' . '</b></font></td><td><input type="text" name="modemNum" size="10" maxlength="10"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'WAN Address: ' . '</b></font></td><td><input type="text" name="wanIP"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN Client: ' . '</b></font></td>';
							?>
							<td>
							<select name="vpnClient">
							<option value="0">None</option>
							<?php
							while($row4 = mysql_fetch_array($result4))
							{
							?>
								<option value="<?php echo $row4['ID']; ?>"><?php echo $row4['ClientName']; ?></option>
							<?php
							}
							?>
							</select>
							</td>
							</tr>
							<?php
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN User: ' . '</b></font></td><td><input type="text" name="vpnUser"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN Password: ' . '</b></font></td><td><input type="text" name="vpnPass"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Username: ' . '</b></font></td><td><input type="text" name="rasUser"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Password: ' . '</b></font></td><td><input type="text" name="rasPass"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Port: ' . '</b></font></td><td><input type="text" name="rasPort"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Dedicated?: ' . '</b></font></td>';
							?>
							<td>
								<select name="sysDedicated">
								<option value="0">NO</option>
								<option value="-1">YES</option>
								</select>
							</td>
							</tr>
							<?php
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Notes: ' . '</b></font></td><td><textarea name="notes" rows="4" cols="45"></textarea></td></tr>';
						}
						if($_GET['sysType'] == "pTransmitter")
						{
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Comm. Port: ' . '</b></font></td><td><input type="text" name="comPort"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Port: ' . '</b></font></td><td><input type="text" name="rasPort"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Protocol: ' . '</b></font></td><td><input type="text" name="notes"></td></tr>';
						}
  			 		echo '<input type="hidden" name="cust_num" value="'.$row2['CustomerNumber'].'">';
  			 		echo '<input type="hidden" name="by_cust" value="Lookup">';
 			  		echo '<tr><td colspan="2"><input type="submit" name="saveSysNew" value="Update">&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['PHP_SELF'].'?cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup\'"></td></tr>';
 			  		echo '</table>';
 			  		echo '</form>';
 			  	}
					
   				if((isset($_GET['action']) && ($_GET['action'] == "updateSys")))
					{
						$sysID = $_GET['sysID'];
						$query13 = "SELECT * FROM tblCustSystemInfo WHERE id = '$sysID'";
						$result13 = mysql_query($query13);
						$row13 = mysql_fetch_array($result13);
						echo '<form method="get" action="'.$_SERVER['PHP_SELF'].'">';
						echo '<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center" STYLE="background-image: url(\'images/invbox_back.gif\'); border: 1 ridge #CCCCCC">';
						echo '<a  name="SysInfo"><tr><td colspan="2" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>System Information</b></font></td></tr></a>';
						
						if($row13['systemType'] == "Server")
						{
							echo '<tr><td valign="top">';
							echo '<table border="0">';
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>SOFTWARE</b></font></td></tr>';
							echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'AMS Version: ' . '</b></font></td><td><input type="text" name="softVersion" value="' . $row2['SystemAMSVersion'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'License Type: ' . '</b></font></td>';
						?>
							<td>
							<select name="sysType">
							<option value="0" <?php if($row2['SystemType'] == 0){ echo 'selected="selected"'; } ?>>ELITE</option>
							<option value="1" <?php if($row2['SystemType'] == 1){ echo 'selected="selected"'; } ?>>ON-SITE</option>
							<option value="2" <?php if($row2['SystemType'] == 2){ echo 'selected="selected"'; } ?>>ON-CALL</option>
							<option value="3" <?php if($row2['SystemType'] == 3){ echo 'selected="selected"'; } ?>>ON-TIME</option>
							<option value="4" <?php if($row2['SystemType'] == 4){ echo 'selected="selected"'; } ?>>ON-TOUCH</option>
							</select>
							</td>
							</tr>
					<?php
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Database Type: ' . '</b></font></td>';
						?>
							<td>
							<select name="dbType">
							<option value="MS Access" <?php if($row2['dbType'] == "MS Access"){ echo 'selected="selected"'; } ?>>MS Access</option>
							<option value="Sybase" <?php if($row2['dbType'] == "Sybase"){ echo 'selected="selected"'; } ?>>Sybase</option>
							</select>
							</td>
							</tr>
					<?php
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Client Licenses: ' . '</b></font></td><td><input type="text" name="clientLic" size="3" value="' . $row2['clientLic'] . '" /></td></tr>';
							echo '</table>';
							echo '</td>';
							echo '<td valign="top">';
						}
						else
						{
							echo '<input type="hidden" name="softVersion" value="' . $row2['SystemAMSVersion'] . '">';
							echo '<input type="hidden" name="sysType" value="' . $row2['SystemType'] . '">';
							echo '<input type="hidden" name="clientLic" value="' . $row2['clientLic'] . '">';
							echo '<input type="hidden" name="dbType" value="' . $row2['dbType'] . '">';
							echo '</td>';
							echo '<td valign="top">';
						}
						
						if($row13['systemType'] == "pgTransmitter")
						{
						echo '<table border="0">';
						echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>PAGING</b></font></td></tr>';
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>Pager Type: </b></font></td>';
						?>
						<td>
						<select name="pagerType">
						<option value="HomeFree" <?php if($row2['pagerType'] == "HomeFree"){ echo 'selected="selected"'; } ?>>HomeFree</option>
						<option value="Commtech7900" <?php if($row2['pagerType'] == "Commtech7900"){ echo 'selected="selected"'; } ?>>Commtech 7900</option>
						<option value="ApolloGold" <?php if($row2['pagerType'] == "ApolloGold"){ echo 'selected="selected"'; } ?>>Apollo Gold</option>
						<option value="Genie" <?php if($row2['pagerType'] == "Genie"){ echo 'selected="selected"'; } ?>>Genie</option>
						</select>
						</td>
						</tr>
						<?php
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Frequency: ' . '</b></font></td><td><input type="text" name="pagingFrequency" value="' . $row2['pagingFrequency'] . '" /></td></tr>';
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'FCC Registration Number (FRN): ' . '</b></font></td><td><input type="text" name="FRN" value="' . $row2['FRN'] . '" /></td></tr>';
						echo '</table>';
						}
						else
						{
							echo '<input type="hidden" name="pagerType" value="' . $row2['pagerType'] . '">';
							echo '<input type="hidden" name="pagingFrequency" value="' . $row2['pagingFrequency'] . '">';
							echo '<input type="hidden" name="FRN" value="' . $row2['FRN'] . '">';
						}
						echo '</td></tr>';
						echo '<tr><td>' . '&nbsp;' . '</td></tr>';
						echo '</td></tr><tr><td colspan="2" align="left"><table>';
						if($row13['systemType'] != "pgTransmitter")
						{
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>STATION DETAILS</b></font></td></tr>';
						}
						else
						{
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>TRANSMITTER DETAILS</b></font></td></tr>';
						}
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Physical Location: ' . '</b></font></td><td><input type="text" name="location" value="' . $row13['SystemStationLocation'] . '"></font></td></tr>';
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Station Type: ' . '</b></font></td>';
						if($row13['systemType'] != "pgTransmitter")
						{
						?>
							<td>
							<select name="stationType">
							<option value="Server" <?php if($row13['systemType'] == "Server"){ echo 'selected="selected"'; } ?>>Server</option>
							<option value="Client" <?php if($row13['systemType'] == "Client"){ echo 'selected="selected"'; } ?>>Client</option>
							</select>
							</td>
							</tr>
						<?php
						}
						else
						{
						?>
							<td>
							<select name="stationType">
							<option value="pgTransmitter" <?php if($row13['systemType'] == "pgTransmitter"){ echo 'selected="selected"'; } ?>>Paging Transmitter</option>
							</select>
							</td>
							</tr>
						<?php
						}
   					echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Manufacturer: ' . '</b></font></td><td><input type="text" name="manufacturer" value="' . $row13['SystemManufacturer'] . '"></td></tr>';
   					echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Model Number: ' . '</b></font></td><td><input type="text" name="modelNum" value="' . $row13['SystemModelNumber'] . '"></td></tr>';
   					echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Serial Number: ' . '</b></font></td><td><input type="text" name="serialNum" value="' . $row13['SystemSerialNumber'] . '"></td></tr>';
   					if($row13['systemType'] != "pgTransmitter")
						{
   						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Operating System: ' . '</b></font></td><td><input type="text" name="os" value="' . $row13['OperatingSystem'] . '"></td></tr>';
   						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'OS License Key: ' . '</b></font></td><td><input type="text" name="oslic" value="' . $row13['OperatingSystemLicense'] . '"></td></tr>';
   					}
   					echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'User Name: ' . '</b></font></td><td><input type="text" name="sysUser" value="' . $row13['SystemUserName'] . '"></td></tr>';
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Password: ' . '</b></font></td><td><input type="text" name="sysPass" value="' . $row13['SystemPassword'] . '"></td></tr>';
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'LAN Address: ' . '</b></font></td><td><input type="text" name="sysLanIp" value="' . $row13['SystemIPAddress'] . '"></td></tr>';
						if($row13['systemType'] != "pgTransmitter")
						{
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>REMOTE ACCESS</b></font></td></tr>';
						}
						echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Connection Type: ' . '</b></font></td>';
						if($row13['systemType'] != "pgTransmitter")
						{
						?>
							<td>
							<select name="connType">
							<option value="0" <?php if((is_null($row13['ConnectionType'])) OR ($row13['ConnectionType'] == 0)){ echo 'selected="selected"'; } ?>>None</option>
							<option value="1" <?php if($row13['ConnectionType'] == 1){ echo 'selected="selected"'; } ?>>Modem - VNC</option>
							<option value="2" <?php if($row13['ConnectionType'] == 2){ echo 'selected="selected"'; } ?>>Internet - VNC</option>
							<option value="3" <?php if($row13['ConnectionType'] == 3){ echo 'selected="selected"'; } ?>>Internet - RDP</option>
							<option value="4" <?php if($row13['ConnectionType'] == 4){ echo 'selected="selected"'; } ?>>VPN - VNC</option>
							<option value="5" <?php if($row13['ConnectionType'] == 5){ echo 'selected="selected"'; } ?>>VPN - RDP</option>
							<option value="6" <?php if($row13['ConnectionType'] == 6){ echo 'selected="selected"'; } ?>>LogMeIn</option>
							<option value="9" <?php if($row13['ConnectionType'] == 9){ echo 'selected="selected"'; } ?>>GoToMyPC</option>
							<option value="10" <?php if($row13['ConnectionType'] == 10){ echo 'selected="selected"'; } ?>>TeamViewer</option>
							</select>
							</td>
							</tr>
						<?php
						}
						else
						{
						?>
							<td>
							<select name="connType">
							<option value="7" <?php if($row13['ConnectionType'] == 7){ echo 'selected="selected"'; } ?>>Serial</option>
							<option value="8" <?php if($row13['ConnectionType'] == 8){ echo 'selected="selected"'; } ?>>Network</option>
							</select>
							</td>
							</tr>
						<?php
						}
						if($row13['systemType'] != "pgTransmitter")
						{
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Modem Number: ' . '</b></font></td><td><input type="text" name="modemNum" size="10" maxlength="10" value="' . $row13['SystemDialInNumber'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'WAN Address: ' . '</b></font></td><td><input type="text" name="wanIP" value="' . $row13['WanIPAddress'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN Client: ' . '</b></font></td>';
							?>
							<td>
							<select name="vpnClient">
							<option value="0" <?php if((is_null($row13['VpnClientType'])) OR ($row13['VpnClientType'] == 0)){ echo 'selected="selected"'; } ?>>None</option>
							<?php
							while($row4 = mysql_fetch_array($result4))
							{
							?>
								<option value="<?php echo $row4['ID']; ?>" <?php if($row4['ID'] == $row13['VpnClientType']){ echo 'selected="selected"'; } ?>><?php echo $row4['ClientName']; ?></option>
							<?php
							}
							?>
							</select>
							</td>
							</tr>
							<?php
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN User: ' . '</b></font></td><td><input type="text" name="vpnUser" value="' . $row13['VpnUsername'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN Password: ' . '</b></font></td><td><input type="text" name="vpnPass" value="' . $row13['VpnPassword'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Username: ' . '</b></font></td><td><input type="text" name="rasUser" value="' . $row13['RasUsername'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Password: ' . '</b></font></td><td><input type="text" name="rasPass" value="' . $row13['RASPassword'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Port: ' . '</b></font></td><td><input type="text" name="rasPort" value="' . $row13['RasPort'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Dedicated?: ' . '</b></font></td>';
							?>
							<td>
							<select name="sysDedicated">
							<option value="0" <?php if((is_null($row13['Dedicated'])) OR ($row13['Dedicated'] == 0)){ echo 'selected="selected"'; } ?>>NO</option>
							<option value="-1" <?php if($row13['Dedicated'] == -1){ echo 'selected="selected"'; } ?>>YES</option>
							</select>
							</td>
							</tr>
							<?php
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Notes: ' . '</b></font></td><td><textarea name="notes" rows="4" cols="45">' . strip_tags($row13['OtherInfo']) . '</textarea></td></tr>';
						}
						else
						{
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Comm. Port: ' . '</b></font></td><td><input type="text" name="comPort" value="' . $row13['commPort'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Port: ' . '</b></font></td><td><input type="text" name="rasPort" value="' . $row13['RasPort'] . '"></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Protocol: ' . '</b></font></td><td><input type="text" name="notes" value="' . $row13['OtherInfo'] . '"></td></tr>';
						}
   					echo '<input type="hidden" name="cust_num" value="'.$row2['CustomerNumber'].'">';
   					echo '<input type="hidden" name="sysID" value="'.$row13['id'].'">';
   					echo '<input type="hidden" name="by_cust" value="Lookup">';
   					echo '<tr><td colspan="2"><input type="submit" name="saveSysUpdates" value="Update">&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['PHP_SELF'].'?cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup\'"></td></tr>';
   					echo '</table>';
   					echo '</form>';
   					echo '</table>';
   				}
   				/*
					else
					{
					*/
						echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" STYLE="background-image: url(\'images/invbox_back.gif\'); border: 1 ridge #CCCCCC">';
						if(!isset($_GET['action']))
						{
  						echo '<a  name="SysInfo"><tr><td colspan="2" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>System Information</b></font></td></tr></a>';
  						echo '<tr><td colspan="2" align="center"><font face="Arial" size="1">Last Updated: '.$row2['DateModified'].'</font></td></tr>';
   						echo '<tr><td>' . '&nbsp;' . '</td></tr>';
  					}
					
							if ($row2['SystemType'] == 0)
							{ 
								$licType = "Elite";
							}
							elseif ($row2['SystemType'] == 1)
							{ 
								$licType = "On-Site";
							}
							elseif ($row2['SystemType'] == 2)
							{ 
								$licType = "On-Call";
							}
							elseif ($row2['SystemType'] == 3)
							{ 
								$licType = "On-Time";
							}
							elseif ($row2['SystemType'] == 4)
							{ 
								$licType = "On-Touch";
							}
 #SysInfo
 							echo '<tr align="center"><td valign="top">';
 							echo '<table border="0">';
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>SOFTWARE</b></font></td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'AMS Version: ' . '</b></font></td><td>' . $row2['SystemAMSVersion'] . '</td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'License Type: ' . '</b></font></td><td>' . $licType . '</td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Database Type: ' . '</b></font></td><td>' . $row2['dbType'] . '</td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Client Licenses: ' . '</b></font></td><td>' . $row2['clientLic'] . '</td></tr>';
							echo '</table>';
							echo '</td>';
							echo '<td valign="top">';
							echo '<table border="0">';
							echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>PAGING</b></font></td></tr>';
							if ($row2['pagerType'] == "HomeFree")
							{ 
								$pagerType = "HomeFree";
							}
							elseif ($row2['pagerType'] == "Commtech7900")
							{ 
								$pagerType = "Commtech 7900";
							}
							elseif ($row2['pagerType'] == "ApolloGold")
							{ 
								$pagerType = "Apollo Gold";
							}
							elseif ($row2['pagerType'] == "Genie")
							{ 
								$pagerType = "Genie";
							}
							else
							{
								$pagerType = "";
							}
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Pager Type: ' . '</b></font></td><td>' . $pagerType . '</td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Frequency: ' . '</b></font></td><td>' . $row2['pagingFrequency'] . '</td></tr>';
							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'FCC Registration Number (FRN): ' . '</b></font></td><td><a href="https://fjallfoss.fcc.gov/coresWeb/searchDetail.do?frn=' . $row2['FRN'] . '" target="blank">' . $row2['FRN'] . '</a>';
							echo '</td></tr>';
							echo '</table>';
							echo '</td></tr>';
							echo '<tr><td>' . '&nbsp;' . '</td></tr>';
							
							if((isset($_GET['sysID'])) && (!isset($_GET['action'])))
							{
								$sysID = $_GET['sysID'];
								$query13 = "SELECT * FROM tblCustSystemInfo WHERE id = '$sysID'";
								$result13 = mysql_query($query13);
								$row13 = mysql_fetch_array($result13);
								if($row13['systemType'] != "pgTransmitter")
								{
									echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>STATION DETAILS</b></font></td></tr>';
								}
								else
								{
									echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>TRANSMITTER DETAILS</b></font></td></tr>';
								}
								echo '<tr><td colspan="2" align="center"><a href='.$_SERVER['PHP_SELF'].'?cust_num=' . $cust_num . '&by_cust=Lookup><font face="Arial" size="2">Close</font></a>';
								if((!(isset($_GET['secID']) &&  ($_GET['secID'] == "system"))))
								{
									echo '&nbsp;&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup&action=updateSys&sysID=' . $sysID . '#SysInfo"><font face="Arial" size="2">Update</font></a>';
								}
								echo '</td></tr><tr><td colspan="2" align="left"><table>';
								echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Physical Location: ' . '</b></font></td><td>' . $row13['SystemStationLocation'] . '</font></td></tr>';					
   							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Manufacturer: ' . '</b></font></td><td>' . $row13['SystemManufacturer'] . '</td></tr>';
   							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Model Number: ' . '</b></font></td><td>' . $row13['SystemModelNumber'] . '</td></tr>';
   							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Serial Number: ' . '</b></font></td><td>' . $row13['SystemSerialNumber'] . '</td></tr>';
   							if($row13['systemType'] != "pgTransmitter")
								{
   								echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Operating System: ' . '</b></font></td><td>' . $row13['OperatingSystem'] . '</td></tr>';
   								echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'OS License Key: ' . '</b></font></td><td>' . $row13['OperatingSystemLicense'] . '</td></tr>';
   							}
   							echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'User Name: ' . '</b></font></td><td>' . $row13['SystemUserName'] . '</td></tr>';
								echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Password: ' . '</b></font></td><td>' . $row13['SystemPassword'] . '</td></tr>';
								echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'LAN IP Address: ' . '</b></font></td><td>' . $row13['SystemIPAddress'] . '</td></tr>';
								if($row13['systemType'] != "pgTransmitter")
								{
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Notes: ' . '</b></font></td><td>' . $row13['OtherInfo'] . '</td></tr>';							
								}
								else
								{
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Protocol: ' . '</b></font></td><td>' . $row13['OtherInfo'] . '</td></tr>';							
								}
								echo '</table></td></tr>';
								if($row13['systemType'] != "pgTransmitter")
								{
									echo '<tr><td>' . '&nbsp;' . '</td></tr>';
									echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>REMOTE ACCESS</b></font></td></tr>';
								}
								if (($row13['ConnectionType'] == 0) OR (is_null($row13['ConnectionType'])))
								{ 
									$connType = "None";
								}
								elseif ($row13['ConnectionType'] == 1)
								{ 
									$connType = "Modem - VNC";
								}
								elseif ($row13['ConnectionType'] == 2)
								{ 
									$connType = "Internet - VNC";
								}
								elseif ($row13['ConnectionType'] == 3)
								{ 
									$connType = "Internet - RDP";
								}
								elseif ($row13['ConnectionType'] == 4)
								{ 
									$connType = "VPN - VNC";
								}
								elseif ($row13['ConnectionType'] == 5)
								{ 
									$connType = "VPN - RDP";
								}
								elseif ($row13['ConnectionType'] == 6)
								{ 
									$connType = "LogMeIn";
								}
								elseif ($row13['ConnectionType'] == 7)
								{ 
									$connType = "Serial";
								}
								elseif ($row13['ConnectionType'] == 8)
								{ 
									$connType = "Network";
								}
								elseif ($row13['ConnectionType'] == 9)
								{ 
									$connType = "GoToMyPC";
								}
								elseif ($row13['ConnectionType'] == 10)
								{ 
									$connType = "TeamViewer";
								}
								echo '<tr><td colspan="2" align="left"><table>';
								echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Connection Type: ' . '</b></font></td><td>' . $connType . '</td></tr>';
								if($row13['systemType'] != "pgTransmitter")
								{
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Modem Number: ' . '</b></font></td><td>' . formatPhone($row13['SystemDialInNumber']) . '</td></tr>';
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'WAN Address: ' . '</b></font></td><td>' . $row13['WanIPAddress'] . '</td></tr>';
									if (($row13['VpnClientType'] == 0) OR (is_null($row13['VpnClientType'])))
									{
										$vpnType = "None";
									}
									else
									{ 
										while($row4 = mysql_fetch_array($result4))
										{
											if($row13['VpnClientType'] == $row4['ID'])
											{
												$vpnType = $row4['ClientName'];
											}
										}
									}
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN Client: ' . '</b></font></td><td>' . $vpnType . '</td></tr>';
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN User: ' . '</b></font></td><td>' . $row13['VpnUsername'] . '</td></tr>';
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'VPN Password: ' . '</b></font></td><td>' . $row13['VpnPassword'] . '</td></tr>';
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Username: ' . '</b></font></td><td>' . $row13['RasUsername'] . '</td></tr>';
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Password: ' . '</b></font></td><td>' . $row13['RASPassword'] . '</td></tr>';
								}
								else
								{
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Comm. Port: ' . '</b></font></td><td>' . $row13['commPort'] . '</td></tr>';
								}
								echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'RAS Port: ' . '</b></font></td><td>' . $row13['RasPort'] . '</td></tr>';
								if($row13['systemType'] != "pgTransmitter")
								{
									if($row13['Dedicated'] == -1)
									{
										$dedicated = "YES";
									}
									else
									{
										$dedicated = "NO";
									}
									echo '<tr><td width="125" valign="top"><font face="Arial" size="2"><b>' . 'Dedicated?: ' . '</b></font></td><td>' . $dedicated . '</td></tr>';
								}
								echo '<tr><td>' . '&nbsp;' . '</td></tr>';
								echo '</table></td></tr>';
   						}
   						
   						# DISPLAY MONITORING STATIONS
   						echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>MONITORING STATIONS</b></font></td></tr>';
   						echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><a href="'.$_SERVER['PHP_SELF'].'?action=createSys&sysType=monStation&cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup#SysInfo">Add</a></font></td></tr>';
   						echo '<tr><td colspan="2">';
   						echo '<table border="0" align="center" cellspacing="8">';
   						if(mysql_num_rows($result14) > 0)
   						{
   						echo '<tr>';
   						echo '<td><font face="Arial" size="2"><u>' . 'Type' . '</u></font></td>';
   						echo '<td><font face="Arial" size="2"><u>' . 'Location' . '</u></font></td>';
   						echo '<td><font face="Arial" size="2"><u>' . 'Last Updated' . '</u></font></td>';
   						echo '</tr>';
   						while($row14 = @mysql_fetch_array($result14))
   						{
   							echo '<tr>';
   							echo '<td><font face="Arial" size="2">' . $row14['systemType'] . '</font></td>';
   							echo '<td><font face="Arial" size="2">' . $row14['SystemStationLocation'] . '</font></td>';
   							echo '<td><font face="Arial" size="2">' . $row14['DateModified'] . '</font></td>';
   							if(isset($_GET['view']) && $_GET['view'] == "print")
   							{
   								echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?cust_num=' . $cust_num . '&by_cust=Lookup&sysID=' . $row14['id'] . '&view=print">View</a></td>';
   							}
   							else
   							{
   								echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?cust_num=' . $cust_num . '&by_cust=Lookup&sysID=' . $row14['id'] . '#SysInfo">View</a></td>';
   							}
   							echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?action=deleteSys&SysID=' . $row14['id'] . '&cust_num=' . $cust_num . '&by_cust=Lookup" onClick="return confirm(\'Are you sure you want to delete station?\')">Remove</a></td>';
   							echo '</tr>';
   						}
   						}
   						else
   						{
   							echo '<tr>';
   							echo '<td colspan ="2"><font face="Arial" size="2"><i>No Monitoring Stations on File</i></font></td>';
   							echo '</tr>';
   						}
   						echo '</table>';
   						echo '</td></tr>';
   						
   						# DISPLAY PAGING TRANSMITTERS
   						echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><b>PAGING TRANSMITTERS</b></font></td></tr>';
   						echo '<tr><td colspan="2" align="center"><a href="'.$_SERVER['PHP_SELF'].'?action=createSys&sysType=pTransmitter&cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup#SysInfo">Add</a></td></tr>';
   						echo '<tr><td colspan="2">';
   						echo '<table border="0" align="center" cellspacing="8">';
   						if(mysql_num_rows($result15) > 0)
   						{
   							echo '<tr>';
   							echo '<td><font face="Arial" size="2"><u>' . 'Manufacturer' . '</u></font></td>';
   							echo '<td><font face="Arial" size="2"><u>' . 'Location' . '</u></font></td>';
   							echo '<td><font face="Arial" size="2"><u>' . 'Last Updated' . '</u></font></td>';
   							echo '</tr>';
   							while($row15 = @mysql_fetch_array($result15))
   							{
   								echo '<tr>';
   								echo '<td><font face="Arial" size="2">' . $row15['SystemManufacturer'] . '</font></td>';
   								echo '<td><font face="Arial" size="2">' . $row15['SystemStationLocation'] . '</font></td>';
   								echo '<td><font face="Arial" size="2">' . $row15['DateModified'] . '</font></td>';
   								echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?cust_num=' . $cust_num . '&by_cust=Lookup&sysID=' . $row15['id'] . '#SysInfo">View</a></td>';
   								echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?action=deleteSys&SysID=' . $row15['id'] . '&cust_num=' . $cust_num . '&by_cust=Lookup" onClick="return confirm(\'Are you sure you want to delete station?\')">Remove</a></td>';
   								echo '</tr>';
   							}
   						}
   						else
   						{
   							echo '<tr>';
   							echo '<td colspan ="2"><font face="Arial" size="2"><i>No Paging Transmitters on File</i></font></td>';
   							echo '</tr>';
   						}
   						echo '</table>';
   						echo '</td></tr></table>';
   					
   					echo '<tr><td colspan="2">';
   					?>
   						<table width="100%" border="0" cellpadding="0" cellspacing="0">
  							<tr>
  								<td>&nbsp;</td>
  							</tr>
  						</table>
  					<?php
  					//echo '</td></tr></table>';
   					echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" STYLE="background-image: url(\'images/invbox_back.gif\'); border: 1 ridge #CCCCCC">';
   					if(mysql_num_rows($result10) > 0)
   					{
   						echo '<tr><td colspan="5" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>File Manager</b></font></td></tr>';
   						while($row10 = mysql_fetch_array($result10))
   						{
   							if($row10['fileType'] == "image/jpeg")
   							{
   							$icon = "JPG_Small.png";
   							}
   							elseif($row10['fileType'] == "image/gif")
   							{
   							$icon = "GIF_Small.png";
   							}
   							elseif($row10['fileType'] == "application/pdf")
   							{
   							$icon = "PDF_Small.png";
   							}
   							elseif($row10['fileType'] == "application/msword")
   							{
   							$icon = "DOC_Small.png";
   							}
   							elseif($row10['fileType'] == "application/vnd.ms-excel")
   							{
   							$icon = "XLSX_Small.png";
   							}
   							elseif($row10['fileType'] == "application/x-zip-compressed")
   							{
   							$icon = "ZIP_Small.png";
   							}
   							elseif($row10['fileType'] == "application/zip")
   							{
   							$icon = "ZIP_Small.png";
   							}
   							elseif($row10['fileType'] == "text/plain")
   							{
   							$icon = "LOG_Small.png";
   							}
   							echo '<tr><td width="27"><img src="images/icons/'.$icon.'" width="26" height="26" /></td>';
   							echo '<td><a href="'.$row10['location'].'"><font face="Arial" size="2">' . $row10['name'] . '</font></a></td>';
   							echo '<td><font face="Arial" size="2">'.$row10['size'].' KB</font></td>';
   							echo '<td width="128" align="center"><font face="Arial" size="2">'.$row10['timestamp'].'</font></td>';
   							echo '<td width="22"><a href="csPortal_FileManage.php?action=deleteFile&fileID=' . $row10['id'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row10['name'].'?\')"><img src="images/delete-icon_Small.png" width="15" height="15" border="0" /></a></td></tr>';
   						}
   						//echo '</table>';
   					}
   					else
   					{
   						echo '<tr><td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>File Manager</b></font></td></tr>';
   						echo '<tr><td align="center"><i>No files found</i></td></tr>';
   						//echo '</table>';
   					}
   					if(!(isset($_GET['view']) && $_GET['view'] == "print"))
  					{
   					?>
   						<tr>
								<td>&nbsp;</td>
							</tr>
  						<form method="post" action="csPortal_FileManage.php" enctype="multipart/form-data">
  						<input type="hidden" name="action" value="add" />
  						<input type="hidden" name="type" value="customer" />
  						<input type="hidden" name="cust_num" value="<?php echo $cust_num; ?>" />
  						<tr>
  							<td colspan="5"><font size="2" face="Arial"><strong>File Description:</strong></font><br /><input name="fileDesc" type="text" />
  						</tr>
  						<tr>
								<td colspan="5"><font size="2" face="Arial"><strong>File to Attach:</strong></font><br /><input name="uploadFile" size="40" type="file" /><i><?php echo ini_get('upload_max_filesize'); ?></i></td>
							</tr>
							<tr>
								<td colspan="5"><input name="submit" type="submit" value="Attach" /></td>
							</tr>
							</form>
						</table>
						<?php
						}
						
						# CUSTOMER NOTES SECTION
						?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
  						<tr>
  							<td>&nbsp;</td>
  						</tr>
  					</table>
  					<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" STYLE="background-image: url('images/invbox_back.gif'); border: 1 ridge #CCCCCC">
						<tr>
							<td colspan="2" align="center" background="images/menu_gray.gif">
								<font face="Arial" size="3"><b>Customer Notes</b></font><br />
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<font face="Arial" size="1"><strong>Legend: </strong></font>
								<img src="images/check1.gif"><font face="Arial" size="1"> Popup Enabled</font>
								<img src="images/check3.gif"><font face="Arial" size="1"> Email Enabled</font>
							</td>
						</tr>
						<tr>
							<td>
   							<table cellspacing="0" cellpadding="0" border="0" align="center">
   								<?php
   								if($num16 > 0)
   								{
   									while($row16 = mysql_fetch_array($result16))
   									{
   										if($row16['notificationPopup'] == 1 && !isset($_GET['action']) && !isset($_GET['sysID']) && !isset($_GET['view']))
   										{
   											?>
   											<script type="text/javascript">
												<!--
												window.alert("<?php echo $row16['text']; ?>");
												//-->
												</script>
   											<?php
   										}
   										?>
   										<tr>
   											<td width="10">
   												<?php
   												if($row16['notificationPopup'] == 1) {
   												?>
   													<img src="images/check1.gif">
   												<?php
   												}
   												?>
   											</td>
   											<td width="10">
   												<?php
   												if($row16['notificationPopup'] == 2) {
   												?>
   													<img src="images/check3.gif">
   												<?php
   												}
   												?>
   											</td>
   											<td width="500">
   												<font size="2" face="Arial"><?php echo $row16['text']; ?></font>
   											</td>
   											<td align="center" width="22">
   												<?php
   												if($userid == $row16['userid'] || $_SESSION['access'] > 7) {
   												?>
   												<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=deleteNote&noteID=<?php echo $row16['id']; ?>&cust_num=<?php echo $cust_num; ?>&by_cust=Lookup" onClick="return confirm('Are you sure you want to delete this note?')"><img src="images/delete-icon_Small.png" width="15" height="15" border="0" /></a>
   												<?php
   												}
   												?>
   											</td>
   										</tr>
   										<?php
   									}
   								}
   								else
   								{
   								?>
   									<tr>
   										<td align="center" colspan="4">
   											<font size="2" face="Arial"><i>No notes found</i></font>
   										</td>
   									</tr>
   								<?php
   								}
   								?>
   								<tr>
   									<td align="center" colspan="4">
   										<table>
   											<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
   											<tr>
   												<td>
   													<font size="2" face="Arial"><b>Enter Note:</b></font>
   												</td>
   												<td>
   													<font size="2" face="Arial"><b>Notification Options:</b></font>
   												</td>
   											</tr>
   											<tr>
   												<td>
   													<input name="noteText" type="text" size="45" />
   												</td>
   												<td align="center">
   													<input name="optionPopup" type="checkbox" /><font size="2" face="Arial">Popup</font>
   												</td>
   											</tr>
   											<tr>
   												<td>
   													<input type="hidden" name="cust_num" value="<?php echo $cust_num; ?>" />
   													<input type="hidden" name="action" value="createNote" />
   													<input type="submit" value="Submit" />
   												</td>
   											</tr>
   											</form>
   										</table>
   									</td>
   								</tr>
   							</table>
   						</td>
   					</tr>
   					</table>
   					<?php
   					if($_SESSION['access'] > 7) {
   					?>
	   					<table width="100%">
	   						<tr>
	   							<td align="center"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=removeCust&fid=<?php echo $cust_num; ?>">[Remove Customer]</a></td>
	   						</tr>
	   					</table>
   					<?php
   					}
   					/*
   				}
   				*/
 				}
			}
			
			if(isset($_GET['by_name']))
			{
				$sql = "SELECT Count(CustomerNumber) FROM tblFacilities WHERE FacilityName LIKE '%$f_name%' AND Active = -1";
				$rs_result = mysql_query($sql);
				$row9 = mysql_fetch_row($rs_result);
				$total_records = $row9[0];
				$total_pages = ceil($total_records / 50);
				
				echo "Page&nbsp;";
				for ($i=1; $i<=$total_pages; $i++) 
				{
            echo "<a href=".$_SERVER['PHP_SELF']."?f_name=".$f_name."&by_name=name&submit=Lookup&page=".$i.">".$i."</a> ";
				}
				if(mysql_num_rows($result5) == 0) {
					echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
					echo '<tr><td align="center"><i>' . 'No matches found' . '</i></td></tr>';
					echo '</table>';
				} else {
					echo '<table width="100%" cellspacing="" cellpadding="0" border="0" align="center">';
					echo '<tr><td width="70"><font face="Arial" size="2"><b>' . 'Number' . '</b></font></td><td><font face="Arial" size="2"><b>' . 'Facility Name' . '</b></font></td></tr>';
					while($row5 = mysql_fetch_array($result5)) {												
						echo '<tr><td><font face="Arial" size="2">' . '<a href="' . $_SERVER['PHP_SELF'] . '?ticket_num=&f_name=&cust_num=' . $row5['CustomerNumber'] . '&by_cust=Lookup">' . $row5['CustomerNumber'] . '</a></font></td><td><font face="Arial" size="2"><DIV onMouseover="ddrivetip(\'Alternate Name: ' . $row5['FacilityNameOther'] . '\', \'#EFEFEF\', 250)"; onMouseout="hideddrivetip()">' . $row5['FacilityName'] . '</div></font></td></tr>';
					}
					echo '</table>';
				}		
			}
  	}
  	Else
  	{
  		?>
  			<tr> 
    			<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Customer Information</b></font></td>
  			</tr>
  			<tr>
  				<td align="center" height="40"><font face="Arial" size="2">Click the Create button below to enter new facility information:</font></td>
    		</tr>
    		<tr>
    			<td align="center">
    				<input type="button" value="Create" onClick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?action=createNew'">
    			</td>
    		</tr>
    		<tr>
    			<td align="center" height="40"><font face="Arial" size="2">Please enter your required search criteria options below:</font></td>
    		</tr>
    		<tr>
    			<td align="center">
    				<table>
  						<tr>
								<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<td><font size="2" face="Arial"><strong>Facility Name:</strong></font><br><input name="f_name" type="text"><input type="hidden" name="by_name" value="name"></td>
								<td valign="bottom"><input name="submit" type="submit" value="Lookup"></td></tr></form>
								<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<td><font size="2" face="Arial"><strong>Customer Number:</strong></font><br><input name="cust_num" type="text"><input type="hidden" name="by_cust" value="number"></td>
								<td valign="bottom"><input name="submit" type="submit" value="Lookup"></td>
								</form>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<form method="get" action="reportFacilityInfo.php">
						<fieldset>
						<legend><b><font face="Arial" size="2">Print/Export Reports</font></b></legend>
							<table cellspacing="3" cellpadding="0" border="0">
								<tr>
									<td>
										<input type="checkbox" name="custNum" /><font face="Arial" size="2">Customer Number</font>
									</td>
									<td>
										<input type="checkbox" name="facName" checked="checked" /><font face="Arial" size="2">Facility Name</font>
									</td>
									<td>
										<input type="checkbox" name="facAddress" /><font face="Arial" size="2">Facility Address</font>
									</td>
									<td>
										<input type="checkbox" name="corpInfo" /><font face="Arial" size="2">Corporate Information</font>
									</td>
								</tr>
								<tr>
									<td>
										<input type="checkbox" name="sysType" /><font face="Arial" size="2">System Type</font>
									</td>
									<td>
										<input type="checkbox" name="saleRep" /><font face="Arial" size="2">Sales Rep.</font>
									</td>
									<td>
										<input type="checkbox" name="saleSrc" /><font face="Arial" size="2">Sale Source</font>
									</td>
									<td>
										<input type="checkbox" name="purchDate" /><font face="Arial" size="2">Date of Purchase</font>
									</td>
								</tr>
								<tr>
									<td>
										<input type="checkbox" name="lastActivity" /><font face="Arial" size="2">Last Activity</font>
									</td>
								</tr>
							</table>
							<table cellspacing="3" cellpadding="0" border="0">
								<tr>
									<td>
										<font face="Arial" size="2"><b>Choose One of the Following:</b></font>
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" name="outType" value="print" /><font face="Arial" size="2">Print</font>
										<input type="radio" name="outType" value="export" /><font face="Arial" size="2">Export</font>
									</td>
								</tr>
								<tr>
								<td>
									<input type="submit" name="submit" value="Run" />
								</td>
							</tr>
							</table>
						</fieldset>
						</form>
					</td>
				</tr>
		<?php
  	}
 		?>
  		</table>
  	</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
 		<td>
			<?php
		if((isset($_GET['view']) && ($_GET['view'] == "print")))
		{
			include 'includes/db_close.inc.php';
		?>
		<td>&nbsp;</td>
		<?php
		}
		else
		{
		
include_once 'rightPane.php';
}
?>
    </td>
    <?php
		/*************************** COLUMN RIGHT END ***************************/
		?>
  </tr>
	<?php
	/***************************** FOOTER START *****************************/
	?>
	<tr>
		<td colspan="2">
			<?php include_once ("./footer.php"); ?>
		</td>
	</tr>
	<?php
	/****************************** FOOTER END ******************************/
	?>
</table>
</body>
</html>