<?php

use Src\Http\Router;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$baseUrl = $_ENV["BASE_URL"];

$router = new Router($baseUrl);