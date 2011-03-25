<?php
include 'config.inc.php';
include 'db_connect.inc.php';
$curDate = date('Y-m-d');
$curMonth = date('Y-m');
$lastMonday = date('Y-m-d', strtotime("last Monday"));
$secIntoWeek = (strtotime($curDate) - strtotime($lastMonday));
$minIntoWeek = $secIntoWeek / 60;
$hrsIntoWeek = $minIntoWeek / 60;
$dysIntoWeek = $hrsIntoWeek / 24;
$query30 = "SELECT ID
						FROM tblTickets
						WHERE (DateOpened >= '$curDate'
						OR ID IN (SELECT TicketID FROM tblticketmessages WHERE Date >= '$curDate'))";
$result30 = mysql_query($query30);
$num30 = mysql_num_rows($result30);
$query31 = "SELECT ID
						FROM tblTickets
						WHERE (DateOpened >= '$lastMonday'
						OR ID IN (SELECT TicketID FROM tblticketmessages WHERE Date >= '$lastMonday'))";
$result31 = mysql_query($query31);
$num31 = mysql_num_rows($result31);
$query32 = "SELECT ID
						FROM tblTickets
						WHERE (DateOpened >= '$curMonth'
						OR ID IN (SELECT TicketID FROM tblticketmessages WHERE Date >= '$curMonth'))";
$result32 = mysql_query($query32);
$num32 = mysql_num_rows($result32);
$dailyAvForWeek = round($num31 / $dysIntoWeek, 1);
?>

<h3>Ticket Statistics</h3>

<table width="100%">
	<tr align="center">
		<td class="border">
			<table>
				<tr>
					<td class="heading">
						Currently Active
					</td>
				</tr>
				<tr>
					<td align="center" class="body">
						<?php echo $num21; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading">
						Total Active Today
					</td>
				</tr>
				<tr>
					<td align="center" class="body">
						<?php echo $num30; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading">
						Total Active Week
					</td>
				</tr>
				<tr>
					<td align="center" class="body">
						<?php echo $num31; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table>
				<tr>
					<td class="heading">
						Total Active Month
					</td>
				</tr>
				<tr>
					<td align="center" class="body">
						<?php echo $num32; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="border">
			<table>
				<tr>
					<td class="heading">
						Daily Average
					</td>
				</tr>
				<tr>
					<td align="center" class="body">
						*<?php echo $dailyAvForWeek; ?><br />
						<font size="1">* Calculated this week
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>