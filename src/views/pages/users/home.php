<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('users/master', [
  "page_title" => "Home",
  "scripts" => [
    "home",
    "change-view-cart",
    "cart"
  ]
]);
?>

<!-- Main Banner -->

<?php require_once __DIR__ . "/../../components/users/main-banner.php"; ?>

<!-- Categories Bar  -->

<?php require_once __DIR__ . "/../../components/users/categories-bar.php"; ?>

<!-- Dish List -->

<?php require_once __DIR__ . "/../../components/users/dish-list.php"; ?>

<!-- Cart -->

<?php require_once __DIR__ . "/../../components/users/cart.php"; ?>

<!-- Show Cart Button -->

<?php require_once __DIR__ . "/../../components/users/show-cart-button.php"; ?>