<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td colspan="2" class="cspBodyHeading">Facility Lookup</td>
	</tr>
	<tr>
		<form id="lookupFacilityName" name="lookupFacilityName" onSubmit="sbmPortalSearch('lookupFacilityName', 'facilityName'); return false;">
			<td style="text-align: right;">Facility Name:</td>
			<td>
				<input type="text" name="srchString" onKeyup="sbmPortalSearch('lookupFacilityName', 'facilityName'); return false;" />
				<input type="submit" value="Search" />
			</td>
		</form>
	</tr>
	<tr>
		<form id="lookupCustNum" name="lookupCustNum" onSubmit="sbmPortalSearch('lookupCustNum', 'custNum'); return false;">
			<td style="text-align: right;">Customer Number:</td>
			<td>
				<input type="text" name="srchString" onKeyup="sbmPortalSearch('lookupCustNum', 'custNum'); return false;" />
				<input type="submit" value="Search" />
			</td>
		</form>
	</tr>
</table>