function btnAction(action, btn) {
  var trDom = btn.parentElement.parentElement;
  var trData = trDom.children;

  var actionData = {
    action: action,
    id: trData[0].innerHTML,
    approved: trData[1].firstElementChild.checked,
    operatorCall: trData[2].firstElementChild.innerHTML,
    qso: trData[3].firstElementChild.innerHTML,
    fromTime: trData[4].firstElementChild.innerHTML,
    toTime: trData[5].firstElementChild.innerHTML,
    frequencies: trData[6].firstElementChild.innerHTML,
    modes: trData[7].firstElementChild.innerHTML,
    specialCall: trData[8].firstElementChild.innerHTML,
    operatorName: trData[9].firstElementChild.innerHTML,
    operatorEmail: trData[10].firstElementChild.innerHTML,
    operatorPhone: trData[11].firstElementChild.innerHTML
  }

  if (actionData.action == 'delete')
    if (confirm("Are you sure you want to delete reservation #" + actionData.id + " made by " + actionData.operatorCall + "?"))
      trDom.remove();

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        // JSON response to object
        var response = JSON.parse(this.responseText);
        console.log(response);
        // Handle various actions
        if (response.action == "update") {
          document.getElementById("notice").innerHTML = "Record #" + actionData.id + " updated.";
        } else if (response.action == "restore") {
          trData[1].firstElementChild.checked = response.approved === "1";
          trData[2].firstElementChild.innerHTML = response.operatorCall;
          trData[3].firstElementChild.innerHTML = response.qso;
          trData[4].firstElementChild.innerHTML = response.fromTime;
          trData[5].firstElementChild.innerHTML = response.toTime;
          trData[6].firstElementChild.innerHTML = response.frequencies;
          trData[7].firstElementChild.innerHTML = response.modes;
          trData[8].firstElementChild.innerHTML = response.specialCall;
          trData[9].firstElementChild.innerHTML = response.operatorName;
          trData[10].firstElementChild.innerHTML = response.operatorEmail;
          trData[11].firstElementChild.innerHTML = response.operatorPhone;
          document.getElementById("notice").innerHTML = "Record's #" + actionData.id + " data restored.";
        } else if (response.action == "delete") {
          document.getElementById("notice").innerHTML = "Record #" + actionData.id + " deleted.";
        } else {
          console.log("No action?");
          console.log(this.responseText);
        }
      } catch {
        console.log(this.responseText);
        document.getElementById("notice").innerHTML = "Bad input data!";
      }
    }
  };
  xhttp.open("POST", "edit.php", true);
  xhttp.send(JSON.stringify(actionData));
}
