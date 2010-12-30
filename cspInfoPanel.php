<img src="images/logo_home.gif" alt="Company Logo" style="float:left;" />
<?php
if(isset($_SESSION['uid'])) {
	?>
	<div class="cspInfoPanel">
		<div>
			<span>Welcome <?php echo $_SESSION['displayname']; ?></span>
			<span style="float:right; padding-right:2px;"><a href="JavaScript:void(0);" onclick="window.location='csp_UserLogin.php?action=logout'">[Log Out]</a></span>
		</div>
		<div>Date: <?php echo date("D M jS Y"); ?></div>
		<div class="cspInfoPanelMsg">Happy Thanksgiving!</div>
	</div>
	<?php
}
?>