<?php
//showing existing lot
require_once("init.php");
$page_title = 'Ошибка';
$user_name = "Андрей";

$content = include_template('404_content.php',[]);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories,
    'user_name'  => $user_name
  ]
);

$templete_404 = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories,
    'user_name'  => $user_name
  ]
);

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

$page_title = strip_tags($lot['title']);

$content = include_template(
  "lot_content.php",
  [
    "lot"           => $lot,
    "current_price" => $current_price,
    "min_rate"      => $min_rate
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories,
    'user_name'  => $user_name
  ]
);

print ($layout);

