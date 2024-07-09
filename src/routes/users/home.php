<?php

$router->add('GET', "/", "Src\\Controllers\\Users\\HomeController@index");
$router->add('GET', "/about", "Src\\Controllers\\Users\\HomeController@about");
$router->add('GET', "/contact", "Src\\Controllers\\Users\\HomeController@contact");