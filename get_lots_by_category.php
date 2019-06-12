<?php
require_once('init.php');
require_once('404.php');

isset_get_404('category_id', $template_404);

//array of categories id
$value_of_categories_id = array_column($categories, 'id');

if (!in_array(intval($_GET['category_id']), $value_of_categories_id, true)) {
    http_response_code(404);
    print ($template_404);
    exit();
}

$page_title = 'Лоты по категориям';

$result_search_amount = 0;
$result_set = [];
$page_range = '';
$pages_number = '';

$cur_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_on_page = 9;

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

$sql = "SELECT COUNT(*) AS cnt
        FROM lots
        WHERE lots.category_id = ?
        AND lots.end_date > CURDATE()";

$result_search_amount = db_fetch_data($sql, [$category_id])[0]['cnt'] ?? 0;

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
          WHERE lots.category_id = ?
          AND lots.end_date > CURDATE()
          ORDER BY lots.dt_add DESC
          LIMIT ? OFFSET ?';

$result_set_of_lots = db_fetch_data($sql_set_of_lots, [$category_id, $items_on_page, $offset]);

$content = include_template(
    "lots_by_category_content.php",
    [
        "result_set_of_lots"   => $result_set_of_lots,
        "page_range"           => $page_range,
        "result_search_amount" => $result_search_amount,
        "cur_page"             => $cur_page,
        "items_on_page"        => $items_on_page
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
