<?php
$odbc = odbc_connect ('Support_DB', '', '') or die('Could Not Connect to Support Database!');

if(!function_exists('odbc_fetch_array'))
{
  function odbc_fetch_array($result, $rownumber=-1)
  {
      if (PHP_VERSION > '4.1')
      {
          if ($rownumber < 0)
          {
              odbc_fetch_into($result, $rs);
          }
          else
          {
              odbc_fetch_into($result, $rs, $rownumber);
          }
      }
      else
      {
          odbc_fetch_into($result, $rownumber, $rs);
      }
      
      $rs_assoc = Array();
  
      foreach ($rs as $key => $value)
      {
          $rs_assoc[odbc_field_name($result, $key+1)] = $value;
      }
       return $rs_assoc;
  }
}

?>