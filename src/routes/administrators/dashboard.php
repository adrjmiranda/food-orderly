<?php

$router->add("GET", "/admin/dashboard/{session:%s}", "Src\\Controllers\\Administrators\\DashboardController@index");