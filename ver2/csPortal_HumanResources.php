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
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	$mail = $_SESSION['mail'];
	
	if(isset($_GET['msgID']))
	{
		$sysMsg = $portalMsg[$_GET['msgID']][$lang];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HTML>

<HEAD>
<title>HomeFree Systems | Customer Service Portal - Support Ticket Tracking</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="templateDefault.css" />
<script type="text/javascript" src="includes/js/pageSelect.js"></script>
<script language="JavaScript">
function change(secID,param)
{
  /*document.getElementById("vac_request").style.display="inline"; */
  var cVacForm = document.getElementById(secID)
  cVacForm.style.display="inline";
}
</script>

</HEAD>

<BODY>
<div class="container">
	<div class="header">
		<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
			<tr>
				<td>
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
													<td><font size="2" color="black" face="Arial"><strong><?php echo $message; ?></strong><div align="center"><a href="csPortal_Login.php?action=logout"><?php echo $portalMsg[9][$lang]; ?></a></font></div></td>
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
						  			<td><a href="csPortal_Main.php"><img src="images/Home_ButtonActive.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonActive.gif'"; height="36" alt="Click to go to Netcom homepage."></a></td>
						  			<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'"; height="36" alt="Click to go to Sales homepage."></a></td>
						  			<td><a href="csPortal_Support.php"><img src="images/Support_ButtonOff.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonOff.gif'"; height="36" alt="Click for customer support options."></a></td>								
						  			<?php
						  			if($_SESSION['access'] >= 7)
						  			{
											echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonOff.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonOff.gif'\";\" height=\"36\" alt=\"Netcom's company administration portal.\"></a></td>";
										}
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
							<td><img src="images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
							<td width="100%" style="background-image: url(images/subnav-bg.gif);">
				<!-- sub nav -->
								<table cellspacing="0" cellpadding="0" border="0" width="100%">
									<tr>
										<td align="center">
											<table cellspacing="0" cellpadding="0" border="0" style="height:20px;">
												<tr>
													<td>
														<table border="0" cellpadding="0" cellspacing="0" id="tablist2">
															<tr>
																<td style="color:#3b3d3d;font-size:10px;font-family: verdana;font-weight:bold;"><b>&nbsp;</b></td>
																<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Facilities.php" style="font-size:10px;font-family: verdana;">PERSONAL</a></td>
																<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
																<td style="padding-left:4px;padding-right:4px;"><a href="javascript:showPage('csPortal_HR_Vacation.php"><div><span onclick="javascript:showPage('csPortal_HR_Vacation.php', '');" style="font-size:10px;font-family: verdana;">VACATION</span></a></div></td>
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
				</td>
			</tr>
		</table>
	</div>
	<div class="content" align="center">
		<div id="pageData">Entering Secured Personal Information</div>
		<div id="vac_request" style="display: none">
			<table>
				<form id="requestFrm" name="requestFrm" method="post" action="csPortal_HR_Vacation.php">
					<tr>
						<td colspan="4" align="center">
							<font size="2" face="Arial"><strong>Vaction Request Form</strong></font>
						</td>
					</tr>
					<tr>
						<td width="10">
			  			<font size="2" face="Arial">Date From:</font><br>
			  			<INPUT TYPE="text" NAME="dateFrom" VALUE="" SIZE=10 />
			  		</td>
			  		<td valign="bottom">
			  			<A HREF="#" onClick="cal.select(document.forms['requestFrm'].dateFrom,'anchor1','yyyy-MM-dd'); return false;" NAME="anchor1" ID="anchor1"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
			  			<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
			        <SCRIPT LANGUAGE="JavaScript">
			     	  	var cal = new CalendarPopup();
			   			</SCRIPT>
			   		</td>
			   		<td width="10">
			   			<font size="2" face="Arial">Date To:</font><br>
			  			<INPUT TYPE="text" NAME="dateTo" VALUE="" SIZE=10 />
			  		</td>
			  		<td valign="bottom">
			  			<A HREF="#" onClick="cal.select(document.forms['requestFrm'].dateTo,'anchor2','yyyy-MM-dd'); return false;" NAME="anchor2" ID="anchor2"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
			  			<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
			        <SCRIPT LANGUAGE="JavaScript">
			     	  	var cal = new CalendarPopup();
			   			</SCRIPT>
			   		</td>
			   	</tr>
			   	<tr>
			   		<td colspan="4">
			   			<font size="2" face="Arial">Reason:</font><br>
			  			<INPUT TYPE="text" NAME="reqReason" VALUE="" SIZE="35" />
			  		</td>
			  	</tr>
			  	<tr>
			  		<td>
			  			<INPUT TYPE="button" NAME="sbmVacReq" id="sbmVacReq" VALUE="Submit" onclick="javascript:get('csPortal_HR_Vacation.php', this.parentNode);" />
			  			<INPUT TYPE="submit" NAME="sbmVacReq" id="sbmVacReq" VALUE="Submit" />
			  		</td>
			  	</tr>
			  </form>
			</table>
		</div>
	</div>
	<div class="footer">
		<?php include_once('footer.php'); ?>
	</div>
</div>
</BODY>
</HTML>