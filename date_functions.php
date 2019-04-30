<?php

/**
 * This function sets default timezone
 *
 * @param string $timezone
 *
 */
function set_timezone($timezone) {
  date_default_timezone_set($timezone);
}


/**
 * This function validate if remained time from current time until
 * end of bargaining is less than hour.
 *
 * @param integer $end_bargaining
 * @return boolean
 *
 */
function validate_less_hour($end_bargaining): bool {
  
  $current_time = time(); // unix timestamp
  
  $difference = floor(($end_bargaining - $current_time) / 60); //get minutes
  
  if($difference <= 60) {
    return true;
  }
  
  return false;
}


/**
 * This function returns remained time in "Hours:minutes"
 *
 * @param integer $end_bargaining
 * @return string
 *
 */
function get_formatted_time($end_bargaining) {
  
  $current_time = time(); // unix timestamp
  
  $difference = floor(($end_bargaining - $current_time));
  
  $hours = floor($difference / 3600); // remaining  hours
  $minutes = floor(($difference - ($hours * 3600)) / 60); // remaining  minutes
  
  $remained_time = $hours . ":" . $minutes;
  
  return $remained_time;
}

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

/**
 * Fetches all result rows as an associative array by prepared variables
 *
 * @param $link mysqli an object which represents the connection to a MySQL Server.
 * @param $sql string This parameter can include one or more
 *        parameter markers in the SQL statement by embedding
 *        question mark (?) characters at the appropriate positions.
 * @param $data an array of prepared variables for bindig this variables
 *        to a prepared statement
 * @return an array
 */
function db_fetch_data($link, $sql, $data = []): mixed {
  $result = [];
  $stmt = db_get_prepare_stmt($link, $sql, $data);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  
  if($res) {
    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
  }
  return $result;
}

/**
 * This function adds new rows
 *
 * @param $link mysqli an object which represents the connection to a MySQL Server.
 * @param $sql string This parameter can include one or more
 *        parameter markers in the SQL statement by embedding
 *        question mark (?) characters at the appropriate positions.
 * @param $data an array of prepared variables for bindig this variables
 *        to a prepared statement
 * @return Returns the auto generated id
 */
function db_insert_data($link, $sql, $data = []): mixed {
  $stmt = db_get_prepare_stmt($link, $sql, $data);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  
  if($result) {
    $result = mysqli_insert_id($link);
  }
  return $result;
}


function get_content(mysqli $connection, string $sql, string $template_file,  $variable_name = []): string {
  if(!$connection) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
  }
  else {
    
    $query_result = mysqli_query($connection, $sql);
    
    if($query_result) {
      
      // возвращает массив
      $array_content = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
      
      foreach($variable_name as $var){
      
      }
      
      $content = include_template($template_file, [$variable_name => $$variable_name]);
    }
    else {
      $error = mysqli_error($connection);
      $content = include_template('error.php', ['error' => $error]);
    }
  }
  return $content;
}



