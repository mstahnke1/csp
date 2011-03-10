<?php
$message="";
$sysMsg="";

//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

//$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
//$url = urlencode(!empty($query) ? " $host$self?$query" : " $host$self");
$url = urlencode(!empty($query) ? " $self?$query" : " $self");

if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	mysql_query($queryLog);
	include 'includes/db_close.inc.php';
	die(header("Location: csPortal_Login.php?url=" . $url));
}
else
{
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
	include 'includes/config.inc.php';
	include 'includes/functions.inc.php';
	include 'includes/db_connect.inc.php';
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	$mail = $_SESSION['mail'];
	
	if(isset($_GET['msgID']))
	{
		$sysMsg = $portalMsg[$_GET['msgID']][$lang];
	}
	
	# Quantity Personal Days
	$totPer = '2';
	
	# Retrieve employee vacation day amount
	$query1 = "SELECT vacDays FROM employees WHERE id = '$_SESSION[uid]'";
	$result1 = mysql_query($query1);
	$row1 = mysql_fetch_assoc($result1);
	$totVac = $row1['vacDays'] - $totPer;
	
}
?>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan="2">
			This is the vacation information for <?php echo $name; ?>
		</td>
	</tr>
	<tr>
		<td width="140">
			Total Vaction Days:
		</td>
		<td>
			<?php echo $totVac; ?>
		</td>
	</tr>
	<tr>
		<td width="140">
			Total Personal Days:
		</td>
		<td>
			<?php echo $totPer; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<INPUT TYPE="button" NAME="opn_VacForm" id="opn_VacForm" VALUE="Request" onclick="javascript:change('vac_request', '');" /> 
		</td>
	</tr>
</table>
     