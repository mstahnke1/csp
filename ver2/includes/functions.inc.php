<?php

function formatPhone($phone = '', $convert = false, $trim = true)
{
	// If we have not entered a phone number just return empty
	if (empty($phone)) {
		return '';
	}
	
	// Strip out any extra characters that we do not need only keep letters and numbers
	$phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);
	
	// Do we want to convert phone numbers with letters to their number equivalent?
	// Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
	if ($convert == true) {
		$replace = array('2'=>array('a','b','c'),
				 '3'=>array('d','e','f'),
			         '4'=>array('g','h','i'),
				 '5'=>array('j','k','l'),
                                 '6'=>array('m','n','o'),
				 '7'=>array('p','q','r','s'),
				 '8'=>array('t','u','v'),								 '9'=>array('w','x','y','z'));
		
		// Replace each letter with a number
		// Notice this is case insensitive with the str_ireplace instead of str_replace 
		foreach($replace as $digit=>$letters) {
			$phone = str_ireplace($letters, $digit, $phone);
		}
	}
	
	// If we have a number longer than 11 digits cut the string down to only 11
	// This is also only ran if we want to limit only to 11 characters
	if ($trim == true && strlen($phone)>11) {
		$phone = substr($phone, 0, 11);
	}						 
	
	// Perform phone number formatting here
	if (strlen($phone) == 7) {
		return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
	} elseif (strlen($phone) == 10) {
		return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone);
	} elseif (strlen($phone) == 11) {
		return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1($2) $3-$4", $phone);
	}
	
	// Return original phone if not 7, 10 or 11 digits long
	return $phone;
}

function fix_apos($needle, $replace, $haystack) { 
  for ($i=0; $i < strlen($haystack); $i++) { 
    if ($haystack["$i"] == $needle) { 
      $haystack = substr_replace($haystack, $replace, $i, strlen($needle)); 
  	  $i++;
    } 
  } 
  return $haystack; 
}

function dateDiff($dateTimeBeginDateTime,$dateTimeEndDateTime) {
			//Take start date/time and put it into seconds
      $dateTimeBegin = strtotime($dateTimeBeginDateTime);
      
      //Take end date/time and put it into seconds
      $dateTimeEnd = strtotime($dateTimeEndDateTime);
      
      $dif = $dateTimeEnd - $dateTimeBegin;

			$days = floor($dif / 86400);
			$temp_remainder = $dif - ($days * 86400);

      $hours = floor($temp_remainder / 3600);
      $temp_remainder = $temp_remainder - ($hours * 3600);
       
      $minutes = floor($temp_remainder / 60);
      $temp_remainder = $temp_remainder - ($minutes * 60);
       
      $seconds = $temp_remainder;
         
      // leading zero's - not bothered about hours
      $min_lead=':';
     if($minutes <=9)
        $min_lead .= '0';
      $sec_lead=':';
     if($seconds <=9)
        $sec_lead .= '0';
       
  // difference/duration returned as Hours:Mins:Secs e.g. 01:29:32
	//return $hours.$min_lead.$minutes.$sec_lead.$seconds;
	return $days.' Days '.$hours.' Hours '.$minutes.' Minutes '.$seconds.' Seconds';    
}

function findexts($filename)
{
	$filename = strtolower($filename) ;
	$exts = split("[/\\.]", $filename) ;
	$n = count($exts)-1;
	$exts = $exts[$n];
	return $exts;
} 
/*
function ldap_authenticate( $p_user_id, $p_password ){
  if ($p_password == "")
    return false;
  
  if($ldap['type'] == "ActiveDirectory") {
  	$ldap_root_dn = $ldap['dn'];
  	$ldap_host = $ldap['host'];
  	$ldap_port = $ldap['port'];
  	$ldap_bind_dn = $ldap['bind_dn'];
  	$ds = ldap_connect($ldap_host, $ldap_port) or die('Could Not Connect to Server');
  	$authenticated = false;
  	if(@ldap_bind($ds,$p_user_id.$ldap_bind_dn,$p_password))
  	  $authenticated = true;

  	return $authenticated;
	}
}
*/
?>