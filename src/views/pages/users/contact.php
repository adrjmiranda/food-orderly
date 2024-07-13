<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('users/master', [
  "page_title" => "Contact",
  "scripts" => [
    "change-view-cart",
    "cart"
  ]
]);
?>

<h1>Contact</h1>

<!-- Cart -->

<?php require_once __DIR__ . "/../../components/users/cart.php"; ?>

<!-- Show Cart Button -->

<?php require_once __DIR__ . "/../../components/users/show-cart-button.php"; ?>