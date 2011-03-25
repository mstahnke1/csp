<link rel="stylesheet" type="text/css" href="sales.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HomeFree Install Quote</title>
<?php
//include 'installheader.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
$date = date('m-d-Y');
$date1 = date('m/d/Y');
$datetime = date('Y-m-d H:i:s');
$completiontime = date('m/d/Y H:i:s');
$onemonth = strtotime("+1 month");
$monthahead = date('m/d/Y',$onemonth);
//$m = date('m');
if(isset($_GET['action'])&&($_GET['action']=='DELETESCH'))
{
	$f_id = $_GET['f_id'];
	$deleteid = $_GET['id'];
	$delete = "UPDATE epc_calendar SET active = 0 WHERE id = '$deleteid'";
	mysql_query($delete) or die(mysql_error());
	header("Location: installquote.php?f_id=$f_id&view=installcalendar");
}
if(isset($_GET['action'])&&($_GET['action']=='DELETE'))
{
	$f_id = $_GET['f_id'];
	$deleteid = $_GET['HFQ'];
	$delete = "DELETE FROM tblinstallinfo WHERE hfq = '$deleteid'";
	mysql_query($delete) or die(mysql_error());
	header("Location: installquote.php?f_id=$f_id&view=getquote");
}
if(!isset($_GET['f_id']))
{
	$f_id = 000000;
}else
{
	$f_id = $_GET['f_id'];
}
$query17 = "SELECT * From tblfacilitygeneralinfo WHERE ID='$f_id'";
$result17 = mysql_query($query17) or die (mysql_error());
$row17 = mysql_fetch_array($result17);	
$sman = $row17['Salesman'];
if($row17['QuoteName'] <> '0')
{ 
	$extname = $row17['QuoteName'];
}else
{
	$extname = '';
}
mysql_select_db('testhomefree');
$query18 = "SELECT id, f_name, l_name FROM employees WHERE id = '$sman' ORDER BY l_name";
$result18 = mysql_query($query18) or die (mysql_error());
while($row18 = mysql_fetch_array($result18))
{  					
	$salesman = $row18['f_name']. ' ' . $row18['l_name'];   									
}
$currentver = '6.12';
mysql_select_db('testwork');
$query = "SELECT * FROM tblinstallprices";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result);
$getequip = "SELECT * FROM tbltotalequipment WHERE FacilityID='$f_id'";
$resgetequip = mysql_query($getequip) or die (mysql_error());
$equip = mysql_fetch_array($resgetequip);
$dual = $equip["TotalCallCorddual"];
$addbaseunits = $equip['addbase'];
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
$squeeze = $equip["Squeezeball"];
$breath = $equip["breathcall"];
$type = $equip["CorridorLights"];
$style = $equip["CorridorLightType"];
$existinglights = $equip["TotalExistingCorrdiorLights"];
$homefreelights = $equip["TotalHomeFreeCorrdiorLights"];
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
$upgrade = $equip['upgrade'];
$power = $equip["TotalCentralPowerSupplies"];
$cpswire = $equip['CPSwire'];
$job = $equip["joboverview"];
$wirex = $equip["Wire162"];
$wirey = $equip["Wire224"];
$utpower = $equip['utpower'];
$whowiring = $equip['powertype'];
/***************************************************************DOOR UNIT QUERIERS**********************************************************/
$query1 = "SELECT SUM(doorunitcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result1 = mysql_query($query1) or die(mysql_error());
$row1 = mysql_fetch_array($result1);
$wmducount = $row1['SUM(doorunitcount)'];
$query2 = "SELECT SUM(outdoordoorunitCount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result2 = mysql_query($query2) or die(mysql_error());
$row2 = mysql_fetch_array($result2);
$owmducount = $row2['SUM(outdoordoorunitCount)'];
/******************************************************LOCK QUERIERS****************************************************************/
$query3 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result3 = mysql_query($query3) or die(mysql_error());
$row3 = mysql_fetch_array($result3);
$minicount = $row3['SUM(minilockcount)'];
$query4 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result4 = mysql_query($query4) or die(mysql_error());
$row4 = mysql_fetch_array($result4);
$minicount = $row4['SUM(minilockcount)'];
$query5 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result5 = mysql_query($query5) or die(mysql_error());
$row5 = mysql_fetch_array($result5);
$zbracketcount = $row5['SUM(zbracket)'];
$query6 = "SELECT SUM(zbracketoutdoor) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result6 = mysql_query($query6) or die(mysql_error());
$row6 = mysql_fetch_array($result6);
$ozbracketcount = $row6['SUM(zbracketoutdoor)'];
$query7 = "SELECT doortype FROM tblfacilitydoors WHERE FacilityID='$f_id' AND elock = 'elock'"; 
$result7 = mysql_query($query7) or die(mysql_error());
$a = 0;
while($row7 = mysql_fetch_array($result7))
{
	$doortype = $row7['doortype'];
	if($doortype == "doortype1" OR $doortype == "doortype3" OR $doortype == "doortype5" OR $doortype == "doortype7" OR $doortype == "doortype8")
	{
		$existing = 1;
	}
	if($doortype == "doortype2" OR $doortype == "doortype4" OR $doortype == "doortype6")
	{
		$existing = 2;
	}
	$a = ($a + $existing);
}
/***************************************************************KEYPAD QUERY**********************************************************/
$query8 = "SELECT SUM(keypadcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result8 = mysql_query($query8) or die(mysql_error());
$row8 = mysql_fetch_array($result8);
$keypadcount = $row8['SUM(keypadcount)'];
/***************************************************************PUSHBUTTON QUERY**********************************************************/
$query9 = "SELECT SUM(pushbuttoncount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result9 = mysql_query($query9) or die(mysql_error());
$row9 = mysql_fetch_array($result9);
$pushbuttoncount = $row9['SUM(pushbuttoncount)'];
/***************************************************************REED QUERIES**********************************************************/
$query10 = "SELECT SUM(reedswitchcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result10 = mysql_query($query10) or die(mysql_error());
$row10 = mysql_fetch_array($result10);
$reedcount = $row10['SUM(reedswitchcount)'];
$query11 = "SELECT SUM(outdoorreedcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result11 = mysql_query($query11) or die(mysql_error());
$row11 = mysql_fetch_array($result11);
$oreedcount = $row11['SUM(outdoorreedcount)'];
/***************************************************************UT QUERIES**********************************************************/
$query12 = "SELECT SUM(utcount) FROM tblfacilitydoors WHERE FacilityID='$f_id' AND utpower1 = 'no'"; 
$result12 = mysql_query($query12) or die(mysql_error());
$row12 = mysql_fetch_array($result12);
$utcount = $row12['SUM(utcount)'];
$query13 = "SELECT SUM(utcount) FROM tblfacilitydoors WHERE FacilityID='$f_id' AND utpower1 = 'yes'"; 
$result13 = mysql_query($query13) or die(mysql_error());
$row13 = mysql_fetch_array($result13);
$powerutcount = $row13['SUM(utcount)'];
if($utpower <> 'no')
{
	$utx = $ut;
}else
{
	$utx = 0;
}
if($utpower <> 'yes')
{
	$uty = $ut;
}else
{
	$uty = 0;
}
$query14 = "SELECT SUM(pircount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result14 = mysql_query($query14) or die(mysql_error());
$row14 = mysql_fetch_array($result14);
$pircount = $row14['SUM(pircount)'];
$query15 = "SELECT SUM(timercount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result15 = mysql_query($query15) or die(mysql_error());
$row15 = mysql_fetch_array($result15);
$timercount = $row15['SUM(timercount)'];
if($base <> 'NONE')
{
	$paging = 1;
}
$query16 = "SELECT SUM(relaycount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result16 = mysql_query($query16) or die(mysql_error());
$row16 = mysql_fetch_array($result16);
$relaycount = $row16['SUM(relaycount)'];
/**********************************************************************************************************************************
**********************************************************************************************************************************/	
/****************************************************************SERVER MATH**********************************************************/
if((($equip['lic'] + $equip['TotalClientStations']) > 5) OR ($upgrade == 1))
{
	$servercost = number_format(1 * $row['sybase'],2);
	$servercost1 = (1 * $row['sybase']);
	$servertype = 'sybase';
	$clienttype = 'sybaseclient';
	$computerqty = 1;
}else
{
	$servercost = number_format(1 * $row['pc'],2);
	$servercost1 = (1 * $row['pc']);
	$servertype = 'access';
	$clienttype = 'accessclient';
	$computerqty = 1;
}
/****************************************************************BASE UNIT MATH**********************************************************/
$sum = ($wmu+ $owmu + $sowmu);
$basesum = ($sum + $wmducount);
//echo $basesum;
if($equip['baseconnect']=="network")
{
	if($basesum < 60)
	{
		$baseunitserial = 0;
		$baseunitnet = (1 + $addbaseunits);
	}
	if($basesum  > 59)
	{
		$baseunitserial = 0;
		$baseunitx = ceil($basesum/ 60);
		$baseunitnet = ($baseunitx + $addbaseunits);
	}
}else
{	
	if($basesum < 60)
	{
		$baseunitserial = 1;
		$baseunitnet = (0 + $addbaseunits);
	}
	if($basesum > 59)
	{
		$baseunitserial = 1;
		$baseunitx = ceil($basesum / 60);
		$baseunitnet = ($baseunitx - 1 + $addbaseunits);
	}
}
$baseunitcost = ($baseunitnet * $row['wmbuprice']);
/****************************************************************WMU MATH**********************************************************/
$wmucost = number_format($wmu * $row['wmuprice'],2);
$wmucost1 = ($wmu * $row['wmuprice']);
$owmucost = number_format($owmu * $row['owmuprice'],2);
$owmucost1 = ($owmu * $row['owmuprice']);
$sowmucost = number_format($sowmu * $row['sowmuprice'],2);
$sowmucost1 = ($sowmu * $row['sowmuprice']);
/****************************************************************WMDU MATH**********************************************************/
$wmducost = number_format($wmducount * $row['wmduprice'],2);
$wmducost1 = ($wmducount * $row['wmduprice']);
$owmducost = number_format($owmducount * $row['owmduprice'],2);
$owmducost1 = ($owmducount * $row['owmduprice']);
/****************************************************************LOCK MATH**********************************************************/
$minicost = number_format($minicount * $row['minilockprice'],2);
$minicost1 = $minicount * $row['minilockprice'];
$zbracketcost = number_format(($zbracketcount) * $row['zbracketprice'],2);
$zbracketcost1 = ($zbracketcount * $row['zbracketprice']);
$outdoorzcost =  $ozbracketcount * $row['outdoorlock'];
$existingcost = number_format($a * $row['existingprice'],2);
$existingcost1 = ($a * $row['existingprice']);
/****************************************************************LOCK MATH**********************************************************/
$callcordcount = ($dual + $ten + $fifteen + $breath + $squeeze);
$callcordcost = ($callcordcount * $row['callcordprice']);
/****************************************************************KEYPAD MATH**********************************************************/
$keypadcost = number_format($keypadcount * $row['keypadprice'],2);
$keypadcost1 = ($keypadcount * $row['keypadprice']);
/****************************************************************PUSHBUTTON MATH**********************************************************/
$pushbuttoncost = number_format($pushbuttoncount * $row['pushbuttonprice'],2);
$pushbuttoncost1 = ($pushbuttoncount * $row['pushbuttonprice']);
/***************************************************************REED SWITCH MATH**********************************************************/
$reedcost = number_format($reedcount * $row['reedprice'],2);
$reedcost1 = ($reedcount * $row['reedprice']);
$oreedcost = number_format($oreedcount * $row['oreedprice'],2);
$oreedcost1 = ($oreedcount * $row['oreedprice']);
/***************************************************************UT MATH**********************************************************/
$powerutcost = number_format(($powerutcount + $utx) * $row['powerutprice'],2);
$powerutcost1 = ($powerutcount + $utx) * $row['powerutprice'];
$powerutcount2 = ($powerutcount + $utx);
$utcost = number_format(($utcount + $uty) * $row['utprice'],2);
$utcount2 = ($utcount + $uty);
$utcost1 = ($utcount + $uty) * $row['utprice'];
/***************************************************************PIR MATH**********************************************************/
$pircost = number_format($pircount * $row['pirprice'],2);
$pircost1 = ($pircount * $row['pirprice']);
/***************************************************************PULLCORD MATH (NO CORRIDOR LIGHTS)**********************************************************/
if($homefreelights == 0 && $existinglights == 0)
{
	$pccount = $pull;
	$activitycount = $pullw;
	$activitycost = $pullw * $row['activityprice'];
	$pccost = number_format($pccount * $row['pcprice'],2);
	$pccost1 = ($pccount * $row['pcprice']);
}
/*************************************************************TIMER MATH**********************************************************/
$timercost = number_format($timercount * $row['timerprice'],2);
$timercost1 = ($timercount * $row['timerprice']);
/*************************************************************WATCH MATH**********************************************************/
$pwcount = ($watch + $fwatch + $swatch);
$pwcost = ($pwcount * $row['pwprice']);
/***********************************************************CALL BUTTON MATH**********************************************************/
$callbuttoncount = ($tags + $callb);
$callcost = number_format($callbuttoncount * $row['callbuttonprice'],2);
$callcost1 = ($callbuttoncount * $row['callbuttonprice']);
/***************************************************************FDU MATH**********************************************************/
$fallcost = number_format($fall * $row['fduprice'],2);
$fallcost1 = ($fall * $row['fduprice']);
/********************************************************CENTRAL POWER SUPPLY AND WIRE**********************************************************/
if($whowiring <> 'cpscus')
{
	$cpscost = number_format($power * $row['cpsprice'],2);
	$cpscost1 = ($power * $row['cpsprice']);
	$cpswirecost = number_format($cpswire * $row['cpswireprice'],2);
	$cpswirecost1 = ($cpswire * $row['cpswireprice']);
}else
{
	$cpscost = 0.00;
	$cpscost1 = 0.00;
	$cpswirecost = 0.00;
	$cpswirecost1 = 0.00;
}
/*****************************************************CLIENT COMPUTERS*******************************************************/
if($clienttype == 'sybase')
{
	$clientprice = $row['sybaseclientprice'];
}else
{
	$clientprice = $row['clientprice'];
}
$clientcost = number_format($client * $clientprice,2);
$clientcost1 = ($client * $clientprice);
/*****************************************************PAGING BASE*******************************************************/
if($base == 'Commtech5W')
{	
	$pagingcost = number_format($paging * $row['pagingprice'],2);
	$pagingcost1 = ($paging * $row['pagingprice']);
	$pagerbaseqty = 1;
}elseif($base == 'Commtech25W')
{
	$pagingcost = number_format($paging * $row['pagingprice25'],2);
	$pagingcost1 = ($paging * $row['pagingprice25']);
	$pagerbaseqty = 1;
}elseif($base == 'Commtech50W')
{
	$pagingcost = number_format($paging * $row['pagingprice50'],2);
	$pagingcost1 = ($paging * $row['pagingprice50']);
	$pagerbaseqty = 1;
}elseif($base == 'Commtech100W')
{
	$pagingcost = number_format($paging * $row['pagingprice100'],2);
	$pagingcost1 = ($paging * $row['pagingprice100']);
	$pagerbaseqty = 1;
}else
{
	$pagingcost = number_format(0,2);
	$pagingcost1 = (0 * $row['pagingprice100']);
	$pagerbaseqty = 0;
}	
/*****************************************************RELAYS*******************************************************/
$relaycost = number_format($relaycount * $row['relayprice'],2);
$relaycost1 = ($relaycount * $row['relayprice']);
/**********************************************************************************************************************************
																											DISPLAY START
**********************************************************************************************************************************/
if((isset($_GET['view'])) && ($_GET['view'] == 'getquote'))
{
	include 'header.php';	$f_id = $_GET['f_id'];
	include 'includes/config.php';
	include 'includes/opendb.php';
	mysql_select_db('testwork');
	$query22 = "SELECT * FROM tblinstallinfo WHERE FacilityID = '$f_id'";
	$result22 = mysql_query($query22) or die(mysql_error());
	$count22 = mysql_num_rows($result22);
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width="750">
<?php
			if(isset($_GET['dup']))
			{
				$usedname = $_GET['dup'];
				$hfq = $_GET['hfq'];
?>
				<tr>
					<td class="heading" colspan="2"><font color="#ff0000">
						<?php echo $usedname.' already has HFQ'.$hfq; ?>
					</font></td>
				</tr>
<?php				
			}
			if($count22 > 0)
			{
?>
				<tr>
					<td>
						Existing quotes for this customer:
					</td>
				</tr>				
<?php				
				while($row22 = mysql_fetch_array($result22))
				{	
?>
					<tr>
						<td>
							<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?f_id='. $row22['FacilityID'].'&hfq='.$row22['hfq'].'&savequote=Continue">'. $row22['hfq'] .' </a>'. '&nbsp;&nbsp;'. $row22['name'] .'</td>' . '<td width="22"><a href="installquote.php?action=DELETE&f_id='. $f_id.'&HFQ=' . $row22['hfq'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row22['hfq'].'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" /></a>'; ?>
						</td>
					</tr>
<?php
				}
			}
?>																
			<tr>
				<td class="heading" width="250">
					Enter Quote Number (HFQ):
				</td>
				<td>
					<input type="text" size="10" maxlength="10" name="hfq" value="0">
				</td>
			</tr>
  	  <tr>
 				<td>
 					<input type="submit" value="Continue" name="savequote">
 				</td>
			</tr>
		</table>			
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';			
?>		
	</form>
<?php		
}
if((isset($_GET['savequote'])) && ($_GET['savequote'] == 'Continue'))
{
	$hfq = $_GET['hfq'];
	$f_id = $_GET['f_id'];
	$query20 = "SELECT * FROM tblinstallinfo WHERE hfq = '$hfq'";
	$result20 = mysql_query($query20) or die(mysql_error());
	$count20 = mysql_num_rows($result20);
	$row20 = mysql_fetch_array($result20);
	include 'header.php';	
	if($count20 == 0 && $row20['FacilityID'] <> $f_id)
	{
?>
		<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<table width="750">
<?php				
				if($existinglights > 0 OR $homefreelights > 0)
				{
?>
	 		 	  <tr>
 			 	  	<td>
  			  		<br>
  			  	</td>
	  		  </tr>				
					<tr>
						<td class="bigheading" colspan="2">
							Pull Cord Spefication
						</td>
					</tr>
					<tr>
						<td class="heading" width="250">
							Pull Cord
						</td>
						<td>
							<input type="text" size="6" maxlength="6" name="pull" value="0">
						</td>
					</tr>
					<tr>
						<td class="heading">
							Pull Cord and Existing Lights
						</td>
						<td>
							<input type="text" size="6" maxlength="6" name="pullexisting" value="0">
						</td>
					</tr>		
					<tr>
						<td class="heading">
							Pull Cord with new lights and wiring
						</td>
						<td>
							<input type="text" size="6" maxlength="6" name="pullnew" value="0">
						</td>
					</tr>	
<?php
					if($pullw > 0)
					{
?>						
						<tr>
							<td class="heading" width="250">
								Pull Cord w/Activity
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pulla" value="0">
							</td>
						</tr>
						<tr>
							<td class="heading">
								Pull Cord w/Activity and Existing Lights
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pullaexisting" value="0">
							</td>
						</tr>		
						<tr>
							<td class="heading">
								Pull Cord w/Activity with new lights and wiring
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pullanew" value="0">
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
				}
				echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
				echo	'<input type = "hidden" name="hfq" value = "'.$hfq.'">';
?>
				<tr>
					<td class="heading">
						Add On? <input type="checkbox" name="addon" value="1">
					</td>		
				</tr>
  	  	<tr>
	  	  	<td class="heading">
  		  		HOMEFREE
  		  	</td>
	  	  </tr>
  		  <tr>
  		  	<td class="body">
  	  			Remote testing and tuning
  	  		</td>
	  	  	<td>
  		  		<input type="text" size="1" maxlength="1" name="remote" value="0">
  		  	</td>
  	  	</tr>
	  	  <tr>
  		  	<td>
  		  		<br>
  	  		</td>
	  	  </tr>
  		  <tr>
  		  	<td class="heading">
  	  			TRAINING
  	  		</td>
	  	  </tr> 	  
  		  <tr>
  		  	<td class="body">
  	  			Training by Installer
	  	  	</td>
  		  	<td>
  		  		<input type="text" size="1" maxlength="1" name="installertraining" value="0">
 		 	  	</td>
	  	  </tr>  	 
  		  <tr>
  		  	<td class="body">
  	  			Training by Homefree
	  	  	</td>
  		  	<td>
  		  		<input type="text" size="1" maxlength="1" name="homefreetraining" value="0">
  	  		</td>
	  	  </tr>  
  		  <tr>
  		  	<td>
  		 	 		<br>
	  	  	</td>
  		  </tr>
  		  <tr>
  	  		<td class="heading">
	  	  		SERVICE CALL
  		  	</td>
  		  </tr> 	  
  	  	<tr>
 		 	  	<td class="body">
	  	  		Service Call per day
  		  	</td>
  		  	<td>
  	  			<input type="text" size="1" maxlength="1" name="perday" value="0">
	  	  	</td>
  		  </tr>  	 
  		  <tr>
  	  		<td class="body">
	  	  		Travel Exp. EST
  		  	</td>
  		  	<td>
  	  			<input type="text" size="1" maxlength="1" name="est" value="0">
	  	  	</td>
  		  </tr>  	   	
  		  <tr>
  	  		<td class="body">
	  	  		Travel Exp. CST
  		  	</td>
  		  	<td>
  	  			<input type="text" size="1" maxlength="1" name="cst" value="0">
	  	  	</td>
  		  </tr>  	 
  		  <tr>
  	  		<td class="body">
	  	  		Travel Exp. MNT
  		  	</td>
  		  	<td>
  	  			<input type="text" size="1" maxlength="1" name="mnt" value="0">
	  	  	</td>
  		  </tr>    
  		  <tr>
  	  		<td class="body">
  	  			Travel Exp. PST
	  	  	</td>
  		  	<td>
  		  		<input type="text" size="1" maxlength="1" name="pst" value="0">
  	  		</td>
	  	  </tr>
  		  <tr>
  		  	<td>
  	  			<br>
  	  		</td>
	  	  </tr>
  		  <tr>
  		  	<td class="heading">
  	  			Misc.
  	  		</td>
	  	  </tr>
	  	  <tr>
	  	  	<td class="body">
	  	  		Misc. Item Description
	  	  	</td>
	  	  	<td>
	  	  		<input type="text" size="50" maxlength="50" name="misc1des" value="">
	  	  	</td>
	  	  	<td class="body">
	  	  		Quantity
	  	  	</td>
	  	  	<td>
	  	  		<input type="text" size="4" maxlength="4" name="misc1qty" value="0">
	  	  	</td>
	  	  	<td class="body">
	  	  		Price
	  	  	</td>
	  	  	<td>
	  	  		<input type="text" size="8" maxlength="8" name="misc1price" value="0">
	  	  	</td>
	  	  </tr>
  		  <tr>
  		  	<td>
  	  			<br>
  	  		</td>
	  	  </tr>
  		  <tr>
  		  	<td class="heading">
  	  			REMARKS
  	  		</td>
	  	  </tr> 	  
  		  <tr>
  		  	<td class="body">
  	  			<textarea rows="8" cols="40" name="remarks"></textarea>
	  	  	</td>
  		  </tr>   	     	  	     
  		  <tr>
 					<td>
 						<input type="submit" value="Continue" name="savepc">
	 				</td>
				</tr>					
			</table>
		</form>
<?php	
	}else
	{
		if($f_id == $row20['FacilityID'])
		{
?>
			<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<table width="750">
<?php				
					if($existinglights > 0 OR $homefreelights > 0)
					{
?>
	 			 	  <tr>
 				 	  	<td>
  				  		<br>
  			  		</td>
		  		  </tr>				
					<tr>
							<td class="bigheading" colspan="2">
								Pull Cord Spefication
							</td>
						</tr>
						<tr>
							<td class="heading" width="250">
								Pull Cord
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pull" value="<?php echo $row20['pccount']; ?>">
							</td>
						</tr>
						<tr>
							<td class="heading">
								Pull Cord and Existing Lights
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pullexisting" value="<?php echo $row20['pcexlightcount']; ?>">
							</td>
						</tr>		
						<tr>
							<td class="heading">
								Pull Cord with new lights and wiring
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pullnew" value="<?php echo $row20['pcnewlightcount']; ?>">
							</td>
						</tr>	
<?php
					if($pullw > 0)
					{
?>						
						<tr>
							<td class="heading" width="250">
								Pull Cord w/Activity
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pulla" value="<?php echo $row20['activitycount']; ?>">
							</td>
						</tr>
						<tr>
							<td class="heading">
								Pull Cord w/Activity and Existing Lights
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pullaexisting" value="<?php echo $row20['activityexcount']; ?>">
							</td>
						</tr>		
						<tr>
							<td class="heading">
								Pull Cord w/Activity with new lights and wiring
							</td>
							<td>
								<input type="text" size="6" maxlength="6" name="pullanew" value="<?php echo $row20['activitynewcount']; ?>">
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
					}
					echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
					echo	'<input type = "hidden" name="hfq" value = "'.$hfq.'">';
?>
					<tr>
						<td class="heading">
							Add On? <input type="checkbox" name="addon" value="1" <?php if($row20['addon']==1){ echo 'CHECKED'; }?>>
						</td>
					</tr>
	  	  	<tr>
		  	  	<td class="heading">
  			  		HOMEFREE
  			  	</td>
	  	  	</tr>
	  		  <tr>
  			  	<td class="body">
  		  			Remote testing and tuning
  	  			</td>
	  	  		<td>
	  		  		<input type="text" size="1" maxlength="1" name="remote" value="<?php echo $row20['remote']; ?>">
  			  	</td>
  		  	</tr>
	  		  <tr>
	  		  	<td>
  			  		<br>
  		  		</td>
	  		  </tr>
	  		  <tr>
  			  	<td class="heading">
  		  			TRAINING
  	  			</td>
		  	  </tr> 	  
  			  <tr>
  			  	<td class="body">
  	  				Training by Installer
	  	  		</td>
	  		  	<td>
  			  		<input type="text" size="1" maxlength="1" name="installertraining" value="<?php echo $row20['installer']; ?>">
 			 	  	</td>
	  		  </tr>  	 
  		  	<tr>
	  		  	<td class="body">
  		  			Training by Homefree
	  		  	</td>
  			  	<td>
  		  			<input type="text" size="1" maxlength="1" name="homefreetraining" value="<?php echo $row20['homefree']; ?>">
	  	  		</td>
		  	  </tr>  
  			  <tr>
  			  	<td>
  		 		 		<br>
	  	  		</td>
	  		  </tr>
  			  <tr>
  		  		<td class="heading">
	  		  		SERVICE CALL
  		  		</td>
	  		  </tr> 	  
  		  	<tr>
 			 	  	<td class="body">
	  		  		Service Call per day
  		  		</td>
  		  		<td>
	  	  			<input type="text" size="1" maxlength="1" name="perday" value="<?php echo $row20['perday']; ?>">
		  	  	</td>
  			  </tr>  	 
  			  <tr>
  	  			<td class="body">
	  	  			Travel Exp. EST
	  		  	</td>
  			  	<td>
  		  			<input type="text" size="1" maxlength="1" name="est" value="<?php echo $row20['est']; ?>">
	  		  	</td>
  		  	</tr>  	   	
	  		  <tr>
  		  		<td class="body">
	  		  		Travel Exp. CST
  			  	</td>
  		  		<td>
  	  				<input type="text" size="1" maxlength="1" name="cst" value="<?php echo $row20['cst']; ?>">
		  	  	</td>
  			  </tr>  	 
  			  <tr>
  	  			<td class="body">
	  	  			Travel Exp. MNT
  			  	</td>
	  		  	<td>
  		  			<input type="text" size="1" maxlength="1" name="mnt" value="<?php echo $row20['mnt']; ?>">
		  	  	</td>
  			  </tr>    
  			  <tr>
  	  			<td class="body">
  	  				Travel Exp. PST
		  	  	</td>
  			  	<td>
  			  		<input type="text" size="1" maxlength="1" name="pst" value="<?php echo $row20['pst']; ?>">
  	  			</td>
	  	  	</tr>
	  	  	<tr>
	  	  		<td>
	  	  			<br>
	  	  		</td>
	  	  	</tr>
	  		  <tr>
	  		  	<td class="heading">
	  	  			Misc.
	  	  		</td>
		  	  </tr>	  	  	
		  	  <tr>
		  	  	<td class="body">
		  	  		Misc. Item Description
		  	  	</td>
		  	  	<td>
		  	  		<input type="text" size="50" maxlength="50" name="misc1des" value="<?php echo $row20['misc1des']; ?>">
		  	  	</td>
		  	  	<td class="body">
		  	  		Quantity
		  	  	</td>
		  	  	<td>
		  	  		<input type="text" size="4" maxlength="4" name="misc1qty" value="<?php echo $row20['misc1qty']; ?>">
		  	  	</td>
		  	  	<td class="body">
		  	  		Price
		  	  	</td>
		  	  	<td>
		  	  		<input type="text" size="8" maxlength="8" name="misc1price" value="<?php echo $row20['misc1price']; ?>">
		  	  	</td>
		  	  </tr>	  	  	
	  		  <tr>
  			  	<td>
  		  			<br>
  	  			</td>
		  	  </tr>
  			  <tr>
  			  	<td class="heading">
  	  				REMARKS
  	  			</td>
		  	  </tr> 	  
  			  <tr>
  			  	<td class="body">
  	  				<textarea rows="8" cols="40" name="remarks"><?php echo strip_tags($row20['remarks']); ?></textarea>
	  	  		</td>
	  		  </tr>   	     	  	     
  			  <tr>
 						<td>
 							<input type="submit" value="Continue" name="updatequote">
	 					</td>
					</tr>					
				</table>
			</form>		
<?php	
		}else
		{
			include 'includes/config.php';
			include 'includes/opendb.php';
			mysql_select_db('testwork');
			$query24 = "SELECT FacilityID FROM tblinstallinfo WHERE hfq = '$hfq'";
			$result24 = mysql_query($query24) or die(mysql_error());
			$row24 = mysql_fetch_array($result24);
			$used = $row24['FacilityID'];
			$query25 = "SELECT FacilityName FROM tblfacilitygeneralinfo WHERE ID = '$used'";
			$result25 = mysql_query($query25) or die(mysql_error());
			$row25 = mysql_fetch_array($result25);
			$dup = $row25['FacilityName'];
			header("Location: installquote.php?view=getquote&f_id=$f_id&dup=$dup&hfq=$hfq");
		}
	}
}
if((isset($_GET['savepc'])) && ($_GET['savepc'] == 'Continue'))
{
	$quotenum = $_GET['hfq'];
	if((isset($_GET['addon'])) && ($_GET['addon'] == 1))
	{
		$addon = 1;
	}else
	{
		$addon = 0;
	}
	$f_id = $_GET['f_id'];
	$remote = $_GET['remote'];
	$installertraining = $_GET['installertraining'];
	$homefreetraining = $_GET['homefreetraining'];
	$perday = $_GET['perday'];
	$est = $_GET['est'];
	$cst = $_GET['cst'];
	$mnt = $_GET['mnt'];
	$pst = $_GET['pst'];
	$remarks = nl2br(addslashes($_GET['remarks']));
	if(isset($_GET['pull']))
	{
		$pullc = $_GET['pull'];
		$pullex = $_GET['pullexisting'];
		$pullnew = $_GET['pullnew'];
	}else
	{
		$pullc = 0;
		$pullex = 0;
		$pullnew = 0;
	}	
	if(isset($_GET['pulla']))
	{	
		$pulla = $_GET['pulla'];
		$pullaex = $_GET['pullaexisting'];
		$pullanew = $_GET['pullanew'];
	}else
	{
		$pulla = 0;
		$pullaex = 0;
		$pullanew = 0;
	}			
	$misc1des = $_GET['misc1des'];
	$misc1qty = $_GET['misc1qty'];
	$misc1price = $_GET['misc1price'];
	$query19 = "INSERT INTO tblinstallinfo (hfq, addon,FacilityID, remote, perday, installer, homefree, est, cst, mnt, pst, remarks,pccount,pcexlightcount,
							pcnewlightcount, activitycount, activityexcount,activitynewcount,misc1des,misc1qty,misc1price) VALUES ('$quotenum','$addon','$f_id', '$remote', '$perday', '$installertraining', 
							'$homefreetraining', '$est', '$cst', '$mnt', '$pst','$remarks', '$pullc', '$pullex', '$pullnew', '$pulla', '$pullaex', '$pullanew','$misc1des','$misc1qty','$misc1price')";
	mysql_query($query19) or die(mysql_error());
	header("Location: installquote.php?view=final&f_id=$f_id&hfq=$quotenum");
}
if((isset($_GET['updatequote'])) && ($_GET['updatequote'] == 'Continue'))
{
	$quotenum = $_GET['hfq'];
	if((isset($_GET['addon'])) && ($_GET['addon'] == 1))
	{
		$addon = 1;
	}else
	{
		$addon = 0;
	}	
	$f_id = $_GET['f_id'];
	$remote = $_GET['remote'];
	$installertraining = $_GET['installertraining'];
	$homefreetraining = $_GET['homefreetraining'];
	$perday = $_GET['perday'];
	$est = $_GET['est'];
	$cst = $_GET['cst'];
	$mnt = $_GET['mnt'];
	$pst = $_GET['pst'];
	$remarks = nl2br(addslashes($_GET['remarks']));
	if(isset($_GET['pull']))
	{
		$pullc = $_GET['pull'];
		$pullex = $_GET['pullexisting'];
		$pullnew = $_GET['pullnew'];
	}else
	{
		$pullc = 0;
		$pullex = 0;
		$pullnew = 0;
	}	
	if(isset($_GET['pulla']))
	{	
		$pulla = $_GET['pulla'];
		$pullaex = $_GET['pullaexisting'];
		$pullanew = $_GET['pullanew'];
	}else
	{
		$pulla = 0;
		$pullaex = 0;
		$pullanew = 0;
	}		
	$misc1des = $_GET['misc1des'];
	$misc1qty = $_GET['misc1qty'];
	$misc1price = $_GET['misc1price'];		
	$query19 = "UPDATE tblinstallinfo SET addon = '$addon',remote = '$remote', perday = '$perday', installer = '$installertraining', homefree = '$homefreetraining',
							est = '$est', cst = '$cst', mnt = '$mnt', pst = '$pst', remarks = '$remarks', pccount = '$pullc', activitycount = '$pulla',
							activityexcount = '$pullaex', activitynewcount = '$pullanew', pcexlightcount = '$pullex',	pcnewlightcount = '$pullnew', 
							misc1des = '$misc1des', misc1qty = '$misc1qty',misc1price = '$misc1price' WHERE hfq = '$quotenum'";
	mysql_query($query19) or die(mysql_error());
	header("Location: installquote.php?view=final&f_id=$f_id&hfq=$quotenum");
}
if((isset($_GET['view'])) && ($_GET['view'] == 'final'))
{
	include 'installheader.php';
	mysql_select_db('testwork');
	$hfq = $_GET['hfq'];
	$f_id = $_GET['f_id'];
	$query21 = "SELECT * FROM tblinstallinfo WHERE hfq = '$hfq'";
	$result21 = mysql_query($query21) or die(mysql_error());
	$row21 = mysql_fetch_array($result21);		
	$email = $_SESSION['mail'];
	mysql_select_db('testhomefree');
	$query27 = "SELECT f_name,l_name FROM employees WHERE email = '$email'";
	$result27 = mysql_query($query27) or die(mysql_error());
	$row27 = mysql_fetch_array($result27);		
	if($existinglights == 0 && $homefreelights == 0)
	{
		$pccosta = number_format($pccosta = 0,2);
		$pccostb = number_format($pccostb = 0,2);
		$pccosta1 = 0;
		$pccostb1 = 0;		
		$pccounta = 0;
		$pccountb = 0;	
		$activitycost = $activitycost;	
		$activitycount = $activitycount;
		$activitycountex = 0;
		$activitycountnew = 0;	
		$activitycostex = 0;
		$activitycostnew = 0;		
	}else
	{
		$pccount = $row21['pccount'];
		$activitycount = $row21['activitycount'];
		$activitycountex = $row21['activityexcount'];
		$activitycountnew = $row21['activitynewcount'];
		$activitycost = ($row21['activitycount'] * $row['activityprice']);
		$activitycostex = ($row21['activityexcount'] * $row['activitypriceex']);
		$activitycostnew = ($row21['activitynewcount'] * $row['activitypricenew']);
		$pccounta = $row21['pcexlightcount'];
		$pccountb = $row21['pcnewlightcount'];
		$pccost = number_format($pccount * $row['pcprice'],2);
		$pccost1 = ($pccount * $row['pcprice']);
		$activitycost = $activitycount * $row['activityprice'];
		$pccosta = number_format($pccounta * $row['pcexlightprice'],2);
		$pccosta1 = ($pccounta * $row['pcexlightprice']);		
		$pccostb = number_format($pccountb * $row['pcnewlightprice'],2);
		$pccostb1 = ($pccountb * $row['pcnewlightprice']);		
	}	
	if($row21['addon'] == 1)
	{
		$servercost = number_format(0 * $row['sybase'],2);
		$servercost1 = (0 * $row['sybase']);
		$servertype = '';
		$clienttype = '';
		$computerqty = 0;
	}		
	$hardwarecost = ($servercost1 + $baseunitcost + $wmucost1 + $wmducost1 + $owmucost1 + $owmducost1 + $sowmucost1 + $minicost1 + $zbracketcost1 + 
									$outdoorzcost + $existingcost1 + $keypadcost1 + $pushbuttoncost1 + $reedcost1 +	$oreedcost1 + $utcost1 + $powerutcost1 + $pircost1 +
									$pccost1 + $activitycost + $activitycostex + $activitycostnew +  $pccosta1 + $pccostb1 + $callcordcost + $timercost1 + $pwcost + 
									$callcost1 + $fallcost1 + $cpscost1 + $cpswirecost1 +	$clientcost1 + $pagingcost1 + $relaycost1);
/*****************************************************MATH FROM INTRO PAGE*******************************************************/
	$quotenum = $row21['hfq'];
	$remote = $row21['remote'];
	$installertraining = $row21['installer'];
	$homefreetraining = $row21['homefree'];
	$perday = $row21['perday'];
	$perdaydisplay = $row21['perday'];
	$est = $row21['est'];
	$cst = $row21['cst'];
	$mnt = $row21['mnt'];
	$pst = $row21['pst'];
	$remarks = stripslashes($row21['remarks']);		
	$remotecost = $remote * $row['remote'];
	$installertrainingcost = $installertraining * $row['installer'];
	$homefreetrainingcost = $homefreetraining * $row['homefree'];
	if($perday > 1)
	{
		$servicecall = ($perday - 1);
		$perday = 1;
	}else
	{
		$servicecall = 0;
	}
	$perdaycost = (($perday * $row['perday']) + ($servicecall * $row['additionaldays']));
	$estcost = $est * $row['est'];
	$cstcost = $cst * $row['cst'];
	$mntcost = $mnt * $row['mnt'];
	$pstcost = $pst * $row['pst'];
	$misccost = $row21['misc1qty'] * $row21['misc1price']; 
	$totaltraining = ($remotecost + $installertrainingcost + $homefreetrainingcost + $perdaycost + $estcost + $cstcost + $mntcost + $pstcost + $misccost);
	$installtotal = $hardwarecost + $totaltraining;
/*****************************************************DISPLAY*******************************************************/
?>
	<table width="750" align="center">
		<tr>
			<td>
				<img src="../images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems">
			</td>
			<td class="heading">
				Quote Number: <?php echo 'HFQ'.$quotenum; ?>
			</td>
		</tr>
	</table>
	<table width="750" align="center" border="0">
		<tr>
			<td>
<?php
				if(!isset($_GET['print']))
				{
?>									
					<a href="javascript:void(0)"onclick="window.open('<?php echo $_SERVER['PHP_SELF'].'?f_id='.$f_id.'&hfq='.$hfq.'&view=final&print=print'; ?>')">Print View</a>
<?php
				}else
				{
?>					
					<br>
<?php			
				}										
?>									
			</td>
		</tr>
		<tr>
			<td class="bigheading" align="center" colspan="3">
				Install Quote
			</td>
		</tr>
		<tr>
			<td>
				<table width="750">
					<tr>
						<td class="heading" width="120">
							Facility:
						</td>
						<td class="body">
							<?php echo $row17['FacilityName'].' '.$extname; ?>
						</td>
					</tr>		
					<tr>
						<td class="heading">
							Location:
						</td>
						<td class="body">
							<?php echo $row17['City'].', '.$row17['StateOrProvinceCode']; ?>
						</td>
					</tr>	
					<tr>
						<td>
							<br>
						</td>
					</tr>		
					<tr>
						<td class="heading" width="120">
							Date:
						</td>
						<td class="body">
							<?php echo $date; ?>
						</td>
					</tr>		
					<tr>
						<td class="heading">
							Sales Rep:
						</td>
						<td class="body">
							<?php echo $salesman; ?>
						</td>
					</tr>	
					<tr>
						<td>
							<br>
						</td>
					</tr>		
				</table>
			</td>
		</tr>
	</table>
	<table align="center" width="759" border="0">
		<tr>
			<td valign="top" width="350">
				<table cellpadding="2">		
					<tr>
						<td class="heading" width="200">
							HARDWARE
						</td>
					</tr>				
					<tr>
<?php
						if($computerqty <> 0)
						{
							if($servertype == 'access')
							{
?>											
								<td class="body">
									Computer
								</td>
<?php
							}else
							{
?>
								<td class="body">
									Server
								</td>
<?php
							}
?>																																	
							<td width="25" class="body">
								<?php echo $computerqty; ?>
							</td>
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.$servercost; ?>
								</td>
<?php	
							}
						}
?>						
					</tr>
<?php
					if($baseunitnet <> 0)
					{
?>										
						<tr>
							<td class="body">
								Base Units
							</td>
							<td class="body">
								<?php echo $baseunitnet; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.number_format($baseunitcost,2); ?>
								</td>
<?php
							}
?>						
						</tr>
<?php
					}
					if($wmu <> 0)
					{
?>																	
						<tr>
							<td class="body">
								WMU
							</td>
							<td class="body">
								<?php echo $wmu; ?>
							</td>
<?php
							if(!isset($_GET['print']))
							{
?>							
								<td class="body">
									<?php echo '$'.$wmucost; ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($wmducount <> 0)
					{
?>												
						<tr>
							<td class="body">
								WMDU
							</td>
							<td class="body">
								<?php echo $wmducount; ?>
							</td>		
	<?php
							if(!isset($_GET['print']))
							{
	?>											
								<td class="body">
									<?php echo '$'.$wmducost; ?>
								</td>	
	<?php
							}
	?>											
						</tr>		
<?php
					}
					if($owmu <> 0)
					{
?>											
						<tr>
							<td class="body">
								Outdoor WMU
							</td>
							<td class="body">
								<?php echo $owmu; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.$owmucost; ?>
								</td>
<?php
							}
?>								
						</tr>		
<?php
					}
					if($owmducount <> 0)
					{
?>						
						<tr>
							<td class="body">
								Outdoor WMDU
							</td>
							<td class="body">
								<?php echo $owmducount; ?>
							</td>
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.$owmducost; ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($sowmu <> 0)
					{
?>						
						<tr>
							<td class="body">
								Outdoor WMU w/ Solar
							</td>
							<td class="body">
								<?php echo $sowmu; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>														
								<td class="body">
									<?php echo '$'.$sowmucost; ?>
								</td>
<?php
							}
?>						
						</tr>	
<?php
					}
					if($minicount <> 0)
					{
?>							
						<tr>
							<td class="body">
								Mini Lock
							</td>
							<td class="body">
								<?php echo $minicount; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.$minicost; ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($zbracketcount <> 0)
					{
?>							
						<tr>
							<td class="body">
								Z Bracket Lock
							</td>
							<td class="body">
								<?php echo $zbracketcount; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.$zbracketcost; ?>
								</td>
<?php
							}
?>							
						</tr>
<?php
					}
					if($ozbracketcount <> 0)
					{
?>								
						<tr>
							<td class="body">
								Outdoor Lock
							</td>
							<td class="body">
								<?php echo $ozbracketcount; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.number_format($outdoorzcost,2); ?>
								</td>
<?php
							}
?>						
						</tr>		
<?php
					}
					if($a <> 0)
					{
?>												
						<tr>
							<td class="body">
								Tieing to existing Lock
							</td>
							<td class="body">
								<?php echo $a; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.$existingcost; ?>
								</td>
<?php
							}
?>							
						</tr>
<?php
					}
					if($keypadcount <> 0)
					{
?>								
						<tr>
							<td class="body">
								Keypad
							</td>
							<td class="body">
								<?php echo $keypadcount; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.$keypadcost; ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($pushbuttoncount <> 0)
					{
?>								
						<tr>
							<td class="body">
								Door Push Button
							</td>
							<td class="body">
								<?php echo $pushbuttoncount; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.$pushbuttoncost; ?>
								</td>
<?php
							}
?>						
						</tr>
<?php
					}
					if($reedcount <> 0)
					{
?>											
						<tr>
							<td class="body">
								Reed Switch
							</td>
							<td class="body">
								<?php echo $reedcount; ?>
							</td>		
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.$reedcost; ?>
								</td>
<?php
							}
?>						
						</tr>	
<?php
					}
					if($oreedcount <> 0)
					{
?>								
						<tr>
							<td class="body">
								Out Door Reed Switch
							</td>
							<td class="body">
								<?php echo $oreedcount; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.$oreedcost; ?>
								</td>
<?php
							}
?>						
						</tr>	
<?php
					}
					if($utcount2 <> 0)
					{
?>								
						<tr>
							<td class="body">
								UT
							</td>
							<td class="body">
								<?php echo $utcount2; ?>
							</td>	
	<?php
							if(!isset($_GET['print']))
							{
	?>													
								<td class="body">
									<?php echo '$'.$utcost; ?>
								</td>
<?php
							}
?>								
						</tr>
<?php
					}
					if($powerutcount2 <> 0)
					{
?>									
						<tr>
							<td class="body">
								UT / Power
							</td>
							<td class="body">
								<?php echo $powerutcount2; ?>
							</td>		
<?php
							if(!isset($_GET['print']))
							{
?>											
								<td class="body">
									<?php echo '$'.$powerutcost; ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($pircount <> 0)
					{
?>												
						<tr>
							<td class="body">
								PIR
							</td>
							<td class="body">
								<?php echo $pircount; ?>
							</td>				
<?php
							if(!isset($_GET['print']))
							{
?>										
								<td class="body">
									<?php echo '$'.$pircost; ?>
								</td>
<?php
							}
?>						
						</tr>	
<?php
					}
					if($pccount <> 0)
					{
?>								
						<tr>
							<td class="body">
								Pull cord
							</td>
							<td class="body">
								<?php echo $pccount; ?>
							</td>				
<?php
							if(!isset($_GET['print']))
							{
?>										
							<td class="body">
								<?php echo '$'.$pccost; ?>
							</td>
<?php
							}
?>						
						</tr>	
<?php
					}
					if($pccounta <> 0)
					{
?>												
						<tr>
							<td class="body">
								Pull cord + existing lights
							</td>
							<td class="body">
								<?php echo $pccounta; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>														
								<td class="body">
									<?php echo '$'.$pccosta; ?>
								</td>
<?php
							}
?>							
						</tr>		
<?php
					}
					if($pccountb <> 0)
					{
?>						
						<tr>
							<td class="body">
								Pull cord + new lights + wiring
							</td>
							<td class="body">
								<?php echo $pccountb ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>														
								<td class="body">
									<?php echo '$'.$pccostb; ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($activitycount <> 0)
					{
?>											
						<tr>
							<td class="body">
								Pull cord w/Activity
							</td>
							<td class="body">
								<?php echo $activitycount; ?>
							</td>				
<?php
							if(!isset($_GET['print']))
							{
?>										
							<td class="body">
								<?php echo '$'.number_format($activitycost,2); ?>
							</td>
<?php
							}
?>						
						</tr>	
<?php
					}
					if($activitycountex <> 0)
					{
?>									
						<tr>
							<td class="body">
								Pull cord w/Activity + Existing
							</td>
							<td class="body">
								<?php echo $activitycountex; ?>
							</td>				
<?php
							if(!isset($_GET['print']))
							{
?>										
							<td class="body">
								<?php echo '$'.number_format($activitycostex,2); ?>
							</td>
<?php
							}
?>						
						</tr>
<?php
					}
					if($activitycountnew <> 0)
					{
?>								
						<tr>
							<td class="body">
								Pull cord w/Activity + new lights + wiring
							</td>
							<td class="body">
								<?php echo $activitycountnew; ?>
							</td>				
<?php
							if(!isset($_GET['print']))
							{
?>										
							<td class="body">
								<?php echo '$'.number_format($activitycostnew,2); ?>
							</td>
<?php
							}
?>						
						</tr>		
<?php
					}
					if($callcordcount <> 0)
					{
?>																			
						<tr>
							<td class="body">
								Call Cords
							</td>
							<td class="body">
								<?php echo $callcordcount ?>
							</td>		
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.number_format($callcordcost,2); ?>
								</td>
<?php
							}
?>							
						</tr>		
<?php
					}
					if($timercount <> 0)
					{
?>														
						<tr>
							<td class="body">
								Timer
							</td>
							<td class="body">
								<?php echo $timercount; ?>
							</td>				
<?php
							if(!isset($_GET['print']))
							{
?>										
								<td class="body">
									<?php echo '$'.$timercost; ?>
								</td>
<?php
							}
?>						
						</tr>
<?php
					}
					if($pwcount <> 0)
					{
?>									
						<tr>
							<td class="body">
								Personal Watchers
							</td>
							<td class="body">
								<?php echo $pwcount; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.number_format($pwcost,2); ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($callbuttoncount <> 0)
					{
?>																
						<tr>
							<td class="body">
								Call button
							</td>
							<td class="body">
								<?php echo $callbuttoncount; ?>
							</td>		
<?php
							if(!isset($_GET['print']))
							{
?>											
								<td class="body">
									<?php echo '$'.$callcost; ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($fall <> 0)
					{
?>						
						<tr>
							<td class="body">
								Aware unit
							</td>
							<td class="body">
								<?php echo $fall; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.$fallcost; ?>
								</td>
<?php
							}
?>						
						</tr>		
<?php
					}
					if($power <> 0)
					{
?>						
						<tr>
							<td class="body">
								Central Power supply
							</td>
							<td class="body">
								<?php echo $power; ?>
							</td>
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.$cpscost; ?>
								</td>
<?php
							}
?>							
						</tr>
<?php
					}
					if($cpswire <> 0)
					{
?>											
						<tr>
							<td class="body">
								Wire for CPS
							</td>
							<td class="body">
								<?php echo $cpswire; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>											
								<td class="body">
									<?php echo '$'.$cpswirecost; ?>
								</td>
<?php
							}
?>									
						</tr>	
<?php
					}
					if($client <> 0)
					{
?>						
						<tr>
							<td class="body">
								Computer sub station
							</td>
							<td class="body">
								<?php echo $client; ?>
							</td>		
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.$clientcost; ?>
								</td>
<?php
							}
?>							
						</tr>		
<?php
					}
					if($pagerbaseqty <> 'NONE')
					{
?>							
						<tr>
							<td class="body">
								Commtech Paging Base
							</td>
							<td class="body">
								<?php echo $pagerbaseqty; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>														
								<td class="body">
									<?php echo '$'.$pagingcost; ?>
								</td>
<?php
							}
?>							
						</tr>		
<?php
					}
					if($relaycount <> 0)
					{
?>							
						<tr>
							<td class="body">
								Elevator Relays
							</td>
							<td class="body">
								<?php echo $relaycount; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>														
								<td class="body">
									<?php echo '$'.$relaycost; ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
?>							
					<tr>
						<td>
							<br>
						</td>
					</tr>																													
					<tr>
						<td class="heading">
							Total Hardware
						</td>
						<td>
						</td>
						<td class="body">
							<?php echo '$'.number_format($hardwarecost,2); ?>
						</td>
					</tr>		
				</table>
			</td>
			<td valign="top">
				<table border="0" width="324">
					<tr>
<?php
						if($remote <> 0)
						{
?>													
							<td class="heading" width="200">
								HOMEFREE
							</td>
						</tr>
						<tr>
							<td class="body">
								HomeFree Testing and Tuning
							</td>
							<td class="body" width="25">
								<?php echo $remote; ?>
							</td>		
<?php
							if(!isset($_GET['print']))
							{
?>											
								<td class="body">
									<?php echo '$'.number_format($remotecost,2); ?>
								</td>
<?php
							}
						}
?>						
					</tr>
					<tr>
						<td>
							<br>
						</td>
					</tr>
					<tr>
						<td class="heading">
							TRAINING
						</td>
					</tr>
					<tr>
						<td class="body">
							Training by Installer
						</td>
						<td class="body">
							<?php echo $installertraining; ?>
						</td>
<?php
						if(!isset($_GET['print']))
						{
?>													
							<td class="body">
								<?php echo '$'.number_format($installertrainingcost,2); ?>
							</td>
<?php
						}
?>							
					</tr>
					<tr>
						<td class="body">
							Training by HomeFree
						</td>
						<td class="body">
							<?php echo $homefreetraining; ?>
						</td>
<?php
						if(!isset($_GET['print']))
						{
?>														
							<td class="body">
								<?php echo '$'.number_format($homefreetrainingcost,2); ?>
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
						<td class="heading">
							SERVICE CALL
						</td>
					</tr>
<?php
					if($perdaydisplay <> 0)
					{
?>											
						<tr>
							<td class="body">
								Service Call per day
							</td>
							<td class="body">
								<?php echo $perdaydisplay; ?>
							</td>
<?php
							if(!isset($_GET['print']))
							{
?>														
								<td class="body">
									<?php echo '$'.number_format($perdaycost,2); ?>
								</td>
<?php
							}
?>							
						</tr>
<?php
					}
					if($est <> 0)
					{
?>						
						<tr>
							<td class="body">
								Travel Exp. EST
							</td>
							<td class="body">
								<?php echo $est; ?>
							</td>	
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.number_format($estcost,2); ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($cst <> 0)
					{
?>								
						<tr>
							<td class="body">
								Travel Exp. CST
							</td>
							<td class="body">
								<?php echo $cst; ?>
							</td>
<?php
							if(!isset($_GET['print']))
							{
?>															
								<td class="body">
									<?php echo '$'.number_format($cstcost,2); ?>
								</td>
<?php
							}
?>							
						</tr>
<?php
					}
					if($mnt <> 0)
					{
?>						
						<tr>
							<td class="body">
								Travel Exp. MNT
							</td>
							<td class="body">
								<?php echo $mnt; ?>
							</td>		
<?php
							if(!isset($_GET['print']))
							{
?>													
								<td class="body">
									<?php echo '$'.number_format($mntcost,2); ?>
								</td>
<?php
							}
?>							
						</tr>	
<?php
					}
					if($pst <> 0)
					{
?>							
						<tr>
							<td class="body">
								Travel Exp. PST
							</td>
							
								<td class="body">
									<?php echo $pst; ?>
								</td>								
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.number_format($pstcost,2); ?>
								</td>
<?php
							}
?>								
						</tr>	
<?php
					}
					if($row21['misc1qty'] <> 0)
					{
?>							
						<tr>
							<td class="body">
								Misc. Install
							</td>
							<td class="body">
								<?php echo $row21['misc1qty']; ?>
							</td>
<?php
							if(!isset($_GET['print']))
							{
?>												
								<td class="body">
									<?php echo '$'.number_format($misccost,2); ?>
								</td>
<?php
							}
?>	
						</tr>
<?php
					}	
?>									
					<tr>
						<td>
							<br>
						</td>
					</tr>		
					<tr>
						<td class="heading">
							TRAINING TOTAL
						</td>
						<td>
						</td>
						<td class="body" colspan="2">
							<?php echo '$'.number_format($totaltraining,2); ?>
						</td>						
					</tr>		
					<tr>
						<td class="heading" valign="top">
							REMARKS
						</td>
					</tr>
				</table>
				<table>
					<tr>		
						<td width="320">
							<?php echo $remarks; ?>
						</td>						
					</tr>	
					<tr>
						<td>
							<br>
						</td>
					</tr>		
				</table>
				<table>			
					<tr>
						<td colspan="2" class="body">
							Prepared by: <?php echo $row27['f_name'].' '.$row27['l_name']; ?>		
						</td>																	
					</tr>
					<tr>
						<td>
							<br>
						</td>
					</tr>					
					<tr>
						<td colspan="2">
							Signature: _______________________________
						</td>
					</tr>
					<tr>
						<td>
							<br>
						</td>
					</tr>					
					<tr>
						<td class="bigheading" valign="top">
							Installation Total
						</td>
						<td class="heading">
							<?php echo '$'.number_format($installtotal,2); ?>
						</td>						
					</tr>												
				</table>
			</td>
		</tr>
	</table>
	<table align="center" width="750" border="0">
		<tr>
			<td class="smallheading" align="center">
				Quote valid for 90 days
			</td>
		</tr>
		<tr>
			<td class="smallheading" align="center">
				*** Prices subject to change ***
			</td>
		</tr>
	</table>
<?php
	if(!isset($_GET['print']))
	{
?>		
		<table align="center" width="450">
			<tr>
				<td>
					<?php echo '<a href="' . 'newfinishedpage.php'.'?f_id='.$f_id.'">'?>Back to Scope</a>
				</td>
				<td>
					<?php echo '<a href="' . 'installquote.php'.'?f_id='.$f_id.'&hfq='.$hfq.'&savequote=Continue">'?>Update</a>
				</td>			
				<td>
					<?php echo '<a href="' . 'installquote.php'.'?f_id='.$f_id.'&view=getquote">'?>Search for HFQ</a>
				</td>	
<?php
				mysql_select_db('testwork');
				$query52 = "SELECT Cust_Num FROM tblfacilitygeneralinfo WHERE ID='$f_id'";
				$result52 = mysql_query($query52) or die (mysql_error());
				$row52 = mysql_fetch_array($result52);
				if($row52['Cust_Num'] <> 0)
				{
					mysql_select_db('testhomefree');
					$customernumber = $row52['Cust_Num'];
					$query53 = "SELECT CustomerNumber FROM tblfacilities WHERE CustomerNumber='$customernumber'";
					$result53 = mysql_query($query53) or die (mysql_error());
					$count53 = mysql_num_rows($result53);
					$row53 = mysql_fetch_array($result53);
					if($count53 == 0)
					{
?>					<td>
							<?php echo '<a href="' . 'installquote.php'.'?f_id='.$f_id.'&view=addtohomefree">'?>Schedule Install</a>
						</td>
<?php						
					}else
					{
						$f_id = $row53['CustomerNumber'];
?>
						<td>
							<?php echo '<a href="' . 'installquote.php'.'?f_id='.$f_id.'&view=schedule">'?>Schedule Install</a>
						</td>
<?php						
					}
				}else
				{
?>						
					<td>
						<?php echo '<a href="' . 'installquote.php'.'?f_id='.$row52['Cust_Num'].'&view=schedule">'?>Schedule Install</a>
					</td>
<?php
				}						
?>						
							
			</tr>
		</table>
<?php		
	}	
}
if((isset($_GET['view'])) && ($_GET['view'] == 'installprices'))
{
	include 'header.php';
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width="750">
			<tr>
				<td class="mediumheading"><font color="#ff0000">
<?php			
					if((isset($_GET['save'])) && ($_GET['save'] == 'save'))
					{
						echo 'Changes Saved';
					}	
?>			
				</font></td>
			</tr>
			<tr>
				<td class="bigheading" colspan="2" align="center">
					Install Price List
				</td>
			</tr>
			<table width="750" border="0">
				<tr>
					<td width="50%">
						<table border="0">
							<tr>
								<td class="mediumheading" width="70%"><u>
									Hardware
								</u></td>
							<tr>
								<td class="heading">
									Computer
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pc" value="<?php echo $row['pc']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Server
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="sybase" value="<?php echo $row['sybase']; ?>">
								</td>
							</tr>		
							<tr>
								<td class="heading">
									Base Units
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="base" value="<?php echo $row['wmbuprice']; ?>">
								</td>
							</tr>							
							<tr>
								<td class="heading">
									WMU's
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="wmu" value="<?php echo $row['wmuprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Outdoor WMU's
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="owmu" value="<?php echo $row['owmuprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Solar Outdoor WMU's
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="sowmu" value="<?php echo $row['sowmuprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Door Units
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="wmdu" value="<?php echo $row['wmduprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Outdoor Door Units
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="owmdu" value="<?php echo $row['owmduprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Minilocks
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="minilock" value="<?php echo $row['minilockprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Z Bracket Locks
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="zbracket" value="<?php echo $row['zbracketprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Outdoor Locks
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="outdoor" value="<?php echo $row['outdoorlock']; ?>">
								</td>
							</tr>							
							<tr>
								<td class="heading">
									Tying into Existing Locks
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="existinglock" value="<?php echo $row['existingprice']; ?>">
								</td>
							</tr>						
							<tr>
								<td class="heading">
									Keypads
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="keypad" value="<?php echo $row['keypadprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Push Button
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pushbutton" value="<?php echo $row['pushbuttonprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Reed Switch
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="reed" value="<?php echo $row['reedprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Outdoor Reed Switch
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="oreed" value="<?php echo $row['oreedprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									UT
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="ut" value="<?php echo $row['utprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									UT w/power
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="powerut" value="<?php echo $row['powerutprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									PIR
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pir" value="<?php echo $row['pirprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Pull Cord
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pullcord" value="<?php echo $row['pcprice']; ?>">
								</td>
							</tr>						
							<tr>
								<td class="heading">
									Pull Cord + Existing Light
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="expullcord" value="<?php echo $row['pcexlightprice']; ?>">
								</td>
							</tr>						
							<tr>
								<td class="heading">
									Pull Cord + New Light + Wiring
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="newpullcord" value="<?php echo $row['pcnewlightprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Pull Cord w/activity 
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pullcorda" value="<?php echo $row['activityprice']; ?>">
								</td>
							</tr>	
							<tr>
								<td class="heading">
									Pull Cord w/activity + Existing Light
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pullcordaex" value="<?php echo $row['activitypriceex']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Pull Cord w/activity + New Light + Wiring
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pullcordanew" value="<?php echo $row['activitypricenew']; ?>">
								</td>
							</tr>																						
							<tr>
								<td class="heading">
									Call Cords
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="callcord" value="<?php echo $row['callcordprice']; ?>">
								</td>
							</tr>								
							<tr>
								<td class="heading">
									Timer
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="timer" value="<?php echo $row['timerprice']; ?>">
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<table>
							<tr>
								<td class="mediumheading"><u>
									Hardware con't
								</u></td>
							</tr>
							<tr>
								<td class="heading">
									PW
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pw" value="<?php echo $row['pwprice']; ?>">
								</td>
							</tr>							
							<tr>
								<td class="heading">
									Call Button + Pull Tags
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="callbutton" value="<?php echo $row['callbuttonprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Aware Units
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="fdu" value="<?php echo $row['fduprice']; ?>">
								</td>
							</tr>							
							<tr>
								<td class="heading">
									Central Power Supplies
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="cps" value="<?php echo $row['cpsprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Wire Central Power
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="cpswire" value="<?php echo $row['cpswireprice']; ?>">
								</td>
							</tr>							
							<tr>
								<td class="heading">
									Client Computer
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="client" value="<?php echo $row['clientprice']; ?>">
								</td>
							</tr>		
							<tr>
								<td class="heading">
									Sybase Client Computer
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="sybaseclient" value="<?php echo $row['sybaseclientprice']; ?>">
								</td>
							</tr>												
							<tr>
								<td class="heading">
									Commtech 5W
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="5w" value="<?php echo $row['pagingprice']; ?>">
								</td>
							</tr>				
							<tr>
								<td class="heading">
									Commtech 25W
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="25w" value="<?php echo $row['pagingprice25']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Commtech 50W
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="50w" value="<?php echo $row['pagingprice50']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Commtech 100W
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="100w" value="<?php echo $row['pagingprice100']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Relays
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="relays" value="<?php echo $row['relayprice']; ?>">
								</td>
							</tr>
							<tr>
								<td class="mediumheading"><u>
									Training And Service
								</u></td>
							</tr>							
							<tr>
								<td class="heading">
									Remote Testing and Tuning
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="remote" value="<?php echo $row['remote']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Installer Training
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="installer" value="<?php echo $row['installer']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Homefree Training
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="homefree" value="<?php echo $row['homefree']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Service Call - 1st Day
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="perday" value="<?php echo $row['perday']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									Service Call - Additional Days
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="additionaldays" value="<?php echo $row['additionaldays']; ?>">
								</td>
							</tr>							
							<tr>
								<td class="heading">
									EST
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="est" value="<?php echo $row['est']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									CST
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="cst" value="<?php echo $row['cst']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									MNT
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="mnt" value="<?php echo $row['mnt']; ?>">
								</td>
							</tr>
							<tr>
								<td class="heading">
									PST
								</td>
								<td>
									$<input type="text" size="8" maxlength="8" name="pst" value="<?php echo $row['pst']; ?>">
								</td>
							</tr>
 						  <tr>
 								<td>
 									<input type="submit" value="Continue" name="saveprice">
								</td>
							</tr>															
						</table>
					</td>
				</tr>
<?php
			echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';			
?>				
		</table>						
	</form>			
<?php
}
if((isset($_GET['saveprice'])) && ($_GET['saveprice'] == 'Continue'))
{
	$f_id = $_GET['f_id'];
	$pcprice = $_GET['pc'];
	$sybase = $_GET['sybase'];
	$wmbuprice = $_GET['base'];
	$wmuprice = $_GET['wmu'];
	$owmuprice = $_GET['owmu'];
	$sowmuprice = $_GET['sowmu'];
	$wmduprice = $_GET['wmdu'];
	$owmduprice = $_GET['owmdu'];
	$miniprice = $_GET['minilock'];	
	$zbracketprice = $_GET['zbracket'];
	$outdoorlockprice = $_GET['outdoor'];
	$existingprice = $_GET['existinglock'];
	$keypadprice = $_GET['keypad'];
	$pushbuttonprice = $_GET['pushbutton'];
	$reedprice = $_GET['reed'];	
	$oreedprice = $_GET['oreed'];
	$utprice = $_GET['ut'];
	$powerutprice = $_GET['powerut'];
	$pirprice = $_GET['pir'];		
	$pullcordprice = $_GET['pullcord'];	
	$expullcordprice = $_GET['expullcord'];
	$newpullcordprice = $_GET['newpullcord'];
	$pulla = $_GET['pullcorda'];
	$pullaex = $_GET['pullcordaex'];
	$pullanew = $_GET['pullcordanew'];	
	$callcordprice = $_GET['callcord'];
	$timerprice = $_GET['timer'];
	$pwprice = $_GET['pw'];
	$callbuttonprice = $_GET['callbutton'];		
	$fallunitprice = $_GET['fdu'];
	$cpsprice = $_GET['cps'];
	$cpswireprice = $_GET['cpswire'];
	$clientprice = $_GET['client'];
	$sybaseclientprice = $_GET['sybaseclient'];
	$pagingprice = $_GET['5w'];		
	$paging25price = $_GET['25w'];
	$paging50price = $_GET['50w'];
	$paging100price = $_GET['100w'];
	$relayprice = $_GET['relays'];
	$remoteprice = $_GET['remote'];
	$installerprice = $_GET['installer'];		
	$homefreeprice = $_GET['homefree'];
	$perdayprice = $_GET['perday'];
	$additionaldayprice = $_GET['additionaldays'];
	$estprice = $_GET['est'];
	$cstprice = $_GET['cst'];
	$mntprice = $_GET['mnt'];
	$pstprice = $_GET['pst'];				
	mysql_select_db('testwork');
	$query26 = "UPDATE tblinstallprices SET pc = '$pcprice', sybase = '$sybase', wmbuprice = '$wmbuprice', wmuprice = '$wmuprice', owmuprice = '$owmuprice',
							sowmuprice = '$sowmuprice',	wmduprice = '$wmduprice', owmduprice = '$owmduprice', minilockprice = '$miniprice', 
							zbracketprice = '$zbracketprice', outdoorlock = '$outdoorlockprice', existingprice = '$existingprice',	keypadprice = '$keypadprice',
							pushbuttonprice = '$pushbuttonprice', reedprice = '$reedprice', oreedprice = '$oreedprice', utprice = '$utprice',
							powerutprice = '$powerutprice', pirprice = '$pirprice', pcprice = '$pullcordprice', pcexlightprice = '$expullcordprice',
							pcnewlightprice = '$newpullcordprice', activityprice = '$pulla', activitypriceex = '$pullaex', activitypricenew = '$pullanew', 
							callcordprice = '$callcordprice', timerprice = '$timerprice', pwprice = '$pwprice', callbuttonprice = '$callbuttonprice', 
							fduprice = '$fallunitprice', cpsprice = '$cpsprice', cpswireprice = '$cpswireprice', clientprice = '$clientprice', 
							sybaseclientprice = '$sybaseclientprice', pagingprice = '$pagingprice', pagingprice25 = '$paging25price', pagingprice50 = '$paging50price',
							pagingprice100 = '$paging100price', relayprice = '$relayprice', remote = '$remoteprice', installer = '$installerprice', 
							homefree = '$homefreeprice', perday = '$perdayprice', additionaldays = '$additionaldayprice', est = '$estprice', cst = '$cstprice', 
							mnt = '$mntprice', pst = '$pstprice' WHERE ID = 1";
	mysql_query($query26) or die(mysql_error());		
	header("Location: installquote.php?view=installprices&save=save");
}	
if((isset($_GET['action'])) && ($_GET['action']=='UPDATESCH'))
{
	$id = $_GET['id'];
	$f_id = $_GET['f_id'];
	$query43 = "SELECT * FROM epc_calendar WHERE ID = '$id'";
	$result43 = mysql_query($query43) or die(mysql_error());
	$row43 = mysql_fetch_array($result43);
	$company = $row43['company'];
	$type = $row43['type'];
	$status = $row43['Status'];
	$startdate = date('m/d/Y',$row43['startDate']);
	$enddate = date('m/d/Y',$row43['endDate']);
	$query44 = "SELECT * FROM tblcompany WHERE ID = '$company'";
	$result44 = mysql_query($query44) or die(mysql_error());
	$row44 = mysql_fetch_array($result44);
	$query45 = "SELECT * FROM tblcompany WHERE ID <> '$company' AND Page = 2 AND active = 1";
	$result45 = mysql_query($query45) or die(mysql_error());
	$query46 = "SELECT * FROM tbltype WHERE ID = '$type'";
	$result46 = mysql_query($query46) or die(mysql_error());
	$row46 = mysql_fetch_array($result46);
	$query47 = "SELECT * FROM tbltype WHERE ID <> '$type' AND Page = 2";
	$result47 = mysql_query($query47) or die(mysql_error());
	$query48 = "SELECT * FROM tblstatus WHERE ID = '$status'";
	$result48 = mysql_query($query48) or die(mysql_error());
	$row48 = mysql_fetch_array($result48);	
	$query49 = "SELECT * FROM tblstatus WHERE ID <> '$status' AND Install = 1 ORDER BY Status DESC";
	$result49 = mysql_query($query49) or die(mysql_error());	
?>
	<form method="GET" name="example12" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td class="mediumheading">
					Title:
				</td>
				<td>
					<input type="text" size="100" maxlength="250" name="title" value="<?php echo $row43['title']; ?>">
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
					<table>
						<tr>
							<td class="mediumheading">
								Company:
							</td>
							<td>
								<select name="company">
									<option value = "<?php echo $row44['ID']; ?>"><?php echo $row44['Company']; ?></option>
			<?php						
								while($row45 = mysql_fetch_array($result45))
								{
			?>						
									<option value = "<?php echo $row45['ID']; ?>"><?php echo $row45['Company']; ?></option>
			<?php						
								}
			?>						
								</select>
							</td>
						</tr>			
						<tr>
							<td class="mediumheading">
								Type:
							</td>
							<td>
								<select name="type">
									<option value = "<?php echo $row46['ID']; ?>"><?php echo $row46['Type']; ?></option>
			<?php						
								while($row47 = mysql_fetch_array($result47))
								{
			?>						
									<option value = "<?php echo $row47['ID']; ?>"><?php echo $row47['Type']; ?></option>
			<?php						
								}
			?>						
								</select>
							</td>
						</tr>
						<tr>
							<td class="mediumheading">
								Status:
							</td>
							<td>
								<select name="status">
									<option value = "<?php echo $row48['ID']; ?>"><?php echo $row48['Status']; ?></option>
			<?php						
								while($row49 = mysql_fetch_array($result49))
								{
			?>						
									<option value = "<?php echo $row49['ID']; ?>"><?php echo $row49['Status']; ?></option>
			<?php						
								}
			?>						
								</select>
							</td>
						</tr>			
					</table>
				</td>
				<td valign="top">
					<table>
						<tr>
							<td class="mediumheading">
								Start Date:	
								<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
								<SCRIPT LANGUAGE="JavaScript">
								var cal = new CalendarPopup();
								</SCRIPT>
								<INPUT TYPE="text" NAME="date1" VALUE="<?php echo $startdate ?>" SIZE=15>
							</td>
							<td valign="bottom">
								<A HREF="#"
			   				onClick="cal.select(document.forms['example12'].date1,'anchor1','MM/dd/yyyy'); return false;"
			   				NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
			  			</td>  
			  		</tr>		
						<tr>
							<td class="mediumheading">
								End Date:	
								<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
								<SCRIPT LANGUAGE="JavaScript">
								var cal = new CalendarPopup();
								</SCRIPT>
								<INPUT TYPE="text" NAME="date2" VALUE="<?php echo $enddate ?>" SIZE=15>
							</td>
							<td valign="bottom">
								<A HREF="#"
			   				onClick="cal.select(document.forms['example12'].date2,'anchor2','MM/dd/yyyy'); return false;"
			   				NAME="anchor2" ID="anchor2"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
			  			</td>  
			  		</tr>	  		
					</table>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
					<input type="submit" value="Save" name="updatesch">
				</td>
			</tr>
		</table>
<?php		
	echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
	echo	'<input type = "hidden" name="id" value = "'.$id.'">';
?>	
	</form>
<?php
}	
if((isset($_GET['view'])) && ($_GET['view']=='schedule'))
{
	include 'header.php';
	include 'includes/config.php';
	include 'includes/opendb.php';
	$f_id = $_GET['f_id'];
	mysql_select_db('testhomefree');
	$query28 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result28 = mysql_query($query28) or die(mysql_error());
	$row28 = mysql_fetch_array($result28);	
	mysql_select_db('testwork');	
	$query29 = "SELECT * FROM tbltype WHERE Page = 2";
	$result29 = mysql_query($query29) or die(mysql_error());
	$query30 = "SELECT * FROM tblstatus WHERE Install = 1 ORDER BY Status DESC";
	$result30 = mysql_query($query30) or die(mysql_error());
	$query31 = "SELECT * FROM tblcompany WHERE Page = 2 AND active = 1";
	$result31 = mysql_query($query31) or die(mysql_error());	
	$query35 = "SELECT * FROM tblcompany WHERE Page = 2";
	$result35 = mysql_query($query35) or die (mysql_error());	
	if((isset($_GET['service']))&&($_GET['service']=='service'))
	{
		$eventtype = 'service';
		$callnumber = $_GET['callnumber'];
	}else
	{
		$eventtype = 'install';
		$callnumber = '-1';
	}
?>	
	<form method="GET" name="example12" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td class="bigheading" colspan="2">
					Schedule <?php echo $eventtype; ?> for <?php echo $row28['FacilityName']; ?>
				</td>
			</tr>
			<tr>
				<td class="mediumheading">
					Title:
				</td>
				<td>
					<input type="text" size="100" maxlength="250" name="title" value="">
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td valign="top">
					<table>
						<tr>
							<td class="mediumheading">
								Company:
							</td>
							<td>
								<select name="company">
<?php						
								while($row31 = mysql_fetch_array($result31))
								{
?>						
									<option value = "<?php echo $row31['ID']; ?>"><?php echo $row31['Company']; ?></option>
<?php						
								}
?>						
								</select>
							</td>
						</tr>	
<?php
						if((isset($_GET['service']))&&($_GET['service']=='service'))
						{
?>							
							<tr>
								<td class="mediumheading">
									Type:
								</td>
								<td class="body">
									Service Call <?php echo	'<input type = "hidden" name="type" value = "17">'; ?>
								</td>
							</tr>
<?php
						}else
						{
?>																					
							<tr>
								<td class="mediumheading">
									Type:
								</td>
								<td>
									<select name="type">
<?php						
									while($row29 = mysql_fetch_array($result29))
									{
?>						
										<option value = "<?php echo $row29['ID']; ?>"><?php echo $row29['Type']; ?></option>
<?php						
									}
?>						
									</select>
								</td>
							</tr>
<?php
						}
?>											
						<tr>
							<td class="mediumheading">
								Status:
							</td>
							<td>
								<select name="status">
			<?php						
								while($row30 = mysql_fetch_array($result30))
								{
			?>						
									<option value = "<?php echo $row30['ID']; ?>"><?php echo $row30['Status']; ?></option>
			<?php						
								}
			?>						
								</select>
							</td>
						</tr>			
					</table>
				</td>
				<td valign="top">
					<table>
						<tr>
							<td class="mediumheading">
								Start Date:	
								<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
								<SCRIPT LANGUAGE="JavaScript">
								var cal = new CalendarPopup();
								</SCRIPT>
								<INPUT TYPE="text" NAME="date1" VALUE="" SIZE=15>
							</td>
							<td valign="bottom">
								<A HREF="#"
			   				onClick="cal.select(document.forms['example12'].date1,'anchor1','MM/dd/yyyy'); return false;"
			   				NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
			  			</td>  
			  		</tr>		
						<tr>
							<td class="mediumheading">
								End Date:	
								<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
								<SCRIPT LANGUAGE="JavaScript">
								var cal = new CalendarPopup();
								</SCRIPT>
								<INPUT TYPE="text" NAME="date2" VALUE="" SIZE=15>
							</td>
							<td valign="bottom">
								<A HREF="#"
			   				onClick="cal.select(document.forms['example12'].date2,'anchor2','MM/dd/yyyy'); return false;"
			   				NAME="anchor2" ID="anchor2"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
			  			</td>  
			  		</tr>	  		
					</table>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="border">
					<table>
						<tr>
							<td>
								Legend:
							</td>
						</tr>
						<tr>						
<?php
							while($row35 = mysql_fetch_array($result35))
							{
								$font = $row35['font'];		
?>								
									<td>
									</td>		
									<td class="legend"><font color="<?php echo $font ?>">
										<?php echo $row35['Company']; ?>
									</font></td>

<?php
							}
?>	
						</tr>												
					</table>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
					<input type="submit" value="Submit Schedule" name="subschedule">
				</td>
			</tr>
		</table>
<?php
	echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
	echo	'<input type = "hidden" name="callnumber" value = "'.$callnumber.'">';
?>		
	</form>		
<?php				
	if(isset($_GET['prm']))
	{
		$prm = $_GET['prm'];
		$chm = $_GET['chm'];
		$m=$prm+$chm;
	}
	else
	{
		$m= date("m");
	}
	$month = date('F');
	$d= date("d");     // Finds today's date
	$y= date("Y");     // Finds today's year
	$no_of_days = date('t',mktime(0,0,0,$m,1,$y));	// This is to calculate number of days in a month
	$mn=date('M',mktime(0,0,0,$m,1,$y)); // Month is calculated to display at the top of the calendar
	$yn=date('Y',mktime(0,0,0,$m,1,$y)); // Year is calculated to display at the top of the calendar
	$j= date('w',mktime(0,0,0,$m,1,$y)); // This will calculate the week day of the first day of the month
	$mt=date('F',mktime(0,0,0,$m,1,$y)); // Month is calculated to display at the top of the calendar
	$adj = '';
	for($k=1; $k<=$j; $k++)
	{ 
		$adj .="<td>&nbsp</td>";
	}
	/// Starting of top line showing name of the days of the week
	echo " <table border='1' bordercolor='#FFFF00' cellspacing='0' cellpadding='0' align=center>
	<tr><td>";
	echo "<table cellspacing='0' cellpadding='0' align=center width='750' border='1'><td align=center bgcolor='#84C552'><font size='3' face='Tahoma'> <a href='installquote.php?view=schedule&f_id=$f_id&prm=$m&chm=-1'><</a> </td><td colspan=5 align=center bgcolor='#84C552'><font size='4' color='#005A8C' face='Verdana'>$mt $yn </td><td align=center bgcolor='#84C552'><font size='3' face='Tahoma'> <a href='installquote.php?view=schedule&f_id=$f_id&prm=$m&chm=1'>></a> </td></tr><tr>";
	echo "<td align=center width=14.2%><font size='3' face='Tahoma'><b>Sun</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Mon</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Tue</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Wed</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Thu</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Fri</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Sat</b></font></td></tr><tr>";
	////// End of the top line showing name of the days of the week//////////
	//////// Starting of the days//////////
	for($i=1;$i<=$no_of_days;$i++)
	{
		mysql_select_db('testwork');
		$daytotime = ($i.' '.$mn.' '.$yn);	
		$string = strtotime($daytotime);
		echo $adj."<td valign=top height=100><font size='2' face='Tahoma'>$i<br></font>";
		$query = "SELECT * FROM epc_calendar WHERE Status <> 7 AND Active <> 0";
		$result = mysql_query($query) or die (mysql_error());
		while($row = mysql_fetch_array($result))
		{
			mysql_select_db('testwork');
			$startDate = $row['startDate'];
			$endDate = $row['endDate'];
			$title = $row['title'];
			$company = $row['company'];
			$status = $row['Status'];
			$facilityid = $row['FacilityID'];
			$query34 = "SELECT font FROM tblcompany WHERE ID = '$company'";
			$result34 = mysql_query($query34) or die (mysql_error());
			$row34 = mysql_fetch_array($result34);
			$font = $row34['font'];
			if($string >= $startDate && $string <= $endDate) 
			{
				mysql_select_db('testhomefree');
				$query33 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$facilityid'";
				$result33 = mysql_query($query33) or die (mysql_error());
				$row33 = mysql_fetch_array($result33);
				if($status == 3)
				{
					echo '<font size=1 color='.$font.'><del>'.$row33['FacilityName'].','.$row33['StateOrProvinceCode'].' '.$title."</del><br />"; // This will display the date inside the calendar cell;
				}elseif($status == 6 OR $status == 7)
				{
					echo '<font size=1 color='.$font.'>'.$row33['FacilityName'].','.$row33['StateOrProvinceCode'].' '.$title."<br />"; // This will display the date inside the calendar cell;
				}
			}
		}
		echo " </font></td>";
		$adj='';
		$j ++;
		if($j==7)
		{
			echo "</tr><tr>";
			$j=0;
		}
	}
	echo "</tr></table></td></tr></table>";	
	mysql_select_db('testwork');
	$query36 = "SELECT * FROM epc_calendar WHERE Status = 6 OR Status = 7 AND Active <> 0 ORDER BY startDate";
	$result36 = mysql_query($query36) or die (mysql_error());
?>
	<table>
		<tr>
			<td class="mediumheading" colspan="1">
				Log:
			</td>
			<td colspan="5" class="body">
				<a href="installquote.php?view=log">View/Customize Log</a>
			</td>			
		</tr>
<?php
		while($row36 = mysql_fetch_array($result36))		
		{
			mysql_select_db('testwork');
			$startdate = date('m-d-Y',$row36['startDate']);
			$enddate = date('m-d-Y',$row36['endDate']);	
			$title = $row36['title'];
			$status = $row36['Status'];
			$company = $row36['company'];
			$type = $row36['type'];
			$f_id = $row36['FacilityID'];
			$query37 = "SELECT Status FROM tblstatus WHERE ID = '$status'";
			$result37 = mysql_query($query37) or die (mysql_error());		
			$row37 = mysql_fetch_array($result37);
			$query38 = "SELECT company FROM tblcompany WHERE ID = '$company'";
			$result38 = mysql_query($query38) or die (mysql_error());		
			$row38 = mysql_fetch_array($result38);	
			$query39 = "SELECT Type FROM tbltype WHERE ID = '$type'";
			$result39 = mysql_query($query39) or die (mysql_error());		
			$row39 = mysql_fetch_array($result39);		
			mysql_select_db('testhomefree');
			$query40 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
			$result40 = mysql_query($query40) or die (mysql_error());
			$row40 = mysql_fetch_array($result40);
?>			
			<tr>
				<td class="mediumheading" colspan="6">
					<?php echo $row40['FacilityName'].' '.$row39['Type'].'-'.$title; ?>
				</td>
			</tr>
			<tr>
				<td class="body">
					Start Date: <?php echo $startdate; ?>
				</td>
				<td class="body">
					End Date: <?php echo $enddate; ?>
				</td>
				<td class="body">
					Status: <?php echo $row37['Status']; ?>
				</td>			
				<td class="body">
					Company: <?php echo $row38['company']; ?>
				</td>	
				<td>
					<?php echo '<a href="installquote.php?action=UPDATESCH&id='. $row36['ID'].'&f_id='.$f_id.'"><img src="../images/icon_edit_pencil.gif" width="16" height="16" border="0" /></a>'; ?>
				</td>					
				<td>
					<?php echo '<a href="installquote.php?action=DELETESCH&id='. $row36['ID'].'&f_id='.$f_id.'" onClick="return confirm(\'Are you sure you want to delete '.$row36['title'].'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" /></a>'; ?>
				</td>
			</tr>	
			<tr>
				<td colspan="6">
					<div align="center"><hr width="100%"></div>
				</td>
			</tr>							
<?php
		}
?>					
	</table>
<?php	
}
if(((isset($_GET['subschedule'])) && ($_GET['subschedule'] == 'Submit Schedule')) OR ((isset($_GET['updatesch'])) && ($_GET['updatesch'] == 'Save')))
{
	$startdate = strtotime($_GET['date1']);
	$enddate  = strtotime($_GET['date2']);
	$title = $_GET['title'];
	$type = $_GET['type'];
	$f_id = $_GET['f_id'];
	$company = $_GET['company'];
	$status = $_GET['status'];
	if($status == 3)
	{
		$comptime = $completiontime;
	}else
	{
		$comptime = 0;
	} 
	if((isset($_GET['subschedule'])) && ($_GET['subschedule'] == 'Submit Schedule'))
	{
		$callnumber = $_GET['callnumber'];
		$query32 = "INSERT INTO epc_calendar (FacilityID,startDate,endDate,type,title,Status,company,service,serviceid,comptime) VALUES ('$f_id','$startdate','$enddate',
		'$type','$title','$status','$company',1,'$callnumber','$comptime')";
		mysql_query($query32) or die(mysql_error());
		if($callnumber <> -1)
		{
			$query64 = "UPDATE tblservicecall SET Status = '$status' WHERE ID='$callnumber'";
			mysql_query($query64) or die(mysql_error());
		}
		header("Location: installquote.php?view=installcalendar&f_id=$f_id");
	}
	if((isset($_GET['updatesch'])) && ($_GET['updatesch'] == 'Save'))
	{
		$id = $_GET['id'];
		$query41 = "UPDATE epc_calendar SET startDate='$startdate', endDate='$enddate', type='$type',company='$company',Status='$status', 
		comptime = '$comptime' WHERE ID = '$id'";
		mysql_query($query41) or die(mysql_error());
		$query65 = "SELECT * FROM epc_calendar WHERE ID = '$id'";
		$result65 = mysql_query($query65) or die (mysql_error());
		$row65 = mysql_fetch_array($result65);
		$query67 = "SELECT * FROM tblproactivecallschedule WHERE CustomerNumber = '$f_id'";
		$result67 = mysql_query($query67) or die (mysql_error());
		mysql_select_db('testhomefree');
		$query68 = "SELECT CustomerNumber FROM tblfacilities WHERE CustomerNumber = '$f_id'";
		$result68 = mysql_query($query68) or die (mysql_error());
		$count68 = mysql_num_rows($result68);
		$count67 = mysql_num_rows($result67);
		if($count68 > 0)
		{
			if($count67 < 1)
			{
				if(($type == 15) && ($status == 3))
				{
					mysql_select_db('testwork');
					$installcall = date('Y-m-d H:i:s',$onemonth);
					$query66 = "INSERT INTO tblproactivecallschedule (CustomerNumber,Freq,LastCall,NextCall) VALUES ('$f_id','0','0000-00-00 00:00:00','$installcall')";
					mysql_query($query66) or die(mysql_error());
				}
			}
		}	
		if($row65['service'] <> 0)
		{
			mysql_select_db('testwork');
			$call = $row65['serviceid'];
			$query64 = "UPDATE tblservicecall SET Status = '$status' WHERE ID='$call'";
			mysql_query($query64) or die(mysql_error());
		}
		header("Location: installquote.php?view=installcalendar&f_id=$f_id");
	}
}
if((isset($_GET['view'])) && ($_GET['view'] == 'installcalendar'))
{
	if(!isset($_GET['print']))
	{	
		include 'header.php';
		$email = $_SESSION['mail'];
		include 'includes/config.php';
		include 'includes/opendb.php';
		mysql_select_db('testhomefree');
		$query50 = "SELECT projmanage FROM employees WHERE email = '$email'";
		$result50 = mysql_query($query50) or die (mysql_error());
		$row50 = mysql_fetch_array($result50);
		$proj = $row50['projmanage'];
	}else
	{
		$proj = 0;
	}
	mysql_select_db('testwork');
	$query51 = "SELECT * FROM tblcompany WHERE Page = 2";
	$result51 = mysql_query($query51) or die (mysql_error());	
	$count51 = mysql_num_rows($result51);
	if(!isset($_GET['print']))
	{	
?>
		<table align="center">
			<tr>
				<td class="smallheading" colspan="<?php echo $count51; ?>" align="center">
					<a href="installquote.php?view=installcalendar&print=print">Print View</a>
				</td>
			</tr>
			<tr>
				<td class="border">
					<table>
						<tr>
							<td>
								Legend:
							</td>
						</tr>
						<tr>						
<?php
							while($row51 = mysql_fetch_array($result51))
							{
								$font = $row51['font'];		
?>								
								<td>
								</td>				
								<td class="legend"><font color="<?php echo $font ?>">
									<?php echo $row51['Company']; ?>
								</font></td>
<?php
							}
?>						
						</tr>
					</table>
				</td>
			</tr>							
		</table>	
<?php				
	}		
	if(isset($_GET['prm']))
	{
		$prm = $_GET['prm'];
		$chm = $_GET['chm'];
		$m=$prm+$chm;
	}
	else
	{
		$m= date("m");
	}
	$month = date('F');
	$d= date("d");     // Finds today's date
	$y= date("Y");     // Finds today's year
	$no_of_days = date('t',mktime(0,0,0,$m,1,$y));	// This is to calculate number of days in a month
	$mn=date('M',mktime(0,0,0,$m,1,$y)); // Month is calculated to display at the top of the calendar
	$yn=date('Y',mktime(0,0,0,$m,1,$y)); // Year is calculated to display at the top of the calendar
	$j= date('w',mktime(0,0,0,$m,1,$y)); // This will calculate the week day of the first day of the month
	$mt=date('F',mktime(0,0,0,$m,1,$y)); // Month is calculated to display at the top of the calendar
	$adj = '';
	for($k=1; $k<=$j; $k++)
	{ 
		$adj .="<td>&nbsp</td>";
	}
	/// Starting of top line showing name of the days of the week
	echo " <table border='1' bordercolor='#000000' cellspacing='0' cellpadding='0' align=center>
	<tr><td>";
	echo "<table cellspacing='0' cellpadding='0' align=center width='750' border='1'><td align=center bgcolor='#84C552'><font size='3' face='Tahoma'> <a href='installquote.php?view=installcalendar&prm=$m&chm=-1'><</a> </td><td colspan=5 align=center bgcolor='#84C552'><font size='4' color='#005A8C' face='Verdana'>$mt $yn </td><td align=center bgcolor='#84C552'><font size='3' face='Tahoma'> <a href='installquote.php?view=installcalendar&prm=$m&chm=1'>></a> </td></tr><tr>";
	echo "<td align=center width=14.2%><font size='3' face='Tahoma'><b>Sun</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Mon</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Tue</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Wed</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Thu</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Fri</b></font></td><td align=center width=14.2%><font size='3' face='Tahoma'><b>Sat</b></font></td></tr><tr>";
	////// End of the top line showing name of the days of the week//////////
	//////// Starting of the days//////////
	for($i=1;$i<=$no_of_days;$i++)
	{
		mysql_select_db('testwork');
		$daytotime = ($i.' '.$mn.' '.$yn);	
		$string = strtotime($daytotime);
		echo $adj."<td valign=top height=100><font size='2' face='Tahoma'>$i<br></font>";
		$query = "SELECT * FROM epc_calendar WHERE Active <> 0";
		$result = mysql_query($query) or die (mysql_error());
		while($row = mysql_fetch_array($result))
		{
			mysql_select_db('testwork');
			$startDate = $row['startDate'];
			$endDate = $row['endDate'];
			$title = $row['title'];
			$company = $row['company'];
			$status = $row['Status'];
			$facilityid = $row['FacilityID'];
			$query34 = "SELECT font FROM tblcompany WHERE ID = '$company'";
			$result34 = mysql_query($query34) or die (mysql_error());
			$row34 = mysql_fetch_array($result34);
			$font = $row34['font'];				
			if($string >= $startDate && $string <= $endDate)
			{			
				mysql_select_db('testhomefree');
				$query33 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$facilityid'";
				$result33 = mysql_query($query33) or die (mysql_error());
				$row33 = mysql_fetch_array($result33);
				if($status == 3)
				{
					echo '<font size=1 color='.$font.'><del>'.$row33['FacilityName'].','.$row33['StateOrProvinceCode'].' '.$title."</del><br />"; // This will display the date inside the calendar cell;
				}elseif($status == 6 OR $status == 7)
				{
					echo '<font size=1 color='.$font.'>'.$row33['FacilityName'].','.$row33['StateOrProvinceCode'].' '.$title."<br />"; // This will display the date inside the calendar cell;
				}
			}
		}
		echo " </font></td>";
		$adj='';
		$j ++;
		if($j==7)
		{
			echo "</tr><tr>";
			$j=0;
		}
	}
	echo "</tr></table></td></tr></table>";	
	mysql_select_db('testwork');
	$query36 = "SELECT * FROM epc_calendar WHERE Status = 6 OR Status = 7 AND Active <> 0 ORDER BY startDate";
	$result36 = mysql_query($query36) or die (mysql_error());
?>
<table width="750" align="center">
	<tr>
		<td>
			<FIELDSET>
				<table>
					<tr>
						<td class="mediumheading">
							Log:
						</td>
						<td colspan="5" class="body">
							<a href="installquote.php?view=log">View/Customize Log</a>
						</td>
					</tr>
<?php
					while($row36 = mysql_fetch_array($result36))		
					{
						mysql_select_db('testwork');
						$startdate = date('m-d-Y',$row36['startDate']);
						$enddate = date('m-d-Y',$row36['endDate']);	
						$title = $row36['title'];
						$status = $row36['Status'];
						$company = $row36['company'];
						$type = $row36['type'];
						$f_id = $row36['FacilityID'];
						$query37 = "SELECT Status FROM tblstatus WHERE ID = '$status'";
						$result37 = mysql_query($query37) or die (mysql_error());		
						$row37 = mysql_fetch_array($result37);
						$query38 = "SELECT company FROM tblcompany WHERE ID = '$company'";
						$result38 = mysql_query($query38) or die (mysql_error());		
						$row38 = mysql_fetch_array($result38);	
						$query39 = "SELECT Type FROM tbltype WHERE ID = '$type'";
						$result39 = mysql_query($query39) or die (mysql_error());		
						$row39 = mysql_fetch_array($result39);	
						$query64 = "SELECT Activated FROM tblfacilitygeneralinfo WHERE Cust_Num = '$f_id'";
						$result64 = mysql_query($query64) or die (mysql_error());
						$row64 = mysql_fetch_array($result64);				
						mysql_select_db('testhomefree');
						$query40 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
						$result40 = mysql_query($query40) or die (mysql_error());
						$row40 = mysql_fetch_array($result40);						
?>				
						<tr>
							<td class="mediumheading" colspan="6">
								<?php echo $row40['FacilityName'].' '.$row39['Type'].'-'.$title; ?>
							</td>
						</tr>
						<tr>
							<td class="body" width="120"><b>
								Start Date:</b> <?php echo $startdate; ?>
							</td>
							<td class="body" width="120"><b>
								End Date:</b> <?php echo $enddate; ?>
							</td>
							<td class="body" width="120"><b>
								Status:</b><?php echo $row37['Status']; ?>
							</td>			
							<td class="body" width="400"><b>
								Company:</b> <?php echo $row38['company']; ?>
							</td>	
<?php
						if(($proj == 1)&&(!isset($_GET['print'])))
						{	
?>							
							<td width="22">
								<?php echo '<a href="installquote.php?action=UPDATESCH&id='. $row36['ID'].'&f_id='.$f_id.'"><img src="../images/icon_edit_pencil.gif" width="16" height="16" border="0" /></a>'; ?>
							</td>					
							<td>
								<?php echo '<a href="installquote.php?action=DELETESCH&id='. $row36['ID'].'&f_id='.$f_id.'" onClick="return confirm(\'Are you sure you want to delete '.$row36['title'].'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" /></a>'; ?>
							</td>				
<?php			
						}	
?>
						</tr>
						<tr>
							<td colspan="6">
								<div align="center"><hr width="100%"></div>
							</td>
						</tr>				
<?php
					}
?>					
				</table>
			</td>
		</tr>
	</table>
	</FIELDSET>
<?php	
}
if((isset($_GET['view'])) && ($_GET['view']=='addtohomefree'))
{
	include 'header.php';
	include 'includes/config.php';
	include 'includes/opendb.php';
	$query54 = "SELECT * FROM tblfacilitygeneralinfo WHERE ID = '$f_id'";
	$result54 = mysql_query($query54) or die (mysql_error());
	$row54 = mysql_fetch_array($result54);
?>
	<table  width="750"  align ="center">
		<tr>
			<td>
				THIS WILL MAKE THE CUSTOMER ACTIVE IN THE PORTAL<br>
<?php
				if((isset($_GET['page']))&&($_GET['page']=='ticket'))
				{
?>									
					PLEASE <?php echo '<a href="' . 'installtickets.php?view=new&f_id='.$f_id.'">'?>CLICK HERE</a> TO SKIP TO TICKETS
<?php
				}elseif((isset($_GET['page']))&&($_GET['page']=='viewticket'))
				{
?>
					PLEASE <?php echo '<a href="' . 'installtickets.php?view=lookup&f_id='.$f_id.'">'?>CLICK HERE</a> TO SKIP TO TICKETS
<?php					
				}else					
				{
?>					
					PLEASE <?php echo '<a href="' . 'installquote.php?view=installcalendar'.'">'?>CLICK HERE</a> TO SKIP AND VIEW CALENDAR
<?php					
				}
?>				
			</td>
		</tr>		
		<tr>
			<td>	
			</td>
		</tr>
	</table>			
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table  width="750"  align ="center">
			<tr>
				<td align=center td colspan="5" class="bigheading">
			  	General Information  
			  </b></font></td>
			</tr>
		</table>		
		<table cellpadding=2 table border ="0" width="750"  align ="center">
			<tr>
				<td class="mediumheading">
					Customer Number:
				<td>
					<input type="text" size="6" maxlength="6" name="custnum"> (FROM PRIORITY)
				</td>
			</tr>
			<tr>
				<td width = "115" class="mediumheading">
					Facility Name:
				</td>
				<td colspan="5"><font face = "Arial" size = 2">
					<input type="text" size="80" maxlength="79" name="Fname" value="<?php echo $row54['FacilityName']; ?>">
				</font></td>
			</tr>
			<tr>
				<td width = "115" class="mediumheading">
					Facility Alternate Name:
				</td>
				<td colspan="5"><font face = "Arial" size = 2">
					<input type="text" size="80" maxlength="79" name="Fname2" value="">
				</font></td>
			</tr>			
			<tr>
				<td class="mediumheading">
					Street Address:
				</td>
				<td colspan="5"><font face = "Arial" size = 2">
					<input type="text" size="80" maxlength="79" name="Address" value="<?php echo $row54['StreetAddress']; ?>">
				</font></td>
			</tr>
			<tr>
				<td class="mediumheading">
					City,State,Postal Code:
				</td>
				<td colspan = "3"><font face = "Arial" size = 2">
					<input type="text" size="32" maxlength="32" name="city" value="<?php echo $row54['City']; ?>">,
		
					<select name="state">
<?php			
					mysql_select_db('testhomefree');
					$query55 = "SELECT * FROM tblsalesrepbyterritories WHERE CountryCode = 'US' ORDER BY StateOrProvinceCode";
					$result55 = mysql_query($query55) or die (mysql_error());
					$state = $row54['StateOrProvinceCode'];
					$query56 = "SELECT * FROM tblsalesrepbyterritories WHERE CountryCode = 'US' AND StateOrProvinceCode = '$state'";
					$result56 = mysql_query($query56) or die (mysql_error());
					$row56 = mysql_fetch_array($result56);
?>					
					<option value="<?php echo $row56['StateOrProvinceCode']; ?>"><?php echo $row56['StateOrProvinceCode']; ?></option>	
<?php					
					while($row55 = mysql_fetch_array($result55))
					{
?>
						<option value="<?php echo $row55['StateOrProvinceCode']; ?>"><?php echo $row55['StateOrProvinceCode']; ?></option>				
<?php
					}				
?>
					</select>				
					,<input type="text" size="16" maxlength="15" name="zip" value="<?php echo $row54['PostalCode']; ?>">
				</font></td>		
			</tr>
			<tr>
				<td class="mediumheading">
					Country:
				</td>				
				<td>
				<select name="country">
<?php
				
				$query59 = "SELECT * FROM tblcountries";
				$result59 = mysql_query($query59) or die (mysql_error());
				while($row59 = mysql_fetch_array($result59))
				{
?>
					<option value="<?php echo $row59['CountryCode']; ?>" <?php if($row59['CountryCode'] == "US"){ echo 'selected="selected"'; } ?>><?php echo $row59['Country']; ?></option>
<?php
				}		
?>				
				</td>
			</tr>			
			<tr>
				<td class="mediumheading">
					Customer Type:
				</td>
				<td><font face = "Arial" size = 2">
					<select name=custype>
		  			<option value ="HomeFree">HomeFree</option>
		  			<option value ="Elmotech">Elmotech</option>
		  		</select>
		  	</font></td> 
		  </tr>		  
		  <tr>
		  	<td align="center" colspan="5" class="bigheading">
		  		General Contact Information
		  	</td>
		  </tr>
			<tr>
				<td class="mediumheading">
					Phone Number:
				</td>
				<td><font face = "Arial" size = 2">
					<input type="text" size="12" maxlength="10" name="Phone"> e.g. 4143588200
				</font></td>
			</tr> 
			<tr>
				<td class="mediumheading">
					Fax:
				</b></font></td>
				<td><font face = "Arial" size = 2">
					<input type="text" size="12" maxlength="10" name="Fax"> e.g. 4143588100
				</td>
			</tr>			 
			<tr>
				<td>
					<input type="submit" value="Save" name="subcustomer">
				</td>
			</tr>		  
		</table>
<?php
		echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
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
	</form>
<?php
}
if((isset($_GET['subcustomer'])) && ($_GET['subcustomer']=='Save'))
{
	$Fname = addslashes($_GET['Fname']);
	$altname = addslashes($_GET['Fname2']);	
	$custnum = $_GET['custnum'];
	$Address = addslashes($_GET['Address']);
	$Phone =$_GET["Phone"];
	$Fax =  $_GET["Fax"];
	$System = $row17["SystemType"];
	if($System == 'Elite')
	{
		$systype = 0;
	}
	if($System == 'On-Site')
	{
		$systype = 1;
	}
	if($System == 'On-Call')
	{
		$systype = 2;
	}
	$version = $currentver;
	$custype = $_GET['custype'];
	$city = $_GET["city"];
	$zip = $_GET["zip"];
	$country = $_GET['country'];
	$statecode = $_GET["state"];
	$usedlicenses = ($equip['lic'] + $equip['TotalClientStations']);
	if((($equip['lic'] + $equip['TotalClientStations']) > 5) OR ($upgrade == 1))
	{
		$db = 'Sybase';
	}else	
	{
		$db = 'MS Access';
	}
	mysql_select_db('testhomefree');
	$query57 = "INSERT INTO tblfacilities (CustomerNumber,FacilityName,FacilityNameOther,StreetAddress,City,StateOrProvinceCode,PostalCode,CountryCode,
						PhoneNumber,FaxNumber,SystemType,SystemAMSVersion,dbType,clientLic,pagerType,refCompany,DateModified) VALUES ('$custnum','$Fname','$altname',
						'$Address','$city','$statecode','$zip','$country','$Phone','$Fax','$System','$version','$db','$usedlicenses','$pager','$custype','$datetime')";
	mysql_query($query57) or die(mysql_error());	
	mysql_select_db('testwork');	
	$query58 = "UPDATE tblfacilitygeneralinfo SET Cust_Num = '$custnum', City = '$city', StreetAddress = '$Address', PostalCode = '$zip',
							StateOrProvinceCode = '$statecode', Activated = 1 WHERE ID = '$f_id'";	
	mysql_query($query58) or die(mysql_error());	
	if((isset($_GET['page']))&&($_GET['page']=='ticket'))
	{
		header("Location: installtickets.php?view=new&f_id=$f_id");
	}elseif((isset($_GET['page']))&&($_GET['page']=='viewticket'))
	{
		header("Location: installtickets.php?view=lookup&f_id=$f_id");		
	}else
	{
		header("Location: installquote.php?view=schedule&f_id=$custnum");		
	}
}
if(((isset($_GET['view'])) && ($_GET['view']=='log')) OR (isset($_GET['logsearch'])))
{
	if(!isset($_GET['print']))
	{	
		include 'header.php';
		$email = $_SESSION['mail'];
		include 'includes/config.php';
		include 'includes/opendb.php';
		mysql_select_db('testhomefree');
		$query62 = "SELECT projmanage FROM employees WHERE email = '$email'";
		$result62 = mysql_query($query62) or die (mysql_error());
		$row62 = mysql_fetch_array($result62);
		$proj = $row62['projmanage'];
	}else
	{
		$proj = 0;
	}	
?>
	<form method="GET" name="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table border="0">
			<tr>
				<td colspan="2" class="bigheading">
					Custom Log Search Criteria:
				</td>
			</tr>
			<tr>
				<td class="heading">
					Company:
				</td>
				<td class="heading">
					Type:
				</td>
				<td class="heading">
					Status:
				</td>
			</tr>
			<tr>								
				<td valign="top">
					<select name="company"> 
	  				<option value="-1">Any</option>
<?php
						mysql_select_db('testwork');
						$query60 = "SELECT * FROM tblcompany WHERE Active <> 0";
						$result60 = mysql_query($query60) or die (mysql_error());
						while($row60 = mysql_fetch_array($result60))
						{
?>
							<option value="<?php echo $row60['ID']; ?>"><?php echo $row60['Company']; ?></option>
<?php
						}						
?>  				 
	  			</select>
	  		</td>
	  		<td valign="top">
	  			<select name="type"> 
	  				<option value="-1">Any</option>
<?php
						$query61 = "SELECT * FROM tbltype WHERE Page = 2";
						$result61 = mysql_query($query61) or die (mysql_error());
						while($row61 = mysql_fetch_array($result61))
						{
?>
							<option value="<?php echo $row61['ID']; ?>"><?php echo $row61['Type']; ?></option>
<?php
						}						
?>  				 
	  			</select>
	  		</td>
	  		<td valign="top">
	  			<select name="status"> 
	  				<option value="-1">Any</option>
<?php
						$query62 = "SELECT * FROM tblstatus WHERE Install = 1 ORDER BY Status DESC";
						$result62 = mysql_query($query62) or die (mysql_error());
						while($row62 = mysql_fetch_array($result62))
						{
?>
							<option value="<?php echo $row62['ID']; ?>"><?php echo $row62['Status']; ?></option>
<?php
						}						
?>  				 
	  			</select>
	  		</td>	  		
	  	</tr>
			<tr>
				<td colspan="2" class="heading">
					From Date:	
				</td>
				 <td colspan="2" class="heading">
					To Date:	
				</td>
			</tr>	 
			<tr>
				<td valign="top">
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date1" VALUE="<?php echo $date1; ?>" SIZE=25>
				</td>
				<td>
					<A HREF="#"
   				onClick="cal.select(document.forms['example'].date1,'anchor1','MM/dd/yyyy'); return false;"
   				NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
  			</td>
				<td valign="top">
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date2" VALUE="<?php echo $monthahead; ?>" SIZE=25>
				</td>
				<td>
					<A HREF="#"
   				onClick="cal.select(document.forms['example'].date2,'anchor2','MM/dd/yyyy'); return false;"
   				NAME="anchor2" ID="anchor2"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
  			</td>   			 			
	  	</tr>		
	  	<tr>
	  		<td>
	  			<input type="submit" value="Submit" name="logsearch">	 	
	  		</td>
	  	</tr>
	  </table>		
	</form>
<?php	
}
if((isset($_GET['logsearch']))&&($_GET['logsearch']=='Submit'))
{
	$date1 = strtotime($_GET['date1']);
	$date2 = strtotime($_GET['date2']);
	mysql_select_db('testwork');
	$query63 = "SELECT * FROM epc_calendar ";
	foreach($_GET as $val)
	{
	  if($val != "-1" OR  $val = "Submit")
	  {
	    $query63 .= "WHERE ";
	    break;
	  }
	}
	
	$where = array();
	if($_GET['company'] != "-1")
	{
	  $where[ ] = "company = '$_GET[company]'";
	}			
	if($_GET['type'] != "-1")
	{
	  $where [ ] = "type = '$_GET[type]'";
	}
	if($_GET['status'] != "-1")
	{
	  $where[ ] = "Status = '$_GET[status]'";
	}
	if($_GET['date1'] != "-1")
	{
	  $where[ ] = "startDate >= '$date1'";
	}	
	if($_GET['date2'] != "-1")
	{
	  $where[ ] = "endDate <= '$date2'";
	}
	$where[]="active <> 0";
	if(!empty($where)){
	  $query63 .= implode(" AND ", $where);
	}	
	$result63 = mysql_query($query63) or die(mysql_error());
	//echo $query63;
	$num = mysql_num_rows($result63);	
		
			
?>
	<FIELDSET>
		<table cellpadding=3  width="750"  align ="center" table border = "0">
			<tr>
				<td colspan="8" class="bigheading">
					Results:
				</td>
			</tr>
			<tr>
				<td colspan="3" class="heading">
					Number of Records that mathced your search: <?php echo $num; ?>
				</td>
			</tr>
<?php		
			while($row63 = mysql_fetch_array($result63))
			{
							mysql_select_db('testwork');
							$startdate = date('m-d-Y',$row63['startDate']);
							$enddate = date('m-d-Y',$row63['endDate']);	
							$title = $row63['title'];
							$status = $row63['Status'];
							$company = $row63['company'];
							$type = $row63['type'];
							$f_id = $row63['FacilityID'];
							$query37 = "SELECT Status FROM tblstatus WHERE ID = '$status'";
							$result37 = mysql_query($query37) or die (mysql_error());		
							$row37 = mysql_fetch_array($result37);
							$query38 = "SELECT company FROM tblcompany WHERE ID = '$company'";
							$result38 = mysql_query($query38) or die (mysql_error());		
							$row38 = mysql_fetch_array($result38);	
							$query39 = "SELECT Type FROM tbltype WHERE ID = '$type'";
							$result39 = mysql_query($query39) or die (mysql_error());		
							$row39 = mysql_fetch_array($result39);					
							mysql_select_db('testhomefree');
							$query40 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
							$result40 = mysql_query($query40) or die (mysql_error());
							$row40 = mysql_fetch_array($result40);						
?>				
							<tr>
								<td class="mediumheading" colspan="6">
									<?php echo $row40['FacilityName'].' '.$row39['Type'].'-'.$title; ?>
								</td>
							</tr>
							<tr>
								<td class="body" width="120"><b>
									Start Date:</b> <?php echo $startdate; ?>
								</td>
								<td class="body" width="120"><b>
									End Date:</b> <?php echo $enddate; ?>
								</td>
								<td class="body" width="120"><b>
									Status:</b><?php echo $row37['Status']; ?>
								</td>			
								<td class="body" width="400"><b>
									Company:</b> <?php echo $row38['company']; ?>
								</td>	
<?php
							if(($proj == 1)&&(!isset($_GET['print'])))
							{	
?>							
								<td width="22">
									<?php echo '<a href="installquote.php?action=UPDATESCH&id='. $row63['ID'].'&f_id='.$f_id.'"><img src="../images/icon_edit_pencil.gif" width="16" height="16" border="0" /></a>'; ?>
								</td>					
								<td>
									<?php echo '<a href="installquote.php?action=DELETESCH&id='. $row63['ID'].'&f_id='.$f_id.'" onClick="return confirm(\'Are you sure you want to delete '.$row63['title'].'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" /></a>'; ?>
								</td>				
<?php			
							}	
?>
							</tr>
							<tr>
								<td colspan="6">
									<div align="center"><hr width="100%"></div>
								</td>
							</tr>				
<?php
						}
?>					
					</table>
				</td>
			</tr>
		</table>
	</FIELDSET>	
<?php			
}
?>		