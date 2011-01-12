<?php
include('includes/config.inc.php');
include('includes/db_connect.inc.php');
include_once('includes/functions.inc.php');
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
						<span style="width:5%; display:inline-block; padding:1px;"> &nbsp;</span>
						<span style="width:60%; display:inline-block; padding:1px;"><u>Description</u></span>
						<span style="width:11%; display:inline-block; padding:1px;"><u>Size</u></span>
						<span style="width:19%; display:inline-block; padding:1px;"><u>Filed</u></span>
					</div>
					<?php
					while($rowFileMngr1 = mysql_fetch_assoc($resFileMngr1)) {
						$fileType = findexts($rowFileMngr1['location']);
						if(file_exists("theme/default/images/icons/" . $fileType . ".png")) {
							$fileImg = '<img src="theme/default/images/icons/' . $fileType . '.png" height="15" width="15" title=' . $fileType . ' />';
						} else {
							$fileImg = '<img src="theme/default/images/icons/Default.png" height="15" width="15" />';
						}
						?>
						<div class="cspMOHighlight">
							<span style="width:5%; display:inline-block; padding:1px; vertical-align:top;"><?php echo $fileImg; ?></span>
							<span style="width:60%; display:inline-block; padding:1px; vertical-align:top;"><?php echo $rowFileMngr1['name']; ?></span>
							<span style="width:11%; display:inline-block; padding:1px; vertical-align:top;"><?php echo $rowFileMngr1['size']; ?> K</span>
							<span style="width:19%; display:inline-block; padding:1px; vertical-align:top;"><?php echo date('Y-m-d', strtotime($rowFileMngr1['timestamp'])); ?></span>
						</div>
						<?php
					}
				}
				?>
				<div id="uploadFrm">
					<div class="posCenter" style="font-size: 10px;"><em>Max File Size: <?php echo ini_get('upload_max_filesize'); ?></em></div>
					<table>
						<form method="post" action="scripts/fileMgmt.php" enctype="multipart/form-data">
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
								<td><input name="submit" type="submit" value="Attach" /></td>
							</tr>
						</form>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>