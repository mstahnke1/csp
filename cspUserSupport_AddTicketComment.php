<!-- START New Ticket Module -->
<?php
require_once('includes/cspSessionMgmt.php');
include_once('includes/config.inc.php');
include('includes/db_connect.inc.php');
require_once('includes/functions.inc.php');
$companyName = 'HomeFree';
if(isset($_GET['ticketID'])) {
	$ticketID = $_GET['ticketID'];
	$qryNewComm1 = "SELECT tblTickets.CustomerNumber, tblFacilities.FacilityName AS FacilityName 
									FROM tblTickets 
									LEFT JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber 
									WHERE tblTickets.ID = '$ticketID'";
	$rstNewComm1 = mysql_query($qryNewComm1);
	$rowNewComm1 = mysql_fetch_assoc($rstNewComm1);
}

if(isset($_POST['saveAgentComment'])) {
	$ticketID = $_POST['ticketID'];
	$agentID = $_SESSION['uid'];
	$agentComment = nl2br(stripslashes(fix_apos("'", "''", $_POST['agentComment'])));
	$date = date('Y-m-d H:i:s');
	$qryAddComment = "INSERT INTO tblTicketMessages (TicketID, Message, EnteredBy, Date, msgType) 
										VALUES('$ticketID', '$agentComment', '$agentID', '$date', 0)";
	mysql_query($qryAddComment) or die(mysql_error());
	die(header("Location: cspUserSupport_TicketDetail.php?ticketID=" . $ticketID));
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

<body onload="focus();newAgentComment.agentComment.focus();">
	<center>
		<div class="cspDashModule" style="width:500px; font:12px arial;">
			<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="cspBodyHeading">Troubleshooting/Technical Analasys Comment</td>
				</tr>
				<tr>
					<td>
						<form name="newAgentComment" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px;">Facility:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowNewComm1['FacilityName']; ?></span>
							</div>
							<div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px;">Ticket:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $ticketID; ?></span>
							</div>
							<div>
								<span style="display:inline-block; width:26%; vertical-align:top; text-align:right; padding:1px; line-height:20px;">Agent Comment:</span>
								<span style="display:inline-block; width:72%; vertical-align:top; text-align:left; float:right; padding:1px;"><textarea name="agentComment" rows="6" cols="41"></textarea></span>
							</div>
							<div style="clear:both; float:right; margin-right:1px;">
								<span><input type="hidden" name="ticketID" value="<?php echo $ticketID; ?>" /><input type="submit" name="saveAgentComment" value="Save" /></span><span><input type="button" name="cancel" value="Cancel" onClick="javascript:TINY.box.hide();" /></span>
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