<?php

$router->add("GET", "/api/v1/dishes/{limit:%d}", "Src\\API\\V1\\Controllers\\DishController@getAllDishes");
$router->add("GET", "/api/v1/dishes/category/{category_id:%d}", "Src\\API\\V1\\Controllers\\DishController@getDishesByCategory");