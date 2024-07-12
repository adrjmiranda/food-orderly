<?php

$router->add("GET", "/admin/user/remove", "Src\\Controllers\\Administrators\\UserController@remove", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);