<?php
$message="";
$date = date('Y-m-d H:i:s');
$displaydate = date('M j, Y');
session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	die(header("Location: /csPortal/csPortal_Login.php"));
}
else
{
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
	$name = $_SESSION['displayname'];
	$message="Hello $name!";
}
$f_id = $_GET["f_id"];
mysql_select_db($dbname2);
$query = "SELECT * From tblfacilitygeneralinfo WHERE ID='$f_id'";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result);	
$sman = $row['Salesman'];
$uid = $_SESSION['uid'];
$conn7 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db('homefree');
$query8 = "SELECT id, f_name, l_name,email FROM employees WHERE id = '$sman' ORDER BY l_name";
$result8 = mysql_query($query8) or die (mysql_error());
$row8 = mysql_fetch_array($result8);		
$salesman = $row8['f_name']. ' ' . $row8['l_name'];  
$mail = $row8['email'];
mysql_select_db($dbname2);
$query9 = "SELECT startdate,days FROM tbltotalequipment WHERE FacilityID='$f_id'";
$result9 = mysql_query($query9) or die (mysql_error());
$row9 = mysql_fetch_array($result9);
$startdate = $row9['startdate'];
$duration = $row9['days'];
$endDate = date('m-d-Y', strtotime("+".$duration." days", strtotime($startdate)));
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Scope Of Work</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
</head>

<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="400" align="left">
				<tr>
					<td rowspan="4" valign="bottom" align="center" style="padding-bottom:1px;">
						<a href="index.php"><img src="../images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
								<table cellspacing="0" cellpadding="0" border="0" width="350" align="right">
<?php				
									if(!isset($_GET['view_amendment']))
									{
?>													
										<tr>
									  	<td align="right">
												Quote Expires: <?php echo $endDate; ?>
	  									</td>
	  								</tr>
<?php
									}
?>																
  								<tr>
  									<td align="right">
  										<?php echo $displaydate; ?>
  									</td>
  								</tr>
  							</td>
  						</tr>
						</table>
				</table>
			</table>	
<?php
include 'includes/db_close.inc.php';
?>
				
					