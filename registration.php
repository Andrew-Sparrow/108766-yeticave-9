<?php

require_once("init.php");
$registration = [];
$errors = [];
$fetch_data = false;
$page_title = 'Регистрация';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  $registration = [
    'email'    => $_POST['email'] ?? null,
    'password' => $_POST['password'] ?? null,
    'name'     => $_POST['name'] ?? null,
    'message'  => $_POST['message'] ?? null
  ];
  
  $required = [
    'email',
    'password',
    'name',
    'message'
  ];
  
  foreach ($required as $req) {
    if (empty($registration[$req])) {
      switch ($req) {
        case  'email' :
          $errors[$req] = 'Введите емаил';
          continue;
        case  'password' :
          $errors[$req] = 'Введите пароль';
          continue;
        case  'name' :
          $errors[$req] = 'Введите имя';
          continue;
        case  'message' :
          $errors[$req] = 'Введите контактные данные';
          continue;
      }
    }
  }
  
  $email_validation = false;
  
  if (empty($errors['email'])) {
    $email_validation = filter_var($registration['email'], FILTER_VALIDATE_EMAIL);
    
    if ($email_validation === false) {
      $errors['email'] = 'Введите корректный емаил';
    }
  }
  
  if (empty($errors)) {
    
    $sql = "SELECT id FROM users WHERE email = ?";
    $user_email = $registration['email'];
    
    $fetch_data = db_fetch_data($sql, [$user_email]);
    
    //verifying if there is user with the same id
    if ($fetch_data) {
      $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    }
    else {
      $password = password_hash($registration['password'], PASSWORD_DEFAULT);
      
      $sql = "INSERT INTO users (email, name, password, contact)
        VALUES ( ?, ?, ?, ?)";
      
      $new_user = db_insert_data(
        $sql,
        [
          $registration['email'],
          $registration['name'],
          $registration['password'],
          $registration['message']
        ]
      );
      
      if ($new_user && empty($errors)) {
        header("Location: enter.php");
        exit();
      }
    }
  }
}

$content = include_template(
  'registration_content.php',
  [
    'registration' => $registration,
    'errors'       => $errors
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories,
    'user_name'  => $user_name
  ]
);

print ($layout);