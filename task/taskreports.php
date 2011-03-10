<?php

$date = date('Y-m-d H:i:s');
include 'header.php';

$conn1 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db('homefree');
$email = $_SESSION['mail'];
$query8 = "SELECT id, f_name, l_name, dept FROM employees WHERE email = '$email'";
$result8 = mysql_query($query8) or die (mysql_error());
$row8 = mysql_fetch_array($result8);
$employeeid = $row8['id'];      
$employeedept = $row8['dept'];
mysql_close($conn1);	
include 'includes/configtask.php';
include 'includes/opendbtask.php';
/*
***************************ALL CLOSED TASKS USER CREATED******************************
*/
if(isset($_GET['closed']))
	{
		$query1 = "SELECT * FROM taskinfo WHERE Createdby = '$employeeid' AND Status = 3 ORDER BY Completiondate";
		$result1 = mysql_query($query1) or die (mysql_error());
		$num = mysql_num_rows($result1);	
		$query = "SELECT * FROM taskinfo WHERE Createdby = '$employeeid'";
		$result = mysql_query($query);
		$a = 0;
		while($row = mysql_fetch_array($result))
			{
	      $complete = strtotime($row['Completiondate']);
	      $due = strtotime($row['Duedate']);
	          $a = $a + 1;
      }
?>
<table>
	<tr>
		<td>
			Completed Tasks: <?php echo $num; ?>
		</td>
	</tr>
	<tr>
		<td><b>
			Last Completed On Top
		</b></td>
	</tr>
	<tr>
		<td>
<?php
		while($allcreated = mysql_fetch_array($result1))
			{
				$subject = $allcreated['Subject'];
				$ID = $allcreated['ID'];
				$status = $allcreated['Status'];
				$duedate1 = $allcreated['Duedate'];
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
									<table align=center width = 750>	
										<tr>
											<td width = 20><font face="Arial" size="2">
												<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update'.'">'.  $ID;?>
											</td>
											<td width = 500>
												Subject: <?php echo $subject; ?>
											</td>
											<td width = 100>
												Status: <?php echo $status1; ?>
											</td>				
										</tr>
<?php
			}
	}
	
/*
***************************ALL CANCELED TASKS USER CREATED******************************
*/
if(isset($_GET['canceled']))
	{
		$query1 = "SELECT * FROM taskinfo WHERE Createdby = '$employeeid' AND Status = 4 ORDER BY Completiondate";
		$result1 = mysql_query($query1) or die (mysql_error());
		$num = mysql_num_rows($result1);	
		$query = "SELECT * FROM taskinfo WHERE Createdby = '$employeeid'";
		$result = mysql_query($query);
		$a = 0;
		while($row = mysql_fetch_array($result))
			{
	      $complete = strtotime($row['Completiondate']);
	      $due = strtotime($row['Duedate']);
	      if($complete > $due)
	        {
	          $a = $a + 1;
          }
       }
?>
<table>
	<tr>
		<td>
			Canceled Tasks: <?php echo $num; ?>
		</td>
	</tr>
	<tr>
		<td><b>
			Last Canceled On Top
		</b></td>
	</tr>
	<tr>
		<td>
<?php
		while($allcreated = mysql_fetch_array($result1))
			{
				$subject = $allcreated['Subject'];
				$ID = $allcreated['ID'];
				$status = $allcreated['Status'];
				$duedate1 = $allcreated['Duedate'];
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
									<table align=center width = 750>	
										<tr>
											<td width = 20><font face="Arial" size="2">
												<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update'.'">'.  $ID;?>
											</td>
											<td width = 500>
												Subject: <?php echo $subject; ?>
											</td>
											<td width = 100>
												Status: <?php echo $status1; ?>
											</td>				
										</tr>
<?php
			}
	}
if((isset($_GET['open'])) OR (isset($_GET['responsible'])) OR (isset($_GET['coresponsible'])) OR (isset($_GET['check'])) OR (isset($_GET['assigned'])))
	{
/*
************************************************ALL OPEN TASKS USER CREATED**************************************************************
*/
		if(isset($_GET['open']))
			{
				$query1 = "SELECT * FROM taskinfo WHERE ((Createdby = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				$num = mysql_num_rows($result1);			
				$query = "SELECT * FROM taskinfo WHERE ((Createdby = '$employeeid') AND (Status <> 3 AND Status <> 4))";
				$result = mysql_query($query);
				$a = 0;
			}
/*
************************************************ALL OPEN TASKS USER IS RESPONSIBLE**************************************************************
*/	
		if(isset($_GET['responsible']))
			{	
				$query1 = "SELECT * FROM taskinfo WHERE ((Response = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				$num = mysql_num_rows($result1);			
				$query = "SELECT * FROM taskinfo WHERE ((Response = '$employeeid') AND (Status <> 3 AND Status <> 4))";
				$result = mysql_query($query);
				$a = 0;
			}
/*
************************************************ALL OPEN TASKS USER IS CORESPONSIBLE**************************************************************
*/	
		if(isset($_GET['coresponsible']))
			{	
				$query1 = "SELECT * FROM taskinfo WHERE ((Response2 = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				$num = mysql_num_rows($result1);			
				$query = "SELECT * FROM taskinfo WHERE ((Response2 = '$employeeid') AND (Status <> 3 AND Status <> 4))";
				$result = mysql_query($query);
				$a = 0;
			}	
/*
************************************************ALL OPEN TASKS USER IS TO CHECK**************************************************************
*/
		if(isset($_GET['check']))
			{	
				$query1 = "SELECT * FROM taskinfo WHERE ((Response3 = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				$num = mysql_num_rows($result1);			
				$query = "SELECT * FROM taskinfo WHERE ((Response3 = '$employeeid') AND (Status <> 3 AND Status <> 4))";
				$result = mysql_query($query);
				$a = 0;
			}	
/*
************************************************ALL OPEN TASKS USER IS ASSIGNED**************************************************************
*/	
		if(isset($_GET['assigned']))
			{	
				$query1 = "SELECT * FROM taskinfo WHERE ((Assignto = '$employeeid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				$num = mysql_num_rows($result1);			
				$query = "SELECT * FROM taskinfo WHERE ((Assignto = '$employeeid') AND (Status <> 3 AND Status <> 4))";
				$result = mysql_query($query);
				$a = 0;
			}		
/*
************************************************DISPLAY FOR OPEN TASK REPORTS**************************************************************
*/	
				while($row = mysql_fetch_array($result))
					{
						$now = strtotime($date);
	      		$due = strtotime($row['Duedate']);
  	        $a = $a + 1;
					}
	
?>
<table align=center>
	<tr>
		<td>
			Open Tasks <?php echo $num; ?>
		</td>
	</tr>
	<tr>
		<td><b>
			Ordered by Due Date:
		</b></td>
	</tr>
</table>
	<tr>
		<td>
<?php
		while($row1 = mysql_fetch_array($result1))
			{
				$subject = $row1['Subject'];
				$ID = $row1['ID'];
				$status = $row1['Status'];
				$duedate1 = $row1['Duedate'];
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
	}			
/*
************************************************ALL OPEN TASKS PER DEPARTMENT**************************************************************
*/
if((isset($_GET['sales'])) OR (isset($_GET['technical'])) OR (isset($_GET['human'])))
	{	
		if(isset($_GET['sales']))
			{
				$query1 = "SELECT * FROM taskinfo WHERE employeedept = 1 AND Status <> 3 AND Status <> 4 ORDER BY Response";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				$num = mysql_num_rows($result1);			
				$query = "SELECT * FROM taskinfo WHERE employeedept = 1 AND Status <> 3 AND Status <> 4 ORDER BY Response";
				$result = mysql_query($query);
				$a = 0;
			}		
		if(isset($_GET['technical']))
			{
				$query1 = "SELECT * FROM taskinfo WHERE employeedept = 2 AND Status <> 3 AND Status <> 4 ORDER BY Response";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				$num = mysql_num_rows($result1);			
				$query = "SELECT * FROM taskinfo WHERE employeedept = 2 AND Status <> 3 AND Status <> 4 ORDER BY Response";
				$result = mysql_query($query);
				$a = 0;
			}			
		if(isset($_GET['human']))
			{
				$query1 = "SELECT * FROM taskinfo WHERE employeedept = 3 AND Status <> 3 AND Status <> 4 ORDER BY Response";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				$num = mysql_num_rows($result1);			
				$query = "SELECT * FROM taskinfo WHERE employeedept = 3 AND Status <> 3 AND Status <> 4 ORDER BY Response";
				$result = mysql_query($query);
				$a = 0;
			}					
/*
************************************************DISPLAY FOR OPEN TASK REPORTS**************************************************************
*/	
		while($row = mysql_fetch_array($result))
			{
	      $now = strtotime($date);
	      $due = strtotime($row['Duedate']);
  	        $a = $a + 1;
			}
	
?>
<table align=center>
	<tr>
		<td>
			Open Tasks <?php echo $num; ?>
		</td>
	</tr>
	<tr>
		<td><b>
			Ordered by Due Date:
		</b></td>
	</tr>
</table>
	<tr>
		<td>
<?php
		while($row1 = mysql_fetch_array($result1))
			{
				$subject = $row1['Subject'];
				$ID = $row1['ID'];
				$status = $row1['Status'];
				$duedate1 = $row1['Duedate'];
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
	}
/*
************************************************SUMMARY REPORTS**************************************************************
*/
if((isset($_GET['techsummary'])) OR (isset($_GET['salessummary'])) OR (isset($_GET['hrsummary'])))
	{
		if(isset($_GET['techsummary']))
			{
				$dept = 2;
				$query1 = "SELECT * FROM taskinfo WHERE ((employeedept = '$dept' OR employee2dept = '$dept' OR employee3dept = '$dept' OR assigntodept = '$dept') AND (Status <> 3 AND Status <> 4))";
				$result1 = mysql_query($query1) or die (mysql_error());
				$num = mysql_num_rows($result1);	
				$query = "SELECT * FROM taskinfo WHERE ((employeedept = '$dept' OR employee2dept = '$dept' OR employee3dept = '$dept' OR assigntodept = '$dept') AND (Status <> 3 AND Status <> 4))";
				$result = mysql_query($query);
				$a = 0;	
			}
		if(isset($_GET['salessummary']))
			{
				$dept = 1;
				$query1 = "SELECT * FROM taskinfo WHERE ((employeedept = '$dept' OR employee2dept = '$dept' OR employee3dept = '$dept' OR assigntodept = '$dept') AND (Status <> 3 AND Status <> 4))";
				$result1 = mysql_query($query1) or die (mysql_error());
				$num = mysql_num_rows($result1);	
				$query = "SELECT * FROM taskinfo WHERE ((employeedept = '$dept' OR employee2dept = '$dept' OR employee3dept = '$dept' OR assigntodept = '$dept') AND (Status <> 3 AND Status <> 4))";
				$result = mysql_query($query);
				$a = 0;	
			}
		if(isset($_GET['hrsummary']))
			{
				$dept = 3;
				$query1 = "SELECT * FROM taskinfo WHERE ((employeedept = '$dept' OR employee2dept = '$dept' OR employee3dept = '$dept' OR assigntodept = '$dept') AND (Status <> 3 AND Status <> 4))";
				$result1 = mysql_query($query1) or die (mysql_error());
				$num = mysql_num_rows($result1);	
				$query = "SELECT * FROM taskinfo WHERE ((employeedept = '$dept' OR employee2dept = '$dept' OR employee3dept = '$dept' OR assigntodept = '$dept') AND (Status <> 3 AND Status <> 4))";
				$result = mysql_query($query);
				$a = 0;	
			}			
				while($row = mysql_fetch_array($result))
					{
						$now = strtotime($date);
		    		$due = strtotime($row['Duedate']);
        		if($now > $due)
	        		{
  	        		$a = $a + 1;
          		}
					}
				$query2 = "SELECT * FROM taskinfo WHERE ((employeedept = '$dept' OR employee2dept = '$dept' OR employee3dept = '$dept' OR assigntodept = '$dept') AND (Status <> 3 AND Status <> 4))";
				$result2 = mysql_query($query2);
				$b = 0;
				while($row2 = mysql_fetch_array($result2))
					{
        		$now = strtotime($date);
		    		$due = strtotime($row2['Duedate']);
        		if($now < $due)
	        		{
  	       		 $b = $b + 1;
        		  }
					}
				$query3 = "SELECT ID FROM taskinfo WHERE employeedept = '$dept' AND Status = 3";
				$result3 = mysql_query($query3) or die (mysql_error());
				$num2 = mysql_num_rows($result3);
				$query4 = "SELECT * FROM taskinfo WHERE employeedept = '$dept' AND Status = 3";
				$result4 = mysql_query($query4);
				$c = 0;
				while($row4 = mysql_fetch_array($result4))
					{
	      		$completiondate = strtotime($row4['Completiondate']);
	      		$due = strtotime($row4['Duedate']);
        	if($completiondate > $due)
	       		{
  	        	$c = $c + 1;
          	}
					}
		$query5 = "SELECT * FROM taskinfo WHERE employeedept = '$dept' AND Status = 3";
		$result5 = mysql_query($query5);
		$d = 0;
		while($row5 = mysql_fetch_array($result5))
			{
        $completiondate = strtotime($row5['Completiondate']);
		    $due = strtotime($row5['Duedate']);
        if($completiondate < $due)
	        {
  	        $d = $d + 1;
          }
			}
?>
		<table cellpadding=3  width="750"  align ="center" table border = "0">
			<tr>
				<td align = "center" colspan = "3"><b>
					Open Tasks:
				</b></td>
			</tr>
			<tr>
				<td>
					Number of Tasks For the department: <?php echo $num; ?>
				</td>
			</tr>
			<tr>
				<td>
					Overdue Tasks: <?php echo $a; ?>
				</td>
			</tr>
			<tr>
				<td>
					On-Time Tasks: <?php echo $b; ?>
				</td>
			</tr>
			<tr>
				<td align = "center" colspan = "3"><b>
					Completed Tasks:
				</b></td>
			</tr>
			<tr>
				<td>
					Number of Tasks For the department: <?php echo $num2; ?>
				</td>
			</tr>
			<tr>
				<td>
					Overdue Tasks: <?php echo $c; ?>
				</td>
			</tr>
			<tr>
				<td>
					On-Time Tasks: <?php echo $d; ?>
				</td>
			</tr>
		</table>
		<table cellpadding=2  width="325" table border = "0" align = "left">
		<tr>
			<td colspan="2"><b>
				Individual Open Tasks (Responsible):
			</b></td>
		</tr>   
<?php

		//$conn1 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
		mysql_select_db('homefree');
		$query6 = "SELECT * FROM employees WHERE dept = '$dept'";
    $result6 = mysql_query($query6) or die (mysql_error());
    while($row6 = mysql_fetch_array($result6))
 	   {
  	   $where[] = $row6['id'];         	
     }
    //mysql_close($conn1);



foreach($where as $val) 
	{
		include 'includes/configtask.php';
		include 'includes/opendbtask.php';
    $query100 = "SELECT * FROM taskinfo WHERE ((Response = '$val') AND (Status <> 3 AND Status <> 4)) ORDER BY ID";
    $result100 = mysql_query($query100);  
    $overdue = "SELECT * FROM taskinfo WHERE ((Response = '$val') AND (Status <> 3 AND Status <> 4)) ORDER BY ID";
    $resoverdue = mysql_query($overdue);  
   	$x = 0;
    while($rowoverdue = mysql_fetch_array($resoverdue))
    	{
    		$duedate1 = $rowoverdue['Duedate'];
				$duedate = strtotime($duedate1);
    		if($now > $duedate)
	      	{
  	      	$x = $x + 1;
          }
       }
      $row100 = mysql_num_rows($result100);
    	if(!$row100 ==0)
				{	        		
?>
 							<tr>
          			<td width = "120">             
									Open Tasks <?php echo $row100. ' '. '<font color="#ff0000">('. $x . ')</font>' ?> 
								</td>
								<td> 
<?php 
          			$rows = mysql_fetch_assoc($result100);
          			$response = $rows['Response'];  
          			//$conn2 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
            		mysql_select_db('homefree');
								$query6000 = "SELECT id,f_name, l_name FROM employees WHERE id = '$response'";
								$result6000 = mysql_query($query6000) or die (mysql_error());
								$row6000 = mysql_fetch_array($result6000);
								$employeename = $row6000['f_name'] . ' ' . $row6000['l_name'];
								//mysql_close($conn2);
?>
               	<?php echo '<a href="' . 'taskreports.php?emp1='.$response.'&emp='.$response.'">'. ($employeename). '</a>' ?>
            		</td>
							</tr>
<?php
				}
	}
			//$conn3 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
      mysql_select_db('homefree');
			$query7 = "SELECT * FROM employees WHERE dept = '$dept'";
			$result7 = mysql_query($query7) or die (mysql_error());
			while($row7 = mysql_fetch_array($result7))
    		{
					$where1[] = $row7['id'];         	
        }
      //mysql_close($conn3);
?>
	<table cellpadding=2  width="325" table border = "0" align = "left">
			<tr>
     		<td colspan="2"><b>
					Individual Open Tasks (Co-Responsible):
				</b></td>
			</tr>
<?php
foreach($where1 as $val1) 
	{
		include 'includes/configtask.php';
		include 'includes/opendbtask.php';
    $query101 = "SELECT * FROM taskinfo WHERE ((Response2 = '$val1') AND (Status <> 3 AND Status <> 4)) ORDER BY ID";
    $result101 = mysql_query($query101);
    $overdue = "SELECT * FROM taskinfo WHERE ((Response2 = '$val1') AND (Status <> 3 AND Status <> 4)) ORDER BY ID";
    $resoverdue = mysql_query($overdue);  
   	$y = 0;
    while($rowoverdue = mysql_fetch_array($resoverdue))
    	{
    		$duedate1 = $rowoverdue['Duedate'];
				$duedate = strtotime($duedate1);
    		if($now > $duedate)
	      	{
  	      	$y = $y + 1;
          }
       }    
    $row101 = mysql_num_rows($result101);
    if(!$row101 ==0)
    	{
?>
				<tr>
       	 <td width = "120" valign = "top">             
						Open Tasks <?php echo $row101. ' '. '<font color="#ff0000">('. $y . ')</font>' ?>
					</td>
					<td> 
<?php 
						$rows1 = mysql_fetch_assoc($result101);
          	$response2 = $rows1['Response2'];  
          	//$conn4 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
            mysql_select_db('homefree');
						$query6001 = "SELECT id,f_name, l_name FROM employees WHERE id = '$response2'";
						$result6001 = mysql_query($query6001) or die (mysql_error());
						$row6001 = mysql_fetch_array($result6001);
						$employeename2 = $row6001['f_name'] . ' ' . $row6001['l_name'];
						//mysql_close($conn4);
?>
						<?php echo '<a href="' . 'taskreports.php?emp1='.$response2.'&emp2='.$response2.'">'. ($employeename2). '</a>' ?>
					</td>
 				</tr>
<?php
			}
	}
?>
</table>
<tr>
	<td>
	<table cellpadding=2  width="325" table border = "0" align = "left">
	<tr>
		<td colspan="2"><b>
			Individual Open Tasks (To Check):
		</b></td>
	</tr>
<?php
//$conn5 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db('homefree');
$query8 = "SELECT * FROM employees WHERE dept = '$dept'";
$result8 = mysql_query($query8) or die (mysql_error());
while($row8 = mysql_fetch_array($result8))
	{
  	$where3[] = $row8['id'];         	
  }
  //mysql_close($conn5);
foreach($where3 as $val3) 
	{
		include 'includes/configtask.php';
		include 'includes/opendbtask.php';
    $query102 = "SELECT * FROM taskinfo WHERE ((Response3 = '$val3') AND (Status <> 3 AND Status <> 4)) ORDER BY ID";
    $result102 = mysql_query($query102);
    $overdue = "SELECT * FROM taskinfo WHERE ((Response3 = '$val3') AND (Status <> 3 AND Status <> 4)) ORDER BY ID";
    $resoverdue = mysql_query($overdue);  
   	$z = 0;
    while($rowoverdue = mysql_fetch_array($resoverdue))
    	{
    		$duedate1 = $rowoverdue['Duedate'];
				$duedate = strtotime($duedate1);
    		if($now > $duedate)
	      	{
  	      	$z = $z + 1;
          }
       }
    $row102 = mysql_num_rows($result102);
    if(!$row102 ==0)
    	{
?>
				<tr>
					<td width = "120">             
						Open Tasks <?php echo $row102. ' '. '<font color="#ff0000">('. $z . ')</font>' ?> 
					</td>
					<td> 
          	 <?php 
          	$rows3 = mysql_fetch_assoc($result102);
          	$response3 = $rows3['Response3'];  
          	//$conn6 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
            mysql_select_db('homefree');
						$query6002 = "SELECT id,f_name, l_name FROM employees WHERE id = '$response3'";
						$result6002 = mysql_query($query6002) or die (mysql_error());
						$row6002 = mysql_fetch_array($result6002);
						$employeename3 = $row6002['f_name'] . ' ' . $row6002['l_name'];
						//mysql_close($conn6);
?>
               	<?php echo '<a href="' . 'taskreports.php?emp1='.$response3.'&emp3='.$response3.'">'. ($employeename3). '</a>' ?>
          </td>
 				</tr>
<?php
			}
	}
//$conn7 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db('homefree');
$query9 = "SELECT * FROM employees WHERE dept = '$dept'";
$result9 = mysql_query($query9) or die (mysql_error());
while($row9 = mysql_fetch_array($result9))
	{
		$where4[] = $row9['id'];         	
	}
//mysql_close($conn7);
?>
<table cellpadding=2 width="325">
	<tr>
		<td colspan="2"><b>
			Individual Open Tasks (Assigned To):
		</b></td>
<?php
foreach($where4 as $val4) 
	{
		include 'includes/configtask.php';
		include 'includes/opendbtask.php';
    $query103 = "SELECT * FROM taskinfo WHERE ((Assignto = '$val4') AND (Status <> 3 AND Status <> 4)) ORDER BY ID";
    $result103 = mysql_query($query103);
    $overdue = "SELECT * FROM taskinfo WHERE ((Assignto = '$val4') AND (Status <> 3 AND Status <> 4)) ORDER BY ID";
    $resoverdue = mysql_query($overdue);  
   	$zz = 0;
    while($rowoverdue = mysql_fetch_array($resoverdue))
    	{
    		$duedate1 = $rowoverdue['Duedate'];
				$duedate = strtotime($duedate1);
    		if($now > $duedate)
	      	{
  	      	$zz = $zz + 1;
          }
       }
    $row103 = mysql_num_rows($result103);
    if(!$row103 ==0)
    	{
?>
		<tr>
    	<td width="120">             
				Open Tasks <?php echo $row103. ' '. '<font color="#ff0000">('. $zz . ')</font>' ?> 
			</td>
			<td> 
<?php 
				$rows4 = mysql_fetch_assoc($result103);
        $assignto = $rows4['Assignto'];  
        //$conn8 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
        mysql_select_db('homefree');
				$query6003 = "SELECT id,f_name, l_name FROM employees WHERE id = '$assignto'";
				$result6003 = mysql_query($query6003) or die (mysql_error());
				$row6003 = mysql_fetch_array($result6003);
				$assigntoname = $row6003['f_name'] . ' ' . $row6003['l_name'];
				//mysql_close($conn8);
?>
      	<?php echo '<a href="' . 'taskreports.php?emp1='.$assignto.'&assemp='.$assignto.'">'. ($assigntoname). '</a>' ?>
       </td>
      </tr>
  <?php
			}
	}
}
?>
</table>
</table>
<tr>
	<td>	
<table width = 750 align = "center" border = 0>
	<tr>
		<td>
				<button onClick="window.location='taskreporthome.php'">Back to the Task Report Page</button>
			</td>
	</tr>
</table>
<?php
if(isset($_GET['emp1']))
	{
		$empid1 = $_GET['emp1'];
		mysql_select_db('homefree');
		$selectemployeename = "SELECT f_name,l_name FROM employees WHERE id = '$empid1'";
		$resemployeename = mysql_query($selectemployeename);
		$rowemployeename = mysql_fetch_array($resemployeename);		
		$employeename = $rowemployeename['f_name'].' '.$rowemployeename['l_name'];
		include 'includes/configtask.php';
		include 'includes/opendbtask.php';
?>
		<table width = 750 align = "center" border = 0>
			<tr>
				<td>
					<b>Report For <?php echo $employeename; ?></b>
				</td>
			</tr>
		</table>
<?php		
		if(isset($_GET['emp']))
			{	
				$empid = $_GET['emp'];
				$query1 = "SELECT * FROM taskinfo WHERE ((Response = '$empid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				//$assign = mysql_fetch_array($result1);
			}	
		if(isset($_GET['emp2']))
			{	
				$empid = $_GET['emp2'];
				$query1 = "SELECT * FROM taskinfo WHERE ((Response2 = '$empid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				//$assign = mysql_fetch_array($result1);
			}				
		if(isset($_GET['emp3']))
			{	
				$empid = $_GET['emp3'];
				$query1 = "SELECT * FROM taskinfo WHERE ((Response3 = '$empid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				//$assign = mysql_fetch_array($result1);
			}					
		if(isset($_GET['assemp']))
			{	
				$empid = $_GET['assemp'];
				$query1 = "SELECT * FROM taskinfo WHERE ((Assignto = '$empid') AND (Status <> 3 AND Status <> 4)) ORDER BY Duedate";		
				$result1 = mysql_query($query1) or die (mysql_error());		
				//$assign = mysql_fetch_array($result1);
			}
		while($emp = mysql_fetch_array($result1))
			{
				$subject = $emp['Subject'];
				$ID = $emp['ID'];
				$status = $emp['Status'];
				$duedate1 = $emp['Duedate'];
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
									<table align=center width = 750>	
										<tr>
											<td width = 20><font face="Arial" size="2">
												<?php echo '<a href="' . 'task.php'.'?taskid='.$ID.'&view=update'.'">'.  $ID;?>
											</td>
											<td width = 500>
												Subject: <?php echo $subject; ?>
											</td>
											<td width = 100>
												Status: <?php echo $status1; ?>
											</td>				
										</tr>
<?php
			}
			echo '<tr><td colspan="2">'.'<input type="button" value="Back to previous page" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'">'.'</td></tr>';
	}


include 'includes/closedbtask.php';
?>