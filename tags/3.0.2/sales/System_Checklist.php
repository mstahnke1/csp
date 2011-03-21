<?php
if(!isset($_GET['print']))
{
	include 'header.php';
}else
{
	include 'printheader.php';
}
include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
if((isset($_GET['system_checklist'])) && ($_GET['system_checklist'] == 'Done'))
{
	$facilityid = $_GET['facilityid'];
	header("Location: newfinishedpage.php?f_id=$facilityid");
}
if((isset($_GET['view'])) && ($_GET['view'] == 'checklist'))
{
	mysql_select_db($dbname2);
	$facilityid = $_GET['f_id'];
	$query = "SELECT ID FROM tblsystem_checklist WHERE FacilityID = '$facilityid'";
	$result = mysql_query($query) or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count < 1)
	{
		$query1 = "INSERT INTO tblsystem_checklist (FacilityID) VALUES ('$facilityid')";
		mysql_query($query1) or die(mysql_error());
	}
	$query2 = "SELECT * FROM tblsystem_checklist WHERE FacilityID = '$facilityid'";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2);
	$per_plan = $row2['per_plan'];
	$bidder_design = $row2['bidder_design'];
	$meets_ada = $row2['meets_ada'];
	$permit_cost = $row2['permit_cost'];
	$additional_equipment = $row2['additional_equipment'];
	$bid_in_phases = $row2['bid_in_phases'];
	$applicable_taxes = $row2['applicable_taxes'];
	$floor_plan_provided = $row2['floor_plan_provided'];
	$submittals = $row2['submittals'];
	$operation_manuals = $row2['operation_manuals'];
	$training_manuals = $row2['training_manuals'];
	$as_built_drawings = $row2['as_built_drawings'];
	$pre_test_acceptance = $row2['pre_test_acceptance'];
	$owner_training = $row2['owner_training'];
	$internet_connection = $row2['internet_connection'];
	$LAN_base_unit = $row2['LAN_base_unit'];
	$LAN_server = $row2['LAN_server'];
	$LAN_clients = $row2['LAN_clients'];
	$static_IP_provided = $row2['static_IP_provided'];
	$static_IP_base_unit = $row2['static_IP_base_unit'];
	$FCC_license = $row2['FCC_license'];
	$phone_integration = $row2['phone_integration'];
	$back_boxes = $row2['back_boxes'];
	$wire_provided = $row2['wire_provided'];
	$labor_homefree = $row2['labor_homefree'];
	$labor_hardware = $row2['labor_hardware'];
	$labor_existing_locks = $row2['labor_existing_locks'];
	$labor_existing_hardware = $row2['labor_existing_hardware'];
	$labor_install_wire = $row2['labor_install_wire'];
	$labor_stub_ups = $row2['labor_stub_ups'];
	$labor_raceway = $row2['labor_raceway'];
	$labor_pull_wire = $row2['labor_pull_wire'];
	$labor_install_network = $row2['labor_install_network'];
	$labor_trenching = $row2['labor_trenching'];
	$ac_requirements = $row2['ac_requirements'];
	$labor_hours = $row2['labor_hours'];
	$labor_overtime = $row2['labor_overtime'];
	if(isset($_GET['saved']))
	{
		$saved_changes = 'yes';
	}else
	{
		$saved_changes = 'no';
	}
?>
	<link rel="stylesheet" type="text/css" href="sales.css" />
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width="550" align="center">
<?php
			if(!isset($_GET['print']))
			{
?>				
				<tr>
					<td>
						<?php echo '<a href="' . 'system_checklist.php'.'?f_id='.$facilityid.'&view=checklist&print=yes">'?>Print View</a>
					</td>
				</tr>
<?php
			}
?>							
			<tr>
				<td>
					<b><u>System Design/Implementation</u></b>
				</td>
				<td>
					Yes
				</td>		
				<td>
					No
				</td>	
				<td>
					N/A
				</td>			
			</tr>
			<tr>
				<td>
					Per Plans and Specifications
				</td>
				<td>
					<input type="radio" name="per_plan" value="1" <?php if($per_plan == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="per_plan" value="2" <?php if($per_plan == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="per_plan" value="3" <?php if($per_plan == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Bidder Design
				</td>
				<td>
					<input type="radio" name="bidder_design" value="1" <?php if($bidder_design == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="bidder_design" value="2" <?php if($bidder_design == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="bidder_design" value="3" <?php if($bidder_design == 3){ echo 'checked';}?>>
				</td>
			</tr>	
			<tr>
				<td>
					Meets ADA Requirements
				</td>
				<td>
					<input type="radio" name="meets_ada" value="1" <?php if($meets_ada == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="meets_ada" value="2" <?php if($meets_ada == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="meets_ada" value="3" <?php if($meets_ada == 3){ echo 'checked';}?>>
				</td>
			</tr>	
			<tr>
				<td>
					Permit cost included
				</td>
				<td>
					<input type="radio" name="permit_cost" value="1" <?php if($permit_cost == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="permit_cost" value="2" <?php if($permit_cost == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="permit_cost" value="3" <?php if($permit_cost == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Additional Equipment required by owner review included
				</td>
				<td>
					<input type="radio" name="additional_equipment" value="1" <?php if($additional_equipment == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="additional_equipment" value="2" <?php if($additional_equipment == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="additional_equipment" value="3" <?php if($additional_equipment == 3){ echo 'checked';}?>>
				</td>
			</tr>	
			<tr>
				<td>
					Project bid in phases
				</td>
				<td>
					<input type="radio" name="bid_in_phases" value="1" <?php if($bid_in_phases == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="bid_in_phases" value="2" <?php if($bid_in_phases == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="bid_in_phases" value="3" <?php if($bid_in_phases == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Applicable taxes
				</td>
				<td>
					<input type="radio" name="applicable_taxes" value="1" <?php if($applicable_taxes == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="applicable_taxes" value="2" <?php if($applicable_taxes == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="applicable_taxes" value="3" <?php if($applicable_taxes == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Floor Plan, customer provide pdf
				</td>
				<td>
					<input type="radio" name="floor_plan_provided" value="1" <?php if($floor_plan_provided == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="floor_plan_provided" value="2" <?php if($floor_plan_provided == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="floor_plan_provided" value="3" <?php if($floor_plan_provided == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Submittals
				</td>
				<td>
					<input type="radio" name="submittals" value="1" <?php if($submittals == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="submittals" value="2" <?php if($submittals == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="submittals" value="3" <?php if($submittals == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Operation Manuals
				</td>
				<td>
					<input type="radio" name="operation_manuals" value="1" <?php if($operation_manuals == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="operation_manuals" value="2" <?php if($operation_manuals == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="operation_manuals" value="3" <?php if($operation_manuals == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Training Manuals
				</td>
				<td>
					<input type="radio" name="training_manuals" value="1" <?php if($training_manuals == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="training_manuals" value="2" <?php if($training_manuals == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="training_manuals" value="3" <?php if($training_manuals == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					As-built drawings, customre to provide if they are installing system
				</td>
				<td>
					<input type="radio" name="as_built_drawings" value="1" <?php if($as_built_drawings == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="as_built_drawings" value="2" <?php if($as_built_drawings == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="as_built_drawings" value="3" <?php if($as_built_drawings == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Pre-test and Acceptance Test
				</td>
				<td>
					<input type="radio" name="pre_test_acceptance" value="1" <?php if($pre_test_acceptance == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="pre_test_acceptance" value="2" <?php if($pre_test_acceptance == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="pre_test_acceptance" value="3" <?php if($pre_test_acceptance == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Owner Training
				</td>
				<td>
					<input type="radio" name="owner_training" value="1" <?php if($owner_training == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="owner_training" value="2" <?php if($owner_training == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="owner_training" value="3" <?php if($owner_training == 3){ echo 'checked';}?>>
				</td>
			</tr>	
			<tr>
				<td>
					&nbsp;
				</td>
			</tr>			
			<tr>
				<td>
					<b><u>Network/Infrastructure</u></b>
				</td>
			</tr>
			<tr>
				<td>
					Internet (LAN) connection to be provided by the faciilty
				</td>
				<td>
					<input type="radio" name="internet_connection" value="1" <?php if($internet_connection == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="internet_connection" value="2" <?php if($internet_connection == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="internet_connection" value="3" <?php if($internet_connection == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					LAN connection at base unit(s)
				</td>
				<td>
					<input type="radio" name="LAN_base_unit" value="1" <?php if($LAN_base_unit == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="LAN_base_unit" value="2" <?php if($LAN_base_unit == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="LAN_base_unit" value="3" <?php if($LAN_base_unit == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					LAN connection at main computer (HF Server)
				</td>
				<td>
					<input type="radio" name="LAN_server" value="1" <?php if($LAN_server == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="LAN_server" value="2" <?php if($LAN_server == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="LAN_server" value="3" <?php if($LAN_server == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					LAN connection at sub station(s) (HF client PC's)
				</td>
				<td>
					<input type="radio" name="LAN_clients" value="1" <?php if($LAN_clients == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="LAN_clients" value="2" <?php if($LAN_clients == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="LAN_clients" value="3" <?php if($LAN_clients == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Static IP addresses provided by the facility
				</td>
				<td>
					<input type="radio" name="static_IP_provided" value="1" <?php if($static_IP_provided == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="static_IP_provided" value="2" <?php if($static_IP_provided == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="static_IP_provided" value="3" <?php if($static_IP_provided == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Static IP addresses for base unit(s)
				</td>
				<td>
					<input type="radio" name="static_IP_base_unit" value="1" <?php if($static_IP_base_unit == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="static_IP_base_unit" value="2" <?php if($static_IP_base_unit == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="static_IP_base_unit" value="3" <?php if($static_IP_base_unit == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					FCC license paperwork for 25W or greater paging transmitter
				</td>
				<td>
					<input type="radio" name="FCC_license" value="1" <?php if($FCC_license == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="FCC_license" value="2" <?php if($FCC_license == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="FCC_license" value="3" <?php if($FCC_license == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Phone integration as per SOW
				</td>
				<td>
					<input type="radio" name="phone_integration" value="1" <?php if($phone_integration == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="phone_integration" value="2" <?php if($phone_integration == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="phone_integration" value="3" <?php if($phone_integration == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;
				</td>
			</tr>			
			<tr>
				<td>
					<b><u>Installation/Labor</u></b>
				</td>
			</tr>			
			<tr>
				<td>
					Back boxes for equipment quoted
				</td>
				<td>
					<input type="radio" name="back_boxes" value="1" <?php if($back_boxes == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="back_boxes" value="2" <?php if($back_boxes == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="back_boxes" value="3" <?php if($back_boxes == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Wire provided for quoted system
				</td>
				<td>
					<input type="radio" name="wire_provided" value="1" <?php if($wire_provided == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="wire_provided" value="2" <?php if($wire_provided == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="wire_provided" value="3" <?php if($wire_provided == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor for HomeFree devices only
				</td>
				<td>
					<input type="radio" name="labor_homefree" value="1" <?php if($labor_homefree == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_homefree" value="2" <?php if($labor_homefree == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_homefree" value="3" <?php if($labor_homefree == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor for associated hardware: locks, keypad, timers, and such
				</td>
				<td>
					<input type="radio" name="labor_hardware" value="1" <?php if($labor_hardware == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_hardware" value="2" <?php if($labor_hardware == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_hardware" value="3" <?php if($labor_hardware == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor for existing lock(s) on door(s)
				</td>
				<td>
					<input type="radio" name="labor_existing_locks" value="1" <?php if($labor_existing_locks == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_existing_locks" value="2" <?php if($labor_existing_locks == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_existing_locks" value="3" <?php if($labor_existing_locks == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor for existing door hardware: keypad, timers, and such
				</td>
				<td>
					<input type="radio" name="labor_existing_hardware" value="1" <?php if($labor_existing_hardware == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_existing_hardware" value="2" <?php if($labor_existing_hardware == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_existing_hardware" value="3" <?php if($labor_existing_hardware == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor to install wire (open cable), fittings, and miscellaneous hardware
				</td>
				<td>
					<input type="radio" name="labor_install_wire" value="1" <?php if($labor_install_wire == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_install_wire" value="2" <?php if($labor_install_wire == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_install_wire" value="3" <?php if($labor_install_wire == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor to install stub-ups
				</td>
				<td>
					<input type="radio" name="labor_stub_ups" value="1" <?php if($labor_stub_ups == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_stub_ups" value="2" <?php if($labor_stub_ups == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_stub_ups" value="3" <?php if($labor_stub_ups == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor to install raceway
				</td>
				<td>
					<input type="radio" name="labor_raceway" value="1" <?php if($labor_raceway == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_raceway" value="2" <?php if($labor_raceway == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_raceway" value="3" <?php if($labor_raceway == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor to pull wire through conduit
				</td>
				<td>
					<input type="radio" name="labor_pull_wire" value="1" <?php if($labor_pull_wire == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_pull_wire" value="2" <?php if($labor_pull_wire == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_pull_wire" value="3" <?php if($labor_pull_wire == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor to install network/fiber
				</td>
				<td>
					<input type="radio" name="labor_install_network" value="1" <?php if($labor_install_network == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_install_network" value="2" <?php if($labor_install_network == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_install_network" value="3" <?php if($labor_install_network == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor and equipment cost for trenching and underground conduits
				</td>
				<td>
					<input type="radio" name="labor_trenching" value="1" <?php if($labor_trenching == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_trenching" value="2" <?php if($labor_trenching == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_trenching" value="3" <?php if($labor_trenching == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					110V AC power requirements
				</td>
				<td>
					<input type="radio" name="ac_requirements" value="1" <?php if($ac_requirements == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="ac_requirements" value="2" <?php if($ac_requirements == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="ac_requirements" value="3" <?php if($ac_requirements == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor during normal business hours.  Monday - Friday 7AM - 5PM Central Time
				</td>
				<td>
					<input type="radio" name="labor_hours" value="1" <?php if($labor_hours == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_hours" value="2" <?php if($labor_hours == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_hours" value="3" <?php if($labor_hours == 3){ echo 'checked';}?>>
				</td>
			</tr>
			<tr>
				<td>
					Labor for overtime, weekend or holiday work included
				</td>
				<td>
					<input type="radio" name="labor_overtime" value="1" <?php if($labor_overtime == 1){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_overtime" value="2" <?php if($labor_overtime == 2){ echo 'checked';}?>>
				</td>
				<td>
					<input type="radio" name="labor_overtime" value="3" <?php if($labor_overtime == 3){ echo 'checked';}?>>
				</td>
			</tr>	
		</table>
		<table width="550" align="center">
		  <tr>
				<td>
					<input type="submit" value="Save" name="system_checklist">
				</td>
<?php
				if($saved_changes == 'yes')
				{
?>				
					<td>
						<input type="submit" value="Done" name="system_checklist">
					</td>	
<?php
				}
?>												
			</tr>																																																																							
		</table>
<?php
		echo	'<input type = "hidden" name="facilityid" value = "'.$facilityid.'">';
?>
	</form>
<?php
}
if((isset($_GET['system_checklist'])) && ($_GET['system_checklist'] == 'Save'))
{
	$facilityid = $_GET['facilityid'];
	if(isset($_GET['per_plan']))
	{
		$per_plan = $_GET['per_plan'];
	}else
	{
		$per_plan = 0;
	}
	if(isset($_GET['bidder_design']))
	{
		$bidder_design = $_GET['bidder_design'];
	}else
	{
		$bidder_design = 0;
	}
	if(isset($_GET['meets_ada']))
	{
		$meets_ada = $_GET['meets_ada'];
	}else
	{
		$meets_ada = 0;
	}	
	if(isset($_GET['permit_cost']))
	{
		$permit_cost = $_GET['permit_cost'];
	}else
	{
		$permit_cost = 0;
	}	
	if(isset($_GET['additional_equipment']))
	{
		$additional_equipment = $_GET['additional_equipment'];
	}else
	{
		$additional_equipment = 0;
	}	
	if(isset($_GET['bid_in_phases']))
	{
		$bid_in_phases = $_GET['bid_in_phases'];
	}else
	{
		$bid_in_phases = 0;
	}
	if(isset($_GET['applicable_taxes']))
	{
		$applicable_taxes = $_GET['applicable_taxes'];
	}else
	{
		$applicable_taxes = 0;
	}		
	if(isset($_GET['floor_plan_provided']))
	{
		$floor_plan_provided = $_GET['floor_plan_provided'];
	}else
	{
		$floor_plan_provided = 0;
	}
	if(isset($_GET['submittals']))
	{
		$submittals = $_GET['submittals'];
	}else
	{
		$submittals = 0;
	}
	if(isset($_GET['operation_manuals']))
	{
		$operation_manuals = $_GET['operation_manuals'];
	}else
	{
		$operation_manuals = 0;
	}
	if(isset($_GET['training_manuals']))
	{
		$training_manuals = $_GET['training_manuals'];
	}else
	{
		$training_manuals = 0;
	}
	if(isset($_GET['as_built_drawings']))
	{
		$as_built_drawings = $_GET['as_built_drawings'];
	}else
	{
		$as_built_drawings = 0;
	}	
	if(isset($_GET['pre_test_acceptance']))
	{
		$pre_test_acceptance = $_GET['pre_test_acceptance'];
	}else
	{
		$pre_test_acceptance = 0;
	}	
	if(isset($_GET['owner_training']))
	{
		$owner_training = $_GET['owner_training'];
	}else
	{
		$owner_training = 0;
	}	
	if(isset($_GET['internet_connection']))
	{
		$internet_connection = $_GET['internet_connection'];
	}else
	{
		$internet_connection = 0;
	}		
	if(isset($_GET['LAN_base_unit']))
	{
		$LAN_base_unit = $_GET['LAN_base_unit'];
	}else
	{
		$LAN_base_unit = 0;
	}	
	if(isset($_GET['LAN_server']))
	{
		$LAN_server = $_GET['LAN_server'];
	}else
	{
		$LAN_server = 0;
	}		
	if(isset($_GET['LAN_clients']))
	{
		$LAN_clients = $_GET['LAN_clients'];
	}else
	{
		$LAN_clients = 0;
	}	
	if(isset($_GET['static_IP_provided']))
	{
		$static_IP_provided = $_GET['static_IP_provided'];
	}else
	{
		$static_IP_provided = 0;
	}		
	if(isset($_GET['static_IP_base_unit']))
	{
		$static_IP_base_unit = $_GET['static_IP_base_unit'];
	}else
	{
		$static_IP_base_unit = 0;
	}
	if(isset($_GET['FCC_license']))
	{
		$FCC_license = $_GET['FCC_license'];
	}else
	{
		$FCC_license = 0;
	}	
	if(isset($_GET['phone_integration']))
	{
		$phone_integration = $_GET['phone_integration'];
	}else
	{
		$phone_integration = 0;
	}	
	if(isset($_GET['back_boxes']))
	{
		$back_boxes = $_GET['back_boxes'];
	}else
	{
		$back_boxes = 0;
	}	
	if(isset($_GET['wire_provided']))
	{
		$wire_provided = $_GET['wire_provided'];
	}else
	{
		$wire_provided = 0;
	}	
	if(isset($_GET['labor_homefree']))
	{
		$labor_homefree = $_GET['labor_homefree'];
	}else
	{
		$labor_homefree = 0;
	}	
	if(isset($_GET['labor_hardware']))
	{
		$labor_hardware = $_GET['labor_hardware'];
	}else
	{
		$labor_hardware = 0;
	}		
	if(isset($_GET['labor_existing_locks']))
	{
		$labor_existing_locks = $_GET['labor_existing_locks'];
	}else
	{
		$labor_existing_locks = 0;
	}	
	if(isset($_GET['labor_existing_hardware']))
	{
		$labor_existing_hardware = $_GET['labor_existing_hardware'];
	}else
	{
		$labor_existing_hardware = 0;
	}	
	if(isset($_GET['labor_install_wire']))
	{
		$labor_install_wire = $_GET['labor_install_wire'];
	}else
	{
		$labor_install_wire = 0;
	}		
	if(isset($_GET['labor_stub_ups']))
	{
		$labor_stub_ups = $_GET['labor_stub_ups'];
	}else
	{
		$labor_stub_ups = 0;
	}	
	if(isset($_GET['labor_raceway']))
	{
		$labor_raceway = $_GET['labor_raceway'];
	}else
	{
		$labor_raceway = 0;
	}		
	if(isset($_GET['labor_pull_wire']))
	{
		$labor_pull_wire = $_GET['labor_pull_wire'];
	}else
	{
		$labor_pull_wire = 0;
	}		
	if(isset($_GET['labor_install_network']))
	{
		$labor_install_network = $_GET['labor_install_network'];
	}else
	{
		$labor_install_network = 0;
	}	
	if(isset($_GET['labor_trenching']))
	{
		$labor_trenching = $_GET['labor_trenching'];
	}else
	{
		$labor_trenching = 0;
	}	
	if(isset($_GET['ac_requirements']))
	{
		$ac_requirements = $_GET['ac_requirements'];
	}else
	{
		$ac_requirements = 0;
	}	
	if(isset($_GET['labor_hours']))
	{
		$labor_hours = $_GET['labor_hours'];
	}else
	{
		$labor_hours = 0;
	}		
	if(isset($_GET['labor_overtime']))
	{
		$labor_overtime = $_GET['labor_overtime'];
	}else
	{
		$labor_overtime = 0;
	}
	mysql_select_db($dbname2);
	$query3 = "UPDATE tblsystem_checklist SET per_plan='$per_plan',bidder_design='$bidder_design',meets_ada='$meets_ada',
	permit_cost='$permit_cost',additional_equipment='$additional_equipment',bid_in_phases='$bid_in_phases',
	applicable_taxes='$applicable_taxes',floor_plan_provided='$floor_plan_provided',submittals='$submittals',
	operation_manuals='$operation_manuals',training_manuals='$training_manuals',as_built_drawings='$as_built_drawings',
	pre_test_acceptance='$pre_test_acceptance',owner_training='$owner_training',internet_connection='$internet_connection',
	LAN_base_unit='$LAN_base_unit',LAN_server='$LAN_server',LAN_clients='$LAN_clients',static_IP_provided='$static_IP_provided',
	static_IP_base_unit='$static_IP_base_unit',FCC_license='$FCC_license',phone_integration='$phone_integration',
	back_boxes='$back_boxes',wire_provided='$wire_provided',labor_homefree='$labor_homefree',labor_hardware='$labor_hardware',
	labor_existing_locks='$labor_existing_locks',labor_existing_hardware='$labor_existing_hardware',labor_install_wire='$labor_install_wire',
	labor_stub_ups='$labor_stub_ups',labor_raceway='$labor_raceway',labor_pull_wire='$labor_pull_wire',
	labor_install_network='$labor_install_network',labor_trenching='$labor_trenching',ac_requirements='$ac_requirements',
	labor_hours='$labor_hours',labor_overtime='$labor_overtime' WHERE FacilityID = '$facilityid'";
	mysql_query($query3) or die(mysql_error());
	header("Location: system_checklist.php?view=checklist&f_id=$facilityid&saved=yes");	
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