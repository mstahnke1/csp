<link rel="stylesheet" type="text/css" href="sales.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>Customer History</title>
<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
$f_id = $_GET['f_id'];
mysql_select_db('testhomefree');
$query100 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
$result100 = mysql_query($query100) or die (mysql_error());
$row100 = mysql_fetch_array($result100);
?>
<table border="0" width="750">
	<tr>
		<td align="center" class="historyheader">
			Customer History
		</td>
	</tr>
	<tr>
		<td  align="center" class="historyheader">
			<?php echo $row100['FacilityName']; ?>
		</td>
	</tr>
</table>			
<?php
$groupid = '-1';
mysql_select_db('testwork');
$query = "SELECT * FROM tblfacilitygeneralinfo WHERE Cust_Num = '$f_id'";
$result = mysql_query($query) or die (mysql_error());
$count = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$id = $row['ID'];
$groupid = $row['GroupID'];
if($count < 1)
{
	mysql_select_db('testhomefree');
	$query = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	$groupid = '-1';
}
/*******************************************IF IN GROUP**************************************/	
if($groupid <> '-1')
{		
	mysql_select_db('testwork');
	$query2 = "SELECT ID,Cust_Num FROM tblfacilitygeneralinfo WHERE GroupID = '$groupid'";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2);	
?>
	<FIELDSET>
	<table border="0" width="750">
		<tr>
			<td class="bigheading" colspan="4">
				Install Tickets:
			</td>
		</tr>
<?php
	$b = 0;	
	while($row2 = mysql_fetch_array($result2))
	{
		$facilityid = $row2['ID'];
		//echo '<tr><td>'.$facilityid.'</td></tr>';
		$cust_num = $row2['Cust_Num'];
		//echo '<tr><td>'.$facilityid.'</td></tr>';
		mysql_select_db('testwork');
	 	$query3 = "SELECT * FROM tblinstalltickets WHERE FacilityID = '$facilityid' OR FacilityID = '$cust_num' ORDER BY Date";
	 	$result3 = mysql_query($query3) or die (mysql_error());
 		$count3 = mysql_num_rows($result3);
	 	if($count3 > 0)
	 	{
	 		$b = $b + 1;
	 	}
	 	if($b > 0)
	 	{
			while($row3 = mysql_fetch_array($result3))
			{
				$type = $row3['Type'];
				$employeeid = $row3['Openedby'];
				mysql_select_db('testwork');
				$query4 = "SELECT * FROM tbltype WHERE ID = '$type'";
				$result4 = mysql_query($query4) or die (mysql_error());
				$row4 = mysql_fetch_array($result4);
				mysql_select_db('testhomefree');
				$query5 = "SELECT id,f_name,l_name FROM employees WHERE ID = '$employeeid'";
				$result5 = mysql_query($query5) or die (mysql_error());
				$row5 = mysql_fetch_array($result5);			
?>			
				<tr>
					<td class="heading" width="70">
						Ticket No:
					</td>
					<td class="body" width="20">
						<?php echo $row3['ID']; ?>
					</td>
					<td class="heading" width="55">
						Type:
					</td>
					<td class="body">
						<?php echo $row4['Type']; ?>
					</td>
					<td class="heading" width="55">
						Contact:
					</td>
					<td class="body">
						<?php echo $row3['ContactName'].' @ ' .formatPhone($row3['ContactNumber']).' Ext: '. $row3['Extension']; ?>
					</td>
				</tr>				
				<tr>
					<td class="heading" valign="top">
						Details:
					</td>				
					<td class="body" colspan="6">
						<?php echo $row3['Description']; ?>
					</td>
				</tr>
				<tr>	
					<td class="heading">
						Opened By:
					</td>								
					<td class="body" colspan="6">
						<?php echo $row5['l_name'].', '.$row5['f_name'].' @ '.$row3['Date']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<div align="center"><hr width="100%"></div>
					</td>
				</tr>	
<?php		
			}
		$installticks = 1;
		}else
		{
			$installticks = 0;
		}
	}
	if($installticks == 0)
	{
		echo '<tr><td>'.'No Install Tickets on Record'.'</td></tr>';
	}
?>
	</table>
	</FIELDSET>
<?php
}else
{
?>	
	<FIELDSET>
	<table border="0" width="750">
		<tr>
			<td class="bigheading" colspan="4">
				Install Tickets:
			</td>
		</tr>
<?php		
	mysql_select_db('testwork');
 	$query3 = "SELECT * FROM tblinstalltickets WHERE FacilityID = '$f_id' OR FacilityID = '$id' ORDER BY Date";
 	$result3 = mysql_query($query3) or die (mysql_error());
 	$count3 = mysql_num_rows($result3);
 	if($count3 > 0)
 	{
		while($row3 = mysql_fetch_array($result3))
		{
			$type = $row3['Type'];
			$employeeid = $row3['Openedby'];
			mysql_select_db('testwork');
			$query4 = "SELECT * FROM tbltype WHERE ID = '$type'";
			$result4 = mysql_query($query4) or die (mysql_error());
			$row4 = mysql_fetch_array($result4);
			mysql_select_db('testhomefree');
			$query5 = "SELECT id,f_name,l_name FROM employees WHERE ID = '$employeeid'";
			$result5 = mysql_query($query5) or die (mysql_error());
			$row5 = mysql_fetch_array($result5);			
?>			
			<tr>
				<td class="heading" width="70">
					Ticket No:
				</td>
				<td class="body" width="20">
					<?php echo $row3['ID']; ?>
				</td>
				<td class="heading" width="55">
					Type:
				</td>
				<td class="body">
					<?php echo $row4['Type']; ?>
				</td>
				<td class="heading" width="55">
					Contact:
				</td>
				<td class="body">
					<?php echo $row3['ContactName'].' @ ' .formatPhone($row3['ContactNumber']).' Ext: '. $row3['Extension']; ?>
				</td>
			</tr>			
			<tr>
				<td class="heading" valign="top">
					Details:
				</td>				
				<td class="body" colspan="6">
					<?php echo $row3['Description']; ?>
				</td>
			</tr>
			<tr>	
				<td class="heading">
					Opened By:
				</td>								
				<td class="body" colspan="6">
					<?php echo $row5['l_name'].', '.$row5['f_name'].' @ '.$row3['Date']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<div align="center"><hr width="100%"></div>
				</td>
			</tr>	
<?php		
		}
	}else
	{
		echo '<tr><td colspan=6>'.'No Install Tickets'.'</td></tr>';
	}
?>
	</table>
	</FIELDSET>
<?php
}
?>
<table>
	<tr>
		<td>
			<br>
		</td>
	</tr>
</table>
<FIELDSET>
<table border="0" width="750">
	<tr>
		<td class="bigheading">
			Site Visits:
		</td>
	</tr>		
<?php
mysql_select_db('testwork');
$query9 = "SELECT * FROM epc_calendar WHERE FacilityID = '$f_id' AND Active <> 0 ORDER BY startDate";
$result9 = mysql_query($query9) or die (mysql_error()); 
$count9 = mysql_num_rows($result9);
if($count9 > 0)
{
	while($row9 = mysql_fetch_array($result9))	
	{
		$callnumber = $row9['serviceid'];
		$startdate = date('m-d-Y',$row9['startDate']);
		$enddate = date('m-d-Y',$row9['endDate']);
		$companyid = $row9['company'];
		$query10 = "SELECT * FROM tblcompany WHERE ID = '$companyid'";
		$result10 = mysql_query($query10) or die (mysql_error()); 
		$row10 = mysql_fetch_array($result10);
		if(($row9['type'] == 15) && ($row9['Status'] == 6))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Install Scheduled For:
				</td>
				<td class="body">
					<?php echo $startdate.' thru '.$enddate.' by '.$row10['Company']; ?>
				</td>
			</tr>
<?php
		}
		if(($row9['type'] == 15) && ($row9['Status'] == 4))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Install was Canceled:
				</td>
				<td class="body">
					<?php echo $startdate.' thru '.$enddate .' by '.$row10['Company']; ?>
				</td>
			</tr>
<?php			
		}
		if(($row9['type'] == 15) && ($row9['Status'] == 3))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Install was Completed:
				</td>
				<td class="body">
					<?php echo 'on '.$row9['comptime'] .' by '.$row10['Company']; ?>
				</td>
			</tr>
<?php			
		}	
		if(($row9['type'] == 19) && ($row9['Status'] == 6))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Training Scheduled For:
				</td>
				<td class="body">
					<?php echo $startdate.' thru '.$enddate .' by '.$row10['Company']; ?>
				</td>
			</tr>
<?php
		}
		if(($row9['type'] == 19) && ($row9['Status'] == 4))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Training was Canceled:
				</td>
				<td class="body">
					<?php echo $startdate.' thru '.$enddate .' by '.$row10['Company']; ?>
				</td>
			</tr>
<?php			
		}
		if(($row9['type'] == 19) && ($row9['Status'] == 3))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Training was Completed:
				</td>
				<td class="body">
					<?php echo 'on '.$row9['comptime'] .' by '.$row10['Company']; ?>
				</td>
			</tr>
<?php			
		}
		if(($row9['type'] == 17) && ($row9['Status'] == 6))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Service Call Scheduled For:
				</td>
				<td class="body">
					<?php echo $startdate.' thru '.$enddate.' by '.$row10['Company'].' <a href="' . 'servicecall.php?view=finished&custnumber='.$f_id.'&callnumber='.$callnumber.'">View Call</a>'; ?>
				</td>
			</tr>
<?php
		}
		if(($row9['type'] == 17) && ($row9['Status'] == 4))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Service Call was Canceled:
				</td>
				<td class="body">
					<?php echo $startdate.' thru '.$enddate .' by '.$row10['Company']; ?>
				</td>
			</tr>
<?php			
		}
		if(($row9['type'] == 17) && ($row9['Status'] == 3))
		{
?>		
			<tr>
				<td class="heading" width="200">
					Service Call was Completed:
				</td>
				<td class="body">
					<?php echo 'on '.$row9['comptime'] .' by '.$row10['Company'].' <a href="' . 'servicecall.php?view=finished&custnumber='.$f_id.'&callnumber='.$callnumber.'">View Call</a>'; ?>
				</td>
			</tr>
<?php			
		}							
	}
}else
{
	echo '<tr><td>'.'No Install, Training, or Service Calls on Record'. '</td></tr>';
}
?>					
</table>
</FIELDSET>
<table>
	<tr>
		<td>
			<br>
		</td>
	</tr>
</table>		
<FIELDSET>
<table border="0" width="750">
	<tr>
		<td colspan="4" class="bigheading">
			Open Support Tickets:
		</td>
	</tr>
	<tr>
		<td width="130">
		</td>
		<td width="100">
		</td>
		<td width="100">
		</td>
		<td width="455">
		</td>
	</tr>			
<?php
mysql_select_db('testhomefree');
$query6 = "SELECT * FROM tbltickets WHERE CustomerNumber = '$f_id' AND Status = 0 ORDER BY DateOpened";
$result6 = mysql_query($query6) or die (mysql_error());
if(mysql_num_rows($result6) > 0)
{
	while($row6 = mysql_fetch_array($result6))
	{
		//$type = $row6['Type'];
		$employeeid = $row6['OpenedBy'];
		mysql_select_db('testhomefree');
		$query8 = "SELECT id,f_name,l_name FROM employees WHERE ID = '$employeeid'";
		$result8 = mysql_query($query8) or die (mysql_error());
		$row8 = mysql_fetch_array($result8);
		
?>			
			<tr>
				<td class="heading">
					Ticket No:
				</td>
			<td class="body">
				<a href="../csPortal_Tickets.php?ticket_num=<?php echo $row6['ID']; ?>&by_ticket=ticket"><?php echo $row6['ID']; ?></a>
			</td>
			</tr>
			<tr>
				<td class="heading">
					Type:
				</td>
				<td class="body">
<?php 
					if($row6['Type'] == 0)
					{
			 			echo 'Office Hours Call Center'; 
			 		}
					if($row6['Type'] == 1)
					{
						echo 'After Hours Call Center';
					}
					if($row6['Type'] == 6)
					{
						echo 'Site Visit/Service Call';
					}
					if($row6['Type'] == 4)
					{ 
						echo 'Site Visit/Training';
					}
					if($row6['Type'] == 3)
					{ 
						echo 'Procactive Call';
					}		
?>	
				</td>					
			<tr>
				<td class="heading" valign="top">
					Summary:
				</td>				
				<td class="body" colspan="4">
					<?php echo $row6['Summary']; ?>
				</td>
			</tr>
			<tr>	
				<td class="heading">
					Opened By:
				</td>								
				<td class="body" colspan="4">
					<?php echo $row8['l_name'].', '.$row8['f_name'].' @ '.$row6['DateOpened']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div align="center"><hr width="100%"></div>
				</td>
			</tr>	
<?php	
		}
	}else
	{
		echo '<tr><td colspan=6>'.'No Open Support Tickets'.'</td></tr>';
	}
?>		
	<tr>
		<td colspan="4" class="bigheading">
			Other Support Tickets:
		</td>
	</tr>	
<?php				
	mysql_select_db('testhomefree');
 	$query6 = "SELECT * FROM tbltickets WHERE CustomerNumber = '$f_id' AND Status <> 0 ORDER BY DateOpened";
 	$result6 = mysql_query($query6) or die (mysql_error());
 	$count6 = mysql_num_rows($result6);
 	if($count6 > 0)
 	{
		while($row6 = mysql_fetch_array($result6))
		{		
			$employeeid = $row6['OpenedBy'];
			mysql_select_db('testhomefree');
			$query8 = "SELECT id,f_name,l_name FROM employees WHERE ID = '$employeeid'";
			$result8 = mysql_query($query8) or die (mysql_error());
			$row8 = mysql_fetch_array($result8);
			$ticket = $row6['ID'];
			$query11 = "SELECT * FROM tblticketmessages WHERE TicketID = '$ticket'";	
			$result11 = mysql_query($query11) or die (mysql_error());
			$query14 = "SELECT * FROM filemanager WHERE refNumber = '$ticket' AND publish <> 0";
			$result14 = mysql_query($query14) or die (mysql_error());
			$count14 = mysql_num_rows($result14);
?>										
			<tr>
				<td class="heading">
					Ticket No:
				</td>
				<td class="body">
					<a href="../csPortal_Tickets.php?ticket_num=<?php echo $row6['ID']; ?>&by_ticket=ticket"><?php echo $row6['ID']; ?></a>
				</td>
				<td class="heading">
					Type:
				</td>
				<td class="body" colspan="3">
<?php 
					if($row6['Type'] == 0)
					{
			 			echo 'Office Hours Call Center'; 
			 		}
					if($row6['Type'] == 1)
					{
						echo 'After Hours Call Center';
					}
					if($row6['Type'] == 6)
					{
						echo 'Site Visit/Service Call';
					}
					if($row6['Type'] == 4)
					{ 
						echo 'Site Visit/Training';
					}
					if($row6['Type'] == 3)
					{ 
						echo 'Procactive Call';
					}		
?>	
				</td>									
			</tr>								
			<tr>
				<td class="heading" valign="top">
					Summary:
				</td>				
				<td class="body" colspan="4">
					<?php echo $row6['Summary']; ?>
				</td>
			</tr>
			<tr>	
				<td class="heading">
					Opened By:
				</td>								
				<td class="body" colspan="4">
					<?php echo $row8['l_name'].', '.$row8['f_name'].' @ '.$row6['DateOpened']; ?>
				</td>
			</tr>
		
<?php
			if($count14 > 0)
			{
?>
				<tr>
					<td class="heading" valign="top">
						Files:
					</td>	
					<td>
<?php
						while($row14 = mysql_fetch_array($result14))
						{					
?>
	
							<?php echo '<a href="'.'../'.$row14['location'].'"><font face="Arial" size="2">' . $row14['name'] . '</font></a>'; ?><br>
<?php
						}
?>	
					</td>			
				</tr>				
<?php	
			}		
			while($row11 = mysql_fetch_array($result11))
			{
				$remarkadd = $row11['EnteredBy'];
				$query12 = "SELECT id,f_name,l_name FROM employees WHERE ID = '$remarkadd'";
				$result12 = mysql_query($query12) or die (mysql_error());
				$row12 = mysql_fetch_array($result12);
	?>			
				<tr>
					<td class="heading">
						<blockquote>Remark:</blockquote>
					</td>
					<td class="body" colspan="4">
						<?php echo $row11['Message']; ?>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td class="heading">
						Added By:
					</td>
					<td class="body" colspan="4">
						<?php echo $row12['l_name'].', '.$row12['f_name'].' @ '.$row11['Date']; ?>
					</td>
				</tr>						
	<?php
			}
	?>
			</tr>
			<tr>
				<td colspan="4">
					<div align="center"><hr width="100%"></div>
				</td>
			</tr>	
	<?php						
		}
	}else
	{
		echo '<tr><td colspan="4"> No Tickets on Record </td></tr>';
	}
?>	
</table>
</FIELDSET>
<table>
	<tr>
		<td>
			<br>
		</td>
	</tr>
</table>
<FIELDSET>
<table border="0" width="750">
	<tr>
		<td class="bigheading">
			Files
		</td>
	</tr>
<?php
$query13 = "SELECT name,location,refNumber,attachType,timestamp FROM filemanager WHERE refNumber = '$f_id' AND publish <> 0";
$result13 = mysql_query($query13) or die (mysql_error());
$count13 = mysql_num_rows($result13);
if($count13 > 0)
{
	while($row13 = mysql_fetch_array($result13))
	{
		if($row13['attachType'] == 'customer')
		{			
?>
			<tr>
				<td class="body">
					<?php echo '<a href="'.'../'.$row13['location'].'"><font face="Arial" size="2">' . $row13['name'] . '</font></a>'; ?>
				</td>	
				<td>
			</tr>
<?php
		}
	}
}else
{
	echo '<tr><td>'.'No Files Attached to this Customer'.'</td></tr>';
}
?>
</table>
</FIELDSET>
<?php		
