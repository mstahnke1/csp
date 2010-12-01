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
	die(header("Location: csPortal_Login.php?url=" . $url));
}
else
{
	if($_SESSION['access'] < 5) {
		die("You are not authorized.<br>Your activity has been logged");
	}
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
}

if(isset($_GET['msgID']))
{
	$sysMsg = $portalMsg[$_GET['msgID']][$lang];
}

if(isset($_GET['track'])) {
$query3 = "SELECT DISTINCT siShipmentID, siCollectionDate FROM shipmentdata ";

foreach($_GET as $val){
  if($val != ""){
    $query3 .= "WHERE ";
    break;
  }
}

$where = array();

$dateFrom = $_GET['dateFrom'];
$dateFromUnix = strtotime($dateFrom);
if($dateFrom != ""){
  $where[] = "siCollectionDate >= '$dateFrom' ";
}

$dateTo = $_GET['dateTo'];
$dateToUnix = strtotime('+1 day',strtotime($dateTo));
if($dateTo != ""){
	$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
	$where[] = "siCollectionDate <= '$dateTo' ";
}

$ref_num = $_GET['ref_num'];
if($ref_num != ""){
  $where[] = "((pkgPackageReference1 = '$ref_num'
  || pkgPackageReference2 = '$ref_num'
  || pkgPackageReference3 = '$ref_num'
  || pkgPackageReference4 = '$ref_num'
  || pkgPackageReference5 = '$ref_num')
  && (siIsVOID !='Y'))";
}

if(!empty($where)){
  $query3 .= implode(" AND ", $where);
}
else
{
	$query3 = substr($query3, 0, -6);
}

$result3 = mysql_query($query3) or die(mysql_error());
$num_rows = mysql_num_rows($result3);

/*
if(isset($_GET['track'])) {
$order_num = $_GET['order_num'];
$query3 = "SELECT DISTINCT siShipmentID, siCollectionDate FROM shipmentdata WHERE (pkgPackageReference1 = '$order_num') OR (pkgPackageReference2 = '$order_num') OR
					(pkgPackageReference3 = '$order_num') OR (pkgPackageReference4 = '$order_num') OR (pkgPackageReference5 = '$order_num') AND siIsVOID !='Y'";
*/
}

$postal_code = 53218;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Shipment Tracking System</title>
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
											echo '<td valign="bottom"><font size="2" face="Arial"><strong>' . $message . '</strong>&nbsp;<a href="csPortal_Login.php?action=logout">[' . $portalMsg[9][$lang] . ']</a></td>';
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

<table align="center" width="759" border="0" bgcolor="#FFFFFF">
	<?php
  /************************** COLUMN LEFT START *************************/
  ?>
	<tr valign="top">
		<td width="550" valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
  			<tr> 
    			<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Shipment Tracking System</b></font></td>
  			</tr>
 				<tr>
    			<?php
    			if(!isset($_GET['track'])) {
    			echo "<td align=\"center\" height=\"40\"><font face=\"Arial\" size=\"2\">Please enter a HomeFree order number below:</font></td>";
    			}
    			?>
  			</tr>
  			<tr valign="top">
    			<td align="center">
    				<table>
  						<tr>
								<?php
								if(!isset($_GET['track'])) {
								echo "<form name=\"searchParams\" method=\"get\" action=\"$_SERVER[PHP_SELF]\">";
								echo "<td colspan=\"4\"><font size=\"2\" face=\"Arial\"><strong>Reference:</strong></font><br><input name=\"ref_num\" type=\"text\"><input type=\"hidden\" name=\"track\" value=\"YES\"></td></tr>";
								?>
							</tr>
							<tr>
								<td width="10">
   								<font size="2" face="Arial"><strong>Date From:</strong></font><br>
   								<INPUT TYPE="text" NAME="dateFrom" VALUE="" SIZE=10 />
  							</td>
  							<td valign="bottom">
  								<A HREF="#" onClick="cal.select(document.forms['searchParams'].dateFrom,'anchor1','yyyy-MM-dd'); return false;" NAME="anchor1" ID="anchor1"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
  								<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
    							<SCRIPT LANGUAGE="JavaScript">
    								var cal = new CalendarPopup();
  								</SCRIPT>
  							</td>
  							<td width="10">
  								<font size="2" face="Arial"><strong>Date To:</strong></font><br>
  								<INPUT TYPE="text" NAME="dateTo" VALUE="" SIZE=10 />
  							</td>
  							<td valign="bottom">
  								<A HREF="#" onClick="cal.select(document.forms['searchParams'].dateTo,'anchor2','yyyy-MM-dd'); return false;" NAME="anchor2" ID="anchor2"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
  								<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
    							<SCRIPT LANGUAGE="JavaScript">
      							var cal = new CalendarPopup();
  								</SCRIPT>
  							</td>
  						</tr>
  						<tr>
  							<td valign="bottom"><input name="submit" type="submit" value="Search"></td>
  						</tr>
							</form>
						</table>
						<?php
					} else {
		if(mysql_num_rows($result3) == 0) {
		echo "<td><i>No shipments found</i></td></tr></table>";
		} else {
		if($ref_num != ""){
			echo '<tr><td colspan="2" align="center"><font face="Arial" size="2">' . 'Search found ' . $num_rows . ' shipment(s) with reference to ' . $ref_num . '</font></td>';
		}
		if($dateFrom != "" AND $dateTo != ""){
			echo '<tr><td colspan="2" align="center"><font face="Arial" size="2">' . 'Search found ' . $num_rows . ' shipment(s) between ' . $dateFrom . ' and ' . $dateTo . '</font></td>';
		}
		while($row3 = @mysql_fetch_array($result3)){ 
		$siShipmentID = $row3['siShipmentID'];
		$siCollectionDate = date('Y-m-d', strtotime($row3['siCollectionDate']));
		echo '<tr>';
		echo '<td>&nbsp;</td>';
		$query = "SELECT * FROM shipmentdata WHERE siShipmentID = '$siShipmentID'";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($result);
		echo '<tr>';
		echo '<td><font face="Arial" size="2"><strong>' . 'Shipment ID: ' . '</strong></font></td>';
		echo '<td><font face="Arial" size="2">' . $row3['siShipmentID'] . '</font></td></tr>';
  	echo '</tr>';
  	echo '<tr>';
		echo '<td><font face="Arial" size="2"><strong>' . 'Date Shipped: ' . '</strong></font></td>';
		echo '<td><font face="Arial" size="2">' . $siCollectionDate . '</font></td></tr>';
  	echo '</tr>';
  	echo '<tr>';
  	echo '<td><font face="Arial" size="2"><strong>' . 'Shipment Cost: ' . '</strong></font></td>';
  	echo '<td><font face="Arial" size="2">$' . $row['siTotalShipmentCharge'] . '</font></td></tr>';
  	echo '</tr>';
		if($row['siCallTagOption']=='Y') {
		echo '<td><font face="Arial" size="2">' . '<strong>' . 'Pickup From: ' . '</strong>' . '</font></td>';
		} else {
		echo '<td><font face="Arial" size="2">' . '<strong>' . 'Ship To: ' . '</strong>' . '</font></td>';
		}
		echo '<td><font face="Arial" size="2">' . $row['stCompanyName'] . '</font></td></tr>';
		if(!is_null($row['stAttention'])) {
		echo '<td>&nbsp;</td>';
		echo '<td><font face="Arial" size="2">' . $row['stAttention'] . '</font></td></tr>';
		}
		echo '<tr>';
		echo '<td>&nbsp;</td>';
		echo '<td><font face="Arial" size="2">' . $row['stStreetAddress'] . '</font></td></tr>';
		echo '<td>&nbsp;</td>';
		echo '<td><font face="Arial" size="2">' . $row['stCity'] . ', ' . $row['stState'] . ' ' . $row['stZipCode'] . '</font></td></tr>';
		echo '<tr><td>&nbsp;</td></tr>';
		echo '<tr>';
		echo '<td><font face="Arial" size="2">' . '<strong>' . 'Service Type: ' . '</strong>' . '</font></td>';
		echo '<td><font face="Arial" size="2">' . $row['siServiceType'] . '</font></td></tr>';
		echo '<tr><td>&nbsp;</td></tr>';
		echo '<td><font face="Arial" size="2">' . '<strong>' . 'Shipment Options: ' . '</strong>' . '</font></td>';
		if($row['siSaturdayDeliveryOption']=='Y') {
		echo '<td><font face="Arial" size="2">' . 'Saturday Delivery' . '</font></td></tr>';
		}
		if($row['siCallTagOption']=='Y') {
		echo '<tr>';
		echo '<td>&nbsp;</td>';
		echo '<td><font face="Arial" size="2">' . 'Call Tag ' . $row['siCallTagReferenceNumber'] . '</font></td></tr>';
		}
		echo '<tr><td>&nbsp;</td></tr>';
		echo '<tr>';
		$query2 = "SELECT siShipmentID,pkgTrackingNumber,pkgWeight FROM shipmentdata WHERE siShipmentID = '$siShipmentID'";
		$result2 = mysql_query($query2) or die(mysql_error());
		while($row2 = @mysql_fetch_assoc($result2)) 
		{
		echo '<tr>';
		echo '<td><font face="Arial" size="2">' . '<b>' . 'Package Details' . '</b>' . '</font></td>';
		echo '<td>&nbsp;</td></tr>';
		echo '<tr>';
		echo '<td><font face="Arial" size="2">' . 'Tracking Number: ' . '</font></td>';
		echo '<td><font face="Arial" size="2">' . '<A HREF="http://wwwapps.ups.com/tracking/tracking.cgi?tracknum=' . $row2['pkgTrackingNumber'] . '"target="_blank">' . $row2['pkgTrackingNumber'] . '</A></font></td></tr>';
		echo '<tr>';
		echo '<td><font face="Arial" size="2">' . 'Weight: ' . '</font></td>';
		echo '<td><font face="Arial" size="2">' . $row2['pkgWeight'] . '</font></td></tr>';
		}
		echo '<tr>';
		echo '<td>&nbsp;</td></tr>';
		echo '<tr><td colspan="2" align="center"><font face="Arial" size="2"><i>' . 'Click package tracking number to track package.' . '</i></font></td></tr>';
		echo '<tr>';
		echo '<td colspan="2"><div align="center"><hr width="50%"></div></td></tr>';
		}
		}
	}
	?>
	</table>
  	</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
  	<td valign="top">
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