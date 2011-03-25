<?php
include 'includes/config.php';
include 'includes/opendb.php';
	$query20 = "SELECT * FROM tblproactivecall";
	$result20 = mysql_query($query20) or die (mysql_error());
	$count20 = mysql_num_rows($result20);	
	$query21 = "SELECT * FROM tblproactivecall WHERE Message = -1";
	$result21 = mysql_query($query21) or die (mysql_error());
	$count21 = mysql_num_rows($result21);
	$query22 = "SELECT * FROM tblproactivecall WHERE Successful = 1";
	$result22 = mysql_query($query22) or die (mysql_error());
	$count22 = mysql_num_rows($result22);		
	$query23 = "SELECT * FROM tblproactivecall WHERE Message <> -1 AND callback = -1";
	$result23 = mysql_query($query23) or die (mysql_error());
	$row23 = mysql_fetch_array($result23);		
	$count23 = mysql_num_rows($result23);		
	$query24 = "SELECT * FROM tblproactivecall WHERE Message <> -1 AND callback <> -1 AND Successful = -1";
	$result24 = mysql_query($query24) or die (mysql_error());
	$count24 = mysql_num_rows($result24);	
	$query25 = "SELECT SUM(q1) FROM tblproactivecall WHERE q1 <> -1";
	$result25 = mysql_query($query25) or die (mysql_error());
	$sum25 = mysql_fetch_array($result25);	
	$query26 = "SELECT q1 FROM tblproactivecall WHERE q1 <> -1";
	$result26 = mysql_query($query26) or die (mysql_error());
	$count26 = mysql_num_rows($result26);		
	$overallavg = $sum25['SUM(q1)']/$count26;
	$overallavg = round($overallavg,2);	
	$query27 = "SELECT SUM(q2) FROM tblproactivecall WHERE q2 <> -1";
	$result27 = mysql_query($query27) or die (mysql_error());
	$sum27 = mysql_fetch_array($result27);	
	$query28 = "SELECT q2 FROM tblproactivecall WHERE q2 <> -1";
	$result28 = mysql_query($query28) or die (mysql_error());
	$count28 = mysql_num_rows($result28);		
	$sysperfavg = $sum27['SUM(q2)']/$count28;
	$sysperfavg = round($sysperfavg,2);	
	$query29 = "SELECT SUM(q3) FROM tblproactivecall WHERE q3 <> -1";
	$result29 = mysql_query($query29) or die (mysql_error());
	$sum29 = mysql_fetch_array($result29);	
	$query30 = "SELECT q3 FROM tblproactivecall WHERE q3 <> -1";
	$result30 = mysql_query($query30) or die (mysql_error());
	$count30 = mysql_num_rows($result30);		
	$techperfavg = $sum29['SUM(q3)']/$count30;
	$techperfavg = round($techperfavg,2);
	$customernumber = $row23['CustomerNumber'];	
	mysql_select_db('testhomefree');
	$query31 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$customernumber'";
	$result31 = mysql_query($query31) or die (mysql_error());
	$row31 = mysql_fetch_array($result31);	
?>
	<table width="750">
		<tr>
			<td align="center" class="bigheading" colspan="3">
				Proactive Call Center
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td class="border" valign="top">
				<table width="120">
					<tr>
						<td>
							<a href="proactivecall.php?view=newticket&history=1"><img src="images/viewcustomerhistory.gif" border="0" onmouseover="this.src='images/viewcustomerhistorymouseover.gif'" onmouseout="this.src='images/viewcustomerhistory.gif'";" alt="Click to view customer history."></a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="proactivecall.php?view=newticket"><img src="images/newticket.gif" border="0" onmouseover="this.src='images/newticketmouseover.gif'" onmouseout="this.src='images/newticket.gif'";" alt="Click to add a call."></a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="proactivecall.php?view=reports"><img src="images/reports.gif" border="0" onmouseover="this.src='images/reportsmouseover.gif'" onmouseout="this.src='images/reports.gif'";" alt="Click to go to Reports."></a>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table width="350">
					<tr>
						<td class="heading">
							Total Proactive Calls Initiated:
						</td>
						<td>
							<?php echo $count20; ?>
						</td>
					</tr>
					<tr>
						<td class="heading">
							Completed Calls:
						</td>
						<td>
							<?php echo ($count21 + $count22); ?>
						</td>
					</tr>
					<tr>
						<td class="heading">
							Pending Calls:
						</td>
						<td>
							<?php echo $count23; ?>
						</td>
					</tr>	
					<tr>
						<td class="heading">
							Unsuccessful Calls:
						</td>
						<td>
							<?php echo $count24; ?>
						</td>
					</tr>															
				</table>
			</td>
			<td>
				<table>
					<tr>
						<td class="heading">
							Overall Satisfaction:
						</td>
						<td>
							<?php echo $overallavg; ?>
						</td>
					</tr>
					<tr>
						<td class="heading">
							System Performance:
						</td>
						<td>
							<?php echo $sysperfavg; ?>
						</td>
					</tr>	
					<tr>
						<td class="heading">
							Technical Performance:
						</td>
						<td>
							<?php echo $techperfavg; ?>
						</td>
					</tr>												
				</table>
			</td>
		</tr>
	</table>	
