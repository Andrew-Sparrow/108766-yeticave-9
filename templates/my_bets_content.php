<section class="rates container">
  <h2>Мои ставки</h2>
    <?php if (empty($user_bets)): ?>
      <h3>У вас нет ставок</h3>
    <?php elseif (isset($user_bets)): ?>
      <table class="rates__list">
          <?php foreach ($user_bets as $bet): ?>
              <?php $author_contact = $bet['author_contact'] ?? '' ?>
            <tr class="rates__item
         <?php if (isset($bet['winner_id']) && isset($bet['lot_end_date'])): ?>
           <?= $_SESSION['user']['id'] === $bet['winner_id'] && strtotime($bet['lot_end_date']) <= strtotime('now') ? 'rates__item--win' : '' ?>
           <?= $_SESSION['user']['id'] !== $bet['winner_id'] && strtotime($bet['lot_end_date']) <= time() ? ' rates__item--end' : '' ?>
         <?php endif; ?> ">
              <td class="rates__info">
                <div class="rates__img">
                  <img src="<?= isset($bet['lot_img']) ? strip_tags($bet['lot_img']) : '' ?>" width="54" height="40"
                       alt="">
                </div>
                <div>
                  <h3 class="rates__title">
                    <a href="/lot.php?id=<?= $bet['lot_id'] ?? '' ?>">
                        <?= isset($bet['lot_title']) ? strip_tags($bet['lot_title']) : '' ?>
                    </a>
                  </h3>
                  <p>
                      <?php if (isset($bet['winner_id'])): ?>
                          <?= $_SESSION['user']['id'] === $bet['winner_id'] ? strip_tags($author_contact) : '' ?>
                      <?php endif; ?>
                  </p>
                </div>
              </td>
              <td class="rates__category">
                  <?= $bet['category_title'] ?? '' ?>
              </td>
              <td class="rates__timer">
                <div class="timer
            <?php if (isset($bet['winner_id'])): ?>
              <?= $_SESSION['user']['id'] === $bet['winner_id'] ? " timer--win" : is_date_equals_tomorrow($bet['lot_end_date']) ? " timer--finishing" : '' ?>
            <?php endif; ?>">
                    <?php if (isset($bet['winner_id'])): ?>
                        <?= $_SESSION['user']['id'] === $bet['winner_id'] ? 'Ставка выиграла' : $bet['lot_end_date'] ?? '' ?>
                    <?php else : ?>
                        <?= $bet['lot_end_date'] ?? '' ?>
                    <?php endif; ?>
                </div>
              </td>
              <td class="rates__price">
                  <?php if (isset($bet['rate'])): ?>
                      <?= format_number(intval($bet['rate'])) . ' p' ?>
                  <?php endif; ?>
              </td>
              <td class="rates__time">
                  <?= $bet['data_rate'] ?? '' ?>
              </td>
            </tr>
          <?php endforeach; ?>
      </table>
    <?php endif; ?>
</section>
