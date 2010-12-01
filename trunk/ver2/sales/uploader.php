<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
 $facilityid = $_GET['f_id'];
//$employeeid = $_GET['employeeid'];

if(!is_dir("uploads/$facilityid"))
{
mkdir("uploads/$facilityid");
}
$target_path = "uploads/$facilityid/";

$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
   
$filename =  basename( $_FILES['uploadedfile']['name']);
$query3 = "SELECT * FROM tbluploads WHERE id = '$facilityid' AND filename = '$filename'";
$result3 = mysql_query($query3) or die (mysql_error());
$row3 = mysql_num_rows($result3);

	if($row3 == 0)
	{
    $query = "INSERT INTO tbluploads (facilityid,path,filename) VALUES ('$facilityid','/csPortal/sales/uploads/$facilityid/$filename','$filename')";
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
			<button onClick="window.location='upload.php?f_id=<?php echo $facilityid; ?>'">Continue</button>
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
include 'includes/closedb.php';
?>
<table align = center width = 750>
	<tr>
		<td>
			<?php include_once ("../footer.php"); ?>
		</td>
	</tr>
</table>