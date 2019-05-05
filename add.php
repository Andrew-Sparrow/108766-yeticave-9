<?php

require_once("init.php");

set_timezone("Asia/Yekaterinburg");

$user_name = "Андрей";

$categories = get_categories();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['lot-picture'])) {
  
  $filename = uniqid().'.jpg';
  
  move_uploaded_file($_FILES['lot-picture']['tmp_name'], 'uploads/' . $filename);
}


$add_content = include_template(
  "add_content.php",
  [
    "categories" => $categories,
    "user_name"  => $user_name
  ]
);

print($add_content);