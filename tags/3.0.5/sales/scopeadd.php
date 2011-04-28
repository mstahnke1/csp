

<?php
header("Location: addcustomer.php?view=new");
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';

$signature = $_SESSION['username'];
$date = date('Y-m-d H:i:s');
if(isset($_GET['action'])&&($_GET['action']='UPDATE '))
{
	$f_id=$_GET['f_id'];
	$query5 = "Select * FROM tbltotalequipment WHERE FacilityID = '$f_id'";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_fetch_array($result5);
	
	$dual = $row5["TotalCallCorddual"];
	$Area = $row5["TotalWMUs"];
	$OArea = $row5["TotalOutdoorAreaUnits"];
	$SArea = $row5["TotalOutdoorSolarUnits"];
	$watch = $row5["TotalWatches"];
	$callb = $row5["TotalPanicButtons"];
	$tags = $row5["TotalPullTags"];
	$pull = $row5["TotalPullCords"];
	$pullw = $row5["TotalPullCordsactivity"];
	$ten = $row5["TotalCallCords"];
	$fifteen = $row5["TotalCallCordssingle15"];
	$type = $row5["CorridorLights"];
	$style = $row5["CorridorLightType"];
	$existing = $row5["TotalExistingCorrdiorLights"];
	$homefree = $row5["TotalHomeFreeCorrdiorLights"];
	$base = $row5["PagingBaseType"];
	$pager = $row5["PagerType"];
	$numpagers = $row5["PagerQuantity"];
	$hfpagers = $row5["HomeFreePager"];
	$fall = $row5["TotalFallUnits"];
	$chair90 = $row5["chair90day"];
	$chair180 = $row5["chair180day"];
	$bed90 = $row5["bed90day"];
	$bed180 = $row5["bed180day"];
	$ut = $row5["UTs"];
	$utfunction = strip_tags($row5["UTFunction"]);
	$client = $row5["TotalClientStations"];
	$clientl = strip_tags($row5["ClientStationlocation"]);
	$power = $row5["TotalCentralPowerSupplies"];
	$job = strip_tags($row5["joboverview"]);
	$wirex = $row5["Wire162"];
	$wirey = $row5["Wire224"];
	$squeeze = $row5["Squeezeball"];
	$breath = $row5["breathcall"];
	$bed = $row5["bedpullcords"];
	$beda = $row5["bedpullcordsact"];
	$bath = $row5["bathpullcords"];
	$batha = $row5["bathpullcordsact"];
	$common = $row5["commonpullcords"];
	$commona = $row5["commonpullcordsact"];
	$pendant = $row5["pendant"];
	$watchstyle = $row5["watchstyle"];
	$baseconnect = $row5["baseconnect"];
	$utpower = $row5['utpower'];
	$lic = $row5['lic'];
	$days = $row5['days'];
	$startdate = $row5['startdate'];

	$query6="Select * From tblfacilitygeneralinfo WHERE ID = '$f_id'";
  $result6 = mysql_query($query6) or die (mysql_error());
	$row6 = mysql_fetch_array($result6);
	
	$Fname = $row6["FacilityName"];
	$Address = $row6["Address"];
	$Contact= $row6["ContactName"];
	$Phone = $row6["PhoneNumber"];
	$second =  $row6["secondnumber"];
	$Title = $row6["Title"];
	$Email = $row6["Email"];
	$Fax =  $row6["Fax"];
	$System = $row6["SystemType"];
	$sman = $row6["Salesman"];

?>
<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table  width="750"  align ="center">
		<tr>
	    		<td align=center td colspan="5"><font size=4 ><strong>  General Information  </strong></td>
		</tr>
	</table>
	
	<table cellpadding=2 table border ="1" width="750"  align ="center">
		<tr>
			<td>Facility Name:</td><td><input type="text" size="40" maxlength="60" name="Fname" value="<?php echo "$Fname"; ?>"></td><td>Address:</td><td><input type="text" size="40" maxlength="60" name="Address" value="<?php echo "$Address"; ?>"></td>
		</tr>
		<tr>
			<td>Contact Name:</td><td><input type="text" size="40" maxlength="60" name="Contact" value="<?php echo "$Contact"; ?>"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title" value="<?php echo "$Title"; ?>"></td>
		</tr>
		<tr>
			<td>Phone Number:</td><td><input type="text" size="12" maxlength="10" name="Phone" value="<?php echo "$Phone"; ?>"></td><td>Second Number:</td><td><input type="text" size="12" maxlength="10" name="second" value="<?php echo "$second"; ?>"></td>
		</tr>
		<tr>
			<td>Email:</td><td><input type="text" size="40" maxlength="40" name="Email" value="<?php echo "$Email"; ?>"></td><td>Fax:</td><td><input type="text" size="12" maxlength="10" name="Fax" value="<?php echo "$Fax"; ?>"></td>
		</tr>
		<tr>
			<td>System Type:</td>
			<td>
				<select name=Systype>
				<option value ="<?php echo $System; ?>"><?php echo $System; ?></option>
  				<option value ="On-Call">On-Call</option>
  				<option value ="On-Site">On-Site</option>
  				<option value ="Elite">Elite</option>
			</td></select>
  			<td>Salesperson:</td>
  			<td> 				
<?php
					$conn7 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
	            		mysql_select_db('homefree');
					$query8 = "SELECT id, f_name, l_name FROM employees ORDER BY l_name";
					$result8 = mysql_query($query8) or die (mysql_error());
        					while($row8 = mysql_fetch_array($result8))
                     			{  					
  								if($row8['id'] == $sman)
  									{
 										echo $row8['f_name']. ' ' . $row8['l_name']; 
  									}
  							}
  	    				mysql_close($conn7);	
  	    				echo '<input type = "hidden" name="sman" value = "'.$sman.'">';
?>

		</td>		
	</tr>

</table>


<table align="center">
	<tr>
		<td align=center><font size=4 ><strong>  Equipment  </strong></td>
	</tr>
</Table>

<Table cellpadding=3 table border ="1" width="750" align ="center">
	
	<tr>
		<td align="center" colspan="6"> <font size=3 ><strong>  Network  </strong></font></td>
	</tr>
	<?php
		if($baseconnect == "serial") 
			{
	?>
	<tr>
		<td colspan="6">
			<input type="radio" name="baseconnect" value="serial" CHECKED>
			 Base unit via Serial Port 
			 <input type="radio" name="baseconnect" value="network">
			 All Base Units Networked
		</td>
	</tr>
	<?php
			}
		elseif($baseconnect == "network")
			{
				?>
	<tr>
		<td colspan="6">
			<input type="radio" name="baseconnect" value="serial">
				 Base unit via Serial Port 
			 <input type="radio" name="baseconnect" value="network" CHECKED>
			 All Base Units Networked
		</td>
	</tr>
	<?php
			}else
			{
		?>
	<tr>
		<td colspan="6">
			<input type="radio" name="baseconnect" value="serial">
				 Base unit via Serial Port 
			 <input type="radio" name="baseconnect" value="network">
			 All Base Units Networked
		</td>
	</tr>
<?php
			}
?>
			<tr>
				<td>Area Units</td><td><input type="text" size="6" maxlength="6" name="Area" value="<?php echo "$Area"; ?>"></td><td>Outdoor Area Units</td><td>
				<input type="text" size="6" maxlength="6" name="OArea" value="<?php echo "$OArea"; ?>"></td><td>Solar Area Units</td><td><input type="text" size="6" maxlength="6" name="SArea" value="<?php echo "$SArea"; ?>">
				</td>
			</tr>
	</table>

<table cellpadding=3 table border ="1" width="750"  align ="center">
	<tr>
		<td align=center colspan = "6"><font size=3 ><strong>  Accessories  </strong></td>
	</tr>	
	<tr>
		<td>Watches</td><td><input type="text" size="6" maxlength="6" name="watch" value="<?php echo "$watch"; ?>"></td><td>Call Buttons</td><td>
		<input type="text" size="6" maxlength="6" name="callb" value="<?php echo "$callb"; ?>"></td><td>Pull Tags</td><td><input type="text" size="6" maxlength="6" name="tags"></td>
	</tr>
	<tr>
		<td>
			Pendant Style Attachments</td><td><input type="text" size="6" maxlength="6" name="pendant" value="<?php echo "$pendant"; ?>"></td><td></td><td></td><td>Watch Style Attachments</td><td>
			<input type="text" size="6" maxlength="6" name="watchstyle" value="<?php echo "$watchstyle"; ?>">
		</td>
	</tr>
</table>

<table cellpadding=3 table border ="1" width="750"  align ="center">
	<tr>
		<td align=center td colspan ="6"><font size=3 ><strong>  Pull Cords  </strong></td>
	<tr>
		<td>Pull Cords</td><td><input type="text" size="6" maxlength="6" name="pull" value="<?php echo "$pull"; ?>"></td>
	<tr>
		<td>
			Bedroom</td><td><input type="text" size="6" maxlength="6" name="bed" value="<?php echo "$bed"; ?>"></td><td>Bathroom</td><td><input type="text" size="6" maxlength="6" name="bath" value="<?php echo "$bath"; ?>"></td><td>
			Common</td><td><input type="text" size="6" maxlength="6" name="common" value="<?php echo "$common"; ?>">	
		</td>
	</tr>
	<tr>
		<td>Pull Cords with Wellness</td><td><input type="text" size="6" maxlength="6" name="pullw"value="<?php echo "$pullw"; ?>"></td>
	</tr>
	<tr>
		<td>
			Bedroom</td><td><input type="text" size="6" maxlength="6" name="beda" value="<?php echo "$beda"; ?>"></td><td>Bathroom</td><td><input type="text" size="6" maxlength="6" name="batha" value="<?php echo "$batha"; ?>"></td><td>
			Common</td><td><input type="text" size="6" maxlength="6" name="commona" value="<?php echo "$commona"; ?>">	
		</td>
	</tr>
	<tr>	
		<td>
			10ft. Call Cords</td><td><input type="text" size="6" maxlength="6" name="ten" value="<?php echo "$ten"; ?>"></td><td>15ft. Call Cords</td><td><input type="text" size="6" maxlength="6" name="fifteen" value="<?php echo "$fifteen"; ?>"></td><td>
			Dual Call Cords</td><td><input type="text" size="6" maxlength="6" name="dual" value="<?php echo "$dual"; ?>">
		</td>
	</tr>
	<tr>
		<td>
			Squeeze Balls</td><td><input type="text" size="6" maxlength="6" name="squeeze" value="<?php echo "$squeeze"; ?>"></td><td>Breath Calls</td><td><input type="text" size="6" maxlength="6" name="breath" value="<?php echo "$breath"; ?>">
		</td>
	</tr>
	<tr>
		<td>Corridor Light Type:</td><td><select name=type>
		<option value ="<?php echo $type; ?>"><?php echo $type; ?></option>
			<option value ="NONE">NONE</option>
  			<option value ="HomeFree">Homefree</option>
  			<option value ="Existing">Existing</option>
  			<option value ="Both">Both</option>
  		</select> </td><td>Corridor Light Style:</td><td><select name=style>
  		<option value ="<?php echo $style; ?>"><?php echo $style; ?></option>
  			<option value ="NONE">NONE</option>
  			<option value ="Single">Single</option>
  			<option value ="Double">Double</option>
  			<option value ="Quad">Quad</option>
  		</select></td>
  	</tr>
  	<tr>
  		<td>
  			Number of Existing Lights</td><td><input type="text" size="6" maxlength="6" name="existing" value="<?php echo "$existing"; ?>"></td><td>Number of HomeFree Lights</td><td>
  			<input type="text" size="6" maxlength="6" name="homefree" value="<?php echo "$homefree"; ?>">
  		</td>
  	</tr>
  	</table>
  	
<table cellpadding=3 table border ="1" width="750"  align ="center">
  	<tr>
  		<td align=center colspan="8"><font size=3 ><strong>  Paging  </strong></td>
  	</tr>
  	<tr>
  	    		<td align=center>Paging Base Type:</td><td><select name=base>
  			<option value ="<?php echo $base; ?>"><?php echo $base; ?></option>
  			<option value ="NONE">NONE</option>
  			<option value ="Commtech5W">Commtech 5 W</option>
  			<option value ="Commtech25W">Commtech 25 W</option>
  			<option value ="Commtech50W">Commtech 50 W</option>
  			<option value ="Commtech100W">Commtech 100 W</option>
  			<option value ="Commtech200W">Commtech 200 W</option>
  			<option value ="Scope">Scope</option>
  		</select></td><td>Pager Type</td><td><select name=pager>
  		<option value ="<?php echo $pager; ?>"><?php echo $pager; ?></option>
  			<option value ="NONE">NONE</option>
  			<option value ="Commtech7900">Commtech7900</option>
  			<option value ="Apollo">Apollo</option>
  		</select></td><td>Number of Pagers</td><td><input type="text" size="6" maxlength="6" name="numpagers" value="<?php echo "$numpagers"; ?>"></td><td>Number of HomeFree Pagers</td><td>
  		<input type="text" size="6" maxlength="6" name="hfpagers" value="<?php echo "$hfpagers"; ?>">
  			</td>
  		</tr>
  		</table>
  		
<table cellpadding=3 table border ="1" width="750"  align ="center">
  		<tr>
  			<td align=center colspan="10"><font size=3 ><strong>  Fall Units  </strong></td>
  		</tr>	
  		<tr>
  			<td align=center>Fall Units</td><td><input type="text" size="6" maxlength="6" name="fall" value="<?php echo "$fall"; ?>"></td><td>Chair Pad 90 day</td><td><input type="text" size="6" maxlength="6" name="chair90" value="<?php echo "$chair90"; ?>"></td><td>
  			Chair Pad 180 day</td><td><input type="text" size="6" maxlength="6" name="chair180" value="<?php echo "$chair180"; ?>"></td><td>Bed Pad 90 day</td><td><input type="text" size="6" maxlength="6" name="bed90" value="<?php echo "$bed90"; ?>"></td><td>
  			Bed Pad 180 day</td><td><input type="text" size="6" maxlength="6" name="bed180" value="<?php echo "$bed180"; ?>"></td>
 		</tr>
 		</table>
 		
<table cellpadding=3 table border ="1" width="750"  align ="center" >
 		<tr>
			<td align=center colspan="6"><font size=3 ><strong>  Universal Transmitters  </strong></font></td> 		
 		<tr>
 			<td align=center trspan=5> Universal Transmitters</td><td><input type="text" size="6" maxlength="6" name="ut" value="<?php echo "$ut"; ?>"></td><td>Universal Transmitter Function</td><td><textarea rows="5" cols="40" name="utfunction"><?php echo "$utfunction"; ?></textarea></td>
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
			}
		elseif($utpower == "no")
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
 		</table>
 		
<table cellpadding=3 table border ="1" width="750"  align ="center">
 		<tr>
 			<td align=center colspan="6"><font size=3 ><strong>  Client Stations  </strong></font></td> 
 		</tr>
 		<tr>
 			<td align=center>Client Stations</td><td><input type="text" size="6" maxlength="6" name="client" value="<?php echo "$client"; ?>"></td><td>Client Station Location</td><td><textarea rows="5" cols="40" name="clientl"><?php echo "$clientl"; ?></textarea></td>
 		</tr>
 		<tr>
 			<td> Client Licenses </td><td><input type="text" size="6" maxlength="6" name="lic" value="<?php echo "$lic"; ?>"></td>
 		</tr>
 		</table>
 <table cellpadding=3 table border ="1" width="750"  align ="center" >
 <tr>
 			<td align=center colspan="6"><font size=3 ><strong>  Central Power and Wire  </strong></font></td>
 		</tr>
 		<tr>
 			<td align=center>Central Power Supplies</td><td><input type="text" size="6" maxlength="6" name="power" value="<?php echo "$power"; ?>"></td><td>Wire 16-2 </td><td><input type="text" size="6" maxlength="6" name="wirex" value="<?php echo "$wirex"; ?>"></td><td>
 			Wire 22-4 <input type="text" size="6" maxlength="6" name="wirey" value="<?php echo "$wirey"; ?>"></td>
 		</tr>
 </table>
 <table cellpadding=3 table border ="1" width="750"  align ="center" >
 	<tr>
 		<td>Job Overview</td><td><textarea rows="12" cols="70" name="job"><?php echo "$job"; ?></textarea></td>
 	</tr>
 </table>
  <table cellpadding=3 table border ="1" width="750"  align ="center" >
 	<tr>
 		<td width = "85">
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
 </table>
 
 
 <table width="750">
 <tr>
		<td><input type="submit" value="DONE" name="done"></td>
	</tr>
</table>
 
 
 <table width="750">
 <tr>
 <?php	echo '<input type = "hidden" name="f_id" value = "'.$f_id.'">';	 ?>
 		<td><input type="submit" value="Save Changes" name="save"></td>
	</tr>
</table>
</form>
<?php

}


if (!(isset($_GET['done'])OR (isset($_GET['save']) OR (isset($_GET['action'])&&($_GET['action']='UPDATE '))))) {

?>


	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table  width="750"  align ="center">
	<tr>
	    <td align=center td colspan="5"><font size=4 ><strong>  General Information  </strong></td>
	</tr>
	</table>
	
	<table cellpadding=2 table border ="1" width="750"  align ="center">
	<tr>
		<td>Facility Name:</td><td><input type="text" size="40" maxlength="60" name="Fname"></td><td>Address:</td><td><input type="text" size="40" maxlength="60" name="Address"></td>
	</tr>
	<tr>
		<td>Contact Name:</td><td><input type="text" size="40" maxlength="60" name="Contact"></td><td>Title:</td><td><input type="text" size="20" maxlength="20" name="Title"></td>
	</tr>
	<tr>
		<td>Phone Number:</td><td><input type="text" size="12" maxlength="10" name="Phone"></td><td>Second Number:</td><td><input type="text" size="12" maxlength="10" name="second"></td>
	</tr>
	<tr>
		<td>Email:</td><td><input type="text" size="40" maxlength="40" name="Email"></td><td>Fax:</td><td><input type="text" size="12" maxlength="10" name="Fax"></td>
	</tr>
	<tr>
		<td>System Type:</td><td><select name=Systype>
  			<option value ="On-Call">On-Call</option>
  			<option value ="On-Site">On-Site</option>
  			<option value ="Elite">Elite</option>
  		</select></td>
  		<td>Salesperson:</td><td> 
  		
<?php
  			$conn2 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
								mysql_select_db('homefree');
								$query4 = "SELECT id, f_name, l_name FROM employees WHERE dept = 1 ORDER BY l_name";
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
								
            						mysql_close($conn2);
?>
			</select>
           </td>
	</tr>

</table>


<table align="center">
	<tr>
		<td align=center><font size=4 ><strong>  Equipment  </strong></td>
	</tr>
</Table>

<Table cellpadding=3 table border ="1" width="750" align ="center">
	
	<tr>
		<td align="center" colspan="6"> <font size=3 ><strong>  Network  </strong></font></td>
	</tr>
	<tr>
		<td colspan="6">
			<input type="radio" name="baseconnect" value="serial" CHECKED>
			 Base unit via Serial Port 
			 <input type="radio" name="baseconnect" value="network">
			 All Base Units Networked
		</td>
	</tr>
			<tr>
				<td>Area Units</td><td><input type="text" size="6" maxlength="6" name="Area"></td><td>Outdoor Area Units</td><td>
				<input type="text" size="6" maxlength="6" name="OArea"></td><td>Solar Area Units</td><td><input type="text" size="6" maxlength="6" name="SArea">
				</td>
			</tr>
	</table>

<table cellpadding=3 table border ="1" width="750"  align ="center">
	<tr>
		<td align=center colspan = "6"><font size=3 ><strong>  Accessories  </strong></td>
	</tr>	
	<tr>
		<td>Watches</td><td><input type="text" size="6" maxlength="6" name="watch"></td><td>Call Buttons</td><td>
		<input type="text" size="6" maxlength="6" name="callb"></td><td>Pull Tags</td><td><input type="text" size="6" maxlength="6" name="tags"></td>
	</tr>
	<tr>
		<td>
			Pendant Style Attachments</td><td><input type="text" size="6" maxlength="6" name="pendant"></td><td></td><td></td><td>Watch Style Attachments</td><td>
			<input type="text" size="6" maxlength="6" name="watchstyle">
		</td>
	</tr>
</table>

<table cellpadding=3 table border ="1" width="750"  align ="center">
	<tr>
		<td align=center td colspan ="6"><font size=3 ><strong>  Pull Cords  </strong></td>
	<tr>
		<td>Pull Cords</td><td><input type="text" size="6" maxlength="6" name="pull"></td>
	</tr>
	<tr>
		<td>
			Bedroom</td><td><input type="text" size="6" maxlength="6" name="bed"></td><td>Bathroom</td><td><input type="text" size="6" maxlength="6" name="bath"></td><td>
			Common</td><td><input type="text" size="6" maxlength="6" name="common">	
		</td>
	</tr>
	<tr>
		<td>Pull Cords with Wellness</td><td><input type="text" size="6" maxlength="6" name="pullw"></td>
	</tr>	
	<tr>
		<td>
			Bedroom</td><td><input type="text" size="6" maxlength="6" name="beda"></td><td>Bathroom</td><td><input type="text" size="6" maxlength="6" name="batha"></td><td>
			Common</td><td><input type="text" size="6" maxlength="6" name="commona">	
		</td>
	</tr>
	<tr>
		<td>
			10ft. Call Cords</td><td><input type="text" size="6" maxlength="6" name="ten"></td><td>15ft. Call Cords</td><td><input type="text" size="6" maxlength="6" name="fifteen"></td><td>
			Dual Call Cords</td><td><input type="text" size="6" maxlength="6" name="dual">
		</td>
	</tr>
	<tr>
		<td>
			Squeeze Balls</td><td><input type="text" size="6" maxlength="6" name="squeeze" </td><td>Breath Calls</td><td><input type="text" size="6" maxlength="6" name="breath">
		</td>
	</tr>
	<tr>
		<td>Corridor Light Type:</td><td><select name=type>
			<option value ="NONE">NONE</option>
  			<option value ="HomeFree">Homefree</option>
  			<option value ="Existing">Existing</option>
  			<option value ="Both">Both</option>
  		</select> </td><td>Corridor Light Style:</td><td><select name=style>
  			<option value ="NONE">NONE</option>
  			<option value ="Single">Single</option>
  			<option value ="Double">Double</option>
  			<option value ="Quad">Quad</option>
  		</select></td>
  	</tr>
  	<tr>
  		<td>
  			Number of Existing Lights</td><td><input type="text" size="6" maxlength="6" name="existing"></td><td>Number of HomeFree Lights</td><td>
  			<input type="text" size="6" maxlength="6" name="homefree">
  		</td>
  	</tr>
  	</table>
  	
<table cellpadding=3 table border ="1" width="750"  align ="center">
  	<tr>
  		<td align=center colspan="8"><font size=3 ><strong>  Paging  </strong></td>
  	</tr>
  	<tr>
  		<td align=center>Paging Base Type:</td><td><select name=base>
  			<option value ="NONE">NONE</option>
  			<option value ="Commtech5W">Commtech 5 W</option>
  			<option value ="Commtech25W">Commtech 25 W</option>
  			<option value ="Commtech50W">Commtech 50 W</option>
  			<option value ="Commtech100W">Commtech 100 W</option>
  			<option value ="Commtech200W">Commtech 200 W</option>
  			<option value ="Scope">Scope</option>
  		</select></td><td>Pager Type</td><td><select name=pager>
  			<option value ="NONE">NONE</option>
  			<option value ="Commtech7900">Commtech7900</option>
  			<option value ="Apollo">Apollo</option>
  			</select></td><td>Number of Pagers</td><td><input type="text" size="6" maxlength="6" name="numpagers"></td><td>Number of HomeFree Pagers</td><td>
  		<input type="text" size="6" maxlength="6" name="hfpagers" value="1">
  			</td>
  		</tr>
  		</table>
  		
<table cellpadding=3 table border ="1" width="750"  align ="center">
  		<tr>
  			<td align=center colspan="10"><font size=3 ><strong>  Fall Units  </strong></td>
  		</tr>	
  		<tr>
  			<td align=center>Fall Units</td><td><input type="text" size="6" maxlength="6" name="fall"></td><td>Chair Pad 90 day</td><td><input type="text" size="6" maxlength="6" name="chair90"></td><td>
  			Chair Pad 180 day</td><td><input type="text" size="6" maxlength="6" name="chair180"></td><td>Bed Pad 90 day</td><td><input type="text" size="6" maxlength="6" name="bed90"></td><td>
  			Bed Pad 180 day</td><td><input type="text" size="6" maxlength="6" name="bed180"></td>
 		</tr>
 		</table>
 		
<table cellpadding=3 table border ="1" width="750"  align ="center" >
 		<tr>
			<td align=center colspan="6"><font size=3 ><strong>  Universal Transmitters  </strong></font></td> 		
 		<tr>
 			<td align=center trspan=5> Universal Transmitters</td><td><input type="text" size="6" maxlength="6" name="ut"></td><td>Universal Transmitter Function</td><td><textarea rows="5" cols="40" name="utfunction"></textarea></td>
 		</tr>
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
 		</table>
 		
<table cellpadding=3 table border ="1" width="750"  align ="center">
 		<tr>
 			<td align=center colspan="6"><font size=3 ><strong>  Client Stations  </strong></font></td> 
 		</tr>
 		<tr>
 			<td align=center>Client Computers</td><td><input type="text" size="6" maxlength="6" name="client"></td><td>Client Station Location</td><td><textarea rows="5" cols="40" name="clientl"></textarea></td>
 		</tr>
 		<tr>
 			<td> Client Licenses </td><td><input type="text" size="6" maxlength="6" name="lic"></td>
 		</tr>
 	</table>
 <table cellpadding=3 table border ="1" width="750"  align ="center" >
 		<tr>
 			<td align=center colspan="6"><font size=3 ><strong>  Central Power and Wire  </strong></font></td>
 		</tr>
 		<tr>
 			<td align=center>Central Power Supplies</td><td><input type="text" size="6" maxlength="6" name="power"></td><td>Wire 16-2 </td><td><input type="text" size="6" maxlength="6" name="wirex"></td><td>
 			Wire 22-4 <input type="text" size="6" maxlength="6" name="wirey"></td>
 		</tr>
 </table>
 <table cellpadding=3 table border ="1" width="750"  align ="center" >
 	<tr>
 		<td align=center>Job Overview</td><td><textarea rows="12" cols="70" name="job"></textarea></td>
 	</tr>
 </table>
 <table cellpadding=3 table border ="1" width="750"  align ="center" >
 	<tr>
 		<td width = "85">
 			Quote Good For:
 		</td>
 		<td width = 55>
 		 <select name=days>
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
			<INPUT TYPE="text" NAME="startdate" VALUE="<?php echo $date; ?>" SIZE=25>
			</td>
			<td>
			<A HREF="#"
   		onClick="cal.select(document.forms['example'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
   		NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="Select" /></A>
   	</td>		
  </tr>
 </table>
 <table width="750">
 <tr>
		<td><input type="submit" value="DONE" name="done"></td>
	</tr>
</table>
</form>



<?php
}

?>
<table align="center" width="500">
<?php
if (isset($_GET['done']) OR (isset($_GET['save'])))
{
	
//General INFO Variables
$wirex = $_GET["wirex"];
$wirey = $_GET["wirey"];
$Fname =addslashes( $_GET["Fname"]);
$Address = $_GET["Address"];
$Contact= $_GET["Contact"];
$Phone =$_GET["Phone"];
$second =  $_GET["second"];
$Title = $_GET["Title"];
$Email = $_GET["Email"];
$Fax =  $_GET["Fax"];
$System = $_GET["Systype"];
$sman = $_GET["sman"];

//total equipment table variables
$dual = $_GET["dual"];
$Area = $_GET["Area"];
$OArea = $_GET["OArea"];
$SArea = $_GET["SArea"];
$watch = $_GET["watch"];
$callb = $_GET["callb"];
$tags = $_GET["tags"];
$pull = $_GET["pull"];
$pullw = $_GET["pullw"];
$ten = $_GET["ten"];
$fifteen = $_GET["fifteen"];
$type = $_GET["type"];
$style = $_GET["style"];
$existing = $_GET["existing"];
$homefree = $_GET["homefree"];
$base = $_GET["base"];
$pager = $_GET["pager"];
$numpagers = $_GET["numpagers"];
$hfpagers = $_GET["hfpagers"];
$fall = $_GET["fall"];
$chair90 = $_GET["chair90"];
$chair180 = $_GET["chair180"];
$bed90 = $_GET["bed90"];
$bed180 = $_GET["bed180"];
$ut = $_GET["ut"];
$utfunction = nl2br(addslashes($_GET["utfunction"]));
$client = $_GET["client"];
$clientl = nl2br(addslashes($_GET["clientl"]));
$power = $_GET["power"];
$job = nl2br(addslashes($_GET["job"]));
$squeeze = $_GET["squeeze"];
$breath = $_GET["breath"];
$bed = $_GET["bed"];
$beda = $_GET["beda"];
$bath = $_GET["bath"];
$batha = $_GET["batha"];
$common = $_GET["common"];
$commona = $_GET["commona"];
$pendant = $_GET["pendant"];
$watchstyle = $_GET["watchstyle"];
$baseconnect = $_GET["baseconnect"];
$utpower = $_GET['utpower'];
$lic = $_GET['lic'];
$days = $_GET['days'];
$startdate = $_GET['startdate'];

										      		echo '<tr>';                                                            
                                                            		echo '<td align="center" td colspan="2"><font size="5" ><strong>' .stripslashes( $Fname ). '</strong></td>';
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            		echo '<td align="center" td colspan="2"><font size="3" ><strong>' . $Address . '</strong></td>';			
                                                            echo '</tr>';	
                                                            echo '<tr>';
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            echo '</tr>';                                                           	
                                                            echo '<tr>';
                                                          		echo '<td><font size="2" >' . 'Contanct Name:    ' . $Contact.'</td>';
                                                          		echo '<td ><font size="2" >' . 'Title:    ' . $Title.'</td>';
                                                          	echo '<tr>';
                                                          		echo '<td><font size="2">' . 'Phone Number:    ' .formatPhone($Phone).'</td>';
                                                          		echo '<td><font size="2">' . '2nd Number:    ' . formatPhone($second).'</td>';
                                                           	echo '</tr>';
                                                          	echo'<tr>';
                                                          		echo '<td><font size="2">' . 'System Type:    ' . $System.'</td>';
                                                          		echo '<td><font size="2">' . 'Fax:    ' . formatPhone($Fax).'</td>';
                                                          	echo '</tr>';
                                                          	echo '<tr>';
                                                          		echo '<td><font size="2">' . 'Email:    ' . $Email.'</td>';
                                                          		echo '<td align="center"><font size="2">' . 'HomeFree Sales Representative:    ' . $sman.'</td>';
                                                          	echo '</tr>';
?>
</table>


													
													
<table align="center" width="750">
 <?php
 
if (!($Area==0 & ($OArea==0  & ($SArea==0))))
{	
echo '<tr><td>' . '<strong>'. '<u>' . 'NETWORK' . '</strong>' . '</u></td></tr>';
}
if (!$Area==0)
{	
		echo '<tr><td>' .  'Area Units:    ' . $Area . '</td></tr>';
	}
if (!$OArea==0)
{	
		echo '<tr><td>' .  'Outdoor Area Units:    ' . $OArea . '</td></tr>';
	}
if (!$SArea==0)
{	
		echo '<tr><td>' .  'Solar Area Units:    ' . $SArea . '</td></tr>';
	}
	
	
	
		if (!($watch==0 & ($callb==0 & ($tags==0))))
	{
		echo '<tr><td><u>' . '<strong>' . 'ACCESSORIES' . '</strong>' . '</u></td></tr>';
	}
if (!$watch==0)
{	
		echo '<tr><td>' . 'Watches:    ' . $watch . '</td></tr>';
	}
if (!$callb==0)
{	
		echo '<tr><td>' .  'Call Buttons:    ' . $callb . '</td></tr>';
		echo '<tr><td>' .  'Pendant Style:    ' . $pendant . '</td></tr>';
		echo '<tr><td>' .  'Watch Style:    ' . $watchstyle . '</td></tr>';
	}
	if (!$tags==0)
	{	
		echo '<tr><td>' .  'Total Pull Tags:    ' . $tags . '</td></tr>';
	}
	
	
	
	
	if (!$pull==0)
	{	
		echo '<tr><td><u>' . '<strong>' . 'PULL CORDS' . '</strong>' . '</u></td></tr>';
	}
if (!$pull==0)
	{	
		echo '<tr><td>' . 'Total Pull Cords:    ' . $pull . '</td></tr>';
	}
if (!$bed==0)
	{	
		echo '<tr><td>' . 'Bedroom:    ' . $bed . '</td></tr>';
	}
if (!$bath==0)
	{	
		echo '<tr><td>' . 'Bathroom:    ' . $bath . '</td></tr>';
	}
if (!$common==0)
	{	
		echo '<tr><td>' . 'Common:    ' . $common . '</td></tr>';
	}
	if (!$pullw==0)
	{{
		echo '<tr><td>' . 'Total Pull Cords with Wellness:    ' . $pullw . '</td></tr>';
	}
	if (!$beda==0)
	{	
		echo '<tr><td>' . 'Bedroom:    ' . $beda . '</td></tr>';
	}
if (!$batha==0)
	{	
		echo '<tr><td>' . 'Bathroom:    ' . $batha . '</td></tr>';
	}
if (!$commona==0)
	{	
		echo '<tr><td>' . 'Common:    ' . $commona . '</td></tr>';
	}}
if (!$ten==0)
	{	
		echo '<tr><td>' . '10ft. Call Cords:    ' . $ten . '</td></tr>';
	}
	if (!$fifteen==0)
	{	
		echo '<tr><td>' .  '15ft. Call Cords:    ' . $fifteen . '</td></tr>';
	}
		if (!$dual==0)
	{	
		echo '<tr><td>' .  'Dual Call Cords:    ' . $dual . '</td></tr>';
	}
		if (!$squeeze==0)
	{	
		echo '<tr><td>' .  'Squeeze Balls:    ' . $squeeze . '</td></tr>';
	}
		if (!$breath==0)
	{	
		echo '<tr><td>' .  'Breath Calls:    ' . $breath . '</td></tr>';
	}
		if ($type<>"NONE")
	{	
		echo '<tr><td>' .  'Corridor Light Type:    ' .$type . '</td></tr>';
	}
		if ($style<>"NONE")
	{	
		echo '<tr><td>' .  'Corridor Light Style:    ' . $style . '</td></tr>';
	}
		if (!$existing==0)
	{	
		echo '<tr><td>' .  'Number of Existing Lights:    ' . $existing . '</td></tr>';
	}
		if (!$homefree==0)
	{	
		echo '<tr><td>' .  'Number of HomeFree Lights:    ' . $homefree . '</td></tr>';
	}




	if ($base <>"NONE")
	{
		echo '<tr><td><u>' . '<strong>' . 'PAGING' . '</strong>' . '</u></td></tr>';
	}
		
		if ($base <>"NONE")
	{	
		echo '<tr><td>' .  'Paging Base Type:    ' . $base . '</td></tr>';
	}
		if ($pager <>"NONE")
	{	
		echo '<tr><td>' .  'Pager Type:    ' . $pager . '</td></tr>';
	}
			if (!$numpagers==0)
	{	
		echo '<tr><td>' .  'Number of Pagers:    ' . $numpagers . '</td></tr>';
	}
			if (!$hfpagers==0)
	{	
		echo '<tr><td>' .  'Number of HomeFree Pagers:    ' . $hfpagers . '</td></tr>';
	}
	
	
	
		if (!$fall==0)
	{	
		echo '<tr><td><u>' . '<strong>' . 'FALL UNITS' . '</strong>' . '</u></td></tr>';
	}
		if (!$fall==0)
	{	
		echo '<tr><td>' .  'Fall Units:    ' . $fall . '</td></tr>';
	}
		if (!$chair90==0)
	{	
		echo '<tr><td>' .  '90 Day Chair Pads:    ' . $chair90 . '</td></tr>';
	}
		if (!$chair180==0)
	{	
		echo '<tr><td>' .  '180 Chair Pads:    ' . $chair180 . '</td></tr>';
	}
		if (!$bed90==0)
	{	
		echo '<tr><td>' .  '90 Day Bed Pads:    ' . $bed90 . '</td></tr>';
	}
		if (!$bed180==0)
	{	
		echo '<tr><td>' .  '180 Bed Pads:    ' . $bed180 . '</td></tr>';
	}
	
	
	
	
	if (!$ut==0)
	{
	echo '<tr><td><u>' . '<strong>' . 'UNIVERSAL TRANSMITTERS' . '</strong>' . '</u></td></tr>';
	}
	if (!$ut==0)
	{	
		echo '<tr><td>' .  'Universal Transmitters:    ' . $ut . '</td></tr>';
	}	
		if (!$utfunction==0)
	{	
		echo '<tr><td>' .  'Universal Transmitter Function:    ' . stripslashes($utfunction) . '</td></tr>';
	}
	
	
	if (!$client==0 & $lic == 0)
	{		
	echo '<tr><td><u>' . '<strong>' . 'CLIENT STATIONS' . '</strong>' . '</u></td></tr>';
	}
		if (!$client==0)
	{	
		echo '<tr><td>' .  'Number of Client Stations:    ' . $client . '</td></tr>';
	}	 
	if (!$clientl==0)
	{	
		echo '<tr><td>' .  'Client Station Location:    ' . stripslashes($clientl) . '</td></tr>';
	}	 
	if (!$lic==0)
	{
		echo '<tr><td>' .  'Number of Client Licenses:    ' . $lic . '</td></tr>';
	}
	
		if (!$power==0)
	{		
	echo '<tr><td><u>' . '<strong>' . 'Central Power Supplies' . '</strong>' . '</u></td></tr>';
	}
		if (!$power==0)
	{		
	echo '<tr><td>' .  'Central Power Supplies:    ' . $power . '</td></tr>';
	}





		if (!($wirex ==0 & ($wirey ==0)))
	{		
	echo '<tr><td><u>' . '<strong>' . 'Wire' . '</strong>' . '</u></td></tr>';
	}
		if (!$wirex==0)
	{		
	echo '<tr><td>' .  '16-2 Wire:    ' . $wirex . '</td></tr>';
	}
		if (!$wirey==0)
	{		
	echo '<tr><td>' .  '22-4 Wire:    ' . $wirey . '</td></tr>';
	}	
	
	echo  '<tr><td><u>' . '<strong>' . 'Job Overview' . '</strong>' . '</u></td></tr>';
	echo '<tr><td>' . stripslashes($job) . '</td></tr>';
		/*			
			$sum=($Area + $SArea + $OArea);
			//echo $sum;
					
				if($_GET['baseconnect'] == "network")
						{
					if($sum < 60)
							{
								$baseunitserial = 0;
								$baseunitnet = 1;
							}
					
					if($sum  > 60)
							{
									$baseunitserial = 0;
														
									$baseunitx = ceil($sum/ 60);
								
									$baseunitnet = $baseunitx;
							}
						}else
						{	
					if($sum < 60)
							{
								$baseunitserial = 1;
								$baseunitnet = 0;
							}
					
					if($sum > 60)
							{
									$baseunitserial = 1;
														
									$baseunitx = ceil($sum / 60);
								
									$baseunitnet = ($baseunitx - 1);
							}
						}
						*/
					
		if (isset($_GET['done']))
													{	
														
													
															
																	
													$query="INSERT INTO tblfacilitygeneralinfo (FacilityName,Address,PhoneNumber,ContactName,secondnumber,Title,Email,Fax,SystemType,Salesman, signature, lastupdated) 
													VALUES ('$Fname', '$Address', '$Phone', '$Contact', '$second','$Title','$Email','$Fax','$System','$sman','$signature', '$date')";
													mysql_query($query) or die(mysql_error());
													
													$query2="Select * From tblfacilitygeneralinfo WHERE FacilityName = '$Fname'";
    											$result2 = mysql_query($query2) or die (mysql_error());
	 												$row2 = mysql_fetch_array($result2);	
													//echo  '<td>' . $row2['ID'] . '</td>';
													
													$f_id=$row2['ID'];

													
														
													$query3="INSERT INTO tblTotalEquipment (TotalWMUs,TotalWatches,TotalPanicButtons,TotalPullCords,TotalPullCordsactivity,TotalCallCords,HomeFreePager,TotalCentralPowerSupplies,
													Wire224,FacilityID,TotalOutdoorAreaUnits,TotalOutdoorSolarUnits,TotalCallCordssingle15,TotalCallCorddual,CorridorLights,CorridorLightType,TotalExistingCorrdiorLights,
													TotalHomeFreeCorrdiorLights,Wire162,PagingBaseType,PagerQuantity,TotalFallUnits,bed90day,bed180day,chair90day,chair180day,UTs,UTFunction,TotalPullTags,TotalClientStations,
													ClientStationlocation,PagerType,joboverview,Squeezeball,breathcall,bedpullcords,bathpullcords,commonpullcords,bedpullcordsact,bathpullcordsact,commonpullcordsact,pendant,watchstyle, 
													baseconnect,utpower, lic, days, startdate) 
													VALUES ('$Area','$watch','$callb','$pull','$pullw','$ten','$hfpagers','$power','$wirey','$row2[ID]','$OArea','$SArea','$fifteen','$dual','$type','$style','$existing','$homefree','$wirex','$base','$numpagers',
													'$fall','$bed90','$bed180','$chair90','$chair180','$ut','$utfunction','$tags','$client','$clientl','$pager','$job','$squeeze','$breath','$bed','$bath','$common','$beda','$batha','$commona','$pendant','$watchstyle',
													 '$baseconnect', '$utpower', '$lic','$days','$startdate')";
                                                        	mysql_query($query3) or die(mysql_error());
                                                        	
                                                        	
    													}
   		if (isset($_GET['save']))
		{
			$f_id = $_GET['f_id'];
			$query2="Select * From tblfacilitygeneralinfo WHERE ID = '$f_id'";
  		$result2 = mysql_query($query2) or die (mysql_error());
			$row2 = mysql_fetch_array($result2);
	 												

			
//echo $f_id;

			$query7 = "UPDATE tblfacilitygeneralinfo SET FacilityName = '$Fname', Address = '$Address', ContactName = '$Contact', PhoneNumber = '$Phone', secondnumber = '$second',Title = '$Title',
			Email = '$Email', Fax = '$Fax', SystemType = '$System', Salesman = '$sman', lastupdated = '$date' WHERE ID = '$f_id'";
			mysql_query($query7) or die(mysql_error());
		
			$query8 = "UPDATE tbltotalequipment SET TotalWMUs = '$Area', TotalWatches = '$watch', TotalPanicButtons = '$callb', TotalPullCords = '$pull', TotalPullCordsactivity = '$pullw',TotalCallCords = '$ten',
			HomeFreePager = '$hfpagers', TotalCentralPowerSupplies = '$power', Wire224 = '$wirey', TotalOutdoorAreaUnits = '$OArea', TotalOutdoorSolarUnits = '$SArea',  TotalCallCordssingle15 = '$fifteen',
			TotalCallCorddual = '$dual', CorridorLights = '$type', CorridorLightType = '$style', TotalExistingCorrdiorLights = '$existing', TotalHomeFreeCorrdiorLights = '$homefree', Wire162 = '$wirex',
			PagingBaseType = '$base', PagerQuantity = '$numpagers', TotalFallUnits = '$fall', bed90day = '$bed90', bed180day = '$bed180', chair90day = '$chair90', chair180day = '$chair180', UTs = '$ut',
			UTFunction = '$utfunction', TotalPullTags = '$tags', TotalClientStations = '$client', ClientStationlocation = '$clientl', PagerType = '$pager', joboverview = '$job', Squeezeball = '$squeeze',
			breathcall = '$breath', bedpullcords = '$bed', bathpullcords = '$bath', commonpullcords = '$common', bedpullcordsact = '$beda', bathpullcordsact = '$batha', commonpullcordsact = '$commona',
			pendant = '$pendant', watchstyle = '$watchstyle', baseconnect = '$baseconnect', utpower = '$utpower', lic = '$lic',
			days = '$days', startdate = '$startdate' WHERE FacilityID = '$f_id'";
			mysql_query($query8) or die(mysql_error());
		
		}

?>
	</table>
<table align="center" width="750">
<tr>
		<td align="center">&nbsp;</td>
	</tr><tr>
		<td align="center">&nbsp;</td>
	</tr>
	<tr>
	
	<?php
$query18 = "Select * FROM tblprojectmanagement WHERE FacilityID = '$f_id'";
$result18 = mysql_query($query18) or die(mysql_error());
$row18 = mysql_num_rows($result18);	
		
		if($row18 == 0)
			{
		?>
		<tr>
		<td><button onClick="window.location='projectmanage.php?f_id=<?php echo $row2['ID']; ?>'">Add Project Info</button></td>
		
	<?php
	}else{
	
	?>
	
	<td><button onClick="window.location='projectmanage.php?action=UPDATE&f_id=<?php echo $row2['ID']; ?>'">Update Project Info</button></td>
	
		<?php
	}
$query9 = "Select * FROM tblfacilitydoors WHERE FacilityID = '$f_id'";
$result9 = mysql_query($query9) or die(mysql_error());
$row9 = mysql_num_rows($result9);	
	
		if($row9 == 0)
{

				
	?>
	
		<td><button onClick="window.location='doorunit.php?f_id=<?php echo $row2['ID']; ?>'">Add Door Units</button></td>
	
	<?php
} else {	

?>
	
		<td><button onClick="window.location='doorunit.php?action=UPDATE&f_id=<?php echo $row2['ID']; ?>'">Add/Update Door Units</button></td>
	
		<?php
			}
			if(!$row18 == 0)
			{
	?>
		<td><button onClick="window.location='newfinishedpage.php?f_id=<?php echo $row2['ID']; ?>'">Complete</button></td>
	</tr>
</table>
<?php									                                                                                                
}}
include 'includes/closedb.php';
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>