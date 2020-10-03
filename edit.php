<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
	try {
		$user = "yota_admin";
		$password = "quaequaquagh6ahwoh6Chahx1EiFooGh";
		$database = "yota_call_db";
		$conn = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "<p>Error!: " . $e->getMessage() . "</p>";
	}

}
