<?php
require_once("init.php");

$templete_404 = include_template("404_content.php", ["categories" => $categories]);

if (!isset($_GET['id'])) {
  http_response_code(404);
  print ($templete_404);
  exit();
}

if (isset($_GET['id']) && $_GET['id'] === '') {
  http_response_code(404);
  print ($templete_404);
  exit();
}

$lot_id = $_GET['id'];

$lot = get_lot($lot_id);

$current_price = get_current_price($lot_id);

$min_rate = $current_price + $lot['step'];

//вывод страницы 404, если нет lot'а с таким id
if (is_null($lot)) {
  http_response_code(404);
  print ($templete_404);
  exit();
}

$content_lot = include_template(
  "lot_content.php",
  [
    "categories" => $categories,
    "lot"        => $lot,
    "current_price" => $current_price,
    "min_rate" => $min_rate
  ]
);

print($content_lot);








