<?php
$page_title = 'Ошибка';

$content = include_template('404_content.php', []);

$template_404 = include_template(
  'simple_layout.php',
  [
    'page_title' => $page_title,
    'content'    => $content,
    'categories' => $categories,
    'is_auth'    => $is_auth,
    'user_name'  => $user_name
  ]
);