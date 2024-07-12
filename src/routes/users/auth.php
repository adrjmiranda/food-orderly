<?php

$router->add('GET', "/login", "Src\\Controllers\\Users\\LoginController@index", [
  "Src\\Http\\Middlewares\\Users\\RequireLogout"
]);

$router->add('GET', "/logout", "Src\\Controllers\\Users\\LogoutController@logout", [
  "Src\\Http\\Middlewares\\Users\\RequireLogin"
]);