<?php
include '../includes/configtask.php';
include '../includes/opendbtask.php';
//require '../includes/functions.inc.php';
$date = date('Y-m-d H:i:s');
$dates = strtotime($date);
$now = strtotime("now");
mysql_select_db('testhomefree');
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
mysql_select_db('testwork');
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
$ab = round(($aa / $c),2);
$ac = ($ab * 100);
$ad = round($y / $c,2) * 100;
$ae = round($z / $c,2) * 100;
?>
<h3>Technical Task Statistics</h3>
<p>
<table width = "100%" align = "center" border = "0">
	<tr>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			Total Technical Tasks
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			Open Technical Tasks
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			Open Overdue Technical Tasks
		</td>
	</tr>			
	<tr>
		<td align = "center"><font face="Arial" size="10px" color="#000000">
			<?php echo $c; ?>
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			<?php echo $b; ?>
		</td>
		<td align = "center"><font face="Arial" size="2" color="#ff0000">
			<?php echo $a; ?>
		</td>		
	</tr>		
	<tr>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			Total Closed Technical Tasks
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			Closed On Time Technical Tasks
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			Closed Overdue Technical Tasks
		</td>
	</tr>			
	<tr>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			<?php echo $d; ?>
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			<?php echo $y; ?>
		</td>
		<td align = "center"><font face="Arial" size="2" color="#ff0000">
			<?php echo $z; ?>
		</td>
	</tr>	

		<td align = "center"><font face="Arial" size="2" color="#000000">
			Cancelled Tasks
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
		</td>
		<td align = "center"><font face="Arial" size="2" color="#ff0000">
		</td>
	</tr>		
	<tr>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			<?php echo $i; ?>			
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">

		</td>
		<td align = "center"><font face="Arial" size="2" color="#ff0000">
		</td>
	</tr>		
	<tr>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			% tasks closed
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			% tasks closed on time
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			% tasks closed overdue
		</td>
	</tr>		
	<tr>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			<?php echo '% '.$ac; ?>
		</td>
		<td align = "center"><font face="Arial" size="2" color="#000000">
			<?php echo '% '.$ad; ?>
		</td>
		<td align = "center"><font face="Arial" size="2" color="#ff0000">
			<?php echo '% '.$ae; ?>
		</td>
	</tr>			
	<tr>		
</table>