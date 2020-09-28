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
  <a class="active" href="index.php">Activity Plan</a>
  <a href="reservation.php">Make reservation</a>
<?php
  if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    echo '<a class="right" href="/logout.php">Logout</a>';
  	echo '<a class="right" href="admin.php">Administration</a>';
  } else {
    echo '<a class="right" href="/admin.php">Login</a>';
  }
?>
</nav>
<main>
<?php
  $user = "yota_user";
  $password = "leex3EThieK0ieLaiVaicaifef5eecei";
  $database = "yota_call_db";
  $table = "activities";

  try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo '<div style="overflow-x:auto;">';
    echo "<table>\n";
    echo "<tr>";
    echo "<th>Ime</th>";
    echo "<th>Prezime</th>";
    echo "<th>Godine</th>";
    echo "</tr>\n";

    foreach($db->query("SELECT * FROM $table where approved=true") as $row) {
      echo "<tr>";
      echo "<td>" . $row['name'] . "</td>";
      echo "<td>" . $row['surname'] . "</td>";
      echo "<td>" . $row['age'] . "</td>";
      echo "</tr>\n";
    }

    echo "</table>\n</div>\n";
  } catch (PDOException $e) {
    echo "<p>Error!: " . $e->getMessage() . "</p>";
    die();
  }
?>
</main>
</body>
</html>
