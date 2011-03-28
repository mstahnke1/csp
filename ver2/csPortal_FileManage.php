<?php
$message="";
$sysMsg="";

//session_set_cookie_params(0 , '/', '.dmatek.com');
session_start();

if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	mysql_query($queryLog);
	include 'includes/db_close.inc.php';
	die(header("Location: csPortal_Login.php"));
}
else
{
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}

	include 'includes/config.inc.php';
	include 'includes/db_connect.inc.php';
	include 'includes/functions.inc.php';
	
	if(isset($_GET['msgID']))
	{
		$sysMsg = $portalMsg[$_GET['msgID']][$lang];
	}
	
	$name = $_SESSION['displayname'];
	$message = $portalMsg[10][$lang] . " $name!";
	$mail = $_SESSION['mail'];
	
	$query5 = "SELECT f_name, l_name FROM employees WHERE email = '$mail'";
	$result5 = mysql_query($query5);
	$row5 = mysql_fetch_array($result5);
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
      	
      	if($attachType == "ticket")
				{
					$ticketNum = $_POST['ticket_num'];
    			if (file_exists("attachments/tickets/$ticketNum/" . $fileName))
    	  	{
    	  		$sysMsg = $_FILES["uploadFile"]["name"] . " " . $portalMsg[12][$lang];
    	  	}
    			else
    	  	{
    	  		if(!is_dir("attachments/tickets/$ticketNum"))
						{
							mkdir("attachments/tickets/$ticketNum");
						}
      			if(move_uploaded_file($_FILES["uploadFile"]["tmp_name"],
      			"attachments/tickets/$ticketNum/" . $fileName))
      			{
      			//echo "Stored in: " . "attachments/customers/$custNum/" . $_FILES["uploadFile"]["name"];
      			$fileLocation = "attachments/tickets/$ticketNum/" . $fileName;
      			$query = "INSERT INTO filemanager (name, size, fileType, location, refNumber, attachType, addedBy) VALUES
      							('$fileDesc', '$fileSize', '$fileType', '$fileLocation', '$ticketNum', '$attachType', '$user')";
      			$result = mysql_query($query) or die(mysql_error());
      			$sysMsg = $portalMsg[4][$lang];
      			}
      		}
      	}
      	
      	if($attachType == "techBinder")
				{
					$uploadType = $_POST['uploadType'];
    			if (file_exists("attachments/techbinder/" . $fileName))
    	  	{
    	  		$sysMsg = $_FILES["uploadFile"]["name"] . " " . $portalMsg[12][$lang];
    	  	}
    			else
    	  	{
    	  		if(!is_dir("attachments/techbinder/"))
						{
							mkdir("attachments/techbinder/");
						}
      			if(move_uploaded_file($_FILES["uploadFile"]["tmp_name"],
      			"attachments/techbinder/" . $fileName))
      			{
      			//echo "Stored in: " . "attachments/customers/$custNum/" . $_FILES["uploadFile"]["name"];
      			$fileLocation = "attachments/techbinder/" . $fileName;
      			$query = "INSERT INTO filemanager (name, size, fileType, location, refNumber, attachType, addedBy) VALUES
      							('$fileDesc', '$fileSize', '$fileType', '$fileLocation', '$uploadType', '$attachType', '$user')";
      			$result = mysql_query($query) or die(mysql_error());
      			$sysMsg = $portalMsg[4][$lang];
      			}
      		}
      	}
      	
				if($attachType == "clean")
				{
					$taskNum = $_POST['task_num'];
    			if (file_exists("attachments/task/cleanfloorplan/$taskNum/" . $fileName))
    	  	{
    	  		$sysMsg = $_FILES["uploadFile"]["name"] . " " . $portalMsg[12][$lang];
    	  	}
    			else
    	  	{
    	  		if(!is_dir("attachments/task/cleanfloorplan/$taskNum"))
						{
							mkdir("attachments/task/cleanfloorplan/$taskNum");
						}
      			if(move_uploaded_file($_FILES["uploadFile"]["tmp_name"],
      			"attachments/task/cleanfloorplan/$taskNum/" . $fileName))
      			{
      			//echo "Stored in: " . "attachments/customers/$custNum/" . $_FILES["uploadFile"]["name"];
      			$fileLocation = "attachments/task/cleanfloorplan/$taskNum/" . $fileName;
      			$query = "INSERT INTO filemanager (name, size, fileType, location, refNumber, attachType, addedBy) VALUES
      							('$fileDesc', '$fileSize', '$fileType', '$fileLocation', '$taskNum', '$attachType', '$user')";
      			$result = mysql_query($query) or die(mysql_error());
      			$sysMsg = $portalMsg[4][$lang];
      			}
      		}  
      	} 
      	if($attachType == "marked")
				{
					$taskNum = $_POST['task_num'];
    			if (file_exists("attachments/task/markedfloorplan/$taskNum/" . $fileName))
    	  	{
    	  		$sysMsg = $_FILES["uploadFile"]["name"] . " " . $portalMsg[12][$lang];
    	  	}
    			else
    	  	{
    	  		if(!is_dir("attachments/task/markedfloorplan/$taskNum"))
						{
							mkdir("attachments/task/markedfloorplan/$taskNum");
						}
      			if(move_uploaded_file($_FILES["uploadFile"]["tmp_name"],
      			"attachments/task/markedfloorplan/$taskNum/" . $fileName))
      			{
      			//echo "Stored in: " . "attachments/customers/$custNum/" . $_FILES["uploadFile"]["name"];
      			$fileLocation = "attachments/task/markedfloorplan/$taskNum/" . $fileName;
      			$query = "INSERT INTO filemanager (name, size, fileType, location, refNumber, attachType, addedBy) VALUES
      							('$fileDesc', '$fileSize', '$fileType', '$fileLocation', '$taskNum', '$attachType', '$user')";
      			$result = mysql_query($query) or die(mysql_error());
      			$sysMsg = $portalMsg[4][$lang];
      			}
      		}  
      	}    	
    	}
  	}
		else
  	{
  		$sysMsg = "Invalid file";
  	}
	}
	}
	else
	{
		die ('You cannot complete actions on this page. Your activity has been logged.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
	}
	
	if(isset($_GET['action']) && $_GET['action'] == "deleteFile")
	{
		$fileID = $_GET['fileID'];
		$query2 = "SELECT location FROM filemanager WHERE id = '$fileID'";
		$result2 = mysql_query($query2);
		$row2 = mysql_fetch_assoc($result2);
		$fileLoc = $row2['location'];
		$fileName = basename($fileLoc);
		if(file_exists("$fileLoc"))
		{
			rename("$fileLoc", "attachments/trash/$fileName");
			$query3 = "UPDATE filemanager SET publish = 0 WHERE id = '$fileID' LIMIT 1";
			if(mysql_query($query3))
			{
				$sysMsg = $portalMsg[5][$lang] . '<p><a href="'.$_SERVER['HTTP_REFERER'].'">' . $portalMsg[13][$lang] . '</a></p>';
			}
		}
		else
		{
			$sysMsg = "File could not be found. It may have been deleted already.";
		}
	}
	
	if(isset($_GET['action']) && $_GET['action'] == "restoreFile")
	{
		$fileID = $_GET['fileID'];
		$query4 = "SELECT location FROM filemanager WHERE id = '$fileID'";
		$result4 = mysql_query($query4);
		$row4 = mysql_fetch_assoc($result4);
		$fileLoc = $row4['location'];
		$fileName = basename($fileLoc);
		if (file_exists("attachments/trash/$fileName"))
   	{
			rename("attachments/trash/$fileName", "$fileLoc");
			$query5 = "UPDATE filemanager SET publish = -1 WHERE id = '$fileID' LIMIT 1";
			if(mysql_query($query5))
			{
				$sysMsg = $portalMsg[14][$lang] . " " . $fileLoc;
			}
		}
		else
		{
			$sysMsg = $portalMsg[6][$lang];
		}
	}
	
	if(isset($_GET['action']) && $_GET['action'] == "viewTrash")
	{
		if($_SESSION['access'] = 10)
		{
			{
				$query3 = "SELECT * FROM filemanager WHERE publish = 0";
				$result3 = mysql_query($query3);
			}
		}
		else
		{
			$sysMsg = $portalMsg[8][$lang];
		}
	}
	
	if(isset($_GET['action']) && $_GET['action'] == "emptyTrash")
	{
		if($_SESSION['access'] = 10)
		{
			$query3 = "SELECT name, description, location FROM filemanager WHERE publish = 0";
			$result3 = mysql_query($query3);
			while($row3 = mysql_fetch_assoc($result3))
			{
				$fileLoc = $row3['location'];
				$fileName = basename($fileLoc);
				unlink("attachments/trash/" . $fileName);
			}
			$query4 = "DELETE FROM filemanager WHERE publish = 0";
			if($result4 = mysql_query($query4))
			{
				$sysMsg = $portalMsg[5][$lang];
			}
			else
			{
				$sysMsg = mysql_error();
			}
		}
		else
		{
			$sysMsg = $portalMsg[8][$lang];
		}
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>HomeFree Systems | Customer Service Portal - Customer Information</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">

<style type="text/css">
#dhtmltooltip{
position: absolute;
width: 150px;
border: 2px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}
</style>

</head>

<body>
<div id="dhtmltooltip"></div>

<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

</script>

<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="600" align="left">
				<tr>
					<td rowspan="2" valign="bottom" style="padding-bottom:1px;">
					<a href="index.php"><img src="images/logo_home.gif" border="0" width="329" height="65" alt="HomeFree Systems"></a></td>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center" style="padding:0 0 6px 0; height:32px;">
									<table cellspacing="0" cellpadding="1" border="0" style="height:32px;">
										<tr>
											<?php
											echo '<td><font size="2" face="Arial"><strong>'.$message.'</strong><div align="center"><a href="csPortal_Login.php?action=logout">' . $portalMsg[9][$lang] . '</a></div></td>';
											?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="bottom">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
						  		<td><a href="csPortal_Main.php"><img src="images/Home_ButtonOff.gif" border="0" onmouseover="this.src='images/Home_ButtonOver.gif'" onmouseout="this.src='images/Home_ButtonOff.gif'";" height="36" alt="Portal Home"></a></td>
						  		<td><a href="csPortal_Sales.php"><img src="images/Sales_ButtonOff.gif" border="0" onmouseover="this.src='images/Sales_ButtonOver.gif'" onmouseout="this.src='images/Sales_ButtonOff.gif'";" height="36" alt="Sales Home"></a></td>
						  		<td><a href="csPortal_Support.php"><img src="images/Support_ButtonOff.gif" border="0" onmouseover="this.src='images/Support_ButtonOver.gif'" onmouseout="this.src='images/Support_ButtonOff.gif'";" height="36" alt="Support Home"></a></td>							
						  		<?php
						  		if($_SESSION['access'] >= 7) {
									echo "<td><a href=\"csAdmin_Main.php\"><img src=\"images/csAdmin_ButtonActive.gif\" border=\"0\" onmouseover=\"this.src='images/csAdmin_ButtonOver.gif'\" onmouseout=\"this.src='images/csAdmin_ButtonActive.gif'\";\" height=\"36\" alt=\"Portal Admin\"></a></td>";
									}
									?>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<td><img src="images/subnav-left.gif" border="0" width="8" height="28" alt=""></td>
					<td width="100%" style="background-image: url(images/subnav-bg.gif);">

		<!-- sub nav -->
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td align="center">
									<table cellspacing="0" cellpadding="0" border="0" style="height:20px;">
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="0" id="tablist2">
													<tr>
														<td style="color:#3b3d3d;font-size:10px;font-family: verdana;font-weight:bold;"><b>&nbsp;</b></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csAdmin_Users.php" style="font-size:10px;font-family: verdana;">USER ADMIN</a></td>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="csAdmin_Bulletins.php" style="font-size:10px;font-family: verdana;">BULLETIN ADMIN</a></td>
														<?php
														if($_SESSION['access'] >= 10) 
														{
														?>
														<td><img src="images/sep.gif" border="0" width="3" height="28"></td>
														<td style="padding-left:4px;padding-right:4px;"><a href="" style="font-size:10px;font-family: verdana;">PORTAL ADMIN</a></td>
														<?php
														}
														?>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
if((isset($_GET['view']) && ($_GET['view'] == "print")))
{
?>
	<table cellspacing="0" cellpadding="0" border="0" width="550" align="center">
<?php
}
else
{
?>
<table cellspacing="0" cellpadding="0" border="0" width="759" align="center">
<?php
}
?>
	<tr valign="top">
		<td width="550">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
  	<td width="100%" align="center" background="images/menu_gray.gif"><font face="Arial" size="3"><strong>File Management</strong></font></td>
  </tr>
  <tr>
  	<td>
  		<b><i><font face="Arial" size="2" color="Red"><?php echo $sysMsg; ?></font></b></i>
  	</td>
  </tr>
  <tr>
  	<td>
  	<?php
  	if(isset($_POST['action']))
  	{
  		echo "Name: " . $_FILES["uploadFile"]["name"] . "<br />";
    	echo "Type: " . $_FILES["uploadFile"]["type"] . "<br />";
    	echo "Size: " . ceil($_FILES["uploadFile"]["size"] / 1024) . " KB<br />";
    	echo '<div align="center"><hr width="25%"></div>';
			echo '<a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>';
		}
		
		if(isset($_GET['action']) && $_GET['action'] == "viewTrash")
		{
			echo '<div align = "center"><a href="' . $_SERVER['PHP_SELF'] . '?action=emptyTrash" onClick="return confirm(\'Are you sure you want to permanantly delete all files in the trash?\')"><font face="Arial" size="2">Empty</font></a></div>';
			while($row3 = mysql_fetch_array($result3))
			{
				if($row3['attachType'] == "customer") {
					$type = "Customer ";
				}
				elseif($row3['attachType'] == "ticket") {
					$type = "Ticket ";
				}
				$query5 = "SELECT f_name, l_name FROM employees WHERE id = '$row3[addedBy]'";
				$result5 = mysql_query($query5);
				$row5 = mysql_fetch_array($result5);
				$f_owner = $row5['l_name'] . ", " . $row5['f_name'];
				echo '<b><font face="Arial" size="2">Reference:</font></b> ' . $type . $row3['refNumber'] . '<br />';
				echo '<b><font face="Arial" size="2">Owner:</font></b> ' . $f_owner . '<br />';
				echo '<b><font face="Arial" size="2">Date Created:</font></b> ' . $row3['timestamp'] . '<br />';
				echo '<b><font face="Arial" size="2">File Name:</font></b> ' . $row3['name'] . '<br />';
				echo '<b><font face="Arial" size="2">File Location:</font></b> ' . $row3['location'] . '<br />';
				echo '<b><font face="Arial" size="2">File Type:</font></b> ' . $row3['fileType'] . '<br />';
				echo '<b><font face="Arial" size="2">File Size:</font></b> ' . $row3['size'] . ' KB<br />';
				echo '<a href="' . $_SERVER['PHP_SELF'] . '?action=restoreFile&fileID=' . $row3['id'] . '">Restore</a>';
				echo '<div align="center"><hr width="25%"></div>';
			}
			echo '<a href="csAdmin_Main.php">Return</a>';
		}
		?>
		</td>
	</tr>
</table>
  	</td>
  	<?php
  	/**************************** COLUMN LEFT END ***************************/
  	
		/************************** COLUMN RIGHT START **************************/
		?>
 		<td>
			<?php
		if((isset($_GET['view']) && ($_GET['view'] == "print")))
		{
			include 'includes/db_close.inc.php';
		?>
		<td>&nbsp;</td>
		<?php
		}
		else
		{
		
include_once 'rightPane.php';
}
?>
    </td>
    <?php
		/*************************** COLUMN RIGHT END ***************************/
		?>
  </tr>
	<?php
	/***************************** FOOTER START *****************************/
	?>
	<tr>
		<td colspan="2">
			<?php include_once ("./footer.php"); ?>
		</td>
	</tr>
	<?php
	/****************************** FOOTER END ******************************/
	?>
</table>
</body>
</html>