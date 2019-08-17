<?php
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Origin: *");

$edit = file_get_contents('php://input');
$item_arr = json_decode($edit, true);
$b = array_pop($item_arr);
$a = array_pop($item_arr);
if (!empty($a) && !empty($b)) {
    if ($a == 'a' && $b == 'b') {
        setcookie("auth", $a, time() + 3600, "/");
        echo 0;
    } else {
        echo 1;
    }
}

