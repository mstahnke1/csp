<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
$f_id = $_GET['f_id'];
$getquoteid = "SELECT ID FROM tblquotegeneral WHERE FacilityID = '$f_id'";
$resgetquoteid = mysql_query($getquoteid) or die(mysql_error());
$quoteidrow = mysql_fetch_array($resgetquoteid);
$quoteid = $quoteidrow['ID'];
if(isset($_GET['Click']))
{
	$inputdiscount = $_GET['discount'];
	$insertdiscount = "UPDATE tblquotegeneral SET Discount = '$inputdiscount' WHERE FacilityID = '$f_id'";
	mysql_query($insertdiscount) or die(mysql_error());
}
$clean = "DELETE FROM tblquotedetails WHERE QuoteID = '$quoteid'";
mysql_query($clean) or die(mysql_error());
$getquoteid = "SELECT Discount FROM tblquotegeneral WHERE FacilityID = '$f_id'";
$resgetquoteid = mysql_query($getquoteid) or die(mysql_error());
$quoteidrow = mysql_fetch_array($resgetquoteid);
$discountselected = $quoteidrow['Discount'];

$query = "SELECT SystemType,pricelist From tblfacilitygeneralinfo WHERE ID='$f_id'";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result);
$pricelist = $row['pricelist'];
$getpricelist = "SELECT * FROM tblpricelist WHERE ID = '$pricelist'";
$resgetpricelist = mysql_query($getpricelist) or die (mysql_error());
$pricelistselected = mysql_fetch_array($resgetpricelist);
$percentage = $pricelistselected['Percentage'];
$usedpercentage = ($percentage / 100);
$pricepercentage = (1 - $usedpercentage);
$systype = $row['SystemType'];
if($systype == "Elite")
{
	$syspn = "90380001";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$syspn','1')";
	mysql_query($insertz) or die(mysql_error());	
}elseif($systype == "On-Call")
{
	$syspn = "90380002";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$syspn','1')";
	mysql_query($insertz) or die(mysql_error());	
}elseif($systype == "On-Site")
{
	$syspn = "90380003";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$syspn','1')";
	mysql_query($insertz) or die(mysql_error());	
}
$getequip = "SELECT * FROM tbltotalequipment WHERE FacilityID='$f_id'";
$resgetequip = mysql_query($getequip) or die (mysql_error());
$equip = mysql_fetch_array($resgetequip);

$wmu = $equip["TotalWMUs"];
if($wmu <> 0)
{
	$pnwmu = "003810151";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnwmu','$wmu')";
	mysql_query($insertz) or die(mysql_error());	
}		
$owmu = $equip["TotalOutdoorAreaUnits"];
if($owmu <> 0)
{
	$pnowmu = "003810180";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnowmu','$owmu')";
	mysql_query($insertz) or die(mysql_error());	
}	
$sowmu = $equip["TotalOutdoorSolarUnits"];
if($sowmu <> 0)
{
	$pnsowmu = "003810195";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnsowmu','$sowmu')";
	mysql_query($insertz) or die(mysql_error());	
}	
$watch = $equip["TotalWatches"];
if($watch <> 0)
{
	$pnwatch = "002407404";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnwatch','$watch')";
	mysql_query($insertz) or die(mysql_error());	
}	
$fwatch = $equip["FemalePW"];
if($fwatch <> 0)
{
	$pnfwatch = "002407405";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnfwatch','$fwatch')";
	mysql_query($insertz) or die(mysql_error());	
}
$swatch = $equip["straplessPW"];
if($swatch <> 0)
{
	$pnswatch = "002407406";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnswatch','$swatch')";
	mysql_query($insertz) or die(mysql_error());	
}
$callb = $equip["TotalPanicButtons"];
if($callb <> 0)
{
	$pncallb= "006109604";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pncallb','$callb')";
	mysql_query($insertz) or die(mysql_error());	
}	
$tags = $equip["TotalPullTags"];
if($tags <> 0)
{
	$pntags= "006109200";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pntags','$tags')";
	mysql_query($insertz) or die(mysql_error());	
}	
$pull = $equip["TotalPullCords"];
if($pull <> 0)
{
	$pnpull= "006429300";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnpull','$pull')";
	mysql_query($insertz) or die(mysql_error());	
}	
$pullw = $equip["TotalPullCordsactivity"];
if($pullw <> 0)
{
	$pnpullw= "006429351";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnpullw','$pullw')";
	mysql_query($insertz) or die(mysql_error());	
}	
$ten = $equip["TotalCallCords"];
if($ten <> 0)
{
	$pnten= "33120941";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnten','$ten')";
	mysql_query($insertz) or die(mysql_error());	
}	  
$fifteen = $equip["TotalCallCordssingle15"];
if($fifteen <> 0)
{
	$pnfifteen= "90000109";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnfifteen','$fifteen')";
	mysql_query($insertz) or die(mysql_error());	
}
$dual = $equip["TotalCallCorddual"];
if($dual <> 0)
{
	$pndual = "90000066";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pndual','$dual')";
	mysql_query($insertz) or die(mysql_error());	
}
//$type = $equip["CorridorLights"];
//$style = $equip["CorridorLightType"];
$existing = $equip["TotalExistingCorrdiorLights"];
//if($existing <> 0)
//{
	//$pnexisting = "90000066";
	//$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnexisting','$existing')";
	//mysql_query($insertz) or die(mysql_error());	
//}
$homefree = $equip["TotalHomeFreeCorrdiorLights"];
if($homefree <> 0)
{
	$pnhomefree = "90000019";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnhomefree','$homefree')";
	mysql_query($insertz) or die(mysql_error());	
}
$base = $equip["PagingBaseType"];
if($base == 'Commtech5W')
{
	$pnbase = "900005004";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnbase','1')";
	mysql_query($insertz) or die(mysql_error());	
}elseif($base == 'Commtech25W')
{
	$pnbase = "900005005";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnbase','1')";
	mysql_query($insertz) or die(mysql_error());	
}elseif($base == 'Commtech50W')
{
	$pnbase = "900005006";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnbase','1')";
	mysql_query($insertz) or die(mysql_error());	
}elseif($base == 'Commtech100W')
{
	$pnbase = "900005007";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnbase','1')";
	mysql_query($insertz) or die(mysql_error());	
}elseif($base == 'Commtech200W')
{
	$pnbase = "900005008";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnbase','1')";
	mysql_query($insertz) or die(mysql_error());	
}
$pager = $equip["PagerType"];
$numpagers = $equip["PagerQuantity"];
if($pager == "Commtech7900")
{
	$pnpager = "900005003";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnpager','$numpagers')";
	mysql_query($insertz) or die(mysql_error());	
}elseif($pager == "Apollo")
{
	$pnpager = "900003012";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnpager','$numpagers')";
	mysql_query($insertz) or die(mysql_error());
}
$hfpagers = $equip["HomeFreePager"];
if($hfpagers > 1)
{
	$pnhfpager = "004913302";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnhfpager','$hfpagers')";
	mysql_query($insertz) or die(mysql_error());	
}
$fall = $equip["TotalFallUnits"];
if($fall <> 0)
{
	$pnfall = "006617101";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnfall','$fall')";
	mysql_query($insertz) or die(mysql_error());	
}
$chair90 = $equip["chair90day"];
if($chair90 <> 0)
{
	$pnchair90 = "37400002";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnchair90','$chair90')";
	mysql_query($insertz) or die(mysql_error());	
}
$chair180 = $equip["chair180day"];
if($chair180 <> 0)
{
	$pnchair180 = "37400001";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnchair180','$chair180')";
	mysql_query($insertz) or die(mysql_error());	
}
$bed90 = $equip["bed90day"];
if($bed90 <> 0)
{
	$pnbed90 = "37400004";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnchair90','$chair90')";
	mysql_query($insertz) or die(mysql_error());	
}
$bed180 = $equip["bed180day"];
if($bed180 <> 0)
{
	$pnbed180 = "37400003";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnchair180','$chair180')";
	mysql_query($insertz) or die(mysql_error());	
}
$ut = $equip["UTs"];
$utpower = $equip['utpower'];
if($ut <> 0 && $utpower == "yes")
{
	$pnut = "006129500";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnut','$ut')";
	mysql_query($insertz) or die(mysql_error());	
}elseif($ut <> 0 && $utpower == "no")
{
	$pnut = "006129501";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnut','$ut')";
	mysql_query($insertz) or die(mysql_error());
}	
//$utfunction = strip_tags($equip["UTFunction"]);
$client = $equip["TotalClientStations"];
if($client <> 0)
{
	$pnclient = "38011011";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnclient','$client')";
	mysql_query($insertz) or die(mysql_error());
}
//$clientl = strip_tags($equip["ClientStationlocation"]);
$power = $equip["TotalCentralPowerSupplies"];
if($power <> 0)
{
	$pnpower = "90000013";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnpower','$power')";
	mysql_query($insertz) or die(mysql_error());
}
//$job = $equip["joboverview"];
$wirex = $equip["Wire162"];
if($wirex <> 0)
{
	$pnwirex = "90000015";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnwirex','$wirex')";
	mysql_query($insertz) or die(mysql_error());
}
$wirey = $equip["Wire224"];
if($wirey <> 0)
{
	$pnwirey = "90000018";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnwirey','$wirey')";
	mysql_query($insertz) or die(mysql_error());
}
/* 		UNKNOWN PN
$squeeze = $equip["Squeezeball"];
if($squeeze <> 0)
{
	$pnsqueeze = "90000018";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnsqueeze','$squeeze')";
	mysql_query($insertz) or die(mysql_error());
}
*/
$breath = $equip["breathcall"];
if($breath <> 0)
{
	$pnbreath = "90000067";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnbreath','$breath')";
	mysql_query($insertz) or die(mysql_error());
}
//$bed = $equip["bedpullcords"];
//$beda = $equip["bedpullcordsact"];
//$bath = $equip["bathpullcords"];
//$batha = $equip["bathpullcordsact"];
//$common = $equip["commonpullcords"];
//$commona = $equip["commonpullcordsact"];
$pendant = $equip["pendant"];
if($pendant <> 0)
{
	$pnpendant = "00700962";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnpendant','$pendant')";
	mysql_query($insertz) or die(mysql_error());
}
$watchstyle = $equip["watchstyle"];
if($watchstyle <> 0)
{
	$pnwatchstyle = "00700961";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnwatchstyle','$watchstyle')";
	mysql_query($insertz) or die(mysql_error());
}
$lic = $equip['lic'];
if($lic <> 0)
{
	$pnlic = "39420001";
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnlic','$lic')";
	mysql_query($insertz) or die(mysql_error());
}
$checklic = ($lic + $client);

$query3 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result3 = mysql_query($query3) or die(mysql_error());
$row3 = mysql_fetch_array($result3);
if($row3['SUM(zbracket)'] <> 0)
{
	$pnz = "90000020";
	$qtyz = $row3['SUM(zbracket)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$zpn','$qtyz')";
	mysql_query($insertz) or die(mysql_error());	
}
$query4 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result4 = mysql_query($query4) or die(mysql_error());
$row4 = mysql_fetch_array($result4);
if($row4['SUM(minilockcount)'] <> 0)
{	
	$pnmini = "90000078";
	$qtymini = $row4['SUM(minilockcount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnmini','$qtymini')";
	mysql_query($insertz) or die(mysql_error());	
}	
$query17 = "SELECT SUM(doorunitcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result17 = mysql_query($query17) or die(mysql_error());
$row17 = mysql_fetch_array($result17);
if($row17['SUM(doorunitcount)'] <> 0)
{	
	$pndoor = "900003009";
	$qtydoor = $row17['SUM(doorunitcount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pndoor','$qtydoor')";
	mysql_query($insertz) or die(mysql_error());	
}	

$query6 = "SELECT SUM(outdoordoorunitCount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result6 = mysql_query($query6) or die(mysql_error());
$row6 = mysql_fetch_array($result6);
if($row6['SUM(outdoordoorunitCount)'] <> 0)
{	
	$pnodoor = "003810181";
	$qtyodoor = $row6['SUM(outdoordoorunitCount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnodoor','$qtyodoor')";
	mysql_query($insertz) or die(mysql_error());	
}	
$query7 = "SELECT SUM(utcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result7 = mysql_query($query7) or die(mysql_error());
$row7 = mysql_fetch_array($result7);
if($row7['SUM(utcount)'] <> 0)
{	
	$getuttype = "SELECT utpower1 FROM tblfacilitydoors WHERE utpower1 = 'yes' AND FacilityID = '$f_id'";
	$resgetuttype = mysql_query($getuttype) or die(mysql_error());
	$utpoweryes = mysql_num_rows($resgetuttype);
	$getutpower = "SELECT utpower1 FROM tblfacilitydoors WHERE utpower1 = 'no' AND FacilityID = '$f_id'";
	$resgetuttype = mysql_query($getutpower) or die(mysql_error());
	$utpowerno = mysql_num_rows($resgetuttype);	
	if($utpoweryes > 0)
	{
		$pnutpower = "006129500";
		$qtyutpower = $utpoweryes;
		$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnutpower','$qtyutpower')";
		mysql_query($insertz) or die(mysql_error());	
	}
	if($utpowerno > 0)
	{
		$pnutnopower = "006129501";
		$qtyutnopower = $utpowerno;
		$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnutnopower','$qtyutnopower')";
		mysql_query($insertz) or die(mysql_error());	
	}	
}	
$query8 = "SELECT SUM(pircount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result8 = mysql_query($query8) or die(mysql_error());
$row8 = mysql_fetch_array($result8);
if($row8['SUM(pircount)'] <> 0)
{	
	$pnpir = "90000012";
	$qtypir = $row8['SUM(pircount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnpir','$qtypir')";
	mysql_query($insertz) or die(mysql_error());	
}	
$query9 = "SELECT SUM(reedswitchcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result9 = mysql_query($query9) or die(mysql_error());
$row9 = mysql_fetch_array($result9);
if($row9['SUM(reedswitchcount)'] <> 0)
{	
	$pnreed = "90000006";
	$qtyreed = $row9['SUM(reedswitchcount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnreed','$qtyreed')";
	mysql_query($insertz) or die(mysql_error());	
}	
$query10 = "SELECT SUM(keypadcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result10 = mysql_query($query10) or die(mysql_error());
$row10 = mysql_fetch_array($result10);
if($row10['SUM(keypadcount)'] <> 0)
{	
	$pnkey = "90000011";
	$qtykey = $row10['SUM(keypadcount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnkey','$qtykey')";
	mysql_query($insertz) or die(mysql_error());	
}
$query11 = "SELECT SUM(pushbuttoncount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result11 = mysql_query($query11) or die(mysql_error());
$row11 = mysql_fetch_array($result11);
if($row11['SUM(pushbuttoncount)'] <> 0)
{	
	$pnpush = "90000009";
	$qtypush = $row11['SUM(pushbuttoncount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnpush','$qtypush')";
	mysql_query($insertz) or die(mysql_error());	
}
$query12 = "SELECT SUM(outdoorreedcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result12 = mysql_query($query12) or die(mysql_error());
$row12 = mysql_fetch_array($result12);
if($row12['SUM(outdoorreedcount)'] <> 0)
{	
	$pnoreed = "90000084";
	$qtyoreed = $row12['SUM(outdoorreedcount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnoreed','$qtyoreed')";
	mysql_query($insertz) or die(mysql_error());	
}
$query13 = "SELECT SUM(timercount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result13 = mysql_query($query13) or die(mysql_error());
$row13 = mysql_fetch_array($result13);
if($row13['SUM(timercount)'] <> 0)
{	
	$pntimer = "90000003";
	$qtytimer = $row13['SUM(timercount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pntimer','$qtytimer')";
	mysql_query($insertz) or die(mysql_error());	
}  	
$query15 = "SELECT SUM(racepackcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result15 = mysql_query($query15) or die(mysql_error());
$row15 = mysql_fetch_array($result15);
if($row15['SUM(racepackcount)'] <> 0)
{	
	$pnrace = "90000127";
	$qtyrace = $row15['SUM(racepackcount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnrace','$qtyrace')";
	mysql_query($insertz) or die(mysql_error());	
}  
$query16 = "SELECT SUM(relaycount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result16 = mysql_query($query16) or die(mysql_error());
$row16 = mysql_fetch_array($result16);
if($row16['SUM(relaycount)'] <> 0)
{	
	$pnrelay = "90000014";
	$qtyrelay = $row16['SUM(relaycount)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnrelay','$qtyrelay')";
	mysql_query($insertz) or die(mysql_error());	
}
$query177 = "SELECT SUM(zbracketoutdoor) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result177 = mysql_query($query177) or die(mysql_error());
$row177 = mysql_fetch_array($result177);
if($row177['SUM(zbracketoutdoor)'] <> 0)
{	
	$pnozlock = "90000054";
	$qtyozlock = $row177['SUM(zbracketoutdoor)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnozlock','$qtyozlock')";
	mysql_query($insertz) or die(mysql_error());	
}
$query178 = "SELECT SUM(egresskit) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$result178 = mysql_query($query178) or die(mysql_error());
$row178 = mysql_fetch_array($result178);
if($row178['SUM(egresskit)'] <> 0)
{	
	$pnekit = "90000021";
	$qtyekit = $row177['SUM(egresskit)'];
	$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnekit','$qtyekit')";
	mysql_query($insertz) or die(mysql_error());	
}
$sum = ($wmu+ $owmu + $sowmu);
$basesum = ($sum + $row17['SUM(doorunitcount)']);
if($equip['baseconnect']=="network")
{
	if($basesum < 60)
	{
		$baseunitserial = 0;
		$baseunitnet = 1;
	}
	if($basesum  > 59)
	{
		$baseunitserial = 0;
		$baseunitx = ceil($basesum/ 60);
		$baseunitnet = $baseunitx;
	}
}else
{	
	if($basesum < 60)
	{
		$baseunitserial = 1;
		$baseunitnet = 0;
	}
	if($basesum > 59)
	{
		$baseunitserial = 1;
		$baseunitx = ceil($basesum / 60);
		$baseunitnet = ($baseunitx - 1);
	}
}
$baseconnect = $equip["baseconnect"];
if($baseunitnet <> 0)
{	
	if($baseconnect == "serial")
	{
		$pnnet = "003810188";
		$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnnet','$baseunitnet')";
		mysql_query($insertz) or die(mysql_error());	
	}else
	{
		$pnnet = "003810188";
		$qtynet = ($baseunitnet - 1);
		$insertz = "INSERT INTO tblquotedetails (QuoteID,PartNumber,Quantity) VALUES ('$quoteid','$pnnet','$qtynet')";
		mysql_query($insertz) or die(mysql_error());
	}
}
?>
<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">'; ?>
<table width = "750" border = "1" cellpadding = "2">
	<tr>
		<td colspan = "2">
			Added Discount
		</td>
		<td>			
				%<input type="text" size="6" maxlength="6" name="discount" value ="<?php echo $discountselected; ?>">	
		</td>
		<td colspan = "3">
			<input type="submit" value="Save" name="Click">
		</td>
	</tr> 
	<tr>
		<td width = 25 align = "center">
			Line
		</td>
		<td width = 90 align = "center">
			Part Number
		</td>
		<td width = 375 align = "center">
			Part Description
		</td>
		<td width = 80 align = "center">
			Unit Price
		</td>
		<td width = 35 align = "center">
			Qty
		</td>
		<td width = 35 align = "center">
			Discount
		</td>		
		<td width = 155 align = "center">
			Ext. Price
		</td>
	</tr>
<?php
$querydiscount = "SELECT Discount From tblquotegeneral WHERE FacilityID = '$f_id'";
$resquerydiscount = mysql_query($querydiscount) or die(mysql_error());
$rowquerydiscount = mysql_fetch_array($resquerydiscount);
$inputdiscount = $rowquerydiscount['Discount'];

$useddiscount = ($inputdiscount / 100);
$discount2 = (1 - $useddiscount);
$query = "SELECT PartNumber FROM tblquotedetails WHERE QuoteID='$quoteid'"; 
$result = mysql_query($query) or die(mysql_error());
$a=0;
$finalprice = 0;
while($row = mysql_fetch_array($result))
{
	$pn = $row['PartNumber'];
	$query1 = "SELECT Quantity FROM tblquotedetails WHERE PartNumber='$pn' AND QuoteID = '$quoteid'"; 
	$result1 = mysql_query($query1) or die(mysql_error());
	$row1 = mysql_fetch_array($result1);
	if($row1['Quantity'] <> 0)
	{
		$a = $a + 1;
		$query100 = "SELECT * FROM tblpartslist WHERE PartNumber = '$pn'";
		$result100 = mysql_query($query100);
		while($row100 = mysql_fetch_array($result100))
		{
   		$pn1 = $row100['ChildPart1'];
   		$getchildreninfo = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn1'";
   		$resgetchildreninfo = mysql_query($getchildreninfo) or die(mysql_error());
   		$child1 = mysql_fetch_array($resgetchildreninfo);
  	 	$pn2 = $row100['ChildPart2'];
  	 	$getchildreninfo2 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn2'";
  	 	$resgetchildreninfo2 = mysql_query($getchildreninfo2) or die(mysql_error());
  	 	$child2 = mysql_fetch_array($resgetchildreninfo2);
  	 	$pn3 = $row100['ChildPart3'];
   		$getchildreninfo3 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn3'";
   		$resgetchildreninfo3 = mysql_query($getchildreninfo3) or die(mysql_error());
   		$child3 = mysql_fetch_array($resgetchildreninfo3);   	
   		$pn4 = $row100['ChildPart4'];
   		$getchildreninfo4 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn4'";
   		$resgetchildreninfo4 = mysql_query($getchildreninfo4) or die(mysql_error());
   		$child4 = mysql_fetch_array($resgetchildreninfo4);   	
   		$pn5 = $row100['ChildPart5'];
   		$getchildreninfo5 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn5'";
   		$resgetchildreninfo5 = mysql_query($getchildreninfo5) or die(mysql_error());
   		$child5 = mysql_fetch_array($resgetchildreninfo5); 
   		$pn6 = $row100['ChildPart6'];
  	 	$getchildreninfo6 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn6'";
  	 	$resgetchildreninfo6 = mysql_query($getchildreninfo6) or die(mysql_error());
  	 	$child6 = mysql_fetch_array($resgetchildreninfo6);	
  	 	$pn7 = $row100['ChildPart7'];
  	 	$getchildreninfo7 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn7'";
   		$resgetchildreninfo7 = mysql_query($getchildreninfo7) or die(mysql_error());    	
   	 	$child7 = mysql_fetch_array($resgetchildreninfo7);    	
 	  	$pn8 = $row100['ChildPart8'];
  	 	$getchildreninfo8 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn8'";
	   	$resgetchildreninfo8 = mysql_query($getchildreninfo8) or die(mysql_error());
 	  	$child8 = mysql_fetch_array($resgetchildreninfo8);
  	 	$pn9 = $row100['ChildPart9'];
   		$getchildreninfo9 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn9'";
   		$resgetchildreninfo9 = mysql_query($getchildreninfo9) or die(mysql_error());
   		$child9 = mysql_fetch_array($resgetchildreninfo9);
			$pn10 = $row100['ChildPart10'];
			$getchildreninfo10 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn10'";
 	  	$resgetchildreninfo10 = mysql_query($getchildreninfo10) or die(mysql_error());
  	 	$child10 = mysql_fetch_array($resgetchildreninfo10);
 	  	$pn11 = $row100['ChildPart11'];
  	 	$getchildreninfo11 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn11'";
  	 	$resgetchildreninfo11 = mysql_query($getchildreninfo11) or die(mysql_error());
  	 	$child11 = mysql_fetch_array($resgetchildreninfo11);
			$pn12 = $row100['ChildPart12'];
			$getchildreninfo12 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn12'";
  	 	$resgetchildreninfo12 = mysql_query($getchildreninfo12) or die(mysql_error());
 	  	$child12 = mysql_fetch_array($resgetchildreninfo12); 	 
 	  	if($child1['PartNumber'] == "38270001")
 	  	{
 	  		if(($checklic > 4) && (($pn == "90380001") OR ($pn == "90380002") OR ($pn == "90380003") OR ($pn == "90380006") OR ($pn == "90380007")))
 	  		{ 		
 	  			$pn1 = "900005026";
   				$getchildreninfo = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn1'";
   				$resgetchildreninfo = mysql_query($getchildreninfo) or die(mysql_error());
   				$child1 = mysql_fetch_array($resgetchildreninfo);
 	  		}
 	  	}
 	  	if($child3['PartNumber'] == "003810152")
 	  	{
 	  		if(($baseconnect == "network") && (($pn == "90380001") OR ($pn == "90380002") OR ($pn == "90380003") OR ($pn == "90380006") OR ($pn == "90380007")))
 	  		{ 		
 	  			$pn3 = "003810188";
   				$getchildreninfo3 = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn3'";
   				$resgetchildreninfo3 = mysql_query($getchildreninfo3) or die(mysql_error());
   				$child3 = mysql_fetch_array($resgetchildreninfo3);
 	  		}
 	  	} 	  	
	
?>   	
			<tr>
				<td align = "left">
					<?php echo $a; ?>
				</td>
				<td align = "left">
					<?php echo $row100['PartNumber']; ?>
				</td>
				<td align = "left">
					<?php echo $row100['Description']; ?>
				</td>
				<td align = "right">
<?php 
					if(($pn == "90380001") OR ($pn == "90380002") OR ($pn == "90380003") OR ($pn == "90380006") OR ($pn == "90380007") OR ($pn == "38011011"))
					{
						$partprice = (($child1['ListPrice'] + $child2['ListPrice'] + $child3['ListPrice'] + $child4['ListPrice'] + $child5['ListPrice'] + $child6['ListPrice'] + $child7['ListPrice'] + $child8['ListPrice'] + $child9['ListPrice'] + $child10['ListPrice'] + $child11['ListPrice'] + $child12['ListPrice']) * ($pricepercentage));
					}else
					{
					$partprice = ($row100['ListPrice'] * $pricepercentage);
					}
					$partprice = round($partprice,2); 
					echo '$'.number_format($partprice,2);										
?>
					
				</td>		
				<td align = "right">
					<?php echo $row1['Quantity']; ?>
				</td>
				<td>
					<input type="text" size="5" maxlength="6" name="discountind" value = "<?php echo $inputdiscount; ?> ">
				</td>			
				<td align = "right">
<?php
				$extprice = (($partprice * $row1['Quantity'])*($discount2));			
				echo '$'.number_format($extprice,2); 
				
				$finalprice = $extprice + $finalprice;
?>
				</td>
			</tr>	
<?php
			if($child1['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
<?php						
						echo $child1['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child1['Description']; ?>
					</td>
					<td align = "right">
						0.00 <?php $child1['ListPrice']; ?>
					</td>		
					<td align = "right">
<?php  
						if($child1['Family'] <> "MANUALS") 
						{
							echo ($child1['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child1['Quantity'];
						}
?>
					</td>
					<td>
					</td>
					<td align = "right">
						$0.00
					</td>
				</tr>	
<?php
			}
			if($child2['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>	
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child2['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child2['Description']; ?>
					</td>
					<td align = "right">
						0.00 <?php $child2['ListPrice']; ?>
					</td>		
					<td align = "right">
<?php  
						if($child2['Family'] <> "MANUALS") 
						{
							echo ($child2['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child2['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>
<?php
			}
			if($child3['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child3['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child3['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child3['Family'] <> "MANUALS") 
						{
							echo ($child3['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child3['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php	
			}
			if($child4['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child4['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child4['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child4['Family'] <> "MANUALS") 
						{
							echo ($child4['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child4['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
			if($child5['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child5['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child5['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child5['Family'] <> "MANUALS") 
						{
							echo ($child5['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child5['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
			if($child6['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child6['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child6['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child6['Family'] <> "MANUALS") 
						{
							echo ($child6['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child6['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
			if($child7['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child7['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child7['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child7['Family'] <> "MANUALS") 
						{
							echo ($child7['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child7['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
			if($child8['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child8['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child8['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child8['Family'] <> "MANUALS") 
						{
							echo ($child8['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child8['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
			if($child9['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child9['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child9['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child9['Family'] <> "MANUALS") 
						{
							echo ($child9['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child9['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
			if($child10['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child10['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child10['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child10['Family'] <> "MANUALS") 
						{
							echo ($child10['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child10['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
			if($child11['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child11['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child11['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child11['Family'] <> "MANUALS") 
						{
							echo ($child11['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child11['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
			if($child12['PartNumber'] <> 0)
			{
				$a = $a + 1;
?>
				<tr>
					<td>
						<?php echo $a; ?>
					</td>
					<td align = "left">
						<?php echo $child12['PartNumber']; ?>
					</td>
					<td align = "left">
						<?php echo $child12['Description']; ?>
					</td>
					<td align = "right">
						0.00
					</td>		
					<td align = "right">
<?php  
						if($child12['Family'] <> "MANUALS") 
						{
							echo ($child12['Quantity'] * $row1['Quantity']);
						}else
						{
							echo $child12['Quantity'];
						}
?>
					</td>
					<td>
					</td>					
					<td align = "right">
						$0.00
					</td>
				</tr>		
<?php
			}
		}
	}
}
?>
<tr>
	<td colspan = "6" align = "right"><b>
		Total Price:
	</b></td>
	<td align = "right">		
<?php
	echo '$'.number_format($finalprice,2);
?>
</td>
</tr>
</table>
</form>
<?php
//PDF_save ($p)