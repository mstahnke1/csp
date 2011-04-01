<?php
$message="";
$sysMsg="";

//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

if(isset($_GET['url']))
{
	$url = $_GET['url'];
}

if(isset($_POST['url']))
{
	$url = $_POST['url'];
}

include 'includes/config.inc.php';
include 'includes/db_connect.inc.php';
include 'includes/functions.inc.php';

if(isset($_GET['msgID']))
{
	$sysMsg = $portalMsg[$_GET['msgID']][$lang];
}

// checking to see if logout action has been sent
if((isset($_SESSION['username'])) && (isset($_GET['action'])) && ($_GET['action']=="logout"))
{
	// if logout action has been sent then insert user, browser info, date and time user logging out
	$user = $_SESSION['username'];
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$query3 = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', 'User Logout', '$agent', CURDATE(), CURTIME())";
  mysql_query($query3) or die(mysql_error());
  // remove all session information
	session_destroy();
	die(header("Location: csPortal_Login.php?msgID=2"));
}

// check for an active session
if(!isset($_SESSION['username'])) 
{
	// check to see if login form info has been submitted
	if(isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['pass']) && $_POST['pass'] != "") 
	{
		// LDAP variables
		$ldap['user'] = $_POST['user'];
		$ldap['pass'] = $_POST['pass'];
		$ldap['base'] = '';

		// if connection to ldap server is successful
		$ldap['conn'] = ldap_connect($ldap['host'],$ldap['port']);

		// if connection to ldap server is successful
		if($ldap['conn'])
		{

			//Set protocol version
			ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3)
					or die ("Could not set ldap protocol");

			// Set this option for AD on Windows Server 2003 per PHP manual
			ldap_set_option($ldap['conn'], LDAP_OPT_REFERRALS, 0)
					or die ("Could not set option referrals");

			// check login credentials against active directory
			//$ldap['bind'] = ldap_bind($ldap['conn'],$ldap['user'].$ldap['bind_dn'],$ldap['pass'])
			//	or die(ldap_error($ldap['conn']));
			
			$ldap['bind'] = ldap_bind($ldap['conn'],$ldap['user'].$ldap['bind_dn'],$ldap['pass']);
			
			// if login credentials have been verified and okay
			if($ldap['bind'])
			{
				// search for the user on the ldap server and return requested user information
				$ldap['result'] = ldap_search($ldap['conn'], $ldap['dn'], 'samaccountname='.$ldap['user'], $ldap['attributes']);
					
				// if active directory search was successful
				if($ldap['result'])
				{
    			// retrieve all the entries from the search result
    			$ldap['info'] = ldap_get_entries( $ldap['conn'], $ldap['result'] );
				}
				else
				{
					$user = $_SESSION['username'];
					$agent = $_SERVER['HTTP_USER_AGENT'];
					$statement = 'Login Error: ' . ldap_error($ldap['conn']);
					$queryLog = "INSERT INTO activity_logs (user, statement, action, agent, date, time) VALUES ('$user', '$statement', '1', '$agent', CURDATE(), CURTIME())";
					mysql_query($queryLog) or die(mysql_error());
					include 'includes/db_close.inc.php';
    			exit;
				}

				if($ldap['info']) {
    			// Add the user’s display name and email address to the session
    			$f_name = $ldap['info'][0]['givenname'][0];
    			$l_name = $ldap['info'][0]['sn'][0];
    			$email = $ldap['info'][0]['mail'][0];
    			$_SESSION['username'] = $ldap['info'][0]['samaccountname'][0];
    			$_SESSION['mail'] = $ldap['info'][0]['mail'][0];
    			$_SESSION['displayname'] = $ldap['info'][0]['displayname'][0];
    			$user = $_SESSION['username'];
    				
    			// Retrieve access level and user id
					$query = "SELECT id, access FROM employees WHERE email = '$email'";
					$result = mysql_query($query) or die(mysql_error());
					if(mysql_num_rows($result)>0)
					{
						$row = mysql_fetch_array($result);
						// Add access level to the session
    				$_SESSION['access'] = $row['access'];
    				$_SESSION['uid'] = $row['id'];
    			}
    			else
    			{
    				$query3 = "INSERT INTO employees (f_name, l_name, ext_num, mobile, email, access) VALUES ('$f_name', '$l_name', '', '', '$email', '5')";
    				mysql_query($query3) or die(mysql_error());
    				$_SESSION['access'] = 5;
    			}
    			$agent = $_SERVER['HTTP_USER_AGENT'];
    			// Insert login logging information into the database
    			$query2 = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', 'User Login', '$agent', CURDATE(), CURTIME())";
    			mysql_query($query2);
    				
   				// after authentication has completed check for open tickets 
   				// if tickets are open notify user else direct to csPortal_Main
    			$queryName = $l_name.', '.$f_name;
    			$query3 = "SELECT id FROM tbltickets WHERE OpenedBy = '$row[id]' && Status NOT IN(-1, 1)";
					$result3 = mysql_query($query3);
					$num3 = mysql_num_rows($result3);
					include 'includes/db_close.inc.php';
					if($num3 > 0)
					{
						if(isset($url)) {
						?>
							<script type="text/javascript">
							<!--
							window.alert("<?php echo "You have " . $num3 . " opened ticket(s) that needs to be reviewed."; ?>");
							window.location = "<?php echo $url; ?>";
							//-->
							</script>
						<?php
						}
						else
						{
    				?>
    					<script type="text/javascript">
							<!--
							window.alert("<?php echo "You have " . $num3 . " opened ticket(s) that needs to be reviewed."; ?>");
							window.location = "csPortal_Main.php";
							//-->
							</script>
						<?php
						}
					}
					else
					{
    				if(isset($url)) {
						?>
							<script type="text/javascript">
							<!--
							window.location = "<?php echo $url; ?>";
							//-->
							</script>
						<?php
						}
						else
						{
    				?>
    					<script type="text/javascript">
							<!--
							window.location = "csPortal_Main.php";
							//-->
							</script>
						<?php
						}
    			}
				}
				else
				{
    			$sysMsg = ldap_error($ldap['conn']);
				}

			// close connection to ldap server
			ldap_close($ldap['conn']);
			}
			else
			{
				$sysMsg = ldap_error($ldap['conn']);
				$user = $_POST['user'];
				$agent = $_SERVER['HTTP_USER_AGENT'];
				$statement = stripslashes(fix_apos("'", "''", 'Login Error: '.ldap_error($ldap['conn'])));
				$queryLog = "INSERT INTO activity_logs (user, statement, action, agent, date, time) VALUES ('$user', '$statement', '1', '$agent', CURDATE(), CURTIME())";
				mysql_query($queryLog) or die(mysql_error());
				include 'includes/db_close.inc.php';
			}
		}
		else
		{
			$sysMsg = $portalMsg[3][$lang];
		}
	}
}
else
{
 	die(header("Location: csPortal_Main.php"));
}

$postal_code = 53218;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Login</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
</head>

<body  onLoad="focus();loginForm.user.focus()">
	
<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="600" align="left">
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;">
					<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center" style="padding:0 0 6px 0; height:32px;">
									<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
										<tr>
											<?php
											echo "<td align=\"center\"><font size=\"2\" face=\"Arial\"><strong>$message </strong></td>";
											?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="bottom">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
						  		<td>&nbsp;</td>
						  		<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<td><img src="images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
					<td width="100%" style="background-image: url(images/subnav-bg.gif);">

		<!-- sub nav -->
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center">
									<table cellspacing="0" cellpadding="0" border="0" style="height:20px;">
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="0" id="tablist2">
													<tr>
														<td style="color:#3b3d3d;font-size:10px;font-family: verdana;font-weight:bold;"><b>&nbsp;</b></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table align="center" width="759" border="0" bgcolor="#FFFFFF">
	<?php
  /************************** COLUMN LEFT START *************************/
  ?>
  <tr>
		<td height="21">
		</td>
	</tr>
	<tr valign="top">
		<td width="550">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
  			<tr> 
    			<td width="100%" align="center"><font face="Arial" size="4"><strong><u>Customer Service Login</u></strong></font></td>
  			</tr>
  			<?php
 				if(!isset($_SESSION['username'])) {
 				echo '<tr><td>&nbsp</td></tr>';
 				if($sysMsg != "") {
  				echo '<tr><td align="center" bgcolor="red"><b><i><font face="Arial" size="2" color="white">'.$sysMsg.'</font></b></i></td></tr>';
  			}
  			echo '<tr valign="top" align="center"><td>';
  			echo '<table>';
  			echo "<form name=\"loginForm\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
  			echo "<tr>";
      	echo "<td><font size=\"2\" face=\"Arial\"><strong>Username:</strong></font></td></tr>";
  			echo "<tr>";
      	echo "<td><input name=\"user\" type=\"text\"></td></tr>";
  			echo "<tr>";
      	echo "<td><font size=\"2\" face=\"Arial\"><strong>Password:</strong></font></td></tr>";
  			echo "<tr>";
      	echo "<td><input name=\"pass\" id=\"req2\" type=\"password\" /></td></tr>";
      	if(isset($_GET['url']) || isset($_POST['url'])) {
      	echo "<input name=\"url\" type=\"hidden\" value=\"$url\">";
      	}
      	?>
  			<tr>
      	 <td><input name="Login" type="submit" value="Login"></td>
      	</tr>
      	</table>
      	<?php
				}
  			?>
  				</td>
  			</tr>
  		</table>
  	</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
 		<td>
<table border="0">
  <tr>
  	<td align="center">
  	<?php
  	echo '<font face="Arial" size="2"><b>'.date("l, M. jS, Y").'<br>'.date("g:i:sa").'</b></font>';
  	?>
  	</td>
  </tr>
  <tr> 
    <td>
      <!-- Search Google -->
      <left>
        <form method="get" action="http://www.google.com/custom" target="google_window">
          <table bgcolor="#ffffff">
            <tr>
              <td nowrap="nowrap" valign="top" align="left" height="32"> <a href="http://www.google.com/"> 
                <img src="http://www.google.com/logos/Logo_25wht.gif" border="0" alt="Google" align="middle"></img></a> 
                <br/> <input type="text" name="q" size="29" maxlength="255" value=""></input> 
              </td>
            </tr>
            <tr>
              <td valign="top" align="left"> <input type="submit" name="sa" value="Search"></input> 
                <input type="hidden" name="client" value="pub-6311950500981555"></input> 
                <input type="hidden" name="forid" value="1"></input>
                <input type="hidden" name="ie" value="ISO-8859-1"></input>
                <input type="hidden" name="oe" value="ISO-8859-1"></input>
                <input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1;"></input> 
                <input type="hidden" name="hl" value="en"></input>
                </td>
            </tr>
          </table>
        </form>
      </center>
      <!-- Search Google -->
    </td>
  </tr>
  <tr>
    <td align="center"><font face="Arial" size="2"><strong>HomeFree Weather</strong></font></td>
  </tr>
  <tr> 
    <td align="center"><div style='width: 160px; height: 600px; background-image: url( http://vortex.accuweather.com/adcbin/netweather_v2/backgrounds/spring1_160x600_bg.jpg ); background-repeat: no-repeat; background-color: #607041;' ><div style='height: 585px;' ><script src='http://netweather.accuweather.com/adcbin/netweather_v2/netweatherV2.asp?partner=netweather&tStyle=normal&logo=1&zipcode=<?php echo "$postal_code"; ?>&lang=eng&size=15&theme=&metric=0&target=_self'></script></div><div style='text-align: center; font-family: arial, helvetica, verdana, sans-serif; font-size: 10px; line-height: 15px; color: FDEA11;' ><a style='color: #FDEA11' href='http://wwwa.accuweather.com/index-forecast.asp?partner=netweather&traveler=0&zipcode=<?php echo "$postal_code"; ?>' >Weather Forecast</a> | <a style='color: #FDEA11' href='http://wwwa.accuweather.com/maps-satellite.asp?partner=netweather' >Weather Maps</a></div></div></td>
  </tr>
</table>
</td>
	</tr>
	<?php
	/*************************** COLUMN RIGHT END ***************************/
	
	/***************************** FOOTER START *****************************/
	?>
	<tr>
		<td colspan="2">
			<?php include_once ("./footer.php"); ?>
		</td>
	</tr>
	<?php
	/****************************** FOOTER END ******************************/
	?>
</table>
</body>
</html>
<?php
include_once ("./footer.php");
?>