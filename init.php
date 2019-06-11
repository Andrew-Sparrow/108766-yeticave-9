<?php
require_once ('vendor/autoload.php');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once("helpers.php");
require_once("functions.php");

if(file_exists('config.php')) {
  require_once 'config.php';
}
else {
  exit('Скопируйте config.default.php в config.php и установите настройки приложения');
}

set_timezone("Asia/Yekaterinburg");

$categories = get_categories();

$is_auth = isset($_SESSION['user']['name']) ?  1 : 0;
$user_name = $_SESSION['user']['name'] ?? '';