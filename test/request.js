function subAction(action, btn) {
  trDom = btn.parentElement.parentElement;
  trData = trDom.children;

  trId = trData[0].innerHTML;
  trFrom = trData[1].innerHTML;
  trTo = trData[2].innerHTML;
  trName = trData[3].innerHTML;

  console.log(trId);
  console.log(trFrom);
  console.log(trTo);
  console.log(trName);

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
      document.getElementById("notice").innerHTML = this.responseText;
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
