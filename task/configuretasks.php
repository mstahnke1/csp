﻿<?php
if(isset($_GET['cancel']))
{
	header("Location: configurehome.php");
}
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
$gettypes = "SELECT * FROM tbltype";
$resgettypes = mysql_query($gettypes) or die (mysql_error());
?>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width= "750">
	<tr>
		<td>
			EXISTING LIST OF TYPES:
		</td>
	</tr>
<?php
while($existingtype = mysql_fetch_array($resgettypes))
{
?>
	<tr>
		<td>
			<?php echo $existingtype['Type']; ?>
		</td>
	</tr>
<?php
}
?>	
	<tr>
		<td><b><font face = "Arial" size = 2">
			ADD TYPE: <input type="text" size="24" maxlength="24" name="type">
		</font></b></td>
	</tr>
	<tr>
		<td>
			<input type="submit" value="SAVE" name="save">
		</td>
		<td>
			<input type="submit" value="CANCEL" name="cancel">
		</td>
	</tr>
</table>
</form>
<?php
if(isset($_GET['save']))
{
	$type = $_GET['type'];
	$INSERTTYPE = "INSERT INTO tbltype (Type) VALUES ('$type')";
	
	