<?php
include 'header.php';
include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
$date = date('Y-m-d H:i:s');
$signature = $_SESSION['username'];
/*
*SAVING GROUP INFORMATION WHEN COMING FROM FINISHED PAGE AND SAID TO MAKE A COPY AND THE CURRENT QUOTE DID BELONG TO A GROUP*********************
*/
if((isset($_GET['save_group'])) && ($_GET['save_group']=='Save'))
{
	mysql_select_db($dbname2);
	$group_name = $_GET['new_group_name'];
	$facilityid = $_GET['Existing_Facility_ID'];
	$query10 = "INSERT INTO tblgroupquote (FacilityID,GroupName) VALUES ('$facilityid','$group_name')";
	mysql_query($query10) or die(mysql_error());
	$query11 = "SELECT max(ID) FROM tblgroupquote";
	$result11 = mysql_query($query11) or die (mysql_error());
	$row11 = mysql_fetch_array($result11);
	$groupid = $row11['max(ID)'];		
	$query12 = "UPDATE tblfacilitygeneralinfo SET GroupID = '$groupid' WHERE ID = '$facilityid'";
	mysql_query($query12) or die(mysql_error());
	header("Location: addcustomer.php?view=new_to_existing_group&customer_info_from_id=$facilityid");
}
if((isset($_GET['save_facility_to_copy'])) && ($_GET['save_facility_to_copy']=='Save'))
{
	mysql_select_db($dbname2);
	$facilityid = $_GET['facility_to_copy'];
	header("Location: addcustomer.php?view=new_to_existing_group&customer_info_from_id=$facilityid");
}
//*******COMES FROM SEARCHING A GROUP AND CLICKING THE ADD TO GROUP LINK******************//
if((isset($_GET['groupsave'])) && ($_GET['groupsave']=='Next'))
{
	mysql_select_db($dbname2);
	$groupid = $_GET['group'];
	$query13 = "SELECT min(ID) FROM tblfacilitygeneralinfo WHERE GroupID = '$groupid'";
	$result13 = mysql_query($query13) or die (mysql_error());
	$count13 = mysql_num_rows($result13);
	$row13 = mysql_fetch_array($result13);
	if($count13 > 0)
	{
		$cus = $row13['min(ID)'];
		header("Location: addcustomer.php?view=new_to_existing_group&customer_info_from_id=$cus");
	}else
	{
		echo 'No Customer in Group, Please add a new group';
	}
}
/*
***************************************ADD NEW SCOPE/CUSTOMER***************************************
*/
if((isset($_GET['view'])) && ($_GET['view'] == "new") && (!isset($_GET['fname']))) 
{
	//$ref=$_SERVER['HTTP_REFERER'];
	//echo $ref; 
?>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table  width="750"  align ="center">
	<tr>
		<td align=center td colspan="5"><font size=4 face = "Arial"><b>
	  	General Information  
	  </b></font></td>
	</tr>
</table>
	
<table cellpadding=2 table border ="0" width="750"  align ="center">
	<tr>
		<td><font face = "Arial" size = 2"><b>
			Customer Number:
		</b></font><td>
			<input type="text" size="6" maxlength="6" name="custnum"> (ONLY IF CONFIRMED CUSTOMER i.e. 500515 not T123456)
		</td>
	</tr>
	<tr>
		<td width = "115"><font face = "Arial" size = 2"><b>
			Facility Name:
		</b></font></td>
		<td colspan="5"><font face = "Arial" size = 2">
			<input type="text" size="80" maxlength="255" name="Fname">
		</font></td>
	</tr>
	<tr>
		<td><font face = "Arial" size = 2"><b>
			Street Address:
		</b></font></td>
		<td colspan="5"><font face = "Arial" size = 2">
			<input type="text" size="80" maxlength="79" name="Address">
		</font></td>
	</tr>
	<tr>
		<td><font face = "Arial" size = 2"><b>
			City,State,Postal Code:
		</b></font></td>
		<td colspan = "3"><font face = "Arial" size = 2">
			<input type="text" size="32" maxlength="32" name="city">,

			<select name="state">
<?php			
			mysql_select_db($dbname);
			$query1 = "SELECT * FROM tblsalesrepbyterritories WHERE CountryCode = 'US' ORDER BY StateOrProvince";
			$result1 = mysql_query($query1) or die (mysql_error());
			while($row1 = mysql_fetch_array($result1))
				{
?>
					<option value="<?php echo $row1['StateOrProvinceCode']; ?>"><?php echo $row1['StateOrProvince']; ?></option>				
<?php
				}				
?>
			</select>				
			,<input type="text" size="16" maxlength="15" name="zip">
		</font></td>		
	</tr>
	<tr>
		<td><b><font face = "Arial" size = 2">
			Contact Name:
		</font></b></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="32" maxlength="40" name="Contact">
		</font></td>
	</tr>
	<tr>
		<td width = "115"><b>
			Quote Name:
		</b></td>
		<td colspan="5">
			<input type="text" size="80" maxlength="79" name="extname" value = "">
		</td>
	</tr>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			Title:
		</font></b></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="32" maxlength="25" name="Title">
		</font></td>
	</tr>
	<tr>
		<td><b><font face = "Arial" size = 2">
			Phone Number:
		</font></b></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="12" maxlength="10" name="Phone"> e.g. 4143588200
		</font></td>
	</tr>
	<tr>
		<td><b><font face = "Arial" size = 2">
			Second Number:
		</font></b></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="12" maxlength="10" name="Phone2"> e.g. 4143588200
		</font></td>
	</tr>
	<tr>
		<td><font face = "Arial" size = 2"><b>
			Fax:
		</b></font></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="12" maxlength="10" name="Fax"> e.g. 4143588100
		</font></td>
	</tr>
	<tr>
		<td><font face = "Arial" size = 2"><b>
			Email:
		</b></font></td>
		<td><font face = "Arial" size = 2">
			<input type="text" size="32" maxlength="60" name="Email">
		</font></td>
	</tr>	
	<tr>
		<td><font face = "Arial" size = 2"><b>
			System Type:
		</b></font></td>
		<td><font face = "Arial" size = 2">
			<select name=Systype>
  			<option value ="On-Call">On-Call</option>
  			<option value ="On-Site">On-Site</option>
  			<option value ="Elite">Elite</option>
  		</select>
  	</font></td>
  </tr>
  <tr>
  	<td><b>
  		Expansion:
  	</b></td>
  	<td>
			<select name=expansion>
				<option value ="0">NO</option>
				<option value ="1">YES</option>
			</select>
		</td>
  </tr>
  <tr> 		
  	<td><font face = "Arial" size = 2"><b>
  			Salesperson:
  	</b></font></td>
  	<td><font face = "Arial" size = 2">
<?php
 				mysql_select_db($dbname);
				$query4 = "SELECT id, f_name, l_name FROM employees WHERE dept = 1 AND Active = 0 ORDER BY l_name";
				$result4 = mysql_query($query4) or die (mysql_error());
?>
				<select name=sman>
				<option value="0">None</option>
<?php
				while($row4 = mysql_fetch_array($result4))
				{
?>
					<option value="<?php echo $row4['id']; ?>"><?php echo $row4['f_name']. ' '. $row4['l_name']; ?></option>
									
<?php
				}
?>
			</select>
     </font></td>
	</tr>
<?php
	if(isset($_GET['groupid']))
	{
		mysql_select_db($dbname2);
		$groupid = $_GET['groupid'];
		$query12 = "SELECT GroupName FROM tblgroupquote WHERE ID = '$groupid'";
		$result12 = mysql_query($query12) or die (mysql_error());
		$row12 = mysql_fetch_array($result12);	
		echo	'<input type = "hidden" name="groupid" value = "'.$groupid.'">';
?>
		<tr>
			<td><b>
				Group:
			</b></td>
			<td>
				<?php echo $row12['GroupName']; ?>
			</td>
		</tr>		
<?php
	}
?>  
	<tr>
		<td><font face = "Arial" size = 2">
			<input type="submit" value="Save" name="save">
		</font></td>
	</tr>
</table>
<?php
}
/*
***************************************SAVE/ADD NEW SCOPE/CUSTOMER***************************************
*/
if((isset($_GET['save'])) && ($_GET['save']=="Save"))
{
	mysql_select_db($dbname2);
	$checkfname = "SELECT FacilityName FROM tblfacilitygeneralinfo";
	$rescheckfname = mysql_query($checkfname) or die (mysql_error());
			
	$Fname =addslashes( $_GET["Fname"]);
	$custnumb = $_GET['custnum'];
	if($custnumb > 499999)
	{
		$custnum = $_GET['custnum'];
	}else
	{
		$custnum = '-1';
	}
	$Address = $_GET["Address"];
	$Contact= $_GET["Contact"];
	$Phone =$_GET["Phone"];
	$second =  $_GET["Phone2"];
	$Title = $_GET["Title"];
	$Email = $_GET["Email"];
	$Fax =  $_GET["Fax"];
	$System = $_GET["Systype"];
	$sman = $_GET["sman"];
	$city = $_GET["city"];
	$zip = $_GET["zip"];
	$statecode = $_GET["state"];
	$pricelist = 0;
	$expansion = $_GET['expansion'];
	$extname = $_GET['extname'];	
	if(isset($_GET['groupid']))
	{
		$groupid = $_GET['groupid'];
	}
/*
***************************************QUERY IF DUPLICATE FACILITY NAME***************************************
*/	
	if(((isset($_GET['add_to_group'])) && ($extname <> '')) || (!isset($_GET['add_to_group'])))
	{				
		$query="INSERT INTO tblfacilitygeneralinfo (FacilityName, Cust_Num,StreetAddress,PhoneNumber,ContactName,secondnumber,Title,Email,Fax,SystemType,Expansion,Salesman, signature, lastupdated,City,PostalCode,StateOrProvinceCode,pricelist,QuoteName) 
						VALUES ('$Fname', '$custnum','$Address', '$Phone', '$Contact', '$second','$Title','$Email','$Fax','$System','$expansion','$sman','$signature', '$date', '$city','$zip', '$statecode','$pricelist','$extname')";
		mysql_query($query) or die(mysql_error());			
		$query2 = "SELECT max(ID) FROM tblfacilitygeneralinfo";
		$result2 = mysql_query($query2) or die (mysql_error());
		$row2 = mysql_fetch_array($result2);
		$currentid = $row2['max(ID)'];
		if(isset($_GET['groupid']))
		{
			$query9 = "UPDATE tblgroupquote SET FacilityID = '$currentid' WHERE ID = '$groupid'";
			mysql_query($query9) or die(mysql_error());
			$query17 = "UPDATE tblfacilitygeneralinfo SET GroupID = '$groupid' WHERE ID = '$currentid'";
			mysql_query($query17) or die(mysql_error());						
		}
		$addequipment = "INSERT INTO tbltotalequipment (FacilityID) VALUES ('$currentid')";
		mysql_query($addequipment) or die(mysql_error());		
		$addother="INSERT INTO tbladditionalcontacts (FacilityID) VALUES ('$currentid')";		
		mysql_query($addother) or die(mysql_error());		
		$addproject ="INSERT INTO tblprojectmanagement (FacilityID) VALUES ('$currentid')";		
		mysql_query($addproject) or die(mysql_error());
		//**************ENTERING PAGE FROM SEARCHING GROUP AND SELECTING ADD TO GROUP*********************//
		if(isset($_GET['add_to_group']))
		{
			$existing_facility_id = $_GET['Existing_Facility_ID'];
			$query23 = "SELECT * FROM tblfacilitydoors WHERE FacilityID = '$existing_facility_id'";
			$result23 = mysql_query($query23) or die (mysql_error());
			while($row23 = mysql_fetch_array($result23))
			{
				$doornumber = $row23['doornumber'];
				$doortype = $row23['doortype'];
				$doorframematerial = $row23['doorframematerial'];
				$surroundingconstruction = $row23['surroundingconstruction'];
				$alarmfunctionID = $row23['alarmfunctionID'];
				$reedswitchcount = $row23['reedswitchcount'];
				$doorunitcount = $row23['doorunitcount'];
				$keypadcount = $row23['keypadcount'];
				$pushbuttoncount = $row23['pushbuttoncount'];
				$minilockcount = $row23['minilockcount'];
				$zbracket = $row23['zbracket'];
				$zbracketoutdoor = $row23['zbracketoutdoor'];
				$timercount = $row23['timercount'];
				$outdoordoorunitCount = $row23['outdoordoorunitCount'];
				$outdoorreedcount = $row23['outdoorreedcount'];
				$utcount = $row23['utcount'];
				$racepackcount = $row23['racepackcount'];
				$pircount = $row23['pircount'];
				$notes = $row23['notes'];
				$relaycount = $row23['relaycount'];
				$doorname = $row23['doorname'];
				$bypass = $row23['bypass'];
				$signature = $row23['signature'];
				$utpower1 = $row23['utpower1'];
				$elock = $row23['elock'];
				$egresskit = $row23['egresskit'];
				$variance = $row23['variance'];
				$extboard = $row23['extboard'];
				$buzzer = $row23['buzzer'];
				$query24 = "INSERT INTO tblfacilitydoors (doornumber,doortype,FacilityID,doorframematerial,surroundingconstruction,alarmfunctionID,reedswitchcount,doorunitcount,keypadcount,
   						pushbuttoncount,minilockcount,zbracket,zbracketoutdoor,timercount,outdoordoorunitCount,outdoorreedcount,utcount,racepackcount,pircount,notes,relaycount,doorname, 
   						bypass, signature, utpower1, elock, egresskit, variance,extboard,buzzer) 
   						VALUES  ('$doornumber','$doortype','$currentid','$doorframematerial','$surroundingconstruction','$alarmfunctionID','$reedswitchcount','$doorunitcount',
   						'$keypadcount','$pushbuttoncount','$minilockcount','$zbracket','$zbracketoutdoor','$timercount','$outdoordoorunitCount','$outdoorreedcount','$utcount','$racepackcount','$pircount','$notes',
   						'$relaycount','$doorname','$bypass','$signature','$utpower1', '$elock','$egresskit','$variance','$extboard','$buzzer')";
   		mysql_query($query24) or die(mysql_error());				
			}
			header("Location: addcustomer.php?view=equip&currentid=$currentid&equip=network&existing_id=$existing_facility_id");
		}else
		{
			header("Location: addcustomer.php?view=equip&currentid=$currentid&equip=network");
		}
	//this else indicates that there was no quote name entered and there was a group assigned and will refer them back to the same page//
	}else
	{
		$existing_facility_id = $_GET['Existing_Facility_ID'];
		header("Location: addcustomer.php?view=new_to_existing_group&customer_info_from_id=$existing_facility_id&error=no_quote_name");
	}
}		
/*
***************************************DISPLAY IF DUPLICATE FACILITY NAME***************************************
*/	

/*
***************************************QUERY TO ADD FACILITY NAME AFTER DUPLICATE DETECTED NEW SCOPE***************************************
*/	
/*
***************************************QUERY TO ADD FACILITY NAME AFTER DUPLICATE DETECTED ON UPDATE***************************************
*/	
/*
***************************************ADD EQUIPMENT (HF NETWORK)***************************************
*/		
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "network"))
{
	$currentid = $_GET['currentid'];
	if(isset($_GET['existing_id']))
	{
		mysql_select_db($dbname2);
		$existing_id = $_GET['existing_id'];
		$query16 = "SELECT upgrade,TotalWMUs,addbase,baseconnect,TotalOutdoorAreaUnits,TotalOutdoorSolarUnits FROM tbltotalequipment WHERE FacilityID = '$existing_id'";
		$result16 = mysql_query($query16) or die (mysql_error());
		$row16 = mysql_fetch_array($result16);
	}
?>	
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="750"  align ="center">
			<tr>
				<td colspan="6" align = "center"><font face = "Arial" size = 4"><b>
					Equipment
				</b></font></td>
			</tr>
			<tr>
				<td colspan = "6" align = "center"><font face = "Arial" size = 2"><b>
					Server
				</td>
			</tr>			
			<tr>
				<td colspan="5">
					Need an upgraded server and sybase?<br>
					The scope of work determines if the system requires sybase and a server upgrade based on how many clients and licenses are listed on the
					Scope.  If you want to upgrade them regardless of the amount of clients/licenses please put a checkmark in the box.
				</td>
<?php
				if(isset($_GET['existing_id']))
				{
					echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
					if($row16['upgrade'] == 1)
					{				
?>						
						<td>
							<input type="checkbox" name="upgrade" value="1" CHECKED>
						</td>	
<?php
					}else
					{
?>						
						<td>
							<input type="checkbox" name="upgrade" value="1">
						</td>			
<?php
					}
				}else
				{
?>									
					<td>
						<input type="checkbox" name="upgrade" value="1">
					</td>
<?php
				}
?>									
			</tr>					
			<tr>
				<td colspan = "6" align = "center"><font face = "Arial" size = 2"><b>
					Network
				</td>
			</tr>
			<tr>
				<td><b>
					Base Unit Information 
				</b></td>
			</tr>					
			<tr>	
<?php		
			if(isset($_GET['existing_id']))
			{					
				if($row16['baseconnect'] == "network") 
				{
?>
					<td colspan="6">
						<input type="radio" name="baseconnect" value="serial"> Base unit via Serial Port 
			 			<input type="radio" name="baseconnect" value="network"CHECKED> All Base Units Networked
					</td>
<?php
				}else
				{
?>
					<td colspan="6">
						<input type="radio" name="baseconnect" value="serial" CHECKED> Base unit via Serial Port 
			 			<input type="radio" name="baseconnect" value="network"> All Base Units Networked
					</td>
<?php
				}
			}else
			{
?>							
					<td>
						<input type="radio" name="baseconnect" value="serial" CHECKED>Base unit via Serial Port 
					</td>
					<td>
	 					<input type="radio" name="baseconnect" value="network">All Base Units Networked
					</td>
<?php
			}
?>																
			</tr>			
			<tr>
				<td colspan="5">
					Additional Base Units? <br>Unless you have chosen <b>expansion</b> the Scope of work automatically detects the amount of base units according to the amount of WMU's and Door WMU's,
					if you need to add more due to the layout of a campus or building please enter the amount of additional network base units required.
				</td>
<?php
				if(isset($_GET['existing_id']))
				{			
?>						
					<td>
						<input type="text" size="1" maxlength="1" name="addbaseunits" value = "<?php echo $row16['addbase']; ?>">
					</td>	
<?php
				}else
				{
?>
					<td>
						<input type="text" size="1" maxlength="1" name="addbaseunits" value = "0">
					</td>	
<?php
				}
?>													
			</tr>		
			<tr>
				<td>
					<br>
				</td>
			</tr>
			<tr>
<?php					
			if(isset($_GET['existing_id']))
			{
?>						
				<td>				
					Area Units: <input type="text" size="5" maxlength="4" name="wmu" value = "<?php echo $row16['TotalWMUs'];?>">
				</td>
				<td>
					Outdoor Area Units: <input type="text" size="5" maxlength="4" name="owmu" value = "<?php echo $row16['TotalOutdoorAreaUnits'];?>">
				</td>
				<td>
					Solar Outdoor Area Units: <input type="text" size="5" maxlength="4" name="sowmu" value = "<?php echo $row16['TotalOutdoorSolarUnits'];?>">
				</td>
<?php
			}else
			{
?>
				<td>
					Area Units: <input type="text" size="5" maxlength="4" name="wmu" value = "0">
				</td>
				<td>
					Outdoor Area Units: <input type="text" size="5" maxlength="4" name="owmu" value = "0">
				</td>
				<td>
					Solar Outdoor Area Units: <input type="text" size="5" maxlength="4" name="sowmu" value = "0">
				</td>					
<?php					
			}
?>									
			</tr>		
			<tr>
				<td>
					<input type="submit" value="Save" name="savenetwork">
				</td>
			</tr>											
		</table>
<?php
		echo	'<input type = "hidden" name="currentid" value = "'.$currentid.'">';
?>		
	</form>
<?php	
}
/*
***************************************QUERY TO ADD EQUIPMENT (HF NETWORK)***************************************
*/
if((isset($_GET['savenetwork'])) && ($_GET['savenetwork'] == "Save"))
{
	mysql_select_db($dbname2);
	$wmu = $_GET['wmu'];
	$owmu = $_GET['owmu'];
	$sowmu = $_GET['sowmu'];
	$baseconnect = $_GET['baseconnect'];
	$addbaseunits = $_GET['addbaseunits'];
	if(isset($_GET['upgrade']))
	{
		$upgrade = 1;
	}else
	{
		$upgrade = 0;
	}
	$f_id = $_GET['currentid'];
	$addnetwork = "UPDATE tbltotalequipment SET TotalWMUs='$wmu',TotalOutdoorAreaUnits = '$owmu',TotalOutdoorSolarUnits = '$sowmu',
								baseconnect = '$baseconnect', addbase = '$addbaseunits', upgrade = '$upgrade' WHERE FacilityID = '$f_id'";
	mysql_query($addnetwork) or die(mysql_error());
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		header("Location: addcustomer.php?view=equip&equip=accessories&f_id=$f_id&existing_id=$existing_id");
	}else
	{	
		header("Location: addcustomer.php?view=equip&equip=accessories&f_id=$f_id");
	}
}
/*
***************************************FORM TO ADD EQUIPMENT (ACCESSORIES)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "accessories"))
{
	mysql_select_db($dbname2);
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		$query17 = "SELECT TotalWatches,FemalePW,straplessPW,TotalPanicButtons,TotalPullTags,pendant,watchstyle FROM tbltotalequipment WHERE FacilityID = '$existing_id'";
		$result17 = mysql_query($query17) or die (mysql_error());
		$row17 = mysql_fetch_array($result17);		
	}
	$f_id = $_GET['f_id'];
	$getsystype = "SELECT SystemType FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
	$resgetsystype = mysql_query($getsystype) or die (mysql_error());		
	$systype = mysql_fetch_array($resgetsystype);
	$system = $systype['SystemType'];
?>		
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="450"  align ="center">
			<tr>
				<td align=center colspan = "6"><font size=3 face = "Arial"><b>  
					Accessories  </strong>
				</b></td>
			</tr>	

<?php
			if(isset($_GET['existing_id']))
			{
				echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
				if($system <> "On-Call")
				{			
?>							
					<tr>
						<td width = 100><font face = "Arial" size = 2">
							Male Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="watch" value = "<?php echo $row17['TotalWatches'];?>">
						</td>
						<td width = 100><font face = "Arial" size = 2">
							Female Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="fwatch" value = "<?php echo $row17['FemalePW'];?>">
						</td>
						<td width = 100><font face = "Arial" size = 2">
							Strapless Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="swatch" value = "<?php echo $row17['straplessPW'];?>">
						</td>						
					</tr>
<?php
				}
				if($system <> "On-Site")						
				{
?>
					<tr>
						<td width = 100><font face = "Arial" size = 2">
							Call Buttons 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="callb" value = "<?php echo $row17['TotalPanicButtons'];?>">
						</td>
						<td width = 100><font face = "Arial" size = 2">
							Pull Tags 
						</td>
						<td><font face = "Arial" size = 2">
							<input type="text" size="5" maxlength="4" name="tags" value = "<?php echo $row17['TotalPullTags'];?>">
						</td>
					</tr>
					<tr>
						<td colspan = "6">
							<div align="center"><hr width="50%"></div>
						</td>
					</tr>
					<tr>
						<td width = 100><font face = "Arial" size = 2">
							Pendant Style Attachments 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="pendant" value = "<?php echo $row17['pendant'];?>">
						</td>
						<td width = 100><font face = "Arial" size = 2">
							Watch Style Attachments 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="watchstyle" value = "<?php echo $row17['watchstyle'];?>">
						</td>
					</tr>					
<?php
				}				
			}else
			{
				if($system <> "On-Call")
				{			
?>							
					<tr>
						<td width = 100><font face = "Arial" size = 2">
							Male Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="watch" value = "0">
						</td>
						<td width = 100><font face = "Arial" size = 2">
							Female Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="fwatch" value = "0">
						</td>
						<td width = 100><font face = "Arial" size = 2">
							Strapless Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="swatch" value = "0">
						</td>						
					</tr>
<?php
				}
				if($system <> "On-Site")						
				{
?>
					<tr>
						<td width = 100><font face = "Arial" size = 2">
							Call Buttons 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="callb" value = "0">
						</td>
						<td width = 100><font face = "Arial" size = 2">
							Pull Tags 
						</td>
						<td><font face = "Arial" size = 2">
							<input type="text" size="5" maxlength="4" name="tags" value = "0">
						</td>
					</tr>
					<tr>
						<td colspan = "6">
							<div align="center"><hr width="50%"></div>
						</td>
					</tr>
					<tr>
						<td width = 100><font face = "Arial" size = 2">
							Pendant Style Attachments 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="pendant" value = "0">
						</td>
						<td width = 100><font face = "Arial" size = 2">
							Watch Style Attachments 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="watchstyle" value = "0">
						</td>
					</tr>					
<?php
				}
			}
?>										
			<tr>
			<td>
				<input type="submit" value="Save" name="saveaccessories" value = "0">
			</td>
			</tr>		
		</table>
<?php
			echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form>
<?php		
	}
/*
***************************************QUERY TO ADD EQUIPMENT (ACCESSORIES)***************************************
*/
if((isset($_GET['saveaccessories'])) && ($_GET['saveaccessories'] == "Save"))
{
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$getsystype = "SELECT SystemType FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
	$resgetsystype = mysql_query($getsystype) or die (mysql_error());		
	$systype = mysql_fetch_array($resgetsystype);
	$system = $systype['SystemType'];
	if($system <> "On-Call")
	{
		$watch = $_GET['watch'];
		$fwatch = $_GET['fwatch'];
		$swatch = $_GET['swatch'];
	}else
	{
		$watch = 0;
		$fwatch = 0;
		$swatch = 0;
	}
	if($system <> "On-Site")
	{
		$callb = $_GET['callb'];
		$tags = $_GET['tags'];
		$pendant = $_GET['pendant'];
		$watchstyle = $_GET['watchstyle'];		
	}else
	{
		$callb = 0;
		$tags = 0;
		$pendant = 0;
		$watchstyle = 0;					
	}				
	$addaccessories = "UPDATE tbltotalequipment SET TotalWatches = '$watch', FemalePW = '$fwatch', straplessPW = '$swatch', TotalPanicButtons = '$callb', TotalPullTags = '$tags', pendant = '$pendant',
	watchstyle = '$watchstyle' WHERE FacilityID = '$f_id'";
	mysql_query($addaccessories) or die(mysql_error());
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		if($system <> "On-Site")
		{
			header("Location: addcustomer.php?view=equip&equip=pullcords&f_id=$f_id&existing_id=$existing_id");		
		}else
		{
			header("Location: addcustomer.php?view=equip&equip=uts&f_id=$f_id&existing_id=$existing_id");
		}		
	}else
	{	
		if($system <> "On-Site")
		{
			header("Location: addcustomer.php?view=equip&equip=pullcords&f_id=$f_id");		
		}else
		{
			header("Location: addcustomer.php?view=equip&equip=uts&f_id=$f_id");
		}
	}
}
/*
***************************************FORM TO ADD EQUIPMENT (PULL CORDS)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "pullcords"))
{		
	$f_id = $_GET['f_id'];
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		mysql_select_db($dbname2);
		$query17 = "SELECT TotalPullCords,TotalPullCordsactivity,TotalCallCords,TotalCallCordssingle15,TotalCallCorddual,CorridorLights,CorridorLightType,
								TotalExistingCorrdiorLights,TotalHomeFreeCorrdiorLights,Squeezeball,breathcall,bedpullcords,bathpullcords,commonpullcords,
								bedpullcordsact,bathpullcordsact,commonpullcordsact FROM tbltotalequipment WHERE FacilityID = '$existing_id'";
		$resgetequip = mysql_query($query17) or die (mysql_error());
		$equip = mysql_fetch_array($resgetequip);	
		$pull = $equip["TotalPullCords"];
		$pullw = $equip["TotalPullCordsactivity"];
		$ten = $equip["TotalCallCords"];
		$fifteen = $equip["TotalCallCordssingle15"];
		$dual = $equip["TotalCallCorddual"];
		$style = $equip["CorridorLights"];
		$type = $equip["CorridorLightType"];
		$existing = $equip["TotalExistingCorrdiorLights"];
		$homefree = $equip["TotalHomeFreeCorrdiorLights"];
		$squeeze = $equip["Squeezeball"];
		$breath = $equip["breathcall"];
		$bed = $equip["bedpullcords"];
		$beda = $equip["bedpullcordsact"];
		$bath = $equip["bathpullcords"];
		$batha = $equip["bathpullcordsact"];
		$common = $equip["commonpullcords"];
		$commona = $equip["commonpullcordsact"];
	}	
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="750"  align ="center">
			<tr>
				<td align=center td colspan ="6"><font size=3 ><b>  
					Pull Cords
				</b></td>
			</tr>
<?php
			if(isset($_GET['existing_id']))
			{
				echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
?>			
				<tr>
					<td>
						Total Number of Pull Cords
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="pull" value = "<?php echo $pull; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Pull Cords in Bedroom
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="bed" value = "<?php echo $bed; ?>">
					</td>
					<td>
						Pull Cords in Bathroom
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="bath" value = "<?php echo $bath; ?>"> 
					</td>
					<td>
						Pull Cords in Common Areas
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="common" value = "<?php echo $common; ?>">	
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Pull Cords with Wellness Check-In
					</b></td>
				</tr>
				<tr>
					<td colspan = "2">
						Total Number of Pull Cords with Wellness
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="pullw" value = "<?php echo $pullw; ?>">
					</td>
				</tr>	
				<tr>
					<td>
						Bedroom
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="beda" value = "<?php echo $beda; ?>">
					</td>
					<td>
						Bathroom
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="batha" value = "<?php echo $batha; ?>">
					</td>
					<td>
						Common
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="commona" value = "<?php echo $commona; ?>">	
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Call Cords
					</b></td>
				</tr>			
				<tr>
					<td>
						10ft. Call Cords
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="ten" value = "<?php echo $ten; ?>">
					</td>
					<td>
						15ft. Call Cords
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="fifteen" value = "<?php echo $fifteen; ?>">
					</td>
					<td>
						Dual Call Cords</td><td><input type="text" size="6" maxlength="6" name="dual" value = "<?php echo $dual; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Squeeze Balls
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="squeeze" value = "<?php echo $squeeze; ?>">
					</td>
					<td>
						Breath Calls
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="breath" value = "<?php echo $breath; ?>">
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center" >
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Corridor Lights
					</b></td>
				</tr>						
				<tr>
					<td>
						Corridor Light Type:
					</td>
					<td><select name=type>
						<option value="<?php echo 'NONE'; ?>" <?php if($type == 'NONE'){ echo 'selected="selected"'; } ?>>  <?php echo 'NONE'; ?> </option>
						<option value="<?php echo 'HomeFree'; ?>" <?php if($type == 'HomeFree'){ echo 'selected="selected"'; } ?>>  <?php echo 'Homefree'; ?> </option>
						<option value="<?php echo 'Existing'; ?>" <?php if($type == 'Existing'){ echo 'selected="selected"'; } ?>>  <?php echo 'Existing'; ?> </option>
						<option value="<?php echo 'Both'; ?>" <?php if($type == 'Both'){ echo 'selected="selected"'; } ?>>  <?php echo 'Both'; ?> </option>
	  			</select></td>
	  			<td>
	  				Corridor Light Style:
	  			</td>
	  			<td><select name=style>
						<option value="<?php echo 'NONE'; ?>" <?php if($style == 'NONE'){ echo 'selected="selected"'; } ?>>  <?php echo 'NONE'; ?> </option>
						<option value="<?php echo 'Single'; ?>" <?php if($style == 'Single'){ echo 'selected="selected"'; } ?>>  <?php echo 'Single'; ?> </option>
						<option value="<?php echo 'Double'; ?>" <?php if($style == 'Double'){ echo 'selected="selected"'; } ?>>  <?php echo 'Double'; ?> </option>
						<option value="<?php echo 'Quad'; ?>" <?php if($style == 'Quad'){ echo 'selected="selected"'; } ?>>  <?php echo 'Quad'; ?> </option>	  				
	  			</select></td>
	  		</tr>
	  		<tr>
	  			<td>
	  				Number of Existing Lights
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="existing" value = "<?php echo $existing; ?>">
	  			</td>
	  			<td>
	  				Number of HomeFree Lights
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="homefree" value = "<?php echo $homefree; ?>">
	  			</td>
	  		</tr>
<?php
			}else
			{
?>				
				<tr>
					<td><font face = "Arial" size = 2">
						Total Number of Pull Cords
					</td>
					<td><font face = "Arial" size = 2">
						<input type="text" size="6" maxlength="6" name="pull" value = "0">
					</td>
				</tr>
				<tr>
					<td><font face = "Arial" size = 2">
						Pull Cords in Bedroom
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="bed" value = "0">
					</td>
					<td><font face = "Arial" size = 2">
						Pull Cords in Bathroom
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="bath" value = "0"> 
					</td>
					<td><font face = "Arial" size = 2">
						Pull Cords in Common Areas
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="common" value = "0">	
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Pull Cords with Wellness Check-In
					</b></td>
				</tr>
				<tr>
					<td colspan = "2"><font face = "Arial" size = 2">
						Total Number of Pull Cords with Wellness
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="pullw" value = "0">
					</td>
				</tr>	
				<tr>
					<td><font face = "Arial" size = 2">
						Bedroom
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="beda" value = "0">
					</td>
					<td><font face = "Arial" size = 2">
						Bathroom
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="batha" value = "0">
					</td>
					<td><font face = "Arial" size = 2">
						Common
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="commona" value = "0">	
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Call Cords
					</b></td>
				</tr>			
				<tr>
					<td><font face = "Arial" size = 2">
						10ft. Call Cords
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="ten" value = "0">
					</td>
					<td><font face = "Arial" size = 2">
						15ft. Call Cords
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="fifteen" value = "0">
					</td>
					<td><font face = "Arial" size = 2">
						Dual Call Cords</td><td><input type="text" size="6" maxlength="6" name="dual" value = "0">
					</td>
				</tr>
				<tr>
					<td><font face = "Arial" size = 2">
						Squeeze Balls
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="squeeze" value = "0">
					</td>
					<td><font face = "Arial" size = 2">
						Breath Calls
					</td>
					<td>
						<input type="text" size="6" maxlength="6" name="breath" value = "0">
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center" >
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Corridor Lights
					</b></td>
				</tr>						
				<tr>
					<td><font face = "Arial" size = 2">
						Corridor Light Type:
					</td>
					<td><select name=type>
						<option value ="NONE">NONE</option>
	  				<option value ="HomeFree">Homefree</option>
	  				<option value ="Existing">Existing</option>
	  				<option value ="Both">Both</option>
	  			</select></td>
	  			<td><font face = "Arial" size = 2">
	  				Corridor Light Style:
	  			</td>
	  			<td><select name=style>
	  				<option value ="NONE">NONE</option>
	  				<option value ="Single">Single</option>
	  				<option value ="Double">Double</option>
	  				<option value ="Quad">Quad</option>
	  			</select></td>
	  		</tr>
	  		<tr>
	  			<td><font face = "Arial" size = 2">
	  				Number of Existing Lights
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="existing" value = "0">
	  			</td>
	  			<td><font face = "Arial" size = 2">
	  				Number of HomeFree Lights
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="homefree" value = "0">
	  			</td>
	  		</tr>
<?php
			}
?>				  		
			<tr>
				<td>
					<input type="submit" value="Save" name="savepullcords">
				</td>
			</tr>		  		
  	</table>
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form>
<?php
}
/*
***************************************QUERY TO ADD EQUIPMENT (PULL CORDS)***************************************
*/	
if((isset($_GET['savepullcords'])) && ($_GET['savepullcords'] == "Save"))
{	
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$getsystype = "SELECT SystemType FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
	$resgetsystype = mysql_query($getsystype) or die (mysql_error());		
	$systype = mysql_fetch_array($resgetsystype);
	$system = $systype['SystemType'];
	$squeeze = $_GET["squeeze"];
	$dual = $_GET["dual"];
	$breath = $_GET["breath"];
	$bed = $_GET["bed"];
	$beda = $_GET["beda"];
	$bath = $_GET["bath"];
	$batha = $_GET["batha"];
	$common = $_GET["common"];
	$commona = $_GET["commona"];
	$pull = $_GET["pull"];
	$pullw = $_GET["pullw"];
	$ten = $_GET["ten"];
	$fifteen = $_GET["fifteen"];
	$type = $_GET["type"];
	$style = $_GET["style"];
	$existing = $_GET["existing"];
	$homefree = $_GET["homefree"];
	$addpullcords = "UPDATE tbltotalequipment SET TotalPullCords = '$pull', TotalPullCordsactivity = '$pullw', TotalCallCords = '$ten',
									TotalCallCordssingle15 = '$fifteen', TotalCallCorddual = '$dual', CorridorLights = '$style', CorridorLightType = '$type',
									TotalExistingCorrdiorLights = '$existing', TotalHomeFreeCorrdiorLights = '$homefree', Squeezeball = '$squeeze',
									breathcall = '$breath', bedpullcords = '$bed', bathpullcords = '$bath', commonpullcords = '$common', bedpullcordsact = '$beda',
									bathpullcordsact = '$batha', commonpullcordsact = '$commona' WHERE FacilityID = '$f_id'";
	mysql_query($addpullcords) or die(mysql_error());
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		if($system == "Elite")
		{
			header("Location: addcustomer.php?view=equip&equip=awareunits&f_id=$f_id&existing_id=$existing_id");		
		}else
		{
			header("Location: addcustomer.php?view=equip&equip=uts&f_id=$f_id&existing_id=$existing_id");
		}			
	}else
	{
		if($system == "Elite")
		{
			header("Location: addcustomer.php?view=equip&equip=awareunits&f_id=$f_id");		
		}else
		{
			header("Location: addcustomer.php?view=equip&equip=uts&f_id=$f_id");
		}		
	}
}
/*
***************************************FORM TO ADD EQUIPMENT (FALL UNITS)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "awareunits"))
{	
	$f_id = $_GET['f_id'];
	if(isset($_GET['existing_id']))
	{
		mysql_select_db($dbname2);
		$existing_id = $_GET['existing_id'];		
		$query18 = "SELECT TotalFallUnits,bed90day,bed180day,chair90day,chair180day FROM tbltotalequipment WHERE FacilityID = '$existing_id'";		
		$result18 = mysql_query($query18) or die (mysql_error());
		$row18 = mysql_fetch_array($result18);		
	}
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
		if(isset($_GET['existing_id']))
		{
			echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
?>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Fall Units
					</b></td>
				</tr>	
	  		<tr>
	  			<td><font face = "Arial" size = 2">
	  				Fall Units
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="fall" value = "<?php echo $row18['TotalFallUnits']; ?>">
	  			</td>
	  		</tr>
				<tr>
					<td align=center td colspan ="6"><font face = "Arial" size = 2"><b>  
						Fall Pads
					</b></td>
				</tr>	  		
	  		<tr>  			
	  			<td><font face = "Arial" size = 2">
	  				Chair Pad 90 day
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="chair90" value = "<?php echo $row18['chair90day']; ?>">
	  			</td>
	  			<td><font face = "Arial" size = 2">
	  				Chair Pad 180 day
	  			</td>			
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="chair180" value = "<?php echo $row18['chair180day']; ?>">
	  			</td>
	  		</tr>
	  		<tr>    			
	  			<td><font face = "Arial" size = 2">
	  				Bed Pad 90 day
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="bed90" value = "<?php echo $row18['bed90day']; ?>">
	  			</td>
	  			<td><font face = "Arial" size = 2">
	  				Bed Pad 180 day</td><td><input type="text" size="6" maxlength="6" name="bed180" value = "<?php echo $row18['bed180day']; ?>">
	  			</td>
	 			</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="savefallunits">
					</td>
				</tr>	 			
	 		</table>
<?php			
		}else
		{
?>		
			<table cellpadding=3 table border ="0" width="750"  align ="center">
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Fall Units
					</b></td>
				</tr>	
	  		<tr>
	  			<td><font face = "Arial" size = 2">
	  				Fall Units
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="fall" value = "0">
	  			</td>
	  		</tr>
				<tr>
					<td align=center td colspan ="6"><font face = "Arial" size = 2"><b>  
						Fall Pads
					</b></td>
				</tr>	  		
	  		<tr>  			
	  			<td><font face = "Arial" size = 2">
	  				Chair Pad 90 day
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="chair90" value = "0">
	  			</td>
	  			<td><font face = "Arial" size = 2">
	  				Chair Pad 180 day
	  			</td>			
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="chair180" value = "0">
	  			</td>
	  		</tr>
	  		<tr>    			
	  			<td><font face = "Arial" size = 2">
	  				Bed Pad 90 day
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="bed90" value = "0">
	  			</td>
	  			<td><font face = "Arial" size = 2">
	  				Bed Pad 180 day</td><td><input type="text" size="6" maxlength="6" name="bed180" value = "0">
	  			</td>
	 			</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="savefallunits">
					</td>
				</tr>	 			
	 		</table>		
<?php
		}
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form>
<?php
}
/*
***************************************QUERY TO ADD EQUIPMENT (FALL UNITS)***************************************
*/	
if((isset($_GET['savefallunits'])) && ($_GET['savefallunits'] == "Save"))
{		
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$fall = $_GET["fall"];
	$chair90 = $_GET["chair90"];
	$chair180 = $_GET["chair180"];
	$bed90 = $_GET["bed90"];
	$bed180 = $_GET["bed180"];
	$addfallunits = "UPDATE tbltotalequipment SET TotalFallUnits = '$fall', bed90day = '$bed90', bed180day = '$bed180', chair90day = '$chair90', 
									chair180day = '$chair180' WHERE FacilityID = '$f_id'";
	mysql_query($addfallunits) or die(mysql_error());		
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		header("Location: addcustomer.php?view=equip&equip=uts&f_id=$f_id&existing_id=$existing_id");
	}else
	{	
		header("Location: addcustomer.php?view=equip&equip=uts&f_id=$f_id");
	}
}
/*
***************************************FORM TO ADD EQUIPMENT (UTS)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "uts"))
{
	$f_id = $_GET['f_id'];
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		mysql_select_db($dbname2);
		$query19 = "SELECT UTs,utpower,UTFunction FROM tbltotalequipment WHERE FacilityID = '$existing_id'";		
		$result19 = mysql_query($query19) or die (mysql_error());
		$row19 = mysql_fetch_array($result19);
		$ut_power = $row19['utpower'];		
	}
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php	
		if(isset($_GET['existing_id']))
		{
			echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
?>
			<table cellpadding=3 table border ="0" width="750"  align ="center" >
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Universal Transmitters
					</b></td>
				</tr>	
				<tr>
	 				<td colspan = "2"> <font face = "Arial" size = 2">
	 					Universal Transmitters (Enter the quantity of UT's that have a function other than a door)  <input type="text" size="6" maxlength="6" name="ut" value = "<?php echo $row19['UTs']; ?>">
	 				</td>
	 			</tr>
	 			<tr> 				
	 				<td><font face = "Arial" size = 2">
	 					Universal Transmitter Function
	 				</td>
	 				<td>
	 					<textarea rows="5" cols="60" name="utfunction"><?php echo strip_tags($row19['UTFunction']); ?></textarea>
	 				</td>
	 			</tr>
	 			<tr>
	 				<td align=center colspan="6"><font face = "Arial" size = 2"> 					
	 					<input type="radio" name="utpower" value="<?php echo 'no'; ?>" <?php if($ut_power == 'no'){ echo 'CHECKED'; } ?>>UT's Powered By Batteries
						<input type="radio" name="utpower" value="<?php echo 'yes'; ?>" <?php if($ut_power == 'yes'){ echo 'CHECKED'; } ?>>UT's Powered By Power Source
						<input type="radio" name="utpower" value="<?php echo 'none'; ?>" <?php if($ut_power == 'none'){ echo 'CHECKED'; } ?>>No UT's
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="saveuts">
					</td>
				</tr>				
	 		</table>
<?php			
		}else
		{
?>
			<table cellpadding=3 table border ="0" width="750"  align ="center" >
				<tr>
					<td align=center td colspan ="6"><font size=3 ><b>  
						Universal Transmitters
					</b></td>
				</tr>	
				<tr>
	 				<td colspan = "2"> <font face = "Arial" size = 2">
	 					Universal Transmitters (Enter the quantity of UT's that have a function other than a door)  <input type="text" size="6" maxlength="6" name="ut" value = "0">
	 				</td>
	 			</tr>
	 			<tr> 				
	 				<td><font face = "Arial" size = 2">
	 					Universal Transmitter Function
	 				</td>
	 				<td>
	 					<textarea rows="5" cols="60" name="utfunction"></textarea>
	 				</td>
	 			</tr>
	 			<tr>
	 				<td align=center colspan="6"><font face = "Arial" size = 2">
	 					<input type="radio" name="utpower" value="no">UT's Powered By Batteries
						<input type="radio" name="utpower" value="yes">UT's Powered By Power Source
						<input type="radio" name="utpower" value="none" CHECKED>No UT's
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="saveuts">
					</td>
				</tr>				
	 		</table>
<?php
		}
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form>
<?php				
}			
/*
***************************************QUERY TO ADD EQUIPMENT (UTS)***************************************
*/	
if((isset($_GET['saveuts'])) && ($_GET['saveuts'] == "Save"))
{		
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$ut = $_GET["ut"];
	$utfunction = nl2br(addslashes($_GET["utfunction"]));
	$utpower = $_GET['utpower'];
	$adduts = "UPDATE tbltotalequipment SET UTs= '$ut', UTFunction = '$utfunction', utpower = '$utpower' WHERE FacilityID = '$f_id'";
	mysql_query($adduts) or die(mysql_error());		
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		header("Location: addcustomer.php?view=equip&equip=clients&f_id=$f_id&existing_id=$existing_id");
	}else
	{	
		header("Location: addcustomer.php?view=equip&equip=clients&f_id=$f_id");
	}
}
/*
***************************************FORM TO ADD EQUIPMENT (CLIENTS)***************************************
*/		
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "clients"))
{
	$f_id = $_GET['f_id'];
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		mysql_select_db($dbname2);
		$query19 = "SELECT TotalClientStations,ClientStationlocation,lic FROM tbltotalequipment WHERE FacilityID = '$existing_id'";		
		$result19 = mysql_query($query19) or die (mysql_error());
		$row19 = mysql_fetch_array($result19);	
	}	
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
		if(isset($_GET['existing_id']))
		{
			echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
?>
			<table cellpadding=3 table border ="0" width="750"  align ="center">
	 			<tr>
	 				<td align=center colspan="6"><font size=3 face = "Arial"><b>
	 					Client Stations  
	 				</b></font></td> 
	 			</tr>
	 			<tr>
	 				<td><font face = "Arial" size = 2">
						Client Computers(License Included with each computer)
	 				</td>
	 				<td>
	 					<input type="text" size="6" maxlength="6" name="client" value = "<?php echo $row19['TotalClientStations'];?>">
	 				</td>
	 			</tr>
	 			<tr> 				
	 				<td><font face = "Arial" size = 2">
	 					Client Station Location
	 				</td>
	 				<td>
	 					<textarea rows="5" cols="40" name="clientl"><?php echo strip_tags($row19['TotalClientStations']);?></textarea>
	 				</td>
	 			</tr>
	 			<tr>
	 				<td><font face = "Arial" size = 2">
	 					Client Licenses(For Customer using non-HomeFree Computers as a client)
	 				</td>
	 				<td>
	 					<input type="text" size="6" maxlength="6" name="lic" value = "<?php echo $row19['lic'];?>">
	 				</td>
	 			</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="saveclients">
					</td>
				</tr>		 		
	 		</table>		
<?php		
		}else
		{
?>		
			<table cellpadding=3 table border ="0" width="750"  align ="center">
	 			<tr>
	 				<td align=center colspan="6"><font size=3 face = "Arial"><b>
	 					Client Stations  
	 				</b></font></td> 
	 			</tr>
	 			<tr>
	 				<td><font face = "Arial" size = 2">
						Client Computers(License Included with each computer)
	 				</td>
	 				<td>
	 					<input type="text" size="6" maxlength="6" name="client" value = "0">
	 				</td>
	 			</tr>
	 			<tr> 				
	 				<td><font face = "Arial" size = 2">
	 					Client Station Location
	 				</td>
	 				<td>
	 					<textarea rows="5" cols="40" name="clientl">NONE</textarea>
	 				</td>
	 			</tr>
	 			<tr>
	 				<td><font face = "Arial" size = 2">
	 					Client Licenses(For Customer using non-HomeFree Computers as a client)
	 				</td>
	 				<td>
	 					<input type="text" size="6" maxlength="6" name="lic" value = "0">
	 				</td>
	 			</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="saveclients">
					</td>
				</tr>		 		
	 		</table>			 				
<?php
		}
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form>
<?php	
}
/*
***************************************QUERY TO ADD EQUIPMENT (UTS)***************************************
*/	
if((isset($_GET['saveclients'])) && ($_GET['saveclients'] == "Save"))
{	
	mysql_select_db($dbname2);	
	$f_id = $_GET['f_id'];
	$client = $_GET["client"];
	$clientl = nl2br(addslashes($_GET["clientl"]));
	$lic = $_GET['lic'];
	$addclients = "UPDATE tbltotalequipment SET TotalClientStations= '$client', ClientStationlocation = '$clientl', lic = '$lic' WHERE FacilityID = '$f_id'";
	mysql_query($addclients) or die(mysql_error());		
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		header("Location: addcustomer.php?view=equip&equip=power&f_id=$f_id&existing_id=$existing_id");
	}else
	{	
		header("Location: addcustomer.php?view=equip&equip=power&f_id=$f_id");
	}
}	
/*
***************************************FORM TO ADD EQUIPMENT (POWER AND WIRE)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "power"))
{
	$f_id = $_GET['f_id'];
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		mysql_select_db($dbname2);
		$query19 = "SELECT powertype,CPSwire,TotalCentralPowerSupplies,Wire224,Wire162 FROM tbltotalequipment WHERE FacilityID = '$existing_id'";		
		$result19 = mysql_query($query19) or die (mysql_error());
		$row19 = mysql_fetch_array($result19);
		$power_type = $row19['powertype'];	
	}		
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
	if(isset($_GET['existing_id']))
	{
		echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
?>
		<table cellpadding=3 table border ="0" width="759"  align ="center" >
 			<tr>
 				<td align=center colspan="6"><font size=3 face = "Arial"><b>
 					Central Power and Wire
 				</b></font></td>
 			</tr>
 			<tr>
 				<td colspan="6"><font size=2 face = "Arial"><b>
 					Power Source(Choose one)
 				</b></font></td>
 			</tr> 		
 			<tr>
 				<td colspan="6"><font face = "Arial" size = 2">
 					<input type="radio" name="power" value="<?php echo 'outlets'; ?>" <?php if($power_type == 'outlets'){ echo 'CHECKED'; } ?>>Outlets installed by customer</br>
					<input type="radio" name="power" value="<?php echo 'cpshf'; ?>" <?php if($power_type == 'cpshf'){ echo 'CHECKED'; } ?>>Central Power Supply, installed by HomeFree</br>
					<input type="radio" name="power" value="<?php echo 'cpscus'; ?>" <?php if($power_type == 'cpscus'){ echo 'CHECKED'; } ?>>Central Power Supply, installed by Customer
				</td>
			</tr>
	 	</table>
	 	<table cellpadding=3 table border ="0" width="759"  align ="center" >		
			<tr>
	 			<td width = 180><font face = "Arial" size = 2">
	 				Central Power Supply Quantity
	 			</td>
	 			<td>
	 				<input type="text" size="6" maxlength="6" name="cpsquantity" value = "<?php echo $row19['TotalCentralPowerSupplies'];?>">
	 			</td>
	 		</tr>
			<tr>
	 			<td width = 220><font face = "Arial" size = 2">
	 				Wire for Central Power Supply ONLY
	 			</td>
	 			<td>
	 				<input type="text" size="6" maxlength="6" name="cpswire" value = "<?php echo $row19['CPSwire'];?>">
	 			</td>
	 		</tr> 		
	 	</table>
	 	<table cellpadding=3 table border ="0">	
	 		<tr>
	 			<td colspan="2"><font face = "Arial" size = 2"><b>
	 				Other Wire Needed
	 			</b></font></td>
	 		</tr>	 		
	 		<tr>
	 			<td width = 60><font face = "Arial" size = 2">
	 				Wire 16-2
	 			</td>
	 			<td width = 80>
	 				<input type="text" size="6" maxlength="6" name="wirex" value = "<?php echo $row19['Wire162'];?>">
	 			</td>
	 			<td width = 60><font face = "Arial" size = 2">
	 				Wire 22-4 
	 			</td>
	 			<td width = 80>
	 				<input type="text" size="6" maxlength="6" name="wirey" value = "<?php echo $row19['Wire224'];?>">
	 			</td>
	 		</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="savepower">
					</td>
				</tr>	 		
		</table>	
<?php		
	}else
	{
?>		
		<table cellpadding=3 table border ="0" width="759"  align ="center" >
 			<tr>
 				<td align=center colspan="6"><font size=3 face = "Arial"><b>
 					Central Power and Wire
 				</b></font></td>
 			</tr>
 			<tr>
 				<td colspan="6"><font size=2 face = "Arial"><b>
 					Power Source(Choose one)
 				</b></font></td>
 			</tr> 		
 			<tr>
 				<td colspan="6"><font face = "Arial" size = 2">
	 				<input type="radio" name="power" value="outlets" CHECKED>Outlets installed by customer</br>
					<input type="radio" name="power" value="cpshf">Central Power Supply, installed by HomeFree</br>
					<input type="radio" name="power" value="cpscus">Central Power Supply, installed by Customer
				</td>
			</tr>
	 	</table>
	 	<table cellpadding=3 table border ="0" width="759"  align ="center" >		
			<tr>
	 			<td width = 180><font face = "Arial" size = 2">
	 				Central Power Supply Quantity
	 			</td>
	 			<td>
	 				<input type="text" size="6" maxlength="6" name="cpsquantity" value = "0">
	 			</td>
	 		</tr>
			<tr>
	 			<td width = 220><font face = "Arial" size = 2">
	 				Wire for Central Power Supply ONLY
	 			</td>
	 			<td>
	 				<input type="text" size="6" maxlength="6" name="cpswire" value = "0">
	 			</td>
	 		</tr> 		
	 	</table>
	 	<table cellpadding=3 table border ="0">	
	 		<tr>
	 			<td colspan="2"><font face = "Arial" size = 2"><b>
	 				Other Wire Needed
	 			</b></font></td>
	 		</tr>	 		
	 		<tr>
	 			<td width = 60><font face = "Arial" size = 2">
	 				Wire 16-2
	 			</td>
	 			<td width = 80>
	 				<input type="text" size="6" maxlength="6" name="wirex" value = "0">
	 			</td>
	 			<td width = 60><font face = "Arial" size = 2">
	 				Wire 22-4 
	 			</td>
	 			<td width = 80>
	 				<input type="text" size="6" maxlength="6" name="wirey" value = "0">
	 			</td>
	 		</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="savepower">
					</td>
				</tr>	 		
		</table>		
<?php
	}
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form>
<?php	
}
/*
***************************************QUERY TO ADD EQUIPMENT (POWER AND WIRE)***************************************
*/	
if((isset($_GET['savepower'])) && ($_GET['savepower'] == "Save"))
{
	mysql_select_db($dbname2);		
	$f_id = $_GET['f_id'];
	$wirex = $_GET['wirex'];
	$wirey = $_GET['wirey'];
	$cpsquantity = $_GET['cpsquantity'];
	$cpswire = $_GET['cpswire'];
	$whowiring = $_GET['power'];
	$addclients = "UPDATE tbltotalequipment SET TotalCentralPowerSupplies = '$cpsquantity', CPSwire = '$cpswire', Wire224 = '$wirey', Wire162 = '$wirex', powertype = '$whowiring' WHERE FacilityID = '$f_id'";
	mysql_query($addclients) or die(mysql_error());		
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		header("Location: addcustomer.php?view=equip&equip=paging&f_id=$f_id&existing_id=$existing_id");
	}else
	{	
		header("Location: addcustomer.php?view=equip&equip=paging&f_id=$f_id");
	}	
}		 
/*
***************************************FORM TO ADD EQUIPMENT (PAGING)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "paging"))
{
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$query14 = "SELECT Expansion FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
	$result14 = mysql_query($query14) or die(mysql_error());
	$row14 = mysql_fetch_array($result14);
	$expansion = $row14['Expansion'];
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
		mysql_select_db($dbname2);
		$query19 = "SELECT PagingBaseType,PagerType,PagerQuantity,HomeFreePager FROM tbltotalequipment WHERE FacilityID = '$existing_id'";		
		$result19 = mysql_query($query19) or die (mysql_error());
		$row19 = mysql_fetch_array($result19);
		$paging_base = $row19['PagingBaseType'];
		$pager_type = $row19['PagerType'];
	}
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
	if(isset($_GET['existing_id']))
	{
		echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
?>
		<table cellpadding=3 table border ="0" width="400"  align ="center">
  		<tr>
  			<td align=center colspan="8"><font size=3 face = "Arial"><b>
  		  	Paging
  		  </b></td>
  		</tr>
  		<tr>
  			<td><font face = "Arial" size = 2">
  				Paging Base Type:
  			</td>
  			<td><select name=base>
					<option value="<?php echo 0; ?>" <?php if($paging_base == 0){ echo 'selected="selected"'; } ?>>  <?php echo 'NONE'; ?> </option>
					<option value="<?php echo 'Commtech5W'; ?>" <?php if($paging_base== 'Commtech5W'){ echo 'selected="selected"'; } ?>>  <?php echo 'Commtech 5 W'; ?> </option>
					<option value="<?php echo 'Commtech25W'; ?>" <?php if($paging_base == 'Commtech25W'){ echo 'selected="selected"'; } ?>>  <?php echo 'Commtech 25 W'; ?> </option>  				
					<option value="<?php echo 'Commtech50W'; ?>" <?php if($paging_base == 'Commtech50W'){ echo 'selected="selected"'; } ?>>  <?php echo 'Commtech 50 W'; ?> </option>
					<option value="<?php echo 'Commtech100W'; ?>" <?php if($paging_base == 'Commtech100W'){ echo 'selected="selected"'; } ?>>  <?php echo 'Commtech 100 W'; ?> </option>
					<option value="<?php echo 'Commtech200W'; ?>" <?php if($paging_base == 'Commtech200W'){ echo 'selected="selected"'; } ?>>  <?php echo 'Commtech 200 W'; ?> </option>  
					<option value="<?php echo 'Scope'; ?>" <?php if($paging_base == 'Scope'){ echo 'selected="selected"'; } ?>>  <?php echo 'Scope'; ?> </option>  
  			</select></td>
  		</tr>
  		<tr>   			
  			<td><font face = "Arial" size = 2">
  				Pager Type
  			</td> 			
  			<td><select name=pager>
					<option value="<?php echo 'NONE'; ?>" <?php if($pager_type == 'NONE'){ echo 'selected="selected"'; } ?>>  <?php echo 'NONE'; ?> </option>
					<option value="<?php echo 'Commtech7900'; ?>" <?php if($pager_type == 'Commtech7900'){ echo 'selected="selected"'; } ?>>  <?php echo 'Commtech7900'; ?> </option>  
					<option value="<?php echo 'Apollo'; ?>" <?php if($pager_type == 'Apollo'){ echo 'selected="selected"'; } ?>>  <?php echo 'Apollo'; ?> </option>    				
  			</select></td>
  		</tr>
  		<tr>  			
  			<td><font face = "Arial" size = 2">
  				Number of Pagers
  			</td>
  			<td>
  				<input type="text" size="6" maxlength="6" name="numpagers" value="<?php echo $row19['PagerQuantity']; ?>">
  			</td>
  		</tr>
<?php
			if($expansion == 0)
			{
?>				  		
	  		<tr>   			
	  			<td><font face = "Arial" size = 2">
	  				Number of HomeFree Pagers
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="hfpagers" value="1" READONLY>
	  			</td>
	  		</tr>
<?php
			}else
			{
?>				
				<tr>   			
	  			<td><font face = "Arial" size = 2">
	  				Number of HomeFree Pagers
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="hfpagers" value="<?php echo $row19['HomeFreePager']; ?>">
	  			</td>
	  		</tr>
<?php
			}	  		
?>				  		
  		<tr>
				<td>
					<input type="submit" value="Save" name="savepaging">
				</td>
			</tr>	
  	</table>
<?php		
	}else
	{	
?>		
		<table cellpadding=3 table border ="0" width="400"  align ="center">
  		<tr>
  			<td align=center colspan="8"><font size=3 face = "Arial"><b>
  		  	Paging
  		  </b></td>
  		</tr>
  		<tr>
  			<td><font face = "Arial" size = 2">
  				Paging Base Type:
  			</td>
  			<td><select name=base>
  				<option value ="0">NONE</option>
  				<option value ="Commtech5W">Commtech 5 W</option>
  				<option value ="Commtech25W">Commtech 25 W</option>
  				<option value ="Commtech50W">Commtech 50 W</option>
  				<option value ="Commtech100W">Commtech 100 W</option>
  				<option value ="Commtech200W">Commtech 200 W</option>
  				<option value ="Scope">Scope</option>
  			</select></td>
  		</tr>
  		<tr>   			
  			<td><font face = "Arial" size = 2">
  				Pager Type
  			</td> 			
  			<td><select name=pager>
  				<option value ="NONE">NONE</option>
  				<option value ="Commtech7900">Commtech7900</option>
  				<option value ="Apollo">Apollo</option>
  			</select></td>
  		</tr>
  		<tr>  			
  			<td><font face = "Arial" size = 2">
  				Number of Pagers
  			</td>
  			<td>
  				<input type="text" size="6" maxlength="6" name="numpagers" value="0">
  			</td>
  		</tr>
<?php
			if($expansion == 0)
			{
?>				  		
	  		<tr>   			
	  			<td><font face = "Arial" size = 2">
	  				Number of HomeFree Pagers
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="hfpagers" value="1" READONLY>
	  			</td>
	  		</tr>
<?php
			}else
			{
?>				
				<tr>   			
	  			<td><font face = "Arial" size = 2">
	  				Number of HomeFree Pagers
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="hfpagers" value="0">
	  			</td>
	  		</tr>
<?php
			}	  		
?>				  		
  		<tr>
				<td>
					<input type="submit" value="Save" name="savepaging">
				</td>
			</tr>	
  		</table>
<?php
		}
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form>
<?php	 					
}
/*
***************************************QUERY TO ADD EQUIPMENT (PAGING)***************************************
*/	
if((isset($_GET['savepaging'])) && ($_GET['savepaging'] == "Save"))
{		
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$base = $_GET["base"];
	$pager = $_GET["pager"];
	$numpagers = $_GET["numpagers"];
	$hfpagers = $_GET["hfpagers"];
	$addpaging = "UPDATE tbltotalequipment SET HomeFreePager = '$hfpagers', PagingBaseType = '$base', PagerQuantity = '$numpagers', PagerType = '$pager' WHERE FacilityID = '$f_id'";
	mysql_query($addpaging) or die(mysql_error());	
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		header("Location: addcustomer.php?view=equip&equip=jobdescription&f_id=$f_id&existing_id=$existing_id");
	}else
	{		
		header("Location: addcustomer.php?view=equip&equip=jobdescription&f_id=$f_id");
	}
}		
/*
***************************************FORM TO ADD JOB DESCRIPTION***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "jobdescription"))
{
	$f_id = $_GET['f_id'];
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		mysql_select_db($dbname2);
		$query19 = "SELECT joboverview FROM tbltotalequipment WHERE FacilityID = '$existing_id'";		
		$result19 = mysql_query($query19) or die (mysql_error());
		$row19 = mysql_fetch_array($result19);
	}
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
	if(isset($_GET['existing_id']))
	{
		echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
?>
		<table cellpadding=3 table border ="0" width="750"  align ="center" > 	
		 	<tr>
 				<td align=center>
 					Job Overview
 				</td>
 				<td>
 					<textarea rows="12" cols="70" name="job"><?php echo strip_tags($row19['joboverview']);?></textarea> 				
 				</td>
 			</tr>
 			<tr>
				<td>
					<input type="submit" value="Save" name="savejobdes">
				</td>
			</tr>
 		</table>
<?php		
	}else
	{
?>
 		<table cellpadding=3 table border ="0" width="750"  align ="center" >
 			<tr>
 				<td align=center>
 					Job Overview
 				</td>
 				<td>
 					<textarea rows="12" cols="70" name="job"></textarea> 				
 				</td>
 			</tr>
 			<tr>
				<td>
					<input type="submit" value="Save" name="savejobdes">
				</td>
			</tr>
 		</table>
<?php
	}
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form> 		
<?php
}
/*
***************************************QUERY TO ADD JOB DESCRIPTION***************************************
*/	
if((isset($_GET['savejobdes'])) && ($_GET['savejobdes'] == "Save"))
{		
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$job = nl2br(addslashes($_GET["job"]));
	$addjobdes = "UPDATE tbltotalequipment SET joboverview = '$job' WHERE FacilityID = '$f_id'";
	mysql_query($addjobdes) or die(mysql_error());		
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		header("Location: addcustomer.php?view=equip&equip=otherinfo&f_id=$f_id&existing_id=$existing_id");
	}else
	{		
		header("Location: addcustomer.php?view=equip&equip=otherinfo&f_id=$f_id");
	}	
}		 		
/*
***************************************FORM TO ADD OTHER STUFF***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "otherinfo"))
{
	$f_id = $_GET['f_id'];
?>
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		echo	'<input type = "hidden" name="existing_id" value = "'.$existing_id.'">';
		mysql_select_db($dbname2);
		$getequip = "SELECT days,startdate FROM tbltotalequipment WHERE FacilityID='$existing_id'";
		$resgetequip = mysql_query($getequip) or die (mysql_error());
		$equip = mysql_fetch_array($resgetequip);
		$days = $equip['days'];
		$startdate = $equip['startdate'];
		$getcontacts = "SELECT * FROM tbladditionalcontacts WHERE FacilityID='$existing_id'";
		$resgetcontacts = mysql_query($getcontacts) or die (mysql_error());
		$contacts = mysql_fetch_array($resgetcontacts);
		$name = $contacts["Name"];
		$title = $contacts["Title"];
		$phone = $contacts["Phone"];
		$name1 = $contacts["Name1"];
		$title1 = $contacts["Title1"];
		$phone1 = $contacts["Phone1"];
		$name2 = $contacts["Name2"];
		$title2 = $contacts["Title2"];
		$phone2 = $contacts["Phone2"];
		$name3 = $contacts["Name3"];
		$title3 = $contacts["Title3"];
		$phone3 = $contacts["Phone3"];
		$name4 = $contacts["Name4"];
		$title4 = $contacts["Title4"];
		$phone4 =$contacts["Phone4"];
		$champ = $contacts["SystemChamp"];
		$champtitle = $contacts["ChampionTitle"];
		$champphone = $contacts["ChampionPhone"];
		$champ1 = $contacts["SystemChamp1"];
		$champtitle1 = $contacts["ChampionTitle1"];
		$champphone1 = $contacts["ChampionPhone1"];
		$champ2 = $contacts["SystemChamp2"];
		$champtitle2 = $contacts["ChampionTitle2"];
		$champphone2 = $contacts["ChampionPhone2"];
		$getprojinfo = "SELECT * FROM tblprojectmanagement WHERE FacilityID='$existing_id'";
		$resgetprojinfo = mysql_query($getprojinfo) or die (mysql_error());
		$projinfo = mysql_fetch_array($resgetprojinfo);	
		$livedate = $projinfo['LiveDate'];
		$remote = $projinfo['Remote'];
		$marshall = $projinfo['marshall'];
		$panel = $projinfo['panel'];
		$fire = $projinfo['fire'];
		$timers = $projinfo['timers'];
		$connection = $projinfo['connectiont'];
		$doorcompany = $projinfo['doorcompany'];
		$wellness = $projinfo['wellness'];
		$comments = strip_tags($projinfo['comments']);		
?>		
		<table cellpadding=3 table border ="0" width="750"  align ="center" >
 			<tr>
 				<td width = 115>
 					Quote Good For:
 				</td>
 				<td width = 55>
				<select name=days>
					<option value="<?php echo 30; ?>" <?php if($days == 30){ echo 'selected="selected"'; } ?>>  <?php echo '30 Days'; ?> </option>
					<option value="<?php echo 45; ?>" <?php if($days == 45){ echo 'selected="selected"'; } ?>>  <?php echo '45 Days'; ?> </option>
					<option value="<?php echo 60; ?>" <?php if($days == 60){ echo 'selected="selected"'; } ?>>  <?php echo '60 Days'; ?> </option>
					<option value="<?php echo 90; ?>" <?php if($days == 90){ echo 'selected="selected"'; } ?>>  <?php echo '90 Days'; ?> </option>
  			</select>
  			</td>
  			<td width = 270> 
  				Start Date: 
  				<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="startdate" VALUE="<?php echo $startdate; ?>" SIZE=25>
				</td>
				<td>
					<A HREF="#"
   				onClick="cal.select(document.forms['example'].startdate,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
   				NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="Select" /></A>
   			</td>		
  		</tr>
  		<tr>
 				<td colspan = "4">
 					**Start Date should be the date that the Scope of Work was sent to the customer**
 				</td>
 			</tr>
		</table>
		<table width="750" align = "center">
			<tr>
				<td><u>
					Key Contacts
				</u></td>
			</tr>
		</table>	
		<table align = "center" width = "750" cellpadding=3>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name" value="<?php echo $name; ?>">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title" value="<?php echo $title; ?>">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone" value="<?php echo $phone; ?>">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name1" value="<?php echo $name1; ?>">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title1" value="<?php echo $title1; ?>">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone1" value="<?php echo $phone1; ?>">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name2" value="<?php echo $name2; ?>">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title2" value="<?php echo $title2; ?>">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone2" value="<?php echo $phone2; ?>">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name3" value="<?php echo $name3; ?>">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title3" value="<?php echo $title3; ?>">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone3" value="<?php echo $phone3; ?>">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name4" value="<?php echo $name4; ?>">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title4" value="<?php echo $title4; ?>">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone4" value="<?php echo $phone4; ?>">
				</td>
			</tr>
			<tr>
				<td><u>
					System Champion
				</u></td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="champ" value="<?php echo $champ; ?>">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="champtitle" value="<?php echo $champtitle; ?>">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="10" maxlength="10" name="champphone" value="<?php echo $champphone; ?>">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="champ1" value="<?php echo $champ1; ?>">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="champtitle1" value="<?php echo $champtitle1; ?>">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="10" maxlength="10" name="champphone1" value="<?php echo $champphone1; ?>">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="champ2" value="<?php echo $champ2; ?>">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="champtitle2" value="<?php echo $champtitle2; ?>">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="10" maxlength="10" name="champphone2" value="<?php echo $champphone2; ?>">
				</td>
			</tr>
			<tr>
				<td><u>
					Anticipated Live Date:
				</u></td>
				<td>
					<input type="text" size="20" maxlength="20" name="LiveDate" value="<?php echo $livedate; ?>">
				</td>
			</tr>
			<tr>
				<td><u>
					Remote Access Type:
				</u></td>
				<td><select name=Remote>
					<option value="<?php echo 'Unknown'; ?>" <?php if($remote == 'Unknown'){ echo 'selected="selected"'; } ?>>  <?php echo 'Unknown'; ?> </option>
					<option value="<?php echo 'Fax line'; ?>" <?php if($remote == 'Fax line'){ echo 'selected="selected"'; } ?>>  <?php echo 'Fax line'; ?> </option>
					<option value="<?php echo 'Dedicated Phone Line'; ?>" <?php if($remote == 'Dedicated Phone Line'){ echo 'selected="selected"'; } ?>>  <?php echo 'Dedicated Phone Line'; ?> </option>
					<option value="<?php echo 'Internet'; ?>" <?php if($remote == 'Internet'){ echo 'selected="selected"'; } ?>>  <?php echo 'Internet'; ?> </option>
  			</select></td>
			</tr>
			 <tr>
				<td>
					<input type="submit" value="Save" name="saveother">
				</td>
			</tr>
		</table>	
<?php				
	}else
	{
?>		
		<table cellpadding=3 table border ="0" width="750"  align ="center" >
 			<tr>
 				<td width = 115>
 					Quote Good For:
 				</td>
 				<td width = 55>
				<select name=days>
					<option value ="90">90 Days</option>
					<option value ="30">30 Days</option>
  				<option value ="45">45 Days</option>
  				<option value ="60">60 Days</option>	
  			</select>
  			</td>
  			<td width = 270> 
  				Start Date: 
  				<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="startdate" VALUE="<?php echo $date; ?>" SIZE=25>
				</td>
				<td>
					<A HREF="#"
   				onClick="cal.select(document.forms['example'].startdate,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
   				NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="Select" /></A>
   			</td>		
  		</tr>
  		<tr>
 				<td colspan = "4">
 					**Start Date should be the date that the Scope of Work was sent to the customer**
 				</td>
 			</tr>
		</table>
		<table width="750" align = "center">
			<tr>
				<td><u>
					Key Contacts
				</u></td>
			</tr>
		</table>	
		<table align = "center" width = "750" cellpadding=3>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name" value="none">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name1" value="none">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title1">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone1">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name2" value="none">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title2">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone2">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name3" value="none">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title3">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone3">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="Name4" value="none">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="Title4">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone4">
				</td>
			</tr>
			<tr>
				<td><u>
					System Champion
				</u></td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="champ" value="none">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="champtitle">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="10" maxlength="10" name="champphone">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="champ1" value="none">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="champtitle1">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="10" maxlength="10" name="champphone1">
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;&nbsp;Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="40" name="champ2" value="none">
				</td>
				<td>
					Title:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="champtitle2">
				</td>
				<td>
					Phone:
				</td>
				<td>
					<input type="text" size="10" maxlength="10" name="champphone2">
				</td>
			</tr>
			<tr>
				<td><u>
					Anticipated Live Date:
				</u></td>
				<td>
					<input type="text" size="20" maxlength="20" name="LiveDate">
				</td>
			</tr>
			<tr>
				<td><u>
					Remote Access Type:
				</u></td>
				<td><select name=Remote>
					<option value ="Unknown">Unknown</option>
					<option value ="Fax line">Fax line</option>
  				<option value ="Dedicated Phone Line">Dedicated Phone Line</option>
  				<option value ="Internet">Internet</option>
  			</select></td>
			</tr>
			 <tr>
				<td>
					<input type="submit" value="Save" name="saveother">
				</td>
			</tr>
		</table>		
<?php
	}
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form> 		
<?php		
}
/*
***************************************QUERY TO ADD OTHER INFO***************************************
*/	
if((isset($_GET['saveother'])) && ($_GET['saveother'] == "Save"))
{
	mysql_select_db($dbname2);		
	$f_id = $_GET['f_id'];
	$name = $_GET["Name"];
	if($name <> "none")
	{
		$title = $_GET["Title"];
		$phone = $_GET["Phone"];
	}else
	{
		$title = "none";
		$phone = 0;
	}				
	$name1 = $_GET["Name1"];
	if($name1 <> "none")
	{
		$title1 = $_GET["Title1"];
		$phone1 = $_GET["Phone1"];
	}else
	{
		$title1 = "none";
		$phone1 = 0;
	}	
	$name2 = $_GET["Name2"];
	if($name2 <> "none")
	{
		$title2 = $_GET["Title2"];
		$phone2 = $_GET["Phone2"];
	}else
	{
		$title2 = "none";
		$phone2 = 0;
	}	
	$name3 = $_GET["Name3"];
	if($name3 <> "none")
	{
		$title3 = $_GET["Title3"];
		$phone3 = $_GET["Phone3"];
	}else
	{
		$title3 = "none";
		$phone3 = 0;
	}	
	$name4 = $_GET["Name4"];
	if($name4 <> "none")
	{
		$title4 = $_GET["Title4"];
		$phone4 = $_GET["Phone4"];
	}else
	{
		$title4 = "none";
		$phone4 = 0;
	}	
	$champ = $_GET["champ"];
	if($champ <> "none")
	{
		$champtitle = $_GET["champtitle"];
		$champphone = $_GET["champphone"];
	}else
	{
		$champtitle = "none";
		$champphone = 0;
	}
	$champ1 = $_GET["champ1"];
	if($champ1 <> "none")
	{
		$champtitle1 = $_GET["champtitle1"];
		$champphone1 = $_GET["champphone1"];
	}else
	{
		$champtitle1 = "none";
		$champphone1 = 0;
	}
	$champ2 = $_GET["champ2"];
	if($champ2 <> "none")
	{
		$champtitle2 = $_GET["champtitle2"];
		$champphone2 = $_GET["champphone2"];
	}else
	{
		$champtitle2 = "none";
		$champphone2 = 0;
	}
	$addother="UPDATE tbladditionalcontacts  SET Name = '$name',Title = '$title',Phone = '$phone',SystemChamp = '$champ',ChampionTitle = '$champtitle',
						ChampionPhone = '$champphone',Name1 = '$name1',Title1 = '$title1',Phone1 = '$phone1',Name2 = '$name2',Title2 = '$title2',
						Phone2 = '$phone2',Name3 = '$name3',Title3 = '$title3',Phone3 = '$phone3',Name4 = '$name4',Title4 = '$title4',Phone4 = '$phone4',
						signature = '$signature',SystemChamp1 = '$champ1',ChampionTitle1 = '$champtitle1',ChampionPhone1 = '$champphone1',SystemChamp2 = '$champ2',
						ChampionTitle2 = '$champtitle2',ChampionPhone2 = '$champphone2' WHERE FacilityID = '$f_id'";							
	mysql_query($addother) or die(mysql_error());
	
	$days = $_GET['days'];
	$startdate = $_GET['startdate'];
	$addstartdate = "UPDATE tbltotalequipment SET startdate = '$startdate',days = '$days' WHERE FacilityID = '$f_id'";
	mysql_query($addstartdate) or die(mysql_error());	
	$livedate = $_GET['LiveDate'];
	$remote = $_GET['Remote'];
	$addproject ="UPDATE tblprojectmanagement SET LiveDate = '$livedate',Remote = '$remote' WHERE FacilityID = '$f_id'";
	mysql_query($addproject) or die(mysql_error());		
	if(isset($_GET['existing_id']))
	{
		$existing_id = $_GET['existing_id'];
		header("Location: newfinishedpage.php?f_id=$f_id&existing_id=$existing_id");
	}else
	{		
		header("Location: newfinishedpage.php?f_id=$f_id");
	}	
}		
/*
***************************************FORM TO ADD PROJECT INFO***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "equip") && (isset($_GET['equip'])) && ($_GET['equip'] == "projectinfo"))
{
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$query1 = "SELECT * From tbltotalequipment WHERE FacilityID='$f_id'";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_fetch_array($result1);
	
	$query3 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
	$result3 = mysql_query($query3) or die(mysql_error());
	$row3 = mysql_fetch_array($result3);

	$query4 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
	$result4 = mysql_query($query4) or die(mysql_error());
	$row4 = mysql_fetch_array($result4);
	
	$query5 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$f_id' AND doortype = 'doortype9' Order by doornumber";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_num_rows($result5);
	
	$query6 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$f_id' AND doortype = 'doortype7' Order by doornumber";
	$result6 = mysql_query($query6) or die (mysql_error());
	$row6 = mysql_num_rows($result6);
?>
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table align ="center" width = "750" cellpadding=3>
<?php
	if(($row4['SUM(minilockcount)']<>0) || ($row3['SUM(zbracket)']<>0))
	{
?>
		<tr>
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Door Company Information</u>
			</td>
		</tr>
		<tr>
			<td colspan = "2"><b>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Magnetic Locks
			</b></td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				Fire Marshall Approval
			</td>
			<td>
				<input type="text" size="40" maxlength="40" name="marshall">
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				Connection to fire Panel
			</td>
			<td>
				<input type="text" size="40" maxlength="40" name="panel">
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				Fire Company
			</td>
			<td>
				<input type="text" size="40" maxlength="40" name="fire">
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				Timers (Schedule):
			</td>
			<td>
				<input type="text" size="40" maxlength="40" name="timers">
			</td>
		</tr>
<?php
	}else
	{
?>
		<input type="hidden" name="marshall" value="none">
		<input type="hidden" name="panel" value="none">
		<input type="hidden" name="fire" value="none">
		<input type="hidden" name="timers" value="none">
<?php
	}
	if($row5 > 0)
	{
?>
		<tr>
			<td><b>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Elevators
			</b></td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				Connection Company:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40" maxlength="40" name="connectiont">
			</td>
		</tr>
<?php
	}else
	{
?>
		<input type="hidden" name="connectiont" value="none">
<?php
	}
	if($row6 > 0)
	{
?>
	<tr>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Automatic Doors
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			Door Company:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40" maxlength="40" name="doorcompany">
		</td>
	</tr>
<?php
	}else
	{
?>
		<input type="hidden" name="doorcompany" value="none">
<?php
	}
	if (!$row1['TotalPullCordsactivity'] == 0)
	{
?>
		<tr>
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Other Information
			</u></td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				Wellness Check in Schedule:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			<td>
				<input type="text" size="40" maxlength="40" name="wellness">
			</td>
		</tr>
<?php
	}else
	{
?>
		<input type="hidden" name="wellness" value="">
<?php
	}
?>
	</table>
	<table align ="center">
		<tr>
			<td>
				Additional Comments:
			</td>
			<td>
				<textarea rows="12" cols="65" name="comments"></textarea>
			</td>	
		</tr>
	</table>
	<table width ="750" align="center">
		<tr>
			<td>
				<input type="submit" value="Save" name="saveproject">
			</td>
		</tr>
	</table>		
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>
	</form> 		
<?php
}
/*
***************************************QUERY TO ADD PROJECT INFO***************************************
*/	
if((isset($_GET['saveproject'])) && ($_GET['saveproject'] == "Save"))
{		
	mysql_select_db($dbname2);
	$f_id = $_GET['f_id'];
	$marshall = $_GET['marshall'];
	$panel = $_GET['panel'];
	$fire = $_GET['fire'];
	$timers = $_GET['timers'];
	$connection = $_GET['connectiont'];
	$doorcompany = $_GET['doorcompany'];
	$wellness = $_GET['wellness'];
	$comments = nl2br(addslashes($_GET['comments']));
	$addproject = "UPDATE tblprojectmanagement SET doorcompany = '$doorcompany',connectiont = '$connection',timers = '$timers',fire = '$fire',
								panel = '$panel',marshall = '$marshall',wellness = '$wellness', comments = '$comments'
								WHERE FacilityID = '$f_id'";
	mysql_query($addproject) or die(mysql_error());		
	header("Location: newfinishedpage.php?f_id=$f_id");
}		
if((isset($_GET['view'])) && ($_GET['view']=='new_to_existing_group'))
{
	mysql_select_db($dbname2);
	$cus = $_GET['customer_info_from_id'];
	$query14 = "SELECT * FROM tblfacilitygeneralinfo WHERE ID = '$cus'";
	$result14 = mysql_query($query14) or die (mysql_error());
	$row14 = mysql_fetch_array($result14);
	$address = $row14['StreetAddress'];
	$city = $row14['City'];
	$facilityname = $row14['FacilityName'];
	$contact_name = $row14['ContactName'];
	$phone_number = $row14['PhoneNumber'];
	$title = $row14['Title'];
	$fax = $row14['Fax'];
	$zip = $row14['PostalCode'];
	$second_number = $row14['secondnumber'];
	$email = $row14['Email'];
	$expansion = $row14['Expansion'];	
	$system_type = $row14['SystemType'];
	$groupid = $row14['GroupID'];
	$query15 = "SELECT GroupName FROM tblgroupquote WHERE ID = '$groupid'";
	$result15 = mysql_query($query15) or die (mysql_error());
	$row15 = mysql_fetch_array($result15);
	$group = $row15['GroupName'];
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table  width="750"  align ="center">
			<tr>
				<td align=center td colspan="5"><b>
	 			 	General Information  
	 			</b></td>
			</tr>
		</table>	
		<table cellpadding=2 table border ="0" width="750"  align ="center">
			<tr>
				<td><b>
					Customer Number:
				</b><td>
					<input type="text" size="6" maxlength="6" name="custnum" value = "<?php echo $row14['Cust_Num'] ?>"> (FROM PRIORITY)
				</td>
			</tr>
			<tr>
				<td width = "115"><b>
					Facility Name:
				</b></td>
				<td colspan="5">
					<input type="text" size="80" maxlength="255" name="Fname" value = "<?php echo $facilityname; ?>">
				</td>
			</tr>									
			<tr>
				<td width = "115"><font color="FF0000"<b>
					Quote Name:
				</b></font></td>
				<td colspan="5">
					<input type="text" size="80" maxlength="79" name="extname" value = "">
				</td>
			</tr>																								
			<tr>
				<td><b>
					Street Address:
				</b></td>
				<td colspan="5">
					<input type="text" size="80" maxlength="79" name="Address" value ="<?php echo $address; ?>">
				</td>
			</tr>
			<tr>
				<td><b>
					City,State,Postal Code:
				</b></td>
				<td colspan = "3">
					<input type="text" size="32" maxlength="32" name="city" value = "<?php echo $city; ?>">,
					<select name="state">
	
<?php			
					mysql_select_db($dbname);
					$query1 = "SELECT * FROM tblsalesrepbyterritories WHERE CountryCode = 'US' ORDER BY StateOrProvince";
					$result1 = mysql_query($query1) or die (mysql_error());	
					while($row1 = mysql_fetch_array($result1))
					{
?>
						<option value="<?php echo $row1['StateOrProvinceCode']; ?>" <?php if($row1['StateOrProvinceCode'] == $row14['StateOrProvinceCode']){ echo 'selected="selected"'; } ?>>  <?php echo $row1['StateOrProvince']; ?> </option>				
<?php
					}				
?>
					</select>				
					,<input type="text" size="16" maxlength="15" name="zip" value = <?php echo $zip; ?>>
				</td>		
			</tr>
			<tr>
				<td><b>
					Contact Name:
				</b></td>
				<td>
					<input type="text" size="32" maxlength="40" name="Contact" value = "<?php echo $contact_name; ?>">
				</td>
			<tr>
				<td><b>
					Title:
				</b></td>
				<td>
					<input type="text" size="32" maxlength="25" name="Title" value = "<?php echo $title; ?>">
				</td>
			</tr>
			<tr>
				<td><b>
					Phone Number:
				</b></td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone" value = "<?php echo $phone_number; ?>"> e.g. 4143588200
				</td>
			</tr>
			<tr>
				<td><b>
					Second Number:
				</b></td>
				<td>
					<input type="text" size="12" maxlength="10" name="Phone2" value = "<?php echo $second_number; ?>"> e.g. 4143588200
				</td>
			</tr>
			<tr>
				<td><b>
					Fax:
				</b></td>
				<td>
					<input type="text" size="12" maxlength="10" name="Fax" value = "<?php echo $fax; ?>"> e.g. 4143588100
				</td>
			</tr>
			<tr>
				<td><b>
					Email:
				</b></td>
				<td>
					<input type="text" size="32" maxlength="60" name="Email" value = "<?php echo $email; ?>">
				</td>
			</tr>	
			<tr>
				<td><b>
					System Type:
				</b></td>
				<td>
				<select name=Systype>
					<option value="<?php echo 'On_Call'; ?>" <?php if($system_type == 'On_Call'){ echo 'selected="selected"'; } ?>>  <?php echo 'On-Call'; ?> </option>
					<option value="<?php echo 'On_Site'; ?>" <?php if($system_type == 'On_Site'){ echo 'selected="selected"'; } ?>>  <?php echo 'On-Site'; ?> </option>
					<option value="<?php echo 'Elite'; ?>" <?php if($system_type == 'Elite'){ echo 'selected="selected"'; } ?>>  <?php echo 'Elite'; ?> </option>
				</select>
				</td> 
			</tr>
			 <tr>
		  	<td><b>
		  		Expansion:
		  	</b></td>
		  	<td>
					<select name=expansion>
						<option value="0" <?php if($expansion == 0){ echo 'selected="selected"'; } ?>>NO</option>
						<option value="1" <?php if($expansion == 1){ echo 'selected="selected"'; } ?>>YES</option>									
					</select>
				</td>
		  </tr>
			<tr> 		
				<td><b>
					Salesperson:
				</b></td>
				<td>
<?php
        mysql_select_db($dbname);
        $sales = $row14['Salesman'];
				$query9 = "SELECT id, f_name, l_name FROM employees WHERE dept = 1 AND Active = 0 ORDER BY f_name";
				$result9 = mysql_query($query9) or die (mysql_error());
?>	
				<select name=sman>
<?php								
				while($row9 = mysql_fetch_array($result9))	
				{				
?>							
					<option value="<?php echo $sales; ?>" <?php if($row9['id'] == $sales){ echo 'selected="selected"'; } ?>>  <?php echo $row9['f_name'].' '.$row9['l_name']; ?> </option>					
<?php
				}
?>
				</select>
<?php								
?>
 				</td>
			</tr>										
			<tr>
				<td><b>
					Group:
				</b></td>
				<td>
					<?php echo $group; ?>
				</td>
			</tr>									  							
			<tr>
				<td>
					<input type="submit" value="Save" name="save">
				</td>
			</tr>
		</table>
<?php
		echo	'<input type = "hidden" name="Existing_Facility_ID" value = "'.$cus.'">';
		echo	'<input type = "hidden" name="add_to_group" value = "'."yes".'">';	
		echo	'<input type = "hidden" name="groupid" value = "'.$groupid.'">';	
?>
	</form> 		
<?php	
}
if((isset($_GET['view'])) && ($_GET['view']=='choose_who_to_copy'))
{
	mysql_select_db($dbname2);
	if(!isset($_GET['groupid']))
	{
		$current_id = $_GET['current_facility_id'];
		$query20 = "SELECT GroupID FROM tblfacilitygeneralinfo WHERE ID = '$current_id'";
		$result20 = mysql_query($query20) or die (mysql_error());
		$row20 = mysql_fetch_array($result20);
		$groupid = $row20['GroupID'];
	}else
	{
		$groupid = $_GET['groupid'];
		$current_id = 0;
	}
	$query21 = "SELECT ID,FacilityName,QuoteName FROM tblfacilitygeneralinfo WHERE GroupID = '$groupid' AND Deleted = 0";
	$result21 = mysql_query($query21) or die (mysql_error());
	$query22 = "SELECT GroupName FROM tblgroupquote WHERE ID = '$groupid'";
	$result22 = mysql_query($query22) or die (mysql_error());
	$count22 = mysql_num_rows($result22);
	$row22 = mysql_fetch_array($result22);
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php	
	if($count22 > 0)
	{
?>
		<table>
			<tr>
				<td>
					Current Group you are going to add this to: <?php echo $row22['GroupName']; ?>
				</td>
			</tr>
			<tr>
				<td>
					Please select the Scope you would like to copy
				</td>
			</tr>
<?php	
			while($row21 = mysql_fetch_array($result21))
			{
				$facility_name = $row21['FacilityName'];
				$id = $row21['ID'];
				$quote_name = $row21['QuoteName'];	
?>
				<tr>
					<td>
						<input type="radio" name="facility_to_copy" value="<?php echo $id; ?>" <?php if($id == $current_id){ echo 'CHECKED'; } ?>><?php echo $facility_name. '-' .$quote_name;?>
					</td>
				</tr>							
<?php	
			}
?>			
			<tr>
				<td>
					<input type="submit" value="Save" name="save_facility_to_copy">
				</td>
			</tr>		
		</table>
<?php		
	}else
	{
?>
			<table>
				<tr>
					<td>
						Please create the group in which the last quote and your copy will be a part of.
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" size="32" maxlength="255" name="new_group_name" value = "">
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Save" name="save_group">
					</td>
				</tr>		
			</table>
<?php
			echo	'<input type = "hidden" name="Existing_Facility_ID" value = "'.$current_id.'">';
?>
		</form>	
<?php						
	}
}	
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>
