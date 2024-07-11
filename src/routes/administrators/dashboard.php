<?php

$router->add("GET", "/admin/dashboard/{session:%s}", "Src\\Controllers\\Administrators\\DashboardController@index", [
  "Src\\Http\\Middlewares\\Administrators\\RequireLogin"
]);