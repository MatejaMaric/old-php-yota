function btnAction(action, btn) {
  var trDom = btn.parentElement.parentElement;
  var trData = trDom.children;

  var actionData = {
    action: action,
    id: trData[0].innerHTML,
    approved: trData[1].firstElementChild.checked,
    operatorSign: trData[2].firstElementChild.innerHTML,
    qso: trData[3].firstElementChild.innerHTML,
    fromTime: trData[4].firstElementChild.innerHTML,
    toTime: trData[5].firstElementChild.innerHTML,
    freqs: trData[6].firstElementChild.innerHTML,
    modes: trData[7].firstElementChild.innerHTML,
    specialSign: trData[8].firstElementChild.innerHTML,
    operatorName: trData[9].firstElementChild.innerHTML,
    operatorEmail: trData[10].firstElementChild.innerHTML,
    operatorPhone: trData[11].firstElementChild.innerHTML
  }

  if (actionData.action == 'delete')
    if (confirm("Are you sure you want to delete reservation #" + actionData.id + " made by " + actionData.operatorSign + "?"))
      trDom.remove();

  //var xhr = new XMLHttpRequest();
  //xhr.onreadystatechange = function () {
  //if (this.readyState == 4 && status == 200) {

  //}
  //};
  //xhr.open("POST", "edit.php", true);
  //xhr.send(JSON.stringify(actionData));
}
