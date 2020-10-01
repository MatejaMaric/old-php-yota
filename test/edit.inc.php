<?php

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST["action"] == "update") {
  try {
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "testuser", "testpass");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("UPDATE tbl1 SET `name`=:name, `from`=:from, `to`=:to WHERE id=:id");
    $stmt->bindParam(':id', $_POST["id"]);
    $stmt->bindParam(':name', $_POST["name"]);
    $stmt->bindParam(':from', $_POST["from"]);
    $stmt->bindParam(':to', $_POST["to"]);
		$stmt->execute();

		$data->action=$_POST["action"];
		echo json_encode($data);
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST["action"] == "restore") {
  try {
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "testuser", "testpass");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM tbl1 WHERE id=:id");
    $stmt->bindParam(':id', $_POST["id"]);
		$stmt->execute();
		$row = $stmt->fetch();

		$data->action=$_POST["action"];
		$data->id = $row["id"];
		$data->from = $row["from"];
		$data->to = $row["to"];
		$data->name = $row["name"];

		echo json_encode($data);
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST["action"] == "delete") {
  try {
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "testuser", "testpass");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("DELETE FROM tbl1 WHERE id=:id");
    $stmt->bindParam(':id', $_POST["id"]);
		$stmt->execute();
		
		$data->action=$_POST["action"];
		echo json_encode($data);
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
	$email = clear_input($_POST['email']);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  echo "Email is not valid: " . $email . "<br>";
	} else {
	  echo "Email is valid: " . $email . "<br>";
	}
}

function clear_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
