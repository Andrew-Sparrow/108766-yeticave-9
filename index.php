<?php
require_once("helpers.php");
require_once("date_functions.php");

setlocale(LC_ALL, 'ru_RU');

set_timezone("Asia/Yekaterinburg");

$user_name = "Андрей"; // укажите здесь ваше имя
$title     = "Главная";

$categories = [
  "Доски и лыжи",
  "Крепления",
  "Ботинки",
  "Одежда",
  "Инструменты",
  "Разное"
];

$lots = [
  [
    'title'    => '2014 Rossignol District Snowboard',
    'category' => 'Доски и лыжи',
    'price'    => 10999,
    'img_src'  => 'img/lot-1.jpg'
  ],
  [
    'title'    => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => 'Доски и лыжи',
    'price'    => 159999,
    'img_src'  => 'img/lot-2.jpg'
  ],
  [
    'title'    => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category' => 'Крепления',
    'price'    => 8000,
    'img_src'  => 'img/lot-3.jpg'
  ],
  [
    'title'    => 'Ботинки для сноуборда DC Mutiny Charocal',
    'category' => 'Ботинки',
    'price'    => 10999,
    'img_src'  => 'img/lot-4.jpg'
  ],
  [
    'title'    => 'Куртка для сноуборда DC Mutiny Charocal',
    'category' => 'Одежда',
    'price'    => 7500,
    'img_src'  => 'img/lot-5.jpg'
  ],
  [
    'title'    => 'Маска Oakley Canopy',
    'category' => 'Разное',
    'price'    => 5400,
    'img_src'  => 'img/lot-6.jpg'
  ]
];


/**
 * This function returns a formated string with groups of thousands and sign of ruble
 * in the end.
 *
 * @param int $number
 *
 * @return string
 */
function format_number($number): string {
  
  $number = ceil($number);
  
  if($number > 1000) {
    $number = number_format($number, 0, ".", " ");
  }
  return $number . " ₽";
}

$main_content = include_template(
  "index.php",
  [
    "categories" => $categories,
    "lots"       => $lots
  ]
);


$layout = include_template(
  "layout.php",
  [
    "main_content" => $main_content,
    "categories"   => $categories,
    "user_name"    => $user_name,
    "title"        => $title
  ]
);

print($layout);





