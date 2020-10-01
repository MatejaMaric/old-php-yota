<?php
echo $_POST['action'];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset(_POST['email'])) {
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
