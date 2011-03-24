<?php
$agent = $_SESSION['uid'];
$query8 = "SELECT id, f_name, l_name, dept, recFloorplan, recRmaEmail, manageRma, warr_prog FROM employees WHERE id = '$agent'";
$result8 = mysql_query($query8) or die (mysql_error());
$row8 = mysql_fetch_array($result8);

mysql_select_db($dbname2);
$query3 = "SELECT ID, Subject FROM taskinfo WHERE (((Assignto = '$agent' && Response != '2000' && Response != '2001') 
					|| (Response = '$agent' && Assignto = 0)";  # Shows tasks assigned in to logged in user
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
$query3 .= " || Response2 = '$agent') && (Status NOT IN(3, 4, 5)) && ack = 0) ORDER BY Duedate";

$result3 = mysql_query($query3) or die(mysql_error());
$numNewTasks = mysql_num_rows($result3);

mysql_select_db($dbname);
?>
<div class="sidebox">
	<div class="boxhead"><h2>Notification Panel</h2></div>
	<div class="boxbody">
		<div id="boxContent">
			<?php
			if($numNewTasks > 0) {
				?>
				<div style="text-align: center; border-bottom: 1px solid #999999;">
					<strong>** New Notifications **</strong>
				</div>
				<?php
				while($row3 = mysql_fetch_assoc($result3)) {
					?>
					<a href="scripts/notificationAck.php?taskID=<?php echo $row3['ID'];?>" style="font-size: 1.0em;">
						<div>
							<span style="display:inline-block; width:98%; text-indent:-10px; padding-left:8px;"><img src="theme/default/images/indent1.gif" /><?php echo "Task " . $row3['ID'] . " | " . $row3['Subject']; ?></span>
						</div>
					</a>
					<?php
				}
			} else {
				?>
				<div style="text-align: center;">
					No new notifications
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>