<?php
$height = array("Andy"=>"176","Barry"=>"165","Charlie"=>"170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

print_r($height);
echo "<br>";
echo "nilai dengan indeks terakhir : " . end($height) . "<br>";
unset ($height["Barry"]);
print_r($height);
echo "<br>";
echo "nilai dengan indeks terakhir setelah dihapus: " . end($height);
?>