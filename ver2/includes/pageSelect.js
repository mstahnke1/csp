
var xmlHttp

function showPage(str,parameters)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }

var myloc = window.location.href;
var locarray = myloc.split("/");
delete locarray[(locarray.length-1)];
var arraytext = locarray.join("/");
var params=parameters
var url=arraytext+str+"?"+params
var url=arraytext+str+"?"+params
//alert (url);
xmlHttp.onreadystatechange=stateChanged
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("pageData").innerHTML=xmlHttp.responseText 
 } 
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

function get(pageStr, obj) {

var poststr = "dateFrom=" + escape(encodeURI(document.getElementById("dateFrom").value )) +
							"&dateTo=" +escape(encodeURI( document.getElementById("dateTo").value )) +
							"&sbmVacReq=" +escape(encodeURI( document.getElementById("sbmVacReq").value ));

showPage(pageStr, poststr);
}


