<?php
//Dummy data
$data = array(73,74,75,76,78,79,80,81,82,83,84,85,86,87);

//Our 'stepping' variable
$g = 0;

//Our rowcount
$rowcount = 0;

echo "<table cellspacing='0'>\r";
    for ($i=0; $i<count($data); ) {

        $rowcount++;
        echo "    <tr>\r"; //New row

        $g = $i + 3; //Set our nested limit
        for( ; $i<$g; $i++) { //nested for loop

            if (!isset($data[$i])) { //Allow us to break on incomplete rows
                break;
            }

            echo "        <td style='border: 1px #000 solid;'>\r"; //Out put a cell
            echo "            <p>Row $rowcount <br/> Cell: $i <br/> Data: $data[$i]</p>\r";
            echo "        </td>\r";
        }

        echo "    </tr> \r"; //End New Row
    }

echo "</table>\r";?>