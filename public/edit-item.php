<?php
// decode json to associative array
$existing_array = json_decode(file_get_contents('items.json'), true);
$overwrite_array = json_decode(file_get_contents('php://input'), true);

foreach ($existing_array as $key => $value) {
    if ($value['name'] === $overwrite_array['oldName']) {
        if ($value['name'] !== $overwrite_array['name']) {
            $existing_array[$key]['name'] = $overwrite_array['name'];
        }
        if ($value['status'] !== $overwrite_array['status']) {
            $existing_array[$key]['status'] = $overwrite_array['status'];
        }
        if ($value['specials'] !== $overwrite_array['specials']) {
            $existing_array[$key]['specials'] = $overwrite_array['specials'];
        }
        break;
    }
}

// encode array to json and save to file
file_put_contents('items.json', json_encode($existing_array, JSON_PRETTY_PRINT));
