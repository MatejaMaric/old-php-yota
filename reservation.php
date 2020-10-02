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
  <a href="index.php">Activity Plan</a>
  <a class="active" href="reservation.php">Make reservation</a>
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
  require "handle-reservation.php";
?>

<form method="post">
<!-- SPECIAL CALL -->
<label for="special-call">Special Call:</label>
<select id="special-call" name="scall">
  <option value="YT50SCWC">YT50SCWC</option>
</select> 
<!-- START TIME -->
<label for="start-date">Start date:</label>
<input type="date" id="start-date" name="sdate">
<label for="start-time">Start time:</label>
<input type="time" id="start-time" name="stime">
<!-- END TIME -->
<label for="end-date">End date:</label>
<input type="date" id="end-date" name="edate">
<label for="end-time">End time:</label>
<input type="time" id="end-time" name="etime">
<!-- BANDS -->
<fieldset>
  <legend>I will be active on bands:</legend>

  <input type="checkbox" id="cb1" name="freqs[]" value="1.8 MHz">
  <label for="cb1">1.8 MHz</label><br>

  <input type="checkbox" id="cb2" name="freqs[]" value="3.5 MHz">
  <label for="cb2">3.5 MHz</label><br>

  <input type="checkbox" id="cb3" name="freqs[]" value="7 MHz">
  <label for="cb3">7 MHz</label><br>

  <input type="checkbox" id="cb4" name="freqs[]" value="10 MHz">
  <label for="cb4">10 MHz</label><br>

  <input type="checkbox" id="cb5" name="freqs[]" value="14 MHz">
  <label for="cb5">14 MHz</label><br>

  <input type="checkbox" id="cb6" name="freqs[]" value="18 MHz">
  <label for="cb6">18 MHz</label><br>

  <input type="checkbox" id="cb7" name="freqs[]" value="21 MHz">
  <label for="cb7">21 MHz</label><br>

  <input type="checkbox" id="cb8" name="freqs[]" value="24 MHz">
  <label for="cb8">24 MHz</label><br>

  <input type="checkbox" id="cb9" name="freqs[]" value="28 MHz">
  <label for="cb9">28 MHz</label><br>

  <input type="checkbox" id="cb10" name="freqs[]" value="50 MHz">
  <label for="cb10">50 MHz</label><br>

  <input type="checkbox" id="cb11" name="freqs[]" value="144 MHz">
  <label for="cb11">144 MHz</label><br>

  <input type="checkbox" id="cb12" name="freqs[]" value="432 MHz">
  <label for="cb12">432 MHz</label><br>

  <input type="checkbox" id="cb13" name="freqs[]" value="1.2 GHz">
  <label for="cb13">1.2 GHz</label><br>

  <input type="checkbox" id="cb14" name="freqs[]" value="2.3 GHz">
  <label for="cb14">2.3 GHz</label><br>

</fieldset>
<!-- MODES -->
<fieldset>
  <legend>I will use modes:</legend>

  <input type="checkbox" id="CW" name="modes[]" value="CW">
  <label for="CW">CW</label><br>

  <input type="checkbox" id="SSB" name="modes[]" value="SSB">
  <label for="SSB">SSB</label><br>

  <input type="checkbox" id="FM" name="modes[]" value="FM">
  <label for="FM">FM</label><br>

  <input type="checkbox" id="RTTY" name="modes[]" value="RTTY">
  <label for="RTTY">RTTY</label><br>

  <input type="checkbox" id="MFSK" name="modes[]" value="MFSK">
  <label for="MFSK">MFSK (JT65, FT8...)</label><br>

  <input type="checkbox" id="IMAGING" name="modes[]" value="IMAGING">
  <label for="IMAGING">IMAGING (ATV, SSTV...)</label><br>

  <input type="checkbox" id="OTHER DIGITAL" name="modes[]" value="OTHER DIGITAL">
  <label for="OTHER DIGITAL">OTHER DIGITAL</label><br>

</fieldset>
<!-- OPERATOR CALL -->
<label for="operator-call">Operator call sign:</label>
<input type="text" id="operator-call" name="ocall">
<!-- OPERATOR NAME -->
<label for="operator-name">Operator name:</label>
<input type="text" id="operator-name" name="oname">
<!-- OPERATOR EMAIL -->
<label for="operator-email">Operator email:</label>
<input type="email" id="operator-email" name="email">
<!-- OPERATOR PHONE -->
<label for="operator-phone">Operator phone:</label>
<input type="tel" id="operator-phone" name="phone">
<!-- SUBMIT BUTTON -->
<input type="submit" value="Submit reservation request">
</form>

</main>
</body>
</html>
