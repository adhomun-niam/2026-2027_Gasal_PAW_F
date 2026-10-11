<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");
print_r($weight);
echo "<br>" . "<br>";
for ($i = 0; $i < count($weight); $i++) {
    echo key($weight) . " is " . current($weight) . " kg<br>";
    next($weight);
}