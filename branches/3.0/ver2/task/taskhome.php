<?php
include 'header.php';
$conn1 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db('homefree');
$email = $_SESSION['mail'];
$uid = $_SESSION['uid'];
$query = "SELECT id, f_name, l_name, dept, recRmaEmail, recFloorplan, manageRma FROM employees WHERE id = '$uid'";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result);
$employeeid = $row['id'];
$dsrma = $row['recRmaEmail'];
$hfrma = $row['dept'];
$hffloorplan = $row['recFloorplan'];
$managerma = $row['manageRma'];
$arr = array("dsrma" => $dsrma, "hfrma" => $hfrma, "hffloorplan" => $hffloorplan,"managerma" => $managerma);
$dept = $row['dept']; 
mysql_close($conn1);	 

include 'includes/configtask.php';
include 'includes/opendbtask.php';
require 'includes/functions.inc.php';

$date = date('Y-m-d H:i:s');
$lastweek =  strtotime("-1 week");
$lastmonth =  strtotime("-1 month");
$lastmonth =  date('Y-m-d H:i:s', $lastmonth);
$nextweek =  strtotime("+1 week");
$plus1Day =  strtotime("+1 day");
$now = strtotime("now");
$less1day = strtotime("-1 day");
$less12hours = strtotime("-12 hours");
?>
<link rel="stylesheet" type="text/css" href="../csPortal_Layout.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HomeFree Task Management</title>
<table cellpadding=3 table border ="0" width="750" align ="center">

<?php
if((isset($_GET['view'])) && ($_GET['view']=="updatedtask"))
	{
?>
			<tr>
				<td>
					<b><font color="#ff0000">Task Updated Succesfully!</font></b>			
				</td>
			</tr>
<?php
	}
?>					
	<tr>
		<td width = "400" valign = "top" rowspan = "5">
			<button onClick="window.location='task.php?q1=q1'">New Task</button>
			<button onClick="window.location='taskreporthome.php'">Reports</button>
<?php
			if($_SESSION['access'] == 10)
				{
?>					
					<button onClick="window.location='taskaudit.php'">Task History</button> 
<?php					
				}		
?>					
		</td>
		<td>
		</td>
		<td align="right">
			<a href="openissues.php"<img src="../images/up_arrow.jpg" WIDTH=25 HEIGHT=25>Escalated Issues</a>
		</td>
	</tr>
</table>

<?php
if((!isset($_GET['view'])) OR (isset($_GET['view'])) && ($_GET['view']=="updatedtask"))
{
	$query1 = "SELECT ID,Duedate FROM taskinfo ";
	foreach($arr as $val)
	{
		if($val != "-1" OR  $val = "Save")
		{
  	  $query1 .= "WHERE ((Status <> 3 AND Status <> 4) AND (";
  	  break;
 	 	}
	}    
	$where = array();
	$where [ ] = "Response = '$employeeid'";
	if($arr['dsrma'] == 1)
	{
		$where [ ] = "Response = 2000";
	}
	if($arr['hfrma'] == 5)
	{
		$where [ ] = "Response = 2001";
	}	
	if($arr['hffloorplan'] == 1)
	{
		$where [ ] = "Response = 1000";
	}		
	if($arr['managerma'] == 1)
	{
		$where [ ] = "Response = 2002";
	}		
	if(!empty($where)){
	  $query1 .= implode(" OR ", $where);
	}
	$query1 .= "))";
	$result1 = mysql_query($query1) or die(mysql_error());
	$rescount = mysql_num_rows($result1);
	$a = 0;
	$b = 0;
	$c = 0;
	while($row1 = mysql_fetch_array($result1))
	{		
		$duedate = strtotime($row1['Duedate']);
		if($duedate < $now)
		{
			$a = $a + 1;
		}
		if(($duedate < $plus1Day) & ($duedate > $now))
		{
			$b = $b + 1;
		}
	}	
	/*if($hffloorplan == 1)
	{
		$query1= "SELECT ID,Duedate FROM taskinfo WHERE (((Response = '$employeeid') OR (Response = '1000')) AND (Status <> 3 AND Status <> 4))";
		$result1 = mysql_query($query1) or die (mysql_error());
		$rescount = mysql_num_rows($result1);
		$a = 0;
		$b = 0;
		$c = 0;
		while($row1 = mysql_fetch_array($result1))
		{		
			$duedate = strtotime($row1['Duedate']);
			if($duedate < $now)
			{
				$a = $a + 1;
			}
			if(($duedate < $plus1Day) & ($duedate > $now))
			{
				$b = $b + 1;
			}
		}
	}elseif($dsrma == 1)
	{
		$query1= "SELECT ID,Duedate FROM taskinfo WHERE (((Response = '$employeeid') OR (Response = '2000')) AND (Status <> 3 AND Status <> 4))";
		$result1 = mysql_query($query1) or die (mysql_error());
		$rescount = mysql_num_rows($result1);
		$a = 0;
		$b = 0;
		$c = 0;
		while($row1 = mysql_fetch_array($result1))
		{		
			$duedate = strtotime($row1['Duedate']);
			if($duedate < $now)
			{
				$a = $a + 1;
			}
			if(($duedate < $plus1Day) & ($duedate > $now))
			{
				$b = $b + 1;
			}
		}		
	}elseif($hfrma == 1)
	{
		$query1= "SELECT ID,Duedate FROM taskinfo WHERE (((Response = '$employeeid') OR (Response = '2001')) AND (Status <> 3 AND Status <> 4))";
		$result1 = mysql_query($query1) or die (mysql_error());
		$rescount = mysql_num_rows($result1);
		$a = 0;
		$b = 0;
		$c = 0;
		while($row1 = mysql_fetch_array($result1))
		{		
			$duedate = strtotime($row1['Duedate']);
			if($duedate < $now)
			{
				$a = $a + 1;
			}
			if(($duedate < $plus1Day) & ($duedate > $now))
			{
				$b = $b + 1;
			}
		}		
	}else
	{
		$query1= "SELECT ID,Duedate FROM taskinfo WHERE ((Response = '$employeeid') AND (Status <> 3 AND Status <> 4))";
		$result1 = mysql_query($query1) or die (mysql_error());
		$rescount = mysql_num_rows($result1);
		$a = 0;
		$b = 0;
		$c = 0;
		while($row1 = mysql_fetch_array($result1))
		{		
			$duedate = strtotime($row1['Duedate']);
			if($duedate < $now)
			{
				$a = $a + 1;
			}
			if(($duedate < $plus1Day) & ($duedate > $now))
			{
				$b = $b + 1;
			}
		}
	}	
	*/	
	$query2= "SELECT ID,Duedate FROM taskinfo WHERE ((Response2 = '$employeeid') AND (Status <> 3 AND Status <> 4))";
	$result2 = mysql_query($query2) or die (mysql_error());
	$corescount = mysql_num_rows($result2);
	$c = 0;
	$d = 0;
		while($row2 = mysql_fetch_array($result2))
			{		
				$duedate = strtotime($row2['Duedate']);
        if($duedate < $now)
        	{
        		$c = $c + 1;
        	}
        if(($duedate < $plus1Day) & ($duedate > $now))
           {
            $d = $d + 1;
           }
			}
?>
<FIELDSET>
<table cellpadding=3 table border ="0" width="759" align ="center">
	<tr>
		<td align = center colspan = "6" class="bigheading">
			All Open Tasks
		</td>
	</tr>
	<tr>
		<td colspan =2 width = 230 class="heading">
			You are responsible for <?php echo $rescount; ?> tasks
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'response' .'&response='.'all'.'">'.  'VIEW ALL' . 	'</td>' ; ?>
		<td colspan =2 width = 230 class="heading">
			You are co-responsible for <?php echo $corescount; ?> tasks
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'coresponse' .'&coresponse='.'all'.'">'.  'VIEW ALL' . 	'</td>' ; ?>				
	</tr>
	<tr>
		<td>
		</td>
		<td class="body">
			Over Due: <?php echo $a; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'response' .'&response='.'overdue'.'">'.  'VIEW' . 	'</td>' ; ?>
		<td>
		</td>
		<td class="body">
			Over Due: <?php echo $c; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'coresponse' .'&coresponse='.'overdue'.'">'.  'VIEW' . 	'</td>' ; ?>				
	</tr>
	<tr>
		<td>
		</td>
		<td class="body">
			Due Today: <?php echo $b; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'response' .'&response='.'duetoday'.'">'.  'VIEW' . 	'</td>' ; ?>
		<td>
		</td>
		<td class="body">
			Due Today: <?php echo $d; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'coresponse' .'&coresponse='.'duetoday'.'">'.  'VIEW' . 	'</td>' ; ?>
	</tr>
</table>

<?php
	$query3= "SELECT ID,Duedate FROM taskinfo WHERE ((Response3 = '$employeeid') AND (Status <> 3 AND Status <> 4))";
	$result3 = mysql_query($query3) or die (mysql_error());
	$checkcount = mysql_num_rows($result3);
	$a = 0;
	$b = 0;
	$c = 0;
		while($row3 = mysql_fetch_array($result3))
			{		
				$duedate = strtotime($row3['Duedate']);
        if($duedate < $now)
        	{
        		$a = $a + 1;
        	}
        if(($duedate < $plus1Day) & ($duedate > $now))
           {
            $b = $b + 1;
           }
			}
	$query4= "SELECT ID,Duedate FROM taskinfo WHERE ((Assignto = '$employeeid') AND (Response <> 2001 AND Response <> 2000) AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";;
	$result4 = mysql_query($query4) or die (mysql_error());
	$assigncount = mysql_num_rows($result4);
	$c = 0;
	$d = 0;

		while($row4 = mysql_fetch_array($result4))
			{		
				$duedate = strtotime($row4['Duedate']);
        if($duedate < $now)
        	{
        		$c = $c + 1;
        	}
        if(($duedate < $plus1Day) & ($duedate > $now))
           {
            $d = $d + 1;
           }
			}			
?>

<table cellpadding=3 table border ="0" width="759" align ="center">
	<tr>
		<td colspan =2 width = "230" class="heading">
			Tasks you are to check <?php echo $checkcount; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'check' .'&check='.'all'.'">'.  'VIEW ALL' . 	'</td>' ; ?>
		<td colspan =2 width = "230" class="heading">
			Tasks you are assigned <?php echo $assigncount; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'assign' .'&assign='.'all'.'">'.  'VIEW ALL' . 	'</td>' ; ?>			
	</tr>
	<tr>
		<td>
		</td>
		<td class="body">
			Over Due: <?php echo $a; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'check' .'&check='.'overdue'.'">'. 'VIEW' . 	'</td>' ; ?>
		<td>
		</td>
		<td class="body">
			Over Due: <?php echo $c; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'assign' .'&assign='.'overdue'.'">'.  'VIEW' . 	'</td>' ; ?>				
	</tr>
	<tr>
		<td>
		</td>
		<td class="body">
			Due Today: <?php echo $b; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'check' .'&check='.'duetoday'.'">'.  'VIEW' . 	'</td>' ; ?>
		<td>
		</td>
		<td class="body">
			Due Today: <?php echo $d; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'assign' .'&assign='.'duetoday'.'">'.  'VIEW' . 	'</td>' ; ?>				
	</tr>
<?php
	$query5 = "SELECT ID,Duedate,Status FROM taskinfo WHERE ((Createdby = '$employeeid') AND (Status <> 3 AND Status <> 4))";
	$result5 = mysql_query($query5) or die (mysql_error());
	$createcount = mysql_num_rows($result5);
	$a = 0;
	$b = 0;

		while($row5 = mysql_fetch_array($result5))
			{		
				$createdstatus = $row5['Status'];
				$duedate = strtotime($row5['Duedate']);
        if($duedate < $now)
        	{
        		$a = $a + 1;
        	}
        if(($duedate < $plus1Day) & ($duedate > $now))
           {
            $b = $b + 1;
           }
			}			
?>
</table>
<table cellpadding=3 table border ="0" width="350" align ="center">
	<tr>
		<td colspan =2 width = "230" class="heading">
			Tasks you you have created <?php echo $createcount; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'check' .'&created='.'all'.'">'.  'VIEW ALL' . 	'</td>' ; ?>
	</tr>
	<tr>
		<td>
		</td>
		<td class="body">
			Over Due: <?php echo $a; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'check' .'&created='.'overdue'.'">'. 'VIEW' . 	'</td>' ; ?>
		<td>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td class="body">
			Due Today: <?php echo $b; ?>
		</td>
			<?php echo  '<td><font face="Arial" size="1"><a href="' . 'taskhome.php'.'?view='.'check' .'&created='.'duetoday'.'">'.  'VIEW' . 	'</td>' ; ?>
		<td>
		</td>
	</tr>
</table>
</FIELDSET>
<?php
	}


if((isset($_GET['view'])) && ($_GET['view'] <> "updatedtask") && ($_GET['view'] <> 'Search'))
{
?>		
	<table align=center width = 750>
		<tr>
			<td class="mediumheading">
				Tasks in order of Due Date.  First Due on top.
			</td>
		</tr>
	</table>
<?php		
	if(isset($_GET['response']))
	{
		$query10 = "SELECT ID,Type,Subject,Status,Duedate FROM taskinfo ";
			foreach($arr as $val)
			{
				if($val != "-1" OR  $val = "Save")
				{
		  	  $query10 .= "WHERE ((Status <> 3 AND Status <> 4) AND (";
		  	  break;
		 	 	}
			}    
			$where = array();
			$where [ ] = "Response = '$employeeid'";
			if($arr['dsrma'] == 1)
			{
				$where [ ] = "Response = 2000";
			}
			if($arr['hfrma'] == 5)
			{
				$where [ ] = "Response = 2001";
			}	
			if($arr['hffloorplan'] == 1)
			{
				$where [ ] = "Response = 1000";
			}	
			if($arr['managerma'] == 1)
			{
				$where [ ] = "Response = 2002";
			}				
			if(!empty($where)){
			  $query10 .= implode(" OR ", $where);
			}
			$query10 .= ")) ORDER BY Duedate";
			$resultallresponse = mysql_query($query10) or die(mysql_error());
	/*		
		if($uid == 1 OR $uid == 45 OR $uid == 8 OR $uid == 25)
		{
			$selectallresponse = "SELECT ID,Type,Subject,Status,Duedate FROM taskinfo WHERE (((Response = '$employeeid') OR (Response = '1000')) AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";
			$resultallresponse = mysql_query($selectallresponse) or die (mysql_error());
		}elseif($dsrma == 1)
		{
			$selectallresponse = "SELECT ID,Type,Subject,Status,Duedate FROM taskinfo WHERE (((Response = '$employeeid') OR (Response = '2000')) AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";
			$resultallresponse = mysql_query($selectallresponse) or die (mysql_error());
		}else
		{
			$selectallresponse = "SELECT ID,Type,Subject,Status,Duedate FROM taskinfo WHERE ((Response = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";
			$resultallresponse = mysql_query($selectallresponse) or die (mysql_error());
		}
		*/
		while($allresponse = mysql_fetch_array($resultallresponse))
		{
			$subject = $allresponse['Subject'];
			$ID = $allresponse['ID'];
			$taskstatus = $allresponse['Status'];
			$duedate1 = $allresponse['Duedate'];
			$duedate = strtotime($duedate1);
			$query12 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
			$result12 = mysql_query($query12) or die (mysql_error());
			$row12 = mysql_fetch_array($result12);		
			$status = $row12['Status'];
			$type = $allresponse['Type'];		
			if(($type == 28) && ($dept == 5))
			{
				$font = "#FF0000";
			}else
			{
				$font = "#000000";
			}
			if($_GET['response']=="all")
			{
?>
				<table border="0" width="98%" cellpadding="3" style="background-image: url(../sales/images/gray.gif);">	
					<tr>
						<td width = "3%">
							<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
						</td>
						<td width="8%" class="heading"><font color="<?php echo $font; ?>">
							Subject:
						</font></td>
						<td class="body" width="63%"><font color="<?php echo $font; ?>">
							 <?php echo $subject; ?>
						</font></td>
						<td width="8%" class="heading"><font color="<?php echo $font; ?>">
							Status:
						</font></td>
						<td class="body" width="16%"><font color="<?php echo $font; ?>">
							<?php echo $status; ?>
						</font></td>			
					</tr>
				</table>
<?php
			}
			if($_GET['response']=="overdue")
			{
				if($duedate < $now)
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
								 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}
			if($_GET['response']=="duetoday")
			{
				if(($duedate < $plus1Day) & ($duedate > $now))
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
								 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}	
		}
	}
	if(isset($_GET['coresponse']))
	{
		$selectallcoresponse = "SELECT ID,Type,Subject,Status,Duedate FROM taskinfo WHERE ((Response2 = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";
		$resultallcoresponse = mysql_query($selectallcoresponse) or die (mysql_error());
		while($allcoresponse = mysql_fetch_array($resultallcoresponse))
		{
			$subject = $allcoresponse['Subject'];
			$ID = $allcoresponse['ID'];
			$taskstatus = $allcoresponse['Status'];
			$duedate1 = $allcoresponse['Duedate'];
			$duedate = strtotime($duedate1);
			$query12 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
			$result12 = mysql_query($query12) or die (mysql_error());
			$row12 = mysql_fetch_array($result12);		
			$status = $row12['Status'];
			$type = $allcoresponse['Type'];
			if($_GET['coresponse']=="all")
			{
?>
				<table border="0" width="98%" cellpadding="3">	
					<tr>
						<td width = "3%"><font face="Arial" size="2">
							<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
						</td>
						<td width="8%" class="heading">
							Subject:
						</td>
						<td class="body" width="63%">
							 <?php echo $subject; ?>
						</td>
						<td width="8%" class="heading">
							Status:
						</td>
						<td class="body" width="16%">
							<?php echo $status; ?>
						</td>			
					</tr>
				</table>
<?php
			}
			if($_GET['coresponse']=="overdue")
			{
				if($duedate < $now)
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
								 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}
			if($_GET['coresponse']=="duetoday")
			{
				if(($duedate < $plus1Day) & ($duedate > $now))
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
								 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}	
		}
	}
	if(isset($_GET['check']))
	{
		$selectallcheck = "SELECT ID,Type,Subject,Status,Duedate FROM taskinfo WHERE ((Response3 = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";
		$resultallcheck = mysql_query($selectallcheck) or die (mysql_error());
		while($allcheck = mysql_fetch_array($resultallcheck))
		{
			$subject = $allcheck['Subject'];
			$ID = $allcheck['ID'];
			$taskstatus = $allcheck['Status'];
			$duedate1 = $allcheck['Duedate'];
			$duedate = strtotime($duedate1);
			$query12 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
			$result12 = mysql_query($query12) or die (mysql_error());
			$row12 = mysql_fetch_array($result12);		
			$status = $row12['Status'];
			$type = $allcheck['Type'];
			if($_GET['check']=="all")
			{
?>
				<table border="0" width="98%" cellpadding="3">	
					<tr>
						<td width = "3%"><font face="Arial" size="2">
							<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
						</td>
						<td width="8%" class="heading">
							Subject:
						</td>
						<td class="body" width="63%">
							 <?php echo $subject; ?>
						</td>
						<td width="8%" class="heading">
							Status:
						</td>
						<td class="body" width="16%">
							<?php echo $status; ?>
						</td>			
					</tr>
				</table>
<?php
			}
			if($_GET['check']=="overdue")
			{
				if($duedate < $now)
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
								 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}
			if($_GET['check']=="duetoday")
			{
				if(($duedate < $plus1Day) & ($duedate > $now))
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
								 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}	
		}
	}				
	if(isset($_GET['assign']))
	{
		$selectallassign = "SELECT ID,Type,Subject,Status,Duedate FROM taskinfo WHERE ((Assignto = '$employeeid') AND (Response <> 2001 AND Response <> 2000) AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";
		$resultallassign = mysql_query($selectallassign) or die (mysql_error());
		while($allassign = mysql_fetch_array($resultallassign))
		{
			$subject = $allassign['Subject'];
			$ID = $allassign['ID'];
			$taskstatus = $allassign['Status'];
			$duedate1 = $allassign['Duedate'];
			$duedate = strtotime($duedate1);
			$query12 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
			$result12 = mysql_query($query12) or die (mysql_error());
			$row12 = mysql_fetch_array($result12);		
			$status = $row12['Status'];
			$type = $allassign['Type'];
			if($_GET['assign']=="all")
			{
?>
				<table border="0" width="98%" cellpadding="3">	
					<tr>
						<td width = "3%"><font face="Arial" size="2">
							<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
						</td>
						<td width="8%" class="heading">
							Subject:
						</td>
						<td class="body" width="63%">
							 <?php echo $subject; ?>
						</td>
						<td width="8%" class="heading">
							Status:
						</td>
						<td class="body" width="16%">
							<?php echo $status; ?>
						</td>			
					</tr>
				</table>
<?php
			}
			if($_GET['assign']=="overdue")
			{
				if($duedate < $now)
				{
?>	
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
								 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}
			if($_GET['assign']=="duetoday")
			{
				if(($duedate < $plus1Day) & ($duedate > $now))
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
							 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}	
		}
	}	
	if(isset($_GET['created']))
	{
		$selectallcreated = "SELECT ID,Type,Subject,Status,Duedate,Completiondate FROM taskinfo WHERE ((Createdby = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";
		$resultallcreated = mysql_query($selectallcreated) or die (mysql_error());
		while($allcreated = mysql_fetch_array($resultallcreated))
		{
			$subject = $allcreated['Subject'];
			$ID = $allcreated['ID'];
			$taskstatus = $allcreated['Status'];
			$duedate1 = $allcreated['Duedate'];
			$duedate = strtotime($duedate1);
			$query12 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
			$result12 = mysql_query($query12) or die (mysql_error());
			$row12 = mysql_fetch_array($result12);		
			$status = $row12['Status'];
			$type = $allcreated['Type'];
			if($_GET['created']=="all")
			{
?>
				<table border="0" width="98%" cellpadding="3">	
					<tr>
						<td width = "3%"><font face="Arial" size="2">
							<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
						</td>
						<td width="8%" class="heading">
							Subject:
						</td>
						<td class="body" width="63%">
							 <?php echo $subject; ?>
						</td>
						<td width="8%" class="heading">
							Status:
						</td>
						<td class="body" width="16%">
							<?php echo $status; ?>
						</td>			
					</tr>
				</table>
<?php
			}
			if($_GET['created']=="overdue")
			{
				if($duedate < $now)
				{
?>	
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
								 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}
			if($_GET['created']=="duetoday")
			{
				if(($duedate < $plus1Day) & ($duedate > $now))
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
							 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php
				}
			}	
		}
	}	
?>
	<table align=center width = 750>
		<tr>
			<td>
				<button onClick="window.location='taskhome.php'">Back to Task Home</button>
			</td>
		</tr>
	</table>
<?php
}		
if(((!isset($_GET['view'])) OR (isset($_GET['view'])) && ($_GET['view']=="updatedtask")) && (!isset($_GET['floorplan'])))
{
?>	
	<table>
		<tr>
			<td width="150">
				<a href="../task/taskhome.php?floorplan=1">View Floor Plans </a>
			</td>
			<td>
				<a href="../task/rmareport.php">View Warranty Checks / RMA's </a>
			</td>			
		</tr>
	</table>
<?php	
}
if(((!isset($_GET['view'])) OR (isset($_GET['view'])) && ($_GET['view']=="updatedtask")) && ((isset($_GET['floorplan'])) && ($_GET['floorplan']==1)))
{
?>
	<table>
		<tr>
			<td colspan="3">
				<a href="../task/taskhome.php">Close Floor Plans</a>
			</td>
		</tr>		
		<tr>
			<td class="heading">
				Find a Floor Plan
			</td>
		</tr>
		<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<tr>
				<td colspan="2">
					Enter Part or Full Facility Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="searchfname" value="">
				</td>
				<td>
					<input type="submit" value="Search" name="view">
				</td>
			</tr>
		</FORM>
<?php
	if(($uid == 4) OR ($uid == 6))
	{
		$a=0;
		//echo $lastmonth;
		$query6 = "SELECT ID FROM taskinfo WHERE Createdate > '$lastmonth' AND Type = 12";
		$result6 = mysql_query($query6) or die (mysql_error());
		while($row6 = mysql_fetch_array($result6))
		{
			$a = $a + 1;
		}
		$query7 = "SELECT count(tblfloorplan.ID) as salescount,tblfloorplan.Salesperson FROM tblfloorplan,taskinfo WHERE taskinfo.ID = tblfloorplan.TaskID AND tblfloorplan.iscanceled <> 0 AND taskinfo.Createdate > '$lastmonth' GROUP BY Salesperson";
		$result7 = mysql_query($query7) or die (mysql_error());
?>				
		<tr>
			<td colspan="3">
				<a href="../task/floorplanreport.php?view=summary">Floor Plan Summary</a>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				Floor Plans submitted in last month (<?php echo $a;?>)
			</td>
		</tr>		
		<tr>
			<td width="120" class="heading">
				Salesperson
			</td>
		</tr>		
<?php
		while($row7 = mysql_fetch_array($result7))
		{
			$salescount = $row7['salescount'];	
			$salesperson = $row7['Salesperson'];
			mysql_select_db('homefree');	
			$query8 = "SELECT f_name,l_name FROM employees WHERE ID = '$salesperson'";
			$result8 = mysql_query($query8) or die (mysql_error());
			$row8 = mysql_fetch_array($result8);
?>	
					
		<tr>
			<td>
				<?php echo '<a href="taskhome.php?view=Search&salesid='.$salesperson.'">'.$row8['f_name'].' '.$row8['l_name'];?>
			</td>
			<td>
				<?php echo $salescount;?>
			</td>
		</tr>
<?php
		}
	}
?>			
	</table>
<?php	
}
if((!isset($_GET['view'])) OR (isset($_GET['view'])) && ($_GET['view']=="updatedtask"))
{
?>
<FIELDSET>
<table align=center width = 750>
	<tr>
		<td class="mediumheading">
			Recently updated tasks
		</td>
	</tr>
<?php
	mysql_select_db('work');
	$lastid = 0;
	$SELECTUPDATED = "SELECT Action,Date,taskid FROM tbltaskaudit WHERE Action = 'UPDATED' OR Action = 'ADDED REMARK' ORDER BY taskid Asc";
	$resSELECTUPDATED = mysql_query($SELECTUPDATED) or die (mysql_error());
	while($updatedtask = mysql_fetch_array($resSELECTUPDATED))
	{
		$updateddate = strtotime($updatedtask['Date']);
		$updatedaction = $updatedtask['Action'];
		$updatedtaskid = $updatedaction = $updatedtask['taskid'];
		if($updateddate > $less1day)
		{
			$selecttaskup = "SELECT ID,Type,Subject,Status,Response, Response2, Response3, Assignto, Createdby FROM taskinfo WHERE ID = '$updatedtaskid'";
			$resselecttaskup = mysql_query($selecttaskup) or die (mysql_error());
			$taskup = mysql_fetch_array($resselecttaskup);
			$ID = $taskup['ID'];
			$taskstatus = $taskup['Status'];
			$subject = $taskup['Subject'];
			$response = $taskup['Response'];
			$coresponse = $taskup['Response2'];
			$check = $taskup['Response3'];
			$assign = $taskup['Assignto'];
			$createdby = $taskup['Createdby'];
			$query12 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
			$result12 = mysql_query($query12) or die (mysql_error());
			$row12 = mysql_fetch_array($result12);		
			$status = $row12['Status'];
			$type = $taskup['Type'];
			if($ID <> $lastid)
			{
				if((($response == 1000) && ($dept == 2)) OR ($response == $employeeid) OR ($coresponse == $employeeid) OR ($check == $employeeid) OR ($assign == $employeeid) OR ($createdby == $employeeid))
				{
?>
					<table border="0" width="98%" cellpadding="3">	
						<tr>
							<td width = "3%"><font face="Arial" size="2">
								<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update&type='.$type.'">'.  $ID;?>
							</td>
							<td width="8%" class="heading">
								Subject:
							</td>
							<td class="body" width="63%">
							 <?php echo $subject; ?>
							</td>
							<td width="8%" class="heading">
								Status:
							</td>
							<td class="body" width="16%">
								<?php echo $status; ?>
							</td>			
						</tr>
					</table>
<?php			
					$lastid = $ID;
				}
			}
		}
	}
?>		
	</table>
</FIELDSET>				
<?php
}
if((isset($_GET['view'])) && ($_GET['view']=='Search'))
{
	if(isset($_GET['searchfname']))
	{
		$searchfname = $_GET['searchfname'];
		$query9 = "SELECT ID,Subject,Type,Status FROM taskinfo WHERE Subject LIKE '%$searchfname%' AND Type = 12 AND Createdate > '2009-06-01 00:00:00' ORDER BY Subject";
		$result9 = mysql_query($query9) or die ('Error retrieving Customer Name Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
		$count9 = mysql_num_rows($result9);
	}
	if(isset($_GET['salesid']))
	{
		$salesid = $_GET['salesid'];
		$query9 = "SELECT ID,Subject,Type,Status FROM taskinfo WHERE ID IN (SELECT TaskID FROM tblfloorplan WHERE Salesperson = '$salesid') ORDER BY Subject";
		$result9 = mysql_query($query9) or die ('Error retrieving Customer Name Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
		$count9 = mysql_num_rows($result9);
	}
?>
		<table>
			<tr>
				<td class="heading">
					Results:
				</td>
			</tr>
<?php	
		if($count9 > 0)
		{
			while($row9 = mysql_fetch_array($result9))
			{
				$status = $row9['Status'];
				$query10 = "SELECT Status FROM tblstatus WHERE ID = '$status'";
				$result10 = mysql_query($query10) or die (mysql_error());
				$row10 = mysql_fetch_array($result10);				
?>
				<tr>
					<td>
						<?php echo '<a href="task.php?type='.$row9['Type'].'&view=update&taskid='.$row9['ID'].'">'.$row9['Subject'].'</a>'; ?>
					</td>
					<td>
						<?php echo $row10['Status']; ?>
					</td>
				</tr>
<?php		
			}
?>
			<tr>
				<td>
					<?php echo '<input type="button" value="Back" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'">'; ?>
				</td>
			</tr>
<?php			
		}else
		{
?>
			<tr>
				<td>
					No Matches Found
				</td>
			</tr>
<?php		
		}
	?>
		<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<tr>
				<td colspan="2" class="heading">
					Enter Part or Full Facility Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="searchfname" value="">
				</td>
				<td>
					<input type="submit" value="Search" name="view">
				</td>
			</tr>
		</FORM>	
<?php
}
include 'includes/closedbtask.php';
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>