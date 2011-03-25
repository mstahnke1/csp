<?php
$message="";
$sysMsg="";

if(isset($_GET['ticketSearch']))
{
	require_once 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	include 'includes/functions.inc.php';

$keyword = urldecode($_GET['keyword']);
$keyword = explode(" ", $keyword);
$keyword = implode(' +', $keyword);

if((isset($_GET['view']) && ($_GET['view'] == "export")))
{
	if($keyword != "")
	{
		$query2 = "SELECT tblTickets.*, tblTicketMessages.Message, MATCH(tblTickets.Summary, tblTicketMessages.Message) AGAINST('+$keyword' IN BOOLEAN MODE) AS RELEVANCE FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
	}
	else
	{
		$query2 = "SELECT tblTickets.*, tblTicketMessages.Message, tblTicketMessages.TicketID FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
	}
}else{
	if($keyword != "")
	{
		$query2 = "SELECT DISTINCT tblTickets.*, MATCH(tblTickets.Summary, tblTicketMessages.Message) AGAINST('+$keyword' IN BOOLEAN MODE) AS RELEVANCE FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
	}
	else
	{
		$query2 = "SELECT DISTINCT tblTickets.* FROM tblTickets LEFT JOIN tblTicketMessages ON tblTickets.ID = tblTicketMessages.TicketID ";
	}
}

foreach($_GET as $val){
  if($val != "ALL"){
    $query2 .= "WHERE ";
    break;
  }
}

$where = array();

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
	  $where[] = "((tblTickets.DateOpened >= '$dateFrom' AND tblTickets.DateOpened <= '$dateTo') OR (tblTicketMessages.Date >= '$dateFrom' AND tblTicketMessages.Date <= '$dateTo')) ";
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
	  $where[] = "((tblTickets.DateOpened >= '$dateFrom' AND tblTickets.DateOpened <= '$dateTo') OR (tblTicketMessages.Date >= '$dateFrom' AND tblTicketMessages.Date <= '$dateTo')) ";
	}
}

$hfEmployee = $_GET['hfEmployee'];
if($hfEmployee != "ALL"){
  $where[] = "(tblTickets.OpenedBy = '$hfEmployee' OR tblTicketMessages.EnteredBy = '$hfEmployee') ";
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
	if($status == -1 || $status == 1) {
 		$where[] = "Status = '$status' ";
 	} else {
 		$where[] = "Status NOT IN(-1, 1) ";
 	}
}

$keyword = $_GET['keyword'];
if($keyword != ""){
  $where[] = "MATCH(tblTickets.Summary, tblTicketMessages.Message) AGAINST('+$keyword' IN BOOLEAN MODE) HAVING RELEVANCE > 0.2 ";
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
	$query2 .= " ORDER BY RELEVANCE DESC, tblTickets.ID DESC LIMIT 50";
	//$query2 .= " ORDER BY RELEVANCE DESC LIMIT 50";
}
else
{
	$query2 .= " ORDER BY tblTickets.ID DESC";
}

$result2 = mysql_query($query2) or die(mysql_error());
$num = mysql_num_rows($result2);

if((isset($_GET['view']) && ($_GET['view'] == "export")))
{
	require_once 'Spreadsheet/Excel/Writer.php';
	
	// Creating a workbook
	$workbook = new Spreadsheet_Excel_Writer();
	
	// sending HTTP headers
	$workbook->send('csPortal_Report_'.date('Ymd').'T'.date('His').'.xls');
	
	// Creating a worksheet
	$worksheet =& $workbook->addWorksheet('Report Details');
	
	$x = 1;
	$y = 0;

	// The actual data
	$worksheet->write(0, 0, 'Ticket Number');
	$worksheet->write(0, 1, 'Status');
	$worksheet->write(0, 2, 'Created Tasks');
	$worksheet->write(0, 3, 'Sale Source');
	$worksheet->write(0, 4, 'Customer');
	$worksheet->write(0, 5, 'Corporate');
	$worksheet->write(0, 6, 'Contact');
	$worksheet->write(0, 7, 'Summary');
	$worksheet->write(0, 8, 'Date Opened');
	$worksheet->write(0, 9, 'Follow Up Date');
	$worksheet->write(0, 10, 'Technician Remark');
	
	while($row = mysql_fetch_array($result2)) {
		// connect to work db and get task information 
		mysql_select_db($dbname2);
		$query5 = "SELECT * FROM taskinfo WHERE ticketNum = '$row[ID]'";
		$result5 = mysql_query($query5, $conn);
		$taskList = "";
		$taskCount = mysql_num_rows($result5);
		mysql_select_db($dbname);
		$qryCustInfo = "SELECT tblFacilities.FacilityName,tblFacilities.TypeOfSale, tblCorpList.name FROM tblFacilities LEFT JOIN tblCorpList ON tblFacilities.corpID = tblCorpList.id WHERE CustomerNumber = '$row[CustomerNumber]'";
		$rstCustInfo = mysql_query($qryCustInfo);
		$rowCustInfo = mysql_fetch_array($rstCustInfo);
		$custName = $rowCustInfo['FacilityName'];
		$custCorp = $rowCustInfo['name'];
		if($taskCount > 0) {
			while($row5 = mysql_fetch_array($result5)) {
				$qryGetEmp = "SELECT f_name, l_name FROM employees WHERE id = '$row5[Response]'";
				$rstGetEmp = mysql_query($qryGetEmp);
				$rowGetEmp = mysql_fetch_array($rstGetEmp);
				$empName = $rowGetEmp['f_name'] . " " . $rowGetEmp['l_name'];
				$taskList .= $row5['ID'] . "(" . $empName . "), ";
			}
			$taskList = substr($taskList, 0, -2);
		}
		if($row['Status']==0) {
			$Status = 'OPEN';
		}elseif($row['Status']==1) {
			$Status = 'CANCELED';
		}elseif($row['Status']==2) {
			$Status = 'ESCALATED';
		}else{
			$Status = 'CLOSED';
		}
		if($rowCustInfo['TypeOfSale'] == 1) {
			$srcLead = "HomeFree";
		} elseif($rowCustInfo['TypeOfSale'] == 2) {
			$srcLead = "Direct Supply";
		} elseif($rowCustInfo['TypeOfSale'] == 3) {
			$srcLead = "Simplex";
		} else {
			$srcLead = "Unknown";
		}
		
	
		$worksheet->write($x, 0, $row['ID']);
		$worksheet->writeString($x, 1, $Status);
		$worksheet->writeString($x, 2, $taskList);
		$worksheet->writeString($x, 3, $srcLead);
		$worksheet->writeString($x, 4, $custName." (".$row['CustomerNumber'].")");
		$worksheet->writeString($x, 5, $custCorp);
		$worksheet->writeString($x, 6, $row['Contact']);
		$worksheet->writeString($x, 7, $row['Summary']);
		$worksheet->writeString($x, 8, $row['DateOpened']);
		$worksheet->writeString($x, 9, $row['DateFollowUp']);
		$worksheet->writeString($x, 10, $row['Message']);
		$x++;
	}
	
	
	// Let's send the file
	$workbook->close();
	
	include 'includes/db_close.inc.php';
	
	exit();
}

}

if((isset($_GET['view']) && ($_GET['view'] == "print")))
{
?>
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
}
	
if($num == 0)
{
?>
	<table border="0" width="100%">
		<tr>
			<td align="center">
				<font size="2" face="Arial"><b>Your search did not return any matching tickets.</b>
			</td>
		</tr>
	</table>
<?php
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
	if(!(isset($_GET['view']) && ($_GET['view'] == "print")))
	{
	?>
	<tr>
		<td align="center">
			<a href="javascript:void(0)" onclick="window.open('<?php echo 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>&view=print','system','width=600,height=750,scrollbars=yes')"><font size="2" face="Arial">[Print]</font></a>
			<a href="javascript:void(0)" onclick="window.open('<?php echo 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>&view=export','_self','')"><font size="2" face="Arial">[Export]</font></a>
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
</table>

<?php
while($row2 = mysql_fetch_array($result2))
{
	$fID = $row2['CustomerNumber'];
	$query3 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$fID'";
	$result3 = mysql_query($query3) or die(mysql_error());
	$row3 = mysql_fetch_array($result3);
	
	if($row2['Status']==0) {
		$Status = 'OPEN';
	}elseif($row2['Status']==1) {
		$Status = 'CANCELED';
	}elseif($row2['Status']==2) {
		$Status = 'ESCALATED';
	}else{
		$Status = 'CLOSED';
	}
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" align="left">
				<font size="2" face="Arial"><b>Ticket Number: <a href="csPortal_Tickets.php?ticket_num=<?php echo $row2['ID']; ?>&by_ticket=ticket" target="blank"><?php echo $row2['ID']; ?></a></b></font>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100" align="left">
				<font size="2" face="Arial">Facility:</font>
			</td>
			<td align="left">
				<font size="2" face="Arial"><?php echo $row3['FacilityName']; ?></font>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100" align="left">
				<font size="2" face="Arial">Date Opened:
			</td>
			<td align="left">
				<font size="2" face="Arial"><?php echo $row2['DateOpened']; ?></font>
			</td>
		</tr>
		<?php
		if($row2['Status'] == -1)
		{
		?>
		<tr>
			<td valign="top" width="100" align="left">
				<font size="2" face="Arial">Duration:</font>
			</td>
			<td align="left">
				<font size="2" face="Arial"><?php echo dateDiff($row2['DateOpened'],$row2['DateClosed']); ?></font>
			</td>
		</tr>
		<?php
		}
		$query23 = "SELECT f_name, l_name FROM employees WHERE id = '$row2[OpenedBy]'";
    $result23 = mysql_query($query23);
    $row23 = mysql_fetch_array($result23);
    $empName23 = $row23['l_name'] . ", " . $row23['f_name'];
		?>
		<tr>
			<td valign="top" width="100" align="left">
				<font size="2" face="Arial">Opened By:</font>
			</td>
			<td align="left">
				<font size="2" face="Arial"><?php echo $empName23; ?></font>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100" align="left">
				<font size="2" face="Arial">Trouble Desc.:</font>
			</td>
			<td align="left">
				<font size="2" face="Arial"><?php echo $row2['Summary']; ?></font>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100" align="left">
				<font size="2" face="Arial">Status:</font>
			</td>
			<td align="left">
				<font size="2" face="Arial"><?php echo $Status; ?></font>
			</td>
		</tr>
		<?php
		/*
		if($keyword != "")
		{
		?>
		<tr>
			<td valign="top" width="100">
				<font size="2" face="Arial">Relevance:</font>
			</td>
			<td>
				<font size="2" face="Arial"><?php echo $row2['RELEVANCE']; ?></font>
			</td>
		</tr>
		<?php
		}
		*/
		if(!(isset($_GET['view']) && ($_GET['view'] == "print")))
		{
		?>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<?php
		}
		?>
	</table>
	<?php
	if((isset($_GET['view']) && ($_GET['view'] == "print")))
	{
		$query4 = "SELECT * FROM tblticketmessages  WHERE TicketID = '$row2[ID]' ORDER BY Date";
		$result4 = mysql_query($query4);
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
			while($row4 = mysql_fetch_array($result4))
			{
				$query24 = "SELECT f_name, l_name FROM employees WHERE id = '$row4[EnteredBy]'";
				$result24 = mysql_query($query24);
				$row24 = mysql_fetch_array($result24);
				$empName24 = $row24['l_name'] . ", " . $row24['f_name'];
			?>
				<tr valign="top">
					<td width="100">
						<font size="2" face="Arial">Rep. Comment:</b></font>
					</td>
					<td>
						<font size="2" face="Arial"><?php echo $row4['Message']; ?></font>
					</td>
				</tr>
				<tr>
					<td width="100">
						&nbsp;
					</td>
					<td>
						<font size="2" face="Arial"><?php echo $empName24; ?></font>
					</td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td>
					&nbsp;
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