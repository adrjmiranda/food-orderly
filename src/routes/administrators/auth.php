<?php

$router->add("GET", "/admin/login", "Src\\Controllers\\Administrators\\LoginController@index", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogout"
]);

$router->add("POST", "/admin/login", "Src\\Controllers\\Administrators\\LoginController@login", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogout"
]);