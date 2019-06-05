<?php
require_once ('functions.php');
require_once ('helpers.php');
?>

<div class="container">
  <section class="lots">
    <h2>Результаты поиска по запросу «<span><?= !empty($_GET['search']) ? strip_tags($_GET['search']) : ''?></span>»</h2>
    <?php if(empty($result_search_amount) && $_GET['search']): ?>
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
                  <span class="lot__cost"><?= !empty(get_bets($val['id'])) ? format_number(get_bets($val['id'])[0]['rate']): '' ?><b class="rub">р</b></span>
                </div>
                <div class="lot__timer timer">
                  <!-- TODO добавить timer--finishing               -->
                  <?= $val['end_date']?>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach;?>
      </ul>
     <?php endif;?>
  </section>
  <?php if($result_search_amount > 9): ?>
  <ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
    <li class="pagination-item pagination-item-active"><a>1</a></li>
    <li class="pagination-item"><a href="#">2</a></li>
    <li class="pagination-item"><a href="#">3</a></li>
    <li class="pagination-item"><a href="#">4</a></li>
    <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
  </ul>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <?php foreach ($page_range as $page): ?>
          <li class="pagination-item <?php if ($page == $cur_page): ?>pagination-item-active<?php endif; ?>">
            <a href="/?page=<?=$page;?>"><?=$page;?></a>
          </li>
        <?php endforeach; ?>
      </ul>
  <?php endif; ?>
</div>
