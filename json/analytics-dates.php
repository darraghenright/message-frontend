<?php

// create a placeholder date range
// between two months ago and today.

sleep(1); // mock delay

$dp = new DatePeriod(
    new DateTime('1 month ago'),
    new DateInterval('P1D'),
    new DateTime()
);

$dates = ['dates' => array_map(function($dt) {
    return $dt->format('D, jS M Y'); // e.g: Wed. 1st July 2015
}, iterator_to_array($dp))];

header('Content-Type: application/json');
echo json_encode($dates);
