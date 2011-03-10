<link rel="stylesheet" type="text/css" href="sales.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HomeFree Install Quote</title>
<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
if(isset($_GET['action'])&&($_GET['action']=='DELETEinst'))
{
	$deleteid = $_GET['id'];
	$delete = "UPDATE tblcompany SET active = 0 WHERE ID = '$deleteid'";
	mysql_query($delete) or die(mysql_error());
	header("Location: configureinstall.php?view=newinstaller");
}
if((isset($_GET['view'])) && ($_GET['view'] == 'changecolor'))
{
	$query = "SELECT * FROM tblcompany WHERE active = 1";
	$result = mysql_query($query) or die(mysql_error());
?>
	<table>
		<tr>
			<td>
				<a href="configurehome.php?">Configuration HOME</a>
			</td>
		</tr>		
		<tr>
			<td class="heading">
				Current Colors
			</td>
		</tr>
<?php					
	while($row = mysql_fetch_array($result))
	{
		$company = $row['Company'];
		$color = $row['font'];
?>				
		<tr>
			<td class="body">
				<?php echo $company ?>
			</td>
			<td width="20" height="15" bgcolor="<?php echo $color; ?>">
			</td>
			<td>
				<?php echo '<a href="configureinstall.php?action=color&id='. $row['ID'].'"><img src="../images/icon_edit_pencil.gif" width="15" height="15" border="0" /></a>'; ?>
			</td>
		</tr>	
<?php
	}
?>
	</table>
<?php
}
if((isset($_GET['action'])) && ($_GET['action'] == 'color'))
{
	$id = $_GET['id'];
	$query1 = "SELECT * FROM tblcompany WHERE ID = '$id'";
	$result1 = mysql_query($query1) or die(mysql_error());
	$row1 = mysql_fetch_array($result1);
	$query3 = "SELECT * FROM tblcolor";
	$result3 = mysql_query($query3) or die(mysql_error());	
?>		
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td colspan="2">
					New color for <?php echo $row1['Company']; ?>
				</td>
			</tr>
<?php
			while($row3 = mysql_fetch_array($result3))
			{
?>				
				<tr>
					<td width="70">
						<input type="radio" name="color" value="<?php echo $row3['color']; ?>">
					</td>
					<td width="50" height="6" bgcolor="<?php echo $row3['color']; ?>">
					</td>
				</tr>
<?php
			}
?>							
			<tr>
				<td>
					<input type="submit" value="Save" name="savecolor">
				</td>
			</tr>								
		</table>
<?php
		echo	'<input type = "hidden" name="id" value = "'.$id.'">';			
?>		
	</form>
<?php
}
if((isset($_GET['savecolor'])) && ($_GET['savecolor'] == 'Save'))
{
	$id = $_GET['id'];
	$color = $_GET['color'];
	$query2 = "UPDATE tblcompany SET font = '$color' WHERE ID = '$id'";
	mysql_query($query2) or die(mysql_error());
	header("Location: configureinstall.php?view=changecolor");
}
if((isset($_GET['view'])) && ($_GET['view'] == 'newinstaller'))
{
	$query4 = "SELECT * FROM tblcompany WHERE active = 1";
	$result4 = mysql_query($query4) or die(mysql_error());
	$query5 = "SELECT * FROM tblcolor";
	$result5 = mysql_query($query5) or die(mysql_error());
?>
	<table>
		<tr>
			<td>
				<a href="configurehome.php">Configuration Home</a>
			</td>
		</tr>
		<tr>
			<td class="border" valign="top">
				<table>
					<tr>
						<td>
							Existing Installers:
						</td>
					</tr>
			<?php		
				while($row4 = mysql_fetch_array($result4))
				{
			?>
					<tr>
						<td>
							<?php echo $row4['Company']; ?>
						</td>
						<td width="20" height="15" bgcolor="<?php echo $row4['font']; ?>">
						</td>
						<td>
							<?php echo '<a href="configureinstall.php?action=DELETEinst&id='. $row4['ID'].'" onClick="return confirm(\'Are you sure you want to delete '.$row4['Company'].'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" /></a>'; ?>
						</td>	
					</tr>
			<?php	
				}
			?>
				</table>
			</td>
			<td valign="top">
				<table>
				<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<table>
						<tr>
							<td>
								New Installers Name:
							</td>
							<td>
								<input type="text" size="25" maxlength="25" name="newinstaller" value="">
							</td>
						</tr>
						<tr>
							<td colspan="2">
								Select Color to Display the new Installer:
							</td>
						</tr>
<?php
						while($row5 = mysql_fetch_array($result5))
						{
?>				
							<tr>
								<td width="70">
									<input type="radio" name="color" value="<?php echo $row5['color']; ?>">
								</td>
								<td width="50" height="6" bgcolor="<?php echo $row5['color']; ?>">
								</td>
							</tr>
<?php
						}
?>								
						<tr>
							<td>
								<input type="submit" value="Save" name="saveinstaller">
							</td>
						</tr>
					</table>
				</form>			
<?php	
}
if((isset($_GET['saveinstaller'])) && ($_GET['saveinstaller'] == 'Save'))
{
	$color = $_GET['color'];
	$company = $_GET['newinstaller'];
	$query6 = "INSERT INTO tblcompany (Company,font,Page) VALUES ('$company','$color',2)";
	mysql_query($query6) or die(mysql_error());
	header("Location: configureinstall.php?view=newinstaller");
}
if((isset($_GET['view'])) && ($_GET['view'] == 'newstatus'))
{
	$query7 = "SELECT * FROM tblstatus";
	$result7 = mysql_query($query7) or die(mysql_error());
?>	
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table>
		<tr>
			<td>
				<a href="configurehome.php">Configuration Home</a>
			</td>
		</tr>
		<tr>
			<td class="border" valign="top">
				<table>
					<tr>
						<td>
							Existing Statuses:
						</td>
					</tr>
<?php		
				while($row7 = mysql_fetch_array($result7))
				{
?>
					<tr>
						<td>
							<?php echo $row7['Status']; ?>
						</td>
						<td>
							Service Call
						</td>
						<td>
							Task
						</td>
						<td>
							Install
						</td>
					</tr>
					<tr>	
						<td>
						</td>					
						<td>
							<input type="radio" name="Service<?php echo $row7['ID'];?>" value="1" <?php if($row7['ServiceCall']==1){echo 'CHECKED';}?>>
						</td>
						<td>
							<input type="radio" name="Task<?php echo $row7['ID'];?>" value="1" <?php if($row7['Task']==1){echo 'CHECKED';}?>>
						</td>
						<td>
							<input type="radio" name="Install<?php echo $row7['ID'];?>" value="1" <?php if($row7['Install']==1){echo 'CHECKED';}?>>
						</td>
					</tr>
<?php	
				}
?>
				</table>
			</td>
			<td valign="top">
				<table>
				
					<table>
						<tr>
							<td>
								New Status:
							</td>
							<td>
								<input type="text" size="25" maxlength="25" name="newstatus" value="">
							</td>
						</tr>							
						<tr>
							<td>
								<input type="submit" value="Save" name="savestatus">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>			
<?php	
}
if((isset($_GET['savestatus'])) && ($_GET['savestatus'] == 'Save'))
{
	$status = $_GET['newstatus'];
	//$query8 = "INSERT INTO tblstatus (Status,Page) VALUES ('$status',2)";
	//mysql_query($query8) or die(mysql_error());
	//header("Location: configureinstall.php?view=newstatus");	
}
if((isset($_GET['view'])) && ($_GET['view'] == 'newtype'))
{
	$query9 = "SELECT * FROM tbltype WHERE Page = 2";
	$result9 = mysql_query($query9) or die(mysql_error());
?>	
	<table>
		<tr>
			<td>
				<a href="configurehome.php">Configuration Home</a>
			</td>
		</tr>
		<tr>
			<td class="border" valign="top">
				<table>
					<tr>
						<td>
							Existing Types:
						</td>
					</tr>
			<?php		
				while($row9 = mysql_fetch_array($result9))
				{
			?>
					<tr>
						<td>
							<?php echo $row9['Type']; ?>
						</td>
					</tr>
			<?php	
				}
			?>
				</table>
			</td>
			<td valign="top">
				<table>
				<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<table>
						<tr>
							<td>
								New Type:
							</td>
							<td>
								<input type="text" size="25" maxlength="25" name="newtype" value="">
							</td>
						</tr>							
						<tr>
							<td>
								<input type="submit" value="Save" name="savetype">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>			
<?php	
}
if((isset($_GET['savetype'])) && ($_GET['savetype'] == 'Save'))
{
	$type = $_GET['newtype'];
	$query10 = "INSERT INTO tbltype (Type,Page) VALUES ('$type',2)";
	mysql_query($query10) or die(mysql_error());
	header("Location: configureinstall.php?view=newtype");	
}