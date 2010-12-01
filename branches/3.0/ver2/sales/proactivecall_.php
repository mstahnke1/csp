<?php
if(!isset($_GET['run']))
{
include 'header.php';
?>
<link rel="stylesheet" type="text/css" href="proactive.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>Proactive Call Center</title>
<?php
}
include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
require_once 'Spreadsheet/Excel/Writer.php';
$uid = $_SESSION['uid'];
$date = date('Y-m-d H:i:s');
$viewyear = date('Y');
$current_year_start = $viewyear.'-01-01';
$current_year_end = $viewyear.'-12-31';
$dateclose1 = strtotime('+1 hour');
$dateclose = date('Y-m-d H:i:s',$dateclose1);
$d2 = date('Y-m-d 00:00:00');
$minusmonth = strtotime('-1 month');
$query10 = "SELECT ID, f_name, l_name, dept, warr_prog FROM employees WHERE ID = '$uid'";
$result10 = mysql_query($query10);
$row10 = mysql_fetch_array($result10);
$curTime = date('H:i:s');
$bgnTime = date('H:i:s', mktime(6, 40, 0, 0, 0, 0));
$endTime = date('H:i:s', mktime(17, 20, 0, 0, 0, 0));
if(isset($_GET['view_table']))
{
	header("Location: proactivecall.php?view=admin&action=viewtable");
}
if(isset($_GET['view_no_schedule']))
{
	header("Location: proactivecall.php?view=admin&action=viewnosch");
}
if(isset($_GET['proactive_home']))
{
	header("Location: proactivecall.php");
}
if((isset($_GET['done2'])) && ($_GET['done2'] == 'Done'))
{
	header("Location: proactivecall.php");
}
if((isset($_GET['rpt'])) && ($_GET['rpt'] == 'Done'))
{
	header("Location: proactivecall.php?view=reports");
}
if((isset($_GET['update_call_tracker'])) && ($_GET['update_call_tracker'] == 'Next'))
{
	mysql_select_db($dbname2);
	$a_date = $_GET['a_date'];
	$callid = $_GET['id_of_call'];
	$trackerid = $_GET['call'];
	if($trackerid <> 0)
	{
	//echo $a_date;
		$query110 = "UPDATE tblproactivescheduletracker SET ActualDate = '$a_date', CallID = '$callid' WHERE ID = '$trackerid'";
		mysql_query($query110) or die(mysql_error());
	}
	header("Location: proactivecall.php");
}
if(isset($_GET['task']))
{
	$procid = $_GET['proid'];
	header("Location: ../task/task.php?q1=q1&proid=$procid");
}
if((isset($_GET['qpage'])) && ($_GET['qpage'] == 'Installation'))
{
	mysql_select_db($dbname2);
	$fid = $_GET['fid'];
	$id = $_GET['id'];
	$install = 1;
	$query13 = "UPDATE tblproactivecall SET Install = '$install' WHERE ID = '$id'";
	mysql_query($query13) or die(mysql_error());
	header("Location: proactivecall.php?view=viewqs&page=plusinstall&fid=$fid&id=$id#A1");
}
//***********************************************************SAVE MESSAGE DETAILS*****************************************//
if((isset($_GET['view'])) && ($_GET['view'] == 'Save Comments'))
{
	mysql_select_db($dbname2);
	$id = $_GET['id'];
	$f_id = $_GET['fid'];
	$details = addslashes($_GET['messagedetails']);
	if($details <> '')
	{
		$query6 = "UPDATE tblproactivecall SET Messagedetails = '$details' WHERE ID = '$id'";
		mysql_query($query6) or die(mysql_error());
		//***********************************************************SAVE AS TICKET*****************************************//		
		$query81 = "SELECT CustomerNumber,ContactName,ContactNumber,Type FROM tblproactivecall WHERE ID = '$id'";
		$result81 = mysql_query($query81);
		$row81 = mysql_fetch_array($result81);
		$cname = $row81['ContactName'];
		$cnumber = $row81['ContactNumber'];
		mysql_select_db($dbname);	
		$query77 = "INSERT INTO tbltickets (CustomerNumber,Contact,ContactPhone,Summary,OpenedBy,DateOpened,Status,DateClosed,ClosedBy,Type) VALUES
		('$f_id','$cname','$cnumber','Proactive Call','$uid','$date','-1','$dateclose','$uid','3')";
		mysql_query($query77) or die(mysql_error());
		$query78 = "SELECT max(ID) FROM tbltickets WHERE CustomerNumber = '$f_id'";
		$result78 = mysql_query($query78) or die (mysql_error());
		$row78 = mysql_fetch_array($result78);
		$curtickid = $row78['max(ID)'];		
		$query79 = "INSERT INTO tblticketmessages (TicketID,Message,EnteredBy,Date) VALUES ('$curtickid','$details','$uid','$date')";	
		mysql_query($query79) or die(mysql_error());	
		//***********************************************************UPDATE CALL SCHEDULE*****************************************//			
		mysql_select_db($dbname2);
		$query7 = "SELECT * FROM tblproactivecallschedule WHERE CustomerNumber = '$f_id'";
		$result7 = mysql_query($query7);
		$count7 = mysql_num_rows($result7);
		$row7 = mysql_fetch_array($result7);
		if(($row7 > 0) && ($row7['Freq'] <> 0))
		{
			$inc = $row7['Freq'];
			$lastcall = strtotime($date);
			$day = date('d',$lastcall);
			$month = date('m',$lastcall);
			$year = date('Y',$lastcall);
			$nextcall1 = mktime(0,0,0, date($month)+$inc,$day,$year); 
			$nextcall = date('Y-m-d 00:00:00', $nextcall1);				
			$query8 = "UPDATE tblproactivecallschedule SET LastCall = '$date',NextCall = '$nextcall' WHERE CustomerNumber = '$f_id'";
			mysql_query($query8) or die(mysql_error());
			if(isset($_GET['tracker']))
			{
				header("Location: proactivecall.php?view=proactivehistory&fid=$f_id");
			}else
			{
				header("Location: proactivecall.php?view=getcall&fid=$f_id&callid=$id&a_date=$date");
			}
		}else
		{
	  	header("Location: proactivecall.php?view=admin&action=addsch&customernumber=$f_id");
	  }
	}else
	{
		header("Location: proactivecall.php?view=newticketformmessage&id=$id&error=1");
	}
}
//***********************************************************SAVE Call Back Date*****************************************//
if((isset($_GET['view'])) && ($_GET['view'] == 'Save'))
{
	mysql_select_db($dbname2);
	$id = $_GET['id'];
	$f_id = $_GET['fid'];
	if(isset($_GET['date1']))
	{
		$calldate = $_GET['date1'];
		$stcalldate = strtotime($calldate);
		$stdate = strtotime($date);
		$formatdate = date('Y-m-d',$stcalldate);
		if($calldate == '')
		{
			header("Location: proactivecall.php?view=newticketformschedule&id=$id&error=2");
		}elseif($calldate < $date)
		{
			header("Location: proactivecall.php?view=newticketformschedule&id=$id&error=3");
		}else
		{
			$query6 = "UPDATE tblproactivecall SET calldate = '$calldate' WHERE ID = '$id'";
			mysql_query($query6) or die(mysql_error());
			//***********************************************************SAVE AS TICKET*****************************************//		
			$query82 = "SELECT CustomerNumber,ContactName,ContactNumber,Type FROM tblproactivecall WHERE ID = '$id'";
			$result82 = mysql_query($query82);
			$row82 = mysql_fetch_array($result82);
			$details = 'Customer Requested a call back on'.' '.$calldate;
			$cname = $row82['ContactName'];
			$cnumber = $row82['ContactNumber'];
			mysql_select_db($dbname);	
			$query83 = "INSERT INTO tbltickets (CustomerNumber,Contact,ContactPhone,Summary,OpenedBy,DateOpened,Status,FollowUp,DateFollowUp,Type)
			 VALUES ('$f_id','$cname','$cnumber','Proactive Call','$uid','$date','0','-1','$formatdate','3')";
			mysql_query($query83) or die(mysql_error());
			$query84 = "SELECT max(ID) FROM tbltickets WHERE CustomerNumber = '$f_id'";
			$result84 = mysql_query($query84) or die (mysql_error());
			$row84 = mysql_fetch_array($result84);
			$curtickid = $row84['max(ID)'];		
			$query85 = "INSERT INTO tblticketmessages (TicketID,Message,EnteredBy,Date) VALUES ('$curtickid','$details','$uid','$date')";	
			mysql_query($query85) or die(mysql_error());
			mysql_select_db($dbname2);	
			//***********************************************************SAVE REFRERENCE TO TICKET*****************************************//
			$query86 = "UPDATE tblproactivecall SET TicketNumber = '$curtickid' WHERE ID = '$id'";
			mysql_query($query86) or die(mysql_error());
			if(isset($_GET['tracker']))
			{
				header("Location: proactivecall.php?view=proactivehistory&fid=$f_id");
			}else
			{
				$query108 = "SELECT * FROM tblproactivecallschedule WHERE CustomerNumber = '$f_id'";
				$result108 = mysql_query($query108);
				$count108 = mysql_num_rows($result108);
				$row108 = mysql_fetch_array($result108);
				if($count108 > 0)
				{
					header("Location: proactivecall.php?view=getcall&fid=$f_id&callid=$id&a_date=$date");
				}else
				{
					header("Location: proactivecall.php?view=admin&action=addsch&customernumber=$f_id");
				}
			}				
		}
	}else
	{
		if(isset($_GET['callback']))
		{
			$callback = 1;
		}else
		{
			$callback = -1;
		}				
		if(isset($_GET['success']))
		{
			$success = 1;
			$callback = 1;
			$remark = 'Called back and filled out the Proactive Customer Survey';
		}else
		{
			$success = -1;
			$remark = 'Called back but was unsuccessful in retrieving the customers thoughts';
		}
		mysql_select_db($dbname2);
		$query6 = "UPDATE tblproactivecall SET callback = '$callback', calledback = '$date',Successful = '$success' WHERE ID = '$id'";
		mysql_query($query6) or die(mysql_error());
		mysql_select_db($dbname2);
		//***********************************************************CLOSING TICKET*****************************************//
		$query87 = "SELECT TicketNumber FROM tblproactivecall WHERE ID = '$id'";
		$result87 = mysql_query($query87);
		$row87 = mysql_fetch_array($result87);
		$tickid = $row87['TicketNumber'];
		mysql_select_db($dbname);
		$query88 = "UPDATE tbltickets SET Status = '-1',DateClosed='$date',ClosedBy='$uid',FollowUp = 0,DateFollowUp = NULL WHERE ID = '$tickid'";
		mysql_query($query88) or die(mysql_error());
		$query89 = "INSERT INTO tblticketmessages (TicketID,Message,EnteredBy,Date) VALUES ('$tickid','$remark','$uid','$date')";	
		mysql_query($query89) or die(mysql_error());	
		mysql_select_db($dbname2);
		$query7 = "SELECT * FROM tblproactivecallschedule WHERE CustomerNumber = '$f_id'";
		$result7 = mysql_query($query7);
		$count7 = mysql_num_rows($result7);
		$row7 = mysql_fetch_array($result7);
		//**********************************************ADD CALL SCHEDULE IF ONE DOES NOT EXIST****************************************//
		if(($row7 > 0) && ($row7['Freq'] <> 0))
		{
			mysql_select_db($dbname2);
			$inc = $row7['Freq'];
			$lastcall = strtotime($date);
			$day = date('d',$lastcall);
			$month = date('m',$lastcall);
			$year = date('Y',$lastcall);
			$nextcall1 = mktime(0,0,0, date($month)+$inc,$day,$year); 
			$nextcall = date('Y-m-d 00:00:00', $nextcall1);				
			$query8 = "UPDATE tblproactivecallschedule SET LastCall = '$date',NextCall = '$nextcall' WHERE CustomerNumber = '$f_id'";
			mysql_query($query8) or die(mysql_error());
			header("Location: proactivecall.php?view=proactivehistory&fid=$f_id");
		}else
		{
	  	header("Location: proactivecall.php?view=admin&action=addsch&customernumber=$f_id");
	  }			
		if($success == 1)
		{ 
			header("Location: proactivecall.php?view=newticketform2&id=$id");
		}else
		{
			//**********************************************UPDATE CALL SCHEDULE TO NEXT CALL DATE****************************************//
			mysql_select_db($dbname2);
			$query7 = "SELECT * FROM tblproactivecallschedule WHERE CustomerNumber = '$f_id'";
			$result7 = mysql_query($query7);
			$count7 = mysql_num_rows($result7);
			$row7 = mysql_fetch_array($result7);
			if(($row7 > 0) && ($row7['Freq'] <> 0))
			{
				$inc = $row7['Freq'];
				$lastcall = strtotime($date);
				$day = date('d',$lastcall);
				$month = date('m',$lastcall);
				$year = date('Y',$lastcall);
				$nextcall1 = mktime(0,0,0, date($month)+$inc,$day,$year); 
				$nextcall = date('Y-m-d 00:00:00', $nextcall1);				
				$query8 = "UPDATE tblproactivecallschedule SET LastCall = '$date',NextCall = '$nextcall' WHERE CustomerNumber = '$f_id'";
				mysql_query($query8) or die(mysql_error());
				header("Location: proactivecall.php?view=proactivehistory&fid=$f_id");
			}else
			{
				//**********************************************ADD CALL SCHEDULE IF ONE DOES NOT EXIST****************************************//
		  	header("Location: proactivecall.php?view=admin&action=addsch&customernumber=$f_id");
		  }	
		}
	}
}
//*****************************************SAVING ADDED QUESTIONS**********************************************//
if(((isset($_GET['add'])) && ($_GET['add'] == 'Add')) && ((isset($_GET['action'])) && ($_GET['action'] == 'addq')))
{
	mysql_select_db($dbname2);
	$q = $_GET['q'];
	$type = $_GET['type'];
	$dept = $_GET['dept'];
	$query33 = "INSERT INTO tblproactivequestions (Question,Type,Dept,Active) VALUES ('$q','$type','$dept',1)";
	mysql_query($query33) or die(mysql_error());
	header("Location: proactivecall.php?view=admin&action=add");
}
//*****************************************SAVING MODIFIED QUESTIONS**********************************************//
if((isset($_GET['action'])) && ($_GET['action'] == 'saveq'))
{
	if((isset($_GET['save'])) && ($_GET['save'] == 'Save'))
	{
		mysql_select_db($dbname2);
		$query38 = "SELECT ID FROM tblproactivequestions";
		$result38 = mysql_query($query38);
		while($row38 = mysql_fetch_array($result38)) 
		{
	    	$id = $row38['ID'];
	    	$question = $_GET[$id];
	      $query39 = "UPDATE tblproactivequestions SET Question = '$question' WHERE ID = '$id'";
	      mysql_query($query39) or die(mysql_error());
	      header("Location: proactivecall.php?view=admin&action=modify");
		}
	}elseif((isset($_GET['done'])) && ($_GET['done'] == 'Done'))
	{
		header("Location: proactivecall.php");
	}
}
//*****************************************SAVING SURVEY QUESTIONS**********************************************//
if((isset($_GET['action'])) && ($_GET['action'] == 'savesurvey'))
{
	mysql_select_db($dbname2);
	$call = $_GET['id'];
	$query47 = "SELECT CustomerNumber,ContactName,ContactNumber,Type FROM tblproactivecall WHERE ID = '$call'";
	$result47 = mysql_query($query47);
	$row47 = mysql_fetch_array($result47);
	$fid = $row47['CustomerNumber'];
	$type = $row47['Type'];
	$cname = $row47['ContactName'];
	$cnumber = $row47['ContactNumber'];
	if((isset($_GET['details'])) && ($_GET['details'] == 1))
	{
		$ticketdetails = addslashes($_GET['ticketdetails']);
		mysql_select_db($dbname);	
		$query77 = "INSERT INTO tbltickets (CustomerNumber,Contact,ContactPhone,Summary,OpenedBy,DateOpened,Status,DateClosed,ClosedBy,Type) VALUES
		('$fid','$cname','$cnumber','Proactive Call','$uid','$date','-1','$dateclose','$uid','3')";
		mysql_query($query77) or die(mysql_error());
		$query78 = "SELECT max(ID) FROM tbltickets WHERE CustomerNumber = '$fid'";
		$result78 = mysql_query($query78) or die (mysql_error());
		$row78 = mysql_fetch_array($result78);
		$curtickid = $row78['max(ID)'];		
		$query79 = "INSERT INTO tblticketmessages (TicketID,Message,EnteredBy,Date) VALUES ('$curtickid','$ticketdetails','2','$date')";	
		mysql_query($query79) or die(mysql_error());
	}else
	{
		$ticketdetails = 'NONE';
	}
	mysql_select_db($dbname2);
	$query48 = "UPDATE tblproactivecall SET CallDetails = '$ticketdetails',Successful = 1 WHERE ID = '$call'";
	mysql_query($query48) or die(mysql_error());
	if($type == 27)
	{
		$type = 1;
	}else
	{
		$type = 2;
	}
	$query45 = "SELECT ID FROM tblproactivequestions WHERE Type = '$type' AND Active = 1";
	$result45 = mysql_query($query45);
	while($row45 = mysql_fetch_array($result45)) 
	{
  	$qid = $row45['ID'];
  	if(isset($_GET[$qid]))
  	{
  		$value = $_GET[$qid];
  	}else
  	{
  		$value=0;
  	}
   	$query46 = "INSERT INTO tblproactiveresults (CallID,QID,Result) VALUES ('$call','$qid','$value')";
    mysql_query($query46) or die(mysql_error());
  }
  $query49 = "SELECT * FROM tblproactivecallschedule WHERE CustomerNumber = '$fid'";
  $result49 = mysql_query($query49);
	$count49 = mysql_num_rows($result49);
	$row49 = mysql_fetch_array($result49);
	$inc = $row49['Freq'];
	if(($count49 > 0) && ($inc <> 0))
	{
		$lastcall = strtotime($date);
		$day = date('d',$lastcall);
		$month = date('m',$lastcall);
		$year = date('Y',$lastcall);
		$nextcall1 = mktime(0,0,0, date($month)+$inc,$day,$year); 
		$nextcall = date('Y-m-d 00:00:00', $nextcall1);
		$query50 = "UPDATE tblproactivecallschedule SET LastCall = '$date', NextCall = '$nextcall' WHERE CustomerNumber = '$fid'";
		mysql_query($query50) or die(mysql_error());
		if(isset($_GET['tracker']))
		{
			header("Location: proactivecall.php?view=viewqs&action=update&id=$call");
		}else
		{
			$query108 = "SELECT * FROM tblproactivecallschedule WHERE CustomerNumber = '$fid'";
			$result108 = mysql_query($query108);
			$count108 = mysql_num_rows($result108);
			$row108 = mysql_fetch_array($result108);
			if($count108 > 0)
			{
				header("Location: proactivecall.php?view=getcall&fid=$fid&callid=$call&a_date=$date");
			}else
			{
				header("Location: proactivecall.php?view=admin&action=addsch&customernumber=$fid");
			}		
		}
	}else
	{
  	header("Location: proactivecall.php?view=admin&action=addsch&customernumber=$fid");
  }	
}
//*****************************************SAVING NEW CALL SCHEDULE**********************************************//
if(((isset($_GET['action'])) && ($_GET['action'] == 'savesch')) && ((isset($_GET['savesch'])) && ($_GET['savesch'] == 'Save')))
{
	mysql_select_db($dbname2);
	$use = $_GET['use'];
	$cust_num = $_GET['fid'];
	$increment = $_GET['increment'];
	if($increment == 1)
	{
		$inc = 3;
	}
	if($increment == 2)
	{
		$inc = 6;
	}
	if($increment == 3)
	{
		$inc = 12;
	}	
	if($use == 1 OR $use == 2)
	{
		if($use == 1)
		{
			$lastdate1 = $_GET['l_date'];
			$lastdate = strtotime($lastdate1);
			$day = date('d',$lastdate);
			$month = date('m',$lastdate);
			$year = date('Y',$lastdate);
			$newdate = mktime(0,0,0, date($month)+$inc, $day, $year);
			$nextcall = date('Y-m-d H:i:s',$newdate);		
		}	
		if($use == 2)
		{
			$lastdate1 = '0000-00-00 00:00:00';
			$nextcall = $_GET['date1'];
			if($nextcall == '')
			{
				$nextcall = $date;
			}else
			{
				$nextcall = $_GET['date1'];
			}
			$nextcall1 = strtotime($nextcall);
			$day = date('d',$nextcall1);
			$month = date('m',$nextcall1);
			$year = date('Y',$nextcall1);
		}
		$query68 = "INSERT INTO tblproactivecallschedule (CustomerNumber,Freq,LastCall,NextCall) VALUES ('$cust_num','$inc','$lastdate1','$nextcall')";
		mysql_query($query68) or die(mysql_error());
		$query93 = "SELECT max(ID) FROM tblproactivecallschedule WHERE CustomerNumber = '$cust_num'";
		$result93 = mysql_query($query93) or die (mysql_error());
		$row93 = mysql_fetch_array($result93);
		$query104 = "SELECT max(ID) FROM tblproactivecall WHERE CustomerNumber = '$cust_num'";
		$result104 = mysql_query($query104) or die (mysql_error());
		$count104 = mysql_num_rows($result104);
		$row104 = mysql_fetch_array($result104);
		$scheduleid = $row93['max(ID)'];	
		$expectedcall1 = strtotime($nextcall);
		if($inc == 12)
		{
			$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		}
		if($inc == 6)
		{
			$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
		}
		if($inc == 3)
		{
			$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40);
		}
		$x = -1;
		if($use == 1)
		{
			if($count104 > 0)
			{
				$callid = $row104['max(ID)'];
				foreach($array as $val)
				{
					$x = $x + 1;
					$inc1 = $inc * $x;
					$newdate1 = mktime(0,0,0, date($month)+$inc1, $day, $year);
					$expectedcall = date('Y-m-d H:i:s',$newdate1);	
					if($x == 0)
					{
						$query94 = "INSERT INTO tblproactivescheduletracker (ScheduleID, ExpectedDate, ActualDate,CallID) VALUES ('$scheduleid','$expectedcall','$lastdate1','$callid')";
						mysql_query($query94) or die(mysql_error());
					}else
					{
						$query94 = "INSERT INTO tblproactivescheduletracker (ScheduleID, ExpectedDate) VALUES ('$scheduleid','$expectedcall')";
						mysql_query($query94) or die(mysql_error());
					}
					$x = $x;
				}											
			}else
			{
				foreach($array as $val)
				{
					$x = $x + 1;
					$inc1 = $inc * $x;
					$newdate1 = mktime(0,0,0, date($month)+$inc1, $day, $year);
					$expectedcall = date('Y-m-d H:i:s',$newdate1);	
					$query94 = "INSERT INTO tblproactivescheduletracker (ScheduleID, ExpectedDate) VALUES ('$scheduleid','$expectedcall')";
					mysql_query($query94) or die(mysql_error());
					$x = $x;
				}	
			}				
		}
		if($use == 2)
		{
				foreach($array as $val)
				{
					$x = $x + 1;
					$inc1 = $inc * $x;
					$newdate1 = mktime(0,0,0, date($month)+$inc1, $day, $year);
					$expectedcall = date('Y-m-d H:i:s',$newdate1);	
					$query94 = "INSERT INTO tblproactivescheduletracker (ScheduleID, ExpectedDate) VALUES ('$scheduleid','$expectedcall')";
					mysql_query($query94) or die(mysql_error());
					$x = $x;
				}				
		}		
		if((isset($_GET['fr'])) && ($_GET['fr'] == 1))
		{		
			header("Location: proactivecall.php?view=admin&action=addsch&fr=1&add=1&customernumber=$cust_num");
		}else
		{
			header("Location: proactivecall.php?view=admin&action=addsch&add=1&customernumber=$cust_num");
		}
	}
	if($use == 3)
	{
		//$query69 = "UPDATE tblproactivecallschedule SET Freq = '$inc' WHERE CustomerNumber = '$cust_num'";
		//mysql_query($query69) or die(mysql_error());
		//header("Location: proactivecall.php?view=admin&action=addsch&up=1&customernumber=$cust_num");
		echo 'PLEASE CONTACT DREW IF YOU SEE THIS MESSAGE';
	}
	if($use == 4)
	{
		$nextcall = $_GET['date1'];	
		$query70 = "UPDATE tblproactivecallschedule SET NextCall = '$nextcall', Freq = '$inc' WHERE CustomerNumber = '$cust_num'";		
		mysql_query($query70) or die(mysql_error());
		$query102 = "SELECT ID FROM tblproactivecallschedule WHERE CustomerNumber = '$cust_num'";
		$result102 = mysql_query($query102) or die (mysql_error());
		$row102 = mysql_fetch_array($result102);
		$scheduleid = $row102['ID'];
		$query103 = "DELETE FROM tblproactivescheduletracker WHERE ScheduleID = '$scheduleid' AND ExpectedDate > '$date' AND CallID IS NULL";
		mysql_query($query103) or die(mysql_error());
		$nextcall1 = strtotime($nextcall);
		$day = date('d',$nextcall1);
		$month = date('m',$nextcall1);
		$year = date('Y',$nextcall1);
		if($inc == 12)
		{
			$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		}
		if($inc == 6)
		{
			$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
		}
		if($inc == 3)
		{
			$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40);
		}
		$x = -1;
		foreach($array as $val)
		{
			$x = $x + 1;
			$inc1 = $inc * $x;
			$newdate1 = mktime(0,0,0, date($month)+$inc1, $day, $year);
			$expectedcall = date('Y-m-d H:i:s',$newdate1);	
			$query94 = "INSERT INTO tblproactivescheduletracker (ScheduleID, ExpectedDate) VALUES ('$scheduleid','$expectedcall')";
			mysql_query($query94) or die(mysql_error());
			$x = $x;
		}		
		header("Location: proactivecall.php?view=admin&action=addsch&up=1&customernumber=$cust_num");
	}
}
if(((isset($_GET['view'])) && ($_GET['view']=='admin')) && ((isset($_GET['action'])) && ($_GET['action'] == 'skipcall')))
{
	mysql_select_db($dbname2);
	$id = $_GET['id'];
	$query108 = "UPDATE tblproactivescheduletracker SET ActualDate = '0000-00-00 00:00:00', CallID = 0 WHERE ID = '$id'";
	mysql_query($query108) or die(mysql_error());
	header("Location: proactivecall.php");
}
if(!(isset($_GET['view'])))
{
	mysql_select_db($dbname2);
	$query20 = "SELECT * FROM tblproactivecall";
	$result20 = mysql_query($query20) or die (mysql_error());
	$count20 = mysql_num_rows($result20);	
	$query21 = "SELECT * FROM tblproactivecall WHERE Message = -1";
	$result21 = mysql_query($query21) or die (mysql_error());
	$count21 = mysql_num_rows($result21);
	$query22 = "SELECT * FROM tblproactivecall WHERE Successful = 1";
	$result22 = mysql_query($query22) or die (mysql_error());
	$count22 = mysql_num_rows($result22);
	$plusmonth1 = strtotime("+1 month");
	$plusmonth = date('Y-m-d 23:59:59',$plusmonth1);
	$query23 = "SELECT * FROM tblproactivescheduletracker WHERE ExpectedDate < '$plusmonth' AND ExpectedDate > '$d2' ORDER BY ExpectedDate";
	$result23 = mysql_query($query23) or die (mysql_error());		
	$count23 = mysql_num_rows($result23);	
	$query29 = "SELECT * FROM tblproactivescheduletracker WHERE ExpectedDate < '$d2' AND ExpectedDate > '$current_year_start' ORDER BY ExpectedDate";
	$result29 = mysql_query($query29) or die (mysql_error());		
	$count29 = mysql_num_rows($result29);		
	$query24 = "SELECT * FROM tblproactivecall WHERE Successful = -1";
	$result24 = mysql_query($query24) or die (mysql_error());
	$count24 = mysql_num_rows($result24);	
	$query25 = "SELECT * FROM tblproactivecall WHERE Message = 2 AND callback = -1 AND Successful = -1 AND calldate > '$current_year_start' ORDER BY callback";
	$result25 = mysql_query($query25) or die (mysql_error());	
	mysql_select_db($dbname2);
	$query27 = "SELECT CustomerNumber FROM tblproactivecallschedule";
	$result27 = mysql_query($query27) or die (mysql_error()); 
	$count27 = mysql_num_rows($result27);	
	$query28 = "SELECT FacilityID,comptime FROM epc_calendar WHERE comptime > 0 ORDER BY comptime DESC";
	$result28 = mysql_query($query28) or die (mysql_error()); 		
	$x=0;	
	while($row27 = mysql_fetch_array($result27))
	{
		$x = $x;
		$cust = $row27['CustomerNumber'];
		mysql_select_db($dbname);
		$query26 = "SELECT CustomerNumber FROM tblfacilities WHERE Active <> 0 AND CountryCode = 'US'";
		$result26 = mysql_query($query26) or die (mysql_error()); 
		$count26 = mysql_num_rows($result26);	
		$row26 = mysql_fetch_array($result26);
		$cust1 = $row26['CustomerNumber'];
		if($cust = $cust1)
		{
			$x = $x+1;
		}
	}
	$y = $count26 - $x;
?>
	<table width="750">
		<tr>
			<td align="center" class="bigheading" colspan="3">
				Proactive Call Center
			</td>
		</tr>	
	</table>
	<table>
		<tr>
			<td valign="top">
				<table width="120">
					<tr>
						<td>
							<a href="proactivecall.php?view=newticket&history=1"><img src="images/viewcustomerhistory.gif" border="0" onmouseover="this.src='images/viewcustomerhistorymouseover.gif'" onmouseout="this.src='images/viewcustomerhistory.gif'";" alt="Click to view customer history."></a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="proactivecall.php?view=newticket"><img src="images/newticket.gif" border="0" onmouseover="this.src='images/newticketmouseover.gif'" onmouseout="this.src='images/newticket.gif'";" alt="Click to add a call."></a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="proactivecall.php?view=reports"><img src="images/reports.gif" border="0" onmouseover="this.src='images/reportsmouseover.gif'" onmouseout="this.src='images/reports.gif'";" alt="Click to go to Reports."></a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="proactivecall.php?view=admin"><img src="images/admin.gif" border="0" onmouseover="this.src='images/adminmouseover.gif'" onmouseout="this.src='images/admin.gif'";" alt="Click to go to Administration."></a>
						</td>
					</tr>					
				</table>
			</td>
			<td valign="top">
				<table width="250">
					<tr>
						<td class="heading">
							Total Proactive Calls Initiated:
						</td>
						<td>
							<?php echo $count20; ?>
						</td>
					</tr>
					<tr>
						<td class="heading">
							Successful Calls:
						</td>
						<td>
							<?php echo ($count22); ?>
						</td>
					</tr>
					<tr>
						<td class="heading">
							Unsuccessful Calls:
						</td>
						<td>
							<?php echo $count24; ?>
						</td>
					</tr>	
					<tr>
						<td>
							&nbsp;
						</td>
					</tr>	
					<tr>
						<td align="center">
							<a href="topten.php">Top 10 Analyzer											
						</td>
					</tr>
				</table>
			</td>
			<td valign="top">
				<table>
					<tr>
						<td class="heading" colspan="2">
							Active Customers:
						</td>
						<td>
							<?php echo $count26; ?>
						</td>
					</tr>
					<tr>
						<td class="heading" colspan="2">
							Customers without Proactive Schedule:
						</td>
						<td>
							<?php echo $y; ?>
						</td>
					</tr>
				</table>
				<table>		
					<tr>
						<td>
							<a href="proactivecall.php?view=admin&action=viewnosch">View Customers without Schedule
						</a></td>
					</tr>	
					<tr>
						<td>
							<a href="proactivecall.php?view=admin&action=viewtable">View Schedule Table
						</a></td>
					</tr>															
				</table>
			</td>
		</tr>
	</table>	
	<table align="left">
		<tr>
			<td valign="top" class="border" width="370">
				<table>
					<tr>
						<td class="heading" colspan="3">
							Scheduled calls (nearest 10):
						</td>	
					</tr>
<?php			
						mysql_select_db($dbname);
						$q = 0;
						while($row23 = mysql_fetch_array($result23))
						{						
							if($q < 10)
							{
								mysql_select_db($dbname2);
								$scheduleid = $row23['ScheduleID'];
								$query106 = "SELECT CustomerNumber FROM tblproactivecallschedule WHERE ID = '$scheduleid'";
								$result106 = mysql_query($query106) or die (mysql_error());
								$row106 = mysql_fetch_array($result106);
								$customernumber = $row106['CustomerNumber'];	
								$schdate = strtotime($row23['ExpectedDate']);
								$trackid = $row23['ID'];
								$callid = $row23['CallID'];
								if(is_null($callid))
								{
									$q = $q + 1;
									mysql_select_db($dbname);
									$query31 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$customernumber'";
									$result31 = mysql_query($query31) or die (mysql_error());	
									while($row31 = mysql_fetch_array($result31))
									{
										$fid=$row31['CustomerNumber'];
										$active_check = $row31['Active'];
										if($active_check == '-1')
										{										
?>	
											<tr>
												<td>						
													<?php	echo $row31['FacilityName']; ?>
												</td>
												<td width="120">
													<?php echo date('F d, Y',$schdate); ?>
												</td>
												<td width="60">
													<?php echo '<a href="' . 'proactivecall.php?view=newticketform&f_id='.$fid.'&tracker='.$trackid.'">' ?> Start Call </a>
												</td>
											</tr>
											<tr>
												<td colspan="4"><div><hr width="100%"></div></td>
											</tr>																
<?php														
										}
									}
								}
							} 
						}
?>
				</table>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td valign="top" class="border">
				<table>
					<tr>
						<td class="heading" colspan="2">
							Recently Completed Installs:
						</td>
					</tr>
<?php
							while($row28 = mysql_fetch_array($result28))
							{
								$id = $row28['FacilityID'];
								mysql_select_db($dbname2);
								$query34 = "SELECT * FROM tblproactivecall WHERE CustomerNumber = '$id'";
								$result34 = mysql_query($query34) or die (mysql_error());	
								$count34 = mysql_num_rows($result34);
								$comptime = strtotime($row28['comptime']);
								$compdate = date('F d, Y',$comptime);
								if($count34 < 1)
								{
									if($comptime > $minusmonth)
									{
										mysql_select_db($dbname);
										$query33 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$id'";
										$result33 = mysql_query($query33) or die (mysql_error());	
										$row33 = mysql_fetch_array($result33);
?>
										<tr>
											<td width="240">
												<?php echo $row33['FacilityName']; ?>
											</td>
											<td width="120">
												<?php echo $compdate; ?>
											</td>
										</tr>
										<tr>
											<td colspan="2"><div><hr width="100%"></div></td>
										</tr>
<?php							
									}
								}	
							}	
?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</table>
	<table align="center" width="750">
		<tr>
			<td valign="top" class="border" width="750">
				<table width="750">
					<tr>
						<td class="heading" colspan="2">
							Over Due calls (current year):
						</td>
					</tr>
<?php			
						while($row29 = mysql_fetch_array($result29))
						{
							mysql_select_db($dbname2);
							$scheduleid = $row29['ScheduleID'];
							$callid = $row29['CallID'];
							$query106 = "SELECT CustomerNumber FROM tblproactivecallschedule WHERE ID = '$scheduleid'";
							$result106 = mysql_query($query106) or die (mysql_error());
							$row106 = mysql_fetch_array($result106);
							$customernumber = $row106['CustomerNumber'];	
							$schdate = strtotime($row29['ExpectedDate']);
							$trackid = $row29['ID'];
							if(is_null($callid))
							{
								mysql_select_db($dbname);
								$query31 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$customernumber'";
								$result31 = mysql_query($query31) or die (mysql_error());		
								while($row31 = mysql_fetch_array($result31))
								{
									$fid=$row31['CustomerNumber'];
									$active_check = $row31['Active'];
									if($active_check == '-1')
									{
?>	
										<tr>
											<td><font color="#FF0000">						
												<?php	echo $row31['FacilityName']; ?>
											</font></td>
											<td>
												<?php echo date('F d, Y',$schdate); ?>
											</td>
											<td>
												<?php echo '<a href="' . 'proactivecall.php?view=proactivehistory&fid='.$fid.'">' ?> Customer History </a>
											</td>											
											<td>
												<?php echo '<a href="' . 'proactivecall.php?view=newticketform&f_id='.$fid.'&tracker='.$trackid.'">' ?> Start Call </a>
											</td>
											<td>
												<?php echo '<a href="' . 'proactivecall.php?view=admin&action=addsch&customernumber='.$fid.'">' ?> Update Schedule </a>
											</td>
											<td>
												<?php echo '<a href="' . 'proactivecall.php?view=admin&action=skipcall&id='.$trackid.'">' ?> Skip Call </a>
											</td>									
										</tr>
										<tr>
											<td colspan="5"><div><hr width="100%"></div></td>
										</tr>																
<?php														
									}
								}
							} 
						}
?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>	
	<table width="750" align="center">
		<tr>
			<td class="border">
				<table>
					<tr>
						<td class="heading" colspan="3">
							Follow-Ups Scheduled (current year):
						</td>	
					</tr>
<?php											
						while($row25 = mysql_fetch_array($result25))
						{
							mysql_select_db($dbname);
							$customernumber = $row25['CustomerNumber'];	
							$id = $row25['ID'];
							$schdate = strtotime($row25['calldate']);
							$query32 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$customernumber'";
							$result32 = mysql_query($query32) or die (mysql_error());		
							while($row32 = mysql_fetch_array($result32))
							{
								$fid=$row32['CustomerNumber'];
?>	
								<tr>
									<td>							
										<?php	echo $row32['FacilityName']; ?>
									</td>
									<td>
										<?php echo date('F d, Y H:i:s',$schdate); ?>
									</td>									
									<td>
										<?php echo '<a href="' . 'proactivecall.php?view=viewticket&trackerid=0&action=update&a=2&id='.$id.'">' ?> Update Call </a>
									</td>
								</tr>
								<tr>
									<td colspan="4"><div><hr width="100%"></div></td>
								</tr>								
<?php														
							}
						} 							
?>
				</table>
			</td>
		</tr>
	</table>	
<?php
}
if((isset($_GET['view'])) && ($_GET['view'] == 'newticket'))
{
?>	
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width="750">
<?php
		if(isset($_GET['history']))
		{
			echo	'<input type = "hidden" name="history" value = "history">';
		}
		if(isset($_GET['xf_id']))
		{
			$xf_id = $_GET['xf_id'];
?>
			<tr>
				<td colspan="3" class="heading"><font color="#ff0000">
<?php					
					echo 'Customer Number '. $xf_id.' Does Not Exist Please Enter A valid Number or Search by Facility Name';
?>					
				</font></td>
			</tr>
<?php
		}
		if(isset($_GET['xfname']))
		{
			$xfname = $_GET['xfname'];
?>
			<tr>
				<td colspan="3" class="heading"><font color="#ff0000">
<?php					
					echo 'No Records Found for '. $xfname.' Please try another name';
?>					
				</font></td>
			</tr>
<?php
		}		
?>								
		
			<tr>	
				<td class="heading">
					Search by Facility Name:
				</td>
				<td>
					<input type="text" size="20" maxlength="20" name="custname" value="">
				</td>
				<td>
					<input type="submit" value="Lookup" name="view">
				</td>				
			</tr>
	</form>
	<form method="GET" NAME="example1" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<tr>
				<td class="heading" width="180">
					Enter Customer Number:
				</td>
				<td width="150">
					<input type="text" size="20" maxlength="6" name="custnum" value="">
				</td>				
				<td>
<?php
if(isset($_GET['history']))
{
					echo	'<input type = "hidden" name="history" value = "history">';
				}
					echo	'<input type = "hidden" name="view" value = "lookup">';
?>										
					<input type="submit" value="Lookup" name="view">
				</td>
			</tr>
		</table>
	</form>				
<?php
}
if(isset($_GET['custname']))
{
	$fname=addslashes($_GET['custname']);
	mysql_select_db($dbname);
	$query = "SELECT * FROM tblfacilities WHERE FacilityName LIKE '%$fname%' AND Active = -1 ORDER BY FacilityName";
	$result = mysql_query($query) or die (mysql_error());
	$num = mysql_num_rows($result);
	if($num > 0)
	{
		if(!(isset($_GET['history'])))
		{
			while($row = mysql_fetch_array($result))
			{		
				echo '<tr><td><font face="Arial" size="2"><a href="' . 'proactivecall.php?view=newticketform&f_id='. $row['CustomerNumber'].'">'. $row['FacilityName'].'</a>'. ' </font></td></tr>';
			}
		}else
		{
			while($row = mysql_fetch_array($result))
			{	
				echo '<tr><td><font face="Arial" size="2"><a href="' . 'proactivecall.php?view=proactivehistory&fid='. $row['CustomerNumber'].'">'. $row['FacilityName'].'</a>'. ' </font></td></tr>';
			}
		}
	}else
	{
		header("Location: proactivecall.php?view=newticket&xfname=$fname");
	}
}
if(isset($_GET['custnum']))
{
	$custnum = $_GET['custnum'];
	mysql_select_db($dbname);
	$query1 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$custnum'";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_num_rows($result1);
	if($row1 > 0)
	{
		if(isset($_GET['history']))
		{		
			header("Location: proactivecall.php?view=proactivehistory&fid=$custnum");	
		}else
		{
			header("Location: proactivecall.php?view=newticketform&f_id=$custnum");
		}
	}else
	{
		header("Location: proactivecall.php?view=newticket&xf_id=$custnum");
	}
}
if((isset($_GET['view'])) && ($_GET['view'] == 'newticketform'))
{
	$custnum = $_GET['f_id'];
	mysql_select_db($dbname);
	$query1 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$custnum'";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_fetch_array($result1);	
	mysql_select_db($dbname2);
	$query40 = "SELECT * FROM tbltype WHERE proactive = 1 ORDER BY Type DESC";
	$result40 = mysql_query($query40) or die (mysql_error());
	//$query101 = "SELECT ID FROM tblproactivecallschedule WHERE CustomerNumber = '$custnum'";
	//$result101 = mysql_query($query101) or die (mysql_error());
	//$count101 = mysql_num_rows($result101);
	//if($count101 > 0)
	//{
?>
		<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<table width="750">
				<tr>
					<td class="heading">
						<?php echo $row1['FacilityName']; ?>
					</td>
				</tr>
				<tr>
					<td>
						Type:
					</td>
<?php	
					if(isset($_GET['tracker']))
					{
						$tracker = $_GET['tracker'];
						echo	'<input type = "hidden" name="tracker" value = "'.$tracker.'">'; 
					} 						
					if(!isset($_GET['type']))
					{
?>					
						<td>
							<select name="type">
<?php
							while($row40 = mysql_fetch_array($result40))
							{
?>							
								<option value="<?php echo $row40['ID']; ?>">  <?php echo $row40['Type']; ?> </option>
<?php							
							}
							echo	'<input type = "hidden" name="f_id" value = "'.$custnum.'">'; 
							echo	'<input type = "hidden" name="view" value = "newticketform">'; 
?>						
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" value="Go" name="">
						</td>	
					</tr>						
<?php		
					}else
					{
						$typeid = $_GET['type'];
						$query42 = "SELECT Type FROM tbltype WHERE ID = '$typeid'";
						$result42 = mysql_query($query42) or die (mysql_error());
						$row42 = mysql_fetch_array($result42);	
						echo '<td>'.$row42['Type'].'</td><tr>';
					}					
					if(isset($_GET['type']))
					{
						$type = $_GET['type'];
?>
						<tr>
							<td>
								Contact:
							</td>
							<td>
								<input type="text" size="40" maxlength="40" name="contactname" value="">
							</td>
							<td>
								Phone Number Called:
							</td>
							<td>
								<input type="text" size="10" maxlength="10" name="contactnumber" value="">
							</td>				
						</tr>
						<tr>
							<td>
								Left message or voice mail.
							</td>
							<td>
								<input type="radio" name="vmail" value="1">
							</td>
						</tr>
						<tr>
							<td colspan="1">
								Customer Requested a call back.
							</td>
							<td>
								<input type="radio" name="vmail" value="2">
							</td>
						</tr>			
<?php
						echo	'<input type = "hidden" name="f_id" value = "'.$custnum.'">'; 
						echo	'<input type = "hidden" name="type" value = "'.$type.'">';
						if(isset($_GET['tracker']))
						{
							$tracker = $_GET['tracker'];
							echo	'<input type = "hidden" name="tracker" value = "'.$tracker.'">'; 
						} 						
?>						
						<tr>
							<td>
								<input type="submit" value="Continue" name="view">
							</td>
						</tr>
					</table>
				</form>
<?php	
		}
	//}else
	//{
	//	echo 'A schedule does not exist for this customer, a schedule is required to enter a call <a href="' . '../sales/proactivecall.php?view=admin&action=addsch&customernumber='.$custnum.'">'.' Add a Schedule Now'. '</a>';
	//}
}
if((isset($_GET['view'])) && ($_GET['view'] == 'Continue'))
{
	mysql_select_db($dbname2);
	$custnum = $_GET['f_id'];
	$name = $_GET['contactname'];
	$number = $_GET['contactnumber'];
	if(isset($_GET['vmail']))
	{ 
 		if($_GET['vmail'] == 1)
		{
			$message = 1;
		}elseif($_GET['vmail'] == 2)
		{
			$message = 2;
		}
	}else
	{
		$message = -1;
	}
	$callback = '0000-00-00 00:00:00';
	$calledback = '0000-00-00 00:00:00';
	$type = $_GET['type'];
	$query2 = "INSERT INTO tblproactivecall (CustomerNumber,ContactName,ContactNumber,DateOpened,Message,calldate,calledback,Type) VALUES ('$custnum',
						'$name','$number','$date','$message','$callback','$calledback','$type')";
	mysql_query($query2) or die(mysql_error());
	$query4 = "SELECT max(ID) FROM tblproactivecall";
	$result4 = mysql_query($query4) or die (mysql_error());
	$row4 = mysql_fetch_array($result4);
	$currentid = $row4['max(ID)'];	
	if(isset($_GET['tracker']))
	{
		$trackerid = $_GET['tracker'];
		$query107 = "UPDATE tblproactivescheduletracker SET ActualDate = '$date', CallID = '$currentid' WHERE ID = '$trackerid'";
		mysql_query($query107) or die(mysql_error());
		if($message == 1)
		{
			header("Location: proactivecall.php?view=newticketformmessage&tracker=$trackerid&id=$currentid");
		}elseif($message == 2)
		{
			header("Location: proactivecall.php?view=newticketformschedule&tracker=$trackerid&id=$currentid");
		}else
		{
			header("Location: proactivecall.php?view=newticketform2&tracker=$trackerid&id=$currentid");
		}		
	}else
	{
		if($message == 1)
		{
			header("Location: proactivecall.php?view=newticketformmessage&id=$currentid");
		}elseif($message == 2)
		{
			header("Location: proactivecall.php?view=newticketformschedule&id=$currentid");
		}else
		{
			header("Location: proactivecall.php?view=newticketform2&id=$currentid");
		}			
	}
}
if((isset($_GET['view'])) && (($_GET['view'] == 'newticketformmessage') || ($_GET['view'] == 'newticketform2') || ($_GET['view'] == 'viewqs') || ($_GET['view'] == 'newticketformschedule')))
{
	if(isset($_GET['error']))
	{
		if($_GET['error'] == 1)
		{
			$message = 'Please enter the details of the message left by the customer';
		}
		if($_GET['error'] == 2)
		{
			$message = 'Please enter the date requested to call back';
		}
		if($_GET['error'] == 3)
		{
			$message = 'Call Back Date must be Later than Todays Date';
		}		
	}
	mysql_select_db($dbname2);
	$id = $_GET['id'];
	$query3 = "SELECT * FROM tblproactivecall WHERE ID = '$id'";
	$result3 = mysql_query($query3) or die (mysql_error());
	$row3 = mysql_fetch_array($result3);	
	$f_id = $row3['CustomerNumber'];
	mysql_select_db($dbname);
	$query5 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_fetch_array($result5);	

?>
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width="750">
			<tr>
				<td colspan="5" class="heading"><font color="#FF0000"> 
<?php
				if(isset($_GET['error']))
				{
					echo $message;
				}
?>			
				</font></td>
			</tr>
			<tr>
				<td class="bigheading" align="center" colspan="4">
					<?php echo $row5['FacilityName']; ?>
				</td>
			</tr>
			<tr>
				<td class="heading" width="120">
					Contact Name:
				</td>				
				<td>
					<?php echo $row3['ContactName']; ?>
				</td>
			</tr>
			<tr>
				<td class="heading">
					Contact Number:
				</td>				
				<td>
					<?php echo formatPhone($row3['ContactNumber']); ?>
				</td>
			</tr>
			<tr>
				<td class="heading">
					Date Opened:
				</td>				
				<td>
					<?php echo $row3['DateOpened']; ?>
				</td>				
			</tr>	
		</table>	
<?php
			if((isset($_GET['view'])) && ($_GET['view'] == 'newticketformmessage'))
			{	
?>			<table width="750">
					<tr>
						<td class="heading">
							Message Details:
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<textarea rows="6" cols="80" name="messagedetails"></textarea>
						</td>			
					</tr>
<?php
					echo	'<input type = "hidden" name="id" value = "'.$id.'">'; 
					echo	'<input type = "hidden" name="fid" value = "'.$f_id.'">'; 
					if(isset($_GET['tracker']))
					{
						$tracker = $_GET['tracker'];
						echo	'<input type = "hidden" name="tracker" value = "'.$tracker.'">'; 
					}					
?>				
					<tr>
						<td>
							<input type="submit" value="Save Comments" name="view">
						</td>
					</tr>		
				</table>
			</form>
	<?php	
			}
			if((isset($_GET['view'])) && ($_GET['view'] == 'newticketformschedule'))
			{	
?>	
				<table>
					<tr>
						<td class="heading">
							Call Back Requested:	
						</td>
						<td>
							<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
							<SCRIPT LANGUAGE="JavaScript">
							var cal = new CalendarPopup();
							</SCRIPT>
							<INPUT TYPE="text" NAME="date1" VALUE="" SIZE=25>
						</td>
						<td>
							<A HREF="#"
							onClick="cal.select(document.forms['example'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
							NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
						</td>
					</tr>
<?php
					echo	'<input type = "hidden" name="id" value = "'.$id.'">'; 
					echo	'<input type = "hidden" name="fid" value = "'.$f_id.'">'; 
					if(isset($_GET['tracker']))
					{
						$tracker = $_GET['tracker'];
						echo	'<input type = "hidden" name="tracker" value = "'.$tracker.'">'; 
					}					
?>					
					<tr>
						<td>
							<input type="submit" value="Save" name="view">
						</td>
					</tr>							
				</table>
			</form>
<?php	
			}					
	if((isset($_GET['view'])) && ($_GET['view'] == 'newticketform2'))
	{
		if($row3['Type'] == 27)
		{
			mysql_select_db($dbname2);
			$query43 = "SELECT * FROM tblproactivequestions WHERE Type = 1";
			$result43 = mysql_query($query43) or die (mysql_error());	 
?>
			<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<table>
					<tr>
						<td class="heading">
							Details? <input type="checkbox" name="details" value="1">
						</td>
					</tr>
					<tr>
						<td class="heading">
							Ticket Details:
						</td>
					</tr>
					<tr>
						<td>
							<textarea rows="6" cols="90" name="ticketdetails"></textarea>
						</td>
					</tr>
				</table>					

<?php 
			while($row43 = mysql_fetch_array($result43)) 
			{
?>						
				<table width="750">
					<tr>
						<td class="border">
							<table width="750">
								<tr>
									<td colspan="7" class="heading">
										<?php	echo $row43['Question']; ?>
									</td>
								</tr>
								<tr>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="1">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="2">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="3">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="4">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="5">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="6">
									</td>																																								
								</tr>	
								<tr>
									<td align="center">
										Needs Improvement
									</td>
									<td align="center">
										Below Average
									</td>
									<td align="center">
										Average
									</td>
									<td align="center">
										Above Average
									</td>
									<td align="center">
										Very Impressive
									</td>
									<td align="center">
										Outstanding
									</td>	
								</tr>
							</table>	
						</td>
					</tr>
				</table>																																										
<?php							
			}
			echo	'<input type = "hidden" name="id" value = "'.$id.'">'; 
			echo	'<input type = "hidden" name="action" value = "savesurvey">';
			echo	'<input type = "hidden" name="view" value = "next">';
			if(isset($_GET['tracker']))
			{
				$tracker = $_GET['tracker'];
				echo	'<input type = "hidden" name="tracker" value = "'.$tracker.'">'; 
			}			
?>
			<table>
				<tr>
					<td>
						<input type="submit" value="Save" name="save">
					</td>
				</tr>
			</table>
			</form>							
<?php
		}elseif($row3['Type'] == 15)
		{
			mysql_select_db($dbname2);
			$query43 = "SELECT * FROM tblproactivequestions WHERE Type = 2";
			$result43 = mysql_query($query43) or die (mysql_error());	 
?>
			<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<table>
					<tr>
						<td class="heading">
							Details? <input type="checkbox" name="details" value="1">
						</td>
					</tr>
					<tr>
						<td class="heading">
							Ticket Details:
						</td>
					</tr>
					<tr>
						<td>
							<textarea rows="6" cols="90" name="ticketdetails"></textarea>
						</td>
					</tr>
				</table>			

<?php 
			while($row43 = mysql_fetch_array($result43)) 
			{
?>					
				<table>	
					<tr>
						<td class="border">
							<table width="750">
								<tr>
									<td colspan="7" class="heading">
										<?php	echo $row43['Question']; ?>
									</td>
								</tr>
								<tr>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="1">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="2">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="3">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="4">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="5">
									</td>
									<td align="center">
										<input type="radio" name="<?php echo $row43['ID'];?>" value="6">
									</td>																																								
								</tr>	
								<tr>
									<td align="center">
										Needs Improvement
									</td>
									<td align="center">
										Below Average
									</td>
									<td align="center">
										Average
									</td>
									<td align="center">
										Above Average
									</td>
									<td align="center">
										Very Impressive
									</td>
									<td align="center">
										Outstanding
									</td>	
								</tr>
							</table>	
						</td>
					</tr>
				</table>																																										
<?php							
			}
			echo	'<input type = "hidden" name="id" value = "'.$id.'">'; 
			echo	'<input type = "hidden" name="action" value = "savesurvey">';
			echo	'<input type = "hidden" name="view" value = "next">';
?>
			<table>
				<tr>
					<td>
						<input type="submit" value="Save" name="save">
					</td>
				</tr>
			</table>
			</form>							
<?php			
		}
	}
	//*********************************************VIEW COMPLETE SURVEY********************************************//
	if((isset($_GET['view'])) && ($_GET['view'] == 'viewqs'))
	{	
		if(!(($row3['CallDetails'] == 'NONE') OR (is_null($row3['CallDetails']))))
		{
?>
			<table>
				<tr>
					<td class="heading">
						Call Details:
					</td>
				</tr>
				<tr>
					<td>
						<?php echo nl2br($row3['CallDetails']); ?>
					</td>
				</tr>
			</table>
<?php	
		}
			mysql_select_db($dbname2);
			$query49="SELECT * FROM tblproactiveresults WHERE CallID='$id'";
			$result49 = mysql_query($query49) or die (mysql_error());			
			while($row49 = mysql_fetch_array($result49)) 
			{
				$qid = $row49['QID'];
				$query43 = "SELECT * FROM tblproactivequestions WHERE ID = '$qid'";
				$result43 = mysql_query($query43) or die (mysql_error());	 
?>						
				<table width="750">
					<tr>
						<td class="border">
<?php
						while($row43 = mysql_fetch_array($result43))
						{
?>							
							<table width="750">
								<tr>
									<td colspan="7" class="heading">
										<?php	echo $row43['Question']; ?>
									</td>
								</tr>																								
									<tr>
										<td align="center">
											<?php if($row49['Result']==1) { echo '<b>'.'Needs Improvement'.'</b>'; }else { echo '<font color="#c0c0c0">'.'Needs Improvement'.'</font>'; } ?>
										</td>
										<td align="center">
											<?php if($row49['Result']==2) { echo '<b>'.'Below Average'.'</b>'; }else { echo '<font color="#c0c0c0">'.'Below Average'.'</font>'; } ?>
										</td>
										<td align="center">
											<?php if($row49['Result']==3) { echo '<b>'.'Average'.'</b>'; }else { echo '<font color="#c0c0c0">'.'Average'.'</font>'; } ?>
										</td>
										<td align="center">
											<?php if($row49['Result']==4) { echo '<b>'.'Above Average'.'</b>'; }else { echo '<font color="#c0c0c0">'.'Above Average'.'</font>'; } ?>
										</td>
										<td align="center">
											<?php if($row49['Result']==5) { echo '<b>'.'Very Impressive'.'</b>'; }else { echo '<font color="#c0c0c0">'.'Very Impressive'.'</font>'; } ?>
										</td>
										<td align="center">
											<?php if($row49['Result']==6) { echo '<b>'.'Outstanding'.'</b>'; }else { echo '<font color="#c0c0c0">'.'Outstanding'.'</font>'; } ?>
										</td>	
									</tr>
								</table>
<?php
								}
?>																	
								
						</td>
					</tr>
				</table>																																										
<?php							
			}
?>
			<table>
				<tr>
					<td>
<?php 								
 						echo '<input type="submit" value="Done" name="done2">';
 						echo	'<input type = "hidden" name="proid" value='.$id.'>';
?> 
					</td>
					<td>
						<input type="submit" value="Create a Task" name="task">
					</td>
				</tr>
			</table>

<?php				
			if($row3['TaskID'] <> '-1')
			{
				$taskid = $row3['TaskID'];
				$query90 = "SELECT ID,Type FROM taskinfo WHERE ID = '$taskid'";
				$result90 = mysql_query($query90) or die (mysql_error());	
				$row90 = mysql_fetch_array($result90);
				$type90 = $row90['Type'];
?>
				<table>
					<tr>	
						<td class="border">
							<table width="750">
								<tr>
									<td valign="top">
										View Related Tasks
									</td>
								</tr>	
								<tr>
									<td>
										<a href="../task/task.php?view=update&type=<?php echo $type90; ?>&taskid=<?php echo $taskid; ?>"><?php echo $taskid; ?></a>
							</table>		
						</td>		
					</tr>
				</table>					
<?php											
			}			
		}		
}
//***********************************************************VIEW SPECIFIC CUSTOMER PROACTIVE HISTORY*****************************************//
if((isset($_GET['view'])) && ($_GET['view'] == 'proactivehistory'))
{
	mysql_select_db($dbname2);
	$fid = $_GET['fid'];
	$query7 = "SELECT * FROM tblproactivecall WHERE CustomerNumber = '$fid' ORDER BY DateOpened DESC";
	$result7 = mysql_query($query7) or die (mysql_error());
	$count7 = mysql_num_rows($result7);
	$query19 = "SELECT * FROM tblproactivecall WHERE CustomerNumber = '$fid' AND Successful = 1";
	$result19 = mysql_query($query19) or die (mysql_error());
	$count19 = mysql_num_rows($result19);	
	$query15 = "SELECT * FROM tblproactivecall WHERE CustomerNumber = '$fid' AND Message = 1 AND callback = -1";
	$result15 = mysql_query($query15) or die (mysql_error());	
	$count15 = mysql_num_rows($result15);	
	$query18 = "SELECT * FROM tblproactivecall WHERE CustomerNumber = '$fid' AND Message = 1 AND callback = 1";
	$result18 = mysql_query($query18) or die (mysql_error());
	$count18 = mysql_num_rows($result18);			
	$query16 = "SELECT * FROM tblproactivecall WHERE CustomerNumber = '$fid' AND Message = 2 AND callback = -1";
	$result16 = mysql_query($query16) or die (mysql_error());
	$count16 = mysql_num_rows($result16);
	$query17 = "SELECT * FROM tblproactivecall WHERE CustomerNumber = '$fid' AND Message = 2 AND callback = 1";
	$result17 = mysql_query($query17) or die (mysql_error());
	$count17 = mysql_num_rows($result17);	
	$query111 = "SELECT ID FROM tblproactivecallschedule WHERE CustomerNumber = '$fid'";
	$result111 = mysql_query($query111) or die (mysql_error());
	$row111 = mysql_fetch_array($result111);
	$scheduleid = $row111['ID'];
	$query20 = "SELECT ExpectedDate FROM tblproactivescheduletracker WHERE ScheduleID = '$scheduleid' AND CallID IS NULL";
	$result20 = mysql_query($query20) or die (mysql_error());
	$row20 = mysql_fetch_array($result20);	
	$count20 = mysql_num_rows($result20);
	$nextcall = strtotime($row20['ExpectedDate']);	
	mysql_select_db($dbname);
	$query8 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$fid'";
	$result8 = mysql_query($query8) or die (mysql_error());
	$row8 = mysql_fetch_array($result8);
?>
	<table width="750">
		<tr>
			<td>
				<?php echo '<a href=" ../sales/proactivecall.php">'. 'Proactive Home'.'</a>'; ?> 
			</td>
			<td>
				<?php echo '<a href=" ../sales/proactivecall.php?view=newticketform&f_id='.$fid.'">'. 'Add A Call For This Customer'.'</a>'; ?> 
			</td>
		</tr>		
	</table>
	<table width="750"?
		<tr>
			<td width="350" class="border" valign="top">
				<table align="center">
					<tr>
						<td align="center" class="bigheading" colspan="2">
							<?php echo $row8['FacilityName']; ?>
						</td>
					</tr>
					<tr>
						<td class="heading" align="center" colspan="2">
							Customer Number: <?php echo $fid; ?>
						</td>
					</tr>
<?php						
					while($row7 = mysql_fetch_array($result7))
					{
						$id = $row7['ID'];
						$dateopened = strtotime($row7['DateOpened']);
						if($row7['Message'] == 1)
						{
							if($row7['callback'] == -1)
							{
								$color = '#0000FF';
							}elseif($row7['Successful'] == 1)
							{
								$color = '#6DCA35';
							}else
							{
								$color = '#000000';
							}
						}elseif($row7['Message'] == 2)
						{
							if($row7['callback'] == -1)
							{
								$color = '#FF0000';
							}elseif($row7['Successful'] == 1)
							{
								$color = '#6DCA35';
							}else
							{
								$color = '#000000';
							}
						}else
						{
							$color = '#6DCA35';
						}
?>
						<tr>
							<td class="heading" width="120"><font color="<?php echo $color;?>">
								Contact Name:
							</td>
							<td><font color="<?php echo $color;?>">
								<?php echo $row7['ContactName']; ?>
							</td>
						</tr>
						<tr>
							<td class="heading"><font color="<?php echo $color;?>">
								Contact Number:
							</td>				
							<td><font color="<?php echo $color;?>">
								<?php echo formatPhone($row7['ContactNumber']); ?>
							</td>
						</tr>
						<tr>
							<td class="heading"><font color="<?php echo $color;?>">
								Date Opened:
							</td>				
							<td><font color="<?php echo $color;?>">
								<?php echo date('m-d-Y',$dateopened); ?>
							</td>				
						</tr>
						<tr>
							<td>
<?php
								if($row7['Message'] == 1)
								{					
								 	echo '<a href=" ../sales/proactivecall.php?view=viewticket&a=1&id='.$id.'">'. 'View Details'.'</a>';	
								}elseif($row7['Message'] == 2)
								{
									echo '<a href=" ../sales/proactivecall.php?view=viewticket&a=2&id='.$id.'">'. 'View Details'.'</a>';
								}elseif(($row7['Message'] == -1) && ($row7['Install'] == -1))
								{
									echo '<a href=" ../sales/proactivecall.php?view=viewqs&action=update&id='.$id.'">'. 'View Details'.'</a>';
								}else
								{
									echo '<a href=" ../sales/proactivecall.php?view=viewqs&action=updateall&id='.$id.'">'. 'View Details'.'</a>';
								}
?>				
							</td>
						</tr>
			  		<tr>
							<td colspan="2"><div><hr width="100%"></div></td>
						</tr>	
<?php		
					}			
?>
				</table>
			</td>
			<td valign="top" width="350">	
				<table width="350">	
					<tr>	
						<td class="heading" align="center" colspan="2">
							Facility Statistics
						</td>
					</tr>
					<tr>
						<td width="180">
							Proactive calls initiated:
						</td>
						<td>
							<?php echo $count7; ?>
						</td>
					</tr>
					<tr>
						<td>
							Proactive calls completed:
						</td>
						<td>
							<?php echo $count19; ?>
						</td>
					</tr>			
					<tr>
						<td>
							Message Pending:
						</td>
						<td>
							<?php echo $count15; ?>
						</td>
					</tr>	
					<tr>
						<td>
							Messages Returned:
						</td>
						<td>
							<?php echo $count18; ?>
						</td>
					</tr>							
					<tr>
						<td>
							Return Calls Scheduled:
						</td>
						<td>
							<?php echo $count16; ?>
						</td>
					</tr>
					<tr>
						<td>
							Return Calls Made:
						</td>
						<td>
							<?php echo $count17; ?>
						</td>
					</tr>	
					<tr>	
						<td class="heading" align="center" colspan="2">
							Schedule Details:
						</td>
					</tr>					
					<tr>
						<td>
							Next Call:
						</td>
						<td>
<?php
						if($count20 > 0)
						{
							echo date('m-d-Y',$nextcall); 
						}else
						{
?>							
							<a href=" ../sales/proactivecall.php?view=admin&action=addsch&customernumber=<?php echo $fid; ?>">Add Schedule</a>
<?php						
						}
?>
						</td>
					</tr>																	
				</table>
			</td>	
		</tr>
	</table>	
	<table>
<?php
		$query = "SELECT ID, CustomerNumber FROM tblTickets WHERE CustomerNumber = '$fid' AND Status <> 1 LIMIT 5";
		$result = mysql_query($query) or die ('Error retrieving Information from database. Please contact system administrator.<br><a href="'.$_SERVER['HTTP_REFERER'].'">Return</a>');
		$row = mysql_fetch_array($result);
		$query2 = "SELECT * FROM tblTickets WHERE CustomerNumber = '$fid' AND Status <> 1 ORDER BY id DESC LIMIT 5";
		$result2 = mysql_query($query2) or die (mysql_error());		
		if(is_null($row['ID'])) 
		{
			echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
			echo '<tr><td align="center"><i>' . 'No matches found' . '</i></td></tr>';
			echo '</table>';
		}
		else
		{
		?>
			<table align="center">
				<tr>
					<td  align="center"><a href="../csPortal_ticketReportsNew.php?cust_num=<?php echo $row['CustomerNumber']; ?>"><font face="Arial" size="2">View Reports</font></a></td>
				</tr>
			</table>
		<?php
			if(!isset($_GET['by_ticket']))
			{
		?>
			<table align="center">
				<tr>
					<td align="center"><font face="Arial" size="3"><b><i>Viewing Last 5 Opened Tickets</i></b></font></td>
				</tr>
			</table>
		<?php
			}
			while($row2 = mysql_fetch_array($result2))
			{
				$CustNumber = $row2['CustomerNumber'];
				$TicketNum = $row2['ID'];
				if($row2['Status']==0) {
					$Status = 'OPEN';
				} elseif($row2['Status']==1) {
					$Status = 'CANCELED';
				}elseif($row2['Status']==2) {
					$Status = 'ESCALATED';
				}else{
					$Status = 'CLOSED';
				}
				$query3 = "SELECT FacilityName FROM tblFacilities WHERE CustomerNumber = '$CustNumber'";
				$result3 = mysql_query($query3) or die (mysql_error());
				$row3 = mysql_fetch_array($result3);
				$query4 = "SELECT * FROM tblTicketMessages WHERE TicketID = '$TicketNum' ORDER BY Date Asc";
				$result4 = mysql_query($query4) or die (mysql_error());
				
				// connect to work db and get task information
				mysql_select_db($dbname2);
				$query5 = "SELECT * FROM taskinfo WHERE ticketNum = '$TicketNum'";
				$result5 = mysql_query($query5, $conn);
				$row5 = mysql_fetch_array($result5);
				$taskId = $row5['ID'];
				$taskStatus = $row5['Status'];
				$taskType = $row5['Type'];
				$taskCount = mysql_num_rows($result5);
				mysql_select_db($dbname);
				
				echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
				echo '<tr align="center"><td colspan="2"><table cellspacing="5"><tr><td></font></a></td>';
					// check to see if task exists
				if($taskCount > 0)
				{
					echo '<td  align="center"><a href="../task/task.php?action=UPDATE&viewticketNum=' . $TicketNum . '"><font face="Arial" size="2">View Task(s)</font></a></td>';
				}
				echo '</tr>';
				echo '</table></td></tr>';
				echo '<tr><td width="140" valign="top"><font face="Arial" size="2"><b>' . 'Customer Number: ' . '</td><td><a href="../csPortal_Facilities.php?cust_num='.$row2['CustomerNumber'].'&by_cust=Lookup">' . $row2['CustomerNumber'] . '</a></font></td></tr>';
				echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Facility Name: ' . '</b></td><td>' . $row3['FacilityName'] . '</font></td></tr>';
				echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Ticket Number: ' . '</b></td><td>' . $row2['ID'] . '</td></tr>';
				echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Current Status: ' . '</b></td><td>';
					echo $Status . '</font></td></tr>';				
				if($row2['Status'] == -1) {
					echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Date Closed: ' . '</b></td><td>' . $row2['DateClosed'] . '</td></tr>';
					echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Ticket Duration: ' . '</b></td><td>' . dateDiffmike($row2['DateOpened'],$row2['DateClosed']) . '</td></tr>';
				}				
				if($row2['Type'] == 0)
				{
					$ticketType = "Office Hours Call Center";
				}
				elseif($row2['Type'] == 1)
				{
					$ticketType = "After Hours Call Center";
				}
				elseif($row2['Type'] == 2)
				{
					$ticketType = "Site Visit/Service Call";
				}
				elseif($row2['Type'] == 3)
				{
					$ticketType = "Proactive Call";
				}
				elseif($row2['Type'] == 4)
				{
					$ticketType = "Site Visit/Training";
				}
				echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Ticket Type: ' . '</b></td><td>' . $ticketType . '</font></td></tr>';
				if($row2['warrantyActivity'] == "Yes")
				{
					echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Ensure Activity: ' . '</b></td><td>' . $row2['warrantyActivity'] . '</font></td></tr>';
				}
				echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Problem Description: ' . '</b></font></td>';
				if((!($row2['Status'] == -1 || $row2['Status'] == 1)) && ($row2['OpenedBy'] == $uid))
				{
					echo '<td>' . $row2['Summary'] . '</td></tr>';
				}
				else
				{
					echo '<td>' . $row2['Summary'] . '</td></tr>';
				}
				echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Contact Name: ' . '</b></td><td>' . $row2['Contact'] . '</font></td></tr>';
				echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Contact Number: ' . '</b></font></td><td>' . formatPhone($row2['ContactPhone']) . '&nbsp;<font face="Arial" size="2"><b>Ext.&nbsp;</b></font>'.$row2['Extension'].'</td></tr>';
				
				$query23 = "SELECT f_name, l_name FROM employees WHERE id = '$row2[OpenedBy]'";
				$result23 = mysql_query($query23);
				$row23 = mysql_fetch_array($result23);
				$empName23 = $row23['l_name'] . ", " . $row23['f_name'];
				echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Opened By: ' . '</b></td><td>' . $empName23 . ' @ ' . $row2['DateOpened'] . '</font></td></tr>';
				while($row4 = mysql_fetch_array($result4))
				{
					if((isset($_GET['action']) && ($_GET['action'] == "updateRemark")) && ($_GET['id'] == $row4['ID']))
					{
						echo '<form name="remarkUpdate" action="'.$_SERVER['PHP_SELF'].'" method="get">';
						echo '<tr><td valign="top"><font face="Arial" size="2"><b>Enter Remark:</b></td>';
						echo '<td><textarea name="updatedRemark" rows="5" cols="45">'.strip_tags($row4['Message']).'</textarea></td></tr>';
						echo '<input type="hidden" name="by_ticket" value="ticket">';
						echo '<input type="hidden" name="ticket_num" value="'.$row2['ID'].'">';
						//echo '<input type="hidden" name="cust_num" value="'.$custNum.'">';
						echo '<input type="hidden" name="remarkID" value="'.$row4['ID'].'">';
						echo '<tr><td>&nbsp;</td><td><input name="saveUpdRemark" type="submit" value="Update"></form>&nbsp;&nbsp;<input type="button" value="Cancel" onClick="window.location.href=\''.$_SERVER['PHP_SELF'].'?cust_num='.$CustNumber.'&by_cust=Lookup\'"></td></tr>';
					}
					else
					{
						echo '<tr><td valign="top"><font face="Arial" size="2"><b>' . 'Technician Remark: ' . '</b></td>';
						if((!($row2['Status'] == -1 || $row2['Status'] == 1)) && ($row4['EnteredBy'] == $user))
						{
							echo '<td>' . $row4['Message'] . '</td></tr>';
							echo '<tr>&nbsp;<td></td><td><font face="Arial" size="2"><a href="'.$_SERVER['PHP_SELF'].'?action=updateRemark&id='.$row4['ID'].'&by_ticket=Lookup&ticket_num='.$row2['ID'].'">Edit</a></font></td></tr>';
						}
						else
						{
							echo '<td>' . $row4['Message'] . '</td></tr>';
						}
					}
					$query24 = "SELECT f_name, l_name FROM employees WHERE id = '$row4[EnteredBy]'";
					$result24 = mysql_query($query24);
					$row24 = mysql_fetch_array($result24);
					$empName24 = $row24['l_name'] . ", " . $row24['f_name'];
					echo '<tr><td valign="top">' . '&nbsp;</td><td>' . '<font face="Arial" size="2"><b>Signature: '.'</b></font>'.$empName24.' @ '.$row4['Date'].'</td></tr>';
				}
				echo '</table>';
					$query28 = "SELECT * FROM devicelist";
					$result28 = mysql_query($query28);
					$query27 = "SELECT * FROM rmadevices WHERE TicketID = '$TicketNum'";
					$result27 = mysql_query($query27);
					$count27 = mysql_num_rows($result27);
					if($count27 > 0) {
					?>
						<table cellspacing="5" align="center">
							<tr>
								<td><u><b><font size="2" face="Arial">Device:</font></u></b></td>
								<td><u><b><font size="2" face="Arial">Serial #:</font></u></b></td>
								<td><u><b><font size="2" face="Arial">Problem:</font></u></b></td>
								<td><u><b><font size="2" face="Arial">Status:</font></u></b></td>
								<td>&nbsp;</td>
							</tr>
							<?php
								while($row27 = mysql_fetch_array($result27)) {
									if($row27['Warranty'] == 1) {
										$warranty = "Problem Warrantied";
									} elseif($row27['Warranty'] == 2) {
										$warranty = "NOT Warrantied - Return for repair";
									} elseif($row27['Warranty'] == 3) {
										$warranty = "NOT Warrantied - Purchase replacement";
									}
									mysql_data_seek($result28, 0);
									while($row28 = mysql_fetch_array($result28)) {
										if($row28['part#'] == $row27['Device']){
											$deviceName = $row28['partDesc'];
										}
									}
									echo '<tr>';
									echo '<td><font size="2" face="Arial">'. $deviceName . '</font></td>';
									echo '<td><font size="2" face="Arial">'. $row27['SN'] . '</font></td>';
									echo '<td><font size="2" face="Arial">'. $row27['Problem'] . '</font></td>';
									echo '<td><font size="2" face="Arial">'. $warranty . '</font></td>';
									if(!($row2['Status'] == -1 || $row2['Status'] == 1)) {
										echo '<td><a href="">[Edit]</a>&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?ticket_num='.$TicketNum.'&by_ticket=ticket&submit=Lookup&action=removeDevice&deviceID='.$row27['ID'].'">[Remove]</a></td>';
									}
									echo '</tr>';
								}
							?>
						</table>
					<?php
					}
				# FILE UPLOAD FEATURE
				$query12 = "SELECT * FROM filemanager WHERE refNumber = '$TicketNum' AND attachType = 'ticket' AND publish = '-1' ORDER BY timestamp DESC";
				$result12 = mysql_query($query12);
				echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
				if(mysql_num_rows($result12) > 0)
				{
					echo '<tr><td colspan="5" align="center"><font face="Arial" size="2"><b>File Manager</b></font></td></tr>';
					while($row12 = mysql_fetch_array($result12))
					{
						if($row12['fileType'] == "image/jpeg")
						{
						$icon = "JPG_Small.png";
						}
						elseif($row12['fileType'] == "image/gif")
						{
						$icon = "GIF_Small.png";
						}
						elseif($row12['fileType'] == "application/pdf")
						{
						$icon = "PDF_Small.png";
						}
						elseif($row12['fileType'] == "application/msword")
						{
						$icon = "DOC_Small.png";
						}
						elseif($row12['fileType'] == "application/vnd.ms-excel")
						{
						$icon = "XLSX_Small.png";
						}
						elseif($row12['fileType'] == "application/x-zip-compressed")
						{
						$icon = "ZIP_Small.png";
						}
						elseif($row12['fileType'] == "application/zip")
						{
						$icon = "ZIP_Small.png";
						}
						elseif($row12['fileType'] == "text/plain")
						{
						$icon = "LOG_Small.png";
						}
						echo '<tr><td width="27"><img src="images/icons/'.$icon.'" width="26" height="26" /></td>';
						echo '<td><a href="'.$row12['location'].'"><font face="Arial" size="2">' . $row12['name'] . '</font></a></td>';
						echo '<td><font face="Arial" size="2">'.$row12['size'].' KB</font></td>';
						echo '<td width="128"><font face="Arial" size="2">'.$row12['timestamp'].'</font></td>';
						if((!($row2['Status'] == -1 || $row2['Status'] == 1)) && ($row12['addedBy'] == $user))
						{
							echo '<td width="22"><a href="csPortal_FileManage.php?action=deleteFile&fileID=' . $row12['id'] . '" onClick="return confirm(\'Are you sure you want to delete '.$row12['name'].'?\')"><img src="images/delete-icon_Small.png" width="20" height="20" border="0" /></a></td></tr>';
						}
					}
					if($row2['Status'] == -1 || $row2['Status'] == 1)
					{
						echo '<tr><td colspan="4"><div align="center"><hr width="50%"></div></td></tr>';
					}
					echo '</table>';
				}
				else
				{
					echo '<tr><td align="center"><font face="Arial" size="2"><b>File Manager</b></font></td></tr>';
					echo '<tr><td align="center"><i>No files found</i></td></tr>';
					echo '<tr><td colspan="2"><div align="center"><hr width="50%"></div></td></tr>';
					echo '</table>';
				}
			}
		}
?>
	</table>
<?php				
}
//************************************************VIEW DETAILED TICKET MESSAGE********************************//
if((isset($_GET['view'])) && ($_GET['view'] == 'viewticket'))
{
	mysql_select_db($dbname2);
	$id = $_GET['id'];
	$query9 = "SELECT * FROM tblproactivecall WHERE ID = '$id'";
	$result9 = mysql_query($query9) or die (mysql_error());
	$row9 = mysql_fetch_array($result9);
	$fid=$row9['CustomerNumber'];
	$details = nl2br($row9['Messagedetails']);
	$callback = strtotime($row9['calldate']);
	$callback = date('m-d-Y H:i:s',$callback);	
	$calledback = strtotime($row9['calledback']);
	$calledback = date('m-d-Y H:i:s',$calledback);	
?>
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width="750">
			<tr>
				<td class="heading" width="200"><font color="#000000">
					Contact Name:
				</td>
				<td><font color="#000000">
					<?php echo $row9['ContactName']; ?>
				</td>
			</tr>
			<tr>
				<td class="heading"><font color="#000000">
					Contact Number:
				</td>				
				<td><font color="#000000">
					<?php echo formatPhone($row9['ContactNumber']); ?>
				</td>
			</tr>
			<tr>
				<td class="heading"><font color="#000000">
					Date Opened:
				</td>				
				<td><font color="#000000">
					<?php echo $row9['DateOpened']; ?>
				</td>				
			</tr>
<?php
			if($_GET['a'] == 1)
			{
?>					
				<tr>
					<td class="heading">
						Left a Message
					</td>
				</tr>
				<tr>
					<td class="heading" valign="top">
						Message Details:
					</td>
					<td valign="top">
						<?php echo $details; ?>
					</td>
				</tr>
<?php	
				if($row9['callback'] == 1)
				{
?>					
					<tr>
						<td class="heading">
							Call Back Made on:
						</td>
						<td>
							<?php echo $calledback;?>
						</td>							
					</tr>
					<tr>
<?php
					if($row9['Successful'] == 1)
					{
?>						
						<td class="heading">
							Call Back Successful
						</td>
						<td>
<?php							
						if($row9['Install'] == -1)
								{
									echo '<a href=" ../sales/proactivecall.php?view=viewqs&action=update&id='.$id.'">'. 'View Details'.'</a>';
								}else
								{
									echo '<a href=" ../sales/proactivecall.php?view=viewqs&action=updateall&id='.$id.'">'. 'View Details'.'</a>';
								}
?>															
						</td>
<?php	
					}else
					{
?>						
						<td class="heading">
							Call Back not Successful
						</td>
<?php												
					}
				}					
				if(isset($_GET['action']))
				{
?>					
					<tr>
						<td class="heading">
							Returned Call
						</td>
						<td>
							<input type="checkbox" name="callback" value="1">
						</td>
					</tr>		
					<tr>
						<td class="heading">
							Returned Call Successful?:	
						</td>
						<td>
							<input type="checkbox" name="success" value="1">
						</td>
					</tr>													
<?php					
				}
			}
			if($_GET['a'] == 2)
			{						
?>
				<table>
					<tr>
						<td class="heading">
							Call Back Scheduled For:
						</td>
						<td colspan = "1" width = "270">
							<?php echo $callback; ?>
						</td> 
					</tr> 					
<?php	
				if($row9['callback'] == 1)
				{
?>					
					<tr>
						<td class="heading">
							Call Back Made on:
						</td>
						<td>
							<?php echo $calledback;?>
						</td>							
					</tr>
					<tr>
<?php
					if($row9['Successful'] == 1)
					{
?>						
						<td class="heading">
							Call Back Successful
						</td>
						<td>
<?php							
						if($row9['Install'] == -1)
						{
							echo '<a href=" ../sales/proactivecall.php?view=viewqs&action=update&id='.$id.'">'. 'View Details'.'</a>';
						}else
						{
							echo '<a href=" ../sales/proactivecall.php?view=viewqs&action=updateall&id='.$id.'">'. 'View Details'.'</a>';
						}
?>															
						</td>
<?php	
					}else
					{
?>						
						<td class="heading">
							Call Back not Successful
						</td>
<?php												
					}
				}			
				if(isset($_GET['action']))
				{
?>
					<tr>
						<td class="heading">
							Called Back:	
						</td>
						<td>
							<input type="checkbox" name="callback" value="1">
						</td>
					</tr>	
					<tr>
						<td class="heading">
							Call Back Successful?:	
						</td>
						<td>
							<input type="checkbox" name="success" value="1">
						</td>
					</tr>									
<?php					
				}
			}		
?>			
			<tr>
<?php				
			if(((!(isset($_GET['action']))) && (($_GET['a'] == 2) || ($_GET['a'] == 1)) && ($row9['callback'] <> 1)))
			{			
				$a = $_GET['a'];					
				echo '<td>'.'<input type="button" value="Update" onClick="window.location.href=\'proactivecall.php?view=viewticket&action=update&id='.$id.'&a='.$a.'&fid='.$fid.'\'">'.'</td>';
			}
			if(!(isset($_GET['action'])))
			{
?>					
				<td>
<?php 								
 					echo '<input type="button" value="Close" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'">';
?> 	
				</td>
<?php
			}else
			{
				echo	'<input type = "hidden" name="id" value = "'.$id.'">'; 
				echo	'<input type = "hidden" name="fid" value = "'.$fid.'">'; 		
?>		
				<td>
					<input type="submit" value="Save" name="view">
				</td>				
<?php				
			}
?>							
			</tr>				
		</table>
	</form>
<?php				
}
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && (!isset($_GET['action'])))
{
?>	
	<table width="750">
		<tr>
			<td align="center" class="bigheading">
				Proactive Call Administration
			</td>
		</tr>
	</table>
	<table width="750">
		<tr>
			<td>
				<table width="350">
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=admin&action=modify">Modify a questions wording</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=admin&action=add">Add a question</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=admin&action=viewq">View Current Questions</a>
						</td>
					</tr>
				</table>	
			</td>
			<td valign="top">
				<table>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=admin&action=sch">Call Schedule</a>
						</td>
					</tr>	
				</table>
			</td>			
		</tr>		
	</table>		
<?php		
}
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && ((isset($_GET['action'])) && ($_GET['action'] == 'add')))
{
	mysql_select_db($dbname2);
	$query32 = "SELECT * FROM tblproactivequestions WHERE Type=1 AND Active = 1";
	$result32 = mysql_query($query32) or die (mysql_error());	
	$query33 = "SELECT * FROM tblproactivequestions WHERE Type=1 AND Active = 1";
	$result33 = mysql_query($query33) or die (mysql_error());	
	$query34 = "SELECT * FROM tblproactivequestions WHERE Type=1 AND Active = 1";
	$result34 = mysql_query($query34) or die (mysql_error());		
	$query35 = "SELECT * FROM tblproactivequestions WHERE Type=2 AND Active = 1";
	$result35 = mysql_query($query35) or die (mysql_error());	
	$query36 = "SELECT * FROM tblproactivequestions WHERE Type=2 AND Active = 1";
	$result36 = mysql_query($query36) or die (mysql_error());	
	$query37 = "SELECT * FROM tblproactivequestions WHERE Type=2 AND Active = 1";
	$result37 = mysql_query($query37) or die (mysql_error());		
	$a=0;
?>
	<table>
		<tr>
			<td class="border" valign="top">
				<table width="370">
					<tr>
						<td class="bigheading" colspan="3">
							Proactive Call Report Questions
						</td>
					</tr>
					<tr>
						<td>
							<b>Operational</b>
						</td>
					</tr>
<?php						
					while($row32 = mysql_fetch_array($result32))
					{
						if($row32['Dept'] == 1)
						{
							$a = $a + 1;							
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'.'.' '.$row32['Question']; ?>
								</td>
							</tr>
<?php							
						}
					}
?>					
					<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">								
						<tr>
							<td>
								New Operational Question:
							</td>
							<td>
								<input type="text" size="30" maxlength="500" name="q" value="">
							</td>	
						</tr>
<?php
						echo	'<input type = "hidden" name="action" value = "addq">';
						echo	'<input type = "hidden" name="type" value = "1">'; 
						echo	'<input type = "hidden" name="dept" value = "1">';
?>						
					  <tr>
							<td>
								<input type="submit" value="Add" name="add">
							</td>
						</tr>								
					</form>			
					<tr>
						<td>
							<b>Tech Support</b>
						</td>
					</tr>
<?php			
					while($row33 = mysql_fetch_array($result33))
					{
						if($row33['Dept'] == 2)
						{
							$a = $a + 1;
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'.'.' '.$row33['Question']; ?>
								</td>
							</tr>
<?php							
						}
					}
?>					
					<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">								
						<tr>
							<td>
								New Tech Support Question:
							</td>
							<td>
								<input type="text" size="30" maxlength="500" name="q" value="">
							</td>	
						</tr>
<?php
						echo	'<input type = "hidden" name="action" value = "addq">';
						echo	'<input type = "hidden" name="type" value = "1">'; 
						echo	'<input type = "hidden" name="dept" value = "2">';
?>						
					  <tr>
							<td>
								<input type="submit" value="Add" name="add">
							</td>
						</tr>								
					</form>	
					<tr>
						<td colspan="2">
							<b>New Sales and Marketing</b>
						</td>
					</tr>
<?php			
					while($row34 = mysql_fetch_array($result34))
					{
						if($row34['Dept'] == 3)
						{
							$a = $a + 1;
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'.'.' '.$row34['Question']; ?>
								</td>
							</tr>
<?php							
						}
					}
?>					
					<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">								
						<tr>
							<td>
								New Sales and Marketing Question:
							</td>
							<td>
								<input type="text" size="30" maxlength="500" name="q" value="">
							</td>	
						</tr>
<?php
						echo	'<input type = "hidden" name="action" value = "addq">';
						echo	'<input type = "hidden" name="type" value = "1">'; 
						echo	'<input type = "hidden" name="dept" value = "3">';
?>						
					  <tr>
							<td>
								<input type="submit" value="Add" name="add">
							</td>
						</tr>	
					</table>							
				</form>			
			</td>
			<td class="border" valign="top">
				<table width="370">
					<tr>
						<td class="bigheading" colspan="3">
							Proactive Installation Report Questions
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<b>Project Management Experience</b>
						</td>
					</tr>
<?php		
					$a=0;				
					while($row35 = mysql_fetch_array($result35))
					{
						if($row35['Dept'] == 4)
						{
							$a = $a + 1;							
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'.'.' '.$row35['Question']; ?>
								</td>
							</tr>
<?php							
						}
					}
?>					
					<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">								
						<tr>
							<td>
								New Project Management Question:
							</td>
							<td>
								<input type="text" size="30" maxlength="500" name="q" value="">
							</td>	
						</tr>
<?php
						echo	'<input type = "hidden" name="action" value = "addq">';
						echo	'<input type = "hidden" name="type" value = "2">'; 
						echo	'<input type = "hidden" name="dept" value = "4">';
?>						
					  <tr>
							<td>
								<input type="submit" value="Add" name="add">
							</td>
						</tr>								
					</form>			
					<tr>
						<td colspan="2">
							<b>Quality of Installation</b>
						</td>
					</tr>
<?php			
					while($row36 = mysql_fetch_array($result36))
					{
						if($row36['Dept'] == 5)
						{
							$a = $a + 1;
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'.'.' '.$row36['Question']; ?>
								</td>
							</tr>
<?php							
						}
					}
?>					
					<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">								
						<tr>
							<td>
								New Install Quality Question:
							</td>
							<td>
								<input type="text" size="30" maxlength="500" name="q" value="">
							</td>	
						</tr>
<?php
						echo	'<input type = "hidden" name="action" value = "addq">';
						echo	'<input type = "hidden" name="type" value = "2">'; 
						echo	'<input type = "hidden" name="dept" value = "5">';
?>						
					  <tr>
							<td>
								<input type="submit" value="Add" name="add">
							</td>
						</tr>								
					</form>	
					<tr>
						<td colspan="2">
							<b>Introductory training by our Installers</b>
						</td>
					</tr>
<?php			
					while($row37 = mysql_fetch_array($result37))
					{
						if($row37['Dept'] == 6)
						{
							$a = $a + 1;
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'.'.' '.$row37['Question']; ?>
								</td>
							</tr>
<?php							
						}
					}
?>					
					<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">								
						<tr>
							<td>
								New Installer Training Question:
							</td>
							<td>
								<input type="text" size="30" maxlength="500" name="q" value="">
							</td>	
						</tr>
<?php
						echo	'<input type = "hidden" name="action" value = "addq">';
						echo	'<input type = "hidden" name="type" value = "2">'; 
						echo	'<input type = "hidden" name="dept" value = "6">';
?>						
					  <tr>
							<td>
								<input type="submit" value="Add" name="add">
							</td>
						</tr>	
					</table>							
				</form>		
			</td>			
		</tr>
		<tr>
			<td>
				<button onClick="window.location='proactivecall.php?'">Done</button>
			</td>
		</tr>
	</table>											
<?php			
}
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && ((isset($_GET['action'])) && ($_GET['action'] == 'modify')))
{
	mysql_select_db($dbname2);
	$query32 = "SELECT * FROM tblproactivequestions WHERE Type=1 AND Active = 1";
	$result32 = mysql_query($query32) or die (mysql_error());	
	$query33 = "SELECT * FROM tblproactivequestions WHERE Type=1 AND Active = 1";
	$result33 = mysql_query($query33) or die (mysql_error());	
	$query34 = "SELECT * FROM tblproactivequestions WHERE Type=1 AND Active = 1";
	$result34 = mysql_query($query34) or die (mysql_error());		
	$query35 = "SELECT * FROM tblproactivequestions WHERE Type=2 AND Active = 1";
	$result35 = mysql_query($query35) or die (mysql_error());	
	$query36 = "SELECT * FROM tblproactivequestions WHERE Type=2 AND Active = 1";
	$result36 = mysql_query($query36) or die (mysql_error());	
	$query37 = "SELECT * FROM tblproactivequestions WHERE Type=2 AND Active = 1";
	$result37 = mysql_query($query37) or die (mysql_error());		
	$a=0;
?>
	<table>
		<tr>
			<td class="border" valign="top">
				<table width="370">
					<tr>
						<td class="bigheading" colspan="3">
							Proactive Call Report Questions
						</td>
					</tr>
					<tr>
						<td>
							<b>Operational</b>
						</td>
					</tr>
					<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">	
<?php	
					echo	'<input type = "hidden" name="action" value = "saveq">';					
					while($row32 = mysql_fetch_array($result32))
					{
						if($row32['Dept'] == 1)
						{
							$a = $a + 1;
							$id = $row32['ID'];							
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'. '; ?><input type="text" size="52" maxlength="500" name="<?php echo $id; ?>" value="<?php echo $row32['Question']; ?>">
								</td>
							</tr>
<?php							
						}
					}
?>								
					<tr>
						<td>
							<b>Tech Support</b>
						</td>
					</tr>
<?php			
					while($row33 = mysql_fetch_array($result33))
					{
						if($row33['Dept'] == 2)
						{
							$a = $a + 1;
							$id = $row33['ID'];
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'. '; ?><input type="text" size="52" maxlength="500" name="<?php echo $id; ?>" value="<?php echo $row33['Question']; ?>">
								</td>
							</tr>
<?php							
						}
					}
?>					
					<tr>
						<td colspan="2">
							<b>New Sales and Marketing</b>
						</td>
					</tr>
<?php			
					while($row34 = mysql_fetch_array($result34))
					{
						if($row34['Dept'] == 3)
						{
							$a = $a + 1;
							$id = $row34['ID'];
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'. '; ?><input type="text" size="52" maxlength="500" name="<?php echo $id; ?>" value="<?php echo $row34['Question']; ?>">
								</td>
							</tr>
<?php							
						}
					}
?>					
						</td>
					</tr>
				</table>								
			</td>
			<td class="border" valign="top">
				<table width="370">
					<tr>
						<td class="bigheading" colspan="3">
							Proactive Installation Report Questions
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<b>Project Management Experience</b>
						</td>
					</tr>
<?php		
					$a=0;				
					while($row35 = mysql_fetch_array($result35))
					{
						if($row35['Dept'] == 4)
						{
							$a = $a + 1;	
							$id = $row35['ID'];						
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'. '; ?><input type="text" size="52" maxlength="500" name="<?php echo $id; ?>" value="<?php echo $row35['Question']; ?>">
								</td>
							</tr>
<?php							
						}
					}
?>												
					<tr>
						<td colspan="2">
							<b>Quality of Installation</b>
						</td>
					</tr>
<?php			
					while($row36 = mysql_fetch_array($result36))
					{
						if($row36['Dept'] == 5)
						{
							$a = $a + 1;
							$id = $row36['ID'];
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'. '; ?><input type="text" size="52" maxlength="500" name="<?php echo $id; ?>" value="<?php echo $row36['Question']; ?>">
								</td>
							</tr>
<?php							
						}
					}
?>					
					<tr>
						<td colspan="2">
							<b>Introductory training by our Installers</b>
						</td>
					</tr>
<?php			
					while($row37 = mysql_fetch_array($result37))
					{
						if($row37['Dept'] == 6)
						{
							$a = $a + 1;
							$id = $row37['ID'];
?>
							<tr>
								<td colspan="2">						
									<?php echo $a.'. '; ?><input type="text" size="52" maxlength="500" name="<?php echo $id; ?>" value="<?php echo $row37['Question']; ?>">
								</td>
							</tr>
<?php							
						}
					}
?>						
				</table>							
			</td>			
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<input type="submit" value="Save" name="save">
			</td>
			<td>
				<input type="submit" value="Done" name="done">
			</td>			
		</tr>	
		</table>
	</form>
<?php	
}
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && ((isset($_GET['action'])) && ($_GET['action'] == 'sch')))
{
?>
	<table width="750">
		<tr>
			<td>
				<button onClick="window.location='proactivecall.php'">Proactive Home</button>
			</td>
		</tr>
		<tr>
			<td valign="top" class="border" width="500">
				<table>
					<tr>
						<td class="heading">
							Build a Customers Call Schedule
						</td>
					</tr>
					<tr>
						<td>
							<li>Building a Customers Call Schedule will provide an automatically generated report seen on the right side of this page.<br>
							<li>If a customer is to be called within one month of the current date, it will appear on the right side of under customers 
							to call this month.<br>
							<li>If a Customer's Schedule already exists, you can then update the current schedule settings.
						</td>
					</tr>
					<tr>
						<td>
							<button onClick="window.location='proactivecall.php?view=admin&action=getcustoadd'">GO</button>
						</td>
					</tr>						
				</table>
			</td>
			<td valign="top" class="border" width="250">
				<table>
					<tr>
						<td class="heading">
							View Customers by Increment
						</td>
					</tr>
					<tr>
						<td>
							<li>Customers to call every 3 months:
						</td>
					</tr>
					<tr>
						<td><p>
							<?php echo '<a href=" ../sales/proactivecall.php?view=admin&action=list&inc=3">'. 'Click Here'.'</a>'; ?>
						</p></td>						
					</tr>
					<tr>
						<td>
							<li>Customers to call every 6 months:
						</td>
					</tr>
					<tr>
						<td><p>
							<?php echo '<a href=" ../sales/proactivecall.php?view=admin&action=list&inc=6">'. 'Click Here'.'</a>'; ?>
						</p></td>						
					</tr>	
					<tr>
						<td>
							<li>Customers to call every 1 year:
						</td>
					</tr>
					<tr>
						<td><p>
							<?php echo '<a href=" ../sales/proactivecall.php?view=admin&action=list&inc=12">'. 'Click Here'.'</a>'; ?>
						</p></td>						
					</tr>									
				</table>								
			</td>
		</tr>
	</table>
<?php	
}
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && ((isset($_GET['action'])) && ($_GET['action'] == 'getcustoadd')))
{
	mysql_select_db($dbname);
	$query64 = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE Active = -1 ORDER BY FacilityName";
	$result64 = mysql_query($query64) or die (mysql_error());	
?>
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td colspan="1">
					Customer:
				</td>
				<td colspan="2">
					<select name="customernumber">
<?php
					while($row64 = mysql_fetch_array($result64))
					{
?>													
						<option value="<?php echo $row64['CustomerNumber']; ?>">  <?php echo $row64['FacilityName']; ?> </option>
<?php							
					}
					echo	'<input type = "hidden" name="view" value = "admin">';
					echo	'<input type = "hidden" name="action" value = "addsch">';
?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" name="addsch" value="GO">
				</td>
			</tr>
		</table>
	</form>
<?php
}
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && ((isset($_GET['action'])) && ($_GET['action'] == 'addsch')))
{		
	$f_id = $_GET['customernumber'];
	mysql_select_db($dbname);
	$query80 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result80 = mysql_query($query80) or die (mysql_error());
	$row80 = mysql_fetch_array($result80);
	mysql_select_db($dbname2);
	$query65 = "SELECT * FROM tblproactivecallschedule WHERE CustomerNumber = '$f_id'";
	$result65 = mysql_query($query65) or die (mysql_error());
	$row65 = mysql_fetch_array($result65);
	$count65 = mysql_num_rows($result65);
	$scheduleid = $row65['ID'];
	if($count65 > 0)
	{	
		$count = $count65;
	}else
	{
		$count = 0;
	}
	if($count < 1)
	{
		$query66 = "SELECT max(ID) FROM tblproactivecall WHERE CustomerNumber = '$f_id'";
		$result66 = mysql_query($query66) or die (mysql_error());
		$row66 = mysql_fetch_array($result66);
		$callid =  $row66['max(ID)'];
		$query67 = "SELECT * FROM tblproactivecall WHERE ID = '$callid'";
		$result67 = mysql_query($query67) or die (mysql_error());
		$count67 = mysql_num_rows($result67);
		$row67 = mysql_fetch_array($result67);
?>
	<form method="GET" NAME="example13" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td colspan="2">
					New Schedule Required for <b><?php echo $row80['FacilityName'];?></b>:
				</td>
			</tr>
<?php				
			if($count67 > 0)
			{
?>
				<tr>
					<td>
						<input type="radio" name="use" value="1" checked>Last Call Made:
					</td>
					<td>
<?php 
						echo $row67['DateOpened']; 
						echo	'<input type = "hidden" name="l_date" value = "'.$row67['DateOpened'].'">';
?>						
					</td>
				</tr>
<?php		
			}			
?>
			<tr>
				<td>
					<input type="radio" name="use" value="2" <?php if($count67 < 1) {echo 'checked';}?>>Schedule Next Call:
				</td>
				<td colspan = "1" width = "200" class="heading">	
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date1" VALUE="" SIZE=25>
				</td>
				<td>
					<A HREF="#"
 					onClick="cal.select(document.forms['example13'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
 					NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
				</td> 
			</tr>
			<tr>
				<td colspan="1">
					Increment:
				</td>
				<td colspan="1">
					<select name="increment">												
						<option value="1">3 months</option>
						<option value="2">6 months</option>
						<option value="3">12 months</option>
					</select>
				</td>
			</tr>
<?php
					echo	'<input type = "hidden" name="fid" value = "'.$f_id.'">';
					echo	'<input type = "hidden" name="action" value = "savesch">';
					if((isset($_GET['fr'])) && ($_GET['fr'] == 'nosch'))
					{
						echo	'<input type = "hidden" name="fr" value = "1">';
					}
?>			
			<tr>
				<td>
					<input type="submit" name="savesch" value="Save">
				</td>
			</tr>			
		</table>
	</form>	
<?php						
	}else
	{
		$x=0;
		$query110 = "SELECT ExpectedDate,CallID FROM tblproactivescheduletracker WHERE ScheduleID = '$scheduleid'";
		$result110 = mysql_query($query110) or die (mysql_error());
		while($row110 = mysql_fetch_array($result110))
		{
			$expecteddates = $row110['ExpectedDate'];
			$call_tracker = $row110['CallID'];
			if(($expecteddates <= $date) && (is_null($call_tracker)))
			{
				echo $expecteddates;
			}
			if($x == 0)
			{
				if(($expecteddates > $date) && (is_null($call_tracker)))
				{
					$x = 1;
					$nextdate = $expecteddates;
				}else
				{
					$nextdate = 'Please Choose';
				}
			}
		}
		//$nextdate = $row65['NextCall'];
?>
	<form method="GET" NAME="example13" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
<?php
			if((isset($_GET['up'])) && ($_GET['up'] == 1))
			{
				$update = 'Changes have been saved';
?>
				<tr>
					<td class="heading" colspan="2"><font color="#FF0000">
						<?php echo $update; ?>
					</font></td>
				</tr>
<?php				
			}
?>
<?php
			if((isset($_GET['add'])) && ($_GET['add'] == 1))
			{
				$update = 'Schedule Added';
?>
				<tr>
					<td class="heading" colspan="2"><font color="#FF0000">
						<?php echo $update; ?>
					</font></td>
				</tr>
<?php				
			}
?>
			<tr>
				<td>
				Current Schedule for <b><?php echo $row80['FacilityName']; ?></b>:
				</td>
			</tr>
			<tr>
				<td colspan="1">
					Next Call: 
				</td> 
				<td colspan = "1" width = "200" class="heading">	
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date1" VALUE="<?php echo $nextdate;?>" SIZE=25>
				</td>
				<td>
					<A HREF="#"
 					onClick="cal.select(document.forms['example13'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
 					NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
				</td> 
			</tr>		
			<tr>
				<td colspan="1">
					Increment:
				</td>
				<td colspan="1">
					<select name="increment">								
						<option value="1" <?php if($row65['Freq'] == 3){ echo 'selected="selected"'; } ?>>3 months</option>
						<option value="2" <?php if($row65['Freq'] == 6){ echo 'selected="selected"'; } ?>>6 months</option>
						<option value="3" <?php if($row65['Freq'] == 12){ echo 'selected="selected"'; } ?>>12 months</option>
					</select>
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="fid" value = "'.$f_id.'">';
			echo	'<input type = "hidden" name="action" value = "savesch">';
			echo	'<input type = "hidden" name="use" value = "4">';
?>			
			<tr>
				<td>
					<input type="submit" name="savesch" value="Save">
				</td>				
				<td>
					<input type="submit" name="view_no_schedule" value="View Customers with No Schedule">
				</td>					
				<td>
					<input type="submit" name="view_table" value="View Schedule Table">
				</td>
				<td>
					<input type="submit" name="proactive_home" value="Home">
				</td>								
			</tr>			
		</table>
	</form>	
<?php			
	}
}	
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && ((isset($_GET['action'])) && ($_GET['action'] == 'list')))
{
	mysql_select_db($dbname);
	$query72 = "SELECT CustomerNumber,FacilityName FROM tblfacilities ORDER BY FacilityName";
	$result72 = mysql_query($query72) or die (mysql_error());
	$inc = $_GET['inc'];	
?>
	<table>
		<tr>
			<td colspan="1">
				Facilities to call every <?php echo $inc; ?> months.
			</td>	
			<td>
<?php 								
				echo '<input type="button" value="Back" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'">';
?> 	
			</td>
		</tr>
		<tr>		
			<td colspan="3">
				Click on any facility to view or update their next call or increment between calls.
			</td>
		</tr>
		<tr>
			<td class="heading" width="260">
				Facility:
			</td>
			<td class="heading" width="160">
				Next Scheduled Call:
			</td>
			<td class="heading" width="160">
				Previous Call Date:
			</td>
		</tr>
<?php		
	while($row72 = mysql_fetch_array($result72))
	{
		$id = $row72['CustomerNumber'];
		mysql_select_db($dbname2);
		$query71 = "SELECT * FROM tblproactivecallschedule WHERE Freq = '$inc'";
		$result71 = mysql_query($query71) or die (mysql_error());
		while($row71 = mysql_fetch_array($result71))
		{			
			if($id == $row71['CustomerNumber'])
			{
				$scheduleid = $row71['ID'];
				$query73 = "SELECT ExpectedDate FROM tblproactivescheduletracker WHERE ScheduleID = '$scheduleid' AND CallID IS NULL";
				$result73 = mysql_query($query73) or die (mysql_error());
				$row73 = mysql_fetch_array($result73);
				$nextcall1 = strtotime($row73['ExpectedDate']);
				$nextcall = date('F d, Y',$nextcall1);
				$lastcall2 = $row71['LastCall'];
				$lastcall1 = strtotime($row71['LastCall']);
				if($lastcall2 <> '0000-00-00 00:00:00')
				{
					$lastcall = date('F d, Y',$lastcall1);
				}else
				{
					$lastcall = 'Call not yet completed';
				}
?>				
				<tr>
					<td>
						<?php echo '<a href=" ../sales/proactivecall.php?view=admin&action=addsch&customernumber='.$id.'">'. $row72['FacilityName'].'</a>'; ?>
					</td>
					<td>
						<?php echo $nextcall; ?>
					</td>
					<td>
						<?php echo $lastcall; ?>
					</td>
				</tr>
<?php				
			}
		}
	}
?>
</table>
<?php		
}	
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && ((isset($_GET['action'])) && ($_GET['action'] == 'viewnosch')))
{
?>
	<table>
		<tr>
			<td class="heading">
				Customers without Schedules
			</td>
		</tr>
	</table>
	<table>
<?php	
	$var = '';
	mysql_select_db($dbname2);
	$query75 = "SELECT CustomerNumber FROM tblproactivecallschedule WHERE Freq <> 0";
	$result75 = mysql_query($query75) or die (mysql_error());
	while($row75 = mysql_fetch_assoc($result75))
	{
		$var .= $row75['CustomerNumber'].',';
	}
	$var = substr($var,0,-1);
	//echo $var; 
	mysql_select_db($dbname);
	$query76 = "SELECT CustomerNumber, FacilityName FROM tblfacilities WHERE SystemType <> 'AT HOME' AND Active = -1 AND CustomerNumber NOT IN ($var) ORDER BY FacilityName";
	$result76 = mysql_query($query76) or die (mysql_error());
	$a = '';
?>
	<tr>
		<td colspan="26">
			Click on a letter to jump Customers starting with that letter.
		</td>
	</tr>
	<tr>
<?php			
		while($row76 = mysql_fetch_array($result76))
		{
			$string = $row76['FacilityName'];
			$b = $string[0];	
			if($b <> $a)
			{
?>
				<td align="center" width="23" height="23" background="images/blank_glass-buttonini.png">
							<a href="<?php echo '#'.$b; ?>"><font face="Arial" size="2" color="white"><b><?php echo $b; ?></b>
				</font></a></td>
<?php
			}
			$a = $b;
		}
?>						
		</tr>	
	</table>

<?php				
	$query74 = "SELECT CustomerNumber, FacilityName FROM tblfacilities WHERE refCompany = 'HomeFree' AND SystemType <> 'AT HOME' AND Active = -1 AND CustomerNumber NOT IN ($var) ORDER BY FacilityName";
	$result74 = mysql_query($query74) or die (mysql_error());
	$z = '';
	while($row74 = mysql_fetch_array($result74))
	{
?>
	<table cellspacing="5">
<?php				
		$id = $row74['CustomerNumber'];
		$string = $row74['FacilityName'];
		$x = $string[0];	
		if($x <> $z)
		{
?>
			<tr>
				<td class="bigheading" width="30"><font color="#477BA4"><a name="<?php echo $x; ?>">
<?php				
					echo $string[0];
?>
				</a></font></td>
				<td align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="proactivecall.php?view=admin&action=viewnosch"><font face="Arial" size="2" color="white"><b>Back to Top</b>
				</font></a></td>		
				<td align="center" width="128" height="25" background="images/bigbutton2.png">
						<a href="proactivecall.php"><font face="Arial" size="2" color="white"><b>Proactive Home</b>
				</font></a></td>							
			</tr>
<?php					
		}	
?>
		</table>
		<table>		
<?php			
		$z = $x;
?>
		<tr>
			<td width="380">
				<?php echo $row74['FacilityName'];?>
			</td>
			<td align="center" width="150">
				<a href="proactivecall.php?view=admin&action=addsch&fr=nosch&customernumber=<?php echo $id; ?>">Create Schedule
			</a></td>
			<td align="center">
				<a href="proactivecall.php?view=newticketform&f_id=<?php echo $id; ?>">Start Call
			</a></td>			
		</tr>
<?php						
	}
?>
	</table>
<?php	
}
/*******************************************************REPORT START***************************************/
if((isset($_GET['view'])) && ($_GET['view'] == 'reports'))
{
?>
	<table width="750">
		<tr>
			<td class="border">
				<table width="350">
					<tr>
						<td align="center" class="heading">
							Proactive Report Center
						</td>
					</tr>					
					<tr>
						<td>
							Quick Reports:
						</td>
					</tr>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=read&id=belowop">Below Average Operational</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=read&id=belowtech">Below Average Technical Support</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=read&id=belowsm">Below Average Sales and Marketing</a>
						</td>
					</tr>			
				</table>
			</td>
			<td>
			<td class="border">
				<table width="350">
					<tr>
						<td align="center" class="heading">
							Installation Report Center
						</td>
					</tr>					
					<tr>
						<td>
							Quick Reports:
						</td>
					</tr>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=read&id=belowproj">Below Average Project Management Experience</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=read&id=belowqual">Below Average Quality of Installation</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href=" ../sales/proactivecall.php?view=read&id=belowintro">Below Average Intro Training</a>
						</td>
					</tr>				
				</table>
			</td>
		</tr>
	</table>
	<table width="750">
		<tr>
			<td align="center" class="heading" colspan="2">
				Advanced Reporting
			</td>
		</tr>
		<tr>
			<td>
				<a href=" ../sales/proactivecall.php?view=adv&id=advpro">Advanced Proactive Call Report per customer</a>
			</td>
			<td>
				<a href=" ../sales/proactivecall.php?view=adv&id=advinst">Advanced Install Call Report per customer</a>
			</td>			
		</tr>
		<tr>
			<td>
				<a href=" ../sales/proactivecall.php?view=adv&id=advprotime">Advanced Proactive Call Report Over Time</a>
			</td>
			<td>
				<a href=" ../sales/proactivecall.php?view=adv&id=advprotimeinst">Advanced Install Call Report Over Time</a>
			</td>
		</tr>
		<tr>
			<td>
				<button onClick="window.location='proactivecall.php'">Done</button>
			</td>
		</tr>		
	</table>	
<?php	
}
if((isset($_GET['view'])) && ($_GET['view'] == 'read'))
{
?>
	<table width="750">
		<tr>
			<td class="bigheading">
				Results:
			</td>
		</tr>
<?php
		if(((isset($_GET['view'])) && ($_GET['view'] == 'read')) && ((isset($_GET['id'])) && ($_GET['id'] == 'belowop')))
		{
			mysql_select_db($dbname2);
			$query51 = "SELECT max(ID) FROM tblproactivecall WHERE Successful = 1 GROUP BY CustomerNumber";
			$result51 = mysql_query($query51) or die (mysql_error());
			while($row51 = mysql_fetch_array($result51))	
			{	
				mysql_select_db($dbname2);
				$id = $row51['max(ID)'];
				$query50 = "SELECT count(*) AS Count FROM tblproactiveresults RIGHT JOIN tblproactivequestions ON 
										tblproactiveresults.QID = tblproactivequestions.ID WHERE tblproactiveresults.Result < 3 AND 
										tblproactiveresults.Result > 0 AND tblproactiveresults.CallID = '$id' AND tblproactivequestions.Dept = 1 
										GROUP BY tblproactiveresults.CallID";
				$result50 = mysql_query($query50) or die (mysql_error());
				$row50 = mysql_fetch_array($result50);
				if($row50['Count'] > 0) 
				{
					$Count = $row50['Count'];
				}else
				{
					$Count = 0;
				}
				if($Count > 0)
				{
					mysql_select_db($dbname2);
					$callid = $id;
					$query52 = "SELECT CustomerNumber FROM tblproactivecall WHERE ID = '$id'";
					$result52 = mysql_query($query52) or die (mysql_error());
					while($row52 = mysql_fetch_array($result52))
					{
						$custid = $row52['CustomerNumber'];
						mysql_select_db($dbname);
						$query53 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custid' ORDER BY FacilityName";
						$result53 = mysql_query($query53) or die (mysql_error());
						while($row53 = mysql_fetch_array($result53))
						{
	?>
							<tr>
								<td>
									<?php echo $row53['FacilityName']; ?>
								</td>
							</tr>
	<?php							
						}	
					}
				}				
			}
		}
		if(((isset($_GET['view'])) && ($_GET['view'] == 'read')) && ((isset($_GET['id'])) && ($_GET['id'] == 'belowtech')))
		{
			mysql_select_db($dbname2);
			$query51 = "SELECT max(ID) FROM tblproactivecall WHERE Successful = 1 GROUP BY CustomerNumber";
			$result51 = mysql_query($query51) or die (mysql_error());
			while($row51 = mysql_fetch_array($result51))	
			{	
				mysql_select_db($dbname2);
				$id = $row51['max(ID)'];
				$query50 = "SELECT count(*) AS Count FROM tblproactiveresults RIGHT JOIN tblproactivequestions ON 
										tblproactiveresults.QID = tblproactivequestions.ID WHERE tblproactiveresults.Result < 3 AND tblproactiveresults.Result > 0 
										AND tblproactiveresults.CallID = '$id' AND tblproactivequestions.Dept = 2 GROUP BY tblproactiveresults.CallID";
				$result50 = mysql_query($query50) or die (mysql_error());
				$row50 = mysql_fetch_array($result50);
				if($row50['Count'] > 0) 
				{
					$Count = $row50['Count'];
				}else
				{
					$Count = 0;
				}
				if($Count > 0)
				{
					mysql_select_db($dbname2);
					$callid = $id;
					$query52 = "SELECT CustomerNumber FROM tblproactivecall WHERE ID = '$id'";
					$result52 = mysql_query($query52) or die (mysql_error());
					while($row52 = mysql_fetch_array($result52))
					{
						$custid = $row52['CustomerNumber'];
						mysql_select_db($dbname);
						$query53 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custid' ORDER BY FacilityName";
						$result53 = mysql_query($query53) or die (mysql_error());
						while($row53 = mysql_fetch_array($result53))
						{
	?>
							<tr>
								<td>
									<?php echo $row53['FacilityName']; ?>
								</td>
							</tr>
	<?php							
						}	
					}
				}				
			}
		}	
		if(((isset($_GET['view'])) && ($_GET['view'] == 'read')) && ((isset($_GET['id'])) && ($_GET['id'] == 'belowsm')))
		{
			mysql_select_db($dbname2);
			$query51 = "SELECT max(ID) FROM tblproactivecall WHERE Successful = 1 GROUP BY CustomerNumber";
			$result51 = mysql_query($query51) or die (mysql_error());
			while($row51 = mysql_fetch_array($result51))	
			{	
				mysql_select_db($dbname2);
				$id = $row51['max(ID)'];
				$query50 = "SELECT count(*) AS Count FROM tblproactiveresults RIGHT JOIN tblproactivequestions ON 
										tblproactiveresults.QID = tblproactivequestions.ID WHERE tblproactiveresults.Result < 3 AND tblproactiveresults.Result > 0 
										AND tblproactiveresults.CallID = '$id' AND tblproactivequestions.Dept = 3 GROUP BY tblproactiveresults.CallID";
				$result50 = mysql_query($query50) or die (mysql_error());
				$row50 = mysql_fetch_array($result50);
				if($row50['Count'] > 0) 
				{
					$Count = $row50['Count'];
				}else
				{
					$Count = 0;
				}
				if($Count > 0)
				{
					mysql_select_db($dbname2);
					$callid = $id;
					$query52 = "SELECT CustomerNumber FROM tblproactivecall WHERE ID = '$id'";
					$result52 = mysql_query($query52) or die (mysql_error());
					while($row52 = mysql_fetch_array($result52))
					{
						$custid = $row52['CustomerNumber'];
						mysql_select_db($dbname);
						$query53 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custid' ORDER BY FacilityName";
						$result53 = mysql_query($query53) or die (mysql_error());
						while($row53 = mysql_fetch_array($result53))
						{
	?>
							<tr>
								<td>
									<?php echo $row53['FacilityName']; ?>
								</td>
							</tr>
	<?php							
						}	
					}
				}				
			}
		}
		if(((isset($_GET['view'])) && ($_GET['view'] == 'read')) && ((isset($_GET['id'])) && ($_GET['id'] == 'belowproj')))
		{
			mysql_select_db($dbname2);
			$query51 = "SELECT max(ID) FROM tblproactivecall WHERE Successful = 1 GROUP BY CustomerNumber";
			$result51 = mysql_query($query51) or die (mysql_error());
			while($row51 = mysql_fetch_array($result51))	
			{	
				mysql_select_db($dbname2);
				$id = $row51['max(ID)'];
				$query50 = "SELECT count(*) AS Count FROM tblproactiveresults RIGHT JOIN tblproactivequestions ON 
										tblproactiveresults.QID = tblproactivequestions.ID WHERE tblproactiveresults.Result < 3 AND 
										tblproactiveresults.Result > 0 AND tblproactiveresults.CallID = '$id' AND tblproactivequestions.Dept = 4 
										GROUP BY tblproactiveresults.CallID";
				$result50 = mysql_query($query50) or die (mysql_error());
				$row50 = mysql_fetch_array($result50);
				if($row50['Count'] > 0) 
				{
					$Count = $row50['Count'];
				}else
				{
					$Count = 0;
				}
				if($Count > 0)
				{
					mysql_select_db($dbname2);
					$callid = $id;
					$query52 = "SELECT CustomerNumber FROM tblproactivecall WHERE ID = '$id'";
					$result52 = mysql_query($query52) or die (mysql_error());
					while($row52 = mysql_fetch_array($result52))
					{
						$custid = $row52['CustomerNumber'];
						mysql_select_db($dbname);
						$query53 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custid' ORDER BY FacilityName";
						$result53 = mysql_query($query53) or die (mysql_error());
						while($row53 = mysql_fetch_array($result53))
						{
	?>
							<tr>
								<td>
									<?php echo $row53['FacilityName']; ?>
								</td>
							</tr>
	<?php							
						}	
					}
				}				
			}
		}
		if(((isset($_GET['view'])) && ($_GET['view'] == 'read')) && ((isset($_GET['id'])) && ($_GET['id'] == 'belowqual')))
		{
			mysql_select_db($dbname2);
			$query51 = "SELECT max(ID) FROM tblproactivecall WHERE Successful = 1 GROUP BY CustomerNumber";
			$result51 = mysql_query($query51) or die (mysql_error());
			while($row51 = mysql_fetch_array($result51))	
			{	
				mysql_select_db($dbname2);
				$id = $row51['max(ID)'];
				$query50 = "SELECT count(*) AS Count FROM tblproactiveresults RIGHT JOIN tblproactivequestions ON 
										tblproactiveresults.QID = tblproactivequestions.ID WHERE tblproactiveresults.Result < 3 AND tblproactiveresults.Result > 0 
										AND tblproactiveresults.CallID = '$id' AND tblproactivequestions.Dept = 5 GROUP BY tblproactiveresults.CallID";
				$result50 = mysql_query($query50) or die (mysql_error());
				$row50 = mysql_fetch_array($result50);
				if($row50['Count'] > 0) 
				{
					$Count = $row50['Count'];
				}else
				{
					$Count = 0;
				}
				if($Count > 0)
				{
					mysql_select_db($dbname2);
					$callid = $id;
					$query52 = "SELECT CustomerNumber FROM tblproactivecall WHERE ID = '$id'";
					$result52 = mysql_query($query52) or die (mysql_error());
					while($row52 = mysql_fetch_array($result52))
					{
						$custid = $row52['CustomerNumber'];
						mysql_select_db($dbname);
						$query53 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custid' ORDER BY FacilityName";
						$result53 = mysql_query($query53) or die (mysql_error());
						while($row53 = mysql_fetch_array($result53))
						{
	?>
							<tr>
								<td>
									<?php echo $row53['FacilityName']; ?>
								</td>
							</tr>
	<?php							
						}	
					}
				}				
			}
		}	
		if(((isset($_GET['view'])) && ($_GET['view'] == 'read')) && ((isset($_GET['id'])) && ($_GET['id'] == 'belowintro')))
		{
			mysql_select_db($dbname2);
			$query51 = "SELECT max(ID) FROM tblproactivecall WHERE Successful = 1 GROUP BY CustomerNumber";
			$result51 = mysql_query($query51) or die (mysql_error());
			while($row51 = mysql_fetch_array($result51))	
			{	
				mysql_select_db($dbname2);
				$id = $row51['max(ID)'];
				$query50 = "SELECT count(*) AS Count FROM tblproactiveresults RIGHT JOIN tblproactivequestions ON 
										tblproactiveresults.QID = tblproactivequestions.ID WHERE tblproactiveresults.Result < 3 AND tblproactiveresults.Result > 0 
										AND tblproactiveresults.CallID = '$id' AND tblproactivequestions.Dept = 6 GROUP BY tblproactiveresults.CallID";
				$result50 = mysql_query($query50) or die (mysql_error());
				$row50 = mysql_fetch_array($result50);
				if($row50['Count'] > 0) 
				{
					$Count = $row50['Count'];
				}else
				{
					$Count = 0;
				}
				if($Count > 0)
				{
					mysql_select_db($dbname2);
					$callid = $id;
					$query52 = "SELECT CustomerNumber FROM tblproactivecall WHERE ID = '$id'";
					$result52 = mysql_query($query52) or die (mysql_error());
					while($row52 = mysql_fetch_array($result52))
					{
						$custid = $row52['CustomerNumber'];
						mysql_select_db($dbname);
						$query53 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$custid' ORDER BY FacilityName";
						$result53 = mysql_query($query53) or die (mysql_error());
						while($row53 = mysql_fetch_array($result53))
						{
	?>
							<tr>
								<td>
									<?php echo $row53['FacilityName']; ?>
								</td>
							</tr>
	<?php							
						}	
					}
				}				
			}
		}		
?>
		<tr>
			<td>
				<button onClick="window.location='proactivecall.php?view=reports'">Done</button>
			</td>
		</tr>
	</table>
<?php											
}
if((isset($_GET['view'])) && ($_GET['view'] == 'adv'))
{
?>
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php			
	mysql_select_db($dbname2);
	if((isset($_GET['id'])) && (($_GET['id'] == 'advpro')) || ($_GET['id'] == 'advprotime'))
	{
		mysql_select_db($dbname2);
		$query54 = "SELECT * FROM tblproactivequestions WHERE Type = 1";
		$result54 = mysql_query($query54) or die (mysql_error());
		$query62 = "SELECT CustomerNumber FROM tblproactivecall WHERE Type = 27 AND Successful = 1 GROUP BY CustomerNumber";
		$result62 = mysql_query($query62) or die (mysql_error());
	}elseif((isset($_GET['id'])) && (($_GET['id'] == 'advinst') || ($_GET['id'] == 'advprotimeinst')))
	{
		mysql_select_db($dbname2);
		$query54 = "SELECT * FROM tblproactivequestions WHERE Type = 2";
		$result54 = mysql_query($query54) or die (mysql_error());
		$query62 = "SELECT CustomerNumber FROM tblproactivecall WHERE Type = 15 AND Successful = 1 GROUP BY CustomerNumber";
		$result62 = mysql_query($query62) or die (mysql_error());
	}	
?>
	<table>	
		<tr>
			<td>
<?php	
				echo '<a href="'.'proactivecall.php'.'">'.' HOME';
?>
			</td>
		</tr>
<?php		
	if(((isset($_GET['id'])) && ($_GET['id'] == 'advpro')) || ((isset($_GET['id'])) && ($_GET['id'] == 'advinst')))
	{	
?>
			<tr>
				<td colspan="1">
					Customer:
				</td>
				<td colspan="2">
					<select name="customernumber">
<?php
					while($row62 = mysql_fetch_array($result62))
					{
						mysql_select_db($dbname);
						$customer = $row62['CustomerNumber'];
						$query61 = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE CustomerNumber = '$customer'";
						$result61 = mysql_query($query61);
						while($row61 = mysql_fetch_array($result61))
						{
?>													
							<option value="<?php echo $row61['CustomerNumber']; ?>">  <?php echo $row61['FacilityName']; ?> </option>
<?php							
						}
					}
?>		
		</table>
<?php
	}else
	{
?>
			<tr>
				<td colspan="1">
					Time Division:
				</td>
				<td colspan="2">
					<select name="timeframe">
						<option value="1">Weekly</option>
						<option value="2">Monthly</option>
						<option value="3">Yearly</option>
					</select>
				</td>
			</tr>
		</table>
<?php
	}		
?>		
		<table>				
			<tr>
				<td>
					FROM:
				</td>
				<td>
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date1" VALUE="" SIZE=25>
				</td>
				<td>
					<A HREF="#"
 					onClick="cal.select(document.forms['example'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
 					NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
				</td>
				<td>
					TO:
				</td>	
				<td>
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date2" VALUE="" SIZE=25>
				</td>
				<td>
					<A HREF="#"
 					onClick="cal.select(document.forms['example'].date2,'anchor2','yyyy/MM/dd hh:mm:ss'); return false;"
 					NAME="anchor2" ID="anchor2"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
				</td>	
			</tr>
			<tr>
				<td colspan="5">
					Questions Included in the Report:
				</td>
			</tr>
<?php
			while($row54 = mysql_fetch_array($result54))
			{
?>				
				<tr>
					<td colspan="5">
						<input type="checkbox" name="<?php echo $row54['ID']; ?>" value="1" checked><?php echo $row54['Question']; ?>
					</td>
				</tr>
<?php			
			}
?>
		</table>
<?php
		if((isset($_GET['id'])) && ($_GET['id'] == 'advpro'))
		{
			echo	'<input type = "hidden" name="view" value = "rptadvpro">';
		}elseif((isset($_GET['id'])) && ($_GET['id'] == 'advinst'))
		{
			echo	'<input type = "hidden" name="view" value = "rptadvinst">';
		}elseif((isset($_GET['id'])) && ($_GET['id'] == 'advprotime'))
		{
			echo	'<input type = "hidden" name="view" value = "rptadvprotime">';
		}elseif((isset($_GET['id'])) && ($_GET['id'] == 'advprotimeinst'))
		{
			echo	'<input type = "hidden" name="view" value = "rptadvproinst">';
		}	
?>		
		<table width="150">				
			<tr>
				<td width="60">
					<input type="submit" value="Run" name="run">
				</td>
				<td>
					<input type="submit" value="Done" name="rpt">
				</td>
			</tr>									
		</table>
	</form>			
<?php			
}
/*************************************************BUILD EXCEL PER CUSTOMER*******************************/
if(((isset($_GET['view'])) && ($_GET['view'] == 'rptadvpro')) || ((isset($_GET['view'])) && ($_GET['view'] == 'rptadvinst')))
{
	// Creating a workbook
  $workbook = new Spreadsheet_Excel_Writer();
  // sending HTTP headers
  $workbook->send('csPortal_Report_'.date('Ymd').'T'.date('His').'.xls');
  // Creating a worksheet
  $worksheet =& $workbook->addWorksheet('Report Details');
  // Creating the format
	$format_wrap =& $workbook->addFormat();
	$format_wrap->setTextWrap( );
	$format_center =& $workbook->addFormat();
	$format_center->setHAlign('center');
	$worksheet->setColumn(0,0,60);
  $worksheet->mergeCells( 0,0,1,0);
  $worksheet->write(1, 0, 'Questions');
  
  $ecol=0;
	$datefrom = $_GET['date1'];
	$dateto = $_GET['date2'];
	$custnum = $_GET['customernumber'];
	mysql_select_db($dbname2);
	$query60 = "SELECT ID FROM tblproactivequestions";
	// WHERE Type = 1
	$result60 = mysql_query($query60);
	mysql_select_db($dbname);
	$query63 = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE CustomerNumber = '$custnum'";
	$result63 = mysql_query($query63);	
	$row63 = mysql_fetch_array($result63);
	$customername = $row63['FacilityName'];
	mysql_select_db($dbname2);
	
	
	$ecol = 0;	
	$erow = 1;
	while($row60 = mysql_fetch_array($result60))
	{
		$getid = $row60['ID'];
		if(isset($_GET[$getid]))
		{
			$callid = $row60['ID'];
			$erow = $erow + 1;
		}else
		{
			$callid=0;
			$erow = $erow;
		}
		$query59 = "SELECT Question FROM tblproactivequestions WHERE ID = '$callid'";
		$result59 = mysql_query($query59);
	  $row59 = mysql_fetch_array($result59);
		/*************************************************DISPLAY SELECTED QUESTIONS*******************************/
	  $worksheet->write($erow, 0, $row59['Question']);	
	}
	if((isset($_GET['view'])) && ($_GET['view'] == 'rptadvpro'))
	{
		$query55 = "SELECT ID,CustomerNumber,DateOpened FROM tblproactivecall WHERE CustomerNumber = '$custnum' AND DateOpened > '$datefrom' AND DateOpened < '$dateto' AND Successful = 1 AND Type = 27";
		$result55 = mysql_query($query55);
		$count55 = mysql_num_rows($result55);
	}else
	{
		$query55 = "SELECT ID,CustomerNumber,DateOpened FROM tblproactivecall WHERE CustomerNumber = '$custnum' AND DateOpened > '$datefrom' AND DateOpened < '$dateto' AND Successful = 1 AND Type = 15";
		$result55 = mysql_query($query55);
		$count55 = mysql_num_rows($result55);
	}
	/*************************************************FORMAT CELLS MERGER FOR CUSTOMER NAME*******************************/
	$worksheet->mergeCells(0,1,0,$count55);
	/*************************************************DISPLAY CUSTOMER NAME*******************************/
	$worksheet->write(0, 1, $customername,$format_center);
	mysql_select_db($dbname2);		
	while($row55 = mysql_fetch_array($result55)) 
	{
		$ecol = $ecol + 1;
		$erow=1;
		/*************************************************FORMAT CELLS WIDTH FOR DATE OPENED*******************************/
		$worksheet->setColumn(0,$ecol,20);
		/*************************************************DISPLAY DATE OPENED*******************************/
		$worksheet->write(1, $ecol, $row55['DateOpened'].' '.'(Date Entered)',$format_wrap);
		/*************************************************SELECTING QUESTIONS FOR RESULT QUERY*******************************/

		mysql_select_db($dbname2);	
		$query38 = "SELECT ID FROM tblproactivequestions";
		$result38 = mysql_query($query38);
		while($row38 = mysql_fetch_array($result38)) 
		{
		 	$qid = $row38['ID'];
			if(isset($_GET[$qid]))
			{
				$qid = $row38['ID'];
				$erow = $erow + 1;
			}else
			{
				$qid = 0;
				$erow = $erow;
			}			 	
		 	$id = $row55['ID'];
			$query56 = "SELECT * FROM tblproactiveresults WHERE CallID = '$id' AND QID = '$qid'";
			$result56 = mysql_query($query56);
			$row56 = mysql_fetch_array($result56);
			$result = $row56['Result'];		
      $worksheet->write($erow, $ecol, $result);
       // include 'includes/db_close.inc.php';
       // Let's send the file	
		}	      		          				
	}
	$workbook->close();
	exit();		
}	
if((isset($_GET['view'])) && ($_GET['view'] == 'rptadvprotime'))
{
	// Creating a workbook
  $workbook = new Spreadsheet_Excel_Writer();
  // sending HTTP headers
  $workbook->send('csPortal_Report_'.date('Ymd').'T'.date('His').'.xls');
  // Creating a worksheet
  $worksheet =& $workbook->addWorksheet('Report Details');
  // Creating the format
  $format_wrap =& $workbook->addFormat();
	$format_wrap->setTextWrap( );
	$format_center =& $workbook->addFormat();
	$format_center->setHAlign('center');
	$format_bold =& $workbook->addFormat();
	$format_bold->setBold();
	$worksheet->setColumn(0,0,60);
  $worksheet->mergeCells( 0,0,1,0);
  $worksheet->write(1, 0, 'Questions');
  //
  /*******************************************************************************/
  mysql_select_db($dbname2);
	$query60 = "SELECT ID FROM tblproactivequestions WHERE Type = 1";
	$result60 = mysql_query($query60);
	$ecol = 0;	
	$erow = 1;
	while($row60 = mysql_fetch_array($result60))
	{
		$getid = $row60['ID'];
		if(isset($_GET[$getid]))
		{
			$callid = $row60['ID'];
			$erow = $erow + 1;
		}else
		{
			$callid=0;
			$erow = $erow;
		}
		$query59 = "SELECT Question FROM tblproactivequestions WHERE ID = '$callid'";
		$result59 = mysql_query($query59);
	  $row59 = mysql_fetch_array($result59);
		/*************************************************DISPLAY SELECTED QUESTIONS*******************************/
	  $worksheet->write($erow, 0, $row59['Question']);	
	}  
	$erow = $erow + 1;
	$worksheet->write($erow, $ecol, 'Calls Entered in period',$format_bold);
  /*********************************************************************************/
	$timeframe = $_GET['timeframe'];
	$datefrom = $_GET['date1'];
	$dateto = $_GET['date2'];
	$enddate = strtotime($dateto);
	$oneweek = 604800;
	$start = strtotime($datefrom);
	/*************************************************CREATE TIMES FOR QUERY*******************************/
	$x=0;
	$ecol = 0;
	if($timeframe == 1)
	{
		for($cursor=$start;$cursor<=$enddate; $cursor = strtotime('+1 week',$cursor))
		{
			if($x == 0)
			{
				$startyear = date('Y',$start);
				$startmonth = date('m',$start);
				$startday = date('d',$start);	
				$startdate1  = mktime(0, 0, 0, date($startmonth), $startday, $startyear);
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = mktime(0, 0, 0, $startmonth, date($startday)+7, $startyear);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);
			}else
			{	
				$startdate1 = $cursor;
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = strtotime('+1 week',$startdate1);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);			
				//echo date('Y-m-d H:i:s',)$nextdate);
			}
			$ecol = $ecol + 1;
			mysql_select_db($dbname2);
			$query38 = "SELECT ID FROM tblproactivequestions WHERE Type = 1";
			$result38 = mysql_query($query38);
			$displaystart = date('Y-m-d',$startdate1);
			$displayend = date('Y-m-d',$nextdate1);
			$worksheet->setColumn(1,$ecol,15);
			$worksheet->write(1, $ecol, $displaystart.'-> '.$displayend,$format_wrap);
			$erow = 1;
			while($row38 = mysql_fetch_array($result38)) 
			{
			 	$qid = $row38['ID'];
				if(isset($_GET[$qid]))
				{
					$erow = ($erow + 1);
					$qid = $row38['ID'];
				}else
				{
					$qid = 0;
					$erow = $erow;
				}	
				$query60 = "SELECT SUM(tblproactiveresults.Result) AS SumOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result60 = mysql_query($query60);	
				$query61 = "SELECT Count(tblproactiveresults.Result) AS CountOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result61 = mysql_query($query61);
				$row61 = mysql_fetch_array($result61);
				while($row60 = mysql_fetch_array($result60))
				{
					$count61 = $row61['CountOfResult'];
					$result = $row60['SumOfResult'];
					if($count61 <> 0)
					{		
						$avg = round(($result / $count61),2);
						$worksheet->write($erow, $ecol, $avg);							
					}
				}				
			}	
			$erow = $erow + 1;
			$worksheet->write($erow, $ecol, $count61,$format_bold);
			$x = 1;
		}
		$workbook->close();
		exit();		
	}
	if($timeframe == 2)
	{
		for($cursor=$start;$cursor<=$enddate; $cursor = strtotime('+1 month',$cursor))
		{
			if($x == 0)
			{
				$startyear = date('Y',$start);
				$startmonth = date('m',$start);
				$startday = date('d',$start);	
				$startdate1  = mktime(0, 0, 0, date($startmonth), $startday, $startyear);
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = mktime(0, 0, 0, date($startmonth)+1, $startday, $startyear);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);
			}else
			{	
				$startdate1 = $cursor;
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = strtotime('+1 month',$startdate1);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);			
				//echo date('Y-m-d H:i:s',)$nextdate);
			}
			$ecol = $ecol + 1;
			mysql_select_db($dbname2);
			$query38 = "SELECT ID FROM tblproactivequestions WHERE Type = 1";
			$result38 = mysql_query($query38);
			$displaystart = date('Y-m-d',$startdate1);
			$displayend = date('Y-m-d',$nextdate1);
			$worksheet->setColumn(1,$ecol,15);
			$worksheet->write(1, $ecol, $displaystart.'-> '.$displayend,$format_wrap);
			$erow = 1;
			while($row38 = mysql_fetch_array($result38)) 
			{
			 	$qid = $row38['ID'];
				if(isset($_GET[$qid]))
				{
					$erow = ($erow + 1);
					$qid = $row38['ID'];
				}else
				{
					$qid = 0;
					$erow = $erow;
				}	
				$query60 = "SELECT SUM(tblproactiveresults.Result) AS SumOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result60 = mysql_query($query60);	
				$query61 = "SELECT Count(tblproactiveresults.Result) AS CountOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result61 = mysql_query($query61);
				$row61 = mysql_fetch_array($result61);
				while($row60 = mysql_fetch_array($result60))
				{
					$count61 = $row61['CountOfResult'];
					$result = $row60['SumOfResult'];
					if($count61 <> 0)
					{		
						$avg = round(($result / $count61),2);
						$worksheet->write($erow, $ecol, $avg);							
					}
				}				
			}	
			$erow = $erow + 1;
			$worksheet->write($erow, $ecol, $count61,$format_bold);			
			$x = 1;
		}
		$workbook->close();
		exit();		
	}		
	if($timeframe == 3)
	{
		for($cursor=$start;$cursor<=$enddate; $cursor = strtotime('+1 year',$cursor))
		{
			if($x == 0)
			{
				$startyear = date('Y',$start);
				$startmonth = date('m',$start);
				$startday = date('d',$start);	
				$startdate1  = mktime(0, 0, 0, date($startmonth), $startday, $startyear);
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = mktime(0, 0, 0, $startmonth, $startday, date($startyear)+1);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);
			}else
			{	
				$startdate1 = $cursor;
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = strtotime('+1 year',$startdate1);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);			
				//echo date('Y-m-d H:i:s',)$nextdate);
			}
			$ecol = $ecol + 1;
			mysql_select_db($dbname2);
			$query38 = "SELECT ID FROM tblproactivequestions WHERE Type = 1";
			$result38 = mysql_query($query38);
			$displaystart = date('Y-m-d',$startdate1);
			$displayend = date('Y-m-d',$nextdate1);
			$worksheet->setColumn(1,$ecol,15);
			$worksheet->write(1, $ecol, $displaystart.'-> '.$displayend,$format_wrap);
			$erow = 1;
			while($row38 = mysql_fetch_array($result38)) 
			{
			 	$qid = $row38['ID'];
				if(isset($_GET[$qid]))
				{
					$erow = ($erow + 1);
					$qid = $row38['ID'];
				}else
				{
					$qid = 0;
					$erow = $erow;
				}	
				$query60 = "SELECT SUM(tblproactiveresults.Result) AS SumOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result60 = mysql_query($query60);	
				$query61 = "SELECT Count(tblproactiveresults.Result) AS CountOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result61 = mysql_query($query61);
				$row61 = mysql_fetch_array($result61);
				while($row60 = mysql_fetch_array($result60))
				{
					$count61 = $row61['CountOfResult'];
					$result = $row60['SumOfResult'];
					if($count61 <> 0)
					{		
						$avg = round(($result / $count61),2);
						$worksheet->write($erow, $ecol, $avg);							
					}
				}				
			}	
			$erow = $erow + 1;
			$worksheet->write($erow, $ecol, $count61,$format_bold);
			$x = 1;
		}
		$workbook->close();
		exit();		
	}		
}
if((isset($_GET['view'])) && ($_GET['view'] == 'rptadvproinst'))
{
	// Creating a workbook
  $workbook = new Spreadsheet_Excel_Writer();
  // sending HTTP headers
  $workbook->send('csPortal_Report_'.date('Ymd').'T'.date('His').'.xls');
  // Creating a worksheet
  $worksheet =& $workbook->addWorksheet('Report Details');
  // Creating the format
  $format_wrap =& $workbook->addFormat();
	$format_wrap->setTextWrap( );
	$format_center =& $workbook->addFormat();
	$format_center->setHAlign('center');
	$format_bold =& $workbook->addFormat();
	$format_bold->setBold();
	$worksheet->setColumn(0,0,60);
  $worksheet->mergeCells( 0,0,1,0);
  $worksheet->write(1, 0, 'Questions');
  //
  /*******************************************************************************/
  mysql_select_db($dbname2);
	$query60 = "SELECT ID FROM tblproactivequestions WHERE Type = 2";
	$result60 = mysql_query($query60);
	$ecol = 0;	
	$erow = 1;
	while($row60 = mysql_fetch_array($result60))
	{
		$getid = $row60['ID'];
		if(isset($_GET[$getid]))
		{
			$callid = $row60['ID'];
			$erow = $erow + 1;
		}else
		{
			$callid=0;
			$erow = $erow;
		}
		$query59 = "SELECT Question FROM tblproactivequestions WHERE ID = '$callid'";
		$result59 = mysql_query($query59);
	  $row59 = mysql_fetch_array($result59);
		/*************************************************DISPLAY SELECTED QUESTIONS*******************************/
	  $worksheet->write($erow, 0, $row59['Question']);	
	}  
  $erow = $erow + 1;
	$worksheet->write($erow, $ecol, 'Calls Entered in period',$format_bold);  
  /*********************************************************************************/
	$timeframe = $_GET['timeframe'];
	$datefrom = $_GET['date1'];
	$dateto = $_GET['date2'];
	$enddate = strtotime($dateto);
	$oneweek = 604800;
	$start = strtotime($datefrom);
	/*************************************************CREATE TIMES FOR QUERY*******************************/
	$x=0;
	$ecol = 0;
	if($timeframe == 1)
	{
		for($cursor=$start;$cursor<=$enddate; $cursor = strtotime('+1 week',$cursor))
		{
			if($x == 0)
			{
				$startyear = date('Y',$start);
				$startmonth = date('m',$start);
				$startday = date('d',$start);	
				$startdate1  = mktime(0, 0, 0, date($startmonth), $startday, $startyear);
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = mktime(0, 0, 0, $startmonth, date($startday)+7, $startyear);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);
			}else
			{	
				$startdate1 = $cursor;
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = strtotime('+1 week',$startdate1);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);			
				//echo date('Y-m-d H:i:s',)$nextdate);
			}
			$ecol = $ecol + 1;
			mysql_select_db($dbname2);
			$query38 = "SELECT ID FROM tblproactivequestions WHERE Type = 2";
			$result38 = mysql_query($query38);
			$displaystart = date('Y-m-d',$startdate1);
			$displayend = date('Y-m-d',$nextdate1);
			$worksheet->setColumn(1,$ecol,15);
			$worksheet->write(1, $ecol, $displaystart.'-> '.$displayend,$format_wrap);
			$erow = 1;
			while($row38 = mysql_fetch_array($result38)) 
			{
			 	$qid = $row38['ID'];
				if(isset($_GET[$qid]))
				{
					$erow = ($erow + 1);
					$qid = $row38['ID'];
				}else
				{
					$qid = 0;
					$erow = $erow;
				}	
				$query60 = "SELECT SUM(tblproactiveresults.Result) AS SumOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result60 = mysql_query($query60);	
				$query61 = "SELECT Count(tblproactiveresults.Result) AS CountOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result61 = mysql_query($query61);
				$row61 = mysql_fetch_array($result61);
				while($row60 = mysql_fetch_array($result60))
				{
					$count61 = $row61['CountOfResult'];
					$result = $row60['SumOfResult'];
					if($count61 <> 0)
					{		
						$avg = round(($result / $count61),2);
						$worksheet->write($erow, $ecol, $avg);							
					}
				}				
			}	
			$erow = $erow + 1;
			$worksheet->write($erow, $ecol, $count61,$format_bold);
			$x = 1;
		}
		$workbook->close();
		exit();		
	}
	if($timeframe == 2)
	{
		for($cursor=$start;$cursor<=$enddate; $cursor = strtotime('+1 month',$cursor))
		{
			if($x == 0)
			{
				$startyear = date('Y',$start);
				$startmonth = date('m',$start);
				$startday = date('d',$start);	
				$startdate1  = mktime(0, 0, 0, date($startmonth), $startday, $startyear);
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = mktime(0, 0, 0, date($startmonth)+1, $startday, $startyear);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);
			}else
			{	
				$startdate1 = $cursor;
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = strtotime('+1 month',$startdate1);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);			
				//echo date('Y-m-d H:i:s',)$nextdate);
			}
			$ecol = $ecol + 1;
			mysql_select_db($dbname2);
			$query38 = "SELECT ID FROM tblproactivequestions WHERE Type = 2";
			$result38 = mysql_query($query38);
			$displaystart = date('Y-m-d',$startdate1);
			$displayend = date('Y-m-d',$nextdate1);
			$worksheet->setColumn(1,$ecol,15);
			$worksheet->write(1, $ecol, $displaystart.'-> '.$displayend,$format_wrap);
			$erow = 1;
			while($row38 = mysql_fetch_array($result38)) 
			{
			 	$qid = $row38['ID'];
				if(isset($_GET[$qid]))
				{
					$erow = ($erow + 1);
					$qid = $row38['ID'];
				}else
				{
					$qid = 0;
					$erow = $erow;
				}	
				$query60 = "SELECT SUM(tblproactiveresults.Result) AS SumOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result60 = mysql_query($query60);	
				$query61 = "SELECT Count(tblproactiveresults.Result) AS CountOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result61 = mysql_query($query61);
				$row61 = mysql_fetch_array($result61);
				while($row60 = mysql_fetch_array($result60))
				{
					$count61 = $row61['CountOfResult'];
					$result = $row60['SumOfResult'];
					if($count61 <> 0)
					{		
						$avg = round(($result / $count61),2);
						$worksheet->write($erow, $ecol, $avg);							
					}
				}		
			}	
			$erow = $erow + 1;
			$worksheet->write($erow, $ecol, $count61,$format_bold);
			$x = 1;
		}
		$workbook->close();
		exit();		
	}		
	if($timeframe == 3)
	{
		for($cursor=$start;$cursor<=$enddate; $cursor = strtotime('+1 year',$cursor))
		{
			if($x == 0)
			{
				$startyear = date('Y',$start);
				$startmonth = date('m',$start);
				$startday = date('d',$start);	
				$startdate1  = mktime(0, 0, 0, date($startmonth), $startday, $startyear);
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = mktime(0, 0, 0, $startmonth, $startday, date($startyear)+1);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);
			}else
			{	
				$startdate1 = $cursor;
				$startdate = date('Y-m-d H:i:s',$startdate1);
				$nextdate1 = strtotime('+1 year',$startdate1);
				$nextdate = date('Y-m-d H:i:s',$nextdate1);			
				//echo date('Y-m-d H:i:s',)$nextdate);
			}
			$ecol = $ecol + 1;
			mysql_select_db($dbname2);
			$query38 = "SELECT ID FROM tblproactivequestions WHERE Type = 2";
			$result38 = mysql_query($query38);
			$displaystart = date('Y-m-d',$startdate1);
			$displayend = date('Y-m-d',$nextdate1);
			$worksheet->setColumn(1,$ecol,15);
			$worksheet->write(1, $ecol, $displaystart.'-> '.$displayend,$format_wrap);
			$erow = 1;
			while($row38 = mysql_fetch_array($result38)) 
			{
			 	$qid = $row38['ID'];
				if(isset($_GET[$qid]))
				{
					$erow = ($erow + 1);
					$qid = $row38['ID'];
				}else
				{
					$qid = 0;
					$erow = $erow;
				}	
				$query60 = "SELECT SUM(tblproactiveresults.Result) AS SumOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result60 = mysql_query($query60);	
				$query61 = "SELECT Count(tblproactiveresults.Result) AS CountOfResult
										FROM tblproactivequestions INNER JOIN (tblproactiveresults INNER JOIN tblproactivecall ON tblproactiveresults.CallID = tblproactivecall.ID) ON tblproactivequestions.ID = tblproactiveresults.QID
										WHERE tblproactivecall.DateOpened > '$startdate' AND tblproactivecall.DateOpened < '$nextdate' AND tblproactiveresults.QID='$qid' AND
										tblproactiveresults.Result > 0";	
				$result61 = mysql_query($query61);
				$row61 = mysql_fetch_array($result61);
				while($row60 = mysql_fetch_array($result60))
				{
					$count61 = $row61['CountOfResult'];
					$result = $row60['SumOfResult'];
					if($count61 <> 0)
					{		
						$avg = round(($result / $count61),2);
						$worksheet->write($erow, $ecol, $avg);							
					}
				}				
			}	
			$erow = $erow + 1;
			$worksheet->write($erow, $ecol, $count61,$format_bold);
			$x = 1;
		}
		$workbook->close();
		exit();		
	}		
}
/*BUILD TABLE FOR SCHEDULE FROM PRIOR TO NEW SCHEDULING*/
if((isset($_GET['view'])) && ($_GET['view'] == 'buildscheduletable')) 
{
/*Takes any Customer that had a schedule created, but no calls logged and created there next x amount of dates*/
	if($_GET['Command'] == 1)
	{

?>
		<link rel="stylesheet" type="text/css" href="../csPortal_Layout.css" />
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<title>Proactive Call Center</title>
		<table>
			<tr>
				<td>
					Yep
				</td>
			</tr>
<?php			
		$x = -1;
		
		mysql_select_db($dbname2);
		$query90 = "SELECT ID,CustomerNumber,Freq,NextCall,LastCall FROM tblproactivecallschedule";
		$result90 = mysql_query($query90) or die (mysql_error());
		while($row90 = mysql_fetch_array($result90))
		{
			mysql_select_db($dbname2);
			$cust_num = $row90['CustomerNumber'];
			$scheduleid = $row90['ID'];
			$nextcall = $row90['NextCall'];
			$nextcall1 = strtotime($nextcall);
			$year = date('Y',$nextcall1);	
			$month = date('m',$nextcall1);
			$inc = $row90['Freq'];
			$lastcall = $row90['LastCall'];
			$x = -1;
			if($inc == 12)
			{
				$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
			}
			if($inc == 6)
			{
				$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
			}
			if($inc == 3)
			{
				$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40);
			}
			if($lastcall == '0000-00-00 00:00:00')
			{
				$day = date('d',$nextcall1);
				$month = date('m',$nextcall1);
				$year = date('Y',$nextcall1);			
				foreach($array as $val)
				{
						$x = $x + 1;
						$inc1 = $inc * $x;
						$newdate1 = mktime(0,0,0, date($month)+$inc1, $day, $year);
						$expectedcall = date('Y-m-d H:i:s',$newdate1);	
						$query94 = "INSERT INTO tblproactivescheduletracker (ScheduleID, ExpectedDate) VALUES ('$scheduleid','$expectedcall')";
						mysql_query($query94) or die(mysql_error());
						$x = $x;
				}			
			}			
		}
	}
	if($_GET['Command'] == 2)
	/*Takes any Customer that had a schedule created and at least one call logged and created there next x amount of dates including
	the one that was last logged*/
	{

?>
		<link rel="stylesheet" type="text/css" href="../csPortal_Layout.css" />
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<title>Proactive Call Center</title>
		<table>
			<tr>
				<td>
					Yep
				</td>
			</tr>
<?php			
		$x = -1;
		
		mysql_select_db($dbname2);
		$query90 = "SELECT ID,CustomerNumber,Freq,NextCall,LastCall FROM tblproactivecallschedule WHERE NextCall < '2010-01-01 00:00:00'";
		$result90 = mysql_query($query90) or die (mysql_error());
		while($row90 = mysql_fetch_array($result90))
		{
			mysql_select_db($dbname2);
			$cust_num = $row90['CustomerNumber'];
			$scheduleid = $row90['ID'];
			$nextcall = $row90['NextCall'];
			$nextcall1 = strtotime($nextcall);
			$year = date('Y',$nextcall1);	
			$month = date('m',$nextcall1);
			$inc = $row90['Freq'];
			$lastcall = $row90['LastCall'];
			$query91 = "SELECT ExpectedDate FROM tblproactivescheduletracker WHERE ScheduleID = '$scheduleid' AND ExpectedDate > '2010-01-01 00:00:00'";
			$result91 = mysql_query($query91) or die (mysql_error());
			$row91 = mysql_fetch_array($result91);
			$callid = $row91['max(ID)'];
			$query109 = "UPDATE ";
			$x = -2;
			/*
			if($inc == 12)
			{
				$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
			}
			if($inc == 6)
			{
				$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
			}
			if($inc == 3)
			{
				$array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40);
			}
			if($lastcall <> '0000-00-00 00:00:00')
			{
				$day = date('d',$nextcall1);
				$month = date('m',$nextcall1);
				$year = date('Y',$nextcall1);			
				foreach($array as $val)
				{
					$x = $x + 1;
					$inc1 = $inc * $x;
					$newdate1 = mktime(0,0,0, date($month)+$inc1, $day, $year);
					$expectedcall = date('Y-m-d H:i:s',$newdate1);	
					if($x == -1)
					{
						$query94 = "INSERT INTO tblproactivescheduletracker (ScheduleID, ExpectedDate,ActualDate,CallID) VALUES ('$scheduleid','$expectedcall','$lastcall','$callid')";
						mysql_query($query94) or die(mysql_error());
					}else
					{
						$query94 = "INSERT INTO tblproactivescheduletracker (ScheduleID, ExpectedDate) VALUES ('$scheduleid','$expectedcall')";
						mysql_query($query94) or die(mysql_error());
					}
					$x = $x;
				}			
			}
			*/						
		}				
	}
	if($_GET['Command'] == 3)
	{
		mysql_select_db($dbname2);
		$query95 = "SELECT ID FROM tblproactivecallschedule";
		$result95 = mysql_query($query95) or die (mysql_error());
		while($row95 = mysql_fetch_array($result95))
		{
			$id = $row95['ID'];
			$query96 = "SELECT ID FROM tblproactivescheduletracker WHERE ScheduleID = '$id'";
			$result96 = mysql_query($query96) or die (mysql_error());
			$row96 = mysql_num_rows($result96);
			if($row96 > 1)
			{
				echo $id.'<br>';
			}
		}
	}
?>
	</table>
<?php	
}
if(((isset($_GET['view'])) && ($_GET['view'] == 'admin')) && ((isset($_GET['action'])) && ($_GET['action']=='viewtable')))
{
	mysql_select_db($dbname2);
	if(isset($_GET['year']))
	{
		$viewyear = $_GET['year'];
		$startdate = $viewyear.'-01-01';
		$enddate = $viewyear.'-12-31';
	}else
	{
		$viewyear = date('Y');
		$startdate = $viewyear.'-01-01';
		$enddate = $viewyear.'-12-31';
	}
	$jan = 0;
	$feb = 0;
	$mar = 0;
	$apr = 0;
	$may = 0;
	$jun = 0;
	$jul = 0;
	$aug = 0;
	$sep = 0;
	$oct = 0;
	$nov = 0;
	$dec = 0;
	$query100 = "SELECT ID,ExpectedDate FROM tblproactivescheduletracker WHERE ExpectedDate >= '$startdate' AND ExpectedDate <= '$enddate'";
	$result100 = mysql_query($query100) or die (mysql_error());
	while($row100 = mysql_fetch_array($result100))
	{
		$count_expected_date = $row100['ExpectedDate'];
		$to_time_count_expected_date = strtotime($count_expected_date);
		$month_of_count_expected_date = date('m',$to_time_count_expected_date);
		if($month_of_count_expected_date == '01')
		{
			$jan = $jan + 1;
		}
		if($month_of_count_expected_date == '02')
		{
			$feb = $feb + 1;
		}
		if($month_of_count_expected_date == '03')
		{
			$mar = $mar + 1;
		}
		if($month_of_count_expected_date == '04')
		{
			$apr = $apr + 1;
		}
		if($month_of_count_expected_date == '05')
		{
			$may = $may + 1;
		}
		if($month_of_count_expected_date == '06')
		{
			$jun = $jun + 1;
		}
		if($month_of_count_expected_date == '07')
		{
			$jul = $jul + 1;
		}
		if($month_of_count_expected_date == '08')
		{
			$aug = $aug + 1;
		}
		if($month_of_count_expected_date == '09')
		{
			$sep = $sep + 1;
		}
		if($month_of_count_expected_date == '10')
		{
			$oct = $oct + 1;
		}
		if($month_of_count_expected_date == '11')
		{
			$nov = $nov + 1;
		}
		if($month_of_count_expected_date == '12')
		{
			$dec = $dec + 1;
		}
	}
	
?>
<link rel="stylesheet" type="text/css" href="../csPortal_Layout.css" />
	<table>
		<tr>
			<td colspan="14">
				<h1>Year: <?php echo $viewyear; ?></h1>
			</td>
		</tr>		
	<table width="3000" style='table-layout:fixed'>				
		<tr>
			<td width="300" class="SectionNav2">
				Customer
			</td>
			<td width="80" class="SectionNav2">
				Calls / Year
			</td>			
			<td width="150" class="SectionNav2">
				January (<?php echo $jan; ?>)
			</td>
			<td width="150" class="SectionNav2">
				February (<?php echo $feb; ?>)
			</td>
			<td width="150" class="SectionNav2">
				March (<?php echo $mar; ?>)
			</td>
			<td width="150" class="SectionNav2">
				April (<?php echo $apr; ?>)
			</td>
			<td width="150" class="SectionNav2">
				May (<?php echo $may; ?>)
			</td>
			<td width="150" class="SectionNav2">
				June (<?php echo $jun; ?>)
			</td>			
			<td width="150" class="SectionNav2">
				July (<?php echo $jul; ?>)
			</td>
			<td width="150" class="SectionNav2">
				August (<?php echo $aug; ?>)
			</td>
			<td width="150" class="SectionNav2">
				September (<?php echo $sep; ?>)
			</td>
			<td width="150" class="SectionNav2">
				October (<?php echo $oct; ?>)
			</td>
			<td width="150" class="SectionNav2">
				November (<?php echo $nov; ?>)
			</td>			
			<td width="150" class="SectionNav2"> 
				December (<?php echo $dec; ?>)
			</td>	
		</tr>								
<?php
		mysql_select_db($dbname);
		$query99 = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE Active = -1 ORDER BY FacilityName";
		$result99 = mysql_query($query99) or die (mysql_error());
		while($row99 = mysql_fetch_array($result99))
		{
			mysql_select_db($dbname2);
			$cust_num = $row99['CustomerNumber'];
			$query97 = "SELECT ID,CustomerNumber,Freq FROM tblproactivecallschedule WHERE CustomerNumber = '$cust_num'";
			$result97 = mysql_query($query97) or die (mysql_error());
			while($row97 = mysql_fetch_array($result97))
			{	
				$scheduleid = $row97['ID'];
				$customername = $row99['FacilityName'];
				$inc = $row97['Freq'];
				if($inc == 12)
				{
					$inc = 1;
				}
				if($inc == 6)
				{
					$inc = 2;
				}
				if($inc == 3)
				{
					$inc = 4;
				}

?>
				<tr>
					<td width="300" class="SectionNav3">
						 <a href="proactivecall.php?view=proactivehistory&fid=<?php echo $cust_num; ?>"><?php echo $customername; ?></a>
					</td>
					<td width="80" class="SectionNav3">
						<?php echo $inc; ?>
					</td>						
<?php		
					mysql_select_db($dbname2);
					$query98 = "SELECT * FROM tblproactivescheduletracker WHERE ScheduleID = '$scheduleid' AND ExpectedDate >= '$startdate' AND ExpectedDate <= '$enddate'";
					$result98 = mysql_query($query98) or die (mysql_error());
					$array_a = array();
					$array_b = array();
					$a = 0;
					$scheduleidy = 0;
					while($row98 = mysql_fetch_array($result98))
					{			
						$callid = $row98['CallID'];
						$query112 = "SELECT Message,callback FROM tblproactivecall WHERE ID = '$callid'";		
						$result112 = mysql_query($query112) or die (mysql_error());
						$row112 = mysql_fetch_array($result112);
						$message_check = $row112['Message'];
						$callback_check = $row112['callback'];
						if($callback_check == -1 && $message_check == 1)
						{
							$voicemail = 1;
						}else
						{
							$voicemail = 0;
						}								
						$scheduleidx = $row98['ScheduleID'];
						if($scheduleidx <> $scheduleidy)
						{
							unset($array_a);
							unset($array_b);
							$a = 0;
						}
						$a = $a + 1;
						$expecteddate = $row98['ExpectedDate'];
						$actualdate = $row98['ActualDate'];
						$expecteddatetotime = strtotime($expecteddate);
						$expectedmonth = date('m',$expecteddatetotime);
						$expectedday = date('d',$expecteddatetotime);
						$expectedyear = date('d',$expecteddatetotime);
						$actualdatetotime = strtotime($actualdate);
						$actualmonth = date('m',$actualdatetotime);
						$actualday = date('d',$actualdatetotime);
						$actualyear = date('Y',$actualdatetotime);
						$compare_expected_time = mktime(23,59,59,$expectedmonth,$expectedday,$expectedyear);
						$compare_expected_date = date('H:i:s Y-m-d',$compare_expected_time);
						$display_expected_date = $expectedmonth.'-'.$expectedday;
						$display_actual_date = $actualmonth.'-'.$actualday;
						//echo $compare_expected_date;
						if(is_null($actualdate))
						{
							$display = $display_expected_date;
						}elseif($actualdate == 0)
						{
							$display = '<font color="FF0000">'.$display_expected_date. '/' . 'Not Completed</font>';
						}elseif($actualdate > 0 && $voicemail == 1)
						{
							$display = '<font color="0000FF">'.$display_expected_date. '/' . $display_actual_date. '('.$callid.')</font>';
						}else
						{
							$display = $display_expected_date. '/' . $display_actual_date. '('.$callid.')';
						}
						$array_a[$a] = $expectedmonth;
						$array_b[$a] = $display;
						//$array_c[$a] = $display_actual_date;
						$scheduleidy = $scheduleidx;
						$c = array_combine($array_a, $array_b);						
					}
					//print_r ($c);
?>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('01',$c))
						{
							print_r ($c['01']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('02',$c))
						{
							print_r ($c['02']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('03',$c))
						{
							print_r ($c['03']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('04',$c))
						{
							print_r ($c['04']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('05',$c))
						{
							print_r ($c['05']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('06',$c))
						{
							print_r ($c['06']);
						}else
						{
							echo 'x';
						}
?>
						</td>			
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('07',$c))
						{
							print_r ($c['07']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('08',$c))
						{
							print_r ($c['08']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('09',$c))
						{
							print_r ($c['09']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('10',$c))
						{
							print_r ($c['10']);
						}else
						{
							echo 'x';
						}
?>
						</td>
						<td width="150" class="SectionNav3">
<?php
						if(array_key_exists('11',$c))
						{
							print_r ($c['11']);
						}else
						{
							echo 'x';
						}
?>
						</td>			
						<td width="150" class="SectionNav3"> 
<?php
						if(array_key_exists('12',$c))
						{
							print_r ($c['12']);
						}else
						{
							echo 'x';
						}
?>
						</td>	
				</tr>
				
<?php			
			}
		}
?>
	</table>
<?php	
}
if((isset($_GET['view'])) && ($_GET['view'] == 'getcall'))
{
?>
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width="750">
<?php	
		mysql_select_db($dbname2);
		$f_id = $_GET['fid'];
		$actual_date = $_GET['a_date'];
		$id_of_call = $_GET['callid'];
		$query107 = "SELECT ID FROM tblproactivecallschedule WHERE CustomerNumber = '$f_id'";
		$result107 = mysql_query($query107) or die (mysql_error()); 
		$row107 = mysql_fetch_array($result107);
		$scheduleid = $row107['ID'];
		$query108 = "SELECT * FROM tblproactivescheduletracker WHERE ScheduleID = '$scheduleid' AND CallID IS NULL LIMIT 3";
		$result108 = mysql_query($query108) or die (mysql_error()); 
		echo	'<input type = "hidden" name="view" value = "add_call">';
		echo	'<input type = "hidden" name="a_date" value = "'.$actual_date.'">';
		echo	'<input type = "hidden" name="id_of_call" value = "'.$id_of_call.'">';
		while($row108 = mysql_fetch_array($result108))
		{
			$possible_dates = $row108['ExpectedDate'];
			$callid = $row108['ID'];
?>
			<tr>
				<td>
					<input type="radio" name="call" value="<?php echo $callid; ?>"><?php echo $possible_dates;?>
				</td>
			</tr>
<?php		
		}
?>
			<tr>
				<td>
					<input type="radio" name="call" value="0">Do Not Count as Scheduled Call
				</td>
			</tr>		
			<tr>
				<td>
					<input type="submit" value="Next" name="update_call_tracker">
				</td>
			</tr>
		</table>
	</form>
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