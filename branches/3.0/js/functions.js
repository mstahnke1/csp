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

function sbmRmaDevice(frmStr, ticketID, deviceAction) {
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
	
	var deviceType = document.forms[frmStr].deviceType.value;
	var serialNumber = document.forms[frmStr].serialNumber.value;
	var problemDesc = document.forms[frmStr].problemDesc.value;
	var warrantyStatus = document.forms[frmStr].warrantyStatus.value;
	var queryString = "deviceType=" + deviceType + "&serialNumber=" + serialNumber + "&problemDesc=" + problemDesc + "&warrantyStatus=" + warrantyStatus + "&ticketID=" + ticketID + "&action=" + deviceAction;
	
	ajaxRequest.open("POST", "scripts/rmaDeviceMgmt.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	ajaxRequest.send(queryString); 
}

function showDiv(str) { 
	if (document.getElementById) {
		document.getElementById(str).style.display = 'block'; 
	}
} 

function getChildCatList(catCode, catAction, ticketID) {
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
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
	
	var imgElement = document.getElementById("img"+catCode);
	imgElement.src="theme/default/images/ajax-loader.gif";
	ajaxRequest.open("GET","scripts/categoryListMgmt.php?catCode="+catCode+"&catAction="+catAction+"&ticketID="+ticketID,true);
	ajaxRequest.send();
}

