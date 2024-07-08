<?php

require_once __DIR__ . "/bootstrap.php";

// Add routes

require_once __DIR__ . "/src/routes/users/main.php";

$router->run();