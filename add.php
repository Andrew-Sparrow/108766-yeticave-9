<?php

require_once("init.php");

$categories = get_categories();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['lot-picture'])) {
  
  $filename = uniqid().'.jpg';
  
  //header("Location:/index.php?success=true");
  
  move_uploaded_file($_FILES['lot-picture']['tmp_name'], 'uploads/' . $filename);
  
  $category_id = $_POST['category'];
  $title = $_POST['lot-title'];
  $description = $_POST['description'];
  
  
  $sql = 'INSERT INTO lots (dt_add, category_id, user_id, title, description,
            img_src, start_price, end_date, step)
          VALUES (NOW(), ?, 1, ?, ?, ?, ?, ?, ?)';
  
  
  $new_lot_id = db_insert_data($sql, [$category_id, ]);
  
  header("Location: lot.php?id=" . $new_lot_id);
}

$add_content = include_template(
  "add_content.php",
  [
    "categories" => $categories,
    "user_name"  => $user_name
  ]
);

print($add_content);