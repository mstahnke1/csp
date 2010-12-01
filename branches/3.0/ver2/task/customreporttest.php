<?php
 
include 'header.php';

$conn1 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());

     				mysql_select_db('homefree');
						$email = $_SESSION['mail'];
            $query8 = "SELECT id, f_name, l_name FROM employees WHERE email = '$email'";
            $result8 = mysql_query($query8) or die (mysql_error());
       		$row8 = mysql_fetch_array($result8);
			$employeeid = $row8['id'];      



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
<table width ="750" align="center" border = "0">
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
					
					<INPUT TYPE="text" NAME="date3" VALUE="-2" SIZE=25>
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
					
					<INPUT TYPE="text" NAME="date4" VALUE="999999999999999" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date4,'anchor4','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor4" ID="anchor4">select</A>
  				</td>
			</tr>
			<tr>
  				
  				<td>
  					Created by:
  				           <?php

            $conn1 = mysql_connect('hf01sql','ups_track','7ZLXRn9.xZfRCuXV') or die(mysql_error());

            mysql_select_db('homefree');

            $query3 = "SELECT id,f_name, l_name FROM employees ORDER BY l_name";

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
			
		</table>
		<table width ="750" align="center" border = "0">
			<tr>
				<td valign = "top">
					Type: 
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
  			</tr>
  			<tr>
  				<td valign="top">
  					Priority:
  					<select name=priority>
  						<option value ="-1">ALL</option>
  						<option value = "1">Low</option>
  						<option value = "2">Medium</option>
  						<option value = "3">High</option>
  						<option value = "4">ASAP</option>
  						<option value = "5">TBD</option>
  						<option value = "6">Immediate</option>
    					</select>
    				</td>
  			</tr>
    			<tr>
  				<td valign="top">
  					Status:
  					<select name=status>
  						<option value ="-1">ALL</option>
  						<option value ="-1">ALL</option>
  						<option value = "1">New</option>
  						<option value = "2">In Progress</option>
  						<option value = "3">Complete</option>
  						<option value = "4">Canceled</option>
  						<option value = "5">Deferred</option>
  					</select>
  				</td>
  			</tr>
  		</table>
  		<table width ="750" align="center" border = "0">
  			<tr>
  				
  				<td>
  					Responsibility:
  				           <?php

            $conn4 = mysql_connect('hf01sql','ups_track','7ZLXRn9.xZfRCuXV') or die(mysql_error());

            mysql_select_db('homefree');

            $query4 = "SELECT id,f_name, l_name FROM employees ORDER BY l_name";

            $result4 = mysql_query($query4) or die (mysql_error());

                 
						?>
<select name="employee">

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
<?php
            

            mysql_close($conn1);

            ?>

  				</td>
  				<td>
  					Co-Responsibility: 
  				 				           <?php

            $conn2 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());

            mysql_select_db('homefree');

            $query4 = "SELECT id, f_name, l_name FROM employees ORDER BY l_name";

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
<?php
            

            mysql_close($conn2);

            ?>
  				</td>
  				<td>
  				Check By:
<?php

            $conn3 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());

            mysql_select_db('homefree');

            $query5 = "SELECT id,f_name, l_name FROM employees ORDER BY l_name";

            $result5 = mysql_query($query5) or die (mysql_error());

                 
						?>
<select name="employee3">

<option value="-1">ALL</option>

<?php

while($row5 = mysql_fetch_array($result5))

{

?>

<option value="<?php echo $row5['id']; ?>"><?php echo $row5['f_name']. ' '. $row5['l_name']; ?></option>

<?php

}

?>

</select>
<?php
            mysql_close($conn3);

            ?>
  				</td>
  			</tr>
  			<tr>	
  				<td>
  				Assigned to: 
  				
  										<?php
  										$conn9 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());

            								mysql_select_db('homefree');
		
           								 $query10 = "SELECT id, f_name, l_name FROM employees ORDER BY l_name";
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
  				</td>
  			</tr>
  		</table>
  		<table width ="750" align="center" border = "0">
  			<tr>
  				<td>
  					Start Due Date:	
  					
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date1" VALUE="-2" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor1" ID="anchor1">select</A>
  					
  				</td>
  				  <td>
  					End Due Date:	
  					
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date2" VALUE="99999999999999" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date2,'anchor2','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor2" ID="anchor2">select</A>
  					
  				</td>
  			</tr>
  			<tr>
  				<td>
  					Start Completion Date:	
  					
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date5" VALUE="-2" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date5,'anchor5','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor5" ID="anchor5">select</A>
  					
  				</td>
  				  <td>
  					End Completion Date:	
  					
  					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					
					<INPUT TYPE="text" NAME="date6" VALUE="999999999999999999" SIZE=25>
					<A HREF="#"
   					onClick="cal.select(document.forms['example'].date6,'anchor6','yyyy/MM/dd hh:mm:ss'); return false;"
   					NAME="anchor6" ID="anchor6">select</A>
  					
  				</td>
  			</tr>
 		  		&nbsp;
  			</tr>	
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

if($startcompletetime != "-1"){
  $where [ ] = "Completiondate  > '$_GET[date5]'";
}

if($endcompletetime != "-1"){
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
		
$ID=$row100['ID'];
$duedate = $row100['Duedate'];
$priority = $row100['Priority'];
$status = $row100['Status'];
$createdby = $row100['Createdby'];
$employee = $row100['Response'];
$employee2 = $row100['Response2'];
$employee3 = $row100['Response3'];
$subject = $row100['Subject'];
$assignto = $row100['Assignto'];
$type = $row100['Type'];
$completiondate = $row100['Completiondate'];
$description = $row100['Description'];
$remarks = $row100['Remarks'];

$duedatetime = strtotime($row100['Duedate']);
$startduetime = strtotime($_GET['date1']);
$endduetime = strtotime($_GET['date2']);
$createtime = strtotime($row100['Createdate']);
$startcreatetime = strtotime($_GET['date3']);
$endcreatetime = strtotime($_GET['date4']);


		$conn3 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
		mysql_select_db('homefree');
		$query = "SELECT id,f_name, l_name FROM employees WHERE id = '$assignto'";
		$result = mysql_query($query) or die (mysql_error());
		$row = mysql_fetch_array($result);
		$assigntoname = $row['f_name'] . ' ' . $row['l_name'];
		
		$query2 = "SELECT id,f_name, l_name FROM employees WHERE id = '$employee'";
		$result2 = mysql_query($query2) or die (mysql_error());
		$row2 = mysql_fetch_array($result2);
		$employeename = $row2['f_name'] . ' ' . $row2['l_name'];
		
		$query3 = "SELECT id,f_name, l_name FROM employees WHERE id = '$employee3'";
		$result3 = mysql_query($query3) or die (mysql_error());
		$row3 = mysql_fetch_array($result3);
		$checkemployeename = $row3['f_name'] . ' ' . $row3['l_name'];
		
		mysql_close($conn3);	

if($type == 1)
	{
		$type1 = "Tech Support Status Meeting";
	}elseif($type == 2)
	{
		$type1 = "Tech Support and Marketing";
	}elseif($type == 3)
	{
		$type1 = "Marketing Status Meeting";
		}elseif($type == 4)
	{
		$type1 = "Management Review";
		}elseif($type == 5)
	{
		$type1 = "General Meeting";
		}elseif($type == 6)
	{
		$type1 = "Customer Site Visit Report";
		}elseif($type == 7)
	{
		$type1 = "Operational Issues";
				}elseif($type == 8)
	{
		$type1 = "Installation Issues";
	}
	if($priority == 1)
{
	$priority1 = "Low";
}elseif($priority == 2)
{
	$priority1 = "Medium";
}elseif($priority == 3)
{
	$priority1 = "High";
}elseif($priority == 4)
{
	$priority1 = "ASAP";
}elseif($priority == 5)
{
	$priority1 = "TBD";
}elseif($priority == 6)
{
	$priority1 = "Immediate";
}

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
				<table cellpadding=3  width="750"  align ="center" table frame = box>
					<tr>
						<td width = "115"><font face = "Arial" size ="1"><b>
							Due Date
						</b></td>
						<td width = "200"><font face = "Arial" size ="1"><b>
							Subject
						</b></td>
						<td width="130"><font face = "Arial" size ="1"><b>
							Responsibility
						</b></td>
						<td width="130"><font face = "Arial" size ="1"><b>
							Assigned To
						</b></td>
						<td width = "130"><font face = "Arial" size ="1"><b>
							Checked By
						</b></td>
					</tr>
					 <tr>
						<td><font face="Arial"color="#000000" size="2"> 
							<?php echo $duedate; ?> 
						</td> 
						<td><font size = "1" color="#000000">
							<?php  echo $subject; ?>
						</td>
						<td><font size = "1" color="#000000">
							 <?php echo $employeename; ?>
						</td> 
						<td><font face="Arial" color="#000000" size="2">
							<?php echo $assigntoname; ?>
						</td>
						<td><font size = "1" color="#000000">
							<?php echo $checkemployeename; ?> 
						</font></td>
					</tr>
				</table>
				<table cellpadding=3  width="750"  align ="center" table border = "1">
					<tr>
						<td valign ="top" width="300"><u>
							Description:<br></u>
							<?php echo ($description); ?>
						</td>
						<td valign="top" width = "300"><u>
						Remarks:<br></u>
							<?php echo ($remarks); ?>
						</td>
					</tr>
				</table>
				<table cellpadding=3  width="750"  align ="center" table border = "0">
				<tr>
				<td></td>
				</tr>
				</table>

<?php	

}  //end while
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

