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

include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
include 'includes/functions.inc.php';

if(isset($_GET['msgID']))
{
	$sysMsg = $portalMsg[$_GET['msgID']][$lang];
}

if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	die(header("Location: csPortal_Login.php?url=" . $url));
}
else
{
	if($_SESSION['access'] < 10)
	{
		$user = $_SESSION['username'];
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';Unauthorized Page Access.';
		$queryLog = "INSERT INTO activity_logs (user, statement, action, agent, date, time) VALUES ('$user', '$statement', '1', '$agent', CURDATE(), CURTIME())";
		mysql_query($queryLog) or die(mysql_error());
		include 'includes/db_close.inc.php';
		die("You are not authorized.<br>Your activity has been logged");
	}
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	
	// get user permissions
	$email=$_SESSION['mail'];
	$query = "SELECT upd_users, rem_users FROM employees WHERE email='$email'";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	// List matching users from database
	if(isset($_GET['submit']))
	{
		$search = $_GET['search'];
		$accesslvl = $_SESSION['access'];
		if($accesslvl == 10)
		{
			$query2 = "SELECT id, f_name, l_name FROM employees WHERE f_name LIKE '%$search%' AND access <= $accesslvl AND Active = 0 ORDER BY l_name ASC";
		}
		else
		{
			$query2 = "SELECT id, f_name, l_name FROM employees WHERE f_name LIKE '%$search%' AND access < $accesslvl AND Active = 0 ORDER BY l_name ASC";
		}
		$result2 = mysql_query($query2) or die('Error retrieving Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
	}
	
	if((isset($_GET['action'])) && ($_GET['action'] == "update"))
	{
		$userid = $_GET['userid'];
		$query3 = "SELECT * FROM employees WHERE id = $userid";
		$result3 = mysql_query($query3) or die('Error retrieving Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
		$row3 = mysql_fetch_array($result3);
	}
	
	// save general information to db
	if(isset($_GET['save_gen']))
	{
		$userid = $_GET['userid'];
		$f_name = $_GET['f_name'];
		$l_name = $_GET['l_name'];
		$mobile = $_GET['mobile'];
		$ext_num = $_GET['ext_num'];
		$query4 = "UPDATE employees SET f_name = '$f_name', l_name = '$l_name', mobile = '$mobile', ext_num = '$ext_num' WHERE id = $userid";
		if(mysql_query($query4))
		{
			$user = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = stripslashes(fix_apos("'", "''", $query4));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog);
			die(header("Location: ".$_SERVER['PHP_SELF']."?msgID=0"));
		}
		else
		{
			$sysMsg = $portalMsg[1][$lang];
		}
	}
		
	// save portal permissions to db
	if(isset($_GET['save_perm']))
	{
		$userid = $_GET['userid'];
		$access = $_GET['access'];
		$dept = $_GET['dept'];
		if(isset($_GET['assignTmpDpt'])) {
			$tmpDept = $_GET['cboTmpDept'];
			$activateDate = $_GET['activateDate'];
			$tmpDeptDays = $_GET['tmpDuration'];
		} else {
			$tmpDept = '0';
			$activateDate = 'NULL';
			$tmpDeptDays = 'NULL';
		}
		$recFloorplan = $_GET['recFloorplan'];
		$recEsc = $_GET['recEsc'];
		$manageRMA = $_GET['manageRMA'];
		$recRma = $_GET['recRma'];
		$warr_prog = $_GET['warr_prog'];
		$corp_mngmt = $_GET['corp_mngmt'];
		$add_bulletin = $_GET['add_bulletin'];
		$upd_bulletin = $_GET['upd_bulletin'];
		$rem_bulletin = $_GET['rem_bulletin'];
		$rem_logs = $_GET['rem_logs'];
		$upd_users = $_GET['upd_users'];
		$rem_users = $_GET['rem_users'];
		$query4 = "UPDATE employees SET access = '$access', dept = '$dept', tmpDept = '$tmpDept', ";
		if(isset($_GET['assignTmpDpt'])) {
			$query4 .= "tmpDeptStartDate = '$activateDate', tmpDeptDays = '$tmpDeptDays', ";
		} else {
			$query4 .= "tmpDeptStartDate = $activateDate, tmpDeptDays = $tmpDeptDays, ";
		}
		$query4 .= "add_bulletin = '$add_bulletin', upd_bulletin = '$upd_bulletin', rem_bulletin = '$rem_bulletin', rem_logs = '$rem_logs', upd_users = '$upd_users', rem_users = '$rem_users', warr_prog = '$warr_prog', recFloorplan = '$recFloorplan', recEscTicket = '$recEsc', recRmaEmail = '$recRma', manageRma = '$manageRMA', manageCorp = '$corp_mngmt' WHERE id = $userid";
		if(mysql_query($query4))
		{
			$user = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = stripslashes(fix_apos("'", "''", $query4));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog);
			die(header("Location: ".$_SERVER['PHP_SELF']."?msgID=0"));
		}
		else
		{
			//$sysMsg = $portalMsg[1][$lang];
			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_GET['save_sys']))
	{
		$userid = $_GET['userid'];
		$sysID = $_GET['sysid'];
		$manufacturer = $_GET['manufacturer'];
		$model = $_GET['model'];
		$serial = $_GET['serial'];
		$vpnUser = $_GET['vpnUser'];
		$vpnPass = $_GET['vpnPass'];
		$date = date('Y-m-d H:i:s');
		$query6 = "UPDATE tblcustsysteminfo SET systemType = 'Employee', SystemManufacturer = '$manufacturer', SystemModelNumber = '$model', SystemSerialNumber = '$serial', VpnUsername = '$vpnUser', VpnPassword = '$vpnPass', extReference = '$userid', DateModified = '$date' WHERE id = '$sysID' LIMIT 1";
		if(mysql_query($query6))
		{
			$user = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = stripslashes(fix_apos("'", "''", $query6));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog);
			die(header("Location: ".$_SERVER['PHP_SELF']."?msgID=0"));
		}
		else
		{
			$sysMsg = $portalMsg[1][$lang];
		}
	}
	
	if(isset($_GET['save_sysNew']))
	{
		$userid = $_GET['userid'];
		$manufacturer = $_GET['manufacturer'];
		$model = $_GET['model'];
		$serial = $_GET['serial'];
		$vpnUser = $_GET['vpnUser'];
		$vpnPass = $_GET['vpnPass'];
		$date = date('Y-m-d H:i:s');
		$query6 = "INSERT INTO tblcustsysteminfo (systemType, SystemManufacturer, SystemModelNumber, SystemSerialNumber, VpnUsername, VpnPassword, extReference, DateModified)
							VALUES ('Employee', '$manufacturer', '$model', '$serial', '$vpnUser', '$vpnPass', '$userid', '$date')";
		if(mysql_query($query6))
		{
			$user = $_SESSION['username'];
			$agent = $_SERVER['HTTP_USER_AGENT'];
			$statement = stripslashes(fix_apos("'", "''", $query6));
			$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
			mysql_query($queryLog);
			die(header("Location: ".$_SERVER['PHP_SELF']."?msgID=0"));
		}
		else
		{
			$sysMsg = $portalMsg[1][$lang];
			//$sysMsg = mysql_error();
		}
	}
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - User Administration</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">

<style type="text/css">
#dhtmltooltip{
position: absolute;
width: 150px;
border: 2px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}
</style>
<?php
if((isset($_GET['action'])) && ($_GET['action'] == "update"))
{
?>
	<script type="text/javascript">
		function showSection(str, section) {
			var chkFormNum = "frmPortalPerms";
			var disFormNum = "divTmpDept";
			if(document.forms[chkFormNum].assignTmpDpt.checked==true) {
				document.getElementById(disFormNum).style.display="inline";
			}
			if(document.forms[chkFormNum].assignTmpDpt.checked==false) {
				var auth = confirm("Are you sure you would like to disable tempory dept. assignment?")
				if(auth) {
					document.getElementById(disFormNum).style.display="none";
				} else {
					window.location.reload()
				}
			}
		}
	</script>
<?php
}
?>
</head>
<body>

<div id="dhtmltooltip"></div>

<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

</script>

<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="600" align="left">
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;">
					<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center" style="padding:0 0 6px 0; height:32px;">
									<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
										<tr>
											<?php
											echo '<td><font size="2" face="Arial"><strong>'.$message.'</strong><div align="center"><a href="csPortal_Login.php?action=logout">' . $portalMsg[9][$lang] . '</a></div></td>';
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
						  		<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'";" height="36" alt="Click to go to Netcom homepage."></a></td>
						  		<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'";" height="36" alt="Click to go to Sales homepage."></a></td>
						  		<td><a href="csPortal_Support.php"><img src="images/Support_ButtonOff.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonOff.gif'";" height="36" alt="Click for customer support options."></a></td>								
						  		<?php
						  		if($_SESSION['access'] >= 7) {
									echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonActive.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonActive.gif'\";\" height=\"36\" alt=\"Netcom's company administration portal.\"></a></td>";
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
														<td style="padding-left:4px;padding-right:4px;"><a href="csAdmin_Users.php" style="font-size:10px;font-family: verdana;">USER ADMIN</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csAdmin_Bulletins.php" style="font-size:10px;font-family: verdana;">BULLETIN ADMIN</a></td>
														<?php
														if($_SESSION['access'] >= 10) 
														{
														?>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="" style="font-size:10px;font-family: verdana;">PORTAL ADMIN</a></td>
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
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table align="center" width="759" border="0" bgcolor="#FFFFFF">
	<?php
  /************************** COLUMN LEFT START *************************/
  ?>
	<tr valign="top">
		<td width="550">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
    			<td height="21" colspan="5"> <div align="center">&nbsp;</div></td>
  			</tr>
  			<tr>
  				<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>User Administration</b></font></td>
  			</tr>
  			<tr>
  	<td align="center" height="40"><font face="Arial" size="2">Please enter your required search criteria options below:</font></td>
  </tr>
  <tr>
  	<td>
  				<div align="center"><font face="Arial" size="2" color="red"><i><b><?php echo $sysMsg; ?></b></i></font></div>
  				<table>
  					<tr>
							<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<td><font size="2" face="Arial"><strong>User Name:</strong></font><br><input name="search" type="text"></td>
							<td valign="bottom"><input name="submit" type="submit" value="Lookup"></td>
							</form>
						</tr>
					</table>
					<?php
					if(isset($_GET['submit']))
					{
					?>
						<div align="center">
							<hr width="25%">
							<font face="Arial" size="3"><b>Search Results</b></font>
						</div>
						<table height="50" cellspacing="0" border="0">
  						<tr>
								<td valign="top"><font face="Arial" size="2"><b><u>Employees:</u></b></font></td><td>&nbsp;</td></tr>
								<?php
								while($row2 = @mysql_fetch_array($result2))
								{
								$empID = $row2['id'];
								$query5 = "SELECT * FROM tblcustsysteminfo WHERE extReference = '$empID' && systemType = 'Employee'";
								$result5 = mysql_query($query5);
								?>
								<tr><td bgcolor="#DADADA"><font face="Arial" size="2"><?php echo $row2['l_name'].', '.$row2['f_name']; ?></font></td><td bgcolor="#DADADA"><font face="Arial" size="2"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=update&userid=<?php echo $row2['id']; ?>">Update</a></font></td></tr>
								<tr>
									<td colspan="2">
										<table border="0" cellspacing="5" cellpadding="0">
											<?php
											if(mysql_num_rows($result5) > 0)
											{
												while($row5 = @mysql_fetch_array($result5))
												{
												?>
													<tr align="center">
														<td width="10">
															&nbsp;
														</td>
														<td>
															<font size="2" face="Arial"><u>Manufacturer</u></font>
														</td>
														<td>
															<font size="2" face="Arial"><u>Model</u></font>
														</td>
														<td>
															<font size="2" face="Arial"><u>Serial Number</u></font>
														</td>
														<td>
															<font size="2" face="Arial"><u>VPN Username</u></font>
														</td>
														<td>
															<font size="2" face="Arial"><u>VPN Password</u></font>
														</td>
													</tr>
													<tr align="center">
														<td width="5">
															&nbsp;
														</td>
														<td>
															<font size="2" face="Arial"><?php echo $row5['SystemManufacturer']; ?></font>
														</td>
														<td>
															<font size="2" face="Arial"><?php echo $row5['SystemModelNumber']; ?></font>
														</td>
														<td>
															<a href="http://support.dell.com/support/topics/global.aspx/support/my_systems_info/details?c=us&l=en&~tab=2&servicetag=<?php echo $row5['SystemSerialNumber']; ?>" target="blank"><font size="2" face="Arial"><?php echo $row5['SystemSerialNumber']; ?></font></a>
														</td>
														<td>
															<font size="2" face="Arial"><?php echo $row5['VpnUsername']; ?></font>
														</td>
														<td>
															<font size="2" face="Arial"><?php echo $row5['VpnPassword']; ?></font>
														</td>
													</tr>
												<?php
												}
											}
											else
											{
												echo '<tr><td width="5">&nbsp;</td>';
												echo '<td><font face="Arial" size="2"><i>No System Information Found';
											}
											?>
										</table>
										<table align="center">
											<tr>
												<td>
													<?php
													$query7 = "SELECT id FROM notifications WHERE usrType = 1 AND usrID = '$empID'";
													$result7 = mysql_query($query7);
													$num7 = mysql_num_rows($result7);
													?>
													<font size="2" face="Arial">User has <?php echo $num7; ?> active monitoring notification(s). <a href="csPortal_Notifications.php?viewUsr=<?php echo $empID; ?>">VIEW</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<?php
								}
								?>
							</tr>
						</table>
					<?php
					}
					if((isset($_GET['action'])) && ($_GET['action'] == "update"))
					{
					?>
						<div align="center">
							<hr width="25%">
						<font face="Arial" size="3"><b>Update Employee:&nbsp;<?php echo $row3['f_name'].' '.$row3['l_name']; ?></b></font>
						</div>
						<table height="50" cellspacing="5" width="100%">
  						<tr>
  							<td valign="top"><font face="Arial" size="2"><b><u>General Information:</u></b></font></td>
  							<td>&nbsp;</td>
  						</tr>
  						<tr>
  							<td>
  								<table>
  									<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  									<tr>
  										<input type="hidden" name="userid" value="<?php echo $row3['id']; ?>">
											<td valign="bottom"><font face="Arial" size="2"><b>First Name:</b></font><br><input type="text" name="f_name" value="<?php echo $row3['f_name']; ?>"></td>
											<td valign="bottom"><font face="Arial" size="2"><b>Last Name:</b></font><br><input type="text" name="l_name" value="<?php echo $row3['l_name']; ?>"></td>
										</tr>
									</table>
									<table>
  									<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>Mobile:</b></font><br><input type="text" name="mobile" size="10" maxlength="10" value="<?php echo $row3['mobile']; ?>"></td>
											<td valign="bottom"><font face="Arial" size="2"><b>Extension:</b></font><br><input type="text" name="ext_num" size="5" maxlength="3" value="<?php echo $row3['ext_num']; ?>"></td>
										</tr>
										<tr>
											<td><input type="submit" name="save_gen" value="Update"></td>
										</tr>
										</form>
									</table>
								</td>
							</tr>
							<tr>
  							<td>&nbsp;</td>
  						</tr>
							<tr>
  							<td valign="top"><font face="Arial" size="2"><b><u>Portal Permissions:</u></b></font></td>
  							<td>&nbsp;</td>
  						</tr>
  						<tr>
  							<td>
  								<table>
  									<form method="get" name="frmPortalPerms" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  									<input type="hidden" name="userid" value="<?php echo $row3['id']; ?>">
  									<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Department Assignment</b></font></legend>
													<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
						          		<SCRIPT LANGUAGE="JavaScript">
						       	  			var cal = new CalendarPopup();
						     					</SCRIPT>
													<select name="dept">
														<option value="0" <?php if($row3['dept'] == 0){ echo 'selected="selected"'; } ?>>Undefined</option>
														<option value="1" <?php if($row3['dept'] == 1){ echo 'selected="selected"'; } ?>>Sales</option>
														<option value="2" <?php if($row3['dept'] == 2){ echo 'selected="selected"'; } ?>>Support</option>
														<option value="4" <?php if($row3['dept'] == 4){ echo 'selected="selected"'; } ?>>Customer Service</option>
														<option value="5" <?php if($row3['dept'] == 5){ echo 'selected="selected"'; } ?>>Shipping & Receiving</option>
														<option value="3" <?php if($row3['dept'] == 3){ echo 'selected="selected"'; } ?>>Human Resources</option>
													</select>
													<p>
														<input type="checkbox" <?php if($row3['tmpDept'] != 0){ echo 'checked'; } ?> name="assignTmpDpt" id="assignTmpDept" onchange="showSection(this.value, 'divTmpDept')" /><font face="Arial" size="2">Assign Temp Dept.</font><br />
														<div id="divTmpDept" style="display: <?php if($row3['tmpDept'] != 0){ echo 'inline'; } else { echo 'none'; } ?>;">
															<select name="cboTmpDept">
																<option value="0" <?php if($row3['tmpDept'] == 0){ echo 'selected="selected"'; } ?>>Not Active</option>
																<option value="1" <?php if($row3['tmpDept'] == 1){ echo 'selected="selected"'; } ?>>Sales</option>
																<option value="2" <?php if($row3['tmpDept'] == 2){ echo 'selected="selected"'; } ?>>Support</option>
																<option value="4" <?php if($row3['tmpDept'] == 4){ echo 'selected="selected"'; } ?>>Customer Service</option>
																<option value="5" <?php if($row3['tmpDept'] == 5){ echo 'selected="selected"'; } ?>>Shipping & Receiving</option>
																<option value="3" <?php if($row3['tmpDept'] == 3){ echo 'selected="selected"'; } ?>>Human Resources</option>
															</select>
															<br />
															<font size="2" face="Arial">Start Date:</font>
								    					<INPUT TYPE="text" NAME="activateDate" id="activateDate" VALUE="<?php echo $row3['tmpDeptStartDate']; ?>" SIZE="10" />
								    					<A HREF="#" onClick="cal.select(document.forms['frmPortalPerms'].activateDate,'anchor1','yyyy-MM-dd'); return false;" NAME="anchor1" ID="anchor1"><img src="images/calendar_icon.png" border="0" alt="Select" /></a><br />
								    					<font size="2" face="Arial">Duration <i>(In days)</i>:</font>
								    					<input type="text" name="tmpDuration" value="<?php echo $row3['tmpDeptDays']; ?>" size="10" />
														</div>
													</p>
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Floorplan Notification</b></font></legend>
													<select name="recFloorplan">
													<option value="0" <?php if($row3['recFloorplan'] == 0){ echo 'selected="selected"'; } ?>>Not Active</option>
													<option value="1" <?php if($row3['recFloorplan'] == 1){ echo 'selected="selected"'; } ?>>Active</option>
												</select>
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Ticket Escalation Notification</b></font></legend>
													<select name="recEsc">
													<option value="0" <?php if($row3['recEscTicket'] == 0){ echo 'selected="selected"'; } ?>>Not Active</option>
													<option value="1" <?php if($row3['recEscTicket'] == 1){ echo 'selected="selected"'; } ?>>Active</option>
												</select>
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Manager RMA Repairs</b></font></legend>
													<select name="manageRMA">
													<option value="0" <?php if($row3['manageRma'] == 0){ echo 'selected="selected"'; } ?>>Not Active</option>
													<option value="1" <?php if($row3['manageRma'] == 1){ echo 'selected="selected"'; } ?>>Active</option>
												</select>
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Sales RMA Notification</b></font></legend>
													<select name="recRma">
													<option value="0" <?php if($row3['recRmaEmail'] == 0){ echo 'selected="selected"'; } ?>>Not Active</option>
													<option value="1" <?php if($row3['recRmaEmail'] == 1){ echo 'selected="selected"'; } ?>>Active</option>
												</select>
												</fieldset>
											</td>
										</tr>
  									<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Access Level</b></font></legend>
												<font face="Arial" size="2">Level </font><input type="text" name="access" size="2" maxlength="2" value="<?php echo $row3['access']; ?>">
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Plug-In Management</b></font></legend>
												<font face="Arial" size="2">Ensure Management </font><input type="text" name="warr_prog" size="2" maxlength="2" value="<?php echo $row3['warr_prog']; ?>"><br />
												<font face="Arial" size="2">Corporate Management </font><input type="text" name="corp_mngmt" size="2" maxlength="2" value="<?php echo $row3['manageCorp']; ?>">
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Bulletin Administration</b></font></legend>
												<font face="Arial" size="2">Create </font><input type="text" name="add_bulletin" size="2" maxlength="1" value="<?php echo $row3['add_bulletin']; ?>">
												<font face="Arial" size="2">Update </font><input type="text" name="upd_bulletin" size="2" maxlength="1" value="<?php echo $row3['upd_bulletin']; ?>">
												<font face="Arial" size="2">Delete </font><input type="text" name="rem_bulletin" size="2" maxlength="1" value="<?php echo $row3['rem_bulletin']; ?>">
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>Activity Log Administration</b></font></legend>
												<font face="Arial" size="2">Delete </font><input type="text" name="rem_logs" size="2" maxlength="1" value="<?php echo $row3['rem_logs']; ?>">
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<fieldset>
												<legend><font face="Arial" size="2"><b>User Administration</b></font></legend>
												<font face="Arial" size="2">Update </font><input type="text" name="upd_users" size="2" maxlength="1" value="<?php echo $row3['upd_users']; ?>">
												<font face="Arial" size="2">Delete </font><input type="text" name="rem_users" size="2" maxlength="1" value="<?php echo $row3['rem_users']; ?>">
												</fieldset>
											</td>
										</tr>
										<tr>
											<td>
												<input type="submit" name="save_perm" value="Update">
											</td>
										</tr>
										</form>
									</table>
								</td>
							</tr>
							<tr>
  							<td valign="top"><font face="Arial" size="2"><b><u>System Information:</u></b></font></td>
  							<td>&nbsp;</td>
  						</tr>
  						<?php
  						$empID = $_GET['userid'];
							$query5 = "SELECT * FROM tblcustsysteminfo WHERE extReference = '$empID' && systemType = 'Employee'";
							$result5 = mysql_query($query5);
							$row5 = mysql_fetch_array($result5);
  						if(mysql_num_rows($result5) > 0)
  						{
  						?>
  						<tr>
  							<td>
  								<table border="0" cellspacing="0" cellpadding="0">
  									<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  									<tr>
  										<input type="hidden" name="userid" value="<?php echo $row3['id']; ?>">
  										<input type="hidden" name="sysid" value="<?php echo $row5['id']; ?>">
											<td valign="bottom"><font face="Arial" size="2"><b>Manufacturer:</b></font><br><input type="text" name="manufacturer" value="<?php echo $row5['SystemManufacturer']; ?>"></td>
										</tr>
										<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>Model:</b></font><br><input type="text" name="model" value="<?php echo $row5['SystemModelNumber']; ?>"></td>
										</tr>
  									<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>Serial Number:</b></font><br><input type="text" name="serial"  value="<?php echo $row5['SystemSerialNumber']; ?>"></td>
										</tr>
  									<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>VPN User:</b></font><br><input type="text" name="vpnUser"  value="<?php echo $row5['VpnUsername']; ?>"></td>
										</tr>
  									<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>VPN Pass:</b></font><br><input type="text" name="vpnPass"  value="<?php echo $row5['VpnPassword']; ?>"></td>
										</tr>
										<tr>
											<td><input type="submit" name="save_sys" value="Update"></td>
										</tr>
										</form>
									</table>
								</td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
  							<td>
  								<table>
  									<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  									<tr>
  										<input type="hidden" name="userid" value="<?php echo $row3['id']; ?>">
											<td valign="bottom"><font face="Arial" size="2"><b>Manufacturer:</b></font><br><input type="text" name="manufacturer" value=""></td>
										</tr>
										<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>Model:</b></font><br><input type="text" name="model" value=""></td>
										</tr>
  									<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>Serial Number:</b></font><br><input type="text" name="serial"  value=""></td>
										</tr>
  									<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>VPN User:</b></font><br><input type="text" name="vpnUser"  value=""></td>
										</tr>
  									<tr>
											<td valign="bottom"><font face="Arial" size="2"><b>VPN Pass:</b></font><br><input type="text" name="vpnPass"  value=""></td>
										</tr>
										<tr>
											<td><input type="submit" name="save_sysNew" value="Update"></td>
										</tr>
										</form>
									</table>
								</td>
							</tr>
							<?php
							}
							?>
						</table>
					<?php
					}
					?>
				</tr>
  	</td>
  </tr>
  		</table>
  	</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
  	<td>
  		<?php include_once ("./rightPane.php"); ?>
		</td>
	</tr>
	<?php
	/*************************** COLUMN RIGHT END ***************************/
	
	/***************************** FOOTER START *****************************/
	?>
	<tr>
		<td colspan="2">
			<?php include_once ("./footer.php"); ?>
		</td>
	</tr>
	<?php
	/****************************** FOOTER END ******************************/
	?>
</table>
</body>
</html>