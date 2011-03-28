<?php
if(!isset($_GET['print']))
{
	include 'header.php';
}else
{
	include 'printheader.php';
}
?>
<link rel="stylesheet" type="text/css" href="task.css" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>HomeFree Task Management</title>
<?php
if(!isset($_SESSION['username']))
{
	$user = "Unknown";
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$statement = 'Page Accessed: '.$_SERVER['PHP_SELF'].';Remote IP: '.$_SERVER['REMOTE_ADDR'].';No session detected. Redirected to login page.';
	$queryLog = "INSERT INTO activity_logs (user, statement, agent, date, time) VALUES ('$user', '$statement', '$agent', CURDATE(), CURTIME())";
	mysql_query($queryLog);
	die(header("Location: csPortal_Login.php"));
}else
{
	$name = $_SESSION['displayname'];
	$message="Hello $name!";
	if($_SESSION['access'] < 5)
	{
		die("You are not authorized.<br>Your activity has been logged");
	}
}
$access = $_SESSION['access'];
$conn11 = mysql_connect('hf01sql', 'ups_track', '7ZLXRn9.xZfRCuXV') or die(mysql_error());
mysql_select_db($dbname);
$uid = $_SESSION['uid'];
$email = $_SESSION['mail'];
$query1 = "SELECT id, f_name, l_name, dept FROM employees WHERE email = '$email'";
$result1 = mysql_query($query1) or die (mysql_error());
$row1 = mysql_fetch_array($result1);
$employeeid = $row1['id'];      
$firstname = $row1['f_name'];
$lastname = $row1['l_name'];
$department = $row1['dept'];
mysql_close($conn11);	
$date = date('Y-m-d H:i:s');
$displaydate = date('m-d-Y');
$now = strtotime("now");
$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$tomorrowplus  = mktime (date("H"), date("i")+15, 0, date("m")  , date("d")+1, date("Y"));
$status = 0;
include '../includes/config.inc.php';
include '../includes/db_connect.inc.php';
require 'includes/functions.inc.php';
if((isset($_GET['view'])) && ($_GET['view'] == 'summary'))
{
	mysql_select_db($dbname2);
	$query3 = "SELECT count(ID) as floorplancount FROM tblfloorplan";
	$result3 = mysql_query($query3) or die (mysql_error());
	$row3 = mysql_fetch_array($result3);
	$query2 = "SELECT count(ID) as floorplancount FROM tblfloorplan WHERE OnCallWMU > 0 OR EliteWMU > 0";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2);
?>
	<table width="100%" align="center" style="background-image: url(../sales/images/bk-lightblue.png);">
		<tr>
			<td align="center" class="bigheading" colspan="2">
				Floor Plan Summary
			</td>
		</tr>
		<tr>
			<td class="heading">
				Total Floor Plans Submitted: <?php echo $row3['floorplancount']; ?> <font color="FF0000">(<?php echo $row2['floorplancount'];?>)
			</td>
		</tr>
		<tr>
			<td valign="top" width="420">
				<table>
					<tr>
						<td class="heading" width="130">
							Type of System
						</td>
						<td class="heading" align="center" width="120">
							Qty of System
						</td>
						<td class="heading">
							Avg. WMU per System
						</td>
					</tr>
<?php			
					$eliteavg=0;
					$oncallavg=0;		
					for($cursor=1;$cursor <= 5; $cursor++)
					{					
?>								
						<tr>
							<td>		
<?php

								mysql_select_db($dbname2);
								$query4 = "SELECT count(ID) as floorplancount,sum(OnCallWMU) as sumOnCallWMU,sum(EliteWMU) as sumEliteWMU FROM tblfloorplan WHERE ((SystemType='$cursor') AND (OnCallWMU > 0 OR EliteWMU > 0))";
								$result4 = mysql_query($query4) or die (mysql_error());
								$row4 = mysql_fetch_array($result4);
								$callwmu = $row4['sumOnCallWMU'];
								$elitewmu = $row4['sumEliteWMU'];
								if($cursor == 1)
								{
									if($row4['floorplancount'] > 0)
									{
										$callavg = round(($callwmu / $row4['floorplancount']),3);
										$eliteavg = round(($elitewmu / $row4['floorplancount']),3);
									}
									$systype = 'On Call';
									echo $systype.'</td><td align=center>'.$row4['floorplancount'].'</td><td align=center>'.$callavg;
								}
								if($cursor == 2)
								{
									if($row4['floorplancount'] > 0)
									{
										$callavg = round(($callwmu / $row4['floorplancount']),3);
										$eliteavg = round(($elitewmu / $row4['floorplancount']),3);
									}									
									$systype = 'On Site';
									echo $systype.'</td><td align=center>'.$row4['floorplancount'].'</td><td align=center>'.$eliteavg;
								}
								if($cursor == 3)
								{
									if($row4['floorplancount'] > 0)
									{
										$callavg = round(($callwmu / $row4['floorplancount']),3);
										$eliteavg = round(($elitewmu / $row4['floorplancount']),3);
									}									
									$systype = 'On-Call + On Site';
									echo $systype.'</td><td align=center>'.$row4['floorplancount'].'</td><td align=center>'.$callavg.' / '.$eliteavg;
								}
								if($cursor == 4)
								{
									if($row4['floorplancount'] > 0)
									{
										$callavg = round(($callwmu / $row4['floorplancount']),3);
										$eliteavg = round(($elitewmu / $row4['floorplancount']),3);
									}									
									$systype = 'Elite';
									echo $systype.'</td><td align=center>'.$row4['floorplancount'].'</td><td align=center>'.$eliteavg;
								}		
								if($cursor == 5)
								{
									if($row4['floorplancount'] > 0)
									{
										$callavg = round(($callwmu / $row4['floorplancount']),3);
										$eliteavg = round(($elitewmu / $row4['floorplancount']),3);
									}									
									$systype = 'On Call + Elite';
									echo $systype.'</td><td align=center>'.$row4['floorplancount'].'</td><td align=center>'.$callavg.' / '.$eliteavg;
								}			
?>
							</td>
						</tr>					
<?php								
					$eliteavg=0;
					$oncallavg=0;
					}
?>					
						<tr>
							<td class="heading">
								Scale Ratings
							</td>
						</tr>
<?php		
						for($cursor=1;$cursor <= 3; $cursor++)
						{					
?>								
							<tr>
								<td colspan="3">		
<?php
									mysql_select_db($dbname2);
									$query6 = "SELECT count(ID) as scalecount FROM tblfloorplan WHERE consist='$cursor'";
									$result6 = mysql_query($query6) or die (mysql_error());
									$row6 = mysql_fetch_array($result6);
									if($cursor == 1)
									{		
										$consist = 'Perfect';
										echo $consist.': '.$row6['scalecount'];
									}
									if($cursor == 2)
									{		
										$consist = 'Good';
										echo $consist.': '.$row6['scalecount'];
									}
									if($cursor == 3)
									{		
										$consist = 'Should Not Be Used';
										echo $consist.': '.$row6['scalecount'];
									}				
?>
								</td>
							</tr>
<?php
						}
					$query7 = "SELECT count(ID) as scalecount FROM tblfloorplan WHERE consist=3";
					$result7 = mysql_query($query7) or die (mysql_error());
					$row7 = mysql_fetch_array($result7);		
					$percentscale = $row7['scalecount'] / $row2['floorplancount'];
?>
					<tr>
						<td colspan="3">
							Percentage of unuseable scales submitted: <?php echo round($percentscale,3) * 100; ?>%
						</td>
					</tr>
					<tr>
						<td>
							<?php echo '<input type="button" value="Back" onClick="window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'">'; ?>
						</td>
					</tr>				
				</table>
			</td>
			<td valign="top">			
				<table>
					<tr>
						<td colspan="6" class="heading" align="center">
							Total Number of WMU's
						</td>
					</tr>
					<tr>
						<td width="45">
							1-24
						</td>
						<td width="45">
							25-49
						</td>
						<td width="45">
							50-74
						</td>
						<td width="45">
							75-99
						</td>
						<td width="65">
							100-199
						</td>
						<td width="65">
							>200
						</td>						
					</tr>
<?php
					$a = 0;
					$b = 0;
					$c = 0;
					$d = 0;
					$e = 0;
					$f = 0;			
					$query5 = "SELECT ID,OnCallWMU,EliteWMU FROM tblfloorplan WHERE OnCallWMU > 0 OR EliteWMU > 0";
					$result5 = mysql_query($query5) or die (mysql_error());
					while($row5 = mysql_fetch_array($result5))
					{
						$oncallwmucount = $row5['OnCallWMU'];
						$elitewmucount = $row5['EliteWMU'];
						$wmutotal = $oncallwmucount + $elitewmucount;
						if((($oncallwmucount > 0 && $oncallwmucount < 25) OR ($elitewmucount > 0 && $elitewmucount < 25)) && ($wmutotal > 0))
						{
							$a = $a+1;
						}
						if((($oncallwmucount >= 25 && $oncallwmucount < 50) OR ($elitewmucount >=25 && $elitewmucount < 50)) && ($wmutotal > 0))
						{
							$b = $b+1;
						}
						if((($oncallwmucount >= 50 && $oncallwmucount < 75) OR ($elitewmucount >=50 && $elitewmucount < 75)) && ($wmutotal > 0))
						{
							$c = $c+1;
						}		
						if((($oncallwmucount >= 75 && $oncallwmucount < 100) OR ($elitewmucount >=75 && $elitewmucount < 100)) && ($wmutotal > 0))
						{
							$d = $d+1;
						}	
						if((($oncallwmucount >= 100 && $oncallwmucount < 200) OR ($elitewmucount >=100 && $elitewmucount < 200)) && ($wmutotal > 0))
						{
							$e = $e+1;
						}											
						if((($oncallwmucount >= 200) OR ($elitewmucount >= 200)) && ($wmutotal > 0))
						{
							$f = $f+1;
						}				
					}
?>									
					<tr>
						<td>
							<?php echo $a;?>
						</td>
						<td>
							<?php echo $b;?>
						</td>
						<td>
							<?php echo $c;?>
						</td>			
						<td>
							<?php echo $d;?>
						</td>
						<td>
							<?php echo $e;?>
						</td>
						<td>
							<?php echo $f;?>
						</td>																
					</tr>
<?php
					if($department == 2)
					{
?>											
						<tr>
							<td colspan="6" class="heading">
								By Technician Floor Plan Count
							</td>
						</tr>							
<?php
						$query8 = "SELECT COUNT(signature) as sigcount,signature FROM taskinfo WHERE Type = 12 AND signature <> 'NULL' Group BY signature";
						$result8 = mysql_query($query8) or die (mysql_error());
						while($row8 = mysql_fetch_array($result8))
						{
							$id = $row8['signature'];
							mysql_select_db('testhomefree');
							$query9 ="SELECT f_name,l_name FROM employees WHERE id = '$id'";
							$result9 = mysql_query($query9) or die (mysql_error());
							$row9 = mysql_fetch_array($result9);						
?>					
							<tr>
								<td colspan="6">
									<?php echo $row9['f_name'].' '.$row9['l_name'].' '.$row8['sigcount']; ?>
								</td>
							</tr>
<?php
						}
					}
					mysql_select_db('work');					
					$query10 = "SELECT Completiondate, Createdate FROM taskinfo WHERE Type = 12 And Status = 3 AND Createdate > '2009-06-01 00:00:00'";
					$result10 = mysql_query($query10) or die (mysql_error());
					$count10 = mysql_num_rows($result10);
					$q = 0;
?>
					<tr>
						<td colspan="6" class="heading">
							Average Completion Time *(office hours)
						</td>
					</tr>
<?php							
					while($row10 = mysql_fetch_array($result10))
					{
						$q = $q;						
						$create = strtotime($row10['Createdate']);
						$complete = strtotime($row10['Completiondate']);
						$d1 = date('d',$create);
						$d2 = date('H',$create);
						$d4 = date('l',$create);
						$d3 = date('d',$complete);
						if(($d1 <> $d3) && ($d2 > 15))
						{
							$night = 50400;
						}elseif(($d4 == 'Friday') && ($d1 <> $d3) && ($d2 > 15))
						{
							$night = 223200;
						}else
						{
							$night = 0;
						}
						$seconds = $complete - $create - $night;
						$q = $q + $seconds;									
					}	
					$dif = $q/$count10;
					$days = floor($dif / 86400);
					$temp_remainder = $dif - ($days * 86400);
		
		      $hours = floor($temp_remainder / 3600);
		      $temp_remainder = $temp_remainder - ($hours * 3600);
		       
		      $minutes = floor($temp_remainder / 60);
		      $temp_remainder = $temp_remainder - ($minutes * 60);
		       
		      $seconds = floor($temp_remainder);
		         
		      // leading zero's - not bothered about hours
		      $min_lead=':';
		     if($minutes <=9)
		        $min_lead .= '0';
		      $sec_lead=':';
		     if($seconds <=9)
		        $sec_lead .= '0';
		       
		  // difference/duration returned as Hours:Mins:Secs e.g. 01:29:32
			//return $hours.$min_lead.$minutes.$sec_lead.$seconds;
			$display = $hours.' Hours '.$minutes.' Minutes '.$seconds.' Seconds';  					
?>
				<tr>
					<td colspan = "6">
						<?php echo $display; ?>
					</td>
				</tr>	
				<tr>
					<td colspan="6">
						* If floor plan submitted after 3 PM closed office hours omitted
					</td>
				</tr>				
				</table>
			</td>
		</tr>						
	</table>											
<?php							
}
?>