<?php
include 'config.inc.php';
include 'db_connect.inc.php';
$curDate = date('Y-m-d H:i:s');
$curActive = date('Y-m-d H:i:s', strtotime("-$maxActive Minutes", strtotime($curDate)));
$query21 = "SELECT *
						FROM tblTickets
						WHERE ((DateOpened >= '$curActive'
						OR ID IN (SELECT TicketID FROM tblticketmessages WHERE Date >= '$curActive'))
						AND Status <> -1)";
$result21 = mysql_query($query21) or die (mysql_error());
$num21 = mysql_num_rows($result21);
?>

<h3><?php echo $num21; ?> Current Active Tickets</h3>

<table width="100%">
	<tr>
		<td class="heading">
			Facility
		</td>
		<td class="heading">
			Duration
		</td>
		<td class="heading">
			Contact
		</td>
		<td class="heading">
			Technician
		</td>
	</tr>
	<?php
	if($num21 > 0) {
		while($row21 = mysql_fetch_array($result21)) {
			$curDate = strtotime("now");
			$ticket_num = $row21['ID'];
			$query99 = "SELECT f_name, l_name FROM employees WHERE id = '$row21[OpenedBy]'";
    	$result99 = mysql_query($query99);
    	$row99 = mysql_fetch_array($result99);
    	$technician = $row99['l_name'] . ", " . $row99['f_name'];
			$query23 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$row21[CustomerNumber]'";
			$result23 = mysql_query($query23);
			$row23 = mysql_fetch_array($result23);
			$DateOpened = strtotime($row21['DateOpened']);
			$DateUpdated = $DateOpened;
			$query22 = "SELECT Date, EnteredBy FROM tblticketmessages WHERE TicketID = '$ticket_num' ORDER BY Date DESC LIMIT 1";
			$result22 = mysql_query($query22) or die (mysql_error());
			$num22 = mysql_num_rows($result22);
			if($num22 > 0) {
				$row22 = mysql_fetch_array($result22);
				if(strtotime($row22['Date']) > $DateOpened) {
					$DateUpdated = $row22['Date'];
					$query99 = "SELECT f_name, l_name FROM employees WHERE id = '$row22[EnteredBy]'";
    			$result99 = mysql_query($query99);
    			$row99 = mysql_fetch_array($result99);
    			$technician = $row99['l_name'] . ", " . $row99['f_name'];
				}
			}
			$timeActive = $curDate - $DateOpened;
			$durationMinutes = floor($timeActive / 60);
			$temp_remainder = $timeActive - ($durationMinutes * 60);
			$durationSeconds = $temp_remainder;
			$duration = $durationMinutes . " Minutes " . $durationSeconds . " Seconds";
			?>
			<tr>
				<td class="body">
					<?php echo $row23['FacilityName']; ?>
				</td>
				<td class="body">
					<?php echo $duration; ?> 
				</td>
				<td class="body">
					<?php echo $row21['Contact']; ?>
				</td>
				<td class="body">
					<?php echo $technician; ?>
				</td>
				<td>
			</tr>
			<?php
		}
	} else {
	?>
		<tr>
			<td colspan="5" align="center" class="body">
				No Current Support Activity
			</td>
		</tr>
	<?php
	}
	?>
</table>