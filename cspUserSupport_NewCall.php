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
	$qryNewCall1 = "SELECT tblTickets.Contact, tblTickets.ContactPhone, tblFacilities.FacilityName AS facilityName 
									FROM tblTickets 
									LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
									WHERE ID = '$ticketID'";
	$rstNewCall1 = mysql_query($qryNewCall1) or die(mysql_error());
	$rowNewCall1 = mysql_fetch_array($rstNewCall1);
}

if(isset($_POST['saveNewCall'])) {
	$ticketID = $_POST['ticketID'];
	$reportedBy = nl2br(stripslashes(fix_apos("'", "''", $_POST['reportedBy'])));
	$contactNumber = formatPhone($_POST['contactNumber']);
	$date = date('Y-m-d H:i:s');
	$qryNewCall2 = "INSERT INTO activeCallList (agent, ticket, contact, contactNum) 
									 VALUES ('$agentID', '$ticketID', '$reportedBy', '$contactNumber')";
	$rstNewCall2 = mysql_query($qryNewCall2);
	if($rstNewCall2) {
		$callMsg = "Caller: " . $reportedBy; 
		if($contactNumber != "") {
			$callMsg .= " - " . $contactNumber;
		}
		$qryNewCall3 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
										 VALUES('$ticketID', '$callMsg', '$agentID', '$date', 2)";
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
					<td class="cspBodyHeading">Create New Ticket</td>
				</tr>
				<tr>
					<td>
						<form name="newTicket" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px;">Ticket:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px"><?php echo $ticketID; ?></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px;">Facility:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px"><?php echo $rowNewCall1['facilityName']; ?></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Reported By:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><input type="text" name="reportedBy" value="<?php echo $rowNewCall1['Contact']; ?>" /></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Contact Number:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><input type="text" name="contactNumber" value="<?php echo $rowNewCall1['ContactPhone']; ?>" maxlength="10" size="10" /></span>
							</div>
							<div style="clear:both; float:right; margin-right:1px;">
								<span><input type="hidden" name="ticketID" value="<?php echo $ticketID; ?>" /><input type="submit" name="saveNewCall" value="Start" /></span><span><input type="button" name="cancel" value="Cancel" onClick="javascript:TINY.box.hide();" /></span>
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