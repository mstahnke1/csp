<div class="menuBox box1" <?php if(basename($_SERVER['PHP_SELF'], ".php") == "cspUserHome_Dashboard") { echo 'style="border:2px solid black;"'; } ?> onClick="window.location='cspUserHome_Dashboard.php'">Home</div>
<div class="menuBox box2" <?php if(basename($_SERVER['PHP_SELF'], ".php") == "cspUserSupport_Home") { echo 'style="border:2px solid black;"'; } ?> onClick="window.location='cspUserSupport_Home.php'">Support</div>
<div class="menuBox box3" <?php if(basename($_SERVER['PHP_SELF'], ".php") == "cspUserSales_Home") { echo 'style="border:2px solid black;"'; } ?> onClick="window.location='cspUserSales_Home.php'">Sales</div>
<div class="menuBox box4" <?php if(basename($_SERVER['PHP_SELF'], ".php") == "cspAdmin_Home") { echo 'style="border:2px solid black;"'; } ?> onClick="self.location.href='cspAdmin_Home.php'">Admin</div>