<?php
/**
 * @var Src\Config\Template\View $this
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?></title>

  <!-- Styles -->

  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/users/master.css">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <!-- Navbar -->

  <?php require_once __DIR__ . "/../../components/users/navbar.php"; ?>

  <!-- Content -->

  <?php $this->load(); ?>

  <!-- Footer -->

  <?php require_once __DIR__ . "/../../components/users/footer.php"; ?>
</body>

</html>