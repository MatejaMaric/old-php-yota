function subAction(action, btn) {
  trDom = btn.parentElement.parentElement;
  trData = trDom.children;

  trId = trData[0].innerHTML;
  //trFrom = trData[1].innerHTML;
  //trTo = trData[2].innerHTML;
  //trName = trData[3].innerHTML;
  trFrom = trData[1].firstElementChild.innerHTML;
  trTo = trData[2].firstElementChild.innerHTML;
  trName = trData[3].firstElementChild.innerHTML;

  //for (var i = 0, len = trData.length - 1; i < len; i++) {
  //console.log(i + ": " + trData[i].innerHTML);
  //}

  if (action == 'delete')
    if (confirm("Are you sure you want to delete this reservation?"))
      trDom.remove();

  // Send XHR
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        var response = JSON.parse(this.responseText)
        if (response.action == "update") {
          document.getElementById("notice").innerHTML = this.responseText;
        }
        else if (response.action == "restore") {
          trData[1].firstElementChild.innerHTML = response.from;
          trData[2].firstElementChild.innerHTML = response.to;
          trData[3].firstElementChild.innerHTML = response.name;
        }
        else if (response.action == "delete") {
          document.getElementById("notice").innerHTML = JSON.stringify(response);
        }
      } catch {
        console.log(this.responseText);
        document.getElementById("notice").innerHTML = "Bad input data!";
      }
    }
  }
  xhttp.open("POST", "edit.inc.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  data_str = "action=" + action
  data_str += "&id=" + trId
  data_str += "&from=" + trFrom
  data_str += "&to=" + trTo
  data_str += "&name=" + trName
  xhttp.send(data_str);
}
