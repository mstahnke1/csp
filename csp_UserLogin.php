<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
$companyName = 'HomeFree';
//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

if(isset($_GET['url'])) {
	$url = $_GET['url'];
}

if(isset($_POST['url'])) {
	$url = $_POST['url'];
}

// Check for active session
if(!isset($_SESSION['uid'])) {
	// Check for login form submission and verify no fields are blank
	if((isset($_POST['user']) && $_POST['user'] != "") && (isset($_POST['pass']) && $_POST['pass'] != "")) 
	{
		// LDAP variables
		$ldap['user'] = $_POST['user'];
		$ldap['pass'] = $_POST['pass'];
		$ldap['base'] = '';

		// if connection to ldap server is successful
		$ldap['conn'] = ldap_connect($ldap['host'],$ldap['port']);
		if($ldap['conn']) {
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
			if($ldap['bind']) {
				// search for the user on the ldap server and return requested user information
				$ldap['result'] = ldap_search($ldap['conn'], $ldap['dn'], 'samaccountname='.$ldap['user'], $ldap['attributes']);
					
				// if active directory search was successful
				if($ldap['result']) {
    			// retrieve all the entries from the search result
    			$ldap['info'] = ldap_get_entries( $ldap['conn'], $ldap['result'] );
				} else {
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
					if(mysql_num_rows($result) > 0) {
						$row = mysql_fetch_array($result);
						// Add access level to the session
    				$_SESSION['access'] = $row['access'];
    				$_SESSION['uid'] = $row['id'];
    			} else {
    				$query3 = "INSERT INTO employees (f_name, l_name, ext_num, mobile, email, access) VALUES ('$f_name', '$l_name', '', '', '$email', '5')";
    				mysql_query($query3) or die(mysql_error());
    				$_SESSION['access'] = 5;
    			}
    			$agent = $_SERVER['HTTP_USER_AGENT'];
    			// Insert authentication information into the database activity log
    			$query2 = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', 'User Login', '$agent', CURDATE(), CURTIME())";
    			mysql_query($query2);
    				
					include 'includes/db_close.inc.php';
					session_regenerate_id();
					
  				if(isset($url)) {
					?>
						<script type="text/javascript">
						<!--
						window.location = "<?php echo $url; ?>";
						//-->
						</script>
					<?php
					} else {
  				?>
  					<script type="text/javascript">
						<!--
						window.location = "cspUserHome_Dashboard.php";
						//-->
						</script>
					<?php
					}
				} else {
    			$sysMsg = ldap_error($ldap['conn']);
				}
				// close connection to ldap server
				ldap_close($ldap['conn']);
			} else {
				$sysMsg = ldap_error($ldap['conn']);
				$user = $_POST['user'];
				$agent = $_SERVER['HTTP_USER_AGENT'];
				$statement = stripslashes(fix_apos("'", "''", 'Login Error: '.ldap_error($ldap['conn'])));
				$queryLog = "INSERT INTO activity_logs (user, statement, action, agent, date, time) VALUES ('$user', '$statement', '1', '$agent', CURDATE(), CURTIME())";
				mysql_query($queryLog) or die(mysql_error());
				include 'includes/db_close.inc.php';
			}
		} else {
			$sysMsg = $portalMsg[3][$lang];
		}
	}
} else {
	die(header("Location: cspUserHome_Dashboard.php"));
}
?>

<head>
	<title><?php echo $companyName; ?> | CSP - User Login</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="theme/default/cspDefault.css" />
	<script type="text/javascript" src="js/cb.js"></script>
	<link rel="icon" type="image/ico" href="favicon.ico" />
</head>

<body>
	<center>
		<div class="cspContainer">
			<div class="cspHeader">
				<?php require_once('cspInfoPanel.php'); ?>
			</div>
			<div class="cspLeftPanel">
				&nbsp;
			</div>
			<div class="cspRightPanel">
				&nbsp;
			</div>
			<div class="cspContent" align="left">
				<div class="cbb">
					<p>
						HomeFree Customer Service Excellence!<br />
						Powered by the new<br />
						Customer Service Portal Version 3.0!
					</p>
				</div>
			</div>
			<div class="cspFooter">
				<?php require_once('cspFooter.php'); ?>
			</div>
		</div>
	</center>
</body>

</html>