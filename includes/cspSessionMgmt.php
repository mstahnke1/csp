<?php
//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

if(file_exists('includes/functions.inc.php')) {
	include_once('includes/functions.inc.php');
	include_once('includes/config.inc.php');
	include_once('includes/db_connect.inc.php');
} elseif(file_exists('../includes/functions.inc.php')) {
	include_once('../includes/functions.inc.php');
	include_once('../includes/config.inc.php');
	include_once('../includes/db_connect.inc.php');
}

$alertSessionInfo1 = "FALSE";
$qrySessionInfo1 = "SELECT ticket FROM activeCallList WHERE agent = '$_SESSION[uid]'";
$resSessionInfo1 = mysql_query($qrySessionInfo1) or die(mysql_error());
while($rowSessionInfo1 = mysql_fetch_assoc($resSessionInfo1)) {
	if(isset($_GET['ticketID']) && $_GET['ticketID'] == $rowSessionInfo1['ticket']) {
		$alertSessionInfo1 = "FALSE";
		break;
	} else {
		$alertSessionInfo1 = "TRUE";
	}
}

$companyName = cspSettingValue('12');
$lang = cspSettingValue('5');

//$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
//$url = urlencode(!empty($query) ? " $host$self?$query" : " $host$self");
$url = urlencode(!empty($query) ? " $self?$query" : " $self");

if(!isset($_SESSION['uid'])) {
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	include_once 'includes/config.inc.php';
	include_once 'includes/db_connect.inc.php';
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	include 'includes/db_close.inc.php';
	die(header("Location: ./csp_UserLogin.php?url=" . $url));
}

if(isset($_GET['msgID'])) {
	$sysMsg = $portalMsg[$_GET['msgID']][$lang];
}

if(isset($_GET['sysMsg'])) {
	$sysMsg = $_GET['sysMsg'];
}
//include_once('../includes/db_close.inc.php');
?>