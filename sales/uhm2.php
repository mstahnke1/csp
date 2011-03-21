<?php
include 'includes/config.php';
include 'includes/opendb.php';	
	$query23 = "SELECT * FROM tblproactivecall WHERE Message <> -1 AND callback = -1";
	$result23 = mysql_query($query23) or die (mysql_error());
	$row23 = mysql_fetch_array($result23);
	$customernumber = $row23['CustomerNumber'];	
	mysql_select_db('testhomefree');
	$query31 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$customernumber'";
	$result31 = mysql_query($query31) or die (mysql_error());
	$row31 = mysql_fetch_array($result31);		
	?>
				
				<table>
					<td class="heading">
						Facilities with pending calls:
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $row31['FacilityName']; ?>
					</td>
				</tr>
			</table>