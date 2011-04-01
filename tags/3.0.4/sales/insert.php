<?php

include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';

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
			<input type="text" size="75" maxlength="75" name="doordes">
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
 	 <tr>
		<td><input type="submit" value="DONE" name="done"></td>
	</tr>
</table>
</form>
<?php
if(isset($_GET['done']))
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
	$insertalarm = "INSERT INTO tbldooralarms (AlarmID, AlarmFunction, DoorUnits, locks, keypads, ut, timer, relay, pir) VALUES
								('$doorid','$des','$doorunit','$locks','$keypads','$ut','$timer','$relay','$pir')";
	mysql_query($insertalarm) or die(mysql_error());
	$query = "INSERT INTO tbldoorfunction (AlarmID, alarmfunction) VALUES  ('$doorid','$function')";
	mysql_query($query) or die(mysql_error());
}
 include 'includes/closedb.php'; 
 
 ?>