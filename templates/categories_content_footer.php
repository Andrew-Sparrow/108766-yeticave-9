<ul class="nav__list container">
  <!--заполните этот список из массива категорий-->
  <?php foreach($categories as $var): ?>
  <li class="nav__item">
    <a href="pages/all-lots.html">
      <?= strip_tags($var['title']) ?>
    </a>
  </li>
  <?php endforeach; ?>
</ul>