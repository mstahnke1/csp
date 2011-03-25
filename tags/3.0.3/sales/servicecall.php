<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
$email = $_SESSION['mail'];
mysql_select_db('testhomefree');
$query100 = "SELECT projmanage FROM employees WHERE email = '$email'";
$result100 = mysql_query($query100) or die (mysql_error());
$row100 = mysql_fetch_array($result100);
$proj = $row100['projmanage'];
if(isset($_GET['no']))
{
	$f_id = $_GET['f_id'];
	header("Location: servicecall.php?view=job&f_id=$f_id");
}
if(isset($_GET['cancel']))
{
	header("Location: servicecall.php?view=new");
}
if(isset($_GET['doorissuesave']))
{
	mysql_select_db('testwork');
	$callnumber = $_GET['callref'];
	$custnumber = $_GET['custref'];
	$ialarm = $_GET['ialarm'];
	$noalarm = $_GET['noalarm'];
	$false = $_GET['false'];
	$number = $_GET['numdoors'];
	$query22 = "INSERT INTO tblissuesummary (CallNumber,numberdoors,falsealarm,noalarm,ialarm) VALUES ('$callnumber','$number','$false','$noalarm','$ialarm')";
	mysql_query($query22) or die(mysql_error());
	header("Location: servicecall.php?issue=door&custnumber=$custnumber&callnumber=$callnumber");
}
if(isset($_GET['falsesave']))
{
	mysql_select_db('testwork');
	$callnumber = $_GET['callnumber'];
	$custnumber = $_GET['custnumber'];
	$alarm = 'False';
	$false = addslashes($_GET['false']);
	$query25 = "INSERT INTO tbldoorissues (CallNumber,Issue,Description) VALUES ('$callnumber', '$alarm', '$false')";
	mysql_query($query25) or die(mysql_error());
	header("Location: servicecall.php?issue=door&custnumber=$custnumber&callnumber=$callnumber");
}
if(isset($_GET['noalarmsave']))
{
	mysql_select_db('testwork');
	$callnumber = $_GET['callnumber'];
	$custnumber = $_GET['custnumber'];
	$alarm = 'No Alarm';
	$noalarm = addslashes($_GET['noalarm']);
	$query27 = "INSERT INTO tbldoorissues (CallNumber,Issue,Description) VALUES ('$callnumber', '$alarm', '$noalarm')";
	mysql_query($query27) or die(mysql_error());
	header("Location: servicecall.php?issue=door&custnumber=$custnumber&callnumber=$callnumber");
}
if(isset($_GET['ialarmsave']))
{
	mysql_select_db('testwork');
	$callnumber = $_GET['callnumber'];
	$custnumber = $_GET['custnumber'];
	$alarm = 'Inconsistent Alarm';
	$ialarm = addslashes($_GET['ialarm']);
	$query29 = "INSERT INTO tbldoorissues (CallNumber,Issue,Description) VALUES ('$callnumber', '$alarm', '$ialarm')";
	mysql_query($query29) or die(mysql_error());
	header("Location: servicecall.php?issue=door&custnumber=$custnumber&callnumber=$callnumber");
}
if(isset($_GET['computerissuesave']))
{
	mysql_select_db('testwork');
	$callnumber = $_GET['callref'];
	$custnumber = $_GET['custref'];
	$boot = $_GET['boot'];
	$dumps = $_GET['dumps'];
	$performance = $_GET['performance'];
	$pctype = $_GET['pctype'];
	$query34 = "INSERT INTO tblissuesummary (CallNumber,PCtype,Boot,Dumps,Performance) VALUES ('$callnumber','$pctype','$boot','$dumps','$performance')";
	mysql_query($query34) or die(mysql_error());
	header("Location: servicecall.php?view=finished&custnumber=$custnumber&callnumber=$callnumber");
}
			if((isset($_GET['save'])) && ($_GET['save'] == "Save"))
			{
				$custNum = $_GET['f_id'];
				//$packageType = $_GET['packageType'];
				//$startDate = $_GET['startDate'];
				//$duration = $_GET['duration'];
				//$endDate = date('Y-m-d', strtotime("+".$duration." year", strtotime($startDate)));
				$wmbuCount = $_GET['wmbuCount'];
				if(is_int($wmbuCount))
				{
					$wmbuCount = $_GET['wmbuCount'];
				}else
				{
					$wmbuCount = 0;
				}
				$wmuCount = $_GET['wmuCount'];
				$outwmuCount = $_GET['outwmuCount'];
				$wmduCount = $_GET['wmduCount'];
				$owmduCount = $_GET['owmduCount'];
				$pwCount = $_GET['pwCount'];
				$cbCount = $_GET['cbCount'];
				if(is_int($cbCount))
				{
					$cbCount = $_GET['cbCount'];
				}else
				{
					$cbCount = 0;
				}				
				$ptCount = $_GET['ptCount'];
				$pcCount = $_GET['pcCount'];
				$fduCount = $_GET['fduCount'];
				$utCount = $_GET['utCount'];
				$compCount = $_GET['compCount'];
				$pcCount = $_GET['pcCount'];
				$pageBase = $_GET['pageBase'];
				$pageCount = $_GET['pageCount'];
				$pagerType = $_GET['pagerType'];
				$cpsCount = $_GET['cpsCount'];
				$lightCount = $_GET['lightCount'];
				$cordCount = $_GET['cordCount'];
				echo $cbCount;
				mysql_select_db('testhomefree');
				$query4 = "INSERT INTO warrantyinfo (FacilityID, Package, TotalWMBU, TotalWMUs, TotalWMDU, TotalOutWMDU, TotalWatches, TotalPanicButtons, TotalPullCords,
								TotalCallCords, TotalCPS, TotalOutWMU, TotalHFCorridorLights, pageBase, PagerQuantity, pagerType, TotalFallUnits,
								UTs, TotalPullTags, TotalClientStations, StartDate, EndDate) VALUES ('$custNum', 0, '$wmbuCount','$wmuCount', '$wmduCount', '$owmduCount', '$pwCount',
								'$cbCount',	'$pcCount', '$cordCount', '$cpsCount', '$outwmuCount','$lightCount', '$pageBase', '$pageCount', '$pagerType', '$fduCount',
								'$utCount', '$ptCount', '$compCount',0,0)";
				$result4 = mysql_query($query4) or die(mysql_error());
				/*
				if(!(isset($_GET['ignore'])))
				{
					header("Location: servicecall.php?view=job&f_id=$custNum");							
				}else
				{
					header("Location: servicecall.php?f_id=$custNum");
				}
				*/
			}
$date = date('Y-m-d H:i:s');
$currentdate = date('m-d-Y');
$signature = $_SESSION['username'];
if((isset($_GET['view'])) && ($_GET['view'] == "new"))
{
?>
		<table align ="center">
			<tr>
				<td colspan = "3" align = "center"><font face="Arial" size="4"><b>
					Service Call Scope of Work
				</b></font></td>
			</tr>
			<form method="GET" name="formname" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<tr>
				<td>
					Facility Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="60" name="Fname">
				</td>
				<td>
					<input type="submit" value="Search" name="searchname">
				</td>
			</tr>
		</form>
		<form method="GET" name="formnumber" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<tr>
				<td>
					Customer Number:
				</td>
				<td>
					<input type="text" size="40" maxlength="60" name="cnumber">
				</td>
				<td>
					<input type="submit" value="Search" name="searchnum">
				</td>
			</tr>
		</table>
	</form>
<?php
}			
if((isset($_GET["searchname"])) OR (isset($_GET["searchnum"])))
{
	if((isset($_GET["searchname"])) && (!isset($_GET["searchnum"])))
	{
		$f_name=addslashes($_GET["Fname"]);
		$conn2 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
		mysql_select_db('testhomefree');
		$query1 = "SELECT CustomerNumber,FacilityName,City,StateOrProvinceCode FROM tblfacilities WHERE FacilityName LIKE '%$f_name%' ORDER BY FacilityName";
		$result1 = mysql_query($query1) or die (mysql_error());
		$count = mysql_num_rows($result1);
	}
	if((isset($_GET["searchnum"])) && (!isset($_GET["searchname"])))
	{
		$cnum = $_GET["cnumber"];
		$conn2 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
		mysql_select_db('testhomefree');
		$query1 = "SELECT CustomerNumber,FacilityName,City,StateOrProvinceCode FROM tblfacilities WHERE CustomerNumber = '$cnum'";
		$result1 = mysql_query($query1) or die (mysql_error());
		$count = mysql_num_rows($result1);
	}
	if($count > 0)
	{			
		while($row1 = mysql_fetch_array($result1))
		{
			echo '<tr><td><font face="Arial" size="2"><a href="' . $_SERVER['PHP_SELF'].'?f_id='. $row1['CustomerNumber'].'">'. $row1['FacilityName'] .'</a>'. '&nbsp;&nbsp;&nbsp;&nbsp;City:'. '&nbsp;&nbsp;&nbsp;&nbsp;'.$row1['City'] . ' </font></td></tr>';
		}
?>
	</table>
<?php
	}else
	{
?>
		<table align="center" width = "750">
			<tr>
				<td width = "200">
					NO RECORDS FOUND
				</td>
			</tr>
			<tr>
				<td colspan ="2">
					IF Searched by name please try by customer number before attempting to add the customer
				</td>
			</tr>			
			<tr>
				<td width = "200">
					<?php echo '<a href=" ../csPortal_Facilities.php?action=createNew">'. 'Click to <u>Add</u> customer to Portal' .' </a>'; ?>
				</td>
				<td>
					<?php echo '<a href=" ../sales/servicecall.php?view=new">'. 'Back to search' .' </a>'; ?>
				</td>				
			</tr>
		</table>			
<?php
	}
}
if((isset($_GET["f_id"])) && (!isset($_GET['view'])))
{
	$f_id = $_GET['f_id'];
	mysql_select_db('testhomefree');
	$query5 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result5 = mysql_query($query5);
	$row5 = mysql_fetch_array($result5);
	mysql_select_db('testwork');
	$findservice = "SELECT * FROM tblservicecall WHERE CustomerNumber = '$f_id'";
	$resfindservice = mysql_query($findservice);
	$countcalls = mysql_num_rows($resfindservice);
	if(isset($_GET['ignore']))
	{
		$countcalls = 0;
	}
	if($countcalls < 1)
	{
		mysql_select_db('testhomefree');
		$query2 = "SELECT * FROM warrantyinfo WHERE FacilityID = '$f_id'";
		$result2 = mysql_query($query2);
		$count2 = mysql_num_rows($result2);
		$row2 = mysql_fetch_array($result2);
		mysql_select_db('testwork');
		$query14 = "SELECT * FROM tblfacilitygeneralinfo WHERE Cust_Num = '$f_id'";
		$result14 = mysql_query($query14);
		$count14 = mysql_num_rows($result14);
		if($count2 > 0)
		{
			header("Location: servicecall.php?view=job&f_id=$f_id");
		}
		if($count2 < 1)
		{
			if(!((isset($_GET['yes'])) OR (isset($_GET['no'])) OR (isset($_GET['view'])) OR (isset($_GET['getequip']))))
			{
?>
				<table align = "center">
					<tr><ul>
						<td colspan = "3"><font face="Arial" size="2">
							<li> <?php echo $row5['FacilityName']; ?> currently does not have the necessary information provided to offer the ensure program or give an accurate summary of the equipment
							being used.
						</font></td>
					</tr>
					<tr>
						<td colspan = "3"><font face="Arial" size="2">
							<li>By clicking yes you will be asked to enter the values of the equipment that the facility has.  This information will be used as a summary on service
							call Scope of Works, and if the customer decides to use the ensure program in the future the information will already be in the system.
						</font></td>
					</tr>
					<tr>
						<td colspan = "3"><font face="Arial" size="2">
							<li>By clicking no you will put in the specifics of the service call in the job overview section and that will be all that is displayed.
						</font></td>
					</ul></tr>					
				<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php			
				if($count14 < 1)
				{			
?>
					<tr>
						<td width = "60">
							<input type="submit" value="YES" name="yes">
						</td>
						<td>
							<input type="submit" value="NO" name="no">
						</td>
					</tr>
<?php
				}else
				{
?>
					<tr>
							<td colspan = "3"><font face="Arial" size="2"><b>
								I have detected that you have previously completed a Scope of Work for this customer. <br>
								Would you like to use that scope of work to compile the equipment list?
							</b></font></td>
						</tr>
						<tr>
							<td width = "60">
								<input type="submit" value="YES" name="getequip">
							</td>
							<td width = "215">
								<input type="submit" value="NO Enter Equipment Manually" name="yes">
							</td>
							<td>
								<input type="submit" value="NO" name="no">
							</td>
						</tr>							
<?php
				}
				echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
				</table>		
			</form>
<?php
	
		}
			if(isset($_GET['yes']))
			{
?>
				<form name="prgmDetails" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<table width = "750" align = "center">
						<tr>
							<td>
									<table border ="0" cellpadding="0" cellspacing="4" width = "160" align = "left">
		 								<tr>
		 									<td colspan = "2">
 											<font face="Arial" size="2"><u>Wireless Infrastructure</u></font>
 										</td>
 									</tr>
 									<tr>
 										<td>
											<font face="Arial" size="2">WMBU: </font>
										</td>
										<td>
											<input type="text" name="wmbuCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
 										<td>
											<font face="Arial" size="2">WMU: </font>
										</td>
										<td>
											<input type="text" name="wmuCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
										<td>
											<font face="Arial" size="2">Outdoor WMU: </font>
										</td>
										<td>
											<input type="text" name="outwmuCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
 										<td>
											<font face="Arial" size="2">WMDU: </font>
										</td>
										<td>
											<input type="text" name="wmduCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
 										<td>
											<font face="Arial" size="2">Outddor WMDU: </font>
										</td>
										<td>
											<input type="text" name="owmduCount" size="4" value="0" />
										</td>
									</tr>
								</table>
								<table border="0" cellpadding="0" cellspacing="4" width = "160" align = "left">
									<tr>
 										<td colspan = "2">
 											<font face="Arial" size="2"><u>Resident Transmitters</u></font>
 										</td>
 									</tr>
 									<tr>
 										<td>
											<font face="Arial" size="2">Watch: </font>
										</td>
										<td>
											<input type="text" name="pwCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
 										<td>
											<font face="Arial" size="2">Call Button: </font>
										</td>
										<td>
											<input type="text" name="cbCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
										<td>
											<font face="Arial" size="2">Staff Assist: </font>
										</td>
										<td>
											<input type="text" name="ptCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
 										<td>
											<font face="Arial" size="2">Pull Cord</font>
										</td>
										<td>
											<input type="text" name="pcCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
										<td>
											<font face="Arial" size="2">Fall Unit: </font>
										</td>
										<td>
											<input type="text" name="fduCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
										<td>
											<font face="Arial" size="2">UT: </font>
										</td>
										<td>
											<input type="text" name="utCount" size="4" value="0" />
										</td>
									</tr>
								</table>
								<table border="0" cellpadding="0" cellspacing="4" width = "250" align="left">
 									<tr>
 										<td colspan = "2">
 											<font face="Arial" size="2"><u>Integrated Hardware</u></font>
 										</td>
 									</tr>
	 								<tr>
 										<td>
											<font face="Arial" size="2">PC Stations: </font>
										</td>
										<td>
											<input type="text" name="compCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
 										<td>
											<font face="Arial" size="2">Paging Base: </font>
										</td>
										<td>
											<select name="pageBase">
												<option value="Commtech 5W">Commtech 5W</option>
												<option value="Commtech 25W">Commtech 25W</option>
												<option value="Commtech 50W">Commtech 50W</option>
												<option value="Commtech 100W">Commtech 100W</option>
												<option value="Scope">Scope</option>
											</select>
										</td>
									</tr>
									<tr>
 										<td>
											<font face="Arial" size="2">Pager Count: </font>
										</td>
										<td>
											<input type="text" name="pageCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
										<td>
											<font face="Arial" size="2">Pager Type: </font>
										</td>
										<td>
											<select name="pagerType">
												<option value="Commtech 7900">Commtech 7900</option>
												<option value="Apollo Gold">Apollo Gold</option>
											</select>							
										</td>
									</tr>
								</table>
								<table border="0" cellpadding="0" cellspacing="4">
									<tr>
 										<td colspan = "2">
	  									<font face="Arial" size="2"><u>Misc. Hardware</u></font>
	  								</td>
 									</tr>
									<tr>
										<td>
											<font face="Arial" size="2">Central Power: </font>
										</td>
										<td>
											<input type="text" name="cpsCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
										<td>
											<font face="Arial" size="2">Corridor Light: </font>
										</td>
										<td>
											<input type="text" name="lightCount" size="4" value="0" />
										</td>
									</tr>
									<tr>
										<td>
											<font face="Arial" size="2">Call Cord: </font>
										</td>
										<td>
											<input type="text" name="cordCount" size="4" value="0" />
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" value="Save" name="save">
							</td>
						</tr>
					</table>
<?php
					echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
					if(isset($_GET['ignore']))
					{
						echo	'<input type = "hidden" name="ignore" value = "yes">';
					}
?>
				</form> 		
<?php
			}
		}
	}else
	{
?>
		<table width = "750" align = "center">
			<tr>
				<td>
					<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?view=new">'. 'Go To Another Customer' .' </a>'; ?>
				</td>
			</tr>
			<tr>
				<td>
					<div align="center"><hr width="100%">
				</div></td>
			</tr>		
		<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "3"><font face = "Arial" size = 3"><b>
					Active Service Calls for <?php echo $row5['FacilityName']; ?>
				</td>
			</tr>
			<tr>
				<td width = "180"><font face = "Arial" size = 2"><b><u>
					Title
				</u></b></td>
				<td width = "20"><font face = "Arial" size = 2"><b><u>
					Status
				</u></b></td>
				<td width = "320"><font face = "Arial" size = 2"><b><u>
					Reason
				</u></b></td>
			</tr>					
			<tr>
				<td>
<?php
					mysql_select_db('testwork');
					while($findserviceres = mysql_fetch_array($resfindservice))
					{ 
						$status1 = $findserviceres['Status'];
						$getstatus = "SELECT Status FROM tblStatus WHERE ID = '$status1'";
						$resgetstatus = mysql_query($getstatus);
						$gotstatus = mysql_fetch_array($resgetstatus);
						$reasonid = $findserviceres['Reason'];
						$query6 = "SELECT Reason FROM tblservicereason WHERE ID = '$reasonid'";
						$result6 = mysql_query($query6) or die (mysql_error());
						$row6 = mysql_fetch_array($result6);
						echo '<tr><td><font face="Arial" size="2"><a href="' . $_SERVER['PHP_SELF'].'?callnumber='. $findserviceres['ID'].'&view=finished&custnumber='.$f_id .'">'. $findserviceres['Title'] .'</a></td><td>'. $gotstatus['Status'].'</td><td>'. $row6['Reason']. ' </font></td></tr>';
					}
?>
				</td>
			</tr>	
			<tr>
				<td colspan="3">
					<div align="center"><hr width="100%">
				</div></td>
			</tr>					 
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td width = "180"><font face = "Arial" size = 2"><b>
					Other Customer Options
				</font></td>
				<td width = "100"><font face = "Arial" size = 2">
					<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?view=job&f_id='.$f_id.'">'. 'New Service Call' .' </a>'; ?> 
				</font></td>
<?php
				mysql_select_db('testhomefree');
				$query2 = "SELECT * FROM warrantyinfo WHERE FacilityID = '$f_id'";
				$result2 = mysql_query($query2);
				$count2 = mysql_num_rows($result2);
				if($count2 < 1)
				{
?>						
					<td width = "350"><font face = "Arial" size = 2">
						<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?ignore=yes&yes=YES&f_id='.$f_id.'">'. 'Add Current Equipment' .' </a>'; ?> 
					</font></td>	
<?php
				}else
				{
?>
					<td width = "350"><font face = "Arial" size = 2">
						<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?view=update&form=equip&f_id='.$f_id.'">'. 'Update Current Equipment' .' </a>'; ?> 
					</font></td>	
<?php
				}
?>
			</tr>		
		</table>
<?php
	}	
}
if((isset($_GET['view'])) && ($_GET['view']=="job"))
{
	$f_id = $_GET['f_id'];
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width = "750" align = "center" cellpadding = "4">
			<tr>
				<td><font face = "Arial" size = 2">
					Please give this service call a Title to reference later.
				</font></td>
				<td><font face = "Arial" size = 2">
					<input type="text" size="65" maxlength="240" name="title">
				</font></td>
			</tr>					
			<tr>
				<td><font face = "Arial" size = 2">
					Please select the reason for the service call.
				</font></td>
				<td><select name = "selectedreason">
					<option value="0">NONE
<?php
				mysql_select_db('testwork');
				$getreason = "SELECT * FROM tblservicereason ORDER BY Reason ASC";
				$resgetreason = mysql_query($getreason) or die (mysql_error());			
				while($reason = mysql_fetch_array($resgetreason))
				{
?>
					<option value="<?php echo $reason['ID']; ?>"><?php echo $reason['Reason']; ?></option>				
<?php
				}	
				echo	'<input type = "hidden" name="custnum" value = "'.$f_id.'">';			
?>
				</select></td>
			</tr>
			<tr>
				<td><font face = "Arial" size = 2">
					Please fill in the job overview:
				</font></td>
				<td>
					Status: New
				</td>							
			</tr>
			<tr>
				<td colspan = "2">
 					<textarea rows="12" cols="88" name="job"></textarea> 				
 				</td>
 			</tr>
 		</table>
 		<table width = "750" align = "center">
 			<tr>
 				<td>
 					<input type="submit" value="Continue" name="cont">
 				</td>
 				<td>
 					<input type="submit" value="Cancel" name="cancel">
 				</td> 				
 			</tr>
		</table>
	</form>
<?php	
}
if((isset($_GET['cont'])) && ($_GET['cont'] == "Continue"))
{
	$f_id = $_GET['custnum'];
	$reason = $_GET['selectedreason'];
	$job = addslashes($_GET["job"]); 
	$title = addslashes($_GET['title']);
	$status = 1;
	mysql_select_db('testwork');
	$insertservice = "INSERT INTO tblservicecall (CustomerNumber, Title,Reason, Description, Status) VALUES ('$f_id', '$title','$reason','$job','$status')";
	mysql_query($insertservice) or die(mysql_error());
	$query8 = "SELECT max(ID) FROM tblservicecall";
	$result8 = mysql_query($query8) or die (mysql_error());
	$row8 = mysql_fetch_array($result8);
	$currentid = $row8['max(ID)'];
	$query9 = "SELECT Type FROM tblservicereason WHERE ID = '$reason'";
	$result9 = mysql_query($query9) or die (mysql_error());
	$row9 = mysql_fetch_array($result9);
	if($row9['Type'] == 1)
	{
		header("Location: servicecall.php?custnumber=$f_id&issue=paging&callnumber=$currentid");
	}elseif($row9['Type'] == 2)
	{
		header("Location: servicecall.php?custnumber=$f_id&issue=doorunit&callnumber=$currentid");
	}elseif($row9['Type'] == 3)
	{
		header("Location: servicecall.php?custnumber=$f_id&issue=computer&callnumber=$currentid");
	}else
	{
		header("Location: servicecall.php?custnumber=$f_id&view=finished&callnumber=$currentid");
	}
}
if((isset($_GET['view'])) && ($_GET['view'] == "finished") && (isset($_GET['callnumber'])))
{
	$f_id = $_GET['custnumber'];
	$callid = $_GET['callnumber'];
	mysql_select_db('testhomefree');
	$query1 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_fetch_array($result1);
	$query2 = "SELECT * FROM warrantyinfo WHERE FacilityID = '$f_id'";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2);
	$count2 = mysql_num_rows($result2);
	mysql_select_db('testwork');
	$query3 = "SELECT * FROM tblservicecall WHERE ID = '$callid'";
	$result3 = mysql_query($query3) or die (mysql_error());
	$row3 = mysql_fetch_array($result3);
	$reasonid = $row3['Reason'];
	$statusid = $row3['Status'];
	$query4 = "SELECT Reason,Type FROM tblservicereason WHERE ID = '$reasonid'";
	$result4 = mysql_query($query4) or die (mysql_error());
	$row4 = mysql_fetch_array($result4);
	$query7 = "SELECT Status FROM tblstatus WHERE ID = '$statusid'";
	$result7 = mysql_query($query7) or die (mysql_error());
	$row7 = mysql_fetch_array($result7);	
	$query13 = "SELECT * FROM tblissuesummary WHERE CallNumber = '$callid'";
	$result13 = mysql_query($query13) or die (mysql_error());
	$row13 = mysql_fetch_array($result13);	
	$query38 = "SELECT ID FROM epc_calendar WHERE serviceid = '$callid' AND Active <> 0";
	$result38 = mysql_query($query38) or die (mysql_error());
	$count38 = mysql_num_rows($result38);
	$row38 = mysql_fetch_array($result38);
?>
	<table width = "750" align = "Center">
<?php
		if(!isset($_GET['print']))
		{
?>					
			<tr>
				<td>
					<?php echo '<a href="' . '../Sales/ServiceCall.php?f_id='.$f_id.'">' . 'View Active Serive Calls'. '</a>'; ?>
				</td>
				<td>
<?php 
				if($count2 > 0)
				{
					echo '<a href="' . '../Sales/ServiceCall.php?f_id='.$f_id.'&call='.$callid.'&view=update&update=equip">' . 'Update Current Equipment'. '</a>';
				}else
				{
					echo '<a href="' . '../Sales/ServiceCall.php?f_id='.$f_id.'&call='.$callid.'&ignore=yes&yes=YES&active=yes">' . 'Add Equipment'. '</a>';
				}
?>					
				</td>
				<td>
					<?php echo '<a href="' . '../Sales/ServiceCall.php?custnumber='.$f_id.'&callnumber='.$callid.'&view=finished&print=print">' . 'Print View'. '</a>'; ?>
				</td>
				<td>	
<?php
				if(($statusid == 6) OR ($statusid == 1))
				{
					if($count38 > 0)
					{
						echo '<a href="' . '../Sales/installquote.php?f_id='.$f_id.'&id='.$row38['ID'].'&action=UPDATESCH">' . 'Update Schedule'. '</a>';
					}else
					{
						if($proj == 1)
						{
							echo '<a href="' . '../Sales/installquote.php?f_id='.$f_id.'&callnumber='.$callid.'&view=schedule&service=service">' . 'Schedule'. '</a>';
						}
					}
				}
?>											
				</td>
			</tr>
<?php
		}
?>					
		<tr>
			<td align = "center" colspan = "3"><font face = "Arial" size = 5"><b>
				SCOPE OF SERVICE CALL
			</td>
		</tr>
	</table>
	<table width = "750" align = "center" border = "0">
		<tr>
			<td>
				<table width = "350" align = "left">	
					<tr>
						<td colspan = "2"><font face = "Arial" size = 3"><b>
							<?php echo $row1['FacilityName']; ?>
						</font></td>
					</tr>			
					<tr>
						<td><font face = "Arial" size = 2">
							<?php echo $row1['StreetAddress']; ?>
						</td>
					</tr>
					<tr>
						<td><font face = "Arial" size = 2">
							<?php echo $row1['City'].', '.$row1['StateOrProvinceCode'].' '.$row1['PostalCode']; ?>
						</td>
					</tr>
					<tr>
						<td><font face = "Arial" size = 2">
							<?php echo 'Phone: '.formatphone($row1['PhoneNumber']).', Fax: '.formatphone($row1['FaxNumber']); ?>
						</td>
					</tr>		
				</table>
				<table width = "250" align = "right">	
					<tr>
						<td>
							<br>
						</td>
					</tr>
					<tr>
						<td><font face = "Arial" size = "2">
							Print Date: <?php echo $currentdate; ?>	
						</td>
					</tr>
					<tr>
						<td>
							Status: <?php echo $row7['Status']; ?>
						</td>
					</tr>	
					<tr>
						<td>
<?php
							if($statusid == 6)
							{			
								$query36 = "SELECT startDate,endDate FROM epc_calendar WHERE serviceid = '$callid'";
								$result36 = mysql_query($query36) or die (mysql_error());
								$row36 = mysql_fetch_array($result36);
								$startdate = date('m-d-Y',$row36['startDate']);
								$enddate = date('m-d-Y',$row36['endDate']);
								echo $startdate.' thru '.$enddate;						
							}elseif($statusid == 3)
							{
								$query37 = "SELECT comptime FROM epc_calendar WHERE serviceid = '$callid'";
								$result37 = mysql_query($query37) or die (mysql_error());
								$row37 = mysql_fetch_array($result37);
								echo 'Completed:'.$row37['comptime'];	
							}
?>						
						</td>
					</tr>					
				</table>
			</td>
		</tr>
	</table>
	<FIELDSET>
	<table width = "750" border = "0" cellpadding = "2" Border = "0">
		<tr>
			<td colspan="3"><font face = "Arial" size = "3">
				Details:
			</td>
		</tr>
		<tr>
			<td width = "20">
			</td>
			<td width = "170"><font face = "Arial" size = "2">
				Reason For Service Call:
			</td>
			<td width = "350"><font face = "Arial" size = "2">
				<?php echo $row4['Reason']; ?>
			</td>
		</tr>
<?php
		if($row4['Type'] == 1)
		{
			if($row13['pagebase'] <> "No Swap Just Test")
			{
?>			
				<tr>
					<td width = "20">
					</td>
					<td><font face = "Arial" size = "2">
						Requested Action:
					</td>		
					<td colspan = "2"><font face = "Arial" size = "2">
						1. Swap Current Paging base with <?php echo $row13['pagebase']; ?>
					</font></td>
				</tr>			
<?php
			}else
			{
?>
						<td colspan = "2"><font face = "Arial" size = "2">
							1. Test Current Paging Base
						</font></td>
					</tr>
<?php	
			}	
			if($row13['pagers'] <> "No Swap Just Test")
			{
?>					
				<tr>
						<td colspan = "2">
						</td>
					<td colspan = "2"><font face = "Arial" size = "2">
						2. Swap Current Pagers <?php echo $row13['pagers']; ?>
					</font></td>
				</tr>			
<?php
			}else
			{
?>
					<tr>
						<td colspan = "2">
						</td>
						<td colspan = "2"><font face = "Arial" size = "2">
							2. Test Current Pagers
						</font></td>
					</tr>			
<?php		
			}	
			if($row13['antenna'] <> "No Swap Just Test")
			{
?>					
				<tr>
						<td colspan = "2">
						</td>
					<td colspan = "2"><font face = "Arial" size = "2">
						3. Swap Current Antenna <?php echo $row13['antenna']; ?>
					</font></td>
				</tr>			
<?php
			}else
			{
?>
					<tr>
						<td colspan = "2">
						</td>
						<td colspan = "2"><font face = "Arial" size = "2">
							3. Test Current Antenna
						</font></td>
					</tr>			
<?php				
			}
?>
			<tr>
				<td colspan = "2">
				</td>
				<td colspan="2"><font face = "Arial" size = "2">
					4. Ensure Frequency is set to <?php echo $row13['frequency']; ?>
				</font></td>
			</tr>			
<?php
			}
			if($row4['Type'] == 2)
			{
				$query30 = "SELECT * FROM tbldoorissues WHERE CallNumber = '$callid'";
				$result30 = mysql_query($query30) or die (mysql_error());
				$row30 = mysql_fetch_array($result30);
?>
				<tr>
					<td width = "20">
					</td>					
					<td colspan = "2"><font face = "Arial" size = "2">
						Number of doors that need attention are <?php echo $row13['numberdoors']; ?>
					</font></td>
				</tr>				
<?php
				if($row13['falsealarm'] <> "NO")
				{
					$query31 = "SELECT * FROM tbldoorissues WHERE Issue = 'False' AND CallNumber = '$callid'";
					$result31 = mysql_query($query31) or die (mysql_error());
					$row31 = mysql_fetch_array($result31);
?>
					<tr>
						<td width = "20">
						</td>						
						<td valign = "top" colspan = "2"><font face = "Arial" size = "2">
							The door names that are having false alarm issues are
							<UL><?php echo nl2br($row31['Description']); ?></UL>
						</font></td>						
					</tr>
<?php
				}
				if($row13['noalarm'] <> "NO")
				{
					$query32 = "SELECT * FROM tbldoorissues WHERE Issue = 'No Alarm' AND CallNumber = '$callid'";
					$result32 = mysql_query($query32) or die (mysql_error());
					$row32 = mysql_fetch_array($result32);					
?>
					<tr>
						<td width = "20">
						</td>						
						<td valign = "top" colspan = "2"><font face = "Arial" size = "2">
							The door names that are not alarming are
							<UL><?php echo nl2br($row32['Description']); ?></UL>
						</font></td>						
					</tr>
<?php
				}	
				if($row13['ialarm'] <> "NO")
				{
					$query33 = "SELECT * FROM tbldoorissues WHERE Issue = 'Inconsistent Alarm' AND CallNumber = '$callid'";
					$result33 = mysql_query($query33) or die (mysql_error());
					$row33 = mysql_fetch_array($result33);					
?>
					<tr>
						<td width = "20">
						</td>						
						<td valign = "top" colspan = "2"><font face = "Arial" size = "2">
							The door names that are inconsistently alarming are
							<UL><?php echo nl2br($row33['Description']); ?></UL>
						</font></td>						
					</tr>
<?php
				}	
			}
			if($row4['Type'] == 3)
			{
?>
				<tr>
					<td width = "20">
					</td>
					<td><font face = "Arial" size = "2">
						Computer Type: <?php echo $row13['PCtype']; ?>
					</td>		
				</tr>			
				<tr>
					<td width = "20">
					</td>
					<td colspan = "2"><font face = "Arial" size = "2">
						Error(s): 
<?php
						if($row13['Boot'] <> "NO" OR $row13['Dumps'] <> "NO" OR $row13['Performance'] <> "NO")
						{
						if($row13['Boot'] <> "NO")
							{
								echo $row13['Boot'];
								if(($row13['Dumps'] <> "NO") OR ($row13['Performance'] <> "NO"))
								{
									echo ', ';
								}
							} 
							if($row13['Dumps'] <> "NO")
							{
								echo $row13['Dumps'];
								if($row13['Performance'] <> "NO")
								{
								echo ', ';
								}
							}
							if($row13['Performance'] <> "NO")
							{
								echo $row13['Performance'];
							}
						}else
						{
?>
							None selected
<?php
						}
?>				
					</td>		
				</tr>					
<?php
			}			
?>
		<tr>
			<td width = "20">
			</td>			
			<td valign = "top" width = "170"><font face = "Arial" size = "2">
				Job Overview:
			</font></td>
			<td><font face = "Arial" size = "2">
				<?php echo nl2br($row3['Description']); ?>
			</td>
		</tr>		
	</table>
	</FIELDSET>
<?php
	if($count2 > 0)
	{
?>
		<FIELDSET>
		<table width = "750" align = "center" border = "0" cellpadding = "4">
			<tr>
				<td><font face = "Arial" size = "3">
					Existing Equipment Summary:
				</td>
			</tr>
			<tr>
				<td>
					<table width ="175" border = "0" align="left" cellpadding = "2">
						<tr>
							<td colspan = "2"><font face = "Arial" size = "2"><u>
								Wireless Infastructure
							</font></u></td>
						</tr>
						<tr>
							<td width = "120"><font face = "Arial" size = "2">
								Base Units:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalWMBU']; ?>
							</td>
						</tr>
						<tr>
							<td width = "120"><font face = "Arial" size = "2">
								Area Units (WMU's):
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalWMUs']; ?>
							</td>
						</tr>
						<tr>								
							<td width = "120"><font face = "Arial" size = "2">
								Outdoor Area Units:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalOutWMU']; ?>
							</td>
						</tr>
						<tr>								
							<td width = "120"><font face = "Arial" size = "2">
								Door Units:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalWMDU']; ?>
							</td>
						</tr>
						<tr>								
							<td width = "120"><font face = "Arial" size = "2">
								Outdoor Door Units:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalOutWMDU']; ?>
							</td>
						</tr>						
					</table>
					<table width ="150" border = "0" cellpadding = "2" align = "left">
						<tr>
							<td colspan = "2"><font face = "Arial" size = "2"><u>
								Transmitters
							</font></u></td>
						</tr>
						<tr>
							<td width = "90"><font face = "Arial" size = "2">
								Watches:
							</dd></td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalWatches']; ?>
							</td>
						</tr>
						<tr>
							<td width = "90"><font face = "Arial" size = "2">
								Call Buttons:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalPanicButtons']; ?>
							</td>
						</tr>
						<tr>								
							<td width = "90"><font face = "Arial" size = "2">
								Staff Assist:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalPullTags']; ?>
							</td>
						</tr>
						<tr>
							<td width = "90"><font face = "Arial" size = "2">
								Pull Cords:
							</dd></td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalPullCords']; ?>
							</td>
						</tr>
						<tr>
							<td width = "90"><font face = "Arial" size = "2">
								Aware Units:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalFallUnits']; ?>
							</td>
						</tr>
						<tr>								
							<td width = "90"><font face = "Arial" size = "2">
								UTs:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['UTs']; ?>
							</td>
						</tr>						
					</table>
					<table width ="220" border = "0" align="left" cellpadding = "2">
						<tr>
							<td colspan = "2"><font face = "Arial" size = "2"><u>
								Integrated Hardware
							</font></u></td>
						</tr>
						<tr>
							<td width = "90"><font face = "Arial" size = "2">
								PC Stations:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalClientStations']; ?>
							</td>
						</tr>
						<tr>
							<td width = "90"><font face = "Arial" size = "2">
								Paging Base:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['pageBase']; ?>
							</td>
						</tr>
						<tr>								
							<td width = "90"><font face = "Arial" size = "2">
								Pager Count:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['PagerQuantity']; ?>
							</td>
						</tr>
						<tr>								
							<td width = "90"><font face = "Arial" size = "2">
								Pager Type:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['pagerType']; ?>
							</td>
						</tr>
					</table>
					<table width ="175" border = "0" align="left" cellpadding = "2">
						<tr>
							<td colspan = "2"><font face = "Arial" size = "2"><u>
								Misc. Hardware
							</font></u></td>
						</tr>
						<tr>
							<td width = "120"><font face = "Arial" size = "2">
								Central Power:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalCPS']; ?>
							</td>
						</tr>
						<tr>
							<td width = "120"><font face = "Arial" size = "2">
								Corridor Light:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalHFCorridorLights']; ?>
							</td>
						</tr>
						<tr>								
							<td width = "120"><font face = "Arial" size = "2">
								Call Cords:
							</td>
							<td><font face = "Arial" size = "2">
								<?php echo $row2['TotalCallCords']; ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</FIELDSET>
<?php		
	}
}
if((isset($_GET['issue'])) && ($_GET['issue'] == "paging"))
{
	$cust_num	= $_GET['custnumber'];
	$callnumber = $_GET['callnumber'];
	mysql_select_db('testhomefree');
	$query10 = "SELECT * FROM warrantyinfo WHERE FacilityID = '$cust_num'";
	$result10 = mysql_query($query10) or die (mysql_error());		
	$row10 = mysql_fetch_array($result10);
	$query11 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$cust_num'";
	$result11 = mysql_query($query11) or die (mysql_error());		
	$row11 = mysql_fetch_array($result11);	
?>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width ="500" border = "0" cellpadding = "2">
	<tr>
		<td><font face = "Arial" size = "3"><b>
			Paging issues
		</b></td>
	</tr>
	<tr>
		<td><u>
			Current Paging Transmitter
		</u></td>
		<td><u>
			Current Type of Pagers
		</u></td>			
	</tr>		
	<tr>
		<td>
			<?php echo $row10['pageBase']; ?>
		</td>
		<td>
			<?php echo $row10['pagerType']; ?>
		</td>			
	</tr>
	<tr>
		<td colspan = "3">
			<div align="center"><hr width="100%">
		</div></td>
	</tr>		
	<tr>
 		<td>
			<font face="Arial" size="2">Swap Paging Base with? </font>
		</td>
		<td>
		<select name="pageBase">
			<option value="No Swap Just Test">No Swap Just Test</option>
			<option value="Commtech 5W">Commtech 5W</option>
			<option value="Commtech 25W">Commtech 25W</option>
			<option value="Commtech 50W">Commtech 50W</option>
			<option value="Commtech 100W">Commtech 100W</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Arial" size="2">Swap Pager Type? </font>
		</td>
		<td>
		<select name="pagerType">
			<option value="No Swap Just Test">No Swap Just Test</option>
			<option value="Commtech 7900">Commtech 7900</option>
			<option value="Apollo Gold">Apollo Gold</option>
		</select>							
		</td>
	</tr>		
	<tr>
		<td><font face="Arial" size="2">
			Frequency? (Default = 457.575)
		</font></td>
		<td><font face="Arial" size="2">
			<input type="text" size="10" maxlength="10" name="freq" value = "<?php echo $row11['pagingFrequency']; ?>">
		</font></td>
	</tr>
	<tr>
		<td colspan = "2">
			If no Frequency, please enter correct frequency.
		</td>
	</tr>
	<tr>
		<td><font face="Arial" size="2">
			Swap Antenna?
		</font></td>
		<td>
		<select name="antenna">
			<option value="No Swap Just Test">No Swap Just Test</option>
			<option value="Mopole">Mopole</option>
			<option value="Dipole">Dipole</option>
		</td>
	</tr>		
<?php
echo	'<input type = "hidden" name="callref" value = "'.$callnumber.'">';
echo	'<input type = "hidden" name="custref" value = "'.$cust_num.'">';	
?>
	<tr>
		<td>
			<input type="submit" value="Save" name="pagingissuesave">
		</td>
	</tr>
</table>
</form>
<?php			
}
if(isset($_GET['pagingissuesave']))
{
	$callnumber = $_GET['callref'];
	$custnumber = $_GET['custref'];
	$base = $_GET['pageBase'];
	$pagers = $_GET['pagerType'];
	$freq = $_GET['freq'];
	$antenna = $_GET['antenna'];
	$query12 = "INSERT INTO tblissuesummary (CallNumber,pagebase,pagers,antenna,frequency) VALUES ('$callnumber','$base','$pagers','$antenna','$freq')";
	mysql_query($query12) or die(mysql_error());
	header("Location: servicecall.php?view=finished&custnumber=$custnumber&callnumber=$callnumber");
}
if((isset($_GET['issue'])) && ($_GET['issue'] == "doorunit") && (!isset($_GET['doorissuesave'])))
{
	$cust_num	= $_GET['custnumber'];
	$callnumber = $_GET['callnumber'];
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width ="500" border = "0" cellpadding = "2">
			<tr>
				<td><font face = "Arial" size = "3"><b>
					Door Unit Issues
				</b></font></td>
			</tr>
			<tr>
				<td>
					Number of Doors that need attention?
				</td>
				<td>
					<input type="text" size="5" maxlength="5" name="numdoors">
				</td>
			</tr>
			<tr>
				<td>
					False Alarms?
				</td>
				<td>
					<select name="false">
						<option value ="NO">NO</option>
						<option value ="False Alarms">YES</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Not Alarming?
				</td>
				<td>
					<select name="noalarm">
						<option value ="NO">NO</option>
						<option value ="Not Alarming">YES</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Inconsistent Alarming?
				</td>
				<td>
					<select name="ialarm">
						<option value ="NO">NO</option>
						<option value ="Inconsistent Alarm">YES</option>
					</select>
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="callref" value = "'.$callnumber.'">';
			echo	'<input type = "hidden" name="custref" value = "'.$cust_num.'">';	
			echo	'<input type = "hidden" name="issue" value = "door">';	
?>			
			<tr>
				<td>
					<input type="submit" value="Save" name="doorissuesave">
				</td>
			</tr>
		</table>
	</form>
<?php	
}
if((isset($_GET['issue'])) && ($_GET['issue'] == "door") && (!isset($_GET['doorissuesave'])))
{
	mysql_select_db('testwork');
	$callnumber = $_GET['callnumber'];
	$custnumber = $_GET['custnumber'];
	$query23 = "SELECT numberdoors,falsealarm,noalarm,ialarm FROM tblissuesummary WHERE Callnumber ='$callnumber'";
	$result23 = mysql_query($query23) or die(mysql_error());
	$row23 = mysql_fetch_array($result23);
	$query24 = "SELECT * FROM tbldoorissues WHERE CallNumber = '$callnumber' AND Issue = 'False'";
	$result24 = mysql_query($query24) or die(mysql_error());
	$count24 = mysql_num_rows($result24);
	$query26 = "SELECT * FROM tbldoorissues WHERE CallNumber = '$callnumber' AND Issue = 'No Alarm'";
	$result26 = mysql_query($query26) or die(mysql_error());
	$count26 = mysql_num_rows($result26);	
	$query28 = "SELECT * FROM tbldoorissues WHERE CallNumber = '$callnumber' AND Issue = 'Inconsistent Alarm'";
	$result28 = mysql_query($query28) or die(mysql_error());
	$count28 = mysql_num_rows($result28);		
	if(($row23['falsealarm'] <> "NO") && ($count24 < 1))
	{				
?>			
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>"	
			<table width ="750" border = "0" cellpadding = "2">
				<tr>
					<td>
						Please enter the door names of the doors that are causing false alarms.
					</td>
				</tr>
				<tr>
					<td>
						<textarea rows="6" cols="70" name="false"></textarea>
					</td>
				</tr>	
				<tr>
					<td>
						<input type="submit" value="Save" name="falsesave">
					</td>
				</tr>
			</table>	
<?php			
		echo	'<input type = "hidden" name="callnumber" value = "'.$callnumber.'">';
		echo	'<input type = "hidden" name="custnumber" value = "'.$custnumber.'">';		
		echo	'<input type = "hidden" name="issue" value = "door">';	
?>
		</form>				
<?php		
	}
	if((($row23['noalarm'] <> "NO") && ($count26 < 1)) && (($row23['falsealarm'] == "NO") OR ($count24 > 0))) 
	{			
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>"	
			<table width ="750" border = "0" cellpadding = "2">
				<tr>
					<td>
						Please enter the door names of the doors that are not alarming when they are supposed to.
					</td>
				</tr>
				<tr>
					<td>
						<textarea rows="6" cols="70" name="noalarm"></textarea>
				</td>
				</tr>	
				<tr>
					<td>
						<input type="submit" value="Save" name="noalarmsave">
					</td>
				</tr>					
			</table>
<?php
		echo	'<input type = "hidden" name="callnumber" value = "'.$callnumber.'">';
		echo	'<input type = "hidden" name="custnumber" value = "'.$custnumber.'">';		
		echo	'<input type = "hidden" name="issue" value = "door">';	
?>
		</form>
<?php
	}
	if((($row23['ialarm'] <> "NO") && ($count28 < 1)) && (($row23['falsealarm'] == "NO") OR ($count24 > 0)) && (($row23['noalarm'] == "NO") OR ($count26 > 0)))
	{			
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>"	
			<table width ="750" border = "0" cellpadding = "2">
				<tr>
					<td>
						Please enter the door names of the doors that are not alarming inconsistently.
					</td>
				</tr>
				<tr>
					<td>
						<textarea rows="6" cols="70" name="ialarm"></textarea>
				</td>
				</tr>	
				<tr>
					<td>
						<input type="submit" value="Save" name="ialarmsave">
					</td>
				</tr>					
			</table>
<?php
		echo	'<input type = "hidden" name="callnumber" value = "'.$callnumber.'">';
		echo	'<input type = "hidden" name="custnumber" value = "'.$custnumber.'">';		
		echo	'<input type = "hidden" name="issue" value = "door">';	
?>
		</form>
<?php
	}		
	if(($row23['falsealarm'] == "NO") OR ($count24 > 0))	
	{
		if(($row23['noalarm'] == "NO") OR ($count26 > 0))
		{
			if(($row23['ialarm'] == "NO") OR ($count28 > 0))
			{
				$callnumber = $_GET['callnumber'];
				$custnumber = $_GET['custnumber'];
?>
				<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>"	
<?php
				echo	'<input type = "hidden" name="callnumber" value = "'.$callnumber.'">';
				echo	'<input type = "hidden" name="custnumber" value = "'.$custnumber.'">';		
?>
					<table width ="750" border = "0" cellpadding = "2">
						<tr>
							<td>
								Your updates have been saved. Click continue to finish.
							</td>
						</tr>						
						<tr>
							<td>
<?php								
								echo  '<a href="' . 'servicecall.php'.'?view=finished&callnumber='.$callnumber.'&custnumber='.$custnumber.'">'.  'Continue'. '</a>';
?>

							</td>
						</tr>
					</table>
				</form>
<?php					
				}
			}
		}	
}	
if((isset($_GET['issue'])) && ($_GET['issue'] == "computer") && (!isset($_GET['computerissuesave'])))
{
	$cust_num	= $_GET['custnumber'];
	$callnumber = $_GET['callnumber'];
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width ="500" border = "0" cellpadding = "2">
			<tr>
				<td><font face = "Arial" size = "3"><b>
					Computer Issues
				</b></font></td>
			</tr>
			<tr>
				<td>
					Type of Computer
				</td>
				<td>
					<select name=pctype>
						<option value = "Server">Server</option>
  					<option value = "Client">Client</option>
  				</select
				</td>
			</tr>
			<tr>
				<td>
					Boot Errors?
				</td>
				<td>
					<select name="boot">
						<option value ="NO">NO</option>
						<option value ="Boot Errors">YES</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Memory Dumps?
				</td>
				<td>
					<select name="dumps">
						<option value ="NO">NO</option>
						<option value ="Memory Dumps">YES</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Not Performing Well?
				</td>
				<td>
					<select name="performance">
						<option value ="NO">NO</option>
						<option value ="Not Performing">YES</option>
					</select>
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="callref" value = "'.$callnumber.'">';
			echo	'<input type = "hidden" name="custref" value = "'.$cust_num.'">';	
			echo	'<input type = "hidden" name="issue" value = "computer">';	
?>
			<tr>
				<td>
					<input type="submit" value="Save" name="computerissuesave">
				</td>
			</tr>
		</table>
	</form>
<?php
}
if(isset($_GET['getequip']))
{
	mysql_select_db('testwork');
	$f_id = $_GET['f_id'];
	$query19 = "SELECT ID FROM tblfacilitygeneralinfo WHERE Cust_Num = '$f_id'";
	$result19 = mysql_query($query19) or die(mysql_error());
	$row19 = mysql_fetch_array($result19);
	$cus_id = $row19['ID'];
	$query21 = "SELECT FacilityID FROM tblfacilitydoors WHERE FacilityID = '$cus_id'";
	$result21 = mysql_query($query21) or die(mysql_error());
	$count21 = mysql_num_rows($result21);
	$query17 = "SELECT SUM(doorunitcount) FROM tblfacilitydoors WHERE FacilityID='$cus_id'"; 
	$result17 = mysql_query($query17) or die(mysql_error());
	$row17 = mysql_fetch_array($result17);
	$query15 = "SELECT SUM(outdoordoorunitCount) FROM tblfacilitydoors WHERE FacilityID='$cus_id'";	
	$result15 = mysql_query($query15) or die(mysql_error());
	$row15 = mysql_fetch_array($result15);
	$query16 = "SELECT SUM(utcount) FROM tblfacilitydoors WHERE FacilityID='$cus_id'"; 
	$result16 = mysql_query($query16) or die(mysql_error());
	$row16 = mysql_fetch_array($result16);
	$query18 = "SELECT * FROM tbltotalequipment WHERE FacilityID = '$cus_id'";
	$result18 = mysql_query($query18) or die(mysql_error());
	$row18 = mysql_fetch_array($result18);	
	$ut = $row16['SUM(utcount)'];
	$utx = $row18['UTs'];	
	$malepws = $row18['TotalWatches'];
	$femalepws = $row18['FemalePW'];
	$lesspws = $row18['straplessPW'];	
	$pullcords = $row18['TotalPullCords'];
	$apullcords = $row18['TotalPullCordsactivity'];
	$t10ft = $row18['TotalCallCords'];
	$t15ft = $row18['TotalCallCordssingle15'];
	$dual = $row18['TotalCallCorddual'];
	$squeeze = $row18['Squeezeball'];
	$breath = $row18['breathcall'];
	$cexlight = $row18['TotalExistingCorrdiorLights'];
	$chflight = $row18['TotalHomeFreeCorrdiorLights'];
	if(($count21 > 0) OR ($row17['SUM(doorunitcount)']) + ($row15['SUM(outdoordoorunitCount)'] > 0))
	{
		$wmdu = $row17['SUM(doorunitcount)'];
		$owmdu = $row15['SUM(outdoordoorunitCount)'];
	}else
	{
		$wmdu = 0;
		$owmdu = 0;
	}
	$wmu = $row18['TotalWMUs'];
	if(is_int($wmu))
	{
		$wmu = $_GET['TotalWMUs'];
	}else
	{
		$sowmu = 0;
	}		
	$owmu = $row18['TotalOutdoorAreaUnits'];
	if(is_int($owmu))
	{
		$owmu = $_GET['TotalOutdoorAreaUnits'];
	}else
	{
		$owmu = 0;
	}		
	$sowmu = $row18['TotalOutdoorSolarUnits']; 
	if(is_int($sowmu))
	{
		$sowmu = $_GET['TotalOutdoorSolarUnits'];
	}else
	{
		$sowmu = 0;
	}	
	$callb = $row18['TotalPanicButtons'];
	if(is_int($callb))
	{
		$callb = $_GET['cbCount'];
	}else
	{
		$callb = 0;
	}		
	$pulltag = $row18['TotalPullTags'];
	if(is_int($pulltag))
	{
		$pulltag = $_GET['TotalPullTags'];
	}else
	{
		$pulltag = 0;
	}			
	$fdu = $row18['TotalFallUnits'];
	if(is_int($fdu))
	{
		$fdu = $_GET['TotalFallUnits'];
	}else
	{
		$fdu = 0;
	}			
	$pcs = $row18['TotalClientStations'];	 
	if(is_int($pcs))
	{
		$pcs = $_GET['TotalClientStations'];
	}else
	{
		$pcs = 0;
	}	
	$pagertype = $row18['PagerType'];	
	$pagerqty = $row18['PagerQuantity'];
	if(is_int($pagerqty))
	{
		$pagerqty = $_GET['PagerQuantity'];
	}else
	{
		$pagerqty = 0;
	}		
	$pagerbase = $row18['PagingBaseType'];
	$cps = $row18['TotalCentralPowerSupplies'];
	if(is_int($cps))
	{
		$cps = $_GET['TotalCentralPowerSupplies'];
	}else
	{
		$cps = 0;
	}		
	$sum = ($wmu+ $owmu + $sowmu); 
	$basesum = ($sum + $wmdu + $owmdu); 
	//echo $basesum; 
  if($basesum < 60)
  {
  	$base = ceil($basesum/ 60);
  }
  if($basesum  > 59) 
  {
  	$base = 1;
  }
	$totalpw = ($malepws + $femalepws + $lesspws);
	if(is_int($totalpw))
	{
		$totalpw = ($malepws + $femalepws + $lesspws);
	}else
	{
		$totalpw = 0;
	}		
	$totalut = ($ut + $utx);
	if(is_int($totalut))
	{
		$totalut = ($malepws + $femalepws + $lesspws);
	}else
	{
		$totalut = 0;
	}			
	$totalpc  = ($pullcords + $apullcords);
	if(is_int($totalpc))
	{
		$totalpc = ($pullcords + $apullcords);
	}else
	{
		$totalpc = 0;
	}	
	$totalcomp = ($pcs + 1);
	$totalcc = ($t10ft + $t15ft + $dual + $squeeze + $breath);
	if(is_int($totalcc))
	{
		$totalcc = ($t10ft + $t15ft + $dual + $squeeze + $breath);
	}else
	{
		$totalcc = 0;
	}		
	$totalcl = ($cexlight + $chflight);
	if(is_int($totalcl))
	{
		$totalcl = ($cexlight + $chflight);
	}else
	{
		$totalcl = 0;
	}			
	mysql_select_db('testhomefree');
	$query20 = "INSERT INTO warrantyinfo (FacilityID, Package, TotalWMBU, TotalWMUs, TotalWMDU, TotalOutWMDU, TotalWatches, TotalPanicButtons,
							TotalPullCords,	TotalCallCords, TotalCPS, TotalOutWMU, TotalHFCorridorLights, pageBase, PagerQuantity, pagerType, TotalFallUnits,
							UTs, TotalPullTags, TotalClientStations, StartDate, EndDate) VALUES ('$f_id',0,'$base','$wmu','$wmdu','$owmdu','$totalpw','$callb',
							'$totalpc','$totalcc','$cps','$owmu','$totalcl','$pagerbase','$pagerqty','$pagertype','$fdu','$totalut','$pulltag','$totalcomp',0,0)";
	mysql_query($query20) or die(mysql_error());	
	header("Location: servicecall.php?view=job&f_id=$f_id");						
}
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['update'])) && ($_GET['update'] == "equip"))
{
	mysql_select_db('testhomefree');
	$f_id = $_GET['f_id'];
	$callnum = $_GET['call'];
	$query2 = "SELECT * FROM warrantyinfo WHERE FacilityID = '$f_id'";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2);
?>
<form method="GET" NAME="example12" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table width = "750" align = "center" border = "0" cellpadding = "4">
		<tr>
			<td><font face = "Arial" size = "3">
				Existing Equipment Summary:
			</td>
		</tr>
		<tr>
			<td>
				<table width ="175" border = "0" align="left" cellpadding = "2">
					<tr>
						<td colspan = "2"><font face = "Arial" size = "2"><u>
							Wireless Infastructure
						</font></u></td>
					</tr>
					<tr>
						<td width = "120"><font face = "Arial" size = "2">
							Base Units:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="2" maxlength="2" name="wmbu" value="<?php echo $row2['TotalWMBU']; ?>">
						</td>
					</tr>
					<tr>
						<td width = "120"><font face = "Arial" size = "2">
							Area Units (WMU's):
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="wmu" value="<?php echo $row2['TotalWMUs']; ?>">
						</td>
					</tr>
					<tr>								
						<td width = "120"><font face = "Arial" size = "2">
							Outdoor Area Units:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="owmu" value="<?php echo $row2['TotalOutWMU']; ?>">
						</td>
					</tr>
					<tr>								
						<td width = "120"><font face = "Arial" size = "2">
							Door Units:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="wmdu" value="<?php echo $row2['TotalWMDU']; ?>">
						</td>
					</tr>
					<tr>								
						<td width = "120"><font face = "Arial" size = "2">
							Outdoor Door Units:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="owmdu" value="<?php echo $row2['TotalOutWMDU']; ?>">
						</td>
					</tr>						
				</table>
				<table width ="150" border = "0" cellpadding = "2" align = "left">
					<tr>
						<td colspan = "2"><font face = "Arial" size = "2"><u>
							Transmitters
						</font></u></td>
					</tr>
					<tr>
						<td width = "90"><font face = "Arial" size = "2">
							Watches:
						</dd></td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="pws" value="<?php echo $row2['TotalWatches']; ?>">
						</td>
					</tr>
					<tr>
						<td width = "90"><font face = "Arial" size = "2">
							Call Buttons:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="callb" value="<?php echo $row2['TotalPanicButtons']; ?>">
						</td>
					</tr>
					<tr>								
						<td width = "90"><font face = "Arial" size = "2">
							Staff Assist:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="pulltags" value="<?php echo $row2['TotalPullTags']; ?>">
						</td>
					</tr>
					<tr>
						<td width = "90"><font face = "Arial" size = "2">
							Pull Cords:
						</dd></td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="pullcords" value="<?php echo $row2['TotalPullCords']; ?>">
						</td>
					</tr>
					<tr>
						<td width = "90"><font face = "Arial" size = "2">
							Aware Units:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="fdus" value="<?php echo $row2['TotalFallUnits']; ?>">
						</td>
					</tr>
					<tr>								
						<td width = "90"><font face = "Arial" size = "2">
							UTs:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="uts" value="<?php echo $row2['UTs']; ?>">
						</td>
					</tr>						
				</table>
				<table width ="220" border = "0" align="left" cellpadding = "2">
					<tr>
						<td colspan = "2"><font face = "Arial" size = "2"><u>
							Integrated Hardware
						</font></u></td>
					</tr>
					<tr>
						<td width = "90"><font face = "Arial" size = "2">
							PC Stations:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="pcs" value="<?php echo $row2['TotalClientStations']; ?>">
						</td>
					</tr>
					<tr>
						<td width = "90"><font face = "Arial" size = "2">
							Paging Base:
						</td>
						<td><font face = "Arial" size = "2">
						<select name="pageBase">
							<option value="Commtech 5W" <?php if($row2['pageBase'] == "Commtech 5W"){ echo 'selected="selected"'; } ?>>Commtech 5W</option>
							<option value="Commtech 25W" <?php if($row2['pageBase'] == "Commtech 25W"){ echo 'selected="selected"'; } ?>>Commtech 25W</option>
							<option value="Commtech 50W" <?php if($row2['pageBase'] == "Commtech 50W"){ echo 'selected="selected"'; } ?>>Commtech 50W</option>
							<option value="Commtech 100W" <?php if($row2['pageBase'] == "Commtech 100W"){ echo 'selected="selected"'; } ?>>Commtech 100W</option>
							<option value="Scope" <?php if($row2['pageBase'] == "Scope"){ echo 'selected="selected"'; } ?>>Scope</option>
						</select>
						</td>
					</tr>
					<tr>								
						<td width = "90"><font face = "Arial" size = "2">
							Pager Count:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="pagerqty" value="<?php echo $row2['PagerQuantity']; ?>">
						</td>
					</tr>
					<tr>								
						<td width = "90"><font face = "Arial" size = "2">
							Pager Type:
						</td>
						<td><font face = "Arial" size = "2">
						<select name="pagertype">
							<option value="Commtech 7900" <?php if($row2['pagerType'] == "Commtech 7900"){ echo 'selected="selected"'; } ?>>Commtech 7900</option>
							<option value="Apollo Gold" <?php if($row2['pagerType'] == "Apollo Gold"){ echo 'selected="selected"'; } ?>>Apollo Gold</option>
						</select>
						</td>
					</tr>
				</table>
			<table width ="175" border = "0" align="left" cellpadding = "2">
					<tr>
						<td colspan = "2"><font face = "Arial" size = "2"><u>
							Misc. Hardware
						</font></u></td>
					</tr>
					<tr>
						<td width = "120"><font face = "Arial" size = "2">
							Central Power:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="cps" value="<?php echo $row2['TotalCPS']; ?>">
						</td>
					</tr>
					<tr>
						<td width = "120"><font face = "Arial" size = "2">
							Corridor Light:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="lights" value="<?php echo $row2['TotalHFCorridorLights']; ?>">
						</td>
					</tr>
					<tr>								
						<td width = "120"><font face = "Arial" size = "2">
							Call Cords:
						</td>
						<td><font face = "Arial" size = "2">
							<input type="text" size="4" maxlength="4" name="callcords" value="<?php echo $row2['TotalCallCords']; ?>">
						</td>
					</tr>					
				</table>
				<tr>
					<td>
						<input type="submit" value="Save Changes" name="equipmentsave">
					</td>
				</tr>
			</td>
		</tr>
	</table>
<?php
	echo	'<input type = "hidden" name="customernumber" value = "'.$f_id.'">';
	echo	'<input type = "hidden" name="callnum" value = "'.$callnum.'">';
?>	
</form>
<?php
}
if((isset($_GET['equipmentsave'])) && ($_GET['equipmentsave'] == "Save Changes"))
{
	$callnum = $_GET['callnum'];
	$customernumber = $_GET['customernumber'];
	$wmbuCount = $_GET['wmbu'];
	$wmuCount = $_GET['wmu'];
	$outwmuCount = $_GET['owmu'];
	$outwmduCount = $_GET['owmdu'];
	$wmduCount = $_GET['wmdu'];
	$pwCount = $_GET['pws'];
	$cbCount = $_GET['callb'];
	if(is_int($cbCount))
	{
		$cbCount = $_GET['cbCount'];
	}else
	{
		$cbCount = 0;
	}	
	$ptCount = $_GET['pulltags'];
	$pcCount = $_GET['pullcords'];
	$fduCount = $_GET['fdus'];
	$utCount = $_GET['uts'];
	$compCount = $_GET['pcs'];
	$pageBase = $_GET['pageBase'];
	$pageCount = $_GET['pagerqty'];
	$pagerType = $_GET['pagertype'];
	$cpsCount = $_GET['cps'];
	$lightCount = $_GET['lights'];
	$cordCount = $_GET['callcords'];
	mysql_select_db('testhomefree');
	$query35 = "UPDATE warrantyinfo SET TotalWMBU='$wmbuCount', TotalWMUs='$wmuCount',
							TotalWMDU='$wmduCount', TotalWatches='$pwCount', TotalPanicButtons='$cbCount',
							TotalPullCords='$pcCount', TotalCallCords='$cordCount', TotalCPS='$cpsCount',
							TotalOutWMU='$outwmuCount', TotalOutWMDU='$outwmduCount', TotalHFCorridorLights='$lightCount', pageBase='$pageBase',
							PagerQuantity='$pageCount', pagerType='$pagerType', TotalFallUnits='$fduCount',
							UTs='$utCount', TotalPullTags='$ptCount', TotalClientStations='$compCount'
							WHERE FacilityID = '$customernumber' LIMIT 1";
	$result35 = mysql_query($query35) or die(mysql_error());
?>
	<table width = "750" align = "center" border = "0" cellpadding = "4">
		<tr>
			<td>
				Your Changes have been saved!
			</td>
		</tr>
		<tr>
			<td>
<?php
				echo  '<a href="' . 'servicecall.php'.'?view=finished&callnumber='.$callnum.'&custnumber='.$customernumber.'">'.  'Continue'. '</a>';
?>
			</td>
		</tr>
	</table>		
<?php
}
include 'includes/closedb.php'; 
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>


