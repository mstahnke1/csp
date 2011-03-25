<?php
	$user = $_SESSION['uid'];
	
	if(isset($_POST['action']) || isset($_GET['action']))
	{
	if(!empty($_FILES["uploadFile"]))
	{
		if ((($_FILES["uploadFile"]["type"] == "image/gif")
		|| ($_FILES["uploadFile"]["type"] == "image/jpeg")
		|| ($_FILES["uploadFile"]["type"] == "image/pjpeg")
		|| ($_FILES["uploadFile"]["type"] == "application/pdf")
		|| ($_FILES["uploadFile"]["type"] == "application/msword")
		|| ($_FILES["uploadFile"]["type"] == "application/vnd.ms-excel")
		|| ($_FILES["uploadFile"]["type"] == "application/x-zip-compressed")
		|| ($_FILES["uploadFile"]["type"] == "application/zip")
		|| ($_FILES["uploadFile"]["type"] == "text/plain")))
  	{
  		if ($_FILES["uploadFile"]["error"] > 0)
    	{
    		$sysMsg = "Return Code: " . $_FILES["uploadFile"]["error"] . "<br />";
    	}
  		else
    	{
    		$attachType = $_POST['type'];
    		if($_POST['fileDesc'] != "") {
    			$fileDesc = $_POST['fileDesc'];
    		} else {
    			$fileDesc = $_FILES["uploadFile"]["name"];
    		}
    		$fileName = md5(rand()) . "." . findexts($_FILES["uploadFile"]["name"]);
    		$fileType = $_FILES["uploadFile"]["type"];
    		$fileSize = ceil($_FILES["uploadFile"]["size"] / 1024);
				if($attachType == "customer")
				{
					$custNum = $_POST['cust_num'];
    			if (file_exists("attachments/customers/$custNum/" . $fileName))
    	  	{
    	  		$sysMsg = $_FILES["uploadFile"]["name"] . " " . $portalMsg[12][$lang];
    	  	}
    			else
    	  	{
    	  		if(!is_dir("attachments/customers/$custNum"))
						{
							mkdir("attachments/customers/$custNum");
						}
      			if(move_uploaded_file($_FILES["uploadFile"]["tmp_name"],
      			"attachments/customers/$custNum/" . $fileName))
      			{
      			//echo "Stored in: " . "attachments/customers/$custNum/" . $_FILES["uploadFile"]["name"];
      			$fileLocation = "attachments/customers/$custNum/" . $fileName;
      			$query = "INSERT INTO filemanager (name, description, size, fileType, location, refNumber, attachType, addedBy) VALUES
      							('$fileDesc', '$fileName', '$fileSize', '$fileType', '$fileLocation', '$custNum', '$attachType', '$user')";
      			$result = mysql_query($query) or die(mysql_error());
      			$sysMsg = $portalMsg[4][$lang];
      			}
      		}
      	}