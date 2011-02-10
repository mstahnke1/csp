<?php
require_once('includes/cspSessionMgmt.php');
include('includes/config.inc.php');
include_once('includes/functions.inc.php');
include('includes/db_connect.inc.php');
$companyName = cspSettingValue('12');
$custNum = "";
$facilityName = "";
$facilityNameOther = "";
$strAddress = "";
$city = "";
$state = "";
$zip = "";
$country = "US";
$phoneNum = "";
$faxNum = "";
$corpID = "";
$transType = "new";
$saleSource = 0;
$qryEmpPerms = "SELECT manageCorp FROM employees WHERE id = '$_SESSION[uid]'";
$rstEmpPerms = mysql_query($qryEmpPerms);
$rowEmpPerms = mysql_fetch_array($rstEmpPerms);

$qryCustInfo2 = "SELECT * FROM tblCorpList ORDER BY name ASC";
$resCustInfo2 = mysql_query($qryCustInfo2) or die(mysql_error());
$qryCustInfo3 = "SELECT StateOrProvinceCode, StateOrProvince FROM tblsalesrepbyterritories WHERE CountryCode = 'US'";
$resCustInfo3 = mysql_query($qryCustInfo3) or die(mysql_error());
$qryCustInfo4 = "SELECT * FROM tblcountries";
$resCustInfo4 = mysql_query($qryCustInfo4) or die(mysql_error());
$qryCustInfo6 = "SELECT * FROM distributors";
$resCustInfo6 = mysql_query($qryCustInfo6) or die(mysql_error());

if(isset($_POST['saveCustInfo'])) {
	$custNum = $_POST['custNum'];
	$facilityName = stripslashes(fix_apos("'", "''", $_POST['fName']));
	$facilityNameOther = stripslashes(fix_apos("'", "''", $_POST['fNameOther']));
	$strAddress = stripslashes(fix_apos("'", "''", $_POST['strAddress']));
	$city = stripslashes(fix_apos("'", "''", $_POST['city']));
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$country = $_POST['country'];
	$phoneNum = $_POST['phoneNum'];
	$faxNum = $_POST['faxNum'];
	$saleType = $_POST['saleType'];
	$date = date('Y-m-d H:i:s');
	if($_POST['cboCorporate'] == -1) {
		$corpID = "NULL";
	} elseif($_POST['cboCorporate'] == 0) {
		$corpName = $_POST['corpName'];
		$qryCustNew1 = "INSERT INTO tblCorpList (name) VALUES ('$corpName')";
		$resCustNew1 = mysql_query($qryCustNew1);
		if($resCustNew1) {
			$qryCustNew2 = "SELECT MAX(id) FROM tblCorpList";
			$resCustNew2 = mysql_query($qryCustNew2) or die(mysql_error());
			$rowCustNew2 = mysql_fetch_array($resCustNew2);
			$corpID = $rowCustNew2['MAX(id)'];
		} else {
			$sysMsg = urlencode(mysql_error());
			die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&sysMsg=" . $sysMsg));
		}
	} else {
		$corpID = $_POST['cboCorporate'];
	}
	if($_POST['transType'] == "new") {
		$qryCustInfo5 = "INSERT INTO tblfacilities (CustomerNumber, corpID, FacilityName, FacilityNameOther, StreetAddress, City, StateOrProvinceCode, PostalCode, CountryCode, PhoneNumber, FaxNumber, TypeOfSale, DateModified) 
										VALUES ('$custNum', $corpID, '$facilityName', '$facilityNameOther', '$strAddress', '$city', '$state', '$zip', '$country', '$phoneNum', '$faxNum', '$saleType', '$date')";
		$resCustInfo5 = mysql_query($qryCustInfo5);
		if($resCustInfo5) {
			die(header("Location: cspUserSupport_Customer.php?custID=" . $custNum));
		} else {
			$sysMsg = urlencode(mysql_error());
			die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&sysMsg=" . $sysMsg));
		}
	} elseif($_POST['transType'] == "upd") {
		$qryCustInfo5 = "UPDATE tblfacilities SET corpID = $corpID, FacilityName = '$facilityName', FacilityNameOther = '$facilityNameOther', StreetAddress = '$strAddress', City = '$city', StateOrProvinceCode = '$state', PostalCode = '$zip', CountryCode = '$country', PhoneNumber = '$phoneNum', FaxNumber = '$faxNum', TypeOfSale = '$saleType', DateModified = '$date' 
										WHERE CustomerNumber = '$custNum' LIMIT 1";
		$resCustInfo5 = mysql_query($qryCustInfo5);
		if($resCustInfo5) {
			die(header("Location: cspUserSupport_Customer.php?custID=" . $custNum));
		} else {
			$sysMsg = urlencode(mysql_error());
			die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&sysMsg=" . $sysMsg));
		}
	}
}

if(isset($_GET['custID'])) {
	$custNum = $_GET['custID'];
	$transType = "upd";
	$qryCustInfo7 = "SELECT * FROM tblFacilities WHERE CustomerNumber = '$custNum'";
	$resCustInfo7 = mysql_query($qryCustInfo7) or die(mysql_error());
	$rowCustInfo7 = mysql_fetch_assoc($resCustInfo7);
	$facilityName = $rowCustInfo7['FacilityName'];
	$facilityNameOther = $rowCustInfo7['FacilityNameOther'];
	$strAddress = $rowCustInfo7['StreetAddress'];
	$city = $rowCustInfo7['City'];
	$state = $rowCustInfo7['StateOrProvinceCode'];
	$zip = $rowCustInfo7['PostalCode'];
	$country = $rowCustInfo7['CountryCode'];;
	$phoneNum = $rowCustInfo7['PhoneNumber'];
	$faxNum = $rowCustInfo7['FaxNumber'];
	$corpID = $rowCustInfo7['corpID'];
	$saleSource = $rowCustInfo7['TypeOfSale'];
}
?>

<!-- START Update Customer Information Module -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?php echo $companyName; ?> | CSP - Support</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="theme/default/cspDefault.css" />
	<script type="text/javascript" src="js/cb.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<link rel="icon" type="image/ico" href="favicon.ico" />
	<script language="JavaScript">
		function changeElem(elemID,elemValue) {
			if(elemValue == 0) {
				/*Shows text box to enter new corporate name*/
				document.getElementById(elemID).style.display="inline-block";
			} else if(elemValue == -1) {
				/*Removes text box to enter new corporate name*/
				//alert('Corporate information will be removed.');
				document.getElementById(elemID).style.display="none";
			} else {
		  	/*alert("You are assigning to corporate ID"+elemValue);*/
		  	document.getElementById(elemID).style.display="none";
		  }
		}
	</script>
</head>

<body>
	<center>
		<div class="cspDashModule" style="width:500px; font:12px arial;">
			<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="cspBodyHeading">Customer Information</td>
				</tr>
				<tr>
					<td>
						<div style="font:12px arial;">
							<form name="custInfo" method="post" target="_top" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Customer Number:</span>
									<span style="display:inline-block; width:71%; vertical-align:top;  float:right; padding:1px;"><input type="text" name="custNum" size="5" maxlength="6" value="<?php echo $custNum; ?>" <?php if(isset($_GET['custID'])) { echo 'READONLY'; } ?> /></span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:24px; vertical-align:top; text-align:right; padding:1px;">Corporate:</span>
									<span style="display:inline-block; width:71%; vertical-align:top; float:right; padding:1px;">
										<select name="cboCorporate" onchange="javascript:changeElem('txtNewCorpName',this.value);">
											<option value="-1" <?php if($corpID == "" || is_null($corpID)){ echo 'selected="selected"'; } ?>>- None -</option>
											<?php
											if($rowEmpPerms['manageCorp'] == 1) {
												?>
												<option value="0">- New -</option>
												<?php
											}
											while($rowCustInfo2 = mysql_fetch_array($resCustInfo2)) { ?>
												<option value="<?php echo $rowCustInfo2['id']; ?>" <?php if($rowCustInfo2['id'] == $corpID){ echo 'selected="selected"'; } ?>><?php echo $rowCustInfo2['name']; ?></option>
											<?php
											}
											?>
										</select>
									</span>
								</div>
								<div id="txtNewCorpName" style="display: none; margin-left: 28%;">
									<span style="line-height:26px; padding:1px; font-weight: bold;">Enter Name:</span>
									<span style="padding:1px;"><input type="text" name="corpName" value="" /></span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Facility Name:</span>
									<span style="display:inline-block; width:71%; vertical-align:top;  float:right; padding:1px;"><input type="text" name="fName" value="<?php echo $facilityName; ?>" /></span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Alternate Name:</span>
									<span style="display:inline-block; width:71%; vertical-align:top;  float:right; padding:1px;"><input type="text" name="fNameOther" value="<?php echo $facilityNameOther; ?>" /></span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Street Address:</span>
									<span style="display:inline-block; width:71%; vertical-align:top; float:right; padding:1px;"><input type="text" name="strAddress" value="<?php echo $strAddress; ?>" /></span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">City, State:</span>
									<span style="display:inline-block; width:71%; vertical-align:top; float:right; padding:1px;"><input type="text" name="city" value="<?php echo $city; ?>" />, 
										<select name="state">
											<?php
											while($rowCustInfo3 = mysql_fetch_assoc($resCustInfo3)) {
												?>
												<option value="<?php echo $rowCustInfo3['StateOrProvinceCode']; ?>" <?php if($rowCustInfo3['StateOrProvinceCode'] == $zip){ echo 'selected="selected"'; } ?>><?php echo $rowCustInfo3['StateOrProvince']; ?></option>
												<?php
											}
											?>
										</select>
									</span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Postal Code:</span>
									<span style="display:inline-block; width:71%; vertical-align:top; float:right; padding:1px;"><input type="text" name="zip" size="9" value="<?php echo $zip; ?>" /></span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Country:</span>
									<span style="display:inline-block; width:71%; vertical-align:top; float:right; padding:1px;">
										<select name="country">
											<?php
											while($rowCustInfo4 = mysql_fetch_array($resCustInfo4)) {
												?>
												<option value="<?php echo $rowCustInfo4['CountryCode']; ?>" <?php if($rowCustInfo4['CountryCode'] == $country){ echo 'selected="selected"'; } ?>><?php echo $rowCustInfo4['Country']; ?></option>
												<?php
											}
											?>
										</select>
									</span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Source of Sale:</span>
									<span style="display:inline-block; width:71%; vertical-align:top; float:right; padding:1px;">
										<select name="saleType">
											<option value="0" <?php if((is_null($saleSource)) OR ($saleSource == 0)){ echo 'selected="selected"'; } ?>>Unknown</option>
											<?php
											while($rowCustInfo6 = mysql_fetch_array($resCustInfo6)) {
												?>
												<option value="<?php echo $rowCustInfo6['id']; ?>" <?php if($saleSource == $rowCustInfo6['id']){ echo 'selected="selected"'; } ?>><?php echo $rowCustInfo6['name']; ?></option>
												<?php
											}
											?>
										</select>
									</span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Phone Number:</span>
									<span style="display:inline-block; width:71%; vertical-align:top; float:right; padding:1px;"><input type="text" name="phoneNum" value="<?php echo $phoneNum; ?>" maxlength="10" size="10" /></span>
								</div>
								<div>
									<span style="display:inline-block; width:27%; line-height:26px; vertical-align:top; text-align:right; padding:1px;">Fax Number:</span>
									<span style="display:inline-block; width:71%; vertical-align:top; float:right; padding:1px;"><input type="text" name="faxNum" value="<?php echo $faxNum; ?>" maxlength="10" size="10" /></span>
								</div>
								<div style="clear:both; float:right; margin-right:1px;">
									<span><input type="hidden" name="transType" value="<?php echo $transType; ?>" /><input type="submit" name="saveCustInfo" value="Save" /></span>
									<span><input type="button" name="cancel" value="Cancel" onClick="javascript:window.close();" /></span>
								</div>
							</form>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</center>
</body>

<!-- END Update Customer Information Module -->

</html>