<?php

$router->add('GET', "/", "Src\\Controllers\\Users\\HomeController@index");
$router->add('GET', "/user/session/{id:%d}/{name:?s}", "Src\\Controllers\\Users\\HomeController@index");
$router->add('GET', "/user/{id:%d}", "Src\\Controllers\\Users\\HomeController@index");
$router->add('GET', "/user/login/{id:%d}", "Src\\Controllers\\Users\\HomeController@index");