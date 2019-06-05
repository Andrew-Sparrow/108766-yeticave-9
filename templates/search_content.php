<?php
require_once ('functions.php');
require_once ('helpers.php');
?>

<div class="container">
  <section class="lots">
    <h2>Результаты поиска по запросу «<span><?= !empty($_GET['search']) ? strip_tags($_GET['search']) : ''?></span>»</h2>
    <?php if(empty($result_search_amount)): ?>
      <h3>Ничего не найдено по вашему запросу</h3>
    <?php else: ?>
      <ul class="lots__list">
        <?php foreach($result_set as $key => $val):?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="../<?= isset($val['lot_img'])? strip_tags($val['lot_img']):''?>" width="350" height="260" alt="<?= $val['title']?>">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= isset($val['category'])? $val['category'] : ''?></span>
              <h3 class="lot__title">
                <a class="text-link" href="/lot.php?id=<?=$val['id']?>">
                  <?= $val['title'] ?>
                </a>
              </h3>
              <div class="lot__state">
                <div class="lot__rate">
                <span class="lot__amount">
                  <?= get_current_price($val['id']) === $val['start_price'] ? 'Стартовая цена' : count(get_bets($val['id'])).' '
                    . get_noun_plural_form(count(get_bets($val['id'])), 'ставка', 'ставки', 'ставок')?>
                </span>
                  <span class="lot__cost">
                    <?= empty(get_bets($val['id']))?
                      format_number($val['start_price']). '<b class="rub">р</b>':
                      format_number(get_current_price($val['id'])). '<b class="rub">р</b>' ?>
                  </span>
                </div>
                <div class="lot__timer timer <?= strtotime($val['end_date']) === strtotime('tomorrow')? 'timer--finishing': ''?>">
                  <?= $val['end_date']?>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach;?>
      </ul>
    <?php endif;?>
  </section>
  <?php if($result_search_amount > $items_on_page): ?>
    <ul class="pagination-list">
      <li class="pagination-item pagination-item-prev"><a href="#">Назад</a></li>
      <?php foreach ($page_range as $page): ?>
        <li class="pagination-item <?php if ($page == $cur_page): ?>pagination-item-active<?php endif; ?>">
          <a href="/search.php?page=<?=$page;?>&&search=<?=$_GET['search']?>"><?=$page;?></a>
        </li>
      <?php endforeach; ?>
      <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
  <?php endif; ?>
</div>
