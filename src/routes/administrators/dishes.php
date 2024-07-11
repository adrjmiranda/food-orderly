<?php

$router->add("POST", "/admin/dish/store", "Src\\Controllers\\Administrators\\DishController@store");
$router->add("GET", "/admin/dish/edit", "Src\\Controllers\\Administrators\\DishController@edit");
$router->add("POST", "/admin/dish/update", "Src\\Controllers\\Administrators\\DishController@update");
$router->add("GET", "/admin/dish/remove", "Src\\Controllers\\Administrators\\DishController@delete");