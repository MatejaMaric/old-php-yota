<?php
session_start();
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
		$user = "yota_admin";
		$password = "quaequaquagh6ahwoh6Chahx1EiFooGh";
		$database = "yota_call_db";
		$conn = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo '<p id="notice">Reservation records: </p>';
    echo '<div class="tablediv">';
    echo "<table><thead>\n";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Approved</th>";
    echo "<th>Operator Sign</th>";
    echo "<th>QSO</th>";
    echo "<th>From</th>";
    echo "<th>To</th>";
    echo "<th>Frequencies</th>";
    echo "<th>Modes</th>";
    echo "<th>Special sign</th>";
    echo "<th>Operator Name</th>";
    echo "<th>Operator Email</th>";
    echo "<th>Operator Phone</th>";
    echo "<th>Actions</th>";
    echo "</tr></thead><tbody>\n";

    foreach($conn->query("SELECT * FROM activities ORDER BY `id` DESC") as $row) {
      echo "<tr>";
      echo "<td>" . $row['id'] . "</td>";

			if ($row['approved'])
				echo "<td class=\"center\"><input type=\"checkbox\" checked></td>";
			else
				echo "<td class=\"center\"><input type=\"checkbox\"></td>";

      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['operatorCall'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['qso'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['fromTime'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['toTime'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['frequencies'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['modes'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['specialCall'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['operatorName'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['operatorEmail'] . "</div></td>";
      echo "<td><div class=\"edit\" contenteditable=\"true\">" . $row['operatorPhone'] . "</div></td>";

			echo "<td>";
			echo "<button onclick=\"btnAction('update', this)\">Update</button>";
			echo "<button onclick=\"btnAction('restore', this)\">Restore</button>";
			echo "<button onclick=\"btnAction('delete', this)\">Delete</button>";
			echo "</td></tr>\n";
    }
    echo "</tbody></table>\n</div>\n";
  } catch (PDOException $e) {
    echo "<p>Error!: " . $e->getMessage() . "</p>";
  }
} else {
	# Bad pass check...
	if (isset($_SESSION['admin']) && $_SESSION['admin'] == false)
		echo "<em>Bad credentials!</em>";
	# Login form
	echo '<form action="login.php" method="post">';
	echo '<label for="email">Email:</label>';
	echo '<input type="email" id="email" name="email">';
	echo '<label for="password">Password:</label>';
	echo '<input type="password" id="password" name="password">';
	echo '<input type="submit" value="Login">';
	echo '</form>';
}
?>
</main>
<script src="request-edit.js"></script>
</body>
</html>
