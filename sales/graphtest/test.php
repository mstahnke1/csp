﻿<?php
        $conn11 = mysql_connect('hf01sql', 'drewd', 'Q1w2e3') or die(mysql_error());
				mysql_select_db('drewd_graphtestdb');
				
        // Contstruct the data lines for ProductX, ProductY and Product Z
        $sql = "SELECT * FROM salesPerYear";
        $result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['productx'];

/*
        $dataNum = 1;
        while ( $row = mysql_fetch_array($result,MYSQL_ASSOC) ) {
                $dataLines[] = "data".$dataNum."series1: ".$row["productx"];
                $dataLines[] = "data".$dataNum."series2: ".$row["producty"];
                $dataLines[] = "data".$dataNum."series3: ".$row["productz"];
                $dataNum++;
        }
*/        
?>