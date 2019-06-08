<?php
require_once("init.php");
require_once("get_winners.php");

$title = "Главная";

$categories = get_categories();
$lots = get_lots();

$main_content = include_template(
  "main.php",
  [
    "categories" => $categories,
    "lots"       => $lots,
  ]
);

$layout = include_template(
  "layout.php",
  [
    "title"        => $title,
    "main_content" => $main_content,
    "categories"   => $categories,
    'is_auth'      => $is_auth,
    'user_name'    => $user_name
  ]
);

print($layout);