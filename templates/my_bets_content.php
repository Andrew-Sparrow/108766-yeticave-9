<?php
require_once ("functions.php");
?>

<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list">
    <?php if(isset($user_bets)): ?>
      <?php foreach($user_bets as $bet): ?>
        <?php $contact = get_lot_author_contact($bet['lot_id'])?>
        <tr class="rates__item<?= $_SESSION['user']['id'] === $bet['winner_id'] ? ' rates__item--win': ''?>">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $bet['lot_img'] ?>" width="54" height="40" alt="Сноуборд">
            </div>
            <div>
              <h3 class="rates__title">
                <a href="lot.html"><?= $bet['lot_title'] ?></a>
              </h3>
              <p><?= $_SESSION['user']['id'] === $bet['winner_id'] ? "$contact": ''?></p>
            </div>
          </td>
          <td class="rates__category">
            <?= $bet['category_title'] ?>
          </td>
          <td class="rates__timer">
            <div class="timer <?= $_SESSION['user']['id'] === $bet['winner_id'] ? ' timer--win': 'timer--finishing'?>">
              <?= $bet['lot_end_date'] ?>
            </div>
          </td>
          <td class="rates__price">
            <?= $bet['rate'] ?>
          </td>
          <td class="rates__time">
            <?= $bet['data_rate'] ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif;?>
  </table>
</section>
