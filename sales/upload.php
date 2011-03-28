<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';

if(isset($_GET['f_id']))
{
$facilityid = $_GET['f_id'];
/*
$query4 = "SELECT filename FROM tbluploads WHERE facilityid = '$facilityid'";
$result4 = mysql_query($query4) or die (mysql_error());
$row4 = mysql_num_rows($result4);
//echo $row4;
if($row4 == 0)
{
    $query2 = "UPDATE taskinfo SET Attachment = 'no' WHERE ID = '$facilityid'";
    mysql_query($query2) or die(mysql_error());
 }else 
 {
     $query5 = "UPDATE taskinfo SET Attachment = 'yes' WHERE ID = '$facilityid'";
    mysql_query($query5) or die(mysql_error());
   }
*/
?>


<form enctype="multipart/form-data" action="uploader.php?f_id=<?php echo $facilityid ?>" method="POST">
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
$query1 = "SELECT * FROM tbluploads WHERE facilityid = '$facilityid'";
$result1 = mysql_query($query1) or die (mysql_error());
while($row1 = mysql_fetch_array($result1))
{
$id = $row1['ID'];
$attach = $row1['filename'];
$path = $row1['path'];
	?>
		<tr>
			
				 <?php echo  '<td><font face="Arial" size="2"><a href="' . $path .'">'.  $attach .'</td>';  ?> <td><button onClick="window.location='upload.php?id=<?php echo $id; ?>'">Delete this attachment</button>
			</td>
		</tr>
			
<?php
}
?>
	</table>
	<table>
	    <tr>
    		<td>
			<button onClick="window.location='newfinishedpage.php?f_id=<?php echo $facilityid; ?>'">Finished</button>
		</td>
	</tr>
	</table>	
<?php
}
if(isset($_GET['id']) & (!isset($_GET['delete'])))
{
$id1 = $_GET['id'];
//echo $id1;	
$query2 = "SELECT * FROM tbluploads WHERE ID = '$id1'";
$result2 = mysql_query($query2) or die (mysql_error());
$row2 = mysql_fetch_array($result2);
$facilityid = $row2['facilityid'];
$filename = $row2['filename'];
?>
<table>
	<tr>
		<td> Are you sure you want to delete this file <?php echo $filename; ?> </td> <td> <button onClick="window.location='upload.php?delete=yes&id=<?php echo $id1 ?>&filename=<?php echo $filename ?>'">Yes</button></td><td> <button onClick="window.location='upload.php?f_id=<?php echo $facilityid; ?>'">No</button></td>
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
$facilityid = $row2['facilityid'];


$query1 = "DELETE FROM tbluploads WHERE ID = '$id'";
mysql_query($query1) or die(mysql_error());

?>
<table>
	<tr>
		<td> 
			File has been deleted. </td> <td> <button onClick="window.location='upload.php?f_id=<?php echo $facilityid; ?>'">Continue</button>
		</td>
	</tr>
</table>
<?php
}
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>