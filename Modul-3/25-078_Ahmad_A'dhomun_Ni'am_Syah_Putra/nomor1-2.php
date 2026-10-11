<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
array_push($fruits, "Durian", "Elderberry", "Fig", "Grapes", "Honeydew");
unset($fruits[1]);
echo "Data Blueberry dihapus. <br>";
print_r($fruits);
echo "<br>";
echo "nilai dengan indeks tertinggi : " . end($fruits);
?>