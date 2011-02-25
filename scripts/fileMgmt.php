<?php
require_once('../includes/cspSessionMgmt.php');
require_once('../includes/config.inc.php');
require_once('../includes/db_connect.inc.php');
require_once('../includes/functions.inc.php');

if(isset($_POST['action']) && $_POST['action'] == "add") {
	if(!empty($_FILES["uploadFile"])) {
		if ((($_FILES["uploadFile"]["type"] == "image/gif")
		|| ($_FILES["uploadFile"]["type"] == "image/jpeg")
		|| ($_FILES["uploadFile"]["type"] == "image/pjpeg")
		|| ($_FILES["uploadFile"]["type"] == "application/pdf")
		|| ($_FILES["uploadFile"]["type"] == "application/msword")
		|| ($_FILES["uploadFile"]["type"] == "application/vnd.ms-excel")
		|| ($_FILES["uploadFile"]["type"] == "application/x-zip-compressed")
		|| ($_FILES["uploadFile"]["type"] == "application/zip")
		|| ($_FILES["uploadFile"]["type"] == "text/plain"))) {
			if ($_FILES["uploadFile"]["error"] > 0) {
	  		$sysMsg = urlencode("Return Code: " . $_FILES["uploadFile"]["error"]);
	  		die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&sysMsg=" . $sysMsg));
	  	} else {
	  		$attachType = $_POST['type'];
	  		if($_POST['fileDesc'] != "") {
	  			$fileDesc = $_POST['fileDesc'];
	  		} else {
	  			$fileDesc = $_FILES["uploadFile"]["name"];
	  		}
	  		$fileName = md5(rand()) . "." . findexts($_FILES["uploadFile"]["name"]);
	  		$fileType = $_FILES["uploadFile"]["type"];
	  		$fileSize = ceil($_FILES["uploadFile"]["size"] / 1024);
	  		
	  		switch($attachType) {
	  			case "customer":
	  				$refNumber = $_POST['custID'];
	  				break;
	  			case "ticket":
	  				$refNumber = $_POST['ticketID'];
	  				break;
	  		}
	    	
				if (file_exists("../attachments/$attachType/$refNumber/" . $fileName)) {
  	  		die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&msgID=12"));
  	  	} else {
  	  		if(!is_dir("../attachments/$attachType/$refNumber")) {
						mkdir("../attachments/$attachType/$refNumber");
					}
    			if(move_uploaded_file($_FILES["uploadFile"]["tmp_name"], "../attachments/$attachType/$refNumber/" . $fileName))
    			{
	    			$fileLocation = "attachments/$attachType/$refNumber/" . $fileName;
	    			$qryFileMngr1 = "INSERT INTO filemanager (name, description, size, fileType, location, refNumber, attachType, addedBy) VALUES
	    							('$fileDesc', '$fileName', '$fileSize', '$fileType', '$fileLocation', '$refNumber', '$attachType', '$_SESSION[uid]')";
	    			$resFileMngr1 = mysql_query($qryFileMngr1) or die(mysql_error());
	    			die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&msgID=4"));
    			}
    		}
	    } 	
		} else {
			$sysMsg = urlencode("File is not an authorized file type.");
			die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&sysMsg=" . $sysMsg));
		}
	} else {
		$sysMsg = urlencode("You cannot complete actions on this page. Your activity has been logged.");
		die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&sysMsg=" . $sysMsg));
	}
}

if(isset($_POST['action']) && $_POST['action'] == "removeFiles") {
	$custID = $_POST['custID'];
	$refType = $_POST['refType'];
	$refNum = $_POST['refNum'];
	foreach ($_POST as $key => $value) {
		if(!($key == "refType" || $key == "refNum" || $key == "action")) {
			$fileID = $key;
			$query2 = "SELECT location FROM filemanager WHERE id = '$fileID'";
			$result2 = mysql_query($query2);
			$row2 = mysql_fetch_assoc($result2);
			$fileLoc = $row2['location'];
			$fileName = basename($fileLoc);
			if(file_exists("../$fileLoc")) {
				rename("../$fileLoc", "../attachments/trash/$fileName");
				$query3 = "UPDATE filemanager SET publish = 0 WHERE id = '$fileID' LIMIT 1";
				$result3 = mysql_query($query3);
				if(!$result3) {
					echo mysql_error();
				}
			}
		}
	}
	die(header("Location: " . $_SERVER['HTTP_REFERER'] . "&msgID=5"));
}

if(isset($_GET['action']) && $_GET['action'] == "restoreFile") {
	$fileID = $_GET['fileID'];
	$query4 = "SELECT location FROM filemanager WHERE id = '$fileID'";
	$result4 = mysql_query($query4);
	$row4 = mysql_fetch_assoc($result4);
	$fileLoc = $row4['location'];
	$fileName = basename($fileLoc);
	if (file_exists("attachments/trash/$fileName")) {
		rename("attachments/trash/$fileName", "$fileLoc");
		$query5 = "UPDATE filemanager SET publish = -1 WHERE id = '$fileID' LIMIT 1";
		if(mysql_query($query5)) {
			$sysMsg = $portalMsg[14][$lang] . " " . $fileLoc;
		}
	} else {
		$sysMsg = $portalMsg[6][$lang];
	}
}

if(isset($_GET['action']) && $_GET['action'] == "viewTrash") {
	if($_SESSION['access'] = 10) {
		$query3 = "SELECT * FROM filemanager WHERE publish = 0";
		$result3 = mysql_query($query3);
	} else {
		$sysMsg = $portalMsg[8][$lang];
	}
}

if(isset($_GET['action']) && $_GET['action'] == "emptyTrash") {
	if($_SESSION['access'] = 10) {
		$query3 = "SELECT name, description, location FROM filemanager WHERE publish = 0";
		$result3 = mysql_query($query3);
		while($row3 = mysql_fetch_assoc($result3)) {
			$fileLoc = $row3['location'];
			$fileName = basename($fileLoc);
			unlink("attachments/trash/" . $fileName);
		}
		$query4 = "DELETE FROM filemanager WHERE publish = 0";
		if($result4 = mysql_query($query4)) {
			$sysMsg = $portalMsg[5][$lang];
		} else {
			$sysMsg = mysql_error();
		}
	} else {
		$sysMsg = $portalMsg[8][$lang];
	}
}
require_once('../includes/db_close.inc.php');
?>