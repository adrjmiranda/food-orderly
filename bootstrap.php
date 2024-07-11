<?php

require_once __DIR__ . "/vendor/autoload.php";

use Src\Config\Logs\Logger;
use Src\Config\Session\Store;
use Src\Http\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Init set logs
$logger = new Logger;
$logger->info('Application Started');

// Init session
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);

if ($_ENV['APPLICATION_STATUS'] === 'production') {
  ini_set('session.cookie_secure', 1);
}

ini_set('session.cookie_samesite', 'Strict');

(new Store());

$baseUrl = $_ENV["BASE_URL"];

// Init router
$router = new Router($baseUrl, $logger);