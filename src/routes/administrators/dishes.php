<?php

$router->add("POST", "/admin/dish/store", "Src\\Controllers\\Administrators\\DishController@store", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);
$router->add("GET", "/admin/dish/edit", "Src\\Controllers\\Administrators\\DishController@edit", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);
$router->add("POST", "/admin/dish/update", "Src\\Controllers\\Administrators\\DishController@update", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);
$router->add("GET", "/admin/dish/remove", "Src\\Controllers\\Administrators\\DishController@delete", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);