function btnAction(action, btn) {
  var trDom = btn.parentElement.parentElement;
  var trData = trDom.children;

  var actionData = {
    action: action,
    id: trData[0].innerText,
    approved: trData[1].firstElementChild.checked,
    operatorCall: trData[2].firstElementChild.innerText,
    qso: trData[3].firstElementChild.innerText,
    fromTime: trData[4].firstElementChild.innerText,
    toTime: trData[5].firstElementChild.innerText,
    frequencies: trData[6].firstElementChild.innerText,
    modes: trData[7].firstElementChild.innerText,
    specialCall: trData[8].firstElementChild.innerText,
    operatorName: trData[9].firstElementChild.innerText,
    operatorEmail: trData[10].firstElementChild.innerText,
    operatorPhone: trData[11].firstElementChild.innerText
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
          document.getElementById("notice").innerText = "Record #" + actionData.id + " updated.";
        } else if (response.action == "restore") {
          trData[1].firstElementChild.checked = response.approved === "1";
          trData[2].firstElementChild.innerText = response.operatorCall;
          trData[3].firstElementChild.innerText = response.qso;
          trData[4].firstElementChild.innerText = response.fromTime;
          trData[5].firstElementChild.innerText = response.toTime;
          trData[6].firstElementChild.innerText = response.frequencies;
          trData[7].firstElementChild.innerText = response.modes;
          trData[8].firstElementChild.innerText = response.specialCall;
          trData[9].firstElementChild.innerText = response.operatorName;
          trData[10].firstElementChild.innerText = response.operatorEmail;
          trData[11].firstElementChild.innerText = response.operatorPhone;
          document.getElementById("notice").innerText = "Record's #" + actionData.id + " data restored.";
        } else if (response.action == "delete") {
          document.getElementById("notice").innerText = "Record #" + actionData.id + " deleted.";
        } else {
          console.log("No action?");
          console.log(this.responseText);
        }
      } catch {
        console.log(this.responseText);
        document.getElementById("notice").innerText = "Bad input data!";
      }
    }
  };
  xhttp.open("POST", "edit.php", true);
  xhttp.send(JSON.stringify(actionData));
}
