<?php
include '../config.inc.php';
include '../db_connect.inc.php';
if(isset($_GET['by_name'])) {
	$f_name = $_GET['f_name'];
	$query = "SELECT CustomerNumber,FacilityName FROM tblFacilities WHERE FacilityName LIKE '%$f_name%' AND Active = -1 ORDER BY FacilityName";
	$result = mysql_query($query) or die ('Error retrieving Customer Name Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?php echo $companyName; ?> | CSP - Support</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="../../theme/default/cspDefault.css" />
	<link rel="icon" type="image/ico" href="favicon.ico" />
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	function pick(symbol) {
	  if (window.opener && !window.opener.closed)
	    window.opener.document.cspRprtParams.custID.value = symbol;
	  window.close();
	}
	// -->
	</SCRIPT>
</head>

<body>
	<TABLE>
	 	<TR>
			<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<td>
				<strong>Facility Name:</strong><br>
				<input name="f_name" type="text">
			</td>
			<td valign="bottom"><input name="by_name" type="submit" value="Lookup"></td>
			</form>
		</TR>
	</TABLE>
	<TABLE>
	<?php
	while($row = mysql_fetch_array($result)) {
		echo '<TR><TD><FONT FACE="Arial" SIZE="2">'.$row['FacilityName'].'</FONT><TD><A HREF="javascript:pick(\''.$row['CustomerNumber'].'\')"><FONT FACE="Arial" SIZE="2">Select</FONT></A></TD></TR>';
	}
	?>
	</TABLE>
</body>
</html>