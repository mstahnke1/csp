<?php
if(isset($_GET['view']) &&($_GET['view']== 'print'))
	{
		include 'printheader.php';
	} 
		else
	{
		include 'header.php';
	}
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';


//echo '<input type = "hidden" name="f_id" value = "'.$facilityID.'">';	
$facilityID = $_GET["f_id"];

$query = "SELECT * From tblfacilitygeneralinfo WHERE ID='$facilityID'";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result);	
$sman = $row['Salesman'];

  					$conn7 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
	            		mysql_select_db('homefree');
					$query8 = "SELECT id, f_name, l_name FROM employees WHERE id = '$sman' ORDER BY l_name";
					$result8 = mysql_query($query8) or die (mysql_error());
        					while($row8 = mysql_fetch_array($result8))
                     			{  					
  								 	$salesman = $row8['f_name']. ' ' . $row8['l_name'];   									
  							}
  	    				mysql_close($conn7);	
  	    				
include 'includes/config.php';
include 'includes/opendb.php';
$query1 = "SELECT * From tbltotalequipment WHERE FacilityID='$facilityID'";
$result1 = mysql_query($query1) or die (mysql_error());
$row1 = mysql_fetch_array($result1);
$startdate = $row1['startdate'];
$duration = $row1['days'];
$endDate = date('m-d-Y', strtotime("+".$duration." days", strtotime($startdate)));

$query2 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID' Order by doornumber";
$result2 = mysql_query($query2) or die (mysql_error());
$row2 = mysql_fetch_array($result2);

$query3 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result3 = mysql_query($query3) or die(mysql_error());
$row3 = mysql_fetch_array($result3);

$query4 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result4 = mysql_query($query4) or die(mysql_error());
$row4 = mysql_fetch_array($result4);

		$query52 = "SELECT * FROM tbladditionalcontacts WHERE FacilityID='$facilityID'"; 
		$result52 = mysql_query($query52) or die(mysql_error());
		$row52 = mysql_fetch_array($result52);
		
		$query54 = "SELECT * FROM tblprojectmanagement WHERE FacilityID='$facilityID'"; 
		$result54 = mysql_query($query54) or die(mysql_error());
		$row54 = mysql_fetch_array($result54);


$query42 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID' Order by doornumber";
$result42 = mysql_query($query42) or die (mysql_error());

$query82 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID' AND doortype = 'doortype9' Order by doornumber";
$result82 = mysql_query($query82) or die (mysql_error());
$row82 = mysql_num_rows($result82);

$query83 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID' AND doortype = 'doortype7' Order by doornumber";
$result83 = mysql_query($query83) or die (mysql_error());
$row83 = mysql_num_rows($result83);

$query17 = "SELECT SUM(doorunitcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result17 = mysql_query($query17) or die(mysql_error());
$row17 = mysql_fetch_array($result17);

$query5 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result5 = mysql_query($query5) or die(mysql_error());
$row5 = mysql_fetch_array($result5);

$query6 = "SELECT SUM(outdoordoorunitCount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result6 = mysql_query($query6) or die(mysql_error());
$row6 = mysql_fetch_array($result6);

$query7 = "SELECT SUM(utcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result7 = mysql_query($query7) or die(mysql_error());
$row7 = mysql_fetch_array($result7);

$query8 = "SELECT SUM(pircount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result8 = mysql_query($query8) or die(mysql_error());
$row8 = mysql_fetch_array($result8);

$query9 = "SELECT SUM(reedswitchcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result9 = mysql_query($query9) or die(mysql_error());
$row9 = mysql_fetch_array($result9);

$query10 = "SELECT SUM(keypadcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result10 = mysql_query($query10) or die(mysql_error());
$row10 = mysql_fetch_array($result10);

$query11 = "SELECT SUM(pushbuttoncount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result11 = mysql_query($query11) or die(mysql_error());
$row11 = mysql_fetch_array($result11);

$query12 = "SELECT SUM(outdoorreedcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result12 = mysql_query($query12) or die(mysql_error());
$row12 = mysql_fetch_array($result12);

$query13 = "SELECT SUM(timercount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result13 = mysql_query($query13) or die(mysql_error());
$row13 = mysql_fetch_array($result13);

$query14 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result14 = mysql_query($query14) or die(mysql_error());
$row14 = mysql_fetch_array($result14);
  	
$query15 = "SELECT SUM(racepackcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result15 = mysql_query($query15) or die(mysql_error());
$row15 = mysql_fetch_array($result15);

$query16 = "SELECT SUM(relaycount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result16 = mysql_query($query16) or die(mysql_error());
$row16 = mysql_fetch_array($result16);

$query177 = "SELECT SUM(zbracketoutdoor) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result177 = mysql_query($query177) or die(mysql_error());
$row177 = mysql_fetch_array($result177);

$query178 = "SELECT SUM(egresskit) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result178 = mysql_query($query178) or die(mysql_error());
$row178 = mysql_fetch_array($result178);

$query70 = "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID'";
$result70 = mysql_query($query70) or die(mysql_error());
$row70 = mysql_num_rows($result70);	

$query71 = "SELECT * From tblprojectmanagement WHERE FacilityID='$facilityID'";
$result71 = mysql_query($query71) or die(mysql_error());
$row71 = mysql_num_rows($result71);	

$query78 = "SELECT * From tblprojectmanagement WHERE FacilityID='$facilityID'";
$result78 = mysql_query($query78) or die(mysql_error());
$row78 = mysql_fetch_array($result78);	

$name = $row52["Name"];
$title = $row52["Title"];
$phone = $row52["Phone"];
$name1 = $row52["Name1"];
$title1 = $row52["Title1"];
$phone1 = $row52["Phone1"];
$name2 = $row52["Name2"];
$title2 = $row52["Title2"];
$phone2 = $row52["Phone2"];
$name3 = $row52["Name3"];
$title3 = $row52["Title3"];
$phone3 = $row52["Phone3"];
$name4 = $row52["Name4"];
$title4 = $row52["Title4"];
$phone4 =$row52["Phone4"];
$champ = $row52["SystemChamp"];
$champtitle = $row52["ChampionTitle"];
$champphone = $row52["ChampionPhone"];
$livedate = $row54['LiveDate'];
$remote = $row54['Remote'];
$marshall = $row54['marshall'];
$panel = $row54['panel'];
$fire = $row54['fire'];
$timers = $row54['timers'];
$connection = $row54['connectiont'];
$doorcompany = $row54['doorcompany'];
$wellness = $row54['wellness'];
$comments =  nl2br($row54['comments']); 	
$champ1 = $row52["SystemChamp1"];
$champtitle1 = $row52["ChampionTitle1"];
$champphone1 = $row52["ChampionPhone1"];
$champ2 = $row52["SystemChamp2"];
$champtitle2 = $row52["ChampionTitle2"];
$champphone2 = $row52["ChampionPhone2"];


//Some Equipment Variables for Math
$Area = $row1["TotalWMUs"];
$OArea = $row1["TotalOutdoorAreaUnits"];
$SArea = $row1["TotalOutdoorSolarUnits"];
$sum = ($Area + $SArea + $OArea);
$basesum =  ($sum + $row17['SUM(doorunitcount)']);
	?>
			
<table align = "center" width = "500">
	<tr>
		<td align=center><u><font size=5 face = "Arial"><strong>   Scope of Work/Sale Summary  </strong></u></td>
	</tr>
	<table align="center" width="500">
<?php
	if(!(isset($_GET['view']) &&($_GET['view']== 'print')))
	{
?>
		<tr>
		<td><font size=3 face = "Arial">
			<a href="javascript:void(0)"onclick="window.open('<?php echo $_SERVER['PHP_SELF'].'?f_id='.$row['ID'].'&view=print'; ?>')">Print</a>
		</font></td>
	</tr>
<?php
	}
?>
	<tr>                                                            
    	<td align="center" td colspan="2"><font size="5" face = "Arial"><strong> 
    		<?php echo stripslashes($row['FacilityName']); ?>
    	</strong></td>
	</tr>
  <tr>
  	<td align="center" td colspan="2"><font size="3" face = "Arial"><strong>
  		<?php echo $row['StreetAddress']; ?>
  	</strong></td>		
  </tr>
  <tr>
		<td align=center colspan="2"><b>
			<?php echo '<a href="' . 'Updatescope.php'.'?equip=general&view=update&f_id='.$facilityID.'">'?>  Sales Contact  
		</b></td>
	</tr>                  	
	<tr>
  </tr>
  <tr>
  </tr>
	<tr>
		<td><font size="2" face = "Arial">
			Contanct Name:  <?php echo $row['ContactName'] ?>
		</td>
		<td><font size="2" face = "Arial">
			Title: <?php echo $row['Title']; ?>
		</td>
	</tr>
	<tr>
		<td><font size="2" face = "Arial">
			Phone Number: <?php echo formatPhone($row['PhoneNumber']); ?>
		</td>
		<td>
			<font size="2" face = "Arial">2nd Number: <?php echo formatPhone($row['secondnumber']); ?>
		</td>
	</tr>
  <tr>
  	<td><font size="2" face = "Arial">
  		System Type:  <?php echo $row['SystemType']; ?>
  	</td>
		<td><font size="2" face = "Arial">
			Fax:	<?php echo formatPhone($row['Fax']); ?>
		</td>
	</tr>
  <tr>
  	<td align="center" colspan="2"><font size="2" face = "Arial">
  		Email: <?php echo $row['Email']; ?>
  	</td>
	</tr>
  <tr>
  	<td><font size="2" face = "Arial">
  		HomeFree Sales Representative: <?php echo $salesman; ?>
  	</td>
    <td><b><font size="2" face = "Arial">
    	Quote Expires:	<?php echo $endDate; ?>
    </b></td>
	</tr>
</table>
<table width ="750" align="center">
	<tr>
		<td colspan="2"><div align="center"><hr width="100%"></div></td>
	</tr>
	<tr>
	<tr>
		<td><u><font size="2" face = "Arial">
			<?php echo '<a href="' . 'Updatescope.php'.'?equip=jobdescription&view=update&f_id='.$facilityID.'">'?>Job Overview
		</u></td></tr>
		<td><font size="2" face = "Arial">
			<?php echo $row1['joboverview']; ?> 
		</td>
	</tr>
	<tr>
		<td colspan="2"><div align="center"><hr width="100%"></div></td>
	</tr>
	<tr>
		<td><u>
			<?php echo '<a href="' . 'Updatescope.php'.'?equip=otherinfo&view=update&f_id='.$facilityID.'">'?>Key Contacts
		</u></td>
	</tr>
</table>
<table align = "center" width = "750" cellpadding=3>
<?php
if($name <> "none")
{
?>
	<tr>
		<td><font size="2" face = "Arial">
			Name: <?php echo $name; ?> 
		</td>
		<td>
			Title: <?php echo $title; ?> 
		</td>
		<td> Phone: <?php echo formatPhone($phone); ?> 
		</td>
	</tr>
<?php
}
if ($name1 <> "none")
{
?>
	<tr>
		<td><font size="2" face = "Arial">
			Name: <?php echo $name1; ?> 
		</td>
		<td> Title: <?php echo $title1; ?> 
		</td>
		<td>Phone: <?php echo formatPhone($phone1); ?> 
		</td>
	</tr>
<?php
}
if($name2 <> "none")
{
?>
	<tr>
		<td>
			<font size="2" face = "Arial">Name: <?php echo $name2; ?> 
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
if($name3 <> "none")
{
?>
	<tr>
		<td><font size="2" face = "Arial">
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
if($name4 <> "none")
{
?>
	<tr>
		<td><font size="2" face = "Arial">
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
	<tr>
		<td><u>
			System Champion
		</u></td>
	</tr>
	<tr>
		<td><font size="2" face = "Arial">
			Name: <?php echo $champ; ?>
		</td>
		<td> 
			Title: <?php echo $champtitle; ?> 
		</td>
		<td>
			Phone: <?php echo formatPhone($champphone); ?> 
		</td>
	</tr>
	<tr>
		<td><font size="2" face = "Arial">
			Name: <?php echo $champ1; ?>
		</td>
		<td> 
			Title: <?php echo $champtitle1; ?> 
		</td>
		<td>
			Phone: <?php echo formatPhone($champphone1); ?> 
		</td>
	</tr>
	<tr>
		<td><font size="2" face = "Arial">
			Name: <?php echo $champ2; ?>
		</td>
		<td>
			Title: <?php echo $champtitle2; ?> 
		</td>
		<td>
			Phone: <?php echo formatPhone($champphone2); ?> 
		</td>
	</tr>
</table>
<table align = "center" width = "750" cellpadding=3>
	<tr>
		<td colspan="2"><div align="center"><hr width="100%"></div></td>
	</tr>
	<tr>
		<td><font size="2" face = "Arial"><u>
			Anticipated Live Date:</u> <?php echo $livedate; ?>
		</td>
	</tr>
	<tr>
		<td><font size="2" face = "Arial"><u>
			Remote Access Type:</u> <?php echo $remote; ?>
		</td>
	</tr>
	<tr>
		<td colspan="6"><div align="center"><hr width="100%"></div></td>
	</tr>
</table>
<table align ="center" width = "750" cellpadding="2">                    	
	<tr>
		<td colspan="2"><b>
			<?php echo '<a href="' . 'Updatescope.php'.'?equip=network&view=update&f_id='.$facilityID.'">'?>  Network
		</b></td>
	</tr>
<?php	
if($row1['baseconnect']=="network")
{
	if($basesum < 60)
	{
		$baseunitserial = 0;
		$baseunitnet = 1;
	}
	if($basesum  > 60)
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
	if($basesum > 60)
	{
		$baseunitserial = 1;
		$baseunitx = ceil($basesum / 60);
		$baseunitnet = ($baseunitx - 1);
	}
}
if(!$baseunitserial==0)
{			
?>
	<tr>
		<td><font size="2" face = "Arial"> 
			Base Units via Serial Port:<?php echo $baseunitserial; ?>  
			</td>		
	</tr>
<?php
}
if(!$baseunitnet==0)
{
?>
	<tr>
		<td> <font size="2" face = "Arial">
			Base Units via Network:<?php echo $baseunitnet; ?> 
		</td>
	</tr>
<?php
}
if (!$row1['TotalWMUs']==0)
{	
?>
		<tr>
			<td>
				Area Units: <?php echo $row1['TotalWMUs']; ?>
			</td>
		</tr>
<?php
}
if(!$row1['TotalOutdoorAreaUnits']==0)
{	
?>	
	<tr>
		<td>
			Outdoor Area Units: <?php echo $row1['TotalOutdoorAreaUnits']; ?>
		</td>
	</tr>
<?php	
}
if(!$row1['TotalOutdoorSolarUnits']==0)
{
?>	
	<tr>
		<td>
			Solar Area Units: <?php echo $row1['TotalOutdoorSolarUnits']; ?>
		</td>
	</tr>
<?php
}
if($baseunitnet > 0)
{
?>
	<tr>
		<td><font size="2" face = "Arial">
			**  Base Units connected via a network  require a connection to the Local Area Connection that is on the same Local Subnet as the HomeFree Server.  Please contact the HomeFree Technical Department for any further questions.
		</td>
	</tr>
<?php
}
?>   
	<tr>
		<td colspan="6"><div align="center"><hr width="100%"></div></td>
	</tr>
</table>
<table align ="center" width = "750" cellpadding="2">
	<tr>
		<td><b><font size=5 ><font size="5" face = "Arial"><strong>
			Systems
		</strong></b></td>
	</tr>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>	
<?php
if($row9['SUM(reedswitchcount)'] <> 0)
{
?>
	<tr>
		<td><font size="2" face = "Arial">
			<font color="#000000" face = "Arial"><strong><u>Wandering and/or Door Control System
		</strong></u></td>
	</tr>
<?php
if($row1['TotalWatches'] <> 0 OR $row1['TotalWatches'] == "TBD")
{	
?>	
	<tr>	
		<td colspan="2"><b>
			<?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$facilityID.'">'?>  Watches:</a></b>   <?php echo $row1['TotalWatches']; ?>
		</td>
	</tr>
<?php
}
if($row9['SUM(reedswitchcount)'] <> 0)
{
?>
	<tr>
		<td colspan="2">
			<font color="#000000" face = "Arial"><u>
			Door Equipment
		</u></td>
  </tr>
<?php  
}
if(!$row17['SUM(doorunitcount)']==0)
{
?>
	<tr>                                                            
  	<td colspan="2">
  		<font color="#000000" face = "Arial">
  		Door Units: 
  		<?php echo $row17['SUM(doorunitcount)']; ?>
  	</td>
  </tr>
<?php
}
if(!$row6['SUM(outdoordoorunitCount)']==0)
{
?>
	<tr>
    <td colspan="2">
    <font color="#000000" face = "Arial">
    Outdoor Units:
    <?php echo $row6['SUM(outdoordoorunitCount)']; ?>
   </td>
	</tr>
<?php
}
if(!$row7['SUM(utcount)']==0)
{
?>
	<tr>                                                            
    <td colspan="2">
    	<font color="#000000" face = "Arial">
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
			<font color="#000000" face = "Arial">
				Reed Switches: <?php echo $row9['SUM(reedswitchcount)']; ?>
			</td>
  	</tr>
<?php  	
  	}
  		if(!$row12['SUM(outdoorreedcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Outdoor Reed Switches: '. $row12['SUM(outdoorreedcount)'] . '</td>';
  	echo '</tr>';
  	}  	
  		if(!$row8['SUM(pircount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Passive Infared Detectors: '. $row8['SUM(pircount)'] . '</td>';
  	echo '</tr>';
  	}
  		if(!$row10['SUM(keypadcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Keypads: '. $row10['SUM(keypadcount)'] . '</td>';
  	echo '</tr>';
  	}
  		if(!$row11['SUM(pushbuttoncount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Pushbuttons: '. $row11['SUM(pushbuttoncount)'] . '</td>';
  	echo '</tr>';
  	}
		if(!$row13['SUM(timercount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Timers: '. $row13['SUM(timercount)'] . '</td>';
  	echo '</tr>';
  	}
  		if(!$row14['SUM(minilockcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Mini Locks: '. $row14['SUM(minilockcount)'] . '</td>';
  	echo '</tr>';
  	}
		if(!$row5['SUM(zbracket)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Z Bracket Locks: '. $row5['SUM(zbracket)'] . '</td>';
  	echo '</tr>';
  	}
  	if(!$row177['SUM(zbracketoutdoor)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Outdoor Z Bracket Locks: '. $row177['SUM(zbracketoutdoor)'] . '</td>';
  	echo '</tr>';
  	}
  	if(!$row178['SUM(egresskit)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Egress Kits: '. $row178['SUM(egresskit)'] . '</td>';
  	echo '</tr>';
  	}  	
  	if(!$row16['SUM(relaycount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Deactivation Relays: '. $row16['SUM(relaycount)'] . '</td>';
  	echo '</tr>';
  	}  	
  		if(!$row15['SUM(racepackcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000" face = "Arial">Raceway Packs: '. $row15['SUM(racepackcount)'] . '</td>';
  	echo '</tr>';
  	}
  	
  	
	if(!($row14['SUM(minilockcount)']==0 & ($row5['SUM(zbracket)']==0)))
	{
?>
		
	<tr>
		<td><font color="#000000" face = "Arial">Magnetic Lock Information</td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">Fire Marshall Approval: <?php echo $marshall;; ?> </td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">Connection to fire Panel: <?php echo $panel; ?> </td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">Fire Company: <?php echo $fire; ?> </td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">Timers (Schedule): <?php echo $timers; ?> </td>
	</tr>

	<?php
	}

		
if($row82 > 0)
	{
?>
	<tr>
		<td><font color="#000000" face = "Arial">Elevators</td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">Connection Company: <?php echo $connection; ?> </td>
	</tr>
<?php
}
if($row83 > 0)
	{
?>
	<tr>
		<td><font color="#000000" face = "Arial">Automatic Doors</td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">Door Company: <?php echo $doorcompany; ?> </td>
	</tr>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
<?php
}}
?>

	<?php
if (!($row1['TotalPanicButtons'] == 0 & ($row1['TotalPullCords'] == 0 & ($row1['TotalPullCordsactivity']==0))))
{
	{
	?>
	<tr>
		<td><font color="#000000" face = "Arial"><strong><u>Call System</strong></u></td>
	</tr>
	<?php
}
	if (!$row1['TotalPanicButtons'] == 0)
	{
?>
	<tr>
		<td><font color="#000000" face = "Arial"><u><?php echo '<a href="' . 'Updatescope.php'.'?equip=accessories&view=update&f_id='.$facilityID.'">'?>Call Buttons</a></u> (Total Ordered= <?php echo $row1['TotalPanicButtons']; ?>) </u></td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">Pendant Style: <?php echo $row1['pendant']; ?> </td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">Watch style: <?php echo $row1['watchstyle']; ?> </td>
	</tr>
	<?php
}
		if (!$row1['TotalPullTags']==0)
	{	
		?>
		<tr>
		<td><font color="#000000" face = "Arial"><u>Pull Tags</u> (Total Ordered= <?php echo $row1['TotalPullTags']; ?>) </u></td>
	</tr>
		
	
<?php
	}

	if (!($row1['TotalPullCords'] == 0 &  ($row1['TotalPullCordsactivity'] == 0)))
	{
		if (!$row1['TotalPullCords']==0)
	{	
		?>
	<tr>
		<td><font color="#000000" face = "Arial">
			<u><b><?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$facilityID.'">'?>  Pull Cords:</a></u></b>(Total Ordered= <?php echo $row1['TotalPullCords']; ?>) 
		</td>
	</tr>
	<tr>
	<td><font color="#000000" face = "Arial">Bedroom: <?php echo $row1['bedpullcords']; ?> </td>
	</tr>
	<tr>
	<td><font color="#000000" face = "Arial">Bathroom: <?php echo $row1['bathpullcords']; ?> </td>
	</tr>
	<tr>
	<td><font color="#000000" face = "Arial">Common Areas: <?php echo $row1['commonpullcords']; ?> </td>
	</tr>
<?php
}
	if (!$row1['TotalPullCordsactivity']==0)
	{	
?>
		<tr>
			<td><font color="#000000" face = "Arial"><u>Pull Cords with Wellness Check-in:(Total Ordered= <?php echo $row1['TotalPullCordsactivity']; ?>)</u>       Schedule: <?php echo $wellness; ?> </td>
		</tr>
		<tr>
			<td><font color="#000000" face = "Arial">Bedroom: <?php echo $row1['bedpullcordsact']; ?> </td>
		</tr>
		<tr>
			<td><font color="#000000" face = "Arial">Bathroom: <?php echo $row1['bathpullcordsact']; ?> </td>
		</tr>
		<tr>
			<td><font color="#000000" face = "Arial">Common Areas: <?php echo $row1['commonpullcordsact']; ?> </td>
		</tr>
	
	<?php
	}
if (!$row1['TotalCallCords']==0)
	{	
		?>
		<tr>
			<td><font color="#000000" face = "Arial"><u>Call Cords:</u></td>
		</tr>
		<?php
		
		echo '<tr><td>' . '<font color="#000000" face = "Arial">10ft. Call Cords:    ' . $row1['TotalCallCords'] . '</td></tr>';
	}
	if (!$row1['TotalCallCordssingle15']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">15ft. Call Cords:    ' . $row1['TotalCallCordssingle15'] . '</td></tr>';
	}
		if (!$row1['TotalCallCorddual']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Dual Call Cords:    ' . $row1['TotalCallCorddual'] . '</td></tr>';
	}
		if (!$row1['Squeezeball']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Squeeze Balls:    ' . $row1['Squeezeball'] . '</td></tr>';
	}
		if (!$row1['breathcall']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Breath Calls:    ' . $row1['breathcall'] . '</td></tr>';
	}
		if ($row1['CorridorLights']<>"NONE")
	{{
		?>
		<tr>
			<td><font color="#000000" face = "Arial"><u>Corridor Lights:</u></td>
		</tr>
		<?php
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Corridor Light Type:    ' .$row1['CorridorLights'] . '</td></tr>';
	}
		if ($row1['CorridorLightType']<>"NONE")
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Corridor Light Style:    ' . $row1['CorridorLightType'] . '</td></tr>';
	}
		if (!$row1['TotalExistingCorrdiorLights']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Number of Existing Lights:    ' . $row1['TotalExistingCorrdiorLights'] . '</td></tr>';
	}
		if (!$row1['TotalHomeFreeCorrdiorLights']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Number of HomeFree Lights:    ' . $row1['TotalHomeFreeCorrdiorLights'] . '</td></tr>';
	}
}
}else
{
?>
<tr>
	<td colspan="2"><b><?php echo '<a href="' . 'Updatescope.php'.'?equip=pullcords&view=update&f_id='.$facilityID.'">'?>  Add Pull Cords</a></b></td>
</tr>
<?php
}
?>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
	
	<?php
}
			if (!$row1['TotalFallUnits']==0)
			{
				?>
		<tr>
			<td><font color="#000000" face = "Arial"><strong><u><?php echo '<a href="' . 'Updatescope.php'.'?equip=awareunits&view=update&f_id='.$facilityID.'">'?>  Fall Alert System:</a></strong></u></td>
		</tr>
	
		<?php
		if (!$row1['TotalFallUnits']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial"><u>Fall Units:    ' . $row1['TotalFallUnits'] . '</td></tr>';
	}
		if (!$row1['chair90day']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">90 Day Chair Pads:    ' . $row1['chair90day'] . '</td></tr>';
	}
		if (!$row1['chair180day']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">180 Day Chair Pads:    ' . $row1['chair180day'] . '</td></tr>';
	}
		if (!$row1['bed90day']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">90 Day Bed Pads:    ' . $row1['bed90day'] . '</td></tr>';
	}
		if (!$row1['bed180day']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">180 Day Bed Pads:    ' . $row1['bed180day'] . '</td></tr>';
	}
	?>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
<?php
}
?>
	<tr>
		<td><b><font size=5 ><strong><?php echo '<a href="' . 'Updatescope.php'.'?equip=paging&view=update&f_id='.$facilityID.'">'?>  Paging Equipment:</a></strong></b></td>
	</tr>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
	<?php
		if ($row1['PagingBaseType']<>"NONE")
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Paging Base Type:    ' . $row1['PagingBaseType'] . '</td></tr>';
	}
		if ($row1['PagerType']<>"NONE")
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Pager Type:    ' . $row1['PagerType'] . '</td></tr>';
	}
			if (!$row1['PagerQuantity']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Number of ' . $row1['PagerType']. ' Pagers:    ' . $row1['PagerQuantity'] . '</td></tr>';
	}
			if (!$row1['HomeFreePager']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Number of HomeFree Pagers:    ' . $row1['HomeFreePager'] . '</td></tr>';
	}
 ?>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>	
	<?php
	if(!($row1['UTs']==0 &($row1['TotalClientStations']==0 &($row1['TotalCentralPowerSupplies']==0 & ($row1['Wire162']==0 & ($row1['Wire224'] ==0))))))
	{
		?>
<tr>
		<td><b><font size=5 ><strong>  Other Equipment  </strong></b></td>
	</tr>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
<?php
	
		if (!$row1['UTs']==0)
	{
	?>
		<tr>
			<td><font color="#000000" face = "Arial"><strong><u><?php echo '<a href="' . 'Updatescope.php'.'?equip=uts&view=update&f_id='.$facilityID.'">'?>  Universal Transmitters:</a></strong></u></td>
		</tr>
	<?php
	if($row1['utpower']=="yes")
		{
?>
		<tr>
			<td><b>Universal Transmitters are to be connected to the correct power source.</b></td>
		</tr>
	<?php
	}
	if($row1['utpower']=="no")
		{
?>
		<tr>
			<td><b>Universal Transmitters will be powered by battery.</b></td>
		</tr>
	<?php
	}
			echo '<tr><td>' .  '<font color="#000000" face = "Arial">Universal Transmitters:    ' . $row1['UTs'] . '</td></tr>';
?>

		<tr><td><font color="#000000" face = "Arial">Universal Transmitter Function:</td></tr>
		<table align ="center" width = "550">
		<tr><td> <?php  echo $row1['UTFunction'] ;?> </td></tr>
	<?php
	}	
	?>
</table>
</table>
<table align ="center" width = "750" cellpadding="2">
	<?php
	if (!($row1['TotalClientStations']==0 & ($row1['lic']==0)))
	{	
	?>

	<tr>
			<td><font color="#000000" face = "Arial"><strong><u><?php echo '<a href="' . 'Updatescope.php'.'?equip=clients&view=update&f_id='.$facilityID.'">'?>  Client Stations</a></strong></u></td>
	</tr>
	<?php		
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Number of Client Stations (Licenses Included):    ' .$row1['TotalClientStations'] . '</td></tr>';
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Number of Client Licenses:    ' .$row1['lic'] . '</td></tr>';
			
	?>

		<tr><td><font color="#000000" face = "Arial">Client Station Location:</td></tr>
		<table align ="center" width = "550">
		<tr><td> <?php  echo $row1['ClientStationlocation'] ;?> </td></tr>
	<?php
		
	?>
</table>
<table align ="center" width = "750" cellpadding="2">
<?php
if(($row1['lic'] + $row1['TotalClientStations']) > 5)
		{
	?>
			<tr>
				<td> 
					**  There are more than 5 client licenses.  The database type should be Sybase and the Computer used for the HomeFree Server should be upgraded. 
				</td>
			</tr>
<?php
}	
?>

</table>
<table align ="center" width = "750" cellpadding="2">

			<tr>
				<td> 
					**  Client computers require a connection to the Local Area Connection that is on the same Local Subnet as the HomeFree Server.  Please contact the HomeFree Technical Department for any further questions.
				</td>
			</tr>
<?php
}
?>
</table>
<table align ="center" width = "750" cellpadding="2">
<?php
		if ((!$row1['TotalCentralPowerSupplies']==0) & (!($row1['Wire162'] ==0 & ($row1['Wire224'] ==0))))
	{
?>
		<tr>
			<td><font color="#000000" face = "Arial"><strong><u><?php echo '<a href="' . 'Updatescope.php'.'?equip=power&view=update&f_id='.$facilityID.'">'?>Power and Wire</strong></u></td>
		</tr>
<?php
if($row1['powertype'] == "outlets")
{
?>
	<tr>
		<td><font face = "Arial" size = "2">
			The customer is responsible to have power outlets installed in each location according to the layout.
		</font></td>
	</tr>
<?php
}elseif($row1['powertype'] == "cpshf")
{
?>
	<tr>
		<td><font face = "Arial" size = "2">
			HomeFree Installers will install the Central Power Supply(s) and run all necessary wire.
		</font></td>
	</tr>
<?php
}else
{
?>
	<tr>
		<td><font face = "Arial" size = "2">
			The customer will install the Central Power Supply(s) and run all necessary wire.
		</font></td>
	</tr>	
<?php
}
	} elseif(($row1['TotalCentralPowerSupplies']==0) & (!($row1['Wire162'] ==0 & ($row1['Wire224'] ==0))))
	{	
?>
	<tr>
			<td><font color="#000000" face = "Arial"><strong><u>Wire</strong></u></td>
		</tr>
<?php
	}
			if (!$row1['TotalCentralPowerSupplies']==0)
	{		
		echo '<tr><td>' .  '<font color="#000000" face = "Arial">Central Power Supplies:    ' .$row1['TotalCentralPowerSupplies'] . '</td></tr>';
	}
				if (!$row1['Wire162']==0)
	{		
	echo '<tr><td>' .  '<font color="#000000" face = "Arial">16-2 Wire:    ' . $row1['Wire162'] . '</td></tr>';
	}
		if (!$row1['Wire224']==0)
	{		
	echo '<tr><td>' .  '<font color="#000000" face = "Arial">22-4 Wire:    ' . $row1['Wire224'] . '</td></tr>';
}
	?>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
	
	<?php
}
	
	if ($comments <> "none")
	{
		?>	
	<tr>
		<td><?php echo '<a href="' . 'Updatescope.php'.'?equip=projectinfo&view=update&f_id='.$facilityID.'">'?>Additional Comments:</td>	
	</tr>
	<tr>
	<td><?php echo $comments; ?> </td>	
	</tr>
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
    		<td><b><font size=5 ><strong>  Individual Door Information  </strong></b></td>
  	</tr>
  <tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
</table>

<table  align="center" table border ="1" cellpadding=2 width="750">
<?php
		
while ($row42 = mysql_fetch_array($result42))	{
	
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

    

if ($doortype == "doortype1")
		{
			($doortype = "Single Door over 6 ft. 11");
		}
	if ($doortype == "doortype2")
		{
			($doortype = "Double Door over 6 ft. 11");
		}
	if ($doortype == "doortype3")
		{
			($doortype = "Single Interior Door under 6 ft. 11");
		}
	if ($doortype == "doortype4")
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
		
	if($setuptype =="door1")	
		{	
			($alarm=1);
		}
	if($setuptype =="door2")	
		{	
			($alarm=3);
		}
	if($setuptype =="door3")	
		{	
			($alarm=4);
			
		}
	if($setuptype =="door4")	
		{	
			($alarm=5);
		}
	if($setuptype =="door5")	
		{	
			($alarm=6);
		}			
	if($setuptype =="door6")	
		{	
			($alarm=7);
		}			
	if($setuptype =="door7")	
		{	
			($alarm=8);
		}	
	if($setuptype =="door9")	
		{	
			($alarm=9);
		}	
	if($setuptype =="door8")	
		{	
			($alarm=10);
		}	
	if($setuptype =="door10")	
		{	
			($alarm=11);
		}	
	if($setuptype =="door11")	
		{	
			($alarm=12);
		}		
	if($setuptype =="door12")	
		{	
			($alarm=13);
		}	
	if($setuptype =="door13")	
		{	
			($alarm=14);
		}		
	if($setuptype =="door14")	
		{	
			($alarm=15);
		}
	if($setuptype =="door15")	
		{	
			($alarm=16);
		}		
	
				
$query72 = "SELECT * From tbldoorfunction WHERE ID = '$alarm'";
$result72 = mysql_query($query72) or die (mysql_error());
$row72 = mysql_fetch_array($result72);
$alarm =  addslashes($row72['alarmfunction']);
		
	if($setuptype == "door1")
		{
			($setuptype = "Door Unit:  Door Alarms only when the door is open and a Watch is in the door range");
		}	
	if($setuptype == "door2")
		{
			($setuptype = "Door Unit:  Door locks when a Watch is in the door range only and alarms if lock is egressed");
		}	
	if($setuptype == "door3")
		{
			($setuptype = "Door Unit: Locks when scheduled to or when a Watch is in the door range door unit will alarm if watch is present and lock is egressed");
		}	
	if($setuptype == "door4")
		{
			($setuptype = "Door Unit:  Door Alarms only when there is motion and a Watch is in the door range");
		}	
	if($setuptype == "door5")
		{
			($setuptype = "Door Unit:  Deactivate door when a watch enters the area (Sliding\Automatic\Elevator Door only)");
		}
	if($setuptype == "door6")
		{
			($setuptype = "Door Unit:  Door deactivates after the door alarms(Sliding\Automatic\Elevator Door only)");
		}
	if($setuptype == "door7")
		{
			($setuptype = "Lock:  Door locked at all times");
		}
	if($setuptype == "door8")
		{
			($setuptype = "Lock: Scheduled Locking: Door locked on schedule notification only if lock egressed - at unscheduled times no alarms or notifications");
		}
	if($setuptype == "door9")
		{
			($setuptype = "Lock:  Locked at all times, notification if door is opened");
		}
	if($setuptype == "door10")
		{
			($setuptype = "Lock:  Locked at all times, notification if the lock is put into egress");
		}		
	if($setuptype == "door11")
		{
			($setuptype = "Universal Transmitter:  Alarm anytime door is opened");
		}	
	if($setuptype == "door12")
		{
			($setuptype = "Universal Transmitter:  Alarm anytime door is opened and bypass code is not entered");
		}	
	if($setuptype == "door13")
		{
			($setuptype = "Universal Transmitter:  Alarm only when the door is held open for more than a defined time");
		}
	if($setuptype == "door14")
		{
			($setuptype = "HomeFree is not covering this door");
		}
	if($setuptype == "door15")
		{
			($setuptype = "HomeFree is tying a Universal Transmitter into an Existing Lock");
		}		
?>
	<tr>							                                                         
		<td colspan="3"><strong><font color="#000000" face = "Arial">
			Door Number: <?php echo $row42['doornumber'] ?>
		</strong></td>
	</tr>
	<tr>
		<td><strong><font color="#000000" face = "Arial">
			Door Name: <?php echo $row42['doorname'] ?>
		</strong></td>
		<td><strong><font color="#000000" face = "Arial">
			<?php echo $doortype; ?>
		</td>
	</tr>
	<tr>
	</tr>
	<tr>
	</tr>  
	<tr>
		<td colspan="3"><font color="#000000" face = "Arial">
			Door Setup: <?php echo $setuptype; ?>
		</td>
	</tr>
	<tr>
		<td><font color="#000000" face = "Arial">
			Surrounding Construction: <?php echo $surroundingconstruction; ?>
		</td>
 		<td><font color="#000000" face = "Arial">
 			Door Frame: <?php echo $framematerial; ?>
 		</td>
	</tr>
	<tr>

<?php		
	if (!$row42['doorunitcount']==0)
		{
?>			
		<td width = "375"><font color="#000000" face = "Arial">
    	Door Units: <?php echo $row42['doorunitcount']; ?>
		</td>    	
<?php
		}
if (!$row42['reedswitchcount']==0)
		{
?>
    <td width = "375"><font color="#000000" face = "Arial">
			Reed Switches: <?php echo $row42['reedswitchcount']; ?>
		</td>
<?php
		}
?>					
	</tr>
	<tr>	
<?php		
if (!$row42['zbracket']==0)
	{
?>		
		<td><font color="#000000" face = "Arial">
	 		Z Bracket Locks: <?php echo $row42['zbracket']; ?>
		</td>	 		
<?php
	}
if (!$row42['timercount']==0)
	{
?>		
		<td><font color="#000000" face = "Arial">
			Timers: <?php echo $row42['timercount']; ?>
		</td>			
<?php
	}
?>				
	</tr>
	<tr>

<?php
if (!$row42['outdoordoorunitCount']==0)
	{
?>
		<td><font color="#000000" face = "Arial">
			Outdoor Door Unit: <?php echo $row42['outdoordoorunitCount']; ?>
		</td>
<?php			
	}
if (! $row42['outdoorreedcount']==0)
	{
?>		
		<td><font color="#000000" face = "Arial">
      Outdoor Reed Switches: <?php echo $row42['outdoorreedcount']; ?>
    </td>
<?php      
	}
?>
	</tr>
	<tr>
<?php		
if (!$row42['utcount']==0)
	{
?>		
		<td><font color="#000000" face = "Arial">
			Universal Transmitters: <?php echo $row42['utcount']; ?>
		</td>			
<?php
	}
if (!$row42['racepackcount']==0)
	{
?>
		<td><font color="#000000" face = "Arial">
			Raceway Packs: <?php echo $row42['racepackcount']; ?>
		</td>
<?php
	}
?>
	</tr>
	<tr>
<?php
if(!$row42['relaycount']==0)
	{
?>
		<td><font color="#000000" face = "Arial">
			Relays:	<?php echo $row42['relaycount']; ?>
		</td>
<?php
	}
if (!$row42['minilockcount']==0)
	{
?>		
		<td><font color="#000000" face = "Arial">
			Mini Locks: <?php echo $row42['minilockcount']; ?>
		</td>
<?php
	}
?>                                                          	
	</tr>
	<tr>
<?php	
if (!$row42['keypadcount']==0)
	{
?>
		<td><font color="#000000" face = "Arial">
			Keypads: <?php echo $row42['keypadcount']; ?>
		</td>
<?php		
	}
if (!$row42['pircount']==0)
	{
?>
		<td><font color="#000000" face = "Arial">
			PIRs: <?php echo $row42['pircount']; ?>
		</td>
<?php
	}
?>
	</tr>
	<tr>
<?php
if(!$row42['pushbuttoncount']==0)
	{
?>		
		<td><font color="#000000" face = "Arial">
			Pushbutton (Secondary Bypass): <?php echo $row42['pushbuttoncount']; ?>
		</td>
<?php		
	}
if(!$row42['zbracketoutdoor']==0)
	{
?>		
		<td><font color="#000000" face = "Arial">
			Outdoor Z Bracket Locks: <?php echo $row42['zbracketoutdoor']; ?>
		</td>
<?php		
	}
?>
	</tr>
	<tr>
<?php
if(!$row42['egresskit']==0)
	{
?>		
		<td><font color="#000000" face = "Arial">
			Egress Kits: <?php echo $row42['egresskit']; ?>
		</td>
<?php		
	}
?>
	</tr>		
	<tr>
<?php
if (!$row42['notes']==0)
	{
?>		
		<td colspan = "2"><font color="#000000" face = "Arial">
			Notes: <?php echo $row42['notes']; ?>
		</td>
<?php
	}
?>
	</tr>
	<tr>
		<td colspan = "2"><font color="#000000" face = "Arial">
			Door Function:
		</td>
	</tr>
	<tr>
		<td colspan="2"><font color="#000000" face = "Arial">
			<?php echo stripslashes($alarm); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><b><font color="#000000" face = "Arial">
			<?php echo $utpower1; ?>
		</b></td>
	</tr>
	<tr>
		<td colspan="2"><b><font color="#000000" face = "Arial">
			<?php echo $elock1; ?>
		</b></td>
	</tr>
	<tr>
	<tr>
		<td colspan="2"><b><font color="#000000" face = "Arial">
			<?php echo $variance1; ?>
		</b></td>
	</tr>
	<tr>		
		<td colspan="2"><font color="#000000" face = "Arial">
			<div align="center"><hr width="50%">
		</div></td>
	</tr>
<?php
}}
                                                           
if(!(isset($_GET['view']) &&($_GET['view']== 'print')))
	{
		$facilityid = $_GET['f_id'];
		$query4 = "SELECT filename FROM tbluploads WHERE facilityid = '$facilityid'";
		$result4 = mysql_query($query4) or die (mysql_error());
		$row4 = mysql_num_rows($result4);
 ?>
<table width = "750" align="center">
	<tr>
		<td colspan = 2 align = center>
			Files/Maps Currently Attached for this scope of work.
		</td>
	</tr>
<?php
		if($row4 <> 0)
			{
				$query1 = "SELECT * FROM tbluploads WHERE facilityid = '$facilityid'";
				$result1 = mysql_query($query1) or die (mysql_error());
				while($row1 = mysql_fetch_array($result1))
					{
						$id = $row1['ID'];
						$attach = $row1['filename'];
						$path = $row1['path'];
?>
						<tr>			
				 				<?php echo  '<td align = center><font face="Arial" size="2"><a href="' . $path .'">'.  $attach .'</td>';?>
							</td>
						</tr>
			
<?php
					}
			}
?>		
</table>
<table width = "750" align="center">					
<tr>
<td width="250"><button onClick="window.location='doorunit.php?action=UPDATE&f_id=<?php echo $facilityID; ?>'">Update Door Info</button></td>
<?php
$facilityID = $_GET['f_id'];
?>
<tr>
	<td colspan = 2 width="250"><button onClick="window.location='upload.php?f_id=<?php echo $facilityID; ?>'">Manage Files</button>(Attach Maps, Variances, etc...)</td>
</tr>
<?php
}
 
?>
</tr>
</table>
<?php
if(isset($_GET['view']) &&($_GET['view']== 'print'))
	{
		include 'scopefooter.php';
		$facilityid = $_GET['f_id'];
				$query1 = "SELECT * FROM tbluploads WHERE facilityid = '$facilityid'";
				$result1 = mysql_query($query1) or die (mysql_error());
				while($row1 = mysql_fetch_array($result1))
					{
						$id = $row1['ID'];
						$attach = $row1['filename'];
						$path = $row1['path'];
						//addslashes($path);
?>
					<table align = center width = 750>
						<tr>
							<td>
						 		<img src="<?php echo $path; ?>" alt="">
						 	</td>
						 </tr>
						</table>
<?php						 						 
					}
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
