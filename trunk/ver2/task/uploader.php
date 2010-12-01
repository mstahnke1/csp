<?php
include 'header.php';
include 'includes/configtask.php';
include 'includes/opendbtask.php';
 $task = $_GET['taskid'];
//$employeeid = $_GET['employeeid'];

if(!is_dir("uploads/$task"))
{
mkdir("uploads/$task");
}
$target_path = "uploads/$task/";

$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
   
$filename =  basename( $_FILES['uploadedfile']['name']);
$query3 = "SELECT * FROM tbluploads WHERE taskid = '$task' AND filename = '$filename'";
$result3 = mysql_query($query3) or die (mysql_error());
$row3 = mysql_num_rows($result3);

	if($row3 == 0)
	{
    $query = "INSERT INTO tbluploads (taskid,path,filename) VALUES ('$task','/csPortal/task/uploads/$task/$filename','$filename')";
    mysql_query($query) or die(mysql_error());
    ?>
           <tr>
    		<td>
			File was succesfully saved!!
		</td>
	</tr>
	<?php
  }else
  {
  	?>
  	<tr>
  		<td>
  			File was overwritten
  		</td>
  	</tr>
  <?php
}


    ?>
 
    <tr>
    		<td>
			<button onClick="window.location='upload.php?taskid=<?php echo $task ?>'">Continue</button>
		</td>
	</tr>
	<?php
} else{
    echo "There was an error uploading the file, please try again!";
    ?>
    <tr>
   	 <td>
   	 	Click the back button in your browser to try again.
   	 </td>
   	</tr>
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