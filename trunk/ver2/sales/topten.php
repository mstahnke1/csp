<?php
if(!isset($_GET['view']))
{
	include 'header.php';
?>
<link rel="stylesheet" type="text/css" href="proactive.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>Proactive Call Center</title>
<?php
}
	include '../includes/config.inc.php';
	include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
require_once 'Spreadsheet/Excel/Writer.php';
$date = date('Y-m-d H:i:s');
if(!isset($_GET['view']))
{
	if(isset($_GET['prm']))
	{
		$prm = $_GET['prm'];
		$chm = $_GET['chm'];
		$m=$prm+$chm;
	}else
	{
		$m= date("m");
	}
	$prevdate1 = mktime(0, 0, 0, date($m)-2, 01, date('Y'));
	$nextdate2 = mktime(0, 0, 0, date($m), 01, date('Y'));
	$end = strtotime($date);
	$x=0;
?>
	<table>
		<tr>
			<td align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="topten.php?prm=<?php echo $m; ?>&chm=-1"><font face="Arial" size="2" color="white"><b>Previous Month</b>
			</font></a></td>
			<td align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="topten.php?prm=<?php echo $m; ?>&chm=+1"><font face="Arial" size="2" color="white"><b>Next Month</b>
			</font></a></td>
			<td align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="topten.php"><font face="Arial" size="2" color="white"><b>Current Month</b>
			</font></a></td>
			<td align="center" width="128" height="25">
			</font></a></td>					
			<td align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="proactivecall.php"><font face="Arial" size="2" color="white"><b>Proactive Home</b>
			</font></a></td>											
		</tr>
	</table>
	<table>
		<tr>
<?php
	for($cursor=$prevdate1;$cursor <= $nextdate2; $cursor = strtotime('+1 month',$cursor))
	{
		if($x == 0)
		{
			$startdate1 = $prevdate1;
			$firstdate = date('Y-m-d 00:00:00',$prevdate1);
			$sm = date('m',$prevdate1); 
			$sy = date('Y',$prevdate1);
			$no_of_days = date('t',mktime(0,0,0,$sm,1,$sy));
			$startdate = $firstdate;
			$nextdate1 = mktime(0, 0, 0, date($sm), $no_of_days, $sy);
			$nextdate = date('Y-m-d H:i:s',$nextdate1);
		}else
		{	
			$startdate1 = $cursor;
			$startmonth = date('m',$startdate1);
			$startyear = date('Y',$startdate1);
			$no_of_days = date('t',mktime(0,0,0,$startmonth,1,$startyear));
			$startdate = date('Y-m-d H:i:s',$startdate1);
			$nextdate1 = mktime(0, 0, 0, date($startmonth), $no_of_days, $startyear);
			$nextdate = date('Y-m-d H:i:s',$nextdate1);			
		}
		mysql_select_db($dbname);	
		$query3 = "SELECT *, Count(CustomerNumber) AS custCount, Count(tblTickets.id) AS ticketCount FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID
							WHERE tblTicketMessages.Date >= '$startdate' AND
							tblTicketMessages.Date <= '$nextdate' AND tblTickets.rmaReturn <> 1 GROUP BY CustomerNumber ORDER BY custCount DESC	LIMIT 10";
		$result3 = mysql_query($query3) or die(mysql_error());

?>
			<td class="border" valign="top">
				<table border="0" align="left" width="250" cellspacing="0" cellpadding="0">
					<tr>
						<td class="heading" colspan="3">
							<?php echo date('m-d-Y',$startdate1); ?> thru <?php echo date('m-d-Y',$nextdate1); ?>
						</td>
					</tr>
<?php
					while($row3 = mysql_fetch_array($result3))
					{
						$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$row3[CustomerNumber]'";
						$result4 = mysql_query($query4);
						$row4 = mysql_fetch_assoc($result4);
						if(isset($_GET['prm']))
						{
?>			
							<tr>
								<td class="body">
									<?php echo '<a href="'.'topten.php?stdate='.$startdate1.'&enddate='.$nextdate1.'&prm='.$prm.'&chm='.$chm.'&fid='.$row3['CustomerNumber'].'">'.$row3['CustomerNumber'].'</a> '.$row4['FacilityName'].' <i>('.$row3['custCount'].')</i>'; ?>
								</td>
							</tr>
<?php
						}else
						{
?>						
							<tr>
								<td class="body">
									<?php echo '<a href="'.'topten.php?stdate='.$startdate1.'&enddate='.$nextdate1.'&fid='.$row3['CustomerNumber'].'">'.$row3['CustomerNumber'].'</a> '.$row4['FacilityName'].' <i>('.$row3['custCount'].')</i>'; ?>
								</td>
							</tr>
<?php
						}
					}
?>
				</table>
			</td>
<?php
		$x = $x + 1;
	}
?>
		</tr>
	</table>
	<table>
		<tr>
			<td colspan="2" align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="topten.php?view=exporttopten"><font face="Arial" size="2" color="white"><b>Export Top Ten</b>
			</font></a></td>			
		</tr>			
	</table>
<?php
}
if(isset($_GET['fid']))
{
	$fid = $_GET['fid'];
	$stdate = date('Y-m-d', $_GET['stdate']);
	$enddate = date('Y-m-d', $_GET['enddate']);
	mysql_select_db($dbname);
	$query5 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$fid'";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_fetch_array($result5);
	mysql_select_db($dbname2);
	$query = "SELECT max(ID) FROM tblproactivecall WHERE CustomerNumber = '$fid'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	$id = $row['max(ID)'];
	$query1 = "SELECT DateOpened FROM tblproactivecall WHERE ID = '$id' AND Successful = 1";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_fetch_array($result1);
	$count1 = mysql_num_rows($result1);
	$query7 = "SELECT max(ID) FROM epc_calendar WHERE FacilityID = '$fid'";
	$result7 = mysql_query($query7) or die (mysql_error());
	$row7 = mysql_fetch_array($result7);
	$installid = $row['max(ID)'];
	$query6 = "SELECT comptime FROM epc_calendar WHERE ID = '$installid'";
	$result6 = mysql_query($query6) or die (mysql_error());
	$row6 = mysql_fetch_array($result6);
	$installdate = strtotime($row6['comptime']);
	$calldate = strtotime($row1['DateOpened']);
?>
	<table>
		<tr>
			<td colspan="12">
				# of calls for <?php echo $row5['FacilityName'];?>
			</td>
		</tr>
		<tr>		
<?php		
	$ttm = date('m',$calldate);	
	$tty = date('Y',$calldate);	
	$call_date_for_check = $tty.'-'.$ttm;
	$check_date = strtotime('-6 months',$date);
	$check_date = date('Y-m',$check_date);
	if($check_date > $call_date_for_check)
	{
		$ttm = date('m',$calldate);	
		$tty = date('Y',$calldate);	
		$ttstartdate = mktime(0, 0, 0, date($ttm)-6, 01, date($tty));
		$ttenddate = mktime(0, 0, 0, date($ttm)+6, 01, date($tty));
	}else
	{
		$ttm = date('m');	
		$tty = date('Y');	
		$ttstartdate = mktime(0, 0, 0, date($ttm)-12, 01, date($tty));
		$ttenddate = mktime(0, 0, 0, date($ttm), 01, date($tty));
	}
		$x=0;
		for($cursor=$ttstartdate;$cursor <= $ttenddate; $cursor = strtotime('+1 month',$cursor))
		{
			if($x == 0)
			{
				$startdate1 = $ttstartdate;
				$firstdate = date('Y-m-d 00:00:00',$ttstartdate);
				$sm = date('m',$startdate1); 
				$sy = date('Y',$startdate1);
				$no_of_days = date('t',mktime(0,0,0,$sm,1,$sy));
				$startdate = $firstdate;
				$nextdate1 = mktime(0, 0, 0, date($sm), $no_of_days, $sy);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);
			}else
			{	
				$startdate1 = $cursor;
				$startmonth = date('m',$startdate1);
				$startyear = date('Y',$startdate1);
				$no_of_days = date('t',mktime(0,0,0,$startmonth,1,$startyear));
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = mktime(0, 0, 0, date($startmonth), $no_of_days, $startyear);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);
				//echo $startdate;			
			}
			mysql_select_db($dbname);
			$query2 = "SELECT *, Count(CustomerNumber) AS custCount, Count(tblTickets.id) AS ticketCount FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID
								WHERE CustomerNumber = '$fid' AND tblTicketMessages.Date > '$startdate' 
								AND tblTicketMessages.Date < '$nextdate' AND tblTickets.rmaReturn <> 1 GROUP BY CustomerNumber ORDER BY custCount";
			$result2 = mysql_query($query2) or die(mysql_error());	
			$row2 = mysql_fetch_array($result2);	
			if(($calldate >= $startdate1) && ($calldate <= $nextdate1))
			{
					$prodate = date('n-j-Y',$calldate);
			}else
			{
				$prodate = '';
			}
			if(($installdate >= $startdate1) && ($installdate <= $nextdate1))
			{
					$idate = date('n-j-Y',$installdate);
			}else
			{
				$idate = '2';
			}			
?>
			<td align="center" class="legend" width="70">
<?php 	
			if($row2['custCount'] > 0)
			{
				echo $row2['custCount']; 
			}else
			{
				echo '0';
			}
			echo '<br>'.date('n-j-Y',$startdate1).'<br>'.'<font color="3333FF"'.$idate.'</font>'.'<font color="#FF0000">'.$prodate.'</font>'.'<br><font color="#000000">'.date('n-j-Y',$nextdate1).'</font>';
?>
			</td>									
<?php		
		$x = 1;	
		}	
?>
		</tr>
		<tr>
			<td colspan="13" height="30" background="images/test.png">			
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="topten.php?view=exportresults&f_id=<?php echo $fid; ?>"><font face="Arial" size="2" color="white"><b>Export Results</b>
			</font></a></td>	
			<td align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="../csPortal_ticketReportsNew.php?datefrom=<?php echo $stdate; ?>&dateto=<?php echo $enddate; ?>&cust_num=<?php echo $fid; ?>" target="_blank"><font face="Arial" size="2" color="white"><b>View Details</b>
			</font></a></td>					
		</tr>		
	</table>
<?php		
}
if((isset($_GET['view'])) && ($_GET['view'] == 'exporttopten'))
{
	// Creating a workbook
  $workbook = new Spreadsheet_Excel_Writer();
  // sending HTTP headers
  $workbook->send('csPortal_Report_'.date('Ymd').'T'.date('His').'.xls');
  // Creating a worksheet
  $worksheet =& $workbook->addWorksheet('Report Details');
  // Creating the format
  $format_wrap =& $workbook->addFormat();
	$format_wrap->setTextWrap( );
	$format_center =& $workbook->addFormat();
	$format_center->setHAlign('center');
	$format_bold =& $workbook->addFormat();
	$format_bold->setBold();
  $m = date('m');	
	$prevdate1 = mktime(0, 0, 0, date($m)-12, 01, date('Y'));
	$nextdate2 = mktime(0, 0, 0, date($m), 01, date('Y'));
	$end = strtotime($date);
	$x=0;
	$ecol = -2;
	for($cursor=$prevdate1;$cursor <= $nextdate2; $cursor = strtotime('+1 month',$cursor))
	{
		if($x == 0)
		{
			$startdate1 = $prevdate1;
			$firstdate = date('Y-m-d 00:00:00',$prevdate1);
			$sm = date('m',$prevdate1); 
			$sy = date('Y',$prevdate1);
			$no_of_days = date('t',mktime(0,0,0,$sm,1,$sy));
			$startdate = $firstdate;
			$nextdate1 = mktime(0, 0, 0, date($sm), $no_of_days, $sy);
			$nextdate = date('Y-m-d H:i:s',$nextdate1);
		}else
		{	
			
			$startdate1 = $cursor;
			$startmonth = date('m',$startdate1);
			$startyear = date('Y',$startdate1);
			$no_of_days = date('t',mktime(0,0,0,$startmonth,1,$startyear));
			$startdate = date('Y-m-d H:i:s',$startdate1);
			$nextdate1 = mktime(0, 0, 0, date($startmonth), $no_of_days, $startyear);
			$nextdate = date('Y-m-d H:i:s',$nextdate1);			
		}
		mysql_select_db($dbname);	
		$query3 = "SELECT *, Count(CustomerNumber) AS custCount, Count(tblTickets.id) AS ticketCount FROM tblTickets LEFT JOIN tblTicketMessages 
							ON tblTickets.ID = tblTicketMessages.TicketID WHERE tblTicketMessages.Date > '$startdate' 
							AND tblTicketMessages.Date < '$nextdate' AND tblTickets.rmaReturn <> 1 GROUP BY CustomerNumber ORDER BY custCount DESC
							LIMIT 10";
		$result3 = mysql_query($query3) or die(mysql_error());
		$exceldate = date('M, y',$startdate1);
		$ecol = $ecol + 2;
		$worksheet->setColumn($ecol,$ecol,40);
		$worksheet->write(0, $ecol, $exceldate,$format_bold);
		$erow = 0;  
		while($row3 = mysql_fetch_array($result3))
		{
			$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$row3[CustomerNumber]'";
			$result4 = mysql_query($query4);
			$row4 = mysql_fetch_assoc($result4);
			$erow = $erow + 1;
 			$worksheet->write($erow, $ecol, $row4['FacilityName']);
 			$ecol = $ecol + 1;
 			$worksheet->write($erow, $ecol, $row3['custCount']);
 			$ecol = $ecol - 1;
		}
		$x = $x + 1;		
	}
	$workbook->close();
	exit();	
}
if((isset($_GET['view'])) && ($_GET['view'] == 'exportresults'))
{
	// Creating a workbook
  $workbook = new Spreadsheet_Excel_Writer();
  // sending HTTP headers
  $workbook->send('csPortal_Report_'.date('Ymd').'T'.date('His').'.xls');
  // Creating a worksheet
  $worksheet =& $workbook->addWorksheet('Report Details');
  // Creating the format
  $format_wrap =& $workbook->addFormat();
	$format_wrap->setTextWrap( );
	$format_center =& $workbook->addFormat();
	$format_center->setHAlign('center');
	$format_bold =& $workbook->addFormat();
	$format_bold->setBold();		
	$fid = $_GET['f_id'];
	mysql_select_db($dbname);
	$query5 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$fid'";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_fetch_array($result5);
	mysql_select_db($dbname2);
	$query = "SELECT max(ID) FROM tblproactivecall WHERE CustomerNumber = '$fid'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	$id = $row['max(ID)'];
	$query1 = "SELECT DateOpened FROM tblproactivecall WHERE ID = '$id' AND Successful = 1";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_fetch_array($result1);
	$count1 = mysql_num_rows($result1);
	$query7 = "SELECT max(ID) FROM epc_calendar WHERE FacilityID = '$fid'";
	$result7 = mysql_query($query7) or die (mysql_error());
	$row7 = mysql_fetch_array($result7);
	$installid = $row['max(ID)'];
	$query6 = "SELECT comptime FROM epc_calendar WHERE ID = '$installid'";
	$result6 = mysql_query($query6) or die (mysql_error());
	$row6 = mysql_fetch_array($result6);
	$installdate = strtotime($row6['comptime']);
	$calldate = strtotime($row1['DateOpened']);
	$worksheet->setColumn(0,0,30);
	$worksheet->setColumn(1,13,10);
	$erow = 0;
	$worksheet->write($erow, 0, $row5['FacilityName'],$format_bold);
	$erow = $erow + 1;
	$worksheet->write($erow, 0, 'Start Date',$format_bold);
	$erow = $erow + 1;
	$worksheet->write($erow, 0, 'Proactive Call Date',$format_bold);
	$erow = $erow + 1;
	$worksheet->write($erow, 0, 'End Date',$format_bold);
	$erow = $erow + 1;
	$worksheet->write($erow, 0, '# of Calls',$format_bold);
	if($count1 > 0)
	{
		$ttm = date('m',$calldate);	
		$tty = date('Y',$calldate);	
		$ttstartdate = mktime(0, 0, 0, date($ttm)-6, 01, date($tty));
		$ttenddate = mktime(0, 0, 0, date($ttm)+6, 01, date($tty));
	}else
	{
		$ttm = date('m');	
		$tty = date('Y');	
		$ttstartdate = mktime(0, 0, 0, date($ttm)-12, 01, date($tty));
		$ttenddate = mktime(0, 0, 0, date($ttm), 01, date($tty));
	}
	$x=0;
	$erow = 0;
	$ecol = 0;
	for($cursor=$ttstartdate;$cursor <= $ttenddate; $cursor = strtotime('+1 month',$cursor))
	{
		$erow = $erow + 1;
		$ecol = $ecol + 1;
		if($x == 0)
		{
			$startdate1 = $ttstartdate;
			$firstdate = date('Y-m-d 00:00:00',$ttstartdate);
			$sm = date('m',$startdate1); 
			$sy = date('Y',$startdate1);
			$no_of_days = date('t',mktime(0,0,0,$sm,1,$sy));
			$startdate = $firstdate;
			$nextdate1 = mktime(0, 0, 0, date($sm), $no_of_days, $sy);
			$nextdate = date('Y-m-d H:i:s',$nextdate1);
		}else
		{	
			$startdate1 = $cursor;
			$startmonth = date('m',$startdate1);
			$startyear = date('Y',$startdate1);
			$no_of_days = date('t',mktime(0,0,0,$startmonth,1,$startyear));
			$startdate = date('Y-m-d H:i:s',$startdate1);
			$nextdate1 = mktime(0, 0, 0, date($startmonth), $no_of_days, $startyear);
			$nextdate = date('Y-m-d H:i:s',$nextdate1);
			//echo $startdate;			
		}
		mysql_select_db($dbname);
		$query2 = "SELECT *, Count(CustomerNumber) AS custCount, Count(tblTickets.id) AS ticketCount FROM tblTickets LEFT JOIN tblTicketMessages 
						ON tblTickets.ID = tblTicketMessages.TicketID WHERE CustomerNumber = '$fid' AND tblTicketMessages.Date > '$startdate' 
						AND tblTicketMessages.Date < '$nextdate' AND tblTickets.rmaReturn <> 1 GROUP BY CustomerNumber ORDER BY custCount";
		$result2 = mysql_query($query2) or die(mysql_error());	
		$row2 = mysql_fetch_array($result2);	
		if(($calldate >= $startdate1) && ($calldate <= $nextdate1))
		{
				$prodate = date('n-j-Y',$calldate);
		}else
		{
			$prodate = '';
		}
		/*
		if(($installdate >= $startdate1) && ($installdate <= $nextdate1))
		{
				$idate = date('n-j-Y',$installdate);
		}else
		{
			$idate = '2';
		}	
		*/		
		if($row2['custCount'] > 0)
		{
			$callcount = $row2['custCount']; 
		}else
		{
			$callcount = 0;
		}
		$worksheet->write($erow, $ecol, date('n-j-Y',$startdate1));
		$erow = $erow +1;
		$worksheet->write($erow, $ecol, $prodate);
		$erow = $erow +1;
		$worksheet->write($erow, $ecol, date('n-j-Y',$nextdate1));
		$erow = $erow +1;
		$worksheet->write($erow, $ecol, $callcount);
		$erow = 0;
		$x = 1;	
	}	
		$workbook->close();
	exit();	
}	
?>	