<?php
$date = date('Y-m-d H:i:s');

include 'header.php';
$signature = $_SESSION['username'];
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';

	if(isset($_GET['action'])&&($_GET['action']=='DELETE'))
		{
			$deleteid = $_GET['doorid'];
			$delete = "DELETE FROM tblfacilitydoors WHERE doorID = '$deleteid'";
			mysql_query($delete) or die(mysql_error());
		}
			

	if(isset($_GET['action'])&&($_GET['action']='UPDATE '))
		{
			$facilityID = $_GET["f_id"];
			$query1 = "SELECT * FROM tblfacilitydoors WHERE FacilityID = '$facilityID' ORDER BY doornumber";
			$result1 = mysql_query($query1) or die (mysql_error());
?>
	<table cellpadding="2" width="300">
<?php		
			
			while($row1 = mysql_fetch_array($result1))
				{
					echo '<tr><td><a href="' . $_SERVER['PHP_SELF'].'?doorid='. $row1['doorID'].'">'. $row1['doornumber'] .' </a>'. '&nbsp;&nbsp;'. $row1['doorname'] .'</td>' . '<td width="22"><a href="doorunit.php?action=DELETE&f_id='. $facilityID.'&doorid=' . $row1['doorID'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row1['doorname'].'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" /></a></td></tr>';
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
if(isset($_GET['doorid']) &(!isset($_GET['save2']) & (!isset($_GET['action']))))
{
	
	
	$doorid = $_GET['doorid'];
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
		}	
		else 
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

<table cellpadding=2 table border ="1" width="750"  align ="center">
<?php
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
<table cellpadding=2 table border ="1" width="750"  align ="center">
<?php

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
			<td>Using an exsiting lock on this door?&nbsp;&nbsp;<input type="radio" name="elock" value="elock" CHECKED>YES <input type="radio" name="elock" value="noelock">NO <input type="radio" name="elock" value="none">No Lock on this door</td>
		</tr>
		<?php
	}else
	{
		?>
		<tr>
		<td>Using an exsiting lock on this door?&nbsp;&nbsp;<input type="radio" name="elock" value="elock">YES <input type="radio" name="elock" value="noelock">NO <input type="radio" name="elock" value="none" CHECKED>No Lock on this door</td>
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
		<td>Notes:</td><td><textarea rows="5" cols="80" name="notes"><?php echo "$notes"; ?></textarea></td>
	</tr>
</table>
	<table cellpadding=2  width="750"  align ="center">
			<td><input type="submit" value="SAVE" name="save2"></td>
			</tr>
				<?php	echo '<input type = "hidden" name="doorid" value = "'.$doorid.'">';	 ?>
		</table>
</form>
<?php

}
/*
***************************************************ADD NEW DOOR************************************
*/
if(!(isset($_GET['save2']) OR (isset ($_GET['doorid']) OR (isset($_GET['done'])OR (isset($_GET['action'])&&($_GET['action']='UPDATE '))))))
	
	{
	$facilityID = $_GET["f_id"];
	$generaltype = "SELECT SystemType FROM tblfacilitygeneralinfo WHERE ID = '$facilityID'";
	$resgeneraltype = mysql_query($generaltype) or die (mysql_error());
	$general = mysql_fetch_array($resgeneraltype);	
?>


<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
echo '<input type = "hidden" name="f_id" value = "'.$facilityID.'">';	
?>
<table align="center">
	<tr>
		<td align=center><font size=4 ><strong>  Door Units  </strong></td>
	</tr>
<table cellpadding=2 table border ="1" width="750"  align ="center">
	<tr>
		<td>Door Number:</td><td><input type="text" size="4" maxlength="4" name="doornumber"></td><td rowspan="2">Door Name:<td colspan="3" rowspan="2"><textarea rows="2"cols = "40"  name="doorname"></textarea></td>
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
		</select></td><td>Surrounding Material:</td><td><select name=surroundingconstruction>
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
$getdooralarm = "SELECT * FROM tbldooralarms";
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
		<td> Using an exsiting lock on this door? <input type="radio" name="elock" value="elock">YES <input type="radio" name="elock" value="noelock" >NO <input type="radio" name="elock" value="none" CHECKED> No Lock on this Door</td>
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
		<td>Notes:</td><td><textarea rows="5" cols="80" name="notes"></textarea></td>
	</tr>
</table>
	<table cellpadding=2  width="750"  align ="center">
			<td><input type="submit" value="Add Door" name="done"></td>
			</tr>
		</table>
</form>
<table cellpadding=2  width="750"  align ="center">
	<tr>
		<td><button onClick="window.location='doorunit.php?action=UPDATE&f_id=<?php echo $facilityID; ?>'">Cancel</button></td>
	</tr>
</table>
	<table width ="750" align ="center">
	<?php
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
																							// Raceway If statement
/*
	if (($surroundingconstruction =="surround1" or  $surroundingconstruction =="surround2") & ($doortype == "doortype1" or  $doortype == "doortype3" or $doortype == "doortype5" or $doortype == "doortype9"))
	{ 
		$racepack=1;
	} elseif   (($surroundingconstruction == "surround1" or  $surroundingconstruction =="surround2") & ($doortype == "doortype2" or  $doortype == "doortype4" or $doortype == "doortype6" or $doortype == "doortype7"))
	{
		$racepack=2;
	}else
	{ 
		$racepack=0;
	}
	*/	
																		//Reed Switch If Statement
	if ((($doortype == "doortype2") or  ($doortype == "doortype4") or ($doortype == "doortype6")) & ($setuptype<>"door4"))
	{
		($reed = 2 & $racepack=2);
	} elseif  ((($doortype == "doortype1") or  ($doortype == "doortype3") or ($doortype == "doortype5"))or (($doortype == "doortype7") or ($doortype == "doortype9") & ($setuptype<>"door4")))
	{
		($reed = 1 & $racepack=1);
	} else
	{
		($reed = 0 & $racepack=0);
	} 
	
	if ($doortype =="doortype8")
	{
		$oreed = 1;
	} else
	{
		$oreed =0;
	}
		

if  ($setuptype=="door4")
	{
		$PIR=1;
	} else
	{
		$PIR=0;
	}

				//Door Unit If Statements
	if (($setuptype=="door1") & ($doortype <> "doortype8"))
	{
		($doorunit = 1) &($odoor=0) & ($minilock = 0) & ($zbracket=0) & ($keypadx=0) & ($ut=0) & ($timer=0) & ($relay = 0);
	}
	elseif (($setuptype=="door1") & ($doortype == "doortype8"))
	{
		($doorunit = 0) & ($odoor = 1);
	}
	elseif ($setuptype=="door2" & ($doortype == "doortype1" & ($elock == "noelock")))
	{
		($doorunit = 1) & ($minilock = 1);
	}
	elseif ($setuptype=="door2" & ($doortype == "doortype1" & ($elock == "elock")))
	{
		($doorunit = 1) & ($minilock = 0);
	}
	elseif ($setuptype=="door2" & ($doortype == "doortype2" & ($elock == "noelock")))
	{
		($doorunit = 1) & ($minilock = 2);
	}
		elseif ($setuptype=="door2" & ($doortype == "doortype2" & ($elock == "elock")))
	{
		($doorunit = 1) & ($minilock = 0);
	}
	elseif (($setuptype=="door2" & ($elock == "noelock")) & ($doortype == "doortype3"))
	{
		($doorunit = 1) & ($zbracket = 1);
	}
	elseif (($setuptype=="door2" & ($elock == "elock")) & ($doortype == "doortype3"))
	{
		($doorunit = 1) & ($zbracket = 0);
	}	
	elseif (($setuptype=="door2" & ($elock == "noelock")) & ($doortype == "doortype5"))
	{
		($doorunit = 1) & ($zbracketoutdoor = 1);
	}	
	elseif (($setuptype=="door2" & ($elock == "elock")) & ($doortype == "doortype5"))
	{
		($doorunit = 1) & ($zbracketoutdoor = 0);
	}
	 elseif (($setuptype=="door2" & ($elock == "noelock")) & ($doortype == "doortype4"))
	{
		($doorunit = 1) & ($zbracket = 2);
	}
	elseif (($setuptype=="door2" & ($elock == "elock")) & ($doortype == "doortype4"))
	{
		($doorunit = 1) & ($zbracket = 0);
	}
	elseif (($setuptype=="door2" & ($elock == "noelock")) & ($doortype == "doortype6"))
	{
		($doorunit = 1) & ($zbracketoutdoor = 2);
	}	
	elseif (($setuptype=="door2" & ($elock == "elock")) & ($doortype == "doortype6"))
	{
		($doorunit = 1) & ($zbracketoutdoor = 0);
	}		
	elseif ($setuptype=="door3" & ($doortype == "doortype1" & ($elock == "noelock")))
	{
		($doorunit = 1) &($minilock = 1) & ($keypadx = 1) &  ($timer = 1);
	}
		elseif ($setuptype=="door3" & ($doortype == "doortype1" & ($elock == "elock")))
	{
		($doorunit = 1) &($minilock = 0) & ($keypadx = 1) &  ($timer = 1);
	}
	elseif ($setuptype=="door3" & ($doortype == "doortype2" & ($elock == "noelock")))
	{
		($doorunit = 1) &($minilock = 2) & ($keypadx = 1) &  ($timer = 1);
	}
		elseif ($setuptype=="door3" & ($doortype == "doortype2" & ($elock == "elock")))
	{
		($doorunit = 1) &($minilock =0) & ($keypadx = 1) &  ($timer = 1);
	}
	elseif (($setuptype=="door3" & ($elock == "noelock")) & ($doortype == "doortype3"))
	{
		($doorunit = 1) & ($zbracket = 1) & ($keypadx = 1) & ($timer = 1);
	}
		elseif (($setuptype=="door3" & ($elock == "elock")) & ($doortype == "doortype3"))
	{
		($doorunit = 1) & ($zbracket = 0) & ($keypadx = 1) & ($timer = 1);
	}
	elseif (($setuptype=="door3" & ($elock == "noelock")) & ($doortype == "doortype5"))
	{
		($doorunit = 1) & ($zbracketoutdoor = 1) & ($keypadx = 1) & ($timer = 1);
	}
	elseif (($setuptype=="door3" & ($elock == "elock")) & ($doortype == "doortype5"))
	{
		($doorunit = 1) & ($zbracketoutdoor = 0) & ($keypadx = 1) & ($timer = 1);
	}	
	 elseif (($setuptype=="door3" & ($elock == "noelock")) & ($doortype == "doortype4"))
	{
		($doorunit = 1) & ($zbracket = 2) & ($keypadx = 1) & ($timer = 1);
	}
		 elseif (($setuptype=="door3" & ($elock == "elock")) & ($doortype == "doortype4"))
	{
		($doorunit = 1) & ($zbracket = 0) & ($keypadx = 1) & ($timer = 1);
	}
	 elseif (($setuptype=="door3" & ($elock == "noelock")) & ($doortype == "doortype6"))
	{
		($doorunit = 1) & ($zbracketoutdoor = 2) & ($keypadx = 1) & ($timer = 1);	
	}
	elseif (($setuptype=="door3" & ($elock == "elock")) & ($doortype == "doortype6"))
	{
		($doorunit = 1) & ($zbracketoutdoor = 0) & ($keypadx = 1) & ($timer = 1);	
	}
	elseif (($setuptype=="door4") & ($doortype <> "doortype8"))
	{
		$doorunit = 1;
	}
	elseif ($setuptype=="door4" & ($doortype == "doortype8"))
	{
		($doorunit = 0) & ($odoor = 1);
	}
	elseif (($setuptype=="door5") & (($doortype == "doortype7") or ($doortype=="doortype9")))
	{
		($doorunit = 1) & ($relay = 1);
	}
	elseif (($setuptype=="door5") & (($doortype <> "doortype7") or ($doortype <> "doortype9")))
	{
		$doorunit = 1;
	}
	elseif (($setuptype=="door6") &(($doortype == "doortype7") or ($doortype=="doortype9")))
	{
		($doorunit = 1) & ($relay = 1);
	}
	elseif (($setuptype=="door6") & (($doortype <> "doortype7") or ($doortype <> "doortype9")))
	{
		$doorunit = 1;
	}
	elseif ($setuptype=="door7" & ($doortype == "doortype1" & ($elock == "noelock")))
	{
		($keypadx = 1) & ($minilock = 1);
	}
		elseif ($setuptype=="door7" & ($doortype == "doortype1" & ($elock == "elock")))
	{
		($keypadx = 1) & ($minilock = 0);
	}
	elseif ($setuptype=="door7" & ($doortype == "doortype2" & ($elock == "noelock")))
	{
		($keypadx = 1) & ($minilock = 2);
	}
		elseif ($setuptype=="door7" & ($doortype == "doortype2" & ($elock == "elock")))
	{
		($keypadx = 1) & ($minilock = 0);
	}
	elseif (($setuptype=="door7" & ($elock == "noelock")) &  ($doortype == "doortype3"))
	{
		($keypadx = 1) & ($zbracket = 1);
	}
		elseif (($setuptype=="door7" & ($elock == "elock")) & ($doortype == "doortype3"))
	{
		($keypadx = 1) & ($zbracket = 0);
	}
	elseif (($setuptype=="door7" & ($elock == "noelock")) & ($doortype == "doortype5"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 1);
	}
	elseif (($setuptype=="door7" & ($elock == "elock")) & ($doortype == "doortype5"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 0);
	}
	 elseif (($setuptype=="door7" & ($elock == "noelock")) & ($doortype == "doortype4"))
	{
		($keypadx = 1) & ($zbracket = 2);
	}
		 elseif (($setuptype=="door7" & ($elock == "elock")) & ($doortype == "doortype4"))
	{
		($keypadx = 1) & ($zbracket = 0);
	}
	 elseif (($setuptype=="door7" & ($elock == "noelock")) & ($doortype == "doortype6"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 2);
	}	
	 elseif (($setuptype=="door7" & ($elock == "elock")) & ($doortype == "doortype6"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 0);
	}		
		elseif ($setuptype=="door8" & ($doortype == "doortype1" & ($elock == "noelock")))
	{
		($ut = 1) & ($minilock = 1) & ($keypadx = 1) & ($timer = 1) & ($ut = 1);
	}
		elseif ($setuptype=="door8" & ($doortype == "doortype1" & ($elock == "elock")))
	{
		($ut = 1) & ($minilock = 0) & ($keypadx = 1) & ($timer = 1) & ($ut = 1);
	}
	elseif ($setuptype=="door8" & ($doortype == "doortype2" & ($elock == "noelock")))
	{
		($ut = 1) & ($minilock = 2) & ($keypadx = 1) & ($timer = 1 & ($ut = 1));
	}
	elseif ($setuptype=="door8" & ($doortype == "doortype2" & ($elock == "elock")))
	{
		($ut = 1) & ($minilock = 0) & ($keypadx = 1) & ($timer = 1) & ($ut = 1);
	}
	elseif (($setuptype=="door8" & ($elock == "noelock")) & ($doortype == "doortype3"))
	{
		($ut = 1) & ($zbracket = 1) & ($keypadx = 1) & ($timer = 1) & ($ut = 1);
	}
	elseif (($setuptype=="door8" & ($elock == "elock")) & ($doortype == "doortype3"))
	{
		($ut = 1) & ($zbracket = 0) & ($keypadx = 1) & ($timer = 1) & ($ut = 1);
	}
	elseif (($setuptype=="door8" & ($elock == "noelock")) & ($doortype == "doortype5"))
	{
		($ut = 1) & ($zbracketoutdoor = 1) & ($keypadx = 1) & ($timer = 1) & ($ut = 1);
	}
	elseif (($setuptype=="door8" & ($elock == "noelock")) & ($doortype == "doortype5"))
	{
		($ut = 1) & ($zbracketoutdoor = 0) & ($keypadx = 1) & ($timer = 1) & ($ut = 1);
	}
	 elseif (($setuptype=="door8" & ($elock == "noelock")) & ($doortype == "doortype4"))
	{
		($ut = 1 & $zbracket = 2 & $keypadx = 1 & $timer = 1) & ($ut = 1);
	}
	 elseif (($setuptype=="door8" & ($elock == "elock")) & ($doortype == "doortype4"))
	{
		($ut = 1 & $zbracket = 0 & $keypadx = 1 & $timer = 1) & ($ut = 1);
	}
	elseif (($setuptype=="door8" & ($elock == "noelock")) & ($doortype == "doortype6"))
	{
		($ut = 1 & $zbracketoutdoor = 2 & $keypadx = 1 & $timer = 1) & ($ut = 1);
	}	
	elseif (($setuptype=="door8" & ($elock == "elock")) & ($doortype == "doortype6"))
	{
		($ut = 1 & $zbracketoutdoor = 0 & $keypadx = 1 & $timer = 1) & ($ut = 1);
	}		
	elseif ($setuptype=="door9" & ($doortype == "doortype1" & ($elock == "noelock")))
	{
		($keypadx = 1) & ($minilock = 1) & ($ut=1);
	}
	elseif ($setuptype=="door9" & ($doortype == "doortype1" & ($elock == "elock")))
	{
		($keypadx = 1) & ($minilock = 0) & ($ut=1);
	}
	elseif ($setuptype=="door9" & ($doortype == "doortype2" & ($elock == "noelock")))
	{
		($keypadx = 1) & ($minilock = 2) & ($ut=1);
	}
	elseif ($setuptype=="door9" & ($doortype == "doortype2" & ($elock == "elock")))
	{
		($keypadx = 1) & ($minilock = 0) & ($ut=1);
	}
	elseif (($setuptype=="door9" & ($elock == "noelock")) & ($doortype == "doortype3"))
	{
		($keypadx = 1) & ($zbracket = 1) & ($ut=1);
	}
	elseif (($setuptype=="door9" & ($elock == "elock")) & ($doortype == "doortype3"))
	{
		($keypadx = 1) & ($zbracket = 0) & ($ut=1);
	}
	elseif (($setuptype=="door9" & ($elock == "noelock")) & ($doortype == "doortype5"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 1) & ($ut=1);
	}
	elseif (($setuptype=="door9" & ($elock == "elock")) & ($doortype == "doortype5"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 0) & ($ut=1);
	}
	 elseif (($setuptype=="door9" & ($elock == "noelock")) & ($doortype == "doortype4"))
	{
		($keypadx = 1) & ($zbracket = 2) & ($ut=1);
	}
	 elseif (($setuptype=="door9" & ($elock == "elock")) & ($doortype == "doortype4"))
	{
		($keypadx = 1) & ($zbracket = 0) & ($ut=1);
	}
	 elseif (($setuptype=="door9" & ($elock == "noelock")) & ($doortype == "doortype6"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 2) & ($ut=1);
	}	
	 elseif (($setuptype=="door9" & ($elock == "noelock")) & ($doortype == "doortype6"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 0) & ($ut=1);
	}		
	elseif ($setuptype=="door10" & ($doortype == "doortype1" & ($elock == "noelock")))
	{
		($keypadx = 1) & ($minilock = 1) & ($ut=1);
	}
	elseif ($setuptype=="door10" & ($doortype == "doortype1" & ($elock == "elock")))
	{
		($keypadx = 1) & ($minilock = 0) & ($ut=1);
	}
	elseif ($setuptype=="door10" & ($doortype == "doortype2" & ($elock == "noelock")))
	{
		($keypadx = 1) & ($minilock = 2) & ($ut=1);
	}
	elseif ($setuptype=="door10" & ($doortype == "doortype2" & ($elock == "elock")))
	{
		($keypadx = 1) & ($minilock = 0) & ($ut=1);
	}
	elseif (($setuptype=="door10" & ($elock == "noelock")) & ($doortype == "doortype3"))
	{
		($keypadx = 1) & ($zbracket = 1) & ($ut=1);
	}
	elseif (($setuptype=="door10" & ($elock == "elock")) & ($doortype == "doortype3"))
	{
		($keypadx = 1) & ($zbracket = 0) & ($ut=1);
	}
	elseif (($setuptype=="door10" & ($elock == "noelock")) & ($doortype == "doortype5"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 1) & ($ut=1);
	}	
	elseif (($setuptype=="door10" & ($elock == "elock")) & ($doortype == "doortype5"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 0) & ($ut=1);
	}		
	elseif (($setuptype=="door10" & ($elock == "noelock")) & ($doortype == "doortype4"))
	{
		($keypadx = 1) & ($zbracket = 2) & ($ut=1);
	}
	elseif (($setuptype=="door10" & ($elock == "elock")) & ($doortype == "doortype4"))
	{
		($keypadx = 1) & ($zbracket = 0) & ($ut=1);
	}
	elseif (($setuptype=="door10" & ($elock == "noelock")) & ($doortype == "doortype6"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 2) & ($ut=1);
	}	
	elseif (($setuptype=="door10" & ($elock == "elock")) & ($doortype == "doortype6"))
	{
		($keypadx = 1) & ($zbracketoutdoor = 0) & ($ut=1);
	}		
	elseif ($setuptype=="door11")
	{
		$ut = 1;
	}
	elseif ($setuptype=="door12")
	{
		($ut = 1) & ($keypadx = 1) ;
	}
	elseif ($setuptype=="door13")
	{
		($ut = 1) & ($keypadx = 1);
	}
	elseif($setuptype=="door14")
	{
		($keypadx = 0) & ($doorunit = 0) & ($zbracket = 0) & ($timer = 0) & ($odoor = 0) & ($ut = 0) & ($relay = 0) & ($minilock = 0) & ($reed = 0) & ($racepack=0) & ($PIR=0);
	}
	elseif($setuptype=="door15")	
	{
		($ut = 1) & ($reed = 0); 	
	}
	else 
	{
		($setuptype="Unknown Door Configuration")& ($keypadx = 0) & ($doorunit = 0) & ($zbracket = 0) & ($timer = 0) & ($odoor = 0) & ($ut = 0) & ($relay = 0) & ($minilock = 0) & ($reed = 0) & ($racepack=0) & ($PIR=0);
?>
		
		<tr>
			<td>Unknown Door Configuration</td>
		</tr>
<?php
	}
	if(($ut > 0 && $utpower1 == "none") OR ($ut < 1 && $utpower1 <> "none"))
		{
			($setuptype="Unknown Door Configuration")& ($keypadx = 0) & ($doorunit = 0) & ($zbracket = 0) & ($timer = 0) & ($odoor = 0) & ($ut = 0) & ($relay = 0) & ($minilock = 0) & ($reed = 0) & ($racepack=0) & ($PIR=0);
		}
	if(((($zbracket > 0) OR ($minilock > 0) OR ($zbracketoutdoor > 0)) & ($elock == "none")) OR (($zbracket < 1 AND $minilock < 1 AND $zbracketoutdoor < 1) & ($elock == "no")))
		{
			($setuptype="Unknown Door Configuration")& ($keypadx = 0) & ($doorunit = 0) & ($zbracket = 0) & ($timer = 0) & ($odoor = 0) & ($ut = 0) & ($relay = 0) & ($minilock = 0) & ($reed = 0) & ($racepack=0) & ($PIR=0);
		}
		
if($setuptype <> "door14")
	{		
  if($bypass=="bypass1")
		{
			($keypad =$keypadx + 1) & ($pushbutton = 0);
		}elseif ($bypass=="bypass2")
		{
			($pushbutton= 1) & ($keypad = $keypadx);
		} else
		{
			($keypad = $keypadx)  & ($pushbutton = 0);
		}
	}else
	{
		$keypad = 0;
		$keypadx = 0;
		$pushbutton = 0;
		$bypass = "NONE";
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

if(isset($_GET['done']))
{		
	if($setuptype == "Unknown Door Configuration")
		{
?>
			<tr>
				<td>
					The Scope of work does not understand this configuration.  IF you think its a valid configuration contact Drew. This door has not been saved.
				</td>
			</tr>
						<tr>
				<td>
					Click the back button to go back to the door setup or cancel this door.
				</td>
			</tr>
			<tr>
				<td>
					Common issues: <br>
					1. Make sure you selected an Alarm Type <br>
					2. Make sure you have not placed a lock on an elevator <br>
					3. Make sure you have not picked a setup that includes a lock but have chosen "No lock on this door" <br>
					4. Make sure you have not picked a setup that includes a UT but have chosen "No UT on this door"
				</td>
			</tr>
<?php			
		}else
		{			
			$facilityID = $_GET["f_id"];
 			$query="INSERT INTO tblfacilitydoors (doornumber,doortype,FacilityID,doorframematerial,surroundingconstruction,alarmfunctionID,reedswitchcount,doorunitcount,keypadcount,
   						pushbuttoncount,minilockcount,zbracket,zbracketoutdoor,timercount,outdoordoorunitCount,outdoorreedcount,utcount,racepackcount,pircount,notes,relaycount,doorname, bypass, signature, utpower1, elock, egresskit, variance) 
   						VALUES  ('$doornumber','$doortype','$facilityID','$framematerial','$surroundingconstruction','$setuptype','$reed','$doorunit','$keypad','$pushbutton','$minilock','$zbracket','$zbracketoutdoor','$timer',
   						'$odoor','$oreed','$ut','$racepack','$PIR','$notes','$relay','$doorname','$bypass','$signature','$utpower1', '$elock','$egresskit','$variance')";
   		mysql_query($query) or die(mysql_error());   
   		header("Location: doorunit.php?action=UPDATE&f_id=$facilityID");
   
 		}
 	}

 if(isset($_GET['save2']))
{		
	if($setuptype == "Unknown Door Configuration")
		{
?>
			<tr>
				<td>
					The Scope of work does not understand this configuration.<br>
					IF you think its a valid configuration contact Drew. This door has not been updated.
				</td>
			</tr>
			<tr>
				<td>
					Click the back button to go back to the door setup or cancel this door.
				</td>
			</tr>
			<tr>
				<td>
					Common issues: <br>
					1. Make sure you selected an Alarm Type <br>
					2. Make sure you have not placed a lock on an elevator <br>
					3. Make sure you have not picked a setup that includes a lock but have chosen "No lock on this door" <br>
					4. Make sure you have not picked a setup that includes a UT but have chosen "No UT on this door"
				</td>
			</tr>
<?php			
		}else
		{			
 	$doorid = $_GET['doorid'];
 	$query5 = "SELECT FacilityID FROM tblfacilitydoors WHERE doorID = '$doorid'";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_fetch_array($result5);
	$facilityID = $row5['FacilityID'];	
 		
 		//echo '<input type = "hidden" name="doorid" value = "'.$doorid.'">';	 
 	 	$query4 = "UPDATE tblfacilitydoors SET doornumber = '$doornumber', doortype = '$doortype', doorframematerial = '$framematerial', surroundingconstruction = '$surroundingconstruction', alarmfunctionID = '$setuptype',
 						reedswitchcount = '$reed', doorunitcount = '$doorunit', keypadcount = '$keypad', pushbuttoncount = '$pushbutton', minilockcount = '$minilock', zbracket = '$zbracket', zbracketoutdoor = '$zbracketoutdoor',timercount = '$timer', outdoordoorunitCount = '$odoor',
 						outdoorreedcount = '$oreed', utcount = '$ut', racepackcount = '$racepack', pircount = '$PIR', notes = '$notes', relaycount = '$relay', doorname = '$doorname', bypass = '$bypass', 
 						utpower1 = '$utpower1', elock = '$elock', egresskit = '$egresskit', variance = '$variance' WHERE doorID = '$doorid'";
 		mysql_query($query4) or die(mysql_error());
 		$query62 = "UPDATE tblfacilitygeneralinfo SET lastupdated = '$date' WHERE ID = '$facilityID'";
		mysql_query($query62) or die(mysql_error());
 		
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
