<?php

$router->add("GET", "/register", "Src\\Controllers\\Users\\RegisterController@index", [
  "Src\\Http\\Middlewares\\Users\\RequireLogout"
]);
$router->add("POST", "/register", "Src\\Controllers\\Users\\RegisterController@register", [
  "Src\\Http\\Middlewares\\Users\\RequireLogout"
]);