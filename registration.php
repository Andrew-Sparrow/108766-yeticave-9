<?php

require_once("init.php");
$registration = [];
$errors = [];


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
  
  if(empty($errors['email'])) {
    $email_validation = filter_var($registration['email'], FILTER_VALIDATE_EMAIL);
    $errors['email'] = 'Введите корректный емаил';
  }
  
}

var_dump($errors);
var_dump($_POST);
var_dump($email_validation);

/*

session_start();
$visit_count = 1;

if (isset($_SESSION["visit_count"])) {
  $visit_count = $_SESSION["visit_count"] + 1;
}

$_SESSION["visit_count"] = $visit_count;

print("Количество посещений: " . $visit_count);

*/


$registration_content = include_template(
  'registration_content.php',
  [
    'registration' => $registration,
    'errors'       => $errors
  ]
);

$layout = include_template(
  'simple_layout.php',
  [
    'registration_content' => $registration_content,
    'categories'           => $categories,
    'user_name'            => $user_name
  ]
);

print ($layout);