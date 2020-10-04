<?php
session_start();

function clear_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
	try {
		$user = "yota_admin";
		$password = "quaequaquagh6ahwoh6Chahx1EiFooGh";
		$database = "yota_call_db";
		$conn = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	try {
		$recvData = json_decode(file_get_contents("php://input"));
		$recvData->id = clear_input($recvData->id);
		$recvData->approved = clear_input($recvData->approved);
		$recvData->specialCall = clear_input($recvData->specialCall);
		$recvData->fromTime = clear_input($recvData->fromTime);
		$recvData->toTime = clear_input($recvData->toTime);
		$recvData->frequencies = clear_input($recvData->frequencies);
		$recvData->modes = clear_input($recvData->modes);
		$recvData->operatorCall = clear_input($recvData->operatorCall);
		$recvData->operatorName = clear_input($recvData->operatorName);
		$recvData->operatorEmail = clear_input($recvData->operatorEmail);
		$recvData->operatorPhone = clear_input($recvData->operatorPhone);
		$recvData->qso = clear_input($recvData->qso);
	} catch (Exception $e) {
		die("Can't decode JSON!");
	}

	try {
		if ($recvData->action == "update") {
			$sql = "UPDATE activities SET 
				approved=:approved, 
				specialCall=:specialCall, 
				fromTime=:fromTime, 
				toTime=:toTime, 
				frequencies=:frequencies, 
				modes=:modes, 
				operatorCall=:operatorCall, 
				operatorName=:operatorName, 
				operatorEmail=:operatorEmail, 
				operatorPhone=:operatorPhone, 
				qso=:qso 
				WHERE id=:id";

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':approved', 			$recvData->approved);
      $stmt->bindParam(':specialCall', 		$recvData->specialCall);
      $stmt->bindParam(':fromTime', 			$recvData->fromTime);
      $stmt->bindParam(':toTime', 				$recvData->toTime);
      $stmt->bindParam(':frequencies', 		$recvData->frequencies);
      $stmt->bindParam(':modes', 					$recvData->modes);
      $stmt->bindParam(':operatorCall', 	$recvData->operatorCall);
      $stmt->bindParam(':operatorName', 	$recvData->operatorName);
      $stmt->bindParam(':operatorEmail', 	$recvData->operatorEmail);
      $stmt->bindParam(':operatorPhone', 	$recvData->operatorPhone);
      $stmt->bindParam(':qso', 						$recvData->qso);
      $stmt->execute();

			$sendData->action=$recvData->action;
			echo json_encode($sendData);

		} else if ($recvData->action == "restore") {

			$stmt = $conn->prepare("SELECT * FROM activities WHERE id=:id");
			$stmt->bindParam(':id', $recvData->id);
			$stmt->execute();
			$row = $stmt->fetch();

			$sendData->action=$recvData->action;
			$sendData->id=$row->id;
			$sendData->approved=$row->approved;
			$sendData->specialCall=$row->specialCall;
			$sendData->fromTime=$row->fromTime;
			$sendData->toTime=$row->toTime;
			$sendData->frequencies=$row->frequencies;
			$sendData->modes=$row->modes;
			$sendData->operatorCall=$row->operatorCall;
			$sendData->operatorName=$row->operatorName;
			$sendData->operatorEmail=$row->operatorEmail;
			$sendData->operatorPhone=$row->operatorPhone;
			$sendData->qso=$row->qso;

			echo json_encode($sendData);

		} else if ($recvData->action == "delete") {
			$stmt = $conn->prepare("DELETE FROM activities WHERE id=:id");
			$stmt->bindParam(':id', $recvData->id);
			$stmt->execute();

			$sendData->action=$recvData->action;
			echo json_encode($sendData);
		}
	} catch ( Exception $e ) {
		if ( $e instanceof PDOException )
			echo "Error: " . $e->getMessage();
		else
			echo "Error in action handling!";
	}
}
