<!DOCTYPE html>
<html>
<head>
<title>Posted Data</title>
</head>
<body>
<h3>Posted data: </h3>
<?php
foreach ($_POST as $key => $value)
    echo "($key) => ($value)<br/>";
require 'validate.inc';
$errors = array();
validateName($errors, $_POST, 'surname');
if ($errors)
{
    echo '<h2>Errors:</h2>';
    foreach ($errors as $field => $error)
        echo "<p>$field: $error</p>";
}
else
    echo '<h2>Data OK!</h2>';
?>
</body>
</html>