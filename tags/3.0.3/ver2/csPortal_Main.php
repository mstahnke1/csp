<?php
$message="";

//$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
//$url = urlencode(!empty($query) ? " $host$self?$query" : " $host$self");
$url = urlencode(!empty($query) ? " $self?$query" : " $self");

//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
include 'includes/functions.inc.php';

if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	die(header("Location: csPortal_Login.php?url=" . $url));
}
else
{
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";

	$email = $_SESSION['mail'];
	$query8 = "SELECT id, f_name, l_name, dept, recFloorplan, recRmaEmail, manageRma, warr_prog FROM employees WHERE email = '$email'";
  $result8 = mysql_query($query8) or die (mysql_error());
  $row8 = mysql_fetch_array($result8);
	$employeeid = $row8['id'];
	$employeeDept = $row8['dept'];
	$warr_progPerm = $row8['warr_prog'];
	$user = $row8['l_name'].', '.$row8['f_name'];
	if($warr_progPerm > 0)
	{
		$curDate = date('Y-m-d');
		$notifyDate = date('Y-m-d', strtotime("+".$notificationPeriod, strtotime($curDate)));
		$query9 = "SELECT * FROM warrantyinfo WHERE EndDate < '$notifyDate' && Package != '0'";
		$result9 = mysql_query($query9) or die(mysql_error());
		$num9 = mysql_num_rows($result9);
	}
}

$query = "SELECT * FROM bulletins WHERE msg_type = 0 && msg_active = 0 ORDER BY msg_date DESC";
$result = mysql_query($query) or die(mysql_error());

$query2 = "SELECT * FROM bulletins WHERE msg_type = 1 && msg_active = 0 ORDER BY msg_date DESC";
$result2 = mysql_query($query2) or die(mysql_error());

$postal_code = 53218;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Main</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="csPortal_Layout.css" />
</head>

<body>
<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" align="left">
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;" width="330">
					<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center" style="padding:0 0 6px 0; height:32px;">
									<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
										<tr>
											<?php
											echo '<td valign="bottom"><font size="2" face="Arial"><strong>' . $message . '</strong>&nbsp;<a href="csPortal_Login.php?action=logout">[' . $portalMsg[9][$lang] . ']</a></td>';
											?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="bottom">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
						  		<td><a href="csPortal_Main.php"><img src="images/Home_ButtonActive.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonActive.gif'";" height="36" alt="Click to go to Netcom homepage."></a></td>
						  		<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'";" height="36" alt="Click to go to Sales homepage."></a></td>
						  		<td><a href="csPortal_Support.php"><img src="images/Support_ButtonOff.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonOff.gif'";" height="36" alt="Click for customer support options."></a></td>								
						  		<?php
						  		if($_SESSION['access']>=7) {
									echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonOff.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonOff.gif'\";\" height=\"36\" alt=\"Netcom's company administration portal.\"></a></td>";
									}
									?>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<td><img src="images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
					<td width="100%" style="background-image: url(images/subnav-bg.gif);">

		<!-- sub nav -->
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center">
									<table cellspacing="0" cellpadding="0" border="0" style="height:20px;">
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="0" id="tablist2">
													<tr>
														<td style="color:#3b3d3d;font-size:10px;font-family: verdana;font-weight:bold;"><b>&nbsp;</b></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="http://my.calendars.net/homefreesystems/" target="blank" style="font-size:10px;font-family: verdana;">CALENDAR</a></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table align="center" width="759" border="0" bgcolor="#FFFFFF">
	<?php
  /************************** COLUMN LEFT START *************************/
  ?>
	<tr valign="top">
		<td width="550">
			<?php
  		/********************* FOLLOW-UP DISPLAY MODULE ****************************/
			$query4 = "SELECT tblTickets.ID AS ID, tblTickets.DateFollowUp AS DateScheduled, tblFacilities.FacilityName AS FacName FROM tbltickets JOIN tblFacilities ON tblTickets.CustomerNumber = tblFacilities.CustomerNumber WHERE tblTickets.FollowUp != 0 AND tblTickets.UidFollowUp = '$_SESSION[uid]'";
			$result4 = mysql_query($query4) or die(mysql_error());
			$num4 = mysql_num_rows($result4);
			?>
			<p>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" STYLE="background-color: #EEEEEE; border: 1 ridge #CCCCCC">
  			<tr valign="top">
  				<td  colspan="4" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Scheduled Follow-Ups</b></font></td>
  			</tr>
  			<tr align="center">
  				<td width="100%">
		  			<?php
		  			if($num4 > 0 ) {
		  			?>
		  				<fieldset>
		  				<legend><b><font face="Arial" size="2">Past Due</font></b></legend>
		  				<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  				<tr>
				  				<td width="50">
				  					<font face="Arial" size="2"><u>Ticket</u></font>
				  				</td>
				  				<td>
				  					<font face="Arial" size="2"><u>Facility</u></font>
				  				</td>
				  				<td width="75">
				  					<font face="Arial" size="2"><u>Scheduled</u></font>
				  				</td>
				  			</tr>
				  			<?php
			  				while($row4 = mysql_fetch_array($result4)) {
					  			if($row4['DateScheduled'] < date('Y-m-d'))  {
					  			?>
						  			<tr>
						  				<td width="50">
						  					<a href="csPortal_Tickets.php?ticket_num=<?php echo $row4['ID']; ?>&by_ticket=ticket"><?php echo $row4['ID']; ?></a>
						  				</td>
						  				<td>
						  					<font face="Arial" size="2"><?php echo $row4['FacName']; ?></font>
						  				</td>
						  				<td width="75">
						  					<font face="Arial" size="2"><?php echo $row4['DateScheduled']; ?></font>
						  				</td>
						  			</tr>
				  				<?php
				  				}
			  				}
			  				?>
			  			</table>
			  			</fieldset>
							<fieldset>
		  				<legend><b><font face="Arial" size="2">Today</font></b></legend>
		  				<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  				<tr>
				  				<td width="50">
				  					<font face="Arial" size="2"><u>Ticket</u></font>
				  				</td>
				  				<td>
				  					<font face="Arial" size="2"><u>Facility</u></font>
				  				</td>
				  				<td width="75">
				  					<font face="Arial" size="2"><u>Scheduled</u></font>
				  				</td>
				  			</tr>
				  			<?php
				  			mysql_data_seek($result4, 0);
			  				while($row4 = mysql_fetch_array($result4)) {
					  			if($row4['DateScheduled'] == date('Y-m-d'))  {
					  			?>
						  			<tr>
						  				<td width="50">
						  					<a href="csPortal_Tickets.php?ticket_num=<?php echo $row4['ID']; ?>&by_ticket=ticket"><?php echo $row4['ID']; ?></a>
						  				</td>
						  				<td>
						  					<font face="Arial" size="2"><?php echo $row4['FacName']; ?></font>
						  				</td>
						  				<td width="75">
						  					<font face="Arial" size="2"><?php echo $row4['DateScheduled']; ?></font>
						  				</td>
						  			</tr>
				  				<?php
				  				}
				  			}
				  			?>
				  		</table>
				  		</fieldset>
				  		<fieldset>
		  				<legend><b><font face="Arial" size="2">Future</font></b></legend>
		  				<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  				<tr>
				  				<td width="50">
				  					<font face="Arial" size="2"><u>Ticket</u></font>
				  				</td>
				  				<td>
				  					<font face="Arial" size="2"><u>Facility</u></font>
				  				</td>
				  				<td width="75">
				  					<font face="Arial" size="2"><u>Scheduled</u></font>
				  				</td>
				  			</tr>
				  			<?php
				  			mysql_data_seek($result4, 0);
			  				while($row4 = mysql_fetch_array($result4)) {
					  			if(($row4['DateScheduled'] > date('Y-m-d')) && ($row4['DateScheduled'] <= (date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d")+5, date("Y")))))) {
					  			?>
						  			<tr>
						  				<td width="50">
						  					<a href="csPortal_Tickets.php?ticket_num=<?php echo $row4['ID']; ?>&by_ticket=ticket"><?php echo $row4['ID']; ?></a>
						  				</td>
						  				<td>
						  					<font face="Arial" size="2"><?php echo $row4['FacName']; ?></font>
						  				</td>
						  				<td width="75">
						  					<font face="Arial" size="2"><?php echo $row4['DateScheduled']; ?></font>
						  				</td>
						  			</tr>
				  				<?php
				  				}
				  			}
				  			?>
				  		</table>
				  		</fieldset>
				  		<?php
		  			} else {
		  			?>
		  				<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  				<tr>
				  				<td align="center">
				  					<font face="Arial" size="2"><i>No Active Follow-up scheduled</i></font>
				  				</td>
				  			</tr>
				  		</table>
			  		<?php
			  		}
			  		?>
			  	</td>
			  </tr>
  		</table>
  		</p>
			<?php
  		/********************* TASK MANAGEMENT MODULE ****************************/
    	include 'includes/config.inc.php';
    	mysql_select_db($dbname2);
			$query3 = "SELECT * FROM taskinfo WHERE (((Assignto = '$employeeid' && Response != '2000' && Response != '2001')
						|| Response = '$employeeid'";  # Shows tasks assigned in to logged in user
			if($row8['manageRma'] == 1) {
				$query3 .= " || Response = '2002'"; # Shows tasks for those who manage RMA's
			}
			if($row8['recFloorplan'] == 1) {
				$query3 .= " || Response = '1000'"; # Shows tasks for those assigned to do floor plans
			}
			if($row8['recRmaEmail'] == 1) {
				$query3 .= " || Response = '2000'"; # Shows tasks for RMAs handled by the sales team
			}
			if($row8['dept'] == 5) {
				$query3 .= " || Response = '2001'"; # Shows tasks for everyone in the warehouse dept.
			}
				$query3 .= " || Response2 = '$employeeid')
						&& (Status NOT IN(3, 4, 5))) ORDER BY Duedate";
			$result3 = mysql_query($query3) or die(mysql_error());
			$numTasks = mysql_num_rows($result3);
			$query10 = "SELECT ID, Type FROM tbltype";
			$result10 = mysql_query($query10);
			$row10 = mysql_fetch_array($result10);
			mysql_select_db($dbname);
			?>
			<p>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" STYLE="background-color: #EEEEEE; border: 1 ridge #CCCCCC">
  			<tr valign="top">
  				<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Open Tasks</b></font></td>
  			</tr>
  			<tr>
  				<td align="center">
  					<a href="task/taskhome.php">Management Console</a>
  				</td>
  			</tr>
  			<?php
				if($numTasks > 0)
				{
					?>
					<tr align="center">
  					<td>
  						<table border="0" cellpadding="0" cellspacing="5">
  							<tr align="left">
									<td>
										<font face="Arial" size="2"><u>Subject</u></font>
									</td>
									<td>
										<font face="Arial" size="2"><u>Priority</u></font>
									</td>
									<td width="118">
										<font face="Arial" size="2"><u>Due Date</u></font>
									</td>
								</tr>
  							<?php
								while($row3 = mysql_fetch_array($result3))
								{
									if($row3['Priority'] == "1")
									{
										$Priority = "Low";
									}
  								elseif($row3['Priority'] == "2")
  								{
  									$Priority = "Medium";
  								}
  								elseif($row3['Priority'] == "3")
  								{
  									$Priority = "High";
  								}
  								elseif($row3['Priority'] == "4")
  								{
  									$Priority = "A.S.A.P.";
  								}
  								elseif($row3['Priority'] == "5")
  								{
  									$Priority = "T.B.D.";
  								}
  								elseif($row3['Priority'] == "6")
  								{
  									$Priority = "Immediatetly";
  								}
									?>
									<tr align="left">
  									<td>
											<font face="Arial" size="2"><?php echo $row3['Subject']; ?></font>
										</td>
										<td valign="top">
											<font face="Arial" size="2"><?php echo $Priority; ?></font>
										</td>
										<td valign="top">
											<font face="Arial" size="2"><?php echo $row3['Duedate']; ?></font>
										</td>
									</tr>
									<?php
								}
								?>
							</table>
						</td>
					</tr>
				<?php
				}
				else
				{
				?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr align="center">
  					<td>
							<font face="Arial" size="2"><i>You Have No Open Tasks</i></font>
						</td>
					</tr>
				<?php
				}
  			?>
  		</table>
  		</p>
  		<?php
  		/****************** WARRANTY PROGRAM MODULE *************************/
  		if($warr_progPerm > 0)
  		{
  		?>
  			<p>
  			<table width="100%" border="0" cellpadding="0" cellspacing="0" STYLE="background-color: #EEEEEE; border: 1 ridge #CCCCCC">
  				<tr>
  					<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Extended Warranty Alerts</b></font></td>
  				</tr>
  			<?php
  				if($num9 == 0)
  				{
  				?>
  					<tr>
  						<td align="center" colspan="2">
  							<font face="Arial" size="2">** All Warranty Contracts Are Current **</font>
  						</td>
  					</tr>
  				<?php
  				}
  				else
  				{
  				?>
  					<tr>
  						<td align="center" colspan="2">
  							<font face="Arial" size="2" color="red"><b>** <?php echo $num9; ?> Contract(s) Expired or Expiring in the Next <?php echo $notificationPeriod; ?> **</b></font>
  						</td>
  					</tr>
  					<tr align="center">
  						<td colspan="2">
  							<table>
  								<tr align="center">
  									<td>
  										<font face="Arial" size="2"><u>Facility ID</u></font>
  									</td>
  									<td>
  										<font face="Arial" size="2"><u>Facility Name</u></font>
  									</td>
  									<td>
  										<font face="Arial" size="2"><u>Contract Number</u></font>
  									</td>
  									<td>
  										<font face="Arial" size="2"><u>Expiration Date</u></font>
  									</td> 
    								<td>
    									&nbsp;
    								</td>
  								</tr>
  								<?php
  								mysql_select_db($dbname);
  								while($row9 = @mysql_fetch_array($result9))
  								{
  									$custNum = $row9['FacilityID'];
  									$query11 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custNum'";
  									$result11 = mysql_query($query11, $conn) or die(mysql_error());
  									$row11 = mysql_fetch_array($result11);
  									?>
  									<tr align="center">
  									<td>
  										<font face="Arial" size="2"><?php echo $row9['FacilityID']; ?></font>
  									</td>
  									<td>
  										<font face="Arial" size="2"><?php echo $row11['FacilityName']; ?></font>
  									</td>
  									<td>
  										<font face="Arial" size="2"><?php echo $row9['id']; ?></font>
  									</td>
  									<td>
  										<font face="Arial" size="2"><?php echo $row9['EndDate']; ?></font>
  									</td>
  									<td>
  										<a href="csPortal_WarrantyProgram.php?cust_num=<?php echo $custNum; ?>">Details</a>
  									</td>
  								</tr>
  							<?php
  							}
  							?>

  						</table>
  					</td>
  			</tr>
  			<?php
  			}
  			?>
  		</table>
  		</p>
  		<?php
  		}
  		/********************* BULLETINS MODULE ****************************/
  		?>
  		<p>
  		<table width="100%" border="0" cellpadding="0" cellspacing="0" STYLE="background-color: #EEEEEE; border: 1 ridge #CCCCCC">
  			<tr>
    			<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Portal Bulletins</b></font></td>		
  			</tr>
  			<tr valign="top" >
  				<td>
  					<table width="100%">
  						<?php
  						if(mysql_num_rows($result) > 0)
  						{
  							while($row = @mysql_fetch_array($result))
  							{ 
									if(isset($_GET['f_details']) && $_GET['f_details'] == $row['id'])
									{
										echo '<tr><td width="65" valign="top" align="center"><font face="Arial" size="2"><b>'.$row['msg_date'].'</b></font></td><td><font face="Arial" size="2"><b>'.$row['msg_subject'].'</b></font></td></tr>';
										echo '<tr><td valign="top" align="center"><font face="Arial" size="2"><a href="'.$_SERVER['PHP_SELF'].'">Close</a></font></td><td><font face="Arial" size="2"><b>'.$row['msg_body'].'</b></font></td></tr>';
									}
									else
									{
										echo '<tr><td width="65" valign="top" align="center"><font face="Arial" size="2">'.$row['msg_date'].'</font></td><td><font face="Arial" size="2">'.$row['msg_subject'].'</font></td></tr>';
										echo '<tr><td valign="top" align="center"><font face="Arial" size="2"><a href="'.$_SERVER['PHP_SELF'].'?f_details='.$row['id'].'">Expand</a></td><td>&nbsp;</td>';
									}
								}
  						}
  						else
  						{
  						?>
  							<tr>
  								<td align="center">
  									<font face="Arial" size="2"><i>No Portal Bulletins Posted</i></font>
  								</td>
  							</tr>
  						<?php
  						}
  						?>
  					</table>
  				</td>
  			</tr>
  			<tr>
    			<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>HomeFree Bulletins</b></font></td>
  			</tr>
  			<tr>
  				<td>
  					<table width="100%">
  						<?php
  						if(mysql_num_rows($result2) > 0)
  						{
  							while($row2 = @mysql_fetch_array($result2))
  							{ 
									if(isset($_GET['f_details']) && $_GET['f_details'] == $row2['id'])
									{
										echo '<tr><td width="65" valign="top"><font face="Arial" size="2"><b>'.$row2['msg_date'].'</b></font></td><td><font face="Arial" size="2"><b>'.$row2['msg_subject'].'</b></font></td></tr>';
										echo '<tr><td valign="top"><font face="Arial" size="2"><a href="'.$_SERVER['PHP_SELF'].'">Close</a></font></td><td><font face="Arial" size="2"><b>'.$row2['msg_body'].'</b></font></td></tr>';
									}
									else
									{
										echo '<tr><td width="65" valign="top"><font face="Arial" size="2">'.$row2['msg_date'].'</font></td><td><font face="Arial" size="2">'.$row2['msg_subject'].'</font></td></tr>';
										echo '<tr><td valign="top"><font face="Arial" size="2"><a href="'.$_SERVER['PHP_SELF'].'?f_details='.$row2['id'].'">Expand</a></td><td>&nbsp;</td>';
									}
								}
  						}
  						else
  						{
  						?>
  							<tr>
  								<td align="center">
  									<font face="Arial" size="2"><i>No HomeFree Bulletins Posted</i></font>
  								</td>
  							</tr>
  						<?php
  						}
  						?>
  					</table>
  				</td>
  			</tr>
  		</table>
  		</p>
  		<?php
  		/********************* DB BACKUP MODULE ****************************/
  		if($employeeDept == 2) {
  			$query12 = "SELECT MAX(filemanager.timestamp) AS MaxTimestamp, MAX(filemanager.id) AS ID, filemanager.timestamp AS timestamp, filemanager.name AS name, filemanager.refNumber AS refNumber, tblCustSystemInfo.CustomerNumber AS custNumber, tblCustSystemInfo.ConnectionType AS ConnectionType 
  									FROM filemanager 
  									LEFT JOIN tblCustSystemInfo ON filemanager.refNumber = tblCustSystemInfo.CustomerNumber 
  									WHERE (name LIKE '%Database%' OR name LIKE '%Db%') 
  									AND Publish = -1 AND (ConnectionType = '10' OR ConnectionType = '2') 
  									AND CustomerNumber NOT IN (SELECT CustomerNumber FROM tblFacilities WHERE Active = 0) 
  									GROUP BY custNumber 
  									ORDER BY ID ASC LIMIT 16";
  			$result12 = mysql_query($query12) or die(mysql_error());
  			$query14 = "SELECT CustomerNumber FROM tblCustSystemInfo 
  									WHERE (ConnectionType = '10' OR ConnectionType = '2') 
  									AND CustomerNumber NOT IN (SELECT refNumber FROM fileManager WHERE (name LIKE '%Database%' OR name LIKE '%Db%') AND Publish = -1) 
  									AND CustomerNumber NOT IN (SELECT CustomerNumber FROM tblFacilities WHERE Active = 0) 
  									LIMIT 10";
  			$result14 = mysql_query($query14) or die(mysql_error());
  			?>
	  		<p>
	  		<table width="100%" border="0" cellpadding="0" cellspacing="0" STYLE="background-color: #EEEEEE; border: 1 ridge #CCCCCC">
	  			<tr>
	    			<td align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><b>Databases Needing Backup</b></font></td>		
	  			</tr>
	  			<tr valign="top" >
	  				<td>
	  					<table width="100%">
	  						<tr>
	  							<td><b><u>Facility Name</b></u></td>
	  							<td><b><u>Last Backup</b></u></td>
	  						</tr>
	  						<?php
	  						while($row14 = mysql_fetch_array($result14)) {
	  							$query13 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$row14[CustomerNumber]'";
	  							$result13 = mysql_query($query13);
	  							$row13 = mysql_fetch_array($result13);
	  							?>
		  						<tr>
		  							<td><a href="csPortal_Facilities.php?cust_num=<?php echo $row14['CustomerNumber']; ?>&by_cust=number"><?php echo $row13['FacilityName']; ?></a></td>
		  							<td><i>No Database on File</i></td>
		  						</tr>
		  						<?php
		  					}
	  						while($row12 = mysql_fetch_array($result12)) {
	  							$query13 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$row12[custNumber]'";
	  							$result13 = mysql_query($query13);
	  							$row13 = mysql_fetch_array($result13);
	  							?>
		  						<tr>
		  							<td><a href="csPortal_Facilities.php?cust_num=<?php echo $row12['custNumber']; ?>&by_cust=number"><?php echo $row13['FacilityName']; ?></a></td>
		  							<td><?php echo $row12['MaxTimestamp']; ?></td>
		  						</tr>
		  						<?php
		  					}
		  					?>
	  					</table>
	  				</td>
	  			</tr>
	  		</table>
	  	</td>
	  	</p>
  		<?php
  	}
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
  	<td width="209">
  		<?php
			if((isset($_GET['view']) && ($_GET['view'] == "print")))
			{
				include 'includes/db_close.inc.php';
			}
			else
			{
			?>
				<table height="215" border="0">
  				<tr>
  					<td align="center">
  						<?php
  						echo '<font face="Arial" size="2"><b>'.date("l, M. jS, Y").'<br>'.date("g:i:sa").'</b></font>';
  						?>
  					</td>
  				</tr>
  				<tr> 
    				<td>
      				<!-- Search Google -->
      				<style type="text/css">
@import url(http://www.google.com/cse/api/branding.css);
</style>
<div class="cse-branding-bottom" style="background-color:#FFFFFF;color:#000000">
  <div class="cse-branding-form">
    <form action="http://www.google.com/cse" id="cse-search-box" target="_blank">
      <div>
        <input type="hidden" name="cx" value="partner-pub-6311950500981555:if19h0fxhz7" />
        <input type="hidden" name="ie" value="ISO-8859-1" />
        <input type="text" name="q" size="31" />
        <input type="submit" name="sa" value="Search" />
      </div>
    </form>
  </div>
  <div class="cse-branding-logo">
    <img src="http://www.google.com/images/poweredby_transparent/poweredby_FFFFFF.gif" alt="Google" />
  </div>
  <div class="cse-branding-text">
    Custom Search
  </div>
</div>
      			<!-- Search Google -->
    			</td>
  			</tr>
  		<tr>
    		<td align="center"><font face="Arial" size="2"><strong>HomeFree Weather</strong></font></td>
  		</tr>
  		<tr> 
    		<td align="center"><div style='width: 160px; height: 600px; background-image: url( http://vortex.accuweather.com/adcbin/netweather_v2/backgrounds/spring1_160x600_bg.jpg ); background-repeat: no-repeat; background-color: #607041;' ><div style='height: 585px;' ><script src='http://netweather.accuweather.com/adcbin/netweather_v2/netweatherV2.asp?partner=netweather&tStyle=normal&logo=1&zipcode=<?php echo "$postal_code"; ?>&lang=eng&size=15&theme=&metric=0&target=_self'></script></div><div style='text-align: center; font-family: arial, helvetica, verdana, sans-serif; font-size: 10px; line-height: 15px; color: FDEA11;' ><a style='color: #FDEA11' href='http://wwwa.accuweather.com/index-forecast.asp?partner=netweather&traveler=0&zipcode=<?php echo "$postal_code"; ?>' >Weather Forecast</a> | <a style='color: #FDEA11' href='http://wwwa.accuweather.com/maps-satellite.asp?partner=netweather' >Weather Maps</a></div></div></td>
  		</tr>
			</table>
			<?php
			}
			?>
		</td>
	</tr>
	<?php
	/*************************** COLUMN RIGHT END ***************************/
	
	/***************************** FOOTER START *****************************/
	?>
	<tr>
		<td colspan="2">
			<?php include_once ("./footer.php"); ?>
		</td>
	</tr>
	<?php
	/****************************** FOOTER END ******************************/
	?>
</table>
</body>
</html>