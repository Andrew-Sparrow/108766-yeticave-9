<?php
require_once 'init.php';

//get rates where lots without winners and end_date in the past or equals today
$sql_rates = "SELECT rates.lot_id, rates.rate, rates.user_id
              FROM rates
              WHERE rates.lot_id in (
                SELECT lots.id
                FROM lots
                WHERE winner_id IS NULL AND lots.end_date <= CURDATE()
              )";

$rates = db_fetch_data($sql_rates);

$maxRates = [];

//find out max rates
foreach ($rates as $rate) {
  if (!isset($maxRates[$rate['lot_id']])) {
    $maxRates[$rate['lot_id']] = $rate;
    continue;
  }
  
  if ($rate['rate'] > $maxRates[$rate['lot_id']]['rate']) {
    $maxRates[$rate['lot_id']] = $rate;
  }
}

$sql_update = "UPDATE lots SET winner_id = ? WHERE lots.id = ?;";

foreach ($maxRates as $mRate) {
  db_update_data($sql_update, [$mRate['user_id'], $mRate['lot_id'] ]);
}
