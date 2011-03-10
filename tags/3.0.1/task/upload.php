<?php

	if(isset($_GET['action'])&&($_GET['action']=='DELETE'))
	{
		$taskid = $_GET['taskid'];
		header("Location: upload.php?taskid=$taskid");
	}
include 'header.php';
include 'includes/configtask.php';
include 'includes/opendbtask.php';

if(isset($_GET['taskid']))
{
$taskid = $_GET['taskid'];
$query4 = "SELECT filename FROM tbluploads WHERE taskid = '$taskid'";
$result4 = mysql_query($query4) or die (mysql_error());
$row4 = mysql_num_rows($result4);
//echo $row4;
if($row4 == 0)
{
    $query2 = "UPDATE taskinfo SET Attachment = 'no' WHERE ID = '$taskid'";
    mysql_query($query2) or die(mysql_error());
 }else 
 {
     $query5 = "UPDATE taskinfo SET Attachment = 'yes' WHERE ID = '$taskid'";
    mysql_query($query5) or die(mysql_error());
   }
?>


<form enctype="multipart/form-data" action="uploader.php?taskid=<?php echo $taskid ?>" method="POST">
  	<table width ="750" align="center" border = "0">
 			<tr>
 				<td>
				<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
				Add a new attachment here. <br><br>
				**If you upload a file with the same name as an existing you will overwrite the one that is there. Which you would want to do if you have just made updates to a file.<br><br>
				Attachments: 
			</td>
		</tr>
	</table>
 	<table width ="750" align="center" border = "0">
		<tr>
			<td width="225">
				<input name="uploadedfile" type="file" />
			</td>				
			<td>
				<input type="submit" value="Upload File" />
			</td>
		</tr>
	</table>
</form>


	<table border="0" align = "center">
		<tr>
			<td colspan = "2">
				Existing Attachments:
			</td>
		</tr>
<?php

$query1 = "SELECT * FROM tbluploads WHERE taskid = '$taskid'";
$result1 = mysql_query($query1) or die (mysql_error());
while($row1 = mysql_fetch_array($result1))
{
$id = $row1['ID'];
$attach = $row1['filename'];
$path = $row1['path'];
$taskid = $row1['taskid'];
	?>
		<tr>
			<td>
		<?php	echo '<a href="' .$path.'">'. $attach .' </a>'. '&nbsp;&nbsp;'.'</td>' . '<td width="22"><a href="upload.php?action=DELETE&id=' . $id . '&taskid='. $taskid .'" onClick="return confirm(\'Are you sure you want to delete '.$attach.'?\')"><img src="../images/delete-icon_Small.png" width="20" height="20" border="0" /></a>'; ?>				 
			</td>
		</tr>
			
<?php
}
?>
	</table>
	<table>
	    <tr>
    		<td>
			<button onClick="window.location='taskhome.php'">Task Home</button>
		</td>
	</tr>
	</table>	
<?php
}
	if(isset($_GET['action'])&&($_GET['action']=='DELETE'))
		{
			$taskid = $_GET['taskid'];
			$deleteid = $_GET['id'];
			$delete = "DELETE FROM tbluploads WHERE ID = '$deleteid'";
			mysql_query($delete) or die(mysql_error());
			//header("Location: upload.php?taskid=$taskid");
		}
/*
if(isset($_GET['id']) & (!isset($_GET['delete'])))
{
$id1 = $_GET['id'];
//echo $id1;	
$query2 = "SELECT * FROM tbluploads WHERE ID = '$id1'";
$result2 = mysql_query($query2) or die (mysql_error());
$row2 = mysql_fetch_array($result2);
$taskid = $row2['taskid'];
$filename = $row2['filename'];
?>
<table>
	<tr>
		<td> Are you sure you want to delete this file <?php echo $filename; ?> </td> <td> <button onClick="window.location='upload.php?delete=yes&id=<?php echo $id1 ?>&filename=<?php echo $filename ?>'">Yes</button></td><td> <button onClick="window.location='upload.php?taskid=<?php echo $taskid ?>'">No</button></td>
	</tr>

</table>
<?php
}
if(isset($_GET['delete'])&&($_GET['delete']='yes'))
{
$id = $_GET['id'];
$query2 = "SELECT * FROM tbluploads WHERE ID = '$id'";
$result2 = mysql_query($query2) or die (mysql_error());
$row2 = mysql_fetch_array($result2);
$filename = $row2['path'];
$task = $row2['taskid'];


$query1 = "DELETE FROM tbluploads WHERE ID = '$id'";
mysql_query($query1) or die(mysql_error());

?>
<table>
	<tr>
		<td> 
			File has been deleted. </td> <td> <button onClick="window.location='upload.php?taskid=<?php echo $task ?>'">Continue</button>
		</td>
	</tr>
</table>
<?php
}
*/
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>