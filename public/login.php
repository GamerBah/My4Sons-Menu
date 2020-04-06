<?php
$edit = file_get_contents('php://input');
$item_arr = json_decode($edit, true);
$b = array_pop($item_arr);
$a = array_pop($item_arr);
if (!empty($a) && !empty($b)) {
    if ($a == 'admin' && $b == 'password') {
        setcookie("auth", $a, time() + 64800, "/");
        echo 0;
    } else {
        echo 1;
    }
}

