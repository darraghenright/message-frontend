<?php

require_once __DIR__ . '/db.php';

// build available date range
$dates = getMinAndMaxDates($db);
$range = array_fill_keys($dates, 0);

// get list of originating countries
$stmt = $db->prepare('
    SELECT DISTINCT originating_country
      FROM trade_message
');

$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_COLUMN);

// get stats for each country
$result = [];

foreach ($countries as $country) {

    $stmt = $db->prepare('
        SELECT DATE(time_placed) AS date,
               COUNT(id)         AS messages
          FROM trade_message
         WHERE originating_country = :country
         GROUP BY date
         ORDER BY date ASC;
    ');

    $stmt->execute(['country' => $country]);
    $data = [];
    $stmt->fetchAll(PDO::FETCH_FUNC, function($date, $messages) use (&$data) {
        $data[$date] = $messages;
    });

    $result[] = [
        'name' => $country,
        'data' => array_values(array_replace($range, $data)),
    ];
}

header('Content-Type: application/json');
echo json_encode($result, JSON_NUMERIC_CHECK);
