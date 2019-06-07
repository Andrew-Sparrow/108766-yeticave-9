<li class="lots__item lot">
  <div class="lot__image">
    <img src="<?= isset($lot['lot_img']) ? strip_tags($lot['lot_img']) : get_default_image_src(); ?>" width="350" height="260" alt="<?= $lot['title']?>">
  </div>
  <div class="lot__info">
    <span class="lot__category"><?= isset($lot['category'])? strip_tags($lot['category']) : ''?></span>
    <h3 class="lot__title">
      <a class="text-link" href="/lot.php?id=<?= isset($lot['id'])? strip_tags($lot['id']) :''?>">
        <?= isset($lot['title'])? strip_tags($lot['title']) : ''?>
      </a>
    </h3>
    <div class="lot__state">
      <div class="lot__rate">
        <span class="lot__amount">
          <?php if(isset($lot['id']) && isset($lot['start_price'])) :?>
          <?= get_current_price($lot['id']) === $lot['start_price'] ? 'Стартовая цена' : count(get_bets($lot['id'])).' '
            . get_noun_plural_form(count(get_bets($lot['id'])), 'ставка', 'ставки', 'ставок')?>
          <?php endif;?>
        </span>
        <span class="lot__cost">
          <?= isset($lot['id']) && empty(get_bets($lot['id'])) && $lot['start_price']  ?
            format_number($lot['start_price']). '<b class="rub">р</b>':
            format_number(get_current_price($lot['id'])). '<b class="rub">р</b>' ?>
        </span>
      </div>
      <?php if(isset($lot['end_date']) ) :?>
        <div class="lot__timer timer <?= strtotime($lot['end_date']) === strtotime('tomorrow')? 'timer--finishing': ''?>">
          <?= strip_tags($lot['end_date'])?>
        </div>
      <?php endif;?>
    </div>
  </div>
</li>
