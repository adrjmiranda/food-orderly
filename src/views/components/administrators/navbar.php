<nav id="navbar">
  <div class="container">
    <div class="content">
      <h1 class="session-title">
        <?php
        switch ($session):
          case "orders":
            echo "<i class='fa-solid fa-list'></i>";
            break;
          case "users":
            echo "<i class='fa-solid fa-users'></i>";
            break;
          case "dishes":
            echo "<i class='fa-solid fa-plate-wheat'></i>";
            break;
          case "new-dish":
            echo "<i class='fa-solid fa-plus'></i>";
            break;

          default:
            echo "<i class='fa-solid fa-pen-nib'></i>";
            break;
        endswitch;
        ?>
        <span><?= $session_title ?></span>
      </h1>

      <div class="admin-info">
        <div class="welcome">
          <span>Welcome</span>
          <a href="#" class="name"><?= $_SESSION["admin"]["first_name"] . " " . $_SESSION["admin"]["last_name"] ?></a>
        </div>

        <img src="<?= $base_url ?>/assets/img/administrators/avatar.png" alt="Avatar Image">
      </div>
    </div>
  </div>
</nav>