<?php
require_once("init.php");

$page_title = 'Мои ставки';
$user_bets = [];


if (!isset($_SESSION['user']['id'])) {
  http_response_code(403);
  exit();
}

if (isset($_SESSION['user']['id'])) {
  
  $user_id = $_SESSION['user']['id'];
  
  $user_bets = get_user_bets($user_id);
}
var_dump($user_bets);
var_dump($user_bets[0]['lot_end_date']<= strtotime('now'));

$content = include_template(
  "my_bets_content.php",
  [
    "user_bets" => $user_bets
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

