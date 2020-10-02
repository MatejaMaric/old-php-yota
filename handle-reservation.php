<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // DB INFO
  $user = "yota_requester";
  $password = "oon5iraeghaidoShi5sheefie2uuz3gu";
  $database = "yota_call_db";
  $table = "activities";

  // SPECIAL CALL
  $specialCall = $_POST["scall"];

  // TIME
  $fromTime = $_POST["sdate"] . $_POST["stime"] . ":00";
  $toTime = $_POST["edate"] . $_POST["etime"] . ":00";

  // FREQUENCIES
  $frequencies = $_POST["freqs"][0];
  for ($i = 0; $i < sizeof($_POST["freqs"]) - 1; $i++) {
    $frequencies += ", " . $_POST["freqs"][$i];
  }

  // MODES
  $modes = $_POST["modes"][0];
  for ($i = 0; $i < sizeof($_POST["modes"]) - 1; $i++) {
    $modes += ", " . $_POST["modes"][$i];
  }

  // OPERATOR INFORMATION
  $operatorCall = $_POST["ocall"] . "<br>";
  $operatorName = $_POST["oname"] . "<br>";
  $operatorEmail = $_POST["email"] . "<br>";
  $operatorPhone = $_POST["phone"] . "<br>";

  try {
    //$conn = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$stmt = $conn->prepare("INSERT INTO $table (name, surname, age) VALUES (:name, :surname, :age)");
    //$stmt->bindParam(':name', $_POST['fname']);
    //$stmt->execute();
    //echo "<p>Data inserted.</p>";
  } catch (PDOException $e) {
    echo "<p>Error!: " . $e->getMessage() . "</p>";
  }
}
