<?php
	include '../includes/config.inc.php';
	include '../includes/db_connect.inc.php';
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

<chart>
	<axis_category skip="0" font='arial' bold='true' size='6' color='000000' alpha='100' orientation='horizontal' />
	<axis_value min='0' max='4' steps='15' prefix='' suffix='' decimals='2' decimal_char='.' separator='' show_min='true' font='arial' bold='true' size='6' color='000000' alpha='75' orientation='horizontal' />
	<legend_label layout='horizontal' bullet='square' font='arial' bold='false' size='6' color='000000' alpha='100=' />
	<legend_rect x='135' y='220' width='300' height='20' margin='0' fill_color='000000' fill_alpha='7' line_color='000000' line_alpha='0' line_thickness='0' /> 		
	<chart_rect x='120' y='40' width='325' height='150' positive_color='ffffff' positive_alpha='50' negative_color='000000' negative_alpha='10' />
	<chart_data>
	      <row>
  	       <null/>
	         <string>Instructor\rProfessional\rManor</string>
    	     <string>Instructor\rKnowledge</string>
      	   <string>Clear\rContent</string>
	         <string>Instructor\rQuestion\rResponse</string>
  	       <string>Length of\rTraining</string>
    	  </row>
<?php
			if($f_id1 <> -1)
			{   
?>	
      <row>
         <string><?php echo $row2['FacilityName']; ?></string>
         <number><?php echo $row1['manor']; ?></number>
         <number><?php echo $row1['knowledge']; ?></number>
         <number><?php echo $row1['ability']; ?></number>    
         <number><?php echo $row1['respond']; ?></number>
         <number><?php echo $row1['length']; ?></number>                
      </row>
<?php
			}
			if($f_id2 <> -1)
			{   
?>				   
      	<row>
      	   <string><?php echo $row4['FacilityName']; ?></string>
    	     <number><?php echo $row3['manor']; ?></number>
        	 <number><?php echo $row3['knowledge']; ?></number>
        	 <number><?php echo $row3['ability']; ?></number>    
  	       <number><?php echo $row3['respond']; ?></number>
    	     <number><?php echo $row3['length']; ?></number>  
      	</row>
<?php
			}
			if($f_id3 <> -1)
			{ 				
?>				      	
	      <row>
  	      <string><?php echo $row6['FacilityName']; ?></string>
         	<number><?php echo $row5['manor']; ?></number>
  	      <number><?php echo $row5['knowledge']; ?></number>
    	    <number><?php echo $row5['ability']; ?></number>    
      	  <number><?php echo $row5['respond']; ?></number>
        	<number><?php echo $row5['length']; ?></number>
      	</row>
<?php
			}      
?>
      <row>
         <string>All Customers</string>
         <number><?php echo $row7['manor']; ?></number>
         <number><?php echo $row7['knowledge']; ?></number>
         <number><?php echo $row7['ability']; ?></number>    
         <number><?php echo $row7['respond']; ?></number>
         <number><?php echo $row7['length']; ?></number>
      </row>  
      <row>
         <string>Threshold</string>
         <number>3.5</number>
         <number>3.5</number>
         <number>3.5</number>
         <number>3.5</number>
         <number>3.5</number>
      </row>                 
  </chart_data>
 	<chart_type>
		<string>column</string>
<?php		
		if($f_id1 <> -1)
		{
?>			
			<string>column</string>
<?php		
		}
		if($f_id2 <> -1)
		{
?>			
			<string>column</string>
<?php
		}
		if($f_id3 <> -1)
		{
?>			
			<string>column</string>
<?php			
		}
?>			
		<string>line</string>
	</chart_type>
	<draw>
		<text transition='dissolve' delay='0' duration='0.5' color='000000' alpha='100' font='Arial' rotation='0' bold='true' size='10' x='45' y='-10' width='445' height='40' h_align='center' v_align='bottom'>Customer Training Evaluation Statistics</text>
		<text color='000000' alpha='100' font='arial' rotation='-90' bold='true' size='12' x='50' y='250' width='300' height='150' h_align='center' v_align='top'>Avg Score</text>
	</draw>  
	<series_color>
		<color>8064A2</color>
		<color>9BBB59</color>
		<color>C0504D</color>
		<color>4F81BD</color>
		<color>000000</color>
	</series_color>
</chart>
