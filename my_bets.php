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
    'is_auth'    => $is_auth,
    'user_name'  => $user_name
  ]
);

print ($layout);

