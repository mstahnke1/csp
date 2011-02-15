<?php
include 'includes/config.php';
include 'includes/opendb.php';
require 'includes/functions.inc.php';
require_once 'Spreadsheet/Excel/Writer.php';
	$query54 = "SELECT * FROM tblproactivequestions WHERE Type = 1";
	$result54 = mysql_query($query54) or die (mysql_error());
?>
	<form method="GET" NAME="example" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td>
					FROM:
				</td>
				<td>
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date1" VALUE="" SIZE=25>
				</td>
				<td>
					<A HREF="#"
 					onClick="cal.select(document.forms['example'].date1,'anchor1','yyyy/MM/dd hh:mm:ss'); return false;"
 					NAME="anchor1" ID="anchor1"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
				</td>
				<td>
					TO:
				</td>	
				<td>
					<SCRIPT LANGUAGE="JavaScript" SRC="/CalendarPopup.js"></SCRIPT>
					<SCRIPT LANGUAGE="JavaScript">
					var cal = new CalendarPopup();
					</SCRIPT>
					<INPUT TYPE="text" NAME="date2" VALUE="" SIZE=25>
				</td>
				<td>
					<A HREF="#"
 					onClick="cal.select(document.forms['example'].date2,'anchor2','yyyy/MM/dd hh:mm:ss'); return false;"
 					NAME="anchor2" ID="anchor2"><img src="../images/calendar_icon.png" border="0" alt="select"/></A>
				</td>	
			</tr>
			<tr>
				<td colspan="5">
					Questions Included in the Report:
				</td>
			</tr>
<?php
			while($row54 = mysql_fetch_array($result54))
			{
?>				
				<tr>
					<td colspan="5">
						<input type="checkbox" name="<?php echo $row54['ID']; ?>" value="1" checked><?php echo $row54['Question']; ?>
					</td>
				</tr>
<?php			
			}
?>
		</table>
		<table>
			<tr>
				<td>
					<table>
						<tr>
							<td>
								Filter Results (FROM):
							</td>
						</tr>
						<tr>
							<td>
								<select name="filterfrom">
									<option value = "0">NONE</option>
									<option value = "1">Needs Improvment</option>
									<option value = "2">Below Average</option>
									<option value = "3">Average</option>
									<option value = "4">Above Average</option>
									<option value = "5">Very Impressive</option>
									<option value = "6">Outstanding</option>
								</select>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table>
						<tr>
							<td>
								Filter Results (TO):
							</td>
						</tr>
						<tr>
							<td>
								<select name="filterto">
									<option value = "0">NONE</option>
									<option value = "1">Needs Improvment</option>
									<option value = "2">Below Average</option>
									<option value = "3">Average</option>
									<option value = "4">Above Average</option>
									<option value = "5">Very Impressive</option>
									<option value = "6">Outstanding</option>
								</select>
							</td>
						</tr>
					</table>
				</td>
			</tr>
<?php
			echo	'<input type = "hidden" name="view" value = "rptadvpro">';
?>						
			<tr>
				<td>
					<input type="submit" value="Run" name="run">
				</td>
			</tr>			
		</table>
	</form>			
			
