<?php
if((isset($_GET['view'])) && ($_GET['view']=='open_resolution'))
{
	include 'printheader.php';
}else
{
	include 'header.php';
}
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
$uid = $_SESSION['uid'];   
$conn11 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db($dbname);;
$email = $_SESSION['mail'];
$query10 = "SELECT id, f_name, l_name, dept FROM employees WHERE id = '$uid'";
$result10 = mysql_query($query10) or die (mysql_error());
$row10 = mysql_fetch_array($result10); 
$firstname = $row10['f_name'];
$lastname = $row10['l_name'];
$department = $row10['dept'];
mysql_close($conn11);	
$date = date('Y-m-d H:i:s');
	include '../includes/config.inc.php';
	include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
//*********************************************SAVE UDPATED THREAD**********************************//
if((isset($_GET['save_update'])) && ($_GET['save_update'] == 'Save'))
{
	mysql_select_db($dbname2);
	$threadid = $_GET['threadid'];
	$fix = $_GET['fix'];
	$replydate = $_GET['replydate'];
	$status = $_GET['status'];
	$query7 = "SELECT COUNT(ID) FROM tblopen_issue_remarks WHERE ThreadID = '$threadid'";
	$result7 = mysql_query($query7) or die (mysql_error());
	$row7 = mysql_fetch_array($result7);
	$z = $row7['COUNT(ID)'];
	if($z > 0)
	{
		$query11 = "SELECT MAX(ID) FROM tblopen_issue_remarks WHERE ThreadID = '$threadid'";
		$result11 = mysql_query($query11) or die (mysql_error());
		$row11 = mysql_fetch_array($result11);
		$y = $row11['MAX(ID)'];	
		$query4 = "UPDATE tblopen_issue_remarks SET Fix = ".(($fix == '') ? 'NULL' : "'$fix'").", Date_Eng_replied = ".(($replydate == '') ? 'NULL' : "'$replydate'").", Status = '$status' WHERE ID = '$y'";
		mysql_query($query4) or die(mysql_error());		
	}else
	{
		$rel_ticket = $_GET['relatedticket'];
		$query4 = "UPDATE tblopen_issues SET RelatedTicket = ".(($rel_ticket == '') ? 'NULL' : "'$rel_ticket'").", Fix = ".(($fix == '') ? 'NULL' : "'$fix'").", Date_Eng_replied = ".(($replydate == '') ? 'NULL' : "'$replydate'").", Status = '$status' WHERE ID = '$threadid'";
		mysql_query($query4) or die(mysql_error());
	}	
	header("Location: openissues.php?view=update&threadid=$threadid#$z");	
}
//*********************************************INSERTING NEW REMARK**********************************//
if((isset($_GET['add_step'])) && ($_GET['add_step'] == 'Add_Step'))
{
	mysql_select_db($dbname2);
	$threadid = $_GET['threadid'];
	$query6 = "SELECT Problem FROM tblopen_issues WHERE ID = '$threadid'";
	$result6 = mysql_query($query6) or die (mysql_error());
	$row6 = mysql_fetch_array($result6);
	$problem = $row6['Problem'];
	$query5 = "INSERT INTO tblopen_issue_remarks (ThreadID,Problem) VALUES ('$threadid','$problem')";
	mysql_query($query5) or die(mysql_error());
	$query7 = "SELECT COUNT(ID) FROM tblopen_issue_remarks WHERE ThreadID = '$threadid'";
	$result7 = mysql_query($query7) or die (mysql_error());
	$row7 = mysql_fetch_array($result7);
	$z = $row7['COUNT(ID)'];
	header("Location: openissues.php?view=update&action=add&threadid=$threadid#$z");
}
//*********************************************SAVING NEW REMARK DATA**********************************//
if((isset($_GET['save_added_remark'])) && ($_GET['save_added_remark'] == 'Save'))
{
	mysql_select_db($dbname2);
	$threadid = $_GET['threadid'];
	$query9 = "SELECT COUNT(ID) FROM tblopen_issue_remarks WHERE ThreadID = '$threadid'";
	$result9 = mysql_query($query9) or die (mysql_error());
	$row9 = mysql_fetch_array($result9);
	$z = $row9['COUNT(ID)'];	
	$query11 = "SELECT MAX(ID) FROM tblopen_issue_remarks WHERE ThreadID = '$threadid'";
	$result11 = mysql_query($query11) or die (mysql_error());
	$row11 = mysql_fetch_array($result11);
	$y = $row11['MAX(ID)'];	
	$problem = $_GET['problem'];
	$sentdate = $_GET['dateadded'];
	$files = $_GET['files'];
	$fix = $_GET['fix'];
	$replydate = $_GET['replydate'];
	$status = $_GET['status'];
	$query8 = "UPDATE tblopen_issue_remarks SET ThreadID = '$threadid', Fix = ".(($fix == '') ? 'NULL' : "'$fix'").", Problem = '$problem', Date_Sent = '$sentdate', 
						Files_Text_Sent = '$files', Date_Eng_replied = ".(($replydate == '') ? 'NULL' : "'$replydate'").", Status = '$status' WHERE ID = '$y'";
	mysql_query($query8) or die(mysql_error());
	header("Location: openissues.php?view=update&threadid=$threadid#$z");
}
//*********************************************CLOSE THREAD**********************************//
if((isset($_GET['update'])) && ($_GET['update'] == 'Close_Thread'))
{
	mysql_select_db($dbname2);
	$threadid = $_GET['threadid'];
	$query12 = "UPDATE tblopen_issues SET Complete = 1 WHERE ID = '$threadid'";
	mysql_query($query12) or die(mysql_error());
	header("Location: openissues.php?view=resolution&threadid=$threadid");
}
//*********************************************SAVE RESOLUTION**********************************//
if((isset($_POST['save_resolution'])) && ($_POST['save_resolution'] == 'Save'))
{
	mysql_select_db($dbname2);
	$threadid = $_POST['threadid'];
	$resolution = $_POST['resolution'];
	$query12 = "UPDATE tblopen_issues SET Resolution = '$resolution' WHERE ID = '$threadid'";
	mysql_query($query12) or die(mysql_error());
	header("Location: openissues.php?view=update&threadid=$threadid");	
}
//*********************************************SAVE ADDED FACILITY**********************************//
if((isset($_GET['save_add_facility'])) && ($_GET['save_add_facility']=='Save'))
{
	mysql_select_db($dbname2);
	$threadid = $_GET['threadid'];
	$add_cus = $_GET['custNum'];
	$date1 = date('Y-m-d');
	$ticketid = $_GET['ticketid'];
	$query12 = "INSERT INTO tblother_facilities (CustomerNumber,ThreadID,Date,TicketID) VALUES ('$add_cus','$threadid','$date1', ".(($ticketid == '') ? 'NULL' : "'$ticketid'").")";
	mysql_query($query12) or die(mysql_error());
	header("Location: openissues.php?view=update&threadid=$threadid");	
}
//*********************************************ADD THREAD**********************************//
if((isset($_GET['save_add_thread'])) && ($_GET['save_add_thread']=='Add'))
{
	mysql_select_db($dbname2);
	$add_cus = $_GET['custNum'];
	$problem = $_GET['problem'];
	$date_added = $_GET['date_add'];
	$ticketid = $_GET['relticket'];
	$fix = $_GET['fix'];
	$files = $_GET['files'];
	$status = $_GET['status'];
	$replydate = $_GET['date_repied'];
	$query12 = "INSERT INTO tblopen_issues (CustomerNumber,Problem,Date_Sent,RelatedTicket,Files_Text_Sent,Date_Eng_replied,Fix,Status) VALUES 
						('$add_cus','$problem','$date_added', ".(($ticketid == '') ? 'NULL' : "'$ticketid'").",'$files',".(($replydate == '') ? 'NULL' : "'$replydate'").",
						'$fix','$status')";
	mysql_query($query12) or die(mysql_error());
	header("Location: openissues.php");	
}
?>
<link rel="stylesheet" type="text/css" href="../csPortal_Layout.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HF Open AMS issues</title>
<SCRIPT LANGUAGE="JavaScript">
<!--
function showList() {
  sList = window.open("../task/lookup.php?fr=openissue","mywindow","width=450","height=350","scrollbars=1");
}
function seeResolution() {
  sList = window.open("../task/openissues.php?view=open_resolution","mywindow","width=450","height=350","scrollbars=1");
}

function remLink() {
  if (window.sList && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>
<?php
if(!((isset($_GET['view'])) && ($_GET['view']=='open_resolution')))
{
?>	
<table>
	<tr>
		<td class="SectionNav2" align="center" width="148" height="25" background="../images/subnav-bg.gif">
			<a href="openissues.php?view=add"> Add A New Thread </a>
		</font></a></td>	
		<td class="SectionNav2" align="center" width="148" height="25" background="../images/subnav-bg.gif">
			<a href="openissues.php?view=search"> Search Existing Threads </a>
		</font></a></td>	
	</tr>
</table>
<?php
}
if(!isset($_GET['view']))
{
	mysql_select_db($dbname2);
	$query = "SELECT * FROM tblopen_issues WHERE Complete = 0 ORDER BY Date_Sent";
	$result = mysql_query($query) or die (mysql_error());
?>
	<table cellpadding=0 border="0" style="table-layout:fixed">
<?php
	while($row = mysql_fetch_array($result))
	{
?>
		<tr>
			<td class="SectionNav">
				<table>
					<tr>
						<td width="80" class="SectionNav">
							Facility
						</td>
						<td width="200" class="SectionNav">
							Problem
						</td>
						<td width="80" class="SectionNav">
							Date Sent
						</td>
						<td width="100" class="SectionNav">
							Desc / Files Sent
						</td>
						<td width="80" class="SectionNav">
							Reply Date
						</td>
						<td width="80" class="SectionNav">
							Proposed Fix
						</td>
						<td width="80" class="SectionNav">
							Status
						</td>
					</tr>	
<?php				
					$ID = $row['ID'];
					$CustomerNumber = $row['CustomerNumber'];
					mysql_select_db($dbname);;
					$query2 = "SELECT FacilityName From tblfacilities WHERE CustomerNumber = '$CustomerNumber'";
					$result2 = mysql_query($query2) or die (mysql_error());
					$row2 = mysql_fetch_array($result2); 
					$f_name = $row2['FacilityName'];
					$problem = $row['Problem'];
					$date_sent = $row['Date_Sent'];
					$Files_Text_Sent = $row['Files_Text_Sent'];
					if(is_null($Files_Text_Sent))
					{
						$Files_Text_Sent = 'none';
					}else
					{
						$Files_Text_Sent = $row['Files_Text_Sent'];
					}
					$Date_Eng_replied = $row['Date_Eng_replied'];
					if(is_null($Date_Eng_replied))
					{
						$Date_Eng_replied = 'no reply';
					}else
					{
						$Date_Eng_replied = $row['Date_Eng_replied'];
					}
					$Fix = $row['Fix'];
					if(is_null($Fix))
					{
						$Fix = 'none given';
					}else
					{
						$Fix = $row['Fix'];
					}
					$Status = $row['Status'];
					// BUILD DISPLAY FOR EACH OPEN ISSUE//	
					$display = '<tr><td width="80" valign="top"><a href="openissues.php?view=update&threadid='.$ID.'">'.$f_name.'</td>';
					$display .= '<td width="200" valign="top">'.$problem.'</td>';
					$display .= '<td width="80" valign="top">'.$date_sent.'</td>';
					$display .= '<td width="100" valign="top">'.$Files_Text_Sent.'</td>';
					$display .= '<td width="80" valign="top">'.$Date_Eng_replied.'</td>';
					$display .= '<td width="80" valign="top">'.$Fix.'</td>';
					$display .= '<td width="80" valign="top">'.$Status.'</td></tr>';
					// DISPLAY THE OPEN ISSUE //
					echo $display;
					// GET ADDED REMARKS FROM ISSUE
					mysql_select_db($dbname2);;
					$query1 = "SELECT * FROM tblopen_issue_remarks WHERE ThreadID = '$ID'";
					$result1 = mysql_query($query1) or die (mysql_error());
					while($row1 = mysql_fetch_array($result1))
					{
						$id = $row1['ID'];
						$threadid = $row1['ThreadID'];
						$problem = $row1['Problem'];
						$date_sent = $row1['Date_Sent'];
						$Files_Text_Sent = $row1['Files_Text_Sent'];
						if(is_null($Files_Text_Sent))
						{
							$Files_Text_Sent = 'none';
						}else
						{
							$Files_Text_Sent = $row1['Files_Text_Sent'];
						}
						$Date_Eng_replied = $row1['Date_Eng_replied'];
						if(is_null($Date_Eng_replied))
						{
							$Date_Eng_replied = 'no reply';
						}else
						{
							$Date_Eng_replied = $row1['Date_Eng_replied'];
						}
						$Fix = $row1['Fix'];
						if(is_null($Fix))
						{
							$Fix = 'none given';
						}else
						{
							$Fix = $row1['Fix'];
						}
						$Status = $row1['Status'];	
						// BUILD DISPLAY FOR EACH OPEN ISSUE REMARK//	
						$display1 = '<tr><td colspan="7"><div align="center"><hr width="80%"></div></td></tr>';
						$display1 .= '<tr><td width="80" valign="top"></td>';
						$display1 .= '<td width="200"  valign="top">'.$problem.'</td>';
						$display1 .= '<td width="80" valign="top">'.$date_sent.'</td>';
						$display1 .= '<td width="100" valign="top">'.$Files_Text_Sent.'</td>';
						$display1 .= '<td width="80" valign="top">'.$Date_Eng_replied.'</td>';
						$display1 .= '<td width="80" valign="top">'.$Fix.'</td>';
						$display1 .= '<td width="80" valign="top">'.$Status.'</td></tr>';
						echo $display1;
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
if((isset($_GET['view'])) && ($_GET['view'] == 'update'))
{
	$threadid = $_GET['threadid'];
	mysql_select_db($dbname2);;
	$query3 = "SELECT * FROM tblopen_issues WHERE ID = '$threadid'";
	$result3 = mysql_query($query3) or die (mysql_error());
	$row3 = mysql_fetch_array($result3);
	$query4 = "SELECT * FROM tblopen_issue_remarks WHERE ThreadID = '$threadid'";
	$result4 = mysql_query($query4) or die (mysql_error());
	$count4 = mysql_num_rows($result4);
	$query13 = "SELECT * FROM tblother_facilities WHERE ThreadID = '$threadid'";
	$result13 = mysql_query($query13) or die (mysql_error());	
	mysql_select_db($dbname);;
	$custNum = $row3['CustomerNumber'];
	$query2 = "SELECT FacilityName From tblfacilities WHERE CustomerNumber = '$custNum'";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2); 
	$f_name = $row2['FacilityName'];	
?>
	<form method="GET" NAME="Open_Issue" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td width="500" class="SectionNav">
					<table>
<?php					
					if($row3['Complete'] == 1)
					{
?>
				
						<tr>
							<td>
								<b>Resolution - Thread Closed</b>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo $row3['Resolution']; ?>
							</td>
						</tr>
<?php				
					}else
					{
						echo '<tr><td><b>Thread Open</b></td></tr>';
					}
?>					
					</table>
				</td>
				<td width="250">
					<table>
						<tr>
							<td>
								<b>Other Facilities w/ same Problem</b>
							</td>
						</tr>
					</table>
				</td>
			</tr>	
		</table>
		<table>
			<tr>
				<td width="500">
					<table width="500">
						<tr>
							<td width="95">
								Thread ID:
							</td>
							<td>
								<?php echo $threadid; ?>
							</td>
						</tr>
						<tr>
							<td>
								Facility:
							</td>
							<td>
								<?php echo $f_name; ?>
							</td>
						</tr>
						<tr>
							<td>
								Related Ticket:
							</td>
							<td>
<?php 	
							if($count4 > 0)
							{
								echo $row3['RelatedTicket'];
							}else
							{
?>
								<input type="text" SIZE="6" name="relatedticket" maxlength="6" value="<?php echo $row3['RelatedTicket'];?>"><?php echo '<a href="' . '../csPortal_Tickets.php?ticket_num='.$row3['RelatedTicket'].'&by_ticket=ticket">'.'View Ticket'.'</a>'; ?>
<?php				
							}				
?>				
							</td>
						</tr>						
						<tr>
							<td>
								Date Opened:
							</td>
							<td>
								<?php echo $row3['Date_Sent']; ?>
							</td>
						</tr>
						<tr>
							<td>
								Problem:
							</td>
							<td>
								<?php echo $row3['Problem']; ?>
							</td>
						</tr>	
						<tr>
							<td>
								Files / Info Sent:
							</td>
							<td>
								<?php echo $row3['Files_Text_Sent']; ?>
							</td>
						</tr>	
						<tr>
							<td>
								Proposed Fix:
							</td>
							<td>
<?php 	
							if($count4 > 0)
							{
								echo $row3['Fix']; 
							}else
							{
?>
								<input type="text" SIZE="40" name="fix" maxlength="255" value="<?php echo $row3['Fix'];?>">
<?php				
							}				
?>
							</td>
						</tr>			
						<tr>
							<td>
								Date of Reply:
							</td>
							<td>
<?php 	
							if($count4 > 0)
							{
								echo $row3['Date_Eng_replied'];
							}else
							{
?>
								<input type="text" SIZE="12" name="replydate" maxlength="10" value="<?php echo $row3['Date_Eng_replied'];?>">format: YYYY-mm-dd
<?php				
							}				
?>				
							</td>
						</tr>	
						<tr>
							<td>
								Status / Action:
							</td>
							<td>
<?php 	
							if($count4 > 0)
							{
								echo $row3['Status'];
							}else
							{
?>
								<input type="text" name="status" SIZE="40" maxlength="255" value="<?php echo $row3['Status'];?>">
<?php				
							}	
							echo	'<input type = "hidden" name="threadid" value = "'.$threadid.'">';
							echo	'<input type = "hidden" name="view" value = "update">';		
?>					
							</td>
						</tr>	
						<tr>
<?php 	
							if($count4 < 1)
							{
?>
								<td>				
									<input type="submit" value="Save" name="save_update">			
								</td>
								<td>	
									<input type="submit" value="Add_Step" name="add_step">
								</td>
<?php				
							}	
?>					
						</tr>			
					</table>
				</form>
<?php	
				$a = 0;
				while($row4 = mysql_fetch_array($result4))
				{
					$a=$a+1;
?>		
					<form method="GET" NAME="Open_Issue_Remark" action="<?php echo $_SERVER['PHP_SELF'];?>">
						<table>
							<tr>
								<td><a name="<?php echo $a; ?>">
									<b>Step <?php echo $a; ?></b>
								</td>
							</tr>
							<tr>
								<td>
									Date Added:
								</td>
								<td>
<?php 	
								if(((isset($_GET['action'])) && ($_GET['action'] == 'add')) && ($count4 == $a))
								{
?>
									<input type="text" SIZE="12" name="dateadded" maxlength="10">
<?php							 
								}else
								{										
									echo $row4['Date_Sent'];		
								}				
?>						
								</td>
							</tr>
							<tr>
								<td>
									Problem:
								</td>
								<td>
<?php 	
								if(((isset($_GET['action'])) && ($_GET['action'] == 'add')) && ($count4 == $a))
								{
?>
									<input type="text" SIZE="40" maxlength="255" name="problem" value="<?php echo $row4['Problem']; ?>">
<?php							 
								}else
								{										
									echo $row4['Problem'];	
								}				
?>				
								</td>
							</tr>	
							<tr>
								<td>
									Files / Info Sent:
								</td>
								<td>
<?php 	
								if(((isset($_GET['action'])) && ($_GET['action'] == 'add')) && ($count4 == $a))
								{
?>
									<input type="text" SIZE="40" maxlength="255" name="files" value="">
<?php							 
								}else
								{										
									echo $row4['Files_Text_Sent'];	
								}				
?>							
								</td>
							</tr>	
							<tr>
								<td>
									Proposed Fix:
								</td>
								<td>
<?php 	
								if(($count4 == $a) && ($row3['Complete'] == 0))
								{
?>
									<input type="text" SIZE="40" name="fix" maxlength="255" value="<?php echo $row3['Fix'];?>">
<?php							 
								}else
								{										
									echo $row4['Fix'];			
								}				
?>
								</td>
							</tr>			
							<tr>
								<td>
									Date of Reply:
								</td>
								<td>
<?php 	
								if(($count4 == $a) && ($row3['Complete'] == 0))
								{
?>
									<input type="text" SIZE="12" name="replydate" maxlength="10" value="<?php echo $row4['Date_Eng_replied'];?>">format: YYYY-mm-dd
<?php											
								}else
								{
									echo $row4['Date_Eng_replied'];
								}				
?>				
								</td>
							</tr>	
							<tr>
								<td>
									Status / Action:
								</td>
								<td>
<?php 				
								if(($count4 == $a) && ($row3['Complete'] == 0))
								{
?>
									<input type="text" name="status" SIZE="40" maxlength="255" value="<?php echo $row4['Status'];?>">
<?php						
								}else
								{
									echo $row4['Status'];
								}	
								echo	'<input type = "hidden" name="threadid" value = "'.$threadid.'">';
								echo	'<input type = "hidden" name="view" value = "update">';		
?>					
								</td>
							</tr>
						</table>
						<table>	
							<tr>
<?php
							if($row3['Complete'] == 0)
							{
								if($count4 == $a)
								{
									if(!isset($_GET['action']))
									{									
?>
										<td align="center" width="100">				
											<input type="submit" value="Save" name="save_update">			
										</td>						
										<td align="center" width="100">	
											<input type="submit" value="Add_Step" name="add_step">
										</td>
										<td align="center" width="100">	
											<input type="submit" value="Close_Thread" name="update">
										</td>							
<?php				
									}else
									{
?>
										<td>				
											<input type="submit" value="Save" name="save_added_remark">			
										</td>
<?php		
									}					
								}	
							}
?>					
							</tr>			
						</table>
					</form>		
<?php		
				}
?>
				</td>
				<td valign="top">
					<table>
						<tr>
							<td colspan="3">
								<a href="openissues.php?view=addfacility&threadid=<?php echo $threadid; ?>">Add Facility
							</td>
						</tr>						
<?php
					while($row13 = mysql_fetch_array($result13))
					{
						mysql_select_db($dbname);;
						$custnum = $row13['CustomerNumber'];
						$query14 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custnum'";
						$result14 = mysql_query($query14) or die (mysql_error());
						$row14 = mysql_fetch_array($result14);
						$facilityname = $row14['FacilityName'];
?>
						<tr>
							<td>
								<?php echo $facilityname; ?>
							</td>
							<td>
								<?php echo $row13['Date']; ?>
							</td>
							<td>
								<?php echo '<a href="' . '../csPortal_Tickets.php?ticket_num='.$row13['TicketID'].'&by_ticket=ticket">'.  $row13['TicketID'] . '</a>'; ?>
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
if((isset($_GET['view'])) && ($_GET['view'] == 'resolution'))
{
	$threadid = $_GET['threadid'];
?>
	<form method="POST" NAME="Resolution" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
	echo	'<input type = "hidden" name="threadid" value = "'.$threadid.'">';
?>		
		<table>
			<tr>
				<td>
					Please explain the resolution
				</td>
			</tr>
			<tr>
				<td>
					<textarea rows="12" cols="80" name="resolution"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Save" name="save_resolution">			
				</td>
			</tr>
		</table>
	</form>
<?php
}
if((isset($_GET['view'])) && ($_GET['view'] == 'addfacility'))
{
	$threadid = $_GET['threadid'];
?>
	<form name="searchParams" id="searchParams" onSubmit="javascript:get(document.getElementById('searchParams'));">
		<table>
			<tr>
				<td align="left">
					<INPUT TYPE="text" NAME="custNum" id="custNum" VALUE="<?php if(isset($_GET['custNum'])){ echo $customer; }?>" SIZE="6" maxlength="6" /> Customer Number
					<INPUT TYPE="button" VALUE="Find" onClick="showList()">	
				</td>
			</tr>
			<tr>
				<td>
					<INPUT TYPE="text" name="ticketid" VALUE="" maxlength="6" SIZE="6"> Ticket Number <i>(if necessary)</i>
				</td>
			</tr>			
			<tr>
				<td>
					<INPUT TYPE="submit" VALUE="Save" name="save_add_facility">
				</td>
			</tr>	
		</table>
<?php
		echo	'<input type = "hidden" name="threadid" value = "'.$threadid.'">';
?>		
	</form>					
<?php	
}
if((isset($_GET['view'])) && ($_GET['view']=='add'))
{
?>
	<form name="searchParams" id="searchParams" onSubmit="javascript:get(document.getElementById('searchParams'));">
		<table>
			<tr>
				<td>
					Customer 
				</td>
				<td>
					<INPUT TYPE="text" NAME="custNum" id="custNum" VALUE="<?php if(isset($_GET['custNum'])){ echo $customer; }?>" SIZE="6" maxlength="6" />
					<INPUT TYPE="button" VALUE="Find" onClick="showList()">	
				</td>
			</tr>
			<tr>
				<td>
					Problem
				</td>
				<td>
					<INPUT TYPE="text" name="problem" VALUE="" maxlength="255" SIZE="60">
				</td>
			</tr>
			<tr>
				<td>
					Date Escalated
				</td>
				<td>
					<INPUT TYPE="text" name="date_add" VALUE="" maxlength="10" SIZE="12">
				</td>
			</tr>
			<tr>
				<td>
					Related Ticket
				</td>
				<td>
					<INPUT TYPE="text" name="relticket" VALUE="" maxlength="6" SIZE="6">
				</td>
			</tr>
			<tr>
				<td>
					Files / Info Sent
				</td>
				<td>
					<INPUT TYPE="text" name="files" VALUE="" maxlength="255" SIZE="60">
				</td>
			</tr>			
			<tr>
				<td>
					Proposed Fix
				</td>
				<td>
					<INPUT TYPE="text" name="fix" VALUE="" maxlength="255" SIZE="60">
				</td>
			</tr>			
			<tr>
				<td>
					Status
				</td>
				<td>
					<INPUT TYPE="text" name="status" VALUE="" maxlength="255" SIZE="60">
				</td>
			</tr>	
			<tr>
				<td>
					Reply Date
				</td>
				<td>
					<INPUT TYPE="text" name="date_repied" VALUE="" maxlength="10" SIZE="12">
				</td>
			</tr>
			<tr>
				<td>
					<INPUT TYPE="submit" VALUE="Add" name="save_add_thread">
				</td>
			</tr>		
		</table>
	</form>			
<?php			
}
if((isset($_GET['view'])) && ($_GET['view']=='search'))
{
//*********************************************SEARCH THREAD**********************************//
	if((isset($_GET['search_thread'])) && ($_GET['search_thread']=='Search'))
	{
		$customer = $_GET['custNum'];
		$stat = $_GET['complete'];
		$threadid = $_GET['thread'];
		mysql_select_db($dbname2);;		
		$query13 = "SELECT * FROM tblopen_issues ";	
		foreach($_GET as $val){
		  if($val != '' OR  $val = "search_thread"){
		    $query13 .= "WHERE ";
		    break;
		  }
		}
		if($customer != ''){
		  $where [ ] = "CustomerNumber = '$customer'";
		}
		if($stat != -1){
		  $where [ ] = "Complete = '$stat'";
		}else
		{
			$where [ ] = "Complete < 100";
		}
		if($threadid != ''){
		  $where [ ] = "ID = '$threadid'";
		}		
		if(!empty($where)){
		  $query13 .= implode(" AND ", $where);
		}
		$result13 = mysql_query($query13) or die(mysql_error());	
		$count13 = mysql_num_rows($result13);			
	}	
?>
	<form name="searchParams" id="searchParams" onSubmit="javascript:get(document.getElementById('searchParams'));">
		<table>
<?php
		echo	'<input type = "hidden" name="view" value = "search">';
?>		
			<tr>
				<td>
					Customer Number:
				</td>
				<td>
					<INPUT TYPE="text" NAME="custNum" id="custNum" VALUE="<?php if(isset($_GET['custNum'])){ echo $customer; }?>" SIZE="6" maxlength="6" />
					<INPUT TYPE="button" VALUE="Find" onClick="showList()">	
				</td>
			</tr>
			<tr>
				<td>
					Thread ID
				</td>
				<td>
					<INPUT TYPE="text" name="thread" VALUE="<?php if(isset($_GET['thread'])){ echo $threadid; }?>" maxlength="6" SIZE="6">
				</td>
			</tr>		
			<tr>
				<td>
					Status
				</td>
				<td>
					<select name="complete">
					<option value="-1">Any</option>
					<option value="0">Open</option>
					<option value="1">Closed</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<INPUT TYPE="submit" VALUE="Search" name="search_thread">
				</td>
			</tr>
		</table>
	</form>
<?php
	if((isset($_GET['search_thread'])) && ($_GET['search_thread']=='Search'))
	{
		if($count13 > 0)
		{
			while($row13 = mysql_fetch_array($result13))
			{
				$custnum = $row13['CustomerNumber'];
				$id = $row13['ID'];
				$problem = $row13['Problem'];
				$complete = $row13['Complete'];
				$dateadded = $row13['Date_Sent'];
				$resolution = $row13['Resolution'];
				mysql_select_db($dbname);;
				$query14 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custnum'";
				$result14 = mysql_query($query14) or die (mysql_error());
				$row14 = mysql_fetch_array($result14);
				$facilityname = $row14['FacilityName'];
?>
<style type="text/css">
table.ex2
{
	table-layout:fixed;
	border-style:inset;
	border-width:1px;
	border-color:gray;
}
</style>
				<form method="GET" NAME="Open_Issue_SEARCH" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<table width="750" class="ex2">
						<tr>
							<td width="10">
								<a href="openissues.php?view=update&threadid=<?php echo $id;?>"><?php echo $id; ?></a>
							</td>
							<td width="100">
								<?php echo $facilityname; ?>
							</td>
							<td width="450">
								<?php echo $problem; ?>
							</td>
							<td width="40">
<?php 
							if($complete == 0)
							{
								$c_stat = 'Open<td width="140"></td>';
							}elseif($complete == 1)
							{
								$c_stat = 'Closed';
							}
								echo $c_stat;
?>							
							</td>
<?php
							if($complete == 1)
							{	
?>												
								<td width="140">
									<INPUT type="button" value="View Resolution" onclick="window.open('../task/openissues.php?threadid=<?php echo $id; ?>&view=open_resolution','mywindow','width=450','height=350','scrollbars=yes')">
								</td>
<?php
							}
?>
						</tr>
					</table>
				</form>
<?php				
			}
		}
	}
}
if((isset($_GET['view'])) && ($_GET['view']=='open_resolution'))
{
	mysql_select_db($dbname2);
	$threadid = $_GET['threadid'];
	$query15 = "SELECT Resolution FROM tblopen_issues WHERE ID = '$threadid'";
	$result15 = mysql_query($query15) or die (mysql_error());
	$row15 = mysql_fetch_array($result15);
?>
	<table width="400">
		<tr>
			<td>
<?php	
				echo $row15['Resolution'];
?>
			</td>
		</tr>
	</table>
<?php					
}