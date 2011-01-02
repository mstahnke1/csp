<?php
$pageName = basename($_SERVER['PHP_SELF']);
$pageClassEnd = strpos($pageName, "_");
$menuClass = substr($pageName, 0, $pageClassEnd);
?>
<a href="JavaScript:void(0);"><div class="menuBox box1" <?php if($menuClass == "cspUserHome") { echo 'style="border:2px solid black;"'; } ?> onClick="window.location='cspUserHome_Dashboard.php'">Home</div></a>
<a href="JavaScript:void(0);"><div class="menuBox box2" <?php if($menuClass == "cspUserSupport") { echo 'style="border:2px solid black;"'; } ?> onClick="window.location='cspUserSupport_Home.php'">Support</div></a>
<a href="JavaScript:void(0);"><div class="menuBox box3" <?php if($menuClass == "cspUserSales") { echo 'style="border:2px solid black;"'; } ?> onClick="window.location='cspUserSales_Home.php'">Sales</div></a>
<a href="JavaScript:void(0);"><div class="menuBox box4" <?php if($menuClass == "cspAdmin") { echo 'style="border:2px solid black;"'; } ?> onClick="self.location.href='cspAdmin_Home.php'">Admin</div></a>