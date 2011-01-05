<!-- START New Ticket Module -->
<?php
require_once('includes/cspSessionMgmt.php');
include('includes/config.inc.php');
include_once('includes/functions.inc.php');
include('includes/db_connect.inc.php');
$companyName = cspSettingValue('12');
$reportedBy = "";
$contactNumber = "";
$contactExt = "";
$probDesc = "";
$agentID = $_SESSION['uid'];

if(isset($_GET['custID'])) {
	$custID = $_GET['custID'];
	$qryNewTicket1 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$custID'";
	$rstNewTicket1 = mysql_query($qryNewTicket1) or die(mysql_error());
	$rowNewTicket1 = mysql_fetch_array($rstNewTicket1);
	$facilityName = $rowNewTicket1['FacilityName'];
}

if(isset($_POST['saveNewTicket'])) {
	$custID = $_POST['custID'];
	$reportedBy = nl2br(stripslashes(fix_apos("'", "''", $_POST['reportedBy'])));
	$contactNumber = $_POST['contactNumber'];
	$contactExt = $_POST['contactExt'];
	$probDesc = nl2br(stripslashes(fix_apos("'", "''",$_POST['probDesc'])));
	$dateOpened = date('Y-m-d H:i:s');
	$qryNewTicket2 = "INSERT INTO tblTickets (CustomerNumber, Contact, ContactPhone, Extension, Summary, OpenedBy, DateOpened) 
									 VALUES ('$custID', '$reportedBy', '$contactNumber', '$contactExt', '$probDesc', '$agentID', '$dateOpened')";
	$rstNewTicket2 = mysql_query($qryNewTicket2);
	if($rstNewTicket2) {
		$qryNewTicket3 = "SELECT MAX(ID) AS newTicketID FROM tblTickets WHERE CustomerNumber = '$custID' AND OpenedBy = '$agentID'";
		$rstNewTicket3 = mysql_query($qryNewTicket3) or die(mysql_error());
		$rowNewTicket3 = mysql_fetch_array($rstNewTicket3);
		$newTicketID = $rowNewTicket3['newTicketID'];
		$qryNewTicket4 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
										 VALUES('$newTicketID', 'Ticket Created', '$agentID', '$dateOpened', 1)";
		$rstNewTicket4 = mysql_query($qryNewTicket4);
		if($rstNewTicket4) {
			die(header("Location: cspUserSupport_TicketDetail.php?ticketID=" . $newTicketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_POST['saveUpdatesTicket'])) {
	$ticketID = $_POST['ticketID'];
	$reportedBy = nl2br(stripslashes(fix_apos("'", "''", $_POST['reportedBy'])));
	$contactNumber = $_POST['contactNumber'];
	$contactExt = $_POST['contactExt'];
	$probDesc = nl2br(stripslashes(fix_apos("'", "''",$_POST['probDesc'])));
	$date = date('Y-m-d H:i:s');
	$qryNewTicket2 = "UPDATE tblTickets SET Contact = '$reportedBy', ContactPhone = '$contactNumber', Extension = '$contactExt', Summary = '$probDesc'  
									 WHERE ID = '$ticketID' LIMIT 1";
	$rstNewTicket2 = mysql_query($qryNewTicket2);
	if($rstNewTicket2) {
		$qryNewTicket4 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
										 VALUES('$ticketID', 'Problem Details Updated', '$agentID', '$date', 6)";
		$rstNewTicket4 = mysql_query($qryNewTicket4);
		if($rstNewTicket4) {
			die(header("Location: cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
		} else {
			die(mysql_error());
		}
	} else {
		die(mysql_error());
	}
}

if(isset($_GET['action']) && $_GET['action'] == "editDetails") {
	$ticketID = $_GET['ticketID'];
	$qryEditTicket1 = "SELECT tblTickets.*, tblFacilities.FacilityName AS facilityName 
										FROM tblTickets 
										LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
										WHERE tblTickets.ID = '$ticketID'";
	$rstEditTicket1 = mysql_query($qryEditTicket1) or die(mysql_error());
	$rowEditTicket1 = mysql_fetch_array($rstEditTicket1);
	$reportedBy = $rowEditTicket1['Contact'];
	$contactNumber = $rowEditTicket1['ContactPhone'];
	$contactExt = $rowEditTicket1['Extension'];
	$probDesc = strip_tags($rowEditTicket1['Summary']);
	$facilityName = $rowEditTicket1['facilityName'];
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
		<div class="cspDashModule" style="width:500px; font:12px arial;">
			<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="cspBodyHeading">Create New Ticket</td>
				</tr>
				<tr>
					<td>
						<form name="newTicket" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px;">Facility:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px"><?php echo $facilityName; ?></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Reported By:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><input type="text" name="reportedBy" value="<?php echo $reportedBy; ?>" /></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Contact Number:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><input type="text" name="contactNumber" value="<?php echo $contactNumber; ?>" maxlength="10" size="10" />&nbsp;Ext:<input type="text" name="contactExt" value="<?php echo $contactExt; ?>" maxlength="5" size="5"></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Problem Description:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><textarea name="probDesc" rows="4" cols="41"><?php echo $probDesc; ?></textarea></span>
							</div>
							<div style="clear:both; float:right; margin-right:1px;">
								<?php 
								if(isset($_GET['ticketID'])) { 
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

<?php
include 'includes/db_close.inc.php';
?>
<!-- END New Ticket Module -->

</html>