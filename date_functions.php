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
  
  $hours   = floor($difference / 3600); // remaining  hours
  $minutes = floor(($difference - ($hours * 3600)) /60) ; // remaining  minutes

  $remained_time = $hours.":".$minutes;
  
  return $remained_time;
}

