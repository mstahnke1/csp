<?php
include 'header.php';
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
mysql_select_db($dbname);
$email = $_SESSION['mail'];
$query10 = "SELECT id, f_name, l_name, dept FROM employees WHERE email = '$email'";
$result10 = mysql_query($query10) or die (mysql_error());
$row10 = mysql_fetch_array($result10);
$employeeid = $row10['id'];      
$firstname = $row10['f_name'];
$lastname = $row10['l_name'];
$department = $row10['dept'];
 mysql_close($conn11);	
$date = date('Y-m-d H:i:s');
include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
if(isset($_GET['taskid']))
	{
		$ID = $_GET['taskid'];
?>
			<table width = 750 border = 0>
				<tr>
					<td font face = Arial size = 3 colspan = 3 align = center>
						<b>History for task <?php echo $ID; ?></b>
					</td>
				</tr>
<?php	
					if(!isset($_GET['query']))
						{
?>			
							<tr>
								<td colspan = 3 align = center>
									<button onClick="window.location='taskaudit.php?taskid=<?php echo $ID; ?>&query=yes'">View Queries</button>
								</td>
							</tr>
<?php			
						}else
						{
?>			
							<tr>
								<td colspan = 3 align = center>
									<button onClick="window.location='taskaudit.php?taskid=<?php echo $ID; ?>'">Hide Queries</button>
								</td>
							</tr>					
<?php
						}
		mysql_select_db($dbname2);						
		$query = "SELECT * FROM tbltaskaudit WHERE taskid = '$ID'";
		$result = mysql_query($query) or die (mysql_error());
		while($row = mysql_fetch_array($result))
			{
				$action = $row['Action'];
				$querydone = addslashes($row['Query']);
				$when = $row['Date'];
				$who = $row['User'];
				$status = $row['status'];
				$priority = $row['priority'];
				mysql_select_db($dbname);
				$query2 = "SELECT f_name, l_name FROM employees WHERE id = '$who'";
				$result2 = mysql_query($query2) or die (mysql_error());
				$row2 = mysql_fetch_array($result2);
				$name = $row2['f_name']. ' '. $row2['l_name'];
?>					
						<tr>
							<td>
								<?php echo $name . ' ' . $action . ' on ' . $when; ?>
							</td>
<?php
								if($action <> "VIEWED")
									{
										if($priority == 1)
											{
												$priority1 = "Low";
											}elseif($priority == 2)
											{
												$priority1 = "Medium";
											}elseif($priority == 3)
											{
												$priority1 = "High";
											}elseif($priority == 4)
											{
												$priority1 = "ASAP";
											}elseif($priority == 5)
											{
												$priority1 = "TBD";
											}elseif($priority == 6)
											{
												$priority1 = "Immediate";
											}
										if($status == 1)
											{
												$status1 = "New";
											}elseif($status == 2)
											{
												$status1="In Progress";
											}elseif($status == 3)
											{
												$status1="Complete";
											}elseif($status == 4)
											{
												$status1="Canceled";
											}elseif($status == 5)
											{
												$status1="Deferred";
											}	
?>						
											<td>
												Status of task: <?php echo $status1; ?>
											</td>
											<td>
												Priority of task: <?php echo $priority1; ?>
											</td>
										</tr>
<?php	
									}	
								if(isset($_GET['query']))
									{
?>
										<tr>
											<td colspan = 3>
												Query done: <?php echo stripslashes($querydone); ?>
											</td>
										</tr>
<?php				
									}
?>
								<tr>
									<td colspan = 3><div align="center"><hr width="100%"></div></td>
								</tr>
<?php										
			}
?>
			<tr>
				<td>
					<button onClick="window.location='task.php?taskid=<?php echo $ID; ?>&view=update'">Back to Task</button>
				</td>
				<td>
					<button onClick="window.location='taskhome.php'">Back to Task Home</button>
				</td>
			</tr>
		</table>
<?php
	}
if(!isset($_GET['taskid']))
	{
?>
		<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<table width = 750 border = 0>
				<tr>
					<td>
						Task Number: <input type="text" size="50" maxlength="100" name="taskid">
					</td>
					<td>
						<input type="submit" value="Search" name="search">
					</td>
				</tr>
			</table>
		</form>
<?php
	} 
include 'includes/closedbtask.php';
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>