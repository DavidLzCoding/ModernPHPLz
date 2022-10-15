<?php

$array = array("a", "b", "c", "d", "e");
foreach ($array as &$color) {
    $color = strtoupper($color);
}
unset($color); /* ensure that following writes to
$color will not modify the last array element */

print_r($array);
?>
