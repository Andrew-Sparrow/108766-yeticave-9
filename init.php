<?php

if(file_exists('config.php')) {
  require_once 'config.php';
}
else {
  exit('Скопируйте config.default.php в config.php и установите настройки приложения');
}

$connection = DbConnectionProvider::getConnection();