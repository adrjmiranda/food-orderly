<?php

$router->add('GET', "/admin/dashboard/requests", "Src\\Controllers\\Administrators\\DashboardController@index");
$router->add('GET', "/admin/dashboard/users", "Src\\Controllers\\Administrators\\DashboardController@index");
$router->add('GET', "/admin/dashboard/dishes", "Src\\Controllers\\Administrators\\DashboardController@index");