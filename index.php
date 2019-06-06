<?php
require_once("init.php");
require_once("winner.php");
require_once("getwinner.php");

$title = "Главная";

if (isset($_SESSION['user']['name'])) {
  $user_name = $_SESSION['user']['name'];
}

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
    "categories"   => $categories
  ]
);

print($layout);

