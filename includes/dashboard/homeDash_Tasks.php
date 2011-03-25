<!-- START Task Dashboard Module -->
<?php
include('includes/config.inc.php');
include('includes/db_connect.inc.php');

$agent = $_SESSION['uid'];
$query8 = "SELECT id, f_name, l_name, dept, recFloorplan, recRmaEmail, manageRma, warr_prog FROM employees WHERE id = '$agent'";
$result8 = mysql_query($query8) or die (mysql_error());
$row8 = mysql_fetch_array($result8);

mysql_select_db($dbname2);
$query3 = "SELECT * FROM taskinfo WHERE (((Assignto = '$agent' && Response != '2000' && Response != '2001')
			|| Response = '$agent'";  # Shows tasks assigned in to logged in user
if($row8['manageRma'] == 1) {
	$query3 .= " || Response = '2002'"; # Shows tasks for those who manage RMA's
}
if($row8['recFloorplan'] == 1) {
	$query3 .= " || Response = '1000'"; # Shows tasks for those assigned to do floor plans
}
if($row8['recRmaEmail'] == 1) {
	$query3 .= " || Response = '2000'"; # Shows tasks for RMAs handled by the sales team
}
if($row8['dept'] == 5) {
	$query3 .= " || Response = '2001'"; # Shows tasks for everyone in the warehouse dept.
}
	$query3 .= " || Response2 = '$agent')
			&& (Status NOT IN(3, 4, 5))) ORDER BY Duedate";
$result3 = mysql_query($query3) or die(mysql_error());
$numTasks = mysql_num_rows($result3);
$query10 = "SELECT ID, Type FROM tbltype";
$result10 = mysql_query($query10);
$row10 = mysql_fetch_array($result10);
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Open Tasks</td>
		</tr>
		<tr>
			<td>
				<?php
				if($numTasks > 0) {
					?>
					<div>
						<span style="display:inline-block; width:77%;"><u>Subject</u></strong></span><span style="display:inline-block; width:23%;"><u>Date Due</u></strong></span>
					</div>
					<?php
					while($row3 = mysql_fetch_array($result3)) {
						?>
						<div class="cspMOHighlight">
							<span style="display:inline-block; width:77%;"><?php echo $row3['Subject']; ?></span><span style="display:inline-block; width:23%; vertical-align:top;"><?php echo date("Y-m-d", strtotime($row3['Duedate'])); ?></span>
						</div>
						<?php
					}
				} else {
					?>
					<div>
						<span style="display:inline-block;">Currently there are no open tasks</span>
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
<!-- END Task Dashboard Module -->