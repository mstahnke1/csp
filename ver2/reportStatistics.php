<?php
$message="";
$sysMsg="";

if(isset($_GET['ticketSearch']))
{
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	include 'includes/functions.inc.php';

$keyword = $_GET['keyword'];

if($keyword != "")
{
	$query2 = "SELECT *, MATCH (tblTickets.Summary, tblTicketMessages.Message) AGAINST('$keyword') AS RELEVANCE FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
}
else
{
	$query2 = "SELECT *, Count(CustomerNumber) AS custCount, Count(tblTickets.id) AS ticketCount FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
	$query6 = "SELECT tblTickets.id, tblTicketMessages.id FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
}

if($keyword != "")
{
	$query3 = "SELECT *, MATCH (tblTickets.Summary, tblTicketMessages.Message) AGAINST('$keyword') AS RELEVANCE FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
}
else
{
	$query3 = "SELECT *, Count(CustomerNumber) AS custCount, Count(tblTickets.id) AS ticketCount FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
	$query7 = "SELECT tblTickets.id, tblTicketMessages.id FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
}

foreach($_GET as $val){
  if($val != "ALL"){
    $query2 .= "WHERE Type != 1 AND Status <> 1 AND ";
    break;
  }
}

if($keyword == "")
{
	foreach($_GET as $val){
	  if($val != "ALL"){
	    $query6 .= "WHERE Type != 1 AND Status <> 1 AND ";
	    break;
	  }
	}
}

foreach($_GET as $val){
  if($val != "ALL"){
    $query3 .= "WHERE Type = 1 AND Status <> 1 AND ";
    break;
  }
}

if($keyword == "")
{
	foreach($_GET as $val){
	  if($val != "ALL"){
	    $query7 .= "WHERE Type = 1 AND Status <> 1 AND ";
	    break;
	  }
	}
}

$where = array();

$hfEmployee = $_GET['hfEmployee'];
if($hfEmployee != "ALL"){
  //$where[] = "(tblTickets.OpenedBy = '$hfEmployee' OR tblTicketMessages.EnteredBy = '$hfEmployee') ";
  $where[] = "tblTicketMessages.EnteredBy = '$hfEmployee' ";
}

$ticketType = $_GET['ticketType'];
if($ticketType != "ALL"){
  $where[] = "Type = '$ticketType' ";
}

$custNum = $_GET['custNum'];
$company = $_GET['company'];
if($custNum != ""){
  $where[] = "CustomerNumber = '$custNum' ";
}elseif($company != "ALL"){
	$where[] = "CustomerNumber IN(SELECT CustomerNumber FROM tblfacilities WHERE refCompany = '$company') ";
}

$incRMA = $_GET['incRMA'];
if($incRMA != "ALL"){
  $where[] = "rmaReturn = '0' ";
}

$status = $_GET['status'];
if($status != "ALL"){
	if($status == -1) {
 		$where[] = "Status = '$status' ";
 	} else {
 		$where[] = "Status >= '$status' ";
 	}
}

$keyword = $_GET['keyword'];
if($keyword != ""){
  $where[] = "MATCH (tblTickets.Summary) AGAINST('+$keyword' IN BOOLEAN MODE) HAVING RELEVANCE > 0.2 ";
}

if($_GET['status'] != 0)
{
	if($_GET['dateTo'] == "")
	{
		$dateTo = date('Y-m-d');
	}
	else
	{
		$dateTo = $_GET['dateTo'];
	}
	$dateFrom = $_GET['dateFrom'];
	$dateFromUnix = strtotime($dateFrom);
	$dateToUnix = strtotime('+1 day',strtotime($dateTo));
	if(($dateFrom != "") && ($dateTo != "")){
		$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
	  //$where[] = "((tblTickets.DateOpened >= '$dateFrom' AND tblTickets.DateOpened <= '$dateTo') OR (tblTicketMessages.Date >= '$dateFrom' AND tblTicketMessages.Date <= '$dateTo')) ";
	  $where[] = "tblTicketMessages.Date >= '$dateFrom' AND tblTicketMessages.Date <= '$dateTo' ";
	}
}
else
{
	if($_GET['dateTo'] == "")
	{
		$dateTo = date('Y-m-d');
	}
	else
	{
		$dateTo = $_GET['dateTo'];
	}
	$dateFrom = $_GET['dateFrom'];
	$dateFromUnix = strtotime($dateFrom);
	$dateToUnix = strtotime('+1 day',strtotime($dateTo));
	if(($dateFrom != "") && ($dateTo != "")){
		$dateTo = date('Y-m-d', strtotime('+1 day',strtotime($dateTo)));
	  //$where[] = "((tblTickets.DateOpened >= '$dateFrom' AND tblTickets.DateOpened <= '$dateTo') OR (tblTicketMessages.Date >= '$dateFrom' AND tblTicketMessages.Date <= '$dateTo')) ";
	  $where[] = "tblTicketMessages.Date >= '$dateFrom' AND tblTicketMessages.Date <= '$dateTo' ";
	}
}

if(!empty($where)){
  $query2 .= implode(" AND ", $where);
}
else
{
	$query2 = substr($query2, 0, -6);
}

if($keyword != "")
{
	$query2 .= " ORDER BY RELEVANCE DESC";
}
else
{
	$query2 .= " GROUP BY CustomerNumber ORDER BY custCount DESC";
}

if(!empty($where)){
  $query3 .= implode(" AND ", $where);
}
else
{
	$query3 = substr($query3, 0, -6);
}

if($keyword != "")
{
	$query3 .= " ORDER BY RELEVANCE DESC";
}
else
{
	$query3 .= " GROUP BY CustomerNumber ORDER BY custCount DESC";
}

if($keyword == "")
{
	if(!empty($where)){
	  $query6 .= implode(" AND ", $where);
	}
	else
	{
		$query6 = substr($query6, 0, -6);
	}
	
	if($keyword != "")
	{
		$query6 .= " ORDER BY RELEVANCE DESC";
	}
	else
	{
		$query6 .= " ORDER BY tblTickets.id DESC";
	}


	if(!empty($where)){
	  $query7 .= implode(" AND ", $where);
	}
	else
	{
		$query7 = substr($query7, 0, -6);
	}
	
	if($keyword != "")
	{
		$query7 .= " ORDER BY RELEVANCE DESC";
	}
	else
	{
		$query7 .= " ORDER BY tblTickets.id DESC";
	}
}

if($keyword != "")
{
	$num = 0;
} else {
$result2 = mysql_query($query2) or die('Query 2: '.mysql_error());

$result6 = mysql_query($query6) or die('Query 6: '.mysql_error());
$num6 = mysql_num_rows($result6);
//$row6 = mysql_fetch_array($result6);
//echo "Query 6: ".$query6."<br />";

$result3 = mysql_query($query3) or die('Query 3: '.mysql_error());
//echo "Query 3: ".$query3."<br />";

$result7 = mysql_query($query7) or die('Query 7: '.mysql_error());
$num7 = mysql_num_rows($result7);
//echo "Query 7: ".$query7."<br />";

$num = $num6 + $num7;
}

}
?>
<?php
if((isset($_GET['view']) && ($_GET['view'] == "print")))
{
?>
<link rel="stylesheet" type="text/css" href="csPortal_Layout.css" />
<table align="center" width="650" border="0" bgcolor="#FFFFFF">
<?php
}
else
{
?>
<table align="center" width="740" border="0" bgcolor="#FFFFFF">
<?php
}
?>
	<tr valign="top">
		<?php
  	/************************** COLUMN LEFT START *************************/
  	if((isset($_GET['view']) && ($_GET['view'] == "print")))
		{
		?>
			<td width="100%">
		<?php
		}
		else
		{
		?>
			<td width="550">
		<?php
		}
		?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  	<td><b><i><font face="Arial" size="2" color="Red"><?php echo $sysMsg; ?></font></b></i></td>
  </tr>
 <tr>
 <td>
 	
<?php
if(isset($_GET['ticketSearch']))
{
	$dif = $dateToUnix - $dateFromUnix;
	$days = floor($dif / 86400);
	if($days > 0)
	{
	$aveTickets = $num / $days;
	}
if($num > 0)
{
?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<?php
		if(!(isset($_GET['view']) && ($_GET['view'] == "print")))
		{
		?>
		<tr>
			<td align="center">
				<a href="javascript:void(0)"onclick="window.open('<?php echo 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>&view=print','system','width=600,height=750,scrollbars=yes')"><font size="2" face="Arial">Print Results</font></a>
			</td>
		</tr>
		<?php
		}
		else
		{
		?>
		<script language="Javascript1.2">
		<!--
		window.print();
		//-->
		</script>
		<?php
		}
		?>
		<tr>
			<td align="center">
				<font size="2" face="Arial"><b>- Your search has returned <?php echo $num; ?> matching tickets -</b></font>
			</td>
		</tr>
		<?php
		// if no Start date is entered you cannot get a ticket count over specified days. For this reason no ticket counts are shown.
		if($dateFrom != "")
		{
		?>
		<tr>
			<td align="center">
				<font size="2" face="Arial"><b>- You have selected to view tickets over <?php echo $days; ?> days -</b></font>
			</td>
		</tr>
		<?php
		}
		
		//if the status is ALL(this removes averate ticket printout when queries are for closed or opened tickets) and no date From is selected do not print an average ticket count. Can't take an average if you don't have a start date.
		if($_GET['status'] == "ALL" AND $dateFrom != "" AND $_GET['custNum'] == "")
		{
		?>
		<tr>
			<td align="center">
				<font size="2" face="Arial"><b>- The average opened tickets per day are <?php echo $aveTickets; ?> -</b></font>
			</td>
		</tr>
		<?php
		}
		?>
	</table>
	<p>
	<table border="1" width="100%" cellspacing="1" cellpadding="0">
		<tr>
			<td width="50%" align="center" valign="top">
				<table class="ticketStats" border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="statHeading">
							<b>Office Hour Stats</b><br />
							<font size="2"><?php echo $num6; ?> Total Calls</font>
						</td>
					</tr>
					<?php
					while($row2 = mysql_fetch_array($result2))
					{
						$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$row2[CustomerNumber]'";
						$result4 = mysql_query($query4);
						$row4 = mysql_fetch_assoc($result4);
						?>
						<tr>
							<td class="statData">
								<?php echo $row2['CustomerNumber'].' '.$row4['FacilityName'].' <i>('.$row2['custCount'].')</i>'; ?>
							</td>
						</tr>
					<?php
					}
					?>
				</table>
			</td>
			<td width="50%" align="center" valign="top">
				<table class="ticketStats" border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="statHeading">
							<b>After Hour Stats</b> <br />
							<font size="2"><?php echo $num7; ?> Total Calls</font>
						</td>
					</tr>
					<?php
					while($row3 = mysql_fetch_array($result3))
					{
						$query4 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$row3[CustomerNumber]'";
						$result4 = mysql_query($query4);
						$row4 = mysql_fetch_assoc($result4);
					?>
					<tr>
						<td class="statData">
							<?php echo $row3['CustomerNumber'].' '.$row4['FacilityName'].' <i>('.$row3['custCount'].')</i>'; ?>
						</td>
					</tr>
					<?php
					}
					?>
				</table>
			</td>
		</tr>
	</table>
	</p>
<?php
}
else
{
?>
	<table border="0" width="100%">
		<tr>
			<td align="center">
				<?php
				if($keyword == "")
				{
				?>
					<font size="2" face="Arial"><b>Your search did not return any matching tickets.</b></font>
				<?php
				} else {
				?>
					<p><font size="2" face="Arial"><b>Please use the details button to view keyword results.</b></font></p>
				<?php
				}
				?>
			</td>
		</tr>
	</table>
<?php
}
}

if(isset($_GET['by_name']))
{
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	$f_name = $_GET['f_name'];
	$query = "SELECT CustomerNumber,FacilityName FROM tblFacilities WHERE FacilityName LIKE '%$f_name%' AND Active = -1 ORDER BY FacilityName";
	$result = mysql_query($query) or die ('Error retrieving Customer Name Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
?>
	<TABLE>
<?php
		while($row = mysql_fetch_array($result))
		{
			echo '<TR><TD><FONT FACE="Arial" SIZE="2">'.$row['FacilityName'].'</FONT><TD><A HREF="javascript:pick(\''.$row['CustomerNumber'].'\')"><FONT FACE="Arial" SIZE="2">Select</FONT></A></TD></TR>';
		}
?>
	</TABLE>
	
<?php
	include 'includes/db_close.inc.php';
}
?>

</td>
</tr>
</table>

  	</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
		?>
  </tr>
</table>