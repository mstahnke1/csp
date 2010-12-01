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

if(isset($_GET['ticketSearch']))
{
	include 'includes/db_connect.inc.php';
	include 'includes/functions.inc.php';

$keyword = $_GET['keyword'];

if($keyword != "")
{
	$query2 = "SELECT *, MATCH (Summary) AGAINST('$keyword') AS RELEVANCE FROM tblTickets ";
}
else
{
	$query2 = "SELECT * FROM tblTickets ";
}

foreach($_GET as $val){
  if($val != "ALL"){
    $query2 .= "WHERE ";
    break;
  }
}

$where = array();

if($_GET['status'] != 0)
{
	$dateFrom = $_GET['dateFrom'];
	$dateFromUnix = strtotime($dateFrom);
	if($dateFrom != ""){
	  $where[] = "DateClosed >= '$dateFrom' ";
	}

	if($_GET['dateTo'] == "")
	{
		$dateTo = date('Y-m-d');
	}
	else
	{
		$dateTo = $_GET['dateTo'];
	}
	$dateToUnix = strtotime('+1 day',strtotime($dateTo));
	if($dateTo != ""){
		$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
  $where[] = "DateClosed <= '$dateTo' ";
	}
}
else
{
	$dateFrom = $_GET['dateFrom'];
	$dateFromUnix = strtotime($dateFrom);
	if($dateFrom != ""){
	  $where[] = "DateOpened >= '$dateFrom' ";
	}

	if($_GET['dateTo'] == "")
	{
		$dateTo = date('Y-m-d');
	}
	else
	{
		$dateTo = $_GET['dateTo'];
	}
	$dateToUnix = strtotime('+1 day',strtotime($dateTo));
	if($dateTo != ""){
		$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
  $where[] = "DateOpened <= '$dateTo' ";
	}
}

$hfEmployee = $_GET['hfEmployee'];
if($hfEmployee != "ALL"){
  $where[] = "OpenedBy = '$hfEmployee' ";
}

$ticketType = $_GET['ticketType'];
if($ticketType != "ALL"){
  $where[] = "Type = '$ticketType' ";
}

$custNum = $_GET['custNum'];
$company = $_GET['company'];
if($custNum != ""){
  $where[] = "CustomerNumber = '$custNum' ";
}elseif($company != "ALL"){
	$where[] = "CustomerNumber IN(SELECT CustomerNumber FROM tblfacilities WHERE refCompany = '$company') ";
}

$status = $_GET['status'];
if($status != "ALL"){
	if($status == -1) {
 		$where[] = "Status = '$status' ";
 	} else {
 		$where[] = "Status >= '$status' ";
 	}
}

$keyword = $_GET['keyword'];
if($keyword != ""){
  $where[] = "MATCH (Summary) AGAINST('+$keyword' IN BOOLEAN MODE) HAVING RELEVANCE > 0.2 ";
}

if(!empty($where)){
  $query2 .= implode(" AND ", $where);
}
else
{
	$query2 = substr($query2, 0, -6);
}

if($keyword != "")
{
	$query2 .= " ORDER BY RELEVANCE DESC";
}
else
{
	$query2 .= " ORDER BY ID DESC";
}

$result2 = mysql_query($query2) or die(mysql_error());
$num = mysql_num_rows($result2);

}

}
?>

<HTML>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
<title>HomeFree Systems | Customer Service Portal - Support Ticket Tracking</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">

<SCRIPT LANGUAGE="JavaScript">
<!--
function pick(symbol) {
  if (window.opener && !window.opener.closed)
    window.opener.document.searchParams.custNum.value = symbol;
  window.close();
}
// -->
</SCRIPT>

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

<SCRIPT LANGUAGE="JavaScript">
<!--
function showList() {
  sList = window.open("ticketReports.php?action=csLookup", "list", "width=350, height=500, scrollbars=yes");
}

function remLink() {
  if (window.sList && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>
<?php
if((isset($_GET['action']) && $_GET['action'] == "csLookup") OR (isset($_GET['by_name'])))
{
?>
<TABLE>
 	<TR>
		<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<td><font size="2" face="Arial"><strong>Facility Name:</strong></font><br><input name="f_name" type="text"><input type="hidden" name="by_name" value="name"><input type="hidden" name="action" value="csLookup"></td>
		<td valign="bottom"><input name="by_name" type="submit" value="Lookup"></td>
		</FORM>
	</TR>
</TABLE>
<?php
}
else
{

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
  	<td><b><i><font face="Arial" size="2" color="Red"><?php echo $sysMsg; ?></font></b></i></td>
  </tr>
 <tr>
 <td>
 	
<?php
if(isset($_GET['ticketSearch']))
{
	$dif = $dateToUnix - $dateFromUnix;
	$days = floor($dif / 86400);
	if($days > 0)
	{
	$aveTickets = $num / $days;
	}
if($num > 0)
{
?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<?php
		if(!(isset($_GET['view']) && ($_GET['view'] == "print")))
		{
		?>
		<tr>
			<td align="center">
				<a href="javascript:void(0)"onclick="window.open('<?php echo 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>&view=print','system','width=600,height=750,scrollbars=yes')"><font size="2" face="Arial">Print Results</font></a>
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
			<td align="center">
				<font size="2" face="Arial"><b>Your search has returned <?php echo $num; ?> matching tickets.</b></font>
			</td>
		</tr>
		<?php
		// if no Start date is entered you cannot get a ticket count over specified days. For this reason no ticket counts are shown.
		if($dateFrom != "")
		{
		?>
		<tr>
			<td align="center">
				<font size="2" face="Arial"><b>You have selected to view tickets over <?php echo $days; ?> days.</b></font>
			</td>
		</tr>
		<?php
		}
		
		//if the status is ALL(this removes averate ticket printout when queries are for closed or opened tickets) and no date From is selected do not print an average ticket count. Can't take an average if you don't have a start date.
		if($_GET['status'] == "ALL" AND $dateFrom != "" AND $_GET['custNum'] == "")
		{
		?>
		<tr>
			<td align="center">
				<font size="2" face="Arial"><b>The average opened tickets per day are <?php echo $aveTickets; ?>.</b></font>
			</td>
		</tr>
		<?php
		}
		?>
	</table>
<?php
}
else
{
?>
	<table border="0" width="100%">
		<tr>
			<td align="center">
				<font size="2" face="Arial"><b>Your search did not return any matching tickets.</b>
			</td>
		</tr>
	</table>
<?php
}

while($row2 = mysql_fetch_array($result2))
{
	$fID = $row2['CustomerNumber'];
	$query3 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$fID'";
	$result3 = mysql_query($query3) or die(mysql_error());
	$row3 = mysql_fetch_array($result3);
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2">
				<font size="2" face="Arial"><b>Ticket Number: <a href="csPortal_Tickets.php?ticket_num=<?php echo $row2['ID']; ?>&by_ticket=ticket"><?php echo $row2['ID']; ?></a></b></font>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100">
				<font size="2" face="Arial">Facility:</font>
			</td>
			<td>
				<font size="2" face="Arial"><?php echo $row3['FacilityName']; ?></font>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100">
				<font size="2" face="Arial">Date Opened:
			</td>
			<td>
				<font size="2" face="Arial"><?php echo $row2['DateOpened']; ?></font>
			</td>
		</tr>
		<?php
		if($row2['Status'] == -1)
		{
		?>
		<tr>
			<td valign="top" width="100">
				<font size="2" face="Arial">Duration:</font>
			</td>
			<td>
				<font size="2" face="Arial"><?php echo dateDiff($row2['DateOpened'],$row2['DateClosed']); ?></font>
			</td>
		</tr>
		<?php
		}
		$query23 = "SELECT f_name, l_name FROM employees WHERE id = '$row2[OpenedBy]'";
    $result23 = mysql_query($query23);
    $row23 = mysql_fetch_array($result23);
    $empName23 = $row23['l_name'] . ", " . $row23['f_name'];
		?>
		<tr>
			<td valign="top" width="100">
				<font size="2" face="Arial">Opened By:</font>
			</td>
			<td>
				<font size="2" face="Arial"><?php echo $empName23; ?></font>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100">
				<font size="2" face="Arial">Trouble Desc.:</font>
			</td>
			<td>
				<font size="2" face="Arial"><?php echo $row2['Summary']; ?></font>
			</td>
		</tr>
		<?php
		if($keyword != "")
		{
		?>
		<tr>
			<td valign="top" width="100">
				<font size="2" face="Arial">Relevance:</font>
			</td>
			<td>
				<font size="2" face="Arial"><?php echo $row2['RELEVANCE']; ?></font>
			</td>
		</tr>
		<?php
		}
		if(!(isset($_GET['view']) && ($_GET['view'] == "print")))
		{
		?>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<?php
		}
		?>
	</table>
	<?php
	if((isset($_GET['view']) && ($_GET['view'] == "print")))
	{
		$query4 = "SELECT * FROM tblticketmessages  WHERE TicketID = '$row2[ID]' ORDER BY Date";
		$result4 = mysql_query($query4);
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
			while($row4 = mysql_fetch_array($result4))
			{
			?>
				<tr valign="top">
					<td width="100">
						<font size="2" face="Arial">Rep. Comment:</b></font>
					</td>
					<td>
						<font size="2" face="Arial"><?php echo $row4['Message']; ?></font>
					</td>
				</tr>
				<tr>
					<td width="100">
						&nbsp;
					</td>
					<td>
						<font size="2" face="Arial"><?php echo $row4['EnteredBy']; ?></font>
					</td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td>
					&nbsp;
				</td>
			</tr>
		</table>
	<?php
	}
}
}
}

if(isset($_GET['by_name']))
{
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	$f_name = $_GET['f_name'];
	$query = "SELECT CustomerNumber,FacilityName FROM tblFacilities WHERE FacilityName LIKE '%$f_name%' AND Active = -1 ORDER BY FacilityName";
	$result = mysql_query($query) or die ('Error retrieving Customer Name Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
?>
	<TABLE>
<?php
		while($row = mysql_fetch_array($result))
		{
			echo '<TR><TD><FONT FACE="Arial" SIZE="2">'.$row['FacilityName'].'</FONT><TD><A HREF="javascript:pick(\''.$row['CustomerNumber'].'\')"><FONT FACE="Arial" SIZE="2">Select</FONT></A></TD></TR>';
		}
?>
	</TABLE>
	
<?php
	include 'includes/db_close.inc.php';
}
?>

</td>
</tr>
</table>

  	</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
 		<td>
			<?php
		if(!((isset($_GET['action']) && $_GET['action'] == "csLookup") OR (isset($_GET['by_name']))))
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

