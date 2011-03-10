<?php
include '../includes/configtask.php';
include '../includes/opendbtask.php';
//require '../includes/functions.inc.php';
$date = date('Y-m-d H:i:s');
$dates = strtotime($date);
$now = strtotime("now");
mysql_select_db('homefree');
$query = "SELECT id,email FROM employees";
$result = mysql_query($query) or die (mysql_error());
while($row = mysql_fetch_array($result))
{
	if($row['email'] == "Maryp@homefreesys.com")
	{
		$maryid = $row['id'];
	}
	if($row['email'] == "Avib@homefreesys.com")
	{
		$aviid = $row['id'];
	}	
	if($row['email'] == "Andrewc@homefreesys.com")
	{
		$andrewid = $row['id'];
	}		
	if($row['email'] == "Toddj@homefreesys.com")
	{
		$toddid = $row['id'];
	}			
	if($row['email'] == "Drewd@homefreesys.com")
	{
		$drewid = $row['id'];
	}
	if($row['email'] == "Mikes@homefreesys.com")
	{
		$mikeid = $row['id'];
	}	
	if($row['email'] == "Justinh@homefreesys.com")
	{
		$justinid = $row['id'];
	}		
	if($row['email'] == "Billl@homefreesys.com")
	{
		$billid = $row['id'];
	}			
	if($row['email'] == "Danhn@homefreesys.com")
	{
		$danhid = $row['id'];
	}		
	if($row['email'] == "Shawnf@homefreesys.com")
	{
		$shawnid = $row['id'];
	}		
}
/*
**********************************************************ACTIVE TASK STATS**********************************************
*/
mysql_select_db('work');
$query13 = "SELECT * FROM taskinfo WHERE employeedept = 2 AND assigntodept = 0 AND Response <> '$maryid' AND Response <> '$aviid' AND Response <> '$andrewid' AND Response <> '$toddid'";
$result13 = mysql_query($query13) or die (mysql_error());
$count13 = mysql_num_rows($result13);
$query16 = "SELECT * FROM taskinfo WHERE assigntodept = 2 AND Assignto <> '$maryid' AND Assignto <> '$aviid' AND Assignto <> '$andrewid' AND Assignto <> '$toddid'";
$result16 = mysql_query($query16) or die (mysql_error());
$count16 = mysql_num_rows($result16);
$query14 = "SELECT * FROM taskinfo WHERE assigntodept = 2 AND Assignto <> '$maryid' AND Assignto <> '$aviid' AND Assignto <> '$andrewid' AND Assignto <> '$toddid' AND Status <> 3 AND Status <> 4";
$result14 = mysql_query($query14) or die (mysql_error());
$count14 = mysql_num_rows($result14);
$query18 = "SELECT * FROM taskinfo WHERE employeedept = 2 AND assigntodept = 0 AND Response <> '$maryid' AND Response <> '$aviid' AND Response <> '$andrewid' AND Response <> '$toddid' AND Status <> 3 AND Status <> 4";
$result18 = mysql_query($query18) or die (mysql_error());
$count18 = mysql_num_rows($result18);
$c = ($count16 + $count13);
$a = 0;
while($row14 = mysql_fetch_array($result14))
{		
	$duedate = strtotime($row14['Duedate']);
  if($duedate < $now)
 	{
		$a = $a + 1;
 	}
}
$b = ($count18 + $count14);
$query15 = "SELECT * FROM taskinfo WHERE employeedept = 2 AND assigntodept = 0 AND Response <> '$maryid' AND Response <> '$aviid' AND Response <> '$andrewid' AND Response <> '$toddid' AND Status = 3";
$result15 = mysql_query($query15) or die (mysql_error());
$count15 = mysql_num_rows($result15);
$query19 = "SELECT * FROM taskinfo WHERE employeedept = 2 AND assigntodept = 0 AND Response <> '$maryid' AND Response <> '$aviid' AND Response <> '$andrewid' AND Response <> '$toddid' AND Status = 4";
$result19 = mysql_query($query19) or die (mysql_error());
$count19 = mysql_num_rows($result19);
$query17 = "SELECT * FROM taskinfo WHERE assigntodept = 2 AND Assignto <> '$maryid' AND Assignto <> '$aviid' AND Assignto <> '$andrewid' AND Assignto <> '$toddid' AND Status = 3";
$result17 = mysql_query($query17) or die (mysql_error());
$count17 = mysql_num_rows($result17);
$query20 = "SELECT * FROM taskinfo WHERE assigntodept = 2 AND Assignto <> '$maryid' AND Assignto <> '$aviid' AND Assignto <> '$andrewid' AND Assignto <> '$toddid' AND Status = 4";
$result20 = mysql_query($query20) or die (mysql_error());
$count20 = mysql_num_rows($result20);
$d = ($count17 + $count15);
$e = 0;
$f = 0;
$g = 0;
$h = 0;
$i = ($count19 + $count20);

while($row15 = mysql_fetch_array($result15))
{		
	$completiondate = strtotime($row15['Completiondate']);
	$duedate = strtotime($row15['Duedate']);
  if($completiondate > $duedate)
 	{
		$e = ($e + 1);
 	}
 	if($completiondate < $duedate)
 	{
		$f = ($f + 1);
 	}
}
while($row17 = mysql_fetch_array($result17))
{		
	$completiondate = strtotime($row17['Completiondate']);
	$duedate = strtotime($row17['Duedate']);
  if($completiondate > $duedate)
 	{
		$g = ($g + 1);
 	}
 	if($completiondate < $duedate)
 	{
		$h = ($h + 1);
 	}
}
$y = ($f + $h);
$z = ($e + $g);
$aa = ($y + $z);
$ab = round(($aa / $c),4);
$ac = ($ab * 100);
$ad = round($y / $c,4) * 100;
$ae = round($z / $c,4) * 100;
/*
**********************************************************ACTIVE TASK STATS TYPE**********************************************
*/
$query21 = " SELECT ID from tbltype WHERE Type = 'RMA'";
$result21 = mysql_query($query21) or die (mysql_error());
$row21 = mysql_fetch_array($result21);
$typerma = $row21['ID'];
$query22 = "SELECT ID FROM taskinfo WHERE Type = '$typerma'";
$result22 = mysql_query($query22) or die (mysql_error());
$count22 = mysql_num_rows($result22);
$query23 = " SELECT ID from tbltype WHERE Type = 'FLOORPLAN'";
$result23 = mysql_query($query23) or die (mysql_error());
$row23 = mysql_fetch_array($result23);
$typeplan = $row23['ID'];
$query24 = "SELECT ID FROM taskinfo WHERE Type = '$typeplan'";
$result24 = mysql_query($query24) or die (mysql_error());
$count24 = mysql_num_rows($result24);
$query25 = " SELECT ID from tbltype WHERE Type = 'TECHNICAL CALL NEEDED'";
$result25 = mysql_query($query25) or die (mysql_error());
$row25 = mysql_fetch_array($result25);
$typetech = $row25['ID'];
$query26 = "SELECT ID FROM taskinfo WHERE Type = '$typetech'";
$result26 = mysql_query($query26) or die (mysql_error());
$count26 = mysql_num_rows($result26);
$query27 = " SELECT ID from tbltype WHERE Type = 'Customer Site Visit Report'";
$result27 = mysql_query($query27) or die (mysql_error());
$row27 = mysql_fetch_array($result27);
$typetech = $row27['ID'];
$query28 = "SELECT ID FROM taskinfo WHERE Type = '$typetech'";
$result28 = mysql_query($query28) or die (mysql_error());
$count28 = mysql_num_rows($result28);
?>
<h3>Technical Task Statistics</h3>

<table width = "100%" align="center" border = "0">
	<tr align="center">
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						Total Tasks
					</td>
				</tr>
				<tr>
					<td align="center">
						<?php echo $c; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						Open Tasks
					</td>
				</tr>
				<tr>
					<td align = "center" class="body"><font color="#000000">
						<?php echo $b; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						Open Overdue Tasks
					</td>
				</tr>		
				<tr>
					<td align = "center" class="body"><font color="#ff0000">
						<?php echo $a; ?>
					</td>	
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td class="border">
			<table>			
				<tr>
					<td align = "center" class="heading"><font color="#000000">
						Total Closed Tasks
					</td>
				</tr>
				<tr>
					<td align = "center" class="body"><font color="#000000">
						<?php echo $d; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						Closed On Time Tasks
					</td>	
				</tr>		
				<tr>
					<td align = "center" class="body"><font color="#000000">
						<?php echo $y; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						Closed Overdue Tasks
					</td>
				</tr>
				<tr>
					<td align = "center" class="body"><font color="#ff0000">
						<?php echo $z; ?>
					</td>
				</tr>	
			</table>			
		</td>
	</tr>			
	<tr align="center">
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						Cancelled Tasks
					</td>
				</tr>
				<tr>
					<td align = "center" class="body"><font color="#000000">
						<?php echo $i; ?>			
					</td>
				</tr>
			</table>
		</td>
	</tr>		
	<tr align="center">
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						% tasks closed
					</td>
				</tr>
				<tr>
					<td align = "center" class="body"><font color="#000000">
						<?php echo '% '.$ac; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						% tasks closed on time
					</td>				
				</tr>
				<tr>
					<td align = "center" class="body"><font color="#000000">
						<?php echo '% '.$ad; ?>
					</td>	
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						% tasks closed overdue
					</td>
				</tr>
				<tr>
					<td align = "center" class="body"><font color="#ff0000">
						<?php echo '% '.$ae; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table width = "100%" align="center" border = "0">
	<tr align="center">
		<td class="border" width="25%">
			<table>
				<tr>
					<td class="heading" align="center"><font color="#000000">
						RMAs
					</td>
				</tr>
				<tr>
					<td class="body" align="center">
						<?php echo $count22; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border" width="25%">
			<table>
				<tr>
					<td class="heading" align="center">
						Floorplans
					</td>
				</tr>
				<tr>
					<td class="body" align="center">
						<?php echo $count24; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border" width="25%">
			<table>
				<tr>
					<td class="heading" align="center">
						Tech call needed
					</td>
				</tr>
				<tr>
					<td class="body" align="center">
						<?php echo $count26; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border" width="25%">
			<table>
				<tr>
					<td class="heading" align="center">
						Site Visit
					</td>
				</tr>
				<tr>
					<td class="body" align="center">
						<?php echo $count28; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>