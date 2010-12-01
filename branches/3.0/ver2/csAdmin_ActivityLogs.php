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
	if($_SESSION['access'] < 10)
	{
		$user = $_SESSION['username'];
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';Unauthorized Page Access.';
		$queryLog = "INSERT INTO activity_logs (user, statement, action, agent, date, time) VALUES ('$user', '$statement', '1', '$agent', CURDATE(), CURTIME())";
		mysql_query($queryLog) or die(mysql_error());
		include 'includes/db_close.inc.php';
		die("You are attempting to access an unauthorized page.<br>Your activity has been logged");
	}
	
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	// get user permissions
	$email=$_SESSION['mail'];
	$query = "SELECT rem_logs FROM employees WHERE email='$email'";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
}

	if(isset($_GET['msgID']))
	{
		$sysMsg = $portalMsg[$_GET['msgID']][$lang];
	}

if ((isset($_GET['action'])) && ($_GET['action'] == "purge") && ($row['rem_logs'] == 0))
{
	$query4 = "UPDATE activity_logs SET active = 1";
	if(mysql_query($query4))
	{
		$user = $_SESSION['username'];
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$statement = stripslashes(fix_apos("'", "''", $query4));
		$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
		$purgeLog = mysql_query($queryLog);
		if($purgeLog)
		{
			die(header("Location: ".$_SERVER['PHP_SELF']."?msgID=0"));
		}
		else {
			$sysMsg = mysql_error();
		}
	}
}

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * 20;
$query2 = "SELECT * FROM activity_logs WHERE active=0 ORDER BY date DESC, time DESC LIMIT $start_from, 20";
$result2 = mysql_query($query2) or die(mysql_error());

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Portal Administration</title>
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

<?php
if((isset($_GET['view']) && ($_GET['view'] == "print")))
{
?>
	<table cellspacing="0" cellpadding="0" border="0" width="550" align="center">
<?php
}
else
{
?>
<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
<?php
}
?>
	<tr>
		<td>
			<?php
			if((isset($_GET['view']) && ($_GET['view'] == "print")))
			{
			?>
			<table cellspacing="0" cellpadding="0" border="0" width="550" align="left">
			<?php
			}
			else
			{
			?>
			<table cellspacing="0" cellpadding="0" border="0" width="600" align="left">
			<?php
			}
			?>
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;">
					<?php
					if((isset($_GET['view']) && ($_GET['view'] == "print")))
					{
					?>
					<img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></td>
					<?php
					}
					else
					{
					?>
					<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					<?php
					}
					?>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center" style="padding:0 0 6px 0; height:32px;">
					
									<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
										<tr>
											<?php
											if((isset($_GET['view']) && ($_GET['view'] == "print")))
											{
											?>
											<td>&nbsp;</td>
											<?php
											}
											else
											{
											echo '<td><font size="2" face="Arial"><strong>'.$message.'</strong><div align="center"><a href="csPortal_Login.php?action=logout">' . $portalMsg[9][$lang] . '</a></font></div></td>';
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
					<td valign="bottom">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
									<?php
									if((isset($_GET['view']) && ($_GET['view'] == "print")))
									{
									?>
										<td>&nbsp;</td>
									<?php
									}
									else
									{
									?>
						  			<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'";" height="36" alt="Portal Home"></a></td>
						  			<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'";" height="36" alt="Sales Home"></a></td>
						  			<td><a href="csPortal_Support.php"><img src="images/Support_ButtonOff.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonOff.gif'";" height="36" alt="Support Home"></a></td>							
						  			<?php
						  			if($_SESSION['access'] >= 7) {
										echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonActive.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonActive.gif'\";\" height=\"36\" alt=\"Portal Admin\"></a></td>";
										}
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
					<?php
					if((isset($_GET['view']) && ($_GET['view'] == "print")))
					{
					?>
						<td>&nbsp;</td>
					<?php
					}
						else
					{
					?>
					<td><img src="images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
					<?php
					}
					?>
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
													<?php
													if((isset($_GET['view']) && ($_GET['view'] == "print")))
													{
													?>
														<td>&nbsp;</td>
													<?php
													}
													else
													{
													?>
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
	<tr valign="top">
		<?php
  	/************************** COLUMN LEFT START *************************/
  	?>
		<td width="550">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="100%" height="21" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Portal Activity Logging Console</b></font></td>
  </tr>
  <tr>
  	<td width="100%" align="center">
  		<table>
  		<?php
  		echo '<tr><td align="center"><font face="Arial" size="2" color="red"><i><b>'.$sysMsg.'</b></i></font></td></tr>';
  		if(mysql_num_rows($result) > 0)
  		{
  			$sql = "SELECT COUNT(id) FROM activity_logs WHERE active=0";
				$rs_result = mysql_query($sql);
				$row9 = mysql_fetch_row($rs_result);
				$total_records = $row9[0];
				$total_pages = ceil($total_records / 20);
				
				echo "Page&nbsp;";
				for ($i=1; $i<=$total_pages; $i++) 
				{
            echo "<a href=csAdmin_ActivityLogs.php?page=".$i.">".$i."</a> ";
				}
				
				echo '<tr><td><a href="'.$_SERVER['PHP_SELF'].'?action=purge" onClick="return confirm(\'Are you sure you want to clear all logs?\')"><font face="Arial" size="2">Clear Log</font></a></td></tr>';
 				while($row2 = @mysql_fetch_array($result2))
 				{
 					echo '<tr><td><font face="Arial" size="2"><strong>' . $row2['date'] . ' ' .$row2['time'] . '</strong></font></td></tr>';
 					echo '<tr><td><font face="Arial" size="2"><strong>' . 'Statement: ' . '</strong></font></td></tr>';
 					echo '<tr><td>' . $row2['statement'] . '</td></tr>';
 					echo '<tr><td><font face="Arial" size="2"><strong>' . 'User Name: ' . '</strong></font></td></tr>';
 					echo '<tr><td>' . $row2['user'] . '</td></tr>';	
 					echo '<tr><td><font face="Arial" size="2"><strong>' . 'Action Taken: ' . '</strong></font></td></tr>';
 					if($row2['action'] == 0)
 					{
 						echo '<tr><td>Allowed</td></tr>';
 					}
 					elseif($row2['action'] == 1)
 					{
 						echo '<tr><td>Denied</td></tr>';
 					}
 					echo '<td>&nbsp;</td>';
				}
			}
			else
			{
				echo '<tr><td><font face="Arial" size="2"><i>There are no active bulletins</i></font></td></tr>';
			}
  		?>
  		</table>
  	</td>
  </tr>
</table>
</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
 		<td valign="top">
			<?php
		if((isset($_GET['view']) && ($_GET['view'] == "print")))
		{
			include 'includes/db_close.inc.php';
		}
		else
		{

include_once 'rightPane.php';
}
?>
    </td>
    <?php
		/*************************** COLUMN RIGHT END ***************************/
		?>
  </tr>
	<?php
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