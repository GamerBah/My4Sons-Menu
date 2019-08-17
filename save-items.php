<?php
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Origin: *");

$data = file_get_contents('items.json');
$edit = file_get_contents('php://input');

// decode json to associative array
$json_arr = json_decode($data, true);
$item_arr = json_decode($edit, true);

foreach ($json_arr as $key => $value) {
    if ($value['name'] === $item_arr['name']) {
        if ($value['name'] !== $item_arr['name']) {
            $json_arr[$key]['name'] = $item_arr['name'];
        }
        if ($value['price'] !== $item_arr['price']) {
            $json_arr[$key]['price'] = $item_arr['price'];
        }
        if ($value['status'] !== $item_arr['status']) {
            $json_arr[$key]['status'] = $item_arr['status'];
        }
        break;
    }
}
// encode array to json and save to file
file_put_contents('items.json', json_encode($json_arr));
