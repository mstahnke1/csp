<link rel="stylesheet" type="text/css" href="sales.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HomeFree Install Quote</title>
<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
?>
	<table>
		<tr>
			<td class="border" width="375" valign="top">
				<table>
					<tr>
						<td>
							Scope of Work
						</td>
					</tr>
					<tr>
						<td>
							<?php echo '<a href="' . 'configuredoorunits.php?view=new'.'">'?> ADD a door alarm setup
						</td>
					</tr>
					<tr>
						<td>
							<?php echo '<a href="' . 'configuredoorunits.php?view=update'.'">'?> UPDATE a door alarm setup
						</td>
					</tr>
				</table>
			</td>
			<td class="border" width="375" valign="top">
				<table>
					<tr>
						<td>
							Task Management
						</td>
					</tr>
					<tr>
						<td>
							<?php echo '<a href="' . 'configuretasks.php?view=new'.'">'?> ADD a TYPE to task management
						</td>
					</tr>
				</table>	
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td class="border" width="375">
				<table>
					<tr>
						<td>
							Install Quote/Schedule
						</td>
					</tr>
					<tr>
						<td>
							<?php echo '<a href="' . 'configureinstall.php?view=newtype'.'">'?> ADD a TYPE to Install Schedule
						</td>
					</tr>
					<tr>
						<td>
							<?php echo '<a href="' . 'configureinstall.php?view=newstatus'.'">'?> ADD a STATUS to Install Schedule
						</td>
					</tr>				
					<tr>
						<td>
							<?php echo '<a href="' . 'configureinstall.php?view=newinstaller'.'">'?> ADD/REMOVE an Install Company
						</td>
					</tr>	
					<tr>
						<td>
							<?php echo '<a href="' . 'configureinstall.php?view=changecolor'.'">'?> CHANGE COLOR of Install Company
						</td>
					</tr>												
				</table>				
			</td>
		</tr>
	</table>
<?php
include 'includes/closedb.php'; 
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>