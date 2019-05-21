<?php
require_once("init.php");

set_timezone("Asia/Yekaterinburg");

//$user_name = "Андрей"; // укажите здесь ваше имя
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
    "user_name"    => $user_name,
    "title"        => $title,
    "main_content" => $main_content,
    "categories"   => $categories
  ]
);

print($layout);
