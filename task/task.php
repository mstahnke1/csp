﻿<?php
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
$conn11 = mysql_connect('127.0.0.1', 'csp', 'LperPKnzBxuhZJhC') or die(mysql_error());
mysql_select_db($dbname);
$uid = $_SESSION['uid'];
$email = $_SESSION['mail'];
$query1 = "SELECT id, f_name, l_name, dept, recRmaEmail, recFloorplan, manageRma FROM employees WHERE id = '$uid'";
$result1 = mysql_query($query1) or die (mysql_error());
$row1 = mysql_fetch_array($result1);
$employeeid = $row1['id'];      
$firstname = $row1['f_name'];
$lastname = $row1['l_name'];
$department = $row1['dept'];
$dsrma = $row1['recRmaEmail'];
$managerma = $row1['manageRma'];
mysql_close($conn11);	
$date = date('Y-m-d H:i:s');
$displaydate = date('m-d-Y');
$now = strtotime("now");
$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$tomorrowplus  = mktime (date("H"), date("i")+15, 0, date("m")  , date("d")+1, date("Y"));
$status = 0;
?>
	<SCRIPT LANGUAGE="JavaScript">
<!--
function showList() {
  sList = window.open("../csPortal_ticketReports.php?action=csLookup", "list", "width=350, height=500, scrollbars=yes");
}

function remLink() {
  if (window.sList && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>
<?php
	include '../includes/config.inc.php';
	include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
if((isset($_GET['taskid'])) && ((isset($_GET['view'])) && ($_GET['view']=='update')) && ((isset($_GET['type'])) && ($_GET['type'] == 12)))
{
	$id = $_GET['taskid'];
	header("Location: floorplan.php?view=update&type=12&taskid=$id");
}
//if((isset($_GET['taskid'])) && ((isset($_GET['view'])) && ($_GET['view']=='update')) && ((isset($_GET['type'])) && ($_GET['type'] == 11)))
//{
	//$id = $_GET['taskid'];
	//header("Location: rma.php?view=verify&taskid=$id");
//}
if(isset($_GET['q1']))
{
	mysql_select_db($dbname2);
?>
	<form method="GET" NAME="example12" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td colspan = "2" class="heading">
					Type: 
					<select name="type">
<?php
					$sqltype = "SELECT * FROM tbltype WHERE Page = 1 AND ID <> 11 AND ID <> 28";
					$resultsqltype = mysql_query($sqltype) or die (mysql_error());
					while($typeoption = mysql_fetch_array($resultsqltype))
					{
?>									
						<option value="<?php echo $typeoption['ID']; ?>"><?php echo $typeoption['Type']; ?></option>
<?php									
					}
?>
					</select>
				</td>	
			</tr>
<?php			
			if(isset($_GET['proid']))
			{
				$proid = $_GET['proid'];
				echo	'<input type = "hidden" name="proid" value = "'.$proid.'">';
			}
?>	
		  <tr>
				<td>
					<input type="submit" value="Continue" name="continue">
				</td>
			</tr>			
		</table>
	</form>
<?php
}
if((isset($_GET['continue'])) && ($_GET['continue'] == 'Continue'))
{
	mysql_select_db($dbname2);
	if(isset($_GET['proid']))
	{
		$proid = $_GET['proid'];
	}else
	{
		$proid = '0';
	}
	$type = $_GET['type'];
	if($type == 12)
	{
		header("Location: floorplan.php?view=floorplan&proid=$proid");
	}//elseif($type == 11)
	//{
	//	header("Location: rma.php?view=new&proid=$proid");
	//}
	else
	{
		header("Location: task.php?view=new&type=$type&proid=$proid");
	}
}
if((isset($_GET['floorplan'])) && ($_GET['floorplan'] == 'Done'))
{
	header("Location: taskhome.php?view=updatedtask");
}
//if((isset($_GET['action'])) && ($_GET['action'] == 'rmatohr'))
//{
	
	//header("Location: taskhome.php?view=updatedtask");
//}

if(isset($_GET['view']))
{
/*
*********************************************NEW TASK***********************************
*/
		if($_GET['view']=="new")
			{
				mysql_select_db($dbname2);
				$selectedtype = $_GET['type'];
				$sqltype = "SELECT * FROM tbltype WHERE ID = '$selectedtype'";
				$resultsqltype = mysql_query($sqltype) or die (mysql_error());
				$typeoption = mysql_fetch_array($resultsqltype);
?>

				<div class="container">
				<table width ="750" align="center" border = "0">
					<tr>
						<td align="center" class="bigheading">
							New Task
						</font></td>
					</tr>
				</table>
				<form method="GET" NAME="example12" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<table width ="750" align="center" border = "0" cellpadding = "5">
					<tr>
						<td colspan = "4" class="heading">
							**Subject: 	<input type="text" size="100" maxlength="100" name="subject" value="NONE">
						</td>
					</tr>
					<tr>
						<td class="heading">
							Type:
						</td>
						<td>
							<?php echo $typeoption['Type']; ?>
						</td>							
						<td class="heading">
							Priority:
							<select name=priority>
  							<option value = "1">Low</option>
  							<option value = "2">Medium</option>
  							<option value = "3">High</option>
  							<option value = "4">ASAP</option>
  							<option value = "5">TBD</option>
  							<option value = "6">Immediate</option>
    					</select>
    				</td> 
    				<td class="heading">
  						Status:
  						<select name=status>
  							<option value = "1">New</option>
  							<option value = "2">In Progress</option>
  							<option value = "3">Complete</option>
  							<option value = "4">Canceled</option>
  							<option value = "5">Deferred</option>
  						</select>
  					</td>
  				</tr>
  				<tr>
  					<td valign = "top" class="heading">
  						Description:
  					</td>
  				</tr>
  				<tr>
  					<td colspan = "4">
  						<textarea rows="6" cols="90" name="description"></textarea>
  					</td>
  				</tr>
  				<tr>
  					<td class="heading">
  						**Responsibility:
  					</td>
  					<td class="heading">
  						Co-Responsibility:
  					</td>
  					<td class="heading">
  						Check by:
  					</td>
  					<td class="heading">
  						Assigned to:
  					</td>
  				</tr>
  				
  				<tr>
  					<td>
  						<select name="employee"> 
  							<option value="0">None</option>
<?php
							mysql_select_db($dbname);
							$selectresponse = "SELECT id,f_name, l_name,dept FROM employees ORDER BY f_name";
					    $resselectresponse = mysql_query($selectresponse) or die (mysql_error());  
					    while($selectedresponse = mysql_fetch_array($resselectresponse))
					    	{
?>					    		
					    		<option value="<?php echo $selectedresponse['id']; ?>"><?php echo $selectedresponse['f_name']. ' '. $selectedresponse['l_name']; ?></option>
<?php
								}
?>
							</select>
						</td>		
						<td>
  						<select name="employee2"> 
  							<option value="0">None</option>
<?php
							mysql_select_db($dbname);
							$selectcoresponse = "SELECT id,f_name, l_name,dept FROM employees ORDER BY f_name";
					    $resselectcoresponse = mysql_query($selectcoresponse) or die (mysql_error());  
					    while($selectedcoresponse = mysql_fetch_array($resselectcoresponse))
					    	{
?>					    		
					    		<option value="<?php echo $selectedcoresponse['id']; ?>"><?php echo $selectedcoresponse['f_name']. ' '. $selectedcoresponse['l_name']; ?></option>
<?php
								}
?>
							</select>
						</td>
						<td>
  						<select name="employee3"> 
  							<option value="0">None</option>
<?php
							mysql_select_db($dbname);
							$selectcheck = "SELECT id,f_name, l_name,dept FROM employees ORDER BY f_name";
					    $resselectcheck = mysql_query($selectcheck) or die (mysql_error());  
					    while($selectedcheck = mysql_fetch_array($resselectcheck))
					    	{
?>					    		
					    		<option value="<?php echo $selectedcheck['id']; ?>"><?php echo $selectedcheck['f_name']. ' '. $selectedcheck['l_name']; ?></option>
<?php
								}
?>
							</select>
						</td>
						<td>
  						<select name="assignto"> 
  							<option value="0">None</option>
<?php
							mysql_select_db($dbname);
							$selectassign = "SELECT id,f_name, l_name,dept FROM employees ORDER BY f_name";
					    $resselectassign = mysql_query($selectassign) or die (mysql_error());  
					    while($selectedassign = mysql_fetch_array($resselectassign))
					    	{
?>					    		
					    		<option value="<?php echo $selectedassign['id']; ?>"><?php echo $selectedassign['f_name']. ' '. $selectedassign['l_name']; ?></option>
<?php
								}
?>
							</select>
						</td>
					</tr>
				</table>
				<table width ="750" align="center" border = "0">
					<tr>
						<td colspan = "1" width = "270" class="heading">
							**Due Date:	
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date1" VALUE="" SIZE=25>
				</td>
				<td>
					<A HREF="#"
   				onClick="cal.select(document.forms['example12'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
   				NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
  			</td>  			
<?php
					if(isset($_GET['ticketNum']))
						{
							$ticketnum = $_GET['ticketNum'];
?>	  					
  							<td class="heading">
									Ticket Reference <input type="text" size="12" maxlength="12" name="ticketNum" value =<?php echo $ticketnum; ?> readonly >							
								</td>						
<?php
						}else
						{
?>												
  							<td class="heading">
									Ticket Reference <input type="text" size="12" maxlength="12" name="ticketNum" value = 0>
								</td>		
<?php							
						}
?>		  			
				</table>
				<table width ="750" align="center" border = "0">	
					<tr>
						<td class="body">
							Created: <?php echo $date ?> by <?php echo $firstname . ' ' . $lastname; ?>
						</td>
					</tr>		
<?php
				if(isset($_GET['proid']))
				{
					$proid = $_GET['proid'];
					echo	'<input type = "hidden" name="proid" value = "'.$proid.'">';
				}
				echo	'<input type = "hidden" name="type" value = "'.$selectedtype.'">';  							
?>									
  			  <tr>
 						<td>
 							<input type="submit" value="Add Task" name="add">
 						</td>
					</tr>
  			</table>				
  			</form>
<?php						
				}
?>
				<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php				
/*
*********************************************UPDATE TASK***********************************
*/				
			if(($_GET['view']=="update") OR ($_GET['view']=="addremark"))
				{
					$taskid = $_GET['taskid'];
					echo	'<input type = "hidden" name="taskid" value = "'.$taskid.'">';
					mysql_select_db($dbname2);
					$sqltaskinfo = "SELECT * FROM taskinfo WHERE ID = '$taskid'";
					$resultsqltaskinfo = mysql_query($sqltaskinfo) or die (mysql_error());
					$taskinfo = mysql_fetch_array($resultsqltaskinfo);
					$sqlremarks = "SELECT * FROM tbltaskremarks WHERE taskid = '$taskid' ORDER BY ID DESC";
					$ressqlremarks = mysql_query($sqlremarks) or die (mysql_error());  
					//$remarkselected = mysql_fetch_array($ressqlremarks);
					$createdby = $taskinfo['Createdby'];
					$employee = $taskinfo['Response'];
					$employee2 = $taskinfo['Response2'];
					$employee3 = $taskinfo['Response3'];
					$assignto = $taskinfo['Assignto'];
					$type = $taskinfo['Type'];
					$selecttype = "SELECT Type FROM tbltype WHERE ID = '$type' AND Page = 1";
					$resultselecttype = mysql_query($selecttype) or die (mysql_error());
					$typeselected = mysql_fetch_array($resultselecttype);					
					$getfiles = "SELECT ID,path,filename FROM tbluploads WHERE taskid = '$taskid'";
					$resgetfiles = mysql_query($getfiles) or die (mysql_error());
					$status = $taskinfo['Status'];
					$query19 = "SELECT Status FROM tblstatus WHERE ID = '$status'";
					$result19 = mysql_query($query19) or die(mysql_error());
					$row19 = mysql_fetch_array($result19);
					$status1 = $row19['Status'];
					$priority = $taskinfo['Priority'];
					if($priority == 1)
						{
							$priority1 = "Low";
						}elseif($priority == 2)
						{
							$priority1 = "Medium";
						}elseif($priority == 3)
						{
							$priority1 = "High";
						}elseif($priority == 4)
						{
							$priority1 = "ASAP";
						}elseif($priority == 5)
						{
							$priority1 = "TBD";
						}elseif($priority == 6)
						{
							$priority1 = "Immediate";
						}
				}		
			if($_GET['view']=="update")
			{			
				?>
			<table width ="750" align="center" border = "0">
<?php
				if((isset($_GET['status'])) && ($_GET['status']=="added"))
				{
?>
					<tr>
						<td>
							<b><font color="#ff0000">Task Added Succesfully</b></font>
						</td>
					</tr>
<?php
				}	
				if(($employee == 2000) && ($status == 13))
				{
?>																				
					<tr>
						<td align="center" class="bigheading">
							CURRENT STATUS: AWAITING APPROVAL
						</font></td>
					</tr>	
<?php
				}elseif(($employee == 2002) && ($status == 1))
				{
?>																				
					<tr>
						<td align="center" class="bigheading">
							CURRENT STATUS: NEW
						</font></td>
					</tr>	
<?php
				}elseif(($employee == 2000) && ($status == 2))
				{
?>																				
					<tr>
						<td align="center" class="bigheading">
							CURRENT STATUS: IN PROGRESS, WORK COMPLETED
						</font></td>
					</tr>	
<?php
				}elseif(($employee == 2000) && ($status == 14))
				{
?>																				
					<tr>
						<td align="center" class="bigheading">
							CURRENT STATUS: WAITING FOR DS PO
						</font></td>
					</tr>	
<?php
				}else
				{													
?>																				
					<tr>
						<td align="center" class="bigheading">
							Update Task
						</font></td>
					</tr>
<?php
				}										
?>						
			</table>
			<table width ="750" align="center" border = "0" cellpadding = "2">
<?php
				if(($type == 11) OR ($type == 28))
				{
					$custnum = $taskinfo['CustomerNumber'];
					mysql_select_db($dbname);
					$query17 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custnum'";
					$result17 = mysql_query($query17) or die (mysql_error());
					$row17 = mysql_fetch_array($result17);
?>
					<tr>
						<td class="heading">
							Facility:
						</td>
						<td>
							<a href="../csPortal_Facilities.php?ticket_num=&f_name=&cust_num=<?php echo $custnum; ?>&by_cust=Lookup"><?php echo $row17['FacilityName']; ?>
						</td>
					</tr>
<?php					
				}		
?>				
				<tr>
					<td colspan = "1" class="heading" width = "85">
						Subject:
					</td> 	
					<td class="body" colspan="3" align="left">
						<?php echo $taskinfo['Subject']; ?>
					</td>
				</tr>
			</table>
			<table width ="750" align="center" border = "0">
				<tr>
					<td colspan = "2" class="heading" width="85">
						Type:
					</td>
					<td class="body">
						<?php echo $typeselected['Type']; ?>
					</td>
					<td class="heading">
						<b>Priority:</b>
<?php
						if($status == 3 OR $status == 4)
							{
								echo $priority1;						
							}else
							{
?>									
								<select name=priority>
									<option value ="<?php echo $priority; ?>"><?php echo $priority1;?></option>
									<option value = "1">Low</option>
									<option value = "2">Medium</option>
									<option value = "3">High</option>
									<option value = "4">ASAP</option>
									<option value = "5">TBD</option>
									<option value = "6">Immediate</option>
  							</select>									
<?php
							}
						echo '</td>';
						echo '<td>';
						echo '<b>Status:</b>';
						if($status == 3 OR $status == 4)
						{
							echo $status1;						
						}elseif(($type == 11) OR ($type == 28))
						{
							if(($employee == 2001) && ($status == 1))
							{
?>																	 
								<select name=status>
									<option value = "3">Complete</option>
									<option value = "4">Cancel</option>
								</select>
<?php								
							}
							if(($employee == 2000) && ($status == 1))
							{
?>																	 
								<select name=status>
									<option value = "13">Awaiting Approval</option>
									<option value = "14">Waiting For DS PO</option>
									<option value = "3">Complete</option>
									<option value = "4">Cancel</option>
								</select>
<?php								
							}
							if(($employee == 2000) && (($status == 13) OR ($status == 14)))
							{
?>																	 
								<select name=status>
									<option value = "3">Complete</option>
									<option value = "4">Cancel</option>
								</select>
<?php								
							}																	
							if(($employee == 2000) && ($status == 2))
							{
?>																	 
								<select name=status>
									<option value = "10">Order Created</option>
									<option value = "4">Cancel</option>
								</select>
<?php									
							}
							if(($employee == 2001) && ($status == 10))
							{
?>																	 
								<select name=status>
									<option value = "3">Complete</option>
									<option value = "4">Cancel</option>
								</select>
<?php									
							}							
							if($employee == 2002)
							{
?>																	 
								<select name=status>
									<option value = "1">New</option>
									<option value = "2">In Progress</option>
									<option value = "4">Cancel</option>
								</select>
<?php		
							}
						}else
						{											
?>																	 
							<select name=status>
								<option value ="<?php echo $status; ?>"><?php echo $status1;?></option>
								<option value = "1">New</option>
								<option value = "2">In Progress</option>
								<option value = "3">Complete</option>
								<option value = "4">Canceled</option>
								<option value = "5">Deferred</option>
							</select>
<?php
						}
?>						
					</td>
				</tr>	
				<tr>
					<td valign = "top" class="heading">
						<b>Description:</b>
					</td>
				</tr>
				<tr>
					<td colspan = "4" class="body">
						<?php echo stripslashes($taskinfo['Description']); ?>
					</td>
				</tr>
			</table>
			<table width ="750" align="center" border = "0" cellpadding = "0">
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>					
				<tr>
					<td class="heading">
						<b>Responsibility:</b>
					</td>
					<td class="heading">
						<b>Co-Responsibility:</b>
					</td>
					<td class="heading">
						<b>Check by:</b>
					</td>
					<td class="heading">
						<b>Assigned to:</b>
					</td>
				</tr>
				
				<tr>
					<td>
<?php
						mysql_select_db($dbname);
						$selectresponse = "SELECT id,f_name, l_name,dept FROM employees WHERE id = '$employee'";
				    $resselectresponse = mysql_query($selectresponse) or die (mysql_error()); 
				    $countrespone = mysql_num_rows($resselectresponse); 
				    $selectedresponse = mysql_fetch_array($resselectresponse);
				    if($countrespone > 0)
				    {
				    	echo $selectedresponse['f_name'] . ' ' . $selectedresponse['l_name'];
				    }else
				    {
				    	if($employee == 1000)
				    	{
				    		echo 'Floorplan GRP';
				    	}elseif($employee == 2000)
				    	{
				    		echo 'SALES RMA GRP';
				    	}elseif($employee == 2001)
				    	{
				    		echo 'WAREHOUSE RMA GRP';
				    	}elseif($employee == 2002)
				    	{
				    		echo 'RMA / Repair MGMT';
				    	}else
				    	{
				    		echo 'Unknown Contact Admin';
				    	}
				    }
?>		    		
					</td>		
					<td>
<?php
								mysql_select_db($dbname);
								$selectcoresponse = "SELECT id,f_name, l_name,dept FROM employees ORDER BY f_name";
				    		$resselectcoresponse = mysql_query($selectcoresponse) or die (mysql_error());  
				    		
						if($status == 3 OR $status == 4)
							{
									$getcoresponse = "SELECT f_name, l_name FROM employees WHERE id = '$employee2'";
									$resultco = mysql_query($getcoresponse) or die (mysql_error());
									$co = mysql_fetch_array($resultco);
									$f_name = $co['f_name'];
									$l_name = $co['l_name'];
									if($co == 0) { $f_name = "None"; }
									echo $f_name.' '.$l_name;
							}else
							{
?>
																			
								<select name="employee2"> 
									<option value="0" <?php if($employee2 == 0){ echo 'selected="selected"'; } ?>>None</option>
<?php

				    			{					    			
										while($selectedcoresponse = mysql_fetch_array($resselectcoresponse))
										{
?>											
				    				<option value="<?php echo $selectedcoresponse['id']; ?>" <?php if($selectedcoresponse['id'] == $employee2){ echo 'selected="selected"'; } ?>>  <?php echo  $selectedcoresponse['f_name']. ' '. $selectedcoresponse['l_name']; ?> </option>
<?php
										}
									}
?>
								</select>
<?php
							}	
?>														
					</td>
					<td>
<?php
						mysql_select_db($dbname);
						$selectcheck = "SELECT id,f_name, l_name,dept FROM employees ORDER BY f_name";
				    $resselectcheck = mysql_query($selectcheck) or die (mysql_error());  
						if($status == 3 OR $status == 4)
							{
									$getcoresponse = "SELECT f_name, l_name FROM employees WHERE id = '$employee3'";
									$resultco = mysql_query($getcoresponse) or die (mysql_error());
									$co = mysql_fetch_array($resultco);
									$f_name = $co['f_name'];
									$l_name = $co['l_name'];
									if($co == 0) { $f_name = "None"; }
									echo $f_name.' '.$l_name;
							}else
							{
?>
								<select name="employee3"> 
									<option value="0" <?php if($employee3 == 0){ echo 'selected="selected"'; } ?>>None</option>
<?php  																					    
				   		 	while($selectedcheck = mysql_fetch_array($resselectcheck))
				    			{
?>					    		
				    				<option value="<?php echo $selectedcheck['id']; ?>" <?php if($selectedcheck['id'] == $employee3){ echo 'selected="selected"'; } ?>>  <?php echo  $selectedcheck['f_name']. ' '. $selectedcheck['l_name']; ?> </option>
<?php
									}
?>
								</select>
<?php
							}
?>															
					</td>
					<td>
<?php
						mysql_select_db($dbname);
						$selectassign = "SELECT id,f_name, l_name,dept FROM employees ORDER BY f_name";
				    $resselectassign = mysql_query($selectassign) or die (mysql_error());	
						if($status == 3 OR $status == 4)
							{
									$getcoresponse = "SELECT f_name, l_name FROM employees WHERE id = '$assignto'";
									$resultco = mysql_query($getcoresponse) or die (mysql_error());
									$co = mysql_fetch_array($resultco);
									$f_name = $co['f_name'];
									$l_name = $co['l_name'];
									if($co == 0) { $f_name = "None"; }
									echo $f_name.' '.$l_name;
							}else
							{
?>					    
								<select name="assignto"> 
									<option value="0" <?php if($assignto == 0){ echo 'selected="selected"'; } ?>>None</option>
<?php
				    			while($selectedassign = mysql_fetch_array($resselectassign))
				    				{
?>					    		
				    					<option value="<?php echo $selectedassign['id']; ?>" <?php if($selectedassign['id'] == $assignto){ echo 'selected="selected"'; } ?>>  <?php echo  $selectedassign['f_name']. ' '. $selectedassign['l_name']; ?> </option>
<?php
										}
?>
								</select>
<?php
							}
?>							
					</td>
				</tr>
			</table>
			<table width ="459" align="left" border = "0" cellpadding = "2">
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan = "1" width = "100" class="heading">
						<b>Due Date:</b>
					</td>
					<td class="body">
						<?php echo $taskinfo['Duedate']; ?>
					</td>	
				</tr>

<?php
				if($taskinfo['ticketNum'] <> 0)
				{
					$ticketnum = $taskinfo['ticketNum'];
?> 					
					<tr> 
						<td class="heading" colspan="3">
							<b>Ticket Reference:</b> <?php echo '<a href="' . '../csPortal_Tickets.php?ticket_num='.$ticketnum.'&by_ticket=ticket">'.  $ticketnum . '</a>'; ?>									 						
						</td>		
					</tr>										
<?php
				}else
				{
?>
					<tr>
						<td class="heading" colspan="3">
							<b>Ticket Reference:</b><input type="text" size="10" maxlength="10" name="tickid" value="">
						</td>
					</tr>
<?php										
				}
				mysql_select_db($dbname2);
				$query29 = "SELECT ID FROM tblproactivecall WHERE TaskID = '$taskid'";
				$result29 = mysql_query($query29) or die (mysql_error());  
				$row29 = mysql_fetch_array($result29);
				if($row29['ID'] <> '-1')
				{
?>
					<tr> 
						<td class="heading">
							<b>Proactive Reference:</b> <?php echo '<a href="' . '../sales/proactivecall.php?view=viewqs&id='.$row29['ID'].'&action=update">'.  $row29['ID'] . '</a>'; ?>									 						
						</td>		
					</tr>
<?php				
				}		
				mysql_select_db($dbname);
				$selectcreator = "SELECT f_name,l_name FROM employees WHERE id = '$createdby'";
				$rescreator = mysql_query($selectcreator) or die (mysql_error());  
				$taskcreator = mysql_fetch_array($rescreator);
?>		  			

				<tr>
					<td class="heading">
						<b>Created By:</b>
					</td> 
					<td class="body">
						<?php echo $taskcreator['f_name'] . ' ' . $taskcreator['l_name'] ?> @ <?php echo $taskinfo['Createdate']; ?>
					</td>
				</tr>
			</table>
			<table width ="300" align="left" border = "0" cellpadding = "0">
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>					
				<tr>
					<td class="heading"><b>
						Files:
					</b></td>
				</tr>					
				<tr>
					<td>
<?php 
					while($gotfiles = mysql_fetch_array($resgetfiles))
						{
							$files = $gotfiles['filename'];
							$path = $gotfiles['path'];
							echo '<a href="' .$path.'">'. $files .' </a>';
						}
?>
					</td>
				</tr>					
			</table>
		</table>
			<table width ="759" align="center" border = "0" cellpadding = "4">					
<?php
				if($status <> 3 AND $status <> 4)
					{
?>													
							<tr>
								<td colspan = "3" align="center">
									<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?taskid='.$taskid.'&view=addremark&type='.$type .'">'. 'Add Remark' .' </a>'; ?> &nbsp;&nbsp; <b>Past Remarks, newest on top.</b>&nbsp;&nbsp;
									<?php echo '<a href="' . 'upload.php?taskid='.$taskid.'">' ?> Manage Files </a>
								</td>
							</tr>
<?php
					}
?>														
				</table>
<?php
							while($remarkselected = mysql_fetch_array($ressqlremarks))
								{
									mysql_select_db($dbname);
									$addedby = $remarkselected['addedby'];
									$query3 = "SELECT f_name, l_name FROM employees WHERE id = '$addedby'";
				  				$result3 = mysql_query($query3) or die (mysql_error());	
				  				$row3 = mysql_fetch_array($result3);
				  				$addedbyname = ($row3['f_name'].' '.$row3['l_name']); 
?>										
								<table width ="750" align = "center" border = "0" cellpadding = "4">
									<tr>
										<td valign="top" width = "80" class="heading">
											<b>Remarks:</b>
										</td>
										<td class="body">
											<?php echo $remarkselected['remarks']; ?>
										</td>
									</tr>
									<tr>	
										<td>
										</td>		
										<td class="heading">								
											<b>Signature:</b>
											 <?php echo $addedbyname . ' @ ' . $remarkselected['dateadded'] ?>
										</td>
									</tr>
								</table>
											
<?php											
								}		
?>				
			<table width ="750" align="center" border = "0" cellpadding = "4">
				<tr>
					<td>
						
			<table width ="750" align="center" border = "0" cellpadding = "4">										
			  <tr>
<?php
					if(!(($status == 3) OR ($status == 4)))
					{
						if($type <> 11)
						{				
	?>	  			  	
							<td>
								<input type="submit" value="Save" name="save">
							</td>
	<?php
						}
						if($type == 11)
						{
							if(($managerma == 1) && ($employee == 2002))
							{
	?>	  			  	
								<td>
									<input type="submit" value="Save" name="save">
								</td>
	<?php						
							}	
							if(($dsrma == 1) && ($employee == 2000))
							{
	?>	  			  	
								<td>
									<input type="submit" value="Save" name="save">
								</td>
	<?php								
							}
							if(($department == 5) && ($employee == 2001))
							{
	?>	  			  	
								<td>
									<input type="submit" value="Save" name="save">
								</td>
	<?php								
							}
						}
					}
?>	 				
					<td>
<?php 							
						echo '<input type="button" value="Back to Task Home" onClick="window.location.href=\'taskhome.php\'">';
?> 						
					</td>
				</tr>
			</table>					
			</form>
<?php
			if($type == 11)
			{
?>
				<table width="750">	
<?php				
				mysql_select_db($dbname2);
				$a = 0;
				$query30 = "SELECT * FROM tbltaskaudit WHERE taskid = '$taskid'";
				$result30 = mysql_query($query30) or die (mysql_error());	
				while($row30 = mysql_fetch_array($result30))
				{
					$a = $a + 1;
					$action = $row30['Action'];
					$querydone = addslashes($row30['Query']);
					$when = $row30['Date'];
					$who = $row30['User'];
					$response = $row30['response'];
					$auditassign = $row30['assignto'];
					$taskstatus = $row30['status'];
					mysql_select_db($dbname2);
					$query31 = "SELECT Status From tblstatus WHERE ID = '$taskstatus'";
					$result31 = mysql_query($query31) or die (mysql_error());
					$row31 = mysql_fetch_array($result31);		
					$status = $row31['Status'];						
					$priority = $row30['priority'];
					mysql_select_db($dbname);
					$query2 = "SELECT f_name, l_name FROM employees WHERE id = '$who'";
					$result2 = mysql_query($query2) or die (mysql_error());
					$row2 = mysql_fetch_array($result2);
					$name = $row2['f_name']. ' '. $row2['l_name'];
					if($response == 1000)
		    	{
		    		$responseemployee = 'Floorplan GRP';
		    	}elseif($response == 2000)
		    	{
		    		$responseemployee = 'SALES RMA GRP';
		    	}elseif($response == 2001)
		    	{
		    		$responseemployee = 'WAREHOUSE RMA GRP';
		    	}elseif($response == 2002)
		    	{
		    		$responseemployee = 'RMA / Repair MGMT';
		    	}else
		    	{
						$query3 = "SELECT f_name, l_name FROM employees WHERE id = '$response'";
						$result3 = mysql_query($query3) or die (mysql_error());
						$row3 = mysql_fetch_array($result3);
						$responseemployee = $row3['f_name']. ' '. $row3['l_name'];	
					}	
					$query4 = "SELECT f_name, l_name FROM employees WHERE id = '$auditassign'";
					$result4 = mysql_query($query4) or die (mysql_error());
					$row4 = mysql_fetch_array($result4);
					$assignemployee = $row4['f_name']. ' '. $row4['l_name'];									
?>
					<tr>
						<td colspan="3">
							<?php echo $a.'. '.$name . ' ' . $action . ' on ' . $when; ?>
						</td>
					</tr>
					<tr>
						<td>
							Status: <b><?php echo $status; ?></b>
						</td>
						<td>
							Responsibility: <?php echo $responseemployee; ?>
						</td>
<?php				
						if($taskstatus == 1 && $response == 2002)
						{	
?>							
							<td>
								Assigned To: <?php echo $assignemployee; ?>
							</td>		
<?php
						}
?>																	
					</tr>
					<tr>
						<td colspan = 3><div align="center"><hr width="100%"></div></td>
					</tr>					
<?php						
				}		
			}  			
		}	
/*
*********************************************ADDING REMARKS***********************************
*/
			if($_GET['view']=="addremark")
				{
					$taskid = $_GET['taskid'];
?>
					<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<table width ="450" border = "0" cellpadding = "2">
						<tr>
							<td colspan = "1" class="heading">
								Subject:
							</td>
							<td class="body">
								<?php echo $taskinfo['Subject']; ?>
							</td>
						</tr>
						<tr>
							<td class="heading">
								Enter Remark:
							</td>
							<td>
								<textarea rows="6" cols="40" name="remark"></textarea>
							</td>
						</tr>
						<tr>
							<td colspan = "3" class="heading">
								Past Remarks, newest on top.
							</td>
						</tr>
<?php
								while($remarkselected = mysql_fetch_array($ressqlremarks))
									{
										mysql_select_db($dbname);
										$addedby = $remarkselected['addedby'];
										$query3 = "SELECT f_name, l_name FROM employees WHERE id = '$addedby'";
					  				$result3 = mysql_query($query3) or die (mysql_error());	
					  				$row3 = mysql_fetch_array($result3);
					  				$addedbyname = ($row3['f_name'].' '.$row3['l_name']); 
?>
										
										
										<tr>
											<td colspan = "1" class="heading">
												Remarks: 
											</td>
											<td colspan="2" class="body">
												<?php echo $remarkselected['remarks']; ?>
											</td>
										</tr>
										<tr>
											<td colspan ="1" class="heading">
  											Signature:
  										</td>
  										<td colspan="2" class="body">
  											<?php echo $addedbyname . ' @ ' . $remarkselected['dateadded'] ?>
  										</td>
  									</tr>
												
<?php											
									} 
?>								
						<tr>										
 								<td>
 									<input type="submit" value="Save" name="saveremark">
 								</td>						 								
 								<td>
<?php 								
 								echo '<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'">';
?> 							
 							</td> 							
						</tr>
					</table>	
					</form>					
<?php					
				}
		}		
if((isset($_GET['add']))&& ($_GET['add']=="Add Task"))
{
	$duedate = $_GET['date1'];
	$type = $_GET['type'];
	$type1 = $type;
	$description = nl2br(addslashes($_GET['description']));
	$subject1 = addslashes($_GET['subject']);
	$priority = $_GET['priority'];
	$status = $_GET['status'];
	$employee = $_GET['employee'];
	$employee2 = $_GET['employee2'];
	$employee3 = $_GET['employee3'];
	$assignto = $_GET['assignto'];
	$completiondate = 0;
	$cancelationdate = 0;
	$duedateref = strtotime($duedate);
	$ticketnum = $_GET['ticketNum'];
	
	mysql_select_db($dbname);
	$query13 = "SELECT email,dept FROM employees WHERE id = '$employee' ORDER BY l_name";
	$result13 = mysql_query($query13) or die (mysql_error());
 	$row13 = mysql_fetch_array($result13);					
 	$employeedept = $row13['dept'];
 	$resemail = $row13['email'];
 	
	$query14 = "SELECT email,dept FROM employees WHERE id = '$employee2'";
 	$result14 = mysql_query($query14) or die (mysql_error());
	$row14 = mysql_fetch_array($result14);
	if($employee2 <> 0)
	{
		$employee2dept = $row14['dept'];
		$coresemail = $row14['email'];
	}else
	{
		$employee2dept = 0;
	}
	$query15 = "SELECT dept,email FROM employees WHERE id = '$employee3'";
  $result15 = mysql_query($query15) or die (mysql_error());
	$row15 = mysql_fetch_array($result15);
	if($employee3 <> 0)
	{
		$employee3dept = $row15['dept'];
		$checkemail = $row15['email'];
	}else
	{
		$employee3dept = 0;
	}
	$query16 = "SELECT id, f_name, l_name, dept,email FROM employees WHERE id = '$assignto'";
  $result16 = mysql_query($query16) or die (mysql_error());
  $row16 = mysql_fetch_array($result16);
  if($assignto <> 0)
	{
		$assigntodept = $row16['dept'];
		$assignemail = $row16['email'];
	}else
	{
		$assigntodept = 0;
	}	
	if($subject1 == "NONE")
	{
?>
			<table width ="450" border = "0" cellpadding = "2">
				<tr>
					<td>
						Subject cannot be NONE!!
					</td>
				</tr>	
			</table>
<?php						
	}elseif($employee == 0)
	{
?>
			<table width ="450" border = "0" cellpadding = "2">
				<tr>
					<td>
						Please Select Someone to be Responsible!!
					</td>
				</tr>	
			</table>
<?php						
	}elseif($duedateref < $now)
	{
?>
			<table width ="450" border = "0" cellpadding = "2">
				<tr>
					<td>
						Please Select due date later than now!!
					</td>
				</tr>	
			</table>
<?php			
	}else
	{		
/*
**************************************************SAVING NEW TASKS QUERY***********************************
*/								
		mysql_select_db($dbname2);
		$addtask = "INSERT INTO taskinfo (Type,Subject,Priority,Status,Description,Attachment,Createdate,Duedate,Response,Response2,Response3,Createdby, Assignto, Completiondate, Cancelationdate, employeedept,
				employee2dept, employee3dept, assigntodept, ticketNum) VALUES
				('$type','$subject1','$priority','$status', '$description','no','$date','$duedate','$employee','$employee2','$employee3','$employeeid','$assignto', '$completiondate', '$cancelationdate', '$employeedept',
				'$employee2dept', '$employee3dept', '$assigntodept', '$ticketnum')";	
		mysql_query($addtask) or die(mysql_error());
/*
**************************************************AUDIT ON NEW TASKS***********************************
*/				
		$query2 = "SELECT max(ID) FROM taskinfo";
		$result2 = mysql_query($query2) or die (mysql_error());
		$row2 = mysql_fetch_array($result2);
		$currentid = $row2['max(ID)'];
		if(isset($_GET['proid']))
		{
			$proid = $_GET['proid'];
			$query28 = "UPDATE tblproactivecall SET TaskID = '$currentid' WHERE ID = '$proid'";
			mysql_query($query28) or die(mysql_error());
		}			
		$sql = nl2br(addslashes($addtask));
		$audit = "INSERT INTO tbltaskaudit (Date, User, Action,taskid,Query,coresponse,priority,status,assignto,checkby) VALUES 
					('$date', '$employeeid', 'Added Task','$currentid','$sql', '$employee2','$priority', '$status', '$assignto', '$employee3')";
		mysql_query($audit) or die(mysql_error());		
		require_once "Mail.php";
		$description1 = stripslashes($description);
		$subject2 = stripslashes($subject1);
		$type = "text/html";
		$from = "Task Manager <donotreply@homefreesys.com>";
		$to = $resemail;
		$subject = "You are involved in a new task";
		$body = '<p><FIELDSET><b><legend><font face="Arial" size="2">Task '.$currentid.' has been added</font></legend></b>
				<dl><dt><font face="Arial" size="2">Subject: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$subject2.'</font></dd></dl>
				<dl><dt><font face="Arial" size="2">Description: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$description1.'</dd></dl></FIELDSET></p>
				<p><a href="'.'http://webapps/csPortal/task/task.php?taskid='.$currentid.'&view=update&type='.$type1.'">'.'Click here to view task'.' </a></p>';
		$host = "upsilon";
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
		if(($employee2 <> 0) && ($employee2 <> $employee) && ($employee2 <> $uid))
		{
			$to = $coresemail;
			$mail = $smtp->send($to, $headers, $body);
		}
		if(($employee3 <> 0) && ($employee3 <> $employee) && ($employee3 <> $employee2) && ($employee3 <> $uid))
		{
			$to = $checkemail;
			$mail = $smtp->send($to, $headers, $body);
		}
		if(($assignto <> 0) && ($assignto <> $employee) && ($assignto <> $employee2) && ($assignto <> $employee3) && ($assignto <> $uid))
		{
			$to = $assignemail;
			$mail = $smtp->send($to, $headers, $body);
		}		
		header("Location: task.php?view=update&taskid=$currentid&status=added&type=$type1");
	}
}
/*
**************************************************SAVING UPDATED TASKS***********************************
*/		
if((isset($_GET['save']))&& ($_GET['save']=="Save"))
{
	mysql_select_db($dbname2);
	$taskid = $_GET['taskid'];
	$sqltaskinfo = "SELECT * FROM taskinfo WHERE ID = '$taskid'";
	$ressqltaskinfo = mysql_query($sqltaskinfo) or die (mysql_error());
	$sqlinfo = mysql_fetch_array($ressqltaskinfo);
	$hellotype = $sqlinfo['Type'];
	$employee = $sqlinfo['Response'];
	$subject1 = addslashes($sqlinfo['Subject']);
	$description = $sqlinfo['Description'];
	$createdby = $sqlinfo['Createdby'];		
	if(isset($_GET['status']))
	{
		$status = $_GET['status'];		
	}
	$ticket = $sqlinfo['ticketNum'];
	if($ticket == 0)
	{
		if((isset($_GET['tickid'])) && ($_GET['tickid'] <> ''))
		{
			$tickid = $_GET['tickid'];
		}else
		{
			$tickid= 0;
		}
	}else
	{
		$tickid = $ticket;
	}
	if(isset($_GET['type']))
	{
		$type = $_GET['type'];
		$typechange = $type;
	}else
	{
		$type = $sqlinfo['Type'];
		$typechange = $sqlinfo['Type'];
	}
	if(isset($_GET['status']))
	{
		$status = $_GET['status'];
		$statuschange = $status;
		if($status == 3)
		{
			($completiondate = $date);
		}else
		{
			($completiondate = "0");
		}
		if($status == 4)
		{
			($cancelationdate = $date);
		}else
		{
			($cancelationdate = "0");
		}	
	}else
	{
		$status = $sqlinfo['Status'];
		$statuschange = $sqlinfo['Status'];
		$cancelationdate = $sqlinfo['Cancelationdate'];
		$completiondate = $sqlinfo['Completiondate'];
	}			
	if(isset($_GET['priority']))
	{
		$priority = $_GET['priority'];
		$prioritychange = $priority;
	}else
	{
		$priority = $sqlinfo['Priority'];
		$prioritychange = $sqlinfo['Priority'];
	}			
	if(isset($_GET['employee2']))
	{
		$employee2 = $_GET['employee2'];
		$cochange = $employee2;
	}else
	{
		$employee2 = $sqlinfo['Response2'];
		$cochange = $sqlinfo['Response2'];
	}	
	if(isset($_GET['employee3']))
	{
		$employee3 = $_GET['employee3'];
		$checkchange = $employee3;
	}else
	{
		$employee3 = $sqlinfo['Response3'];
		$checkchange = $sqlinfo['Response3'];
	}	
	if(isset($_GET['assignto']))
	{
		$assignto = $_GET['assignto'];
		$assignment = $assignto;
	}else
	{
		$assignto = $sqlinfo['Assignto'];
		$assignment = $sqlinfo['Assignto'];
	}														
	mysql_select_db($dbname);
	if($hellotype <> 11)
	{
		$query12 = "SELECT email,dept FROM employees WHERE id = '$createdby'";
  	$result12 = mysql_query($query12) or die (mysql_error());
   	$row12 = mysql_fetch_array($result12);	
   	$createdemail = $row12['email'];		
	
		$query13 = "SELECT email,dept FROM employees WHERE id = '$employee'";
  	$result13 = mysql_query($query13) or die (mysql_error());
   	$row13 = mysql_fetch_array($result13);					
	 	$employeedept = $row13['dept'];
	 	$resemail = $row13['email'];
 	}
	$query14 = "SELECT email,dept FROM employees WHERE id = '$employee2'";
 	$result14 = mysql_query($query14) or die (mysql_error());
	$row14 = mysql_fetch_array($result14);
	if($employee2 <> 0)
	{
		$employee2dept = $row14['dept'];
		$coresemail = $row14['email'];
	}else
	{
		$employee2dept = 0;
	}
	$query15 = "SELECT dept,email FROM employees WHERE id = '$employee3'";
  $result15 = mysql_query($query15) or die (mysql_error());
	$row15 = mysql_fetch_array($result15);
	if($employee3 <> 0)
	{
		$employee3dept = $row15['dept'];
		$checkemail = $row15['email'];
	}else
	{
		$employee3dept = 0;
	}
	$query16 = "SELECT dept,email FROM employees WHERE id = '$assignto'";
  $result16 = mysql_query($query16) or die (mysql_error());
  $row16 = mysql_fetch_array($result16);
  if($assignto <> 0)
	{
		$assigntodept = $row16['dept'];
		$assignemail = $row16['email'];
	}else
	{
		$assigntodept = 0;
	}							
	if($hellotype == 11)
	{
		if(($employee == 2002) && ($status == 2))
		{
			mysql_select_db($dbname);
			$query17 = "SELECT id,email FROM employees WHERE recRmaEmail = 1";
			$result17 = mysql_query($query17) or die(mysql_error());
			$count17 = mysql_num_rows($result17);
			$a = 0;
			$arr = array();
     	while($row17 = mysql_fetch_array($result17))
     	{
     		$a = $a + 1;
     		$id = $row17['id'];
     		$email = $row17['email'];
     		//echo $id.'<br>';
     		$arr[$a] = $email;
     		//print_r ($arr);
     	}  
     	$resemail = implode(', ', $arr);  	
		}
		elseif(($employee == 2000) && ($status == 10))
		{
			mysql_select_db($dbname);
			$query17 = "SELECT id,email FROM employees WHERE dept = 5";
			$result17 = mysql_query($query17) or die(mysql_error());
			$count17 = mysql_num_rows($result17);
			$a = 0;
			$arr = array();
     	while($row17 = mysql_fetch_array($result17))
     	{
     		$a = $a + 1;
     		$id = $row17['id'];
     		$email = $row17['email'];
     		//echo $id.'<br>';
     		$arr[$a] = $email;
     		//print_r ($arr);
     	}  
     	$resemail = implode(', ', $arr);    	
		}else
		{
			$resemail = 'donotreply@homefreesys.com';
		}
	}
/*
****************************************UPDATE QUERY*********************************************
*/				
	mysql_select_db($dbname2);			
	$updatetask = "UPDATE taskinfo SET Type = '$type', Status = '$status', Subject = '$subject1', Priority = '$priority', Response2 = '$employee2', Response3 = '$employee3', 
								Assignto = '$assignto', Completiondate = '$completiondate', Cancelationdate = '$cancelationdate', employee2dept = '$employee2dept', employee3dept = '$employee3dept', 
								assigntodept = '$assigntodept',ticketNum = '$tickid' WHERE ID = '$taskid'";
	mysql_query($updatetask) or die(mysql_error());
/*****************************************UPDATE RESPONSIBLITY AS RMA PROCESS GOES ALONG**********************************************/	
	$newresponse = $employee;
	if(($employee == 2002) && ($status == 2))
	{		
		mysql_select_db($dbname2);
		$newresponse = 2000;
		$updateresponse = "UPDATE taskinfo SET Response = '$newresponse' WHERE ID = '$taskid'";
		mysql_query($updateresponse) or die(mysql_error());
	}
	if(($employee == 2000) && ($status == 10))		
	{
		mysql_select_db($dbname2);
		$newresponse = 2001;
		$updateresponse = "UPDATE taskinfo SET Response = '$newresponse' WHERE ID = '$taskid'";
		mysql_query($updateresponse) or die(mysql_error());
	}		
	if(($employee == 2001) && ($status == 3))		
	{
		mysql_select_db($dbname2);
		$newresponse = 2002;
		$updateresponse = "UPDATE taskinfo SET Response = '$newresponse' WHERE ID = '$taskid'";
		mysql_query($updateresponse) or die(mysql_error());
	}	
/*
****************************************AUDIT UPDATE*********************************************
*/				
	if(($statuschange == $sqlinfo['Status']) AND ($prioritychange == $sqlinfo['Priority']) AND ($cochange == $sqlinfo['Response2']) AND ($checkchange == $sqlinfo['Response3']) AND ($assignment == $sqlinfo['Assignto']) AND ($newresponse == $sqlinfo['Response']))
	{
		$action = "VIEWED";
		$sql = "NO QUERY";
	}else
	{
		$action = "UPDATED";
		$sql = addslashes($updatetask);
		require_once "Mail.php";
		$from = "Task Manager <donotreply@homefreesys.com>";
		$type = "text/html";
		if($hellotype <> 28)
		{
			if(!(($hellotype == 11) && ($status == 3)))
			{
				$to = $resemail;
				$description1 = stripslashes($description);
				$subject2 = stripslashes($subject1);
				$subject = "A task has been updated";
				$body = '<p><FIELDSET><b><legend><font face="Arial" size="2">Task '.$taskid.' has been updated</font></legend></b>
						<dl><dt><font face="Arial" size="2">Subject: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$subject2.'</font></dd></dl>
						<dl><dt><font face="Arial" size="2">Description: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$description1.'</dd></dl></FIELDSET></p>
						<p><a href="'.'http://webapps/csPortal/task/task.php?taskid='.$taskid.'&view=update&type='.$hellotype.'">'.'Click here to view task'.' </a></p>';
				$host = "upsilon";
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
	 		 	if($uid <> $employee)
	 		 	{
					$mail = $smtp->send($to, $headers, $body);
				}
				if(($employee2 <> 0) && ($employee2 <> $employee) && ($employee2 <> $uid))
				{
					$to = $coresemail;
					$mail = $smtp->send($to, $headers, $body);
				}
				if(($employee3 <> 0) && ($employee3 <> $employee) && ($employee3 <> $employee2) && ($employee3 <> $uid))
				{
					$to = $checkemail;
					$mail = $smtp->send($to, $headers, $body);
				}
				if(($assignto <> 0) && ($assignto <> $employee) && ($assignto <> $employee2) && ($assignto <> $employee3) && ($uid <> $assignto))
				{
					if($hellotype == 11)
					{
						if($employee == 2002)
						{
							$to = $assignemail;
							$mail = $smtp->send($to, $headers, $body);
						}
					}else
					{
						$to = $assignemail;
						$mail = $smtp->send($to, $headers, $body);
					}
				}
				if(($createdby <> $assignto) && ($createdby <> $employee) && ($createdby <> $employee2) && ($createdby <> $employee3) && ($createdby <> $uid) && ($hellotype <> 11) && ($hellotype <> 28))
				{
					$to = $createdemail;
					$mail = $smtp->send($to, $headers, $body);
				}						
			}
		}
	}
	mysql_select_db($dbname2);
	$audit = "INSERT INTO tbltaskaudit (Date, User, Action, taskid, Query, coresponse, type, priority, status, assignto, checkby, response) VALUES 
					('$date','$employeeid','$action','$taskid','$sql','$cochange','$typechange','$prioritychange','$statuschange','$assignment','$checkchange','$newresponse')";
	mysql_query($audit) or die(mysql_error());					
	header("Location: task.php?view=update&taskid=$taskid&type=$hellotype");
}
/*
**************************************************SAVING REMARKS***********************************
*/	
	if((isset($_GET['saveremark']))&& ($_GET['saveremark']=="Save"))
		{
			mysql_select_db($dbname2);
			$taskid = $_GET['taskid'];
			$remarks = nl2br(addslashes($_GET['remark']));
			$addremark = "INSERT INTO tbltaskremarks (taskid,remarks,dateadded,addedby) VALUES ('$taskid','$remarks','$date','$employeeid')";
			mysql_query($addremark) or die(mysql_error());
/*
**************************************************AUDITING REMARKS***********************************
*/	
			$getstats = "SELECT Response,Response2,Response3,Assignto,Subject,Description,Createdby,Priority,Status,Type FROM taskinfo WHERE ID = '$taskid'";
			$resgetstats = mysql_query($getstats) or die (mysql_error());
    	$stats = mysql_fetch_array($resgetstats);
    	$hellotype = $stats['Type'];
    	$employee = $stats['Response'];
    	$createdby = $stats['Createdby'];
    	$employee2 = $stats['Response2'];
    	$employee3 = $stats['Response3'];
    	$assignto = $stats['Assignto'];
    	$subject1 = $stats['Subject'];
    	$description = $stats['Description'];
    	$status = $stats['Status'];
    	$priority = $stats['Priority'];			
			$sql = addslashes($addremark);
			$action = "ADDED REMARK";
			$auditremark = "INSERT INTO tbltaskaudit (Date, User, Action, taskid, Query, coresponse, type, priority, status, assignto, checkby) VALUES 
								('$date','$employeeid','$action','$taskid','$sql',0,0,'$priority','$status',0,0)";
			mysql_query($auditremark) or die(mysql_error());	
			mysql_select_db($dbname);
			$query12 = "SELECT email,dept FROM employees WHERE id = '$createdby'";
    	$result12 = mysql_query($query12) or die (mysql_error());
     	$row12 = mysql_fetch_array($result12);	
     	$createdemail = $row12['email'];	
     				
			$query13 = "SELECT email,dept FROM employees WHERE id = '$employee' ORDER BY l_name";
    	$result13 = mysql_query($query13) or die (mysql_error());
     	$row13 = mysql_fetch_array($result13);					
  	 	$employeedept = $row13['dept'];
  	 	$resemail = $row13['email'];
  	 	
			$query14 = "SELECT email,dept FROM employees WHERE id = '$employee2'";
     	$result14 = mysql_query($query14) or die (mysql_error());
    	$row14 = mysql_fetch_array($result14);
    	if($employee2 <> 0)
  		{
				$employee2dept = $row14['dept'];
				$coresemail = $row14['email'];
			}else
			{
				$employee2dept = 0;
			}
			$query15 = "SELECT dept,email FROM employees WHERE id = '$employee3'";
      $result15 = mysql_query($query15) or die (mysql_error());
 			$row15 = mysql_fetch_array($result15);
			if($employee3 <> 0)
				{
					$employee3dept = $row15['dept'];
					$checkemail = $row15['email'];
				}else
				{
					$employee3dept = 0;
				}
			$query16 = "SELECT dept,email FROM employees WHERE id = '$assignto'";
      $result16 = mysql_query($query16) or die (mysql_error());
      $row16 = mysql_fetch_array($result16);
      if($assignto <> 0)
      	{
  				$assigntodept = $row16['dept'];
  				$assignemail = $row16['email'];
  			}else
				{
					$assigntodept = 0;
				}				
			require_once "Mail.php";
					$from = "Task Manager <donotreply@homefreesys.com>";
					$to = $resemail;
					$type = "text/html";
					$subject = "A Remark has been added";
					$description1 = strip_tags($description);
					$remarks1 = stripslashes($remarks);
					$body = '<p><FIELDSET><b><legend><font face="Arial" size="2">A remark has been added to task '.$taskid.'</font></legend></b>
							<dl><dt><font face="Arial" size="2">Subject: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$subject1.'</font></dd></dl>
							<dl><dt><font face="Arial" size="2">Description: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$description1.'</font></dd></dl>
							<dl><dt><font face="Arial" size="2">Last Remark: </font></dt><dd><font face="Arial" size="2" color = "#666666">'.$remarks1.'</font></dd></dl></FIELDSET></p>
							<p><a href="'.'http://webapps/csPortal/task/task.php?taskid='.$taskid.'&view=update'.'">'.'Click here to view task'.' </a></p>';
					$host = "upsilon";
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
	   		 	if($employee <> $uid)
	   		 	{
						$mail = $smtp->send($to, $headers, $body);
					}
					if(($employee2 <> 0) && ($employee2 <> $employee) && ($employee2 <> $uid))
					{
						$to = $coresemail;
						$mail = $smtp->send($to, $headers, $body);
					}
					if(($employee3 <> 0) && ($employee3 <> $employee) && ($employee3 <> $employee2) && ($employee3 <> $uid))
					{
						$to = $checkemail;
						$mail = $smtp->send($to, $headers, $body);
					}
					if(($assignto <> 0) && ($assignto <> $employee) && ($assignto <> $employee2) && ($assignto <> $employee3) && ($assignto <> $uid))
					{
						$to = $assignemail;
						$mail = $smtp->send($to, $headers, $body);
					}	
					if(($createdby <> $assignto) && ($createdby <> $employee) && ($createdby <> $employee2) && ($createdby <> $employee3) && ($createdby <> $uid) && ($hellotype <> 11) && ($hellotype <> 28))
					{
						$to = $createdemail;
						$mail = $smtp->send($to, $headers, $body);
					}						
			header("Location: task.php?view=update&taskid=$taskid&type=$hellotype");
		}
/*
**************************************************VIEW ALL TASKS RELATED TO TICKET***********************************
*/	
if((isset($_GET['viewticketNum'])) OR (isset($_GET['viewtaskNum'])))
{
?>
	<table align = "center" width ="750" border = "0">	
		<tr>
			<td>
				All Tasks Related to this ticket
			</td>
		</tr>
		<tr>
			<td colspan = 3><div align="center"><hr width="100%"></div></td>
		</tr>
	</table>
<?php  		
	include 'includes/configtask.php';
	include 'includes/opendbtask.php';
	if(isset($_GET['viewticketNum']))
	{
		mysql_select_db($dbname2);
		$ticketNum = $_GET['viewticketNum'];
		$query101 = "SELECT * FROM taskinfo WHERE ticketNum = '$ticketNum'";
		$result101 = mysql_query($query101) or die (mysql_error()); 
	}
	if(isset($_GET['viewtaskNum']))
	{
		mysql_select_db($dbname2);
		$taskNum = $_GET['viewtaskNum'];
		$query101 = "SELECT * FROM taskinfo WHERE ticketNum = '$taskNum'";
		$result101 = mysql_query($query101) or die (mysql_error()); 
	}
	while($row101 = mysql_fetch_array($result101))
	{
		mysql_select_db($dbname2);
		$ID = $row101['ID'];
		$subject = $row101['Subject'];
		$status = $row101['Status'];
		$response = $row101['Response'];
		$assignto = $row101['Assignto'];
		$viewticketNum = $row101['ticketNum'];
		mysql_select_db($dbname2);
		$query12 = "SELECT Status From tblstatus WHERE ID = '$status'";
		$result12 = mysql_query($query12) or die (mysql_error());
		$row12 = mysql_fetch_array($result12);		
		$status = $row12['Status'];
		mysql_select_db($dbname);
		if($response == 1000)
  	{
  		$name = 'Floorplan GRP';
  	}elseif($response == 2000)
  	{
  		$name = 'SALES RMA GRP';
  	}elseif($response == 2001)
  	{
  		$name  = 'WAREHOUSE RMA GRP';
  	}elseif($response == 2002)
  	{
  		$name  = 'RMA / Repair MGMT';
  	}else
  	{	
			$query2 = "SELECT f_name, l_name FROM employees WHERE id = '$response'";
			$result2 = mysql_query($query2) or die (mysql_error());
			$row2 = mysql_fetch_array($result2);
			$name = $row2['f_name']. ' '. $row2['l_name'];
		}
		$query3 = "SELECT f_name, l_name FROM employees WHERE id = '$assignto'";
		$result3 = mysql_query($query3) or die (mysql_error());
		$row3 = mysql_fetch_array($result3);
		$name1 = $row3['f_name']. ' '. $row3['l_name'];
?>
		<table align="center"  border = "0">
			<tr>
				<?php echo  '<td><font face="Arial" size="1"><a href="' . 'task.php'.'?viewticketNum='.$viewticketNum . '&taskid='. $ID.'&view=update'.'">'.  $ID . 	'</td>' ; ?>
				<td>
					Subject: <?php echo $subject; ?>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					Responsibility: <?php echo $name; ?>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					Status: <?php echo $status; ?>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					Assigned To: <?php echo $name1; ?>
				</td>
			</tr>
			<tr>
				<td colspan = 2><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>
<?php
	}  		
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
	
