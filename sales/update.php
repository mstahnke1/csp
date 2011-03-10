<?php

include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
//$job = nl2br(addslashes($_GET["job"]));
?>

<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
 	 <tr>
		<td><input type="submit" value="DONE" name="done"></td>
	</tr>
</table>
</form>
<?php
if(isset($_GET['done']))
	{
		
$query = "UPDATE tblfacilitygeneralinfo SET Cust_Num = -1 WHERE Cust_Num = 0";
mysql_query($query) or die(mysql_error());
 
}
 include 'includes/closedb.php'; 
 
 ?>