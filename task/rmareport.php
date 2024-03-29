<?php
if(!isset($_GET['comp']))
{
	include 'header.php';
}
if(isset($_GET['comp']))
{
	include 'rmaprintheader.php';
}
?>
<link rel="stylesheet" type="text/css" href="../csPortal_Layout.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HomeFree Task Management</title>
<?php
if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	die(header("Location: csPortal_Login.php"));
}else
{
	$name = $_SESSION['displayname'];
	$message="Hello $name!";
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
}
$access = $_SESSION['access'];
$conn11 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db($dbname);
$uid = $_SESSION['uid'];
$email = $_SESSION['mail'];
$query1 = "SELECT id, f_name, l_name, dept FROM employees WHERE email = '$email'";
$result1 = mysql_query($query1) or die (mysql_error());
$row1 = mysql_fetch_array($result1);
$employeeid = $row1['id'];      
$firstname = $row1['f_name'];
$lastname = $row1['l_name'];
$department = $row1['dept'];
mysql_close($conn11);	
$date = date('Y-m-d H:i:s');
$displaydate = date('m-d-Y H:i:s');
$now = strtotime("now");
$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$displaydate1 = date('Y-m-d',$tomorrow);
$tomorrowplus  = mktime (date("H"), date("i")+15, 0, date("m")  , date("d")+1, date("Y"));
$eightdaysago  = mktime (0, 0, 0, date("m"), date("d")-8, date("Y"));
$sevendaysago  = mktime (0, 0, 0, date("m"), date("d")-7, date("Y"));
$sixdaysago  = mktime (0, 0, 0, date("m"), date("d")-6, date("Y"));
$fivedaysago  = mktime (0, 0, 0, date("m"), date("d")-5, date("Y"));
$fourdaysago  = mktime (0, 0, 0, date("m"), date("d")-4, date("Y"));
$threedaysago  = mktime (0, 0, 0, date("m"), date("d")-3, date("Y"));
$twodaysago  = mktime (0, 0, 0, date("m"), date("d")-2, date("Y"));
$onedaysago  = mktime (0, 0, 0, date("m"), date("d")-1, date("Y"));
$currentmorning  = mktime (0, 0, 0, date("m"), date("d"), date("Y"));
$dateseven  = date('Y-m-d 00:00:00',$sevendaysago);
$datesix  = date('Y-m-d 00:00:00',$sixdaysago);
include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
mysql_select_db($dbname2);
$query16 = "SELECT ID FROM taskinfo WHERE Type = 28";
$result16 = mysql_query($query16) or die (mysql_error());
$count16 = mysql_num_rows($result16);
$query17 = "SELECT ID,Completiondate,Createdate FROM taskinfo WHERE Type = 11 AND Response > 1999";
$result17 = mysql_query($query17) or die (mysql_error());
$count17 = mysql_num_rows($result17);
$query18 = "SELECT ID,Completiondate,Createdate FROM taskinfo WHERE Type = 11 AND Response > 1999 AND Status = 3";
$result18 = mysql_query($query18) or die (mysql_error());
$count18 = mysql_num_rows($result18);
$query19 = "SELECT ID,Createdate,ticketNum,CustomerNumber FROM taskinfo WHERE Type = 11 AND Status <> 3 AND Status <> 4 AND Createdate < '$dateseven'";
$result19 = mysql_query($query19) or die (mysql_error());
$count19 = mysql_num_rows($result19);
$query20 = "SELECT ID,Createdate,ticketNum,CustomerNumber FROM taskinfo WHERE Type = 11 AND Status <> 3 AND Status <> 4 AND Createdate < '$datesix' AND Createdate > '$dateseven'";
$result20 = mysql_query($query20) or die (mysql_error());
$count20 = mysql_num_rows($result20);
//q will keep adding the total amount of seconds that the tasks have been opened
$q = 0;
while($row18 = mysql_fetch_array($result18))
{
	$q = $q;						
	$create = strtotime($row18['Createdate']);
	$complete = strtotime($row18['Completiondate']);
/*
Creating variables to mktime the create date
H = hours
i = minutes
s = seconds
d = days
m = months
Y = year
*/
	$hour_create = date('H', $create);
	$min_create = date('i', $create);
	$sec_create = date('s', $create);
	$d_create = date('d', $create);
	$m_create = date('m', $create);
	$y_create = date('Y', $create);
/*
Creating variables to mktime the completion date
H = hours
i = minutes
s = seconds
d = days
m = months
Y = year
*/
	$hour_complete = date('H', $complete);
	$min_complete = date('i', $complete);
	$sec_complete = date('s', $complete);
	$d_complete = date('d', $complete);
	$m_complete = date('m', $complete);
	$y_complete = date('Y', $complete);
/* no_of_days defines the amount of days the month the task was created*/
	$no_of_days = date('t',mktime(0,0,0,$m_create,1,$y_create));
/* $_endDate is the strtotime of the completed date*/
  $_endDate = mktime($hour_complete,$min_complete,$sec_complete,$m_complete,$d_complete,$y_complete);
/* $_beginDate is the strtotime of the created date*/ 
  $_beginDate = mktime($hour_create,$min_create,$sec_create,$m_create,$d_create,$y_create);
  $timestamp_diff= $_endDate-$_beginDate +1 ;
 /* $days_diff finds the amount of days between the created and completed date*/
  $days_diff = ($timestamp_diff/86400);
	$d1 = date('d',$create); //is the number value of the day in the create date i.e. 01, 10, 25
	$d2 = date('H',$create); 
	$d4 = date('l',$create); //is the text value of the day in the create date i.e. Monday, Friday
	$d3 = date('d',$complete); //is the number value of the day in the completed date i.e. 01, 10, 25
	$d5 = ($d1 + 1); //is the number value of the day after the create date
	$d6 = ($d1 + 2); //is the number value of two days after the create date
	$d7 = ($d1 + 3); //is the number value of three days after the create date
	$d8 = ($d1 + 4); //is the number value of four days after the create date
	$multiplier = 1; //the multiplier will always be 1 unless re-defined later in the code
	
/************the reason the below code exists is because I need to know if there was a weekend between the create and complete date*************/
	if($d1 == $no_of_days) //says if the create date is the last day of the month define the variables from the 01 instead of 32, 33, 34
	{
		$d9 = 00;
		$d5 = ($d9 + 1); 
		$d6 = ($d9 + 2);
		$d7 = ($d9 + 3);
		$d8 = ($d9 + 4);
	}elseif($d5 == $no_of_days)//says if the create date(+1) is the last day of the month define the variables from the 01 instead of 32, 33, 34
	{
		$d9 = 00;
		$d6 = ($d9 + 1);
		$d7 = ($d9 + 2);
		$d8 = ($d9 + 3);
	}elseif($d6 == $no_of_days)//says if the create date(+2) is the last day of the month define the variables from the 01 instead of 32, 33, 34
	{
		$d9 = 00;
		$d7 = ($d9 + 1);
		$d8 = ($d9 + 2);
	}elseif($d7 == $no_of_days)//says if the create date(+3) is the last day of the month define the variables from the 01 instead of 32, 33, 34
	{
		$d9 = 00;
		$d8 = ($d9 + 1);
	}
/***************************************************************************************************************************************/

/*using the days defined above finds if their is a weekend or more for a task that starts on that day*/
	if(($d4 == 'Friday') && ($d1 <> $d3))
	{
		if($days_diff > 7)
		{
			$multiplier = 2;
		}
		if($days_diff > 14)
		{
			$multiplier = 3;
		}
		if($days_diff > 21)
		{
			$multiplier = 3;
		}	
		if($days_diff > 28)
		{
			$multiplier = 4;
		}							
		$weekend = (172800 * $multiplier);
	}elseif($d4 == 'Thursday')
	{
		if(($d1 <> $d3) && ($d3 <> $d5))
		{
			if($days_diff > 8)
			{
				$multiplier = 2;
			}
			if($days_diff > 15)
			{
				$multiplier = 3;
			}
			if($days_diff > 22)
			{
				$multiplier = 3;
			}	
			if($days_diff > 29)
			{
				$multiplier = 4;
			}						
			$weekend = (172800 * $multiplier);
		}else
		{
			$weekend = 0;
		}
	}elseif($d4 == 'Wednesday') 
	{
		if(($d1 <> $d3) && (!(($d3 == $d5) OR ($d3 == $d6))))
		{
			if($days_diff > 9)
			{
				$multiplier = 2;
			}
			if($days_diff > 16)
			{
				$multiplier = 3;
			}
			if($days_diff > 23)
			{
				$multiplier = 3;
			}	
			if($days_diff > 30)
			{
				$multiplier = 4;
			}				
			$weekend = (172800 * $multiplier);
		}else
		{
			$weekend = 0;
		}
	}elseif($d4 == 'Tuesday')
	{
		if(($d1 <> $d3) && (!(($d3 == $d5) OR ($d3 == $d6) OR ($d3 == $d7))))
		{
			if($days_diff > 10)
			{
				$multiplier = 2;
			}
			if($days_diff > 17)
			{
				$multiplier = 3;
			}
			if($days_diff > 24)
			{
				$multiplier = 3;
			}			
			$weekend = (172800 * $multiplier);
		}else
		{
			$weekend = 0;
		}	
	}elseif($d4 == 'Monday')
	{
		if(($d1 <> $d3) && (!(($d3 == $d5) OR ($d3 == $d6) OR ($d3 == $d7) OR ($d3 == $d8))))
		{
			if($days_diff > 11)
			{
				$multiplier = 2;
			}
			if($days_diff > 18)
			{
				$multiplier = 3;
			}
			if($days_diff > 25)
			{
				$multiplier = 3;
			}			
			$weekend = (172800 * $multiplier);
		}else
		{
			$weekend = 0;
		}		
	}else
	{
		$weekend = 0;
	}
	$seconds = $complete - $create - $weekend; //calculation to find the number of seconds for each completed RMA task
	$q = $q + $seconds; //adding the seconds of each task to the previous total
	//echo ($seconds / 86400).' '.$d1.' '.$d3.'<br>';
	//echo $row18['ID'].' '.$timestamp_diff.' '.round($days_diff,2).' '.round($seconds / 86400,3).'<br>';
}	
$dif = $q/$count18; //finds the average amount of seconds
/* Calculation turning average amount of seconds into days / hours / minutes / seconds*/
$days = floor($dif / 86400);
$temp_remainder = $dif - ($days * 86400);

$hours = floor($temp_remainder / 3600);
$temp_remainder = $temp_remainder - ($hours * 3600);
 
$minutes = floor($temp_remainder / 60);
$temp_remainder = $temp_remainder - ($minutes * 60);
 
$seconds = floor($temp_remainder);
$min_lead=':';
if($minutes <=9)
  $min_lead .= '0';
$sec_lead=':';
if($seconds <=9)
  $sec_lead .= '0';     
$display_time_diff = $days.' Days '.$hours.' Hours '.$minutes.' Minutes '.$seconds.' Seconds';  
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function showList() {
  sList = window.open("../task/lookup.php?fr=rmareport","mywindow","width=450","height=350","scrollbars=1");
}
function seeSN() {
  sList = window.open("../task/lookup.php?fr=editsn","mywindow","width=450","height=350","scrollbars=1");
}

function remLink() {
  if (window.sList && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>
<table width="750">	
	<tr>
		<td align="center" class="SectionNav">
			RMA Information Center
		</td>
	</tr>		
</table>		
<table align="center" cellpadding="2">
	<tr>
		<td width="120" align="center">
			<?php echo  '<a href="' . 'taskhome.php">'.'Task Home'; ?>
		</td>
<?php			
		if(!isset($_GET['view']))
		{
?>				
			<td width="120" align="center">
				<?php echo '<a href="'.'rmareport.php?view=customrmarpt">'.'Create Report'; ?>
			</td>			
<?php
		}
		elseif((isset($_GET['view'])) && ($_GET['view'] == 'facility'))
		{		
			$custnum = $_GET['cus'];					
?>				
			<td width="120" align="center">
				<?php echo '<a href="'.'rmareport.php?view=customrmarpt&custnum='.$custnum.'">'.'Create Report'; ?>
			</td>			
<?php
		}		
?>						
			<td width="120" align="center">
				<?php echo '<a href="'.$_SERVER['HTTP_REFERER'].'">'.'Back'; ?>
			</td>					
	</tr>
</table>
<table>
	<tr>
		<td>
			Overall RMA Statistics
		</td>
	</tr>
	<tr>
		<td>
			Number of equipment return requests:
		</td>
		<td>
			<?php echo $count16; ?>
		</td>
	</tr>
	<tr>
		<td>
			Number of equipment repair requests:
		</td>
		<td>
			<?php echo $count17; ?>
		</td>
	</tr>		
	<tr>
		<td>
			Average Equipment Time @ HomeFree:
		</td>
		<td>
			<?php echo $display_time_diff; ?>
		</td>
	</tr>
</table>	
<?php
if($count19 > 0)
{
?>		
	<table width="750" align="center">
		<tr>
			<td class="SectionNav">
				<table>
					<tr>
						<td colspan="4" align="center"><font color="#FF0000"><b>
							**Tickets that have not shipped within 5 BUSINESS days of being received at HF**
						</b></td>			
					</tr>
<?php
					while($row19 = mysql_fetch_array($result19))
					{
						mysql_select_db($dbname2);
						$ticketid = $row19['ticketNum'];
						$cusnum = $row19['CustomerNumber'];
						mysql_select_db($dbname);
						$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$cusnum'";
						$result4 = mysql_query($query4) or die (mysql_error());
						$row4 = mysql_fetch_array($result4);			
						$facilityname = $row4['FacilityName'];			
?>		
						<tr>	
							<td width="200">
								<?php echo $facilityname; ?>
							</td>
							<td width="50">
								<?php echo '<a href="' . '../csPortal_Tickets.php?ticket_num='.$ticketid.'&by_ticket=ticket" target="blank">'.  $ticketid . '</a>'; ?>
							</td>	
							<td width="70">
								<?php echo '<a href="' . 'task.php?view=update&type=11&taskid='.$row19['ID'].'" target="blank">'. 'View Task'; ?>
							</td>
							<td width="429">
								Date Equipment was Received: <?php echo $row19['Createdate']; ?>
							</td>
						</tr>
<?php			
					}
?>		
				</table>
			</td>
		</tr>
	</table>
<?php
}
if($count20 > 0)
{
?>		
	<table width="750" align="center">
		<tr>
			<td class="SectionNav">
				<table>
					<tr>
						<td colspan="4" align="center"><font color="#FF0000"><b>
							**Tickets that need to ship today (5th day at HF)**
						</b></td>			
					</tr>
<?php
					while($row20 = mysql_fetch_array($result20))
					{
						$ticketid = $row20['ticketNum'];
						$cusnum = $row20['CustomerNumber'];
						mysql_select_db($dbname);
						$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$cusnum'";
						$result4 = mysql_query($query4) or die (mysql_error());
						$row4 = mysql_fetch_array($result4);			
						$facilityname = $row4['FacilityName'];			
?>		
						<tr>	
							<td width="200">
								<?php echo $facilityname; ?>
							</td>
							<td width="50">
								<?php echo '<a href="' . '../csPortal_Tickets.php?ticket_num='.$ticketid.'&by_ticket=ticket" target="blank">'.  $ticketid . '</a>'; ?>
							</td>	
							<td width="70">
								<?php echo '<a href="' . 'task.php?view=update&type=11&taskid='.$row20['ID'].'" target="blank">'. 'View Task'; ?>
							</td>
							<td width="429">
								Date Equipment was Received: <?php echo $row20['Createdate']; ?>
							</td>
						</tr>
<?php			
					}
?>		
				</table>
			</td>
		</tr>
	</table>
<?php
}
if((isset($_GET['view'])) && ($_GET['view'] == 'customrmarpt'))
{
	if(isset($_GET['rmarpt']))
	{
		$startdate = $_GET['date3'];
		$enddate = $_GET['date4'];
		$customer = $_GET['custNum'];	
		$type = $_GET['type'];
		$ticketid = $_GET['ticketnum'];
		$status = $_GET['status'];
		$sn = $_GET['serialnum'];
		$part = $_GET['part'];
	}
	mysql_select_db($dbname);
	$query12 = "SELECT * FROM devicelist";
	$result12 = mysql_query($query12);	
?>
	<form name="searchParams" id="searchParams" onSubmit="javascript:get(document.getElementById('searchParams'));">
		<table width="750">	
			<tr>
				<td class="heading" width="125"><b>
					Serial Number:
				</b></td>
				<td align="left">
					<INPUT TYPE="text" NAME="serialnum" VALUE="<?php if(isset($_GET['serialnum'])){ echo $sn; }?>" SIZE="10" maxlength="10" />
				</td>
			</tr>	
			<tr>
				<td><b>
					Part:
				</b></td>
				<td>
					<select name="part">
					<option value = "00">Any Part</option>
<?php 		while($row12 = mysql_fetch_array($result12))
					{
?>						
						<option value = <?php echo '"'.$row12['part#'].'">'. $row12['partDesc']; ?></option>
<?php
					}
?>					
				</td>
			</tr>
			<tr>
				<td colspan="1" align="center">
					- OR -
				</td>
			</tr>			
			<tr>
				<td class="heading" width="125"><b>
					Ticket Number:
				</b></td>
				<td align="left">
					<INPUT TYPE="text" NAME="ticketnum" VALUE="<?php if(isset($_GET['ticketnum'])){ echo $ticketid; }?>" SIZE="10" maxlength="10" />
				</td>
			</tr>	
			<tr>
				<td colspan="1" align="center">
					- OR -
				</td>
			</tr>
			<tr>
				<td class="heading" width="125"><b>
					Customer Number:
				</b></td>
				<td align="left">
					<INPUT TYPE="text" NAME="custNum" id="custNum" VALUE="<?php if(isset($_GET['custNum'])){ echo $customer; }?>" SIZE="6" maxlength="6" />
					<INPUT TYPE="button" VALUE="Find" onClick="showList()">	
				</td>
			</tr>		
			<tr>
				<td class="heading" width="125"><b>
					Type:
				</b></td>
				<td align="left">
					<select name=type>
					<option value = "00">Any</option>
					<option value = "11" <?php if((isset($_GET['type'])) && ($type == 11)){ echo 'selected="selected"'; } ?>>Equipment Repair / Replacement Task</option>
					<option value = "28" <?php if((isset($_GET['type'])) && ($type == 28)){ echo 'selected="selected"'; } ?>>Request Equipment Return</option>
					</select>
				</td>
			</tr>		
			<tr>
				<td class="heading" width="125"><b>
					Status:
				</b></td>
				<td align="left">
					<select name=status>
					<option value = "00">Any </option>
					<option value = "1" <?php if((isset($_GET['status'])) && ($status == 1)){ echo 'selected="selected"'; } ?>>New</option>
					<option value = "2" <?php if((isset($_GET['status'])) && ($status == 2)){ echo 'selected="selected"'; } ?>>In Progress (equipment repaired)</option>
					<option value = "9" <?php if((isset($_GET['status'])) && ($status == 9)){ echo 'selected="selected"'; } ?>> Equipment Received</option>
					<option value = "10" <?php if((isset($_GET['status'])) && ($status == 10)){ echo 'selected="selected"'; } ?>> Order Created</option>
					<option value = "13" <?php if((isset($_GET['status'])) && ($status == 13)){ echo 'selected="selected"'; } ?>> Awaiting Approval</option>
					<option value = "14" <?php if((isset($_GET['status'])) && ($status == 14)){ echo 'selected="selected"'; } ?>> Waiting For DS PO</option>
					<option value = "3" <?php if((isset($_GET['status'])) && ($status == 3)){ echo 'selected="selected"'; } ?>> Complete (Shipment Processed)</option>
					</select>
				</td>
			</tr>											
			<tr>
			  <td><b>
					Start Date:	
				</b></td>
				<td>
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date3" VALUE="<?php if(isset($_GET['date3'])){ echo $startdate; }?>" SIZE=25>
					<A HREF="#"
 					onClick="cal.select(document.forms['searchParams'].date3,'anchor3','yyyy-MM-dd'); return false;"
 					NAME="anchor3" ID="anchor3"><img src="../images/calendar_icon.png" height="18" border="0" alt="select"/></A>	
				</td>
			</tr>
			<tr>
				<td><b>
					End Date:	
				</b></td>
				<td>
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date4" VALUE="<?php if(isset($_GET['date4'])){ echo $enddate; }?>" SIZE=25>
					<A HREF="#"
 					onClick="cal.select(document.forms['searchParams'].date4,'anchor4','yyyy-MM-dd'); return false;"
 					NAME="anchor4" ID="anchor4"><img src="../images/calendar_icon.png" height="18" border="0" alt="select"/></A>
				</td>
			</tr>		
			<?php echo	'<input type = "hidden" name="view" value = "customrmarpt">';	?>
			<tr>
				<td>
					<input type="submit" value="Run" name="rmarpt">				
				</td>
			</tr>
		</table>				
	</form>		
<?php
}			
if((isset($_GET['rmarpt'])) && ($_GET['rmarpt'] == 'Run'))
{
	mysql_select_db($dbname2);		
	$sn = $_GET['serialnum'];
	$ticketid = $_GET['ticketnum'];
	$startdate = $_GET['date3'];
	$enddate = $_GET['date4'];
	if($startdate == '')
	{
		$startdate = '2009-08-01 00:00:00';
	}
	if($enddate == '')
	{
		$enddate = $displaydate1;
	}else
	{
		$enddate1 = strtotime($_GET['date4']);
		$endday = date('d',$enddate1);
		$endmonth = date('m',$enddate1);
		$endyear = date('Y',$enddate1);
		$enddate2 = mktime(0,0,0, $endmonth,$endday,$endyear);
		$enddate = date('Y-m-d 23:59:59',$enddate2);
		//$nextdate1 = mktime(0, 0, 0, date($startmonth), $no_of_days, $startyear);
		//$displaydate1 = date('Y-m-d',$tomorrow);		
	}
	$customer = $_GET['custNum'];	
	$status = $_GET['status'];
	$rpttype = $_GET['type'];
	if((isset($_GET['serialnum'])) && ($_GET['serialnum'] <> ''))
	{
		$part = $_GET['part'];
		mysql_select_db($dbname);	
		if($part == 00)
		{	
			$query9 = "SELECT TicketID,SN FROM rmadevices WHERE SN LIKE '%$sn%' ORDER BY TicketID DESC";
			$result9 = mysql_query($query9) or die (mysql_error());
		}else
		{
			$query9 = "SELECT TicketID,SN FROM rmadevices WHERE SN LIKE '%$sn%' AND Device = '$part' ORDER BY TicketID DESC";
			$result9 = mysql_query($query9) or die (mysql_error());
		}
?>
		<table width="750">
			<tr>
				<td align="center" colspan="6"><font size="4"><b>
					RESULTS
				</b></td>
			</tr>		
			<tr>
				<td align="center" colspan="6"><i>
					(newest on top)
				</i></td>
			</tr>
<?php						
		while($row9 = mysql_fetch_array($result9))
		{
			mysql_select_db($dbname);		
			$ticketid = $row9['TicketID'];
			$query11 = "SELECT DateOpened FROM tbltickets WHERE ID = '$ticketid'";
			$result11 = mysql_query($query11) or die (mysql_error());
			$row11 = mysql_fetch_array($result11);
			mysql_select_db($dbname2);
			$query10 = "SELECT ID,Status,Type FROM taskinfo WHERE ticketNum = '$ticketid'";
			$result10 = mysql_query($query10) or die (mysql_error());
?>
			<tr>
				<td class="sectionNav">
					<table>
						<tr>
							<td width="180"><b>
								Ticket No: <?php echo '<a href="' . '../csPortal_Tickets.php?ticket_num='.$ticketid.'&by_ticket=ticket">'.$ticketid; ?>
							</b></td>
							<td width="110"><b>
								Date Opened: 
							</b></td>
							<td width="140">
								<?php echo $row11['DateOpened']; ?>
							</td>
							<td width="200"><b>
								Actual SN entered on ticket:
							</b></td>
							<td width="110">
								<?php echo $row9['SN']; ?>
							</td>
						</tr>
<?php 
						while($row10 = mysql_fetch_array($result10))
						{
							if($row10['Type'] == 28)
							{
?>								
								<tr>
									<td>
<?php
										echo 'Customer Return Request:'. '<a href="' . 'task.php?view=update&type='.$row10['Type'].'&taskid='.$row10['ID'].'">'. ' '.$row10['ID'];
?>
									</td>
								</tr>
<?php															
							}		
							if($row10['Type'] == 11)
							{
?>								
								<tr>
									<td>
<?php
										echo 'Repair Request:'. '<a href="' . 'task.php?view=update&type='.$row10['Type'].'&taskid='.$row10['ID'].'">'. ' '.$row10['ID'];
?>
									</td>
								</tr>
<?php															
							}					
						}	
?>
					</table>
				</td>
			</tr>				
<?php	
		}	
?>
		</table>
<?php		
	}
	elseif((isset($_GET['ticketnum'])) && ($_GET['ticketnum'] <> ''))
	{
		mysql_select_db($dbname2);		
		$query8 = "SELECT * FROM taskinfo WHERE TicketNum = '$ticketid'";
	}else
	{
		mysql_select_db($dbname2);			
		$query8 = "SELECT * FROM taskinfo ";
		
		foreach($_GET as $val){
		  if($val != '' OR  $val = "rmarpt"){
		    $query8 .= "WHERE ((";
		    break;
		  }
		}
		$where [ ] = "Createdate >= '$startdate' && Createdate <= '$enddate'";	
		if($customer != ''){
		  $where [ ] = "CustomerNumber = '$customer'";
		}	
		if($status != 00){
		  $where [ ] = "Status = '$status'";
		}			
		if(!empty($where)){
		  $query8 .= implode(" AND ", $where);
		}
		if($rpttype == 00)
		{
			$query8 .= " )AND (Type = 11 OR Type = 28))";
		}else
		{
			$query8 .= ' )AND (Type ='.$rpttype.")) ";
		}
		$query8 .= " ORDER BY Createdate DESC";
	}
	if(!((isset($_GET['serialnum'])) && ($_GET['serialnum'] <> '')))
	{	
		$result8 = mysql_query($query8) or die(mysql_error());	
		$count8 = mysql_num_rows($result8);	
	?>
		<table>	
			<tr>
				<td align="center" colspan="4"><font size="4"><b>
					RESULTS
				</b></td>
			</tr>
			<tr>
				<td align="center" colspan="4"><i>
					Newest on Top
				</i></td>
			</tr>
	<?php		
			if($count8 < 1)
			{
				echo '<tr><td>'.'No Results Found'.'</td></tr>';
			}else
			{		
				while($row8 = mysql_fetch_array($result8))
				{
					$id = $row8['ID'];
					$type = $row8['Type'];
					mysql_select_db($dbname);
					$cusnum = $row8['CustomerNumber'];
					$datecreated = strtotime($row8['Createdate']);
					$display_date_created = date('m-d-Y',$datecreated);
					$ticketid = $row8['ticketNum'];
					$taskstatus = $row8['Status'];	
					mysql_select_db($dbname2);
					$query12 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
					$result12 = mysql_query($query12) or die (mysql_error());
					$row12 = mysql_fetch_array($result12);		
					$status = $row12['Status'];
					mysql_select_db($dbname);
					$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$cusnum'";
					$result4 = mysql_query($query4) or die (mysql_error());
					$row4 = mysql_fetch_array($result4);							
					if($type == 11)
					{			
						mysql_select_db($dbname2);	
						$query13 = "SELECT ID,Type,ticketNum From taskinfo WHERE ticketNum = '$ticketid' AND Createdate > '2009-08-01 00:00:00'";
						$result13 = mysql_query($query13) or die (mysql_error());
						$row13 = mysql_fetch_array($result13);		
						$count13 = mysql_num_rows($result13);
						if($count13 > 0)
						{
							mysql_select_db($dbname2);	
							$query14 = "SELECT * From taskinfo WHERE ticketNum = '$ticketid' AND Type = 28";
							$result14 = mysql_query($query14) or die (mysql_error());
							$row14 = mysql_fetch_array($result14);
							if($taskstatus == 2)
							{ 
								$extra_status_comment = '(Equipment Repaired)';
							}else
							{
								$extra_status_comment = '';
							}
							$query15 = "SELECT * From tbltaskaudit WHERE taskid = '$id' Order By ID desc";
							$result15 = mysql_query($query15) or die (mysql_error());
							$row15 = mysql_fetch_array($result15);
							if(($row15['response'] == 2002) && ($row15['status'] <> 3))
							{		
								$audit_trail = '<br><li>Equipment Received ->';
							}elseif(($row15['response'] == 2000) && ($row15['status'] <> 3))
							{
								$audit_trail = '<br><li>Equipment Received -> <br><li>Equipment Repaired, Waiting for Order Approval ->';
							}elseif(($row15['response'] == 2001) && ($row15['status'] <> 3))
							{
								$audit_trail = '<br><li>Equipment Received -> <br><li>Equipment Repaired, Waiting for Order Approval -> <br><li>Order Approved, Ready to Ship ->';
							}elseif($row15['status'] == 3)
							{
								$ship_date = strtotime($row15['Date']);
								$display_ship_date = date('m-d-Y',$ship_date);
								$audit_trail = '<br><li>Equipment Received -> <br><li>Equipment Repaired, Waiting for Order Approval -> <br><li>Order Approved, Ready to Ship -> <br><li>Shipped'.' '. $display_ship_date.' -> ';
							}
							$tasktype = $row14['Type'];
							$display = '<tr><td class="SectionNav" width="749"><table><tr><td colspan="5"><b>'.$row4['FacilityName'].'</b></td></tr>';
							$display .= '<tr><td width="130">Current Status:</td><td>'.$status.' '.$extra_status_comment.'</td></tr>';
							$display .= '<tr><td colspan="5">Date Submitted:'.' '.$display_date_created.'</td></tr>';
							$display .= '<tr><td>Ticket Reference:</td><td>'.'<a href="' . '../csPortal_Tickets.php?ticket_num='.$ticketid.'&by_ticket=ticket">'.  $ticketid . '</a>'.'</td></tr>';
							$display .= '<tr><td colspan="5"><a href="' . 'task.php?view=update&type='.$tasktype.'&taskid='.$row14['ID'].'">'.'Return Request</a> ->';
							$display .=	$audit_trail;
							$display .='<a href="' . 'task.php?view=update&type='.$tasktype.'&taskid='.$id.'">View Equipment Return Task</td></tr></table></td></tr>';
						}
					}
					if($type == 28)
					{
						$display = '<tr><td class="SectionNav" width="749"><table><tr><td colspan="5"><b>'.$row4['FacilityName'].'</b></td></tr>';
						$display .= '<tr><td width="130">Current Status:</td><td>'.$status.'</td></tr>';
						$display .= '<tr><td colspan="5">Date Submitted:'.' '.$display_date_created.'</td></tr>';
						$display .= '<tr><td>Ticket Reference:</td><td>'.'<a href="' . '../csPortal_Tickets.php?ticket_num='.$ticketid.'&by_ticket=ticket">'.  $ticketid . '</a>'.'</td></tr>';
						$display .= '<tr><td colspan="5"><a href="' . 'task.php?view=update&type='.$type.'&taskid='.$id.'">'.'Return Request</a>';
						$display .='</td></tr></table></td></tr>';							
					}		
				echo $display;	
				}
			}
	?>
		</table>
<?php
	}
}
if((isset($_GET['view'])) && ($_GET['view'] == 'bycus'))
{
?>
	<table>	
		<tr>
			<td align="center" colspan="4"><font size="4"><b>
				RESULTS
			</b></td>
		</tr>
		<tr>
			<td align="center" colspan="4"><i>
				Newest on Top
			</i></td>
		</tr>
<?php	
	mysql_select_db($dbname2);
	$customer = $_GET['custnum'];
	$query8 = "SELECT * FROM taskinfo WHERE ((Type = 11 OR Type = 28) AND (CustomerNumber = '$customer')) ORDER BY Createdate DESC";
	$result8 = mysql_query($query8) or die (mysql_error());
	while($row8 = mysql_fetch_array($result8))
	{
		$id = $row8['ID'];
		$type = $row8['Type'];
		mysql_select_db($dbname);
		$cusnum = $row8['CustomerNumber'];
		$datecreated = strtotime($row8['Createdate']);
		$display_date_created = date('m-d-Y',$datecreated);
		$ticketid = $row8['ticketNum'];
		$taskstatus = $row8['Status'];	
		mysql_select_db($dbname2);
		$query12 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
		$result12 = mysql_query($query12) or die (mysql_error());
		$row12 = mysql_fetch_array($result12);		
		$status = $row12['Status'];
		mysql_select_db($dbname);
		$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$cusnum'";
		$result4 = mysql_query($query4) or die (mysql_error());
		$row4 = mysql_fetch_array($result4);							
		if($type == 11)
		{			
			mysql_select_db($dbname2);	
			$query13 = "SELECT ID,Type,ticketNum From taskinfo WHERE ticketNum = '$ticketid' AND Type = 28";
			$result13 = mysql_query($query13) or die (mysql_error());
			$row13 = mysql_fetch_array($result13);		
			$count13 = mysql_num_rows($result13);
			if($count13 > 0)
			{
				mysql_select_db($dbname2);	
				$query14 = "SELECT * From taskinfo WHERE ticketNum = '$ticketid' AND Type = 28";
				$result14 = mysql_query($query14) or die (mysql_error());
				$row14 = mysql_fetch_array($result14);
				if($taskstatus == 2)
				{ 
					$extra_status_comment = '(Equipment Repaired)';
				}else
				{
					$extra_status_comment = '';
				}
				$query15 = "SELECT * From tbltaskaudit WHERE taskid = '$id' Order By ID desc";
				$result15 = mysql_query($query15) or die (mysql_error());
				$row15 = mysql_fetch_array($result15);
				if(($row15['response'] == 2002) && ($row15['status'] <> 3))
				{		
					$audit_trail = '<br><li>Equipment Received ->';
				}elseif(($row15['response'] == 2000) && ($row15['status'] <> 3))
				{
					$audit_trail = '<br><li>Equipment Received -> <br><li>Equipment Repaired, Waiting for Order Approval ->';
				}elseif(($row15['response'] == 2001) && ($row15['status'] <> 3))
				{
					$audit_trail = '<br><li>Equipment Received -> <br><li>Equipment Repaired, Waiting for Order Approval -> <br><li>Order Approved, Ready to Ship ->';
				}elseif($row15['status'] == 3)
				{
					$ship_date = strtotime($row15['Date']);
					$display_ship_date = date('m-d-Y',$ship_date);
					$audit_trail = '<br><li>Equipment Received -> <br><li>Equipment Repaired, Waiting for Order Approval -> <br><li>Order Approved, Ready to Ship -> <br><li>Shipped'.' '. $display_ship_date.' -> ';
				}
				$tasktype = $row14['Type'];
				$display = '<tr><td class="SectionNav" width="749"><table><tr><td colspan="5"><b>'.$row4['FacilityName'].'</b></td></tr>';
				$display .= '<tr><td width="130">Current Status:</td><td>'.$status.' '.$extra_status_comment.'</td></tr>';
				$display .= '<tr><td colspan="5">Date Submitted:'.' '.$display_date_created.'</td></tr>';
				$display .= '<tr><td>Ticket Reference:</td><td>'.'<a href="' . '../csPortal_Tickets.php?ticket_num='.$ticketid.'&by_ticket=ticket">'.  $ticketid . '</a>'.'</td></tr>';
				$display .= '<tr><td colspan="5"><a href="' . 'task.php?view=update&type='.$tasktype.'&taskid='.$row14['ID'].'">'.'Return Request</a> ->';
				$display .=	$audit_trail;
				$display .='<a href="' . 'task.php?view=update&type='.$tasktype.'&taskid='.$id.'">View Equipment Return Task</td></tr></table></td></tr>';
			}
		}
		if($type == 28)
		{
			$display = '<tr><td class="SectionNav" width="749"><table><tr><td colspan="5"><b>'.$row4['FacilityName'].'</b></td></tr>';
			$display .= '<tr><td width="130">Current Status:</td><td>'.$status.'</td></tr>';
			$display .= '<tr><td colspan="5">Date Submitted:'.' '.$display_date_created.'</td></tr>';
			$display .= '<tr><td>Ticket Reference:</td><td>'.'<a href="' . '../csPortal_Tickets.php?ticket_num='.$ticketid.'&by_ticket=ticket">'.  $ticketid . '</a>'.'</td></tr>';
			$display .= '<tr><td colspan="5"><a href="' . 'task.php?view=update&type='.$type.'&taskid='.$id.'">'.'Return Request</a>';
			$display .='</td></tr></table></td></tr>';							
		}		
	echo $display;	
	}
}