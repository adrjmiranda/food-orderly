<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('users/auth-area', [
  "page_title" => "Register"
]);
?>

<div id="form-area">
  <div class="form-header">
    <h1>Register now</h1>
    <p>It won't be long before you satisfy your hunger!</p>
  </div>

  <form action="#">
    <!-- TODO: fill csrf value -->
    <input type="hidden" name="csrf" value="">

    <div class="input-field">
      <label for="first-name">First name</label>
      <input type="text" name="first_name" id="first-name" placeholder="Your first name">

      <?php if (isset($errors["first_name"])): ?>
        <p class="form-error"><?= $errors["first_name"] ?></p>
      <?php endif; ?>
    </div>

    <div class="input-field">
      <label for="last-name">Last name</label>
      <input type="text" name="last_name" id="last-name" placeholder="Your last name">

      <?php if (isset($errors["last_name"])): ?>
        <p class="form-error"><?= $errors["last_name"] ?></p>
      <?php endif; ?>
    </div>

    <div class="input-field">
      <label for="email">E-mail</label>
      <input type="email" name="email" id="email" placeholder="Your email">

      <?php if (isset($errors["email"])): ?>
        <p class="form-error"><?= $errors["email"] ?></p>
      <?php endif; ?>
    </div>

    <div class="input-field">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Your password">

      <?php if (isset($errors["password"])): ?>
        <p class="form-error"><?= $errors["password"] ?></p>
      <?php endif; ?>
    </div>

    <div class="input-field">
      <label for="password-confirmation">Password confirmation</label>
      <input type="password" name="password_confirmation" id="password-confirmation" placeholder="Your password again">

      <?php if (isset($errors["password_confirmation"])): ?>
        <p class="form-error"><?= $errors["password_confirmation"] ?></p>
      <?php endif; ?>
    </div>

    <div class="input-field">
      <button type="submit" class="btn btn-primary">Register</button>
    </div>

    <p class="change-form">Already have an account? <a href="/login">Login</a></p>
  </form>
</div>