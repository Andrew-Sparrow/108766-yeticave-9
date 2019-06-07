<div class="container">
  <section class="lots">
    <h2>Результаты поиска по запросу «<span><?= !empty($_GET['search']) ? strip_tags($_GET['search']) : '' ?></span>»
    </h2>
    <?php if (empty($result_search_amount)): ?>
      <h3>Ничего не найдено по вашему запросу</h3>
    <?php else: ?>
      <ul class="lots__list">
        <?php foreach ($result_set_of_lots as $lot): ?>
          <?= include_template("lot_cards.php", ["lot" => $lot]) ?>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
  <?php if ($result_search_amount > $items_on_page): ?>
    <ul class="pagination-list">
      <li class="pagination-item pagination-item-prev">
        <a href="/search.php?page=<?= $cur_page - 1 < 1 ? 1 : $cur_page - 1 ?>&search=<?= $_GET['search'] ?? '' ?>">Назад</a>
      </li>
      <?php foreach ($page_range as $page): ?>
        <li class="pagination-item <?php if ($page == $cur_page): ?>pagination-item-active<?php endif; ?>">
          <a href="/search.php?page=<?= $page; ?>&search=<?= $_GET['search'] ?? '' ?>">
            <?= $page; ?>
          </a>
        </li>
      <?php endforeach; ?>
      <li class="pagination-item pagination-item-next"><a
          href="/search.php?page=<?= $cur_page + 1 > count($page_range) ? count($page_range) : $cur_page + 1 ?>&search=<?= $_GET['search'] ?? '' ?>">Вперед</a>
      </li>
    </ul>
  <?php endif; ?>
</div>
