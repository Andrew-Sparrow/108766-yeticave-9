<section class="lot-item container">
  <h2>
      <?php if (isset($lot['title'])): ?>
          <?= strip_tags($lot['title']) ?>
      <?php endif; ?>
  </h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
          <?php if (isset($lot['img_src'])): ?>
            <img src="../<?= strip_tags($lot['img_src']) ?>" width="730" height="548" alt="">
          <?php endif; ?>
      </div>
      <p class="lot-item__category">Категория:
          <?php if (isset($lot['category'])): ?>
            <span><?= strip_tags($lot['category']) ?></span>
          <?php endif; ?>
      </p>
      <p class="lot-item__description">
          <?php if (isset($lot['description'])): ?>
              <?= strip_tags($lot['description']) ?>
          <?php endif; ?>
      </p>
    </div>
    <div class="lot-item__right">
      <div class="lot-item__state">
        <div class="lot-item__timer timer
          <?php if (isset($lot['end_date'])): ?>
            <?= validate_less_hour(strtotime($lot['end_date'])) ? "timer--finishing" : "" ?> ">
            <?= get_formatted_time(strtotime($lot['end_date'])) ?>
            <?php endif ?>
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">
              <?php if (isset($lot['id']) && isset($lot['start_price'])): ?>
                  <?= get_current_price($lot['id']) === $lot['start_price'] ? 'Стартовая цена' : 'Текущая цена' ?>
              <?php endif ?>
            </span>
              <?php if (isset($lot['id'])): ?>
                <span class="lot-item__cost">
                <?= format_number_ruble(strip_tags($current_price)); ?>
              </span>
              <?php endif; ?>
          </div>
          <div class="lot-item__min-cost">
            Мин. ставка
            <span>
              <?php if (isset($lot['step'])): ?>
                  <?= format_number(strip_tags($min_rate)); ?>
              <?php endif; ?> р
            </span>
          </div>
        </div>
          <?php if (isset($_SESSION['user']['id'])
              && $is_end_date_in_future
              && $is_lot_author_other_user
              && $is_user_last_bet_other) : ?>
            <form class="lot-item__form" action="" method="post" autocomplete="off">
                <?php
                $classname = isset($errors['cost']) ? "form__item--invalid" : "";
                ?>
              <p class="lot-item__form-item form__item <?= $classname ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= format_number(strip_tags($min_rate)); ?>"
                       autofocus>
                <span class="form__error"><?= $errors['cost'] ?? '' ?></span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          <?php endif; ?>
      </div>
        <?php if (!empty($bets)): ?>
          <div class="history">
            <h3>История ставок (<span><?= count($bets) ?></span>)</h3>
            <table class="history__list">
                <?php foreach ($bets as $bet): ?>
                  <tr class="history__item">
                    <td class="history__name"><?= strip_tags($bet['user_name']) ?? '' ?></td>
                    <td class="history__price"><?= isset($bet['rate']) ? format_number(strip_tags($bet['rate'])) : '' ?>
                      p
                    </td>
                    <td
                      class="history__time"><?= isset($bet['data_rate']) ? get_time_ago($bet['data_rate']) : '' ?></td>
                  </tr>
                <?php endforeach; ?>
            </table>
          </div>
        <?php endif; ?>
    </div>
  </div>
</section>


