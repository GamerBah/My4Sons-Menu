<?php

$items = json_decode(file_get_contents('items.json', true));
$data = json_decode(file_get_contents('php://input'), true);

array_push($items, $data);

file_put_contents("items.json", json_encode($items, JSON_PRETTY_PRINT));
