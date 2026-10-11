<?php
$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca",  "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

echo "Data awal:<br>";
print_r($students);
echo "<br><br>";

echo "Data setelah ditambah 5 data lain:<br>";
array_push($students,
    array("Daniel", "220404", "0812345611"),
    array("Elena",  "220405", "0812345622"),
    array("Fiona",  "220406", "0812345633"),
    array("Gabe",   "220407", "0812345644"),
    array("Hannah", "220408", "0812345655")
);
print_r($students);
echo "<br><br>";

echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr><th>Nama</th><th>NIM</th><th>No. Mobile</th></tr>";

foreach ($students as $baris) {
    echo "<tr>";
    echo "<td>" . $baris[0] . "</td>";
    echo "<td>" . $baris[1] . "</td>";
    echo "<td>" . $baris[2] . "</td>";
    echo "</tr>";
}
echo "</table>";    
?>