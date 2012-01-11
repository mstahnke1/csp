<?php
session_start();
if(isset($_POST['action'])) {
	include('../config.inc.php');
	include('../db_connect.inc.php');
	$custID = $_POST['custID'];
	$agentID = $_SESSION['uid'];
	$noteText = nl2br($_POST['noteText']);
	if(isset($_POST['optionPopup'])) {
		$optionPopup = 1;
	} else {
		$optionPopup = 0;
	}
	$qryNewNote = "INSERT INTO sysNotes (text, type, reference, notificationPopup, userid) 
								VALUES ('$noteText', 'customer', '$custID', $optionPopup, $agentID)";
	$resNewNote = mysql_query($qryNewNote);
	if($resNewNote) {
		$sysMsg = urlencode("Note successfully saved");
		die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&sysMsg=" . $sysMsg));
	} else {
		$sysMsg = urlencode(mysql_error());
		die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&sysMsg=" . $sysMsg));
	}
}
include('includes/config.inc.php');
include('includes/db_connect.inc.php');
$qryIntNotes1 = "SELECT * FROM sysNotes WHERE type = 'customer' AND reference = '$custID'";
$resIntNotes1 = mysql_query($qryIntNotes1) or die(mysql_error());
?>
<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">
				<span style="float: left;">Internal Notes</span>
				<span style="float: right;">
					<a href="javascript:void(0);" onclick="showDiv('newNote', '');">
						<img src="theme/default/images/icons/add_file_icon.gif" height="14" width="14" border="0" title="Add contact" />
					</a>
				</span>	
			</td>
		</tr>
		<tr>
			<td>
				<?php
				while($rowIntNotes1 = mysql_fetch_assoc($resIntNotes1)) {
					?>
					<div>
						<span>&bull;<?php echo $rowIntNotes1['text']; ?></span>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
</div>
<div id="newNote" style="display: none;">
	<table>
		<form method="post" action="includes/support/cspCustomer_InternalNotes.php"> 
		<tr>
			<td>
				<div>
					<font size="2" face="Arial"><b>Enter Note:</b></font><br />
					<input name="noteText" type="text" size="45" />
				</div>
				<div>
					<font size="2" face="Arial"><b>Notification Options:</b></font><br />
					<input name="optionPopup" type="checkbox" /><font size="2" face="Arial">Popup</font>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="custID" value="<?php echo $custID; ?>" />
				<input type="hidden" name="action" value="createNote" />
				<input type="submit" value="Save" />
			</td>
		</tr>
		</form>
	</table>
</div>