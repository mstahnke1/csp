<link rel="stylesheet" type="text/css" href="sales.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<link rel="stylesheet" type="text/css" href="proactive.css" />
<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
$date = date('Y-m-d H:i:s');
$signature = $_SESSION['username'];
/*
***************************************UPDATE SCOPE/CUSTOMER*************************************************************
*/
	$f_id = $_GET['f_id'];
	$getcus = "SELECT * FROM tblfacilitygeneralinfo WHERE ID='$f_id'";
	$resgetcus = mysql_query($getcus) or die (mysql_error());
	$cus = mysql_fetch_array($resgetcus);
	$pricelist = $cus['pricelist'];
	$groupid = $cus['GroupID'];
	$query9 = "SELECT GroupName FROM tblgroupquote WHERE ID = '$groupid'";
	$result9 = mysql_query($query9) or die (mysql_error());
	$count9 = mysql_num_rows($result9);
	$row9 = mysql_fetch_array($result9);
	$group = $row9['GroupName'];
	if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
	{
		/*QUERY17 Will find the ID of the open amendment for the Facility.  This means that when the person
		enters the page the values will show what is currently done in the amendment.*/
		$query17 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
		$result17 = mysql_query($query17) or die (mysql_error());
		$row17 = mysql_fetch_array($result17);
		$amendment_id = $row17['ID'];
		$getequip = "SELECT * FROM tbltotalequipment WHERE amendment_id='$amendment_id'";
	}else
	{
		$getequip = "SELECT * FROM tbltotalequipment WHERE FacilityID='$f_id'";
	}
	$resgetequip = mysql_query($getequip) or die (mysql_error());
	$equip = mysql_fetch_array($resgetequip);
	$dual = $equip["TotalCallCorddual"];
	$addbases = $equip['addbase'];
	$wmu = $equip["TotalWMUs"];
	$owmu = $equip["TotalOutdoorAreaUnits"];
	$sowmu = $equip["TotalOutdoorSolarUnits"];
	$watch = $equip["TotalWatches"];
	$fwatch = $equip["FemalePW"];
	$swatch = $equip["straplessPW"];
	$callb = $equip["TotalPanicButtons"];
	$tags = $equip["TotalPullTags"];
	$pull = $equip["TotalPullCords"];
	$pullw = $equip["TotalPullCordsactivity"];
	$ten = $equip["TotalCallCords"];
	$fifteen = $equip["TotalCallCordssingle15"];
	$style = $equip["CorridorLights"];
	$type = $equip["CorridorLightType"];
	$existing = $equip["TotalExistingCorrdiorLights"];
	$homefree = $equip["TotalHomeFreeCorrdiorLights"];
	$base = $equip["PagingBaseType"];
	$pager = $equip["PagerType"];
	$numpagers = $equip["PagerQuantity"];
	$hfpagers = $equip["HomeFreePager"];
	$fall = $equip["TotalFallUnits"];
	$chair90 = $equip["chair90day"];
	$chair180 = $equip["chair180day"];
	$bed90 = $equip["bed90day"];
	$bed180 = $equip["bed180day"];
	$ut = $equip["UTs"];
	$utfunction = strip_tags($equip["UTFunction"]);
	$client = $equip["TotalClientStations"];
	$clientl = strip_tags($equip["ClientStationlocation"]);
	$power = $equip["TotalCentralPowerSupplies"];
	$cpswire = $equip['CPSwire'];
	$job = strip_tags($equip["joboverview"]);
	$wirex = $equip["Wire162"];
	$wirey = $equip["Wire224"];
	$squeeze = $equip["Squeezeball"];
	$breath = $equip["breathcall"];
	$bed = $equip["bedpullcords"];
	$beda = $equip["bedpullcordsact"];
	$bath = $equip["bathpullcords"];
	$batha = $equip["bathpullcordsact"];
	$common = $equip["commonpullcords"];
	$commona = $equip["commonpullcordsact"];
	$pendant = $equip["pendant"];
	$watchstyle = $equip["watchstyle"];
	$baseconnect = $equip["baseconnect"];
	$utpower = $equip['utpower'];
	$lic = $equip['lic'];
	$days = $equip['days'];
	$startdate = $equip['startdate'];
	$whowiring = $equip['powertype'];
	$getcontacts = "SELECT * FROM tbladditionalcontacts WHERE FacilityID='$f_id'";
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
	$getprojinfo = "SELECT * FROM tblprojectmanagement WHERE FacilityID='$f_id'";
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
		if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "general"))
			{ 	
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
							<input type="text" size="6" maxlength="6" name="custnum" value = "<?php echo $cus['Cust_Num'] ?>"> (FROM PRIORITY)
						</td>
					</tr>
					<tr>
						<td width = "115"><b>
							Facility Name:
						</b></td>
						<td colspan="5">
							<input type="text" size="80" maxlength="255" name="Fname" value = "<?php echo $cus['FacilityName']; ?>">
						</td>
					</tr>									
					<tr>
						<td width = "115"><b>
							Quote Name:
						</b></td>
						<td colspan="5">
							<input type="text" size="80" maxlength="79" name="extname" value = "<?php echo $cus['QuoteName']; ?>">
						</td>
					</tr>																								
					<tr>
						<td><b>
							Street Address:
						</b></td>
						<td colspan="5">
							<input type="text" size="80" maxlength="79" name="Address" value ="<?php echo $cus['StreetAddress']; ?>">
						</td>
					</tr>
					<tr>
						<td><b>
							City,State,Postal Code:
						</b></td>
						<td colspan = "3">
							<input type="text" size="32" maxlength="32" name="city" value = "<?php echo $cus['City']; ?>">,
							<select name="state">
			
<?php			
							$conn2 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
							mysql_select_db('homefree');
							$query1 = "SELECT * FROM tblsalesrepbyterritories WHERE CountryCode = 'US' ORDER BY StateOrProvince";
							$result1 = mysql_query($query1) or die (mysql_error());	
							while($row1 = mysql_fetch_array($result1))
							{
?>
								<option value="<?php echo $row1['StateOrProvinceCode']; ?>" <?php if($row1['StateOrProvinceCode'] == $cus['StateOrProvinceCode']){ echo 'selected="selected"'; } ?>>  <?php echo $row1['StateOrProvince']; ?> </option>				
<?php
							}				
?>
							</select>				
								,<input type="text" size="16" maxlength="15" name="zip" value = <?php echo $cus['PostalCode']; ?>>
							</td>		
						</tr>
						<tr>
							<td><b>
								Contact Name:
							</b></td>
							<td>
								<input type="text" size="32" maxlength="40" name="Contact" value = "<?php echo $cus['ContactName']; ?>">
							</td>
						<tr>
							<td><b>
								Title:
							</b></td>
							<td>
								<input type="text" size="32" maxlength="25" name="Title" value = "<?php echo $cus['Title']; ?>">
							</td>
						</tr>
						<tr>
							<td><b>
								Phone Number:
							</b></td>
							<td>
								<input type="text" size="12" maxlength="10" name="Phone" value = "<?php echo $cus['PhoneNumber']; ?>"> e.g. 4143588200
							</td>
						</tr>
						<tr>
							<td><b>
								Second Number:
							</b></td>
							<td>
								<input type="text" size="12" maxlength="10" name="Phone2" value = "<?php echo $cus['secondnumber']; ?>"> e.g. 4143588200
							</td>
						</tr>
						<tr>
							<td><b>
								Fax:
							</b></td>
							<td>
								<input type="text" size="12" maxlength="10" name="Fax" value = "<?php echo $cus['Fax']; ?>"> e.g. 4143588100
							</td>
						</tr>
						<tr>
							<td><b>
								Email:
							</b></td>
							<td>
								<input type="text" size="32" maxlength="60" name="Email" value = "<?php echo $cus['Email']; ?>">
							</td>
						</tr>	
						<tr>
							<td><b>
								System Type:
							</b></td>
							<td>
							<select name=Systype>
								<option value ="<?php echo $cus['SystemType']; ?>"><?php echo $cus['SystemType']; ?></option>
  							<option value ="On-Call">On-Call</option>
  							<option value ="On-Site">On-Site</option>
  							<option value ="Elite">Elite</option>
  						</select>
  						</td> 
  					</tr>
  					 <tr>
					  	<td><b>
					  		Expansion:
					  	</b></td>
					  	<td>
								<select name=expansion>
									<option value="0" <?php if($cus['Expansion'] == 0){ echo 'selected="selected"'; } ?>>NO</option>
									<option value="1" <?php if($cus['Expansion'] == 1){ echo 'selected="selected"'; } ?>>YES</option>									
								</select>
							</td>
					  </tr>
  					<tr> 		
  						<td><b>
  							Salesperson:
  						</b></td>
  						<td>
<?php
							$conn7 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
	            mysql_select_db('homefree');
	            $sales = $cus['Salesman'];
							$query8 = "SELECT id, f_name, l_name FROM employees WHERE active = 0 AND id = '$sales' ORDER BY f_name";
							$result8 = mysql_query($query8) or die (mysql_error());
        			$count8 = mysql_num_rows($result8);
        			$row8 = mysql_fetch_array($result8);	  
        			if($count8 > 0)
        			{	 	
        				echo	'<input type = "hidden" name="sman" value = "'.$sales.'">';
	 							echo $row8['f_name']. ' ' . $row8['l_name'];         				       			         		            	
							}else
							{
								$query9 = "SELECT id, f_name, l_name FROM employees WHERE active = 0 AND dept = 1 ORDER BY f_name";
								$result9 = mysql_query($query9) or die (mysql_error());
?>	
								<select name=sman>
<?php								
								while($row9 = mysql_fetch_array($result9))	
								{				
?>												
										<option value ="<?php echo $row9['id']; ?>"><?php echo $row9['f_name'].' '.$row9['l_name']; ?></option>
<?php
								}
?>
								</select>
<?php								
	 						}
  	    			mysql_close($conn7);	
?>
     					</td>
						</tr>
<?php
						if($count9 > 0)
						{  		
?>										
	  					<tr>
	  						<td>
	  							Group:
	  						</td>
	  						<td>
	  							<?php echo $group; ?>
	  						</td>
	  					</tr>			
<?php
						}else
						{
?>
							<tr>
								<td>							
									<?php echo '<a href="' . 'Updatescope.php'.'?f_id='.$f_id.'&page=addtogroup">'?>Add to a Group</a>
								</td>
							</tr>
<?php
						}							
?>						  							
						<tr>
							<td>
								<input type="submit" value="Save" name="update">
							</td>
						</tr>
					</table>
<?php
					echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
					echo	'<input type = "hidden" name="view" value = "'."update".'">';
					if($groupid > 0)
					{
						echo	'<input type = "hidden" name="groupid" value = "'.$groupid.'">';
					}				
?>
					</form> 		
<?php
			}
if((isset($_GET['update'])) && ($_GET['update']== "Save")) 
{	
	$f_id = $_GET['f_id'];
	$custnum = $_GET['custnum'];
	$Fname =addslashes( $_GET["Fname"]);
	$pricelist = 0;
	$Address = nl2br($_GET["Address"]);
	$Contact= $_GET["Contact"];
	$Phone =$_GET["Phone"];
	$second =  $_GET["Phone2"];
	$Title = $_GET["Title"];
	$Email = $_GET["Email"];
	$Fax =  $_GET["Fax"];
	$System = $_GET["Systype"];
	$expansion = $_GET['expansion'];
	$city = $_GET["city"];
	$zip = $_GET["zip"];
	$sman = $_GET['sman'];
	$statecode = $_GET["state"];
	$extname =addslashes($_GET["extname"]);
	if(isset($_GET['groupid']))
	{
		$groupid = $_GET['groupid'];		
	}else
	{
		$groupid = 0;
	}
	include 'includes/config.php';
	include 'includes/opendb.php';		
	$query7 = "UPDATE tblfacilitygeneralinfo SET FacilityName = '$Fname', Cust_Num = '$custnum',pricelist = '$pricelist', StreetAddress = '$Address', ContactName = '$Contact', PhoneNumber = '$Phone',
						secondnumber = '$second',Title = '$Title',Email = '$Email', Fax = '$Fax', SystemType = '$System', Expansion = '$expansion', lastupdated = '$date', City = '$city',
						PostalCode = '$zip',StateOrProvinceCode = '$statecode',Salesman = '$sman',QuoteName = '$extname',GroupID = '$groupid'	WHERE ID = '$f_id'";
	mysql_query($query7) or die(mysql_error());	
	header("Location: newfinishedpage.php?f_id=$f_id");
}
	
/*
***************************************UPDATE EQUIPMENT (HF NETWORK)***************************************
*/		
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "network"))
	{
		$f_id = $_GET['f_id'];
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="750"  align ="center">
			<tr>
				<td colspan="6" align = "center"><font face = "Arial" size = 4"><b>
					Equipment
				</b></td>
			</tr>
			<tr>
				<td colspan = "6" align = "center"><b>
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
				if($equip['upgrade'] == 1)
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
?>																				
			</tr>						
			<tr>
				<td colspan = "6" align = "center"><b>
					Network
				</td>
			</tr>			
			<tr>
				<td><b>
					Base Unit Information 
				</b></td>
			</tr>	
<?php							
		if($equip['baseconnect'] == "network") 
			{
?>
				<tr>
					<td colspan="6">
						<input type="radio" name="baseconnect" value="serial"> Base unit via Serial Port 
			 			<input type="radio" name="baseconnect" value="network"CHECKED> All Base Units Networked
					</td>
				</tr>
	<?php
			}else
			{
?>
				<tr>
					<td colspan="6">
						<input type="radio" name="baseconnect" value="serial" CHECKED> Base unit via Serial Port 
			 			<input type="radio" name="baseconnect" value="network"> All Base Units Networked
					</td>
				</tr>
<?php
			}
?>							
			<tr>
				<td colspan="5">
					Additional Base Units? The Scope of work automatically detects the amount of base units according to the amount of WMU's and Door WMU's,
					if you need to add more due to the layout of a campus or building please enter the amount of additional network base units required.
				</td>
				<td>
					<input type="text" size="1" maxlength="1" name="addbaseunits" value = "<?php echo $addbases; ?>">
				</td>				
			</tr>		
			<tr>
				<td>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					Area Units: <input type="text" size="5" maxlength="4" name="wmu" value="<?php echo $wmu; ?>">
				</td>
				<td>
					Outdoor Area Units: <input type="text" size="5" maxlength="4" name="owmu" value = "<?php echo $owmu; ?>">
				</td>
				<td>
					Solar Outdoor Area Units: <input type="text" size="5" maxlength="4" name="sowmu" value = "<?php echo $sowmu; ?>">
				</td>
			</tr>		
			<tr>
				<td>
					<input type="submit" value="Save" name="savenetwork">
				</td>
			</tr>											
		</table>
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
		if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
		{
			echo	'<input type = "hidden" name="amend" value = "1">';
		}
?>		
		</form>
<?php	
	}
/*
***************************************QUERY TO UPDATE EQUIPMENT (HF NETWORK)***************************************
*/
if((isset($_GET['savenetwork'])) && ($_GET['savenetwork'] == "Save"))
	{
		$f_id = $_GET['f_id'];
		$wmu = $_GET['wmu'];
		$addbaseunits = $_GET['addbaseunits'];
		$owmu = $_GET['owmu'];
		$baseconnect = $_GET['baseconnect'];
		$sowmu = $_GET['sowmu'];
		if(isset($_GET['upgrade']))
		{
			$upgrade = 1;
		}else
		{
			$upgrade = 0;
		}
		if(isset($_GET['amend']))
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$updatenetwork = "UPDATE tbltotalequipment SET TotalWMUs='$wmu',TotalOutdoorAreaUnits = '$owmu',TotalOutdoorSolarUnits = '$sowmu',baseconnect = '$baseconnect', addbase = '$addbaseunits', upgrade = '$upgrade' WHERE amendment_id = '$amendment_id'";
			mysql_query($updatenetwork) or die(mysql_error());			
		}else
		{
			$updatenetwork = "UPDATE tbltotalequipment SET TotalWMUs='$wmu',TotalOutdoorAreaUnits = '$owmu',TotalOutdoorSolarUnits = '$sowmu',baseconnect = '$baseconnect', addbase = '$addbaseunits', upgrade = '$upgrade' WHERE FacilityID = '$f_id'";
			mysql_query($updatenetwork) or die(mysql_error());
		}
		header("Location: newfinishedpage.php?f_id=$f_id");
	}
/*
***************************************FORM TO ADD EQUIPMENT (ACCESSORIES)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "accessories"))
	{
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
			<tr>
<?php
			if($system <> "On-Call")
				{			
?>							
					<tr>
						<td width = 100>
							Male Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="watch" value = "<?php echo $watch; ?>">
						</td>
						<td width = 100>
							Female Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="fwatch" value = "<?php echo $fwatch; ?>">
						</td>
						<td width = 100>
							Strapless Watches 
						</td>
						<td>	
							<input type="text" size="5" maxlength="4" name="swatch" value = "<?php echo $swatch; ?>">
						</td>						
					</tr>
					<tr>
						<td colspan = "6">
							<div align="center"><hr width="50%"></div>
						</td>
					</tr>					
<?php
				}
			if($system <> "On-Site")						
				{
?>					
					<tr>
						<td width = 100>
							Call Buttons 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="callb" value = "<?php echo $callb; ?>">
						</td>
						<td width = 100>
							Pull Tags 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="tags" value = "<?php echo $tags; ?>">
						</td>
					</tr>
					<tr>
						<td width = 100>
							Pendant Style Attachments 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="pendant" value = "<?php echo $pendant; ?>">
						</td>
						<td width = 100>
							Watch Style Attachments 
						</td>
						<td>
							<input type="text" size="5" maxlength="4" name="watchstyle" value = "<?php echo $watchstyle; ?>">
						</td>
<?php
				}
?>										
					</tr>
					<tr>
						<td>
							<input type="submit" value="Save" name="saveaccessories" value = "0">
						</td>
					</tr>		
				</table>
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
		if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
		{
			echo	'<input type = "hidden" name="amend" value = "1">';
		}		
?>
</form>
<?php		
	}
/*
***************************************QUERY TO ADD EQUIPMENT (ACCESSORIES)***************************************
*/
if((isset($_GET['saveaccessories'])) && ($_GET['saveaccessories'] == "Save"))
	{
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
		if(isset($_GET['amend']))
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$addaccessories = "UPDATE tbltotalequipment SET TotalWatches = '$watch', FemalePW = '$fwatch', straplessPW = '$swatch', TotalPanicButtons = '$callb', TotalPullTags = '$tags', pendant = '$pendant',
			watchstyle = '$watchstyle' WHERE amendment_id = '$amendment_id'";
			mysql_query($addaccessories) or die(mysql_error());	
		}else	
		{				
			$addaccessories = "UPDATE tbltotalequipment SET TotalWatches = '$watch', FemalePW = '$fwatch', straplessPW = '$swatch', TotalPanicButtons = '$callb', TotalPullTags = '$tags', pendant = '$pendant',
			watchstyle = '$watchstyle' WHERE FacilityID = '$f_id'";
			mysql_query($addaccessories) or die(mysql_error());
			header("Location: newfinishedpage.php?f_id=$f_id");		
		}
		header("Location: newfinishedpage.php?f_id=$f_id");	
	}	
/*
***************************************FORM TO ADD EQUIPMENT (PULL CORDS)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "pullcords"))
	{		
		$f_id = $_GET['f_id'];
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="750"  align ="center">
			<tr>
				<td align=center td colspan ="6"><font size=3 ><b>  
					Pull Cords
				</b></td>
			</tr>
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
					<option value ="<?php echo $type; ?>"><?php echo $type; ?></option>
					<option value ="NONE">NONE</option>
  				<option value ="HomeFree">Homefree</option>
  				<option value ="Existing">Existing</option>
  				<option value ="Both">Both</option>
  			</select></td>
  			<td>
  				Corridor Light Style:
  			</td>
  			<td><select name=style>
  				<option value ="<?php echo $style; ?>"><?php echo $style; ?></option>
  				<option value ="NONE">NONE</option>
  				<option value ="Single">Single</option>
  				<option value ="Double">Double</option>
  				<option value ="Quad">Quad</option>
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
			<tr>
				<td>
					<input type="submit" value="Save" name="savepullcords">
				</td>
			</tr>		  		
  	</table>
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
		if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
		{
			echo	'<input type = "hidden" name="amend" value = "1">';
		}			
?>
		</form>
<?php
	}
/*
***************************************QUERY TO ADD EQUIPMENT (PULL CORDS)***************************************
*/	
if((isset($_GET['savepullcords'])) && ($_GET['savepullcords'] == "Save"))
	{	
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
		if(isset($_GET['amend']))
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$addpullcords = "UPDATE tbltotalequipment SET TotalPullCords = '$pull', TotalPullCordsactivity = '$pullw', TotalCallCords = '$ten',
											TotalCallCordssingle15 = '$fifteen', TotalCallCorddual = '$dual', CorridorLights = '$style', CorridorLightType = '$type',
											TotalExistingCorrdiorLights = '$existing', TotalHomeFreeCorrdiorLights = '$homefree', Squeezeball = '$squeeze',
											breathcall = '$breath', bedpullcords = '$bed', bathpullcords = '$bath', commonpullcords = '$common', bedpullcordsact = '$beda',
											bathpullcordsact = '$batha', commonpullcordsact = '$commona' WHERE amendment_id = '$amendment_id'";
			mysql_query($addpullcords) or die(mysql_error());	
		}else	
		{		
			$addpullcords = "UPDATE tbltotalequipment SET TotalPullCords = '$pull', TotalPullCordsactivity = '$pullw', TotalCallCords = '$ten',
											TotalCallCordssingle15 = '$fifteen', TotalCallCorddual = '$dual', CorridorLights = '$style', CorridorLightType = '$type',
											TotalExistingCorrdiorLights = '$existing', TotalHomeFreeCorrdiorLights = '$homefree', Squeezeball = '$squeeze',
											breathcall = '$breath', bedpullcords = '$bed', bathpullcords = '$bath', commonpullcords = '$common', bedpullcordsact = '$beda',
											bathpullcordsact = '$batha', commonpullcordsact = '$commona' WHERE FacilityID = '$f_id'";
			mysql_query($addpullcords) or die(mysql_error());
		}
		header("Location: newfinishedpage.php?f_id=$f_id");		
	}	
	/*
***************************************FORM TO ADD EQUIPMENT (FALL UNITS)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "awareunits"))
	{	
		$f_id = $_GET['f_id'];
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="750"  align ="center">
			<tr>
				<td align=center td colspan ="6"><font size=3 ><b>  
					Fall Units
				</b></td>
			</tr>	
  		<tr>
  			<td>
  				Fall Units
  			</td>
  			<td>
  				<input type="text" size="6" maxlength="6" name="fall" value = "<?php echo $fall; ?>">
  			</td>
  		</tr>
			<tr>
				<td align=center td colspan ="6"><b>  
					Fall Pads
				</b></td>
			</tr>	  		
  		<tr>  			
  			<td>
  				Chair Pad 90 day
  			</td>
  			<td>
  				<input type="text" size="6" maxlength="6" name="chair90" value = "<?php echo $chair90; ?>">
  			</td>
  			<td>
  				Chair Pad 180 day
  			</td>			
  			<td>
  				<input type="text" size="6" maxlength="6" name="chair180" value = "<?php echo $chair180; ?>">
  			</td>
  		</tr>
  		<tr>    			
  			<td>
  				Bed Pad 90 day
  			</td>
  			<td>
  				<input type="text" size="6" maxlength="6" name="bed90" value = "<?php echo $bed90; ?>">
  			</td>
  			<td>
  				Bed Pad 180 day</td><td><input type="text" size="6" maxlength="6" name="bed180" value = "<?php echo $bed180; ?>">
  			</td>
 			</tr>
			<tr>
				<td>
					<input type="submit" value="Save" name="savefallunits">
				</td>
			</tr>	 			
 		</table>		
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
		if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
		{
			echo	'<input type = "hidden" name="amend" value = "1">';
		}				
?>
		</form>
<?php
	}
/*
***************************************QUERY TO ADD EQUIPMENT (FALL UNITS)***************************************
*/	
if((isset($_GET['savefallunits'])) && ($_GET['savefallunits'] == "Save"))
	{		
		$f_id = $_GET['f_id'];
		$fall = $_GET["fall"];
		$chair90 = $_GET["chair90"];
		$chair180 = $_GET["chair180"];
		$bed90 = $_GET["bed90"];
		$bed180 = $_GET["bed180"];
		if(isset($_GET['amend']))
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$updatefallunits = "UPDATE tbltotalequipment SET TotalFallUnits = '$fall', bed90day = '$bed90', bed180day = '$bed180', chair90day = '$chair90', 
											chair180day = '$chair180' WHERE amendment_id = '$amendment_id'";
			mysql_query($updatefallunits) or die(mysql_error());	
		}else	
		{		
			$updatefallunits = "UPDATE tbltotalequipment SET TotalFallUnits = '$fall', bed90day = '$bed90', bed180day = '$bed180', chair90day = '$chair90', 
											chair180day = '$chair180' WHERE FacilityID = '$f_id'";
			mysql_query($updatefallunits) or die(mysql_error());		
		}
		header("Location: newfinishedpage.php?f_id=$f_id");		
	}
/*
***************************************FORM TO ADD EQUIPMENT (UTS)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "uts"))
	{
		$f_id = $_GET['f_id'];
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="750"  align ="center" >
			<tr>
				<td align=center td colspan ="6"><font size=3 ><b>  
					Universal Transmitters
				</b></td>
			</tr>	
			<tr>
 				<td colspan = "2"> 
 					Universal Transmitters (Enter the quantity of UT's that have a function other than a door)  <input type="text" size="6" maxlength="6" name="ut" value = "<?php echo $ut; ?>">
 				</td>
 			</tr>
 			<tr> 				
 				<td>
 					Universal Transmitter Function
 				</td>
 				<td>
 					<textarea rows="5" cols="60" name="utfunction"><?php echo $utfunction; ?></textarea>
 				</td>
 			</tr>
<?php 			
if($utpower == "yes")
{
?>
 		<tr>
 			<td align=center colspan="6">
 				 <input type="radio" name="utpower" value="no">
			 		UT's Powered By Batteries
				 <input type="radio" name="utpower" value="yes" CHECKED>
					 UT's Powered By Power Source
					 <input type="radio" name="utpower" value="none">
					 No UT's
			</td>
		</tr>		
<?php
}elseif($utpower == "no")
{
?>			
		<tr>
 			<td align=center colspan="6">
 				 <input type="radio" name="utpower" value="no"  CHECKED>
			 		UT's Powered By Batteries
				 <input type="radio" name="utpower" value="yes">
					 UT's Powered By Power Source
					 <input type="radio" name="utpower" value="none">
					 No UT's
			</td>
		</tr>
<?php
}else
{
?>
		<tr>
 			<td align=center colspan="6">
 				 <input type="radio" name="utpower" value="no">
			 		UT's Powered By Batteries
				 <input type="radio" name="utpower" value="yes">
					 UT's Powered By Power Source
					 <input type="radio" name="utpower" value="none" CHECKED>
					 No UT's
			</td>
		</tr>
	
<?php
}
?>		
		<tr>
			<td>
				<input type="submit" value="Save" name="utsave">
			</td>
		</tr>	
 	</table>
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
		if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
		{
			echo	'<input type = "hidden" name="amend" value = "1">';
		}			
?>
	</form>
<?php				
}			
/*
***************************************QUERY TO ADD EQUIPMENT (UTS)***************************************
*/	
if(isset($_GET['utsave']))
	{		
		$f_id = $_GET['f_id'];
		$ut = $_GET["ut"];
		$utfunction = nl2br(addslashes($_GET["utfunction"]));
		$utpower = $_GET['utpower'];
		if(isset($_GET['amend']))
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$adduts = "UPDATE tbltotalequipment SET UTs = '$ut', UTFunction = '$utfunction', utpower = '$utpower' WHERE amendment_id = '$amendment_id'";
			mysql_query($adduts) or die(mysql_error());	
		}else	
		{		
			$adduts = "UPDATE tbltotalequipment SET UTs = '$ut', UTFunction = '$utfunction', utpower = '$utpower' WHERE FacilityID = '$f_id'";
			mysql_query($adduts) or die(mysql_error());		
		}
		header("Location: newfinishedpage.php?f_id=$f_id");
	}
/*
***************************************FORM TO ADD EQUIPMENT (CLIENTS)***************************************
*/		
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "clients"))
	{
		$f_id = $_GET['f_id'];
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="750"  align ="center">
 			<tr>
 				<td align=center colspan="6"><font size=3 face = "Arial"><b>
 					Client Stations  
 				</b></td> 
 			</tr>
 			<tr>
 				<td>
					Client Computers(License Included with each computer)
 				</td>
 				<td>
 					<input type="text" size="6" maxlength="6" name="client" value = "<?php echo $client; ?>">
 				</td>
 			</tr>
 			<tr> 				
 				<td>
 					Client Station Location
 				</td>
 				<td>
 					<textarea rows="5" cols="40" name="clientl"><?php echo $clientl; ?></textarea>
 				</td>
 			</tr>
 			<tr>
 				<td>
 					Client Licenses(For Customer using non-HomeFree Computers as a client)
 				</td>
 				<td>
 					<input type="text" size="6" maxlength="6" name="lic" value = "<?php echo $lic; ?>">
 				</td>
 			</tr>
			<tr>
				<td>
					<input type="submit" value="Save" name="saveclients">
				</td>
			</tr>		 		
 		</table>				
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
		if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
		{
			echo	'<input type = "hidden" name="amend" value = "1">';
		}			
?>
		</form>
<?php	
	}
/*
***************************************QUERY TO ADD EQUIPMENT (UTS)***************************************
*/	
if((isset($_GET['saveclients'])) && ($_GET['saveclients'] == "Save"))
	{		
		$f_id = $_GET['f_id'];
		$client = $_GET["client"];
		$clientl = nl2br(addslashes($_GET["clientl"]));
		$lic = $_GET['lic'];
		if(isset($_GET['amend']))
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$addclients = "UPDATE tbltotalequipment SET TotalClientStations= '$client', ClientStationlocation = '$clientl', lic = '$lic' WHERE amendment_id = '$amendment_id'";
			mysql_query($addclients) or die(mysql_error());	
		}else	
		{		
			$addclients = "UPDATE tbltotalequipment SET TotalClientStations= '$client', ClientStationlocation = '$clientl', lic = '$lic' WHERE FacilityID = '$f_id'";
			mysql_query($addclients) or die(mysql_error());		
		}
		header("Location: newfinishedpage.php?f_id=$f_id");
	}		
/*
***************************************FORM TO ADD EQUIPMENT (POWER AND WIRE)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "power"))
	{
		$f_id = $_GET['f_id'];
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="759"  align ="center" >
 			<tr>
 				<td align=center colspan="6"><font size=3 face = "Arial"><b>
 					Central Power and Wire
 				</b></td>
 			</tr>
 			<tr>
 				<td colspan="6"><font size=2 face = "Arial"><b>
 					Power Source(Choose one)
 				</b></td>
 		</tr> 		
 		<tr>
 			<td colspan="6">
<?php
if($whowiring == "outlets")
{
?>
 				<input type="radio" name="power" value="outlets" CHECKED>Outlets installed by customer</br>
 				<input type="radio" name="power" value="cpshf">Central Power Supply, installed by HomeFree</br>
				<input type="radio" name="power" value="cpscus">Central Power Supply, installed by Customer
<?php
}elseif($whowiring == "cpshf")
{
?> 		
				<input type="radio" name="power" value="outlets">Outlets installed by customer</br>		
				<input type="radio" name="power" value="cpshf" CHECKED>Central Power Supply, installed by HomeFree</br>
				<input type="radio" name="power" value="cpscus">Central Power Supply, installed by Customer
<?php
}else
{
?> 		
				<input type="radio" name="power" value="outlets">Outlets installed by customer</br>		
				<input type="radio" name="power" value="cpshf">Central Power Supply, installed by HomeFree</br>
				<input type="radio" name="power" value="cpscus" CHECKED>Central Power Supply, installed by Customer	
<?php
}
?>								
			</td>
		</tr>
 	</table>
 	<table cellpadding=3 table border ="0" width="759"  align ="center" >		
		<tr>
 			<td width = 180>
 				Central Power Supply Quantity
 			</td>
 			<td>
 				<input type="text" size="6" maxlength="6" name="cpsquantity" value = "<?php echo $power; ?>">
 			</td>
 		</tr>
		<tr>
 			<td width = 220>
 				Wire for Central Power Supply ONLY
 			</td>
 			<td>
 				<input type="text" size="8" maxlength="8" name="cpswire" value = "<?php echo $cpswire; ?>">
 			</td>
 		</tr>  		
 	</table>
 	<table cellpadding=3 table border ="0">		 
 		<tr>
 			<td colspan="2"><b>
 				Other Wire Needed
 			</b></td>
 		</tr>	  				
 		<tr>
 			<td width = 60>
 				Wire 16-2
 			</td>
 			<td width = 80>
 				<input type="text" size="6" maxlength="6" name="wirex" value = "<?php echo $wirex; ?>">
 			</td>
 			<td width = 60>
 				Wire 22-4 
 			</td>
 			<td width = 80>
 				<input type="text" size="6" maxlength="6" name="wirey" value = "<?php echo $wirey; ?>">
 			</td>
 		</tr>
			<tr>
				<td>
					<input type="submit" value="Save" name="savepower">
				</td>
			</tr>	 		
	</table>		
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
		if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
		{
			echo	'<input type = "hidden" name="amend" value = "1">';
		}			
?>
		</form>
<?php	
	}
/*
***************************************QUERY TO ADD EQUIPMENT (POWER AND WIRE)***************************************
*/	
if((isset($_GET['savepower'])) && ($_GET['savepower'] == "Save"))
	{		
		$f_id = $_GET['f_id'];
		$wirex = $_GET['wirex'];
		$wirey = $_GET['wirey'];
		$cpsquantity = $_GET['cpsquantity'];
		$cpswire = $_GET['cpswire'];
		$whowiring = $_GET['power'];
		if(isset($_GET['amend']))
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$addclients = "UPDATE tbltotalequipment SET TotalClientStations= '$client', ClientStationlocation = '$clientl', lic = '$lic' WHERE amendment_id = '$amendment_id'";
			mysql_query($addclients) or die(mysql_error());	
		}else	
		{		
			$addclients = "UPDATE tbltotalequipment SET TotalCentralPowerSupplies = '$cpsquantity', CPSwire = '$cpswire', Wire224 = '$wirey', Wire162 = '$wirex', powertype = '$whowiring' WHERE FacilityID = '$f_id'";
			mysql_query($addclients) or die(mysql_error());
		}
		header("Location: newfinishedpage.php?f_id=$f_id");
	}		
/*
***************************************FORM TO ADD EQUIPMENT (PAGING)***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "paging"))
	{
		$f_id = $_GET['f_id'];
		$query14 = "SELECT Expansion FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
		$result14 = mysql_query($query14) or die(mysql_error());
		$row14 = mysql_fetch_array($result14);
		$expansion = $row14['Expansion'];		
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="400"  align ="center">
  		<tr>
  			<td align=center colspan="8"><font size=3 face = "Arial"><b>
  		  	Paging
  		  </b></td>
  		</tr>
  		<tr>
  			<td>
  				Paging Base Type:
  			</td>
  			<td><select name=base>
  				<option value ="<?php echo $base; ?>"><?php echo $base; ?></option>
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
  			<td>
  				Pager Type
  			</td> 			
  			<td><select name=pager>
  				<option value ="<?php echo $pager; ?>"><?php echo $pager; ?></option>
  				<option value ="NONE">NONE</option>
  				<option value ="Commtech7900">Commtech7900</option>
  				<option value ="Apollo">Apollo</option>
  			</select></td>
  		</tr>
  		<tr>  			
  			<td>
  				Number of Pagers
  			</td>
  			<td>
  				<input type="text" size="6" maxlength="6" name="numpagers" value="<?php echo $numpagers; ?>">
  			</td>
  		</tr>
<?php
			if(($expansion == 0) && (!isset($_GET['type'])))
			{
?>				  		
	  		<tr>   			
	  			<td>
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
	  			<td>
	  				Number of HomeFree Pagers
	  			</td>
	  			<td>
	  				<input type="text" size="6" maxlength="6" name="hfpagers" value="<?php echo $hfpagers; ?>">
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
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
		if((isset($_GET['type'])) && ($_GET['type'] == 'amend'))
		{
			echo	'<input type = "hidden" name="amend" value = "1">';
		}				
?>
		</form>
<?php	 					
	}
/*
***************************************QUERY TO ADD EQUIPMENT (PAGING)***************************************
*/	
if((isset($_GET['savepaging'])) && ($_GET['savepaging'] == "Save"))
	{		
		$f_id = $_GET['f_id'];
		$base = $_GET["base"];
		$pager = $_GET["pager"];
		$numpagers = $_GET["numpagers"];
		$hfpagers = $_GET["hfpagers"];
		if(isset($_GET['amend']))
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$addpaging = "UPDATE tbltotalequipment SET HomeFreePager = '$hfpagers', PagingBaseType = '$base', PagerQuantity = '$numpagers', PagerType = '$pager' WHERE amendment_id = '$amendment_id'";
			mysql_query($addpaging) or die(mysql_error());	
		}else	
		{		
			$addpaging = "UPDATE tbltotalequipment SET HomeFreePager = '$hfpagers', PagingBaseType = '$base', PagerQuantity = '$numpagers', PagerType = '$pager' WHERE FacilityID = '$f_id'";
			mysql_query($addpaging) or die(mysql_error());
		}	
		header("Location: newfinishedpage.php?f_id=$f_id");
	}		
/*
***************************************FORM TO ADD JOB DESCRIPTION***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "jobdescription"))
{
	$f_id = $_GET['f_id'];
?>
	<form method="GET" name="job" action="<?php echo $_SERVER['PHP_SELF'];?>">
 		<table cellpadding=3 table border ="0" width="750"  align ="center" >
 			<tr>
<?php
			if($_GET['type'] == 'amend')
			{
				echo	'<input type = "hidden" name="type" value="amend">';
?>				
 				<td align=center>
 					Amendment Overview
 				</td>	 				
				<td>
					<textarea rows="12" cols="70" name="job"><?php echo $job; ?></textarea>	
				</td>
<?php
			}else
			{
?> 		
 				<td align=center>
 					Job Overview
 				</td>		
				<td>
					<textarea rows="12" cols="70" name="job"><?php echo $job; ?>	</textarea>	
				</td>
<?php
			}
?>					
			</tr>
 			<tr>
				<td>
					<input type="submit" value="Save" name="savejobdes">
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
***************************************QUERY TO ADD JOB DESCRIPTION***************************************
*/	
if((isset($_GET['savejobdes'])) && ($_GET['savejobdes'] == "Save"))
	{		
		$f_id = $_GET['f_id'];
		$job = nl2br(addslashes($_GET["job"]));
		
		if($_GET['type'] == 'amend')
		{
			$query16 = "SELECT ID FROM tblamendmentinfo WHERE FacilityID = '$f_id' AND Status = 0";
			$result16 = mysql_query($query16) or die (mysql_error());
			$row16 = mysql_fetch_array($result16);
			$amendment_id = $row16['ID'];
			$addjobdes = "UPDATE tbltotalequipment SET joboverview = '$job' WHERE amendment_id = '$amendment_id'";
			mysql_query($addjobdes) or die(mysql_error());
			header("Location: newfinishedpage.php?f_id=$f_id");
		}else
		{
			$addjobdes = "UPDATE tbltotalequipment SET joboverview = '$job' WHERE FacilityID = '$f_id'";
			mysql_query($addjobdes) or die(mysql_error());		
			header("Location: newfinishedpage.php?f_id=$f_id");
		}
		
	}	
/*
***************************************FORM TO ADD OTHER STUFF***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "otherinfo"))
	{
		$f_id = $_GET['f_id'];
?>
		<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table cellpadding=3 table border ="0" width="750"  align ="center" >
 			<tr>
 				<td width = 115>
 					Quote Good For:
 				</td>
 				<td width = 55>
				<select name=days>
					<option value ="<?php echo $days;?>"><?php echo $days;?> Days</option>
					<option value ="30">30 Days</option>
  				<option value ="45">45 Days</option>
  				<option value ="60">60 Days</option>
  				<option value ="90">90 Days</option>
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
					<option value ="<?php echo $remote; ?>"><?php echo $remote; ?></option>
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
		$updateproj = "UPDATE tblprojectmanagement SET LiveDate = '$livedate',Remote = '$remote' WHERE FacilityID = '$f_id'";	
		mysql_query($updateproj) or die(mysql_error());			
		header("Location: newfinishedpage.php?f_id=$f_id");
		
	}
/*
***************************************FORM TO ADD PROJECT INFO***************************************
*/	
if((isset($_GET['view'])) && ($_GET['view'] == "update") && (isset($_GET['equip'])) && ($_GET['equip'] == "projectinfo"))
	{
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
					<input type="text" size="40" maxlength="40" name="marshall" value="<?php echo $marshall; ?>">
				</td>
			</tr>
			<tr>
				<td>
				</td>
			<td>
				Connection to fire Panel
			</td>
			<td>
				<input type="text" size="40" maxlength="40" name="panel" value="<?php echo $panel; ?>">
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				Fire Company
			</td>
			<td>
				<input type="text" size="40" maxlength="40" name="fire" value="<?php echo $fire; ?>">
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				Timers (Schedule):
			</td>
			<td>
				<input type="text" size="40" maxlength="40" name="timers" value="<?php echo $timers; ?>">
			</td>
		</tr>
<?php
	}
	else{
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
		<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Elevators</b></td>
	</tr>
	<tr>
		<td></td><td>Connection Company:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40" maxlength="40" name="connectiont" value="<?php echo $connection; ?>"></td>
	</tr>
<?php
}
else
{
	?>
	<input type="hidden" name="connectiont" value="none">
	<?php
}
if($row6 > 0)
	{
?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Automatic Doors</td>
	</tr>
	<tr>
		<td></td><td>Door Company:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40" maxlength="40" name="doorcompany" value="<?php echo $doorcompany; ?>"></td>
	</tr>
<?php
}
else
{
?>
<input type="hidden" name="doorcompany" value="none">
<?php
}

	if (!$row1['TotalPullCordsactivity'] == 0)
	{
		?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Other Information</u></td>
	</tr>
	<tr>
		<td></td><td>Wellness Check in Schedule:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> <input type="text" size="40" maxlength="40" name="wellness" value="<?php echo $wellness; ?>"></td>
	</tr>
<?php
	}
	else {
		?>
		<input type="hidden" name="wellness" value="none">
		<?php
	}
?>
</table>
<table align ="center">
<tr>
<td>Additional Comments:</td><td><textarea rows="12" cols="65" name="comments"><?php echo $comments; ?></textarea></td>	
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
/*
***************************************Add a customer to a Group on update***************************************
*/
if((isset($_GET['page']))&&($_GET['page']=='addtogroup'))
{
	$query10 = "SELECT FacilityName from tblfacilitygeneralinfo WHERE ID = '$f_id'";
	$result10 = mysql_query($query10) or die (mysql_error());
	$row10 = mysql_fetch_array($result10);	
	$query11 = "SELECT * FROM tblgroupquote";
	$result11 = mysql_query($query11) or die (mysql_error());
	
?>
	<table>
		<tr>
			<td>
				<?php echo $row10['FacilityName']; ?>
			</td>
		</tr>
		<tr>
			<td width="324" class="border">
				<form method="GET" name="new" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<table>
						<tr>
							<td>
								Enter Group Name:
							</td>
							<td>
								<input type="text" size="12" maxlength="12" name="newgroup">
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" value="Add" name="addnew">
							</td>
						</tr>
					</table>
<?php
					echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>					
				</form>
			</td>
			<td width="324" class="border">
				<form method="GET" name="existing" action="<?php echo $_SERVER['PHP_SELF'];?>">	
					<table>
						<tr>
							<td>
								<select name="existing">
<?php
								while($row11 = mysql_fetch_array($result11))
								{
?>
									<option value="<?php echo $row11['ID']; ?>"><?php echo $row11['GroupName']; ?></option>
<?php
								}
?>																																						
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" value="Update" name="addtoexisting">
							</td>
						</tr>							
					</table>
<?php
					echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>						
				</form>
			</td>
		</tr>					
	</table>
<?php
}
if((isset($_GET['addtoexisting']))&&($_GET['addtoexisting']=='Update'))
{
	$groupid = $_GET['existing'];
	$query12 = "UPDATE tblfacilitygeneralinfo SET GroupID = '$groupid' WHERE ID = '$f_id'";
	mysql_query($query12) or die(mysql_error());
	header("Location: Updatescope.php?equip=general&view=update&f_id=$f_id");
}
if((isset($_GET['addnew']))&&($_GET['addnew']=='Add'))
{
	$group = $_GET['newgroup'];
	$query13 = "INSERT INTO tblgroupquote (FacilityID,GroupName) VALUES ('$f_id','$group')";
	mysql_query($query13) or die(mysql_error());
	$query14 = "SELECT max(ID) FROM tblgroupquote";
	$result14 = mysql_query($query14) or die (mysql_error());
	$row14 = mysql_fetch_array($result14);
	$groupid = $row14['max(ID)'];
	$query15 = "UPDATE tblfacilitygeneralinfo SET GroupID = '$groupid' WHERE ID = '$f_id'";
	mysql_query($query15) or die(mysql_error());	
	header("Location: Updatescope.php?equip=general&view=update&f_id=$f_id");
}