function validate(tocheck){
  var tocheck = document.getElementById(entry);
  switch(tocheck)
  {
    case document.getElementById("txtname" || "txtprenom"):
    var model = /^[\p{L}\s'.-]+$;
    if(!tocheck.value.match(model))
    {
      tocheck.innerHTML="Invalid entry. Numerical entry and special characters are not accepted.";
      break;
    }
    case document.getElementById("txttel"):
      var model = /^\(?([0-9]{3})?\)?[- .]?([0-9]{3})[- .]?([0-9]{4})$|/;
      if(tocheck.value.match(model))
      {
        tocheck.innerHTML="Invalid entry. Please enter numbers. "(,),.,-" are accepted.";
      break;
      }
      case document.getElementById("txtCP"):
          var model = /^([A-Z][0-9][A-Z])[- ]?([0-9][A-Z][0-9])$/;
          if(tocheck.value.match(model))
          {
            tocheck.insertAdjacentHTML("afterend","Ivalid entry. Please match this format : A1A 1A1");
            break;
          }
      case document.getElementById("txtbirth"):
      var model = /^([1-31][1-31])([1-31][1-31])?[-/ ]$/;
      if(tocheck.value.match(model))
      {
        tocheck.innerHTML="Invalid entry. Please match one of the following format: AAAA-MM-JJ | AAAA/MM/JJ | JJ MMMM AAAA ";
        break;
      }
      case document.getElementById("txtnas"):
      var model = /^([0-9]{3})[- ]?([0-9]{3})[- ]?([0-9]{3})$/;
      if(tocheck.value.match(model))
      {
        tocheck.innerHTML="Invalid entry. Please match one of the following format: 999 999 9999/999-999-9999/9999999999";
        break;
      }
}
