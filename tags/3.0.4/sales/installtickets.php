<link rel="stylesheet" type="text/css" href="sales.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HomeFree Install Tickets</title>
<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
$datetime = date('Y-m-d H:i:s');
mysql_select_db('testhomefree');
$mail = $_SESSION['mail'];
$q = "SELECT id,f_name,l_name,projmanage FROM employees WHERE email = '$mail'";
$rq = mysql_query($q) or die (mysql_error());
$r = mysql_fetch_array($rq);
$projaccess = $r['projmanage'];
if((isset($_GET['view'])) && ($_GET['view']=='new'))
{
	$f_id = $_GET['f_id'];
	$query = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result = mysql_query($query) or die (mysql_error());
	$count = mysql_num_rows($result);	
	if($count < 1)
	{
		mysql_select_db('testwork');
		$query = "SELECT * FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
		$result = mysql_query($query) or die (mysql_error());
	}
	$row = mysql_fetch_array($result);
	mysql_select_db('testwork');
	$query1 = "SELECT * FROM tbltype WHERE Page = 3";
	$result1 = mysql_query($query1) or die (mysql_error());
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table align="center">
			<tr>
				<td class="heading">
					Facility Name:
				</td>
				<td class="body">
					<?php echo $row['FacilityName'];?>
				</td>
			</tr>
			<tr>
				<td class="heading">
					Type:
				</td>
				<td>
					<select name="type">
<?php
					while($row1 = mysql_fetch_array($result1))					
					{
?>					
						<option value="<?php echo $row1['ID']; ?>"><?php echo $row1['Type']; ?></option>						
<?php	
					}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="heading" valign="top">
					Call Details:
				</td>
				<td>
					<textarea rows="2" cols="40" name="desc"></textarea>
				</td>
			</tr>
			<tr>
				<td class="heading">
					Contact Name:
				</td>
				<td>
					<input type="text" size="30" maxlength="40" name="cname" value="">
				</td>
			</tr>
			<tr>
				<td class="heading">
					Contact Number:
				</td>
				<td class="heading">
					<input type="text" size="10" maxlength="10" name="cnumber" value=""> Ext. <input type="text" size="4" maxlength="4" name="ext" value="">
				</td>
			</tr>		
			<tr>
				<td class="heading">
					Opened By:
				</td>
				<td>
					<?php echo $r['f_name'].' '.$r['l_name']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Open" name="openticket">
				</td>
			</tr>
		</table>
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>				
	</form>
<?php				
}
if((isset($_GET['openticket']))&&($_GET['openticket']=='Open'))
{
	$f_id = $_GET['f_id'];
	$type = $_GET['type'];
	$description = nl2br(addslashes($_GET['desc']));
	$name = $_GET['cname'];
	$number = $_GET['cnumber'];
	$ext = $_GET['ext'];
	$openedby = $r['id'];
	mysql_select_db('testwork');
	$query2 = "INSERT INTO tblinstalltickets (FacilityID,Type,Description,ContactName,ContactNumber,Extension,Date,Openedby) VALUES ('$f_id','$type',
						'$description','$name','$number','$ext','$datetime','$openedby')";
	mysql_query($query2) or die(mysql_error());	
	$max = "SELECT max(ID) FROM tblinstalltickets";
	$rmax = mysql_query($max) or die (mysql_error());
	$m = mysql_fetch_array($rmax);
	$ticketid = $m['max(ID)'];
	header("Location: installtickets.php?view=look&ticketid=$ticketid");
}
if((isset($_GET['view']))&&($_GET['view']=='look'))
{
	mysql_select_db('testwork');
	$ticketid = $_GET['ticketid'];
	$query3 = "SELECT * FROM tblinstalltickets WHERE ID = '$ticketid'";
	$result3 = mysql_query($query3) or die (mysql_error());
	$row3 = mysql_fetch_array($result3);
	$f_id = $row3['FacilityID'];
	$type = $row3['Type'];
	$disdate = strtotime($row3['Date']);
	$displaydate = date('m-d-Y H:i:s', $disdate);
	$employeeid = $row3['Openedby'];
	mysql_select_db('testhomefree');
	$query4 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result4 = mysql_query($query4) or die (mysql_error());
	$count4 = mysql_num_rows($result4);	
	if($count4 < 1)
	{
		mysql_select_db('testwork');
		$query4 = "SELECT * FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
		$result4 = mysql_query($query4) or die (mysql_error());
	}
	$row4 = mysql_fetch_array($result4); 
	mysql_select_db('testwork');
	$query5 = "SELECT * FROM tbltype WHERE ID = '$type'";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_fetch_array($result5); 
	mysql_select_db('testhomefree');
	$query6 = "SELECT id,f_name,l_name FROM employees WHERE id = '$employeeid'";
	$result6 = mysql_query($query6) or die (mysql_error());
	$row6 = mysql_fetch_array($result6); 	
?>	
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table align="center">
			<tr>
				<td colspan="3">
					<?php echo '<a href="' . 'installtickets.php'.'?f_id='.$f_id.'&view=lookup">'?>View Customer Install Tickets</a>
				</td>
			</tr>
			<tr>
				<td class="heading">
					Facility Name:
				</td>
				<td class="body">
					<?php echo $row4['FacilityName'];?>
				</td>
			</tr>
			<tr>
				<td class="heading">
					Type:
				</td>
				<td class="body">
					<?php echo $row5['Type']; ?>
				</td>
			</tr>
			<tr>
				<td class="heading" valign="top">
					Call Details:
				</td>
				<td class="body">
					<?php echo $row3['Description']; ?>
				</td>
			</tr>
			<tr>
				<td class="heading">
					Contact Name:
				</td>
				<td class="body">
					<?php echo $row3['ContactName']; ?>
				</td>
			</tr>
			<tr>
				<td class="heading">
					Contact Number:
				</td>
				<td class="body">
					<?php echo formatPhone($row3['ContactNumber']).' Ext: '.$row3['Extension'] ; ?>
				</td>
			</tr>		
			<tr>
				<td class="heading">
					Opened By:
				</td>
				<td>
					<?php echo $row6['f_name'].' '.$row6['l_name'].' @ '. $displaydate; ?>
				</td>
			</tr>
		</table>
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>				
	</form>
<?php
}				
if((isset($_GET['view']))&&($_GET['view']=='lookup'))
{
	$f_id = $_GET['f_id'];
	mysql_select_db('testwork');
	$query7 = "SELECT ID,Cust_Num,FacilityName FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
	$result7 = mysql_query($query7) or die (mysql_error());
	$count7 = mysql_num_rows($result7);
	if($count7 < 1)
	{
		mysql_select_db('testwork');
		$query7 = "SELECT ID,Cust_Num,FacilityName FROM tblfacilitygeneralinfo WHERE Cust_Num = '$f_id'";
		$result7 = mysql_query($query7) or die (mysql_error());
	}
	$row7 = mysql_fetch_array($result7);
?>
	<table width="750">
		<tr>
			<td colspan="2" align="center" class="bigheading">
				Install Tickets For <?php echo $row7['FacilityName']; ?>
			</td>
		</tr>
<?php
		if($projaccess = 1)
		{
?>					
			<tr>
				<td width = "105">
					<?php echo '<a href="' . 'installtickets.php'.'?f_id='.$f_id.'&view=new">'?>New Ticket</a>
				</td>
			</tr>
<?php
		}
?>					
		<tr>
			<td>
				<br>
			</td>
		</tr>
<?php	
	$id = $row7['ID'];
	$customer = $row7['Cust_Num'];
	$query8 = "SELECT * FROM tblinstalltickets WHERE FacilityID = '$id' OR FacilityID = '$customer'";
	$result8 = mysql_query($query8) or die (mysql_error());
	while($row8 = mysql_fetch_array($result8))
	{
		$disdate = strtotime($row8['Date']);
		$displaydate = date('m-d-Y H:i:s', $disdate);
		$employeeid = $row8['Openedby'];
		$type = $row8['Type'];
		mysql_select_db('testwork');
		$query9 = "SELECT * FROM tbltype WHERE ID = '$type'";
		$result9 = mysql_query($query9) or die (mysql_error());
		$row9 = mysql_fetch_array($result9); 
		mysql_select_db('testhomefree');
		$query10 = "SELECT id,f_name,l_name FROM employees WHERE id = '$employeeid'";
		$result10 = mysql_query($query10) or die (mysql_error());
		$row10 = mysql_fetch_array($result10); 	
?>
		<tr>
			<td class="mediumheading">
				Type:
			</td>
			<td class="body">
				<?php echo $row9['Type']; ?>
			</td>
		</tr>
		<tr>
			<td class="mediumheading" valign="top">
				Details:
			<td class="body">
				<?php echo $row8['Description']; ?>
			</td>
		</tr>
		<tr>
			<td class="mediumheading">
				Opened By:
			</td>
			<td class="body">
				<?php echo $row10['f_name'].' '.$row10['l_name']. ' @ '.$displaydate; ?>
			</td>
		</tr>	
		<tr>
			<td colspan="2"><div align="center"><hr width="100%"></div></td>
		</tr>				
<?php
	}
}
			