<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Test table</title>
<style>
  table {
    border-collapse: collapse;
  }
  th, td {
    border: 1px solid black;
    padding: 0.2rem;
  }
</style>

<script>
function subAction(action) {
  var xhttp = new XMLHttpRequest();
  /*
  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  }
  */
  xhttp.onload = function() {
    console.log(this.responseText);
  }
  xhttp.open("POST", "edit.inc.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=" + action);
}
</script>

</head>
<body>
<?php
try {
  $conn = new PDO("mysql:host=localhost;dbname=testdb", "testuser", "testpass");
  echo "<table>\n";
  echo "<tr><th>Name</th><th>Actions</th></tr>\n";
  foreach ($conn->query("SELECT * FROM tbl1") as $row) {
    echo "<tr><td contenteditable=\"true\">" . $row['name'] . "</td>";
    echo "<td>";
    echo "<button onclick=\"subAction('save')\">Save</button>";
    echo "<button onclick=\"subAction('delete')\">Delete</button>";
    echo "</td></tr>\n";
  }
  echo "</table>\n";
}
catch (PDOException $e) {
  echo $e->getMessage();
}
?>
</body>
</html>
