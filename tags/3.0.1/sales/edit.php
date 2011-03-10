<?php
$query = "SELECT title
FROM tblfacilitygeneralinfo, epc_calendar
WHERE type=15 AND FacilityID = Cust_Num";