<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('administrators/master', [
  "page_title" => "Orders"
]);
?>

<div id="dashboard">
  <div class="container">
    <!-- Session Bar -->

    <?php require_once __DIR__ . "/../../components/administrators/session-bar.php"; ?>

    <!-- Search Area -->

    <?php require_once __DIR__ . "/../../components/administrators/search-area.php"; ?>

    <!-- Data -->

    <?php require_once __DIR__ . "/../../components/administrators/orders-data.php"; ?>
  </div>
</div>