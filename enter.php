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

  if (empty($errors['email'])) {
    $user = getUser();
  
    if (count($user) === 0) {
      $errors['email'] = 'Такой пользователь не найден';
    }
  }
  
  if (!count($errors) && count($user) > 0) {
    if (password_verify($enter['password'], $user['password'])) {
      
      !isset($_SESSION['user']['id'])? $_SESSION['user']['id'] = $user['id']: '' ;
      !isset($_SESSION['user']['name'])? $_SESSION['user']['name'] = $user['name']: '' ;
  
      header('Location: /');
      exit();
    }
    else {
      $errors['password'] = 'Неверный пароль';
    }
  }
}
else {
  if (isset($_SESSION['user'])) {
    header('Location: /');
    exit();
  }
}


$enter_content = include_template(
  'enter_content.php',
  [
    'errors' => $errors,
    'enter'  => $enter
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $enter_content,
    'categories' => $categories
  ]
);

print ($layout);
