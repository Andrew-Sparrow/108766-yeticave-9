<?php
//http_response_code(404);
require_once("init.php");

set_timezone("Asia/Yekaterinburg");

$categories = get_categories();
//array_key_exists("id", $_GET)


$sql =
"SELECT lots.id , categories.title AS category, lots.description,
  start_price, lots.title as title, img_src, end_date
FROM lots
JOIN categories ON categories.id = lots.category_id
where lots.id = ?";


if (isset($lot_id)) {
  $lot = db_fetch_data($sql, [$lot_id]);
  $content_lot = include_template(
    "content_lot.php",
    [
      "categories" => $categories,
      "lot" => $lot
    ]
  );
  
  print($content_lot);
}
else {
  http_response_code(404);
}





