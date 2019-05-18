<?php
//adding new lot
require_once("init.php");
$lot = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  $lot = [
    'title'       => $_POST['title'] ?? null,
    'category_id' => $_POST['category_id'] ?? null,
    'description' => $_POST['description'] ?? null,
    'start_price' => $_POST['start_price'] ?? null,
    'lot_step'    => $_POST['lot_step'] ?? null,
    'end_date'    => $_POST['end_date'] ?? null,
    'lot-picture' => $_FILES['lot-picture'] ?? null
  ];
  
  $required = [
    'title',
    'category_id',
    'description',
    'start_price',
    'lot_step',
    'end_date'
  ];
  
  foreach ($required as $req) {
    if (empty($lot[$req])) {
      $errors[$req] = 'Это поле надо заполнить';
    }
  }

  foreach ($required as $req) {
    trim($lot[$req]);
  }

  //verifying start price
  if (!is_numeric($lot['start_price'])) {
    $errors['start_price'] = 'Введите число';
  }
  elseif ($lot['start_price'] <= 0) {
    $errors['start_price'] = 'Введите число больше нуля';
  }
  
  //verifying lot step
  if (!is_numeric($lot['lot_step'])) {
    $errors['lot_step'] = 'Введите число';
  }
  elseif ($lot['lot_step'] <= 0) {
    $errors['lot_step'] = 'Введите число больше нуля';
  }
  elseif (!ctype_digit($lot['lot_step'])) {
    $errors['lot_step'] = 'Введите целое число';
  }
  
  //verifying date of ending
  
  if (empty($errors['end_date']) && !is_date_valid($lot['end_date'])) {
    $errors['end_date'] = 'Введите дату в указанном формате';
  }
  elseif (!more_than_day($lot['end_date'])) {
    $errors['end_date'] = 'Дата должна быть больше текущей даты, хотя бы на один день';
  }
  
  //img verifying ---------------------------
  
  if (isset($_FILES['lot-picture']['error']) &&
    $_FILES['lot-picture']['error'] === UPLOAD_ERR_NO_FILE) {
    
    $errors['lot-picture'] = 'Добавьте файл';
  }
  //verifying if file size more than 2Mb
  if (isset($_FILES['lot-picture']) &&
    ($_FILES['lot-picture']['size'] > 2097152 || $_FILES['lot-picture']['error'] === UPLOAD_ERR_INI_SIZE)) {
    
    $errors['lot-picture'] = 'Размер файла превысил допустимое значение';
  }
  //if post_max_size=0 (unlimited)
  elseif ( empty($_POST) && empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0 ) {
  
    $displayMaxSize = ini_get('post_max_size');
    
    switch ( substr($displayMaxSize,-1) ) {
      case 'G':
        $displayMaxSize = intval($displayMaxSize) * 1024;
      case 'M':
        $displayMaxSize = intval($displayMaxSize) * 1024;
      case 'K':
        $displayMaxSize = intval($displayMaxSize) * 1024;
    }
    
    $errors['lot-picture'] = 'размер файла- '. $_SERVER['CONTENT_LENGTH'].
      ' bytes превышает максимальный размер '. $displayMaxSize.' bytes.' . 'в настройках сервера' ;
  }
  
  //verifying MIME type of file
  if (empty($errors['lot-picture']) &&
    isset($_FILES['lot-picture']['error']) &&
    $_FILES['lot-picture']['error'] === UPLOAD_ERR_OK) {
  
    $tmp_name = $_FILES['lot-picture']['tmp_name'];
  
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name); // get MIME type of file
  
    if ($file_type !== "image/jpeg" && $file_type !== "image/png") { // verify if file is jpg, png
      $errors['lot-picture'] = 'Загрузите картинку в формате jpg, jpeg, png';
    }
  }
  // if no errors
  if(empty($errors)) {
    $file_extension = pathinfo($_FILES['lot-picture']['name'], PATHINFO_EXTENSION);
  
    $filename = 'uploads/' . uniqid() . '.' . $file_extension;
  
    $sql = "INSERT INTO lots (title, category_id, description, author_id,
           start_price, end_date, step, img_src)
        VALUES ( ?, ?,  ?, 1 , ?, ?, ?, ?)";
  
    $new_lot_id = db_insert_data(
      $sql,
      [
        $lot['title'],
        $lot['category_id'],
        $lot['description'],
        $lot['start_price'],
        $lot['end_date'],
        $lot['lot_step'],
        $filename
      ]
    );
  
    if ($new_lot_id) {
      header("Location: lot.php?id=" . $new_lot_id);
    }
    move_uploaded_file($tmp_name, $filename);
  }
}

$add_content = include_template(
  "add_content.php",
  [
    "lot"        => $lot,
    "errors"     => $errors,
    "categories" => $categories,
    "user_name"  => $user_name
  ]
);

print($add_content);

