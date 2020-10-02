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

		if (password_verify($_POST['password'], $row['password'])){
			$_SESSION['admin'] = true;
		} else {
			$_SESSION['admin'] = false;
		}
	} catch (PDOException $e) {
			echo "<p>Error!: " . $e->getMessage() . "</p>";
	}
	$stmt=null;
	$conn=null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width initial-scale=1.0"/>
	<link href="style.css" rel="stylesheet" type="text/css"/>
	<title>Yota Callplan</title>
</head>
<body>
<header><a href="http://yota.yu1srs.org.rs/">YOTA</a></header>
<nav>
  <a href="/index.php">Activity Plan</a>
  <a href="/reservation.php">Make reservation</a>
<?php
  if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    echo '<a class="right" href="/logout.php">Logout</a>';
  	echo '<a class="active right" href="admin.php">Administration</a>';
	} else {
    echo '<a class="active right" href="/admin.php">Login</a>';
	}
?>
</nav>
<main>
<?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
  try {
    echo '<div style="overflow-x:auto;">';
    echo "<table>\n";
    echo "<tr>";
    echo "<th>Ime</th>";
    echo "<th>Prezime</th>";
    echo "<th>Godine</th>";
    echo "<th>Actions</th>";
    echo "</tr>\n";
    foreach($conn->query("SELECT * FROM activities WHERE approved = false") as $row) {
      echo "<tr>";
      echo "<td>" . $row['name'] . "</td>";
      echo "<td>" . $row['surname'] . "</td>";
      echo "<td>" . $row['age'] . "</td>";
      echo '<td><form action="admin.php" method="post">';
      echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
      echo '<input type="submit" class="abtn" value="Approve"/>';
      echo '</form></td>';
      echo "</tr>\n";
    }
    echo "</table>\n</div>\n";
  } catch (PDOException $e) {
    echo "<p>Error!: " . $e->getMessage() . "</p>";
  }
} else {
	# Bad pass check...
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['admin']) && $_SESSION['admin'] == false) echo "<em>Bad credentials!</em>";
	# Login form
	echo '<form method="post">';
	echo '<label for="email">Email:</label>';
	echo '<input type="email" id="email" name="email">';
	echo '<label for="password">Password:</label>';
	echo '<input type="password" id="password" name="password">';
	echo '<input type="submit" value="Login">';
	echo '</form>';
}
?>
</main>
</body>
</html>
