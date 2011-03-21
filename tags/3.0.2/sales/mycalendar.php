<?php
include 'includes/config.php';
include 'includes/opendb.php';

if(isset($_GET['prm']))
{
	$prm = $_GET['prm'];
	$chm = $_GET['chm'];
	$m=$prm+$chm;
}
else
{
	$m= date("m");
}
$month = date('F');
$d= date("d");     // Finds today's date
$y= date("Y");     // Finds today's year
$no_of_days = date('t',mktime(0,0,0,$m,1,$y));	// This is to calculate number of days in a month
$mn=date('M',mktime(0,0,0,$m,1,$y)); // Month is calculated to display at the top of the calendar
$yn=date('Y',mktime(0,0,0,$m,1,$y)); // Year is calculated to display at the top of the calendar
$j= date('w',mktime(0,0,0,$m,1,$y)); // This will calculate the week day of the first day of the month
for($k=1; $k<=$j; $k++)
{ 
	$adj .="<td>&nbsp</td>";
}
echo $string;
/// Starting of top line showing name of the days of the week
echo " <table border='1' bordercolor='#FFFF00' cellspacing='0' cellpadding='0' align=center>
<tr><td>";
echo "<table cellspacing='0' cellpadding='0' align=center width='750' border='1'><td align=center bgcolor='#ffff00'><font size='3' face='Tahoma'> <a href='mycalendar.php?prm=$m&chm=-1'><</a> </td><td colspan=5 align=center bgcolor='#ffff00'><font size='3' face='Tahoma'>$mn $yn </td><td align=center bgcolor='#ffff00'><font size='3' face='Tahoma'> <a href='mycalendar.php?prm=$m&chm=1'>></a> </td></tr><tr>";
echo "<td width=14.2%><font size='3' face='Tahoma'><b>Sun</b></font></td><td width=14.2%><font size='3' face='Tahoma'><b>Mon</b></font></td><td width=14.2%><font size='3' face='Tahoma'><b>Tue</b></font></td><td width=14.2%><font size='3' face='Tahoma'><b>Wed</b></font></td><td width=14.2%><font size='3' face='Tahoma'><b>Thu</b></font></td><td width=14.2%><font size='3' face='Tahoma'><b>Fri</b></font></td><td width=14.2%><font size='3' face='Tahoma'><b>Sat</b></font></td></tr><tr>";
////// End of the top line showing name of the days of the week//////////
//////// Starting of the days//////////
for($i=1;$i<=$no_of_days;$i++)
{
	$daytotime = ($i.' '.$mn.' '.$yn);	
	$string = strtotime($daytotime);
	echo $adj."<td valign=top height=100><font size='2' face='Tahoma'>$i<br></font><font size='1' color='#ff0000'>";
	$query = "SELECT * FROM epc_calendar";
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$startDate = $row['startDate'];
		$endDate = $row['endDate'];
		$title = $row['title'];
		if($string >= $startDate && $string <= $endDate) {
			echo $title."<br />"; // This will display the date inside the calendar cell;
		}
	}
	echo " </font></td>";
	$adj='';
	$j ++;
	if($j==7)
	{
		echo "</tr><tr>";
		$j=0;
	}	
}
?>
