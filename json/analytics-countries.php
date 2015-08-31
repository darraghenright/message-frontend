<?php

// create a placeholder country range

function xrand($min = 0, $max = 100, $limit = 30) {
    while($limit--) {
        yield mt_rand($min, $max);
    }
}

$countries = array_map(function($country) {
    return ['name' => $country, 'data' => iterator_to_array(xrand())];
}, ['FR', 'GB', 'IE', 'US']);

header('Content-Type: application/json');
echo json_encode($countries, JSON_NUMERIC_CHECK);
