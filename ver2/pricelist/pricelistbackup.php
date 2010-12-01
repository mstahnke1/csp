<?php
include 'header.php';
include 'includes/config.php';
include 'includes/opendb.php';
if(!((isset($_GET['PN'])) OR (isset($_GET['update']))))
	{
		$array=array(90380001,90380002,90380003,90380006,90380007,38011011)
?>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table width = 750 border = 1>
		<tr>
			<td>
				<?php echo '<a href="' . 'pricelist.php'.'?update=child'.'">'?>UPDATE CHILD PART
			</td>
		</tr>
		<tr>
			<td align = center><font size = 5 face = Arial><b>
				HOMEFREE PRICE LIST 2008
			</b></font></td>
		</tr>
		<tr>
			<td align = center bgcolor = 0000FF><font size = 4 face = Arial><b>
				SYSTEMS
			</b></font></td>
		</tr>
	</table>
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>		
<?php
/*
**********************************************SYTEMS************************************
*/
foreach($array as $pn)
{
$query = "SELECT * FROM tblpartslist WHERE PartNumber = '$pn'";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result)
?>
		<tr>
			<td><b><font face = Arial size = 2>
			<?php echo $row['DSPartNumber']; ?>
			</font></b></td>
			<td><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row['PartNumber'].'">'. $row['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td><b><font face = Arial size = 2>
			</font></b></td>
			<td><b><font color="#ff0000">
				<?php echo $row['Description']; ?>
			</font></b></font></td>		
			<td align = center><b><font face = Arial size = 2>
				<?php echo $row['Quantity']; ?>
			</font></b></td>	
			<td><b><font face = Arial size = 2>
				-----
			</font><b></td>	
		</tr>	
<?php		
if($row['ChildPart1'] <> 0)
	{		
		$childpart1 = $row['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child1['ListPrice'] = 0;
	}
if($row['ChildPart2'] <> 0)
	{		
		$childpart2 = $row['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child2['ListPrice'] = 0;
	}
if($row['ChildPart3'] <> 0)
	{		
		$childpart3 = $row['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child3['ListPrice'] = 0;
	}
if($row['ChildPart4'] <> 0)
	{		
		$childpart4 = $row['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child4['ListPrice'] = 0;
	}
if($row['ChildPart5'] <> 0)
	{		
		$childpart5 = $row['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child5['ListPrice'] = 0;
	}
if($row['ChildPart6'] <> 0)
	{		
		$childpart6 = $row['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child6['ListPrice'] = 0;
	}
if($row['ChildPart7'] <> 0)
	{		
		$childpart7 = $row['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child7['ListPrice'] = 0;
	}
if($row['ChildPart8'] <> 0)
	{		
		$childpart8 = $row['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child8['ListPrice'] = 0;
	}
if($row['ChildPart9'] <> 0)
	{		
		$childpart9 = $row['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child9['ListPrice'] = 0;
	}
if($row['ChildPart10'] <> 0)
	{		
		$childpart10 = $row['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child10['ListPrice'] = 0;
	}
if($row['ChildPart11'] <> 0)
	{		
		$childpart11 = $row['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}else	
	{
		$child11['ListPrice'] = 0;
	}
if($row['ChildPart12'] <> 0)
	{		
		$childpart12 = $row['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>		

<?php
	}else
	{
		$child12['ListPrice'] = 0;
	}
?>
		<tr>
			<td><font face = Arial size = 2>
			
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				
			</font></td>
			<td><font face = Arial size = 2>
				
			</font></td>		
			<td><font face = Arial size = 2>
				TOTAL
			</font></td>	
			<td><font face = Arial size = 2><b>
<?php				
				$sumelite = $child1['ListPrice'] + $child2['ListPrice']+$child3['ListPrice']+$child4['ListPrice']+$child5['ListPrice']+$child6['ListPrice']+$child7['ListPrice']+$child8['ListPrice']+$child9['ListPrice']+$child10['ListPrice']+$child11['ListPrice']+$child12['ListPrice'];
				$formattedsumelite = number_format($sumelite, 2);
				echo $formattedsumelite; 
?>			
			</b></font></td>	
		</tr>	
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
	</tr>	
<?php
}
?>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 0000FF><font size = 4 face = Arial><b>
				SYSTEM ACCESSORIES
			</b></font></td>
		</tr>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				HOMEFREE SYSTEM CONTROL UNITS
			</b></font></td>
		</tr>
	</table>
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************HOMEFREE SYSTEM CONTROL UNITS************************************
*/
$query5 = "SELECT * FROM tblpartslist WHERE Family = 'HOMEFREE SYSTEM CONTROL UNITS' ORDER BY PartNumber";
$result5 = mysql_query($query5) or die (mysql_error());
while($row5 = mysql_fetch_array($result5))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row5['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row5['PartNumber'].'">'. $row5['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row5['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row5['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row5['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row5['ChildPart1'] <> 0)
	{		
		$childpart1 = $row5['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart2'] <> 0)
	{		
		$childpart2 = $row5['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart3'] <> 0)
	{		
		$childpart3 = $row5['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart4'] <> 0)
	{		
		$childpart4 = $row5['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart5'] <> 0)
	{		
		$childpart5 = $row5['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart6'] <> 0)
	{		
		$childpart6 = $row5['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart7'] <> 0)
	{		
		$childpart7 = $row5['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<t<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart8'] <> 0)
	{		
		$childpart8 = $row5['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart9'] <> 0)
	{		
		$childpart9 = $row5['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart10'] <> 0)
	{		
		$childpart10 = $row5['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row6['PartNumber'].'">'. $row6['PartNumber'] .'</a>'; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart11'] <> 0)
	{		
		$childpart11 = $row5['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row5['ChildPart12'] <> 0)
	{		
		$childpart12 = $row5['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				PERSONAL WATCHER AND ACCESSORIES
			</b></font></td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>
<?php
/*
**********************************************PERSONAL WATCHER AND ACCESSORIES************************************
*/
$query6 = "SELECT * FROM tblpartslist WHERE Family = 'PERSONAL WATCHER AND ACCESSORIES' ORDER BY PartNumber";
$result6 = mysql_query($query6) or die (mysql_error());
while($row6 = mysql_fetch_array($result6))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row6['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row6['PartNumber'].'">'. $row6['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row6['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row6['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row6['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row6['ChildPart1'] <> 0)
	{		
		$childpart1 = $row6['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart2'] <> 0)
	{		
		$childpart2 = $row6['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart3'] <> 0)
	{		
		$childpart3 = $row6['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart4'] <> 0)
	{		
		$childpart4 = $row6['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart5'] <> 0)
	{		
		$childpart5 = $row6['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart6'] <> 0)
	{		
		$childpart6 = $row6['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart7'] <> 0)
	{		
		$childpart7 = $row6['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart8'] <> 0)
	{		
		$childpart8 = $row6['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart9'] <> 0)
	{		
		$childpart9 = $row6['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart10'] <> 0)
	{		
		$childpart10 = $row6['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart11'] <> 0)
	{		
		$childpart11 = $row6['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row6['ChildPart12'] <> 0)
	{		
		$childpart12 = $row6['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				PAGERS AND ACCESSORIES
			</b></font></td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>
<?php
/*
**********************************************PAGERS AND ACCESSORIES************************************
*/
$query7 = "SELECT * FROM tblpartslist WHERE Family = 'PAGERS AND ACCESSORIES' ORDER BY PartNumber";
$result7 = mysql_query($query7) or die (mysql_error());
while($row7 = mysql_fetch_array($result7))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row7['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row7['PartNumber'].'">'. $row7['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row7['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row7['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row7['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row7['ChildPart1'] <> 0)
	{		
		$childpart1 = $row7['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart2'] <> 0)
	{		
		$childpart2 = $row7['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart3'] <> 0)
	{		
		$childpart3 = $row7['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart4'] <> 0)
	{		
		$childpart4 = $row7['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart5'] <> 0)
	{		
		$childpart5 = $row7['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart6'] <> 0)
	{		
		$childpart6 = $row7['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart7'] <> 0)
	{		
		$childpart7 = $row7['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart8'] <> 0)
	{		
		$childpart8 = $row7['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart9'] <> 0)
	{		
		$childpart9 = $row7['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart10'] <> 0)
	{		
		$childpart10 = $row7['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart11'] <> 0)
	{		
		$childpart11 = $row7['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row7['ChildPart12'] <> 0)
	{		
		$childpart12 = $row7['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				CALL BUTTONS AND ACCESSORIES
			</b></font></td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>
<?php
/*
**********************************************CALL BUTTONS AND ACCESSORIES************************************
*/
$query8 = "SELECT * FROM tblpartslist WHERE Family = 'CALL BUTTONS AND ACCESSORIES' ORDER BY PartNumber";
$result8 = mysql_query($query8) or die (mysql_error());
while($row8 = mysql_fetch_array($result8))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row8['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row8['PartNumber'].'">'. $row8['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row8['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row8['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row8['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row8['ChildPart1'] <> 0)
	{		
		$childpart1 = $row8['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart2'] <> 0)
	{		
		$childpart2 = $row8['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart3'] <> 0)
	{		
		$childpart3 = $row8['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart4'] <> 0)
	{		
		$childpart4 = $row8['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart5'] <> 0)
	{		
		$childpart5 = $row8['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart6'] <> 0)
	{		
		$childpart6 = $row8['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart7'] <> 0)
	{		
		$childpart1 = $row8['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart8'] <> 0)
	{		
		$childpart8 = $row8['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart9'] <> 0)
	{		
		$childpart9 = $row8['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart10'] <> 0)
	{		
		$childpart10 = $row8['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart11'] <> 0)
	{		
		$childpart11 = $row8['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row8['ChildPart12'] <> 0)
	{		
		$childpart12 = $row8['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				Push Cord and Accessories
			</b></font></td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>
<?php
/*
**********************************************Push Cord and Accessories************************************
*/
$query9 = "SELECT * FROM tblpartslist WHERE Family = 'Push Cord and Accessories' ORDER BY PartNumber";
$result9 = mysql_query($query9) or die (mysql_error());
while($row9 = mysql_fetch_array($result9))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row9['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row9['PartNumber'].'">'. $row9['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row9['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row9['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row9['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row9['ChildPart1'] <> 0)
	{		
		$childpart1 = $row9['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart2'] <> 0)
	{		
		$childpart2 = $row9['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart3'] <> 0)
	{		
		$childpart3 = $row9['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart4'] <> 0)
	{		
		$childpart4 = $row9['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart5'] <> 0)
	{		
		$childpart5 = $row9['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart6'] <> 0)
	{		
		$childpart6 = $row9['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart7'] <> 0)
	{		
		$childpart7 = $row9['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart8'] <> 0)
	{		
		$childpart8 = $row9['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart9'] <> 0)
	{		
		$childpart9 = $row9['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart10'] <> 0)
	{		
		$childpart10 = $row9['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart11'] <> 0)
	{		
		$childpart11 = $row9['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row9['ChildPart12'] <> 0)
	{		
		$childpart12 = $row9['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				TIMERS
			</b></font></td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>
<?php
/*
**********************************************TIMERS************************************
*/
$query10 = "SELECT * FROM tblpartslist WHERE Family = 'TIMERS' ORDER BY PartNumber";
$result10 = mysql_query($query10) or die (mysql_error());
while($row10 = mysql_fetch_array($result10))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row10['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row10['PartNumber'].'">'. $row10['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row10['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row10['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row10['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row10['ChildPart1'] <> 0)
	{		
		$childpart1 = $row10['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart2'] <> 0)
	{		
		$childpart2 = $row10['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart3'] <> 0)
	{		
		$childpart3 = $row10['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart4'] <> 0)
	{		
		$childpart4 = $row10['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart5'] <> 0)
	{		
		$childpart5 = $row10['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart6'] <> 0)
	{		
		$childpart6 = $row10['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart7'] <> 0)
	{		
		$childpart7 = $row10['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart8'] <> 0)
	{		
		$childpart8 = $row10['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart9'] <> 0)
	{		
		$childpart9 = $row10['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart10'] <> 0)
	{		
		$childpart10 = $row10['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart11'] <> 0)
	{		
		$childpart11 = $row10['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row10['ChildPart12'] <> 0)
	{		
		$childpart12 = $row10['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				Computer Sub Station and 2nd Monitor Accessories
			</b></font></td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>
<?php
/*
**********************************************Computer Accessories and 2nd Monitor Accessories************************************
*/
$query11 = "SELECT * FROM tblpartslist WHERE Family = 'Computer Sub Station and 2nd Monitor Accessories' ORDER BY PartNumber";
$result11 = mysql_query($query11) or die (mysql_error());
while($row11 = mysql_fetch_array($result11))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row11['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row11['PartNumber'].'">'. $row11['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row11['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row11['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row11['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row11['ChildPart1'] <> 0)
	{		
		$childpart1 = $row11['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart2'] <> 0)
	{		
		$childpart2 = $row11['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart3'] <> 0)
	{		
		$childpart3 = $row11['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart4'] <> 0)
	{		
		$childpart4 = $row11['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart5'] <> 0)
	{		
		$childpart5 = $row11['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart6'] <> 0)
	{		
		$childpart6 = $row11['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart7'] <> 0)
	{		
		$childpart7 = $row11['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart8'] <> 0)
	{		
		$childpart8 = $row11['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart9'] <> 0)
	{		
		$childpart9 = $row11['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart10'] <> 0)
	{		
		$childpart10 = $row11['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart11'] <> 0)
	{		
		$childpart11 = $row11['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row11['ChildPart12'] <> 0)
	{		
		$childpart12 = $row11['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				BYPASS/RESET ACCESSORIES
			</b></font></td>
		</tr>	
	</table>	
<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
********************************************** BYPASS/RESET ACCESSORIES************************************
*/
$query12 = "SELECT * FROM tblpartslist WHERE Family = 'BYPASS/RESET ACCESSORIES'";
$result12 = mysql_query($query12) or die (mysql_error());
while($row12 = mysql_fetch_array($result12))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row12['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row12['PartNumber'].'">'. $row12['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row12['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row12['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row12['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row12['ChildPart1'] <> 0)
	{		
		$childpart1 = $row12['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart2'] <> 0)
	{		
		$childpart2 = $row12['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart3'] <> 0)
	{		
		$childpart3 = $row12['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart4'] <> 0)
	{		
		$childpart4 = $row12['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart5'] <> 0)
	{		
		$childpart5 = $row12['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart6'] <> 0)
	{		
		$childpart6 = $row12['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart7'] <> 0)
	{		
		$childpart7 = $row12['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart8'] <> 0)
	{		
		$childpart8 = $row12['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart9'] <> 0)
	{		
		$childpart9 = $row12['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart10'] <> 0)
	{		
		$childpart10 = $row12['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart11'] <> 0)
	{		
		$childpart11 = $row12['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row12['ChildPart12'] <> 0)
	{		
		$childpart12 = $row12['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				BUZZERS
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************BUZZERS************************************
*/
$query14 = "SELECT * FROM tblpartslist WHERE Family = 'BUZZERS'";
$result14 = mysql_query($query14) or die (mysql_error());
while($row14 = mysql_fetch_array($result14))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row14['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row14['PartNumber'].'">'. $row14['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row14['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row14['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row14['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row14['ChildPart1'] <> 0)
	{		
		$childpart1 = $row14['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart2'] <> 0)
	{		
		$childpart2 = $row14['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart3'] <> 0)
	{		
		$childpart3 = $row14['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart4'] <> 0)
	{		
		$childpart4 = $row14['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart5'] <> 0)
	{		
		$childpart5 = $row14['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart6'] <> 0)
	{		
		$childpart6 = $row14['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart7'] <> 0)
	{		
		$childpart7 = $row14['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart8'] <> 0)
	{		
		$childpart8 = $row14['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart9'] <> 0)
	{		
		$childpart9 = $row14['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart10'] <> 0)
	{		
		$childpart10 = $row14['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart11'] <> 0)
	{		
		$childpart11 = $row14['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row14['ChildPart12'] <> 0)
	{		
		$childpart12 = $row14['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				Wireless Doorbell Pushbutton
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
********************************************** Wireless Doorbell Pushbutton************************************
*/
$query13 = "SELECT * FROM tblpartslist WHERE Family = 'Wireless Doorbell Pushbutton'";
$result13 = mysql_query($query13) or die (mysql_error());
while($row13 = mysql_fetch_array($result13))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row13['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row13['PartNumber'].'">'. $row13['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row13['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row13['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row13['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row13['ChildPart1'] <> 0)
	{		
		$childpart1 = $row13['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart2'] <> 0)
	{		
		$childpart2 = $row13['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart3'] <> 0)
	{		
		$childpart3 = $row13['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart4'] <> 0)
	{		
		$childpart4 = $row13['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart5'] <> 0)
	{		
		$childpart5 = $row13['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart6'] <> 0)
	{		
		$childpart6 = $row13['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart7'] <> 0)
	{		
		$childpart7 = $row13['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart8'] <> 0)
	{		
		$childpart8 = $row13['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart9'] <> 0)
	{		
		$childpart9 = $row13['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart10'] <> 0)
	{		
		$childpart10 = $row13['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart11'] <> 0)
	{		
		$childpart11 = $row13['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row13['ChildPart12'] <> 0)
	{		
		$childpart12 = $row13['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>		
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				DOOR POSITION AND MOTION SENSORS
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************DOOR POSITION AND MOTION SENSORS************************************
*/
$query15 = "SELECT * FROM tblpartslist WHERE Family = 'DOOR POSITION AND MOTION SENSORS'";
$result15 = mysql_query($query15) or die (mysql_error());
while($row15 = mysql_fetch_array($result15))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row15['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row15['PartNumber'].'">'. $row15['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row15['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row15['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row15['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row15['ChildPart1'] <> 0)
	{		
		$childpart1 = $row15['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart2'] <> 0)
	{		
		$childpart2 = $row15['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart3'] <> 0)
	{		
		$childpart3 = $row15['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart4'] <> 0)
	{		
		$childpart4 = $row15['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart5'] <> 0)
	{		
		$childpart5 = $row15['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart6'] <> 0)
	{		
		$childpart6 = $row15['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart7'] <> 0)
	{		
		$childpart7 = $row15['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart8'] <> 0)
	{		
		$childpart8 = $row15['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart9'] <> 0)
	{		
		$childpart9 = $row15['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart10'] <> 0)
	{		
		$childpart10 = $row15['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart11'] <> 0)
	{		
		$childpart11 = $row15['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row15['ChildPart12'] <> 0)
	{		
		$childpart12 = $row15['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				TEMPERATURE SENSOR AND ACCESSORIES
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************TEMPERATURE SENSOR AND ACCESSORIES************************************
*/
$query16 = "SELECT * FROM tblpartslist WHERE Family = 'TEMPERATURE SENSOR AND ACCESSORIES'";
$result16 = mysql_query($query16) or die (mysql_error());
while($row16 = mysql_fetch_array($result16))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row16['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row16['PartNumber'].'">'. $row16['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row16['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row16['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row16['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row16['ChildPart1'] <> 0)
	{		
		$childpart1 = $row16['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart2'] <> 0)
	{		
		$childpart2 = $row16['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart3'] <> 0)
	{		
		$childpart3 = $row16['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart4'] <> 0)
	{		
		$childpart4 = $row16['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart5'] <> 0)
	{		
		$childpart5 = $row16['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart6'] <> 0)
	{		
		$childpart6 = $row16['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart7'] <> 0)
	{		
		$childpart7 = $row16['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart8'] <> 0)
	{		
		$childpart8 = $row16['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart9'] <> 0)
	{		
		$childpart9 = $row16['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart10'] <> 0)
	{		
		$childpart10 = $row16['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart11'] <> 0)
	{		
		$childpart11 = $row16['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row16['ChildPart12'] <> 0)
	{		
		$childpart12 = $row16['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				LOCKS AND LOCK ACCESSORIES
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************LOCKS AND LOCK ACCESSORIES************************************
*/
$query17 = "SELECT * FROM tblpartslist WHERE Family = 'LOCKS AND LOCK ACCESSORIES'";
$result17 = mysql_query($query17) or die (mysql_error());
while($row17 = mysql_fetch_array($result17))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row17['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row17['PartNumber'].'">'. $row17['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row17['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row17['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row17['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row17['ChildPart1'] <> 0)
	{		
		$childpart1 = $row17['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart2'] <> 0)
	{		
		$childpart2 = $row17['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart3'] <> 0)
	{		
		$childpart3 = $row17['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart4'] <> 0)
	{		
		$childpart4 = $row17['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart5'] <> 0)
	{		
		$childpart5 = $row17['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart6'] <> 0)
	{		
		$childpart6 = $row17['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart7'] <> 0)
	{		
		$childpart7 = $row17['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart8'] <> 0)
	{		
		$childpart8 = $row17['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart9'] <> 0)
	{		
		$childpart9 = $row17['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart10'] <> 0)
	{		
		$childpart10 = $row17['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart11'] <> 0)
	{		
		$childpart11 = $row17['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row17['ChildPart12'] <> 0)
	{		
		$childpart12 = $row17['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				DEACTIVATORS
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************DEACTIVATORS************************************
*/
$query18 = "SELECT * FROM tblpartslist WHERE Family = 'DEACTIVATORS'";
$result18 = mysql_query($query18) or die (mysql_error());
while($row18 = mysql_fetch_array($result18))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
				<?php echo $row18['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row18['PartNumber'].'">'. $row18['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row18['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row18['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row18['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row18['ChildPart1'] <> 0)
	{		
		$childpart1 = $row18['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart2'] <> 0)
	{		
		$childpart2 = $row18['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart3'] <> 0)
	{		
		$childpart3 = $row18['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart4'] <> 0)
	{		
		$childpart4 = $row18['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart5'] <> 0)
	{		
		$childpart5 = $row18['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart6'] <> 0)
	{		
		$childpart6 = $row18['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart7'] <> 0)
	{		
		$childpart7 = $row18['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart8'] <> 0)
	{		
		$childpart8 = $row18['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart9'] <> 0)
	{		
		$childpart9 = $row18['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart10'] <> 0)
	{		
		$childpart10 = $row18['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart11'] <> 0)
	{		
		$childpart11 = $row18['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row18['ChildPart12'] <> 0)
	{		
		$childpart12 = $row18['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>			
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				KEYPADS
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************KEYPADS************************************
*/
$query19 = "SELECT * FROM tblpartslist WHERE Family = 'KEYPADS'";
$result19 = mysql_query($query19) or die (mysql_error());
while($row19 = mysql_fetch_array($result19))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
				<?php echo $row19['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row19['PartNumber'].'">'. $row19['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row19['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row19['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row19['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row19['ChildPart1'] <> 0)
	{		
		$childpart1 = $row19['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart2'] <> 0)
	{		
		$childpart2 = $row19['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart3'] <> 0)
	{		
		$childpart3 = $row19['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart4'] <> 0)
	{		
		$childpart4 = $row19['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart5'] <> 0)
	{		
		$childpart5 = $row19['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart6'] <> 0)
	{		
		$childpart6 = $row19['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart7'] <> 0)
	{		
		$childpart7 = $row19['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart8'] <> 0)
	{		
		$childpart8 = $row19['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart9'] <> 0)
	{		
		$childpart9 = $row19['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart10'] <> 0)
	{		
		$childpart10 = $row19['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart11'] <> 0)
	{		
		$childpart11 = $row19['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row19['ChildPart12'] <> 0)
	{		
		$childpart12 = $row19['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>			
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				MOUNTING BOXES
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************MOUNTING BOXES************************************
*/
$query20 = "SELECT * FROM tblpartslist WHERE Family = 'MOUNTING BOXES'";
$result20 = mysql_query($query20) or die (mysql_error());
while($row20 = mysql_fetch_array($result20))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row20['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row20['PartNumber'].'">'. $row20['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row20['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row20['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row20['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row20['ChildPart1'] <> 0)
	{		
		$childpart1 = $row20['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart2'] <> 0)
	{		
		$childpart2 = $row20['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart3'] <> 0)
	{		
		$childpart3 = $row20['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart4'] <> 0)
	{		
		$childpart4 = $row20['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart5'] <> 0)
	{		
		$childpart5 = $row20['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart6'] <> 0)
	{		
		$childpart6 = $row20['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart7'] <> 0)
	{		
		$childpart7 = $row20['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart8'] <> 0)
	{		
		$childpart8 = $row20['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart9'] <> 0)
	{		
		$childpart9 = $row20['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart10'] <> 0)
	{		
		$childpart10 = $row20['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart11'] <> 0)
	{		
		$childpart11 = $row20['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row20['ChildPart12'] <> 0)
	{		
		$childpart12 = $row20['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				KEY SWITCHES
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************KEY SWITCHES************************************
*/
$query21 = "SELECT * FROM tblpartslist WHERE Family = 'KEY SWITCHES'";
$result21 = mysql_query($query21) or die (mysql_error());
while($row21 = mysql_fetch_array($result21))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row21['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row21['PartNumber'].'">'. $row21['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row21['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row21['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row21['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row21['ChildPart1'] <> 0)
	{		
		$childpart1 = $row21['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart2'] <> 0)
	{		
		$childpart2 = $row21['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart3'] <> 0)
	{		
		$childpart3 = $row21['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart4'] <> 0)
	{		
		$childpart4 = $row21['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart5'] <> 0)
	{		
		$childpart5 = $row21['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart6'] <> 0)
	{		
		$childpart6 = $row21['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart7'] <> 0)
	{		
		$childpart7 = $row21['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart8'] <> 0)
	{		
		$childpart8 = $row21['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart9'] <> 0)
	{		
		$childpart9 = $row21['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart10'] <> 0)
	{		
		$childpart10 = $row21['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart11'] <> 0)
	{		
		$childpart11 = $row21['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row21['ChildPart12'] <> 0)
	{		
		$childpart12 = $row21['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				AWARE ACCESSORIES
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************AWARE ACCESSORIES************************************
*/
$query22 = "SELECT * FROM tblpartslist WHERE Family = 'AWARE ACCESSORIES'";
$result22 = mysql_query($query22) or die (mysql_error());
while($row22 = mysql_fetch_array($result22))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row22['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row22['PartNumber'].'">'. $row22['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row22['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row22['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row22['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row22['ChildPart1'] <> 0)
	{		
		$childpart1 = $row22['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart2'] <> 0)
	{		
		$childpart2 = $row22['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart3'] <> 0)
	{		
		$childpart3 = $row22['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart4'] <> 0)
	{		
		$childpart4 = $row22['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart5'] <> 0)
	{		
		$childpart5 = $row22['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart6'] <> 0)
	{		
		$childpart6 = $row22['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart7'] <> 0)
	{		
		$childpart7 = $row22['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart8'] <> 0)
	{		
		$childpart8 = $row22['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart9'] <> 0)
	{		
		$childpart9 = $row22['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart10'] <> 0)
	{		
		$childpart10 = $row22['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart11'] <> 0)
	{		
		$childpart11 = $row22['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row22['ChildPart12'] <> 0)
	{		
		$childpart12 = $row22['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				WIRE
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************WIRE************************************
*/
$query23 = "SELECT * FROM tblpartslist WHERE Family = 'WIRE'";
$result23 = mysql_query($query23) or die (mysql_error());
while($row23 = mysql_fetch_array($result23))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row23['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row23['PartNumber'].'">'. $row23['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row23['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row23['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row23['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row23['ChildPart1'] <> 0)
	{		
		$childpart1 = $row23['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart2'] <> 0)
	{		
		$childpart2 = $row23['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart3'] <> 0)
	{		
		$childpart3 = $row23['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart4'] <> 0)
	{		
		$childpart4 = $row23['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart5'] <> 0)
	{		
		$childpart5 = $row23['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart6'] <> 0)
	{		
		$childpart6 = $row23['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart7'] <> 0)
	{		
		$childpart7 = $row23['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart8'] <> 0)
	{		
		$childpart8 = $row23['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart9'] <> 0)
	{		
		$childpart9 = $row23['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart10'] <> 0)
	{		
		$childpart10 = $row23['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart11'] <> 0)
	{		
		$childpart11 = $row23['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart12'] <> 0)
	{		
		$childpart12 = $row23['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				WIRE MOLDING - RACEWAY
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************WIRE MOLDING (RACEWAY)************************************
*/
$query23 = "SELECT * FROM tblpartslist WHERE Family = 'WIRE MOLDING - RACEWAY'";
$result23 = mysql_query($query23) or die (mysql_error());
while($row23 = mysql_fetch_array($result23))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row23['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row23['PartNumber'].'">'. $row23['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row23['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row23['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row23['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row23['ChildPart1'] <> 0)
	{		
		$childpart1 = $row23['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart2'] <> 0)
	{		
		$childpart2 = $row23['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart3'] <> 0)
	{		
		$childpart3 = $row23['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart4'] <> 0)
	{		
		$childpart4 = $row23['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart5'] <> 0)
	{		
		$childpart5 = $row23['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart6'] <> 0)
	{		
		$childpart6 = $row23['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart7'] <> 0)
	{		
		$childpart7 = $row23['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart8'] <> 0)
	{		
		$childpart8 = $row23['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart9'] <> 0)
	{		
		$childpart9 = $row23['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart10'] <> 0)
	{		
		$childpart10 = $row23['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart11'] <> 0)
	{		
		$childpart11 = $row23['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row23['ChildPart12'] <> 0)
	{		
		$childpart12 = $row23['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>			
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				POWER SUPPLIES
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************POWER SUPPLIES************************************
*/
$query24 = "SELECT * FROM tblpartslist WHERE Family = 'POWER SUPPLIES'";
$result24 = mysql_query($query24) or die (mysql_error());
while($row24 = mysql_fetch_array($result24))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row24['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row24['PartNumber'].'">'. $row24['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row24['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row24['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row24['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row24['ChildPart1'] <> 0)
	{		
		$childpart1 = $row24['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart2'] <> 0)
	{		
		$childpart2 = $row24['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart3'] <> 0)
	{		
		$childpart3 = $row24['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart4'] <> 0)
	{		
		$childpart4 = $row24['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart5'] <> 0)
	{		
		$childpart5 = $row24['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart6'] <> 0)
	{		
		$childpart6 = $row24['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart7'] <> 0)
	{		
		$childpart7 = $row24['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart8'] <> 0)
	{		
		$childpart8 = $row24['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart9'] <> 0)
	{		
		$childpart9 = $row24['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart10'] <> 0)
	{		
		$childpart10 = $row24['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart11'] <> 0)
	{		
		$childpart11 = $row24['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row24['ChildPart12'] <> 0)
	{		
		$childpart12 = $row24['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>			
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				Manuals
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************Manuals************************************
*/
$query25 = "SELECT * FROM tblpartslist WHERE Family = 'Manuals'";
$result25 = mysql_query($query25) or die (mysql_error());
while($row25 = mysql_fetch_array($result25))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row25['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row25['PartNumber'].'">'. $row25['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row25['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row25['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row25['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row25['ChildPart1'] <> 0)
	{		
		$childpart1 = $row25['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart2'] <> 0)
	{		
		$childpart2 = $row25['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart3'] <> 0)
	{		
		$childpart3 = $row25['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart4'] <> 0)
	{		
		$childpart4 = $row25['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart5'] <> 0)
	{		
		$childpart5 = $row25['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart6'] <> 0)
	{		
		$childpart6 = $row25['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart7'] <> 0)
	{		
		$childpart7 = $row25['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart8'] <> 0)
	{		
		$childpart8 = $row25['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart9'] <> 0)
	{		
		$childpart9 = $row25['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart10'] <> 0)
	{		
		$childpart10 = $row25['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart11'] <> 0)
	{		
		$childpart11 = $row25['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row25['ChildPart12'] <> 0)
	{		
		$childpart12 = $row25['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				MISC. ACCESSORIES
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************MISC. ACCESSORIES************************************
*/
$query26 = "SELECT * FROM tblpartslist WHERE Family = 'MISC. ACCESSORIES'";
$result26 = mysql_query($query26) or die (mysql_error());
while($row26 = mysql_fetch_array($result26))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row26['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row26['PartNumber'].'">'. $row26['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row26['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row26['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row26['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row26['ChildPart1'] <> 0)
	{		
		$childpart1 = $row26['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart2'] <> 0)
	{		
		$childpart2 = $row26['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart3'] <> 0)
	{		
		$childpart3 = $row26['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart4'] <> 0)
	{		
		$childpart4 = $row26['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart5'] <> 0)
	{		
		$childpart5 = $row26['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart6'] <> 0)
	{		
		$childpart6 = $row26['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart7'] <> 0)
	{		
		$childpart7 = $row26['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart8'] <> 0)
	{		
		$childpart8 = $row26['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart9'] <> 0)
	{		
		$childpart9 = $row26['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart10'] <> 0)
	{		
		$childpart10 = $row26['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart11'] <> 0)
	{		
		$childpart11 = $row26['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row26['ChildPart12'] <> 0)
	{		
		$childpart12 = $row26['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				RMA
			</b></font></td>
		</tr>	
	</table>	
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
**********************************************RMA************************************
*/
$query27 = "SELECT * FROM tblpartslist WHERE Family = 'RMA'";
$result27 = mysql_query($query27) or die (mysql_error());
while($row27 = mysql_fetch_array($result27))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row27['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row27['PartNumber'].'">'. $row27['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row27['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row27['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row27['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row27['ChildPart1'] <> 0)
	{		
		$childpart1 = $row27['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart2'] <> 0)
	{		
		$childpart2 = $row27['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart3'] <> 0)
	{		
		$childpart3 = $row27['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart4'] <> 0)
	{		
		$childpart4 = $row27['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart5'] <> 0)
	{		
		$childpart5 = $row27['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart6'] <> 0)
	{		
		$childpart6 = $row27['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart7'] <> 0)
	{		
		$childpart7 = $row27['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart8'] <> 0)
	{		
		$childpart8 = $row27['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart9'] <> 0)
	{		
		$childpart9 = $row27['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart10'] <> 0)
	{		
		$childpart10 = $row27['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart11'] <> 0)
	{		
		$childpart11 = $row27['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row27['ChildPart12'] <> 0)
	{		
		$childpart12 = $row27['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	<table width = 750 border = 1>
		<tr>
			<td align = center bgcolor = 008000><font size = 3 face = Arial><b>
				OLD PARTS
			</b></font></td>
		</tr>	
	</table>		
	<table width = 750 border = 1>
		<tr>
			<td width = 60 valign = bottom><font face = Arial size = 2>
				DS Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Parent Part Number
			</font></td>
			<td width = 70 valign = bottom><font face = Arial size = 2>
				Child Part(s)
			</font></td>
			<td width = 320 align = center valign = bottom><font face = Arial size = 2>
				Product/Part
			</font></td>		
			<td width = 40 valign = bottom><font face = Arial size = 2>
				QTY
			</font></td>	
			<td width = 50 valign = bottom><font face = Arial size = 2>
				Base Prices
			</font></td>	
		</tr>				
<?php
/*
*********************************************OLD PARTS************************************
*/
$query28 = "SELECT * FROM tblpartslist WHERE Family = 'OLD PARTS'";
$result28 = mysql_query($query28) or die (mysql_error());
while($row28 = mysql_fetch_array($result28))
	{
?>
		<tr>
			<td width = 60><b><font face = Arial size = 2>
			<?php echo $row28['DSPartNumber']; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
				<?php echo '<a href="' . $_SERVER['PHP_SELF'].'?PN='. $row28['PartNumber'].'">'. $row28['PartNumber'] .'</a>'; ?>
			</font></b></td>
			<td width = 70><b><font face = Arial size = 2>
			</font></b></td>
			<td width = 320><b><font face = Arial size = 2>
				<?php echo $row28['Description']; ?>
			</font></b></td>		
			<td align = center width = 40><b><font face = Arial size = 2>
				<?php echo $row28['Quantity']; ?>
			</font></b></td>	
			<td width = 50><b><font face = Arial size = 2>
				<?php echo $row28['ListPrice']; ?>
			</font><b></td>	
		</tr>	
<?php		
if($row28['ChildPart1'] <> 0)
	{		
		$childpart1 = $row28['ChildPart1'];
		$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
		$child1queryresult = mysql_query($child1query) or die (mysql_error());
		$child1 = mysql_fetch_array($child1queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child1['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child1['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child1['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child1['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart2'] <> 0)
	{		
		$childpart2 = $row28['ChildPart2'];
		$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
		$child2queryresult = mysql_query($child2query) or die (mysql_error());
		$child2 = mysql_fetch_array($child2queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child2['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child2['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child2['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child2['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart3'] <> 0)
	{		
		$childpart3 = $row28['ChildPart3'];
		$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
		$child3queryresult = mysql_query($child3query) or die (mysql_error());
		$child3 = mysql_fetch_array($child3queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child3['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child3['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child3['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child3['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart4'] <> 0)
	{		
		$childpart4 = $row28['ChildPart4'];
		$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
		$child4queryresult = mysql_query($child4query) or die (mysql_error());
		$child4 = mysql_fetch_array($child4queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child4['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child4['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				OR <?php echo $child4['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child4['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child4['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart5'] <> 0)
	{		
		$childpart5 = $row28['ChildPart5'];
		$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
		$child5queryresult = mysql_query($child5query) or die (mysql_error());
		$child5 = mysql_fetch_array($child5queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child5['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child5['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child5['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child5['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart6'] <> 0)
	{		
		$childpart6 = $row28['ChildPart6'];
		$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
		$child6queryresult = mysql_query($child6query) or die (mysql_error());
		$child6 = mysql_fetch_array($child6queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child6['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child6['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child6['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child6['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart7'] <> 0)
	{		
		$childpart7 = $row28['ChildPart7'];
		$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
		$child7queryresult = mysql_query($child7query) or die (mysql_error());
		$child7 = mysql_fetch_array($child7queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child7['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child7['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child7['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child7['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart8'] <> 0)
	{		
		$childpart8 = $row28['ChildPart8'];
		$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
		$child8queryresult = mysql_query($child8query) or die (mysql_error());
		$child8 = mysql_fetch_array($child8queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child8['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child8['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child8['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child8['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart9'] <> 0)
	{		
		$childpart9 = $row28['ChildPart9'];
		$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
		$child9queryresult = mysql_query($child9query) or die (mysql_error());
		$child9 = mysql_fetch_array($child9queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child9['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child9['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child9['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child9['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart10'] <> 0)
	{		
		$childpart10 = $row28['ChildPart10'];
		$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
		$child10queryresult = mysql_query($child10query) or die (mysql_error());
		$child10 = mysql_fetch_array($child10queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child10['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child10['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child10['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child10['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart11'] <> 0)
	{		
		$childpart11 = $row28['ChildPart11'];
		$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
		$child11queryresult = mysql_query($child11query) or die (mysql_error());
		$child11 = mysql_fetch_array($child11queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child11['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child11['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child11['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child11['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
if($row28['ChildPart12'] <> 0)
	{		
		$childpart12 = $row28['ChildPart12'];
		$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
		$child12queryresult = mysql_query($child12query) or die (mysql_error());
		$child12 = mysql_fetch_array($child12queryresult)
?>
		<tr>
			<td><font face = Arial size = 2>
			<?php echo $child12['DSPartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['PartNumber']; ?>
			</font></td>
			<td><font face = Arial size = 2>
				<?php echo $child12['Description']; ?>
			</font></td>		
			<td><font face = Arial size = 2>
				<?php echo $child12['Quantity']; ?>
			</font></td>	
			<td><font face = Arial size = 2>
				<?php echo $child12['ListPrice']; ?>
			</font></td>	
		</tr>			
<?php
	}
	}
?>
		<tr>
			<td colspan = 6>
				<div align="center"><hr width="100%"></div>
			</td>
		</tr>	
	</table>
</form>		
<?php
	}
/*
******************************************UPDATE/VIEW PART**********************************
*/	
if(isset($_GET['Save']))
	{
		$PN = $_GET['PN'];
		$DSPartNumber = $_GET['DSPartNumber'];
		$Description = $_GET['Description'];
		$Quantity = $_GET['Quantity'];
		$ListPrice = $_GET['ListPrice'];
		$ChildPart1 = $_GET['ChildPart1'];
		$ChildPart2 = $_GET['ChildPart2'];
		$ChildPart3 = $_GET['ChildPart3'];
		$ChildPart4 = $_GET['ChildPart4'];
		$ChildPart5 = $_GET['ChildPart5'];
		$ChildPart6 = $_GET['ChildPart6'];
		$ChildPart7 = $_GET['ChildPart7'];
		$ChildPart8 = $_GET['ChildPart8'];
		$ChildPart9 = $_GET['ChildPart9'];
		$ChildPart10 = $_GET['ChildPart10'];
		$ChildPart11 = $_GET['ChildPart11'];
		$ChildPart12 = $_GET['ChildPart12'];
		
		$update = "UPDATE tblpartslist SET DSPartNumber='$DSPartNumber',Description = '$Description',Quantity = '$Quantity',
							ListPrice = '$ListPrice',ChildPart1 = '$ChildPart1',ChildPart2 = '$ChildPart2',ChildPart3 = '$ChildPart3',
							ChildPart4 = '$ChildPart4',ChildPart5 = '$ChildPart5',ChildPart6 = '$ChildPart6',ChildPart7 = '$ChildPart7',
							ChildPart8 = '$ChildPart8',ChildPart9 = '$ChildPart9',ChildPart10 = '$ChildPart10',ChildPart11 = '$ChildPart11',
							ChildPart12 = '$ChildPart12' WHERE PartNumber = '$PN'";
		mysql_query($update) or die(mysql_error());
	}
if(isset($_GET['PN']))
	{
		if($_SESSION['access'] > 6)
			{
?>
				<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
				if(isset($_GET['Save']))
				{
?>		
					<table width = 750 border = 0>
						<tr>
							<td><font color="#ff0000">
								Changes Saved Successfully
							</font></td>
						</tr>
					</table>
<?php
				}
?>
					<table width = 750 border = 0>
						<tr>
							<td width = 60 valign = bottom><font face = Arial size = 2>
								DS Part Number
							</font></td>
							<td width = 70 valign = bottom><font face = Arial size = 2>
								Parent Part Number
							</font></td>
							<td width = 70 valign = bottom><font face = Arial size = 2>
								Child Part(s)
							</font></td>
							<td width = 320 align = center valign = bottom><font face = Arial size = 2>
								Product/Part
							</font></td>		
							<td width = 40 valign = bottom><font face = Arial size = 2>
								QTY
							</font></td>	
							<td width = 50 valign = bottom><font face = Arial size = 2>
								Base Prices
							</font></td>	
						</tr>		
	
<?php
						$PN = $_GET['PN'];
						echo	'<input type = "hidden" name="PN" value = "'.$PN.'">';
						$query = "SELECT * FROM tblpartslist WHERE PartNumber = '$PN'";
						$result = mysql_query($query) or die (mysql_error());
						$row = mysql_fetch_array($result)
?>
						<tr>
							<td width = 60><b><font face = Arial size = 2>
								<input type="text" size="10" maxlength="10" name="DSPartNumber" value = "<?php echo $row['DSPartNumber'] ?>">
							</font></b></td>
							<td width = 70><b><font face = Arial size = 2>
								<?php echo $row['PartNumber']; ?>
							</font></b></td>
							<td width = 70><b><font face = Arial size = 2>
							</font></b></td>
							<td width = 320><b><font color="#ff0000">
								<input type="text" size="50" maxlength="255" name="Description" value = "<?php echo $row['Description']; ?>">
							</font></b></font></td>		
							<td align = center width = 40><b><font face = Arial size = 2>
								<input type="text" size="5" maxlength="5" name="Quantity" value = "<?php echo $row['Quantity']; ?>">
							</font></b></td>	
							<td width = 50><b><font face = Arial size = 2>
								<input type="text" size="10" maxlength="10" name="ListPrice" value = "<?php echo $row['ListPrice']; ?>">
							</font><b></td>	
						</tr>	
<?php		
						$childpart1 = $row['ChildPart1'];
						$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
						$child1queryresult = mysql_query($child1query) or die (mysql_error());
						$child1 = mysql_fetch_array($child1queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child1['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<input type="text" size="11" maxlength="11" name="ChildPart1" value = "<?php echo $child1['PartNumber']; ?>">
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child1['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child1['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
						$childpart2 = $row['ChildPart2'];
						$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
						$child2queryresult = mysql_query($child2query) or die (mysql_error());
						$child2 = mysql_fetch_array($child2queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child2['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<input type="text" size="11" maxlength="11" name="ChildPart2" value = "<?php echo $child2['PartNumber']; ?>">
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child2['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child2['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php	
						$childpart3 = $row['ChildPart3'];
						$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
						$child3queryresult = mysql_query($child3query) or die (mysql_error());
						$child3 = mysql_fetch_array($child3queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child3['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<input type="text" size="11" maxlength="11" name="ChildPart3" value = "<?php echo $child3['PartNumber']; ?>">
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child3['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child3['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php		
						$childpart4 = $row['ChildPart4'];
						$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
						$child4queryresult = mysql_query($child4query) or die (mysql_error());
						$child4 = mysql_fetch_array($child4queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child4['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<input type="text" size="11" maxlength="11" name="ChildPart4" value = "<?php echo $child4['PartNumber']; ?>">
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child4['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child4['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php	
						$childpart5 = $row['ChildPart5'];
						$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
						$child5queryresult = mysql_query($child5query) or die (mysql_error());
						$child5 = mysql_fetch_array($child5queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child5['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<input type="text" size="11" maxlength="11" name="ChildPart5" value = "<?php echo $child5['PartNumber']; ?>">
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child5['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child5['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php	
						$childpart6 = $row['ChildPart6'];
						$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
						$child6queryresult = mysql_query($child6query) or die (mysql_error());
						$child6 = mysql_fetch_array($child6queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child6['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<input type="text" size="11" maxlength="11" name="ChildPart6" value = "<?php echo $child6['PartNumber']; ?>">
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child6['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child6['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php	
						$childpart7 = $row['ChildPart7'];
						$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
						$child7queryresult = mysql_query($child7query) or die (mysql_error());
						$child7 = mysql_fetch_array($child7queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child7['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<input type="text" size="11" maxlength="11" name="ChildPart7" value = "<?php echo $child7['PartNumber']; ?>">
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child7['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child7['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php	
						$childpart8 = $row['ChildPart8'];
						$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
						$child8queryresult = mysql_query($child8query) or die (mysql_error());
						$child8 = mysql_fetch_array($child8queryresult)
?>
					<tr>
						<td><font face = Arial size = 2>
							<?php echo $child8['DSPartNumber']; ?>
						</font></td>
						<td><font face = Arial size = 2>
						</font></td>
						<td><font face = Arial size = 2>
							<input type="text" size="11" maxlength="11" name="ChildPart8" value = "<?php echo $child8['PartNumber']; ?>">
						</font></td>
						<td><font face = Arial size = 2>
							<?php echo $child8['Description']; ?>
						</font></td>		
						<td><font face = Arial size = 2>
							<?php echo $child8['Quantity']; ?>
						</font></td>	
						<td><font face = Arial size = 2>
							0.00
						</font></td>	
					</tr>			
<?php	
					$childpart9 = $row['ChildPart9'];
					$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
					$child9queryresult = mysql_query($child9query) or die (mysql_error());
					$child9 = mysql_fetch_array($child9queryresult)
?>
					<tr>
						<td><font face = Arial size = 2>
							<?php echo $child9['DSPartNumber']; ?>
						</font></td>
						<td><font face = Arial size = 2>
						</font></td>
						<td><font face = Arial size = 2>
							<input type="text" size="11" maxlength="11" name="ChildPart9" value = "<?php echo $child9['PartNumber']; ?>">
						</font></td>
						<td><font face = Arial size = 2>
							<?php echo $child9['Description']; ?>
						</font></td>		
						<td><font face = Arial size = 2>
							<?php echo $child9['Quantity']; ?>
						</font></td>	
						<td><font face = Arial size = 2>
							0.00
						</font></td>	
					</tr>			
<?php		
					$childpart10 = $row['ChildPart10'];
					$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
					$child10queryresult = mysql_query($child10query) or die (mysql_error());
					$child10 = mysql_fetch_array($child10queryresult)
?>
					<tr>
						<td><font face = Arial size = 2>
							<?php echo $child10['DSPartNumber']; ?>
						</font></td>
						<td><font face = Arial size = 2>
						</font></td>
						<td><font face = Arial size = 2>
							<input type="text" size="11" maxlength="11" name="ChildPart10" value = "<?php echo $child10['PartNumber']; ?>">
						</font></td>
						<td><font face = Arial size = 2>
							<?php echo $child10['Description']; ?>
						</font></td>		
						<td><font face = Arial size = 2>
							<?php echo $child10['Quantity']; ?>
						</font></td>	
					<td><font face = Arial size = 2>
						<?php echo $child10['ListPrice']; ?>
					</font></td>	
				</tr>			
<?php		
				$childpart11 = $row['ChildPart11'];
				$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
				$child11queryresult = mysql_query($child11query) or die (mysql_error());
				$child11 = mysql_fetch_array($child11queryresult)
?>
				<tr>
					<td><font face = Arial size = 2>
						<?php echo $child11['DSPartNumber']; ?>
					</font></td>
					<td><font face = Arial size = 2>
					</font></td>
					<td><font face = Arial size = 2>
						<input type="text" size="11" maxlength="11" name="ChildPart11" value = "<?php echo $child11['PartNumber']; ?>">
					</font></td>
					<td><font face = Arial size = 2>
						<?php echo $child11['Description']; ?>
					</font></td>		
					<td><font face = Arial size = 2>
						<?php echo $child11['Quantity']; ?>
					</font></td>	
					<td><font face = Arial size = 2>
						0.00
					</font></td>	
				</tr>			
<?php
				$childpart12 = $row['ChildPart12'];
				$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
				$child12queryresult = mysql_query($child12query) or die (mysql_error());
				$child12 = mysql_fetch_array($child12queryresult)
?>
				<tr>
					<td><font face = Arial size = 2>
						<?php echo $child12['DSPartNumber']; ?>
					</font></td>
					<td><font face = Arial size = 2>
					</font></td>
					<td><font face = Arial size = 2>
						<input type="text" size="11" maxlength="11" name="ChildPart12" value = "<?php echo $child12['PartNumber']; ?>">
					</font></td>
					<td><font face = Arial size = 2>
						<?php echo $child12['Description']; ?>
					</font></td>		
					<td><font face = Arial size = 2>
						<?php echo $child12['Quantity']; ?>
					</font></td>	
					<td><font face = Arial size = 2>
						0.00
					</font></td>	
				</tr>		
				<tr>
					<td colspan = 6>
						<div align="center"><hr width="100%"></div>
					</td>
			</tr>
			<tr>
 				<td>
 					<input type="submit" value="Save Changes" name="Save">
				</td>
			</tr>
			</table>
			</form>
			<table width="750">
			<tr>
				<td>
					<button onClick="window.location='pricelist.php'">Back to Price List</button>
				</td>
			</tr>
			</table>

<?php
			}else
			{
?>				
				<table width = 750 border = 0>
					<tr>
						<td width = 60 valign = bottom><font face = Arial size = 2>
							DS Part Number
						</font></td>
						<td width = 70 valign = bottom><font face = Arial size = 2>
							Parent Part Number
						</font></td>
						<td width = 70 valign = bottom><font face = Arial size = 2>
							Child Part(s)
						</font></td>
						<td width = 320 align = center valign = bottom><font face = Arial size = 2>
							Product/Part
						</font></td>		
						<td width = 40 valign = bottom><font face = Arial size = 2>
							QTY
						</font></td>	
						<td width = 50 valign = bottom><font face = Arial size = 2>
							Base Prices
						</font></td>	
					</tr>			
<?php
					$PN = $_GET['PN'];
					echo	'<input type = "hidden" name="PN" value = "'.$PN.'">';
					$query = "SELECT * FROM tblpartslist WHERE PartNumber = '$PN'";
					$result = mysql_query($query) or die (mysql_error());
					$row = mysql_fetch_array($result)
?>
					<tr>
						<td><b><font face = Arial size = 2>
							<?php echo $row['DSPartNumber'] ?>
						</font></b></td>
						<td><b><font face = Arial size = 2>
							<?php echo $row['PartNumber']; ?>
						</font></b></td>
						<td><b><font face = Arial size = 2>
						</font></b></td>
						<td><b><font color="#ff0000">
							<?php echo $row['Description']; ?>
						</font></b></font></td>		
						<td align = center><b><font face = Arial size = 2>
							<?php echo $row['Quantity']; ?>
						</font></b></td>	
						<td><b><font face = Arial size = 2>
							<?php echo $row['ListPrice']; ?>
						</font><b></td>	
					</tr>	
<?php		
					if($row['ChildPart1'] <> 0)
					{		
						$childpart1 = $row['ChildPart1'];
						$child1query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart1'";
						$child1queryresult = mysql_query($child1query) or die (mysql_error());
						$child1 = mysql_fetch_array($child1queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child1['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child1['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child1['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child1['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart2'] <> 0)
					{		
						$childpart2 = $row['ChildPart2'];
						$child2query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart2'";
						$child2queryresult = mysql_query($child2query) or die (mysql_error());
						$child2 = mysql_fetch_array($child2queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child2['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child2['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child2['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child2['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart3'] <> 0)
					{		
						$childpart3 = $row['ChildPart3'];
						$child3query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart3'";
						$child3queryresult = mysql_query($child3query) or die (mysql_error());
						$child3 = mysql_fetch_array($child3queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child3['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child3['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child3['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child3['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart4'] <> 0)
					{		
						$childpart4 = $row['ChildPart4'];
						$child4query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart4'";
						$child4queryresult = mysql_query($child4query) or die (mysql_error());
						$child4 = mysql_fetch_array($child4queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child4['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child4['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child4['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child4['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart5'] <> 0)
					{		
						$childpart5 = $row['ChildPart5'];
						$child5query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart5'";
						$child5queryresult = mysql_query($child5query) or die (mysql_error());
						$child5 = mysql_fetch_array($child5queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child5['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child5['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child5['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child5['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart6'] <> 0)
					{		
						$childpart6 = $row['ChildPart6'];
						$child6query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart6'";
						$child6queryresult = mysql_query($child6query) or die (mysql_error());
						$child6 = mysql_fetch_array($child6queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child6['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child6['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child6['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child6['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart7'] <> 0)
					{		
						$childpart7 = $row['ChildPart7'];
						$child7query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart7'";
						$child7queryresult = mysql_query($child7query) or die (mysql_error());
						$child7 = mysql_fetch_array($child7queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child7['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child7['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child7['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child7['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart8'] <> 0)
					{		
						$childpart8 = $row['ChildPart8'];
						$child8query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart8'";
						$child8queryresult = mysql_query($child8query) or die (mysql_error());
						$child8 = mysql_fetch_array($child8queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child8['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child8['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child8['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child8['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart9'] <> 0)
					{		
						$childpart9 = $row['ChildPart9'];
						$child9query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart9'";
						$child9queryresult = mysql_query($child9query) or die (mysql_error());
						$child9 = mysql_fetch_array($child9queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child9['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child9['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child9['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child9['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart10'] <> 0)
					{		
						$childpart10 = $row['ChildPart10'];
						$child10query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart10'";
						$child10queryresult = mysql_query($child10query) or die (mysql_error());
						$child10 = mysql_fetch_array($child10queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child10['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child10['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child10['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child10['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								<?php echo $child10['ListPrice']; ?>
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart11'] <> 0)
					{		
						$childpart11 = $row['ChildPart11'];
						$child11query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart11'";
						$child11queryresult = mysql_query($child11query) or die (mysql_error());
						$child11 = mysql_fetch_array($child11queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child11['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child11['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child11['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child11['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>			
<?php
					}
					if($row['ChildPart12'] <> 0)
					{		
						$childpart12 = $row['ChildPart12'];
						$child12query = "SELECT * FROM tblchildparts WHERE PartNumber = '$childpart12'";
						$child12queryresult = mysql_query($child12query) or die (mysql_error());
						$child12 = mysql_fetch_array($child12queryresult)
?>
						<tr>
							<td><font face = Arial size = 2>
								<?php echo $child12['DSPartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child12['PartNumber']; ?>
							</font></td>
							<td><font face = Arial size = 2>
								<?php echo $child12['Description']; ?>
							</font></td>		
							<td><font face = Arial size = 2>
								<?php echo $child12['Quantity']; ?>
							</font></td>	
							<td><font face = Arial size = 2>
								0.00
							</font></td>	
						</tr>
<?php		
					}		
?>		
				<tr>
					<td colspan = 6>
						<div align="center"><hr width="100%"></div>
					</td>
				</tr>
			</table>	
<?php				
			}
	}
/*
***********************************************CHILD PART UPDATE*****************************************
*/
if((isset($_GET['update'])) && ($_GET['update']=="child") && (!isset($_GET['childpartnumber'])))
{
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table width = "500">
		<tr>
			<td width = "250">
				Enter Child Part Number to Edit:
			</td>
			<td>
				<input type="text" size="15" maxlength="15" name="childpartnumber">
				<?php echo	'<input type = "hidden" name="update" value="child">'; ?>
			</td>
		</tr>
		<tr>
			<td>
 				<input type="submit" value="Continue" name="continue">
 			</td>
 		</tr>				
	</table>
	</form>
<?php	
}
if(isset($_GET['childpartnumber']))
{
	$pn = $_GET['childpartnumber'];
	$getchildpart = "SELECT * FROM tblchildparts WHERE PartNumber = '$pn'";
	$resgetchildpart = mysql_query($getchildpart) or die (mysql_error());
	$childpart = mysql_fetch_array($resgetchildpart);
	//$lprice = $childpart['ListPrice'];	
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table width = "650" align = "center">
		<tr>
			<td>
 				Part AS CHILD:
 			</td>
 		</tr>
 	</table>
 	<table width = "550" align = "center">	
		<tr>
			<td>
				Part Number:
			</td>
			<td>
 				 <?php echo $childpart['PartNumber']; ?>
 			</td>
 		</tr>
 		<tr>
 			<td>
 				Part Description:
			</td>
 			<td>
 				 <input type="text" size="70" maxlength="200" name="description" value="<?php echo $childpart['Description']; ?>">
 			</td>
 		</tr>	 	
 		<tr>
 			<td>
 				Quantity:
			</td>
 			<td>
 				 <input type="text" size="12" maxlength="3" name="qty" value="<?php echo $childpart['Quantity']; ?>">
 			</td>
 		</tr>	
 		<tr>
 			<td>
 				List Price:
			</td>
 			<td>
 				 <input type="text" size="12" maxlength="12" name="lprice" value="$<?php echo $childpart['ListPrice']; ?>">
 			</td>
 		</tr> 		
		<tr>
			<td>
 				<input type="submit" value="Save" name="savechild">
 			</td>
 		</tr>				
	</table>
	</form>
<?php	
}
if((isset($_GET['savechild'])) && ($_GET['savechild'] == "Save"))
{	
?>
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table width = "650" align = "center">
		<tr>
			<td>
 				Part AS CHILD:
 			</td>
 		</tr>
 	</table>
 	<table width = "550" align = "center">	
		<tr>
			<td>
				Part Number:
			</td>
			<td>
 				 <?php echo $childpart['PartNumber']; ?>
 			</td>
 		</tr>
 		<tr>
 			<td>
 				Part Description:
			</td>
 			<td>
 				 <input type="text" size="70" maxlength="200" name="description" value="<?php echo $childpart['Description']; ?>">
 			</td>
 		</tr>	 	
 		<tr>
 			<td>
 				Quantity:
			</td>
 			<td>
 				 <input type="text" size="12" maxlength="3" name="qty" value="<?php echo $childpart['Quantity']; ?>">
 			</td>
 		</tr>	
 		<tr>
 			<td>
 				List Price:
			</td>
 			<td>
 				 <input type="text" size="12" maxlength="12" name="lprice" value="$<?php echo $childpart['ListPrice']; ?>">
 			</td>
 		</tr> 		
		<tr>
			<td>
 				<input type="submit" value="Save" name="savechild">
 			</td>
 		</tr>				
	</table>
	</form>
<?php	
}
include 'includes/closedb.php'; 
?>