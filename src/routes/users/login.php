<?php

$router->add('GET', "/login", "Src\\Controllers\\Users\\LoginController@index", [
  "Src\\Http\\Middlewares\\Users\\RequireLogout"
]);