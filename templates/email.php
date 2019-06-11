<?php
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
    "https" : "http") . "://" . $_SERVER['SERVER_NAME'];
?>

<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?=$winner_name?></p>
<p>Ваша ставка для лота <a href="<?=$link?>/lot.php?id=<?=$lot_id?>"><?=strip_tags($lot_title)?></a> победила.</p>
<p>Перейдите по ссылке <a href="<?=$link?>/my_bets.php">мои ставки</a>,
  чтобы связаться с автором объявления</p>
<small>Интернет Аукцион "YetiCave"</small>
