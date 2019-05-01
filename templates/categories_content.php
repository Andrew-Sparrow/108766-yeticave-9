  <ul class="promo__list">
    <!--заполните этот список из массива категорий-->
    <?php foreach($categories as $var): ?>
      <li class="promo__item promo__item--<?= strip_tags($var['symbol_code'])?>">
        <a class="promo__link" href="pages/all-lots.html">
          <?= strip_tags($var['title']); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>