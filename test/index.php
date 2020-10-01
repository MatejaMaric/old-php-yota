<?php
  try {
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "testuser", "testpass");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["date"]) && isset($_POST["time"])) {
  # values will always be set, check if they are empty...
  echo "<strong>Information submitted!</strong><br>";
  echo "<strong>Date: " . date('Y-m-d H:i:s') . "</strong><br>";
  echo "<strong>User date: " . $_POST["date"] . "</strong><br>";
  echo "<strong>User time: " . $_POST["time"] . "</strong><br>";
  //$toDT='2020-10-10 12:00:00';
  $toDT=$_POST["date"] . " " . $_POST["time"] . ":00";
  echo "<strong>$toDT</strong><br>";
  try {
    $stmt = $conn->prepare("INSERT INTO tbl1 (`name`, `from`, `to`) VALUES (:name, :from, :to)");
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':from', date('Y-m-d H:i:s'));
    $stmt->bindParam(':to', $toDT);
    $stmt->execute();
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Test table</title>
<style>
  #notice {
    color: red;
  }
  table {
    border-collapse: collapse;
  }
  th, td {
    border: 1px solid black;
    padding: 0.3rem;
  }
  tbody tr:nth-child(even) {
    background-color: #ccc;
  }
  thead {
    color: white;
    background-color: black;
  }
  .edit {
    padding: 2px;
    border-top: 1px solid #333;
    border-left: 1px solid #333;
    border-bottom: 1px solid #666;
    border-right: 1px solid #666;
    border-radius: 3px;
  }
</style>
</head>
<body>
<p id="notice"></p>
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
  echo "<table>\n";
  echo "<thead><tr><th>ID</th><th>From</th><th>To</th><th>Name</th><th>Actions</th></tr></thead><tbody>\n";
  foreach ($conn->query("SELECT * FROM tbl1 ORDER BY `id` DESC") as $row) {
    echo "<tr><td>" . $row['id'] . "</td>";
    echo "<td><div contenteditable=\"true\" class=\"edit\">" . $row['from'] . "</div></td>";
    echo "<td><div contenteditable=\"true\" class=\"edit\">" . $row['to'] . "</div></td>";
    echo "<td><div contenteditable=\"true\" class=\"edit\">" . $row['name'] . "</div></td>";
    echo "<td>";
    echo "<button onclick=\"subAction('save', this)\">Save</button>";
    echo "<button onclick=\"subAction('cancel', this)\">Cancel</button>";
    echo "<button onclick=\"subAction('delete', this)\">Delete</button>";
    echo "</td></tr>\n";
  }
  echo "</tbody></table>\n";
}
catch (PDOException $e) {
  echo $e->getMessage();
}
?>
<script src="request.js"></script>
</body>
</html>
