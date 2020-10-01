<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["date"]) && isset($_POST["time"])) {
  # values will always be set, check if they are empty...
  echo "<strong>You gay!</strong><br>";
}
?>
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

  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  }
  /*
  xhttp.onload = function() {
    console.log(this.responseText);
  }
  */
  xhttp.open("POST", "edit.inc.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=" + action);
}
</script>
</head>
<body>
<form method="post">
<label for="name">Name: </label>
<input type="text" name="name" id="name">
<br>
<label for="date">Date: </label>
<input type="date" name="date" id="date">
<br>
<label for="time">Time: </label>
<input type="time" name="time" id="time">
<br>
<input type="submit" value="Submit">
</form>
<?php
try {
  $conn = new PDO("mysql:host=localhost;dbname=testdb", "testuser", "testpass");
  echo "<table>\n";
  echo "<thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead><tbody>\n";
  foreach ($conn->query("SELECT * FROM tbl1") as $row) {
    echo "<tr><td>" . $row['id'] . "</td>";
    echo "<td contenteditable=\"true\">" . $row['name'] . "</td>";
    echo "<td>";
    echo "<button onclick=\"subAction('save')\">Save</button>";
    echo "<button onclick=\"subAction('cancel')\">Cancel</button>";
    echo "<button onclick=\"subAction('delete')\">Delete</button>";
    echo "</td></tr>\n";
  }
  echo "</tbody></table>\n";
}
catch (PDOException $e) {
  echo $e->getMessage();
}
?>
</body>
</html>
