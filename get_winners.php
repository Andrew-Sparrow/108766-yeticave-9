<?php

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

require_once 'init.php';

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$winner_name = '';
$lot_title = '';

$maxRates = [];

$logger = new Swift_Plugins_Loggers_ArrayLogger();

$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

//get rates where lots without winners and end_date in the past or equals today
$sql_rates = "SELECT rates.lot_id,
                rates.rate,
                rates.user_id,
                users.name as user_name,
                users.email as user_email,
                lots.title as lot_title
              FROM rates
              JOIN lots ON lots.id = rates.lot_id
              JOIN users ON users.id = rates.user_id
              WHERE rates.lot_id in (
                SELECT lots.id
                FROM lots
                WHERE winner_id IS NULL AND lots.end_date <= CURDATE()
              )";

$rates = db_fetch_data($sql_rates);

//find out max rates
foreach ($rates as $rate) {
    if (isset($rate['lot_id'])) {
        if (!isset($maxRates[$rate['lot_id']])) {
            $maxRates[$rate['lot_id']] = $rate;
            continue;
        }
        
        if ($rate['rate'] > $maxRates[$rate['lot_id']]['rate']) {
            $maxRates[$rate['lot_id']] = $rate;
        }
    }
}

$sql_update = "UPDATE lots SET winner_id = ? WHERE lots.id = ?;";

//update data , set winners to lots
foreach ($maxRates as $mRate) {
    if (isset($mRate['user_id'], $mRate['lot_id'])) {
        db_update_data($sql_update, [$mRate['user_id'], $mRate['lot_id']]);
    }
}

if (count($maxRates) > 0) {
    
    foreach ($maxRates as $maxRate) {
        
        $validator = new EmailValidator();
        
        //validate email
        if (isset($maxRate['user_name'], $maxRate['lot_title'], $maxRate['lot_id'], $maxRate['user_email']) &&
            $validator->isValid(strip_tags($maxRate['user_email']), new RFCValidation())) {
            
            $recipient = [];
            
            $recipient[strip_tags($maxRate['user_email'])] = strip_tags($maxRate['user_name']);
            
            $message = new Swift_Message();
            $message->setSubject("Ваша ставка победила");
            $message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);
            $message->setBcc($recipient);
            
            $message_content = include_template('email.php', [
                "winner_name" => strip_tags($maxRate['user_name']),
                "lot_title"   => strip_tags($maxRate['lot_title']),
                "lot_id"      => $maxRate['lot_id']
            ]);
            
            $message->setBody($message_content, 'text/html');
            
            $result_of_message = $mailer->send($message);
        }
    }
}
