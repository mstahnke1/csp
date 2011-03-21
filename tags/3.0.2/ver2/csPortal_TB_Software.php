<?php
$message="";
$sysMsg="";

//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

//$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
//$url = urlencode(!empty($query) ? " $host$self?$query" : " $host$self");
$url = urlencode(!empty($query) ? " $self?$query" : " $self");

if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	mysql_query($queryLog);
	include 'includes/db_close.inc.php';
	die(header("Location: csPortal_Login.php?url=" . $url));
}
else
{
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	include 'includes/functions.inc.php';
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	
	$qryTechBinderFiles = "SELECT * FROM filemanager WHERE attachType = 'techBinder' ORDER BY name ASC";
	$rstTechBinderFiles = mysql_query($qryTechBinderFiles);
	$fileCount = mysql_num_rows($rstTechBinderFiles);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>HomeFree Systems | Technical Binder - Software</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="csPortal_Layout.css" />
<script type="text/javascript" src="includes/js/pageSelect.js"></script>
<script type="text/javascript">
	function addFile(str, divname) {
		if(str == 'add') {
			document.getElementById(divname).style.display="inline";
		}
	}
</script>
</head>

<body>
<center>
	<!-- START Table Page -->
	<table width="759" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<!-- START Table Menu -->
				<table cellspacing="0" cellpadding="0" border="0" width="100%" align="left">
					<tr>
						<td rowspan="2" valign="bottom" style="padding-bottom:1px;" width="330">
						<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tr>
									<td align="center" style="padding:0 0 6px 0; height:32px;">
										<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
											<tr>
												<td valign="bottom"><font size="2" face="Arial"><strong><?php echo $message; ?></strong>&nbsp;<a href="csPortal_Login.php?action=logout">[<?php echo $portalMsg[9][$lang]; ?>]</a></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="bottom">
							<table cellspacing="0" cellpadding="0" border="0">
								<tr>
						  		<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'";" height="36" alt="Portal Home"></a></td>
						  		<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'";" height="36" alt="Portal Sales"></a></td>
						  		<td><a href="csPortal_Support.php"><img src="images/Support_ButtonActive.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonActive.gif'";" height="36" alt="Portal Support"></a></td>								
						  		<?php
						  		if($_SESSION['access']>=7) {
									echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonOff.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonOff.gif'\";\" height=\"36\" alt=\"Portal Administration\"></a></td>";
									}
									?>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tr>
									<td><img src="images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
									<td width="100%" style="background-image: url(images/subnav-bg.gif);">
										<!-- START SUB NAV -->
										<table cellspacing="0" cellpadding="0" border="0" width="100%">
											<tr>
												<td align="center">
													<table cellspacing="0" cellpadding="0" border="0" style="height:20px;">
														<tr>
															<td>
																<table border="0" cellpadding="0" cellspacing="0" id="tablist2">
																	<tr>
																		<td style="color:#3b3d3d;font-size:10px;font-family: verdana;font-weight:bold;"><b>&nbsp;</b></td>
																		<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Facilities.php" style="font-size:10px;font-family: verdana;">CUSTOMER INFO</a></td>
																		<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
																		<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Tickets.php" style="font-size:10px;font-family: verdana;">SUPPORT TICKETS</a></td>
																		<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
																		<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_UpsTrack.php" style="font-size:10px;font-family: verdana;">SHIPMENT TRACKING</a></td>
																		<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
																		<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Notifications.php" style="font-size:10px;font-family: verdana;">NOTIFICATIONS</a></td>
																		<?php
																		if(isset($_GET['cust_num'])) {
																		?>
																			<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
																			<td style="padding-left:4px;padding-right:4px;"><a href="sales/proactivecall.php?f_id=<?php echo $custNum; ?>&view=newticketform" style="font-size:10px;font-family: verdana;">PROACTIVE CALLS</a></td>
																		<?php
																		}
																		?>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<!-- END SUB NAV -->
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<!-- END Table Menu -->
			</td>
		</tr>
		<tr>
			<td>
				<!-- START Table Body -->
				<table cellspacing="0" cellpadding="0" border="0" width="100%" align="left">
					<tr>
						<td>
							<table cellspacing="0" cellpadding="2" border="0" width="100%" align="left">
								<tr>
									<td colspan="5">&nbsp;</td>
								</tr>
								<tr>
									<td class="SectionNav">
										<a href="csPortal_TB_Main.php" class="Nav">Home</a>
									</td>
									<td class="SectionNav" background="images/menu_gray.gif">
										<a href="csPortal_TB_Software.php" class="Nav">Software</a>
									</td>
									<td class="SectionNav">
										<a href="csPortal_TB_Hardware.php" class="Nav">Hardware</a>
									</td>
									<td class="SectionNav">
										<a href="csPortal_TB_Documents.php" class="Nav">Documents</a>
									</td>
									<td width="100%">&nbsp;</td>
								</tr>
								<tr>
									<td class="SectionText" colspan="5">
										<table cellspacing="0" cellpadding="2" border="0" width="100%" align="left">
											<tr>
												<td class="BorderRight" width="50" valign="top">
													<p><b><u>Software Releases</u></b></p>
													<p>
														<?php
														if($fileCount > 0) {
															while($rowFileList = mysql_fetch_array($rstTechBinderFiles)) {
																if($rowFileList['refNumber'] == 'uploadreleases') {
																	echo '<a href="' . $rowFileList['location'] . '">Version ' .$rowFileList['name'] . '</a><br />';
																}
															}
															mysql_data_seek($rstTechBinderFiles, 0);
														} else {
															echo "No files found";
														}
														?>
													</p>
													<div id="uploadreleases" style="display: none;">
														<form method="post" action="csPortal_FileManage.php" enctype="multipart/form-data">
															<input type="hidden" name="uploadType" value="uploadreleases">
															<input type="hidden" name="action" value="add" />
  														<input type="hidden" name="type" value="techBinder" />
															Version: <input type="text" name="fileDesc"><br />
															File: <input name="uploadFile" size="40" type="file" /><i><?php echo ini_get('upload_max_filesize'); ?></i><br />
															<input type="submit" name="submit" value="Upload">
														</form>
													</div>
													<a href="#"><span onclick="javascript:addFile('add', 'uploadreleases');">ADD</span></a>
												</td>
												<td width="50" valign="top">
													<p><b><u>Software Tools</u></b></p>
													<p>
														<?php
														if($fileCount > 0) {
															while($rowFileList = mysql_fetch_array($rstTechBinderFiles)) {
																if($rowFileList['refNumber'] == 'uploadtools') {
																	echo '<a href="' . $rowFileList['location'] . '">' . $rowFileList['name'] . '</a><br />';
																}
															}
															mysql_data_seek($rstTechBinderFiles, 0);
														} else {
															echo "No files found";
														}
														?>
													</p>
													<div id="uploadtools" style="display: none;">
														<form method="post" action="csPortal_FileManage.php" enctype="multipart/form-data">
															<input type="hidden" name="uploadType" value="uploadtools" />
															<input type="hidden" name="action" value="add" />
  														<input type="hidden" name="type" value="techBinder" />
															Description: <input type="text" name="fileDesc"><br />
															File: <input name="uploadFile" size="40" type="file" /><i><?php echo ini_get('upload_max_filesize'); ?></i><br />
															<input type="submit" name="submit" value="Upload" />
														</form>
													</div>
													<a href="#"><span onclick="javascript:addFile('add', 'uploadtools');">ADD</span></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<!-- END Table Body -->
			</td>
		</tr>
		<tr>
			<td>
				<!-- START Table Footer -->
				<table cellspacing="0" cellpadding="0" border="0" width="100%" align="left">
					<tr>
						<td>
							<?php include_once ("./footer.php"); ?>
						</td>
					</tr>
				</table>
				<!-- END Table Footer -->
			</td>
		</tr>
	</table>
	<!-- END Table Page -->
</center>
</body>
</html>