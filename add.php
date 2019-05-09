<?php
require_once("init.php");

$lot = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' /*&& isset($_FILES['lot-picture'])*/) {
  
  
  $lot = [
    'title'       => $_POST['title'] ?? null,
    'category_id' => $_POST['category_id'] ?? null,
    'description' => $_POST['description'] ?? null,
    'start_price' => $_POST['start_price'] ?? null,
    'lot_step'    => $_POST['lot_step'] ?? null,
    'end_date'    => $_POST['end_date'] ?? null
  ];
  
  $required = ['title', 'category_id', 'description', 'start_price', 'lot_step', 'end_date'];
  
  $dict = ['title' => 'Название', 'description' => 'Описание'];
  
  foreach ($required as $req) {
    if (empty($_POST[$req])) {
      $errors[$req] = 'Это поле надо заполнить';
    }
  }
  
  if (count($errors)) {
    $page_content = include_template(
      'add_content.php',
      [
        'lot' => $lot,
        'errors' => $errors,
        'dict' => $dict,
        'categories' => $categories,
        'user_name'  => $user_name
      ]
    );
    
    print ($page_content);
  }
  else {
    $sql = 'INSERT INTO lots (title, category_id, description, author_id,
             start_price, end_date, step, img_src)
          VALUES ( ?, 4,  "smth", 1 , 100, "2019-12-30", 100, "img/name.jpg")';
  
  
    $new_lot_id = db_insert_data($sql, [$lot['title']/*, $lot['category_id'],
    $lot['description'], $lot['start_price'], $lot['end_date'], $lot['lot_step']*/]);
  
  
  
    if ($new_lot_id) {
    
      header("Location: lot.php?id=" . $new_lot_id);
    }
  }
  
  //$filename = uniqid() . '.jpg';
  
  
 // move_uploaded_file($_FILES['lot-picture']['tmp_name'], 'uploads/' . $filename);
 
  
}
else {
  $add_content = include_template(
    "add_content.php",
    [
      "categories" => $categories,
      "user_name"  => $user_name
    ]
  );
  
  print($add_content);
}







