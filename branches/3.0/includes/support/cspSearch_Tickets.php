<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td colspan="2" class="cspBodyHeading">Ticket Lookup</td>
	</tr>
	<tr>
		<form id="lookupTicket" name="lookupTicket" onSubmit="sbmPortalSearch('lookupFacilityName'); return false;">
			<td style="text-align: right;">Ticket Number:</td>
			<td>
				<input type="text" name="srchString" />
				<input type="hidden" name="srchType" value="ticket" />
				<input type="submit" value="Search" />
			</td>
		</form>
	</tr>
</table>