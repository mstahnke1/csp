
<?php
		if((isset($_GET['view']) && ($_GET['view'] == "print")))
		{
			include 'includes/db_close.inc.php';
		}
		else
		{
		?>
<table border="0">
  <tr>
  	<td align="center">
  	<?php
  	echo '<font face="Arial" size="2"><b>'.date("l, M. jS, Y").'<br>'.date("g:i:sa").'</b></font>';
  	?>
  	</td>
  </tr>
  <tr> 
    <td>
      <!-- Search Google -->
        <style type="text/css">
@import url(http://www.google.com/cse/api/branding.css);
</style>
<div class="cse-branding-bottom" style="background-color:#FFFFFF;color:#000000">
  <div class="cse-branding-form">
    <form action="http://www.google.com/cse" id="cse-search-box" target="_blank">
      <div>
        <input type="hidden" name="cx" value="partner-pub-6311950500981555:if19h0fxhz7" />
        <input type="hidden" name="ie" value="ISO-8859-1" />
        <input type="text" name="q" size="31" />
        <input type="submit" name="sa" value="Search" />
      </div>
    </form>
  </div>
  <div class="cse-branding-logo">
    <img src="http://www.google.com/images/poweredby_transparent/poweredby_FFFFFF.gif" alt="Google" />
  </div>
  <div class="cse-branding-text">
    Custom Search
  </div>
</div>
      <!-- Search Google -->
    </td>
  </tr>
  <tr>
    <td align="center"><font face="Arial" size="2"><u><strong>HomeFree Directory</strong></u></font></td>
  </tr>
  <tr> 
    <td align="center" width="160">
  </tr>
  <tr>
    <td align="center" width="160">
		<table>
		<?php
		$query7 = "SELECT f_name, l_name, ext_num, mobile, email FROM employees WHERE active = 0 ORDER BY l_name";
		$result7 = mysql_query($query7, $conn) or die (mysql_error());
		while($row7 = @mysql_fetch_array($result7)){
		echo '<tr><td width="100"><font face="Arial" size="2"><DIV onMouseover="ddrivetip(\'Mobile: ' . formatPhone($row7['mobile']) . '<br>Email: ' . $row7['email'] . '\', \'#EFEFEF\', 250)"; onMouseout="hideddrivetip()">' . $row7['l_name'] . ', ' . $row7['f_name'] . '</td><td>&nbsp;</td><td><font face="Arial" size="2">' . $row7['ext_num'] . '</div></font></td></tr>';
		}
		include 'includes/db_close.inc.php';
 		?>
		</table>
    </td>
  </tr>
</table>
<?php
		}
	?>
</body>
</html>