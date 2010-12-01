<?php
include 'printheader.php';
?>
<link rel="stylesheet" type="text/css" href="task.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>Customer Search</title>
<?php
if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	die(header("Location: csPortal_Login.php"));
}else
{
	$name = $_SESSION['displayname'];
	$message="Hello $name!";
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
}
$access = $_SESSION['access'];
$conn11 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db('homefree');
$uid = $_SESSION['uid'];
$email = $_SESSION['mail'];
$query1 = "SELECT id, f_name, l_name, dept FROM employees WHERE email = '$email'";
$result1 = mysql_query($query1) or die (mysql_error());
$row1 = mysql_fetch_array($result1);
$employeeid = $row1['id'];      
$firstname = $row1['f_name'];
$lastname = $row1['l_name'];
$department = $row1['dept'];
mysql_close($conn11);	
$date = date('Y-m-d H:i:s');
$displaydate = date('m-d-Y');
$now = strtotime("now");
$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$tomorrowplus  = mktime (date("H"), date("i")+15, 0, date("m")  , date("d")+1, date("Y"));
$status = 0;
include 'includes/configtask.php';
include 'includes/opendbtask.php';
require 'includes/functions.inc.php';
if((isset($_GET['fr'])) && ($_GET['fr'] == 'rma'))
{
?>
<Script>
function pick(custnum) {
  if (window.opener && !window.opener.closed)
    window.opener.document.searchParams.custNum.value = custnum;
  window.close();
}
</Script>
	<form method="GET" NAME="searchParams" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td>
					Facility Name:
				</td>
				<td>
					<input type="text" size="30" maxlength="30" name="custNum" value="">
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Search" name="search">
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="fr" value = "rma">';
			if(isset($_GET['search']))
			{
				$f_name = $_GET['custNum'];
				mysql_select_db('homefree');
				$query = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE FacilityName like '%$f_name%' ORDER BY FacilityName";
				$result = mysql_query($query) or die (mysql_error());
				while($row = mysql_fetch_array($result))
				{
?>
					<tr>
						<td class="body">
<?php			
							echo $row['FacilityName'];
?>
						</td>
						<td>
							<?php echo '<A HREF="javascript:pick(\''.$row['CustomerNumber'].'\')">'. 'SELECT'; ?>
						</td>
					</tr>
<?php			
				}	
			}
?>
		</table>
	</form>
<?php
}
if((isset($_GET['fr'])) && ($_GET['fr'] == 'rmareport'))
{
?>
<Script>
function pick(custnum2) {
  if (window.opener && !window.opener.closed)
    window.opener.document.searchParams.custNum.value = custnum;
  window.close();
}
</Script>
	<form method="GET" NAME="searchParams" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td>
					Facility Name:
				</td>
				<td>
					<input type="text" size="30" maxlength="30" name="custNum" value="">
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Search" name="search">
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="fr" value = "rma">';
			if(isset($_GET['search']))
			{
				$f_name = $_GET['custNum'];
				mysql_select_db('homefree');
				$query = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE FacilityName like '%$f_name%' ORDER BY FacilityName";
				$result = mysql_query($query) or die (mysql_error());
				while($row = mysql_fetch_array($result))
				{
?>
					<tr>
						<td class="body">
<?php			
							echo $row['FacilityName'];
?>
						</td>
						<td>
							<?php echo '<A HREF="javascript:pick(\''.$row['CustomerNumber'].'\')">'. 'SELECT'; ?>
						</td>
					</tr>
<?php			
				}	
			}
?>
		</table>
	</form>
<?php
}
if((isset($_GET['fr'])) && ($_GET['fr'] == 'openissue'))
{
?>
<Script>
function pick(custnum3) {
  if (window.opener && !window.opener.closed)
    window.opener.document.searchParams.custNum.value = custnum;
  window.close();
}
</Script>
	<form method="GET" NAME="searchParams" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td>
					Facility Name:
				</td>
				<td>
					<input type="text" size="30" maxlength="30" name="custNum" value="">
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Search" name="search">
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="fr" value = "rma">';
			if(isset($_GET['search']))
			{
				$f_name = $_GET['custNum'];
				mysql_select_db('homefree');
				$query = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE FacilityName like '%$f_name%' ORDER BY FacilityName";
				$result = mysql_query($query) or die (mysql_error());
				while($row = mysql_fetch_array($result))
				{
?>
					<tr>
						<td class="body">
<?php			
							echo $row['FacilityName'];
?>
						</td>
						<td>
							<?php echo '<A HREF="javascript:pick(\''.$row['CustomerNumber'].'\')">'. 'SELECT'; ?>
						</td>
					</tr>
<?php			
				}	
			}
?>
		</table>
	</form>
<?php
}
if((isset($_GET['fr'])) && ($_GET['fr'] == 'editsn'))
{
?>	
<Script>
function pick(sn) {
  if (window.opener && !window.opener.closed)
    window.opener.document.editsn.newsn.value = sn;
  window.close();
}
</Script>
<form method="GET" NAME="editsn" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
	//$serial = $_GET['sn'];
?>
	<table>
		<tr>
			<td>
				New Serial Number:
			</td>
			<td>
				<input type="text" size="10" maxlength="10" name="sn" value="">
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="Change" name="change">
			</td>
		</tr>
<?php
	echo	'<input type = "hidden" name="fr" value = "editsn">';
	if(isset($_GET['change']))
	{
?>
		<tr>
			<td>
<?php		
				$sn = $_GET['sn'];
	 			echo $sn. '<A HREF="javascript:pick(\''.$sn.'\')">'. 'SELECT';
?>
			</td>
		</tr>
<?php			 			
	}
?>
	</table>
</form>
<?php
}
?>		