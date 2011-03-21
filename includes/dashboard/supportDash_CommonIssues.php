<!-- START Recent Support Call Stats Dashboard Module -->
<?php
include_once ('includes/config.inc.php');
include_once ('includes/db_connect.inc.php');

$qryCommonIssues1 = "SELECT COUNT(tblTickets.id) AS issueCount, tblTickets.categoryCode AS categoryCode, issueCategories.description AS issueDesc 
										FROM tblTickets 
										LEFT JOIN issueCategories ON issueCategories.code = tblTickets.categoryCode 
										WHERE tblTickets.categoryCode IN NOT NULL 
										GROUP BY categoryCode";
$rstCommonIssues1 = mysql_query($qryCommonIssues1);
$numCommonIssues1 = mysql_num_rows($rstCommonIssues1);
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Most Common Support Issues</td>
		</tr>
		<tr>
			<td>
				<?php
				if($numCommonIssues1 > 0) {
					?>
					<div>
						<span style="display:inline-block; width:90%;"><u>Issue Description (Reported)</u></span>
					</div>
					<?php
					while($rowCommonIssues1 = mysql_fetch_array($rstCommonIssues1)) {
						?>
						<div class="cspMOHighlight">
							<span style="display:inline-block; width:90%;"><?php echo $rowCommonIssues1['issueDesc'] . " (" . $rowCommonIssues1['issueCount'] . ")"; ?></span>
						</div>
						<?php
					}
				} else {
					?>
					<div>
						<span style="display:inline-block; width:100%;">No recent issues have been logged.</span>
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
<!-- END Recent Support Call Stats Dashboard Module -->