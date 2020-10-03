<?php
session_start();

# IS LOGIN LEGITIMATE?
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
	# DB CONNECT
	try {
		$user = "yota_user";
		$password = "gahdeer6shai9hogai2sai4quuaj1eVu";
		$database = "yota_call_db";

		$conn = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $conn->prepare("SELECT * FROM admins WHERE email=:email");
		$stmt->bindParam(':email', $_POST['email']);
		$stmt->execute();
		$row = $stmt->fetch();

		if (password_verify($_POST['password'], $row['password'])) {
			$_SESSION['admin'] = true;
		} else {
			$_SESSION['admin'] = false;
		}
	} catch (PDOException $e) {
			die("Error!: " . $e->getMessage());
	}
	$stmt=null;
	$conn=null;
}

header("Location: admin.php");
