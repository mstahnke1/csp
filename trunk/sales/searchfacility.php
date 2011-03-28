<?php

include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
if((isset($_GET['action'])) && ($_GET['action'] == 'delete'))
{
	$id = $_GET['facilityid'];
	$fname = $_GET['fname'];
	$query = "UPDATE tblfacilitygeneralinfo SET Deleted = 1 WHERE ID = '$id'";
	mysql_query($query) or die(mysql_error());
	header("Location: searchfacility.php?Fname=$fname");
}
?>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table align ="center">
		<tr>
			<td>
				Facility Name:
			</td>
			<td>
				<input type="text" size="40" maxlength="60" name="Fname">
			</td>
			<td>
				<input type="submit">
			</td>
		</tr>
	</form>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<tr>
			<td>
				Group Name:
			</td>
			<td>
				<input type="text" size="40" maxlength="60" name="Gname">
			</td>
			<td>
				<input type="submit">
			</td>
		</tr>
	</table>
</form>
<?php
if(isset($_GET["Fname"]))
{
	$real_f_name = $_GET['Fname'];
	$f_name=addslashes($_GET["Fname"]);
	$query5 = "SELECT * FROM tblfacilitygeneralinfo WHERE FacilityName LIKE '%$f_name%' AND Deleted = 0 ORDER BY FacilityName";
	$result5 = mysql_query($query5) or die (mysql_error());
?>
	<table>
<?php	
	if(mysql_num_rows($result5) > 0)
	{
		while($row5 = mysql_fetch_array($result5))
		{
			$sign_off = $row5['Signed_Off'];
			$id = $row5['ID'];
			$cus_id = $row5['Cust_Num'];
			$qname = $row5['QuoteName'];
			if($qname == '0')
			{
				$qname = '';
			}
			$query18 = "SELECT Max(ID) FROM epc_calendar WHERE FacilityID = '$cus_id'";
			$result18 = mysql_query($query18) or die (mysql_error());
			$row18 = mysql_fetch_array($result18);
			$schedule_id = $row18['Max(ID)'];
			$query19 = "SELECT Status FROM epc_calendar WHERE ID = '$schedule_id'";
			$result19 = mysql_query($query19) or die (mysql_error());
			$row19 = mysql_fetch_array($result19);
			$active = '';
			if($sign_off == 1)
			{
				$active = 'Customer Signed Off - ';
			}
			if($row5['Activated'] == 1)
			{
				if($row19['Status']==3)
				{
					$active .= '[Install Completed]';
				}elseif($row19['Status']==4)
				{
					$active .= '[Install Canceled]';
				}elseif(($row19['Status']==6) OR ($row19['Status']==7))
				{
					$active .= '[Install Scheduled]';
				}
			}else
			{
				$active .= '';
			}
?>
			<tr>
				<td>
					<?php echo '<tr><td><font face="Arial" size="2"><a href="' . 'newfinishedpage.php?f_id='. $row5['ID'].'">'. $row5['FacilityName'] .' '.$qname.'</a>'. $active.  '</font></td><td><a href="searchfacility.php?action=delete&facilityid='.$id.'&fname='.$real_f_name.'"><img src="../images/delete-icon_Small.png" height="10" width"10"></a></td></tr>'; ?>
				</td>
			</tr>							
<?php
			unset($active);
		}
	}else
	{
		echo '<tr><td><font size="2" face="Arial"> NO RECORDS FOUND </td></tr>';
	}
}
?>
	</table>
<?php
if(isset($_GET["f_id"])&(!(isset($_GET["Fname"]))))
{
	$f_id=$_GET['f_id'] ;
	$query = "SELECT * From tblfacilitygeneralinfo WHERE ID='$f_id'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);	
	$sman = $row['Salesman'];
	if($row['QuoteName']<>'0')
	{
		$qname = $row['QuoteName'];
	}else
	{
		$qname = '';
	}
	$fname= stripslashes($row['FacilityName']);
	$conn7 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
  mysql_select_db('homefree');
	$query8 = "SELECT id, f_name, l_name FROM employees WHERE id = '$sman' ORDER BY l_name";
	$result8 = mysql_query($query8) or die (mysql_error());
	while($row8 = mysql_fetch_array($result8))
  {  					
	 	$salesman = $row8['f_name']. ' ' . $row8['l_name'];   									
	}
	mysql_close($conn7);	
?>
	<table align="center" width="500">
<?php
	echo '<tr>';                                                            
 	echo '<td align="center" td colspan="2"><font size="5" ><strong>' .$fname.' '.$qname. '</strong></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td align="center" td colspan="2"><font size="3"><strong>' . $row['StreetAddress'] . '</strong></td>';			
  echo '</tr>';	
  echo '<tr>';
  echo '</tr>';
  echo '<tr>';
  echo '</tr>';                                                           	
  echo '<tr>';
	echo '<td><font size="2" >' . 'Contanct Name:    ' . $row['ContactName'].'</td>';
	echo '<td ><font size="2">' . 'Phone Number:    ' . formatPhone($row['PhoneNumber']).'</td>';
	echo '<tr>';
	echo '<td><font size="2" >' . '2nd Number:    ' .  formatPhone($row['secondnumber']).'</td>';
	echo '<td><font size="2" >' . 'Email:    ' .$row['Email'].'</td>';
	echo '</tr>';
	echo'<tr>';
	echo '<td><font size="2" >' . 'System Type:    ' .$row['SystemType'].'</td>';
	echo '<td><font size="2" >' . 'Fax:    ' .  formatPhone($row['Fax']).'</td>';
	echo '</tr>';
	echo '<tr>';
 	echo '<td align="center"><font size="2" >' . 'Email:    ' . $row['Email'].'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td align="center" td colspan="2"><font size="2" >' . 'HomeFree Sales Representative:    ' . $salesman.'</td>';
	echo '</tr>'; 
 include 'includes/closedb.php'; 
?>
 </table>
 <table align="center" width="750">
 	<tr>
		<td align="center"> 	
 			<button onClick="window.location='newfinishedpage.php?f_id=<?php echo $f_id; ?>'">Continue</button>
 		</td>
 	</tr>
 </table>
 <?php
}
if(isset($_GET["Gname"]))
{
	$group = $_GET['Gname'];
	$query10 = "SELECT * FROM tblgroupquote WHERE GroupName LIKE '%$group%' ORDER BY GroupName";
	$result10 = mysql_query($query10) or die (mysql_error());
?>
	<table align="center" width="750">
<?php	
	if(mysql_num_rows($result10)>0)
	{
		while($row10 = mysql_fetch_array($result10))
		{
			echo '<tr><td><font face="Arial" size="2"><a href="' . $_SERVER['PHP_SELF'].'?g_id='. $row10['ID'].'">'. $row10['GroupName'] .'</a>'. ' </font></td></tr>';
		}
	}else
	{
		echo '<tr><td><font size="2" face="Arial"> NO RECORDS FOUND </td></tr>';
	}
?>
	</table>
<?php	
}	
if(isset($_GET['g_id']))
{
	$g_id = $_GET['g_id'];
	$query11 = "SELECT ID,Cust_Num,FacilityName,Activated,QuoteName,Signed_Off FROM tblfacilitygeneralinfo WHERE GroupID = '$g_id' AND Deleted = 0";
	$result11 = mysql_query($query11) or die (mysql_error());
	$a = 0;
	$b=0;
?>
	<table align="center" width="750">
		<tr>
			<td>
				Facilities in Group:
			</td>
		</tr>
<?php			
	while($row11 = mysql_fetch_array($result11))
	{
		$sign_off = $row11['Signed_Off'];
		$facilityid = $row11['Cust_Num'];
		$query18 = "SELECT Max(ID) FROM epc_calendar WHERE FacilityID = '$facilityid'";
		$result18 = mysql_query($query18) or die (mysql_error());
		$row18 = mysql_fetch_array($result18);
		$schedule_id = $row18['Max(ID)'];
		$query19 = "SELECT Status FROM epc_calendar WHERE ID = '$schedule_id'";
		$result19 = mysql_query($query19) or die (mysql_error());
		$row19 = mysql_fetch_array($result19);
		if($row11['QuoteName']<>'0')
		{
			$qname = $row11['QuoteName'];
		}else
		{
			$qname = '';
		}
		if($row11['Activated'] == 1)
		{
			if($row19['Status']==3)
			{
				$active .= '[Install Completed]';
				$a = 1;
			}elseif($row19['Status']==4)
			{
				$active .= '[Install Canceled]';
				$a = 1;
			}elseif(($row19['Status']==6) OR ($row19['Status']==7))
			{
				$active .= '[Install Scheduled]';
				$a = 1;
			}
		}else
		{
			$active = '';
			$a = 0;
		}
		if($sign_off == 1)
		{
				$active = 'Customer Signed Off - ';
		}		
?>
				<tr>
					<td>
						<?php echo '<tr><td><font face="Arial" size="2"><a href="' . 'newfinishedpage.php?f_id='. $row11['ID'].'">'. $row11['FacilityName'] .' '.$qname.'</a>'. ' '.$active.' </font></td></tr>'; ?>
					</td>
				</tr>							
<?php			
	}
?>
	<tr>
		<td>
			<?php echo '<a href="' . 'addcustomer.php'.'?groupid='.$g_id.'&view=choose_who_to_copy">'?>Add Quote to Group</a>
		</td>
	</tr>
</table>
<?php
}		
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>