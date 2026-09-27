<?php
function familyName($fname, $year) {
    return "<h1>" . $fname . " " ."born in " . $year . "</h1>";
}
echo familyName("Hege", "1975");
echo familyName("Stale", "1978");
echo familyName("Kai Jim", "1983");
?>