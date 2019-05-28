<?php
//showing existing lot
require_once("init.php");

$page_title = 'Ошибка';

$content = include_template('404_content.php', []);

$templete_404 = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories,
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

$new_bet = [];

$errors = [];

//вывод страницы 404, если нет lot'а с таким id
if (is_null($lot)) {
  http_response_code(404);
  print ($templete_404);
  exit();
}

if (isset($_SESSION['user'])) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $new_bet = [
      'cost' => $_POST['cost'] ?? null
    ];
  
    
    if (!is_numeric($new_bet['cost'])) {
      $errors['cost'] = 'Введите число';
    }
    elseif ($new_bet['cost'] <= 0 ) {
      $errors['cost'] = 'Введите число больше нуля';
    }
    elseif (empty($new_bet['cost'])) {
      $errors['cost'] = 'Это поле надо заполнить';
    }
    $new_bet['cost'] = intval(trim($new_bet['cost']));
    
    var_dump($new_bet);
  }
}

$page_title = strip_tags($lot['title']);

$content = include_template(
  "lot_content.php",
  [
    "lot"           => $lot,
    "current_price" => $current_price,
    "min_rate"      => $min_rate,
    "errors"        => $errors
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories,
  ]
);

print ($layout);
