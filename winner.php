<?php
require_once 'init.php';

$link = DbConnectionProvider::getConnection();

$winners = get_winners();

$sql_winners = "SELECT lots.id as lot_id , lots.title AS lot_title, lots.end_date AS lot_end_date , rates.rate AS win_rate , rates.user_id AS win_user_id
                FROM lots
                JOIN rates
                ON lots.id = rates.lot_id
                WHERE winner_id IS NULL AND lots.end_date <= CURDATE()
                and rates.dt_add in (SELECT MAX(rates.dt_add) from rates GROUP BY lot_id);";

$sql_update_winners = "UPDATE lots SET winner_id = ? WHERE lots.id = ?;";

foreach ($winners as $key => $val) {
  
  $query_win = mysqli_query($link, $sql_winners);
  
  $data = [$val['win_user_id'], $val['lot_id']];
  
  $stmt = db_get_prepare_stmt($link, $sql_update_winners, $data);
  $result = mysqli_stmt_execute($stmt);
 }

