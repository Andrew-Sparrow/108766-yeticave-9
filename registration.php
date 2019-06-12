<?php
require_once("init.php");

$registration = [];
$errors = [];
$fetch_data = false;
$page_title = 'Регистрация';
$user_name = null;

if (isset($_SESSION['user']['id'])) {
    header('Location: /');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
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
            $errors[$req] = 'Заполните поле';
        }
    }
    
    if (empty($errors['email']) && (filter_var($registration['email'], FILTER_VALIDATE_EMAIL) === false)) {
        $errors['email'] = 'Введите корректный емаил';
    }
    
    if (mb_strlen($registration['email']) > 120) {
        $errors['email'] = 'Введите емаил не более 120 символов';
    }
    
    if (mb_strlen($registration['password']) > 120) {
        $errors['password'] = 'Введите пароль не более 120 символов';
    }
    
    if (mb_strlen($registration['name']) > 120) {
        $errors['name'] = 'Введите имя не более 120 символов';
    } else {
        $sql_users_name = "SELECT name
      FROM users
      WHERE users.name = ?";
        
        $users_name_fetch_data = db_fetch_data($sql_users_name, [$registration['name']]);
        
        if (count($users_name_fetch_data) > 0) {
            $errors['name'] = 'Пользователь с таким именем уже существует';
        }
    }
    
    if (mb_strlen($registration['message']) > 2000) {
        $errors['message'] = 'Введите контактные данные не более 2000 символов';
    }
}

if (empty($errors) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $sql = "SELECT id FROM users WHERE email = ?";
    $user_email = $registration['email'];
    
    $fetch_data = db_fetch_data($sql, [$user_email]);
    
    //verifying if there is user with the same id
    if (count($fetch_data) > 0) {
        $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    } else {
        $password = password_hash($registration['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (email, name, password, contact)
      VALUES ( ?, ?, ?, ?)";
        
        $new_user = db_insert_data(
            $sql,
            [
                $registration['email'],
                $registration['name'],
                $password,
                $registration['message']
            ]
        );
        
        if ($new_user) {
            header("Location: enter.php");
            exit();
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
        'is_auth'    => $is_auth,
        'user_name'  => $user_name
    ]
);

print ($layout);
