<?php
$existing_array = json_decode(file_get_contents('items.json'), true);
$overwrite_array = json_decode(file_get_contents('php://input'), true);

foreach ($existing_array as $key => $value) {
    if ($value['name'] === $overwrite_array['name']
        && $value['status'] === $overwrite_array['status']) {
        $subItems = $value['subItems'];
        array_push($subItems, $overwrite_array['subItem']);
        usort($subItems, function ($a, $b) {
            return $a['price'] <=> $b['price'];
        });
        $existing_array[$key]['subItems'] = $subItems;
    }
}

// encode array to json and save to file
file_put_contents('items.json', json_encode($existing_array, JSON_PRETTY_PRINT));
