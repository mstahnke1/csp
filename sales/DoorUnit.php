<?php
$date = date('Y-m-d H:i:s');

include 'header.php';
$signature = $_SESSION['username'];
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
if(isset($_GET['copydoor'])&&($_GET['copydoor']=='yes'))
{
	$door_to_copy = $_GET['copydoor_id'];
?>
	<form method="GET" name="copy_door" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td>
					New Door Number
				</td>
				<td>
					<input type="text" size="4" maxlength="4" name="doornumber">
				</td>
			</tr>
			<tr>
				<td>
					New Door Name
				</td>
				<td>
					<input type="text" size="100" maxlength="255" name="doorname">
				</td>
			</tr>			
			<tr>
				<td>
					<input type="submit" value="SAVE" name="save_copied_door">
				</td>
			</tr>			
		</table>
<?php
	echo '<input type = "hidden" name="original_door" value = "'.$door_to_copy.'">';
	if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
	{
		echo '<input type = "hidden" name="type" value = "amend">';
	}
?>			
	</form>
<?php	
}
if(isset($_GET['save_copied_door'])&&($_GET['save_copied_door']=='SAVE'))
{
	$original_door = $_GET['original_door'];
	$new_door_name = $_GET['doorname'];
	$new_door_number = $_GET['doornumber'];
	$query8 = "SELECT * FROM tblfacilitydoors WHERE doorID = '$original_door'";
	$result8 = mysql_query($query8) or die (mysql_error());
	$row8 = mysql_fetch_array($result8);
	$doortype = $row8['doortype'];
	$FacilityID = $row8['FacilityID'];
	$doorframematerial = $row8['doorframematerial'];
	$surroundingconstruction = $row8['surroundingconstruction'];
	$alarmfunctionID = $row8['alarmfunctionID'];
	$reedswitchcount = $row8['reedswitchcount'];
	$doorunitcount = $row8['doorunitcount'];
	$keypadcount = $row8['keypadcount'];
	$pushbuttoncount = $row8['pushbuttoncount'];
	$minilockcount = $row8['minilockcount'];
	$zbracket = $row8['zbracket'];
	$zbracketoutdoor = $row8['zbracketoutdoor'];
	$timercount = $row8['timercount'];
	$outdoordoorunitCount = $row8['outdoordoorunitCount'];
	$outdoorreedcount = $row8['outdoorreedcount'];
	$utcount = $row8['utcount'];
	$racepackcount = $row8['racepackcount'];
	$pircount = $row8['pircount'];
	$notes = $row8['notes'];
	$relaycount = $row8['relaycount'];
	$bypass = $row8['bypass'];
	$signature = $row8['signature'];
	$utpower1 = $row8['utpower1'];
	$elock = $row8['elock'];
	$egresskit = $row8['egresskit'];
	$variance = $row8['variance'];
	$extboard = $row8['extboard'];
	$buzzer = $row8['buzzer'];
	$amendment_id = $row8['amendment_id'];
	$query9="INSERT INTO tblfacilitydoors (doornumber,doortype,FacilityID,doorframematerial,surroundingconstruction,
					alarmfunctionID,reedswitchcount,doorunitcount,keypadcount,pushbuttoncount,minilockcount,zbracket,
					zbracketoutdoor,timercount,outdoordoorunitCount,outdoorreedcount,utcount,racepackcount,pircount,notes,
					relaycount,doorname,bypass, signature, utpower1, elock, egresskit, variance,extboard,buzzer,amendment_id) 
	   			VALUES  ('$new_door_number','$doortype','$FacilityID','$doorframematerial','$surroundingconstruction','$alarmfunctionID',
	   			'$reedswitchcount','$doorunitcount','$keypadcount','$pushbuttoncount','$minilockcount','$zbracket',
	   			'$zbracketoutdoor','$timercount','$outdoordoorunitCount','$outdoorreedcount','$utcount','$racepackcount',
	   			'$pircount','$notes','$relaycount','$new_door_name','$bypass','$signature','$utpower1', '$elock',
	   			'$egresskit','$variance','$extboard','$buzzer','$amendment_id')";
	mysql_query($query9) or die(mysql_error());
	if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
	{
		$query10 = "SELECT amendment_id FROM tblfacilitydoors WHERE doorID = '$original_door'";
		$result10 = mysql_query($query10) or die (mysql_error());
		$row10 = mysql_fetch_array($result10);
		$amendment_id = $row10['amendment_id'];
		$query11 = "SELECT FacilityID FROM tblamendmentinfo WHERE ID = '$amendment_id'";	
		$result11 = mysql_query($query11) or die (mysql_error());
		$row11 = mysql_fetch_array($result11);
		$FacilityID = $row11['FacilityID'];			
		header("Location: doorunit.php?action=UPDATE&type=amend&f_id=$FacilityID");
	}else
	{
		header("Location: doorunit.php?action=UPDATE&f_id=$FacilityID");
	}
}
if(isset($_GET['action'])&&($_GET['action']=='DELETE'))
{
	$facilityID = $_GET['f_id'];
	$deleteid = $_GET['doorid'];
	$delete = "DELETE FROM tblfacilitydoors WHERE doorID = '$deleteid'";
	mysql_query($delete) or die(mysql_error());
	if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
	{
		header("Location: doorunit.php?action=UPDATE&f_id=$facilityID&type=amend");
	}else
	{
		header("Location: doorunit.php?action=UPDATE&f_id=$facilityID");
	}
}
if(isset($_GET['action'])&&($_GET['action']=='UPDATE'))
{
	$facilityID = $_GET["f_id"];
	$query1 = "SELECT * FROM tblfacilitydoors WHERE FacilityID = '$facilityID' ORDER BY doornumber";
	$result1 = mysql_query($query1) or die (mysql_error());
	if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
	{
		$query6 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$facilityID' AND Status = 0";
		$result6 = mysql_query($query6) or die (mysql_error());
		$row6 = mysql_fetch_array($result6);	
		$amendment_id = $row6['ID'];
		$query7 = "SELECT * FROM tblfacilitydoors WHERE amendment_id = '$amendment_id' ORDER BY doornumber";
		$result7 = mysql_query($query7) or die (mysql_error());
?>
		<form method="GET" name="job" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding="2" width="400">
			<tr>
				<td>
					Doors on Original Scope of Work
				</td>
			</tr>
<?php			
			while($row1 = mysql_fetch_array($result1))
			{
				echo '<tr><td><a href="' . $_SERVER['PHP_SELF'].'?amendment_id='.$amendment_id.'&doorid='. $row1['doorID'].'">'. $row1['doornumber'] .' </a>'. '&nbsp;&nbsp;'. $row1['doorname'] .'</td></tr>';
			}
?>
		</table>
		<table align ="center" width = "750" cellpadding="2">  	
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>		
		<table cellpadding="2" width="400">
			<tr>
				<td>
					Doors updated or added for Amendment
				</td>
			</tr>
<?php			
			while($row7 = mysql_fetch_array($result7))
			{
				echo '<tr><td><a href="' . $_SERVER['PHP_SELF'].'?amendment=true&doorid='. $row7['doorID'].'">'. $row7['doornumber'] .' </a>'.'&nbsp;&nbsp;'. $row7['doorname'] .'</td>'.'<td><a href="' . $_SERVER['PHP_SELF'].'?type=amend&action=copydoor&copydoor=yes&copydoor_id='. $row7['doorID'].'"><img src="../images/copy-icon.png" width="20" height="20" border="0" TITLE="Make a Copy" /></a></td><td width="22"><a href="doorunit.php?type=amend&action=DELETE&f_id='. $facilityID.'&doorid=' . $row7['doorID'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row7['doorname'].'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" TITLE="Delete Door"/></a></td></tr>';
			}
			if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
			{
				echo	'<input type = "hidden" name="amend" value = "1">';
			}				
?>
		</table>
		</form>
		<table cellpadding="2" width="750">
			<tr>
				<td width = 50>
					<button onClick="window.location='doorunit.php?amendment_id=<?php echo $amendment_id.'&f_id='.$facilityID; ?>'">Add Another Door</button>
				</td>
				<td>
					<button onClick="window.location='newfinishedpage.php?f_id=<?php echo $facilityID; ?>'">Finish</button>
				</td>
			</tr>	
		</table>
<?php		
	}else
	{
?>
		<table cellpadding="2" width="300">
<?php			
		while($row1 = mysql_fetch_array($result1))
		{
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'].'?doorid='. $row1['doorID'].'">'. $row1['doornumber'] .' </a>'.'&nbsp;&nbsp;'. $row1['doorname'] .'</td><td><a href="' . $_SERVER['PHP_SELF'].'?action=doorcopy&copydoor=yes&copydoor_id='. $row1['doorID'].'"><img src="../images/copy-icon.png" width="20" height="20" border="0" TITLE="Make a Copy" /></a></td><td width="22"><a href="doorunit.php?action=DELETE&f_id='. $facilityID.'&doorid=' . $row1['doorID'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row1['doorname'].'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" TITLE="Delete Door"/></a></td></tr>';
		}
?>
		</table>
		<table cellpadding="2" width="750">
			<tr>
				<td width = 50>
					<button onClick="window.location='doorunit.php?f_id=<?php echo $facilityID; ?>'">Add Another Door</button>
				</td>
				<td>
					<button onClick="window.location='newfinishedpage.php?f_id=<?php echo $facilityID; ?>'">Finish</button>
				</td>
			</tr>	
		</table>
<?php
	}
}
if(isset($_GET['doorid']) &(!isset($_GET['save2']) & (!isset($_GET['action']))))
{
	$doorid = $_GET['doorid'];
	if(!isset($_GET['problem']))
	{
		$query2 = "SELECT * FROM tblfacilitydoors WHERE doorID = '$doorid'";
		$result2 = mysql_query($query2) or die (mysql_error());
		$row2 = mysql_fetch_array($result2);	
		$facilityID = $row2["FacilityID"];
		$doornumber = $row2["doornumber"];
		$doorname = $row2["doorname"];
		$doortype = $row2["doortype"];
		$framematerial = $row2["doorframematerial"];
		$surroundingconstruction =$row2["surroundingconstruction"];
		$notes = $row2["notes"];
		$setuptype = $row2["alarmfunctionID"];
		$bypass = $row2["bypass"];
		$utpower1 = $row2["utpower1"];
		$elock1 = $row2["elock"];
		$variance = $row2["variance"];
		$lock_problem = 0;
		$ut_problem = 0;		
	}else
	{		
		if((isset($_GET['problem'])) && ($_GET['problem'] == 'add_door_problem'))
		{
			$facilityID = $_GET['FacilityID'];
		}else
		{
			$query2 = "SELECT * FROM tblfacilitydoors WHERE doorID = '$doorid'";
			$result2 = mysql_query($query2) or die (mysql_error());
			$row2 = mysql_fetch_array($result2);	
			$facilityID = $row2["FacilityID"];			
		}
		$doornumber = $_GET["doornumber"];
		$doorname = $_GET["doorname"];
		$doortype = $_GET["doortype"];
		$framematerial = $_GET["framematerial"];
		$surroundingconstruction =$_GET["surroundingconstruction"];
		$notes = addslashes($_GET["notes"]);
		$setuptype = $_GET["setuptype"];
		$bypass = $_GET["bypass"];
		$utpower1 = $_GET["utpower1"];
		$elock1 = $_GET["elock"]; 
		$variance = $_GET['variance'];
		$lock_problem = $_GET['lock_problem'];
		$ut_problem = $_GET['utproblem'];
	}
	if ($doortype == "doortype1")
	{
		($doortype1 = "Single Door over 6 ft. 11");
	}
	if ($doortype == "doortype2")
	{
		($doortype1 = "Double Door over 6 ft. 11");
	}
	if ($doortype == "doortype3")
	{
		($doortype1 = "Single Interior Door under 6 ft. 11");
	}
	if ($doortype == "doortype4")
	{
		($doortype1 = "Double Interior Door under 6 ft. 11");
	}
	if ($doortype == "doortype5")
	{
		($doortype1 = "Single Exit Door under 6 ft. 11");
	}
	if ($doortype == "doortype6")
	{
		($doortype1 = "Double Exit Door under 6 ft. 11");
	}
	if ($doortype == "doortype7")
	{
		($doortype1 = "Sliding\Automatic Door");
	}
	if ($doortype == "doortype8")
	{
		($doortype1 = "Outdoor Gate");
	}
	if ($doortype == "doortype9")
	{
		($doortype1 = "Elevator Bank");
	}
	if ($bypass == "bypass1")
	{
		($bypass1 = "Keypad");
	}	
	elseif ($bypass == "bypass2")
	{
		($bypass1 = "Pushbutton");
	}else 
	{
		($bypass1 = "NONE");
	}		
	if ($framematerial == "frame1")
	{
		($framematerial1 = "Wood");
	}elseif($framematerial == "frame2")
	{
		($framematerial1 = "Metal");
	}else
	{
		($framematerial1 = "unkown");
	}	
	if($surroundingconstruction == "surround1")
	{
		($surroundingconstruction1 = "Cinder Block");
	}elseif($surroundingconstruction == "surround2")
	{
		($surroundingconstruction1 = "Window/Glass");
	}elseif($surroundingconstruction == "surround3")
	{
		($surroundingconstruction1 = "Dry Wall");
	}else
	{
		($surroundingconstruction1 = "unkown");
	}
	$generaltype = "SELECT SystemType FROM tblfacilitygeneralinfo WHERE ID = '$facilityID'";
	$resgeneraltype = mysql_query($generaltype) or die (mysql_error());
	$general = mysql_fetch_array($resgeneraltype);
	$getdooralarm = "SELECT * FROM tbldooralarms";
	$resgetdooralarm = mysql_query($getdooralarm) or die (mysql_error());	
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table align="center">
			<tr>
				<td align=center><font size=4 ><strong>  Door Units  </strong></td>
			</tr>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td>Door Number:</td><td><input type="text" size="4" maxlength="4" name="doornumber" value="<?php echo "$doornumber"; ?>"></td><td rowspan="2">Door Name:<td colspan="3" rowspan="2"><textarea rows = "2"  cols ="40" name="doorname"><?php echo "$doorname"; ?></textarea></td>
			</tr>
			<tr>
				<td>Door Type:</td><td><select name=doortype>
					<option value ="<?php echo $doortype; ?>"><?php echo $doortype1; ?></option>
					<option value ="doortype1">Single Door over 6 ft. 11</option>
		  			<option value ="doortype2">Double Door over 6 ft. 11</option>
		  			<option value ="doortype3">Single Interior Door under 6 ft. 11</option>
		  			<option value ="doortype4">Double Interior Door under 6 ft. 11</option>
		  			<option value ="doortype5">Single Exit Door under 6 ft. 11</option>
		  			<option value ="doortype6">Double Exit Door under 6 ft. 11</option>
		  			<option value ="doortype7">Sliding\Automatic Door</option>
		  			<option value ="doortype8">Outdoor Gate</option>
		  			<option value ="doortype9">Elevator Bank</option>
				</select></td>
			</tr>
			<tr>
				<td>Door Frame Material:</td><td><select name=framematerial>
						<option value ="<?php echo $framematerial; ?>"><?php echo $framematerial1; ?></option>
						<option value ="unknown">unknown</option>
						<option value ="frame1">Wood</option>
		  			<option value ="frame2">Metal</option>
				</select></td><td>Surrounding Material:</td><td><select name=surroundingconstruction>
					<option value ="<?php echo $surroundingconstruction; ?>"><?php echo $surroundingconstruction1; ?></option>
					<option value ="unknown">unknown</option>
					<option value ="surround1">Cinder Block</option>
		  			<option value ="surround2">Window/Glass</option>
		  			<option value ="surround3">Dry Wall</option>
				</select></td>
			</tr>
		</table>
<?php
		if($ut_problem == 1)
		{
?>		
			<table cellpadding=2 table border ="1" bordercolor="ff0000" width="750"  align ="center">
<?php				
		}else
		{
?>			
			<table cellpadding=2 table border ="1" bordercolor="000000" width="750"  align ="center">
<?php
		}
		if($utpower1 == "yes")
		{
?>
			<tr>
				<td colspan="6">
					<input type="radio" name="utpower1" value="no">
						 UT's Powered By Batteries
					 <input type="radio" name="utpower1" value="yes" CHECKED>
					  UT's Powered By Power Source
					  <input type="radio" name="utpower1" value="none">
					  No UT's on this door
				</td>
			</tr>
<?php
		}
		if($utpower1 == "no")
		{
?>
			<tr>
				<td colspan="6">
					<input type="radio" name="utpower1" value="no" CHECKED>
						 UT's Powered By Batteries
					 <input type="radio" name="utpower1" value="yes">
					  UT's Powered By Power Source
					  <input type="radio" name="utpower1" value="none">
					  No UT's on this door
				</td>
			</tr>
<?php
		}
		if($utpower1 == "none")
		{
?>
			<tr>
				<td colspan="6">
					<input type="radio" name="utpower1" value="no" >
						 UT's Powered By Batteries
					 <input type="radio" name="utpower1" value="yes">
					  UT's Powered By Power Source
					  <input type="radio" name="utpower1" value="none" CHECKED>
					  No UT's on this door
				</td>
			</tr>
<?php
		}
?>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td>Door Setup:</td><td><select name=setuptype>
<?php			
				while($dooralarmtype = mysql_fetch_array($resgetdooralarm))
				{
?>				
					<option value="<?php echo $dooralarmtype['AlarmID']; ?>" <?php if($dooralarmtype['AlarmID'] == $setuptype){ echo 'selected="selected"'; } ?>>  <?php echo  $dooralarmtype['AlarmFunction']; ?> </option>
<?php
				}	
?>				
				</select></td>
			</tr>
		</table>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td>Secondary Bypass &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name = bypass>
					<option value ="<?php echo $bypass; ?>"><?php echo $bypass1; ?></option>
					<option value = "NONE"> NONE</option>
					<option value = "bypass1">Keypad</option>
					<option value = "bypass2">Pushbutton</option>
				</select></td>
			</tr>
		</table>
<?php		
		if($lock_problem == 1)
		{
?>		
			<table cellpadding=2 table border ="1" bordercolor="ff0000" width="750"  align ="center">
<?php				
		}else
		{
?>			
			<table cellpadding=2 table border ="1" bordercolor="000000" width="750"  align ="center">
<?php
		}
		if($elock1 == "noelock")
		{
?>
			<tr>
				<td>Using an exsiting lock on this door?&nbsp;&nbsp;<input type="radio" name="elock" value="elock">YES 
				<input type="radio" name="elock" value="noelock" CHECKED>NO <input type="radio" name="elock" value="none">No Lock on this door</td>
			</tr>
<?php
		}elseif($elock1 == "elock")
		{
?>
			<tr>
				<td>
					Using an exsiting lock on this door?&nbsp;&nbsp;<input type="radio" name="elock" value="elock" CHECKED>YES <input type="radio" name="elock" value="noelock">NO <input type="radio" name="elock" value="none">No Lock on this door
				</td>
			</tr>
<?php
		}else
		{
?>
			<tr>
				<td>
					Using an exsiting lock on this door?&nbsp;&nbsp;<input type="radio" name="elock" value="elock">YES <input type="radio" name="elock" value="noelock">NO <input type="radio" name="elock" value="none" CHECKED>No Lock on this door
				</td>
			</tr>
<?php
		}
?>	
		</table>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td> There is a Variance for a Minilock 
<?php
				if($variance == 0)
				{
?>					
					<input type="checkbox" name="variance" value="yes">
<?php
				}else
				{
?>			
					<input type="checkbox" name="variance" value="yes" CHECKED>
<?php
				}		
?>		
				</td>
			</tr>
		</table>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td>
					Notes:</td><td><textarea rows="5" cols="80" name="notes"><?php echo "$notes"; ?></textarea>
				</td>
			</tr>
		</table>
		<table cellpadding=2  width="750"  align ="center">
<?php
		if(isset($_GET['amendment_id']))
		{
			$amendment_id = $_GET['amendment_id'];
			echo	'<input type = "hidden" name="amendment_id" value = "'.$amendment_id.'">';
		}
		if((isset($_GET['amendment'])) && ($_GET['amendment'] == 'true'))
		{
			echo	'<input type = "hidden" name="amendment" value = "true">';
		}
		if((isset($_GET['problem'])) && ($_GET['problem'] == 'add_door_problem'))
		{
?>	
			<tr>
				<td>
					<input type="submit" value="Add Door" name="done">
				</td>
			</tr>	
<?php
			echo '<input type = "hidden" name="f_id" value = "'.$facilityID.'">';
		}else
		{
?>			
			<tr>
				<td>
					<input type="submit" value="SAVE" name="save2">
				</td>
			</tr>
<?php	
			echo '<input type = "hidden" name="doorid" value = "'.$doorid.'">';
		}

?>		
		</table>
	</form>
<?php
}
/*
***************************************************ADD NEW DOOR************************************
*/
if(!(isset($_GET['save2']) OR (isset($_GET['save_copied_door']) OR (isset ($_GET['doorid']) OR (isset($_GET['done'])OR (isset($_GET['action'])&&($_GET['action']='UPDATE')))))))
{
	$facilityID = $_GET["f_id"];
	$generaltype = "SELECT SystemType FROM tblfacilitygeneralinfo WHERE ID = '$facilityID'";
	$resgeneraltype = mysql_query($generaltype) or die (mysql_error());
	$general = mysql_fetch_array($resgeneraltype);	
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
	echo '<input type = "hidden" name="f_id" value = "'.$facilityID.'">';	
	if(isset($_GET['amendment_id']))
	{
		$amendment_id = $_GET['amendment_id'];
		echo	'<input type = "hidden" name="amendment_id" value = "'.$amendment_id.'">';
	}			
?>
		<table align="center">
			<tr>
				<td align=center><font size=4 ><strong>  
					Door Units  
				</strong></td>
			</tr>
		</table>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td>
					Door Number:
				</td>
				<td>
					<input type="text" size="4" maxlength="4" name="doornumber">
				</td>
				<td rowspan="2">
					Door Name:
				</td>
				<td colspan="3" rowspan="2">
					<textarea rows="2"cols = "40"  name="doorname"></textarea>
				</td>
			</tr>
			<tr>
				<td>Door Type:</td><td><select name=doortype>
					<option value ="doortype1">Single Door over 6 ft. 11</option>
		  			<option value ="doortype2">Double Door over 6 ft. 11</option>
		  			<option value ="doortype3">Single Interior Door under 6 ft. 11</option>
		  			<option value ="doortype4">Double Interior Door under 6 ft. 11</option>
		  			<option value ="doortype5">Single Exit Door under 6 ft. 11</option>
		  			<option value ="doortype6">Double Exit Door under 6 ft. 11</option>
		  			<option value ="doortype7">Sliding\Automatic Door</option>
		  			<option value ="doortype8">Outdoor Gate</option>
		  			<option value ="doortype9">Elevator Bank</option>
				</select></td>
			</tr>
			<tr>
				<td>Door Frame Material:</td><td><select name=framematerial>
					<option value ="unknown">unknown</option>
					<option value ="frame1">Wood</option>
	  			<option value ="frame2">Metal</option>
				</select></td>
				<td>Surrounding Material:
				</td>
				<td><select name=surroundingconstruction>
					<option value ="unknown">unknown</option>
					<option value ="surround1">Cinder Block</option>
	  			<option value ="surround2">Window/Glass</option>
	  			<option value ="surround3">Dry Wall</option>
				</select></td>
				</tr>
			</table>
			<table cellpadding=2 table border ="1" width="750"  align ="center">
				<tr>
					<td colspan="6">
						<input type="radio" name="utpower1" value="no">
							 UT's Powered By Batteries
						 <input type="radio" name="utpower1" value="yes">
						  UT's Powered By Power Source
						  <input type="radio" name="utpower1" value="none" CHECKED>
						  No UT on this Door
					</td>
				</tr>
			</table>
<?php
			$getdooralarm = "SELECT AlarmID,AlarmFunction FROM tbldooralarms";
			$resgetdooralarm = mysql_query($getdooralarm) or die (mysql_error());
?>
			<table cellpadding=2 table border ="1" width="750"  align ="center">
				<tr>
					<td>Door Setup:</td><td><select name=setuptype>
<?php			
					while($dooralarmtype = mysql_fetch_array($resgetdooralarm))
					{
?>				
						<option value="<?php echo $dooralarmtype['AlarmID']; ?>"><?php echo $dooralarmtype['AlarmFunction']; ?></option>
<?php
					}
?>							
				</select></td>
			</tr>
		</table>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td>
					Using an exsiting lock on this door?<input type="radio" name="elock" value="elock">YES <input type="radio" name="elock" value="noelock" >NO <input type="radio" name="elock" value="none" CHECKED> No Lock on this Door
				</td>
			</tr>
		</table>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td> There is a Variance for a Minilock <input type="checkbox" name="variance" value="yes">
			</tr>
		</table>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td>Secondary Bypass &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name = bypass>
					<option value = "NONE"> NONE</option>
					<option value = "bypass1">Keypad</option>
					<option value = "bypass2">Pushbutton</option>
				</select></td>
			</tr>
		</table>
		<table cellpadding=2 table border ="1" width="750"  align ="center">
			<tr>
				<td>
					Notes:
				</td>
				<td>
					<textarea rows="5" cols="80" name="notes"></textarea>
				</td>
			</tr>
		</table>
		<table cellpadding=2  width="750"  align ="center">
				<td>
					<input type="submit" value="Add Door" name="done">
				</td>
			</tr>
		</table>
	</form>
<?php
	if(!isset($_GET['amendment_id']))	
	{
?>
		<table cellpadding=2  width="750"  align ="center">
			<tr>
				<td><button onClick="window.location='doorunit.php?action=UPDATE&f_id=<?php echo $facilityID; ?>'">Cancel</button></td>
			</tr>
		</table>
<?php
	}
}
if(isset($_GET['save2']) OR (isset($_GET['done'])))
{
	$doornumber = $_GET["doornumber"];
	$doorname = $_GET["doorname"];
	$doortype = $_GET["doortype"];
	$framematerial = $_GET["framematerial"];
	$surroundingconstruction =$_GET["surroundingconstruction"];
	$notes = addslashes($_GET["notes"]);
	$setuptype = $_GET["setuptype"];
	$bypass = $_GET["bypass"];
	$utpower1 = $_GET["utpower1"];
	$elock = $_GET["elock"]; 
	if(isset($_GET['variance']))
	{
		$variance = 1;
	}else
	{
		$variance = 0;
	}
	$keypadx = 0;
	$doorunit = 0;
	$zbracket = 0;
	$timer = 0;
	$odoor = 0;
	$ut = 0;
	$relay = 0;
	$minilock = 0;
	$zbracketoutdoor = 0;
	$egresskit = 0;
	$PIR = 0;
	$reed = 0;
	$oreed = 0;	
				//Door Unit If Statements
	$getdoorequip = "SELECT * FROM tbldooralarms WHERE AlarmID = '$setuptype'";
	$resgetdoorequip = mysql_query($getdoorequip) or die (mysql_error());
	$dooralarmequip = mysql_fetch_array($resgetdoorequip);
	$doorunits = $dooralarmequip['DoorUnits'];
	$locks = $dooralarmequip['locks'];
	$keypads = $dooralarmequip['keypads'];	
	$utransmitter = $dooralarmequip['ut'];	
	$timers = $dooralarmequip['timer'];
	$relay = $dooralarmequip['relay'];
	$motion = $dooralarmequip['pir'];
	$keypadext = $dooralarmequip['keypadext'];
	$buzz = $dooralarmequip['Buzzer'];
/*
******************************************************GET REEDS OR PIR********************************************
*/
	if($motion == 0)
	{
		if((($doortype == "doortype2") or  ($doortype == "doortype4") or ($doortype == "doortype6")) & ($setuptype<>"door4"))
		{
			(($reed = 2) && ($racepack=2));
		}elseif  ((($doortype == "doortype1") or  ($doortype == "doortype3") or ($doortype == "doortype5"))or (($doortype == "doortype7") or ($doortype == "doortype9") & ($setuptype<>"door4")))
		{
			(($reed = 1) && ($racepack=1));
		}elseif($doortype =="doortype8")
		{
			(($oreed = 1) && ($racepack = 0));
		}else
		{
			(($oreed = 0) && ($reed = 0) && ($racepack = 0));
		}
	}else
	{
		(($PIR = 1) && ($racepack=1));
	}
/*
******************************************************DETERMINE DOOR UNITS********************************************
*/
	if($doorunits <> 0)
	{
		if($doortype == "doortype8")
		{
			$odoor = 1;
			$keypads = 1;
		}else
		{
			$doorunit = 1;
		}
	}
/*
******************************************************DETERMINE LOCKS********************************************
*/
	if($locks <> 0)
	{
		if($doortype == "doortype8")
		{
			$zbracketoutdoor = 1;
			$egresskit = 1;
		}elseif(($doortype == "doortype3") || ($doortype == "doortype4") || ($doortype == "doortype5") || ($doortype == "doortype6"))
		{
			$zbracket = 1;
			$egresskit = 1;
		}else
		{
			$minilock = 1;
		}	
/*
******************************************************DOUBLE DOOR CONSIDERATTION STATEMENTS********************************************
*/
		if(($doortype == "doortype2") || ($doortype == "doortype4") || ($doortype == "doortype6"))
		{
			$zbracketoutdoor = ($zbracketoutdoor * 2);
			$zbracket = ($zbracket * 2);
			$minilock = ($minilock * 2);
		}
		if($elock == "elock")
		{
			$zbracketoutdoor = ($zbracketoutdoor * 0);
			$zbracket = ($zbracket * 0);
			$minilock = ($minilock * 0);
		}		
	}
/*
******************************************************DETERMINE KEYPADS********************************************
*/
	if($keypads == 1)
	{
		$keypadx = 1;
	}
/*
******************************************************DETERMINE UNIVERSAL TRANSMITTERS********************************************
*/
	if($utransmitter == 1)
	{
		$ut = 1;
	}
/*
******************************************************DETERMINE TIMERS********************************************
*/
	if($timers == 1)
	{
		$timer = 1;
	}
/*
******************************************************DETERMINE KEYPAD EXT BOARDS********************************************
*/
	if($keypadext == 1)
	{
		$extboard = 1;
	}else
	{
		$extboard = 0;
	}
/*
******************************************************DETERMINE TIMERS********************************************
*/	
	if(($ut > 0 & $utpower1 == "none") OR ($ut < 1 & $utpower1 <> "none"))
	{
		$ut_problem = 1;
	}else
	{
		$ut_problem = 0;
	}
	if(((($zbracket > 0) OR ($minilock > 0) OR ($zbracketoutdoor > 0)) && ($elock == "none")) OR (($locks == 0) && ($elock <> "none")))
	{
		$lock_problem = 1;
	}else
	{
		$lock_problem = 0;
	}
	if(($setuptype <> "door14") or ($setuptype <> "door16"))
	{		
		if($bypass=="bypass1")
		{
			($keypad =$keypadx + 1) & ($pushbutton = 0);
		}elseif ($bypass=="bypass2")
		{
			($pushbutton= 1) & ($keypad = $keypadx);
		}else
		{
			($keypad = $keypadx)  & ($pushbutton = 0);
		}
	}
	if($setuptype == "door14")
	{
		$keypad = 0;
		$keypadx = 0;
		$pushbutton = 0;
		$bypass = "NONE";
		$reed = 0;
		$oreed = 0;
		$racepack = 0;
	}
	if($setuptype == "door16")
	{
		$pushbutton = 1;
		$reed = 0;
		$oreed = 0;
		$racepack = 0;
		$bypass = "NONE";
		$keypad = 0;
		$keypadx = 0;
	}
	if($setuptype == "door19")
	{
		$reed = 0;
	}
	if($zbracket == 0 AND $zbracketoutdoor == 0)
	{
		$egresskit = 0;
	}else
	{
		$egresskit = 1;
	}
	if($variance == 1)
	{
		if($zbracket > 0)
		{
			$minilock = $zbracket;
			$zbracket = 0;
			$egresskit = 0;
		}elseif($zbracketoutdoor > 0)
		{
			$minilock = $zbracketoutdoor;
			$zbracketoutdoor = 0;
			$egresskit = 0;
		}else
		{
			$variance = 0;
		}
	}
//******************************************************DETERMINE BUZZERS**************************************//
	if($buzz > 0)
	{
		$buzz = 1;
	}else
	{
		$buzz = 0;
	}
	//ADDING A NEW DOOR
	if(isset($_GET['done']))
	{	
		$facilityID = $_GET["f_id"];		
		if(isset($_GET['amendment_id']))
		{
			$amendment_id = $_GET['amendment_id'];
			if(($ut_problem == 1) OR ($lock_problem == 1))
			{
				$doornumber = $_GET["doornumber"];
				$doorname = $_GET["doorname"];
				$doortype = $_GET["doortype"];
				$framematerial = $_GET["framematerial"];
				$surroundingconstruction =$_GET["surroundingconstruction"];
				$notes = addslashes($_GET["notes"]);
				$setuptype = $_GET["setuptype"];
				$bypass = $_GET["bypass"];
				$utpower1 = $_GET["utpower1"];
				$elock = $_GET["elock"]; 
				if(isset($_GET['variance']))
				{
					$variance = 1;
				}else
				{
					$variance = 0;
				}			
				header("Location: doorunit.php?doorid=0&doornumber=$doornumber&doorname=$doorname&doortype=$doortype&framematerial=$framematerial&surroundingconstruction=$surroundingconstruction&notes=$notes&setuptype=$setuptype&bypass=$bypass&utpower1=$utpower1&elock=$elock&variance=$variance&utproblem=$ut_problem&lock_problem=$lock_problem&problem=add_door_problem&FacilityID=$facilityID&amendment_id=$amendment_id");
			}else
			{
				$query="INSERT INTO tblfacilitydoors (FacilityID,doornumber,doortype,amendment_id,doorframematerial,surroundingconstruction,alarmfunctionID,reedswitchcount,doorunitcount,keypadcount,
   							pushbuttoncount,minilockcount,zbracket,zbracketoutdoor,timercount,outdoordoorunitCount,outdoorreedcount,utcount,racepackcount,pircount,notes,relaycount,doorname, 
   							bypass, signature, utpower1, elock, egresskit, variance,extboard,buzzer) 
   							VALUES  (0,'$doornumber','$doortype','$amendment_id','$framematerial','$surroundingconstruction','$setuptype','$reed','$doorunit','$keypad','$pushbutton','$minilock','$zbracket','$zbracketoutdoor','$timer',
   							'$odoor','$oreed','$ut','$racepack','$PIR','$notes','$relay','$doorname','$bypass','$signature','$utpower1', '$elock','$egresskit','$variance','$extboard','$buzz')";
	   			mysql_query($query) or die(mysql_error());   
	   			header("Location: doorunit.php?action=UPDATE&f_id=$facilityID&type=amend");
	   	}
		}else
		{	
			if(($ut_problem == 1) OR ($lock_problem == 1))
			{
				$doornumber = $_GET["doornumber"];
				$doorname = $_GET["doorname"];
				$doortype = $_GET["doortype"];
				$framematerial = $_GET["framematerial"];
				$surroundingconstruction =$_GET["surroundingconstruction"];
				$notes = addslashes($_GET["notes"]);
				$setuptype = $_GET["setuptype"];
				$bypass = $_GET["bypass"];
				$utpower1 = $_GET["utpower1"];
				$elock = $_GET["elock"]; 
				if(isset($_GET['variance']))
				{
					$variance = 1;
				}else
				{
					$variance = 0;
				}			
				header("Location: doorunit.php?doorid=0&doornumber=$doornumber&doorname=$doorname&doortype=$doortype&framematerial=$framematerial&surroundingconstruction=$surroundingconstruction&notes=$notes&setuptype=$setuptype&bypass=$bypass&utpower1=$utpower1&elock=$elock&variance=$variance&utproblem=$ut_problem&lock_problem=$lock_problem&problem=add_door_problem&FacilityID=$facilityID");		
			}else
			{			
	 			$query="INSERT INTO tblfacilitydoors (doornumber,doortype,FacilityID,doorframematerial,surroundingconstruction,alarmfunctionID,reedswitchcount,doorunitcount,keypadcount,
	   						pushbuttoncount,minilockcount,zbracket,zbracketoutdoor,timercount,outdoordoorunitCount,outdoorreedcount,utcount,racepackcount,pircount,notes,relaycount,doorname, 
	   						bypass, signature, utpower1, elock, egresskit, variance,extboard,buzzer) 
	   						VALUES  ('$doornumber','$doortype','$facilityID','$framematerial','$surroundingconstruction','$setuptype','$reed','$doorunit','$keypad','$pushbutton','$minilock','$zbracket','$zbracketoutdoor','$timer',
	   						'$odoor','$oreed','$ut','$racepack','$PIR','$notes','$relay','$doorname','$bypass','$signature','$utpower1', '$elock','$egresskit','$variance','$extboard','$buzz')";
	   		mysql_query($query) or die(mysql_error());   
	   		header("Location: doorunit.php?action=UPDATE&f_id=$facilityID"); 
	 		}
	 	}
	}
 	//SAVING AN EXISTING DOOR
 	if(isset($_GET['save2']))
	{		
		$doorid = $_GET['doorid'];
		//If making an amendment to a scope of work and updating a door to reflect changes on the amendment this will insert
		//a new row with the amendment id as the reference.  It makes another door because if updating the original line,
		//it would change on the initial scope of work.  All doors inserted will be queried on the amendment id in the 
		//"new finished page"
		if(isset($_GET['amendment_id']))
		{
			$amendment_id = $_GET['amendment_id'];
			if(($ut_problem == 1) OR ($lock_problem == 1))
			{
				header("Location: doorunit.php?doorid=$doorid&doornumber=$doornumber&doorname=$doorname&doortype=$doortype&framematerial=$framematerial&surroundingconstruction=$surroundingconstruction&notes=$notes&setuptype=$setuptype&bypass=$bypass&utpower1=$utpower1&elock=$elock&variance=$variance&utproblem=$ut_problem&lock_problem=$lock_problem&problem=update_door_problem&amendment_id=$amendment_id");		
			}else
			{	
				$query5 = "SELECT FacilityID FROM tblfacilitydoors WHERE doorID = '$doorid'";
				$result5 = mysql_query($query5) or die (mysql_error());
				$row5 = mysql_fetch_array($result5);
				$facilityID = $row5['FacilityID'];
				$query="INSERT INTO tblfacilitydoors (FacilityID,doornumber,doortype,amendment_id,doorframematerial,surroundingconstruction,alarmfunctionID,reedswitchcount,doorunitcount,keypadcount,
	   						pushbuttoncount,minilockcount,zbracket,zbracketoutdoor,timercount,outdoordoorunitCount,outdoorreedcount,utcount,racepackcount,pircount,notes,relaycount,doorname, 
	   						bypass, signature, utpower1, elock, egresskit, variance,extboard,buzzer) 
	   						VALUES  (0,'$doornumber','$doortype','$amendment_id','$framematerial','$surroundingconstruction','$setuptype','$reed','$doorunit','$keypad','$pushbutton','$minilock','$zbracket','$zbracketoutdoor','$timer',
	   						'$odoor','$oreed','$ut','$racepack','$PIR','$notes','$relay','$doorname','$bypass','$signature','$utpower1', '$elock','$egresskit','$variance','$extboard','$buzz')";
		   	mysql_query($query) or die(mysql_error());   
				header("Location: doorunit.php?action=UPDATE&f_id=$facilityID&type=amend");
			}
		}else
		{
			if(($ut_problem == 1) OR ($lock_problem == 1))
			{
				if((isset($_GET['amendment'])) && ($_GET['amendment'] == 'true'))
				{	
					header("Location: doorunit.php?doorid=$doorid&doornumber=$doornumber&doorname=$doorname&doortype=$doortype&framematerial=$framematerial&surroundingconstruction=$surroundingconstruction&notes=$notes&setuptype=$setuptype&bypass=$bypass&utpower1=$utpower1&elock=$elock&variance=$variance&utproblem=$ut_problem&lock_problem=$lock_problem&problem=update_door_problem&amendment=true");
				}else
				{			
					header("Location: doorunit.php?doorid=$doorid&doornumber=$doornumber&doorname=$doorname&doortype=$doortype&framematerial=$framematerial&surroundingconstruction=$surroundingconstruction&notes=$notes&setuptype=$setuptype&bypass=$bypass&utpower1=$utpower1&elock=$elock&variance=$variance&utproblem=$ut_problem&lock_problem=$lock_problem&problem=update_door_problem");
				}
			}else
			{	
				if((isset($_GET['amendment'])) && ($_GET['amendment'] == 'true'))
				{
					$query5 = "SELECT amendment_id FROM tblfacilitydoors WHERE doorID = '$doorid'";
					$result5 = mysql_query($query5) or die (mysql_error());
					$row5 = mysql_fetch_array($result5);
					$amendment_id = $row5['amendment_id'];
					$query6 = "SELECT FacilityID FROM tblamendmentinfo WHERE ID = '$amendment_id'";
				}else
				{
					$query6 = "SELECT FacilityID FROM tblfacilitydoors WHERE doorID = '$doorid'";	 			 		
			 	}		
				$result6 = mysql_query($query6) or die (mysql_error());
				$row6 = mysql_fetch_array($result6);
				$facilityID = $row6['FacilityID'];		
		 		//echo '<input type = "hidden" name="doorid" value = "'.$doorid.'">';	 
		 	 	$query4 = "UPDATE tblfacilitydoors SET doornumber = '$doornumber', doortype = '$doortype', doorframematerial = '$framematerial', surroundingconstruction = '$surroundingconstruction', alarmfunctionID = '$setuptype',
		 						reedswitchcount = '$reed', doorunitcount = '$doorunit', keypadcount = '$keypad', pushbuttoncount = '$pushbutton', minilockcount = '$minilock', zbracket = '$zbracket', zbracketoutdoor = '$zbracketoutdoor',timercount = '$timer', outdoordoorunitCount = '$odoor',
		 						outdoorreedcount = '$oreed', utcount = '$ut', racepackcount = '$racepack', pircount = '$PIR', notes = '$notes', relaycount = '$relay', doorname = '$doorname', bypass = '$bypass', 
		 						utpower1 = '$utpower1', elock = '$elock', egresskit = '$egresskit', variance = '$variance', extboard = '$extboard', buzzer = '$buzz' WHERE doorID = '$doorid'";
		 		mysql_query($query4) or die(mysql_error());
		 		$query62 = "UPDATE tblfacilitygeneralinfo SET lastupdated = '$date' WHERE ID = '$facilityID'";
				mysql_query($query62) or die(mysql_error());	
			}
			if((isset($_GET['amendment'])) && ($_GET['amendment'] == 'true'))
			{
?>
				<tr>
				 <td>
						Door Updated! 
						<button onClick="window.location='doorunit.php?action=UPDATE&f_id=<?php echo $facilityID; ?>&type=amend'">CONTINUE</button>
					</td>
				</tr>
<?php   
			}else	
			{			
?>
				<tr>
				 <td>
						Door Updated! 
						<button onClick="window.location='doorunit.php?action=UPDATE&f_id=<?php echo $facilityID; ?>'">CONTINUE</button>
					</td>
				</tr>
<?php   
			}
 		}
	}
?>
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
