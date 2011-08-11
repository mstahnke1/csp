<?php
require_once('includes/cspSessionMgmt.php');
include('includes/config.inc.php');
include_once('includes/functions.inc.php');
include('includes/db_connect.inc.php');
$companyName = cspSettingValue('12');
$agentID = $_SESSION['uid'];

$custID = $_GET['custID'];

if(isset($_POST['saveNewContact'])) {
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<head>
	<title><?php echo $companyName; ?> | CSP - Support</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="theme/default/cspDefault.css" />
	<script type="text/javascript" src="js/cb.js"></script>
	<link rel="icon" type="image/ico" href="favicon.ico" />
</head>

<body>
	<center>
		<div class="cspDashModule" style="width:400px; font:12px arial;">
			<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="cspBodyHeading">New Contact</td>
				</tr>
				<tr>
					<td>
						<form name="newContact" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div>
								<span style="display:block; width:29%; vertical-align:top; text-align:right; float:left; clear:both; padding:1px;">Ticket:</span>
								<span style="display:block; width:69%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $ticketID; ?></span>
							</div>
							<div>
								<span style="display:block; width:29%; vertical-align:top; text-align:right; float:left; blear:both; padding:1px;">Facility:</span>
								<span style="display:block; width:69%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowNewCall1['facilityName']; ?></span>
							</div>
							<div>
								<span style="display:inline-block; width:26%; line-height:24px; vertical-align:top; text-align:right; float:left; clear:both; padding:1px;">Reported By:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><input type="text" name="reportedBy" value="<?php if(isset($_GET['callID'])) { echo $contact; } else { echo $rowNewCall1['Contact']; } ?>" /></span>
							</div>
							<div>
								<span style="display:inline-block; width:26%; line-height:24px; vertical-align:top; text-align:right; float:left; padding:1px;">Contact Number:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><input type="text" name="contactNumber" value="<?php if(isset($_GET['callID'])) { echo $contactNum; } else { echo $rowNewCall1['ContactPhone']; } ?>" maxlength="10" size="10" /></span>
							</div>
							<div style="clear:both; float:right; margin-right:1px;">
								<span>
									<input type="hidden" name="custID" value="<?php echo $custID; ?>" />
									<input type="submit" name="saveNewContact" value="Start" />
								</span>
								<span><input type="button" name="cancel" value="Cancel" onClick="javascript:TINY.box.hide();" /></span>
							</div>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</center>
</body>

</html>