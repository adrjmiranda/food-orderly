<?php

require_once __DIR__ . "/vendor/autoload.php";

use Src\Config\Logs\Logger;
use Src\Http\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$logger = new Logger;
$logger->info('Application started');

$baseUrl = $_ENV["BASE_URL"];

$router = new Router($baseUrl);