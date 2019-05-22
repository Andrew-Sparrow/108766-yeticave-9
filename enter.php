<?php
require_once("init.php");

$enter = [];
$errors = [];
$page_title = 'Страница входа';
$_SESSION = [];

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
  
  $sql = 'select id, name, password from users where email = ?';
  $user = db_fetch_data($sql, [$enter['email']]);
  
  if (!count($errors) && count($user) > 0) {
    if (password_verify($enter['password'], $user[0]['password'])) {
      
      session_start();
      
      $_SESSION['user']['id'] = $user[0]['id'];
      $_SESSION['user']['name'] = $user[0]['name'];
      
      require_once('index.php');
      exit();
    }
    else {
      $errors['password'] = 'Неверный пароль';
    }
  }
  elseif (empty($errors['email']) && count($user) === 0) {
    $errors['email'] = 'Такой пользователь не найден';
  }
}
else {
  if (isset($_SESSION['user'])) {
    require_once("index.php");
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


