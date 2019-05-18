<?php
require_once("init.php");

$errors = [];
$page_title = 'Страница входа';

$enter_content = include_template(
  'enter_content.php',
  [
    'errors' => $errors
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $enter_content,
    'categories' => $categories,
    'user_name'  => $user_name
  ]
);

print ($layout);
