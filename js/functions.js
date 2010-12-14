function sbmFacilityLookup(frmStr){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser is not supported!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById("resultsDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	
	var srchString = document.forms['lookupFacilityName'].srchString.value;
	var srchType = document.forms['lookupFacilityName'].srchType.value;
	var queryString = "srchType=" + srchType + "&srchString=" + srchString;
	
	ajaxRequest.open("POST", "cspSearchResults.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	ajaxRequest.send(queryString); 
}