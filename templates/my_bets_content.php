<?php
?>

<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list">
    <?php if(isset($user_bets)): ?>
      <?php foreach($user_bets as $bet): ?>
      <?php $author_contact = $bet['author_contact'] ?? '' ?>
        <tr class="rates__item <?= $_SESSION['user']['id'] === $bet['winner_id'] && strtotime($bet['lot_end_date'])<= strtotime('now') ? 'rates__item--win': ''?>
                               <?= $_SESSION['user']['id'] != $bet['winner_id'] && strtotime($bet['lot_end_date'])<= time() ? 'rates__item--end': ''?>">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $bet['lot_img'] ?>" width="54" height="40" alt="">
            </div>
            <div>
              <h3 class="rates__title">
                <a href="/lot.php?id=<?=$bet['lot_id']?>"><?= strip_tags($bet['lot_title']) ?></a>
              </h3>
              <p><?= $_SESSION['user']['id'] === $bet['winner_id'] ? strip_tags($author_contact): ''?></p>
            </div>
          </td>
          <td class="rates__category">
            <?= $bet['category_title'] ?? ''?>
          </td>
          <td class="rates__timer">
            <div class="timer <?= $_SESSION['user']['id'] === $bet['winner_id'] ? ' timer--win': ' timer--finishing'?>">
              <?= $_SESSION['user']['id'] === $bet['winner_id'] ? 'Ставка выиграла': $bet['lot_end_date'] ?? ''?>
            </div>
          </td>
          <td class="rates__price">
            <?= format_number(intval($bet['rate'])) ?? '' . ' p'?>
          </td>
          <td class="rates__time">
            <?= $bet['data_rate'] ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif;?>
  </table>
</section>
