<?php

require_once __DIR__ . '/db.php';

$dates = getMinAndMaxDates($db);
$range = array_fill_keys($dates, 0);

$stmt = $db->prepare('
    SELECT DATE(time_placed) AS date,
           COUNT(id) as messages
      FROM trade_message
     GROUP BY date
     ORDER BY date ASC
');

$stmt->execute();
$data = [];
$stmt->fetchAll(PDO::FETCH_FUNC, function($date, $messages) use (&$data) {
    $data[$date] = (int) $messages;
});

$merged = array_replace($range, $data);

$rotated = [
    'date'     => array_keys($merged),
    'messages' => array_values($merged),
];

header('Content-Type: application/json');
echo json_encode($rotated, JSON_NUMERIC_CHECK);
