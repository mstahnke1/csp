	<!-- START Database Backup Dashboard Module -->
<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';

$qryDashDb1 = "SELECT MAX(filemanager.timestamp) AS MaxTimestamp, MAX(filemanager.id) AS ID, filemanager.timestamp AS timestamp, filemanager.name AS name, filemanager.refNumber AS refNumber, tblCustSystemInfo.CustomerNumber AS CustomerNumber, tblCustSystemInfo.ConnectionType AS ConnectionType 
							FROM filemanager 
							LEFT JOIN tblCustSystemInfo ON filemanager.refNumber = tblCustSystemInfo.CustomerNumber 
							WHERE (name LIKE '%Database%' OR name LIKE '%Db%') 
							AND Publish = -1 AND (ConnectionType = '10' OR ConnectionType = '2') 
							AND CustomerNumber NOT IN (SELECT CustomerNumber FROM tblFacilities WHERE Active = 0) 
							GROUP BY CustomerNumber 
							ORDER BY ID ASC LIMIT 20";
$rsltDashDb1 = mysql_query($qryDashDb1) or die(mysql_error());

$qryDashDb2 = "SELECT CustomerNumber FROM tblCustSystemInfo 
							WHERE (ConnectionType = '10' OR ConnectionType = '2') 
							AND CustomerNumber NOT IN (SELECT refNumber FROM fileManager WHERE (name LIKE '%Database%' OR name LIKE '%Db%') AND Publish = -1) 
							AND CustomerNumber NOT IN (SELECT CustomerNumber FROM tblFacilities WHERE Active = 0) 
							LIMIT 10";
$rsltDashDb2 = mysql_query($qryDashDb2) or die(mysql_error());
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Databases Needing Backup</td>
		</tr>
		<tr>
			<td>
				<div>
					<span style="display:inline-block; width:77%;"><strong><u>Facility Name</u></strong></span><span style="display:inline-block; width:23%;"><strong><u>Last Backup</u></strong></span>
				</div>
				<?php
				while($rowDashDb2 = mysql_fetch_array($rsltDashDb2)) {
					$query13 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$rowDashDb2[CustomerNumber]'";
					$result13 = mysql_query($query13);
					$row13 = mysql_fetch_array($result13);
					?>
					<div class="cspMOHighlight">
						<span style="display:inline-block; width:77%;"><?php echo $row13['FacilityName']; ?></span><span style="display:inline-block; width:23%;"><em>No Backup</em></span>
					</div>
					<?php
				}
				while($rowDashDb1 = mysql_fetch_array($rsltDashDb1)) {
					$query13 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$rowDashDb1[CustomerNumber]'";
					$result13 = mysql_query($query13);
					$row13 = mysql_fetch_array($result13);
					?>
					<div class="cspMOHighlight">
						<span style="display:inline-block; width:77%;"><?php echo $row13['FacilityName']; ?></span><span style="display:inline-block; width:23%; vertical-align:top;"><?php echo date("Y-m-d", strtotime($rowDashDb1['MaxTimestamp'])); ?></span>
					</div>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
</div>

<?php
include 'includes/db_close.inc.php';
?>
<!-- END Database Backup Dashboard Module -->