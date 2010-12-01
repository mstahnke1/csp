<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
if((isset($_GET['by']))&&($_GET['by']=='hfq'))
{
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table align = "center" width = "750">
			<tr>
				<td width="200">
					Please enter the hfq number:
				</td>
				<td>
					HFQ<input type="text" size="6" maxlength="6" name="hfq" value="">
				</td>
			</tr>
		  <tr>
				<td>
					<input type="submit" value="Search" name="saveprice">
				</td>
			</tr>			
		</table>
	</form>
<?php
}
if((isset($_GET['saveprice'])) && ($_GET['saveprice'] == 'Search'))
{
	$hfq = $_GET['hfq'];
	$query = "SELECT FacilityID FROM tblinstallinfo WHERE hfq = '$hfq'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	$count = mysql_num_rows($result);
	if($count > 0)
	{
		$f_id = $row['FacilityID'];
		$query1 = "SELECT FacilityName from tblfacilitygeneralinfo WHERE ID = '$f_id'";
		$result1 = mysql_query($query1) or die (mysql_error());
		$row1 = mysql_fetch_array($result1);
?>
		<table align="center" width="750">	
			<tr>
				<td width="400">
					Facility: <?php echo $row1['FacilityName']; ?>
				</td>
				<td>
					<?php echo '<a href="'.'./installquote.php?f_id='. $row['FacilityID'].'&hfq='.$_GET['hfq'].'&savequote=Continue">'. $_GET['hfq'] .' </a>' ?>
				</td>
			</tr>
		</table>
<?php
	}else
	{
?>
		<table align="center" width="750">	
			<tr>
				<td width="200">
					No Results Found
				</td>
			</tr>
		</table>		
<?php		
	}
}
if((isset($_GET['by']))&&($_GET['by']=='facility'))
{
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td>
					Search For:
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Existing_Customers" name="value">
				</td>
				<td>
					<input type="submit" value="New_Customers" name="value">
				</td>
			</tr>		
		</table>
	</form>				
<?php	
}
if(isset($_GET['value']))
{
	$value = $_GET['value'];
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php		
	if(isset($_GET['page']))
	{
		if($_GET['page']=='ticket')
		{
			echo	'<input type = "hidden" name="page" value = "ticket">';
		}
		if($_GET['page']=='viewticket')
		{
			echo	'<input type = "hidden" name="page" value = "viewticket">';
		}
	}
?>			
		<table align = "center" width = "750">
			<tr>
				<td width="120">
					Facility Name:
				</td>
				<td>
					<input type="text" size="25" maxlength="25" name="fname" value="">
				</td>
			</tr>
		  <tr>
				<td>
					<input type="submit" value="Search" name="<?php echo $value; ?>">
				</td>
			</tr>			
		</table>
	</form>
<?php	
}
if((isset($_GET['New_Customers']))OR(isset($_GET['Existing_Customers'])))
{
	$fname = addslashes($_GET['fname']);
}
if((isset($_GET['New_Customers']))&&($_GET['New_Customers']=='Search'))
{
	$query2 = "SELECT * FROM tblfacilitygeneralinfo WHERE FacilityName LIKE '%$fname%' ORDER BY FacilityName";
	$result2 = mysql_query($query2) or die (mysql_error());
	$count2 = mysql_num_rows($result2);
	if((isset($_GET['ex'])) && ($_GET['ex']=='ex'))
	{
		$count2 = 0;
	}
	if($count2 > 0)
	{
?>
		<table>
			<tr>
				<td>
					Results:
				</td>
			</tr>				
<?php		
		$a=0;
		$b=0;
		while($row2 = mysql_fetch_array($result2))
		{
			mysql_select_db('homefree');
			$cust_num = $row2['Cust_Num'];
			if($row2['QuoteName']<>'0')
			{
				$qname = $row2['QuoteName'];
			}else
			{
				$qname = '';
			}				
			if($row2['Activated'] == 1)
			{
				$active = 'Active';
				$a = 1;
			}else
			{
				$active = 'Not Active';
				$a = 0;
			}
			if($a == 1)
			{
				$b = $a+1;
			}
			if($row2['GroupID'] == '-1')
			{
				$b = 0;
			}			
			$query3 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$cust_num'";
			$result3 = mysql_query($query3) or die (mysql_error());
			$count3 = mysql_num_rows($result3);
			//$count3 = 3;
			if((($count3 > 0) OR ($row2['GroupID']<>'-1')) && ($row2['Activated'] == 1))
			{	
				if((isset($_GET['page'])) && ($_GET['page']=='ticket'))
				{
					echo '<tr><td><font face="Arial" size="2"><a href="'.'installtickets.php?view=new&f_id='. $row2['Cust_Num'].'">'. $row2['FacilityName'] .$qname.'</a>'.' </font></td></tr>';
				}elseif((isset($_GET['page'])) && ($_GET['page']=='viewticket'))
				{
					echo '<tr><td><font face="Arial" size="2"><a href="'.'installtickets.php?view=lookup&f_id='. $row2['Cust_Num'].'">'. $row2['FacilityName'] .'['. $active.']'.$qname.'</a>'.' </font></td></tr>';
				}else					
				{
					if($b < 1)
					{
		?>
						<tr>
							<td>			
								<?php echo '<tr><td><font face="Arial" size="2"><a href="'.'installquote.php?view=schedule&f_id='. $row2['Cust_Num'].'">'. $row2['FacilityName'] .$qname.'</a>'.'['. $active.']'.' </font></td></tr>'; ?>
							</td>
						</tr>			
		<?php			
					}else
					{
						if($row2['Activated'] == 0)
						{
		?>
							<tr>
								<td>
									<?php echo $row2['FacilityName'].' ['. $active.']'.$qname; ?>
								</td>
							</tr>
		<?php
						}else
						{
		?>
							<tr>
								<td>
									<?php echo '<tr><td><font face="Arial" size="2"><a href="'.'installquote.php?view=schedule&f_id='. $row2['Cust_Num'].'">'. $row2['FacilityName'] .$qname.'</a>'.'['. $active.']'.' </font></td></tr>'; ?>
								</td>
							</tr>							
		<?php			
						}
					}					
				}
			}else
			{
				if((isset($_GET['page'])) && ($_GET['page']=='ticket'))
				{
					echo '<tr><td><font face="Arial" size="2"><a href="'.'installquote.php?view=addtohomefree&page=ticket&f_id='. $row2['ID'].'">'. $row2['FacilityName'] .'</a>'.' </font></td></tr>';
				}elseif((isset($_GET['page'])) && ($_GET['page']=='viewticket'))
				{
					echo '<tr><td><font face="Arial" size="2"><a href="'.'installquote.php?view=addtohomefree&page=viewticket&f_id='. $row2['ID'].'">'. $row2['FacilityName'] .'</a>'.' </font></td></tr>';
				}else
				{
					if($b > 0)
					{
?>
						<tr>
							<td>
								<?php echo $row2['FacilityName'].' '.' ['. $active.']'.$qname; ?>
							</td>
						</tr>
<?php
					}else
					{
						echo '<tr><td><font face="Arial" size="2"><a href="'.'installquote.php?view=addtohomefree&f_id='. $row2['ID'].'">'. $row2['FacilityName'].$qname .'</a>'.' ['. $active.']' .'</font></td></tr>';
					}
				}
			}
		}
		if((isset($_GET['page'])) && ($_GET['page']=='ticket'))
		{
?>
			<tr>
				<td>
					If you don't see the facility you are looking for <a href="installquotesearch.php?New_Customers=Search&page=ticket&ex=ex&fname=<?php echo $fname; ?>">click here</a>.
				</td>
			</tr>
<?php		
		}
	}else
	{
		echo '<tr><td><font size="2" face="Arial"> NO SCOPE of WORK for this CUSTOMER </td></tr>';
		if((isset($_GET['page'])) && ($_GET['page']=='ticket'))
		{
			mysql_select_db('homefree');
			$query9 = "SELECT * FROM tblfacilities WHERE FacilityName LIKE '%$fname%' ORDER BY FacilityName";
			$result9 = mysql_query($query9) or die (mysql_error());
			$count9 = mysql_num_rows($result9);
			if($count9 > 0)
			{
				while($row9 = mysql_fetch_array($result9))
				{
					echo '<tr><td><font face="Arial" size="2"><a href="'.'installtickets.php?view=new&f_id='. $row9['CustomerNumber'].'">'. $row9['FacilityName'] .'</a>'.' </font></td></tr>';
				}
			}
		}
	}
}
if((isset($_GET['Existing_Customers']))&&($_GET['Existing_Customers']=='Search'))
{
	mysql_select_db('homefree');
	$query2 = "SELECT * FROM tblfacilities WHERE FacilityName LIKE '%$fname%' ORDER BY FacilityName";
	$result2 = mysql_query($query2) or die (mysql_error());
	if(mysql_num_rows($result2)>0)
	{
?>
		<table>
			<tr>
				<td>
					Results:
				</td>
			</tr>
<?php								
		while($row2 = mysql_fetch_array($result2))
		{
			echo '<tr><td><font face="Arial" size="2"><a href="'.'installquote.php?view=schedule&f_id='. $row2['CustomerNumber'].'">'. $row2['FacilityName'] .'</a>'.'</font></td></tr>';

		}
	}else
	{
		echo '<tr><td><font size="2" face="Arial"> NO RECORDS FOUND </td></tr>';
	}
}
if((isset($_GET['reason']))&&($_GET['reason'] == 'history'))
{
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table align = "center" width = "750">
			<tr>
				<td width="120">
					History Of Acitve Customers:
				</td>
				<td>
					<input type="text" size="25" maxlength="25" name="hname" value="">
				</td>
			</tr>
		  <tr>
				<td>
					<input type="submit" value="Submit" name="history">
				</td>
			</tr>			
		</table>
	</form>				
<?php	
}
if((isset($_GET['history']))&&($_GET['history'] == 'Submit'))
{
	$hname = $_GET['hname'];
	mysql_select_db('homefree');
	$query4 = "SELECT * FROM tblfacilities WHERE FacilityName LIKE '%$hname%' ORDER BY FacilityName"; 
	$result4 = mysql_query($query4) or die (mysql_error());
	if(mysql_num_rows($result4) > 0)
	{
?>
		<table>
			<tr>
				<td>
					Results:
				</td>
			</tr>
<?php								
		while($row4 = mysql_fetch_array($result4))
		{
			echo '<tr><td><font face="Arial" size="2"><a href="'.'history.php?f_id='. $row4['CustomerNumber'].'">'. $row4['FacilityName'] .'</a> '.'</font></td></tr>';
		}		
	}else
	{
		echo '<tr><td><font size="2" face="Arial"> NO RECORDS FOUND </td></tr>';		
	}	
}