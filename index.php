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
  <span class="right">
<?php
  if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
  	echo '<a href="admin.php">Administration</a>';
    echo '<a href="/logout.php">Logout</a>';
  } else {
    echo '<a href="/admin.php">Login</a>';
  }
?>
  </span>
</nav>
<main>
<?php
  $user = "yota_user";
  $password = "gahdeer6shai9hogai2sai4quuaj1eVu";
  $database = "yota_call_db";
  $table = "activities";

  try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo '<div style="overflow-x:auto;">';
    echo "<table>\n";
    echo "<thead><tr>";
    echo "<th>Operator</th>";
    echo "<th>From</th>";
    echo "<th>To</th>";
    echo "<th>Special sign</th>";
    echo "<th>Frequencies</th>";
    echo "<th>QSO</th>";
    echo "</tr></thead><tbody>\n";

    foreach($db->query("SELECT * FROM $table where approved=true ORDER BY `id` DESC") as $row) {
      echo "<tr>";
      echo "<td>" . $row['operatorCall'] . "</td>";
      echo "<td>" . $row['fromTime'] . "</td>";
      echo "<td>" . $row['toTime'] . "</td>";
      echo "<td>" . $row['specialCall'] . "</td>";
      echo "<td>" . $row['frequencies'] . "</td>";
      echo "<td>" . $row['qso'] . "</td>";
      echo "</tr>\n";
    }

    echo "</tbody></table>\n</div>\n";
  } catch (PDOException $e) {
    echo "<p>Error!: " . $e->getMessage() . "</p>";
    die();
  }
?>
</main>
</body>
</html>
