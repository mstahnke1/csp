<!-- START Recent Support Call Stats Dashboard Module -->
<?php
include_once ('includes/config.inc.php');
include_once ('includes/db_connect.inc.php');

$dateTo = date('Y-m-d', strtotime('+1 day',strtotime(date('Y-m-d'))));
$dateFrom = date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));

$qryCommonIssues1 = "SELECT tblTickets.*, COUNT(DISTINCT tblTickets.ID) AS issueCount, issueCategories.description AS catDesc, issueCategories.parentCode AS parentCode 
										FROM tblTickets 
										LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID 
										LEFT JOIN issueCategories ON tblTickets.categoryCode = issueCategories.code 
										WHERE tblTicketMessages.Date > '$dateFrom' AND tblTicketMessages.Date < '$dateTo' 
										AND tblTicketMessages.msgType = 2 
										AND tblTickets.Status NOT IN(1) 
										GROUP BY tblTickets.categoryCode ORDER BY issueCount DESC LIMIT 0,20";
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
						if(is_null($rowCommonIssues1['categoryCode'])) {
							$catDesc = "Undefined";
							$i = 0;
						} else {
							$catDesc = $rowCommonIssues1['catDesc'];
							$catCode = $rowCommonIssues1['parentCode'];
							$i = 1;
						}
						while($i > 0) {
							$qryCatCode1 = "SELECT * FROM issueCategories WHERE code = '$catCode'";
							$rstCatCode1 = mysql_query($qryCatCode1);
							$i = mysql_num_rows($rstCatCode1);
							$rowCatCode1 = mysql_fetch_assoc($rstCatCode1);
							if($i > 0) {
								$catDesc = $rowCatCode1['description'] . " &rarr; " . $catDesc;
							}
							$catCode = $rowCatCode1['parentCode'];
						}
						?>
						<div class="cspMOHighlight">
							<span style="display:inline-block; width:90%; text-indent:-7px; padding-left:7px;">&bull; <?php echo $catDesc . " (" . $rowCommonIssues1['issueCount'] . ")"; ?></span>
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