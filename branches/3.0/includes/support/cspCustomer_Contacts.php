<!-- START Customer Contacts Dashboard Module -->
<?php
include_once 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
include_once 'includes/functions.inc.php';
if(isset($_GET['custID'])) {
	$custID = $_GET['custID'];
	$qryCustContacts1 = "SELECT * FROM clients WHERE custRef = '$custID' AND active = 0";
	$rstCustContacts1 = mysql_query($qryCustContacts1) or die(mysql_error());
}
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Facility Contacts</td>
		</tr>
		<tr>
			<td>
				<?php
				while($rowCustContacts1 = mysql_fetch_array($rstCustContacts1)) {
					?>
					<div style="padding-bottom:5px;">
						<span style="display:inline-block; width:98%; vertical-align:top;"><?php echo $rowCustContacts1['f_name'] . " " . $rowCustContacts1['l_name'] . " <em>(" . $rowCustContacts1['position'] . ")</em>"; ?></span>
						<?php
						if(!(is_null($rowCustContacts1['phone1']) || $rowCustContacts1['phone1'] == "")) {
							?>
							<span style="display:inline-block; width:25%; vertical-align:top; text-align:right; padding:1px 1px 1px 10px;">Phone:</span><span style="display:inline-block; width:70%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px"><?php echo formatPhone($rowCustContacts1['phone1']); ?></span>
							<?php
						}
						if(!(is_null($rowCustContacts1['email']) || $rowCustContacts1['email'] == "")) {
							?>
							<span style="display:inline-block; width:25%; vertical-align:top; text-align:right; padding:1px 1px 1px 10px;">Email:</span><span style="display:inline-block; width:70%; vertical-align:top; text-align:left; float:right; padding:1px 1px 1px 1px"><?php echo $rowCustContacts1['email']; ?></span>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
</div>

<?php
include 'includes/db_close.inc.php';
?>
<!-- END Customer Contacts Dashboard Module -->