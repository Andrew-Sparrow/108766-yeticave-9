<li class="lots__item lot">
  <div class="lot__image">
    <img src="<?= isset($val['lot_img'])? strip_tags($val['lot_img']):''?>" width="350" height="260" alt="<?= $val['title']?>">
  </div>
  <div class="lot__info">
    <span class="lot__category"><?= isset($val['category'])? strip_tags($val['category']) : ''?></span>
    <h3 class="lot__title">
      <a class="text-link" href="/lot.php?id=<?= isset($val['id'])? strip_tags($val['id']) :''?>">
        <?= isset($val['title'])? strip_tags($val['title']) : ''?>
      </a>
    </h3>
    <div class="lot__state">
      <div class="lot__rate">
        <span class="lot__amount">
          <?php if(isset($val['id']) && isset($val['start_price'])) :?>
          <?= get_current_price($val['id']) === $val['start_price'] ? 'Стартовая цена' : count(get_bets($val['id'])).' '
            . get_noun_plural_form(count(get_bets($val['id'])), 'ставка', 'ставки', 'ставок')?>
          <?php endif;?>
        </span>
        <span class="lot__cost">
          <?= empty(get_bets($val['id'])) && isset($val['id']) && $val['start_price'] ?
            format_number($val['start_price']). '<b class="rub">р</b>':
            format_number(get_current_price($val['id'])). '<b class="rub">р</b>' ?>
        </span>
      </div>
      <?php if(isset($val['end_date']) ) :?>
        <div class="lot__timer timer <?= strtotime($val['end_date']) === strtotime('tomorrow')? 'timer--finishing': ''?>">
          <?= strip_tags($val['end_date'])?>
        </div>
      <?php endif;?>
    </div>
  </div>
</li>

<?php
$val = '';
?>