<?php

include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
$job = nl2br(addslashes($_GET["job"]));
?>

<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table>
	<tr>
 		<td align=center>Job Overview</td><td><textarea rows="12" cols="70" name="job"></textarea></td>
 	</tr>
 	 <tr>
		<td><input type="submit" value="DONE" name="done"></td>
	</tr>
</table>
</form>
<?php
if(isset($_GET['done']))
	{
		
$query = "UPDATE tbldoorfunction  SET alarmfunction = '$job' WHERE ID = 10";
mysql_query($query) or die(mysql_error());
 
}
 include 'includes/closedb.php'; 
 
 ?>