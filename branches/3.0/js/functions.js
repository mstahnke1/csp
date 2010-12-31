function sbmPortalSearch(frmStr){
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
	
	var srchString = document.forms[frmStr].srchString.value;
	var srchType = document.forms[frmStr].srchType.value;
	var queryString = "srchType=" + srchType + "&srchString=" + srchString;
	
	ajaxRequest.open("POST", "cspSearchResults.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	ajaxRequest.send(queryString); 
}

function showDiv(str) { 
	if (document.getElementById) {
		document.getElementById(str).style.display = 'block'; 
	}
} 

function conExpImg(catCode, newState) {
	switch(newState) {
		
	}
	
	if (newState == "expand") {
		alert("Expanding");
		var linkElement = document.getElementById("link"+catCode);
		var imgElement = document.getElementById("img"+catCode);
  	imgElement.src="theme/default/images/iconContract.png";
  	linkElement.onclick=conExpImg(catCode, 'contract')
  } else if(newState == "contract") {
  	alert("Contracting");
  	var divElement = document.getElementById("div"+catCode);
  	var imgElement = document.getElementById("img"+catCode);
  	divElement.parentNode.removeChild(element);
  	imgElement.src="theme/default/images/iconExpand.png";
  }
}

function getChildCatList(catCode) {
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  	ajaxRequest=new XMLHttpRequest();
  } else {// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	ajaxRequest.onreadystatechange=function() {
  	if (ajaxRequest.readyState==4 && ajaxRequest.status==200) {
  		document.getElementById("div"+catCode).innerHTML += ajaxRequest.responseText;
  	}
  }
	
	ajaxRequest.open("GET","scripts/getCategoryList.php?catCode="+catCode,true);
	ajaxRequest.send();
}