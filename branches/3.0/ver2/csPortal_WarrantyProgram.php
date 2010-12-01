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

	$name = $_SESSION['displayname'];
	$email=$_SESSION['mail'];

	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	include 'includes/functions.inc.php';
	
	if(isset($_GET['msgID']))
	{
		$sysMsg = $portalMsg[$_GET['msgID']][$lang];
	}
	
	$message = $portalMsg[10][$lang] . " $name!";
	
	$query = "SELECT warr_prog FROM employees WHERE email='$email'";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$access = $row['warr_prog'];
	
	if(isset($_POST['action']))
	{
		$custNum = $_POST['cust_num'];
		$packageType = $_POST['packageType'];
		$startDate = $_POST['startDate'];
		$duration = $_POST['duration'];
		$endDate = date('Y-m-d', strtotime("+".$duration." year", strtotime($startDate)));
		$wmbuCount = $_POST['wmbuCount'];
		$wmuCount = $_POST['wmuCount'];
		$outwmuCount = $_POST['outwmuCount'];
		$outwmduCount = $_POST['outwmduCount'];
		$wmduCount = $_POST['wmduCount'];
		$pwCount = $_POST['pwCount'];
		$cbCount = $_POST['cbCount'];
		$ptCount = $_POST['ptCount'];
		$pcCount = $_POST['pcCount'];
		$fduCount = $_POST['fduCount'];
		$utCount = $_POST['utCount'];
		$compCount = $_POST['compCount'];
		$pcCount = $_POST['pcCount'];
		$pageBase = $_POST['pageBase'];
		$pageCount = $_POST['pageCount'];
		$pagerType = $_POST['pagerType'];
		$cpsCount = $_POST['cpsCount'];
		$lightCount = $_POST['lightCount'];
		$cordCount = $_POST['cordCount'];
		if($_POST['action'] == "newEnrollment")
		{
		$query4 = "INSERT INTO warrantyinfo (FacilityID, Package, TotalWMBU, TotalWMUs, TotalWMDU, TotalWatches, TotalPanicButtons, TotalPullCords,
							TotalCallCords, TotalCPS, TotalOutWMU, TotalOutWMDU, TotalHFCorridorLights, pageBase, PagerQuantity, pagerType, TotalFallUnits,
							UTs, TotalPullTags, TotalClientStations, StartDate, EndDate) VALUES ('$custNum', '$packageType', '$wmbuCount', 
							'$wmuCount', '$wmduCount', '$pwCount', '$cbCount', '$pcCount', '$cordCount', '$cpsCount', '$outwmuCount', '$outwmduCount',
							'$lightCount', '$pageBase', '$pageCount', '$pagerType', '$fduCount', '$utCount', '$ptCount', '$compCount',
							'$startDate', '$endDate')";
		}
		elseif($_POST['action'] == "updateEnrollment")
		{
		$query4 = "UPDATE warrantyinfo SET Package='$packageType', TotalWMBU='$wmbuCount', TotalWMUs='$wmuCount',
							TotalWMDU='$wmduCount', TotalWatches='$pwCount', TotalPanicButtons='$cbCount',
							TotalPullCords='$pcCount', TotalCallCords='$cordCount', TotalCPS='$cpsCount',
							TotalOutWMU='$outwmuCount', TotalOutWMDU='$outwmduCount', TotalHFCorridorLights='$lightCount', pageBase='$pageBase',
							PagerQuantity='$pageCount', pagerType='$pagerType', TotalFallUnits='$fduCount',
							UTs='$utCount', TotalPullTags='$ptCount', TotalClientStations='$compCount',
							StartDate='$startDate', EndDate='$endDate' WHERE FacilityID = '$custNum' LIMIT 1";
		}
		$result4 = mysql_query($query4) or die(mysql_error());
		if($result4)
		{
			die(header("Location: ".$_SERVER['PHP_SELF']."?cust_num=".$custNum."&msgID=0"));
		}
		else
		{
			$sysMsg = mysql_error();
		}
	}
	
	if(isset($_GET['cust_num']))
	{
		$custNum = $_GET['cust_num'];
		$curDate = date('Y-m-d');
		$query5 = "SELECT id FROM warrantyinfo WHERE FacilityID = '$custNum' && Package = '0'";
		$result5 = mysql_query($query5);
		$num5 = mysql_num_rows($result5);
		$query2 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$custNum'";
		$result2 = mysql_query($query2);
		$count2 = mysql_num_rows($result2);
		$row2 = mysql_fetch_array($result2);
		if($count2 > 0)
		{
			$query3 = "SELECT * FROM warrantyinfo WHERE FacilityID = '$custNum'";
			$result3 = mysql_query($query3);
			$count3 = mysql_num_rows($result3);
			$row3 = mysql_fetch_array($result3);
		}
	}
	else
	{
		die("No customer information selected");
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Customer Information</title>
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
	<table cellspacing="0" cellpadding="0" border="0" width="650" align="center">
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
			<table cellspacing="0" cellpadding="0" border="0" width="100%" align="left">
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;" width="330">
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
						  			<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'"; height="36" alt="Click to go to Netcom homepage."></a></td>
						  			<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'"; height="36" alt="Click to go to Sales homepage."></a></td>
						  			<td><a href="csPortal_Support.php"><img src="images/Support_ButtonActive.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonActive.gif'"; height="36" alt="Click for customer support options."></a></td>								
						  			<?php
						  			if($_SESSION['access'] >= 7)
						  			{
											echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonOff.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonOff.gif'\";\" height=\"36\" alt=\"Netcom's company administration portal.\"></a></td>";
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
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Facilities.php" style="font-size:10px;font-family: verdana;">CUSTOMER INFO</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_Tickets.php" style="font-size:10px;font-family: verdana;">SUPPORT TICKETS</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csPortal_UpsTrack.php" style="font-size:10px;font-family: verdana;">SHIPMENT TRACKING</a></td>
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

<?php
if((isset($_GET['view']) && ($_GET['view'] == "print")))
{
?>
<table align="center" width="650" border="0" bgcolor="#FFFFFF">
<?php
}
else
{
?>
<table align="center" width="759" border="0" bgcolor="#FFFFFF">
<?php
}
?>
	<tr valign="top">
		<?php
  	/************************** COLUMN LEFT START *************************/
  	if((isset($_GET['view']) && ($_GET['view'] == "print")))
		{
		?>
			<td width="100%">
		<?php
		}
		else
		{
		?>
			<td width="550">
		<?php
		}
		?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
  	<td width="100%" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Ensure Program Enrollment</b></font></td>
  </tr>
  <tr>
  	<td>
  		<b><i><font face="Arial" size="2" color="Red"><?php echo $sysMsg; ?></font></b></i>
  	</td>
  </tr>
	<?php
  if(!(isset($_GET['view']) && $_GET['view'] == "print"))
  {
  ?>
  <tr>
  	<td align="center">
  		<a href="javascript:void(0)"onclick="window.open('csPortal_WarrantyProgram.php?cust_num=<?php echo $row2['CustomerNumber']; ?>&view=print','system','width=600,height=750,scrollbars=yes')"><font face="Arial" size="2">Print</font></a>
  	</td>
  </tr>
  <?php
	}
	else
	{
	?>
	<script language="Javascript1.2">
	<!--
		window.print();
	//-->
	</script>
	<?php
	}
	?>
  <tr>
  	<td>
  		<fieldset>
			<legend><b><font face="Arial" size="2">Account Details</font></b></legend>
  			<table border="0" cellpadding="0" cellspacing="4">
  				<tr>
  					<td>
  						<font face="Arial" size="2"><?php echo $row2['CustomerNumber']; ?></font><br />
  						<font face="Arial" size="2"><?php echo $row2['FacilityName']; ?></font><br />
  						<font face="Arial" size="2"><?php echo $row2['StreetAddress']; ?></font><br />
  						<font face="Arial" size="2"><?php echo $row2['City'] . ', ' . $row2['StateOrProvinceCode'] . ' ' . $row2['PostalCode']; ?></font><br />
						</td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
	
	<?php
  if(($count3 < 1) && (!isset($_GET['action'])))
	{
	?>
	<tr>
		<td align="center">
			<fieldset>
			<legend><b><font face="Arial" size="2">Program Details</font></b></legend>
				<font face="Arial" size="2" color="red"><b>This customer is not currently enrolled in program.</b></font>
			</fieldset>
		</td>
	</tr>
	<tr>
  	<td align="center">
  	<input type="button" value="Enroll" onClick="window.location='<?php echo $_SERVER['PHP_SELF'] . '?action=enroll&cust_num=' . $custNum; ?>'">
  	</td>
  </tr>
  <?php
  }
	
	if((isset($_GET['action']) && ($access > 0)) || ($count3 > 0))
  {
  ?>
  <tr>
  	<td>
  		<?php
  		if($num5 == '0' || isset($_GET['action']))
  		{
  		?>
  		<fieldset>
			<legend><b><font face="Arial" size="2">Program Details</font></b></legend>
				<?php
  			if(isset($_GET['action']))
  			{
  			?>
				<form name="prgmDetails" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" name="cust_num" value="<?php echo $custNum; ?>" />
				<?php
				}
				?>
  			<table align="center" border="0" cellpadding="0" cellspacing="8">
  				<?php
  				if($count3 > 0)
  				{
  				?>
  				<tr>
  					<td colspan="3">
  						<font face="Arial" size="2"><b>Contract Number: </b><?php echo $row3['id']; ?></font><br />
  					</td>
  				</tr>
  				<?php
  				}
  				?>
  				<tr>
  					<td>
  						<font face="Arial" size="2"><u>Package</u></font><br />
  						<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<select name="packageType">
								<option value="Basic" <?php if($row3['Package'] == "Basic"){ echo 'selected="selected"'; } ?>>Basic</option>
								<option value="Advantage" <?php if($row3['Package'] == "Advantage"){ echo 'selected="selected"'; } ?>>Advantage</option>
								<option value="Select" <?php if($row3['Package'] == "Select"){ echo 'selected="selected"'; } ?>>Select</option>
								<option value="Premium" <?php if($row3['Package'] == "Premium"){ echo 'selected="selected"'; } ?>>Premium</option>
							</select>
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['Package']; ?></font>
							<?php
							}
							?>
						</td>
						<td>
							<font size="2" face="Arial"><u>Start Date:</u></font><br />
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
    					<INPUT TYPE="text" NAME="startDate" VALUE="<?php echo $row3['StartDate']; ?>" SIZE=10 onClick="cal.select(document.forms['prgmDetails'].startDate,'anchor1','yyyy-MM-dd'); return false;" NAME="anchor1" ID="anchor1" />
    					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
          		<SCRIPT LANGUAGE="JavaScript">
       	  			var cal = new CalendarPopup();
     					</SCRIPT>
     					<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['StartDate']; ?></font>
							<?php
							}
							?>
						</td>
						<td>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{ 
  						$EndDate = strtotime($row3['EndDate']);
  						$StartDate = strtotime($row3['StartDate']);
  						$durSec = $EndDate - $StartDate;
  						$durYear = floor($durSec/31536000);
  						?>
  						<font face="Arial" size="2"><u>Duration</u></font><br />
							<select name="duration">
								<option value="1" <?php if($durYear == 1){ echo 'selected="selected"'; } ?>>1 Year</option>
								<option value="2" <?php if($durYear == 2){ echo 'selected="selected"'; } ?>>2 Years</option>
								<option value="3" <?php if($durYear == 3){ echo 'selected="selected"'; } ?>>3 Years</option>
								<option value="4" <?php if($durYear == 4){ echo 'selected="selected"'; } ?>>4 Years</option>
								<option value="5" <?php if($durYear == 5){ echo 'selected="selected"'; } ?>>5 Years</option>
							</select>
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><u>End Date:</u></font><br />
							<font face="Arial" size="2" <?php if($curDate > $row3['EndDate']) { echo 'color="red"'; } ?>><?php echo $row3['EndDate']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
				</table>
				<?php
  			if($count3 > 0)
  			{
  			?>
				<table align="center" border="0" cellpadding="0" cellspacing="0">
  				<?php
  				if($row3['Package'] == "Basic")
  				{
  				?>
  				<tr>
  					<td>
  						<font face="Arial" size="2"><b><u>Included Services</u></b></font><br />
  						<dl>
							<dt><font face="Arial" size="2">Phone Technical Support (Monday - Friday, 7AM - 7PM CST)</dt>
							<dd><font face="Arial" size="2" color="#666666">Our dedicated team of technical support specialists will take as much time as needed to answer your
									questions, help with daily routines, and do anything they can to assist you.</font></dd>
							<dt><font face="Arial" size="2">Remote System Diagnostics</font></dt>
							<dd><font face="Arial" size="2" color="#666666">All our systems can be diagnosed remotely. Over 95% of all technical issues can be being resolved this way.
									Customers will need to provide us with a dedicated phone line or to connect the system over the Internet for fast and
									accurate diagnostics.</font></dd>
							<dt><font face="Arial" size="2">Software Updates</font></dt>
							<dd><font face="Arial" size="2" color="#666666">HomeFree's technical team will update your system with the latest version of our software, so you can 
									benefit from the continuous advancements in our resident monitoring technology.</font></dd>
							</dl>
  					</td>
  				</tr>
  				<?php
  				}
  				elseif($row3['Package'] == "Advantage")
  				{
  				?>
  				<tr>
  					<td>
  						<font face="Arial" size="2"><b><u>Included Services</u></b></font><br />
  						<dl>
							<dt><font face="Arial" size="2">Phone Technical Support (Monday - Friday, 7AM - 7PM CST)</dt>
							<dd><font face="Arial" size="2" color="#666666">Our dedicated team of technical support specialists will take as much time as needed to answer your
									questions, help with daily routines, and do anything they can to assist you.</font></dd>
							<dt><font face="Arial" size="2">After Hours Phone Technical Support - 24/7</dt>
							<dd><font face="Arial" size="2" color="#666666">All after hours calls will be answered promptly by an answering service that will make sure a technical
									support specialist will call back within a short period of time.</font></dd>
							<dt><font face="Arial" size="2">Remote System Diagnostics</font></dt>
							<dd><font face="Arial" size="2" color="#666666">All our systems can be diagnosed remotely. Over 95% of all technical issues can be being resolved this way.
									Customers will need to provide us with a dedicated phone line or to connect the system over the Internet for fast and
									accurate diagnostics.</font></dd>
							<dt><font face="Arial" size="2">Software Updates</font></dt>
							<dd><font face="Arial" size="2" color="#666666">HomeFree's technical team will update your system with the latest version of our software, so you can 
									benefit from the continuous advancements in our resident monitoring technology.</font></dd>
							</dl>
  					</td>
  				</tr>
  				<?php
  				}
  				elseif($row3['Package'] == "Select")
  				{
  				?>
  				<tr>
  					<td>
  						<font face="Arial" size="2"><b><u>Included Services</u></b></font><br />
  						<dl>
							<dt><font face="Arial" size="2">Phone Technical Support (Monday - Friday, 7AM - 7PM CST)</dt>
							<dd><font face="Arial" size="2" color="#666666">Our dedicated team of technical support specialists will take as much time as needed to answer your
									questions, help with daily routines, and do anything they can to assist you.</font></dd>
							<dt><font face="Arial" size="2">After Hours Phone Technical Support - 24/7</dt>
							<dd><font face="Arial" size="2" color="#666666">All after hours calls will be answered promptly by an answering service that will make sure a technical
									support specialist will call back within a short period of time.</font></dd>
							<dt><font face="Arial" size="2">Remote System Diagnostics</font></dt>
							<dd><font face="Arial" size="2" color="#666666">All our systems can be diagnosed remotely. Over 95% of all technical issues can be being resolved this way.
									Customers will need to provide us with a dedicated phone line or to connect the system over the Internet for fast and
									accurate diagnostics.</font></dd>
							<dt><font face="Arial" size="2">Remote Staff Training</font></dt>
							<dd><font face="Arial" size="2" color="#666666">Using our remote dial-in capabilities, one of our team members can dial into your system and have a 
									one-on-one training session with your staff. Training sessions can be scheduled in advance to accommodate
									customers' schedule.</font></dd>
							<dt><font face="Arial" size="2">Annual On-Site System Check and Training</font></dt>
							<dd><font face="Arial" size="2" color="#666666">A HomeFree technical specialist will visit your site once a year to 
									recertify your system. The visit will be scheduled in advance to accommodate your schedule and needs. 
									During the visit our representative will perform the following:
									<br />• Complete system inspection and check
									<br />• Database maintenance and backup
									<br />• Staff training: on-site refresher training course will be provided for both software and product familiarity
									<br />• Update software if applicable</font></dd>
							<dt><font face="Arial" size="2">5% Product Accessories Discounts</dt>
							<dd><font face="Arial" size="2" color="#666666">Discounts will apply to all new product accessories you purchase from us during the service plan period.
									<br /><br />Product accessories are defined as the resident devices (Personal Watchers, Call Buttons, Pull Cords, Aware Units) that are currently in operation 
									at the facility</font></dd>
							<dt><font face="Arial" size="2">Periodic System Checks, Maintenance, and Database Storage</font></dt>
							<dd><font face="Arial" size="2" color="#666666">Our technical support team will remotely diagnose your system periodically, will perform necessary
									maintenance tasks, and will back up your system database to assure you have an up-to-date copy in case
									of a malfunction. We will provide you with a written report detailing all work done.</font></dd>
							<dt><font face="Arial" size="2">Software Updates</font></dt>
							<dd><font face="Arial" size="2" color="#666666">HomeFree's technical team will update your system with the latest version of our software, so you can 
									benefit from the continuous advancements in our resident monitoring technology.</font></dd>
							<dt><font face="Arial" size="2">Extended Hardware Warranty</font></dt>
							<dd><font face="Arial" size="2" color="#666666">HomeFree will warranty all network components and
									the monitoring computer. HomeFree will replace, free of charge, any of the following items in the event of a technical malfunction.
									<br />• Wireless network – Including all wireless area units, door units, and base unit.
									<br />• Monitoring Computer – Including personal computer, monitor and all peripherals.</font></dd>
							</dl>
  					</td>
  				</tr>
  				<?php
  				}
  				elseif($row3['Package'] == "Premium")
  				{
  				?>
  				<tr>
  					<td>
  						<font face="Arial" size="2"><b><u>Included Services</u></b></font><br />
  						<dl>
							<dt><font face="Arial" size="2">Phone Technical Support (Monday - Friday, 7AM - 7PM CST)</dt>
							<dd><font face="Arial" size="2" color="#666666">Our dedicated team of technical support specialists will take as much time as needed to answer your
									questions, help with daily routines, and do anything they can to assist you.</font></dd>
							<dt><font face="Arial" size="2">After Hours Phone Technical Support - 24/7</dt>
							<dd><font face="Arial" size="2" color="#666666">All after hours calls will be answered promptly by an answering service that will make sure a technical
									support specialist will call back within a short period of time.</font></dd>
							<dt><font face="Arial" size="2">Remote System Diagnostics</font></dt>
							<dd><font face="Arial" size="2" color="#666666">All our systems can be diagnosed remotely. Over 95% of all technical issues can be being resolved this way.
									Customers will need to provide us with a dedicated phone line or to connect the system over the Internet for fast and
									accurate diagnostics.</font></dd>
							<dt><font face="Arial" size="2">Remote Staff Training</font></dt>
							<dd><font face="Arial" size="2" color="#666666">Using our remote dial-in capabilities, one of our team members can dial into your system and have a 
									one-on-one training session with your staff. Training sessions can be scheduled in advance to accommodate
									customers' schedule.</font></dd>
							<dt><font face="Arial" size="2">Annual On-Site System Check and Training</font></dt>
							<dd><font face="Arial" size="2" color="#666666">A HomeFree technical specialist will visit your site once a year to 
									recertify your system. The visit will be scheduled in advance to accommodate your schedule and needs. 
									During the visit our representative will perform the following:
									<br />• Complete system inspection and check
									<br />• Database maintenance and backup
									<br />• Staff training: on-site refresher training course will be provided for both software and product familiarity
									<br />• Update software if applicable</font></dd>
							<dt><font face="Arial" size="2">5% Product Accessories Discounts</dt>
							<dd><font face="Arial" size="2" color="#666666">Discounts will apply to all new product accessories you purchase from us during the service plan period.
									<br /><br />Product accessories are defined as the resident devices (Personal Watchers, Call Buttons, Pull Cords, Aware Units) that are currently in operation 
									at the facility</font></dd>
							<dt><font face="Arial" size="2">Periodic System Checks, Maintenance, and Database Storage</font></dt>
							<dd><font face="Arial" size="2" color="#666666">Our technical support team will remotely diagnose your system periodically, will perform necessary
									maintenance tasks, and will back up your system database to assure you have an up-to-date copy in case
									of a malfunction. We will provide you with a written report detailing all work done.</font></dd>
							<dt><font face="Arial" size="2">Software Updates</font></dt>
							<dd><font face="Arial" size="2" color="#666666">HomeFree's technical team will update your system with the latest version of our software, so you can 
									benefit from the continuous advancements in our resident monitoring technology.</font></dd>
							<dt><font face="Arial" size="2">Extended Hardware Warranty</font></dt>
							<dd><font face="Arial" size="2" color="#666666">HomeFree will provide a complete warranty package covering 
									network components, the monitoring computer and ALL resident devices. HomeFree will replace, free of charge, any of the following items in the event of a technical malfunction.
									<br />• Wireless network – Including all wireless area units, door units, and base unit.
									<br />• Monitoring Computer – Including personal computer, monitor and all peripherals.
									<br />• Personal Watchers – HomeFree will provide an advance replacement for low battery or technical fault.
									<br />• Call Buttons – HomeFree will provide an advance replacement for low battery or technical fault.
									<br />• Pull Cords – HomeFree will provide an advance replacement for low battery or technical fault.
									<br />• Aware Units – HomeFree will provide an advance replacement for fall detection units that
										encounter a technical issue.</font></dd>
							</dl>
  					</td>
  				</tr>
  				<?php
  				}
  				?>
				</table>
				<?php
  			}
  			?>
			</fieldset>
			<?php
			}
			else
			{
			?>
				<fieldset>
				<legend><b><font face="Arial" size="2">Program Details</font></b></legend>
					<font face="Arial" size="2" color="red"><b>This customer is not currently enrolled in program.</b></font>
				</fieldset>
			<?php
			}
			?>
		</td>
	</tr>
	<?php
	if(($count3 > 0) && (($row3['Package'] == "Premium") || ($row3['Package'] == "Select")) || (isset($_GET['action'])))
	{
	?>
  <tr>
  	<td>
  		<fieldset>
			<legend><b><font face="Arial" size="2">Hardware Details</font></b></legend>
			<table align="center" border="0" cellpadding="0" cellspacing="8">
				<tr valign="top">
					<td>
  			<table border="0" cellpadding="0" cellspacing="4">
  				<tr>
  					<td>
  						<font face="Arial" size="2"><u>Wireless Infrastructure</u></font>
  					</td>
  				</tr>
  				<tr>
  					<td>
							<font face="Arial" size="2">WMBU: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="wmbuCount" size="4" value="<?php echo $row3['TotalWMBU']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalWMBU']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
  					<td>
							<font face="Arial" size="2">WMU: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="wmuCount" size="4" value="<?php echo $row3['TotalWMUs']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalWMUs']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<font face="Arial" size="2">Outdoor WMU: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="outwmuCount" size="4" value="<?php echo $row3['TotalOutWMU']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalOutWMU']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<font face="Arial" size="2">Outdoor WDMU: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="outwmduCount" size="4" value="<?php echo $row3['TotalOutWMDU']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalOutWMDU']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
  					<td>
							<font face="Arial" size="2">WMDU: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="wmduCount" size="4" value="<?php echo $row3['TotalWMDU']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalWMDU']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table border="0" cellpadding="0" cellspacing="4">
					<tr>
  					<td>
  						<font face="Arial" size="2"><u>Resident Transmitters</u></font>
  					</td>
  				</tr>
  				<tr>
  					<td>
							<font face="Arial" size="2">Watch: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="pwCount" size="4" value="<?php echo $row3['TotalWatches']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalWatches']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
  					<td>
							<font face="Arial" size="2">Call Button: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="cbCount" size="4" value="<?php echo $row3['TotalPanicButtons']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalPanicButtons']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<font face="Arial" size="2">Staff Assist: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="ptCount" size="4" value="<?php echo $row3['TotalPullTags']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalPullTags']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
  					<td>
							<font face="Arial" size="2">Pull Cord</font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="pcCount" size="4" value="<?php echo $row3['TotalPullCords']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalPullCords']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<font face="Arial" size="2">Fall Unit: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="fduCount" size="4" value="<?php echo $row3['TotalFallUnits']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalFallUnits']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<font face="Arial" size="2">UT: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="utCount" size="4" value="<?php echo $row3['UTs']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['UTs']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr valign="top">
			<td>
  			<table border="0" cellpadding="0" cellspacing="4">
  				<tr>
  					<td>
  						<font face="Arial" size="2"><u>Integrated Hardware</u></font>
  					</td>
  				</tr>
  				<tr>
  					<td>
							<font face="Arial" size="2">PC Stations: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="compCount" size="4" value="<?php echo $row3['TotalClientStations']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalClientStations']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
  					<td>
							<font face="Arial" size="2">Paging Base: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<select name="pageBase">
								<option value="Commtech 5W" <?php if($row3['pageBase'] == "Commtech 5W"){ echo 'selected="selected"'; } ?>>Commtech 5W</option>
								<option value="Commtech 25W" <?php if($row3['pageBase'] == "Commtech 25W"){ echo 'selected="selected"'; } ?>>Commtech 25W</option>
								<option value="Commtech 50W" <?php if($row3['pageBase'] == "Commtech 50W"){ echo 'selected="selected"'; } ?>>Commtech 50W</option>
								<option value="Commtech 100W" <?php if($row3['pageBase'] == "Commtech 100W"){ echo 'selected="selected"'; } ?>>Commtech 100W</option>
								<option value="Scope" <?php if($row3['pageBase'] == "Scope"){ echo 'selected="selected"'; } ?>>Scope</option>
							</select>
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['pageBase']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
  					<td>
							<font face="Arial" size="2">Pager Count: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="pageCount" size="4" value="<?php echo $row3['PagerQuantity']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['PagerQuantity']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<font face="Arial" size="2">Pager Type: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<select name="pagerType">
								<option value="Commtech 7900" <?php if($row3['pagerType'] == "Commtech 7900"){ echo 'selected="selected"'; } ?>>Commtech 7900</option>
								<option value="Apollo Gold" <?php if($row3['pagerType'] == "Apollo Gold"){ echo 'selected="selected"'; } ?>>Apollo Gold</option>
							</select>
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['pagerType']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table border="0" cellpadding="0" cellspacing="4">
					<tr>
  					<td>
  						<font face="Arial" size="2"><u>Misc. Hardware</u></font>
  					</td>
  				</tr>
					<tr>
						<td>
							<font face="Arial" size="2">Central Power: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="cpsCount" size="4" value="<?php echo $row3['TotalCPS']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalCPS']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<font face="Arial" size="2">Corridor Light: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="lightCount" size="4" value="<?php echo $row3['TotalHFCorridorLights']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalHFCorridorLights']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<font face="Arial" size="2">Call Cord: </font>
							<?php
  						if((isset($_GET['action']) && ($access > 0)))
  						{
  						?>
							<input type="text" name="cordCount" size="4" value="<?php echo $row3['TotalCallCords']; ?>" />
							<?php
							}
							else
							{
							?>
							<font face="Arial" size="2"><?php echo $row3['TotalCallCords']; ?></font>
							<?php
							}
							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
			</fieldset>
  	</td>
  </tr>
  <?php
  }
  ?>
  <tr>
  	<td align="center">
  		<?php
  		if((isset($_GET['action']) && $_GET['action'] == "enroll") && ($access > 0))
  		{
  		?>
  		<input type="hidden" name="action" value="newEnrollment" />
  		<input type="submit" value="Complete" />
  		<?php
			}
			elseif((isset($_GET['action']) && $_GET['action'] == "update") && ($access > 0))
			{
			?>
			<input type="hidden" name="action" value="updateEnrollment" />
			<input type="submit" value="Update" />
			<input type="button" value="Cancel" onClick="window.location='<?php echo $_SERVER['PHP_SELF'] . '?cust_num=' . $custNum; ?>'">
			<?php
			}
			elseif(($count3 > 0) && ($access > 0) && (!(isset($_GET['view']) && $_GET['view'] == "print")))
  		{
  		?>
  		<input type="button" value="Update" onClick="window.location='<?php echo $_SERVER['PHP_SELF'] . '?action=update&cust_num=' . $custNum; ?>'">
	  	<?php
	  	}
			?>
  	</td>
  	<?php
  	if(isset($_GET['action']))
  	{
  	?>
  	</form>
  	<?php
  	}
  	?>
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
			<?php
		if((isset($_GET['view']) && ($_GET['view'] == "print")))
		{
			include 'includes/db_close.inc.php';
		?>
		<td>&nbsp;</td>
		<?php
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