<?php
require_once("init.php");

$enter = [];
$errors = [];
$page_title = 'Страница входа';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $enter = [
    'email'    => $_POST['email'] ?? '',
    'password' => $_POST['password'] ?? ''
  ];
  
  $required = ['email', 'password'];
  
  foreach ($required as $req) {
    if (empty($enter[$req])) {
      $errors[$req] = 'Это поле надо заполнить';
    }
  }
  
  $sql = 'select * from users where email = ?';
  $user = db_fetch_data($sql, [$enter['email']])[0];
  
  //var_dump($user[0]);
  
  if (!count($errors) && count($user) > 0) {
    if (password_verify($enter['password'], $user['password'])) {
      session_start();
      $_SESSION['user'] = $user;
    }
    else {
      $errors['password'] = 'Неверный пароль';
    }
  }
  elseif(empty($errors['email']) && count($user) === 0) {
    $errors['email'] = 'Такой пользователь не найден';
  }
  
  if(!count($errors)) {
    header('Location: index.php');
    exit();
  }
}
else {
  if (isset($_SESSION['user'])) {
    require_once("init.php");
  
    $layout  = include_template(
      "layout.php",
      [
        "user_name"    => $user_name,
        "title"        => $title,
        "main_content" => $main_content,
        "categories"   => $categories
      ]
    );
  
    print($layout);
  }
}

$enter_content = include_template(
  'enter_content.php',
  [
    'errors' => $errors
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $enter_content,
    'categories' => $categories,
    'user_name'  => $user_name
  ]
);

print ($layout);
