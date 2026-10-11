<?php
$height = array("Andy"=>"176","Barry"=>"165","Charlie"=>"170");
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

print_r($height);
echo "<br>" . "<br>";
for ($i = 0; $i < count($height); $i++) {
    echo key($height) . " is " . current($height) . " cm tall" . "<br>";
    next($height);
}
?>