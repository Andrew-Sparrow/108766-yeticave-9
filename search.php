<?php
require_once('init.php');

$page_title = 'Поиск';

$result_search_amount = 0;
$result_set = [];
$page_range = '';
$pages_number = '';
$cur_page = '';
$items_on_page = 0;
$errors = [];

$cur_page = $_GET['page'] ?? 1;
$items_on_page = 9;

$search_data = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search_data !== '') {
    
    $sql = "SELECT COUNT(*) AS cnt
          FROM lots
          WHERE MATCH(lots.title, lots.description) AGAINST(? IN BOOLEAN MODE)
          AND lots.end_date > CURDATE()";
    
    $result_search_amount = db_fetch_data($sql, [$search_data])[0]['cnt'] ?? 0;
}

$pages_number = ceil($result_search_amount / $items_on_page);

$offset = ($cur_page - 1) * $items_on_page;

$page_range = range(1, $pages_number);

$sql_set_of_lots = 'SELECT lots.id ,
          categories.title AS category,
          start_price,
          lots.title as title,
          lots.img_src AS lot_img,
          end_date as end_date
          FROM lots
          JOIN categories ON categories.id = lots.category_id
          WHERE MATCH(lots.title, lots.description) AGAINST(? IN BOOLEAN MODE)
          AND lots.end_date > CURDATE()
          ORDER BY lots.dt_add DESC
          LIMIT ' . $items_on_page . ' OFFSET ' . $offset;

$result_set_of_lots = db_fetch_data($sql_set_of_lots, [$search_data]);

$content = include_template(
    "search_content.php",
    [
        "result_set_of_lots"   => $result_set_of_lots,
        "page_range"           => $page_range,
        "result_search_amount" => $result_search_amount,
        "cur_page"             => $cur_page,
        "items_on_page"        => $items_on_page,
    ]
);

$layout = include_template(
    'simple_layout.php',
    [
        'page_title' => $page_title,
        'content'    => $content,
        'categories' => $categories,
        'is_auth'    => $is_auth,
        'user_name'  => $user_name,
        "errors"     => $errors
    ]
);


print ($layout);