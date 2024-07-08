<?php

require_once __DIR__ . "/vendor/autoload.php";

use Src\Config\Logs\Logger;
use Src\Http\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$logFile = __DIR__ . "/src/resources/cache/register.log";
$logger = new Logger($logFile);

$logger->info('Application started');

$baseUrl = $_ENV["BASE_URL"];

$router = new Router($baseUrl);