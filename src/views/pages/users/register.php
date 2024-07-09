<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('users/auth-area', [
  "page_title" => "Register"
]);
?>

<h1>Register now</h1>
<p>It won't be long before you satisfy your hunger!</p>

<form action="#">
  <div class="input-field">
    <label for="first-name">First name</label>
    <input type="text" name="first_name" id="first-name" placeholder="Your first name">
  </div>

  <div class="input-field">
    <label for="last-name">Last name</label>
    <input type="text" name="last_name" id="last-name" placeholder="Your last name">
  </div>

  <div class="input-field">
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email" placeholder="Your email">
  </div>

  <div class="input-field">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="Your password">
  </div>

  <div class="input-field">
    <label for="password-confirmation">Password confirmation</label>
    <input type="password" name="password_confirmation" id="password-confirmation" placeholder="Your password again">
  </div>

  <div class="input-field">
    <button type="submit" class="btn btn-primary">Register</button>
  </div>
</form>