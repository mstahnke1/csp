<?php
include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
if(isset($_POST['srchString']) && $_POST['srchType'] == 'facilityName') {
	$srchString = $_POST['srchString'];
	$qryCustSearch = "SELECT CustomerNumber, FacilityName, FacilityNameOther 
										FROM tblFacilities 
										WHERE (FacilityName LIKE '%$srchString%' OR FacilityNameOther LIKE '%$srchString%') 
										AND Active = -1 
										ORDER BY FacilityName";
	$rstCustSearch = mysql_query($qryCustSearch) or die(mysql_error());
	$numCustSearch = mysql_num_rows($rstCustSearch);
} elseif(isset($_POST['srchString']) && $_POST['srchType'] == 'custNum') {
	$srchString = $_POST['srchString'];
	$qryCustSearch = "SELECT CustomerNumber, FacilityName, FacilityNameOther 
										FROM tblFacilities 
										WHERE CustomerNumber = '$srchString'  
										AND Active = -1 
										ORDER BY FacilityName";
	$rstCustSearch = mysql_query($qryCustSearch) or die(mysql_error());
	$numCustSearch = mysql_num_rows($rstCustSearch);
}
?>

<div class="cspDashModule">
	<fieldset>
	<legend>Search Results</legend>
		<?php
		if($numCustSearch > 0 && isset($_POST['srchType'])) {
			while($rowCustSearch = mysql_fetch_array($rstCustSearch)) {
				?>
				<a href="cspUserSupport_Customer.php?custID=<?php echo $rowCustSearch['CustomerNumber']; ?>"><div class="cspMOHighlight"><?php echo $rowCustSearch['FacilityName']; ?></div></a>
				<?php
			}
		} else {
			?>
			<div>Search returned no matches</div>
			<?php
		}
		?>
	</fieldset>
</div>

<?php
include 'includes/db_close.inc.php';
?>