<?php
require_once('includes/cspSessionMgmt.php');
include('includes/config.inc.php');
include_once('includes/functions.inc.php');
include('includes/db_connect.inc.php');
$companyName = cspSettingValue('12');
$facilityName = "";
$facilityNameOther = "";
$corpID = "";
$qryEmpPerms = "SELECT manageCorp FROM employees WHERE id = '$_SESSION[uid]'";
$rstEmpPerms = mysql_query($qryEmpPerms);
$rowEmpPerms = mysql_fetch_array($rstEmpPerms);

$qryCustInfo2 = "SELECT * FROM tblCorpList ORDER BY name ASC";
$resCustInfo2 = mysql_query($qryCustInfo2);

if(isset($_GET['saveNew'])) {
	$facilityName = stripslashes(fix_apos("'", "''", $_GET['fName']));
	$facilityNameOther = stripslashes(fix_apos("'", "''", $_GET['fNameOther']));
	$strAddress = stripslashes(fix_apos("'", "''", $_GET['strAddress']));
	$city = stripslashes(fix_apos("'", "''", $_GET['city']));
	$state = $_GET['state'];
	$zip = $_GET['zip'];
	$country = $_GET['country'];
	$phoneNum = $_GET['phoneNum'];
	$faxNum = $_GET['faxNum'];
	$saleType = $_GET['saleType'];
	$date = date('Y-m-d H:i:s');
	if($_GET['cboCorporate'] == -1) {
		$corpID = "NULL";
	} elseif($_GET['cboCorporate'] == 0) {
		$corpName = $_GET['corpName'];
		$qryCustNew1 = "INSERT INTO tblCorpList (name) VALUES ('$corpName')";
		$resCustNew1 = mysql_query($qryCustNew1) or die(mysql_error());
		if($resCustNew1) {
			$qryCustNew2 = "SELECT MAX(id) FROM tblCorpList";
			$resCustNew2 = mysql_query($qryCustNew2) or die(mysql_error());
			$rowCustNew2 = mysql_fetch_array($resCustNew2);
			$corpID = $rowCustNew['MAX(id)'];
		}
	} else {
		$corpID = $_GET['cboCorporate'];
	}
}
?>

<!-- END Update Customer Information Module -->
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
			alert('Corporate information will be removed.');
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
						<form name="custInfo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px;">Facility Name:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px"><input type="text" value="<?php echo $facilityName; ?>" /></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px;">Corporate:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px">
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
								<div id="txtNewCorpName" style="display: none;">
									<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px;">Corporate Name:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px"><input type="text" name="corpName" value="" /></span>
								</div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Reported By:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><input type="text" name="reportedBy" value="<?php echo $reportedBy; ?>" /></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Contact Number:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><input type="text" name="contactNumber" value="<?php echo $contactNumber; ?>" maxlength="10" size="10" />&nbsp;Ext:<input type="text" name="contactExt" value="<?php echo $contactExt; ?>" maxlength="5" size="5"></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Problem Description:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><textarea name="probDesc" rows="4" cols="41"><?php echo $probDesc; ?></textarea></span>
							</div>
							<div style="clear:both; float:right; margin-right:1px;">
								<?php 
								if(isset($_GET['custID'])) {
									?>
									<span><input type="hidden" name="ticketID" value="<?php echo $ticketID; ?>" /><input type="submit" name="saveUpdatesTicket" value="Save" /></span>
									<?php 
								} else {
									?>
									<span><input type="hidden" name="custID" value="<?php echo $custID; ?>" /><input type="submit" name="saveNewTicket" value="Save" /></span>
									<?php
								}
								?>
								<span><input type="button" name="cancel" value="Cancel" onClick="javascript:TINY.box.hide();" /></span>
							</div>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</center>
</body>

<!-- END Update Customer Information Module -->

</html>