var url = window.location.href;

var page = url.split('/').pop();


if(page=="ajouter_bac.php"||page=="ajouter_zone.php"||page=="ajouter_ras_pi.php"){

  if(getAction()=="Ajouter"){
    document.getElementById("id").removeAttribute("required");
    document.getElementById("id").disabled=true;
    //document.getElementById("labelId").style.display="none";
  }
  else if(getAction()=="Supprimer"){
    document.getElementById("user").disabled=true;
    document.getElementById("zone").disabled=true;
    document.getElementById("modele").disabled=true;
    document.getElementById("date").disabled=true;
    document.getElementById("capacity").disabled=true;
  }


  document.getElementById("actionButton").innerHTML=getAction();
  document.getElementById("actionButton").name=getAction();
  document.getElementById("actionButton").value=getAction();
  //document.write.(document.getElementById("actionButton").name);

}

function checkAction(action, url){
  document.cookie ="action="+action;
  window.location.href=url;

}

function getAction() {
  var name = "action=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

/*function addRasPi(){
  var result;
  var model = document.getElementById("modele").value;
  var user = document.getElementById("user").value;
  var zone = document.getElementById("zone").value;
  var date = document.getElementById("date").value;
  var capacity = document.getElementById("capacity").value;

  jQuery.ajax({
    type: "POST",
    url: '$_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/JsonTarget.php"',
    dataType: 'json',
    data: {functionname: 'createNewRaspberryPi', arguments: [model, user,zone,date,capacity]},

    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      result = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
}*/
