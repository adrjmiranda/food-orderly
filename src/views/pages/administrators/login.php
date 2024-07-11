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

      <form action="#">
        <!-- TODO: fill csrf value -->
        <input type="hidden" name="csrf" value="">

        <h1>Login <i class="fa-solid fa-right-to-bracket"></i></h1>

        <div class="input-field">
          <label for="email">E-mail:</label>
          <input type="email" name="email" placeholder="example@email.com">
        </div>

        <div class="input-field">
          <label for="password">Password</label>
          <input type="password" name="password" placeholder="****">
        </div>

        <button type="submit" class="btn btn-primary">Enter</button>
      </form>
    </div>
  </div>
</div>