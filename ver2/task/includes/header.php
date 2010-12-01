<?php
$message="";
/*
session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	die(header("Location: /csPortal/csPortal_Login.php"));
}
else
{
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
	$name = $_SESSION['displayname'];
	$message="Hello $name!";
}
include 'includes/db_close.inc.php';
*/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Main</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="600" align="left">
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;">
					<a href="index.php"><img src="/csPortal/images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center" style="padding:0 0 6px 0; height:32px;">
					
									<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
										<tr>
											<?php
											echo '<td><font size="2" face="Arial"><strong>'.$message.'</strong><div align="center"><a href="/csPortal/csPortal_Login.php?action=logout">LOGOUT</a></div></td>';
											?>
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
						  		<td><a href="/csPortal/csPortal_Main.php"><img src="/csPortal/images/Home_ButtonOff.gif" border="0" onmouseover="this.src='/csPortal/images/Home_ButtonOver.gif'" onmouseout="this.src='/csPortal/images/Home_ButtonOff.gif'";" height="36" alt="Click to go to Netcom homepage."></a></td>
						  		<td><a href="/csPortal/csPortal_Sales.php"><img src="/csPortal/images/Sales_ButtonActive.gif" border="0" onmouseover="this.src='/csPortal/images/Sales_ButtonOver.gif'" onmouseout="this.src='/csPortal/images/Sales_ButtonActive.gif'";" height="36" alt="Click to go to Sales homepage."></a></td>
						  		<td><a href="/csPortal/csPortal_Support.php"><img src="/csPortal/images/Support_ButtonOff.gif" border="0" onmouseover="this.src='/csPortal/images/Support_ButtonOver.gif'" onmouseout="this.src='/csPortal/images/Support_ButtonOff.gif'";" height="36" alt="Click for customer support options."></a></td>								
						  		<?php
						  		//if($_SESSION['access'] >= 7) {
									//echo "<td><a href=\"csAdmin_Main.php\"><img src=\"/csPortal/images/csAdmin_ButtonOff.gif\" border=\"0\" onmouseover=\"this.src='/csPortal/images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='/csPortal/images/csAdmin_ButtonOff.gif'\";\" height=\"36\" alt=\"Netcom's company administration portal.\"></a></td>";
									//}
									?>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<td><img src="/csPortal/images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
					<td width="100%" style="background-image: url(/csPortal/images/subnav-bg.gif);">

		<!-- sub nav -->
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="right">
									<table cellspacing="0" cellpadding="0" border="0" style="height:20px;">
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="0" id="tablist2">
													<tr>
														<td style="color:#3b3d3d;font-size:10px;font-family: verdana;font-weight:bold;"><b>&nbsp;</b></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="" style="font-size:10px;font-family: verdana;"></a></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>