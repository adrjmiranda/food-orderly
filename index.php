<?php

require_once __DIR__ . "/bootstrap.php";

// Add routes

require_once __DIR__ . "/src/routes/users/main.php";
require_once __DIR__ . "/src/routes/administrators/main.php";

// Add API routes

require_once __DIR__ . "/src/API/V1/routes/main.php";

$router->run();