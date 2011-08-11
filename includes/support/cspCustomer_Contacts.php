<!-- START Customer Contacts Dashboard Module -->
<?php
include('includes/config.inc.php');
include('includes/db_connect.inc.php');
include_once('includes/functions.inc.php');
$custID = $_GET['custID'];
if(isset($custID)) {
	$qryCustContacts1 = "SELECT * FROM clients WHERE custRef = '$custID' AND active = 0";
	$rstCustContacts1 = mysql_query($qryCustContacts1) or die(mysql_error());
}
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">
				<span style="float: left;">Facility Contacts</span>
				<span style="float: right;">
					<a href="javascript:void(0);" onclick="TINY.box.show('cspUserSupport_NewContact.php',1,0,0,1,0);">
						<img src="theme/default/images/icons/add_file_icon.gif" height="14" width="14" border="0" title="Add contact" />
					</a>
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				while($rowCustContacts1 = mysql_fetch_array($rstCustContacts1)) {
					?>
					<div style="padding-bottom:5px;">
						<span style="display:inline-block; width:98%; vertical-align:top;"><?php echo $rowCustContacts1['f_name'] . " " . $rowCustContacts1['l_name'] . " <em>(" . $rowCustContacts1['position'] . ")</em>"; ?></span>
					</div>
						<?php
						if(!(is_null($rowCustContacts1['phone1']) || $rowCustContacts1['phone1'] == "")) {
							?>
							<div>
								<span style="display:inline-block; width:25%; vertical-align:top; text-align:right; float:left; padding:1px 1px 1px 10px;">Phone:</span>
								<span style="display:inline-block; width:70%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo formatPhone($rowCustContacts1['phone1']); ?></span>
							</div>
							<?php
						}
						if(!(is_null($rowCustContacts1['email']) || $rowCustContacts1['email'] == "")) {
							?>
							<div>
								<span style="display:inline-block; width:25%; vertical-align:top; text-align:right; float:left; padding:1px 1px 1px 10px;">Email:</span>
								<span style="display:inline-block; width:70%; vertical-align:top; text-align:left; float:right; padding:1px;"><?php echo $rowCustContacts1['email']; ?></span>
							</div>
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