<?php
 
include 'header.php';

$conn1 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());

     				mysql_select_db('homefree');
						$email = $_SESSION['mail'];
				$query8 = "SELECT id, f_name, l_name,dept FROM employees WHERE email = '$email'";
				$result8 = mysql_query($query8) or die (mysql_error());
       		$row8 = mysql_fetch_array($result8);
				$employeeid = $row8['id'];      
				$access = $_SESSION['access'];
				$department = $row8['dept'];

 mysql_close($conn1);	
 

include 'includes/configtask.php';
include 'includes/opendbtask.php';
require 'includes/functions.inc.php';

/*
***************************************************INITIAL DISPLAY*************************************************
*/


if(!isset($_GET['save']))
{
$date = date('Y-m-d H:i:s');
$lastmonthtime =  strtotime("-1 month");
$lastmonth = date("Y-m-d H:i:s",$lastmonthtime);
$lastweek =  strtotime("-1 week");
$nextweek =  strtotime("+1 week");
$plus1Day =  strtotime("+1 day");
$now = strtotime("now");
$less1day = strtotime("-1 day");
$less12hours = strtotime("-12 hours");


?>
<table width ="750" align="center" border = "0" cellpadding = "5">
			<tr>
				<td align="center">
					<font face="arial" size="6">HomeFree Task Management</font>
				</td>
			</tr>
			<tr>
				<td align="center">
					Custom Report
				<td>
			</tr>
		</table>
		<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width ="750" align="center" border = "0">
			<tr>
				  <td>
  					Start Created Date:	
  					
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date3" VALUE="1970/01/01 00:00:00" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date3,'anchor3','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor3" ID="anchor3">select</A>
  					
  				</td>
  				<td>
  					End Created Date:	
  					
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date4" VALUE="2020/01/01 12:00:00" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date4,'anchor4','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor4" ID="anchor4">select</A>
  				</td>
			</tr>
		</table>
	<table width ="750" align="center" border = "0" cellpadding = "5">
		<tr>
			<td width = 100>
				Type: 
			</td>
			<td width = 275>
						<select name=type>
							<option value ="-1">ALL</option>
							<option value ="1">Tech Support Status Meeting</option>
  							<option value ="2">Tech Support and Marketing Meeting</option>
  							<option value ="3">Marketing Status Meeting</option>
  							<option value ="4">Management Review</option>
  							<option value ="5">General Meeting</option>
  							<option value ="6">Customer Site Visit Report</option>
  							<option value ="7">Operational Issues</option>
  							<option value ="8">Installation Issues</option>
  						</select>
			</td>
  			<td>
  				Subject:
  			</td>
  			<td>
  					<input type="text" size="15" maxlength="250" name="subject" value = "ALL" readonly>
  			</td>
  		</tr>
  		<tr>
  			<td>
  				Priority:
  			</td>
  			<td>
								<select name=priority>	 
  									<option value = "-1">ALL</option>
  									<option value = "1">Low</option>
  									<option value = "2">Medium</option>
  									<option value = "3">High</option>
  									<option value = "4">ASAP</option>
  									<option value = "5">TBD</option>
  									<option value = "6">Immediate</option>
    								</select>
    		</td>
  			<td>
  				Status:
  			<td>
  							<select name=status>
  								<option value = "-1">ALL</option>
  								<option value = "1">New</option>
  								<option value = "2">In Progress</option>
  								<option value = "3">Complete</option>
  								<option value = "4">Canceled</option>
  								<option value = "5">Deferred</option>
  							</select>
  			</td>
		</tr>
	</table>
  	<table width ="750" align="center" border = "0" cellpadding = "5">
  		<tr>
  			<td width = 100>
  				Responsibility: 
  			</td>
  			<td width = 275>
<?php
  					$conn7 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
	            	mysql_select_db('homefree');
	            	if($access > 6)
									{
										$query8 = "SELECT id, f_name, l_name FROM employees ORDER BY l_name";
									}else
									{
										$query8 = "SELECT id, f_name, l_name FROM employees WHERE id = '$employeeid' OR dept = '$department' AND access < '$access' ORDER BY l_name";
									}
					$result8 = mysql_query($query8) or die (mysql_error());
										
?>  										
 										<select name = "employee">
 											<option value = "-1">ALL</option>
<?php
											while($row8 = mysql_fetch_array($result8))
												{
?>
													<option value="<?php echo $row8['id']; ?>"><?php echo $row8['f_name']. ' '. $row8['l_name']; ?></option>
<?php
												}
  	    				mysql_close($conn7);			
?>
			</td>
  			<td width = 100>
  				Co-Responsibility:
  			</td>
  			<td>
<?php
/*
*******************************************************CO RESPONSIBLE SELECT BOX********************************************************				
*/
		 		
  								$conn2 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
								mysql_select_db('homefree');
								if($access > 6)
									{
										$query4 = "SELECT id,f_name, l_name,dept FROM employees ORDER BY l_name";
									}else
									{
										$query4 = "SELECT id,f_name, l_name,dept FROM employees WHERE id = '$employeeid' OR dept = '$department' AND access < '$access' ORDER BY l_name";
									}
								$result4 = mysql_query($query4) or die (mysql_error());
?>
									<select name="employee2">	 
										<option value="-1">ALL</option>
<?php
											while($row4 = mysql_fetch_array($result4))
												{
?>
													<option value="<?php echo $row4['id']; ?>"><?php echo $row4['f_name']. ' '. $row4['l_name']; ?></option>
									
<?php
												}
?>
									</select>				
			</td>
		</tr>
<?php
								mysql_close($conn2);
/*
*******************************************************CHECK BY SELECT BOX********************************************************				
*/
?>				
				<tr>
				  <td>
  					Check By: 
  				</td>
  			<td>
  						
<?php			
									$conn3 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
									mysql_select_db('homefree');
									if($access > 6)
										{
											$query5 = "SELECT id,f_name, l_name,access FROM employees ORDER BY l_name";
										}else
										{
											$query5 = "SELECT id,f_name, l_name,access FROM employees WHERE id = '$employeeid' OR dept = '$department' AND access < '$access' ORDER BY l_name";
										}
									$result5 = mysql_query($query5) or die (mysql_error());
?>
										<select name = "employee3">
										<option value="-1">ALL</option>
<?php
											while($row5 = mysql_fetch_array($result5))
												{
?>
													<option value="<?php echo $row5['id']; ?>"><?php echo $row5['f_name']. ' '. $row5['l_name']; ?></option>
<?php
												}
									mysql_close($conn3);
?>
  				</td>
  				<td>
  					Assigned to: 
  				</td>
  			<td>
  						
<?php
/*
*******************************************************ASSIGN TO SELECT BOX********************************************************				
*/  			
  										$conn9 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
         								mysql_select_db('homefree');
         								if($access > 6)
         									{
         										$query10 = "SELECT id, f_name, l_name FROM employees ORDER BY l_name";
         									}else
         									{
         										$query10 = "SELECT id, f_name, l_name FROM employees WHERE id = '$employeeid' OR dept = '$department' AND access < '$access' ORDER BY l_name";
         									}
      							  		$result10 = mysql_query($query10) or die (mysql_error());
?>
											<select name=assignto>
  											<option value="-1">ALL</option>
<?php
       									 while($row10 = mysql_fetch_array($result10))
          						           	{  		
?>			
  												<option value="<?php echo $row10['id']; ?>"><?php echo $row10['f_name']. ' '. $row10['l_name']; ?></option>
<?php
  											}
  	 						   			mysql_close($conn9);
?>
											</select>
				</td>
			</tr>
			<tr>
				<td>
  					Created by:
  				</td>
  			<td>
<?php
            $conn1 = mysql_connect('hf01sql','ups_track','7ZLXRn9.xZfRCuXV') or die(mysql_error());
            mysql_select_db('homefree');
            if($access > 6)
            	{
            		$query3 = "SELECT id,f_name, l_name FROM employees ORDER BY l_name";
            	}else
            	{
            		$query3 = "SELECT id,f_name, l_name FROM employees WHERE access < '$access' AND dept = '$department' OR id = '$employeeid' ORDER BY l_name";
            	}
            $result3 = mysql_query($query3) or die (mysql_error());
?>
					<select name="createdby">
					<option value="-1">ALL</option>
<?php
					while($row3 = mysql_fetch_array($result3))
						{
?>
							<option value="<?php echo $row3['id']; ?>"><?php echo $row3['f_name']. ' '. $row3['l_name']; ?></option>
<?php
						}
?>
				</select>
  				</td>
  			</tr>
  		</table>
  		<table width ="750" align="center" border = "0" cellpadding = "5">
  			<tr>
  				<td>
  					Start Due Date:	
  				</td>
  				<td>
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date1" VALUE="1970/01/01 00:00:00" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor1" ID="anchor1">select</A>
  					
  				</td>
  				<td>
  					End Due Date:	
  				</td>
  				<td>
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date2" VALUE="2020/01/01 12:00:00" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date2,'anchor2','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor2" ID="anchor2">select</A>
  					
  				</td>
  			</tr>
  			<tr>
  				<td>
  					Start Completion Date:	
  				</td>
  				<td>
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date5" VALUE="1970/01/01 00:00:00" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date5,'anchor5','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor5" ID="anchor5">select</A>
  					
  				</td>
  				  <td>
  					End Completion Date:	
  				</td>
  				<td>
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date6" VALUE="2020/01/01 12:00:00" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date6,'anchor6','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor6" ID="anchor6">select</A>
  					
  				</td>
  			</tr>
  		</table>
  		<table width ="750" align="center" border = "0" cellpadding = "5">
 		  	<tr>
 				<td><input type="submit" value="Run Report" name="save"></td>
			</tr>
			<tr>
				<td colspan="2">
					**If you are not concerned with dates, the defaults will yeild all results meeting your criteria for all tasks ever created.
				</td>
			</tr>

  	</table>
</form>
		<table>
			<tr>
				<td>
					<button onClick="window.location='taskreporthome.php?name=<?php echo $employeeid; ?>'">Back to the Task Report Page</button>
				</td>
			</tr>
  		</table>
<?php
}

/*
****************************************AFTER VALUES SELECTED*************************************************
*/


if(isset($_GET['save']))
{
$type = $_GET['type'];
$priority = $_GET['priority'];
$status = $_GET['status'];
$createdby = $_GET['createdby'];
$employee = $_GET['employee'];
$employee2 = $_GET['employee2'];
$employee3 = $_GET['employee3'];
$assignto = $_GET['assignto'];
$startcreatetime = $_GET['date3'];
$endcreatetime = $_GET['date4'];
$startduetime = $_GET['date1'];
$endduetime = $_GET['date2'];	
$startcompletetime = $_GET['date5'];
$endcompletetime = $_GET['date6'];	

$query100 = "SELECT * FROM taskinfo ";

foreach($_GET as $val){
  if($val != "-1" OR  $val = "Save"){
    $query100 .= "WHERE ";
    break;
  }
}

$where = array();

if($type != "-1"){
  $where [ ] = "Type = '$_GET[type]'";
}

if($priority != "-1"){
  $where[ ] = "Priority = '$_GET[priority]'";
}

if($status != "-1"){
  $where[ ] = "Status = '$_GET[status]'";
}

if($employee != "-1"){
  $where[ ] = "Response = '$_GET[employee]'";
}

if($employee2 != "-1"){
  $where[ ] = "Response2 = '$_GET[employee2]'";
}

if($employee3 != "-1"){
  $where[ ] = "Response3 = '$_GET[employee3]'";
}

if($assignto != "-1"){
  $where[ ] = "Assignto = '$_GET[assignto]'";
}

if($createdby != "-1"){
  $where [ ] = "Createdby = '$_GET[createdby]'";
}

if($startduetime != "-1"){
  $where [ ] = "Duedate  > '$_GET[date1]'";
}

if($endduetime != "-1"){
  $where [ ] = "Duedate  < '$_GET[date2]'";
}

if($startcreatetime != "-1"){
  $where [ ] = "Createdate  > '$_GET[date3]'";
}

if($endcreatetime != "-1"){
  $where [ ] = "Createdate  < '$_GET[date4]'";
}

if($startcompletetime != "1970/01/01 00:00:00"){
  $where [ ] = "Completiondate  > '$_GET[date5]'";
}

if($endcompletetime != "2020/01/01 12:00:00"){
  $where [ ] = "Completiondate  < '$_GET[date6]'";
}

if(!empty($where)){
  $query100 .= implode(" AND ", $where);
}


$result100 = mysql_query($query100) or die(mysql_error());
//echo $query100;
$num = mysql_num_rows($result100);	
	
		
?>
				<table cellpadding=3  width="750"  align ="center" table border = "0">
					<tr>
						<td>
							Number of Records that mathced your search: <?php echo $num; ?>
						</td>
					</tr>
				</table>
<?php		
		
		while($row100 = mysql_fetch_array($result100))
			{
				$subject = $row100['Subject'];
				$ID = $row100['ID'];
				$status = $row100['Status'];
				$duedate1 = $row100['Duedate'];
				$duedate = strtotime($duedate1);
							if($status == 1)
								{
									$status1 = "New";
								}elseif($status == 2)
								{
									$status1="In Progress";
								}elseif($status == 3)
								{
									$status1="Complete";
								}elseif($status == 4)
								{
									$status1="Canceled";
								}elseif($status == 5)
								{
									$status1="Deferred";
								}
							
?>
									<table width = 750>	
										<tr>
											<td width = 50><font face="Arial" size="2">
												<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update'.'">'.  $ID;?>
											</td>
											<td width = 450><b>
												Due Date: </b> <?php echo $duedate1; ?>
											</td>
											<td><b>
												Status:</b> <?php echo $status1; ?>
											</td>				
										</tr>
										<tr>
											<td>
											</td>
											<td colspan = 2><b>
												Subject: </b> <?php echo $subject; ?>
											</td>
										</tr>
										<tr>
											<td colspan = 3>
												<div align="center"><hr width="50%"></div>
											</td>
										</tr>
									</table>
<?php
				}
?>								
		<table>
			<tr>
				<td>
					<button onClick="window.location='customreport.php'">Back to the Custom Report Page</button>
				</td>
			</tr>
  		</table>
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

