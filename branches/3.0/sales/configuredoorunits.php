<?php
if(isset($_GET['cancel']))
{
	header("Location: configurehome.php");
}
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
if((isset($_GET['view'])) && $_GET['view'] == "new")
{
$getid = "SELECT max(ID) FROM tbldooralarms";
$resgetid = mysql_query($getid) or die (mysql_error());
$id = mysql_fetch_array($resgetid);
$highid = $id['max(ID)'];
$newid = $highid + 1;
?>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width= "750">
	<tr>
		<td><b><font face = "Arial" size = 2">
			DoorID:
		</font></b></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="12" maxlength="10" name="doorid" value="door<?php echo $newid; ?>" READONLY>
		</font></td>
	</tr>
	<tr>
		<td><b><font face = "Arial" size = 2">
			Door Description:
		</font></b></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="75" maxlength="135" name="doordes">
		</font></td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			Door Units?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = doorunit>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
	<tr>
		<td><b><font face = "Arial" size = 2">
			Locks?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = locks>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
	<tr>
		<td><b><font face = "Arial" size = 2">
			Keypad?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = keypads>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			Universal Transmitter?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = ut>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			Timer?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = timer>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
	<tr>
		<td><b><font face = "Arial" size = 2">
			Relay?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = relay>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			PIR?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = pir>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
	<tr>
		<td><b><font face = "Arial" size = 2">
			Keypad Relay Extension?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = ext>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>			
	<tr>
		<td><b><font face = "Arial" size = 2">
			Buzzer?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = buzz>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
</table>
<table>	
	<tr>
 		<td align=center>
 			Door Function
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<textarea rows="12" cols="70" name="function"></textarea>
 		</td>
 	</tr>
 </table>
 <table>
 		<tr>
			<td>
				<input type="submit" value="DONE" name="done">
			</td>
			<td>
				<input type="submit" value="CANCEL" name="cancel">
			</td>
		</tr>
	</table>
	</form>
<?php
}
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (!isset($_GET['doordes'])))
{
?>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table cellpadding=2 table border ="1" width="750"  align ="center">
		<tr>
			<td colspan="1">
				Select the setup in which you would like to update.
			</td>
		</tr>
		<tr>
			<td><select name=doordes>
<?php			
				$getdooralarm = "SELECT AlarmID,AlarmFunction FROM tbldooralarms";
				$resgetdooralarm = mysql_query($getdooralarm) or die (mysql_error());
				while($dooralarmtype = mysql_fetch_array($resgetdooralarm))
				{
?>				
					<option value="<?php echo $dooralarmtype['AlarmID']; ?>"><?php echo $dooralarmtype['AlarmFunction']; ?></option>
<?php
				}
?>							
			</select></td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="CONTINUE" name="continue">
			</td>
			<td>
				<input type="submit" value="CANCEL" name="cancel">
			</td>			
		</tr>
	</table>
<?php
}
if(isset($_GET['continue']))
{
	$doordes = $_GET['doordes'];
	$SELECTDOOR = "SELECT * FROM tbldooralarms WHERE AlarmID = '$doordes'";
	$resSELECTDOOR = mysql_query($SELECTDOOR) or die (mysql_error());
	$alarm = mysql_fetch_array($resSELECTDOOR);
	$alarmid = $alarm['AlarmID'];
	$GETFUNCTION = "SELECT alarmfunction FROM tbldoorfunction WHERE AlarmID = '$doordes'";
	$resGETFUNCTION = mysql_query($GETFUNCTION) or die (mysql_error());
	$alarmfunction = mysql_fetch_array($resGETFUNCTION);		
	$doorunit = $alarm['DoorUnits'];
	$ext = $alarm['keypadext'];
	$buzz = $alarm['Buzzer'];
	if($doorunit == 1)
	{
		$dooru = "YES";
	}else
	{
		$dooru = "NO";
	}
	$locks = $alarm['locks'];
	if($locks == 1)
	{
		$lock = "YES";
	}else
	{
		$lock = "NO";
	}	
	$keypad = $alarm['keypads'];
		if($keypad == 1)
	{
		$key = "YES";
	}else
	{
		$key = "NO";
	}
	$universal = $alarm['ut'];
	if($universal == 1)
	{
		$ut1 = "YES";
	}else
	{
		$ut1 = "NO";
	}	
	$timer = $alarm['timer'];
	if($timer == 1)
	{
		$timer1 = "YES";
	}else
	{
		$timer1 = "NO";
	}	
	$relay = $alarm['relay'];
	if($relay == 1)
	{
		$relay1 = "YES";
	}else
	{
		$relay1 = "NO";
	}	
	$pir = $alarm['pir'];
	if($pir == 1)
	{
		$pir1 = "YES";
	}else
	{
		$pir1 = "NO";
	}	
	if($ext == 1)
	{
		$ext1 = "YES";
	}else
	{
		$ext1 = "NO";
	}
	if($buzz == 1)
	{
		$buzz1 = "YES";
	}else
	{
		$buzz1 = "NO";
	}	
?>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width= "750">
	<tr>
		<td><b><font face = "Arial" size = 2">
				DoorID:
		</font></b></td>
		<td><font face = "Arial" size = 2">
			<?php	echo '<input type = "hidden" name="doorid" value = "'.$alarmid.'">';	 ?>
			<?php echo $alarm['AlarmID']; ?>
		</font></td>
	</tr>
	<tr>
		<td><b><font face = "Arial" size = 2">
			Door Description:
		</font></b></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="75" maxlength="135" name="doordes" value="<?php echo $alarm['AlarmFunction']; ?>">
		</font></td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			Door Units? 
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = doorunit>
			<option value = "<?php echo $alarm['DoorUnits'];?>"><?php echo $dooru; ?>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
	<tr>
		<td><b><font face = "Arial" size = 2">
			Locks?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = locks>
			<option value = "<?php echo $alarm['locks'];?>"><?php echo $lock; ?>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
	<tr>
		<td><b><font face = "Arial" size = 2">
			Keypad?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = keypads>
			<option value = "<?php echo $alarm['keypads'];?>"><?php echo $key; ?>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			Universal Transmitter?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = ut>
			<option value = "<?php echo $alarm['ut'];?>"><?php echo $ut1; ?>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			Timer?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = timer>
			<option value = "<?php echo $alarm['timer'];?>"><?php echo $timer1; ?>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
	<tr>
		<td><b><font face = "Arial" size = 2">
			Relay?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = relay>
			<option value = "<?php echo $alarm['relay'];?>"><?php echo $relay1; ?>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			PIR?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = pir>
			<option value = "<?php echo $alarm['pir'];?>"><?php echo $pir1; ?>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>		
	<tr>
		<td><b><font face = "Arial" size = 2">
			Keypad Relay Extenstion?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = ext>
			<option value = "<?php echo $alarm['keypadext'];?>"><?php echo $ext1; ?>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>
	<tr>
		<td><b><font face = "Arial" size = 2">
			Buzzer?
		</font></b></td>
		<td><font face = "Arial" size = 2">
		<select name = buzz>
			<option value ="0">NO</option>
			<option value ="1">YES</option>
		</select>
		</font></td>
	</tr>						
</table>
<table>	
	<tr>
 		<td align=center>
 			Door Function
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<textarea rows="12" cols="70" name="function"><?php echo strip_tags($alarmfunction['alarmfunction']); ?></textarea>
 		</td>
 	</tr>
		<tr>
			<td>
				<input type="submit" value="SAVE" name="save">
			</td>
			<td>
				<input type="submit" value="CANCEL" name="cancel">
			</td>
		</tr> 	
</table>	
</form>
<?php
}
if((isset($_GET['done'])) || (isset($_GET['save'])))
{
	$function = nl2br(addslashes($_GET["function"]));
	$doorid = $_GET['doorid'];
	$des = $_GET['doordes'];	
	$doorunit = $_GET['doorunit'];
	$locks = $_GET['locks'];
	$keypads = $_GET['keypads'];
	$ut = $_GET['ut'];
	$timer = $_GET['timer'];
	$relay = $_GET['relay'];
	$pir = $_GET['pir'];
	$ext = $_GET['ext'];
	$buzz = $_GET['buzz'];
	if(isset($_GET['done']))
	{
		$insertalarm = "INSERT INTO tbldooralarms (AlarmID, AlarmFunction, DoorUnits, locks, keypads, ut, timer, relay, pir,keypadext) VALUES
									('$doorid','$des','$doorunit','$locks','$keypads','$ut','$timer','$relay','$pir','$ext')";
		mysql_query($insertalarm) or die(mysql_error());
		$query = "INSERT INTO tbldoorfunction (AlarmID, alarmfunction) VALUES  ('$doorid','$function')";
		mysql_query($query) or die(mysql_error());
	}
	if(isset($_GET['save']))
	{
		$updatealarm = "UPDATE tbldooralarms SET AlarmFunction = '$des', DoorUnits = '$doorunit', locks = '$locks', keypads = '$keypads', ut = '$ut',
		timer = '$timer', relay = '$relay', pir = '$pir', keypadext = '$ext', Buzzer = '$buzz' WHERE AlarmID = '$doorid'";
		mysql_query($updatealarm) or die(mysql_error());
		$query1 = "UPDATE tbldoorfunction SET alarmfunction = '$function' WHERE AlarmID = '$doorid'";
		mysql_query($query1) or die(mysql_error());
	}
	header("Location: configurehome.php");
}
 include 'includes/closedb.php'; 
 
 ?>