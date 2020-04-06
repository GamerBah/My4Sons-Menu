<?php
$existing_array = json_decode(file_get_contents('items.json'), true);
$overwrite_array = json_decode(file_get_contents('php://input'), true);

foreach ($existing_array as $key => $value) {
    if ($value['name'] === $overwrite_array['name']
        && $value['status'] === $overwrite_array['status']
        && $value['subItems'] === $overwrite_array['subItems']) {
        unset($existing_array[$key]);

    }
}

$existing_array = array_values($existing_array);

// encode array to json and save to file
file_put_contents('items.json', json_encode($existing_array, JSON_PRETTY_PRINT));
