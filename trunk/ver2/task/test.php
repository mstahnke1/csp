<?php
include 'includes/config.php';
include 'includes/opendb.php';
$query1 = "SELECT * From tbltotalequipment WHERE FacilityID='$facilityID'";
$result1 = mysql_query($query1) or die (mysql_error());
$row1 = mysql_fetch_array($result1);
$startdate = $row1['startdate'];
$start = strtotime($startdate);
if($row1['startdate'] == 30)
	{
		$days1 =  strtotime("+30 days");
		$expiration = $start;
		
	}elseif($row1['startdate'] == 45)
	{
		$expirationdate =  strtotime("+45 days");
	}
?>

<table>
	<tr>
		<td>
			$days<?php echo $days1; ?>
		</td>
	</tr>
	<tr>
		<td>
			$start<?php echo $start; ?>
		</td>
	</tr>	
	