<?php
include 'header.php';
include 'includes/configtask.php';
include 'includes/opendbtask.php';
require 'includes/functions.inc.php';
?>
<table align ="center" width = "750" cellpadding="2">   
	<tr>
		<td>
<?php
			$query = "SELECT ID FROM taskinfo WHERE ID < 23";
			$result = mysql_query($query) or die (mysql_error());
			while($row = mysql_fetch_array($result))
			{
				foreach($row as $val)
				{
					$query1 = "SELECT Type,Status FROM taskinfo WHERE ID = '$val'";
					$result1 = mysql_query($query1) or die (mysql_error());
					$row1 = mysql_fetch_array($result1);	
					
				}
				echo $row1['Type'].' '.$row1['Status'].'<br>';
			}
?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><div align="center"><hr width="100%"></div></td>
	</tr>
	<tr>
		<td>
<?php
$os = array();
$os["main"] = "Linux";
$os["distro"] = "Ubuntu";
$os["version"] = "7.10";

list($main, $distro, $version) = array_values($os);
print $main;
?>
</td>
</tr>