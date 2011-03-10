<?php

if((isset($_GET['print'])) && ($_GET['print'] == "print"))
{
	include 'printheader2.php';
}elseif((isset($_GET['print'])) && ($_GET['print'] == "graphprint"))
{
	include 'printheader4.php';
}elseif((isset($_GET['print'])) && ($_GET['print'] == "print1"))
{
	include 'printheader3.php';
}
else
{
	include 'header.php';
}

include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';

$date = date('m-d-Y');
/*
**************************************************************NEW SURVEY FORM**************************************************************
*/
?>
<link rel="stylesheet" type="text/css" href="sales.css" />
<?php
if((isset($_GET['view'])) && ($_GET['view'] == "new"))
{
	$f_id = $_GET['f_id'];
	mysql_select_db($dbname);
	$query1 = "SELECT FacilityName, City, StateOrProvinceCode FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_fetch_array($result1);	
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "2" align = "Center"><font face="Arial" size="4"><b>
				HomeFree Sales, Installation, and Training Evaluation Form<br></br>
				</b></td>
			</tr>
			<tr>
				<td colspan = "2"><b>
					As a customer of HomeFree your feedback is very important to the success of our operation.<br>
				Please take a few minutes to tell us about your total experience with HomeFree.<br></br>
				</b></td>
			<tr>
				<td width = "520">
					Customer Name: <input type="text" name="name" size="50" />
				</td>
				<td>
					Date: <input type="text" name="date" size="12" value="<?php echo $date; ?>" readonly/>
				</td>
			</tr>
			<tr>
				<td> 
					Customer Title: <input type="text" name="title" size="52" />
				</td>
				<td>
					Time Started: <input type="text" name="timestarted" size="12" />
				</td>
			</tr>
			<tr>
				<td>
					Customer Signature:_______________________________________________
				</td>
				<td>
					Time Ended: <input type="text" name="timeended" size="12" />
				</td>				
			</tr>
			<tr>
				<td>
					Facility Name: <input type="text" name="facility" size="53" value="<?php echo $row1['FacilityName']; ?>" readonly/>
				</td>
			</tr>
			<tr>
				<td>
					Facility Location: <input type="text" name="location" size="50" value="<?php echo $row1['City'].', '.$row1['StateOrProvinceCode']; ?>" readonly/>
				</td>
			</tr>
			<tr>
				<td>
					Presenter: <input type="text" name="presenter" size="56" />
				</td>
			</tr>
			<tr>
				<td>
					<br>
				</td>
			</tr>
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "2"><b>
					Sales:  Please evealuate each of the following aspects of the sales process by circling a number on the scale
					below.
				</b></td>
			</tr>
		</table>	
		<table width = "750" align = "center" border = "1">		
			<tr>
				<td width = "300" align="center">
				</td>
				<td width = "95" align="center">
					Excellent
				</td>
				<td width = "60" align="center">
					Good
				</td>
				<td width = "60" align="center">
					Fair
				</td>
				<td width = "60" align="center">
					Unsatisfactory
				</td>
				<td width = "170" align="center">
					Not Applicable
				</td>
			</tr>
			<tr>
				<td>
					Sales representative's product knowledge
				</td>
				<td align = "center">
					<input type="radio" name="sales_knowledge" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="sales_knowledge" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="sales_knowledge" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="sales_knowledge" value="1">
				</td>
				<td align = "center">
					<input type="radio" name="sales_knowledge" value="0">
				</td>				
			</tr>			
			<tr>
				<td>
					Ease and promptness of getting information from the sales representative
				</td>
				<td align = "center">
					<input type="radio" name="sales_ease_of_info" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="sales_ease_of_info" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="sales_ease_of_info" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="sales_ease_of_info" value="1">
				</td>
				<td align = "center">
					<input type="radio" name="sales_ease_of_info" value="0">
				</td>		
			</tr>		
			<tr>
				<td>
					Usefulness of sales information and brochures
				</td>
				<td align = "center">
					<input type="radio" name="sales_useful_info" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="sales_useful_info" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="sales_useful_info" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="sales_useful_info" value="1">
				</td>
				<td align = "center">
					<input type="radio" name="sales_useful_info" value="0">
				</td>			
			</tr>	
			<tr>
				<td>
					Sales representatives's professional manor
				</td>
				<td align = "center">
					<input type="radio" name="sales_professional_manor" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="sales_professional_manor" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="sales_professional_manor" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="sales_professional_manor" value="1">
				</td>
				<td align = "center">
					<input type="radio" name="sales_professional_manor" value="0">
				</td>		
			</tr>	
		</table>		
		<table width = "750" align = "center" border = "0">
			<tr>
				<td>
					Any other comments about the sales process:
				</td>
			</tr>
			<tr>
				<td colspan = "9">
					<textarea rows="3" cols="70" name="sales_comments"></textarea>
				</td>
			</tr>	
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "2"><b>
					Installation Process:  Please evealuate each of the following aspects of the installation process by circling a 
					number on the scale below.
				</b></td>
			</tr>
		</table>	
		<table width = "750" align = "center" border = "1">		
			<tr>
				<td width = "300" align="center">
				</td>
				<td width = "95" align="center">
					Excellent
				</td>
				<td width = "60" align="center">
					Good
				</td>
				<td width = "60" align="center">
					Fair
				</td>
				<td width = "60" align="center">
					Unsatisfactory
				</td>
				<td width = "170" align="center">
					Not Applicable
				</td>
			</tr>
			<tr>
				<td>
					Given clear, concise information about your installation
				</td>
				<td align = "center">
					<input type="radio" name="installation_clarity" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="installation_clarity" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="installation_clarity" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="installation_clarity" value="1">
				</td>
				<td align = "center">
					<input type="radio" name="installation_clarity" value="0">
				</td>				
			</tr>			
			<tr>
				<td>
					Received what was described in terms of equipment and design
				</td>
				<td align = "center">
					<input type="radio" name="installation_terms" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="installation_terms" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="installation_terms" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="installation_terms" value="1">
				</td>
				<td align = "center">
					<input type="radio" name="installation_terms" value="0">
				</td>		
			</tr>		
			<tr>
				<td>
					System installed in a timely manner
				</td>
				<td align = "center">
					<input type="radio" name="installation_timely" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="installation_timely" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="installation_timely" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="installation_timely" value="1">
				</td>
				<td align = "center">
					<input type="radio" name="installation_timely" value="0">
				</td>			
			</tr>	
			<tr>
				<td>
					Satisfaction with final installation
				</td>
				<td align = "center">
					<input type="radio" name="installation_satisfaction" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="installation_satisfaction" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="installation_satisfaction" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="installation_satisfaction" value="1">
				</td>
				<td align = "center">
					<input type="radio" name="installation_satisfaction" value="0">
				</td>		
			</tr>	
		</table>		
		<table width = "750" align = "center" border = "0">
			<tr>
				<td>
					Any other comments about the system installation:
				</td>
			</tr>
			<tr>
				<td colspan = "9">
					<textarea rows="3" cols="70" name="installation_comments"></textarea>
				</td>
			</tr>	
		</table>		
		<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "8"><b>
					Training:  Please evealuate each of the following aspects of the training session by circling a number on the scale
					below.
				</b></td>
			</tr>	
		</table>								
		<table width = "750" align = "center" border = "1">		
			<tr>
				<td width = "300" align="center">
				</td>
				<td width = "95" align="center">
					Excellent
				</td>
				<td width = "60" align="center">
					Good
				</td>
				<td width = "60" align="center">
					Fair
				</td>
				<td width = "60" align="center">
					Unsatisfactory
				</td>
				<td width = "170" align="center">
				</td>
			</tr>
			<tr>
				<td>
					The length of the in-service was: 
				</td>
				<td align = "center">
					<input type="radio" name="length" value="4">
				</td>
				<td align = "center">
					<input type="radio" name="length" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="length" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="length" value="1">
				</td>			
			</tr>			
			<tr>
				<td>
					Instructor professional manor and courtesy
				</td>
				<td align = "center">
					<input type="radio" name="manor" value="4">	
				</td>
				<td align = "center">
					<input type="radio" name="manor" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="manor" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="manor" value="1">
				</td>
			</tr>		
			<tr>
				<td>
					Instructor’s knowledge
				</td>
				<td align = "center">
					<input type="radio" name="knowledge" value="4">	
				</td>
				<td align = "center">
					<input type="radio" name="knowledge" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="knowledge" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="knowledge" value="1">
				</td>	
			</tr>	
			<tr>
				<td>
					Instructor’s ability to explain content clearly
				</td>
				<td align = "center">
					<input type="radio" name="ability" value="4">	
				</td>
				<td align = "center">
					<input type="radio" name="ability" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="ability" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="ability" value="1">
				</td>		
			</tr>	
			<tr>
				<td>
					Instructor’s ability to respond well to questions
				</td>
				<td align = "center">
					<input type="radio" name="respond" value="4">	
				</td>
				<td align = "center">
					<input type="radio" name="respond" value="3">
				</td>
				<td align = "center">
					<input type="radio" name="respond" value="2">
				</td>
				<td align = "center">
					<input type="radio" name="respond" value="1">
				</td>
			</tr>
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td>
				</td>
			</tr>
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td>
					<br>
				</td>
			</tr>	
			<tr>
				<td>
					<br>
				</td>
			</tr>
			<tr>
				<td colspan = "9">
					Please Comment on the overall training session and provide any comments that would help HomeFree improve
					our training efforts:
				</td>
			</tr>
			<tr>
				<td colspan = "9">
					<textarea rows="3" cols="70" name="overall"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan = "9">
					Do you feel that you need additional training? <input type="radio" name="additional" value="0">NO		<input type="radio" name="additional" value="1">YES
				</td>
			</tr>
			<tr>
				<td>
					Comments:
				</td>
			</tr>
			<tr>
				<td colspan = "9">
					<textarea rows="3" cols="70" name="additional_training_comments"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan = "9">
					Would you recommend HomeFree to other customers?<input type="radio" name="reference" value="0">NO		<input type="radio" name="reference" value="1">YES
				</td>
			</tr>
			<tr>
				<td>
					Comments:
				</td>
			</tr>
			<tr>
				<td colspan = "9">
					<textarea rows="3" cols="70" name="reference_comments"></textarea>
				</td>
			</tr>			
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td>
					<br>
					<br>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Submit" name="surveysubmit">
				</td>
			</tr>
			<tr>
				<td align = "center" colspan = "3">
					Thank you so much for your frank contributions.<br>
					Your feedback will help us improve our efforts in order to serve you better.<br>
					Please do not hesitate to contact us with any additional comments.
				</td>
			</tr>
			<tr>
				<td>
					<br>
				</td>
			</tr>
		</table>
		<table width = "415" align = "center" border = "0">
			<tr>
				<td>
					<table width = "150" align = "left" border = "0">
						<tr>
							<td>
								<table width = "250" align = "left" border = "0">
									<tr>
										<td><b>
											Mary Petersen
										</b></td>
									</tr>
									<tr>
										<td>
											Customer Trainer
										</td>
									</tr>
									<tr>
										<td>
											maryp@homefreesys.com
										</td>
									</tr>
									<tr>
										<td>
											Toll Free….800.606.0661
										</td>
									</tr>
									<tr>
										<td>
											Local…414.358.8200
										</td>
									</tr>
									<tr>
										<td>
											Fax….414.358.8100
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width = "50" align = "left" border = "0">
						<tr>
							<td>
								<table width = "250" align = "right" border = "0">
									<tr>
										<td><b>
											Andrew Cohen
										</b></td>
									</tr>
									<tr>
										<td>				
											Customer Service Manager
										</td>
									</tr>
									<tr>
										<td>
											andrewc@homefreesys.com
										</td>
									</tr>
									<tr>
										<td>
											Toll Free….800.606.0661
										</td>
									</tr>
									<tr>
										<td>
											Local…414.358.8200
										</td>
									</tr>
									<tr>
										<td>
											Fax….414.358.8100
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>						
		</table>
	</form>
<?php
}
/*
**************************************************************INSERT DATA to DB FROM SURVEY********************************************************
*/
if(isset($_GET['surveysubmit']))
{	
	$f_id = $_GET['f_id'];
	if($_GET['name'] <> '')
	{
		$name = $_GET['name'];
	}else
	{
		$name = "Anonymous";
	}
	if($_GET['title'] <> '')
	{
		$title = $_GET['title'];
	}else
	{
		$title = "Not Given";
	}
	if($_GET['presenter'] <> '')
	{
		$presenter = $_GET['presenter'];
	}else
	{
		$presenter = "Not Given";
	}
	if($_GET['timestarted'] <> '')
	{
		$starttime = $_GET['timestarted'];
	}else
	{
		$starttime = "Not Given";
	}
	if($_GET['timeended'] <> '')
	{
		$endtime = $_GET['timeended'];
	}else
	{
		$endtime = "Not Given";		
	}
	$submitdate = $_GET['date'];
/***************************************SALES VARIABLES********************************/
	if(isset($_GET['sales_knowledge']))
	{
		$sales_knowledge = $_GET['sales_knowledge'];
	}else
	{
		$sales_knowledge = 0;
	}
	if(isset($_GET['sales_ease_of_info']))
	{
		$sales_ease_of_info = $_GET['sales_ease_of_info'];
	}else
	{
		$sales_ease_of_info = 0;
	}
	if(isset($_GET['sales_useful_info']))
	{
		$sales_useful_info = $_GET['sales_useful_info'];
	}else
	{
		$sales_useful_info = 0;
	}
	if(isset($_GET['sales_professional_manor']))
	{
		$sales_professional_manor = $_GET['sales_professional_manor'];
	}else
	{
		$sales_professional_manor = 0;
	}
	if($_GET['sales_comments'] <> '')
	{
		$sales_comments = addslashes($_GET['sales_comments']);
	}else
	{
		$sales_comments = 'NONE';
	}		
/***************************************INSTALLATION VARIABLES********************************/
	if(isset($_GET['installation_clarity']))
	{
		$installation_clarity = $_GET['installation_clarity'];
	}else
	{
		$installation_clarity = 0;
	}
	if(isset($_GET['sales_ease_of_info']))
	{
		$installation_terms = $_GET['installation_terms'];
	}else
	{
		$installation_terms = 0;
	}
	if(isset($_GET['installation_timely']))
	{
		$installation_timely = $_GET['installation_timely'];
	}else
	{
		$installation_timely = 0;
	}
	if(isset($_GET['installation_satisfaction']))
	{
		$installation_satisfaction = $_GET['installation_satisfaction'];
	}else
	{
		$installation_satisfaction = 0;
	}
	if($_GET['installation_comments'] <> '')
	{
		$installation_comments = addslashes($_GET['installation_comments']);
	}else
	{
		$installation_comments = 'NONE';
	}			
/***************************************TRAINING VARIABLES*********************************/	
	if(isset($_GET['manor']))
	{
		$manor = $_GET['manor'];
	}else
	{
		$manor = 0;
	}
	if(isset($_GET['knowledge']))
	{
		$knowledge = $_GET['knowledge'];
	}else
	{
		$knowledge = 0;
	}
	if(isset($_GET['ability']))
	{
		$ability = $_GET['ability'];
	}else
	{
		$ability = 0;
	}
	if(isset($_GET['respond']))
	{
		$respond = $_GET['respond'];
	}else
	{
		$respond = 0;
	}
	if(isset($_GET['length']))
	{
		$length = $_GET['length'];
	}else
	{
		$length = 0;
	}
	if($_GET['overall'] <> '')
	{
		$overall = addslashes($_GET['overall']);
	}else
	{
		$overall = 'NONE';
	}		
	if(isset($_GET['additional']))
	{
		$additional = $_GET['additional'];
	}else
	{
		$additional = 2;
	}
	if($_GET['additional_training_comments'] <> '')
	{
		$additionalexp = addslashes($_GET['additional_training_comments']);
	}else
	{
		$additionalexp = 'NONE';
	}	
	if(isset($_GET['reference']))
	{
		$reference = $_GET['reference'];
	}else
	{
		$reference = 2;
	}	
	if($_GET['reference_comments'] <> '')
	{
		$referenceexp = addslashes($_GET['reference_comments']);
	}else
	{
		$referenceexp = 'NONE';
	}
	mysql_select_db($dbname2);
	$query2 = "INSERT INTO tbltrainingdata (date,name,title,CustomerNumber,timestarted,timeended,presenter,manor,knowledge,
						ability,respond,length,reference,overall,additional,additionalexp,referenceexp,sales_knowledge,sales_ease_of_info,
						sales_useful_info,sales_professional_manor,sales_comments,installation_clarity,installation_terms,installation_timely,
						installation_satisfaction,installation_comments) VALUES ('$submitdate','$name','$title','$f_id','$starttime',
						'$endtime','$presenter','$manor','$knowledge','$ability','$respond','$length','$reference','$overall',
						'$additional','$additionalexp','$referenceexp','$sales_knowledge','$sales_ease_of_info','$sales_useful_info',
						'$sales_professional_manor','$sales_comments','$installation_clarity','$installation_terms','$installation_timely',
						'$installation_satisfaction','$installation_comments')";
	mysql_query($query2) or die(mysql_error());	
/*	
**************************************************************EMAIL ALERT*********************************************	
*/
	$query57 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber = '$f_id'";
	$result57 = mysql_query($query57) or die (mysql_error());
	$row57 = mysql_num_rows($result57);
	mysql_select_db($dbname);
	$query58 = "SELECT FacilityName FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result58 = mysql_query($query58) or die (mysql_error());
	$row58 = mysql_fetch_array($result58);
	if($row57 > 4)
	{
		mysql_select_db($dbname2);
		$query13 = "SELECT SUM(manor), SUM(knowledge), SUM(ability), SUM(respond),
								SUM(length) FROM tbltrainingdata WHERE CustomerNumber='$f_id'"; 
		$result13 = mysql_query($query13) or die(mysql_error());	
		$row13 = mysql_fetch_array($result13);	
		
		$totalman1 = $row13['SUM(manor)'];
		$totalkno1 = $row13['SUM(knowledge)'];
		$totalabi1 = $row13['SUM(ability)'];
		$totalres1 = $row13['SUM(respond)'];
		$totallen1 = $row13['SUM(length)'];

		$query17 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND manor <> 0"; 
		$result17 = mysql_query($query17) or die(mysql_error());
		$count17 = mysql_num_rows($result17);
		$query19 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND knowledge <> 0"; 
		$result19 = mysql_query($query19) or die(mysql_error());
		$count19 = mysql_num_rows($result19);
		$query20 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND ability <> 0"; 
		$result20 = mysql_query($query20) or die(mysql_error());
		$count20 = mysql_num_rows($result20);
		$query21 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND respond <> 0"; 
		$result21 = mysql_query($query21) or die(mysql_error());
		$count21 = mysql_num_rows($result21);	
		$query22 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND length <> 0"; 
		$result22 = mysql_query($query22) or die(mysql_error());
		$count22 = mysql_num_rows($result22);		
	
		$avgman1a = ($totalman1 / $count17);
		$avgkno1a = ($totalkno1 / $count19);
		$avgabi1a = ($totalabi1 / $count20);
		$avgres1a = ($totalres1 / $count21);
		$avglen1a = ($totallen1 / $count22);
	
		$avgman1 = round($avgman1a,2);
		if($avgman1 < 3.50)
		{
			$avgman1font = '#ff0000';
		}else
		{
			$avgman1font = '#000000';
		}		
		$avgkno1 = round($avgkno1a,2);
		if($avgkno1 < 3.50)
		{
			$avgkno1font = '#ff0000';
		}else
		{
			$avgkno1font = '#000000';
		}		
		$avgabi1 = round($avgabi1a,2);
		if($avgabi1 < 3.50)
		{
			$avgabi1font = '#ff0000';
		}else
		{
			$avgabi1font = '#000000';
		}		
		$avgres1 = round($avgres1a,2);
		if($avgres1 < 3.50)
		{
			$avgres1font = '#ff0000';
		}else
		{
			$avgres1font = '#000000';
		}		
		$avglen1 = round($avglen1a,2);
		if($avglen1 < 3.50)
		{
			$avglen1font = '#ff0000';
		}else
		{
			$avglen1font = '#000000';
		}		
		if(($avgman1 < 3.50) OR ($avgkno1 < 3.50) OR ($avgabi1 < 3.50) OR ($avgres1 < 3.50) OR ($avglen1 < 3.50))
		{
			require_once "Mail.php";
			$SmtpHost = "upsilon.dmatek.com";
			$SmtpUsername = "Demon";
			$SmtpPassword = "Q1w2e3";
			$type = "text/html";
			$from = "Training Center <donotreply@homefreesys.com>";
			$to =  "Drew Dehnert <drewd@homefreesys.com";//"Mary Petersen <maryp@homefreesys.com>,Andrew Cohen <andrewc@homefreesys.com>, Avi Ben-Hayun <avib@homefreesys.com";
			$subject = "Rating Warning For ".  $row58['FacilityName']."";
			$body = '<p>You are receiving this because a facility has given training ratings that are below the treshold</p><p>The lines in red show what is under the treshold.</p>
							<p>This message was automatically generated to provide you with the following information:</p>
							<p><fieldset><legend><b><font face="Arial" size="2">Details:</b></legend><dl><dt><font face="Arial" size="2">Customer Results:</dt><dt><dd><font face="Arial" size="2" color="'.$avgman1font.'"> Professional Manor: ' . $avgman1 . '</dd></dt><dt><dd><font face="Arial" size="2" color="'.$avgkno1font.'"> Instructor Knowledge: ' . $avgkno1 . '</dd></dt><dt><dd><font face="Arial" size="2" color="'.$avgabi1font.'"> Clear Content: ' . $avgabi1 . '</dd></dt><dt><dd><font face="Arial" size="2" color="'.$avgres1font.'"> Instructor Question Response: ' . $avgres1 . '</dd></dt><dt><dd><font face="Arial" size="2" color="'.$avglen1font.'"> Length of Training: ' . $avglen1 . '</dd></dl></fieldset></p>';
			$headers = array ('From' => $from,
				'To' => $to,
	      'Subject' => $subject,
  	    'Content-type' => $type);
			$smtp = Mail::factory('smtp',
	    array ('host' => $SmtpHost,
	           'auth' => true,
 	          'username' => $SmtpUsername,
 	          'password' => $SmtpPassword));                                   
			$mail = $smtp->send($to, $headers, $body);
		}
	}	
	header("Location: trainingeval.php?view=home&f_id=$f_id");		
}
/*
**************************************************************TRAINING HOME PAGE**************************************************************
*/
if((isset($_GET['view'])) && ($_GET['view'] == "home"))
{
	if(isset($_GET['f_id']))
	{
		$f_id = $_GET['f_id'];
		mysql_select_db($dbname);
		$query3 = "SELECT FacilityName, City, StateOrProvinceCode FROM tblfacilities WHERE CustomerNumber = '$f_id'";
		$result3 = mysql_query($query3) or die (mysql_error());
		$row3 = mysql_fetch_array($result3);
		$fname = $row3['FacilityName'];
		mysql_select_db($dbname2);
		$query4 = "SELECT * FROM tbltrainingdata WHERE CustomerNumber = '$f_id'";
		$result4 = mysql_query($query4) or die (mysql_error());
		$count4 = mysql_num_rows($result4);
?>
		<table width = "450" align = "center" border = "0">
			<tr>
				<td colspan = "3" align = "center"><font face="Arial" size="4"><b>
					Customer Evaluation Center
				</b></td>
			</tr>
			<tr>
				<td align = "center"><font face="Arial" size="2">
					<?php echo '<a href=" ../sales/trainingeval.php?view=new&f_id='.$f_id.'">'. 'Submit A Survey' .' </a>'; ?>
				</td>
<?php 	if($count4 > 0)
				{
?>					
					<td align = "center"><font face="Arial" size="2">
						<?php echo '<a href=" ../sales/trainingeval.php?view=compare&f_id='.$f_id.'">'. 'Compare Information' .' </a>'; ?>
					</td>	
<?php
				}	
?>							
				<td>
					<?php echo '<a href=" ../sales/trainingeval.php?view=search">'. 'Change Acitve Customer' .' </a>'; ?>
				</td>							
			</tr>
			<tr>
				<td>
					<br>
				</td>
			</tr>						
			<tr>
				<td colspan = "3" align = "center"><font face="Arial" size="3"><b>
					<?php echo $fname; ?>
				</b></td>
			</tr>		
		</table>
<?php		
		if($count4 > 0)
		{
			$query13 = "SELECT SUM(manor), SUM(knowledge), SUM(ability), SUM(respond), SUM(length), SUM(sales_knowledge),
		 						SUM(sales_ease_of_info), SUM(sales_useful_info), SUM(sales_professional_manor), SUM(installation_clarity), 
		 						SUM(installation_terms), SUM(installation_timely), SUM(installation_satisfaction) FROM tbltrainingdata WHERE 
								CustomerNumber='$f_id'"; 
			$result13 = mysql_query($query13) or die(mysql_error());	
			$row13 = mysql_fetch_array($result13);	
		
			$totalman1 = $row13['SUM(manor)'];
			$totalkno1 = $row13['SUM(knowledge)'];
			$totalabi1 = $row13['SUM(ability)'];
			$totalres1 = $row13['SUM(respond)'];
			$totallen1 = $row13['SUM(length)'];

			$query17 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND manor <> 0"; 
			$result17 = mysql_query($query17) or die(mysql_error());
			$count17 = mysql_num_rows($result17);
			$query19 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND knowledge <> 0"; 
			$result19 = mysql_query($query19) or die(mysql_error());
			$count19 = mysql_num_rows($result19);
			$query20 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND ability <> 0"; 
			$result20 = mysql_query($query20) or die(mysql_error());
			$count20 = mysql_num_rows($result20);
			$query21 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND respond <> 0"; 
			$result21 = mysql_query($query21) or die(mysql_error());
			$count21 = mysql_num_rows($result21);	
			$query22 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND length <> 0"; 
			$result22 = mysql_query($query22) or die(mysql_error());
			$count22 = mysql_num_rows($result22);		
	
			$avgman1a = ($totalman1 / $count17);
			$avgkno1a = ($totalkno1 / $count19);
			$avgabi1a = ($totalabi1 / $count20);
			$avgres1a = ($totalres1 / $count21);
			$avglen1a = ($totallen1 / $count22);
		
			$avgman1 = round($avgman1a,2);
			if($avgman1 < 3.50)
			{
				$avgman1font = '#ff0000';
			}else
			{
				$avgman1font = '#000000';
			}		
			$avgkno1 = round($avgkno1a,2);
			if($avgkno1 < 3.50)
			{
				$avgkno1font = '#ff0000';
			}else
			{
				$avgkno1font = '#000000';
			}		
			$avgabi1 = round($avgabi1a,2);
			if($avgabi1 < 3.50)
			{
				$avgabi1font = '#ff0000';
			}else
			{
				$avgabi1font = '#000000';
			}		
			$avgres1 = round($avgres1a,2);
			if($avgres1 < 3.50)
			{
				$avgres1font = '#ff0000';
			}else
			{
				$avgres1font = '#000000';
			}		
			$avglen1 = round($avglen1a,2);
			if($avglen1 < 3.50)
			{
				$avglen1font = '#ff0000';
			}else
			{
				$avglen1font = '#000000';
			}
/*SALES MATH FOR Customer STATISTICS*/
			$total_sales_knowledge1 = $row13['SUM(sales_knowledge)'];
			$total_sales_ease1 = $row13['SUM(sales_ease_of_info)'];
			$total_sales_useful1 = $row13['SUM(sales_useful_info)'];
			$total_sales_professional1 = $row13['SUM(sales_professional_manor)'];		
			
			$query117 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND sales_knowledge <> 0 AND sales_knowledge <> 5"; 
			$result117 = mysql_query($query117) or die(mysql_error());
			$count117 = mysql_num_rows($result117);
			$query119 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND sales_ease_of_info <> 0 AND sales_ease_of_info <> 5"; 
			$result119 = mysql_query($query119) or die(mysql_error());
			$count119 = mysql_num_rows($result119);
			$query120 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND sales_useful_info <> 0 AND sales_useful_info <> 5"; 
			$result120 = mysql_query($query120) or die(mysql_error());
			$count120 = mysql_num_rows($result120);
			$query121 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND sales_professional_manor <> 0 AND sales_professional_manor <> 5"; 
			$result121 = mysql_query($query121) or die(mysql_error());
			$count121 = mysql_num_rows($result121);
			
			if($count117 > 0)
			{
				$avg_sales_knowledge1a = ($total_sales_knowledge1 / $count117);
			}else
			{
				$avg_sales_knowledge1a = 0;
			}
			if($count119 > 0)
			{
				$avg_sales_ease1a = ($total_sales_ease1 / $count119);
			}else
			{
				$avg_sales_ease1a = 0;
			}			
			if($count120 > 0)
			{
				$avg_sales_useful1a = ($total_sales_useful1 / $count120);
			}else
			{
				$avg_sales_useful1a = 0;
			}				
			if($count120 > 0)
			{
				$avg_sales_professional1a = ($total_sales_professional1 / $count121);
			}else
			{
				$avg_sales_professional1a = 0;
			}			
			
			$avg_sales_knowledge1 = round($avg_sales_knowledge1a,2);
			if($avg_sales_knowledge1 < 3.50)
			{
				$avg_sales_knowledge1font = '#ff0000';
			}else
			{
				$avg_sales_knowledge1font = '#000000';
			}				
			$avg_sales_ease1 = round($avg_sales_ease1a,2);
			if($avg_sales_ease1 < 3.50)
			{
				$avg_sales_ease1font = '#ff0000';
			}else
			{
				$avg_sales_ease1font = '#000000';
			}		
			$avg_sales_useful1 = round($avg_sales_useful1a,2);
			if($avg_sales_useful1 < 3.50)
			{
				$avg_sales_useful1font = '#ff0000';
			}else
			{
				$avg_sales_useful1font = '#000000';
			}		
			$avg_sales_professional1 = round($avg_sales_professional1a,2);
			if($avg_sales_professional1 < 3.50)
			{
				$avg_sales_professional1font = '#ff0000';
			}else
			{
				$avg_sales_professional1font = '#000000';
			}		
/*INSTALLATION MATH FOR Customer STATISTICS*/				
			$total_installation_clarity1 = $row13['SUM(installation_clarity)'];
			$total_installation_terms1 = $row13['SUM(installation_terms)'];
			$total_installation_timely1 = $row13['SUM(installation_timely)'];
			$total_installation_satisfaction1 = $row13['SUM(installation_satisfaction)'];	
			
			$query217 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND installation_clarity <> 0 AND installation_clarity <> 5"; 
			$result217 = mysql_query($query217) or die(mysql_error());
			$count217 = mysql_num_rows($result217);
			$query219 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND installation_timely <> 0 AND installation_timely <> 5"; 
			$result219 = mysql_query($query219) or die(mysql_error());
			$count219 = mysql_num_rows($result219);
			$query220 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND installation_timely <> 0 AND installation_timely <> 5"; 
			$result220 = mysql_query($query220) or die(mysql_error());
			$count220 = mysql_num_rows($result220);
			$query221 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$f_id' AND installation_satisfaction <> 0 AND installation_satisfaction <> 5"; 
			$result221 = mysql_query($query221) or die(mysql_error());
			$count221 = mysql_num_rows($result221);	
		
			if($count217 > 0)
			{
				$avg_installation_clarity1a = ($total_installation_clarity1 / $count217);
			}else
			{
				$avg_installation_clarity1a = 0;
			}
			if($count219 > 0)
			{
				$avg_installation_terms1a = ($total_installation_terms1 / $count219);
			}else
			{
				$avg_installation_terms1a = 0;
			}			
			if($count220 > 0)
			{
				$avg_installation_timely1a = ($total_installation_timely1 / $count220);
			}else
			{
				$avg_installation_timely1a = 0;
			}				
			if($count120 > 0)
			{
				$avg_installation_satisfaction1a = ($total_installation_satisfaction1 / $count221);
			}else
			{
				$avg_installation_satisfaction1a = 0;
			}
		
		
			$avg_installation_clarity1 = round($avg_installation_clarity1a,2);
			if($avg_installation_clarity1 < 3.50)
			{
				$avg_installation_clarity1font = '#ff0000';
			}else
			{
				$avg_installation_clarity1font = '#000000';
			}				
			$avg_installation_terms1 = round($avg_installation_terms1a,2);
			if($avg_installation_terms1 < 3.50)
			{
				$avg_installation_terms1font = '#ff0000';
			}else
			{
				$avg_installation_terms1font = '#000000';
			}		
			$avg_installation_timely1 = round($avg_installation_timely1a,2);
			if($avg_installation_timely1 < 3.50)
			{
				$avg_installation_timely1font = '#ff0000';
			}else
			{
				$avg_installation_timely1font = '#000000';
			}		
			$avg_installation_satisfaction1 = round($avg_installation_satisfaction1a,2);
			if($avg_installation_satisfaction1 < 3.50)
			{
				$avg_installation_satisfaction1font = '#ff0000';
			}else
			{
				$avg_installation_satisfaction1font = '#000000';
		}		
		
		
					
					
?>
		<FIELDSET>
			<table width = "730" align = "center" border = "0">
				<tr>
					<td colspan = "2"><font face="Arial" size="2"><u>
						Previously Submitted Surveys:
					</u></td>
				</tr>
				<tr>
					<td><font face="Arial" size="2"><u>
						Name
					</u></td>
					<td><font face="Arial" size="2"><u>
						Title
					</u></td>
					<td><font face="Arial" size="2"><u>
						Date
					</u></td>						
<?php
					while($row4 = mysql_fetch_array($result4))
					{	
						$surveyid = $row4['ID'];
?>						
						<tr>
							<td><font face="Arial" size="2">
								<?php echo $row4['name']; ?>
							</td>
							<td><font face="Arial" size="2">
								<?php echo $row4['title']; ?>
							</td>
							<td><font face="Arial" size="2">
								<?php echo $row4['date']; ?>
							</td>
							<td><font face="Arial" size="2">
								<?php echo '<a href=" ../sales/trainingeval.php?view=survey&surveyid='.$surveyid.'">'. 'View Survey' .' </a>'; ?>
							</td>
<?php					
					}
?>								
			</table>
		</FIELDSET>
		<FIELDSET>
			<table width = "750" align = "center" border = "0">
				<tr>
					<td colspan = "10" align = "center"><font face="Arial" size="3"><b>
						Customer Statistics
					</b></td>
				</tr>
				<tr>
					<td colspan = "10" align = "center"><font face="Arial" size="2"><b>
						Surveys Submitted: <?php echo $count4; ?>
					</b></td>
				</tr>
				<tr>
					<td valign = "bottom" align = "center"><font face="Arial" size="1">
					</td>
       		<td valign = "bottom" align = "center"><font face="Arial" size="1">
       			Product knowledge
       		</td>
   	    	<td valign = "bottom" align = "center"><font face="Arial" size="1">
   	    		Availability
   	    	</td>
     	  	<td valign = "bottom" align = "center"><font face="Arial" size="1">
     	  		Brochures
     	  	</td>
        	<td valign = "bottom" align = "center"><font face="Arial" size="1">
        		Professional Manor
        	</td>
 	      	<td valign = "bottom" align = "center"><font face="Arial" size="1">
 	      	</td>
 	      </tr>
				<tr>
					<td align = "center"><font face="Arial" size="2">
						Sales
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_knowledge1font; ?>">
						<?php echo $avg_sales_knowledge1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_ease1font; ?>">
						<?php echo $avg_sales_ease1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_useful1font; ?>">
						<?php echo $avg_sales_useful1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_professional1font; ?>">
						<?php echo $avg_sales_professional1; ?>
					</td>
					<td align = "center">
					</td>
				</tr>	
	      <tr>
 	      	<td colspan = 10 valign = "top">
 	      		<div align="center"><hr width="100%"></div>
 	      	</td>
				</tr>		
				<tr>
					<td valign = "bottom" align = "center"><font face="Arial" size="1">
					</td>
       		<td valign = "bottom" align = "center"><font face="Arial" size="1">
       			Clear Information
       		</td>
   	    	<td valign = "bottom" align = "center"><font face="Arial" size="1">
   	    		Terms of Equipment and Design
   	    	</td>
     	  	<td valign = "bottom" align = "center"><font face="Arial" size="1">
     	  		Timely Manner
     	  	</td>
        	<td valign = "bottom" align = "center"><font face="Arial" size="1">
        		Satisfaction
        	</td>
 	      	<td valign = "bottom" align = "center"><font face="Arial" size="1">
 	      	</td>
 	      </tr>
				<tr>
					<td align = "center"><font face="Arial" size="2">
						Installation
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_installation_clarity1font; ?>">
						<?php echo $avg_installation_clarity1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_installation_terms1font; ?>">
						<?php echo $avg_installation_terms1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_installation_timely1font; ?>">
						<?php echo $avg_installation_timely1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_professional1font; ?>">
						<?php echo $avg_sales_professional1; ?>
					</td>
					<td align = "center">
					</td>
				</tr>		
 	      <tr>
 	      	<td colspan = 10 valign = "top">
 	      		<div align="center"><hr width="100%"></div>
 	      	</td>
				</tr>											
				<tr>
					<td>
					</td>
       		<td valign = "bottom" align = "center"><font face="Arial" size="1">
       			Instructor Professional Manor
       		</td>
   	    	<td valign = "bottom" align = "center"><font face="Arial" size="1">
   	    		Instructor Knowledge
   	    	</td>
     	  	<td valign = "bottom" align = "center"><font face="Arial" size="1">
     	  		Clear Content
     	  	</td>
        	<td valign = "bottom" align = "center"><font face="Arial" size="1">
        		Instructor Question Response
        	</td>
 	      	<td valign = "bottom" align = "center"><font face="Arial" size="1">
 	      		Length of Training
 	      	</td>
 	      </tr>
				<tr>
					<td align = "center"><font face="Arial" size="2">
						Training
					</td>
					<td align = "center"><font face="Arial" size="2"color="<?php echo $avgman1font; ?>">
						<?php echo $avgman1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2"color="<?php echo $avgkno1font; ?>">
						<?php echo $avgkno1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2"color="<?php echo $avgres1font; ?>">
						<?php echo $avgabi1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2"color="<?php echo $avgabi1font; ?>">
						<?php echo $avgres1; ?>
					</td>
					<td align = "center"><font face="Arial" size="2"color="<?php echo $avglen1font; ?>">
						<?php echo $avglen1; ?>
					</td>
				</tr> 	      
 	    </table>
 	  </FIELDSET>				
<?php		
		}else
		{
?>
			<table width = "450" align = "center" border = "0">
				<tr>
					<td>
						<br>
					</td>
				</tr>				
				<tr>
					<td colspan = "3" align = "center"><font face="Arial" size="2">
						No Surveys have been submitted by this customer.
					</td>
				</tr>		
				<tr>
					<td>
						<br>
					</td>
				</tr>		
			</table>
<?php
		}
	}else
	{
		$fname = 'No Active Customer';
?>
			<table width = "450" align = "center" border = "0">
				<tr>
					<td colspan = "3" align = "center"><font face="Arial" size="4"><b>
						Customer Evaluation Center
					</b></td>
				</tr>
				<tr>
					<td align = "center"><font face="Arial" size="2">
						<?php echo '<a href=" ../sales/trainingeval.php?view=compare">'. 'Compare Information' .' </a>'; ?>
					</td>	
					<td align = "center">
						<?php echo '<a href=" ../sales/trainingeval.php?view=search">'. 'Change Acitve Customer' .' </a>'; ?>
					</td>							
				</tr>
				<tr>
					<td>
						<br>
					</td>
				</tr>						
				<tr>
					<td colspan = "3" align = "center"><font face="Arial" size="3"><b>
						<?php echo $fname; ?>
					</b></td>
				</tr>					
			</table>	
<?php				
	}
	mysql_select_db($dbname2);
	$query60 = "SELECT * FROM tbltrainingdata";
	$result60 = mysql_query($query60);
	$count60 = mysql_num_rows($result60);
	$row60 = mysql_fetch_array($result60);
	if($count60 <> 0)
	{
		$query24 = "SELECT SUM(manor), SUM(knowledge), SUM(ability), SUM(respond), SUM(length), SUM(sales_knowledge),
		 SUM(sales_ease_of_info), SUM(sales_useful_info), SUM(sales_professional_manor), SUM(installation_clarity), 
		 SUM(installation_terms), SUM(installation_timely), SUM(installation_satisfaction) FROM tbltrainingdata"; 
		$result24 = mysql_query($query24) or die(mysql_error());	
		$row24 = mysql_fetch_array($result24);	
/*TRAINING MATH FOR OVERALL STATISTICS*/
		$totalman2 = $row24['SUM(manor)'];
		$totalkno2 = $row24['SUM(knowledge)'];
		$totalabi2 = $row24['SUM(ability)'];
		$totalres2 = $row24['SUM(respond)'];
		$totallen2 = $row24['SUM(length)'];

		$query28 = "SELECT ID FROM tbltrainingdata WHERE manor <> 0 AND manor <> 5"; 
		$result28 = mysql_query($query28) or die(mysql_error());
		$count28 = mysql_num_rows($result28);
		$query30 = "SELECT ID FROM tbltrainingdata WHERE knowledge <> 0 AND knowledge <> 5"; 
		$result30 = mysql_query($query30) or die(mysql_error());
		$count30 = mysql_num_rows($result30);
		$query31 = "SELECT ID FROM tbltrainingdata WHERE ability <> 0 AND ability <> 5"; 
		$result31 = mysql_query($query31) or die(mysql_error());
		$count31 = mysql_num_rows($result31);
		$query32 = "SELECT ID FROM tbltrainingdata WHERE respond <> 0 AND respond <> 5"; 
		$result32 = mysql_query($query32) or die(mysql_error());
		$count32 = mysql_num_rows($result32);	
		$query33 = "SELECT ID FROM tbltrainingdata WHERE length <> 0 AND length <> 5"; 
		$result33 = mysql_query($query33) or die(mysql_error());
		$count33 = mysql_num_rows($result33);		
	
		$avgman2a = ($totalman2 / $count28);
		$avgkno2a = ($totalkno2 / $count30);
		$avgabi2a = ($totalabi2 / $count31);
		$avgres2a = ($totalres2 / $count32);
		$avglen2a = ($totallen2 / $count33);
	
		$avgman2 = round($avgman2a,2);
		if($avgman2 < 3.50)
		{
			$avgman2font = '#ff0000';
		}else
		{
			$avgman2font = '#000000';
		}				
		$avgkno2 = round($avgkno2a,2);
		if($avgkno2 < 3.50)
		{
			$avgkno2font = '#ff0000';
		}else
		{
			$avgkno2font = '#000000';
		}		
		$avgabi2 = round($avgabi2a,2);
		if($avgabi2 < 3.50)
		{
			$avgabi2font = '#ff0000';
		}else
		{
			$avgabi2font = '#000000';
		}		
		$avgres2 = round($avgres2a,2);
		if($avgres2 < 3.50)
		{
			$avgres2font = '#ff0000';
		}else
		{
			$avgres2font = '#000000';
		}		
		$avglen2 = round($avglen2a,2);
		if($avglen2 < 3.50)
		{
			$avglen2font = '#ff0000';
		}else
		{
			$avglen2font = '#000000';
		}
/*SALES MATH FOR OVERALL STATISTICS*/
		$total_sales_knowledge2 = $row24['SUM(sales_knowledge)'];
		$total_sales_ease2 = $row24['SUM(sales_ease_of_info)'];
		$total_sales_useful2 = $row24['SUM(sales_useful_info)'];
		$total_sales_professional2 = $row24['SUM(sales_professional_manor)'];

		$query128 = "SELECT ID FROM tbltrainingdata WHERE sales_knowledge <> 0 AND sales_knowledge <> 5"; 
		$result128 = mysql_query($query128) or die(mysql_error());
		$count128 = mysql_num_rows($result128);
		$query130 = "SELECT ID FROM tbltrainingdata WHERE sales_ease_of_info <> 0 AND sales_ease_of_info <> 5"; 
		$result130 = mysql_query($query130) or die(mysql_error());
		$count130 = mysql_num_rows($result130);
		$query131 = "SELECT ID FROM tbltrainingdata WHERE sales_useful_info <> 0 AND sales_useful_info <> 5"; 
		$result131 = mysql_query($query131) or die(mysql_error());
		$count131 = mysql_num_rows($result131);
		$query132 = "SELECT ID FROM tbltrainingdata WHERE sales_professional_manor <> 0 AND sales_professional_manor <> 5"; 
		$result132 = mysql_query($query132) or die(mysql_error());
		$count132 = mysql_num_rows($result132);			
	
		$avg_sales_knowledge2a = ($total_sales_knowledge2 / $count128);
		$avg_sales_ease2a = ($total_sales_ease2 / $count130);
		$avg_sales_useful2a = ($total_sales_useful2 / $count131);
		$avg_sales_professional2a = ($total_sales_professional2 / $count132);
	
		$avg_sales_knowledge2 = round($avg_sales_knowledge2a,2);
		if($avg_sales_knowledge2 < 3.50)
		{
			$avg_sales_knowledge2font = '#ff0000';
		}else
		{
			$avg_sales_knowledge2font = '#000000';
		}				
		$avg_sales_ease2 = round($avg_sales_ease2a,2);
		if($avg_sales_ease2 < 3.50)
		{
			$avg_sales_ease2font = '#ff0000';
		}else
		{
			$avg_sales_ease2font = '#000000';
		}		
		$avg_sales_useful2 = round($avg_sales_useful2a,2);
		if($avg_sales_useful2 < 3.50)
		{
			$avg_sales_useful2font = '#ff0000';
		}else
		{
			$avg_sales_useful2font = '#000000';
		}		
		$avg_sales_professional2 = round($avg_sales_professional2a,2);
		if($avg_sales_professional2 < 3.50)
		{
			$avg_sales_professional2font = '#ff0000';
		}else
		{
			$avg_sales_professional2font = '#000000';
		}				
/*ISNTALLATION MATH FOR OVERALL STATISTICS*/
		$total_installation_clarity2 = $row24['SUM(installation_clarity)'];
		$total_installation_terms2 = $row24['SUM(installation_terms)'];
		$total_installation_timely2 = $row24['SUM(installation_timely)'];
		$total_installation_satisfaction2 = $row24['SUM(installation_satisfaction)'];

		$query228 = "SELECT ID FROM tbltrainingdata WHERE installation_clarity <> 0 AND installation_clarity <> 5"; 
		$result228 = mysql_query($query228) or die(mysql_error());
		$count228 = mysql_num_rows($result228);
		$query230 = "SELECT ID FROM tbltrainingdata WHERE installation_terms <> 0 AND installation_terms <> 5"; 
		$result230 = mysql_query($query230) or die(mysql_error());
		$count230 = mysql_num_rows($result230);
		$query231 = "SELECT ID FROM tbltrainingdata WHERE installation_timely <> 0 AND installation_timely <> 5"; 
		$result231 = mysql_query($query231) or die(mysql_error());
		$count231 = mysql_num_rows($result231);
		$query232 = "SELECT ID FROM tbltrainingdata WHERE installation_satisfaction <> 0 AND installation_satisfaction <> 5"; 
		$result232 = mysql_query($query232) or die(mysql_error());
		$count232 = mysql_num_rows($result232);			
	
		$avg_installation_clarity2a = ($total_installation_clarity2 / $count228);
		$avg_installation_terms2a = ($total_installation_terms2 / $count230);
		$avg_installation_timely2a = ($total_installation_timely2 / $count231);
		$avg_installation_satisfaction2a = ($total_installation_satisfaction2 / $count232);
	
		$avg_installation_clarity2 = round($avg_installation_clarity2a,2);
		if($avg_installation_clarity2 < 3.50)
		{
			$avg_installation_clarity2font = '#ff0000';
		}else
		{
			$avg_installation_clarity2font = '#000000';
		}				
		$avg_installation_terms2 = round($avg_installation_terms2a,2);
		if($avg_installation_terms2 < 3.50)
		{
			$avg_installation_terms2font = '#ff0000';
		}else
		{
			$avg_installation_terms2font = '#000000';
		}		
		$avg_installation_timely2 = round($avg_installation_timely2a,2);
		if($avg_installation_timely2 < 3.50)
		{
			$avg_installation_timely2font = '#ff0000';
		}else
		{
			$avg_installation_timely2font = '#000000';
		}		
		$avg_installation_satisfaction2 = round($avg_installation_satisfaction2a,2);
		if($avg_installation_satisfaction2 < 3.50)
		{
			$avg_installation_satisfaction2font = '#ff0000';
		}else
		{
			$avg_installation_satisfaction2font = '#000000';
		}		
?>
		<FIELDSET>
			<table width = "750" align = "center" border = "0">
				<tr>
					<td colspan = "10" align = "center"><font face="Arial" size="3"><b>
						Overall Statistics
					</b></td>
				</tr>
				<tr>
					<td colspan = "10" align = "center"><font face="Arial" size="2"><b>
						<?php echo 'Surveys Submitted:'.$count60; ?>
					</b></td>
				</tr>				
				<tr>
					<td valign = "bottom" align = "center"><font face="Arial" size="1">
					</td>
       		<td valign = "bottom" align = "center"><font face="Arial" size="1">
       			Product knowledge
       		</td>
   	    	<td valign = "bottom" align = "center"><font face="Arial" size="1">
   	    		Availability
   	    	</td>
     	  	<td valign = "bottom" align = "center"><font face="Arial" size="1">
     	  		Brochures
     	  	</td>
        	<td valign = "bottom" align = "center"><font face="Arial" size="1">
        		Professional Manor
        	</td>
 	      	<td valign = "bottom" align = "center"><font face="Arial" size="1">
 	      	</td>
 	      </tr>
				<tr>
					<td align = "center"><font face="Arial" size="2">
						Sales
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_knowledge2font; ?>">
						<?php echo $avg_sales_knowledge2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_ease2font; ?>">
						<?php echo $avg_sales_ease2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_useful2font; ?>">
						<?php echo $avg_sales_useful2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_installation_satisfaction2font; ?>">
						<?php echo $avg_installation_satisfaction2; ?>
					</td>
					<td align = "center">
					</td>
				</tr>		
 	      <tr>
 	      	<td colspan = 10 valign = "top">
 	      		<div align="center"><hr width="100%"></div>
 	      	</td>
				</tr>	
				<tr>
					<td valign = "bottom" align = "center"><font face="Arial" size="1">
					</td>
       		<td valign = "bottom" align = "center"><font face="Arial" size="1">
       			Clear Information
       		</td>
   	    	<td valign = "bottom" align = "center"><font face="Arial" size="1">
   	    		Terms of Equipment and Design
   	    	</td>
     	  	<td valign = "bottom" align = "center"><font face="Arial" size="1">
     	  		Timely Manner
     	  	</td>
        	<td valign = "bottom" align = "center"><font face="Arial" size="1">
        		Satisfaction
        	</td>
 	      	<td valign = "bottom" align = "center"><font face="Arial" size="1">
 	      	</td>
 	      </tr>
				<tr>
					<td align = "center"><font face="Arial" size="2">
						Installation
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_installation_clarity2font; ?>">
						<?php echo $avg_installation_clarity2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_installation_terms2font; ?>">
						<?php echo $avg_installation_terms2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_installation_timely2font; ?>">
						<?php echo $avg_installation_timely2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avg_sales_professional2font; ?>">
						<?php echo $avg_sales_professional2; ?>
					</td>
					<td align = "center">
					</td>
				</tr>		
 	      <tr>
 	      	<td colspan = 10 valign = "top">
 	      		<div align="center"><hr width="100%"></div>
 	      	</td>
				</tr>
				<tr>
					<td valign = "bottom" align = "center"><font face="Arial" size="1">
					</td>
       		<td valign = "bottom" align = "center"><font face="Arial" size="1">
       			Instructor Professional Manor
       		</td>
   	    	<td valign = "bottom" align = "center"><font face="Arial" size="1">
   	    		Instructor Knowledge
   	    	</td>
     	  	<td valign = "bottom" align = "center"><font face="Arial" size="1">
     	  		Clear Content
     	  	</td>
        	<td valign = "bottom" align = "center"><font face="Arial" size="1">
        		Instructor Question Response
        	</td>
 	      	<td valign = "bottom" align = "center"><font face="Arial" size="1">
 	      		Length of Training
 	      	</td>
 	      </tr>
				<tr>
					<td align = "center"><font face="Arial" size="2">
						Training
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avgman2font; ?>">
						<?php echo $avgman2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avgkno2font; ?>">
						<?php echo $avgkno2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avgabi2font; ?>">
						<?php echo $avgabi2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avgres2font; ?>">
						<?php echo $avgres2; ?>
					</td>
					<td align = "center"><font face="Arial" size="2" color="<?php echo $avglen2font; ?>">
						<?php echo $avglen2; ?>
					</td>
				</tr>								
			</table>
		</FIELDSET>						
<?php	
	}
}
/*
**************************************************************VIEW COMPLETED SURVEY**************************************************************
*/
if((isset($_GET['view'])) && ($_GET['view'] == "survey"))
{
	mysql_select_db($dbname2);
	$surveyid = $_GET['surveyid'];
	$query5 = "SELECT * FROM tbltrainingdata WHERE ID = '$surveyid'";
	$result5 = mysql_query($query5);
	$row5 = mysql_fetch_array($result5);
	$f_id = $row5['CustomerNumber'];
	mysql_select_db($dbname);
	$query6 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id'";
	$result6 = mysql_query($query6);
	$row6 = mysql_fetch_array($result6);
?>
	<table width = "750" align = "center" border = "0">
<?php
	if(!isset($_GET['print']))
	{
?>		
		<tr>
			<td>
				<?php echo '<a href=" ../sales/trainingeval.php?print=print&view=survey&surveyid='.$surveyid.'">'. 'Print View' .' </a>'; ?>
			</td>
			<td>
				<?php echo '<a href=" ../sales/trainingeval.php?view=home&f_id='.$f_id.'">'. 'Training Evaluation Center' .' </a>'; ?>
			</td>							
		</tr>
<?php
	}
?>			
			<tr>
				<td colspan = "2" align = "Center"><font face="Arial" size="4"><b>
				HomeFree Sales, Installation, and Training Evaluation Form<br></br>
				</b></td>
			</tr>
			<tr>
				<td colspan = "2"><b>
					As a customer of HomeFree your feedback is very important to the success of our operation.<br>
				Please take a few minutes to tell us about your total experience with HomeFree.<br></br>
				</b></td>
			<tr>
			<tr>
				<td width = "520">
					Customer Name: <?php echo $row5['name']; ?>
				</td>
				<td>
					Date: <?php echo $row5['date']; ?>
				</td>
			</tr>
			<tr>
				<td> 
					Customer Title: <?php echo $row5['title']; ?>
				</td>
				<td>
					Time Started: <?php echo $row5['timestarted']; ?>
				</td>
			</tr>
			<tr>
				<td>
					Facility Name: <?php echo $row6['FacilityName']; ?>
				</td>
				<td>
					Time Ended: <?php echo $row5['timeended']; ?>
				</td>
			</tr>
			<tr>
				<td>
					Facility Location: <?php echo $row6['City'].', '.$row6['StateOrProvinceCode']; ?>
				</td>
			</tr>
			<tr>
				<td>
					Presenter: <?php echo $row5['presenter']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<br>
				</td>
			</tr>
		</table>
				<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "2"><b>
					Sales:  Please evealuate each of the following aspects of the sales process by circling a number on the scale
					below.
				</b></td>
			</tr>
		</table>	
		<table width = "750" align = "center" border = "1">		
			<tr>
				<td width = "300" align="center">
				</td>
				<td width = "95" align="center">
					Excellent
				</td>
				<td width = "60" align="center">
					Good
				</td>
				<td width = "60" align="center">
					Fair
				</td>
				<td width = "60" align="center">
					Unsatisfactory
				</td>
				<td width = "170" align="center">
					Not Applicable
				</td>
			</tr>
			<tr>
				<td>
					Sales representative's product knowledge
				</td>
				<td align = "center">
<?php
				if($row5['sales_knowledge'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_knowledge'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_knowledge'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_knowledge'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>
				</td>
				<td align = "center">
<?php				
				if($row5['sales_knowledge'] == 0)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
			</tr>		
			</tr>			
			<tr>
				<td>
					Ease and promptness of getting information from the sales representative
				</td>
				<td align = "center">
<?php
				if($row5['sales_ease_of_info'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_ease_of_info'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_ease_of_info'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_ease_of_info'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>
				</td>
				<td align = "center">
<?php				
				if($row5['sales_ease_of_info'] == 0)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
			</tr>		
			<tr>
				<td>
					Usefulness of sales information and brochures
				</td>
				<td align = "center">
<?php
				if($row5['sales_useful_info'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_useful_info'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_useful_info'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_useful_info'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>
				</td>
				<td align = "center">
<?php				
				if($row5['sales_useful_info'] == 0)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>		
			</tr>	
			<tr>
				<td>
					Sales representatives's professional manor
				</td>
				<td align = "center">
<?php
				if($row5['sales_professional_manor'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_professional_manor'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_professional_manor'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['sales_professional_manor'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>
				</td>
				<td align = "center">
<?php				
				if($row5['sales_professional_manor'] == 0)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>	
			</tr>	
		</table>		
		<table width = "750" align = "center" border = "0">
			<tr>
				<td>
					Any other comments about the sales process:
				</td>
			</tr>
			<tr>
				<td colspan = "9"><b>
					<ul><?php echo nl2br($row5['sales_comments']);?></ul>
				</b></td>
			</tr>
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "2"><b>
					Installation Process:  Please evealuate each of the following aspects of the installation process by circling a 
					number on the scale below.
				</b></td>
			</tr>
		</table>	
		<table width = "750" align = "center" border = "1">		
			<tr>
				<td width = "300" align="center">
				</td>
				<td width = "95" align="center">
					Excellent
				</td>
				<td width = "60" align="center">
					Good
				</td>
				<td width = "60" align="center">
					Fair
				</td>
				<td width = "60" align="center">
					Unsatisfactory
				</td>
				<td width = "170" align="center">
					Not Applicable
				</td>
			</tr>
			<tr>
				<td>
					Given clear, concise information about your installation
				</td>
				<td align = "center">
<?php
				if($row5['installation_clarity'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_clarity'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_clarity'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_clarity'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>
				</td>
				<td align = "center">
<?php				
				if($row5['installation_clarity'] == 0)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>				
			</tr>			
			<tr>
				<td>
					Received what was described in terms of equipment and design
				</td>
				<td align = "center">
<?php
				if($row5['installation_terms'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_terms'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_terms'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_terms'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>
				</td>
				<td align = "center">
<?php				
				if($row5['installation_terms'] == 0)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>	
			</tr>		
			<tr>
				<td>
					System nistalled in a timely fashion
				</td>				
				<td align = "center">
<?php
				if($row5['installation_timely'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_timely'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_timely'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_timely'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>
				</td>
				<td align = "center">
<?php				
				if($row5['installation_timely'] == 0)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>		
			</tr>	
			<tr>
				<td>
					Satisfaction with the final installation
				</td>				
				<td align = "center">
<?php
				if($row5['installation_satisfaction'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_satisfaction'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_satisfaction'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['installation_satisfaction'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>
				</td>
				<td align = "center">
<?php				
				if($row5['installation_satisfaction'] == 0)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>		
			</tr>	
		</table>		
		<table width = "750" align = "center" border = "0">
			<tr>
				<td>
					Any other comments about the system installation:
				</td>
			</tr>
			<tr>
				<td colspan = "9"><b>
					<ul><?php echo nl2br($row5['installation_comments']);?></ul>
				</b></td>
			</tr>
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "2">
					Please evaluate each of the following aspects of the in-service program by circling a number on the scale below.
				</td>
			</tr>
		</table>
		<table width = "750" align = "center" border = "1">
			<tr>
				<td width = "300" align="center">
				</td>
				<td width = "95" align="center">
					Excellent
				</td>
				<td width = "60" align="center">
					Good
				</td>
				<td width = "60" align="center">
					Fair
				</td>
				<td width = "60" align="center">
					Unsatisfactory
				</td>
				<td>
				</td>
			</tr>	
			<tr>
				<td>
					Length of training sessions
				</td>
				<td align = "center">
<?php
				if($row5['length'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['length'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['length'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['length'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
			</tr>							
			<tr>
				<td>
					Instructor professional manor and courtesy
				</td>
				<td align = "center">
<?php
				if($row5['manor'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['manor'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['manor'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['manor'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
				</td>
			</tr>		
			<tr>
				<td>
					Instructor’s knowledge
				</td>
				<td align = "center">
<?php
				if($row5['knowledge'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>		
				</td>
				<td align = "center">
<?php
				if($row5['knowledge'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['knowledge'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['knowledge'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
				</td>		
			</tr>	
			<tr>
				<td>
					Instructor’s ability to explain content clearly
				</td>
				<td align = "center">
<?php
				if($row5['ability'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['ability'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['ability'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['ability'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
				</td>		
			</tr>	
			<tr>
				<td>
					Instructor’s ability to respond well to questions
				</td>
				<td align = "center">
<?php
				if($row5['respond'] == 4)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>		
				</td>
				<td align = "center">
<?php
				if($row5['respond'] == 3)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['respond'] == 2)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
<?php
				if($row5['respond'] == 1)
				{
?>					
					<img src="../images/check4.jpg" border="0" width="15" height="15" alt="CHECK">
<?php					
				}else
				{
				echo '-'; 
				}
?>	
				</td>
				<td align = "center">
				</td>	
			</tr>
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td colspan = "9">
					Please comment on the overall training session and provide any comments that would help HomeFree improve our
					training effors:
				</td>
			</tr>
			<tr>
				<td colspan = "9"><b>
					<ul><?php echo nl2br($row5['overall']);?></ul>
				</b></td>
			</tr>
		</table>
		<table width = "750" align = "center" border = "0">
			<tr>
				<td>
					<br>
				</td>
			</tr>
			<tr>
				<td colspan = "3">
					Do you feel that you need additional training? 
<?php
					if($row5['additional'] == 0)				
					{
						echo '<b>'.'NO'.'</b>';
					}elseif($row5['additional'] == 1)
					{
						echo '<b>'.'YES'.'</b>';
					}else
					{
						echo '<b>'.'No Response'.'</b>';
					}
?>						
				</td>
			</tr>
			<tr>
				<td><b>
					<ul><?php echo nl2br($row5['additionalexp']);?></ul>
				</b></td>
			</tr>
			<tr>
				<td colspan = "3">
					Would you recommend HomeFree to other customers?
<?php
					if($row5['reference'] == 0)				
					{
						echo '<b>'.'NO'.'</b>';
					}elseif($row5['reference'] == 1)
					{
						echo '<b>'.'YES'.'</b>';
					}else
					{
						echo '<b>'.'No Response'.'</b>';
					}
?>						
				</td>
			</tr>
			<tr>
				<td><b>
					<ul><?php echo nl2br($row5['referenceexp']);?></ul>
				</b></td>	
			<tr>				
			<tr>
				<td>
					<br>
					<br>
					<br>
				</td>
			</tr>
			<tr>
				<td align = "center" colspan = "3">
					Thank you so much for your frank contributions.<br>
					Your feedback will help us improve our efforts in order to serve you better.<br>
					Please do not hesitate to contact us with any additional comments.
				</td>
			</tr>
			<tr>
				<td>
					<br>
				</td>
			</tr>
		</table>
		<table width = "415" align = "center" border = "0">
			<tr>
				<td>
					<table width = "150" align = "left" border = "0">
						<tr>
							<td>
								<table width = "250" align = "left" border = "0">
									<tr>
										<td><b>
											Mary Petersen
										</b></td>
									</tr>
									<tr>
										<td>
											Customer Trainer
										</td>
									</tr>
									<tr>
										<td>
											maryp@homefreesys.com
										</td>
									</tr>
									<tr>
										<td>
											Toll Free….800.606.0661
										</td>
									</tr>
									<tr>
										<td>
											Local…414.358.8200
										</td>
									</tr>
									<tr>
										<td>
											Fax….414.358.8100
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width = "50" align = "left" border = "0">
						<tr>
							<td>
								<table width = "250" align = "right" border = "0">
									<tr>
										<td><b>
											Andrew Cohen
										</b></td>
									</tr>
									<tr>
										<td>				
											Customer Service Manager
										</td>
									</tr>
									<tr>
										<td>
											andrewc@homefreesys.com
										</td>
									</tr>
									<tr>
										<td>
											Toll Free….800.606.0661
										</td>
									</tr>
									<tr>
										<td>
											Local…414.358.8200
										</td>
									</tr>
									<tr>
										<td>
											Fax….414.358.8100
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="f_id" value = "'.$f_id.'">';
?>						
		</table>
<?php
}
/*
**************************************************************SEARCH PAGE**************************************************************
*/
if((isset($_GET['view'])) && ($_GET['view'] == "search"))
{
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table align ="center" width = "750">
			<tr>
				<td>
					Facility Name:
				</td>
				<td>
					<input type="text" size="40" maxlength="60" name="Fname">
				</td>
				<td>
					<input type="submit" value="Search" name="search">
				</td>
			</tr>
		</table>
<?php
		echo	'<input type = "hidden" name="view" value = "search">';		
?>		
	</form>
<?php
	if(isset($_GET["Fname"]))
	{
		$f_name=addslashes($_GET["Fname"]);
		mysql_select_db($dbname);
		$query6 = "SELECT * FROM tblfacilities WHERE FacilityName LIKE '%$f_name%' ORDER BY FacilityName";
		$result6 = mysql_query($query6) or die (mysql_error());
		if(mysql_num_rows($result6) > 0)
		{
			while($row6 = mysql_fetch_array($result6))
			{
?>
				<table width = "750">
					<tr>
						<td><font face="Arial" size="2">
<?php
							echo '<a href="../sales/trainingeval.php?view=home&f_id='. $row6['CustomerNumber'].'">'. $row6['FacilityName'] .'</a>';
?>
						</td>
					</tr>
				</table>
<?php					
			}
		}else
		{
?>
				<table width = "750">
					<tr>
						<td><font face="Arial" size="2">
<?php
							echo 'No Records Found';
?>
						</td>
					</tr>
				</table>
<?php					
		}
	}		
}
/*
**************************************************************SELECT FACILITIES FOR GRAPH***********************************************************
*/
if((isset($_GET['view'])) && ($_GET['view'] == "compare"))
{

	if(isset($_GET['f_id']))
	{
		$f_id = $_GET['f_id'];
	}
	mysql_select_db($dbname2);
	$query7 = "SELECT CustomerNumber FROM tbltrainingdata GROUP BY CustomerNumber";
	$result7 = mysql_query($query7) or die (mysql_error());
	$query9 = "SELECT CustomerNumber FROM tbltrainingdata GROUP BY CustomerNumber";
	$result9 = mysql_query($query9) or die (mysql_error());
	$query11 = "SELECT CustomerNumber FROM tbltrainingdata GROUP BY CustomerNumber";
	$result11 = mysql_query($query11) or die (mysql_error());
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table align="center" width = "750">
		<tr>
			<td colspan = "2"><font face = "Arial" size = "2">
				Please choose 3 facilities to compare their training evaluation results:
			</td>
		</tr>
		<tr>
			<td width = "80">
				Customer 1:
			</td>
			<td><font face = "Arial" size = "2"><select name="cus1">				
<?php
			if(isset($_GET['f_id']))
			{
				mysql_select_db($dbname);
				$query61 = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE CustomerNumber = '$f_id'";
				$result61 = mysql_query($query61) or die (mysql_error());
				$row61 = mysql_fetch_array($result61);
?>					
					<option value="<?php echo $row61['CustomerNumber']; ?>">  <?php echo $row61['FacilityName']; ?> </option>
<?php	
			}else
			{	
?>
				<option value="-1">Please Select Facility </option>
<?php			
			}		
			while($row7 = mysql_fetch_array($result7))
			{
				$customernumber1 = $row7['CustomerNumber'];
				mysql_select_db($dbname);
				$query8 = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE CustomerNumber = '$customernumber1'";
				$result8 = mysql_query($query8) or die (mysql_error());
				$row8 = mysql_fetch_array($result8);			
?>
				 <option value="<?php echo $row8['CustomerNumber']; ?>">  <?php echo $row8['FacilityName']; ?> </option>
<?php	
			}
?>
			</td>
		</tr>
		<tr>
			<td>
				Customer 2:
			</td>
			<td><font face = "Arial" size = "2"><select name="cus2">
			<option value="-1">Please Select Facility </option>
<?php					
			while($row9 = mysql_fetch_array($result9))
			{
				$customernumber2 = $row9['CustomerNumber'];
				mysql_select_db($dbname);
				$query10 = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE CustomerNumber = '$customernumber2'";
				$result10 = mysql_query($query10) or die (mysql_error());
				$row10 = mysql_fetch_array($result10)
?>
				<option value="<?php echo $row10['CustomerNumber']; ?>">  <?php echo $row10['FacilityName']; ?> </option>
<?php	
			}
?>
			</td>
		</tr>		
		<tr>
			<td>
				Customer 3:
			</td>
			<td><font face = "Arial" size = "2"><select name="cus3">
				<option value="-1">Please Select Facility </option>
<?php					
			while($row11 = mysql_fetch_array($result11))
			{
				$customernumber3 = $row11['CustomerNumber'];
				mysql_select_db($dbname);
				$query12 = "SELECT CustomerNumber,FacilityName FROM tblfacilities WHERE CustomerNumber = '$customernumber3'";
				$result12 = mysql_query($query12) or die (mysql_error());
				$row12 = mysql_fetch_array($result12)
?>
				<option value="<?php echo $row12['CustomerNumber']; ?>">  <?php echo $row12['FacilityName']; ?> </option>
<?php	
			}
?>
			</td>
		</tr>			
		<tr>
			<td>
				<input type="submit" value="Continue" name="cont">
			</td>
<?php
			if(isset($_GET['f_id']))
			{
				$f_id = $_GET['f_id'];
?>		
				<td align = "center">
				<?php echo '<a href=" ../sales/trainingeval.php?view=home&f_id='.$f_id.'">'. 'Training Evalution Center' .' </a>'; ?>
				</td>	
<?php
			}else
			{
?>							
			<td align = "center">
				<?php echo '<a href=" trainingeval.php?view=home">'. 'Training Evalution Center' .' </a>'; ?>
			</td>
<?php
			}
?>						
		</tr>
	</table>
	</form>
<?php			
}
if((isset($_GET['cont'])) && ($_GET['cont'] == "Continue"))
{
	mysql_select_db($dbname2);
	$truncate = "TRUNCATE TABLE tblgraphdata";
	mysql_query($truncate) or die(mysql_error());
/*
**************************************************************CUSTOMER 1**************************************************************
*/
	$cus1 = $_GET['cus1'];	
	if($cus1 <> -1)
	{	
		$query13 = "SELECT SUM(manor), SUM(knowledge), SUM(ability), SUM(respond),
								SUM(length) FROM tbltrainingdata WHERE CustomerNumber='$cus1'"; 
		$result13 = mysql_query($query13) or die(mysql_error());	
		$row13 = mysql_fetch_array($result13);	
	
		$totalman1 = $row13['SUM(manor)'];
		$totalkno1 = $row13['SUM(knowledge)'];
		$totalabi1 = $row13['SUM(ability)'];
		$totalres1 = $row13['SUM(respond)'];
		$totallen1 = $row13['SUM(length)'];

		$query17 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus1' AND manor <> 0"; 
		$result17 = mysql_query($query17) or die(mysql_error());
		$count17 = mysql_num_rows($result17);
		$query19 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus1' AND knowledge <> 0"; 
		$result19 = mysql_query($query19) or die(mysql_error());
		$count19 = mysql_num_rows($result19);
		$query20 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus1' AND ability <> 0"; 
		$result20 = mysql_query($query20) or die(mysql_error());
		$count20 = mysql_num_rows($result20);
		$query21 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus1' AND respond <> 0"; 
		$result21 = mysql_query($query21) or die(mysql_error());
		$count21 = mysql_num_rows($result21);	
		$query22 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus1' AND length <> 0"; 
		$result22 = mysql_query($query22) or die(mysql_error());
		$count22 = mysql_num_rows($result22);		
	
		$avgman1a = ($totalman1 / $count17);
		$avgkno1a = ($totalkno1 / $count19);
		$avgabi1a = ($totalabi1 / $count20);
		$avgres1a = ($totalres1 / $count21);
		$avglen1a = ($totallen1 / $count22);
	
		$avgman1 = round($avgman1a,2);
		$avgkno1 = round($avgkno1a,2);
		$avgabi1 = round($avgabi1a,2);
		$avgres1 = round($avgres1a,2);
		$avglen1 = round($avglen1a,2);
	}else
	{
		$avgman1 = 0;
		$avgkno1 = 0;
		$avgabi1 = 0;
		$avgres1 = 0;
		$avglen1 = 0;
	}
		$query23 = "INSERT INTO tblgraphdata (ID,CustomerNumber,manor,knowledge,ability,respond,length) 
								VALUES (1,'$cus1','$avgman1','$avgkno1','$avgabi1','$avgres1','$avglen1')";
		mysql_query($query23) or die(mysql_error());	

/*
**************************************************************CUSTOMER 2**************************************************************
*/		

	$cus2 = $_GET['cus2'];
	if($cus2 <> -1)
	{
		$query24 = "SELECT SUM(manor), SUM(knowledge), SUM(ability), SUM(respond),
								SUM(length) FROM tbltrainingdata WHERE CustomerNumber='$cus2'"; 
		$result24 = mysql_query($query24) or die(mysql_error());	
		$row24 = mysql_fetch_array($result24);	
	
		$totalman2 = $row24['SUM(manor)'];
		$totalkno2 = $row24['SUM(knowledge)'];
		$totalabi2 = $row24['SUM(ability)'];
		$totalres2 = $row24['SUM(respond)'];
		$totallen2 = $row24['SUM(length)'];

		$query28 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus2' AND manor <> 0"; 
		$result28 = mysql_query($query28) or die(mysql_error());
		$count28 = mysql_num_rows($result28);
		$query30 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus2' AND knowledge <> 0"; 
		$result30 = mysql_query($query30) or die(mysql_error());
		$count30 = mysql_num_rows($result30);
		$query31 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus2' AND ability <> 0"; 
		$result31 = mysql_query($query31) or die(mysql_error());
		$count31 = mysql_num_rows($result31);
		$query32 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus2' AND respond <> 0"; 
		$result32 = mysql_query($query32) or die(mysql_error());
		$count32 = mysql_num_rows($result32);	
		$query33 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus2' AND length <> 0"; 
		$result33 = mysql_query($query33) or die(mysql_error());
		$count33 = mysql_num_rows($result33);		
	
		$avgman2a = ($totalman2 / $count28);
		$avgkno2a = ($totalkno2 / $count30);
		$avgabi2a = ($totalabi2 / $count31);
		$avgres2a = ($totalres2 / $count32);
		$avglen2a = ($totallen2 / $count33);
	
		$avgman2 = round($avgman2a,2);
		$avgkno2 = round($avgkno2a,2);
		$avgabi2 = round($avgabi2a,2);
		$avgres2 = round($avgres2a,2);
		$avglen2 = round($avglen2a,2);
	}else	
	{
		$avgman2 = 0;
		$avgkno2 = 0;
		$avgabi2 = 0;
		$avgres2 = 0;
		$avglen2 = 0;
	}
	$query34 = "INSERT INTO tblgraphdata (ID,CustomerNumber,manor,knowledge,ability,respond,length) 
							VALUES (2,'$cus2','$avgman2','$avgkno2','$avgabi2','$avgres2','$avglen2')";
	mysql_query($query34) or die(mysql_error());	
/*
**************************************************************CUSTOMER 3**************************************************************
*/			
	$cus3 = $_GET['cus3'];
	if($cus3 <> -1)
	{
		$query35 = "SELECT SUM(manor), SUM(knowledge), SUM(ability), SUM(respond),
								SUM(length) FROM tbltrainingdata WHERE CustomerNumber='$cus3'"; 
		$result35 = mysql_query($query35) or die(mysql_error());	
		$row35 = mysql_fetch_array($result35);	
	
		$totalman3 = $row35['SUM(manor)'];
		$totalkno3 = $row35['SUM(knowledge)'];
		$totalabi3 = $row35['SUM(ability)'];
		$totalres3 = $row35['SUM(respond)'];
		$totallen3 = $row35['SUM(length)'];

		$query39 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus3' AND manor <> 0"; 
		$result39 = mysql_query($query39) or die(mysql_error());
		$count39 = mysql_num_rows($result39);
		$query41 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus3' AND knowledge <> 0"; 
		$result41 = mysql_query($query41) or die(mysql_error());
		$count41 = mysql_num_rows($result41);
		$query42 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus3' AND ability <> 0"; 
		$result42 = mysql_query($query42) or die(mysql_error());
		$count42 = mysql_num_rows($result42);
		$query43 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus3' AND respond <> 0"; 
		$result43 = mysql_query($query43) or die(mysql_error());
		$count43 = mysql_num_rows($result43);	
		$query44 = "SELECT ID FROM tbltrainingdata WHERE CustomerNumber='$cus3' AND length <> 0"; 
		$result44 = mysql_query($query44) or die(mysql_error());
		$count44 = mysql_num_rows($result44);		
	
		$avgman3a = ($totalman3 / $count39);
		$avgkno3a = ($totalkno3 / $count41);
		$avgabi3a = ($totalabi3 / $count42);
		$avgres3a = ($totalres3 / $count43);
		$avglen3a = ($totallen3 / $count44);
	
		$avgman3 = round($avgman3a,2);
		$avgkno3 = round($avgkno3a,2);
		$avgabi3 = round($avgabi3a,2);
		$avgres3 = round($avgres3a,2);
		$avglen3 = round($avglen3a,2);
	}else
	{
		$avgman3 = 0;
		$avgkno3 = 0;
		$avgabi3 = 0;
		$avgres3 = 0;
		$avglen3 = 0;
	}
	$query45 = "INSERT INTO tblgraphdata (ID,CustomerNumber,manor,knowledge,ability,respond,length) 
							VALUES (3,'$cus3','$avgman3','$avgkno3','$avgabi3','$avgres3','$avglen3')";
	mysql_query($query45) or die(mysql_error());
/*
**************************************************************TOTAL RESULTS**************************************************************
*/
	$query46 = "SELECT SUM(manor), SUM(knowledge), SUM(ability), SUM(respond),
							SUM(length) FROM tbltrainingdata"; 
	$result46 = mysql_query($query46) or die(mysql_error());	
	$row46 = mysql_fetch_array($result46);	
	
	$totalman4 = $row46['SUM(manor)'];
	$totalkno4 = $row46['SUM(knowledge)'];
	$totalabi4 = $row46['SUM(ability)'];
	$totalres4 = $row46['SUM(respond)'];
	$totallen4 = $row46['SUM(length)'];

	$query50 = "SELECT ID FROM tbltrainingdata WHERE manor <> 0"; 
	$result50 = mysql_query($query50) or die(mysql_error());
	$count50 = mysql_num_rows($result50);
	$query52 = "SELECT ID FROM tbltrainingdata WHERE knowledge <> 0"; 
	$result52 = mysql_query($query52) or die(mysql_error());
	$count52 = mysql_num_rows($result52);
	$query53 = "SELECT ID FROM tbltrainingdata WHERE ability <> 0"; 
	$result53 = mysql_query($query53) or die(mysql_error());
	$count53 = mysql_num_rows($result53);
	$query54 = "SELECT ID FROM tbltrainingdata WHERE respond <> 0"; 
	$result54 = mysql_query($query54) or die(mysql_error());
	$count54 = mysql_num_rows($result54);	
	$query55 = "SELECT ID FROM tbltrainingdata WHERE length <> 0"; 
	$result55 = mysql_query($query55) or die(mysql_error());
	$count55 = mysql_num_rows($result55);		
	
	$avgman4a = ($totalman4 / $count50);
	$avgkno4a = ($totalkno4 / $count52);
	$avgabi4a = ($totalabi4 / $count53);
	$avgres4a = ($totalres4 / $count54);
	$avglen4a = ($totallen4 / $count55);
	
	$avgman4 = round($avgman4a,2);
	$avgkno4 = round($avgkno4a,2);
	$avgabi4 = round($avgabi4a,2);
	$avgres4 = round($avgres4a,2);
	$avglen4 = round($avglen4a,2);
	
	$query56 = "INSERT INTO tblgraphdata (ID,CustomerNumber,manor,knowledge,ability,respond,length) 
							VALUES (4,'999999','$avgman4','$avgkno4','$avgabi4','$avgres4','$avglen4')";
	mysql_query($query56) or die(mysql_error());	
	header("Location: trainingeval.php?graph=average&print=print1");
}
/*
**************************************************************ON SCREEN GRAPH**************************************************************
*/
if((isset($_GET['graph'])) && ($_GET['graph'] == "average"))
{
?>
		<table align="left" width = "850" border="0">
			<tr>
				<td>
	<HTML>					
	<BODY bgcolor="#FFFFFF">

	<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
	codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" 
	WIDTH="925" 
	HEIGHT="450" 
	id="charts" />
<PARAM NAME="movie" VALUE="charts.swf?library_path=charts_library&xml_source=averagegraph.php" />
<PARAM NAME="quality" VALUE="high" />
<PARAM NAME="bgcolor" VALUE="#ffffff" />
<param name="allowScriptAccess" value="sameDomain" />

<EMBED src="charts.swf?library_path=charts_library&xml_source=averagegraph.php"
       quality="high" 
       bgcolor="#ffffff" 
       WIDTH="925" 
       HEIGHT="450" 
       NAME="charts" 
       allowScriptAccess="sameDomain" 
       swLiveConnect="true" 
       TYPE="application/x-shockwave-flash" 
       PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
</EMBED>
</OBJECT>

</BODY>
</HTML>
</td>
</tr>
</table>	
<?php
	mysql_select_db($dbname2);
	$query1 = "SELECT * FROM tblgraphdata WHERE ID = 1";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_fetch_array($result1);	
	$f_id1 = $row1['CustomerNumber'];
	mysql_select_db($dbname);
	$query2 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id1'";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2);	
	mysql_select_db($dbname2);
	$query3 = "SELECT * FROM tblgraphdata WHERE ID = 2";
	$result3 = mysql_query($query3) or die (mysql_error());
	$row3 = mysql_fetch_array($result3);	
	$f_id2 = $row3['CustomerNumber'];
	mysql_select_db($dbname);
	$query4 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id2'";
	$result4 = mysql_query($query4) or die (mysql_error());
	$row4 = mysql_fetch_array($result4);	
	mysql_select_db($dbname2);
	$query5 = "SELECT * FROM tblgraphdata WHERE ID = 3";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_fetch_array($result5);	
	$f_id3 = $row5['CustomerNumber'];
	mysql_select_db($dbname);
	$query6 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id3'";
	$result6 = mysql_query($query6) or die (mysql_error());
	$row6 = mysql_fetch_array($result6);	
	mysql_select_db($dbname2);
	$query7 = "SELECT * FROM tblgraphdata WHERE ID = 4";
	$result7 = mysql_query($query7) or die (mysql_error());
	$row7 = mysql_fetch_array($result7);
?>
	<table align="left" width = "850" border="1">
<?php		
		if($f_id1 <> -1)
		{
?>			
			<tr>
				<td width="95"><font face = "Arial" size = "2">
					<?php echo $row2['FacilityName']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row1['manor']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row1['knowledge']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row1['ability']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row1['respond']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row1['length']; ?>
				</td>
			</tr>
<?php
		}
		if($f_id2 <> -1)
		{
?>				
			<tr>
				<td width="95"><font face = "Arial" size = "2">
					<?php echo $row4['FacilityName']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row3['manor']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row3['knowledge']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row3['ability']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row3['respond']; ?>
				</td>
				<td width="80" align = "center"><font face = "Arial" size = "2">
					<?php echo $row3['length']; ?>
				</td>
			</tr>	
<?php
		}
		if($f_id3 <> -1)
		{
?>									
			<tr>
				<td width="95"><font face = "Arial" size = "2">
					<?php echo $row6['FacilityName']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row5['manor']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row5['knowledge']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row5['ability']; ?>
				</td>
				<td width="81" align = "center"><font face = "Arial" size = "2">
					<?php echo $row5['respond']; ?>
				</td>
				<td width="80" align = "center"><font face = "Arial" size = "2">
					<?php echo $row5['length']; ?>
				</td>
			</tr>
<?php
		}
		?>					
		<tr>
			<td width="95"><font face = "Arial" size = "2">
				Overall Average
			</td>
			<td width="81" align = "center"><font face = "Arial" size = "2">
				<?php echo $row7['manor']; ?>
			</td>
			<td width="81" align = "center"><font face = "Arial" size = "2">
				<?php echo $row7['knowledge']; ?>
			</td>
			<td width="81" align = "center"><font face = "Arial" size = "2">
				<?php echo $row7['ability']; ?>
			</td>
			<td width="81" align = "center"><font face = "Arial" size = "2">
				<?php echo $row7['respond']; ?>
			</td>
			<td width="80" align = "center"><font face = "Arial" size = "2">
				<?php echo $row7['length']; ?>
			</td>
		</tr>	
	</table>
	<table align="left" width = "850" border="0">
		<tr>
			<td align = "center">
				<?php echo '<a href="'.'trainingeval.php?graph=avg&print=graphprint'.'">' . 'Print View'. '</a>'; ?>
			</td>
		</tr>	
	</table>		
<?php
}
/*
**************************************************************PRINTABLE GRAPH**************************************************************
*/
if((isset($_GET['print'])) && ($_GET['print'] == "graphprint"))
{
?>
		<table align="center" width = "750" border="0">
			<tr>
				<td>
	<HTML>					
	<BODY bgcolor="#FFFFFF">

	<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
	codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" 
	WIDTH="550" 
	HEIGHT="250" 
	id="charts" />
<PARAM NAME="movie" VALUE="charts.swf?library_path=charts_library&xml_source=printviewgraph.php" />
<PARAM NAME="quality" VALUE="high" />
<PARAM NAME="bgcolor" VALUE="#ffffff" />
<param name="allowScriptAccess" value="sameDomain" />

<EMBED src="charts.swf?library_path=charts_library&xml_source=printviewgraph.php"
       quality="high" 
       bgcolor="#ffffff" 
       WIDTH="550" 
       HEIGHT="250" 
       NAME="charts" 
       allowScriptAccess="sameDomain" 
       swLiveConnect="true" 
       TYPE="application/x-shockwave-flash" 
       PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
</EMBED>
</OBJECT>

</BODY>
</HTML>
<?php
	mysql_select_db($dbname2);
	$query1 = "SELECT * FROM tblgraphdata WHERE ID = 1";
	$result1 = mysql_query($query1) or die (mysql_error());
	$row1 = mysql_fetch_array($result1);	
	$f_id1 = $row1['CustomerNumber'];
	mysql_select_db($dbname);
	$query2 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id1'";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2);	
	mysql_select_db($dbname2);
	$query3 = "SELECT * FROM tblgraphdata WHERE ID = 2";
	$result3 = mysql_query($query3) or die (mysql_error());
	$row3 = mysql_fetch_array($result3);	
	$f_id2 = $row3['CustomerNumber'];
	mysql_select_db($dbname);
	$query4 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id2'";
	$result4 = mysql_query($query4) or die (mysql_error());
	$row4 = mysql_fetch_array($result4);	
	mysql_select_db($dbname2);
	$query5 = "SELECT * FROM tblgraphdata WHERE ID = 3";
	$result5 = mysql_query($query5) or die (mysql_error());
	$row5 = mysql_fetch_array($result5);	
	$f_id3 = $row5['CustomerNumber'];
	mysql_select_db($dbname);
	$query6 = "SELECT * FROM tblfacilities WHERE CustomerNumber = '$f_id3'";
	$result6 = mysql_query($query6) or die (mysql_error());
	$row6 = mysql_fetch_array($result6);	
	mysql_select_db($dbname2);
	$query7 = "SELECT * FROM tblgraphdata WHERE ID = 4";
	$result7 = mysql_query($query7) or die (mysql_error());
	$row7 = mysql_fetch_array($result7);
?>
	<table align="center" width = "700" border="1">
<?php		
		if($f_id1 <> -1)
		{
?>			
			<tr>
				<td width="115"><font face = "Arial" size = "1">
					<?php echo $row2['FacilityName']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row1['manor']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row1['knowledge']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row1['ability']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row1['respond']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row1['length']; ?>
				</td>
				<td width="380">
				</td>				
			</tr>
<?php
		}
		if($f_id2 <> -1)
		{
?>				
			<tr>
				<td width="115"><font face = "Arial" size = "1">
					<?php echo $row4['FacilityName']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row3['manor']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row3['knowledge']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row3['ability']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row3['respond']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row3['length']; ?>
				</td>
				<td width="380">
				</td>
			</tr>	
<?php
		}
		if($f_id3 <> -1)
		{
?>									
			<tr>
				<td width="115"><font face = "Arial" size = "1">
					<?php echo $row6['FacilityName']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row5['manor']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row5['knowledge']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row5['ability']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row5['respond']; ?>
				</td>
				<td width="70" align = "center"><font face = "Arial" size = "1">
					<?php echo $row5['length']; ?>
				</td>
				<td width="380">
				</td>
			</tr>
<?php
		}
		?>					
		<tr>
			<td width="115"><font face = "Arial" size = "1">
				Overall Average
			</td>
			<td width="70" align = "center"><font face = "Arial" size = "1">
				<?php echo $row7['manor']; ?>
			</td>
			<td width="70" align = "center"><font face = "Arial" size = "1">
				<?php echo $row7['knowledge']; ?>
			</td>
			<td width="70" align = "center"><font face = "Arial" size = "1">
				<?php echo $row7['ability']; ?>
			</td>
			<td width="70" align = "center"><font face = "Arial" size = "1">
				<?php echo $row7['respond']; ?>
			</td>
			<td width="70" align = "center"><font face = "Arial" size = "1">
				<?php echo $row7['length']; ?>
			</td>
			<td width="380">
			</td>
		</tr>	
	</table>
<?php
}
?>