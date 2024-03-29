function sbmPortalSearch(frmStr, srchType){
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById("resultsDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	
	var srchString = document.forms[frmStr].srchString.value;
	var queryString = "srchType=" + srchType + "&srchString=" + srchString;
	
	ajaxRequest.open("POST", "cspSearchResults.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	ajaxRequest.send(queryString); 
}

function srchShipments(frmStr){
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById("trackDetails");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	
	var refNum = document.forms[frmStr].refNum.value;
	var dateFrom = document.forms[frmStr].dateFrom.value;
	var dateTo = document.forms[frmStr].dateTo.value;
	var queryString = "refNum=" + refNum + "&dateFrom=" + dateFrom + "&dateTo=" + dateTo;
	
	ajaxRequest.open("POST", "scripts/shipmentDetails.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString); 
}

function buildRpt(frmStr, pageStr, frmEle, frmVal){
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById("rptDetails");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	
	var ajaxDisplay = document.getElementById("rptDetails");
	ajaxDisplay.innerHTML = '<div style="text-align:center;"><img src="theme/default/images/loading.gif" /></div>';
	
	if(frmEle != "" && frmVal != "") {
		document.forms[frmStr].elements[frmEle].value = frmVal;
	}
	
	var dateFrom = document.forms[frmStr].dateFrom.value;
	var dateTo = document.forms[frmStr].dateTo.value;
	var custID = document.forms[frmStr].custID.value;
	var incRMA = document.forms[frmStr].incRMA.value;
	var hfEmployee = document.forms[frmStr].hfEmployee.value;
	var ticketStatus = document.forms[frmStr].ticketStatus.value;
	var callType = document.forms[frmStr].callType.value;
	var issueCat = document.forms[frmStr].issueCat.value;
	var queryString = "dateFrom=" + dateFrom + "&dateTo=" + dateTo + "&custID=" + custID + "&incRMA=" + incRMA + 
										"&hfEmployee=" + hfEmployee + "&ticketStatus=" + ticketStatus + "&callType=" + callType + "&issueCat=" + issueCat;
	
	ajaxRequest.open("POST", "includes/reports/" + pageStr, true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString); 
}

function updRmaDevice(deviceID, ticketID) {
	var auth = confirm("Remove device from RMA list?");
	if(auth) {
		if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
	  	ajaxRequest=new XMLHttpRequest();
	  } else {// code for IE6, IE5
			ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange=function() {
	  	if(ajaxRequest.readyState==4 && ajaxRequest.status==200) {
				var ajaxDisplay = document.getElementById("divRmaDeviceLst");
				ajaxDisplay.innerHTML = ajaxRequest.responseText;
			}
		}
		
		ajaxRequest.open("GET","scripts/rmaDeviceMgmt.php?deviceID="+deviceID+"&action=remove&ticketID="+ticketID,true);
		ajaxRequest.send();
	} else {
		var frmStr = "updDevice"+deviceID;
		document.forms[frmStr].device.checked=false;
	}
}

function getPage(pageURL, divID) {
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange=function() {
  	if(ajaxRequest.readyState==4 && ajaxRequest.status==200) {
			var ajaxDisplay = document.getElementById(divID);
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	
	ajaxRequest.open("GET",pageURL,true);
	ajaxRequest.send();
}

function getSysDetails(pageURL, divID, sysID) {
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange=function() {
  	if(ajaxRequest.readyState==4 && ajaxRequest.status==200) {
			var ajaxDisplay = document.getElementById(divID);
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	pageURL = pageURL+"?sysID="+sysID;
	
	ajaxRequest.open("GET",pageURL,true);
	ajaxRequest.send();
}

function fileDelConf() {
	var auth = confirm("Are you sure you want to REMOVE the selected files?");
	if(auth) {
		document.updFileList.submit();
	}
}

function sbmRmaDevice(frmStr, ticketID, deviceAction) {
	var frmName = document.forms[frmStr];
	if(frmName.serialNumber.value == "" || frmName.problemDesc.value == "" || frmName.warrantyStatus.value == "0") {
		alert("Must fill in all device RMA details to save");
		return false;
	}
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange=function() {
  	if(ajaxRequest.readyState==4 && ajaxRequest.status==200) {
			var ajaxDisplay = document.getElementById("divRmaDeviceLst");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			document.forms[frmStr].reset();
		}
	}
	
	if(document.forms[frmStr].chkCRP.checked == true) {
		var chkCRP = 1;
	} else {
		var chkCRP = 0;
	}
	var deviceType = document.forms[frmStr].deviceType.value;
	var serialNumber = document.forms[frmStr].serialNumber.value;
	var problemDesc = document.forms[frmStr].problemDesc.value;
	var warrantyStatus = document.forms[frmStr].warrantyStatus.value;
	var queryString = "deviceType=" + deviceType + "&serialNumber=" + serialNumber + "&problemDesc=" + problemDesc + "&warrantyStatus=" + warrantyStatus + "&chkCRP=" + chkCRP + "&ticketID=" + ticketID + "&action=" + deviceAction;
	
	ajaxRequest.open("POST", "scripts/rmaDeviceMgmt.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	ajaxRequest.send(queryString); 
}

function populateTxt(frmStr, eleStr, valStr) {
	document.forms[frmStr].elements[eleStr].value = valStr;
	hideDiv('issueCatMod');
}

function showDiv(divStr, imgID) {
	if (document.getElementById) {
		if(imgID != "") {
			var linkElement = document.getElementById("link_"+imgID);
			var imgElement = document.getElementById("img_"+imgID);
			imgElement.src="theme/default/images/iconContract.png";
			linkElement.setAttribute("onclick", "hideDiv('"+divStr+"','"+imgID+"');");
		}
		document.getElementById(divStr).style.display = 'block';
	}
}

function hideDiv(divStr, imgID) { 
	if (document.getElementById) {
		if(imgID != "") {
			var linkElement = document.getElementById("link_"+imgID);
			var imgElement = document.getElementById("img_"+imgID);
			imgElement.src="theme/default/images/iconExpand.png";
			linkElement.setAttribute("onclick", "showDiv('"+divStr+"','"+imgID+"');");
		}
		document.getElementById(divStr).style.display = 'none'; 
	}
} 

function activeCalls() {
	alert('You must end your active call ASAP!')
}

function getChildCatList(catCode, catAction, ticketID) {
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var imgElement = document.getElementById("img"+catCode);
	imgElement.src="theme/default/images/ajax-loader.gif";
	
	ajaxRequest.onreadystatechange=function() {
  	if(ajaxRequest.readyState==4 && ajaxRequest.status==200) {
  		if(ajaxRequest.responseText) {
	  		if(catAction == 'expand') {
	  			var linkElement = document.getElementById("link"+catCode);
			  	imgElement.src="theme/default/images/iconContract.png";
			  	linkElement.setAttribute("onclick", "getChildCatList('"+catCode+"','contract','"+ticketID+"');");
	  			document.getElementById("div"+catCode).innerHTML += ajaxRequest.responseText;
	  		} else if(catAction == 'contract') {
	  			var linkElement = document.getElementById("link"+catCode);
			  	imgElement.src="theme/default/images/iconExpand.png";
			  	linkElement.setAttribute("onclick", "getChildCatList('"+catCode+"','expand','"+ticketID+"');");
	  			document.getElementById("div"+catCode).innerHTML = ajaxRequest.responseText;
	  		}
	  	}
  	}
  }
	
	ajaxRequest.open("GET","scripts/categoryListMgmt.php?catCode="+catCode+"&catAction="+catAction+"&ticketID="+ticketID,true);
	ajaxRequest.send();
}

function changeStatus(newStatus, ticketID) {
	if(newStatus == -1) {
		var auth = confirm("Are you sure you would like to CLOSE this ticket?");
		if(auth) {
			window.location = "scripts/ticketMgmt.php?action=closeTicket&ticketID="+ticketID;
		}
	}
	if(newStatus == 1) {
		var auth = confirm("Are you sure you would like to CANCEL this ticket?");
		if(auth) {
			window.location = "scripts/ticketMgmt.php?action=cancelTicket&ticketID="+ticketID;
 		}
	}
	if(newStatus == 2) {
		var auth = confirm("Are you sure you would like to ESCALATE this ticket?");
		if(auth) {
			window.location = "scripts/ticketMgmt.php?action=escalateTicket&ticketID="+ticketID;
		}
	}
}