<form class="form form--add-lot container <?= isset($errors) ? "form--invalid" : "" ?>"  method="post" enctype="multipart/form-data"> <!-- form--invalid -->
<h2>Добавление лота</h2>
<div class="form__container-two">
  <?php
  $classname = isset($errors['title']) ? " form__item--invalid" : "";
  $value = $lot['title'] ??  "";
  ?>
  <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
    <label for="lot-title">Наименование <sup>*</sup></label>
    <input id="lot-title" type="text" name="title"
           placeholder="Введите наименование лота" value="<?= $value ?>">
    <span class="form__error"><?= $errors['title'] ?? '' ?></span>
  </div>
  <?php
  $classname = isset($errors['category_id']) ? "form__item--invalid" : "";
  ?>
  <div class="form__item <?= $classname ?> ">
    <label for="category">Категория <sup>*</sup></label>
    <select id="category" name="category_id">
      <option value=''>Выберите категорию</option>
      <?php foreach ($categories as $category): ?>
        <option
          value="<?= ($category['id'] ?? 1) ?>" <?= isset($lot['category_id']) && (int)$lot['category_id'] === (int)$category['id'] ? 'selected' : '' ?> >
          <?= strip_tags($category['title']); ?>
        </option>
      <?php endforeach; ?>
    </select>
    <span class="form__error"><?= $errors['category_id'] ?? '' ?></span>
  </div>
</div>
<?php
$classname = isset($errors['description']) ? " form__item--invalid" : "";
$value = $lot['description'] ?? '';
?>
<div class="form__item form__item--wide <?= $classname ?>">
  <label for="id-description">Описание <sup>*</sup></label>
  <textarea id="id-description" name="description" placeholder="Напишите описание лота"><?= $value ?></textarea>
  <span
    class="form__error"><?= $errors['description'] ?? '' ?></span>
</div>
<?php
$classname = isset($errors['lot-picture']) ? "form__item--invalid" : "";
?>
<div class="form__item form__item--file">
  <label>Изображение jpeg, jpg, png (не более 2Мб) <sup>*</sup></label>
  <div class="form__input-file <?= $classname ?>">
    <input class="visually-hidden" type="file" id="id-lot-img" value="" name="lot-picture">
    <label for="id-lot-img">
      Добавить
    </label>
    <span class="form__error"><?= $errors['lot-picture'] ?? '' ?></span>
  </div>
</div>
<div class="form__container-three">
  <?php
  $classname = isset($errors['start_price']) ? " form__item--invalid" : "";
  $value = $lot['start_price'] ?? "";
  ?>
  <div class="form__item form__item--small <?= $classname ?>">
    <label for="lot-rate">Начальная цена <sup>*</sup></label>
    <input id="id-start-price" type="text" name="start_price" value="<?= $value ?>" placeholder="0">
    <span class="form__error">
      <?= $errors['start_price'] ?? '' ?>
    </span>
  </div>
  <?php
  $classname = isset($errors['lot_step']) ? " form__item--invalid" : "";
  $value = $lot['lot_step'] ?? "";
  ?>
  <div class="form__item form__item--small <?= $classname ?>">
    <label for="id-lot-step">Шаг ставки <sup>*</sup></label>
    <input id="id-lot-step" type="text" name="lot_step" value="<?= $value ?>" placeholder="0">
    <span class="form__error"><?= $errors['lot_step'] ?? '' ?></span>
  </div>
  <?php
  $classname = isset($errors['end_date']) ? " form__item--invalid" : "";
  $value = $lot['end_date'] ?? "";
  ?>
  <div class="form__item <?= $classname ?>">
    <label for="id-lot-date">Дата окончания торгов (дата в формате ГГГГ-ММ-ДД) <sup>*</sup></label>
    <input class="form__input-date" id="id-lot-date" type="text" name="end_date" value="<?= $value ?>"
           placeholder="Введите дату в формате ГГГГ-ММ-ДД">
    <span class="form__error">
      <?= $errors['end_date'] ?? '' ?>
    </span>
  </div>
</div>
<?php if(count($errors) > 0):?>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
<?php endif;?>
<button type="submit" class="button">Добавить лот</button>
</form>
