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
    'is_auth'    => $is_auth,
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

$min_rate = $current_price + $lot['step'] + 1;

$new_bet = [];

$errors = [];

$is_lot_author_other_user = false;

$bets = get_bets($lot_id);

$last_bet = get_last_bet($lot_id);

$is_user_last_bet_other = true;

//вывод страницы 404, если нет lot'а с таким id
if (is_null($lot)) {
  http_response_code(404);
  print ($templete_404);
  exit();
}

if (isset($_SESSION['user']['id'])) {
  
  $user_id = $_SESSION['user']['id'];
  
  $is_lot_author_other_user = $user_id !== $lot['author_id'];
  
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $new_bet = $_POST['cost'] ?? null;
  
    //if $new_bet equals zero it will be empty($new_bet) == true
    if (empty($new_bet)) {
      $errors['cost'] = 'Это поле надо заполнить';
    }
    elseif (!is_numeric($new_bet)) {
      $errors['cost'] = 'Введите число';
    }
    elseif ($new_bet < 0) {
      $errors['cost'] = 'Введите число больше нуля';
    }
    elseif ($new_bet < $min_rate) {
      $errors['cost'] = 'Значение должно быть больше либо равно минимальной ставке';
    }
    elseif (!ctype_digit($new_bet)) {
      $errors['cost'] = 'Введите целое число';
    }
  
    if (empty($errors)) {
      $new_bet = intval(trim($new_bet));
    
      $sql = "INSERT INTO rates (rate, user_id, lot_id)
      VALUES ( ?, ?, ?)";
    
      $bet = db_insert_data(
        $sql,
        [
          $new_bet,
          $user_id,
          $lot_id
        ]
      );
    }
  }
  
  //for showing or not block of entering new bet
  //verify if last bet made by other user than this one
  if (isset($last_bet['user_id'])) {
    $is_user_last_bet_other = $user_id != $last_bet['user_id'];
  }
}

//verify if lot's end_date in the future
$is_end_date_in_future = date_create($lot['end_date']) > new DateTime("now");

$page_title = strip_tags($lot['title']);

$content = include_template(
  "lot_content.php",
  [
    "lot"                      => $lot,
    "current_price"            => $current_price,
    "min_rate"                 => $min_rate,
    "bets"                     => $bets,
    "errors"                   => $errors,
    "is_end_date_in_future"    => $is_end_date_in_future,
    "is_lot_author_other_user" => $is_lot_author_other_user,
    "is_user_last_bet_other"   => $is_user_last_bet_other
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories,
    'is_auth'    => $is_auth,
    'user_name'  => $user_name
  ]
);

print ($layout);
