<?php

$router->add("GET", "/admin/login", "Src\\Controllers\\Administrators\\LoginController@index", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogout"
]);

$router->add("POST", "/admin/login", "Src\\Controllers\\Administrators\\LoginController@login", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogout"
]);

$router->add("GET", "/admin/logout", "Src\\Controllers\\Administrators\\LogoutController@logout", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);