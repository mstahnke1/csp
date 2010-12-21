<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- START New Ticket Module -->
<?php
include_once 'includes/config.inc.php';
include 'includes/functions.inc.php';
include 'includes/db_connect.inc.php';
$companyName = 'HomeFree';
if(isset($_GET['custID'])) {
	$custID = $_GET['custID'];
	$qryNewTicket1 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$custID'";
	$rstNewTicket1 = mysql_query($qryNewTicket1) or die(mysql_error());
	$rowNewTicket1 = mysql_fetch_array($rstNewTicket1);
}

if(isset($_POST['saveNewTicket'])) {
	$custID = $_POST['custID'];
	$reportedBy = nl2br(stripslashes(fix_apos("'", "''", $_POST['reportedBy'])));
	$contactNumber = $_POST['contactNumber'];
	$probDesc = nl2br(stripslashes(fix_apos("'", "''",$_POST['probDesc'])));
	$openedBy = '1';
	$dateOpened = date('Y-m-d H:i:s');
	$qryNewTicket2 = "INSERT INTO tblTickets (CustomerNumber, Contact, ContactPhone, Summary, OpenedBy, DateOpened) 
									 VALUES ('$custID', '$reportedBy', '$contactNumber', '$probDesc', '$openedBy', '$dateOpened')";
	$rstNewTicket2 = mysql_query($qryNewTicket2);
	if($rstNewTicket2) {
		$qryNewTicket3 = "SELECT MAX(ID) AS newTicketID FROM tblTickets WHERE CustomerNumber = '$custID' AND OpenedBy = '$openedBy'";
		$rstNewTicket3 = mysql_query($qryNewTicket3) or die(mysql_error());
		$rowNewTicket3 = mysql_fetch_array($rstNewTicket3);
		$newTicketID = $rowNewTicket3['newTicketID'];
		$qryNewTicket4 = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType)
										 VALUES('$newTicketID', 'Ticket Created', '1', '$dateOpened', 1)";
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

?>

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
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px;">Facility:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px"><?php echo $rowNewTicket1['FacilityName']; ?></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Reported By:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><input type="text" name="reportedBy" /></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Contact Number:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><input type="text" name="contactNumber" maxlength="10" size="10" /></span>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px 1px 1px 5px; line-height:25px;">Problem Description:</span><span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px 1px 0px 1px"><textarea name="probDesc" rows="4" cols="41"></textarea></span>
							</div>
							<div style="clear:both; float:right; margin-right:1px;">
								<span><input type="hidden" name="custID" value="<?php echo $custID; ?>" /><input type="submit" name="saveNewTicket" value="Save" /></span><span><input type="button" name="cancel" value="Cancel" onClick="javascript:TINY.box.hide();" /></span>
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