<!-- START Customer Information Dashboard Module -->
<?php
include('includes/config.inc.php');
include('includes/db_connect.inc.php');
include_once('includes/functions.inc.php');
if(isset($_GET['custID'])) {
	$custID = $_GET['custID'];
	$qryCustInfo1 = "SELECT tblFacilities.*, employees.f_name AS repFirstName, employees.l_name AS repLastName 
									FROM tblFacilities 
									LEFT JOIN tblSalesRepByTerritories ON tblFacilities.CountryCode = tblSalesRepByTerritories.CountryCode 
									LEFT JOIN employees ON tblSalesRepByTerritories.SalesRepID = employees.id 
									WHERE tblFacilities.CustomerNumber = '$custID' 
									AND tblSalesRepByTerritories.CountryCode = (SELECT CountryCode FROM tblFacilities WHERE CustomerNumber = '$custID') 
									AND tblSalesRepByTerritories.StateOrProvinceCode = (SELECT StateOrProvinceCode FROM tblFacilities WHERE CustomerNumber = '$custID')";
	$rstCustInfo1 = mysql_query($qryCustInfo1) or die(mysql_error());
	$rowCustInfo1 = mysql_fetch_array($rstCustInfo1);
	$salesRep = $rowCustInfo1['repFirstName'] . " " . $rowCustInfo1['repLastName'];
	$TypeOfSale = $rowCustInfo1['TypeOfSale'];
	$qrySaleSource = "SELECT name FROM distributors WHERE id = '$TypeOfSale'";
	$rstSaleSource = mysql_query($qrySaleSource) or die(mysql_error());
	$rowSaleSource = mysql_fetch_array($rstSaleSource);
	$saleSource = $rowSaleSource['name'];
}
?>

<div class="cspDashModule">
	<table class="cspDashRow" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="cspBodyHeading">Facility Information</td>
		</tr>
		<tr>
			<td>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Customer Number:</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowCustInfo1['CustomerNumber']; ?></span></div>
			</td>
		</tr>
		<tr>
			<td>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Facility Name:</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowCustInfo1['FacilityName']; ?></span></div>
			</td>
		</tr>
		<tr>
			<td>
				<?php if(!is_null($rowCustInfo1['FacilityNameOther']) || $rowCustInfo1['FacilityNameOther'] != "") {
					?>
					<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Alternate Name:</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowCustInfo1['FacilityNameOther']; ?></span></div>
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Street Address:</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowCustInfo1['StreetAddress']; ?></span></div>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">&nbsp</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowCustInfo1['City'] . ", " . $rowCustInfo1['StateOrProvinceCode'] . " " . $rowCustInfo1['PostalCode']; ?></span></div>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">&nbsp</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $rowCustInfo1['CountryCode']; ?></span></div>
			</td>
		</tr>
		<tr>
			<td>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Phone Number:</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo formatPhone($rowCustInfo1['PhoneNumber']); ?></span></div>
			</td>
		</tr>
		<tr>
			<td>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Fax Number:</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo formatPhone($rowCustInfo1['FaxNumber']); ?></span></div>
			</td>
		</tr>
		<tr>
			<td>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Sales Rep:</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $salesRep; ?></span></div>
			</td>
		</tr>
		<tr>
			<td>
				<div><span style="display:inline-block; width:35%; vertical-align:top; text-align:right; padding:1px;">Source of Sale:</span><span style="display:inline-block; width:62%; vertical-align:top; float:right; padding:1px 1px 1px 5px"><?php echo $saleSource; ?></span></div>
			</td>
		</tr>
	</table>
</div>

<?php
include 'includes/db_close.inc.php';
?>
<!-- END Customer Information Dashboard Module -->