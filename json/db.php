<?php

/**
 * getMinAndMaxDates
 *
 * @param  PDO    $db
 * @param  string $format
 * @return array
 */
function getMinAndMaxDates(PDO $db, $format = 'Y-m-d')
{
    $stmt = $db->prepare('
        SELECT MIN(DATE(time_placed)) AS date_min,
               MAX(DATE(time_placed)) AS date_max
          FROM trade_message
    ');

    $stmt->execute();
    $dates = $stmt->fetch(PDO::FETCH_OBJ);

    $dp = new DatePeriod(
        new DateTime($dates->date_min),
        new DateInterval('P1D'),
        new DateTime($dates->date_max)
    );

    return array_map(function($dt) use ($format){
        return $dt->format($format);
    }, iterator_to_array($dp));
}

// connect
try {
    $db = new PDO('mysql:host=localhost;dbname=message_consumer', 'root');
} catch (PDOException $e) {
    header('HTTP/1.1 503 Service Unavailable');
    exit();
}
