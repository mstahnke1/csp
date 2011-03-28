<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Shipment Tracking</td>
		</tr>
		<tr>
			<td>
				<div>
					<form name="searchParams" id="searchParams" onSubmit="srchShipments('searchParams'); return false;">
						<div>
							Reference:<br />
							<input name="refNum" type="text" />
						</div>
						<span style="display:inline-block;">
							Date From:<br>
							<INPUT TYPE="text" NAME="dateFrom" VALUE="" SIZE=10 />
						</span>
						<span style="display:inline-block; vertical-align:bottom;">
							<A HREF="#" onClick="cal.select(document.forms['searchParams'].dateFrom,'anchor1','yyyy-MM-dd'); return false;" NAME="anchor1" ID="anchor1"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
							<SCRIPT LANGUAGE="JavaScript" SRC="js/calendarpopup.js"></SCRIPT>
							<SCRIPT LANGUAGE="JavaScript">
								var cal = new CalendarPopup();
							</SCRIPT>
						</span>
						<span style="display:inline-block;">
							Date To:<br>
							<INPUT TYPE="text" NAME="dateTo" VALUE="" SIZE=10 />
						</span>
						<span style="display:inline-block; vertical-align:bottom;">
							<A HREF="#" onClick="cal.select(document.forms['searchParams'].dateTo,'anchor2','yyyy-MM-dd'); return false;" NAME="anchor2" ID="anchor2"><img src="images/calendar_icon.png" border="0" alt="Select" /></a>
							<SCRIPT LANGUAGE="JavaScript" SRC="js/calendarpopup.js"></SCRIPT>
							<SCRIPT LANGUAGE="JavaScript">
								var cal = new CalendarPopup();
							</SCRIPT>
						</span>
						<div>
							<input name="submit" type="submit" value="Search">
						</div>
					</form>
				</div>
				<div id="trackDetails"></div>
			</td>
		</tr>
	</table>
</div>