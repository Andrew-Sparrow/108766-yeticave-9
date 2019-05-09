<?php

class DbConnectionProvider
{
  protected static $connection;
  
  public static function getConnection() {
    if (self::$connection === null) {
      self::$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      if (!self::$connection) {
        exit('Ошибка MySQL: connection failed');
      }
      
      mysqli_set_charset(self::$connection, 'utf8');
    }
    
    return self::$connection;
  }
}

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
  
  if ($difference <= 60) {
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
function format_number_ruble($number): string {
  
  $number = ceil($number);
  
  if ($number > 1000) {
    $number = number_format($number, 0, ".", " ");
  }
  return $number . " ₽";
}

/**
 * This function returns a formated string with groups of thousands
 *
 * @param int $number
 *
 * @return string
 */
function format_number($number): string {
  $number = ceil($number);
  
  if ($number > 1000) {
    $number = number_format($number, 0, ".", " ");
  }
  return $number;
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
function db_fetch_data($sql, $data = []) {
  $link = DbConnectionProvider::getConnection();
  $result = [];
  $stmt = db_get_prepare_stmt($link, $sql, $data);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  
  if ($res) {
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
function db_insert_data($sql, $data = []) {
  $link = DbConnectionProvider::getConnection();
  $stmt = db_get_prepare_stmt($link, $sql, $data);
  $result = mysqli_stmt_execute($stmt);
  
  if ($result) {
    $result = mysqli_insert_id($link);
  }
  return $result;
}

/**
 * This function returns array of categories
 *
 * @return array of categories
 */
function get_categories(): array {
  $sql = 'SELECT id, title, symbol_code FROM categories';
  $categories = db_fetch_data($sql);
  return $categories;
}

/**
 * This function returns array of lots
 *
 * @return array of lots
 */
function get_lots(): array {
  $sql = 'SELECT lots.id as lot_id, lots.title as lot_title, start_price , img_src
          FROM lots';
  $lots = db_fetch_data($sql);
  return $lots;
}

/**
 * This function returns a lot-item by id,
 * like array of its properties
 * if lot exists or null
 *
 * @return array of properties of lot
 */
function get_lot($lot_id) {
  $sql = "SELECT lots.id , categories.title AS category,
          lots.description, start_price, lots.title as title,
          img_src, end_date, step
          FROM lots
          JOIN categories ON categories.id = lots.category_id
          where lots.id = ?";
  
  $lot = db_fetch_data($sql, [$lot_id]);
  
  return $lot[0] ?? null;
}

/**
 * This function returns current price of lot by lot's id
 *
 * @return integer
 */
function get_current_price($lot_id) {
  $sql = "SELECT MAX(price) AS max_price
          FROM (SELECT max(rate) AS price
                FROM rates
                WHERE lot_id = ?
                UNION
                SELECT start_price
                FROM lots
                WHERE id = ?) AS prices";
  
  $price = db_fetch_data($sql, [$lot_id, $lot_id]);
  
  return $price[0]['max_price'];
}


