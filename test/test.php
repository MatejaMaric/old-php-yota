<?php
$lol->a="a1";
$lol->b="b1";
$lol->c="c1";

echo "<b>Stuff: </b><br>";
print_r($lol);
echo "<br><b>More stuff: </b><br>";
var_dump($lol);
echo "<br><b>Even more stuff: </b><br>";
foreach ($lol as $key => $value) {
	echo "$key -> $value<br>";
}
