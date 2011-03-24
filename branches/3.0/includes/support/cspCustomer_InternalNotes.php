<?php
include('includes/config.inc.php');
include('includes/db_connect.inc.php');
$qryIntNotes1 = "SELECT * FROM sysNotes WHERE type = 'customer' AND reference = '$custID'";
$resIntNotes1 = mysql_query($qryIntNotes1) or die(mysql_error());
?>
<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Internal Notes</td>
		</tr>
		<tr>
			<td>
				<?php
				while($rowIntNotes1 = mysql_fetch_assoc($resIntNotes1)) {
					?>
					<div>
						<span><?php echo $rowIntNotes1['text']; ?></span>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
</div>