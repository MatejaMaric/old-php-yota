<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width initial-scale=1.0"/>
    <link href="../style.css" rel="stylesheet" type="text/css"/>
    <title>Test</title>
</head>
<body>
<main>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = clear_input($_POST['name']);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  echo "You fucking bitch!<br>";
	} else {
	  echo "You oki: " . $email . "<br>";
	}
}
function clear_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
include 'test.inc.php';
?>
<form method="POST">
<input type="text" name="name">
<input type="submit" name="your-submit" value="Submit">
</form>
</main>
</body>
</html>
