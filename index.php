<?php
require_once("helpers.php");
require_once("date_functions.php");
require_once("init.php");

set_timezone("Asia/Yekaterinburg");

$user_name = "Андрей"; // укажите здесь ваше имя
$title = "Главная";

$categories = [];
$lots = [];
$error = '';
$main_content = '';
$categories_content = '';
$categories_content_footer = '';


 /*я пытался уменьшить блоки if-else'ы, с помощью самописной функции get_content()
 из date_functions.php
 */

// запрос на отображение категорий
if(!$connection) {
  $error = mysqli_connect_error();
  $categories_content = $categories_content_footer = include_template('error.php', ['error' => $error]);
}
else {
  $sql = 'SELECT id, title, symbol_code FROM categories';
  $result_categories = mysqli_query($connection, $sql);
  
  if($result_categories) {
    
    // возвращает массив категорий
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
    
    $categories_content = include_template("categories_content.php", ["categories" => $categories]);
    $categories_content_footer = include_template("categories_content_footer.php", ["categories" => $categories]);
  }
  else {
    $error = mysqli_error($connection);
    $categories_content = $categories_content_footer = include_template('error.php', ['error' => $error]);
  }
}

//запрос на отображение лотов
if(!$connection) {
  $error = mysqli_connect_error();
  $main_content = include_template('error.php', ['error' => $error]);
}
else {
  
  $sql_lots = 'SELECT lots.id, lots.title as lot_title, start_price , img_src
              FROM lots
              LIMIT 6';
  
  $result_lots = mysqli_query($connection, $sql_lots);
  
  if($result_lots) {
    $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    
    $main_content = include_template(
      "main.php",
      [
        "categories_content" => $categories_content,
        "lots" => $lots
      ]
    );
  }
  else {
    $error = mysqli_error($connection);
    $main_content = include_template('error.php', ['error' => $error]);
  }
}


$layout = include_template(
  "layout.php",
  [
    "main_content" => $main_content,
    "categories_content_footer" => $categories_content_footer,
    "user_name"    => $user_name,
    "title"        => $title
  ]
);

print($layout);





