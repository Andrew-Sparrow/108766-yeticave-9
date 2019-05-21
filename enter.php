<?php
require_once("init.php");

$enter = [];
$errors = [];
$page_title = 'Страница входа';

session_start();

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
  $user = db_fetch_data($sql, [$enter['email']]);
  
  if (!count($errors) && count($user) > 0) {
    if (password_verify($enter['password'], $user['password'])) {
      $_SESSION['user'] = $user;
    }
    else {
      $errors['password'] = 'Неверный пароль';
    }
  }
  else {
    $errors['email'] = 'Такой пользователь не найден';
  }
  
  if(!count($errors)) {
    header('Location: index.php');
    exit();
  }
}
else {
  if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
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
