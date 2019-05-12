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
    'end_date'    => $_POST['end_date'] ?? null,
    'lot-picture' => $_FILES['lot-picture'] ?? null
  ];
  
  //var_dump($_FILES);
  
  $required = [
    'title',
    'category_id',
    'description',
    'start_price',
    'lot_step',
    'end_date',
    'lot-picture'
  ];
  
  foreach ($required as $req) {
    if (empty($lot[$req])) {
      $errors[$req] = 'Это поле надо заполнить';
    }
    else {  // verify is it a number
      if($req === 'start_price') {
        if (!is_numeric($lot['start_price'])) {
             $errors['start_price'] = 'Ввведите число';
        }
        if (!is_numeric($lot['lot_step'])) {
          $errors['lot_step'] = 'Ввведите число';
        }
      }
    }
  }
  
  if (empty($_FILES['lot-picture']['name'])) {
    $errors['lot-picture'] = 'Добавьте файл';
  }
  
  if (count($errors)) {  // if there are any errors show them
    $page_err_content = include_template(
      'add_content.php',
      [
        'lot'        => $lot,
        'errors'     => $errors,
        'categories' => $categories,
        'user_name'  => $user_name
      ]
    );
    
    print ($page_err_content);
  }
  else {
    
    $tmp_name = $_FILES['lot-picture']['tmp_name'];
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name); // get MIME type of file
    
    if ($file_type == "image/jpeg" || $file_type == "image/png") { // verify if file is jpg, png
      
      if ($_FILES['lot-picture']['size'] > 2097152) {
        $errors['lot-picture'] = 'Загрузите файл не более 2Мб';
        
        $page_err_content = include_template(
          'add_content.php',
          [
            'lot'        => $lot,
            'errors'     => $errors,
            'categories' => $categories,
            'user_name'  => $user_name
          ]
        );
        print ($page_err_content);
      }
      else {
        
        $file_extension = pathinfo($_FILES['lot-picture']['name'], PATHINFO_EXTENSION);
        
        $filename = 'uploads/' . uniqid() . '.' . $file_extension;
        
        $sql = "INSERT INTO lots (title, category_id, description, author_id,
             start_price, end_date, step, img_src)
          VALUES ( ?, ?,  ?, 1 , ?, ?, ?, ?)";
        
        $new_lot_id = db_insert_data($sql, [$lot['title'], $lot['category_id'],
                                            $lot['description'], $lot['start_price'], $lot['end_date'], $lot['lot_step'], $filename]);
        
        if ($new_lot_id) {
          header("Location: lot.php?id=" . strval($new_lot_id));
        }
        
        move_uploaded_file($tmp_name, $filename);
      }
    }
    else {
      $errors['lot-picture'] = 'Загрузите картинку в формате jpg, jpeg, png';
      
      $page_err_content = include_template(
        'add_content.php',
        [
          'lot'        => $lot,
          'errors'     => $errors,
          'categories' => $categories,
          'user_name'  => $user_name
        ]
      );
      print ($page_err_content);
    }
  }
}
else {
  $add_content = include_template(
    "add_content.php",
    [
      "categories" => $categories,
      "user_name"  => $user_name,
      "lot"        => $lot
    ]
  );
  print($add_content);
}


