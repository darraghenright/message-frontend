<?php

/**
 * getDateRange
 *
 * @param  PDO    $db
 * @param  string $format
 * @return array
 */
function getDateRange(PDO $db, $format = 'Y-m-d')
{
    $stmt = $db->prepare('
        SELECT MIN(DATE(time_placed)) AS date_min
          FROM trade_message
    ');

    $stmt->execute();
    $dateMin = $stmt->fetch(PDO::FETCH_COLUMN);

    $dp = new DatePeriod(
        new DateTime($dateMin),
        new DateInterval('P1D'),
        new DateTime('tomorrow')
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
