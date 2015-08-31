<?php

/*

SELECT DATE(time_placed) AS date,
       COUNT(id) as requests
  FROM trade_message
 GROUP BY date
 ORDER BY date ASC

*/

$dp = new DatePeriod(
    new DateTime('1 month ago'),
    new DateInterval('P1D'),
    new DateTime()
);

$dates = array_map(function($dt) {
    return $dt->format('Y-m-d');
}, iterator_to_array($dp));

$range = array_fill_keys($dates, 0);

$results = [
    '2015-07-31' => 1,
    '2015-08-05' => 8,
    '2015-08-06' => 12,
    '2015-08-08' => 2,
    '2015-08-09' => 15,
    '2015-08-15' => 32,
    '2015-08-16' => 45,
    '2015-08-21' => 43,
    '2015-08-22' => 29,
    '2015-08-23' => 4,
    '2015-08-26' => 8,
    '2015-08-27' => 18,
    '2015-08-28' => 12,
    '2015-08-29' => 6,
    '2015-08-30' => 9,
];

$merged = array_replace($range, $results);

$rotated = [
    'date'  => array_keys($merged),
    'messages' => array_values($merged),
];

header('Content-Type: application/json');
echo json_encode($rotated, JSON_NUMERIC_CHECK);
