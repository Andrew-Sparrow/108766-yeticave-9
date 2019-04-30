<?php
require_once("date_functions.php");
?>

<section class="promo">
  <h2 class="promo__title">Нужен стафф для катки?</h2>
  <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
    горнолыжное снаряжение.</p>
  <?= $categories_content ?>
</section>
<section class="lots">
  <div class="lots__header">
    <h2>Открытые лоты</h2>
  </div>
  <ul class="lots__list">
    <!--заполните этот список из массива с товарами-->
    <?php foreach($lots as $item): ?>
      <li class="lots__item lot">
        <div class="lot__image">
          <?php if(isset($item['img_src'])): ?>     <!--#4 property-->
            <img src="<?= strip_tags($item['img_src']); ?>" width="350" height="260" alt="">
          <?php endif; ?>
        </div>
        <div class="lot__info">
          <?php if(isset($item['categories_title'])): ?>  <!--#2 property-->
            <span class="lot__category">
                <?= strip_tags($item['categories_title']) ?>
              </span>
          <?php endif; ?>
          <h3 class="lot__title">
            <?php if(isset($item['lot_title'])): ?>    <!--#1 property-->
              <a class="text-link" href="pages/lot.html">
                <?= strip_tags($item['lot_title']) ?>
              </a>
            <?php endif; ?>
          </h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount">Стартовая цена</span>
              <?php if(isset($item['start_price'])): ?>   <!--#3 property-->
                <span class="lot__cost">
                    <?= format_number(intval($item['start_price'])) ?>
                  </span>
              <?php endif; ?>
            </div>
            <div class="lot__timer timer
              <?php echo validate_less_hour(strtotime("tomorrow")) ? "timer--finishing" : "" ?> ">
              <?= get_formatted_time(strtotime("tomorrow"))?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</section>