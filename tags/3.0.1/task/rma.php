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
<link rel="stylesheet" type="text/css" href="rma.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HomeFree Task Management</title>
<SCRIPT LANGUAGE="JavaScript">
<!--
function showList() {
  sList = window.open("../task/lookup.php?fr=rma","mywindow","width=450","height=350","scrollbars=1");
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
mysql_select_db('homefree');
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
$displaydate1 = date('m-d-Y');
$now = strtotime("now");
$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$tomorrowplus  = mktime (date("H"), date("i")+15, 0, date("m")  , date("d")+1, date("Y"));
$onehour  = mktime (date("H")+1, date("i"), 0, date("m")  , date("d"), date("Y"));
$twohour  = mktime (date("H")+2, date("i"), 0, date("m")  , date("d"), date("Y"));
$threehour  = mktime (date("H")+3, date("i"), 0, date("m")  , date("d"), date("Y"));
$fourhour  = mktime (date("H")+4, date("i"), 0, date("m")  , date("d"), date("Y"));
$status = 0;
include 'includes/configtask.php';
include 'includes/opendbtask.php';
require 'includes/functions.inc.php';
require_once "Mail.php";
/*****************************************************RE-OPEN CLOSED WARRANTY*************************************/
if((isset($_GET['open'])) && ($_GET['open'] == 'Re-Open'))
{
	$taskid = $_GET['taskid'];
	$query27 = "UPDATE taskinfo SET Status = '1' WHERE ID = '$taskid'";
	mysql_query($query27) or die(mysql_error());
	header("Location: rma.php?view=verify&taskid=$taskid");
}
/*****************************************************RE-OPEN CLOSED WARRANTY*************************************/
if(((isset($_GET['verified'])) && ($_GET['verified'] == 'Request_RMA')) OR ((isset($_GET['verified'])) &&  ($_GET['verified']=='Request_Warranty_ONLY_RMA')))
{
	if($_GET['verified'] == 'Request_RMA')
	{
		$taskid = $_GET['taskid'];
		$query30 = "UPDATE tblrmaserialinfo SET Status = 11 WHERE TaskID = '$taskid'";
		mysql_query($query30) or die(mysql_error());
	}
	if($_GET['verified'] == 'Request_Warranty_ONLY_RMA')
	{
		$taskid = $_GET['taskid'];
		$query30 = "UPDATE tblrmaserialinfo SET Status = 11 WHERE TaskID = '$taskid' AND Warranty = 2";
		mysql_query($query30) or die(mysql_error());
	}	
	$type = "text/html";
	$from = "Task Manager <donotreply@homefreesys.com>";
	$to = 'drewd@homefreesys.com';
	$subject = "Please Complete an RMA";
	$body = '<p><FIELDSET><b><legend><font face="Arial" size="2">RMA REQUIRED</font></legend></b>
			<dl><dt><font face="Arial" size="2">Subject: </font></dt><dd><font face="Arial" size="2" color = "#666666">RMA REQUEST</font></dd></dl>
			<dl><dt><font face="Arial" size="2">Description: </font></dt><dd><font face="Arial" size="2" color = "#666666">Click on the link below to complete the task.</dd></dl></FIELDSET></p>
			<p><a href="'.'http://webapps/csPortal/task/rma.php?taskid='.$taskid.'&view=verify'.'">'.'Click here to view task'.' </a></p>';
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
	$query27 = "UPDATE taskinfo SET Status = '11' WHERE ID = '$taskid'";
	mysql_query($query27) or die(mysql_error());
	header("Location: rma.php?view=verify&taskid=$taskid");
}
/*****************************************************INSERT TASK AND SERIAL NUMBERS*************************************/
if((isset($_GET['sns'])) && ($_GET['sns'] == 'Continue'))
{
	$qty = $_GET['qtysn'];
	$custNum = $_GET['custNum'];
	$priority = $_GET['priority'];
	$due = $_GET['timeframe'];
	if($due == 1)
	{
		$duedate = date('Y-m-d H:i:s', $onehour);
	}
	if($due == 2)
	{
		$duedate = date('Y-m-d H:i:s', $twohour);
	}
	if($due == 3)
	{
		$duedate = date('Y-m-d H:i:s', $threehour);
	}
	if($due == 4)
	{
		$duedate = date('Y-m-d H:i:s', $fourhour);
	}	
	$dspo = $_GET['dspo'];
	if($dspo = '')
	{
		$dspo = 0;
	}
	mysql_select_db('homefree');
	$query = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custNum'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	mysql_select_db('testwork');
	$facility = addslashes($row['FacilityName']);
	$query2 = "INSERT INTO taskinfo (Type,Subject,Priority,Status,Createdate,DueDate,Response,Response2,Createdby,employeedept,employee2dept,CustomerNumber,DSPO)
						VALUES ('11','$facility','$priority','1','$date','$duedate','4','1','$uid',2,2,'$custNum','$dspo')";					
	mysql_query($query2) or die(mysql_error());
	$query4 = "SELECT max(ID) FROM taskinfo";
	$result4 = mysql_query($query4) or die (mysql_error());
	$row4 = mysql_fetch_array($result4);
	$currentid = $row4['max(ID)'];
	$fname = stripslashes($facility);
	if(($qty <> 0) || ($qty <> ''))
	{
		for($sn=1;$sn <= $qty; $sn++)
		{
			$subsn = $_GET[$sn];
			$probid = $_GET['probdesc'.$sn];
			$query5 = "INSERT INTO tblrmaserialinfo (SN,TaskID,Problem,Status) VALUES ('$subsn','$currentid','$probid',0)";
			mysql_query($query5) or die(mysql_error());
		}	
		header("Location: rma.php?view=verify&taskid=$currentid");
	}	
}
/****************************************UPDATE SERIAL NUMBER OR PROBLEM****************************/
if((isset($_GET['update'])) && (($_GET['update'] == 'Set') || ($_GET['update'] == 'Remove')))
{
	$taskid = $_GET['taskid'];
	$query = "SELECT ID FROM tblrmaserialinfo WHERE TaskID = '$taskid'";
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$id = $row['ID'];
		if((isset($_GET[$id])) && ((isset($_GET['update'])) && ($_GET['update'] <> 'Remove')))
		{			
			echo $id;
			$query13 = "SELECT SN,Problem,Status FROM tblrmaserialinfo WHERE ID = '$id'";
			$result13 = mysql_query($query13) or die (mysql_error());
			$row13 = mysql_fetch_array($result13);
			$oldsn = $row13['SN'];
			$oldprob = $row13['Problem'];
			$newsn = $_GET[$id];
			$newprob = $_GET['probdesc'];			
			if(isset($_GET['partnum']))
			{
				$newpn = $_GET['partnum'];
				$query14 = "UPDATE tblrmaserialinfo SET PartNumber = '$newpn' WHERE ID = '$id'";
				mysql_query($query14) or die(mysql_error());
			}
			if(isset($_GET['status']))
			{
				$existing_status = $row13['Status'];
				if($existing_status <> 11)
				{
					$status = $_GET['status'];
					$query15 = "UPDATE tblrmaserialinfo SET Status = '$status' WHERE ID = '$id'";
					mysql_query($query15) or die(mysql_error());
				}
			}	
			if(isset($_GET['warranty']))
			{
				$warranty = $_GET['warranty'];
				$query18 = "UPDATE tblrmaserialinfo SET Warranty = '$warranty' WHERE ID = '$id'";
				mysql_query($query18) or die(mysql_error());
			}						
			if(($newsn <> $oldsn) && ($newprob == $oldprob))
			{
				$query12 = "UPDATE tblrmaserialinfo SET SN = '$newsn' WHERE ID = '$id'";
				mysql_query($query12) or die(mysql_error());
				header("Location: rma.php?verified=Update&taskid=$taskid&oldsn=$oldsn&newsn=$newsn&x=1");
			}elseif(($newsn == $oldsn) && ($newprob <> $oldprob))
			{
				$query12 = "UPDATE tblrmaserialinfo SET Problem = '$newprob' WHERE ID = '$id'";
				mysql_query($query12) or die(mysql_error());
				header("Location: rma.php?verified=Update&taskid=$taskid&oldsn=$oldsn&oldprob=$oldprob&newprob=$newprob&x=2");
			}elseif(($newsn <> $oldsn) && ($newprob <> $oldprob))
			{
				$query12 = "UPDATE tblrmaserialinfo SET SN = '$newsn',Problem = '$newprob' WHERE ID = '$id'";
				mysql_query($query12) or die(mysql_error());
				header("Location: rma.php?verified=Update&taskid=$taskid&oldsn=$oldsn&newsn=$newsn&oldprob=$oldprob&newprob=$newprob&x=3");
			}
			else
			{
				header("Location: rma.php?verified=Update&taskid=$taskid&x=4");
			}
		}elseif((isset($_GET[$id])) && (!isset($_GET['Remove'])))
		{
			$query17 = "DELETE FROM tblrmaserialinfo WHERE ID = '$id'";
			mysql_query($query17) or die(mysql_error());
			header("Location: rma.php?verified=Update&taskid=$taskid&x=5");
		}		
	}
}
if((isset($_GET['addsn'])) && ($_GET['addsn'] == 'Add'))
{
	$taskid = $_GET['taskid'];
	$addsn = $_GET['addedsn'];
	$probid = $_GET['probdescadd'];
	$query5 = "INSERT INTO tblrmaserialinfo (SN,TaskID,Problem,Status) VALUES ('$addsn','$taskid','$probid',0)";
	mysql_query($query5) or die(mysql_error());
	header("Location: rma.php?verified=Update&taskid=$taskid&text=1");
}
if((isset($_GET['verified'])) && ($_GET['verified'] == 'Continue'))
{
	$taskid = $_GET['taskid'];
	header("Location: rma.php?view=verify&taskid=$taskid");
}
if((isset($_GET['verified'])) && ($_GET['verified'] == 'Home'))
{
	$taskid = $_GET['taskid'];
	header("Location: taskhome.php");
}
if((isset($_GET['verified'])) && ($_GET['verified'] == 'Complete_Task'))
{
	$taskid = $_GET['taskid'];
	$query22 = "UPDATE taskinfo SET Status = 3, Completiondate = '$date' WHERE ID = '$taskid'";
	mysql_query($query22) or die(mysql_error());
	header("Location: taskhome.php?view=updatedtask");
}
if((isset($_GET['contact'])) && ($_GET['contact'] == 'Save'))
{
	$taskid = $_GET['taskid'];
	$attn = $_GET['attn'];
	$query19 = "UPDATE taskinfo SET Attention = '$attn' WHERE ID = '$taskid'";
	mysql_query($query19) or die(mysql_error());
	header("Location: rma.php?verified=Create_RMA&taskid=$taskid&comp=1");	
}
/****************************************Saving Remarks****************************/
if((isset($_GET['remark'])) && ($_GET['remark'] == 'Add'))
{
	$remark = addslashes($_GET['remarks']);
	$taskid = $_GET['taskid'];
	$query23 = "INSERT INTO tbltaskremarks (taskid,remarks,dateadded,addedby) VALUES ('$taskid','$remark','$date','$uid')";
	mysql_query($query23) or die(mysql_error());
	header("Location: rma.php?verified=Update&taskid=$taskid");
}
/*****************************************VIEW PAGE****************************************/
if(!((isset($_GET['verified'])) && ($_GET['verified'] == 'Create_RMA')))
{
?>
<div class="container">
	<table width ="750" class="hborder">
		<tr>
			<td align="center" class="bigheading">
				Warranty Check / RMA
			</font></td>
		</tr>
	</table>
</div>
<?php
}
if((isset($_GET['view'])) && ($_GET['view'] == 'new'))
{
?>
	<form name="searchParams" id="searchParams" onSubmit="javascript:get(document.getElementById('searchParams'));">
		<table width="750">
			<tr>
				<td class="heading">
					Enter the Customer Number:
				</td>
				<td>
					<INPUT TYPE="text" NAME="custNum" id="custNum" VALUE="" SIZE="6" maxlength="6" />
					<INPUT TYPE="button" VALUE="Find" onClick="showList()">			
				</td>
			</tr>
			<tr>
				<td class="heading">
					How many serial numbers are you submitting?
				</td>
				<td>
					<input type="text" size="2" maxlength="2" name="qtysn" value="">
				</td>
			</tr>
			<tr>
				<td class="note">
					**Enter 0 if there are no serialized parts in the RMA.
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Continue" name="qty">
				</td>
			</tr>
		</table>
	</form>
<?php
}
if((isset($_GET['qty'])) && ($_GET['qty'] == 'Continue'))
{
	$qty = $_GET['qtysn'];
	$custnum = $_GET['custNum'];
	mysql_select_db('homefree');
	$query = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custnum'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	mysql_select_db('testwork');	
?>
	<form method="GET" NAME="example12" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table class="gray">
			<tr>
				<td class="heading">
					Facility Name:
				</td>
				<td class="body">
					<?php echo $row['FacilityName']; ?> 
				</td>
				<td class="heading">
					Problem Description
				</td>
			</tr>					
<?php				
			for($sn=1;$sn <= $qty; $sn++)
			{
?>
				<tr>
					<td class="heading">
						Serial Number:
					</td>
					<td>
						<input type="text" size="10" maxlength="10" name="<?php echo $sn; ?>" value="">
					</td>		
					<td>
					<select name="probdesc<?php echo $sn; ?>">
<?php
					$query10 = "SELECT ID,Problem FROM tblrmaproblem WHERE RMA = 1";
					$result10 = mysql_query($query10) or die (mysql_error());
					while($row10 = mysql_fetch_array($result10))
					{
?>
						<option value="<?php echo $row10['ID']; ?>"><?php echo $row10['Problem']; ?></option>
<?php
					}
?>				
					</select>
					</td>				
				</tr>
<?php		
			}
			echo	'<input type = "hidden" name="qtysn" value = "'.$qty.'">';
			echo	'<input type = "hidden" name="custNum" value = "'.$custnum.'">';
?>
			<tr>
				<td class="heading">
					Prioirty:
				</td>
				<td>
				<select name="priority">
<?php
				mysql_select_db('testwork');
				$query3 = "SELECT ID,Priority FROM tblpriority WHERE RMA = 1";
				$result3 = mysql_query($query3) or die (mysql_error());
				while($row3 = mysql_fetch_array($result3))
				{
?>
					<option value="<?php echo $row3['ID']; ?>"><?php echo $row3['Priority']; ?></option>
<?php
				}
?>		
				</select>
				</td>							
			</tr>
			<tr>
				<td class="heading">
					Feedback requested in:
				</td>
				<td>
				<select name="timeframe">
					<option value="1">1 Hour</option>
					<option value="2">2 Hours</option>
					<option value="3">3 Hours</option>
					<option value="4">4 Hours</option>
				</select>
				</td>
			</tr>
			<tr>
				<td class="heading">
					DS PO #
				</td>
				<td>
					<input type="text" size="10" maxlength="10" name="dspo" value="">
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Continue" name="sns">
				</td>
			</tr>
		</table>
	</form>
<?php		
}
if(((isset($_GET['view'])) && ($_GET['view'] == 'verify')) OR (isset($_GET['verified'])))
{
	$taskid = $_GET['taskid'];
	mysql_select_db('testwork');
	$query6 = "SELECT * FROM tblrmaserialinfo WHERE TaskID = '$taskid'";
	$result6 = mysql_query($query6) or die (mysql_error());
	$query8 = "SELECT * FROM taskinfo WHERE ID = '$taskid'";
	$result8 = mysql_query($query8) or die (mysql_error());
	$row8 = mysql_fetch_array($result8);
	$due = strtotime($row8['Duedate']);
	$duedate = date('Y-m-d g:i:s A',$due);
	$creator = $row8['Createdby'];
	$custnum = $row8['CustomerNumber'];
	$taskstatus = $row8['Status'];
	$priority = $row8['Priority'];
	$query31 = "SELECT * FROM tblpriority WHERE ID = '$priority'";
	$result31 = mysql_query($query31) or die (mysql_error());
	$row31 = mysql_fetch_array($result31);
	mysql_select_db('homefree');
	$query7 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custnum'";
	$result7 = mysql_query($query7) or die (mysql_error());
	$row7 = mysql_fetch_array($result7);
	$query9 = "SELECT f_name, l_name FROM employees WHERE id = '$creator'";
	$result9 = mysql_query($query9) or die (mysql_error());
	$row9 = mysql_fetch_array($result9);	
	$creatorname = $row9['f_name'].' '.$row9['l_name'];
	if((isset($_GET['view'])) && ($_GET['view'] == 'verify'))
	{
		
?>
		<form method="GET" NAME="example12" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<table class="gray">
				<tr>
					<td class="heading" width="125">
						Verify Information:
					</td>
					<td class="body">
						<?php echo $row7['FacilityName'];?>
					</td>
					<td class="body">
						Requested By:<br> <?php echo $duedate;?>
					</td>
					<td class="body">
						Submitted By:<br> <?php echo $creatorname; ?>
					</td>
				</tr>
			</table>
			<table class="gray" width="750">		
				<tr>
					<td class="heading" width="115">
						Part Number
					</td>
					<td class="heading" width="110">
						Serial Number
					</td>
					<td class="heading" width="130">
						Problem Desc.
					</td>
					<td class="heading" width="140">
						Status
					</td>
					<td class="heading" width="140">
						Warranty
					</td>	
					<td class="heading" width="140">
						RMA
					</td>		
				</tr>					
<?php			
			$a = 0;
			$r = 0;
			while($row6 = mysql_fetch_array($result6))
			{
				mysql_select_db('testwork');	
				$probid = $row6['Problem'];	
				$isrma = $row6['isRMA'];	
				$query11 = "SELECT Problem FROM tblrmaproblem WHERE ID = '$probid'";
				$result11 = mysql_query($query11) or die (mysql_error());
				$row11 = mysql_fetch_array($result11);
				if($isrma == 0)
				{
					$r = 1;
				}
?>
				<tr>
<?php
				if($row6['PartNumber'] <> 0)
				{
?>					
					<td class="body1">
						<?php echo ''.$row6['PartNumber']; ?>
					</td>	
<?php
				}else
				{
?>								
					<td width="125">
					</td>	
<?php
				}
?>					
					<td class="sn">
<?php				
						echo ''.$row6['SN'];
?>
					</td>
					<td class="body">
						<?php echo $row11['Problem']; ?>
					</td>
					<td class="body">
<?php											
						$status = $row6['Status'];
						$query16 = "SELECT ID,Status FROM tblstatus WHERE ID = '$status'";
						$result16 = mysql_query($query16) or die (mysql_error());
						$row16 = mysql_fetch_array($result16);
						if($status <> 0)
						{
							echo $row16['Status'];
						}else
						{
							echo 'Not Confirmed';
							$a = 1;
						}
?>
					</td>			
					<td class="body">
<?php 			
						if($row6['Warranty'] == 1)
						{ 
							$warranty = 'NO';
						}elseif($row6['Warranty'] == 2)
						{
							$warranty = 'YES';
						}elseif($row6['Warranty'] == 3)
						{
							$warranty = 'NO (Battery Only)';						
						}else
						{
							$warranty = '--';
						}
?>
						<?php echo $warranty; ?>
					</td>		
					<td class="body">
<?php 			if($row6['isRMA'] == 1)
						{ 
							$rma = 'YES';
						}else
						{
							$rma = 'NO';
						}
?>
						<?php echo $rma; ?>
					</td>											
				</tr>
<?php		
			}
			echo	'<input type = "hidden" name="taskid" value = "'.$taskid.'">';
?>		
			</table>
			<table class="gray" width="750">	
<?php				
				if((isset($_GET['notes'])) && ($_GET['notes'] == 1))
				{					
?>					
				<tr>
					<td class="heading" colspan="6">
						<a href="../task/rma.php?view=verify&taskid=<?php echo $taskid;?>">Close Notes</a> (click to close)
					</td>
				</tr>
<?php		
				}else
				{
?>					
				<tr>
					<td class="heading" colspan="6">
						<a href="../task/rma.php?view=verify&notes=1&taskid=<?php echo $taskid;?>">Notes / Remarks</a> (click to view)
					</td>
				</tr>
<?php
				}									
				if((isset($_GET['notes'])) && ($_GET['notes'] == 1))
				{
					mysql_select_db('testwork');
					$query24 = "SELECT remarks,dateadded,addedby FROM tbltaskremarks WHERE taskid = '$taskid'";
					$result24 = mysql_query($query24) or die (mysql_error());
					while($row24 = mysql_fetch_array($result24))
					{
						$added = $row24['addedby'];
						mysql_select_db('testhomefree');
						$query25 = "SELECT f_name, l_name FROM employees WHERE id = '$added'";
						$result25 = mysql_query($query25) or die (mysql_error());
						$row25 = mysql_fetch_array($result25);				
	?>
						<tr>
							<td colspan="6" class="body2">
								<?php echo nl2br($row24['remarks']);?>
							</td>
						</tr>
						<tr>
							<td colspan="6" class="heading">
								By: <?php echo $row25['f_name'].' '.$row25['l_name'].' @ '.$row24['dateadded'];?>
							</td>
						</tr>
	<?php	
					}	
				}
			if($a < 1)
			{
?>				
				<tr>	
<?php
					if(($taskstatus <> 3) && ($department == 2))
					{			
?>								
						<td>
							<input type="submit" value="Update" name="verified">
						</td>					
<?php
					}
					if((isset($_GET['rpt'])) && ($_GET['rpt'] == 1))
					{
?>											
						<td>
							<?php echo '<input type="button" value="Back" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'">'; ?>
						</td>				
<?php
					}else
					{							
?>											
						<td>
							<input type="submit" value="Home" name="verified">
						</td>
<?php
					}
					if(($r <> 0) && ($department == 2))
					{			
?>						
						<td>
							<input type="submit" value="Create_RMA" name="verified">
						</td>
<?php
					}elseif((($r <> 0) && ($department <> 2)) && ($taskstatus <> 11))
					{			
?>						
						<td>
							<input type="submit" value="Request_RMA" name="verified">
						</td>
						<td>
							<input type="submit" value="Request_Warranty_ONLY_RMA" name="verified">
						</td>						
<?php
					}	
					if($taskstatus == 11)
					{
						echo '<td>RMA Pending</td>';
					}elseif($taskstatus == 12)
					{
						echo '<td>RMA Completed</td>';
					}
					if(($taskstatus <> 3) AND ($taskstatus <> 11) AND ($taskstatus <> 12))
					{			
?>								
						<td>
							<input type="submit" value="Complete_Task" name="verified">
						</td>	
<?php
					}else
					{
						if((($uid == 1) OR ($uid == 4) OR ($uid == 19)) AND ($taskstatus <> 11))
						{
?>								
							<td>
								<input type="submit" value="Re-Open" name="open">
								<?php echo	'<input type = "hidden" name="taskid" value = "'.$taskid.'">'; ?>
							</td>	
<?php				
						}
					}			
?>															
				</tr>
<?php
			}else
			{
?>				
				<tr>	
<?php
					if($taskstatus <> 3)
					{			
?>								
						<td>
							<input type="submit" value="Update" name="verified">
						</td>					
<?php
					}
?>					
					<td>
						<input type="submit" value="Home" name="verified">
					</td>
				</tr>
<?php			
			}				
?>				
			</table>							
		</form>
<?php				
	}
	if((isset($_GET['verified'])) && ($_GET['verified'] <> 'Create_RMA'))
	{
		if(isset($_GET['text']))
		{
			if($_GET['text'] == 1)
			{
				$text = 'Serial Number has been added to the RMA';
			}
		}		
		if((isset($_GET['x'])) && ($_GET['x'] == 1))
		{
			$newsn = $_GET['newsn'];
			$oldsn = $_GET['oldsn'];
?>	
			<table width="750" class="border">
				<tr>
					<td class="note">
						<?php echo 'Serial Number '.$oldsn.' has been changed to '.$newsn; ?>
					</td>
				</tr>
			</table>
<?php
		}
		if((isset($_GET['x'])) && ($_GET['x'] == 2))
		{
			$newprob = $_GET['newprob'];
			$oldprob = $_GET['oldprob'];
			$oldsn = $_GET['oldsn'];
			mysql_select_db('testwork');
			$query14 = "SELECT ID,Problem FROM tblrmaproblem";
			$result14 = mysql_query($query14) or die (mysql_error());
			while($row14 = mysql_fetch_array($result14))
			{
				if($row14['ID'] == $newprob)
				{
					$x=$row14['Problem'];
				}
				if($row14['ID'] == $oldprob)
				{
					$y = $row14['Problem'];
				}
			}	
?>	
			<table width="750" class="updateborder">
				<tr>
					<td class="note">
						<?php echo 'The Problem for '.$oldsn.' <b>'.$y.'</b> has been changed to <b>'.$x.'</b>'; ?>
					</td>
				</tr>
			</table>
<?php		
		}	
		if((isset($_GET['x'])) && ($_GET['x'] == 3))
		{
			$newprob = $_GET['newprob'];
			$oldprob = $_GET['oldprob'];
			$oldsn = $_GET['oldsn'];
			$newsn = $_GET['newsn'];
			mysql_select_db('testwork');
			$query14 = "SELECT ID,Problem FROM tblrmaproblem";
			$result14 = mysql_query($query14) or die (mysql_error());
			while($row14 = mysql_fetch_array($result14))
			{
				if($row14['ID'] == $newprob)
				{
					$x=$row14['Problem'];
				}
				if($row14['ID'] == $oldprob)
				{
					$y = $row14['Problem'];
				}
			}						
?>	
			<table width="750" class="updateborder">
				<tr>
					<td class="note">
					<?php echo 'Serial Number '.$oldsn.' has been changed to '.$newsn. ' and the Problem for '.$newsn.' has been changed to <b>'.$x.'</b>'; ?>
					</td>
				</tr>
			</table>
<?php
		}		
		if((isset($_GET['x'])) && ($_GET['x'] == 5))
		{
?>	
			<table width="750" class="updateborder">
				<tr>
					<td class="note">
					<?php echo 'Serial Number has been removed from RMA'; ?>
					</td>
				</tr>
			</table>
<?php
		}			
		if((isset($_GET['text'])) && ($_GET['text'] == 1))
		{
?>	
			<table width="750" class="updateborder">
				<tr>
					<td class="note">
						<?php echo $text; ?>
					</td>
				</tr>	
			</table>
<?php		
		}		
?>						
			
		<table width="750" class="gray">		
			<tr>
				<td class="heading" width="125">
					Update Information:
				</td>
				<td class="body">
					<?php echo $row7['FacilityName'];?>
				</td>
				<td class="body">
					Requested By:<br> <?php echo $duedate;?>
				</td>
				<td class="body">
					Submitted By:<br> <?php echo $creatorname; ?>
				</td>
			</tr>
		</table>
		<table width="750" class="gray">
			<tr>
				<td class="heading" width="115">
					Part Number
				</td>
				<td class="heading" width="110">
					Serial Number
				</td>
				<td class="heading" width="130">
					Problem Desc.
				</td>
				<td class="heading" width="140">
					Status
				</td>
				<td class="heading" width="140">
					Warranty
				</td>				
			</tr>						
<?php			
		while($row6 = mysql_fetch_array($result6))
		{
			mysql_select_db('testwork');	
			$probid = $row6['Problem'];		
			$query11 = "SELECT Problem FROM tblrmaproblem WHERE ID = '$probid'";
			$result11 = mysql_query($query11) or die (mysql_error());
			$row11 = mysql_fetch_array($result11);
?>
			
				<form method="GET" NAME="update" action="<?php echo $_SERVER['PHP_SELF'];?>">			
<?php
			echo	'<input type = "hidden" name="taskid" value = "'.$taskid.'">';
?>					
				<tr>
<?php
				if($department == 2)
				{
?>					
					<td>
						<input type="text" size="12" maxlength="10" name="partnum" value="<?php echo ''.$row6['PartNumber']; ?>">
					</td>	
<?php
				}else
				{
?>								
					<td>
						<?php echo $row6['PartNumber']; ?>
					</td>	
<?php
				}
				if($row6['Status'] <> 8)
				{
?>																	
					<td>			
						<input type="text" size="12" maxlength="10" name="<?php echo $row6['ID']; ?>" value="<?php echo ''.$row6['SN']; ?>">
					</td>
<?php
				}else
				{
?>																	
					<td>	
						<?php /*echo	'<input type = "hidden" name="'.$row6['ID'].'" value = "'.$row6['SN'].'">'; ?><?php echo $row6['SN']; */?>
						<input type="text" size="12" maxlength="10" name="<?php echo $row6['ID']; ?>" value="<?php echo ''.$row6['SN']; ?>">
					</td>
<?php					
					
				}
?>					
					<td>
					<select name="probdesc">
<?php
					$query10 = "SELECT ID,Problem FROM tblrmaproblem WHERE RMA = 1";
					$result10 = mysql_query($query10) or die (mysql_error());
					while($row10 = mysql_fetch_array($result10))
					{
?>
						<option value="<?php echo $row10['ID']; ?>" <?php if($row10['ID'] == $probid){ echo 'selected="selected"'; } ?>>  <?php echo $row10['Problem']; ?> </option>
<?php
					}
?>				
					</select>
					</td>	
<?php
				if($department == 2)
				{
?>							
					<td>
					<select name="status">
<?php
					$status = $row6['Status'];
					$query16 = "SELECT ID,Status FROM tblstatus WHERE SN = 1";
					$result16 = mysql_query($query16) or die (mysql_error());
					while($row16 = mysql_fetch_array($result16))
					{
?>
						<option value="<?php echo $row16['ID']; ?>" <?php if($row16['ID'] == $status){ echo 'selected="selected"'; } ?>>  <?php echo $row16['Status']; ?> </option>
<?php
					}
?>				
					</select>
					</td>	
					<td>
					<select name="warranty">
						<option value="1"<?php if($row6['Warranty'] == 1){ echo 'selected="selected"'; } ?>>NO</option>
						<option value="2"<?php if($row6['Warranty'] == 2){ echo 'selected="selected"'; } ?>>YES</option>
						<option value="3"<?php if($row6['Warranty'] == 3){ echo 'selected="selected"'; } ?>>NO (Battery Only)</option>
					</select>
					</td>					
<?php
				}else
				{
?>
					<td width="130">
<?php											
						$status = $row6['Status'];
						$query16 = "SELECT ID,Status FROM tblstatus WHERE ID = '$status'";
						$result16 = mysql_query($query16) or die (mysql_error());
						$row16 = mysql_fetch_array($result16);
						if($status <> 0)
						{
							echo $row16['Status'];
						}else
						{
							echo 'Not Confirmed';
						}
?>
					</td>	
					<td>
<?php
					if($row6['Warranty'] == 1)
					{
						echo 'NO';
					}
					if($row6['Warranty'] == 2)
					{
 						echo 'YES';
 					}
 					if($row6['Warranty'] == 3)
 					{
 						echo 'No (Battery Only)';
 					}
?>
				</td>
<?php 												
				}
				if($_GET['verified'] <> 'Add')
				{
?>											
					<td>
						<input type="submit" value="Set" name="update">
					</td>
					<td>
						<input type="submit" value="Remove" name="update">
					</td>					
<?php
				}
?>									
				</tr>
			</form>
<?php		
		}
?>		
		<tr>
			<td class="heading">
				Notes / Remarks
			</td>
		</tr>
<?php		
mysql_select_db('testwork');
		$query24 = "SELECT remarks,dateadded,addedby FROM tbltaskremarks WHERE taskid = '$taskid'";
		$result24 = mysql_query($query24) or die (mysql_error());
		while($row24 = mysql_fetch_array($result24))
		{
			$added = $row24['addedby'];
			mysql_select_db('testhomefree');
			$query25 = "SELECT f_name, l_name FROM employees WHERE id = '$added'";
			$result25 = mysql_query($query25) or die (mysql_error());
			$row25 = mysql_fetch_array($result25);				
?>
			<tr>
				<td colspan="6" class="body2">
					<?php echo nl2br($row24['remarks']);?>
				</td>
			</tr>
			<tr>
				<td colspan="6" class="heading">
					By: <?php echo $row25['f_name'].' '.$row25['l_name'].' @ '.$row24['dateadded'];?>
				</td>
			</tr>
<?php	
		}					
		if($_GET['verified'] == 'remark')
		{
?>
		<form method="GET" NAME="remark" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php			
			echo	'<input type = "hidden" name="taskid" value = "'.$taskid.'">';			
?>			
			<tr>
				<td>
					Add Comments
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<textarea rows="6" cols="60" name="remarks"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Add" name="remark">
				</td>
			</tr>
		</form>
<?php
		}else
		{		
			if($_GET['verified'] <> 'Add')
			{
?>			
				<tr>
					<td colspan="6">
						<button onClick="window.location='rma.php?verified=remark&taskid=<?php echo $taskid; ?>'">Add Notes / Comments</button>
					</td>
				</tr>
<?php
			}
		}
?>					
	</table>
<?php		
		echo	'<input type = "hidden" name="taskid" value = "'.$taskid.'">';
?>		
		<form method="GET" NAME="update" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
			echo	'<input type = "hidden" name="taskid" value = "'.$taskid.'">';
			if(($_GET['verified'] <> 'Add') && ($_GET['verified'] <> 'remark'))
			{	
?>	
							
				<table class="gray" width="750">
					<tr>
						<td width="125">
							<input type="submit" value="Add" name="verified">
						</td>																
						<td>
							<input type="submit" value="Continue" name="verified">
						</td>							
					</tr>
				</table>
<?php
			}
			if($_GET['verified'] == 'Add')
			{				
?>			
				<table>
					<tr>
						<td class="heading">
							Serial Number:
						</td>
						<td>
							<input type="text" size="10" maxlength="10" name="addedsn" value="">
						</td>		
						<td>
						<select name="probdescadd">
<?php
						mysql_select_db('testwork');
						$query10 = "SELECT ID,Problem FROM tblrmaproblem WHERE RMA = 1";
						$result10 = mysql_query($query10) or die (mysql_error());
						while($row10 = mysql_fetch_array($result10))
						{
?>
							<option value="<?php echo $row10['ID']; ?>"><?php echo $row10['Problem']; ?></option>
<?php
						}
?>				
						</select>
						</td>				
						<td>
							<input type="submit" value="Add" name="addsn">
						</td>		
						<td>
							<?php echo '<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'">'; ?>
						</td>												
					</tr>						
				</table>
<?php		
				}
?>
		</form>
<?php			
	}
	if((isset($_GET['verified'])) && ($_GET['verified'] == 'Create_RMA'))
	{
		if(!isset($_GET['comp']))
		{
?>	
			<form method="GET" NAME="update" action="<?php echo $_SERVER['PHP_SELF'];?>">		
<?php
			echo	'<input type = "hidden" name="taskid" value = "'.$taskid.'">';
?>		
				<table>
					<tr>
						<td class="heading">
							Attention:
						</td>
						<td>
							<input type="text" size="40" maxlength="40" name="attn" value="<?php echo $row8['Attention']; ?>">
						</td>	
						<td>
							<input type="submit" value="Save" name="contact">
						</td>
					</tr>
				</table>	
			</form>		
<?php				
		}
		if(isset($_GET['comp']))
		{	
			mysql_select_db('testwork');
			if($row8['Status'] == 11)
			{
				$on_rma_check = 1;
			}else
			{
				$on_rma_check = 0;
			}
			$query28 = "UPDATE taskinfo SET Status = 3 WHERE ID = '$taskid'";
			mysql_query($query28) or die(mysql_error());					
?>		
			<table>
				<tr>
					<td class="heading">
						Attention: 
					</td>
					<td>
						<?php echo $row8['Attention']; ?>
					</td>
				</tr>
				<tr>
					<td class="heading">
						Shipping Method:
					</td>
					<td>
						<?php echo $row31['Priority']; ?>
					</td>
				</tr>
			</table>
			<table border="1">
				<tr>
					<td class="heading">
						Items to be Returned
					</td>
					<td class="heading">
						Serial Number
					</td>					
					<td class="heading">
						Problem Description
					</td>	
					<td class="heading">
						Warranty
					</td>					
				</tr>					
<?php
				$query32 = "SELECT * FROM tblrmaserialinfo WHERE TaskID = '$taskid' AND Status = 11";
				$result32 = mysql_query($query32) or die (mysql_error());		
				if($on_rma_check == 1)
				{
					$query26 = "UPDATE tblrmaserialinfo SET isRMA = 1, Status = 12 WHERE TaskID = '$taskid' AND Status = 11";
					mysql_query($query26) or die(mysql_error());
				}else
				{
					$query26 = "UPDATE tblrmaserialinfo SET isRMA = 1, Status = 12 WHERE SN = '$serial'";
					mysql_query($query26) or die(mysql_error());
				}						
				while($row32 = mysql_fetch_array($result32))
				{
					mysql_select_db('testwork');
					$serial = $row32['SN'];
?>
					<tr>
						<td>
							<?php echo $row32['PartNumber']; ?>
						</td>
						<td>
							<?php echo $row32['SN']; ?>
						</td>
						<td>
<?php 
							$prob = $row32['Problem'];
							mysql_select_db('testwork');
							$query20 = "SELECT Problem FROM tblrmaproblem WHERE ID = '$prob'";
							$result20 = mysql_query($query20) or die (mysql_error());
							$row20 = mysql_fetch_array($result20);
							echo $row20['Problem'];
?>
						</td>
						<td>
<?php 			
						if(($row32['Warranty'] == 1) OR ($row32['Warranty'] == 3))
						{	 
							$warr = 'NO';
						}
						if($row32['Warranty'] == 2)
						{	 
							$warr = 'YES';
						}		
						echo $warr;		
?>
						</td>
					</tr>
<?php					
				}
?>												
			</table>			
			<table border="1">
				<tr>
					<td class="heading">
						Items to be Sent
					</td>
					<td class="heading">
						Description
					</td>					
					<td class="heading">
						Quantity
					</td>	
					<td class="heading">
						Remarks
					</td>					
				</tr>
<?php
				mysql_data_seek($result6, 0);

					$query21 = "SELECT COUNT(PartNumber) as pncount,PartNumber FROM tblrmaserialinfo WHERE TaskID = '$taskid' AND isRMA = 1 GROUP BY PartNumber";
					$result21 = mysql_query($query21) or die (mysql_error());
					while($row21 = mysql_fetch_array($result21))
					{
?>				
						<tr>
							<td>
								<?php echo $row21['PartNumber']; ?>
							</td>
							<td>
								<?php echo 'PW'; ?>
							</td>
							<td>
<?php 
								echo $row21['pncount']; 
?>
							</td>
							<td>
								
							</td>
						</tr>
<?php					
					}
?>
			</table>
			<table>
				<tr>
					<td>
						Authorized By: <?php echo $firstname.' '.$lastname; ?>
					</td>
					<td width="150">
					</td>
					<td>
						Date: <?php echo $displaydate1; ?>
					</td>
				</tr>
			</table>
			<table width="520" class="border">
				<tr>
					<td colspan="2">
						Terms and Conditions:
					</td>
				</tr>
				<tr>
					<td valign="top">
						1. 
					</td>
					<td valign="top">
						The Technical Support Department must be contacted before an RMA can be issued.
					</td>
				</tr>
				<tr>
					<td valign="top"><b>
						2.
					</b></td>
					<td valign="top"><b>
						YOU MUST INCLUDE A SIGNED COPY OF THIS RMA FORM WITH THE RETURN OF THE PRODUCT LISTED ABOVE OR YOU WILL NOT RECEIVE CREDIT FOR 
						THE RETURN.
					</b></td>					
				</tr>
				<tr>
					<td valign="top"><b>
						3. 
					</b></td>
					<td valign="top"><b>
						IF AN ADVANCED REPLACEMENT WAS ISSUED FOR A NON-WARRANTY, LOW BATTERY DEVICE, AND ADDITIONAL PROBLEMS ARE FOUND, ADDITIONAL 
						CHARGES WILL APPLY. 
					</b></td>					
				</tr>
				<tr>
					<td valign="top"><b>				
						4.
					</b></td>
					<td valign="top"><b>				
						DO NOT RETURN ANY PRODUCT NOT LISTED ABOVE. A CREDIT WILL NOT BE ISSUED FOR ANY ADDITIONAL PRODUCTS NOT LISTED OR 
						AUTHORIZED BY HOMEFREE.
					</b></td>					
				</tr>
				<tr>
					<td valign="top">
						5.
					</td>
					<td valign="top">
						All equipment must be properly packaged for shipment.
					</td>					
				</tr>
				<tr>
					<td valign="top">
						6.
					</td>
					<td valign="top">
						Out of Warranty equipment is subject to service and/or replacement charges.
					</td>					
				</tr>
				<tr>
					<td valign="top">
						7.
					</td>
					<td valign="top">
						Defective equipment must be returned within 30 days from the receipt of the 
						replacement equipment or the customer will be billed the full amount for the replacement equipment.
					</td>					
				</tr>
				<tr>
					<td valign="top">
						8.
					</td>
					<td valign="top">
						A 30-day warranty will be given with any advanced replacement/refurbished product purchased if the replaced product was 
						no longer under the manufacturers warranty.
					</td>					
				</tr>
				<tr>
					<td valign="top">
						9.
					</td>
					<td valign="top">
						Advanced replacement product may be refurbished product that will replace your product.
					</td>					
				</tr>
			</table>
			<table width="520">				
				<tr>
					<td colspan="3" class="note">
						**Call UPS for pick up the defective unit to HF and use the pre-paid UPS label that is attached to
					  the advance replacement shipment that you will get shortly from HF.
					</td>
				</tr>
				<tr>
					<td class="biggerheading">
						Please sign here:
					</td>
				</tr>
				<tr>
					<td>
						I agree to the above terms
					</td>
				</tr>
				<tr>
					<td>
						Customer Signature:________________________
					</td>
					<td width="10">
					</td>
					<td>
						Date:_______________
					</td>
				</tr>
			</table>
			<table align="center" width="520">
				<tr>
					<td><i>
						(Please send this form or a copy of it with defective equipment)				
					</i></td>
				</tr>
			</table>
<?php									
		}	
	}
}
?>