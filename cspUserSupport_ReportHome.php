<?php
require_once('includes/cspSessionMgmt.php');
include_once('includes/config.inc.php');
include_once('includes/db_connect.inc.php');
include_once('includes/functions.inc.php');
$qryCallReport1 = "SELECT id, f_name, l_name FROM employees ORDER BY l_name ASC";
$rstCallReport1 = mysql_query($qryCallReport1) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
<head>
	<title><?php echo $companyName; ?> | CSP - Support</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="theme/default/cspDefault.css" />
	<link rel="stylesheet" type="text/css" href="tinyboxstyle.css" />
	<script type="text/javascript" src="js/cb.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		function showList() {
		sList = window.open("includes/reports/cspReport_custSearch.php", "list", "width=350, height=500, scrollbars=yes");
	}
	
	function remLink() {
		if (window.sList && !window.sList.closed)
	  	window.sList.opener = null;
	}
	// -->
	</SCRIPT>
	<link rel="icon" type="image/ico" href="favicon.ico" />
</head>

<body>
	<center>
		<div class="cspContainer">
			<div class="cspHeader">
				<?php require_once('cspInfoPanel.php'); ?>
			</div>
			<div class="cspLeftPanel">
				<?php require_once('cspMenuBar.php'); ?>
			</div>
			<div class="cspRightPanel">
				<?php require_once('cspRightPanel.php'); ?>
			</div>
			<div id="cspContent" class="cspContent" align="left">
				<div class="cspNavBar">
					<ul id="navbar">
						<?php require_once('includes/nav_Support.php'); ?>
					</ul>
				</div>
				<div class="cbb">
					<?php
					if(isset($sysMsg)) {
						?>
						<div class="cspSysMsg">
							<?php if(isset($sysMsg)) { echo $sysMsg; } ?>
						</div>
						<?php
					}
					?>
					<div id="newContent">
						<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td class="cspBodyHeading">CSP Call Report Builder</td>
							</tr>
							<tr>
								<td>
									<form name="cspRprtParams" id="cspRprtParams" onSubmit="javascript:void(0);">
										<div>
											<span style="display:inline-block;">
												Report Type:<br />
												<select name="rptType" id="rptType" onChange="changeFrmEleState('cspRprtParams', this.value);">
							    				<option value="callStats">Call Statistics</option>
							    				<option value="callDetail">Call Detailed</option>
												</select>
											</span>
											<span style="display:inline-block;">
												Analysis Limit:<br />
												<input type="text" name="recLimit" id="recLimit" value="" size="2" />
											</span>
										</div>
										<div>
											<span style="display:inline-block;">
												Date From:<br>
												<input type="text" name="dateFrom" value="" SIZE="10" />
											</span>
											<span style="display:inline-block; vertical-align:bottom;">
												<A HREF="#" onClick="cal.select(document.forms['cspRprtParams'].dateFrom,'anchor1','yyyy-MM-dd'); return false;" NAME="anchor1" ID="anchor1"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
												<SCRIPT LANGUAGE="JavaScript" SRC="js/calendarpopup.js"></SCRIPT>
												<SCRIPT LANGUAGE="JavaScript">
													var cal = new CalendarPopup();
												</SCRIPT>
											</span>
											<span style="display:inline-block;">
												Date To:<br>
												<INPUT type="text" name="dateTo" value="" size="10" />
											</span>
											<span style="display:inline-block; vertical-align:bottom;">
												<A HREF="#" onClick="cal.select(document.forms['cspRprtParams'].dateTo,'anchor2','yyyy-MM-dd'); return false;" NAME="anchor2" ID="anchor2"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
												<SCRIPT LANGUAGE="JavaScript" SRC="js/calendarpopup.js"></SCRIPT>
												<SCRIPT LANGUAGE="JavaScript">
													var cal = new CalendarPopup();
												</SCRIPT>
											</span>
											<span style="display:inline-block;">
												Customer Number:<br>
												<input type="text" name="custID" value="" size="10" />
												<input type="button" value="Find" onClick="showList()" />
											</span>
										</div>
										<div>
											<span style="display:inline-block;">
												Call Taker:<br>
												<select name="hfEmployee" id="hfEmployee">
													<option value="ALL">ALL</option>
													<?php
													while($rowCallReport1 = mysql_fetch_array($rstCallReport1)) {
														$agent = $rowCallReport1['l_name'].', '.$rowCallReport1['f_name'];
														?>
														<option value="<?php echo $rowCallReport1['id']; ?>"><?php echo $agent; ?></option>
														<?php
													}
													?>
												</select>
											</span>
											<span style="display:inline-block;">
												Ticket Status:<br />
												<select name="ticketStatus" id="ticketStatus">
													<option value="ALL">ALL</option>
													<option value="0">Open</option>
													<option value="-1">Closed</option>
													<option value="1">Canceled</option>
												</select>
											</span>
											<span style="display:inline-block;">
												Call Type:<br />
												<select name="callType" id="callType">
							    				<option value="ALL">ALL</option>
													<option value="0">Office Hours Call Center</option>
													<option value="1">After Hours Call Center</option>
													<option value="2">Site Visit/Service Call</option>
													<option value="4">Site Visit/Training</option>
													<option value="3">Proactive Call</option>
												</select>
											</span>
										</div>
										<div>
											<span style="display:inline-block;">
												Service Plan Type:<br />
												<select name="spType" id="spType">
							    				<option value="ALL">ALL</option>
													<option value="1">No Plan</option>
													<option value="2">Time & Material</option>
													<option value="3">Bronze</option>
													<option value="4">Silver</option>
													<option value="5">Gold</option>
													<option value="6">Platinum</option>
													<option value="7">Credit Hold / No Service</option>
													<option value="8">Free Service</option>
												</select>
											</span>
											<span style="display:inline-block;">
												RMA Information:<br />
												<select name="incRMA" id="incRMA">
							    				<option value="ALL">ALL</option>
							    				<option value="Only">Only RMA</option>
													<option value="No">Exclude RMA</option>
												</select>
											</span>
											<span style="display:inline-block;">
												Issue Category:<br />
												<input type="text" name="issueCat" id="issueCat" value="" SIZE="4" />
												<input type="button" value="Find" onclick="showDiv('issueCatMod', '');" />
											</span>
										</div>
										<div>
											<span style="display:inline-block;">
												Keyword Search:<br />
												<input type="text" name="keyword" id="keyword" value="" size="47" />
											</span>
										</div>
										<?php include_once('includes/support/cspTicket_IssueCategories.php'); ?>
										<div>
											<input type="button" value="Build" onclick="buildRpt('cspRprtParams', '', '');" />
										</div>
									</form>
								</td>
							</tr>
						</table>
					</div>
					<div id="loadingScreen" style="display:none; text-align:center;"><img src="theme/default/images/loading.gif" /></div>
					<div id="rptDetails"></div>
				</div>
			</div>
			<div class="cspFooter">
				<?php require_once('cspFooter.php'); ?>
			</div>
		</div>
	</center>
</body>
</html>