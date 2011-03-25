<?php
include 'header.php';
//session_start();
	include '../includes/config.inc.php';
	include '../includes/db_connect.inc.php';
if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	die(header("Location: csPortal_Login.php"));
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

$conn1 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db($dbname);
$email = $_SESSION['mail'];
$query8 = "SELECT id, f_name, l_name, dept FROM employees WHERE email = '$email'";
$result8 = mysql_query($query8) or die (mysql_error());
$row8 = mysql_fetch_array($result8);
$employeeid = $row8['id'];      
$department = $row8['dept'];
$access = $_SESSION['access'];
mysql_close($conn1);	

?>

<table cellpadding=3 width="750"  align ="center">
	<tr>
		<td width="50">
		</td>
		<td colspan="2">
				<button onClick="window.location='taskhome.php?name=<?php echo $employeeid; ?>'">Back to the Task Home Page</button>
			</td>
	</tr>
	<tr>
		<td colspan = "3"><div align="center"><hr width="100%"></div></td>
	</tr>
</table>
<table cellpadding=1 width="150"  border = 0 align ="left">
	<tr>
		<td colspan="2">
			Open Tasks:
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<?php echo '<a href="' . 'taskreports.php'.'?open=yes'.'">'?>Created Tasks			
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<?php echo '<a href="' . 'taskreports.php'.'?responsible=yes'.'">'?>Responsible		
		</td>	
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<?php echo '<a href="' . 'taskreports.php'.'?coresponsible=yes'.'">'?>Co-Responsible			
		</td>
	</tr>		
	<tr>
		<td>
		</td>
		<td>
			<?php echo '<a href="' . 'taskreports.php'.'?check=yes'.'">'?>Check			
		</td>
	</tr>		
	<tr>
		<td>
		</td>
		<td>
			<?php echo '<a href="' . 'taskreports.php'.'?assigned=yes'.'">'?>Assigned
		</td>
	</tr>		
</table>	
<table cellpadding=1 width="150" border=0 align ="left">
	<tr>
		<td colspan="2">
			Created Tasks:
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<?php echo '<a href="' . 'taskreports.php'.'?closed=yes'.'">'?>Status Completed			
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<?php echo '<a href="' . 'taskreports.php'.'?canceled=yes'.'">'?>Status Canceled		
		</td>
	</tr>	
</table>	

<?php
	if($access > 5)
		{	
?>	
			<table cellpadding=1 width="150"  align ="left">
				<tr>
					<td colspan="2">
						Other Reports:
					</td>
				</tr>			
				<tr>
					<td>
					</td>
					<td>
						<?php echo '<a href="' . 'customreport.php'.'">'?>Custom Report		
					</td>
				</tr>		
<?php
			if($department == 2 OR $access > 6)
				{	
?>								
					<tr>
						<td>
						</td>
						<td>
							<?php echo '<a href="' . 'taskreports.php'.'?technical=yes'.'">'?>All Technical Tasks		
						</td>
					</tr>	
<?php
				}
			if($department == 1 OR $access > 6 )	
				{
?>									
					<tr>
						<td>
						</td>
						<td>
							<?php echo '<a href="' . 'taskreports.php'.'?sales=yes'.'">'?>All Sales Tasks		
						</td>
					</tr>
<?php	
				}
			if($department == 3 OR $access > 6)
				{
?>					
					<tr>					
					<td>
					</td>
					<td>
						<?php echo '<a href="' . 'taskreports.php'.'?human=yes'.'">'?>All HR Tasks		
					</td>
				</tr>	
<?php
				}
			if($department == 2 OR $access > 6)
				{					
?>								
					<tr>
						<td>
						</td>
						<td>
							<?php echo '<a href="' . 'taskreports.php'.'?techsummary=yes'.'">'?>Technical Summary		
						</td>
					</tr>	
<?php
				}
			if($department == 1 OR $access > 6 )	
				{
?>					
					<tr>
						<td>
						</td>
						<td>
							<?php echo '<a href="' . 'taskreports.php'.'?salessummary=yes'.'">'?>Sales Summary		
						</td>
					</tr>	
<?php	
				}
			if($department == 3 OR $access > 6)
				{
?>							
					<tr>
						<td>
						</td>
						<td>
							<?php echo '<a href="' . 'taskreports.php'.'?hrsummary=yes'.'">'?>HR Summary	
						</td>
					</tr>		
<?php
				}
?>									
				</table>
<?php	
		}
include 'includes/closedbtask.php';
?>			

	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>
