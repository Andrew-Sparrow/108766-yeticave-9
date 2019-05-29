<section class="lot-item container">
  <h2>
    <?php if(isset($lot['title'])): ?>
      <?= $lot['title']?>
    <?php endif;?>
  </h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <?php if(isset($lot['img_src'])): ?>
          <img src="../<?= strip_tags($lot['img_src'])?>" width="730" height="548" alt="" >
        <?php endif; ?>
      </div>
      <p class="lot-item__category">Категория:
        <?php if(isset($lot['category'])):?>
          <span><?= $lot['category']?></span>
        <?php endif; ?>
      </p>
      <p class="lot-item__description">
        <?php if(isset($lot['description'])):?>
          <?= $lot['description']?>
        <?php endif; ?>
      </p>
    </div>
    <div class="lot-item__right">
      <?php if(isset($_SESSION['user'])): ?>
      <div class="lot-item__state">
        <div class="lot-item__timer timer
          <?php if (isset($lot['end_date'])): ?>
            <?php echo validate_less_hour(strtotime($lot['end_date'])) ? "timer--finishing" : "" ?> ">
            <?= get_formatted_time(strtotime($lot['end_date']))?>
          <?php endif?>
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <?php if(isset($lot['id'])): ?>
              <span class="lot-item__cost">
                <?= format_number_ruble(intval($current_price));?>
              </span>
            <?php endif; ?>
          </div>
          <div class="lot-item__min-cost">
            Мин. ставка
            <span>
              <?php if(isset($lot['step'])): ?>
                <?= format_number(intval($min_rate));?>
              <?php endif; ?> р
            </span>
          </div>
        </div>
        <form class="lot-item__form" action="" method="post" autocomplete="off">
          <?php
          $classname = isset($errors['cost']) ? " form__item--invalid" : "";
          ?>
          <p class="lot-item__form-item form__item <?=$classname ?>">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="text" name="cost" placeholder="<?= format_number(intval($min_rate));?>" autofocus>
            <span class="form__error"><?= $errors['cost'] ?? '' ?></span>
          </p>
          <button type="submit" class="button">Сделать ставку</button>
        </form>
      </div>
      <?php endif; ?>
      <div class="history">
        <h3>История ставок (<span>10</span>)</h3>
        <table class="history__list">
          <?php foreach($bets as $bet): ?>
            <tr class="history__item">
              <td class="history__name"><?= $bet['user_name'] ?></td>
              <td class="history__price"><?= format_number($bet['rate']) ?> p </td>
              <td class="history__time"><?= get_time_ago($bet['data_rate']) ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>


