<?php
$message="";
$sysMsg="";
$rmtDateFrom="";
$rmtDateTo="";
$rmtfid="";

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
	
	if((isset($_GET['datefrom'])) && (isset($_GET['dateto']))) {
		$rmtDateFrom = $_GET['datefrom'];
		$rmtDateTo = $_GET['dateto'];
		$rmtfid = $_GET['f_id'];
	}
	
	include 'php-ofc-library/open-flash-chart.php';

	$title = new title( date("D M d Y") );
	
	$bar = new bar();
	$bar->set_values( array(9,8,7,6,5,4,3,2,1) );
	$bar->set_colour( '#94D700' );
	
	$chart_1 = new open_flash_chart();
	$chart_1->set_title( $title );
	$chart_1->add_element( $bar );
	//
	//
	$data_1 = $chart_1->toPrettyString();
	//
	//
	
	//
	// CHART 2
	//
	// generate some random data
	srand((double)microtime()*1000000);
	
	$tmp = array();
	for( $i=0; $i<9; $i++ )
	  $tmp[] = rand(1,10);
	
	$bar_2 = new bar();
	$bar_2->set_values( $tmp );
	
	$chart_2 = new open_flash_chart();
	$chart_2->set_title( new title( "Chart 2 :-)" ) );
	$chart_2->add_element( $bar_2 );
	//
	//
	$data_2 = $chart_2->toPrettyString();
	//
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

<script type="text/javascript" src="js/json/json2.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript">
 
/*
 
don't forget to include the JSON JS library :-) ^^
 
*/
 
function show_Chart(str)
{
swfobject.embedSWF(
  "open-flash-chart.swf", "pageData",
  "450", "300", "9.0.0", "expressInstall.swf",
  {"get-data":"get_data_"+str+""} );
}

function ofc_ready()
{
	// alert('ofc_ready');
}
 
 
function get_data_1()
{
	// alert( 'reading data 1' );
	return JSON.stringify(data_1);
}
 
function get_data_2()
{
	// alert( 'reading data 2' );
	// alert(JSON.stringify(data_2));
	return JSON.stringify(data_2);
}
 
var data_1 = <?php echo $data_1; ?>;
 
//
// to help debug:
//
// alert(JSON.stringify(data_1));
 
var data_2 = <?php echo $data_2 ?>;
</script>

<script language="JavaScript">
function change(str)
{
  document.getElementById(str).style.display="inline"; 
}
</script>

</HEAD>

<BODY>
	
	<SCRIPT LANGUAGE="JavaScript">
<!--
function showList() {
  sList = window.open("csPortal_ticketReports.php?action=csLookup", "list", "width=350, height=500, scrollbars=yes");
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
?>
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
													<td><font size="2" face="Arial" color="black"><strong><?php echo $message; ?></strong><div align="center"><a href="csPortal_Login.php?action=logout"><?php echo $portalMsg[9][$lang]; ?></a></font></div></td>
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
						  			<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'"; height="36" alt="Click to go to Netcom homepage."></a></td>
						  			<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'"; height="36" alt="Click to go to Sales homepage."></a></td>
						  			<td><a href="csPortal_Support.php"><img src="images/Support_ButtonActive.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonActive.gif'"; height="36" alt="Click for customer support options."></a></td>								
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
	</div>
	<div class="content" align="center">
		<div id="srchFrm">
			<form name="searchParams" id="searchParams" onSubmit="javascript:get(document.getElementById('searchParams'));">
			<table border="0" cellspacing="0" cellpadding="0" STYLE="background-image: url('images/invbox_back.gif'); border: 1 ridge #CCCCCC" width="75%">
	 			<tr> 
	 				<td colspan="4" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Support Ticket Reporting</b></font></td>
	 			</tr>
	  			<td colspan="4" align="center"><font face="Arial" size="2">Please enter your required search criteria options below:</font></td>
	 			</tr>
	  		<tr>
	    		<td width="10">
	    			<font size="2" face="Arial"><strong>Date From:</strong></font><br>
	    			<INPUT TYPE="text" NAME="dateFrom" id="dateFrom" VALUE="<?php echo $rmtDateFrom; ?>" SIZE=10 />
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
	    			<INPUT TYPE="text" NAME="dateTo" id="dateTo" VALUE="<?php echo $rmtDateTo; ?>" SIZE=10 />
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
	     		<td colspan="2">
	     			<font size="2" face="Arial"><strong>Opened By:</strong></font><br>
	     			<select name="hfEmployee" id="hfEmployee">
						<option value="ALL">ALL</option>
						<?php
						include 'includes/config.inc.php';
						include 'includes/db_connect.inc.php';
						$query20 = "SELECT id, f_name, l_name FROM employees ORDER BY l_name ASC";
  					$result20 = mysql_query($query20);
  					include 'includes/db_close.inc.php';
						while($row20 = mysql_fetch_array($result20))
						{
							$user1 = $row20['l_name'].', '.$row20['f_name'];
						?>
							<option value="<?php echo $row20['id']; ?>"><?php echo $user1; ?></option>
						<?php
						}
						?>
						</select>
	     		</td>
	     		<td colspan="2">
	     			<font size="2" face="Arial"><strong>Customer Number:</strong></font><br>
	    			<INPUT TYPE="text" NAME="custNum" id="custNum" VALUE="<?php if(isset($_GET['cust_num'])){ echo $_GET['cust_num']; } ?>" SIZE=15 />
	    			<INPUT TYPE="button" VALUE="Find" onClick="showList()">
	     		</td>
	     	</tr>
	     	<tr>
	     		<td colspan="2">
	     			<font size="2" face="Arial"><strong>Status:</strong></font><br>
	    			<select name="status" id="status">
						<option value="ALL">ALL</option>
						<option value="0">Open</option>
						<option value="-1">Closed</option>
						</select>
					</td>
					<td colspan="2">
	     			<font size="2" face="Arial"><strong>Ticket Type:</strong></font><br>
	    			<select name="ticketType" id="ticketType">
	    				<option value="ALL">ALL</option>
							<option value="0">Office Hours Call Center</option>
							<option value="1">After Hours Call Center</option>
							<option value="2">Site Visit/Service Call</option>
							<option value="4">Site Visit/Training</option>
							<option value="3">Proactive Call</option>
						</select>
					</td>
	     	</tr>
	     	<tr>
	     		<td colspan="2">
	     			<font size="2" face="Arial"><strong>Company:</strong></font><br>
	    			<select name="company" id="company">
	    				<option value="ALL">ALL</option>
							<option value="HomeFree">HomeFree</option>
							<option value="ElmoTech">ElmoTech</option>
						</select>
					</td>
				</tr>
	     	<tr>
	     		<td colspan="4">
	     			<font size="2" face="Arial"><strong>Keyword Search:</strong></font><br>
	    			<INPUT TYPE="text" NAME="keyword" id="keyword" VALUE="" SIZE=47 />
	     		</td>
	     	</tr>
	     	<tr>
	     		<td colspan="4">
	     			<font size="1" face="Arial">Use keyword search to search for keywords in the ticket summary and/or technician remark within tickets.</font><br>
	     		</td>
	     	</tr>
	     	<tr>
	     		<td colspan="4" align="center">
	     			<INPUT TYPE="button" NAME="ticketSearch" id="ticketSearch" VALUE="Statistics" onclick="javascript:get('reportStatistics.php', this.parentNode);" />
	     			<INPUT TYPE="button" NAME="ticketSearch" id="ticketSearch" VALUE="Details" onclick="javascript:get('reportDetails.php', this.parentNode);" />
	     			<?php //<INPUT TYPE="button" NAME="ticketSearch" id="ticketSearch" VALUE="Graphs" onclick="javascript:change('chartMenu');" />?>
	     			<INPUT TYPE="button" NAME="ticketSearch" id="ticketSearch" VALUE="Graphs" onclick="javascript:get('reportGraphs.php');" />
	     		</td>
				</tr>
			</table>
			</form>
		</div>
		<div id="chartMenu" style="display: none;">
			<span id="chart1" onclick="javascript:show_Chart('1');">Chart 1</span>
			<span id="chart2" onclick="javascript:show_Chart('2');">Chart 2</span>
			<br />
		</div>
		<div id="pageData"></div>
	</div>
<?php
}
?>
	<div class="footer">
		<?php include_once('footer.php'); ?>
	</div>
</div>
</BODY>
</HTML>