<?php
?>

<section class="promo">
      <h2 class="promo__title">Нужен стафф для катки?</h2>
      <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
        горнолыжное снаряжение.</p>
      <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php foreach($categories as $var): ?>
        <li class="promo__item promo__item--boards">
          <a class="promo__link" href="pages/all-lots.html">
            <?=strip_tags($var);?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
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
              <?php if(isset($item['img_src'])):?>     <!--#4 property-->
              <img src="<?=strip_tags($item['img_src']); ?>" width="350" height="260" alt="">
              <?php endif;?>
            </div>
            <div class="lot__info">
              <?php if (isset($item['category'])): ?>  <!--#2 property-->
              <span class="lot__category">
                <?=strip_tags($item['category']) ?>
              </span>
              <?php endif; ?>
              <h3 class="lot__title">
                <?php if (isset($item['title'])): ?>    <!--#1 property-->
                <a class="text-link" href="pages/lot.html">
                  <?=strip_tags($item['title']) ?>
                </a>
                <?php endif;?>
              </h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <?php if(isset($item['price'])): ?>   <!--#3 property-->
                  <span class="lot__cost">
                    <?=format_number($item['price'])?>
                  </span>
                  <?php endif;?>
                </div>
                <div class="lot__timer timer">
                  12:23
                </div>
              </div>
            </div>
          </li>
        <?php endforeach ;?>
      </ul>
    </section>
