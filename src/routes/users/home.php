<?php

$router->get("/", "Src\\Controllers\\Users\\HomeController@index");
$router->get("/user/{id:%d}/{ name :%s}/{session:?s}/{mand:?d}", "Src\\Controllers\\Users\\HomeController@index");