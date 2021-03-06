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
		$recvData->approved = filter_var($recvData->approved, FILTER_VALIDATE_BOOLEAN);
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

		//foreach ($recvData as $key => $value) {
			//if ($key == "approved")
				//$recvData->approved = filter_var($recvData->approved, FILTER_VALIDATE_BOOLEAN);
			//else
				//$recvData->$key = clear_input($recvData->$key);
		//}

		$recvData->$specialCall = strtoupper($recvData->$specialCall);
		$recvData->$modes = strtoupper($recvData->$modes);
		$recvData->$operatorCall = strtoupper($recvData->$operatorCall);

		//print_r($recvData);

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

			$recvData->approved = $recvData->approved === true ? "1" : "0";

			$stmt = $conn->prepare($sql);

			//foreach ($recvData as $key => $value) {
				//$stmt->bindParam(':'.$key, $recvData->$key);
			//}

			$stmt->bindParam(':id', 						$recvData->id);
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

			$sendData = null;
			$sendData->action=$recvData->action;

			//foreach ($row as $key => $value) {
				//$sendData->$key = $value;
			//}

			$sendData->id=$row["id"];
			$sendData->approved=$row["approved"];
			$sendData->specialCall=$row["specialCall"];
			$sendData->fromTime=$row["fromTime"];
			$sendData->toTime=$row["toTime"];
			$sendData->frequencies=$row["frequencies"];
			$sendData->modes=$row["modes"];
			$sendData->operatorCall=$row["operatorCall"];
			$sendData->operatorName=$row["operatorName"];
			$sendData->operatorEmail=$row["operatorEmail"];
			$sendData->operatorPhone=$row["operatorPhone"];
			$sendData->qso=$row["qso"];

			$recvData->approved = filter_var($recvData->approved, FILTER_VALIDATE_BOOLEAN);
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
