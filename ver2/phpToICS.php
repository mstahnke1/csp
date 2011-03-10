<?php
$ticket_num = $_GET['ticket_num'];
$fuDate = $_GET['fuDate'];
$cust_name = $_GET['cust_name'];
header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=calendar.ics");
echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "PRODID:-//HomeFree Systems//NONSGML csPortal//EN\n";
echo "METHOD:PUBLISH\n"; // requied by Outlook
echo "BEGIN:VEVENT\n";
echo "UID:".date('Ymd').'T'.date('His')."-".rand()."-dmatek.com\n"; // required by Outlook
echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n"; // required by Outlook
echo "DTSTART:".$fuDate."T080000\n"; 
echo "SUMMARY:Follow Up with ".$cust_name."\n";
echo "DESCRIPTION: Follow up regarding ticket ".$ticket_num."\n";
echo "END:VEVENT\n";
echo "END:VCALENDAR\n";
?>