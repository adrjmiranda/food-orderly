<nav id="navbar">
  <div class="container">
    <div class="content">
      <div class="left-nav">
        <a href="/" class="logo">
          <img src="<?= $base_url ?>/assets/img/logo.png" alt="Logo">
        </a>

        <ul class="menu">
          <li><a href="/">Home</a></li>
          <li><a href="/about">About</a></li>
          <li><a href="/contact">Contact</a></li>
        </ul>
      </div>

      <div class="right-nav">
        <ul class="register-login">
          <?php if (isset($_SESSION["user"]["id"])): ?>
            <li>
              <a href="#" id="your-orders">Your orders</a>
            </li>

            <li>
              <a href="/logout" class="btn btn-primary">Logout</a>
            </li>
          <?php else: ?>
            <li>
              <a href="/register" style="text-transform: capitalize;">Create account</a>
            </li>

            <li>
              <a href="/login" class="btn btn-primary">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>