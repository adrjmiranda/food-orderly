<?php

$router->add("GET", "/checkout", "Src\\Controllers\\Users\\PaymentController@checkout", [
  "Src\\Http\\Middlewares\\Users\\RequireLogin"
]);
$router->add("POST", "/payment", "Src\\Controllers\\Users\\PaymentController@payment", [
  "Src\\Http\\Middlewares\\Users\\RequireLogin"
]);