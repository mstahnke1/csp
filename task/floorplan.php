<?php
if(!isset($_GET['print']))
{
	include 'header.php';
}else
{
	include 'printheader.php';
}
?>
<link rel="stylesheet" type="text/css" href="task.css" />
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
$displaydate = date('m-d-Y');
$now = strtotime("now");
$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$tomorrowplus  = mktime (date("H"), date("i")+15, 0, date("m")  , date("d")+1, date("Y"));
$status = 0;
include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
//*******************************************************************COMPLETING FLOORPLAN*********************************//
if((isset($_GET['cancel'])) && ($_GET['cancel']=='cancel'))
{
	$id = $_GET['taskid'];
	mysql_select_db($dbname2);
	$query35 = "UPDATE taskinfo SET Status = 4 WHERE ID = '$id'";
	mysql_query($query35) or die(mysql_error());
	$query36 = "UPDATE tblfloorplan set iscanceled = '0' WHERE TaskID = '$id'";
	mysql_query($query36) or die(mysql_error());
	echo '<table><tr><td>The task has been canceled, if this has been done in error please email this number ('.$id.') to Drew and let him know you need it re-opened.</td></tr>';
?> 
	<tr>
		<td>
			<a href="taskhome.php">Home </a> 
		</td>
	</tr>
<?php	
}
if((isset($_GET['reopen'])) && ($_GET['reopen']=='reopen'))
{
	$id = $_GET['taskid'];
	mysql_select_db($dbname2);
	$query35 = "UPDATE taskinfo SET Status = 1, Assignto = 0 WHERE ID = '$id'";
	mysql_query($query35) or die(mysql_error());
	$query36 = "UPDATE tblfloorplan set iscanceled = '-1' WHERE TaskID = '$id'";
	mysql_query($query36) or die(mysql_error());
	header("Location: floorplan.php?view=update&type=12&taskid=$id");
}
if((isset($_GET['complete'])) && ($_GET['complete'] == 'Complete'))
{
	$id = $_GET['taskid'];
	$status = 3;
	mysql_select_db($dbname2);
	$query26 = "UPDATE taskinfo SET Status = '$status',signature = '$uid', Completiondate = '$date' WHERE ID = '$id'";
	mysql_query($query26) or die(mysql_error());
	$sql = $sql = nl2br(addslashes($query26));
	$audit = "INSERT INTO tbltaskaudit (Date, User, Action,taskid,Query,coresponse,priority,status,assignto,checkby) VALUES 
								('$date', '$employeeid', 'UPDATED','$id','$sql', '0','0', '3', '0', '0')";
	mysql_query($audit) or die(mysql_error());	
	//**********************************************************EMAIL TO SALESPERSON WHEN COMPLETE***************************//
	require_once "Mail.php";
	$query30 = "SELECT * FROM tblfloorplan WHERE TaskID = '$id'";
	$result30 = mysql_query($query30) or die (mysql_error());
	$row30 = mysql_fetch_array($result30);
	$salesman = $row30['Salesperson'];
	mysql_select_db($dbname);
	$query31 = "SELECT email FROM employees WHERE id = '$salesman'";
	$result31 = mysql_query($query31) or die (mysql_error());
	$row31 = mysql_fetch_array($result31);
	$eaddress = $row31['email'];
	mysql_select_db($dbname2);
	$oncallindoor = $row30['OnCallindoor'];
	$oncalloutdoor = $row30['OnCalloutdoor'];
	$oncall = $oncallindoor + $oncalloutdoor;
	$eliteindoor = $row30['Eliteindoor'];
	$eliteoutdoor = $row30['Eliteoutdoor'];
	$elite = $eliteindoor + $eliteoutdoor;
	if($oncall > 0 && $elite < 1)
	{ 
		$description1 = '<b>On Call</b><br>Indoor WMU: '.$oncallindoor.'<br>Outdoor WMU: '.$oncalloutdoor;
	}
	if($oncall < 1 && $elite > 0)
	{ 
		$description1 = '<b>On Site/Elite</b><br>Indoor WMU: '.$eliteindoor.'<br>Outdoor WMU: '.$eliteoutdoor;
	}
	if($oncall > 0 && $elite > 0)
	{
		$description1 = '<b>On Call</b><br>Indoor WMU: '.$oncallindoor.'<br>Outdoor WMU: '.$oncalloutdoor.'<br><b>On Site/Elite<b><br>Indoor WMU: '.$eliteindoor.'<br>Outdoor WMU: '.$eliteoutdoor;
	}
	//$description1 = 'The floor plan is complete.'
	$subject2 = "Your Floor Plan has been completed.";
	$type = "text/html";
	$from = "Task Manager <donotreply@homefreesys.com>";
	$to = $eaddress;
	$subject = "You are involved in a new task";
	$body = '<p><FIELDSET><b><legend><font face="Arial" size="2">Task '.$id.' has been added</font></legend></b>
			<dl><dt><font face="Arial" size="2">Subject: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$subject2.'</font></dd></dl>
			<dl><dt><font face="Arial" size="2">Description: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$description1.'</dd></dl></FIELDSET></p>
			<p><a href="'.'http://webapps/csPortal/task/floorplan.php?taskid='.$id.'&view=update'.'">'.'Click here to view task'.' </a></p>';
	$host = "upsilon.dmatek.com";
	$username = "Demon";
	$password = "Q1w2e3";
	$headers = array ('From' => $from,
	'To' => $to,
	'Subject' => $subject,
	'Content-type' => $type);
	$smtp = Mail::factory('smtp',
	array ('host' => $host,
	'auth' => true,
 	'username' => $username,
 	'password' => $password));
	$mail = $smtp->send($to, $headers, $body);	
	header("Location: floorplan.php?view=update&type=12&taskid=$id");
}
if(((isset($_GET['view'])) && ($_GET['view'] == "floorplan")) OR ((isset($_GET['view'])) && ($_GET['view'] == "update")))
{
	if((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
	{
		$duedate = $_GET['date1'];
		$facility = addslashes($_GET['fname']);
		$priority = $_GET['priority'];
		if(isset($_GET['facilitytype']))
		{
			$facilitytype = $_GET['facilitytype'];
		}else
		{
			$facilitytype = 0;
		}
		if(isset($_GET['systemtype1']))
		{	
			$sys1 = $_GET['systemtype1'];
		}else
		{
			$sys1 = 0;
		}	
		if(isset($_GET['systemtype2']))
		{	
			$sys2 = $_GET['systemtype2'];
		}else
		{
			$sys2 = 0;
		}
		if(isset($_GET['systemtype3']))
		{	
			$sys3 = $_GET['systemtype3'];
		}else
		{
			$sys3 = 0;
		}	
		$salesrep = $_GET['sales'];
		$systemtype = $sys1 + $sys2 + $sys3;
		$status = 1;
		$createdby = $employeeid;
		$createdate = $date;
		$comments = addslashes($_GET['comments']);
		$comments1 = $_GET['comments'];
		$datecheck = strtotime($duedate);
		$savedate = date('Y-m-d H:i:s',$datecheck);
		if((($facility <> 'NONE') AND ($systemtype <> 0) AND ($facilitytype <> 0)) AND ($datecheck > $tomorrow))
		{
			mysql_select_db($dbname2);
			//****************************************Add Task Query******************************************//
			$addfloorplan = "INSERT INTO taskinfo (Type,Subject,Priority,Status,Description,Attachment,Createdate,Duedate,Response,Createdby, 
											employeedept) VALUES	('12','$facility','$priority','$status', '$comments','no','$date',
											'$savedate','1000','$employeeid', '2')";	
			mysql_query($addfloorplan) or die(mysql_error());
			$sql = $sql = nl2br(addslashes($addfloorplan));
			$query2 = "SELECT max(ID) FROM taskinfo";
			$result2 = mysql_query($query2) or die (mysql_error());
			$row2 = mysql_fetch_array($result2);
			$currentid = $row2['max(ID)'];
			//**************************************Add General Floorplan Information******************************//
			$addfloorplaninfo = "INSERT INTO tblfloorplan (TaskID,SystemType,FacilityType,Salesperson) VALUES ('$currentid','$systemtype','$facilitytype','$salesrep')";
			mysql_query($addfloorplaninfo) or die(mysql_error());
			$audit = "INSERT INTO tbltaskaudit (Date, User, Action,taskid,Query,coresponse,priority,status,assignto,checkby) VALUES 
								('$date', '$employeeid', 'Added Task','$currentid','$sql', '0','$priority', '$status', '0', '0')";
			mysql_query($audit) or die(mysql_error());
			//**************************************EMAIL Floorplan To Techs******************************//
			require_once "Mail.php";
			$description1 = 'There is a floorplan in the box for '.$facility.', please complete it by the due date';
			$subject2 = "A new floor plan to lay out";
			$type = "text/html";
			$from = "Task Manager <donotreply@homefreesys.com>";
			$to = 'homefreesupport@homefreesys.com';
			$subject = "You are involved in a new task";
			$body = '<p><FIELDSET><b><legend><font face="Arial" size="2">Task '.$currentid.' has been added</font></legend></b>
					<dl><dt><font face="Arial" size="2">Subject: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$subject2.'</font></dd></dl>
					<dl><dt><font face="Arial" size="2">Description: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$description1.'</dd></dl></FIELDSET></p>
					<p><a href="'.'http://webapps/csPortal/task/floorplan.php?taskid='.$currentid.'&view=update'.'">'.'Click here to view task'.' </a></p>';
			$host = "upsilon.dmatek.com";
			$username = "Demon";
			$password = "Q1w2e3";
			$headers = array ('From' => $from,
  		'To' => $to,
  		'Subject' => $subject,
  		'Content-type' => $type);
			$smtp = Mail::factory('smtp',
  		array ('host' => $host,
  		'auth' => true,
 		 	'username' => $username,
 		 	'password' => $password));
			$mail = $smtp->send($to, $headers, $body);
			header("Location: floorplan.php?view=update&taskid=$currentid&type=12");
		}		
	}
	if((isset($_GET['floorplan'])) && ($_GET['floorplan'] == "Save Changes"))
	{
		$id = $_GET['taskid'];
		$duedate = $_GET['date1'];
		$facility = $_GET['fname'];
		$priority = $_GET['priority'];
		if(isset($_GET['facilitytype']))
		{
			$facilitytype = $_GET['facilitytype'];
		}else
		{
			$facilitytype = 0;
		}
		if(isset($_GET['systemtype1']))
		{	
			$sys1 = $_GET['systemtype1'];
		}else
		{
			$sys1 = 0;
		}	
		if(isset($_GET['systemtype2']))
		{	
			$sys2 = $_GET['systemtype2'];
		}else
		{
			$sys2 = 0;
		}
		if(isset($_GET['systemtype3']))
		{	
			$sys3 = $_GET['systemtype3'];
		}else
		{
			$sys3 = 0;
		}			
		$salesrep = $_GET['sales'];
		$systemtype = $sys1 + $sys2 + $sys3;
		$comments = addslashes($_GET['comments']);
		mysql_select_db($dbname2);
		$query23 = "UPDATE taskinfo SET Duedate = '$duedate', Subject = '$facility', Priority = '$priority',Description = '$comments' WHERE ID = '$id'";
		mysql_query($query23) or die(mysql_error());	
		$query24 = "UPDATE tblfloorplan SET FacilityType = '$facilitytype',SystemType = '$systemtype',Salesperson = '$salesrep' WHERE TaskID='$id'";
		mysql_query($query24) or die(mysql_error());
		header("Location: floorplan.php?view=update&taskid=$id&type=12");	
	}	
	if((isset($_GET['button'])) && ($_GET['button'] == 'Calculate'))
	{
		$id = $_GET['taskid'];
		$measure = $_GET['measure'];
		$length = $_GET['length'];
		$indoor1 = $_GET['indoor1'];
		$outdoor1 = $_GET['outdoor1'];
		$indoor2 = $_GET['indoor2'];
		$outdoor2 = $_GET['outdoor2'];
		$technotes = addslashes($_GET['techcomments']);
		if($measure <> 0)
		{
			$scalemath = ($length / $measure);
			$scale = round($scalemath, 3);
		}else
		{
			$scale = 0;
		}
		if(isset($_GET['consist']))
		{
			$con = $_GET['consist'];
		}else
		{
			$con = 0;
		}		
		mysql_select_db($dbname2);
		$query21 = "UPDATE tblfloorplan SET length = '$length', measure = '$measure', scale = '$scale', consist = '$con' WHERE TaskID = '$id'";
		mysql_query($query21) or die(mysql_error());
		if($technotes <> '')
		{
			$query32 = "UPDATE taskinfo SET techcomments = '$technotes' WHERE ID = '$id'";
			mysql_query($query32) or die(mysql_error());
		}
		$query33 = "UPDATE taskinfo SET Assignto = '$uid', Status = '2' WHERE ID = '$id'";
		mysql_query($query33) or die(mysql_error());
	}	
	if((isset($_GET['floorplan'])) && ($_GET['floorplan'] == 'Save'))
	{
		$id = $_GET['taskid'];
		$measure = $_GET['measure'];
		$length = $_GET['length'];
		$indoor1 = $_GET['indoor1'];
		$outdoor1 = $_GET['outdoor1'];
		$indoor2 = $_GET['indoor2'];
		$outdoor2 = $_GET['outdoor2'];	
		$totalwmu1 = ($indoor1 + $outdoor1);
		$totalwmu2 = ($indoor2 + $outdoor2);
		$technotes = addslashes($_GET['techcomments']);
		if($measure <> 0)
		{
			$scalemath = ($length / $measure);
			$scale = round($scalemath, 3);
		}else
		{
			$scale = 0;
		}
		if(isset($_GET['consist']))
		{
			$con = $_GET['consist'];
		}else
		{
			$con = 0;
		}
		mysql_select_db($dbname2);
		$query22 = "UPDATE tblfloorplan SET length = '$length', measure = '$measure', scale = '$scale', OnCallindoor = '$indoor1', OnCalloutdoor = '$outdoor1',
								Eliteindoor = '$indoor2', Eliteoutdoor = '$outdoor2', OnCallWMU = '$totalwmu1', EliteWMU = '$totalwmu2', consist = '$con' WHERE TaskID = '$id'";
		mysql_query($query22) or die(mysql_error());
		if($technotes <> '')
		{
			$query32 = "UPDATE taskinfo SET techcomments = '$technotes' WHERE ID = '$id'";
			mysql_query($query32) or die(mysql_error());
		}		
	}		
	if($_GET['view'] == "update")
	{
		mysql_select_db($dbname2);
		$id = $_GET['taskid'];
		$query19 = "SELECT * FROM taskinfo WHERE ID = '$id'";
		$result19 = mysql_query($query19) or die (mysql_error());
		$row19 = mysql_fetch_array($result19);
		$query21 = "SELECT * FROM tblfloorplan WHERE TaskID = '$id'";
		$result21 = mysql_query($query21) or die (mysql_error());
		$row21 = mysql_fetch_array($result21);
		$salesrep = $row21['Salesperson'];
		$completedby = $row19['signature'];
		$assignto = $row19['Assignto'];
		mysql_select_db($dbname);
		$query20 = "SELECT f_name,l_name FROM employees WHERE ID = '$salesrep'";
		$result20 = mysql_query($query20) or die (mysql_error());
		$row20 = mysql_fetch_array($result20);	
		$query27 = "SELECT f_name,l_name FROM employees WHERE ID = '$completedby'";
		$result27 = mysql_query($query27) or die (mysql_error());
		$row27 = mysql_fetch_array($result27);	
		$query34 = "SELECT f_name,l_name FROM employees WHERE ID = '$assignto'";
		$result34 = mysql_query($query34) or die (mysql_error());
		$row34 = mysql_fetch_array($result34);					
		$salesrepf = $row20['f_name'];
		$salesrepl = $row20['l_name'];
		$facilitytype = $row21['FacilityType'];
		$systemtype = $row21['SystemType'];
		$duedate = $row19['Duedate'];
		$datecheck = strtotime($duedate);
		$priority = $row19['Priority'];
		$created = $row19['Createdby'];
		$description = $row19['Description'];
		$facility = $row19['Subject'];
		$status = $row19['Status'];
		$con = $row21['consist'];
		$techcomments = $row19['techcomments'];
	}	
	mysql_select_db($dbname2);
	$query17 = "SELECT * FROM tblpriority WHERE Task = 1";
	$result17 = mysql_query($query17) or die (mysql_error());	
	mysql_select_db($dbname);
	$query18 = "SELECT * FROM employees WHERE Dept = 1 AND Active = 0 Order BY f_name";
	$result18 = mysql_query($query18) or die (mysql_error());			
?>
	<form method="GET" NAME="example13" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width ="750" border = "0" cellpadding="3">
<?php			
		if((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))		
		{
			if($facility == 'NONE')
			{
				echo '<tr><td colspan="3" class="heading"><font color="ff0000">'.'Facility Name Cannot be None'.'</td></tr>';
			}
			if($facilitytype == 0)
			{
				echo '<tr><td colspan="3" class="heading"><font color="ff0000">'.'Select A Facility Type'.'</td></tr>';
			}				
			if($systemtype == 0)
			{
				echo '<tr><td colspan="3" class="heading"><font color="ff0000">'.'Select A System Type'.'</td></tr>';
			}		
			if($datecheck < $tomorrow)
			{
				echo '<tr><td colspan="3" class="heading"><font color="ff0000">'.'Due Date must be 24 hours after date given'.'</td></tr>';
			}				
		}
?>		
			<tr>
				<td align="center" class="bigheading" colspan="4">
					WMU Layout Form
				</td>
			</tr>
<?php
			if(isset($_GET['print']))
			{
?>				
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
<?php
			}else
			{
?>
				<tr>
<?php				
					if(($_GET['view'] == "update") && ($row19['Status'] <> 4))
					{
?>				

						<td>
							<a href="../task/floorplan.php?view=update&print=print&type=12&taskid=<?php echo $row19['ID']; ?>">Print View </a>
						</td>
<?php
					}else
					{
?>				

						<td>
							<a href="taskhome.php">Home </a>
						</td>
<?php
					}
					if(($_GET['view'] == "update") && (!(($row19['Status'] == 3) || ($row19['Status'] == 4))))
					{
?>					
						<td>
							<a href="../task/floorplan.php?cancel=cancel&taskid=<?php echo $row19['ID']; ?>">Cancel Task </a>
						</td>
<?php
					}
					if(($_GET['view'] == "update") && (($row19['Status'] == 4) && ($uid == 4) OR ($uid == 1)))
					{
?>					
						<td>
							<a href="../task/floorplan.php?reopen=reopen&taskid=<?php echo $row19['ID']; ?>">Reopen Task </a>
						</td>
<?php
					}						
?>					
				</tr>
<?php				
			}
?>		
			<tr>
				<td class="heading" width="160">
					HomeFree Salesperson: 
				</td>
				<td colspan="3">
					
<?php
				if((isset($_GET['floorplan']))&& ($_GET['floorplan']=="Add"))
				{
?>
					<select name=sales>
<?php
					while($row18 = mysql_fetch_array($result18))
					{
?>				
						<option value="<?php echo $row18['id']; ?>" <?php if($row18['id'] == $salesrep){ echo 'selected="selected"'; } ?>>  <?php echo  $row18['f_name'].' '. $row18['l_name']; ?> </option>
<?php
					}
?>
					</select>
<?php						
				}elseif($_GET['view'] == "update") 
				{
					if((($row19['Createdby'] == $employeeid) || ($row21['Salesperson'] == $employeeid)) && (!(($status == 3) OR ($status ==4))))
					{
?>
						<select name=sales>
<?php												
							while($row18 = mysql_fetch_array($result18))
							{
?>					
								<option value="<?php echo $row18['id']; ?>" <?php if($row18['id'] == $salesrep){ echo 'selected="selected"'; } ?>>  <?php echo  $row18['f_name'].' '. $row18['l_name']; ?> </option>
<?php
							}
?>
						</select>
<?php				
					}else
					{
						echo $salesrepf.' '.$salesrepl;							
					}
				}else
				{
?>
						<select name=sales>
<?php												
							while($row18 = mysql_fetch_array($result18))
							{
?>					
								<option value="<?php echo $row18['id']; ?>" <?php if($row18['id'] == $employeeid){ echo 'selected="selected"'; } ?>>  <?php echo  $row18['f_name'].' '. $row18['l_name']; ?> </option>
<?php
							}
?>
						</select>
<?php						
				}
?>							
						
				</td>
			</tr>		
			<tr>
				<td class="heading" width="160">
<?php
					if((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
					{
						if($facility == "NONE")
						{
?>						
								<font color="#FF0000">Facility Name:</font>
							</td>
							<td colspan="3">
								<input type="text" size="60" maxlength="100" name="fname" value="NONE">
<?php
						}else
						{
?>												
								Facility Name:
							</td> 
							<td colspan="3">
								<input type="text" size="60" maxlength="100" name="fname" value="<?php echo $facility; ?>">								
<?php
						}
					}elseif($_GET['view'] == "update")
					{
						if((($row19['Createdby'] <> $employeeid) && ($row21['Salesperson'] <> $employeeid)) || ($status == 3) || ($status == 4))
						{
?>											
								Facility Name:
							</td> 
							<td colspan="3">
<?php													
							echo $row19['Subject'];
						}elseif((($created == $employeeid) || ($salesrep == $employeeid)) && ($status <> 3))
						{	
?>												
							Facility Name:
						</td> 
						<td colspan="3">
							<input type="text" size="60" maxlength="100" name="fname" value="<?php echo $facility; ?>">								
<?php			
						}else
						{
?>											
								Facility Name:
							</td> 
							<td colspan="3">
<?php	
							echo $row19['Subject'];
						}		
					}else
					{
?>									
						Facility Name: 
						</td>
						<td colspan="3">
							<input type="text" size="60" maxlength="100" name="fname" value="NONE">						
<?php
					}
?>	
				</td>														
			</tr>	
<?php
			if(($_GET['view'] == "floorplan") OR ($_GET['view'] == "update"))
			{
?>			
				<tr>
					<td class="heading">
						Priority:
					</td>
					<td>
<?php
						if((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
						{
?>
							<select name=priority>
<?php						
							while($row17 = mysql_fetch_array($result17))
							{
?>					
								<option value="<?php echo $row17['ID']; ?>" <?php if($row17['ID'] == $priority){ echo 'selected="selected"'; } ?>>  <?php echo  $row17['Priority']; ?> </option>
<?php
							}
?>
							</select>
<?php						
						}elseif(($_GET['view'] == "update") && ($row19['Status'] <> 4))
						{
							if(($row19['Createdby'] <> $employeeid) && ($row21['Salesperson'] <> ($employeeid)) || ($status == 3))
							{
								mysql_select_db($dbname2);
								$query17 = "SELECT * FROM tblpriority WHERE ID = '$priority'";
								$result17 = mysql_query($query17) or die (mysql_error());	
								$row17 = mysql_fetch_array($result17);
								echo $row17['Priority'];
							}else
							{
?>
								<select name=priority>
<?php						
									while($row17 = mysql_fetch_array($result17))
									{
?>					
										<option value="<?php echo $row17['ID']; ?>" <?php if($row17['ID'] == $priority){ echo 'selected="selected"'; } ?>>  <?php echo  $row17['Priority']; ?> </option>
<?php
									}
?>
								</select>
<?php						
							}						
						}else
						{
?>
							<select name=priority>
<?php						
								while($row17 = mysql_fetch_array($result17))
								{
?>					
									<option value="<?php echo $row17['ID']; ?>"> <?php echo  $row17['Priority']; ?> </option>
<?php
								}
						}
?>
						</select>						
					</td>	
				</tr>					
				<tr>
					<td class="heading" width="160">
<?php				
					if((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
					{
						if($facilitytype == 0)
						{
?>						
							<font color="#FF0000">Type of Facility:</font>
<?php
						}else
						{
?>												
							Type of Facility: 
<?php
						}
					}else
					{
?>				
						Type of Facility: 
<?php
					}
?>
					</td>
					<td>
<?php									
					if(((isset($_GET['view'])) && ($_GET['view'] == 'floorplan')) && (!isset($_GET['floorplan'])))
					{								
?>
							<input type="radio" name="facilitytype" value="1"> ALF
						</td>
						<td>
							<input type="radio" name="facilitytype" value="2"> SNF
						</td>		
						<td>
							<input type="radio" name="facilitytype" value="3"> CCRC
						</td>	
<?php						
					}elseif((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
					{
							if($facilitytype == 1)
							{								
?>	
								<input type="radio" name="facilitytype" value="1" checked> ALF
<?php
							}else
							{
?>						
								<input type="radio" name="facilitytype" value="1" > ALF
<?php
							}						
?>							
							</td>
							<td>
<?php						
							if($facilitytype == 2)
							{
?>						
								<input type="radio" name="facilitytype" value="2" checked> SNF
<?php
							}else
							{
?>						
								<input type="radio" name="facilitytype" value="2" > SNF
<?php
							}						
?>							
							</td>		
							<td>
<?php						
							if($facilitytype == 3)
							{
?>						
								<input type="radio" name="facilitytype" value="3" checked> CCRC
<?php
							}else
							{
?>						
								<input type="radio" name="facilitytype" value="3" > CCRC
<?php
							}						
					}elseif($_GET['view'] == "update") 
					{
						if((($row19['Createdby'] <> $employeeid) && ($row21['Salesperson'] <> $employeeid)) || ($status == 3))
						{
							if($facilitytype == 1)
							{
?>						
								<b>ALF</b>
<?php
							}else
							{
?>						
								<font color="#c0c0c0">ALF</font>
<?php
							}						
?>							
							</td>
							<td>
<?php						
							if($facilitytype == 2)
							{
?>						
								<b>SNF</b>
<?php
							}else
							{
?>						
								<font color="#c0c0c0">SNF</font>
<?php
							}						
?>							
							</td>		
							<td>
<?php						
							if($facilitytype == 3)
							{
?>						
								<b>CCRC</b>
<?php
							}else
							{
?>						
								<font color="#c0c0c0">CCRC</font>
<?php
							}							
						}else
						{	
							if($facilitytype == 1)
							{								
?>	
								<input type="radio" name="facilitytype" value="1" checked> ALF
<?php
							}else
							{
?>						
								<input type="radio" name="facilitytype" value="1" > ALF
<?php
							}						
?>							
							</td>
							<td>
<?php						
							if($facilitytype == 2)
							{
?>						
								<input type="radio" name="facilitytype" value="2" checked> SNF
<?php
							}else
							{
?>						
								<input type="radio" name="facilitytype" value="2" > SNF
<?php
							}						
?>							
							</td>		
							<td>
<?php						
							if($facilitytype == 3)
							{
?>						
								<input type="radio" name="facilitytype" value="3" checked> CCRC
<?php
							}else
							{
	?>						
								<input type="radio" name="facilitytype" value="3" > CCRC
	<?php
							}	
						}
					}
	?>																	
				</tr>
				<tr>
					<td class="heading" width="160">
	<?php
					if((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
					{					
						if($systemtype == 0)
						{
	?>						
							<font color="#FF0000">Type of System::</font>
	<?php
						}else
						{
	?>												
							Type of System:: 
	<?php
						}
					}else
					{
	?> 		
						Type of System: 
	<?php
					}
	?>										
					</td>
					<td>
	<?php		
					if(((isset($_GET['view'])) && ($_GET['view'] == 'floorplan')) && (!isset($_GET['floorplan'])))
					{				
	?>						
								<input type="checkbox" name="systemtype1" value="1"> On-Call
							</td>
							<td>
								<input type="checkbox" name="systemtype2" value="2"> On-Site
							</td>		
							<td>
								<input type="checkbox" name="systemtype3" value="4"> Elite		
	<?php
					}elseif((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
					{
						if($systemtype == 1 OR $systemtype == 3 OR $systemtype == 5)
						{
	?>						
							<input type="checkbox" name="systemtype1" value="1" checked> On-Call
	<?php
						}else
						{
	?>						
							<input type="checkbox" name="systemtype1" value="1"> On-Call
	<?php
						}						
	?>												
						</td>
						<td>
	<?php						
						if($systemtype == 2 OR $systemtype == 3 OR $systemtype == 6)
						{
	?>						
							<input type="checkbox" name="systemtype2" value="2" checked> On-Site
	<?php
						}else
						{
	?>						
							<input type="checkbox" name="systemtype2" value="2"> On-Site
	<?php
						}						
	?>						
						</td>		
						<td>
	<?php						
						if($systemtype == 4 OR $systemtype == 5 OR $systemtype == 6)
						{
	?>						
							<input type="checkbox" name="systemtype3" value="4" checked> Elite
	<?php
						}else
						{
	?>						
							<input type="checkbox" name="systemtype3" value="4"> Elite
	<?php
						}						
					}elseif($_GET['view'] == "update")
					{ 
						if((($row19['Createdby'] <> $employeeid) && ($row21['Salesperson'] <> $employeeid)) || ($status == 3))
						{
							if($systemtype == 1 OR $systemtype == 3 OR $systemtype == 5)
							{
	?>						
								<b>On-Call</b>
	<?php
							}else
							{
	?>						
								<font color="#c0c0c0">On-Call</font>
	<?php
							}						
	?>												
							</td>
							<td>
	<?php						
							if($systemtype == 2 OR $systemtype == 3 OR $systemtype == 6)
							{
	?>						
								<b>On-Site</b>
	<?php
							}else
							{
	?>						
								<font color="#c0c0c0">On-Site</font>
	<?php
							}						
	?>						
							</td>		
							<td>
	<?php						
							if($systemtype == 4 OR $systemtype == 5 OR $systemtype == 6)
							{
	?>						
								<b>Elite</b>
	<?php
							}else
							{
	?>						
								<font color="#c0c0c0">Elite</font>
	<?php
							}					
						}else
						{
							if($systemtype == 1 OR $systemtype == 3 OR $systemtype == 5)
							{
	?>						
								<input type="checkbox" name="systemtype1" value="1" checked> On-Call
	<?php
							}else
							{
	?>						
								<input type="checkbox" name="systemtype1" value="1"> On-Call
	<?php
							}						
	?>												
							</td>
							<td>
	<?php						
							if($systemtype == 2 OR $systemtype == 3 OR $systemtype == 6)
							{
	?>						
								<input type="checkbox" name="systemtype2" value="2" checked> On-Site
	<?php
							}else
							{
	?>						
								<input type="checkbox" name="systemtype2" value="2"> On-Site
	<?php
							}						
	?>						
							</td>		
							<td>
	<?php						
							if($systemtype == 4 OR $systemtype == 5 OR $systemtype == 6)
							{
	?>						
								<input type="checkbox" name="systemtype3" value="4" checked> Elite
	<?php
							}else
							{
	?>						
								<input type="checkbox" name="systemtype3" value="4"> Elite
	<?php
							}	
						}	
					}			
	?>		
					</td>							
				</tr>				
				<tr>
					<td class="heading">
						Date Given:
					</td>
	<?php
					if(!(((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add")) OR ((isset($_GET['view'])) && ($_GET['view'] == "update"))))
					{
	?>									
						<td colspan="2">
							<?php echo $date; ?>
						</td>
	<?php
					}elseif((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
					{
	?>									
						<td colspan="2">
							<?php echo $date; ?>
						</td>
	<?php 
					}else
					{
	?>					
						<td colspan="2">
							<?php echo $row19['Createdate']; ?>
						</td>
	<?php					
					}	
	?>							
				</tr>					
			</table>
			<table>	
				<tr>		
	<?php		
				if((!isset($_GET['floorplan'])) && (!isset($_GET['view'])))
				{			
	?>			
					<td colspan = "1" width = "270" class="heading">
							Due Date:	
						<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
						<SCRIPT LANGUAGE="JavaScript">
						var cal = new CalendarPopup();
						</SCRIPT>
						<INPUT TYPE="text" NAME="date1" VALUE="<?php echo date('Y/m/d H:i:s',$tomorrowplus); ?>" SIZE=25>
					</td>
					<td>
						<A HREF="#"
	 					onClick="cal.select(document.forms['example13'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
	 					NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
					</td> 
	<?php
				}elseif((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
				{
					if($datecheck < $tomorrow) 
					{			
	?>					
						<td colspan = "1" width = "270" class="heading"><font color="ff0000">
							Due Date:																												
						<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
						<SCRIPT LANGUAGE="JavaScript">
						var cal = new CalendarPopup();
						</SCRIPT>
						<INPUT TYPE="text" NAME="date1" VALUE="<?php echo $duedate; ?>" SIZE=25>
					</td>
					<td>
						<A HREF="#"
	 					onClick="cal.select(document.forms['example13'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
	 					NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
					</td> 					
	<?php
					}else	
					{
	?>
						<td colspan = "1" width = "270" class="heading">
							Due Date:	
																												
						<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
						<SCRIPT LANGUAGE="JavaScript">
						var cal = new CalendarPopup();
						</SCRIPT>
						<INPUT TYPE="text" NAME="date1" VALUE="<?php echo $duedate; ?>" SIZE=25>
					</td>
					<td>
						<A HREF="#"
	 					onClick="cal.select(document.forms['example13'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
	 					NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
					</td> 						
	<?php
					}
				}elseif((isset($_GET['view'])) && ($_GET['view'] == 'update'))
				{
					if((($row19['Createdby'] == $employeeid) || ($row21['Salesperson'] == $employeeid)) && ($status <> 3))
					{
	?>			
						<td colspan = "1" width = "270" class="heading">
							Due Date:																									
						<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
						<SCRIPT LANGUAGE="JavaScript">
						var cal = new CalendarPopup();
						</SCRIPT>
						<INPUT TYPE="text" NAME="date1" VALUE="<?php echo $duedate; ?>" SIZE=25>
						</td>
						<td>
							<A HREF="#"
		 					onClick="cal.select(document.forms['example13'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
		 					NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
						</td> 
	<?php
					}else	
					{			
						echo '<td width="165" class="heading">'.'Due Date:'.'</td><td>'.$row19['Duedate'].'</td>';
					}
				}
	?>		
				</tr>
			</table>			
			<table> 	
				<tr>
					<td class="heading">
						Comments:
					</td>
				</tr>			
				<tr>
	<?php
					if((isset($_GET['floorplan'])) && ($_GET['floorplan']=="Add"))
					{
	?>								
						<td colspan = "4">
							<textarea rows="6" cols="90" name="comments"> <?php echo $comments1; ?></textarea>
						</td>
	<?php				
					}elseif((isset($_GET['view'])) && ($_GET['view'] == "update"))
					{
						if((($created == $employeeid) || ($salesrep == $employeeid)) && ($status <> 3))
						{					
	?>								
							<td colspan = "4">
								<textarea rows="6" cols="90" name="comments"><?php echo $row19['Description']; ?></textarea>
							</td>
	<?php	
						}else
						{
	?>					
							<td colspan = "4">
								<?php echo nl2br($row19['Description']); ?>
							</td>	
	<?php									
						}
					}else
					{
	?>
	
						<td colspan = "4">
							<textarea rows="6" cols="90" name="comments"></textarea>
						</td>							
	<?php
					}												
	?>									
				</tr>
			</table>
	<?php 
			if(((isset($_GET['view'])) && ($_GET['view'] == "update")) && ((($department == 2)) || ($status == 3)))
			{
				echo	'<input type = "hidden" name="view" value = "update">'; 
				echo	'<input type = "hidden" name="taskid" value = "'.$id.'">'; 
				echo	'<input type = "hidden" name="type" value = "12">';
	?>
				<table>  
					<tr>
						<td class="border">
							<table cellpadding="2">		
							  <tr>
									<td class="heading" width="100">				
										Length (in feet):
									</td>
	<?php
									if($status <> 3)
									{
	?>																	
										<td>
											<input type="text" size="5" maxlength="5" name="length" value="<?php echo $row21['length'] ?>">	
										</td>
	<?php
									}else
									{
										echo '<td width="40">'.$row21['length'].'</td>';
									}	
	?>					
									<td class="heading" width="160">											
										Measurement (in inches):
									</td>
	<?php
									if($status <> 3)
									{
	?>										
										<td>
											<input type="text" size="5" maxlength="5" name="measure" value="<?php echo $row21['measure'] ?>">	
										</td>
	<?php
									}else
									{
										echo '<td width="40">'.$row21['measure'].'</td>';
									}
	?>									
									<td class="heading">
										Scale:
									</td>
									<td>
										1 inch = <?php echo $row21['scale'] ?> feet
									</td>					
								</tr>
	<?php
								if(($row21['scale'] <> 0) && ($row21['SystemType'] == 1))
								{
									$scale = $row21['scale'];
									$thirtyfive = (45 / $scale);
									$seventy = (90 / $scale);					
	?>
									<tr>
										<td colspan="6" align="center" class="heading">
											On-Call Scale
										</td>
									</tr>			
									<tr>
										<td colspan="6" align="center">
											45 feet = <?php echo round($thirtyfive,2); ?> inches
										</td>
									</tr>
									<tr>
										<td colspan="6" align="center">
											90 feet = <?php echo round($seventy,2); ?> inches
										</td>
									</tr>					
	<?php
								}							
								if(($row21['scale'] <> 0) && (($row21['SystemType'] == 2) || ($row21['SystemType'] == 4)))
								{
									$scale = $row21['scale'];
									$twentyfive = (35 / $scale);
									$fifty = (70 / $scale);					
				
	?>
									<tr>
										<td colspan="6" align="center" class="heading">
											On-Site / Elite Scale
										</td>
									</tr>			
									<tr>
										<td colspan="6" align="center">
											35 feet = <?php echo round($twentyfive,2); ?> inches
										</td>
									</tr>
									<tr>
										<td colspan="6" align="center">
											70 feet = <?php echo round($fifty,2); ?> inches
										</td>
									</tr>					
	<?php
								}		
								if(($row21['scale'] <> 0) && (($row21['SystemType'] == 3) || ($row21['SystemType'] == 5)))
								{
									$scale = $row21['scale'];
									$twentyfive = (35 / $scale);
									$fifty = (70 / $scale);		
									$scale = $row21['scale'];
									$thirtyfive = (45 / $scale);
									$seventy = (90 / $scale);													
				
	?>
									<tr>
										<td colspan="6" align="center" class="heading">
											On-Site / Elite Scale
										</td>
									</tr>			
									<tr>
										<td colspan="6" align="center">
											35 feet = <?php echo round($twentyfive,2); ?> inches
										</td>
									</tr>
									<tr>
										<td colspan="6" align="center">
											70 feet = <?php echo round($fifty,2); ?> inches
										</td>
									</tr>	
									<tr>
										<td colspan="6" align="center" class="heading">
											On-Call Scale
										</td>
									</tr>			
									<tr>
										<td colspan="6" align="center">
											45 feet = <?php echo round($thirtyfive,2); ?> inches
										</td>
									</tr>
									<tr>
										<td colspan="6" align="center">
											90 feet = <?php echo round($seventy,2); ?> inches
										</td>
									</tr>													
	<?php
								}						
								if($status <> 3)
								{														
	?>					
									<tr>
										<td>
											<input type="submit" value="Calculate" name="button">
										</td>
									</tr>
	<?php
								}													
	?>						
							</table>
	<?php
							if(!((isset($_GET['view'])) && ($_GET['view'] == 'update')))
							{
	?>													
								<table>
									<tr>
										<td class="heading">
											Scale Consistency:
										</td>
										<td>
											Perfect<input type="radio" name="consist" value="1">
										</td>
										<td>
											Good<input type="radio" name="consist" value="2">
										</td>
										<td>
											Should not be used<input type="radio" name="consist" value="3">
										</td>
									</tr>
								</table>
	<?php							
							}elseif(((isset($_GET['view'])) && ($_GET['view'] == 'update')) && ($status <> 3))
							{	
	?>	
								<table>
									<tr>
	<?php
										if($con == 0)
										{
	?>									
											<td class=heading><font color="#FF0000">
												Scale Consistency:
											</font></td>
	<?php										
										}else
										{
	?>									
											<td class="heading">
												Scale Consistency:
											</td>
	<?php
										}
										if($con == 1)
										{
	?>																			
											<td>
												Perfect<input type="radio" name="consist" value="1" checked>
											</td>
	<?php
										}else
										{
	?>									
											<td>
												Perfect<input type="radio" name="consist" value="1">
											</td>	
	<?php
										}
										if($con == 2)
										{									
	?>																		
											<td>
												Good<input type="radio" name="consist" value="2" checked>
											</td>
	<?php
										}else
										{
	?>									
											<td>
												Good<input type="radio" name="consist" value="2">
											</td>	
	<?php
										}		
										if($con == 3)
										{									
	?>																		
											<td>
												Should Not be used<input type="radio" name="consist" value="3" checked>
											</td>
	<?php
										}else
										{
	?>									
											<td>
												Should Not be used<input type="radio" name="consist" value="3">
											</td>	
	<?php
										}		
	?>							
									</tr>
								</table>
	<?php
							}else
							{
	?>	
								<table>
									<tr>
										<td class="heading">
											Scale Consistency:
										</td>
	<?php
										if($row21['consist'] == 1)
										{
	?>																			
											<td>
												<b>Perfect |</b>
											</td>
	<?php
										}else
										{
	?>									
											<td>
												<font color="#c0c0c0">Perfect |</font
											</td>	
	<?php
										}
										if($row21['consist'] == 2)
										{									
	?>																		
											<td>
												<b>Good | </b>
											</td>
	<?php
										}else
										{
	?>									
											<td>
												<font color="#c0c0c0">Good | </font>
											</td>	
	<?php
										}		
										if($row21['consist'] == 3)
										{									
	?>																		
											<td>
												<b>Should Not be used</b>
											</td>
	<?php
										}else
										{
	?>									
											<td>
												<font color="#c0c0c0">Should Not be used</font>
											</td>	
	<?php
										}		
	?>
										</td>
									</tr>
								</table>
	<?php																
							}
	?>																						
						</td>
					</tr>	
				</table>	
				<table>
	<?php
				if(($row21['SystemType'] == 1) || ($row21['SystemType'] == 3) || ($row21['SystemType'] == 5))
				{
	?>				
					<tr>
						<td colspan="4" class="heading">
							<?php echo 'On-Call WMU Count'; ?>
						</td>
					</tr>
	<?php				
					if($row21['SystemType'] == 1)
					{
						echo	'<input type = "hidden" name="indoor2" value = "0">';
						echo	'<input type = "hidden" name="outdoor2" value = "0">';
					}			
	?>				
					<tr>
						<td class="heading">
							WMU's:
						</td>
	<?php
						if($status <> 3)
						{
	?>					
							<td>
								<input type="text" size="5" maxlength="5" name="indoor1" value="<?php if(((isset($_GET['button'])) && ($_GET['button']=='Calculate')) || ((isset($_GET['floorplan'])) && ($_GET['floorplan']=='Save'))){ echo $indoor1; }else{echo $row21['OnCallindoor'];}?>">	
							</td>
	<?php
						}else
						{
							echo '<td>'.$row21['OnCallindoor'].'</td>';
						}
	?>						
						<td class="heading">
							Outdoor WMU's:
						</td>
	<?php
						if($status <> 3)
						{
	?>						
						<td>
							<input type="text" size="5" maxlength="5" name="outdoor1" value="<?php if(((isset($_GET['button'])) && ($_GET['button']=='Calculate')) || ((isset($_GET['floorplan'])) && ($_GET['floorplan']=='Save'))){ echo $outdoor1; }else{echo $row21['OnCalloutdoor'];}?>">	
						</td>
	<?php
						}else
						{
							echo '<td>'.$row21['OnCalloutdoor'].'</td>';
						}
	?>					
					</tr>
						<tr>
							<td class="heading">
								Total WMU's: 
							</td>
							<td>
								<?php echo $row21['OnCallWMU'];?>
							</td>
						</tr>				
	<?php
				}
				if(($row21['SystemType'] == 2) || ($row21['SystemType'] == 3) || ($row21['SystemType']==4) ||($row21['SystemType'] == 5))
				{
					echo '<tr><td colspan="4" class="heading">'.'On-Site/Elite WMU Count'.'</td></tr>';
					if(($row21['SystemType'] <> 1) && ($row21['SystemType'] <> 3) && ($row21['SystemType'] <> 5))
					{
						echo	'<input type = "hidden" name="indoor1" value = "0">';
						echo	'<input type = "hidden" name="outdoor1" value = "0">';
					}
	?>				
						<tr>
							<td class="heading">
								Indoor WMU's:
							</td>
	<?php
						if($status <> 3)
						{
	?>							
							<td>
								<input type="text" size="5" maxlength="5" name="indoor2" value="<?php if(((isset($_GET['button'])) && ($_GET['button']=='Calculate')) || ((isset($_GET['floorplan'])) && ($_GET['floorplan']=='Save'))){ echo $indoor2; }else{echo $row21['Eliteindoor'];}?>">	
							</td>
	<?php
						}else
						{
							echo '<td>'.$row21['Eliteindoor'].'</td>';
						}
	?>							
							<td class="heading">
								Outdoor WMU's:
							</td>
	<?php
						if($status <> 3)
						{
	?>							
							<td>
								<input type="text" size="5" maxlength="5" name="outdoor2" value="<?php if(((isset($_GET['button'])) && ($_GET['button']=='Calculate')) || ((isset($_GET['floorplan'])) && ($_GET['floorplan']=='Save'))){ echo $outdoor2; }else{echo $row21['Eliteoutdoor'];}?>">	
							</td>
	<?php
						}else
						{
							echo '<td>'.$row21['Eliteoutdoor'].'</td>';
						}
	?>								
						</tr>
						<tr>
							<td class="heading">
								Total WMU's: 
							</td>
							<td>
								<?php echo $row21['EliteWMU'];?>
							</td>
						</tr>
	<?php				
				}
	?>			
			</table>
			<table>
				<tr>
					<td class="heading">
						Technicians Comments:
					</td>
				</tr>
	<?php
				if($status <> 3)
				{
	?>							
					<tr>
						<td>
							<textarea rows="6" cols="90" name="techcomments"><?php echo $techcomments; ?></textarea>
						</td>
					</tr>
	<?php
				}else
				{
	?>
					<tr>
						<td>
							<?php echo nl2br($techcomments); ?>
						</td>
					</tr>
	<?php
				}
	?>												
			</table>
	<?php			
			}
			if((isset($_GET['view'])) && ($_GET['view'] == "update"))
			{
	?>		
				<table>
					<tr>
						<td class="heading">
							Technician:
						</td>
						<td>
	<?php										
							if(($assignto <> 0) && ($status <> 3))
							{
								echo $row34['f_name'].' '.$row34['l_name'].'(In Progress)';
							}
							if($status == 3)
							{
								echo $row27['f_name'].' '.$row27['l_name']; 	
							}	
	?>								
						</td>
					</tr>
				</table>
	<?php				
			}
			if(!((isset($_GET['view'])) && ($_GET['view'] == "update")))
			{
				echo	'<input type = "hidden" name="view" value = "floorplan">'; 
	?>
				<table>
				  <tr>
						<td>
							<input type="submit" value="Add" name="floorplan">
						</td>
					</tr>
				</table>		
	<?php	
			}elseif((isset($_GET['view'])) && ($_GET['view'] == "update"))
			{
				if($status <> 3)
				{
					if(($row19['Createdby'] == $employeeid) || ($row21['Salesperson'] == $employeeid))
					{
						$id = $_GET['taskid'];
						echo	'<input type = "hidden" name="view" value = "floorplan">';
						echo	'<input type = "hidden" name="taskid" value = "'.$id.'">';
	?>
						<table>
							<tr>
								<td>
									<input type="submit" value="Save Changes" name="floorplan">
								</td>
							</tr>
						</table>
					</form>							
					<table>
						<tr>
							<td>
								<a href="taskhome.php?view=updatedtask">Task Home</a>
							</td>				
						</tr>
					</table>
	<?php			
					}elseif($department == 2)
					{
	?>
						<table>
							<tr>
								<td>
									<input type="submit" value="Save" name="floorplan">
								</td>
	<?php
								if((((isset($_GET['floorplan'])) && ($_GET['floorplan'] == 'Save')) && (($row21['OnCallWMU'] <> 0) || ($row21['EliteWMU'] <> 0))) && ($con <> 0))
								{
									echo	'<input type = "hidden" name="taskid" value = "'.$id.'">'; 
	?>						
									<td>
										<input type="submit" value="Complete" name="complete">
									</td>
	<?php
								}
	?>								
							</tr>
						</table>
	<?php				
					}else
					{
	?>
						<table>
						  <tr>
								<td>
									<a href="taskhome.php?view=updatedtask">Task Home</a>
								</td>					
							</tr>	
						</table>	
	<?php				
					}
				}else
				{	
					if(!isset($_GET['print']))
					{
	?>
						<table>
						  <tr>
								<td>
									<a href="taskhome.php?view=updatedtask">Done</a>
								</td>					
							</tr>	
						</table>	
	<?php	
					}
				}
			}
						
	?>														
		</form>	
	<?php
		if(($_GET['view'] == "update") && (!isset($_GET['print'])))
		{
	?>			
			<table>
				<tr>
					<td width="350" valign="top">
						<table width="350">
						<form method="post" action="../csPortal_FileManage.php" enctype="multipart/form-data">
						<input type="hidden" name="action" value="add" />
						<input type="hidden" name="type" value="clean" />
						<input type="hidden" name="task_num" value="<?php echo $id; ?>" />						
	<?php
							echo '<tr><td colspan="5" align="center" background="../images/menu_gray.gif"><font face="Arial" size="3"><b>Clean Maps</b></font></td></tr>';
							mysql_select_db($dbname);
							$query10 = "SELECT * FROM filemanager WHERE refNumber = '$id' && attachType = 'clean' && publish = -1 ORDER BY timestamp DESC";
							$result10 = mysql_query($query10);
							if(mysql_num_rows($result10) > 0)
							{
								while($row10 = mysql_fetch_array($result10))
								{
									if($row10['fileType'] == "image/jpeg")
									{
									$icon = "JPG_Small.png";
									}
									elseif($row10['fileType'] == "image/gif")
									{
									$icon = "GIF_Small.png";
									}
									elseif($row10['fileType'] == "application/pdf")
									{
									$icon = "PDF_Small.png";
									}
									elseif($row10['fileType'] == "application/msword")
									{
									$icon = "DOC_Small.png";
									}
									elseif($row10['fileType'] == "application/vnd.ms-excel")
									{
									$icon = "XLSX_Small.png";
									}
									elseif($row10['fileType'] == "application/x-zip-compressed")
									{
									$icon = "ZIP_Small.png";
									}
									elseif($row10['fileType'] == "application/zip")
									{
									$icon = "ZIP_Small.png";
									}
									elseif($row10['fileType'] == "text/plain")
									{
									$icon = "LOG_Small.png";
									}
									echo '<tr><td width="27"><img src="../images/icons/'.$icon.'" width="26" height="26" /></td>';
									echo '<td><a href="../'.$row10['location'].'"><font face="Arial" size="2">' . $row10['name'] . '</font></a></td>';
									echo '<td><font face="Arial" size="2">'.$row10['size'].' KB</font></td>';
									echo '<td width="128" align="center"><font face="Arial" size="2">'.$row10['timestamp'].'</font></td>';
									echo '<td width="22"><a href="../csPortal_FileManage.php?action=deleteFile&fileID=' . $row10['id'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row10['name'].'?\')"><img src="../images/delete-icon_Small.png" width="15" height="15" border="0" /></a></td></tr>';
								}
								//echo '</table>';
							}
	?>   
							<tr>
								<td colspan="5"><font size="2" face="Arial"><strong>
									File Description:</strong></font><br /><input name="fileDesc" type="text" />
								</td>
							</tr>								
							<tr>
								<td colspan="5"><font size="2" face="Arial"><strong>
									File to Attach:</strong></font><br /><input name="uploadFile" size="35" type="file" /><i><?php echo ini_get('upload_max_filesize'); ?></i>
								</td>
							</tr>		
							<tr>
								<td colspan="5">
									<input name="submit" type="submit" value="Attach" />
								</td>
							</tr>		
						</form>	
					</table>
				</td>
				<td valign="top">
					<table>
						<form method="post" action="../csPortal_FileManage.php" enctype="multipart/form-data">
						<input type="hidden" name="action" value="add" />
						<input type="hidden" name="type" value="marked" />
						<input type="hidden" name="task_num" value="<?php echo $id; ?>" />					
							<tr>
								<td>
	<?php								
							echo '<tr><td colspan="5" align="center" background="../images/menu_gray.gif"><font face="Arial" size="3"><b>Marked Maps</b></font></td></tr>';
							mysql_select_db($dbname);
							$query10 = "SELECT * FROM filemanager WHERE refNumber = '$id' && attachType = 'marked' && publish = -1 ORDER BY timestamp DESC";
							$result10 = mysql_query($query10);
							if(mysql_num_rows($result10) > 0)
							{
								while($row10 = mysql_fetch_array($result10))
								{
									if($row10['fileType'] == "image/jpeg")
									{
									$icon = "JPG_Small.png";
									}
									elseif($row10['fileType'] == "image/gif")
									{
									$icon = "GIF_Small.png";
									}
									elseif($row10['fileType'] == "application/pdf")
									{
									$icon = "PDF_Small.png";
									}
									elseif($row10['fileType'] == "application/msword")
									{
									$icon = "DOC_Small.png";
									}
									elseif($row10['fileType'] == "application/vnd.ms-excel")
									{
									$icon = "XLSX_Small.png";
									}
									elseif($row10['fileType'] == "application/x-zip-compressed")
									{
									$icon = "ZIP_Small.png";
									}
									elseif($row10['fileType'] == "application/zip")
									{
									$icon = "ZIP_Small.png";
									}
									elseif($row10['fileType'] == "text/plain")
									{
									$icon = "LOG_Small.png";
									}
									echo '<tr><td width="27"><img src="../images/icons/'.$icon.'" width="26" height="26" /></td>';
									echo '<td><a href="../'.$row10['location'].'"><font face="Arial" size="2">' . $row10['name'] . '</font></a></td>';
									echo '<td><font face="Arial" size="2">'.$row10['size'].' KB</font></td>';
									echo '<td width="128" align="center"><font face="Arial" size="2">'.$row10['timestamp'].'</font></td>';
									echo '<td width="22"><a href="../csPortal_FileManage.php?action=deleteFile&fileID=' . $row10['id'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row10['name'].'?\')"><img src="../images/delete-icon_Small.png" width="15" height="15" border="0" /></a></td></tr>';
								}
								//echo '</table>';
							}
	?>   
							<tr>
								<td colspan="5"><font size="2" face="Arial"><strong>
									File Description:</strong></font><br /><input name="fileDesc" type="text" />
								</td>
							</tr>								
							<tr>
								<td colspan="5"><font size="2" face="Arial"><strong>
									File to Attach:</strong></font><br /><input name="uploadFile" size="35" type="file" /><i><?php echo ini_get('upload_max_filesize'); ?></i>
								</td>
							</tr>		
							<tr>
								<td colspan="5">
									<input name="submit" type="submit" value="Attach" />
								</td>
							</tr>			
						</table>	
					</td>
				</tr>
			</table>												
		</form>									
<?php	
		}
	}	
}

?>
