function userWarn(str,varID)
{
  var auth = confirm(str);
  if(auth) {
  	showPage('csPortal_HR_Vacation.php', varID)
  }
}