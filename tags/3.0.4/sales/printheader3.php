<?php
$message="";
$date = date('Y-m-d H:i:s');
session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
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

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Training Evaluation</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
</head>

<table cellspacing="0" cellpadding="0" border="0" width="759" align="left">
	<tr>
		<td rowspan="4" valign="bottom" align="left" style="padding-bottom:1px;">
			<a href="index.php"><img src="../images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a>
		</td>
	</tr>
</table>	
<?php
include 'includes/db_close.inc.php';
?>
				
					