<?php
$message="";

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
	include 'includes/db_close.inc.php';
	die(header("Location: csPortal_Login.php?url=" . $url));
}
else
{
	if($_SESSION['access'] < 7)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Administration</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="csPortal_Layout.css" />

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
											echo '<td valign="bottom"><font size="2" face="Arial"><strong>' . $message . '</strong>&nbsp;<a href="csPortal_Login.php?action=logout">[' . $portalMsg[9][$lang] . ']</a></td>';
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
						  		<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'";" height="36" alt="Portal Home"></a></td>
						  		<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'";" height="36" alt="Sales Home"></a></td>
						  		<td><a href="csPortal_Support.php"><img src="images/Support_ButtonOff.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonOff.gif'";" height="36" alt="Support Home"></a></td>							
						  		<?php
						  		if($_SESSION['access']>=7) {
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
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csAdmin_ItInventory.php" style="font-size:10px;font-family: verdana;">IT INVENTORY</a></td>
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
    			<td width="268"></td>
  				<td width="6"></td>
  				<td width="1"></td>
  				<td width="6"></td>
  				<td width="268"></td>
  			</tr>
  			<tr>
    			<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>User Administration</b></font></td>
    			<td colspan="3" background="images/az_nav_menu_div.gif"</td>
    			<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Bulletin Administration</b></font></td>
  			</tr>
  			<tr> 
  				<?php
		  	if($_SESSION['access'] >= 7) 
		  	{
		  	?>
		    <td valign="top" width="268">
		    <img src="images/users.gif" align="left"</img><font face="Arial, Helvetica, sans-serif" size="2">
		    User Administration is done here. Update users email, access level, phone number and extensions.
		    <p align="center"><b>Click action below to proceed:</b></p>
		    <UL>
		    <LI><a href="">User Email Address</a>
		    <LI><a href="">Phone Number / Extension</a>
		    <LI><a href="">Portal Access Level</a>
		    </UL></b></font></p>
		    </td>
		    <?php
		  	}else{
		    ?>
		    <td>&nbsp;</td>
		    <?php
		  	}
		  	?>
    			<td width="6"></td>
  				<td width="1" bgcolor="#DADADA"></td>
  				<td width="6"></td>
  				<?php
		  	if($_SESSION['access'] >= 7) 
		  	{
		  	?>
		    <td valign="top" width="268">
		    <img src="images/bulletin.jpg" align="left"</img><font face="Arial, Helvetica, sans-serif" size="2">
		    Portal messaging system. Update, add or delete portal news bulletins. Also, update, add or delete HomeFree news bulletins.
		    <p align="center"><b>Click action below to proceed:</b></p>
		    <UL>
		    <LI><a href="csAdmin_Bulletins.php">Bulletin Administration</a>
		    <LI><a href="">Update HomeFree Bulletin</a>
		    </UL></b></font></p>
		    </td>
		    <?php
		  	}else{
		    ?>
		    <td>&nbsp;</td>
		    <?php
		  	}
		  	?>
  			</tr>
  			<tr>
    			<td height="21"> <div align="center">&nbsp;</div></td>
  			</tr>
  			<?php
			if($_SESSION['access'] >= 10) 
		{
		?>
  			<tr>
    			<td colspan="2" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Portal Administration</b></font></td>
    			<td bgcolor="#DADADA"></td>
    			<td colspan="2" align="center"></td>
  			</tr>
  			<tr> 
  				<td valign="top" width="268">
		    <img src="images/Repair.gif" align="left"</img><font face="Arial, Helvetica, sans-serif" size="2">
		    User Administration is done here. Update users email, access level, phone number and extensions.
		    <p align="center"><b>Click action below to proceed:</b></p>
		    <UL>
		    <LI><a href="csAdmin_ActivityLogs.php">Portal Activity Logs</a>
		    <LI><a href="csPortal_FileManage.php?action=viewTrash">File Trash Bin</a>
		    </UL></b></font></p>
		    </td>
    			<td width="6"></td>
  				<td width="1" bgcolor="#DADADA"></td>
  				<td width="6"></td>
  				<td valign="top" width="268">
		    	</td>
  			</tr>
  			<?php
		}else{
		?>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php
		}
		?>
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