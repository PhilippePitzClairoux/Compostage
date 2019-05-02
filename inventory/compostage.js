var url = window.location.href;

var page = url.split('/')

//document.write(page[5]);
if(page[5]=="ajouter_bac.php"||page[5]=="ajouter_zone.php"||page[5]=="ajouter_ras_pi.php"){
  document.write(document.cookie);
}

function checkAction(action, url){
  document.cookie ="action="+action;
  window.location.href=url;

}
