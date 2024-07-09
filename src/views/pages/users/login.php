<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('users/auth-area', [
  "page_title" => "Login"
]);
?>

<div id="form-area">
  <div class="form-header">
    <h1>Login now</h1>
    <p>It won't be long before you satisfy your hunger!</p>
  </div>

  <form action="#">
    <!-- TODO: fill csrf value -->
    <input type="hidden" name="csrf" value="">

    <div class="input-field">
      <label for="email">E-mail</label>
      <input type="email" name="email" id="email" placeholder="Your email">

      <?php if (!empty($error->email)): ?>
        <p class="form-error"><?= $error->email ?></p>
      <?php endif; ?>
    </div>

    <div class="input-field">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Your password">

      <?php if (!empty($error->password)): ?>
        <p class="form-error"><?= $error->password ?></p>
      <?php endif; ?>
    </div>

    <div class="input-field">
      <button type="submit" class="btn btn-primary">Enter</button>
    </div>

    <p class="change-form">Don't have an account yet? <a href="/Register">Register</a></p>
  </form>
</div>