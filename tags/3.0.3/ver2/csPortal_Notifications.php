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
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}

	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	
	$userEmail = $_SESSION['mail'];
	$query2 = "SELECT id FROM employees WHERE email = '$userEmail'";
	$result2 = mysql_query($query2);
	$row2 = mysql_fetch_array($result2);
	$usrID = $row2['id'];
	
	if(isset($_GET['subscription']) && $_GET['subscription'] == "remove") {
		$ntfID = $_GET['id'];
		$query5 = "DELETE FROM notifications WHERE id = '$ntfID' LIMIT 1";
		if(mysql_query($query5)) {
			if(isset($_GET['viewUsr'])) {
				die(header('Location: '.$_SERVER['PHP_SELF'].'?msgID=0&viewUsr='.$_GET['viewUsr']));
			} elseif(isset($_GET['f_id'])) {
				die(header('Location: csPortal_Facilities.php?msgID=0&by_cust=Lookup&cust_num='.$_GET['f_id']));
			} else {
				die(header('Location: '.$_SERVER['PHP_SELF'].'?msgID=0'));
			}
		}
		die(header('Location: '.$_SERVER['PHP_SELF'].'?msgID=1'));
	}
	
	if(isset($_GET['subscription']) && $_GET['subscription'] == "enroll") {
		$mntrRef = $_GET['mntrRef'];
		$usrType = $_GET['usrType'];
		if(($usrType == 2) && (isset($_GET['usrID']))) {
			$usrID = $_GET['usrID'];
		}
		$query6 = "SELECT id FROM notifications WHERE reference = '$mntrRef' AND usrID = '$usrID' AND usrType = '$usrType'";
		$result6 = mysql_query($query6);
		$num6 = mysql_num_rows($result6);
		if($num6 == 0) {
			$query5 = "INSERT INTO notifications (reference, usrType, usrID, ntfyType) VALUES ('$mntrRef', '$usrType', '$usrID', '1')";
			if(mysql_query($query5)) {
				if($usrType == 1) {
					die(header('Location: '.$_SERVER['PHP_SELF'].'?msgID=0'));
				}
				if($usrType == 2) {
					die(header('Location: csPortal_Facilities.php?msgID=0&by_cust=Lookup&cust_num='.$mntrRef));
				}
			} else {
				die(header('Location: '.$_SERVER['PHP_SELF'].'?msgID=1'));
			}
		} else {
			die(header('Location: '.$_SERVER['PHP_SELF'].'?msgID=17'));
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Monitoring and Notifications</title>
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
						  		<td><a href="csPortal_Support.php"><img src="images/Support_ButtonActive.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonActive.gif'";" height="36" alt="Support Home"></a></td>								
						  		<?php
						  		if($_SESSION['access']>=7) {
									echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonOff.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonOff.gif'\";\" height=\"36\" alt=\"Portal Admin\"></a></td>";
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
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Facilities.php" style="font-size:10px;font-family: verdana;">CUSTOMER INFO</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Tickets.php" style="font-size:10px;font-family: verdana;">SUPPORT TICKETS</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_UpsTrack.php" style="font-size:10px;font-family: verdana;">SHIPMENT TRACKING</a></td>
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
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" STYLE="background-image: url('images/invbox_back.gif'); border: 1 ridge #CCCCCC">
  			<tr>
  				<td align="center">
  					<b><i><font face="Arial" size="2" color="Red"><?php echo $sysMsg; ?></font></b></i>
  				</td>
  			</tr>
  			<tr> 
    			<td align="center" background="images/menu_gray.gif">
    				<font face="Arial" size="3"><b>Enrolled Notifications</b></font>
    			</td>
  			</tr>
  			<tr>
  				<td align="center">
  						<font face="Arial" size="1"><strong>Legend: </strong></font>
							<img src="images/check1.gif"><font face="Arial" size="1"> Popup Enabled</font>
							<img src="images/check3.gif"><font face="Arial" size="1"> Email Enabled</font>
  				</td>
  			</tr>
  			<?php
  			if((isset($_GET['viewUsr'])) && ($_SESSION['access'] == 10)) {
  				$userID = $_GET['viewUsr'];
  			} else {
  				$userID = $row2['id'];
  			}
				$query3 = "SELECT * FROM notifications WHERE usrID = '$userID' AND usrType = 1";
				$result3 = mysql_query($query3);
				$num3 = mysql_num_rows($result3);
				if($num3 > 0) {
					while($row3 = mysql_fetch_array($result3)) {
						$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$row3[reference]'";
						$result4 = mysql_query($query4);
						$row4 = mysql_fetch_array($result4);
						if($row3['ntfyType'] == 1) {
							$chkImg = 'images/check3.gif';
						}
				?>
  					<tr>
  						<td>
  							<img src="<?php echo $chkImg; ?>" />
  							<font face="Arial" size="2"><?php echo $row4['FacilityName']; ?></font>
  							<?php
  							if(isset($_GET['viewUsr'])) {
  							?>
  								<a href="<?php echo $_SERVER['PHP_SELF']; ?>?subscription=remove&id=<?php echo $row3['id']; ?>&viewUsr=<?php echo $userID; ?>" onClick="return confirm('Are you sure you want to unsubscribe to this notification?')"><img src="images/delete-icon_Smallest.png" title="Unsubscribe" border="0" /></a>
  							<?php
  							} else {
  							?>
  								<a href="<?php echo $_SERVER['PHP_SELF']; ?>?subscription=remove&id=<?php echo $row3['id']; ?>" onClick="return confirm('Are you sure you want to unsubscribe to this notification?')"><img src="images/delete-icon_Smallest.png" title="Unsubscribe" border="0" /></a>
  							<?php
  							}
  							?>
  						</td>
  					</tr>
  			<?php
  				}
  			}
  			else
  			{
  			?>
  				<tr>
  					<td>
  						<font face="Arial" size="2">No notification subscriptions found</font>
  					</td>
  				</tr>
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