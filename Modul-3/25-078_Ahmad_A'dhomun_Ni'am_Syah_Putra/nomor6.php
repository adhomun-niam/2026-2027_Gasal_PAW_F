<?php
// array_push() - menambah data di akhir array
$a = array("A");
echo 'Array awal: ("A")<br>';
array_push($a, "B");
echo "Hasil array_push: " . implode($a) . "<br><br>";

// array_merge() - menggabungkan dua array
$b1 = array("A", "B");
$b2 = array("C");
$gabung = array_merge($b1, $b2);
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo "Hasil array_merge: " . implode($gabung) . "<br><br>";

// array_values() - mengambil semua nilai, indeks jadi angka
$c = array("x" => 1, "y" => 2);
$nilai = array_values($c);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo "Hasil array_values: " . implode($nilai) . "<br><br>";

// array_search() - mencari indeks dari sebuah nilai
$d = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . array_search("B", $d) . "<br><br>";

// array_filter() - membuang nilai kosong
$e = array(0, 1, false, 2, "", 3, "array");
$hasilFilter = array_filter($e);
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo "Hasil array_filter: " . implode($hasilFilter) . "<br><br>";

// 6. Sorting array terindeks
$f = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($f);   // urutan depan-belakang
echo "Hasil sort: " . implode($f) . "<br>";
rsort($f);  // urutan belakang-depan
echo "Hasil rsort: " . implode($f) . "<br><br>";

$age = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

asort($age);   // urutan value naik
echo "Hasil asort: ";
print_r($age);
echo "<br>";

ksort($age);   // urutan key naik
echo "Hasil ksort: ";
print_r($age);
echo "<br>";

arsort($age);  // urutan value turun
echo "Hasil arsort: ";
print_r($age);
echo "<br>";

krsort($age);  // urutan key turun
echo "Hasil krsort: ";
print_r($age);
echo "<br>";
?>