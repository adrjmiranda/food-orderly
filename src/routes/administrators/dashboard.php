<?php

$router->add("GET", "/admin/dashboard/{session:%s}", "Src\\Controllers\\Administrators\\DashboardController@index", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);

$router->add("GET", "/admin/dishes/search", "Src\\Controllers\\Administrators\\DashboardController@getDishesByName", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);