<?php
include('includes/config.inc.php');
include('includes/db_connect.inc.php');
//include_once('includes/functions.inc.php');
$custID = $_GET['custID'];
$qryFileMngr1 = "SELECT * FROM filemanager WHERE refNumber = '$custID' && attachType = 'customer' && publish = -1 ORDER BY timestamp DESC";
$resFileMngr1 = mysql_query($qryFileMngr1) or die(mysql_error());
$numFileMngr1 = mysql_num_rows($resFileMngr1);
?>
<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">File Manager</td>
		</tr>
		<tr>
			<td>
				<?php
				if($numFileMngr1 > 0) {
					?>
					<div>
						<span style="width:55%; display:inline-block; padding:1px;"><u>Description</u></span>
						<span style="width:15%; display:inline-block; padding:1px;"><u>Size</u></span>
						<span style="width:25%; display:inline-block; padding:1px;"><u>Date Filed</u></span>
					</div>
					<?php
					while($rowFileMng1 = mysql_fetch_assoc($resFileMngr1)) {
						?>
						<div class="cspMOHighlight">
							<span style="width:55%; display:inline-block; padding:1px;"><?php echo $rowFileMngr1['name']; ?></span>
							<span style="width:15%; display:inline-block; padding:1px;"><?php echo $rowFileMngr1['size']; ?></span>
							<span style="width:25%; display:inline-block; padding:1px;"><?php echo $rowFileMngr1['timestamp']; ?></span>
						</div>
						<?php
					}
				} else {
					?>
					<div>
						<span style="width:100%; display:inline-block; padding:1px;">No files found</span>
					</div>
					<?php
				}
				?>
				<table>
					<form method="post" action="" enctype="multipart/form-data">
						<input type="hidden" name="action" value="add" />
						<input type="hidden" name="type" value="customer" />
						<input type="hidden" name="custID" value="<?php echo $custID; ?>" />
						<tr>
							<td>File Description:<br /><input name="fileDesc" type="text" />
						</tr>
						<tr>
							<td><input name="uploadFile" type="file" /></td>
						</tr>
						<tr>
							<td><input name="submit" type="submit" value="Attach" /><em>Max File Size: <?php echo ini_get('upload_max_filesize'); ?></em></td>
						</tr>
					</form>
				</table>
			</td>
		</tr>
	</table>
</div>