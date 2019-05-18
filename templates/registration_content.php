<form class="form container <?= isset($errors) ? "form--invalid" : "" ?>"
      action="registration.php" method="post" autocomplete="off"> <!-- form--invalid -->
  <h2>Регистрация нового аккаунта</h2>
  <?php
  $classname = isset($errors['email']) ? 'form__item--invalid' : '';
  ?>
  <div class="form__item <?= $classname ?>"> <!-- form__item--invalid -->
    <label for="email">E-mail <sup>*</sup></label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail">
    <? if (isset($errors['email'])): ?>
      <span class="form__error"><?= $errors['email'] ?></span>
    <? endif ?>
  </div>
  <?php
  $classname = isset($errors['password']) ? 'form__item--invalid' : '';
  ?>
  <div class="form__item <?= $classname ?>">
    <label for="password">Пароль <sup>*</sup></label>
    <input id="password" type="password" name="password" placeholder="Введите пароль">
    <? if (isset($errors['email'])): ?>
      <span class="form__error"><?= $errors['password'] ?></span>
    <? endif; ?>
  </div>
  <?php
  $classname = isset($errors['name']) ? 'form__item--invalid' : '';
  ?>
  <div class="form__item <?= $classname ?>">
    <label for="name">Имя <sup>*</sup></label>
    <input id="name" type="text" name="name" placeholder="Введите имя">
    <? if (isset($errors['email'])): ?>
      <span class="form__error"><?= $errors['name'] ?></span>
    <? endif; ?>
  </div>
  <?php
  $classname = isset($errors['message']) ? 'form__item--invalid' : '';
  ?>
  <div class="form__item <?= $classname ?>">
    <label for="message">Контактные данные <sup>*</sup></label>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться"></textarea>
    <span class="form__error"><?= $errors['message'] ?></span>
  </div>
  <? if (count($errors) != 0): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <? endif; ?>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
