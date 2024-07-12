<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('users/master', [
  "page_title" => "Home"
]);
?>

<!-- Main Banner -->

<?php require_once __DIR__ . "/../../components/users/main-banner.php"; ?>

<!-- Categories Bar  -->

<?php require_once __DIR__ . "/../../components/users/categories-bar.php"; ?>

<!-- Dish List -->

<?php require_once __DIR__ . "/../../components/users/dish-list.php"; ?>