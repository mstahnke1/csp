<!-- START New Call Module -->
<?php
require_once('includes/cspSessionMgmt.php');
include('includes/config.inc.php');
include_once('includes/functions.inc.php');
include('includes/db_connect.inc.php');
$companyName = cspSettingValue('12');
$agentID = $_SESSION['uid'];

if(isset($_GET['ticketID'])) {
	$ticketID = $_GET['ticketID'];
	$callType = 0;
	$curTime = date('H:i:s');
	$bgnTime = date('H:i:s', mktime(6, 45, 0, 0, 0, 0));
	$endTime = date('H:i:s', mktime(17, 15, 0, 0, 0, 0));
	$qryNewCall1 = "SELECT tblTickets.Contact, tblTickets.ContactPhone, tblFacilities.FacilityName AS facilityName 
									FROM tblTickets 
									LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
									WHERE tblTickets.ID = '$ticketID'";
	$resNewCall1 = mysql_query($qryNewCall1);
	$rowNewCall1 = mysql_fetch_assoc($resNewCall1);
	if(($curTime > $endTime) || ($curTime < $bgnTime) || (date("l")=="Saturday") || (date("l")=="Sunday")) { 
		$callType = 1; 
	}
}

if(isset($_GET['callID'])) {
	$callID = $_GET['callID'];
	$curTime = date('H:i:s');
	$qryEditCall1 = "SELECT activeCallList.*, tblTicketMessages.callType AS callType, tblTicketMessages.TicketID AS ticketID 
									FROM activeCallList 
									LEFT JOIN tblTicketMessages ON activeCallList.id = tblTicketMessages.callid 
									WHERE tblTicketMessages.callid = $callID AND msgType = 2";
	$resEditCall1 = mysql_query($qryEditCall1);
	$rowEditCall1 = mysql_fetch_assoc($resEditCall1);
	$callType = $rowEditCall1['callType'];
	$ticketID = $rowEditCall1['ticketID'];
	$contact = $rowEditCall1['contact'];
	$contactNum = $rowEditCall1['contactNum'];
	$qryNewCall1 = "SELECT tblTickets.CustomerNumber, tblFacilities.FacilityName AS facilityName 
									FROM tblTickets 
									LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
									WHERE tblTickets.ID = '$ticketID'";
	$resNewCall1 = mysql_query($qryNewCall1);
	$rowNewCall1 = mysql_fetch_assoc($resNewCall1);
	
}

if(isset($_POST['saveNewCall'])) {
	$ticketID = $_POST['ticketID'];
	$callType = $_POST['callType'];
	switch ($callType) {
		case 0:
			$callTypeDesc = "Office Hours Call Center";
			break;
		case 1:
			$callTypeDesc = "After Hours Call Center";
			break;
		case 2:
			$callTypeDesc = "Site Visit/Service Call";
			break;
		case 3:
			$callTypeDesc = "Proactive Call";
			break;
		case 4:
			$callTypeDesc = "Site Visit/Training";
			break;
	}
	$reportedBy = nl2br(stripslashes(fix_apos("'", "''", $_POST['reportedBy'])));
	$contactNumber = formatPhone($_POST['contactNumber']);
	$date = date('Y-m-d H:i:s');
	$qryNewCall2 = "INSERT INTO activeCallList (agent, ticket, contact, contactNum) 
									 VALUES ('$agentID', '$ticketID', '$reportedBy', '$contactNumber')";
	$rstNewCall2 = mysql_query($qryNewCall2);
	if($rstNewCall2) {
		$qryNewCall4 = "SELECT MAX(ID) AS callID FROM activeCallList WHERE ticket = '$ticketID'";
		$resNewCall4 = mysql_query($qryNewCall4);
		$rowNewCall4 = mysql_fetch_assoc($resNewCall4);
		$callID = $rowNewCall4['callID'];
		$callMsg = "Call ID: " . $callID . " | Call Type: " . $callTypeDesc . " | Caller: " . $reportedBy; 
		if($contactNumber != "") {
			$callMsg .= " - " . $contactNumber;
		}
		$qryNewCall3 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType, callid, callType) 
										VALUES('$ticketID', '$callMsg', '$agentID', '$date', 2, $callID, $callType)";
		$rstNewCall3 = mysql_query($qryNewCall3);
		if($rstNewCall3) {
			die(header("Location: cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_POST['editNewCall'])) {
	$callID = $_POST['callID'];
	$ticketID = $_POST['ticketID'];
	$callType = $_POST['callType'];
	switch ($callType) {
		case 0:
			$callTypeDesc = "Office Hours Call Center";
			break;
		case 1:
			$callTypeDesc = "After Hours Call Center";
			break;
		case 2:
			$callTypeDesc = "Site Visit/Service Call";
			break;
		case 3:
			$callTypeDesc = "Proactive Call";
			break;
		case 4:
			$callTypeDesc = "Site Visit/Training";
			break;
	}
	$reportedBy = nl2br(stripslashes(fix_apos("'", "''", $_POST['reportedBy'])));
	$contactNumber = formatPhone($_POST['contactNumber']);
	$date = date('Y-m-d H:i:s');
	$qryNewCall2 = "UPDATE activeCallList SET contact = '$reportedBy', contactNum = '$contactNumber'";
	$rstNewCall2 = mysql_query($qryNewCall2);
	if($rstNewCall2) {
		$callMsg = "Call ID: " . $callID . " | Call Type: " . $callTypeDesc . " | Caller: " . $reportedBy; 
		if($contactNumber != "") {
			$callMsg .= " - " . $contactNumber;
		}
		$qryNewCall3 = "UPDATE tblTicketMessages SET Message = '$callMsg', EnteredBy = '$agentID', callType = $callType 
										WHERE TicketID = $ticketID AND callid = $callID AND msgType = 2";
		$rstNewCall3 = mysql_query($qryNewCall3);
		if($rstNewCall3) {
			die(header("Location: cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
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
					<td class="cspBodyHeading">Start New Call</td>
				</tr>
				<tr>
					<td>
						<form name="newTicket" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; float:left; padding:1px;">Ticket:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $ticketID; ?></span>
							</div>
							<div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; float:left; padding:1px;">Facility:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowNewCall1['facilityName']; ?></span>
							</div>
							<div>
								<span style="display:inline-block; width:26%; line-height:20px; vertical-align:top; text-align:right; float:left; padding:1px;">Call Type:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;">
									<select name="callType">
										<option value="0" <?php if($callType == 0){ echo 'selected="selected"'; } ?>>Office Hours Call Center</option>
										<option value="1" <?php if($callType == 1){ echo 'selected="selected"'; } ?>>After Hours Call Center</option>
										<option value="2" <?php if($callType == 2){ echo 'selected="selected"'; } ?>>Site Visit/Service Call</option>
										<option value="4" <?php if($callType == 4){ echo 'selected="selected"'; } ?>>Site Visit/Training</option>
										<option value="3" <?php if($callType == 3){ echo 'selected="selected"'; } ?>>Proactive Call</option>
									</select>
								</span>
							</div>
							<div>
								<span style="display:inline-block; width:26%; line-height:24px; vertical-align:top; text-align:right; float:left; padding:1px;">Reported By:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><input type="text" name="reportedBy" value="<?php if(isset($_GET['callID'])) { echo $contact; } else { echo $rowNewCall1['Contact']; } ?>" /></span>
							</div>
							<div>
								<span style="display:inline-block; width:26%; line-height:24px; vertical-align:top; text-align:right; float:left; padding:1px;">Contact Number:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><input type="text" name="contactNumber" value="<?php if(isset($_GET['callID'])) { echo $contactNum; } else { echo $rowNewCall1['ContactPhone']; } ?>" maxlength="10" size="10" /></span>
							</div>
							<div style="clear:both; float:right; margin-right:1px;">
								<span>
									<input type="hidden" name="ticketID" value="<?php echo $ticketID; ?>" />
									<?php
									if(isset($_GET['callID'])) {
										?>
										<input type="hidden" name="callID" value="<?php echo $callID; ?>" />
										<input type="submit" name="editNewCall" value="Update" />
										<?php
									} else {
										?>
										<input type="submit" name="saveNewCall" value="Start" />
										<?php
									}
									?>
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

<?php
include 'includes/db_close.inc.php';
?>
<!-- END New Ticket Module -->

</html>