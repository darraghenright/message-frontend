<?php

// create a placeholder date range
// between two months ago and today.

$dp = new DatePeriod(
    new DateTime('2 months ago'),
    new DateInterval('P1D'),
    new DateTime()
);

$dates = ['dates' => array_map(function($dt) {
    return $dt->format('D, jS M Y'); // e.g: Wed. 1st July 2015
}, iterator_to_array($dp))];

echo json_encode($dates);
