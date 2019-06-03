<?php

require_once('init.php');

$page_title = 'Поиск';
$result_search = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  
  $search_data = trim($_GET['search']) ?? '';
  
  if ($search_data) {
    
    $sql = "SELECT lots.id ,
            categories.title AS category,
            start_price,
            lots.title as title,
            lots.img_src AS lot_img,
            end_date as end_date
            FROM lots
            JOIN categories ON categories.id = lots.category_id
            WHERE MATCH(lots.title, description) AGAINST(? IN BOOLEAN MODE)";
    
    $result_search = db_fetch_data($sql, [$search_data]);
  }
}
var_dump($result_search);

$content = include_template(
  "search_content.php",
  [
    "result_search" => $result_search
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories
  ]
);

print ($layout);