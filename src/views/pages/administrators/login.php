<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('administrators/auth', [
  "page_title" => "Login"
]);
?>

<div id="auth">
  <div class="container">
    <div class="content">

      <form action="/admin/login" method="post">
        <!-- TODO: fill csrf value -->
        <input type="hidden" name="csrf" value="">

        <h1>Login <i class="fa-solid fa-right-to-bracket"></i></h1>

        <div class="input-field">
          <label for="email">E-mail</label>
          <input type="email" name="email" placeholder="example@email.com"
            value="<?= !empty($values["email"]) ? $values["email"] : "" ?>">

          <i class="fa-regular fa-envelope"></i>

          <?php if (isset($errors["email"])): ?>
            <p class="form-error"><?= $errors["email"] ?></p>
          <?php endif; ?>
        </div>

        <div class="input-field">
          <label for="password">Password</label>
          <input type="password" name="password" placeholder="Your password"
            value="<?= !empty($values["password"]) ? $values["password"] : "" ?>">

          <i class="fa-solid fa-lock"></i>

          <?php if (isset($errors["password"])): ?>
            <p class="form-error"><?= $errors["password"] ?></p>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Enter</button>
      </form>
    </div>
  </div>
</div>