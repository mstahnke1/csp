<?php
//count30 is the number of amendments that have the facilityID that is currently in use
if(isset($_GET['view']) &&($_GET['view']== 'print'))
{
	include 'printheader.php';
} 
	else
{
	include 'header.php';
}
$date = date('Y-m-d H:i:s');
include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
/*run sign off will change the Signed off Status to 1, which indicates it is signed off.  0 indicates the customer
has not signed off yet*/
if((isset($_GET['action'])) && ($_GET['action'] == 'run_sign_off'))
{
	mysql_select_db($dbname2);
	$facilityid = $_GET['current_facility_id'];
	$query19 = "UPDATE tblfacilitygeneralinfo SET Signed_Off = '1' WHERE ID = '$facilityid'";
	mysql_query($query19) or die(mysql_error()); 
	header("Location: newfinishedpage.php?f_id=$facilityid");
}
//query21 checks to make sure there is not an open amendment already currently being created / edited

//if query21 results in no open amendments it will allow the creation of a new amendment

/*query19 updates signed off status to 2 which indicates that it has been signed off but there is an amendment
for this Scope.  Being at 2 will open the links to add / edit information, but only in the amenment form.*/

/*query20 inserts a line in the tblamendmentinfo which will link the FacilityID in the tblfacilitygeneralinfo with
the ID of this table which is referenced as the amendment_id */
if((isset($_GET['action'])) && ($_GET['action'] == 'make_amendment'))
{
	mysql_select_db($dbname2);
	$facilityid = $_GET['current_facility_id'];
	$query21 = "SELECT FacilityID FROM tblamendmentinfo WHERE FacilityID='$facilityid' AND Status = 0";
	$result21 = mysql_query($query21) or die (mysql_error());
	$row21 = mysql_num_rows($result21);
	$row21 = mysql_fetch_array($result21);
	if($row21 < 1)
	{
		$query19 = "UPDATE tblfacilitygeneralinfo SET Signed_Off = '2' WHERE ID = '$facilityid'";
		mysql_query($query19) or die(mysql_error());
		$query20 = "INSERT INTO tblamendmentinfo (Date_Opened, FacilityID) VALUES ('$date','$facilityid')";
		mysql_query($query20) or die(mysql_error());
		$query2 = "SELECT max(ID) FROM tblamendmentinfo";
		$result2 = mysql_query($query2) or die (mysql_error());
		$row2 = mysql_fetch_array($result2);
		$currentid = $row2['max(ID)'];
		$query22 = "INSERT INTO tbltotalequipment (FacilityID,parent_facility_id,amendment_id) VALUES (0,'$facilityid','$currentid')";
		mysql_query($query22) or die(mysql_error());	
	}
	header("Location: newfinishedpage.php?f_id=$facilityid");
}
if((isset($_GET['action'])) && ($_GET['action'] == 'cancel_amendment'))
{
	mysql_select_db($dbname2);
	$amendment_id = $_GET['amendment_id'];
	$facilityid = $_GET['current_facility_id'];
	$query31 = "DELETE FROM tblamendmentinfo WHERE ID = '$amendment_id'";
	mysql_query($query31) or die(mysql_error());
	$query32 = "DELETE FROM tbltotalequipment WHERE amendment_id = '$amendment_id'";
	mysql_query($query32) or die(mysql_error());
	$query33 = "DELETE FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'";
	mysql_query($query33) or die(mysql_error());
	$query34 = "UPDATE tblfacilitygeneralinfo SET signed_off = 1 WHERE ID = '$facilityid'";
	mysql_query($query34) or die(mysql_error());
	header("Location: newfinishedpage.php?f_id=$facilityid");
}
if((isset($_GET['action'])) && ($_GET['action'] == 'run_sign_off_on_open_amendment'))
{
	mysql_select_db($dbname2);
	$amendment_id = $_GET['amendment_id'];
	$facilityid = $_GET['current_facility_id'];
	$query35 = "UPDATE tblfacilitygeneralinfo SET signed_off = 1 WHERE ID = '$facilityid'";
	mysql_query($query35) or die(mysql_error());
	$query36 = "UPDATE tblamendmentinfo SET Status = 1 WHERE ID = '$amendment_id'";
	mysql_query($query36) or die(mysql_error());
	header("Location: newfinishedpage.php?f_id=$facilityid");
}
/*
***************************************SELECTING ALL INFORMATION FROM TABLES***************************************
*/
if(!isset($_GET['action']))
{
	$f_id = $_GET['f_id'];
	mysql_select_db($dbname2);
	$query30 = "SELECT ID,Status FROM tblamendmentinfo WHERE FacilityID = '$f_id'";
	$result30 = mysql_query($query30) or die (mysql_error());
	$row30 = mysql_fetch_array($result30);
	$count30 = mysql_num_rows($result30);
	if($count30 > 0)
	{
		$amendment_id = $row30['ID'];	
		$amendment_status = $row30['Status'];	
	}else
	{
		$amendment_id = 0;
		$amendment_status = '-1';
	}
	mysql_select_db($dbname2);
	$query = "SELECT * From tblfacilitygeneralinfo WHERE ID='$f_id'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);	
	$expansion = $row['Expansion'];
	$sman = $row['Salesman'];
	$signed_off = $row['Signed_Off'];
	$uid = $_SESSION['uid'];
	mysql_select_db($dbname);
	$query18 = "SELECT access,dept,projmanage FROM employees WHERE id = '$uid'";
	$result18 = mysql_query($query18) or die (mysql_error());
	$row18 = mysql_fetch_array($result18);
	$dept = $row18['dept'];
	$access = $row18['access'];
	$query8 = "SELECT id, f_name, l_name FROM employees WHERE id = '$sman' ORDER BY l_name";
	$result8 = mysql_query($query8) or die (mysql_error());
	$row8 = mysql_fetch_array($result8);		
	$salesman = $row8['f_name']. ' ' . $row8['l_name'];   									 	    				
	mysql_select_db($dbname2);
	if(isset($_GET['view_amendment']))
	{
		$getequip = "SELECT * FROM tbltotalequipment WHERE amendment_id='$amendment_id'";
	}else
	{
		$getequip = "SELECT * FROM tbltotalequipment WHERE FacilityID='$f_id'";
	}
	$resgetequip = mysql_query($getequip) or die (mysql_error());
	$equip = mysql_fetch_array($resgetequip);
	$dual = $equip["TotalCallCorddual"];
	$addbaseunits = $equip['addbase'];
	$upgrade = $equip['upgrade'];
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
	$type = $equip["CorridorLights"];
	$style = $equip["CorridorLightType"];
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
	$job = $equip["joboverview"];
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
	$duration = $equip['days'];
	$endDate = date('m-d-Y', strtotime("+".$duration." days", strtotime($startdate)));
	$endDate1 = date('Y-m-d', strtotime("+".$duration." days", strtotime($startdate)));
	$endDateexp = strtotime($endDate1);
	$now = strtotime("now"); 
	
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
	$marshall = $projinfo['marshall'];
	if(($marshall == '') OR ($marshall == 'none') OR (is_null($marshall)))
	{
		$marshall = 'TBD';
	}
	$panel = $projinfo['panel'];
	if(($panel == '') OR ($panel == 'none') OR (is_null($panel)))
	{
		$panel = 'TBD';
	}
	$fire = $projinfo['fire'];
	if(($fire == '') OR ($fire == 'none') OR (is_null($fire)))
	{
		$fire = 'TBD';
	}
	$timers = $projinfo['timers'];
	$connection = $projinfo['connectiont'];
	if(($connection == '') OR ($connection == 'none') OR (is_null($connection)))
	{
		$connection = 'TBD';
	}
	$doorcompany = $projinfo['doorcompany'];
	if(($doorcompany == '') OR ($doorcompany == 'none') OR (is_null($doorcompany)))
	{
		$doorcompany = 'TBD';
	}
	$wellness = $projinfo['wellness'];
	$comments = $projinfo['comments'];
	$livedate = $projinfo['LiveDate'];
	$remote = $projinfo['Remote'];
	
	$query37 = "SELECT * FROM tblsystem_checklist WHERE FacilityID = '$f_id'";
	$result37 = mysql_query($query37) or die (mysql_error());
	$row37 = mysql_fetch_array($result37);
	$count37 = mysql_num_rows($result37);
	if($count37 > 0)
	{
		$per_plan = $row37['per_plan'];
		$bidder_design = $row37['bidder_design'];
		$meets_ada = $row37['meets_ada'];
		$permit_cost = $row37['permit_cost'];
		$additional_equipment = $row37['additional_equipment'];
		$bid_in_phases = $row37['bid_in_phases'];
		$applicable_taxes = $row37['applicable_taxes'];
		$floor_plan_provided = $row37['floor_plan_provided'];
		$submittals = $row37['submittals'];
		$operation_manuals = $row37['operation_manuals'];
		$training_manuals = $row37['training_manuals'];
		$as_built_drawings = $row37['as_built_drawings'];
		$pre_test_acceptance = $row37['pre_test_acceptance'];
		$owner_training = $row37['owner_training'];
		$internet_connection = $row37['internet_connection'];
		$LAN_base_unit = $row37['LAN_base_unit'];
		$LAN_server = $row37['LAN_server'];
		$LAN_clients = $row37['LAN_clients'];
		$static_IP_provided = $row37['static_IP_provided'];
		$static_IP_base_unit = $row37['static_IP_base_unit'];
		$FCC_license = $row37['FCC_license'];
		$phone_integration = $row37['phone_integration'];
		$back_boxes = $row37['back_boxes'];
		$wire_provided = $row37['wire_provided'];
		$labor_homefree = $row37['labor_homefree'];
		$labor_hardware = $row37['labor_hardware'];
		$labor_existing_locks = $row37['labor_existing_locks'];
		$labor_existing_hardware = $row37['labor_existing_hardware'];
		$labor_install_wire = $row37['labor_install_wire'];
		$labor_stub_ups = $row37['labor_stub_ups'];
		$labor_raceway = $row37['labor_raceway'];
		$labor_pull_wire = $row37['labor_pull_wire'];
		$labor_install_network = $row37['labor_install_network'];
		$labor_trenching = $row37['labor_trenching'];
		$ac_requirements = $row37['ac_requirements'];
		$labor_hours = $row37['labor_hours'];
		$labor_overtime = $row37['labor_overtime'];
		$checklist_not_complete = 0;
		if($per_plan == 0)
		{
			$checklist_not_complete = 1;
		}
		if($bidder_design == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($meets_ada == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($permit_cost == 0)
		{
			$checklist_not_complete = 1;
		}			
		if($additional_equipment == 0)
		{
			$checklist_not_complete = 1;
		}
		if($bid_in_phases == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($applicable_taxes == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($floor_plan_provided == 0)
		{
			$checklist_not_complete = 1;
		}		
		if($submittals == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($operation_manuals == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($training_manuals == 0)
		{
			$checklist_not_complete = 1;
		}		
		if($as_built_drawings == 0)
		{
			$checklist_not_complete = 1;
		}		
		if($pre_test_acceptance == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($owner_training == 0)
		{
			$checklist_not_complete = 1;
		}		
		if($internet_connection == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($LAN_base_unit == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($LAN_server == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($LAN_clients == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($static_IP_provided == 0)
		{
			$checklist_not_complete = 1;
		}
		if($static_IP_base_unit == 0)
		{
			$checklist_not_complete = 1;
		}			
		if($FCC_license == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($phone_integration == 0)
		{
			$checklist_not_complete = 1;
		}			
		if($back_boxes == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($wire_provided == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_homefree == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_hardware == 0)
		{
			$checklist_not_complete = 1;
		}		
		if($labor_existing_locks == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_existing_hardware == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_install_wire == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_stub_ups == 0)
		{
			$checklist_not_complete = 1;
		}
		if($labor_raceway == 0)
		{
			$checklist_not_complete = 1;
		}		
		if($labor_pull_wire == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_install_network == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_trenching == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($ac_requirements == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_hours == 0)
		{
			$checklist_not_complete = 1;
		}	
		if($labor_overtime == 0)
		{
			$checklist_not_complete = 1;
		}
	}else
	{
		$checklist_not_complete = 1;
	}
	if(isset($_GET['view_amendment']))
	{	
		$query2 =  "SELECT * From tblfacilitydoors WHERE amendment_id = '$amendment_id' Order by doornumber";
		$result2 = mysql_query($query2) or die (mysql_error());
		$row2 = mysql_fetch_array($result2);
		
		$query3 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result3 = mysql_query($query3) or die(mysql_error());
		$row3 = mysql_fetch_array($result3);
		
		$query4 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result4 = mysql_query($query4) or die(mysql_error());
		$row4 = mysql_fetch_array($result4);
		
		$query5 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result5 = mysql_query($query5) or die(mysql_error());
		$row5 = mysql_fetch_array($result5);
		
		$query6 = "SELECT SUM(outdoordoorunitCount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result6 = mysql_query($query6) or die(mysql_error());
		$row6 = mysql_fetch_array($result6);
		
		$query7 = "SELECT SUM(utcount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result7 = mysql_query($query7) or die(mysql_error());
		$row7 = mysql_fetch_array($result7);
		
		$query8 = "SELECT SUM(pircount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result8 = mysql_query($query8) or die(mysql_error());
		$row8 = mysql_fetch_array($result8);
		
		$query9 = "SELECT SUM(reedswitchcount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result9 = mysql_query($query9) or die(mysql_error());
		$row9 = mysql_fetch_array($result9);
		
		$query13 = "SELECT SUM(timercount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result13 = mysql_query($query13) or die(mysql_error());
		$equip3 = mysql_fetch_array($result13);
		
		$query14 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result14 = mysql_query($query14) or die(mysql_error());
		$equip4 = mysql_fetch_array($result14);
		
		$query15 = "SELECT SUM(racepackcount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result15 = mysql_query($query15) or die(mysql_error());
		$equip5 = mysql_fetch_array($result15);
		
		$query16 = "SELECT SUM(relaycount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result16 = mysql_query($query16) or die(mysql_error());
		$equip6 = mysql_fetch_array($result16);
		
		$query17 = "SELECT SUM(doorunitcount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result17 = mysql_query($query17) or die(mysql_error());
		$equip7 = mysql_fetch_array($result17);
		
		$query10 = "SELECT SUM(keypadcount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result10 = mysql_query($query10) or die(mysql_error());
		$equip0 = mysql_fetch_array($result10);
		
		$query11 = "SELECT SUM(pushbuttoncount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result11 = mysql_query($query11) or die(mysql_error());
		$equip1 = mysql_fetch_array($result11);
		
		$query12 = "SELECT SUM(outdoorreedcount) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result12 = mysql_query($query12) or die(mysql_error());
		$equip2 = mysql_fetch_array($result12);
		
		$query42 =  "SELECT * From tblfacilitydoors WHERE amendment_id = '$amendment_id' Order by doornumber";
		$result42 = mysql_query($query42) or die (mysql_error());
		
		$query20 = "SELECT SUM(extboard) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result20 = mysql_query($query20) or die(mysql_error());
		$row20 = mysql_fetch_array($result20);
		
		$query70 = "SELECT * From tblfacilitydoors WHERE amendment_id = '$amendment_id'";
		$result70 = mysql_query($query70) or die(mysql_error());
		$row70 = mysql_num_rows($result70);	
		
		$query82 =  "SELECT * From tblfacilitydoors WHERE amendment_id = '$amendment_id' AND doortype = 'doortype9' Order by doornumber";
		$result82 = mysql_query($query82) or die (mysql_error());
		$row82 = mysql_num_rows($result82);
		
		$query83 =  "SELECT * From tblfacilitydoors WHERE amendment_id = '$amendment_id' AND doortype = 'doortype7' Order by doornumber";
		$result83 = mysql_query($query83) or die (mysql_error());
		$row83 = mysql_num_rows($result83);			
		
		$query177 = "SELECT SUM(zbracketoutdoor) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result177 = mysql_query($query177) or die(mysql_error());
		$equip77 = mysql_fetch_array($result177);

		$query178 = "SELECT SUM(egresskit) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result178 = mysql_query($query178) or die(mysql_error());
		$equip78 = mysql_fetch_array($result178);
		
		$query202 = "SELECT SUM(buzzer) FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'"; 
		$result202 = mysql_query($query202) or die(mysql_error());
		$equip202 = mysql_fetch_array($result202);
		
		$ifdoor = "SELECT * FROM tblfacilitydoors WHERE amendment_id = '$amendment_id'";
		$resifdoor = mysql_query($ifdoor) or die(mysql_error());
		$door = mysql_num_rows($resifdoor);		
	}else
	{
		$query2 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$f_id' Order by doornumber";
		$result2 = mysql_query($query2) or die (mysql_error());
		$row2 = mysql_fetch_array($result2);
		
		$query3 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result3 = mysql_query($query3) or die(mysql_error());
		$row3 = mysql_fetch_array($result3);
		
		$query4 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result4 = mysql_query($query4) or die(mysql_error());
		$row4 = mysql_fetch_array($result4);
		
		$query5 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result5 = mysql_query($query5) or die(mysql_error());
		$row5 = mysql_fetch_array($result5);
		
		$query6 = "SELECT SUM(outdoordoorunitCount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result6 = mysql_query($query6) or die(mysql_error());
		$row6 = mysql_fetch_array($result6);
		
		$query7 = "SELECT SUM(utcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result7 = mysql_query($query7) or die(mysql_error());
		$row7 = mysql_fetch_array($result7);
		
		$query8 = "SELECT SUM(pircount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result8 = mysql_query($query8) or die(mysql_error());
		$row8 = mysql_fetch_array($result8);
		
		$query9 = "SELECT SUM(reedswitchcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result9 = mysql_query($query9) or die(mysql_error());
		$row9 = mysql_fetch_array($result9);
		
		$query13 = "SELECT SUM(timercount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result13 = mysql_query($query13) or die(mysql_error());
		$equip3 = mysql_fetch_array($result13);
		
		$query14 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result14 = mysql_query($query14) or die(mysql_error());
		$equip4 = mysql_fetch_array($result14);
		
		$query15 = "SELECT SUM(racepackcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result15 = mysql_query($query15) or die(mysql_error());
		$equip5 = mysql_fetch_array($result15);
		
		$query16 = "SELECT SUM(relaycount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result16 = mysql_query($query16) or die(mysql_error());
		$equip6 = mysql_fetch_array($result16);
		
		$query17 = "SELECT SUM(doorunitcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result17 = mysql_query($query17) or die(mysql_error());
		$equip7 = mysql_fetch_array($result17);
		
		$query10 = "SELECT SUM(keypadcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result10 = mysql_query($query10) or die(mysql_error());
		$equip0 = mysql_fetch_array($result10);
		
		$query11 = "SELECT SUM(pushbuttoncount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result11 = mysql_query($query11) or die(mysql_error());
		$equip1 = mysql_fetch_array($result11);
		
		$query12 = "SELECT SUM(outdoorreedcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result12 = mysql_query($query12) or die(mysql_error());
		$equip2 = mysql_fetch_array($result12);
		
		$query42 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$f_id' Order by doornumber";
		$result42 = mysql_query($query42) or die (mysql_error());
		
		$query20 = "SELECT SUM(extboard) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result20 = mysql_query($query20) or die(mysql_error());
		$row20 = mysql_fetch_array($result20);
		
		$query70 = "SELECT * From tblfacilitydoors WHERE FacilityID='$f_id'";
		$result70 = mysql_query($query70) or die(mysql_error());
		$row70 = mysql_num_rows($result70);	
		
		$query82 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$f_id' AND doortype = 'doortype9' Order by doornumber";
		$result82 = mysql_query($query82) or die (mysql_error());
		$row82 = mysql_num_rows($result82);
		
		$query83 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$f_id' AND doortype = 'doortype7' Order by doornumber";
		$result83 = mysql_query($query83) or die (mysql_error());
		$row83 = mysql_num_rows($result83);			
		
		$query177 = "SELECT SUM(zbracketoutdoor) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result177 = mysql_query($query177) or die(mysql_error());
		$equip77 = mysql_fetch_array($result177);

		$query178 = "SELECT SUM(egresskit) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result178 = mysql_query($query178) or die(mysql_error());
		$equip78 = mysql_fetch_array($result178);
		
		$query202 = "SELECT SUM(buzzer) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
		$result202 = mysql_query($query202) or die(mysql_error());
		$equip202 = mysql_fetch_array($result202);
		
		$ifdoor = "SELECT * FROM tblfacilitydoors WHERE FacilityID='$f_id'";
		$resifdoor = mysql_query($ifdoor) or die(mysql_error());
		$door = mysql_num_rows($resifdoor);
	}
	$fname = stripslashes($row['FacilityName']);
	if($row['QuoteName'] <> '0')
	{
		$qname = $row['QuoteName'];
	}else
	{
		$qname = '';
	}
	/*
	***************************************DISPLAY FOR CUSTOMER GENERAL INFO***************************************
	*/
	?>
	<link rel="stylesheet" type="text/css" href="sales.css" />
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<table align = "center" width = "750">
		<tr>
			<td align=center><u><font size=5<b>Scope of Work</b></u></td>
		</tr>
	</table>
<?php
	if($checklist_not_complete == 1)
	{
?>		
		<table border="5" align="center" bordercolor="red">
			<tr>
				<td><b>
					CHECKLIST NOT COMPLETE
				</b></td>
<?php
				if(!isset($_GET['view']))
				{
?>					
					<?php echo '<tr><td align="center"><a href="' . 'system_checklist.php'.'?f_id='.$f_id.'&view=checklist">'?>Complete Checklist</a></td></tr>
<?php					
				}
?>				
			</tr>
		</table>
<?php		
	}
	if((!isset($_GET['view'])) && ($signed_off == 1))
	{
?>		
		<table border="1" align="center">
			<tr>
				<td><b>
					This Scope has been signed off by the customer
				</b></td>
			</tr>
		</table>
<?php
	}elseif((!isset($_GET['view'])) && ($amendment_status == 0))
	{
?>		
		<table border="1" align="center">
			<tr>
				<td><b>
					You are making an amendment to this Scope
				</b></td>
			</tr>
		</table>
<?php
	}		
	if((isset($_GET['view'])) && (!isset($_GET['view_amendment'])) && ($amendment_status <> '-1'))
	{
?>		
		<table border="1" align="center">
			<tr>
				<td><b>
					There is an amendment for this scope of work
				</b></td>
			</tr>
		</table>
<?php		
	}
	if(!(isset($_GET['view']) &&($_GET['view']== 'print')))
	{	
?>	
		<table>			
			<tr>
				<td>
					Available options
				</td>
			</tr>
<?php			
			if(isset($_GET['view_amendment']))
			{
?>
				<tr>
					<td>
						<a href="javascript:void(0)"onclick="window.open('<?php echo $_SERVER['PHP_SELF'].'?f_id='.$row['ID'].'&view=print&view_amendment='.$amendment_id; ?>')">Print</a>
					</td>
				</tr>
<?php
			}else
			{
?>
				<tr>
					<td>
						<a href="javascript:void(0)"onclick="window.open('<?php echo $_SERVER['PHP_SELF'].'?f_id='.$row['ID'].'&view=print'; ?>')">Print</a>
					</td>
				</tr>
<?php		
			}
			if($row18['projmanage'] == 1)
			{
?>		
				<tr>
					<td>
						<?php echo '<a href="' . 'installquote.php'.'?f_id='.$f_id.'&view=getquote">'?>Install Quote</a>
					</td>
				</tr>
<?php	
			}
			if($checklist_not_complete == 0)
			{
?>		
				<tr>
					<td>
						<?php echo '<a href="' . 'system_checklist.php'.'?f_id='.$f_id.'&view=checklist">'?>View Checklist</a>
					</td>
				</tr>
<?php	
			}
			if(($access > 8 || $dept == 1) && ($signed_off == 0))
			{
?>
				<tr>
					<td>
						<?php echo '<a href="' . 'addcustomer.php'.'?current_facility_id='.$f_id.'&view=choose_who_to_copy">'?>Make a Copy</a>
					</td>
				</tr>
<?php			
			}		
			if($signed_off == 0)
			{
?>
				<tr>
					<td>
						<?php echo '<a href="' . 'newfinishedpage.php'.'?current_facility_id='.$f_id.'&action=run_sign_off">'?>Customer Signed Off</a>
					</td>
				</tr>
<?php			
			}
			if(($amendment_status <> 1) && ($signed_off == 1))
			{
?>
				<tr>
					<td>
						<?php echo '<a href="' . 'newfinishedpage.php'.'?current_facility_id='.$f_id.'&action=make_amendment">'?>Make an Amendment</a>
					</td>
				</tr>
<?php					
			}
			if($amendment_status <> '-1')
			{
?>
				<tr>
					<td>
						<?php echo '<a href="' . 'newfinishedpage.php'.'?f_id='.$f_id.'&view_amendment='.$amendment_id.'&view=print">'?>View Amendment</a>
					</td>
				</tr>
<?php					
			}
			if($amendment_status <> '-1')
			{
?>				
				<tr>
					<td>
						Amendment Options
					</td>
				</tr>
<?php
				if($amendment_status == 0)
				{
?>						
					<tr>
						<td>															
							<?php echo '<a href="' . 'newfinishedpage.php'.'?current_facility_id='.$f_id.'&amendment_id='.$amendment_id.'&action=run_sign_off_on_open_amendment">'?>Customer Signed Amendment</a>
						</td>
					</tr>
<?php
				}
?>								
				<tr>
					<td>
						<?php echo '<a href="' . 'newfinishedpage.php'.'?current_facility_id='.$f_id.'&amendment_id='.$amendment_id.'&action=cancel_amendment"onClick="return confirm(\'Are you sure you want to delete the amendment for this Scope?\')">'?>Cancel Amendment</a>
					</td>
				</tr>						
<?php
			}
?>				
		</table>
<?php
	}
?>	
	<table align="center" width="750">	
		<tr>                                                            
	    <td align="center" td colspan="4"><font size="5"><b> 
	<?php 	
			if((!isset($_GET['view'])) && ($signed_off == 0))
			{
				echo '<a href="' . 'Updatescope.php'.'?equip=general&view=update&f_id='.$f_id.'">'.$fname.' '.$qname;
			}else
			{
				echo $fname.' '.$qname;
			}
	?>			
	   	</b></td>
		</tr>
	  <tr>
	  	<td align="center" td colspan="4"><font size="3"><b>
	  		<?php echo $row['StreetAddress'].' '.$row['City'].', '.$row['StateOrProvinceCode'].' '.$row['PostalCode']; ?>
	  	</b></td>		
	  </tr>  
	</table>
	<table align="center" width="750">            	
		<tr>
			<td width = "105"><b>
				Contact:
			</b></td>
			<td>
				<?php echo $row['ContactName'] ?>
			</td>	
		</tr>
		<tr>		
			<td>
				<b>Phone Number:</b>
			</td>
			<td>
				<?php echo formatPhone($row['PhoneNumber']); ?>
			</td>			
		</tr>
		<tr>
			<td>
				<b>2nd Number:</b>
			</td>
			<td>
				<?php echo formatPhone($row['secondnumber']); ?>
			</td>		
		</tr>
	  <tr> 	
			<td>
				<b>Fax:</b>
			</td>
			<td>
				<?php echo formatPhone($row['Fax']); ?>
			</td>		
		</tr>		
		<tr>
			<td>
				<b>Title:</b>
			</td>
			<td>
				<?php echo $row['Title']; ?>
			</td>	
		</tr>
	  <tr>
	  	<td>
	  		<b>System Type:</b>
	  	</td>
	  	<td>
	  		<?php echo $row['SystemType']; ?>
	  	</td> 
	  </tr>
	  <tr>
	  	<td colspan="1">
	  		<b>Email:</b> 
	  	</td>
	  	<td colspan="3">
	  		<?php echo $row['Email']; ?>
	  	</td>  	
		</tr>	
	  <tr>
	<?php
	if(!isset($_GET['view_amendment']))
	{
		if((!isset($_GET['view'])) && ($signed_off == 0))
		{
			if($endDateexp > $now)
			{
	?>		
		    <td><b>
		    	<?php echo '<a href="' . 'Updatescope.php'.'?equip=otherinfo&view=update&f_id='.$f_id.'">'?>Quote Expires:
		    </b></a></td>
		    <td>
					<?php echo $endDate; ?>
		    </td>
	<?php
			}else
			{
	?>	
		    <td><b>
		    	<?php echo '<a href="' . 'Updatescope.php'.'?equip=otherinfo&view=update&f_id='.$f_id.'">'?>Quote Expires:
		    </b></td>
		    <td>
					<?php echo $endDate; ?>
		    </td>
	<?php
			}
		}elseif(($signed_off == 1) OR ($signed_off == 2))
		{
			echo '<td><b>Quote Expires:</b></td><td>'.' '.$endDate.'</td>'; 
		}
	}
	?>   	        
		</tr>
	</table>
	<table width ="750" align="center">
		<tr>
			<td colspan="2"><div align="center"><hr width="100%"></div></td>
		</tr>
		<tr>
		<tr>
	<?php
		if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
		{
			if(isset($_GET['view_amendment']))
			{
	?>
			<td><u>
				<b>Amendment Overview</b>
			</u></td>
	<?php	
			}else			
			{
	?>
			<td><u>
				<b>Job Overview</b>
			</u></td>
	<?php	
			}	
		}elseif($signed_off == 2)
		{
	?>
			<td><u>
				<?php echo '<a href="' . 'Updatescope.php'.'?equip=jobdescription&view=update&f_id='.$f_id.'&&type=amend">'?>Job Overview
			</u></td>
	<?php
		}else
		{
	?>
			<td><u>
				<?php echo '<a href="' . 'Updatescope.php'.'?equip=jobdescription&view=update&f_id='.$f_id.'">'?>Job Overview
			</u></td>
	<?php
		}		
	?>
		</tr>
	</table>
	<table width ="720" align="center">	
		<tr>
			<td>
				<?php echo $job; ?> 
			</td>
		</tr>
	</table>
	<table align = "center" width = "750" cellpadding=3>
		<tr>
			<td colspan="2"><div align="center"><hr width="100%"></div></td>
		</tr>
		<tr>
<?php
	if(!isset($_GET['view_amendment']))
	{
		if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off <> 0))
		{
	?>
			<td><u>
			<b>Anticipated Live Date:</b></u> <?php echo $livedate; ?></b>
			</td>
<?php
		}else
		{
	?>
			<td><u>
				<?php echo '<a href="' . 'Updatescope.php'.'?equip=otherinfo&view=update&f_id='.$f_id.'">'?>Anticipated Live Date:</a></u> <?php echo $livedate; ?>
			</td>
	<?php
		}
	?>		
		</tr>
		<tr>
	<?php
		if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off <> 0))
		{
	?>	
				<td><u>
				<b>Remote Access Type:</b></u> <?php echo $remote; ?></b>
				</td>
	<?php
		}else
		{
	?>
			<td><u>
				<?php echo '<a href="' . 'Updatescope.php'.'?equip=otherinfo&view=update&f_id='.$f_id.'">'?>Remote Access Type:</a></u> <?php echo $remote; ?>
			</td>
	<?php
		}
	?>					
		</tr>		
		<tr>
			<td colspan="6"><div align="center"><hr width="100%"></div></td>
		</tr>
	</table>
	<table width ="750" align="center">	
		<tr>
	<?php
		if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off <> 0))
		{
	?>
			<td><u>
				<b>Key Contact(s)</b>
			</u></td>
	<?php
		}else
		{
	?>		
			<td><u>
				<?php echo '<a href="' . 'Updatescope.php'.'?equip=otherinfo&view=update&f_id='.$f_id.'">'?>Key Contact(s)
			</u></td>
	<?php
		}
	?>		
		</tr>
	</table>
	<table align = "center" width = "720" cellpadding=2>
	<?php
	if(($name <> "none") && ($name <> ''))
	{
	?>
		<tr>
			<td width = "240">
				Name: <?php echo $name; ?> 
			</td>
			<td width = "240">
				Title: <?php echo $title; ?> 
			</td>
			<td> Phone: <?php echo formatPhone($phone); ?> 
			</td>
		</tr>
	<?php
	}
	if (($name1 <> "none") && ($name1 <> ''))
	{
	?>
		<tr>
			<td>
				Name: <?php echo $name1; ?> 
			</td>
			<td> Title: <?php echo $title1; ?> 
			</td>
			<td>Phone: <?php echo formatPhone($phone1); ?> 
			</td>
		</tr>
	<?php
	}
	if($name2 <> "none"  && $name2 <> '')
	{
	?>
		<tr>
			<td>
				Name: <?php echo $name2; ?> 
			</td>
			<td> 
				Title: <?php echo $title2; ?>
			</td>
			<td>
				Phone: <?php echo formatPhone($phone2); ?>
			</td>
		</tr>
	<?php
	}
	if($name3 <> "none"  && $name3 <> '')
	{
	?>
		<tr>
			<td>
				Name: <?php echo $name3; ?>
			</td>
			<td> 
				Title: <?php echo $title3; ?>
			</td>
			<td>
				Phone: <?php echo formatPhone($phone3); ?>
			</td>
		</tr>
	<?php
	}
	if($name4 <> "none"  && $name4 <> '')
	{
	?>
		<tr>
			<td>
				Name: <?php echo $name4; ?>
			</td>
			<td> 
				Title: <?php echo $title4; ?>
			</td>
			<td>
				Phone:<?php echo formatPhone($phone4); ?>
			</td>
		</tr>
	<?php
	}
	?>
	</table>
	<table align = "center" width = "750" cellpadding=2>
		<tr>
	<?php
	if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1) || ($signed_off == 2))
	{
	?>
			<td><u>
				System Champion(s)
			</u></td>
	<?php
	}else
	{
	?>
			<td><u>
				<?php echo '<a href="' . 'Updatescope.php'.'?equip=otherinfo&view=update&f_id='.$f_id.'">'?>System Champion(s)</a>
			</u></td>
	<?php
	}
	?>						
		</tr>
	</table>
	<table align = "center" width = "720" cellpadding=2>	
	<?php
	if((($champ <> "none") OR ($champ1 <> "none") OR ($champ2 <> "none")) && (($champ <> '') OR ($champ1 <> '') OR ($champ2 <> '')))
	{
		if($champ <> "none" && $champ <> '')
		{
	?>	
			<tr>
				<td width = "240">
					Name: <?php echo $champ; ?>
				</td>
				<td width = "240"> 
					Title: <?php echo $champtitle; ?> 
				</td>
				<td>
					Phone: <?php echo formatPhone($champphone); ?> 
				</td>
			</tr>
	<?php
		}
		if($champ1 <> "none" && $champ1 <> '')
		{
	?>	
			<tr>
				<td>
					Name: <?php echo $champ1; ?>
				</td>
				<td> 
					Title: <?php echo $champtitle1; ?> 
				</td>
				<td>
					Phone: <?php echo formatPhone($champphone1); ?> 
				</td>
			</tr>
	<?php
		}
		if($champ2 <> "none" && $champ2 <> '')
		{
	?>	
			<tr>
				<td>
					Name: <?php echo $champ2; ?>
				</td>
				<td>
					Title: <?php echo $champtitle2; ?> 
				</td>
				<td>
					Phone: <?php echo formatPhone($champphone2); ?> 
				</td>
			</tr>
	<?php
		}
	}else
	{
	?>
		<tr>
			<td>
				There are currently no system champions.
			</td>
		</tr>
	<?php
	}
	?>
		<tr>
			<td colspan="2"><div align="center"><hr width="100%"></div></td>
		</tr>   	
	</table>
<?php
	}
	//Variables for figuring out the number of base units
	if(($expansion <> 0) OR (isset($_GET['view_amendment'])))
	{
		$baseunitserial = 0;
		$baseunitnet = $addbaseunits;
	}else
	{
		$sum = ($wmu+ $owmu + $sowmu);
		$basesum = ($sum + $equip7['SUM(doorunitcount)']);
		//echo $basesum;
		if($equip['baseconnect']=="network")
		{
			if($basesum < 60)
			{
				$baseunitserial = 0;
				$baseunitnet = (1 + $addbaseunits);
			}
			if($basesum  >= 60)
			{
				$baseunitserial = 0;
				$baseunitx = ceil($basesum/ 60);
				$baseunitnet = ($baseunitx + $addbaseunits);
			}
		}else
		{	
			if($basesum < 59)
			{
				$baseunitserial = 1;
				$baseunitnet = (0 + $addbaseunits);
			}
			if($basesum >= 60)
			{
				$baseunitserial = 1;
				$baseunitx = ceil($basesum / 60);
				$baseunitnet = ($baseunitx - 1 + $addbaseunits);
			}
		}
	}	
	$total_network_units = $baseunitnet + $baseunitserial + $wmu + $owmu + $sowmu;
	if($total_network_units > 0)
	{		
?>		
		<table align ="center" width = "750" cellpadding="2">                 	
			<tr>
<?php				
			if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
			{
	?>		
				<td colspan="2">
					<b><u>Network / Infastructure</b></u>
				</td>
	<?php
			}elseif($signed_off == 0)
			{
	?>
				<td colspan="2">
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=network&view=update&f_id='.$f_id.'">'?>  Network / Infastructure
				</td>
	<?php
			}elseif($signed_off == 2)
			{
	?>
				<td colspan="2">
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=network&view=update&f_id='.$f_id.'&type=amend">'?>  Network / Infastructure
				</td>
	<?php
			}	
	?>			
			</tr>
		</table>
		<table align ="center" width = "720" cellpadding="2"> 	
	<?php	
		if(!$baseunitserial==0)
		{			
	?>
			<tr>
				<td> 
					Base Units via Serial Port: <?php echo $baseunitserial; ?>  
				</td>		
			</tr>
	<?php
		}
		if(!$baseunitnet==0)
		{
	?>
			<tr>
				<td>
					Base Units via Network: <?php echo $baseunitnet; ?> 
				</td>
			</tr>
	<?php
		}
		if ($wmu <> 0)
		{	
	?>
			<tr>
				<td>
					Area Units: <?php echo $wmu; ?>
				</td>
			</tr>
	<?php
		}
		if($owmu <> 0)
		{	
	?>	
			<tr>
				<td>
					Outdoor Area Units: <?php echo $owmu; ?>
				</td>
			</tr>
	<?php	
		}
		if($sowmu <> 0)
		{
	?>	
			<tr>
				<td>
					Solar Area Units: <?php echo $sowmu; ?>
				</td>
			</tr>
	<?php
		}
		if($baseunitnet > 0)
		{
	?>
			<tr>
				<td>
					**  Base Units connected via a network  require a connection to the Local Area Connection that is on the same Local Subnet as the HomeFree Server.  Please contact the HomeFree Technical Department for any further questions.
				</td>
			</tr>
	<?php
		}
	?>   
		</table>
	<?php
	}
	$twatch = ($watch + $fwatch + $swatch);
	//if(($twatch < 1) && ($door < 1)
	if(!isset($_GET['view_amendment']))
	{
?>	
		<table align ="center" width = "750" cellpadding="2">
			<tr>
				<td colspan="6"><div align="center"><hr width="100%"></div></td>
			</tr>
			<tr>
				<td><b><font size=5 ><font size="5"><strong>
					Systems
				</strong></b></td>
			</tr>
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>	
<?php
	}
	if($row['SystemType'] <> "On-Call")
	{
		if(($twatch == 0) && (!isset($_GET['view'])) && ($signed_off == 0))
		{
	?>
			<tr>	
				<td colspan="2">
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'">'?>  Add Watches</a> 
				</td>
			</tr>
	<?php
		}elseif(($twatch == 0) && (!isset($_GET['view'])) && ($signed_off == 2))
		{
	?>
			<tr>	
				<td colspan="2">
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'&type=amend">'?>  Add Watches</a> 
				</td>
			</tr>
	<?php
		}		
	}
			if(($door < 1) && (!isset($_GET['view'])) && ($signed_off == 0))
			{
	?>
			<tr>                                                            
	  		<td colspan="2">
	  			
	  			<?php echo '<a href="' . 'doorunit.php'.'?action=UPDATE&f_id='.$f_id.'">'?> Add Door Configurations</a>
	  		</td>
	  	</tr>
	  </table>
	<?php
		}elseif(($door < 1) && (!isset($_GET['view'])) && ($signed_off == 2))		
		{
	?>
			<tr>                                                            
	  		<td colspan="2">
	  			
	  			<?php echo '<a href="' . 'doorunit.php'.'?action=UPDATE&f_id='.$f_id.'&type=amend">'?> Add Door Configurations</a>
	  		</td>
	  	</tr>
	  </table>
	<?php
		}		
	//if(!((($row9['SUM(reedswitchcount)'] == 0) && ($row8['SUM(pircount)'] == 0)) && ($twatch == 0)) && ($row8['SUM(keypadcount)'] == 0))
	if($door > 0) 
	{
	?>
		<table align ="center" width = "750" cellpadding="2">
			<tr>
				<td><strong><u>
					Wandering and/or Door Control System
				</strong></u></td>
			</tr>
		</table>
	<?php
	}
	?>
	<?php
	if($row['SystemType'] <> "On-Call")
	{
		if(!$twatch == 0)
		{
	?>		
		<table align = "center" width = "720" cellpadding=2>			
			<tr>
	<?php
			if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
			{
	?>
				<td colspan="2">
					Watches: <?php echo $twatch; ?>
				</td>
	<?php
			}elseif($signed_off == 0)
			{
	?>			
				<td colspan="2">
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'">'?>  Watches:</a>  <?php echo $twatch; ?>
				</td>
	<?php
			}elseif($signed_off == 2)
			{
	?>			
				<td colspan="2">
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'&type=amend">'?>  Watches:</a>  <?php echo $twatch; ?>
				</td>
	<?php
			}			
	?>								
			</tr>
		</table>
	<?php
		}	
	}
	if($door > 0) 
	{
	?>
	
	<table align="center" width="750">
	<?php
		if(!(($row9['SUM(reedswitchcount)'] == 0) && ($row8['SUM(pircount)'] == 0)))
		{
	?>
			<tr>
				<td colspan="2">
					<u>
					Door Equipment Summary:
				</u></td>
	  	</tr>
	<?php  
		}
	?>
	</table>
	<table align="center" width="720">
	<?php
		if($equip7['SUM(doorunitcount)']<>0)
		{
	?>
			<tr>                                                            
	  		<td colspan="2">
	  			
	  			Door Units: 
	  			<?php echo $equip7['SUM(doorunitcount)']; ?>
	  		</td>
	  	</tr>
	<?php
		}		
		if(!$row6['SUM(outdoordoorunitCount)']==0)
		{
	?>
			<tr>
	   	 	<td colspan="2">
	   	 		Outdoor Units:<?php echo $row6['SUM(outdoordoorunitCount)']; ?>
	   		</td>
			</tr>
	<?php
		}			
		if(!$row7['SUM(utcount)']==0)
		{
	?>
			<tr>                                                            
	    	<td colspan="2">
	    		Universal Transmitters: <?php echo $row7['SUM(utcount)'] ?>
	   		</td>
			</tr>
	<?php
		}
		if(!$row9['SUM(reedswitchcount)']==0)
		{
	?>
			<tr>
				<td colspan="2">
					Reed Switches: <?php echo $row9['SUM(reedswitchcount)']; ?>
				</td>
	  	</tr>
	<?php  	
		}		
		if(!$equip2['SUM(outdoorreedcount)']==0)
		{
	?>
			<tr>                                                            
	  		<td colspan="2">
	  			Outdoor Reed Switches: <?php echo $equip2['SUM(outdoorreedcount)']; ?>
	  		</td>
			</tr>
	<?php
		}  	
		if(!$row8['SUM(pircount)']==0)
		{
	?>
			<tr>
				<td colspan="2">
					Passive Infared Detectors: <?php echo $row8['SUM(pircount)']; ?>
				</td>
			</tr>
	<?php	
		}	
		if(!$equip0['SUM(keypadcount)']==0)
		{
	?>
			<tr>                                                            
	    	<td colspan="2">
	    		Keypads: <?php echo $equip0['SUM(keypadcount)']; ?>
	    	</td>
	  	</tr>
	<?php
		}
		if(!$row20['SUM(extboard)']==0)
		{
	?>
			<tr>                                                            
	    	<td colspan="2">
	    		Extended Relays: <?php echo $row20['SUM(extboard)']; ?>
	    	</td>
	  	</tr>
	<?php
		}			
		if(!$equip1['SUM(pushbuttoncount)']==0)
		{
	?>
			<tr>                                                            
	  		<td colspan="2">
	  			Pushbuttons: <?php echo $equip1['SUM(pushbuttoncount)']; ?>
	  		</td>
	  	</tr>
	<?php
		}			
		if(!$equip3['SUM(timercount)']==0)
		{
	?>
			<tr>
	  		<td colspan="2">
	  			Timers: <?php echo $equip3['SUM(timercount)']; ?>
	  		</td>
	  	</tr>
	<?php
		}	
		if(!$equip202['SUM(buzzer)']==0)
		{
	?>
			<tr>
	    	<td colspan="2">
	    		Buzzers: <?php echo $equip202['SUM(buzzer)'] ?> 
	    	</td>
	  	</tr>
	<?php  
		}					
		if(!$equip4['SUM(minilockcount)']==0)
		{
	?>
			<tr>
	    	<td colspan="2">
	    		Mini Locks: <?php echo $equip4['SUM(minilockcount)'] ?> 
	    	</td>
	  	</tr>
	<?php  
		}	
		if(!$row5['SUM(zbracket)']==0)
		{
	?>
			<tr>
				<td colspan="2">
					Z Bracket Locks: <?php echo $row5['SUM(zbracket)'] ?>
				</td>
	 	 </tr>
	<?php
		}	
		if(!$equip77['SUM(zbracketoutdoor)']==0)
		{
	?>
			<tr>
				<td colspan="2">
					Outdoor Z Bracket Locks: <?php echo $equip77['SUM(zbracketoutdoor)'] ?>
				</td>
	 	 </tr>
	<?php
		}
		if(!$equip78['SUM(egresskit)']==0)
		{
	?>
			<tr>
	  		<td colspan="2">
	  			Egress Kits: <?php echo $equip78['SUM(egresskit)']; ?>
	  		</td>
	  	</tr>
	<?php
		}
		if(!$equip6['SUM(relaycount)']==0)
		{
	?>
			<tr>
	  		<td colspan="2">
	  			Deactivation Relays: <?php echo $equip6['SUM(relaycount)'] ?>
	  		</td>
	  	</tr>
	<?php
		}
		if(!$equip5['SUM(racepackcount)']==0)
		{
	?>
			<tr>                                                            
	  		<td colspan="2">
	  			Raceway Packs: <?php echo $equip5['SUM(racepackcount)'] ?>
	  		</td>
	  	</tr>
		</table>
	 
	<?php
		} 	
		if(($equip4['SUM(minilockcount)'] > 0) OR ($row5['SUM(zbracket)'] > 0) OR ($equip77['SUM(zbracketoutdoor)']> 0) OR ($row82 > 0) OR ($row83 > 0))
		{	
	?>		
			<table align ="center" width = "750" cellpadding="2"> 
				<tr>
					<td>
	<?php 
						if((!isset($_GET['view'])) && ($signed_off == 0))
						{
							echo '<a href="' . 'Updatescope.php'.'?equip=projectinfo&view=update&f_id='.$f_id.'">'.'Additional Door Information:</a>';
						}else
						{
							echo 'Additional Door Information:';
						}
	?>					
					</td>
				</tr>  	
	<?php				
			if(!(($equip4['SUM(minilockcount)']==0) && ($row5['SUM(zbracket)']==0) && ($equip77['SUM(zbracketoutdoor)']==0)))
			{
	?>	
				<tr>
					<td>
						Magnetic Lock Information:
					</td>
				</tr>
				<tr>
					<td>
						Fire Marshall Approval: <?php echo $marshall; ?> 
					</td>
				</tr>
				<tr>
					<td>
						Connection to fire Panel: <?php echo $panel; ?>
					</td>
				</tr>
				<tr>
					<td>
						Fire Company: <?php echo $fire; ?>
					</td>
				</tr>
	<?php
			}
			if($row82 > 0)
			{
	?>
				<tr>
					<td>
						Elevators:
					</td>
				</tr>
				<tr>
					<td>
						Connection Company: <?php echo $connection; ?>
					</td>
				</tr>
	<?php
			}	
			if($row83 > 0)
			{
	?>
				<tr>
					<td>
						Automatic Doors
					</td>
				</tr>
				<tr>
					<td>
						Door Company: <?php echo $doorcompany; ?> 
					</td>
				</tr>
	<?php
			}
	?>		
		</table>
		<table align ="center" border = 0 width = "750" cellpadding="2">
		<tr>
			<td><div align="center"><hr width="100%"></div></td>
		</tr>
	</table>
	<?php
		}
	}
	if($row['SystemType'] <> "On-Site")
	{
		if(($equip['TotalPanicButtons'] == 0) && (!isset($_GET['view'])) && ($signed_off == 0))
		{	
	?>
			<table align ="center" border = 0 width = "750" cellpadding="2">
				<tr>									
					<td>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'">'?>Add Call Buttons
					</a></u></td>
				</tr>
			</table>
	<?php
		}elseif(($equip['TotalPanicButtons'] == 0) && (!isset($_GET['view'])) && ($signed_off == 2))
		{	
	?>
			<table align ="center" border = 0 width = "750" cellpadding="2">
				<tr>									
					<td>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'&type=amend">'?>Add Call Buttons
					</a></u></td>
				</tr>
			</table>
	<?php
		}		
		if(($equip['TotalPullCords'] == 0) && (!isset($_GET['view'])) && ($signed_off == 0))
		{
	?>	
				<table align ="center" border = 0 width = "750" cellpadding="2">
					<tr>
						<td>
							<?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'">'?>Add Pull Cords
						</a></u></td>
					</tr>	
				</table>
	<?php
			}elseif(($equip['TotalPullCords'] == 0) && (!isset($_GET['view'])) && ($signed_off == 2))
			{
	?>	
				<table align ="center" border = 0 width = "750" cellpadding="2">
					<tr>
						<td>
							<?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'&type=amend">'?>Add Pull Cords
						</a></u></td>
					</tr>	
				</table>
	<?php
			}			
	
		if(!($equip['TotalPanicButtons'] == 0 && ($equip['TotalPullCords'] == 0 && ($equip['TotalPullCordsactivity']==0))))
		{
	?>
		<table align ="center" width = "750" cellpadding="2">
			<tr>
				<td><strong><u>
					Call System
				</strong></u></td>
			</tr>
		</table>
		<table align ="center" width = "720" cellpadding="2">
	<?php
			if(!$equip['TotalPanicButtons'] == 0)
			{
	?>
				<tr>
	<?php
				if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
				{
	?>				
					<td>
						Call Buttons: (Total Ordered= <?php echo $equip['TotalPanicButtons']; ?>)
					</td>
	<?php
				}elseif($signed_off == 0)
				{
	?>
					<td><u>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'">'?>Call Buttons:</a></u> (Total Ordered= <?php echo $equip['TotalPanicButtons']; ?>)
					</u></td>
	<?php
				}elseif($signed_off == 2)
				{
	?>
					<td><u>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'&type=amend">'?>Call Buttons:</a></u> (Total Ordered= <?php echo $equip['TotalPanicButtons']; ?>)
					</u></td>
	<?php					
				}
	?>							
				</tr>
			</table>
			<table align ="center" width = "690" cellpadding="2">
	<?php
				if($equip['pendant'] > 0)
				{
	?>	
					<tr>
						<td>
							Pendant Style: <?php echo $equip['pendant']; ?> 
						</td>
					</tr>
	<?php
				}
				if($equip['watchstyle'] > 0)		
				{
	?>			
					<tr>
						<td>
							Watch style: <?php echo $equip['watchstyle']; ?>
						</td>
					</tr>
	<?php
				}
			}
	?>
			</table>
			<table align ="center" width = "720" cellpadding="2">
	<?php		
			if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
			{	
				if($equip['TotalPullTags'] > 0)
				{		
	?>
					<tr>
						<td>
							Pull Tags: (Total Ordered= <?php echo $equip['TotalPullTags']; ?>)
						</td>
					</tr>	
	<?php
				}
			}elseif($signed_off == 0)
			{
	?>
				<tr>
					<td><u>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'">'?>Pull Tags</u></a> (Total Ordered= <?php echo $equip['TotalPullTags']; ?>)
					</td>
				</tr>	
	<?php
			}elseif($signed_off == 2)
			{
	?>
				<tr>
					<td><u>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$f_id.'&type=amend">'?>Pull Tags</u></a> (Total Ordered= <?php echo $equip['TotalPullTags']; ?>)
					</td>
				</tr>	
	<?php
			}				
			if (!(($equip['TotalPullCords'] == 0) &&  ($equip['TotalPullCordsactivity'] == 0)))
			{
				if (!$equip['TotalPullCords']==0)
				{	
	?>
					<tr>
	<?php
					if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
					{
	?>
						<td>
							Pull Cords: (Total Ordered= <?php echo $equip['TotalPullCords']; ?>) 
						</td>
	<?php
					}elseif($signed_off == 0)
					{
	?>
						<td>
							<u><?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'">'?>  Pull Cords:</a></u>(Total Ordered= <?php echo $equip['TotalPullCords']; ?>) 
						</td>
	<?php
					}elseif($signed_off == 2)
					{
	?>
						<td>
							<u><?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'&type=amend">'?>  Pull Cords:</a></u>(Total Ordered= <?php echo $equip['TotalPullCords']; ?>) 
						</td>
	<?php
					}					
	?>			
					</tr>
				</table>
				<table align ="center" width = "690" cellpadding="2">
	<?php
					if($equip['bedpullcords'] > 0)
					{
	?>					
						<tr>
							<td>
								Bedroom: <?php echo $equip['bedpullcords']; ?>
							</td>
						</tr>
	<?php
					}		
					if($equip['bathpullcords'] > 0)
					{
	?>											
						<tr>
							<td>
								Bathroom: <?php echo $equip['bathpullcords']; ?>
							</td>
						</tr>
	<?php
					}		
					if($equip['commonpullcords'] > 0)
					{		
	?>										
						<tr>
							<td>
								Common Areas: <?php echo $equip['commonpullcords']; ?>
							</td>
						</tr>
	<?php
					}
				}
	?>
				</table>
				<table align ="center" width = "720" cellpadding="2">
	<?php			
				if (!$equip['TotalPullCordsactivity']==0)
				{	
					if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
					{
	?>
						<tr>
							<td>
								Pull Cords with Wellness Check-in:</a>(Total Ordered= <?php echo $equip['TotalPullCordsactivity']; ?>)
								Schedule: <?php echo $wellness; ?>
							</td>
						</tr>
	<?php
					}elseif($signed_off == 0)
					{
	?>
						<tr>
							<td><u>
								<?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'">'?>
								Pull Cords with Wellness Check-in:</a>(Total Ordered= <?php echo $equip['TotalPullCordsactivity']; ?>)</u>
								<?php echo '<a href="' . 'Updatescope.php'.'?equip=projectinfo&view=update&f_id='.$f_id.'">'?>  Schedule: <?php echo $wellness; ?></a>														
							</td>
						</tr>
	<?php
					}elseif($signed_off == 2)
					{
	?>
						<tr>
							<td><u>
								<?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'&type=amend">'?>
								Pull Cords with Wellness Check-in:</a>(Total Ordered= <?php echo $equip['TotalPullCordsactivity']; ?>)</u>
								Schedule: <?php echo $wellness; ?>																
							</td>
						</tr>
	<?php
					}					
	?>
					</table>
					<table align ="center" width = "690" cellpadding="2">
	<?php				
					if($equip['bedpullcordsact'] > 0)
					{
	?>																					
						<tr>
							<td>
								Bedroom: <?php echo $equip['bedpullcordsact']; ?>
							</td>
						</tr>
	<?php
					}
					if($equip['bathpullcordsact'] > 0)
					{				
	?>									
						<tr>
							<td>
								Bathroom: <?php echo $equip['bathpullcordsact']; ?>
							</td>
						</tr>
	<?php
					}
					if($equip['commonpullcordsact'] > 0)
					{				
	?>					
						<tr>
							<td>
								Common Areas: <?php echo $equip['commonpullcordsact']; ?>
							</td>
						</tr>	
	<?php
					}
				}
				if(!(($equip['TotalCallCords']==0) && ($equip['TotalCallCordssingle15'] == 0) && ($equip['TotalCallCorddual'] == 0) && ($equip['Squeezeball']==0) && ($equip['breathcall'] == 0)))
				{	
	?>
				</table>
				<table align ="center" width = "720" cellpadding="2">
					<tr>
	<?php
					if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
					{
?>										
						<td>
							Call Cords:
						</td>
<?php
					}elseif($signed_off == 0)
					{
?>					
						<td><u>
							<?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'">'?>Call Cords:
						</a></u></td>	
<?php
					}elseif($signed_off == 2)
					{
?>					
						<td><u>
							<?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'&type=amend">'?>Call Cords:
						</a></u></td>	
<?php
					}					
?>
															
				</tr>
<?php
				}
?>					
				</table>			
				<table align ="center" width = "690" cellpadding="2">
<?php			
				if(!($equip['TotalCallCords']==0))
				{
?>
				<tr>
					<td>
						10ft. Call Cords: <?php echo $equip['TotalCallCords']; ?>
					</td>
				</tr>
<?php			
				}
				if(!$equip['TotalCallCordssingle15']==0)
				{
?>	
					<tr>
						<td>
							15ft. Call Cords: <?php echo $equip['TotalCallCordssingle15']; ?>
						</td>
					</tr>
<?php			
				}
				if (!$equip['TotalCallCorddual']==0)
				{	
?>			
					<tr>
						<td>
							Dual Call Cords: <?php echo $equip['TotalCallCorddual']; ?>
						</td>
					</tr>
<?php			
				}
				if (!$equip['Squeezeball']==0)
				{
?>	
					<tr>
						<td>
							Squeeze Balls: <?php echo $equip['Squeezeball']; ?>
						</td>
					</tr>
<?php
				}
				if(!$equip['breathcall']==0)
				{
?>	
					<tr>
						<td>
							Breath Calls: <?php echo $equip['breathcall']; ?>
						</td>
					</tr>
<?php
				}
?>
			</table>
			<table align ="center" width = "720" cellpadding="2">		
<?php			
				if($equip['CorridorLightType']<>"NONE")
				{		
					if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
					{	
?>
						<tr>
							<td>
								Corridor Lights:
							</td>
						</tr>
<?php
					}elseif($signed_off == 0)
					{
?>
						<tr>
							<td><u>
								<?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'">'?>Corridor Lights:
							</a></u></td>
						</tr>
<?php
					}elseif($signed_off == 2)
					{
?>
						<tr>
							<td><u>
								<?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$f_id.'&type=amend">'?>Corridor Lights:
							</a></u></td>
						</tr>
<?php
					}					
?>					
				</table>
				<table align ="center" width = "690" cellpadding="2">																		
					<tr>
						<td>
							Corridor Light Type: <?php echo $equip['CorridorLightType'] ?>
						</td>
					</tr>
<?php
					if($equip['CorridorLights']<>"NONE")
					{
?>	
						<tr>
							<td>
								Corridor Light Style: <?php echo $equip['CorridorLights'] ?>
							</td>
						</tr>
<?php
					}
					if(!$equip['TotalExistingCorrdiorLights']==0)
					{
?>	
						<tr>
							<td>
								Number of Existing Lights: <?php echo $equip['TotalExistingCorrdiorLights']; ?>
							</td>
						</tr>
<?php			
					}
					if(!$equip['TotalHomeFreeCorrdiorLights']==0)
					{
?>	
						<tr>
							<td>
								Number of HomeFree Lights: <?php echo $equip['TotalHomeFreeCorrdiorLights'] ?>
							</td>
						</tr>
<?php
					}
				}
			}
?>	
		</table>
		<table align ="center" border = 0 width = "750" cellpadding="2">
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>
<?php
		}
		if(!$equip['TotalFallUnits']==0)
		{
?>
			<table align ="center" border = 0 width = "750" cellpadding="2">
				<tr>
<?php
				if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
				{
?>
					<td><u><b>
						Fall Alert System:
					</b></td>
<?php
				}elseif($signed_off == 0)
				{
?>
					<td><u>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=awareunits&view=update&f_id='.$f_id.'">'?> Fall Alert System:
					</a></u></td>
<?php
				}elseif($signed_off == 2)
				{
?>
					<td><u>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=awareunits&view=update&f_id='.$f_id.'&type=amend">'?> Fall Alert System:
					</a></u></td>
<?php
				}				
?>																				
				</tr>
			</table>	
			<table align ="center" border = 0 width = "720" cellpadding="2">
<?php
			if (!$equip['TotalFallUnits']==0)
			{	
?>		
				<tr>
					<td>
						Fall Units: <?php echo $equip['TotalFallUnits']; ?>
					</td>
				</tr>
<?php
			}
?>
			</table>
			<table align ="center" border = 0 width = "690" cellpadding="2">
<?php		
			if(!$equip['chair90day']==0)
			{	
?>
				<tr>
					<td>
						90 Day Chair Pads: <?php echo $equip['chair90day']; ?>
					</td>
				</tr>
<?php
			}
			if(!$equip['chair180day']==0)
			{	
?>
				<tr>
					<td>
						180 Day Chair Pads: <?php echo $equip['chair180day']; ?>
					</td>
				</tr>
<?php
			}
			if(!$equip['bed90day']==0)
			{
?>	
				<tr>
					<td>
						90 Day Bed Pads: <?php echo $equip['bed90day']; ?>
					</td>
				</tr>
<?php
			}
			if(!$equip['bed180day']==0)
			{	
?>
				<tr>
					<td>
						180 Day Bed Pads: <?php echo $equip['bed180day']; ?>
					</td>
				</tr>
<?php
			}
?>
		</table>
		<table align ="center" border = 0 width = "750" cellpadding="2">
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>
<?php
		}else
		{
			if(($row['SystemType'] == "Elite") && (!isset($_GET['view'])) && ($signed_off == 0))
			{
?>		
				<table align ="center" border = 0 width = "750" cellpadding="2">	
						<tr>
							<td>
								<?php echo '<a href="' . 'Updatescope.php'.'?equip=awareunits&view=update&f_id='.$f_id.'">'?> Add Fall Management
							</td>
						</tr>	
					</table>
<?php	
			}elseif(($row['SystemType'] == "Elite") && (!isset($_GET['view'])) && ($signed_off == 2))
			{
?>		
				<table align ="center" border = 0 width = "750" cellpadding="2">	
						<tr>
							<td>
								<?php echo '<a href="' . 'Updatescope.php'.'?equip=awareunits&view=update&f_id='.$f_id.'&type=amend">'?> Add Fall Management
							</td>
						</tr>	
					</table>
<?php	
			}			
		}
	}
	/*
	*************************************************PAGING EQUIPMENT*********************************************
	*/
	if(isset($_GET['view_amendment']))
	{
		if((!IS_NULL($equip['PagingBaseType'])) && ($equip['PagerQuantity']<>0) && ($equip['PagingBaseType'])<>0)
		{
?>
			<table align ="center" width = "750" cellpadding="2">
				<tr>
<?php
				if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
				{
?>					
					<td><b><font size=5 ><strong>
						Paging Equipment:
					</a></strong></b></td>
<?php			
				}elseif($signed_off == 0)
				{
?>
					<td><b><font size=5 ><strong>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=paging&view=update&f_id='.$f_id.'">'?>Paging Equipment:
					</a></strong></b></td>
<?php
				}elseif($signed_off == 2)
				{
?>
					<td><b><font size=5 ><strong>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=paging&view=update&f_id='.$f_id.'&type=amend">'?>Paging Equipment:
					</a></strong></b></td>
<?php
				}			
?>						
				</tr>
				<tr>
					<td><div align="center"><hr width="100%"></div></td>
				</tr>
			</table>
			<table align ="center" border = 0 width = "720" cellpadding="2">	
<?php
			if ($equip['PagingBaseType']<>"NONE")
			{
?>	
				<tr>
					<td>
						Paging Base Type: <?php echo $equip['PagingBaseType']; ?>
					</td>
				</tr>
<?php
			}
			if($equip['PagerType']<>"NONE")
			{	
?>
				<tr>
					<td>
						Pager Type: <?php echo $equip['PagerType']; ?>
					</td>
				</tr>
<?php
			}
			if(!$equip['PagerQuantity']==0)
			{
?>	
				<tr>
					<td>
						Number of <?php echo $equip['PagerType']. ' Pagers:    ' . $equip['PagerQuantity']; ?>
					</td>
				</tr>
<?php
			}
			if(!$equip['HomeFreePager']==0)
			{	
?>
				<tr>
					<td>
						Number of HomeFree Pagers: <?php echo $equip['HomeFreePager']; ?>
					</td>
				</tr>
<?php
			}
?>
			</table>
			<table align ="center" border = 0 width = "750" cellpadding="2">
				<tr>
					<td><div align="center"><hr width="100%"></div></td>
				</tr>
			</table>
<?php	
		}		
	}else
	{
?>
		<table align ="center" width = "750" cellpadding="2">
			<tr>
<?php
			if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
			{
?>					
				<td><b><font size=5 ><strong>
					Paging Equipment:
				</a></strong></b></td>
<?php			
			}elseif($signed_off == 0)
			{
?>
				<td><b><font size=5 ><strong>
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=paging&view=update&f_id='.$f_id.'">'?>Paging Equipment:
				</a></strong></b></td>
<?php
			}elseif($signed_off == 2)
			{
?>
				<td><b><font size=5 ><strong>
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=paging&view=update&f_id='.$f_id.'&type=amend">'?>Paging Equipment:
				</a></strong></b></td>
<?php
			}			
?>						
			</tr>
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>
		<table align ="center" border = 0 width = "720" cellpadding="2">	
<?php
		if ($equip['PagingBaseType']<>"NONE")
		{
?>	
			<tr>
				<td>
					Paging Base Type: <?php echo $equip['PagingBaseType']; ?>
				</td>
			</tr>
<?php
		}
		if($equip['PagerType']<>"NONE")
		{	
?>
			<tr>
				<td>
					Pager Type: <?php echo $equip['PagerType']; ?>
				</td>
			</tr>
<?php
		}
		if(!$equip['PagerQuantity']==0)
		{
?>	
			<tr>
				<td>
					Number of <?php echo $equip['PagerType']. ' Pagers:    ' . $equip['PagerQuantity']; ?>
				</td>
			</tr>
<?php
		}
		if(!$equip['HomeFreePager']==0)
		{	
?>
			<tr>
				<td>
					Number of HomeFree Pagers: <?php echo $equip['HomeFreePager']; ?>
				</td>
			</tr>
<?php
		}
?>
		</table>
		<table align ="center" border = 0 width = "750" cellpadding="2">
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>
<?php
	}
	/*
	*************************************************OTHER EQUIPMENT*********************************************
	*/
	if(!isset($_GET['view_amendment']))
	{
?>
		<table align ="center" border = 0 width = "750" cellpadding="2">
			<tr>
				<td><b><font size=5>
					Other Equipment
				</b></td>
			</tr>
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>	
		</table>
<?php
	}
	/*
	*************************************************UNIVERSAL TRANSMITTERS*********************************************
	*/
		if(($equip['UTs']==0) && (!isset($_GET['view'])) && ($signed_off == 0))
		{
?>
			<table align ="center" width = "750" cellpadding="2">	
				<tr>
					<td>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=uts&view=update&f_id='.$f_id.'">'?> Add UT's (other than on doors)
					</td>
				</tr>
			</table>
<?php
		}elseif(($equip['UTs']==0) && (!isset($_GET['view'])) && ($signed_off == 2))
		{
?>
			<table align ="center" width = "750" cellpadding="2">	
				<tr>
					<td>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=uts&view=update&f_id='.$f_id.'&type=amend">'?> Add UT's (other than on doors)
					</td>
				</tr>
			</table>
<?php			
		}
		if (($equip['TotalClientStations']==0) && ($equip['lic']==0) && (!isset($_GET['view'])) && ($signed_off == 0))
		{	
?>		
			<table align ="center" width = "750" cellpadding="2">	
				<tr>
					<td>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=clients&view=update&f_id='.$f_id.'">'?> Add Client Stations
					</td>
				</tr>	
			</table>
<?php
		}elseif(($equip['TotalClientStations']==0) && ($equip['lic']==0) && (!isset($_GET['view'])) && ($signed_off == 2))
		{
?>		
			<table align ="center" width = "750" cellpadding="2">	
				<tr>
					<td>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=clients&view=update&f_id='.$f_id.'&&type=amend">'?> Add Client Stations
					</td>
				</tr>	
			</table>
<?php			
		}
	if(($equip['UTs']==0) || (($equip['TotalClientStations']==0) && ($equip['lic']==0)))
	{	
		if((!isset($_GET['view'])) && ($signed_off == 1))
		{
?>				
			<table align ="center" width = "750" cellpadding="2">		
				<tr>
					<td><div align="center"><hr width="100%"></div></td>
				</tr>
			</table>
<?php
		}
	}
		if (!$equip['UTs']==0)
		{
?>
		<table align ="center" border = 0 width = "750" cellpadding="2">
			<tr>
<?php
			if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
			{
?>							
				<td><u>
					<b>Universal Transmitters:</b>
				</a></u></td>
<?php
			}elseif($signed_off == 0)
			{
?>			
				<td><u>
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=uts&view=update&f_id='.$f_id.'">'?>Universal Transmitters:
				</a></u></td>			
<?php
			}elseif($signed_off == 2)
			{
?>			
				<td><u>
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=uts&view=update&f_id='.$f_id.'&&type=amend">'?>Universal Transmitters:
				</a></u></td>			
<?php				
			}
?>								
			</tr>
		</table>
		<table align ="center" border = 0 width = "720" cellpadding="2">		
<?php
			if($equip['utpower']=="yes")
			{
?>
				<tr>
					<td>
						Universal Transmitters are to be connected to the correct power source.
					</td>
				</tr>
<?php
			}
			if($equip['utpower']=="no")
			{
?>
				<tr>
					<td><b>
						Universal Transmitters will be powered by battery.
					</b></td>
				</tr>
<?php
			}
?>
			<tr>
				<td>
					Universal Transmitters: <?php echo $equip['UTs']; ?>
				</td>
			</tr>
	
			<tr>
			<td>
				Universal Transmitter Function:
			</td>
		</tr>
		</table>
		<table align ="center" width = "690">
		<tr>
			<td> 
				<?php  echo $equip['UTFunction'] ;?> 
			</td>
		</tr>
		</table>
		<table align ="center" border = 0 width = "750" cellpadding="2">
		<tr>
			<td><div align="center"><hr width="100%"></div></td>
		</tr>	
		</table>	
<?php
		}
		
	/*
	*************************************************CLIENT STATIONS*********************************************
	*/
	if ((!($equip['TotalClientStations']==0 & ($equip['lic']==0))) OR ($upgrade == 1))
	{	
?>
		<table align ="center" width = "750" cellpadding="2">
			<tr>
<?php			
			if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
			{
?>						
				<td><u>
					<b>Client Stations:</b>
				</a></u></td>
<?php
			}elseif($signed_off == 0)
			{			
?>						
				<td><u>
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=clients&view=update&f_id='.$f_id.'">'?>  Client Stations:
				</a></u></td>
<?php
			}elseif($signed_off == 2)
			{
?>						
				<td><u>
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=clients&view=update&f_id='.$f_id.'&&type=amend">'?>  Client Stations:
				</a></u></td>
<?php				
			}
?>								
			</tr>		
		</table>
		<table align ="center" border = 0 width = "720" cellpadding="2">			
			<tr>
				<td>
					Number of Client Stations (Licenses Included): <?php echo $equip['TotalClientStations']; ?>
				</td>
			</tr>
<?php
		if($equip['lic'] <> 0)
		{
?>				
			<tr>
				<td>
					Number of Client Licenses (Installed on Customer PC): <?php echo $equip['lic']; ?>
				</td>
			</tr>
<?php
		}
?>
			<tr>
				<td>
					Client Station Location:
				</td>
			</tr>
		</table>
		<table align ="center" width = "690">
			<tr>
				<td> 
					<?php echo $equip['ClientStationlocation']; ?> 
				</td>
			</tr>
		</table>
		<table align ="center" width = "720" cellpadding="2">
<?php
		if((($equip['lic'] + $equip['TotalClientStations']) > 5) OR ($upgrade == 1))
		{
?>
	
			<tr>
				<td> 
					**  The database type will be Sybase and the Computer used for the HomeFree Server will be upgraded. 
				</td>
			</tr>
<?php
		}	
?>
				<tr>
					<td> 
						**  Client computers require a connection to the Local Area Connection that is on the same Local Subnet as the HomeFree Server.  Please contact the HomeFree Technical Department for any further questions.
					</td>
				</tr>
			</table>
		<table align ="center" width = "750" cellpadding="2">
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>
<?php
	}
	/*
	*************************************************POWER AND WIRE*********************************************
	*/
	if((!$equip['TotalCentralPowerSupplies']==0) || (!($equip['Wire162'] ==0 & ($equip['Wire224'] ==0))))
	{
?>
		<table align ="center" width = "750" cellpadding="2">
			<tr>
<?php			
			if((isset($_GET['view']) &&($_GET['view']== 'print')) || ($signed_off == 1))
			{
?>			
				<td><u>
					<b>Power and Wire</b>
				</u></td>
<?php
			}elseif($signed_off == 2)
			{
?>
				<td><u>
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=power&view=update&f_id='.$f_id.'&&type=amend">'?>Power and Wire
				</a></u></td>
<?php
			}elseif($signed_off == 0)
			{
?>
				<td><u>
					<?php echo '<a href="' . 'Updatescope.php'.'?equip=power&view=update&f_id='.$f_id.'">'?>Power and Wire
				</a></u></td>
<?php
			}
?>															
			</tr>		
		</table>		
		<table align ="center" width = "720" cellpadding="2"
<?php
		if($equip['powertype'] == "outlets")
		{
?>
	
			<tr>
				<td>
					The customer is responsible to have power outlets installed in each location according to the layout.
				</td>
			</tr>
<?php
		}elseif($equip['powertype'] == "cpshf")
		{
?>
			<tr>
				<td>
					HomeFree Installers will install the Central Power Supply(s) and run all necessary wire.
				</td>
			</tr>
<?php
		}else
		{
?>
			<tr>
				<td>
					The customer will install the Central Power Supply(s) and run all necessary wire.
				</td>
			</tr>	
<?php
		}
		if(!$equip['TotalCentralPowerSupplies']==0)
		{	
?>	
			<tr>
				<td>
					Central Power Supplies: <?php echo $equip['TotalCentralPowerSupplies']; ?>
				</td>
			</tr>
			<tr>
				<td>
					Central Power Supply Wire: <?php echo $cpswire; ?>
				</td>
			</tr>
		</table>
<?php
		}
?>
		<table align ="center" width = "720" cellpadding="2">
<?php
		if(!$equip['Wire162']==0)
		{	
?>	
			<tr>
				<td>
					16-2 Wire: <?php echo $wirex; ?>
				</td>
			</tr>
<?php		
		}
			if (!$equip['Wire224']==0)
		{	
?>			
			<tr>
				<td>
					22-4 Wire: <?php echo $wirey; ?>
				</td>
			</tr>
<?php
		}
?>
		</table>
		<table align ="center" width = "750" cellpadding="2">
			<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>
<?php
	}else
	{
		if((!isset($_GET['view'])) && ($signed_off == 0))
		{
?>
			<table align ="center" width = "750" cellpadding="2">	
				<tr>
					<td>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=power&view=update&f_id='.$f_id.'">'?> Add/Update Power or Wire
					</td>
				</tr>			
				<tr>
					<td><div align="center"><hr width="100%"></div></td>
			</tr>
			</table>
<?php
		}elseif((!isset($_GET['view'])) && ($signed_off == 2))
		{
?>
			<table align ="center" width = "750" cellpadding="2">	
				<tr>
					<td>
						<?php echo '<a href="' . 'Updatescope.php'.'?equip=power&view=update&f_id='.$f_id.'&&type=amend">'?> Add/Update Power or Wire
					</td>
				</tr>			
				<tr>
					<td><div align="center"><hr width="100%"></div></td>
			</tr>
			</table>
<?php			
		}
	}
	/**************************************************ADDITIONAL INFO**********************************************/
	?>	
	<table align ="center" width = "750" cellpadding="2">
		<tr>
			<td>
<?php
			if((!isset($_GET['view'])) && ($signed_off == 0))
			{
				echo '<a href="' . 'Updatescope.php'.'?equip=projectinfo&view=update&f_id='.$f_id.'">'.'Additional Comments:';
			}else
			{
				if($comments <> '')
				{
					echo '<u><b>Additional Comments:</b></u>';
				}
			}
?>		
			</td>	
		</tr>
	</table>
	<?php
	if($comments <> '')
	{
?>
	<table align ="center" width = "720" cellpadding="2">
		<tr>
		<td><?php echo $comments; ?> </td>	
		</tr>
		</table>
	<table align ="center" width = "750" cellpadding="2">  	
		<tr>
			<td><div align="center"><hr width="100%"></div></td>
		</tr>
	</table>
<?php
	}
	if(!$row70 == 0)
	{
?>
		<table width ="750" align="center">
	  	<tr>                                                      
	   		<td><b><font size=5>
<?php 
				if((!isset($_GET['view'])) && ($signed_off == 0))
				{
					echo '<a href="' . 'doorunit.php'.'?action=UPDATE&f_id='.$f_id.'">'.'Individual Door Information</a>';
				}elseif((!isset($_GET['view'])) && ($signed_off == 2))
				{
					echo '<a href="' . 'doorunit.php'.'?action=UPDATE&f_id='.$f_id.'&&type=amend">'.'Individual Door Information</a>';
				}else
				{
					echo 'Individual Door Information';
				}
?>			
	   		</b></td>
	  	</tr>
	  	<tr>
				<td><div align="center"><hr width="100%"></div></td>
			</tr>
		</table>
<?php
		while ($row42 = mysql_fetch_array($result42))
		{
		$doorid = $row42['doorID'];
		$doornumber = $row42["doornumber"];
		$doorname = $row42["doorname"];
		$doortype = $row42["doortype"];
		$framematerial = $row42["doorframematerial"];
		$surroundingconstruction =$row42["surroundingconstruction"];
		$notes = nl2br($row42["notes"]);
		$setuptype = $row42["alarmfunctionID"];
		$bypass = $row42["bypass"];
		$elock = $row42["elock"];
		$utpowerx = $row42["utpower1"];
		$variance = $row42["variance"];
	
		if($utpowerx == "yes")
		{
			$utpower1 =	"Universal Transmitters are to be connected to the correct power source.";
		}
		elseif($utpowerx == "no")
		{
			$utpower1 = "Universal Transmitter Powered by Battery";
		}
		elseif($utpowerx == "none")
		{
			$utpower1 = "";
		}
		if($elock == "elock")
		{
			$elock1 =	"HomeFree is tying into an existing lock on this door.";
		}
		elseif($elock== "noelock")
		{
			$elock1 = "HomeFree is installing a lock provided by HomeFree";
		}
		elseif($elock == "none")
		{
			$elock1 = "";
		}
		if($variance == 1)
		{
			$variance1 = "The customer has received a variance that allows HomeFree to install a mini lock on this door";
		}else
		{
			$variance1 = "";
		}
		if($doortype == "doortype1")
		{
			($doortype = "Single Door over 6 ft. 11");
		}
		if($doortype == "doortype2")
		{
			($doortype = "Double Door over 6 ft. 11");
		}
		if($doortype == "doortype3")
		{
			($doortype = "Single Interior Door under 6 ft. 11");
		}
		if($doortype == "doortype4")
		{
			($doortype = "Double Interior Door under 6 ft. 11");
		}
		if ($doortype == "doortype5")
		{
			($doortype = "Single Exit Door under 6 ft. 11");
		}
		if ($doortype == "doortype6")
		{
			($doortype = "Double Exit Door under 6 ft. 11");
		}
		if ($doortype == "doortype7")
		{
			($doortype = "Sliding\Automatic Door");
		}
		if ($doortype == "doortype8")
		{
			($doortype = "Outdoor Gate");
		}
		if ($doortype == "doortype9")
		{
			($doortype = "Elevator Bank");
		}
		if ($bypass == "bypass1")
		{
			($bypass = "Keypad");
		}	
		if ($bypass == "bypass2")
		{
			($bypass = "Pushbutton");
		}	
		if ($framematerial == "frame1")
		{
			($framematerial = "Wood");
		}	
		if ($framematerial == "frame2")
		{
			($framematerial = "Metal");
		}			
		if($surroundingconstruction == "surround1")
		{
			($surroundingconstruction = "Cinder Block");
		}
		if($surroundingconstruction == "surround2")
		{
			($surroundingconstruction = "Window/Glass");
		}
		if($surroundingconstruction == "surround3")
		{
			($surroundingconstruction = "Dry Wall");
		}		
		$query72 = "SELECT * From tbldoorfunction WHERE AlarmID = '$setuptype'";
		$result72 = mysql_query($query72) or die (mysql_error());
		$row72 = mysql_fetch_array($result72);
		$alarm =  addslashes($row72['alarmfunction']);
			
		$getdoorequip = "SELECT * FROM tbldooralarms WHERE AlarmID = '$setuptype'";
		$resgetdoorequip = mysql_query($getdoorequip) or die (mysql_error());
		$dooralarmequip = mysql_fetch_array($resgetdoorequip);
		$setuptype = 	$dooralarmequip['AlarmFunction'];
?>
	<table width="759" align="center">
		<tr>
			<td>
				<FIELDSET>
					<table align="center" cellpadding=2 width="750">
						<tr>							                                                         
							<td colspan="3"><strong>
<?php
							if((!isset($_GET['view'])) && ($signed_off == 0))
							{							
	 							echo '<a href="' . 'doorunit.php'.'?doorid='.$doorid.'">'.'Door Number:'.$row42['doornumber'];
	 						}else
	 						{
	 							echo 'Door Number: '. $row42['doornumber'];
	 						}
?> 						
							</strong></td>
						</tr>
						<tr>
							<td class="border">
								<table width="749">	
									<tr>
										<td colspan="3" align="center">
											<b>Properties</b>
										</td>
									</tr>												
									<tr>
										<td colspan="3">
											<b>Door Name:</b> <?php echo $row42['doorname'] ?>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<b>Door Type:</b> <?php echo $doortype; ?>
										</td>
									</tr>
								</table>
								<table align="center" width=750">
									<tr>
										<td width="77" valign="top">
											<b>Door Setup:</b> 
										</td>
										<td>
											<?php echo $setuptype; ?>
										</td>
									</tr>
								</table>
								<table align="center" width=750">
									<tr>
										<td>
											<b>Surrounding Construction: </b><?php echo $surroundingconstruction; ?>
										</td>
									</tr>
									<tr>
								 		<td>
								 			<b>Door Frame: </b><?php echo $framematerial; ?>
								 		</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td class="border">
								<table width="749">	
									<tr>
										<td colspan="3" align="center">
											<b>Equipment</b>
										</td>
									</tr>
<?php		
								if($row42['doorunitcount'] <> 0)
								{
?>		
									<tr>
										<td width = "375">
							  	  	<b>Door Units:</b> <?php echo $row42['doorunitcount']; ?>
										</td>    	
									</tr>
<?php
								}
								if($row42['reedswitchcount'] <> 0)
								{
?>
									<tr>
							   	 	<td width = "375">
											<b>Reed Switches: </b><?php echo $row42['reedswitchcount']; ?>
										</td>
									</tr>
<?php
								}	
								if($row42['pircount'] <> 0)
								{
?>
									<tr>
										<td>
											<b>PIRs:</b> <?php echo $row42['pircount']; ?>
										</td>
									</tr>
<?php
								}							
								if($row42['outdoordoorunitCount'] <> 0)
								{
?>
									<tr>
										<td>
											<b>Outdoor Door Unit:</b> <?php echo $row42['outdoordoorunitCount']; ?>
										</td>
									</tr>
<?php			
								}
								if($row42['outdoorreedcount'] <> 0)
								{
?>	
									<tr>	
										<td>
							     		<b>Outdoor Reed Switches: </b><?php echo $row42['outdoorreedcount']; ?>
							    	</td>
							    </tr>
<?php      
								}
								if($row42['keypadcount'] <> 0)
								{
?>
									<tr>
										<td>
											<b>Keypads:</b> <?php echo $row42['keypadcount']; ?>
										</td>
									</tr>
<?php		
								}	
								if($row42['pushbuttoncount'] <> 0)
								{
?>	
									<tr>	
										<td>
											<b>Pushbutton (Secondary Bypass):</b> <?php echo $row42['pushbuttoncount']; ?>
										</td>
									</tr>
<?php		
								}													
								if($row42['minilockcount'] <> 0)
								{
?>		
									<tr>
										<td>
											<b>Mini Locks:</b> <?php echo $row42['minilockcount']; ?>
										</td>
									</tr>
<?php
								}	
								if($row42['zbracket'] <> 0)
								{
?>	
									<tr>	
										<td>
								 			<b>Z Bracket Locks: </b><?php echo $row42['zbracket']; ?>
										</td>	 		
									</tr>
<?php
								}	
								if($row42['zbracketoutdoor'] <> 0)
								{
?>		
									<tr>
										<td>
											<b>Outdoor Z Bracket Locks: </b><?php echo $row42['zbracketoutdoor']; ?>
										</td>
									</tr>
<?php		
								}	
								if($row42['egresskit'] <> 0)
								{
?>		
									<tr>
										<td>
											<b>Egress Kits:</b> <?php echo $row42['egresskit']; ?>
										</td>
									</tr>
<?php		
								}																									
								if($row42['utcount'] <> 0)
								{
?>	
									<tr>	
										<td>
											<b>Universal Transmitters:</b> <?php echo $row42['utcount']; ?>
										</td>			
									</tr>
<?php
								}
								if($row42['timercount'] <> 0)
								{
?>		
									<tr>
										<td>
											<b>Timers:</b> <?php echo $row42['timercount']; ?>
										</td>			
									</tr>
<?php
								}	
								if($row42['buzzer'] <> 0)
								{
?>	
									<tr>	
										<td>
											<b>Buzzer(Local alarm): </b><?php echo $row42['buzzer']; ?>
										</td>
									</tr>
<?php		
								}									
								if($row42['relaycount'] <> 0)
								{
?>
									<tr>
										<td>
											<b>Relays:</b><?php echo $row42['relaycount']; ?>
										</td>
									</tr>
<?php
								}
								if($row42['extboard'] <> 0)
								{
?>
									<tr>
										<td>
											<b>Keypad Extended Relays:</b> <?php echo $row42['extboard']; ?>
										</td>
									</tr>
<?php		
								}												
								if($row42['racepackcount'] <> 0)
								{
?>
									<tr>
										<td>
											<b>Raceway Packs:</b> <?php echo $row42['racepackcount']; ?>
										</td>
									</tr>
<?php
								}
?>
								</table>
							</td>
						</tr>
					</table>
					<table align="center" width="750">
						<tr>
							<td class="border">
								<table width="750">
									<tr>
										<td colspan = "2" align="center">
											<b>Door Functionality</b>
										</td>
									</tr>				
									<tr>
										<td colspan="2">
											<?php echo stripslashes($alarm); ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table align="center" width=750">
<?php	
						if($row42['notes'] <> '')
						{
?>		
							<tr>
								<td valign="top">
									<b>Notes: </b>
								</td>
								<td>
									<?php echo $row42['notes']; ?>
								</td>
							</tr>
<?php
						}
?>
						</tr>						
						<tr>
							<td colspan="2"><b>
								<?php echo $utpower1; ?>
							</b></td>
						</tr>
						<tr>
							<td colspan="2"><b>
								<?php echo $elock1; ?>
							</b></td>
						</tr>
						<tr>
						<tr>
							<td colspan="2"><b>
								<?php echo $variance1; ?>
							</b></td>
						</tr>
					</table>
				</td>
			</tr>
		</FIELDSET>
	</table>
<?php
		}
	} 
}                                                         
if(isset($_GET['view']) &&($_GET['view']== 'print'))
{
	include 'scopefooter.php';
}
include 'includes/closedb.php';
if(!((isset($_GET['view'])) &&($_GET['view']== 'print')))
{
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>
<?php
}
?>
