<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';

$signature = $_SESSION['username'];
$date = date('Y-m-d H:i:s');
$facilityID = $_GET["f_id"];
echo '<input type = "hidden" name="f_id" value = "'.$facilityID.'">';	

$query = "SELECT * From tblfacilitygeneralinfo WHERE ID='$facilityID'";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result);	

$query1 = "SELECT * From tbltotalequipment WHERE FacilityID='$facilityID'";
$result1 = mysql_query($query1) or die (mysql_error());
$row1 = mysql_fetch_array($result1);

$query2 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID' Order by doornumber";
$result2 = mysql_query($query2) or die (mysql_error());
$row2 = mysql_fetch_array($result2);

$query3 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result3 = mysql_query($query3) or die(mysql_error());
$row3 = mysql_fetch_array($result3);

$query4 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result4 = mysql_query($query4) or die(mysql_error());
$row4 = mysql_fetch_array($result4);
$query30 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result30 = mysql_query($query30) or die(mysql_error());
$row30 = mysql_num_rows($result30);

$query40 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$facilityID'"; 
$result40 = mysql_query($query40) or die(mysql_error());
$row40 = mysql_fetch_array($result40);

$query70 = "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID'";
$result70 = mysql_query($query70) or die(mysql_error());
$row70 = mysql_num_rows($result70);	

$query71 = "SELECT * From tblprojectmanagement WHERE FacilityID='$facilityID'";
$result71 = mysql_query($query71) or die(mysql_error());
$row71 = mysql_num_rows($result71);	

if(isset($_GET['action'])&&($_GET['action']='UPDATE '))
	{
		$query52 = "SELECT * FROM tbladditionalcontacts WHERE FacilityID='$facilityID'"; 
		$result52 = mysql_query($query52) or die(mysql_error());
		$row52 = mysql_fetch_array($result52);
		
		$query54 = "SELECT * FROM tblprojectmanagement WHERE FacilityID='$facilityID'"; 
		$result54 = mysql_query($query54) or die(mysql_error());
		$row54 = mysql_fetch_array($result54);
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
$champ1 = $row52["SystemChamp1"];
$champtitle1 = $row52["ChampionTitle1"];
$champphone1 = $row52["ChampionPhone1"];
$champ2 = $row52["SystemChamp2"];
$champtitle2 = $row52["ChampionTitle2"];
$champphone2 = $row52["ChampionPhone2"];


$livedate = $row54['LiveDate'];
$remote = $row54['Remote'];
$marshall = $row54['marshall'];
$panel = $row54['panel'];
$fire = $row54['fire'];
$timers = $row54['timers'];
$connection = $row54['connectiont'];
$doorcompany = $row54['doorcompany'];
$wellness = $row54['wellness'];
$comments = strip_tags($row54['comments']);
		?>
		<table align = "center" width = "750">
	<tr>
		<td>Date: <?php echo date('l, M j  Y'); ?> </td>
	</tr>

<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php echo '<input type = "hidden" name="f_id" value = "'.$facilityID.'">';	?>
<table align = "center" width = "500">
	<tr>
		<td align=center><u><font size=5 ><strong>  Scope of Work/Sale Summary  </strong></u></td>
	</tr>
	<tr><td><br></td></tr>
	
<table align="center" width="500">
<?php


										      		echo '<tr>';                                                            
                                                            		echo '<td align="center" td colspan="2"><font size="5" ><strong>' .stripslashes( $row['FacilityName'] ). '</strong></td>';
                                                            echo '</tr>';
                                                          echo '<tr>';
                                                            		echo '<td align="center" td colspan="2"><font size="3"><strong>' . $row['Address'] . '</strong></td>';			
                                                            echo '</tr>';
?>
      <tr>
		<td align=center colspan="2"><font size=2 ><strong>  Sales Contact  </strong></td>
	</tr>               
<?php                                 	
                                                            echo '<tr>';
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            echo '</tr>';                                                           	
                                                            echo '<tr>';
                                                          		echo '<td><font size="2" >' . 'Contanct Name:    ' . $row['ContactName'].'</td>';
                                                          		echo '<td ><font size="2" >' . 'Title:    ' . $row['Title'].'</td>';
                                                          	echo '<tr>';
                                                          		echo '<td ><font size="2" >' . 'Phone Number:    ' . formatPhone($row['PhoneNumber']).'</td>';
                                                          		echo '<td><font size="2" >' . '2nd Number:    ' . formatPhone($row['secondnumber']).'</td>';
                                                          	echo '</tr>';
                                                          	echo'<tr>';
                                                          		echo '<td><font size="2">' . 'System Type:    ' .$row['SystemType'].'</td>';
                                                          		echo '<td><font size="2" >' . 'Fax:    ' . formatPhone($row['Fax']).'</td>';
                                                          	echo '</tr>';
                                                          	echo '<tr>';
                                                         	 	echo '<td align="center" colspan="2"><font size="2" >' . 'Email:    ' . $row['Email'].'</td>';
                                                                	echo '</tr>';
                                                                echo'<tr>';
                                                          	echo '<td align="center" colspan = "2"><font size="2" >' . 'HomeFree Sales Representative:    ' . $row['Salesman'].'</td>';
                                                          	echo '</tr>';
?>
</table>
<table width="750" align = "center">
<tr>
<td><u>Key Contacts</u></td>
</tr>
</table>
		
<table align = "center" width = "750" cellpadding=3>

	
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name" value="<?php echo "$name"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title" value="<?php echo "$title"; ?>"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone" value="<?php echo "$phone"; ?>"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name1" value="<?php echo "$name1"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title1" value="<?php echo "$title1"; ?>"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone1" value="<?php echo "$phone1"; ?>"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name2" value="<?php echo "$name2"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title2" value="<?php echo "$title2"; ?>"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone2" value="<?php echo "$phone2"; ?>"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name3" value="<?php echo "$name3"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title3" value="<?php echo "$title3"; ?>"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone3" value="<?php echo "$phone3"; ?>"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name4" value="<?php echo "$name4"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title4" value="<?php echo "$title4"; ?>"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone4" value="<?php echo "$phone4"; ?>"></td>
	</tr>
	<tr>
		<td><u>System Champion</u></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="champ" value="<?php echo "$row52[SystemChamp]"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="champtitle" value="<?php echo "$row52[ChampionTitle]"; ?>" ></td><td>Phone:</td><td><input type="text" size="10" maxlength="10" name="champphone" value="<?php echo "$row52[ChampionPhone]"; ?>"></td>
	</tr>
		<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="champ1" value="<?php echo "$row52[SystemChamp1]"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="champtitle1" value="<?php echo "$row52[ChampionTitle1]"; ?>" ></td><td>Phone:</td><td><input type="text" size="10" maxlength="10" name="champphone1" value="<?php echo "$row52[ChampionPhone1]"; ?>"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="champ2" value="<?php echo "$row52[SystemChamp2]"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="champtitle2" value="<?php echo "$row52[ChampionTitle2]"; ?>" ></td><td>Phone:</td><td><input type="text" size="10" maxlength="10" name="champphone2" value="<?php echo "$row52[ChampionPhone2]"; ?>"></td>
	</tr>
	<tr>
		<td><u>Anticipated Live Date:</u></td><td><input type="text" size="20" maxlength="20" name="LiveDate" value="<?php echo "$row54[LiveDate]"; ?>"></td>
	</tr>
	<tr>
		<td><u>Remote Access Type:</u></td><td><select name=Remote>
		<option value ="<?php echo $row54['Remote']; ?>"><?php echo $row54['Remote']; ?></option>
			<option value ="Unknown">Unknown</option>
			<option value ="Fax line">Fax line</option>
  			<option value ="Dedicated Phone Line">Dedicated Phone Line</option>
  			<option value ="Internet">Internet</option>
  		</select></td>
	</tr>
</table>

</table>


	<table align ="center" width = "750" cellpadding=3>
	<?php
	if($row4 <> 0 AND $row3 <> 0)
	{
?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Door Company Information</u></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Magnetic Locks</td>
	</tr>
	<tr>
		<td></td><td>Fire Marshall Approval</td><td><input type="text" size="40" maxlength="40" name="marshall" value="<?php echo "$row54[marshall]"; ?>"></td>
	</tr>
	<tr>
		<td></td><td>Connection to fire Panel</td><td><input type="text" size="40" maxlength="40" name="panel" value="<?php echo "$row54[panel]"; ?>"></td>
	</tr>
	<tr>
		<td></td><td>Fire Company</td><td><input type="text" size="40" maxlength="40" name="fire" value="<?php echo "$row54[fire]"; ?>"></td>
	</tr>
	<tr>
		<td></td><td>Timers (Schedule):</td><td><input type="text" size="40" maxlength="40" name="timers"value="<?php echo "$row54[timers]"; ?>"></td>
	</tr>

	<?php
	}
	else {
		?>
		<input type="hidden" name="marshall" value="">
		<input type="hidden" name="panel" value="">
		<input type="hidden" name="fire" value="">
		<input type="hidden" name="timers" value="">
		<?php
	}
if($row2['doortype']== 'doortype9')
	{
?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Elevators</td>
	</tr>
	<tr>
		<td></td><td>Connection Company:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40" maxlength="40" name="connectiont" value="<?php echo "$row54[connectiont]"; ?>"></td>
	</tr>
<?php
}
else {
 	?>
 	<input type="hidden" name="connectiont" value="">
 	<?php
}
if($row2['doortype']== 'doortype7')
	{
?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Automatic Doors</td>
	</tr>
	<tr>
		<td></td><td>Door Company:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40" maxlength="40" name="doorcompany" value="<?php echo "$row54[doorcompany]"; ?>"></td>
	</tr>
<?php
}
else {
 	?>
 	<input type="hidden" name="doorcompany" value="">
 	<?php
}
	?>
	
	<?php
	if (!$row1['TotalPullCordsactivity'] == 0)
	{
		?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Other Information</u></td>
	</tr>
	<tr>
		<td></td><td>Wellness Check in Schedule:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> <input type="text" size="40" maxlength="40" name="wellness" value="<?php echo "$row54[wellness]"; ?>"></td>
	</tr>
<?php
	}else {
 	?>
 	<input type="hidden" name="wellness" value="">
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
		<td><input type="submit" value="SAVE CHANGES" name="save"></td>
	</tr>
</table>
</form>

<?php

			

}
    ?>
    <head>

<title>Scope Of Work</title>

<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>

</head>
<?php
if (!(isset($_GET['done'])OR (isset($_GET['save']) OR (isset($_GET['action'])&&($_GET['action']='UPDATE ')))))   
         {                      
                     	 
?>
<table align = "center" width = "750">
	<tr>
		<td>Date: <?php echo date('l, M j  Y'); ?> </td>
	</tr>

<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php echo '<input type = "hidden" name="f_id" value = "'.$facilityID.'">';	?>
<table align = "center" width = "500">
	<tr>
		<td align=center><u><font size=5 ><strong>  Scope of Work/Sale Summary  </strong></u></td>
	</tr>
	<tr><td><br></td></tr>
	
<table align="center" width="500">
<?php


										      		echo '<tr>';                                                            
                                                            		echo '<td align="center" td colspan="2"><font size="5" ><strong>' .stripslashes( $row['FacilityName'] ). '</strong></td>';
                                                            echo '</tr>';
                                                          echo '<tr>';
                                                            		echo '<td align="center" td colspan="2"><font size="3" ><strong>' . $row['StreetAddress'] . '</strong></td>';			
                                                            echo '</tr>';
?>
      <tr>
		<td align=center colspan="2"><font size=2 ><strong>  Sales Contact  </strong></td>
	</tr>               
<?php                                 	
                                                            echo '<tr>';
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            echo '</tr>';                                                           	
                                                            echo '<tr>';
                                                          		echo '<td><font size="2" >' . 'Contanct Name:    ' . $row['ContactName'].'</td>';
                                                          		echo '<td ><font size="2" >' . 'Title:    ' . $row['Title'].'</td>';
                                                          	echo '<tr>';
                                                          		echo '<td ><font size="2" >' . 'Phone Number:    ' . formatPhone($row['PhoneNumber']).'</td>';
                                                          		echo '<td><font size="2" >' . '2nd Number:    ' . formatPhone($row['secondnumber']).'</td>';
                                                          	echo '</tr>';
                                                          	echo'<tr>';
                                                          		echo '<td><font size="2" >' . 'System Type:    ' .$row['SystemType'].'</td>';
                                                          		echo '<td><font size="2" >' . 'Fax:    ' . formatPhone($row['Fax']).'</td>';
                                                          	echo '</tr>';
                                                          	echo '<tr>';
                                                         	 	echo '<td align="center" colspan="2"><font size="2" >' . 'Email:    ' . $row['Email'].'</td>';
                                                                	echo '</tr>';
                                                                echo'<tr>';
                                                          	echo '<td align="center" colspan = "2"><font size="2" >' . 'HomeFree Sales Representative:    ' . $row['Salesman'].'</td>';
                                                          	echo '</tr>';
?>
</table>
<table width="750" align = "center">
<tr>
<td><u>Key Contacts</u></td>
</tr>
</table>
		
<table align = "center" width = "750" cellpadding=3>

	
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name" value="none"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name1" value="none"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title1"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone1"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name2" value="none"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title2"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone2"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name3" value="none"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title3"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone3"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="Name4" value="none"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title4"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="Phone4"></td>
	</tr>
	<tr>
		<td><u>System Champion(s)</u></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="champ" value="none"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="champtitle"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="champphone"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="champ1" value="none"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="champtitle1"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="champphone1"></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:</td><td><input type="text" size="40" maxlength="40" name="champ2" value="none"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="champtitle2"></td><td>Phone:</td><td><input type="text" size="12" maxlength="10" name="champphone2"></td>
	</tr>
	<tr>
		<td><u>Anticipated Live Date:</u></td><td><input type="text" size="20" maxlength="20" name="LiveDate"></td>
	</tr>
	<tr>
		<td><u>Remote Access Type:</u></td><td><select name=Remote>
			<option value ="Unknown">Unknown</option>
			<option value ="Fax line">Fax line</option>
  			<option value ="Dedicated Phone Line">Dedicated Phone Line</option>
  			<option value ="Internet">Internet</option>
  		</select></td>
	</tr>
</table>
	<table align ="center" width = "750" cellpadding=3>


	<tr>
		<td> 
			Base Units via Serial Port:&nbsp;&nbsp;<?php echo $row1['baseunitserial']; ?>  
			</td>		
	</tr>
	<tr>
		<td> 
			Base Units via Network:&nbsp;&nbsp;<?php echo $row1['baseunitnet']; ?> 
		</td>
	</tr>
</table>

<table align ="center" width = "750" cellpadding=3>
	<?php
	if(!($row4['SUM(minilockcount)']==0) & ($row3['SUM(zbracket)']==0))
	{
?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Door Company Information</u></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Magnetic Locks</td>
	</tr>
	<tr>
		<td></td><td>Fire Marshall Approval</td><td><input type="text" size="40" maxlength="40" name="marshall"></td>
	</tr>
	<tr>
		<td></td><td>Connection to fire Panel</td><td><input type="text" size="40" maxlength="40" name="panel"></td>
	</tr>
	<tr>
		<td></td><td>Fire Company</td><td><input type="text" size="40" maxlength="40" name="fire"></td>
	</tr>
	<tr>
		<td></td><td>Timers (Schedule):</td><td><input type="text" size="40" maxlength="40" name="timers"></td>
	</tr>

	<?php
	}
	else {
		?>
		<input type="hidden" name="marshall" value="">
		<input type="hidden" name="panel" value="">
		<input type="hidden" name="fire" value="">
		<input type="hidden" name="timers" value="">
		<?php
	}
	$query82 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID' Order by doornumber";
$result82 = mysql_query($query82) or die (mysql_error());
if(mysql_num_rows($result82) > 0)
{
while ($row82 = mysql_fetch_array($result82))
	{
		$doortype = $row82["doortype"];
if($doortype == 'doortype9')
	{
?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Elevators</td>
	</tr>
	<tr>
		<td></td><td>Connection Company:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40" maxlength="40" name="connectiont"></td>
	</tr>
<?php
}
else
{
	?>
	<input type="hidden" name="connectiont" value="">
	<?php
}
if($doortype== 'doortype7')
	{
?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Automatic Doors</td>
	</tr>
	<tr>
		<td></td><td>Door Company:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40" maxlength="40" name="doorcompany"></td>
	</tr>
<?php
}
else
{
	?>
<input type="hidden" name="doorcompany" value="">
<?php
}
}
}
else
{
?>
	<input type="hidden" name="doorcompany" value="">
	<input type="hidden" name="connectiont" value="">
<?php
}
	if (!$row1['TotalPullCordsactivity'] == 0)
	{
		?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Other Information</u></td>
	</tr>
	<tr>
		<td></td><td>Wellness Check in Schedule:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> <input type="text" size="40" maxlength="40" name="wellness"></td>
	</tr>
<?php
	}
	else {
		?>
		<input type="hidden" name="wellness" value="">
		<?php
	}
?>
</table>
<table align ="center">
<tr>
<td>Additional Comments:</td><td><textarea rows="12" cols="65" name="comments"></textarea></td>	
</tr>
</table>
<table width ="750" align="center">
	<tr>
		<td><input type="submit" value="DONE" name="done"></td>
	</tr>
</table>
</form>
<?php
}

if (isset($_GET['done']) OR (isset($_GET['save'])))
{

if (isset($_GET['done']))
{
$name = $_GET["Name"];
$title = $_GET["Title"];
$phone = $_GET["Phone"];
$name1 = $_GET["Name1"];
$title1 = $_GET["Title1"];
$phone1 = $_GET["Phone1"];
$name2 = $_GET["Name2"];
$title2 = $_GET["Title2"];
$phone2 = $_GET["Phone2"];
$name3 = $_GET["Name3"];
$title3 = $_GET["Title3"];
$phone3 = $_GET["Phone3"];
$name4 = $_GET["Name4"];
$title4 = $_GET["Title4"];
$phone4 = $_GET["Phone4"];
$champ = $_GET["champ"];
$champtitle = $_GET["champtitle"];
$champphone = $_GET["champphone"];
$livedate = $_GET['LiveDate'];
$remote = $_GET['Remote'];
$marshall = $_GET['marshall'];
$panel = $_GET['panel'];
$fire = $_GET['fire'];
$timers = $_GET['timers'];
$connection = $_GET['connectiont'];
$doorcompany = $_GET['doorcompany'];
$wellness = $_GET['wellness'];
$comments = nl2br(addslashes($_GET['comments']));  
$champ1 = $_GET["champ1"];
$champtitle1 = $_GET["champtitle1"];
$champphone1 = $_GET["champphone1"];
$champ2 = $_GET["champ2"];
$champtitle2 = $_GET["champtitle2"];
$champphone2 = $_GET["champphone2"];


	$facilityID = $_GET["f_id"];
	$query25="INSERT INTO tblprojectmanagement  (FacilityID,LiveDate,Remote,marshall,panel,fire,timers,doorcompany, wellness, connectiont, comments, signature)
			 VALUES ('$facilityID', '$livedate', '$remote', '$marshall', '$panel', '$fire', '$timers', '$doorcompany', '$wellness', '$connection', '$comments', '$signature')";
			mysql_query($query25) or die(mysql_error());
			
			
			$query26="INSERT INTO tbladditionalcontacts  (FacilityID,Name,Title,Phone,Name1,Title1,Phone1,Name2,Title2,Phone2,Name3,Title3,Phone3,Name4,Title4,Phone4,signature)
			 	VALUES ('$facilityID', '$name','$title','$phone','$name1','$title1','$phone1','$name2','$title2','$phone2','$name3','$title3','$phone3','$name4','$title4','$phone4','$signature')";
				mysql_query($query26) or die(mysql_error());
			
			
		if ($champ <> "none")
			{
			$query31= "UPDATE tbladditionalcontacts  SET SystemChamp = '$champ', ChampionTitle = '$champtitle', ChampionPhone = '$champphone' WHERE FacilityID = '$facilityID'";
				mysql_query($query31) or die(mysql_error());		
			}
			else{
			$query32=" UPDATE tbladditionalcontacts  SET SystemChamp = 'Unknown', ChampionTitle = 'Unknown', ChampionPhone = '0000000000' WHERE FacilityID = '$facilityID'";
				mysql_query($query32) or die(mysql_error());
			}
			if ($champ <> "none")
			{
			$query33= "UPDATE tbladditionalcontacts  SET SystemChamp1 = '$champ1', ChampionTitle1 = '$champtitle1', ChampionPhone1 = '$champphone1' WHERE FacilityID = '$facilityID'";
				mysql_query($query33) or die(mysql_error());		
			}
			else{
			$query34=" UPDATE tbladditionalcontacts  SET SystemChamp1 = 'Unknown', ChampionTitle1 = 'Unknown', ChampionPhone1 = '0000000000' WHERE FacilityID = '$facilityID'";
				mysql_query($query34) or die(mysql_error());
			}
			if ($champ <> "none")
			{
			$query35= "UPDATE tbladditionalcontacts  SET SystemChamp2 = '$champ2', ChampionTitle2 = '$champtitle2', ChampionPhone2 = '$champphone2' WHERE FacilityID = '$facilityID'";
				mysql_query($query35) or die(mysql_error());		
			}
			else{
			$query36=" UPDATE tbladditionalcontacts  SET SystemChamp2 = 'Unknown', ChampionTitle2 = 'Unknown', ChampionPhone2 = '0000000000' WHERE FacilityID = '$facilityID'";
				mysql_query($query36) or die(mysql_error());
			}}

if (isset($_GET['save']))
{
$name = $_GET["Name"];
$title = $_GET["Title"];
$phone = $_GET["Phone"];
$name1 = $_GET["Name1"];
$title1 = $_GET["Title1"];
$phone1 = $_GET["Phone1"];
$name2 = $_GET["Name2"];
$title2 = $_GET["Title2"];
$phone2 = $_GET["Phone2"];
$name3 = $_GET["Name3"];
$title3 = $_GET["Title3"];
$phone3 = $_GET["Phone3"];
$name4 = $_GET["Name4"];
$title4 = $_GET["Title4"];
$phone4 =  $_GET["Phone4"];
$champ = $_GET["champ"];
$champtitle = $_GET["champtitle"];
$champphone = $_GET["champphone"];
$livedate = $_GET['LiveDate'];
$remote = $_GET['Remote'];
$marshall = $_GET['marshall'];
$panel = $_GET['panel'];
$fire = $_GET['fire'];
$timers = $_GET['timers'];
$connection = $_GET['connectiont'];
$doorcompany = $_GET['doorcompany'];
$wellness = $_GET['wellness'];
$comments = addslashes($_GET['comments']);  
$champ1 = $_GET["champ1"];
$champtitle1 = $_GET["champtitle1"];
$champphone1 = $_GET["champphone1"];
$champ2 = $_GET["champ2"];
$champtitle2 = $_GET["champtitle2"];
$champphone2 = $_GET["champphone2"];

		$query52 = "SELECT * FROM tbladditionalcontacts WHERE FacilityID='$facilityID'"; 
		$result52 = mysql_query($query52) or die(mysql_error());
		$row52 = mysql_fetch_array($result52);
			
			$query55="UPDATE tbladditionalcontacts  SET Name = '$name',Title = '$title',Phone = '$phone',Name1 = '$name1',Title1 = '$title1',Phone1 = '$phone1',Name2 = '$name2',Title2 = '$title2',
							Phone2 = '$phone2',Name3 = '$name3',Title3 = '$title3',Phone3 = '$phone3',Name4 = '$name4',Title4 ='$title4',Phone4 = '$phone4' WHERE FacilityID = '$facilityID'";
				mysql_query($query55) or die(mysql_error());
			
			
		if ($row52['SystemChamp'] <> "unknown")
			{
			$query56= "UPDATE tbladditionalcontacts  SET SystemChamp = '$champ', ChampionTitle = '$champtitle', ChampionPhone = '$champphone' WHERE FacilityID = '$facilityID'";
				mysql_query($query56) or die(mysql_error());		
			}
			else{
			$query56=" UPDATE tbladditionalcontacts  SET SystemChamp = 'Unknown', ChampionTitle = 'Unknown', ChampionPhone = 'Unknown' WHERE FacilityID = '$facilityID'";
				mysql_query($query56) or die(mysql_error());
			}
			if ($row52['SystemChamp1'] <> "unknown")
			{
			$query58= "UPDATE tbladditionalcontacts  SET SystemChamp1 = '$champ1', ChampionTitle1 = '$champtitle1', ChampionPhone1 = '$champphone1' WHERE FacilityID = '$facilityID'";
				mysql_query($query58) or die(mysql_error());		
			}
			else{
			$query59=" UPDATE tbladditionalcontacts  SET SystemChamp1 = 'Unknown', ChampionTitle1 = 'Unknown', ChampionPhone1 = 'Unknown' WHERE FacilityID = '$facilityID'";
				mysql_query($query59) or die(mysql_error());
			}
						if ($row52['SystemChamp2'] <> "unknown")
			{
			$query60= "UPDATE tbladditionalcontacts  SET SystemChamp2 = '$champ2', ChampionTitle2 = '$champtitle2', ChampionPhone2 = '$champphone2' WHERE FacilityID = '$facilityID'";
				mysql_query($query60) or die(mysql_error());		
			}
			else{
			$query61=" UPDATE tbladditionalcontacts  SET SystemChamp2 = 'Unknown', ChampionTitle2 = 'Unknown', ChampionPhone2 = 'Unknown' WHERE FacilityID = '$facilityID'";
				mysql_query($query61) or die(mysql_error());
			}
			$query57="UPDATE tblprojectmanagement SET  LiveDate = '$livedate', Remote = '$remote',marshall = '$marshall',panel = '$panel',fire = '$fire',timers = '$timers',
							doorcompany = '$doorcompany', wellness= '$wellness', connectiont= '$connection', comments = '$comments' WHERE FacilityID='$facilityID'";
			mysql_query($query57) or die(mysql_error());
			
			$query62 = "UPDATE tblfacilitygeneralinfo SET lastupdated = '$date' WHERE ID = 'facilityID'";
			mysql_query($query62) or die(mysql_error());
			
}
/*
$query42 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID' Order by doornumber";
$result42 = mysql_query($query42) or die (mysql_error());

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

$query51 =  "SELECT * From tblfacilitydoors WHERE FacilityID='$facilityID'";
$result51 = mysql_query($query51) or die (mysql_error());
$row51 = mysql_num_rows($result51);	
	?>
				
<table align = "center" width = "500">
	<tr>
		<td align=center><u><font size=5 ><strong>   Scope of Work/Sale Summary  </strong></u></td>
	</tr>
	<table align="center" width="500">
<?php

										      		echo '<tr>';                                                            
                                                            		echo '<td align="center" td colspan="2"><font size="5" ><strong>' .stripslashes( $row['FacilityName'] ). '</strong></td>';
                                                            echo '</tr>';
                                                          echo '<tr>';
                                                            		echo '<td align="center" td colspan="2"><font size="3" ><strong>' . $row['Address'] . '</strong></td>';			
                                                            echo '</tr>';
 ?>
      <tr>
		<td align=center colspan="2"><font size=2 ><strong>  Sales Contact  </strong></td>
	</tr>               
<?php   	
                                                            echo '<tr>';
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            echo '</tr>';                                                           	
                                                            echo '<tr>';
                                                          		echo '<td><font size="2">' . 'Contanct Name:    ' . $row['ContactName'].'</td>';
                                                          		echo '<td ><font size="2" >' . 'Title:    ' . $row['Title'].'</td>';
                                                          	echo '<tr>';
                                                          		echo '<td ><font size="2" >' . 'Phone Number:    ' .  formatPhone($row['PhoneNumber']).'</td>';
                                                          		echo '<td><font size="2" >' . '2nd Number:    ' .  formatPhone($row['secondnumber']).'</td>';
                                                          	echo '</tr>';
                                                          	echo'<tr>';
                                                          		echo '<td><font size="2" >' . 'System Type:    ' .$row['SystemType'].'</td>';
                                                          		echo '<td><font size="2" >' . 'Fax:    ' .  formatPhone($row['Fax']).'</td>';
                                                          	echo '</tr>';
                                                          	echo '<tr>';
                                                         	 	echo '<td align="center" colspan="2"><font size="2">' . 'Email:    ' . $row['Email'].'</td>';
                                                                	echo '</tr>';
                                                                echo'<tr>';
                                                          	echo '<td align="center" colspan = "2"><font size="2" >' . 'HomeFree Sales Representative:    ' . $row['Salesman'].'</td>';
                                                          	echo '</tr>';
?>
</table>

<table width ="750" align="center">
	<tr>
		<td colspan="2"><div align="center"><hr width="100%"></div></td>
	</tr>
<?php

						echo '<tr>';
						echo '<tr><td><u>'  . 'Job Overview' .  '</u></td></tr>';
                      		echo '<td>' . $row1['joboverview'].  '</td>';
                          	echo '</tr>';
?>
	<tr>
		<td colspan="2"><div align="center"><hr width="100%"></div></td>
	</tr>
<?php
	if(($name <> "none") & ($champ <> "none"))
	{
		?>
<tr>
		<td><u>Key Contacts</u></td>
	</tr>
</table>
<table align = "center" width = "750" cellpadding=3>
	<?php
}
	if ($name <> "none")
			{
			?>
	<tr>
		<td>&nbsp;&nbsp;Name:&nbsp; <?php echo $name; ?> &nbsp;&nbsp;Title:&nbsp; <?php echo $title; ?> &nbsp;&nbsp;Phone:&nbsp; <?php echo formatPhone($phone); ?> </td>
	</tr>
	<?php
	}
if ($name1 <> "none")
	{
		?>
	<tr>
		<td>&nbsp;&nbsp;Name:&nbsp; <?php echo $name1; ?> &nbsp;&nbsp;Title:&nbsp; <?php echo $title1; ?> &nbsp;&nbsp;Phone:&nbsp; <?php echo formatPhone($phone1); ?> </td>
	</tr>
	<?php
}
	if ($name2 <> "none")
	{
		?>
	<tr>
		<td>&nbsp;&nbsp;Name:&nbsp; <?php echo $name2; ?> &nbsp;&nbsp;Title:&nbsp; <?php echo $title2; ?> &nbsp;&nbsp;Phone:&nbsp; <?php echo formatPhone($phone2); ?> </td>
	</tr>
	<?php
}
if ($name3 <> "none")
	{
		?>
	<tr>
		<td>&nbsp;&nbsp;Name:&nbsp; <?php echo $name3; ?> &nbsp;&nbsp;Title:&nbsp; <?php echo $title3; ?> &nbsp;&nbsp;Phone:&nbsp; <?php echo formatPhone($phone3); ?> </td>
	</tr>
	<?php
	}
if ($name4 <> "none")
	{
		?>
	<tr>
		<td>&nbsp;&nbsp;Name:&nbsp; <?php echo $name4; ?> &nbsp;&nbsp;Title:&nbsp; <?php echo $title4; ?> &nbsp;&nbsp;Phone:&nbsp;<?php echo formatPhone($phone4); ?> </td>
	</tr>
	<?php
}
if ($champ <> "none")
{
	?>
	<tr>
		<td><u>System Champion(s)</u></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;Name:&nbsp; <?php echo $champ; ?> &nbsp;&nbsp;Title: <?php echo $champtitle; ?> &nbsp;&nbsp;Phone:&nbsp; <?php echo formatPhone($champphone); ?> </td>
	</tr>
	<?php
}
if ($champ1 <> "none")
{
	?>
	<tr>
		<td>&nbsp;&nbsp;Name:&nbsp; <?php echo $champ1; ?> &nbsp;&nbsp;Title: <?php echo $champtitle1; ?> &nbsp;&nbsp;Phone:&nbsp; <?php echo formatPhone($champphone1); ?> </td>
	</tr>
	<?php
}

if ($champ1 <> "none")
{
	?>
	<tr>
		<td>&nbsp;&nbsp;Name:&nbsp; <?php echo $champ2; ?> &nbsp;&nbsp;Title: <?php echo $champtitle2; ?> &nbsp;&nbsp;Phone:&nbsp; <?php echo formatPhone($champphone2); ?> </td>
	</tr>
	<?php
}
?>
<tr>
		<td><u>Anticipated Live Date:</u>&nbsp; <?php echo $livedate; ?> </td>
	</tr>
	<tr>
		<td><u>Remote Access Type:</u>&nbsp; <?php echo $remote; ?> </td>
	</tr>
	<tr>
		<td colspan="6"><div align="center"><hr width="100%"></div></td>
	</tr>
</table>
<table align ="center" width = "750" cellpadding="2">
	
<?php	                    	
if (!($row1['TotalWMUs']==0 & ($row1['TotalOutdoorAreaUnits']==0  & ($row1['TotalOutdoorSolarUnits']==0))))
{	
echo '<tr><td>' .  '<u>' . 'Network' . '</u></td></tr>';
}


if (!$row1['TotalWMUs']==0)
	{	
		echo '<tr><td>' .  'Area Units:    ' . $row1['TotalWMUs'] . '</td></tr>';
	}
if (!$row1['TotalOutdoorAreaUnits']==0)
{	
		echo '<tr><td>' .  'Outdoor Area Units:    ' . $row1['TotalOutdoorAreaUnits'] . '</td></tr>';
	}
if (!$row1['TotalOutdoorSolarUnits']==0)
	{	
		echo '<tr><td>' .  'Solar Area Units:    ' . $row1['TotalOutdoorSolarUnits'] . '</td></tr>';
	}
	
?>   
	<tr>
		<td colspan="6"><div align="center"><hr width="100%"></div></td>
	</tr>
	</table>
	<table align ="center" width = "750" cellpadding="2">
	<tr>
		<td><b><font size=5 <strong>  Systems  </strong></b></td>
	</tr>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>	

	
<?php
	if(!($row1['TotalWatches']==0 & ($row17['SUM(doorunitcount)']==0 & ($row7['SUM(utcount)']==0))))
	{{
		?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000"><strong><u>Wandering and/or Door Control System</strong></u></td>
	</tr>

	<?php
}
	if (!$row1['TotalWatches']==0)
{	
		echo '<tr><td>' . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000">Watches:    ' . $row1['TotalWatches'] . '</td></tr>';
	}
				//Door Unit Display
		if(!$row17['SUM(doorunitcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000"><u>Door Equipment' . '</u></td>';
  	echo '</tr>';
  	}
		if(!$row17['SUM(doorunitcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Door Units: '. $row17['SUM(doorunitcount)'] . '</td>';
  	echo '</tr>';
  	}
		if(!$row6['SUM(outdoordoorunitCount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2" >' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outdoor Units: '. $row6['SUM(outdoordoorunitCount)'] . '</td>';
  	echo '</tr>';
  	}
		if(!$row7['SUM(utcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Universal Transmitters: '. $row7['SUM(utcount)'] . '</td>';
  	echo '</tr>';
  	}
  		if(!$row9['SUM(reedswitchcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reed Switches: '. $row9['SUM(reedswitchcount)'] . '</td>';
  	echo '</tr>';
  	}
  		if(!$row12['SUM(outdoorreedcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outdoor Reed Switches: '. $row12['SUM(outdoorreedcount)'] . '</td>';
  	echo '</tr>';
  	}  	
  		if(!$row8['SUM(pircount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Passive Infared Detectors: '. $row8['SUM(pircount)'] . '</td>';
  	echo '</tr>';
  	}
  		if(!$row10['SUM(keypadcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keypads: '. $row10['SUM(keypadcount)'] . '</td>';
  	echo '</tr>';
  	}
  		if(!$row11['SUM(pushbuttoncount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pushbuttons: '. $row11['SUM(pushbuttoncount)'] . '</td>';
  	echo '</tr>';
  	}
		if(!$row13['SUM(timercount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Timers: '. $row13['SUM(timercount)'] . '</td>';
  	echo '</tr>';
  	}
  		if(!$row14['SUM(minilockcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mini Locks: '. $row14['SUM(minilockcount)'] . '</td>';
  	echo '</tr>';
  	}
		if(!$row5['SUM(zbracket)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Z Bracket Locks: '. $row5['SUM(zbracket)'] . '</td>';
  	echo '</tr>';
  	}
  	if(!$row16['SUM(relaycount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deactivation Relays: '. $row16['SUM(relaycount)'] . '</td>';
  	echo '</tr>';
  	}  	
  		if(!$row15['SUM(racepackcount)']==0)
	{
	echo '<tr>';                                                            
    echo '<td colspan="2">' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Raceway Packs: '. $row15['SUM(racepackcount)'] . '</td>';
  	echo '</tr>';
  	}
  	
  	
	if(!($row14['SUM(minilockcount)']==0) & ($row5['SUM(zbracket)']==0))
	{
?>
		
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Magnetic Lock Information</td>
	</tr>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fire Marshall Approval: <?php echo $marshall;; ?> </td>
	</tr>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Connection to fire Panel:&nbsp; <?php echo $panel; ?> </td>
	</tr>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fire Company:&nbsp; <?php echo $fire; ?> </td>
	</tr>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Timers (Schedule):&nbsp; <?php echo $timers; ?> </td>
	</tr>

	<?php
}
	
	
	while ($row42 = mysql_fetch_array($result42))
	{
		$doortype = $row42["doortype"];
if($doortype == 'doortype9')
	{
?>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Elevators</td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000">Connection Company:&nbsp; <?php echo $connection; ?> </td>
	</tr>
<?php
}
 
if($row42['doortype']== 'doortype7')
	{	
?>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Automatic Doors</td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000">Door Company:&nbsp; <?php echo $doorcompany; ?> </td>
	</tr>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
<?php
}else
{
	?> 
	<input type="hidden" name="connection" value="">
	<?php
}
}}

if (!($row1['TotalPanicButtons'] == 0 & ($row1['TotalPullCords'] == 0 & ($row1['TotalPullCordsactivity']==0))))
{
	{
	?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000"><strong><u>Call System</strong></u></td>
	</tr>
	<?php
}
	if (!$row1['TotalPanicButtons'] == 0)
	{
?>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Call Buttons</u> &nbsp;(Total Ordered= <?php echo $row1['TotalPanicButtons']; ?>) </u></td>
	</tr>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pendant Style: <?php echo $row1['pendant']; ?> </td>
	</tr>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Watch style: <?php echo $row1['watchstyle']; ?> </td>
	</tr>
	<?php
}
		if (!$row1['TotalPullTags']==0)
	{	
		?>
		<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Pull Tags</u> &nbsp;(Total Ordered= <?php echo $row1['TotalPullTags']; ?>) </u></td>
	</tr>
		
	
<?php
	}

	if (!($row1['TotalPullCords'] == 0 &  ($row1['TotalPullCordsactivity'] == 0)))
	{
		if (!$row1['TotalPullCords']==0)
	{	
		?>
	<tr>
		<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Pull Cords&nbsp;(Total Ordered= <?php echo $row1['TotalPullCords']; ?>) </u></td>
	</tr>
	<tr>
	<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bedroom: <?php echo $row1['bedpullcords']; ?> </td>
	</tr>
	<tr>
	<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bathroom: <?php echo $row1['bathpullcords']; ?> </td>
	</tr>
	<tr>
	<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Common Areas: <?php echo $row1['commonpullcords']; ?> </td>
	</tr>
<?php
}
	if (!$row1['TotalPullCordsactivity']==0)
	{	
?>
		<tr>
			<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Pull Cords with Wellness Check-in:&nbsp;(Total Ordered= <?php echo $row1['TotalPullCordsactivity']; ?>)</u> &nbsp;&nbsp;      Schedule:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $wellness; ?> </td>
		</tr>
		<tr>
			<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bedroom: <?php echo $row1['bedpullcordsact']; ?> </td>
		</tr>
		<tr>
			<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bathroom: <?php echo $row1['bathpullcordsact']; ?> </td>
		</tr>
		<tr>
			<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Common Areas: <?php echo $row1['commonpullcordsact']; ?> </td>
		</tr>
	
	<?php
	}
if (!$row1['TotalCallCords']==0)
	{	
		?>
		<tr>
			<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Call Cords:</u></td>
		</tr>
		<?php
		
		echo '<tr><td>' . '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10ft. Call Cords:    ' . $row1['TotalCallCords'] . '</td></tr>';
	}
	if (!$row1['TotalCallCordssingle15']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15ft. Call Cords:    ' . $row1['TotalCallCordssingle15'] . '</td></tr>';
	}
		if (!$row1['TotalCallCorddual']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dual Call Cords:    ' . $row1['TotalCallCorddual'] . '</td></tr>';
	}
		if (!$row1['Squeezeball']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Squeeze Balls:    ' . $row1['Squeezeball'] . '</td></tr>';
	}
		if (!$row1['breathcall']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Breath Calls:    ' . $row1['breathcall'] . '</td></tr>';
	}
		if ($row1['CorridorLights']<>"NONE")
	{{
		?>
		<tr>
			<td><font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Corridor Lights:</u></td>
		</tr>
		<?php
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Corridor Light Type:    ' .$row1['CorridorLights'] . '</td></tr>';
	}
		if ($row1['CorridorLightType']<>"NONE")
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Corridor Light Style:    ' . $row1['CorridorLightType'] . '</td></tr>';
	}
		if (!$row1['TotalExistingCorrdiorLights']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Existing Lights:    ' . $row1['TotalExistingCorrdiorLights'] . '</td></tr>';
	}
		if (!$row1['TotalHomeFreeCorrdiorLights']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of HomeFree Lights:    ' . $row1['TotalHomeFreeCorrdiorLights'] . '</td></tr>';
	}
}}
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
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000"><strong><u>Fall Alert System</strong></u></td>
		</tr>
	
		<?php
		if (!$row1['TotalFallUnits']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Fall Units:    ' . $row1['TotalFallUnits'] . '</td></tr>';
	}
		if (!$row1['chair90day']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;90 Day Chair Pads:    ' . $row1['chair90day'] . '</td></tr>';
	}
		if (!$row1['chair180day']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;180 Day Chair Pads:    ' . $row1['chair180day'] . '</td></tr>';
	}
		if (!$row1['bed90day']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;90 Day Bed Pads:    ' . $row1['bed90day'] . '</td></tr>';
	}
		if (!$row1['bed180day']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;180 Day Bed Pads:    ' . $row1['bed180day'] . '</td></tr>';
	}
	?>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
<?php
}
?>
		<tr>
		<td><b><font size=5 ><strong>  Paging Equipment  </strong></b></td>
	</tr>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
	<?php
		if ($row1['PagingBaseType']<>"NONE")
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paging Base Type:    ' . $row1['PagingBaseType'] . '</td></tr>';
	}
		if ($row1['PagerType']<>"NONE")
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pager Type:    ' . $row1['PagerType'] . '</td></tr>';
	}
			if (!$row1['PagerQuantity']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of ' . $row1['PagerType']. ' Pagers:    ' . $row1['PagerQuantity'] . '</td></tr>';
	}
			if (!$row1['HomeFreePager']==0)
	{	
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of HomeFree Pagers:    ' . $row1['HomeFreePager'] . '</td></tr>';
	}
 ?>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>	
	
<?php
	if(!($row1['UTs']==0 &($row1['TotalClientStations']==0 &($row1['TotalCentralPowerSupplies']==0 & ($row1['Wire162']==0 & ($row1['Wire224']==0))))))
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
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000"><strong><u>Universal Transmitters</strong></u></td>
		</tr>
<?php
	
		
			echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Universal Transmitters:    ' . $row1['UTs'] . '</td></tr>';
	 		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Universal Transmitter Function:    ' . $row1['UTFunction'] . '</td></tr>';
	}
	
	if (!$row1['TotalClientStations']==0)
	{		
	?>
	<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000"><strong><u>Client Stations</strong></u></td>
	</tr>
<?php		
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Client Stations:    ' .$row1['TotalClientStations'] . '</td></tr>';
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client Station Location:    ' .$row1['ClientStationlocation'] . '</td></tr>';
	}	
		if ((!$row1['TotalCentralPowerSupplies']==0) & (!($row1['Wire162'] ==0 & ($row1['Wire224'] ==0))))
	{
?>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000"><strong><u>Power and Wire</strong></u></td>
		</tr>
<?php
	} elseif(($row1['TotalCentralPowerSupplies']==0) & (!($row1['Wire162'] ==0 & ($row1['Wire224'] ==0))))
	{	
?>
	<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000"><strong><u>Wire</strong></u></td>
		</tr>
<?php
	}
			if (!$row1['TotalCentralPowerSupplies']==0)
	{		
		echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Central Power Supplies:    ' .$row1['TotalCentralPowerSupplies'] . '</td></tr>';
	}
				if (!$row1['Wire162']==0)
	{		
	echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;16-2 Wire:    ' . $row1['Wire162'] . '</td></tr>';
	}
		if (!$row1['Wire224']==0)
	{		
	echo '<tr><td>' .  '<font color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;22-4 Wire:    ' . $row1['Wire224'] . '</td></tr>';
}
	?>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
<?php
}	
?>
	<tr>
		<td>Additional Comments: </td>	
	</tr>
	<tr>
	<td>&nbsp;<?php echo stripslashes($comments); ?> </td>	
	</tr>
	<tr>
		<td><div align="center"><hr width="100%"></div></td>
	</tr>
</table>
  
?>
<table width = "750" align="center">
<tr>
<td width="250"><button onClick="window.location='scopeadd.php?action=UPDATE&f_id=<?php echo $facilityID; ?>'">Update Sales Info</button></td>

<?php
	if(!$row70 == 0)
	{
		$facilityID = $_GET['f_id'];
		?>
<td width="250"><button onClick="window.location='doorunit.php?action=UPDATE&f_id=<?php echo $facilityID; ?>'">Update Door Info</button></td>
<?php
}else{
?>
<td width="250"><button onClick="window.location='doorunit.php?f_id=<?php echo $facilityID; ?>'">Add Door Info</button></td>
<?php
}

	if(!$row71 == 0)
	{
		$facilityID = $_GET['f_id'];
		?>
<td width="250"><button onClick="window.location='projectmanage.php?action=UPDATE&f_id=<?php echo $facilityID; ?>'">Update Project Management</button></td>
<?php
}else{ 
?>
<td width="250"><button onClick="window.location='projectmanage.php?f_id=<?php echo $facilityID; ?>'">Add/Update Project Info</button></td>
</tr>
<?php
}
*/
?>
<table width ="759" border="1"align="center">
<tr>
<td colspan="2">DO NOT CLICK THE BACK BUTTON, IF YOU NEED TO MAKE CHANGES A BUTTON IS AVAILABLE ON THE NEXT PAGE.</td>
</tr>
<tr>
<td>Changes Complete</td><td><button onClick="window.location='newfinishedpage.php?f_id=<?php echo $facilityID; ?>'">Click here to Continue</button></td>
</tr>
</table>


 <?php

 include 'includes/closedb.php'; 

}
 ?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>