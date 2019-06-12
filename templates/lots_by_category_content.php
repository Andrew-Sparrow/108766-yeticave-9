<div class="container">
  <section class="lots">
      <?php if (empty($result_search_amount)): ?>
        <h3>Лотов в этой категории нет</h3>
      <?php else: ?>
        <ul class="lots__list">
            <?php foreach ($result_set_of_lots as $lot): ?>
                <?= include_template("lot_card.php", ["lot" => $lot]) ?>
            <?php endforeach; ?>
        </ul>
      <?php endif; ?>
  </section>
    <?php if ($result_search_amount > $items_on_page): ?>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev">
          <a
            href="/get_lots_by_category.php?page=<?= $cur_page - 1 < 1 ? 1 : $cur_page - 1 ?>&category_id=<?= isset($_GET['category_id']) ? intval($_GET['category_id']) : '' ?>">Назад</a>
        </li>
          <?php foreach ($page_range as $page): ?>
            <li class="pagination-item <?php if ($page === $cur_page): ?>pagination-item-active<?php endif; ?>">
              <a
                href="/get_lots_by_category.php?page=<?= $page; ?>&category_id=<?= isset($_GET['category_id']) ? intval($_GET['category_id']) : '' ?>">
                  <?= $page; ?>
              </a>
            </li>
          <?php endforeach; ?>
        <li class="pagination-item pagination-item-next"><a
            href="/get_lots_by_category.php?page=<?= $cur_page + 1 > count($page_range) ? count($page_range) : $cur_page + 1 ?>&category_id=<?= isset($_GET['category_id']) ? intval($_GET['category_id']) : '' ?>">Вперед</a>
        </li>
      </ul>
    <?php endif; ?>
</div>
