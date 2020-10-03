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
  $fromTime = $_POST["sdate"] . " " . $_POST["stime"] . ":00";
  $toTime = $_POST["edate"] . " " . $_POST["etime"] . ":00";

  // FREQUENCIES
  $frequencies = $_POST["freqs"][0];
  for ($i = 1; $i < sizeof($_POST["freqs"]); $i++) {
    $frequencies .= ", " . $_POST["freqs"][$i];
  }

  // MODES
  $modes = $_POST["modes"][0];
  for ($i = 1; $i < sizeof($_POST["modes"]); $i++) {
    $modes .= ", " . $_POST["modes"][$i];
  }

  // OPERATOR INFORMATION
  $operatorCall = $_POST["ocall"];
  $operatorName = $_POST["oname"];
  $operatorEmail = $_POST["email"];
  $operatorPhone = $_POST["phone"];

  // Sanitize data
  $specialCall = clear_input($specialCall);
  $fromTime = clear_input($fromTime);
  $toTime = clear_input($toTime);
  $frequencies = clear_input($frequencies);
  $modes = clear_input($modes);
  $operatorCall = clear_input($operatorCall);
  $operatorName = clear_input($operatorName);
  $operatorEmail = clear_input($operatorEmail);
  $operatorPhone = clear_input($operatorPhone);

  // Check if something is empty
  $is_something_empty = false;
  $is_something_empty |= empty($specialCall);
  $is_something_empty |= empty($fromTime);
  $is_something_empty |= empty($toTime);
  $is_something_empty |= empty($frequencies);
  $is_something_empty |= empty($modes);
  $is_something_empty |= empty($operatorCall);
  $is_something_empty |= empty($operatorName);
  $is_something_empty |= empty($operatorEmail);
  $is_something_empty |= empty($operatorPhone);

  // Operator call sign to uppercase
  $operatorCall = strtoupper($operatorCall);

  // Error handling
  if ($is_something_empty) {
    $_SESSION["msg"] = "All fields must be filed!";
  }
  else {
    // Send to DB
    try {
      $conn = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO $table (specialCall, fromTime, toTime, frequencies, modes, operatorCall, operatorName, operatorEmail, operatorPhone)
        VALUES (:specialCall, :fromTime, :toTime, :frequencies, :modes, :operatorCall, :operatorName, :operatorEmail, :operatorPhone)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':specialCall', $specialCall);
      $stmt->bindParam(':fromTime', $fromTime);
      $stmt->bindParam(':toTime', $toTime);
      $stmt->bindParam(':frequencies', $frequencies);
      $stmt->bindParam(':modes', $modes);
      $stmt->bindParam(':operatorCall', $operatorCall);
      $stmt->bindParam(':operatorName', $operatorName);
      $stmt->bindParam(':operatorEmail', $operatorEmail);
      $stmt->bindParam(':operatorPhone', $operatorPhone);
      $stmt->execute();
      $_SESSION["msg"] = "Data inserted.";
    } catch (PDOException $e) {
      $_SESSION["msg"] = "Error!: " . $e->getMessage();
    }
  }
}

function clear_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

header("Location: reservation.php");
